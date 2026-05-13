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
	//$emp_id = $_REQUEST['emp_id'];
	$status = $_REQUEST['status'];
	//$reference_no = $_REQUEST['reference_no'];
	$dept_id = $_REQUEST['dept_id']??'';
	
	
	$f_date = $_REQUEST['f_date']??'';
	$t_date = $_REQUEST['t_date']??'';
	
	$ward_id = !empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';
	
	$fdate = '';
	$tdate = '';
	
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


	if ($status == 0 || $status == 1 || $status == 2) {
			$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		    g.app_type_id='" . $app_type_id . "' and gt.disposal_status IN(2,9,8,4,6,10) and gt.dept_id='" . $dept_id . "' and cat3_id !='0'";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='" . $app_type_id . "' and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status IN(2,9,8,4,6,10) and gt.dept_id='" . $dept_id . "' and cat3_id !='0'";
	
	} else if ($status == 3 || $status == 107) {
			$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		    g.app_type_id='" . $app_type_id . "' and g.grievance_status_id IN('2') and gt.disposal_status!='5' and gt.dept_id='" . $dept_id . "' and cat3_id !='0'";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='" . $app_type_id . "' and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $dept_id . "' and g.grievance_status_id IN('2') and cat3_id !='0'";
	
	} else if ($status == 4 || $status == 108) {
	
			$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' 
			and gt.disposal_status!='5' and gt.dept_id='" . $dept_id . "' and g.grievance_status_id IN(3,8,9,6,4,10,13) and cat3_id !='0'";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='" . $app_type_id . "' and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN(3,8,9,6,4,10,13) and gt.disposal_status !='5' and gt.dept_id='" . $dept_id . "' and cat3_id !='0'";

	} else if ($status == 100) {

			$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and 
			gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and cat3_id !='0'";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='" . $app_type_id . "' and g.ulbid='" . $_SESSION['ulbid'] . "' and 
			gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and cat3_id !='0'";

	} else if ($status == 200 || $status == 800) {
		$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $app_type_id . "' and gt.disposal_status!='5' and grievance_status_id IN('2') ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='" . $app_type_id . "' and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' and g.grievance_status_id IN('2') and cat3_id !='0'";
		
	} else if ($status == 300 || $status == 900) {
	
		$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' 
		and gt.disposal_status!='5' and grievance_status_id IN(3,8,9,6,4,10,13) ";
	
		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='" . $app_type_id . "' and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN(3,8,9,6,4,10,13) and gt.disposal_status !='5' and cat3_id !='0'";
	}

	if($ward_id!=''){
		$sql .= " and g.ward_id=" . $ward_id . " ";
	}

	if (isset($_POST['search'])) {

		if ($_POST['reference_no'] != '') {
			$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}

		if ($fdate != '' && $tdate != '') {
			$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
			$sqlExcel .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}

	if ($status != 4 || $status != 108) {
		$sql .= " group by gt.grievance_id ";
		$sqlExcel .= " group by g.grievance_id";
	}

	$_SESSION['myquery'] = $sqlExcel;
	//echo $sql;

	$adjacents = 5;
	if ($status == 0 || $status == 1 || $status == 2) {
			$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and 
			g.app_type_id='" . $app_type_id . "' and gt.disposal_status IN(2,9,8,4,6,10) and gt.dept_id='" . $dept_id . "' and cat3_id !='0'";
	} else if ($status == 3 || $status == 107) {
			$query = "select count(DISTINCT g.grievance_id) as num,g.sla_status from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.disposal_status!='5' and 
			gt.dept_id='" . $dept_id . "'  and g.grievance_status_id IN('2') ";
	} else if ($status == 4 || $status == 108) {
			$query = "select count(DISTINCT g.grievance_id) as num,g.sla_status,g.grievance_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
			g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.disposal_status!='5' and gt.dept_id='" . $dept_id . "' 
			and grievance_status_id IN(3,8,9,6,4,10,13) ";
	} else if ($status == 100) {
			$query = "select COUNT(DISTINCT gt.grievance_id) as num,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and 
			gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11)";
	} else if ($status == 200 || $status == 800) {
			$query = "select count(DISTINCT g.grievance_id) as num,g.sla_status from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
		    	and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.disposal_status!='5'   and grievance_status_id IN('2') ";
	} else if ($status == 300 || $status == 900) {
			$query = "select count(DISTINCT g.grievance_id) as num,g.sla_status,g.grievance_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
			g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.disposal_status!='5'  
			and g.grievance_status_id IN(3,8,9,6,4,10,13) and cat3_id !='0' ";
	}

	if (isset($_POST['search'])) {
		
		if ($_POST['reference_no'] != '') {
			$query . " and g.grievance_id='" . $_POST['reference_no'] . "' ";
		}
		
		if ($fdate != '' && $tdate != '') {
			$query .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
		
		$query .= ' group by g.grievance_id';
		
	}
	
	//echo $query;
	
/* ====================pagination code start========================= */	
	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	
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

		if (!empty($dept_id)) {
			$filter_query .= '&dept_id=' . urlencode($dept_id);
		}
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

	//	print_r($online_applications);
	
	$tpl->assign('dept_id_sel', $dept_id);
	$tpl->assign('emp_list', $emp_list);
	//$tpl->assign('firstNumber', $start);
	$tpl->assign('user_type', $_SESSION['user_type']);
	//$tpl->assign('emp_id', $emp_id);
	$tpl->assign('status', $status);
	//$tpl->assign('sla', $_REQUEST['sla_status']);
	$tpl->assign('dept_id', $dept_id);
	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('online_applications', $online_applications);
	//$tpl->assign('reference_no', $_POST['reference_no']);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('data', $data);
	//$tpl->assign('tot', $tot);
	//$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
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
	$tpl->display('corp_inner_pendancy_report.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
