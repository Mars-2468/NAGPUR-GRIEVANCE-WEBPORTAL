<?php
require "config.php";

ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

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

	$app_type_id = $_REQUEST['app_type_id']??'';
	$emp_id = $_REQUEST['emp_id']??'';
	$reference_no = $_REQUEST['reference_no']??'';
	$status = $_REQUEST['status']??'';
	$dept_id = $_REQUEST['dept_id']??'';
	$f_date = $_REQUEST['f_date']??'';
	$t_date = $_REQUEST['t_date']??'';
	$fdate = '';
	$tdate = '';
	
	$ward_id = !empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';
	
	if ($f_date != '' && $t_date != '') {
		$fdate = date('Y-m-d', strtotime($f_date));
		$tdate = date('Y-m-d', strtotime($t_date));
	}

	if ($app_type_id == 1) {
		$table = "cs_mst";
		$fieldName = "c.cs_desc";
	} else {
		$table = "standard_services";
		$fieldName = "c.cs_desc";
	}
	if ($status == 1 || $status == 109) {
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and date_regd >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) 
  		AND date_regd <= CURDATE()";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and date_regd >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) 
		AND date_regd <= CURDATE() and cat3_id !='0'";
		
	} else if ($status == 2 || $status == 110) {
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and date_regd <= DATE_SUB(CURDATE(), INTERVAL 30 DAY) ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and date_regd <= DATE_SUB(CURDATE(), INTERVAL 30 DAY) and cat3_id !='0'";
	}
	
	if (isset($_POST['search'])) {
		if ($_POST['reference_no'] != '') {
			$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}
		if ($f_date != '' && $t_date != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
			$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	if($ward_id!=''){
		$sql .= " and ward_id = " . $ward_id . " ";
	}
	
/* ====================pagination code start========================= */	
	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	//echo $page;exit;		
	$start = ($page - 1) * $limit;
	
	$pageNumber=$start+1;
	$tpl->assign('pageNumber', $pageNumber);
		//	echo "<pre>";print_r($sql);echo "</pre>";die();
	$pgrs=mysqli_query($conn,$sql);

	$total_rows=$pgrs->num_rows;

/* ====================pagination code end========================= */
	
	$sql .= " group by gt.grievance_id ";
	
	$sql.=" LIMIT ".$start.", ".$limit." ";	
		
	$sqlExcel .= " group by g.grievance_id";
	
	$_SESSION['myquery'] = $sqlExcel;
	//echo $sqlExcel;

	$adjacents = 5;
	if ($status == 1 || $status == 109) {
		$query = "SELECT * FROM grievances WHERE date_regd >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) -- Retrieve records from the past one week AND date_regd <= CURDATE()";
	
	} else if ($status == 2 || $status == 110) {
		$query = "select count(g.grievance_id) as num,g.sla_status from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
		and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.disposal_status!='5' and 
		gt.dept_id='" . $dept_id . "'  and grievance_status_id IN('2') ";
	}
	
	if($ward_id!=''){
		$query .= " and ward_id = " . $ward_id . " ";
	}

	if (isset($_POST['search'])) {
		if ($_POST['reference_no'] != '') {
			$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}
		if ($f_date != '' && $t_date != '') {
			$query .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
		$query .= ' group by g.grievance_id';
	}
	//echo $query;
	$result = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($result)) {
		$total_pages = $row['num'];	
	}

	$rs = mysqli_query($conn, $sql);
	$field_info = mysqli_fetch_fields($rs);
	while ($row = mysqli_fetch_assoc($rs)) {
		foreach ($field_info as $fi => $f)
			$data[$row['grievance_id']][$f->name] = $row[$f->name];
	}

	//pagination end
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

	/* if (!empty($dept_id)) {
		$filter_query .= '&dept_id=' . urlencode($dept_id);
	} */
	
	if (!empty($fdate)) {
		$filter_query .= '&f_date=' . urlencode($fdate);
	}

	if (!empty($tdate)) {
		$filter_query .= '&t_date=' . urlencode($tdate);
	}

	if (!empty($reference_no)) {
		$filter_query .= '&reference_no=' . urlencode($reference_no);
	}

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
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('status', $status);
	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('data', $data);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('mc_yn', $_SESSION['mc_yn']);
	$tpl->display('corp_grievance_month_inner_report.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
