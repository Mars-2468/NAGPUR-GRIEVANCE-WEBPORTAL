<?php
require "config.php";
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

if (isset($_GET['active'])) {
	$active_class = $_GET['active'];
}
if (isset($_SESSION['uid'])) {
	//session_regenerate_id();

	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	/// In case of service 

	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

	$cs_id = strip_tags($_REQUEST['cs_id'])??'';
	$status = strip_tags($_REQUEST['status'])??'';
	$ulbid = strip_tags($_SESSION['ulbid'])??'';
	$user_type = strip_tags($_SESSION['user_type'])??'';
	

	$street_id = $_REQUEST['street_id']??'';

	$grievances_trns=$_SESSION['grievances_trns'];
	$app_type_id = $_REQUEST['app_type_id']??'';
	$emp_id = $_SESSION['emp_id']??'';
	$dept_id = $_SESSION['dept_id']??'';
	
	$fdate = '';
	$tdate = '';

	if (!empty($_REQUEST['f_date']) && !empty($_REQUEST['t_date'])) {

		$f = strtotime($_REQUEST['f_date']);
		$t = strtotime($_REQUEST['t_date']);

		if ($f && $t) {
			$fdate = date('Y-m-d', $f);
			$tdate = date('Y-m-d', $t);
		}
	}

	$sql = "select ward_id, ward_desc from ward_mst where ulbid=?";

	$query = $conn->prepare($sql);
	$query->bind_param("s", $ulbid);
	$query->execute();
	$rs = $query->get_result();



	while ($row = $rs->fetch_assoc()) {
		$ward_list[$row['ward_id']] = $row['ward_desc'];
	}

	$sql = "select street_id, street_desc from street_mst where ulbid=?";

	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$query = $conn->prepare($sql);
	$query->bind_param("s", $ulbid);
	$query->execute();
	$rs = $query->get_result();

	while ($row = $rs->fetch_assoc()) {
		$street_list[$row['street_id']] = $row['street_desc'];
	}
	
	$baseSql = "
	SELECT 
		g.grievance_id,
		g.person_name,
		g.hno,
		g.address,
		g.ward_id,
		g.street_id,
		g.mobile,
		g.comp_desc,
		e.emp_name,
		e.emp_mobile
	FROM grievances g
	INNER JOIN $grievances_trns gt 
		ON g.grievance_id = gt.grievance_id
	LEFT JOIN cs_mst c 
		ON g.cat3_id = c.cs_id
	LEFT JOIN emp_mst e 
		ON gt.emp_id = e.emp_id
	WHERE g.ulbid = $ulbid
	AND g.app_type_id = '1'
	";

	$baseSqlExcel = "
	SELECT 
		g.person_name AS ApplicantName,
		g.mobile AS ApplicantMobile,
		g.hno AS HNo,
		g.address AS Address,
		g.ward_id AS Zone,
		g.street_id AS Ward,
		g.comp_desc AS ComplaintDetails,
		e.emp_name AS EmployeeName,
		e.emp_mobile AS EmployeeMobile,
		g.date_regd AS ReceivedDate
	FROM grievances g
	INNER JOIN $grievances_trns gt 
		ON g.grievance_id = gt.grievance_id
	LEFT JOIN cs_mst c 
		ON g.cat3_id = c.cs_id
	LEFT JOIN emp_mst e 
		ON gt.emp_id = e.emp_id
	WHERE g.ulbid = $ulbid
	AND g.app_type_id = '1'
	";

	if ($user_type == 'E'){
	   if($emp_id!=''){
			$baseSql .= " AND gt.emp_id =".$emp_id." ";
			$baseSqlExcel .= " AND gt.emp_id =".$emp_id." ";
	   } 	   
	   if($dept_id!=''){
			$baseSql .= " AND gt.dept_id =".$dept_id." ";
			$baseSqlExcel .= " AND gt.dept_id =".$dept_id." ";
	   }
	}

	if ($fdate!='' && $tdate!=''){
		$baseSql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		$baseSqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' "; 
	}

	if ($cs_id!=''){
		$baseSql .= " AND g.cat3_id=".$cs_id." ";   
		$baseSqlExcel .= " AND g.cat3_id=".$cs_id." ";   
	}
	
//***********************************************************************

	if ($cs_id && $status == 0) {
		$sql = $baseSql . " AND g.grievance_status_id IN(2,3,6,8,9,11,12,13) AND gt.disposal_status IN(2,3,6,8,9,11,12,13) ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(2,3,6,8,9,11,12,13) AND gt.disposal_status IN(2,3,6,8,9,11,12,13) ";
	}
	
/*** Pending within SLA ***/

	if ($cs_id && $status == 2) {
		$sql = $baseSql . " AND g.grievance_status_id IN(2) AND gt.disposal_status IN(2) AND g.sla_status=1 ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(2) AND gt.disposal_status IN(2) AND g.sla_status=1 ";
	}

/*** Pending beyond SLA ***/

	if ($cs_id && $status == 8) {
		$sql = $baseSql . " AND g.grievance_status_id IN(2) AND gt.disposal_status IN(2) AND g.sla_status=2 ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(2) AND gt.disposal_status IN(2) AND g.sla_status=2 ";
	}

/**** Resolved within SLA ****/

	if ($cs_id && $status == 3) {
		$sql = $baseSql . " AND g.grievance_status_id IN(3,8,9) AND g.sla_status=1 ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(3,8,9) AND g.sla_status=1 ";
	}

/** Resolved beyond SLA ****/

	if ($cs_id && $status == 9) {
		$sql = $baseSql . " AND g.grievance_status_id IN(3,8,9) AND g.sla_status=2 ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(3,8,9) AND g.sla_status=2 ";
	}

/*** REOPENED COMPLAINTS ***/

	if ($cs_id && $status == 5) {
		$sql = $baseSql . " AND g.grievance_status_id IN(13) AND gt.disposal_status IN(13) ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(13) AND gt.disposal_status IN(13) ";
	}

/*** REOPENED UnderProgress COMPLAINTS ***/

	if ($cs_id && $status == 105) {
		$sql = $baseSql . " AND g.grievance_status_id IN(11) AND gt.disposal_status IN(11) ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(11) AND gt.disposal_status IN(11) ";
	}

/*** REOPENED COMPLETED COMPLAINTS ***/

	if ($cs_id && $status == 7) {
		$sql = $baseSql . " AND g.grievance_status_id IN(12) ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(12) ";
	}

/*** REOPENED UnderProgress COMPLAINTS ***/

	if ($cs_id && $status == 108) {
		$sql = $baseSql . " AND g.grievance_status_id IN(3,8,9,12) ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(3,8,9,12) ";
	}

/*** Financial Implication ***/
	if ($cs_id && $status == 10) {
		$sql = $baseSql . " AND g.grievance_status_id IN(6) ";
		$sqlExcel = $baseSqlExcel . " AND g.grievance_status_id IN(6) ";
	}
	
//*****************************************************************

	$baseQuery = "
	SELECT 
		COUNT(DISTINCT g.grievance_id) AS num,
		gt.emp_id
	FROM grievances g
	INNER JOIN $grievances_trns gt 
		ON g.grievance_id = gt.grievance_id
	LEFT JOIN cs_mst c 
		ON g.cat3_id = c.cs_id
	LEFT JOIN emp_mst e 
		ON gt.emp_id = e.emp_id
	WHERE g.ulbid = $ulbid
	AND g.app_type_id = '1'
	";

	if ($user_type == 'E'){
	   if($emp_id!=''){
			$baseQuery .= " AND gt.emp_id =".$emp_id." ";
	   } 	   
	   if($dept_id!=''){
			$baseQuery .= " AND gt.dept_id =".$dept_id." ";
	   }
	}

	if ($fdate!='' && $tdate!=''){
		$baseQuery .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
	}

	if ($cs_id!=''){
		$baseQuery .= " AND g.cat3_id=".$cs_id." ";		 
	}

//********************************************************

	$adjacents = 5;
	if ($status == 0) {
		$query = $baseQuery . " AND g.grievance_status_id IN(2,3,6,8,9,11,12,13) AND gt.disposal_status IN(2,3,6,8,9,11,12,13) ";
	} else if ($status == 1) {
		$query = $baseQuery . " AND g.grievance_status_id IN(2) AND gt.disposal_status IN(2) AND g.sla_status=1 ";
	} else if ($status == 2) {
		$query = $baseQuery . " AND g.grievance_status_id IN(2) AND gt.disposal_status IN(2) AND g.sla_status=2 ";
	} else if ($status == 3) {
		$query = $baseQuery . " AND g.grievance_status_id IN(3,8,9) AND g.sla_status=1 ";
	} else if ($status == 4) {
		$query = $baseQuery . " AND g.grievance_status_id IN(3,8,9) AND g.sla_status=2 ";
	} else if ($status == 5) {
		$query = $baseQuery . " AND g.grievance_status_id IN(2) AND gt.disposal_status IN(2) AND g.sla_status=2 ";
	} else if ($status == 6) {
		$query = $baseQuery . " AND g.grievance_status_id IN(6) ";
	}


//*********************************************************************************




	$result = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($result)) {
		$total_pages = $row['num'];
		//echo $row['num'];
	}

	$_SESSION['myquery'] = $sqlExcel;
	
	
