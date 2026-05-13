<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {

//echo "<pre>";print_r($_SESSION);echo "</pre>";die();

	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	$user_type=$_SESSION['user_type'];
	
	$filteryear=$_SESSION['filteryear'];

	$app_type_id = $_REQUEST['app_type_id'];
	$emp_id = $_REQUEST['emp_id'];
	$reference_no = $_REQUEST['reference_no'];
	$status = $_REQUEST['status'];
	$dept_id = $_REQUEST['dept_id'];
	
/* ====================pagination code start========================= */	
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	//echo"<pre>";print_r(isset($_GET['page']));echo"</pre>";die();
		
	$start = ($page - 1) * $limit;
	
	$pageNumber=$start+1;
/* ====================pagination code end========================= */			

	$emplist = join("','", $_SESSION['emp_list']);

	$sql = "SELECT dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($_SESSION['user_type'] == 'E' || $_SESSION['user_type'] == 'D') {

		$sql = "SELECT d.dept_id,dept_desc from dept_mst d, hod_emp_map h where h.dept_id = d.dept_id and emp_id IN ('" . $emplist . "')";
	}

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_id'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$dept_list1 = $dept_list;

	$deptlist = implode(',', $dept_list1);

	$sql = "SELECT emp_id, emp_name, emp_mobile from emp_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {

		$emp_list[$row['emp_id']] = $row['emp_name'] . " - " . $row['emp_mobile'];

		$emp_mobile[$row['emp_id']] = $row['emp_mobile'];
	}

	$tpl->assign('emp_list', $emp_list);

	$tpl->assign('emp_mobile', $emp_mobile);

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

	if ($status == 100) {

		if ($user_type == 'U') {

			 $sql = "SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) 
					AND gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) 
					AND g.cat3_id != 0 "; 
			
			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status != 5 and cat3_id !='0'";
		} else {

			$sql = "SELECT g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt,emp_mst e where g.grievance_id=gt.grievance_id  and gt.dept_id=e.emp_dept and gt.emp_id=e.emp_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
			g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2,3,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,6,8,9,10,11,12,13)  and cat3_id !='0' and gt.dept_id IN ( $deptlist )";

			$sql = "SELECT * from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id 
			and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	} else if ($status == 200) {

		if ($user_type == 'U') {
			 
			$sql = "SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(2) 
					AND gt.disposal_status IN(2) 
					AND g.sla_status='1'
					AND g.cat3_id != 0 "; 
					
			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2) and sla_status=1 and gt.disposal_status != 5 and cat3_id !='0'";
		} else {
			$sql = "SELECT g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and g.sla_status='1' and g.grievance_status_id IN(2) and gt.dept_id IN ( $deptlist )";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2) and sla_status=1 and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	} else if ($status == 300) {

		if ($user_type == 'U') {

			$sql = "SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(2) 
					AND gt.disposal_status IN(2) 
					AND g.sla_status='2'
					AND g.cat3_id != 0 "; 
					

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2) and sla_status=2 and gt.disposal_status != 5 and cat3_id !='0'";
		} else {
			$sql = "SELECT g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and g.sla_status='2' and gt.disposal_status IN (2) and grievance_status_id IN(2) and gt.dept_id IN ( $deptlist )";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2) and sla_status=2 and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	} else if ($status == 400) {

		if ($user_type == 'U') {
		
			$sql = "SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(3,8,9) 
					AND g.sla_status='1'
					AND g.cat3_id != 0 "; 
 
 			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('3','9','8') and sla_status=1 and gt.disposal_status != 5 and cat3_id !='0'";
		} else {
			$sql = "SELECT g.*,gt.emp_id FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
			app_type_id='1' and grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' and gt.dept_id IN ( $deptlist )";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('3','9','8') and sla_status=1 and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	} else if ($status == 500) {

		if ($user_type == 'U') {
		
 
			$sql = "SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(3,8,9) 
					AND g.sla_status='2'
					AND g.cat3_id != 0 "; 				
					
		
			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('3','9','8') and sla_status=2 and gt.disposal_status != 5 and cat3_id !='0'";
		} else {
			$sql = "SELECT g.*,gt.emp_id FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
			app_type_id='1' and grievance_status_id IN('3','9','8') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5' and gt.dept_id IN ( $deptlist )";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('3','9','8') and sla_status=2 and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	} else if ($status == 600) {

		if ($user_type == 'U') {
			
			$sql = "SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(13) 
					AND gt.disposal_status IN(13) 
					AND g.cat3_id != 0 "; 

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('13') and gt.disposal_status != 5 and cat3_id !='0'";
		} else {
			$sql = "SELECT g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and gt.disposal_status IN (13) and g.grievance_status_id IN(13) and gt.dept_id IN ( $deptlist )";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('13') and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	} else if ($status == 700) {

		if ($user_type == 'U') {

			$sql = "SELECT g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and grievance_status_id IN(6) and cat3_id !='0'";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status != 5 and cat3_id !='0'";
		} else {

			$sql = "SELECT g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and grievance_status_id IN(6) and gt.dept_id IN ( $deptlist ) and cat3_id !='0'";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('6') and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	} else if ($status == 701) {

		if ($user_type == 'U') {

			/* $sql = "SELECT g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and grievance_status_id IN(6) and cat3_id !='0'";
			*/
			
			$sql = "SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(5,10) 
					AND g.cat3_id != 0 "; 
			
			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status != 5 and cat3_id !='0'";
		} else {

			$sql = "SELECT g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and grievance_status_id IN(6) and gt.dept_id IN ( $deptlist ) and cat3_id !='0'";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('6') and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	} else if ($status == 105) {

		if ($user_type == 'U') {
				
			$sql = "SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(11) 
					AND gt.disposal_status IN(11) 
					AND g.cat3_id != 0 "; 


			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and and g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0'";
		} else {

			$sql = "SELECT g.*,gt.emp_id,gt.dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.dept_id IN( $deptlist ) 
			and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('11') and gt.disposal_status !=5 and cat3_id !='0' ";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('11') and gt.disposal_status !=5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	} else if ($status == 601) {

		if ($user_type == 'U') {
			
				$sql = "SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(12) 
					AND gt.disposal_status IN(12) 
					AND g.cat3_id != 0 "; 

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0'";
		} else {

			$sql = "SELECT g.*,gt.emp_id,gt.dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.dept_id IN( $deptlist ) 
			and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5') and cat3_id !='0' ";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5') and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	}else if ($status == 501) {
		if ($user_type == 'U') {

			$sql = "SELECT g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' 
			and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' ";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0'";
		} else {

			$sql = "SELECT g.*,gt.emp_id,gt.dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.dept_id IN( $deptlist ) 
			and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('11') and gt.disposal_status !=5 and cat3_id !='0' ";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('11') and gt.disposal_status !=5 and cat3_id !='0' and gt.dept_id IN ( $deptlist )";
		}
	}
	if ($filteryear) {
		$sql .= " and date_format(date_regd,'%Y') = '" . $filteryear . "' ";
		
		$sqlExcel .= " and date_format(date_regd,'%Y') '" . $filteryear . "' ";
	}
	
	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
	}
	
	if (isset($_POST['search'])) {
		if ($_POST['reference_no'] != '') {
			$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "' ";

			$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "' ";
		}
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= "and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
			$sqlExcel .= "and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	

	$_SESSION['myquery'] = $sqlExcel;
	

//echo"<pre>";print_r($sql);echo"</pre>";die();


	$adjacents = 5;

	if ($status == 100) {
		if ($user_type == 'U') {
			$query = "SELECT count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and 
			g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status != 5 and cat3_id !='0'";
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status != 5 and cat3_id !='0' and gt.dept_id IN ($deptlist)";
		}
	} else if ($status == 200) {

		if ($user_type == 'U') {
			$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and 
			g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and g.sla_status='1' and g.grievance_status_id IN(2) ";
		} else {
			$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and 
			g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and g.sla_status='1' and g.grievance_status_id IN(2) and gt.dept_id IN ($deptlist) ";
		}
	} else if ($status == 300) {

		if ($user_type == 'U') {
			$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and g.sla_status='2' and gt.disposal_status IN (2) and g.grievance_status_id IN(2)";
		} else {
			$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and g.sla_status='2' and gt.disposal_status IN (2) and g.grievance_status_id IN(2) and gt.dept_id IN ($deptlist) ";
		}
	} else if ($status == 400) {

		if ($user_type == 'U') {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
			app_type_id='1' and grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
			app_type_id='1' and grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' and gt.dept_id IN ($deptlist) ";
		}
	} else if ($status == 500) {

		if ($user_type == 'U') {
			$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and 
			g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.sla_status='2' and gt.disposal_status IN ('3','8','9','12') and g.grievance_status_id IN('3','8','9','12')";
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and 
			g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.sla_status='2' and gt.disposal_status IN ('3','8','9','12') and g.grievance_status_id IN('3','8','9','12') and gt.dept_id IN ($deptlist) ";
		}
	} else if ($status == 600) {

		if ($user_type == 'U') {
			$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and gt.disposal_status IN (13) and grievance_status_id IN(13) ";
		} else {
			$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and gt.disposal_status IN (13) and grievance_status_id IN(13) and gt.dept_id IN ($deptlist) ";
		}
	} else if ($status == 700) {

		if ($user_type == 'U') {
			$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and gt.disposal_status IN (6) and grievance_status_id IN(6) ";
		} else {
			$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and gt.disposal_status IN (6) and grievance_status_id IN(6) and gt.dept_id IN ($deptlist) ";
		}
	} else if ($status == 701) {

		if ($user_type == 'U') {
			$query = "SELECT count(g.grievance_id) as num
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(5,10) 
					AND g.cat3_id != 0 "; 
		} else {
			
		/* 	$query = "SELECT count(g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and gt.disposal_status IN (6) and grievance_status_id IN(6) and gt.dept_id IN ($deptlist) ";
		 */
			$query = "SELECT count(g.grievance_id) as num
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $_SESSION['ulbid'] . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(5,10) 
					AND g.cat3_id != 0  
					AND gt.dept_id IN ($deptlist) "; 
		
		}
	} else if ($status == 105) {

		if ($user_type == 'U') {

			$query = "SELECT COUNT(DISTINCT g.grievance_id) as num,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' 
			and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' ";
		} else {
			$query = "SELECT COUNT(DISTINCT g.grievance_id) as num,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and dept_id IN( $deptlist ) 
			and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('11') and gt.disposal_status !=5 and cat3_id !='0' ";
		}
	}else if ($status == 601) {

		if ($user_type == 'U') {
			$query = "SELECT COUNT(DISTINCT g.grievance_id) as num,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' 
			and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' ";
		} else {
			$query = "SELECT COUNT(DISTINCT g.grievance_id) as num,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) 
			and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status IN('9') and cat3_id !='0' ";
		}
	}

	if (isset($_POST['search'])) {
		if ($_POST['reference_no'] != '') {
			$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$query .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
		$query .= ' group by emp_dept';
	}

	//$query .= ' group by emp_dept';
	//echo $query;

/* 	$result = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($result)) {
		$total_pages = $row['num'];
		// echo $row['num'];
	} */
	//echo $query;

/* ====================pagination code start========================= */	

		$pg_sql=$sql;
		
//echo "<pre>";print_r($sql);echo "</pre>";die();		
		
		$sql.=" LIMIT ".$start.", ".$limit." ";	
		
		$pgrs=mysqli_query($conn,$pg_sql);
		
			$total_rows=$pgrs->num_rows;
			
/* ====================pagination code end========================= */				

	$rs = mysqli_query($conn, $sql);
	$field_info = mysqli_fetch_fields($rs);
	while ($row = mysqli_fetch_assoc($rs)) {
		foreach ($field_info as $fi => $f)
			$data[$row['grievance_id']][$f->name] = $row[$f->name];
	}

	//pagination end


//echo "<pre>";print_r($sql);echo "</pre>";die();

	$sql = "SELECT cs_id,cs_desc as comp_desc from standard_services";

	if ($_REQUEST['app_type_id'] == '1') {
		$sql = "SELECT cs_id,cs_desc as comp_desc from cs_mst";
	}
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$cs_list[$row['cs_id']] = $row['comp_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "SELECT dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));



	$sql = "SELECT * from grievance_status_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));




/************************* pagination start  **************************/
	
		
	// Query to fetch paginated data


	// Calculate total pages
	
	$total_pages = ceil($total_rows / $limit);
	


	// Generate pagination data
	$pagination = [
		'current_page' => $page,
		'total_pages' => $total_pages,
		'range' => 3 // Number of visible pages before/after the current page
	];
			
	$filter_query = '';

	//echo "<pre>";print_r($data);echo "</pre>";die();
		
	

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
	
	/************************* pagination end  **************************/

//echo"<pre>";print_r($filter_query);echo"</pre>";die();


	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	mysqli_close($conn);
	$start = $start + 1;
	//	print_r($online_applications);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('pageNumber', $pageNumber);
	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('status', $status);
	$tpl->assign('deptlist', $deptlist);
	$tpl->assign('dept_id', $dept_id);

	/*$tpl->assign('fdate',$_REQUEST['f_date']);
        $tpl->assign('tdate',$_REQUEST['t_date']);*/
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('reference_no', $reference_no);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('sno', $start);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('TotalDepartmentsReceivedGrievances.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
?>