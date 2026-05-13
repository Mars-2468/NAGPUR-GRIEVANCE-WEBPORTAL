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

	$sla1 = $_REQUEST['sla'];

	$_REQUEST['app_type_id'] = 1;
	
	//echo "<pre>"; print_r($_SESSION);echo "</pre>"; die();

	$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:'';
	$selectedDesg = !empty($_SESSION['filterdesg'])?$_SESSION['filterdesg']:'';
	$selectedDept = !empty($_SESSION['employee_dept'])?$_SESSION['employee_dept']:'';
	$selectedDesgnation = !empty($_SESSION['employee_desg'])?$_SESSION['employee_desg']:'';
		
	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
	}

	if ($user_type1 == 'U') {
		$sql = "SELECT COUNT(DISTINCT sc.warning_id) as count,sc.emp_id FROM `show_case_response_logs` as sc LEFT JOIN emp_mst as e ON e.emp_id=sc.emp_id RIGHT JOIN dept_mst as d ON e.emp_dept = d.dept_id ";
	
		
		if (isset($_POST['search'])) {
			if ($_REQUEST['emp_name'] != '') {
				$sql .= " and e.emp_name='" . $_REQUEST['emp_name'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$sql .= " and date(sc.date_regd) between '" . $fdate . "' and '" . $tdate . "'";
			}else{
				$sql .= "  and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01' ";				
			}
		}else{
			$sql .= "  and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01' ";				
		}
		
			
		if ($selectedYear) { 
			$sql .=" and date_format(sc.date_regd, '%Y') = '" . $selectedYear . "'  ";
		}
		
		$sql .= " group by sc.emp_id";
		
	} else {
		$sql = "SELECT COUNT(DISTINCT sc.warning_id) as count,e.emp_name,d.dept_desc,sc.emp_id FROM `show_case_response_logs` as sc LEFT JOIN emp_mst as e ON e.emp_id=sc.emp_id LEFT JOIN dept_mst as d ON e.emp_dept = d.dept_id LEFT JOIN grievances as g ON sc.grievance_id = g.grievance_id WHERE sc.emp_id = '" . $_SESSION['emp_id'] . "' ";
		
	
		if ($selectedDept) { 
			$sql .=" and d.dept_id = '".$selectedDept."' ";
		}
		
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(sc.datetime) between '" . $fdate . "' and '" . $tdate . "' group by sc.emp_id";
		} else {
			
			$sql .= "  and g.date_regd >= date('2024-09-01') ";				
			
			
		}
					
		if ($selectedYear) { 
			$sql .="   AND YEAR(g.date_regd) = '" . $selectedYear . "'  ";
		}
		$sql .= " group by sc.emp_id";
	}

//echo "<pre>";print_r($sql);echo "</pre>";die();

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['emp_id']]['count'] = $row['count'];
			
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));
	
	//echo "<pre>";print_r($data);echo "</pre>";die();

	if ($user_type1 == 'U') {
			$sql = "SELECT sum(sc.warning_id) as count,e.emp_name,e.emp_dept,d.dept_desc,sc.emp_id FROM `show_case_response_logs` as sc LEFT JOIN emp_mst as e ON e.emp_id=sc.emp_id RIGHT JOIN dept_mst as d ON e.emp_dept = d.dept_id group by sc.emp_id";
	
		//$sql = "select sc.emp_id,e.emp_id,e.emp_name,e.emp_dept from grievances g, show_case_response_logs sc,emp_mst e where g.grievance_id=sc.grievance_id and sc.emp_id=e.emp_id and e.emp_name like '%" . $emp_name . "%'  and g.date_regd >= date('2024-09-01')";
	} else {
		$sql = "select emp_id,emp_name,emp_dept from emp_mst where emp_id IN ('" . $_SESSION['emp_id'] . "') and emp_name like '%" . $emp_name . "%'";
	}

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$emp_dept_list[$row['emp_id']] = $row['emp_dept'];
		}
	}

	if ($user_type1 == 'U') {
		//$sql = "select sc.emp_id,e.emp_id,e.emp_name,emp_dept from grievances g,show_case_response_logs sc,emp_mst_od e where g.grievance_id=sc.grievance_id and sc.emp_id=e.emp_id and e.emp_name like '%" . $emp_name . "%'  and g.date_regd > date('2024-09-01')";
		$sql = "SELECT sum(sc.warning_id) as count,e.emp_name,e.emp_dept,d.dept_desc,sc.emp_id FROM `show_case_response_logs` as sc LEFT JOIN emp_mst_od as e ON e.emp_id=sc.emp_id RIGHT JOIN dept_mst as d ON e.emp_dept = d.dept_id group by sc.emp_id";
	
	} else {
		$sql = "select emp_id,emp_name,emp_dept from emp_mst_od where emp_id IN ('" . $_SESSION['emp_id'] . "') and emp_name like '%" . $emp_name . "%'";
	}

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$emp_dept_list[$row['emp_id']] = $row['emp_dept'];
		}
	}
	
//echo "<pre>";print_r($emp_list[3]);echo "</pre>";die();

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

	$sql = "select sc.warning_id,sc.grievance_id,sc.emp_id,sc.notice_status,sc.datetime,e.emp_id,e.emp_name,e.emp_dept from grievances g, show_case_response_logs sc,emp_mst e where g.grievance_id=sc.grievance_id and sc.emp_id=e.emp_id  and g.date_regd > date('2024-09-01')";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
		$warning_list[$row['warning_id']] = $row['warning_id'];
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
	$tpl->assign('warning_list', $warning_list);
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
	$tpl->display('warning_notice.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
