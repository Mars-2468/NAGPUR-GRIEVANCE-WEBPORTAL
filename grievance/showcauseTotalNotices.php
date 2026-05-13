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

	$app_type_id = $_REQUEST['app_type_id'];
	$emp_id = $_REQUEST['emp_id'];
	$warning_no = $_REQUEST['warning_no'];
	$status = $_REQUEST['status'];
	$dept_id = $_REQUEST['dept_id'];
	
	$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:'';

	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
	}

	if ($_REQUEST['app_type_id'] == 1) {
		$table = "cs_mst";
		$fieldName = "c.cs_desc";
	} else {
		$table = "standard_services";
		$fieldName = "c.cs_desc";
	}

	if ($status == 'show_all') {

		$sql = "SELECT sc.warning_id, sc.row_number, sc.datetime AS showcase_date, e.emp_id,e.emp_name,d.dept_id,d.dept_desc, g.ward_id, g.street_id, g.date_regd,sc.grievance_id,g.cat3_id from show_case_response_logs sc,emp_mst e,dept_mst d,grievances g where sc.grievance_id = g.grievance_id and sc.emp_id = e.emp_id and e.emp_dept = d.dept_id and sc.row_number%5=0";

		$sqlExcel = "SELECT sc.warning_id as ShowcauseNo, r.grievance_id as ReferenceNo, e.emp_name as EmployeeName, d.dept_desc as DeparmentName, w.ward_desc as ZoneName, s.street_desc as StreetName, c.cs_desc as ComplaintDetails, g.date_regd as ReceivedDate, sc.datetime AS ShowcaseDate from show_case_emp_count sc,emp_mst e,show_case_response_logs r,dept_mst d,grievances g,ward_mst w,street_mst s,cs_mst as c where sc.emp_id = e.emp_id and e.emp_dept = d.dept_id and sc.emp_id = r.emp_id and r.grievance_id = g.grievance_id and g.ward_id = w.ward_id and g.street_id = s.street_id and g.cat3_id = c.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "'";

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
			$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
			$sql.="and date_format(sc.datetime,'%Y-%m-%d') between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date_format(sc.datetime,'%Y-%m-%d') between '".$fdate."' and '".$tdate."' and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01' ";
		}else{
			$sql .= "  and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01' ";				
		}
		
		if ($selectedYear) { 
			$sql .=" and date_format(sc.date_regd, '%Y') = '" . $selectedYear . "'  ";
		}
		
		if (isset($_POST['search'])) {
			if ($_POST['showcause_no'] != '') {
				$sql .= " and sc.warning_id='" . $_POST['showcause_no'] . "'";
				$sqlExcel .= " and sc.warning_id='" . $_POST['showcause_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date_format(sc.datetime,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' and date_format(sc.date_regd, '%Y-%m-%d') >= '2024-09-01'  ";
				$sqlExcel .= " and date_format(sc.datetime,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "'";
			}
		}
		$sql .= " group by sc.warning_id";
		$sqlExcel .= " group by sc.warning_id";
	}        
	
/* ====================pagination code start========================= */	
	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	//echo $page;exit;
	$cat3_id = strip_tags($_REQUEST['cat3_id']);
	$grievance_status_id = strip_tags($_REQUEST['grievance_status_id']);
	//echo"<pre>";print_r(isset($_GET['page']));echo"</pre>";die();
	// Set variables
	
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
	
//echo "<pre>";print_r($sql);echo "</pre>";die();

	$sql = "select cs_id,cs_desc as comp_desc from standard_services";

	if ($_REQUEST['app_type_id'] == '1') {
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

	$sql = "select showcause_id,emp_id,showcase_count,`datetime` from show_case_emp_count";
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

	/* 	if (!empty($dept_id)) {
			$filter_query .= '&dept_id=' . urlencode($dept_id);
		} */
		if (!empty($fdate)) {
			$filter_query .= '&f_date=' . urlencode($fdate);
		}

		if (!empty($tdate)) {
			$filter_query .= '&t_date=' . urlencode($tdate);
		}

		/* if (!empty($reference_no)) {
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
	$start = $start + 1;
	$tpl->assign('dept_id_sel', $_REQUEST['dept_id']);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('firstNumber', $start);
	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('showcause_no', $_POST['showcause_no']);
	$tpl->assign('status', $status);
	$tpl->assign('dept_id', $dept_id);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('sno', $start);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('showcause_list', $showcause_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('showcauseTotalNotices.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
?>