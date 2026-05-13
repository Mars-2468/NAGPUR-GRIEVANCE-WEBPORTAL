<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	$aptid1 = $_REQUEST['aptid'];

	$emp_name = $_REQUEST['emp_name'];

	$status1 = $_REQUEST['status'];

	$ulbid1 = $_SESSION['ulbid'];

	$user_type1 = $_SESSION['user_type'];
	$ward_id = !empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';

	$sla1 = $_REQUEST['sla'];

	$_REQUEST['app_type_id'] = 1;
	
	$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:'';
	$selectedDesg = !empty($_SESSION['filterdesg'])?$_SESSION['filterdesg']:'';
	$selectedDept = !empty($_SESSION['employee_dept'])?$_SESSION['employee_dept']:'';
	$selectedDesgnation = !empty($_SESSION['employee_desg'])?$_SESSION['employee_desg']:'';

	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
	}
		
	$sql = "SELECT COUNT(DISTINCT sl.warning_id) as count,e.emp_name,d.dept_desc,sl.emp_id FROM `show_case_response_logs` as sl LEFT JOIN emp_mst as e ON e.emp_id=sl.emp_id  LEFT JOIN emp_map as em ON em.emp_id=sl.emp_id LEFT JOIN dept_mst as d ON e.emp_dept = d.dept_id where sl.row_number%5=0 and em.ward_id = ".$ward_id." ";
	
	if ($selectedYear) { 
		$sql .="   AND date_format(sl.date_regd, '%Y') = '" . $selectedYear . "'  ";
	}
	
	if (isset($_POST['search'])) {
		if ($_REQUEST['emp_name'] != '') {
			$sql .= " and e.emp_name='" . $_REQUEST['emp_name'] . "' ";
		}
		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
			$sql .= " and date_format(sl.date_regd, '%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
		}else{
			$sql .= " and date_format(sl.date_regd, '%Y-%m-%d') >= '2024-09-01' ";				
		}
	}else{
		$sql .= "  and date_format(sl.date_regd, '%Y-%m-%d') >= '2024-09-01' ";				
	}
	
	$sql .= "  group by sl.emp_id ";

//echo "<pre>";print_r($sql);echo "</pre>";die();

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['emp_id']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	if ($user_type1 == 'P') {
	//	$sql = "select sc.emp_id,e.emp_id,e.emp_name,e.emp_dept from show_case_emp_count sc,emp_mst e where sc.emp_id=e.emp_id and e.emp_name like '%" . $emp_name . "%'";
		$sql = "SELECT sum(sc.warning_id) as count,e.emp_name,e.emp_dept,d.dept_desc,sc.emp_id FROM `show_case_response_logs` as sc LEFT JOIN emp_mst as e ON e.emp_id=sc.emp_id RIGHT JOIN dept_mst as d ON e.emp_dept = d.dept_id group by sc.emp_id";
	
	
	} else {
		$sql = "select emp_id,emp_name,emp_dept from emp_mst where emp_id IN ('" . $_SESSION['emp_id'] . "') and emp_name like '%" . $emp_name . "%'";
		//$sql = "SELECT e.emp_name,e.emp_dept,d.dept_desc,sc.emp_id,r.grievance_id FROM `show_case_emp_count` as sc LEFT JOIN emp_mst as e ON e.emp_id=sc.emp_id LEFT JOIN dept_mst as d ON e.emp_dept = d.dept_id LEFT JOIN show_case_response_logs as r ON sc.emp_id = r.emp_id LEFT JOIN grievances as g ON g.grievance_id = r.grievance_id WHERE emp_id IN ('" . $_SESSION['emp_id'] . "') and emp_name like '%" . $emp_name . "%' and g.ulbid='" . $_SESSION['ulbid'] . "' group by sc.emp_id";

	}

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$emp_dept_list[$row['emp_id']] = $row['emp_dept'];
		}
	}
	
//echo "<pre>";print_r($data);echo "</pre>";die();

	if ($user_type1 == 'P') {
		$sql = "select sc.emp_id,e.emp_id,e.emp_name,e.emp_dept from show_case_emp_count sc,emp_mst_od e where sc.emp_id=e.emp_id and e.emp_name like '%" . $emp_name . "%'";
	} else {
		$sql = "select emp_id,emp_name from emp_mst_od where emp_id IN ('" . $_SESSION['emp_id'] . "') and emp_name like '%" . $emp_name . "%'";
	}

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$emp_dept_list[$row['emp_id']] = $row['emp_dept'];
		}
	}

	$sql = "select sc.emp_id,e.emp_id,e.emp_name,e.emp_dept,d.dept_id,d.dept_desc from show_case_emp_count sc,emp_mst e, dept_mst d where sc.emp_id=e.emp_id and e.emp_dept=d.dept_id";

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "select * from grievance_status_mst";

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select sc.showcause_id,sc.emp_id,sc.showcase_count,sc.datetime,e.emp_id,e.emp_name,e.emp_dept from show_case_emp_count sc,emp_mst e ,emp_map em where sc.emp_id=e.emp_id and e.emp_id=em.emp_id and em.ward_id = ".$ward_id." ";

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
		$showcause_list[$row['showcause_id']] = $row['showcause_id'];
	} else
	printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}

	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('online_applications', $online_applications);
	mysqli_close($conn);
	$tpl->assign('emp_dept_list', $emp_dept_list);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet', '3' => 'Both'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('tot', $tot);
	$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
	$tpl->assign('emp_name', $_REQUEST['emp_name']);
	$tpl->assign('dept_id1', $_REQUEST['dept_id']);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('showcause_list', $showcause_list);
	$tpl->assign('data_list', $data_list);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('user_type', $user_type1);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('corp_show_cause_notice.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
