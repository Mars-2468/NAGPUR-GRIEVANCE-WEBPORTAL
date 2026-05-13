<?php
require "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {

	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

	$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:'';
	
	$app_type_id = $_REQUEST['app_type_id'];
	$emp_id = $_REQUEST['emp_id'];
	$status = $_REQUEST['status'];
	$dept_id = $_REQUEST['dept_id'];
	$user_type = $_SESSION['user_type'];
	$ward_id = !empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';
	$ulbid = $_SESSION['ulbid'];
	$fdate = $_REQUEST['f_date']??'';
	$tdate = $_REQUEST['t_date']??'';

	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('status', $status);
	$tpl->assign('dept_id', $dept_id);
	$tpl->assign('ulbid', $ulbid);
	$tpl->assign('f_date', $fdate);
	$tpl->assign('t_date', $tdate);

	$f_date='';
	$t_date='';
	
	if ($f_date != '' && $t_date != '') {
		$f_date = date('Y-m-d', strtotime($f_date));
		$t_date = date('Y-m-d', strtotime($t_date));

		$f_date = date('Y-m-d', strtotime($f_date));
		$t_date = date('Y-m-d', strtotime($t_date));
	}

	if ($app_type_id == 1) {
		$table = "cs_mst";
		$fieldName = "c.cs_desc";
	} else {
		$table = "standard_services";
		$fieldName = "c.cs_desc";
	}

	if ($status == 'show') {
		
			$sql = "SELECT sc.warning_id,sc.emp_id, sc.row_number, sc.datetime , e.emp_name from show_case_response_logs sc,emp_mst e,emp_map em where sc.emp_id = e.emp_id and e.emp_id = em.emp_id and sc.emp_id = '" . $_REQUEST['emp_id'] . "' and sc.row_number%5=0 and em.ward_id = ".$ward_id." ";

			$sqlExcel = "SELECT sc.warning_id,sc.emp_id as ShowcauseNo,sc.grievance_id as ReferenceNo, e.emp_name as EmployeeName, d.dept_desc as DeparmentName, w.ward_desc as ZoneName, s.street_desc as StreetName, c.cs_desc as ComplaintDetails, g.date_regd as ReceivedDate, sc.datetime AS ShowcaseDate from show_case_response_logs sc,emp_mst e,dept_mst d,grievances g,ward_mst w,street_mst s,cs_mst as c where sc.emp_id = e.emp_id and e.emp_dept = d.dept_id and sc.emp_id = r.emp_id and sc.datetime = r.datetime and r.grievance_id = g.grievance_id and g.ward_id = w.ward_id and g.street_id = s.street_id and g.cat3_id = c.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and sc.emp_id = '" . $_REQUEST['emp_id'] . "'";
		
	}

	if ($f_date != '' && $t_date != '') {
		$fdate = date('Y-m-d', strtotime($f_date));
		$tdate = date('Y-m-d', strtotime($t_date));
		$sql .= " and date_format(sc.datetime,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01'  ";
		$sqlExcel .= " and date_format(sc.datetime,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	}else{
		$sql .= "  and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01' ";				
	}
	
	if ($selectedYear) { 
		$sql .=" and date_format(sc.date_regd, '%Y') = '" . $selectedYear . "'  ";
	}	
	
	if (isset($_POST['search'])) {
		if ($_POST['showcause_no'] != '') {
			$sql .= " and sc.showcause_id='" . $_POST['showcause_no'] . "'";
			$sqlExcel .= " and sc.showcause_id='" . $_POST['showcause_no'] . "'";
		}
		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
			$fdate = date('Y-m-d', strtotime($_POST['f_date']));
			$tdate = date('Y-m-d', strtotime($_POST['t_date']));
			$sql .= " and date_format(sc.datetime,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01' ";
			$sqlExcel .= " and and date_format(sc.datetime,'%Y-%m-%d')  between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	$sql .= " group by sc.warning_id";
	$sqlExcel .= " group by sc.warning_id";
	
//echo "<pre>";print_r($sql);echo "</pre>";die();

/* ====================pagination code start========================= */	
	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	//echo $page;exit;	
	//echo"<pre>";print_r(isset($_GET['page']));echo"</pre>";die();
	// Set variables
	//$limit = 50; // Number of records per page
	
	$start = ($page - 1) * $limit;
	
	$pageNumber=$start+1;
	$tpl->assign('pageNumber', $pageNumber);

$pgrs=mysqli_query($conn,$sql);

$sql.=" LIMIT ".$start.", ".$limit." ";	

//echo "<pre>";print_r($sql);echo "</pre>";die();

$total_rows=$pgrs->num_rows;

/* ====================pagination code end========================= */

	$rs = mysqli_query($conn, $sql);
	$field_info = mysqli_fetch_fields($rs);
	while ($row = mysqli_fetch_assoc($rs)) {
		foreach ($field_info as $fi => $f)
			$data[$row['warning_id']][$f->name] = $row[$f->name];
	}

	$sql = "select cs_id,cs_desc as comp_desc from standard_services";

	if ($app_type_id == '1') {
		$sql = "select cs_id,cs_desc as comp_desc from cs_mst";
	}
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$cs_list[$row['cs_id']] = $row['comp_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select * from emp_mst";

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$emp_list[$row['emp_id']] = $row['emp_name'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select ward_id,ward_desc from ward_mst where ulbid='" . $_SESSION['ulbid'] . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
		$ward_list[$row['ward_id']] = $row['ward_desc'];
	} else
	printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select showcause_id,emp_id,showcase_count,datetime from show_case_emp_count where emp_id='" . $_REQUEST['emp_id'] . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
		$showcause_list[$row['showcause_id']] = $row['showcause_id'];
	} else
	printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select * from grievance_status_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs = mysqli_query($conn, $sql);
	$online_applications=[];
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	
	/************************* pagination start  **************************/

	$total_pages = ceil($total_rows / $limit);
		// Generate pagination data
	$pagination = [
		'current_page' => $page,
		'total_pages' => $total_pages,
		'range' => 3 // Number of visible pages before/after the current page
	];
	
	/**************Filters***************/
	
		$filter_query = '';

		//echo "<pre>";print_r($data);echo "</pre>";die();

		if (!empty($dept_id)) {
			$filter_query .= '&dept_id=' . urlencode($dept_id);
		} 
		
		if (!empty($fdate)) {
			$filter_query .= '&f_date=' . urlencode($fdate);
		}

		if (!empty($tdate)) {
			$filter_query .= '&t_date=' . urlencode($tdate);
		}

	/* 	if (!empty($reference_no)) {
			$filter_query .= '&reference_no=' . urlencode($reference_no);
		} */

		if (!empty($status)) {
			$filter_query .= '&status=' . urlencode($status);
		}
		
		//echo "<pre>";print_r($filter_query);echo "</pre>";die();

		$tpl->assign('filter_query', $filter_query);
		
	/************************************/
	
	//echo "<pre>";print_r($filter_query);echo "</pre>";die();

	$tpl->assign('filter_query', $filter_query);	
	$tpl->assign('pagination', $pagination);
	$tpl->assign('current_page', $page);
	$tpl->assign('total_pages', $total_pages);
	
/************************* pagination end  **************************/
	
	mysqli_close($conn);

	$tpl->assign('dept_id_sel', $dept_id);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('firstNumber', $start);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('fdate', $f_date);
	$tpl->assign('tdate', $t_date);
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('showcause_no', $_POST['showcause_no']??'');
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('data', $data);
	//$tpl->assign('tot', $tot);
	$tpl->assign('status', $status);
	//$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('showcause_list', $showcause_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	//$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('mc_yn', $_SESSION['mc_yn']);
	//$tpl->assign('is_hod', $_SESSION['is_hod']);
	//$tpl->assign('is_level4_emp', $_SESSION['is_level4_emp']);
	$tpl->display('corp_all_showcause_notice_list.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
?>