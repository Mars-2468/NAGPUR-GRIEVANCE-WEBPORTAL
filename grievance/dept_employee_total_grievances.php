<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {
	//session_regenerate_id();

	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	$app_type_id = $_REQUEST['app_type_id'];
	$emp_id = $_REQUEST['emp_id'];
	$reference_no = $_REQUEST['reference_no'];
	$status = $_REQUEST['status'];
	$dept_id = $_REQUEST['dept_id'];


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

/************************* pagination part start  **************************/
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	//echo"<pre>";print_r(isset($_GET['page']));echo"</pre>";die();
	// Set variables
	//$limit = 50; // Number of records per page
	
	$start = ($page - 1) * $limit;
	$pageNumber=$start+1;
/************************* pagination part end  **************************/

	if ($status == 100) {
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and 
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) and g.cat3_id !='0' ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and
		g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and g.cat3_id !='0' and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) ";
		
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
				
	} else if ($status == 21) {
	
	// within sla
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and sla_status='1' ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.grievance_status_id IN('2') and sla_status='1'";
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
		
		//echo "<pre>";print_r($sql);echo "</pre>";die();	
		
	}else if ($status == 22) {
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		g.sla_status='2' and gt.disposal_status IN (2) and g.grievance_status_id IN(2) and cat3_id !='0'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id
		and g.grievance_status_id=gsm.grievance_status_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN (2) and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
		
	//echo "<pre>";print_r($sql);echo "</pre>";die();	
	
	} else if ($status == 3891) {
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(3,8,9) and sla_status='1'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "' and g.grievance_status_id IN('2') and sla_status='2'";
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
		
	//echo "<pre>";print_r($sql);echo "</pre>";die();	
	
	} else if ($status == 3892) {
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		g.sla_status='2' and g.grievance_status_id IN(3,8,9) and cat3_id!=0 ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN (2) and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5'";
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
		
		//echo "<pre>";print_r($sql);echo "</pre>";die();	
		
	} else if ($status == 4) {
		$sql = "SELECT g.*,gt.emp_id FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8','12','6','10') and cat3_id !='0' and gt.disposal_status NOT IN(12,5,13,11) ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('3','9','8','12','6','10') and cat3_id !='0' and gt.disposal_status not in(12,5,13,11) and gt.disposal_status!='5' ";
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
	} else if ($status == 13) {

		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "'  
		and g.grievance_status_id IN(13) and gt.disposal_status IN(13) and cat3_id !='0'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.grievance_status_id IN('3','9','8') and g.sla_status='1' and cat3_id !='0'";

		
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
			
	} else if ($status == 11) {

		$sql = "select g.*,gt.emp_id,gt.disposal_status from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		 g.grievance_status_id IN(11) and gt.disposal_status IN(11) and cat3_id !='0' ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
	} else if ($status == 12) {

		$sql = "select g.*,gt.emp_id,gt.disposal_status from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		 g.grievance_status_id IN(12) and gt.disposal_status IN(12) and cat3_id !='0' ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
	} else if ($status == 510) {
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "'  and
		g.grievance_status_id IN(5,10) and cat3_id!=0 ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and
		g.grievance_status_id IN('3','9','8') and sla_status='2'";

			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
	} 
		if($dept_id!=null)
		$sql.="  and gt.dept_id=".$dept_id ." ";

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
		
		$pg_sql=$sql;
	
		$sql .= " order by g.grievance_id DESC";
//echo "<pre>";print_r($sql);echo "</pre>";die();

/************************* pagination part start  **************************/

		
		$sql.=" LIMIT ".$start.", ".$limit." ";	
		
		$pgrs=mysqli_query($conn,$pg_sql);
		
			$total_rows=$pgrs->num_rows;
		
/************************* pagination part end  **************************/

		$rs=mysqli_query($conn,$sql);
		
		$field_info = mysqli_fetch_fields($rs);
		
		while($row = mysqli_fetch_assoc($rs))
		{
			foreach($field_info as $fi => $f) 
				$data[$row['grievance_id']][$f->name]=$row[$f->name];
			
		}

//echo "<pre>";print_r($sql);echo "</pre>";die();

	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	
	$sql = "select cs_id,cs_desc as comp_desc from standard_services";

	if ($_REQUEST['app_type_id'] == '1') {
		$sql = "select cs_id,cs_desc as comp_desc from cs_mst";
	}
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$cs_list[$row['cs_id']] = $row['comp_desc'];
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


/***********************************pagination start********************************/

	$total_pages = ceil($total_rows / $limit);
	
	// Generate pagination data
	$pagination = [
		'current_page' => $page,
		'total_pages' => $total_pages,
		'range' => 3 // Number of visible pages before/after the current page
	];
		

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
	
	$tpl->assign('pagination', $pagination);
	$tpl->assign('current_page', $page);
	$tpl->assign('total_pages', $total_pages);
	
	/***********************************pagination end********************************/
	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	mysqli_close($conn);
	$start = $start + 1;
	//	print_r($online_applications);

	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('pageNumber', $pageNumber);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('reference_no', $reference_no);
	$tpl->assign('status', $status);
	$tpl->assign('dept_id', $dept_id);

	//$tpl->assign('dept_id', $_REQUEST['dept_id']);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('user_type', $_SESSION['user_type']);
	/*$tpl->assign('fdate', $_REQUEST['f_date']);
	$tpl->assign('tdate', $_REQUEST['t_date']);*/

	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('online_applications', $online_applications);
	
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	//$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	//$tpl->assign('status', $_REQUEST['status']);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('sno', $start);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('dept_employee_total_grievances.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
?>