/* ====================pagination code start========================= */	
	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
		
	$start = ($page - 1) * $limit;
	
	$pageNumber=$start+1;
	$tpl->assign('pageNumber', $pageNumber);
	$tpl->assign('cat3_id', $cat3_id);
	$tpl->assign('grievance_status_id', $grievance_status_id);
	
	$pgrs=mysqli_query($conn,$sql);

	$sql.=" LIMIT ".$start.", ".$limit." ";	

	//echo "<pre>";print_r($sql);echo "</pre>";die();

	$total_rows=$pgrs->num_rows;

/* ====================pagination code end========================= */

	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	$field_info = mysqli_fetch_fields($rs);
	while ($row = mysqli_fetch_assoc($rs)) {
		foreach ($field_info as $fi => $f)
			$data[$row['grievance_id']][$f->name] = $row[$f->name];
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
		
		if (!empty($dept_id)) {
			$filter_query .= '&dept_id=' . urlencode($dept_id);
		}
		if (!empty($fdate)) {
			$filter_query .= '&f_date=' . urlencode($fdate);
		}
		if (!empty($tdate)) {
			$filter_query .= '&t_date=' . urlencode($tdate);
		}		
		$tpl->assign('filter_query', $filter_query);
		
	/************************************/
	
	//echo "<pre>";print_r($filter_query);echo "</pre>";die();

	$tpl->assign('filter_query', $filter_query);	
	$tpl->assign('pagination', $pagination);
	$tpl->assign('current_page', $page);
	$tpl->assign('total_pages', $total_pages);
	
/************************* pagination end  **************************/

	$conn->close();
	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('street_list', $street_list);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('status', $status);
	$tpl->assign('cs_id', $cs_id);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('app_type_id', $_REQUEST['app_type_id']);	
	$tpl->assign('data', $data);	
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);	
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('f_date', $fdate);
	$tpl->assign('t_date', $tdate);
	$tpl->display('emp_complaints_full_rep.tpl');
} else {	
	echo "<script>window.location='index.php';</script>";
}
