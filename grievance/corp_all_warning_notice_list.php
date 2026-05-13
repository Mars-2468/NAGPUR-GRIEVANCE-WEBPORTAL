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

	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

	$app_type_id = $_REQUEST['app_type_id'];
	$emp_id = $_REQUEST['emp_id'];
	$status = $_REQUEST['status'];
	$dept_id = $_REQUEST['dept_id'];
	$user_type = $_SESSION['user_type'];
	$ward_id = $_SESSION['zone_id'];
	$ulbid = $_SESSION['ulbid'];
	$fdate = $_REQUEST['f_date'];
	$tdate = $_REQUEST['t_date'];

//echo "<pre>";print_r($_SESSION);echo "</pre>";die();

	$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:'';

	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('status', $status);
	$tpl->assign('dept_id', $dept_id);
	$tpl->assign('ulbid', $ulbid);

	$f_date='';
	$t_date='';

	if ($fdate != '' && $tdate != '') {
		$f_date = date('Y-m-d', strtotime($fdate));
		$t_date = date('Y-m-d', strtotime($tdate));

		$fdate = date('Y-m-d', strtotime($fdate));
		$tdate = date('Y-m-d', strtotime($tdate));
	}

	if ($app_type_id == 1) {
		$table = "cs_mst";
		$fieldName = "c.cs_desc";
	} else {
		$table = "standard_services";
		$fieldName = "c.cs_desc";
	}

	if ($status == 'war') {
		$sql = "SELECT distinct(sc.grievance_id), sc.warning_id,  sc.datetime AS warning_date, e.emp_id,e.emp_name,d.dept_id,d.dept_desc, g.ward_id, g.street_id, g.date_regd,g.cat3_id from show_case_response_logs sc,emp_mst e,emp_map em,dept_mst d,grievances g,cs_mst cs,ward_mst w where sc.emp_id = e.emp_id and e.emp_id = em.emp_id and e.emp_dept = d.dept_id and sc.grievance_id = g.grievance_id and g.cat3_id = cs.cs_id and g.ward_id = w.ward_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and sc.emp_id = '" . $emp_id . "' and em.ward_id = ".$ward_id." ";
		$sqlExcel = "SELECT sc.warning_id as WarningNo, sc.grievance_id as ReferenceNo, e.emp_name as EmployeeName, d.dept_desc as DeparmentName, w.ward_desc as ZoneName, s.street_desc as StreetName, c.cs_desc as ComplaintDetails, g.date_regd as ReceivedDate, sc.datetime AS WarningDate from show_case_response_logs sc,emp_mst e,dept_mst d,grievances g,ward_mst w,street_mst s,cs_mst as c where sc.emp_id = e.emp_id and e.emp_dept = d.dept_id and sc.grievance_id = g.grievance_id and g.ward_id = w.ward_id and g.street_id = s.street_id and g.cat3_id = c.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and sc.emp_id = '" . $emp_id . "'";
	} 
	
	if ($fdate != '' && $tdate != '') {
		$sql .= "and date(sc.datetime) between '" . $f_date . "' and '" . $t_date . "'  and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01' ";
		$sqlExcel .= "and date(sc.datetime) between '" . $f_date . "' and '" . $t_date . "' ";
	}else{
		$sql .= "  and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01'  ";				
	}
		
	if ($selectedYear!='') { 
		$sql .=" and date_format(sc.date_regd, '%Y') = '" . $selectedYear . "'  ";
	}	
	
	if (isset($_POST['search'])) {
		if ($_POST['warning_no'] != '') {
			$sql .= " and sc.warning_id='" . $_POST['warning_no'] . "'";
			$sqlExcel .= " and sc.warning_id='" . $_POST['warning_no'] . "'";
		}
		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
			$f_date = date('Y-m-d', strtotime($_POST['f_date']));
			$t_date = date('Y-m-d', strtotime($_POST['t_date']));
			$sql .= " and date(sc.datetime) between '" . $f_date . "' and '" . $t_date . "'  and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01'  ";
			$sqlExcel .= " and date(sc.datetime) between '" . $f_date . "' and '" . $t_date . "' sc.warning_id ASC";
		}else{
			$sql .= "  and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01' ";				
		}
	}
	$sql .= " order by sc.warning_id ASC ";

/* ====================pagination code start========================= */	
	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	$start = ($page - 1) * $limit;
	
	$pageNumber=$start+1;
	
	$tpl->assign('pageNumber', $pageNumber);		

//echo $sql;exit;

	$pgrs=mysqli_query($conn,$sql);

	$sql.=" LIMIT ".$start.", ".$limit." ";	

	//echo "<pre>";print_r($sql);echo "</pre>";die();

	$total_rows=$pgrs->num_rows;
	
	//echo $total_rows;exit;

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

	$sql = "select warning_id,grievance_id,emp_id,notice_status,is_test_done,datetime from show_case_response_logs where emp_id='" . $emp_id . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
		$warning_list[$row['warning_id']] = $row['warning_id'];
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

		/* if (!empty($reference_no)) {
			$filter_query .= '&reference_no=' . urlencode($reference_no);
		} */

		/* if (!empty($status)) {
			$filter_query .= '&status=' . urlencode($status);
		} */
		
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
	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('warning_no', $_POST['warning_no']);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('status', $status);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('warning_list', $warning_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('mc_yn', $_SESSION['mc_yn']);
	$tpl->assign('is_hod', $_SESSION['is_hod']);
	$tpl->assign('is_level4_emp', $_SESSION['is_level4_emp']);
	$tpl->display('corp_all_warning_notice_list.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
?>