<?php
require "config.php";

ini_set('display_errors', 0);
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {

	//session_regenerate_id();
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

	$user_type = !empty($_REQUEST['user_type'])?$_REQUEST['user_type']:'';
	$app_type_id = !empty($_REQUEST['app_type_id'])?$_REQUEST['app_type_id']:'';
	$emp_id = !empty($_REQUEST['emp_id'])?$_REQUEST['emp_id']:'';
	$ward_id = $_SESSION['zone_id'];
	$reference_no = !empty($_REQUEST['reference_no'])?$_REQUEST['reference_no']:'';
	$status = !empty($_REQUEST['status'])? $_REQUEST['status']:'';
	$dept_id = !empty($_REQUEST['dept_id'])?$_REQUEST['dept_id']:'';
	$filteryear=!empty($_SESSION['filteryear'])?$_SESSION['filteryear']:'';
	
	$f_date=!empty($_REQUEST['f_date'])?$_REQUEST['f_date']:'';
	$t_date=!empty($_REQUEST['t_date'])?$_REQUEST['t_date']:'';
		
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

	$sql = "SELECT dept_id,emp_id FROM hod_emp_map ";

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_id'];
	}

	$dept_list1 = $dept_list;
	
	$deptlist = implode(',', $dept_list1);	

	if ($status == 0) {
		//$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.disposal_status IN(2,9,8,4,6,10) and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and cat3_id !='0'";

		$sql="SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '250' 
					AND g.ward_id = '{$ward_id}' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) 
					AND gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) 
					AND gt.dept_id='" . $dept_id . "' 
					AND gt.emp_id='" . $emp_id . "'
					AND g.cat3_id != 0 ";

		$sqlExcel = "SELECT g.grievance_id as RefferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and
		gt.disposal_status=gsm.grievance_status_id and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and gt.disposal_status IN(2,9,8,4,6,10) and app_type_id='1' and cat3_id !='0' ";

		if ($app_type_id == 2) {
			$sqlExcel = "select g.grievance_id as RefferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as ComplaintDetails,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
			g.app_type_id='" . $app_type_id . "' and gt.disposal_status IN(2,9,8,4,6,10) and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and cat3_id !='0'";
		}

	} else if ($status == 2) {
				
		$sql="SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '250' 
					AND g.ward_id = '{$ward_id}' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(2) 
					AND gt.disposal_status IN(2) 
					AND gt.dept_id='" . $dept_id . "' 
					AND gt.emp_id='" . $emp_id . "'
					AND g.sla_status='1'
					AND g.cat3_id != 0 ";
	
		$sqlExcel = "SELECT g.grievance_id as RefferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and
		gt.disposal_status=gsm.grievance_status_id and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and gt.disposal_status IN('2') and g.grievance_status_id IN('2') and sla_status='1' and app_type_id='1' and cat3_id !='0' ";

		if ($app_type_id == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and
			g.app_type_id='" . $app_type_id . "' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and
			gt.disposal_status IN('2') and g.grievance_status_id IN('2') and sla_status='1'";
		}
		if ($f_date != '' && $t_date != '') {
			$sql .= "and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
			$sqlExcel .= "and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
		}
	} else if ($status == 8) {
	
		$sql="SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '250' 
					AND g.ward_id = '{$ward_id}' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(2) 
					AND gt.disposal_status IN(2) 
					AND gt.dept_id='" . $dept_id . "' 
					AND gt.emp_id='" . $emp_id . "'
					AND g.sla_status='2'
					AND g.cat3_id != 0 ";
		
		$sqlExcel = "SELECT g.grievance_id as RefferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and
		gt.disposal_status=gsm.grievance_status_id and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and gt.disposal_status IN('2') and g.grievance_status_id IN('2') and sla_status='2' and app_type_id='1' and cat3_id !='0' ";

		if ($app_type_id == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and
				g.app_type_id='" . $app_type_id . " and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and
				gt.disposal_status IN('2') and g.grievance_status_id IN('2') and sla_status='2'";
		}

	} else if ($status == 3) {
		
		$sql="SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '250' 
					AND g.ward_id = '{$ward_id}' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(3,8,9) 
					AND gt.dept_id='" . $dept_id . "' 
					AND gt.emp_id='" . $emp_id . "'
					AND g.sla_status='1'
					AND g.cat3_id != 0 ";
		
		$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName,mobile as Mobile,address as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status,date_regd as ReceivedDate from grievances g,cs_mst c,
		grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and gt.disposal_status=gsm.grievance_status_id and g.cat3_id=c.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		g.app_type_id='" . $app_type_id . "' and gt.disposal_status NOT IN('5') and gt.dept_id='" . $dept_id . "' and 
		gt.emp_id='" . $emp_id . "'  and g.grievance_status_id IN('3','8','9') and g.sla_status = '1'";

		if ($app_type_id == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "'  and 
				g.app_type_id='" . $app_type_id . "' and gt.disposal_status IN('3','8','9') and gt.dept_id='" . $dept_id . "' and 
				gt.emp_id='" . $emp_id . "'  and g.grievance_status_id IN('3','8','9') and g.sla_status = '1'";
		}

	} else if ($status == 9) {
		//$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "'  and g.grievance_status_id IN('3','8','9') and gt.disposal_status IN('3','8','9') and sla_status='2'";

		$sql="SELECT g.*,gt.dept_id 
			FROM 
				grievances g
			INNER JOIN 
				".$_SESSION['grievances_trns']." gt 
				ON g.grievance_id = gt.grievance_id
			WHERE 
				g.ulbid = '250' 
				AND g.ward_id = '{$ward_id}' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN(3,8,9) 
				AND gt.dept_id='" . $dept_id . "' 
				AND gt.emp_id='" . $emp_id . "'
				AND g.sla_status='2'
				AND g.cat3_id != 0 ";

		$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName,mobile as Mobile,address as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status,date_regd as ReceivedDate from grievances g,cs_mst c,
		grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and gt.disposal_status=gsm.grievance_status_id and g.cat3_id=c.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		g.app_type_id='" . $app_type_id . "' and gt.disposal_status NOT IN('5') and gt.dept_id='" . $dept_id . "' and 
		gt.emp_id='" . $emp_id . "'  and g.grievance_status_id IN('3','8','9') and g.sla_status = '2'";


		if ($app_type_id == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "'  and
				g.app_type_id='" . $app_type_id . "' and gt.dept_id='" . $dept_id . "' and 
				gt.emp_id='" . $emp_id . "'  and g.grievance_status_id IN('3','8','9') and gt.disposal_status IN('3','8','9') and sla_status='2'";
		}

	} else if ($status == 4) {
		$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and g.grievance_status_id IN('4') and gt.disposal_status IN('4')";

		// $sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$app_type_id."' and gt.disposal_status!='5' and gt.dept_id='".$dept_id."' and gt.emp_id='".$_REQUEST['emp_id']."'  and g.grievance_status_id IN('4')";

		$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
			g.app_type_id='" . $app_type_id . "' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and g.grievance_status_id IN('4') and gt.disposal_status IN('4')";


		if ($app_type_id == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "'  and 
				g.app_type_id='" . $app_type_id . "' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "'  and g.grievance_status_id IN('4') and gt.disposal_status IN('4')";
		}

	} else if ($status == 5) {

		$sql="SELECT g.*,gt.dept_id 
			FROM 
				grievances g
			INNER JOIN 
				".$_SESSION['grievances_trns']." gt 
				ON g.grievance_id = gt.grievance_id
			WHERE 
				g.ulbid = '250' 
				AND g.ward_id = '{$ward_id}' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN(13) 
				AND gt.disposal_status IN(13) 
				AND gt.dept_id='" . $dept_id . "' 
				AND gt.emp_id='" . $emp_id . "'
				AND g.cat3_id != 0 ";

		$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and gt.disposal_status IN('13') and is_reopened_yn='1' and g.grievance_status_id IN('13') and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "'";

	}else if ($status == 105) {
	
			$sql="SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '250' 
					AND g.ward_id = '{$ward_id}' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(11) 
					AND gt.disposal_status IN(11) 
					AND gt.dept_id='" . $dept_id . "' 
					AND gt.emp_id='" . $emp_id . "'
					AND g.cat3_id != 0 ";

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and
			gt.disposal_status=gsm.grievance_status_id and app_type_id='1' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('11') and gt.disposal_status IN('11') and gsm.grievance_status_id IN('11') and cat3_id !='0' and gt.grievance_id IN(select gg.grievance_id from grievances gg where gg.grievance_status_id IN(11) and gt.is_escalated='0')";
	
	} else if ($status == 7) {

			$sql="SELECT g.*,gt.dept_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '250' 
					AND g.ward_id = '{$ward_id}' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(12) 
					AND gt.disposal_status IN(12) 
					AND gt.dept_id='" . $dept_id . "' 
					AND gt.emp_id='" . $emp_id . "'
					AND g.cat3_id != 0 ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and
		gt.disposal_status=gsm.grievance_status_id and app_type_id='1' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and gsm.grievance_status_id IN('12') and cat3_id !='0' and gt.grievance_id IN(select gg.grievance_id from grievances gg where gg.grievance_status_id IN(12) and gt.is_escalated='0')";

	} else if ($status == 10) {

		$sql="SELECT g.*,gt.dept_id 
			FROM 
				grievances g
			INNER JOIN 
				".$_SESSION['grievances_trns']." gt 
				ON g.grievance_id = gt.grievance_id
			WHERE 
				g.ulbid = '250' 
				AND g.ward_id = '{$ward_id}' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN(6) 
				AND gt.dept_id='" . $dept_id . "' 
				AND gt.emp_id='" . $emp_id . "'
				AND g.cat3_id != 0 ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and
		gt.disposal_status=gsm.grievance_status_id and app_type_id='1' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('6') and gt.disposal_status IN('6') and gsm.grievance_status_id IN('6') and cat3_id !='0' and gt.grievance_id IN(select gg.grievance_id from grievances gg where gg.grievance_status_id IN('6') and gt.is_escalated='0')";

	} else if ($status == 101) {

		$sql="SELECT g.*,gt.dept_id 
			FROM 
				grievances g
			INNER JOIN 
				".$_SESSION['grievances_trns']." gt 
				ON g.grievance_id = gt.grievance_id
			WHERE 
				g.ulbid = '250' 
				AND g.ward_id = '{$ward_id}' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN(5,10) 
				AND gt.dept_id='" . $dept_id . "' 
				AND gt.emp_id='" . $emp_id . "'
				AND g.cat3_id != 0 ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and
		gt.disposal_status=gsm.grievance_status_id and app_type_id='1' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('6') and gt.disposal_status IN('6') and gsm.grievance_status_id IN('6') and cat3_id !='0' and gt.grievance_id IN(select gg.grievance_id from grievances gg where gg.grievance_status_id IN('6') and gt.is_escalated='0')";

	} else if ($status == 100) {
		$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and is_reopened_yn='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' ";

		$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and is_reopened_yn='1' and g.grievance_status_id IN('13') and g.ulbid='" . $_SESSION['ulbid'] . "' ";
	          
	} else if ($status == 200) {
		if ($app_type_id == 1 && $user_type == 'E') {
			$sql = "select g.*,gt.dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('11','12') and gt.dept_id IN( $deptlist ) ";

			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
        		grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and gt.disposal_status IN('11','12') and gt.dept_id IN( $deptlist ) and cat3_id !='0'";
		} else {
			if ($user_type == 'E') {
				$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and is_reopened_yn='1' and gt.disposal_status IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $emp_id . "'";
			} else {
				$sql = "select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and is_reopened_yn='1' and gt.disposal_status IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $emp_id . "'";

				$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
					grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and is_reopened_yn='1' and g.grievance_status_id IN('13') and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $emp_id . "' and cat3_id !='0'";
			}
		}
                  			          
	}
			
	if ($filteryear != '') {		
		$sql.=" and date_format(date_regd,'%Y') = ".$filteryear;
	}
	
	if($f_date!= '' && $t_date!='')
    {
        $sql.=" and date(date_regd) between '".$fdate."' and '".$tdate."' ";
        $sqlExcel.=" and date(date_regd) between '".$fdate."' and '".$tdate."' ";
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
	$sql .= " group by gt.grievance_id ";
	$sqlExcel .= " group by g.grievance_id";

	$_SESSION['myquery'] = $sqlExcel;

	$adjacents = 5;
	if ($status == 0) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and 
			gt.disposal_status IN(2,9,8,4,6,10) and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and cat3_id !='0'";
	} else if ($status == 2) {
		$query = "select count(DISTINCT g.grievance_id) as num,g.sla_status from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
		    and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and 
		    gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and gt.disposal_status IN('2') and gt.disposal_status NOT IN('2') and sla_status='1'";
	} else if ($status == 3) {

		$query = "select count(DISTINCT g.grievance_id) as num,g.sla_status,g.grievance_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.disposal_status!='5' and gt.dept_id='" . $dept_id . "' 
		and gt.emp_id='" . $emp_id . "' and g.grievance_status_id IN('3','8','9') and gt.disposal_status NOT IN('5') and sla_status='1'";
	} else if ($status == 9) {

		$query = "select count(DISTINCT g.grievance_id) as num,g.sla_status,g.grievance_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
			g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' 
			and g.grievance_status_id IN('3','8','9') and gt.disposal_status IN('3','8','9') and sla_status='2'";

	} else if ($status == 4) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and
		    g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $app_type_id . "' and 
		    gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "'  and g.grievance_status_id IN('4') and gt.disposal_status IN('4') ";
	} else if ($status == 5) {

		$query = "select COUNT(DISTINCT g.grievance_id) as num,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id
		and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status IN('13') and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "'";
	} else if ($status == 100) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
		    and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and
		    g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "'";
	} else if ($status == 200) {
		if ($app_type_id == 1 && $user_type == 'E') {
			$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('11','12') and g.grievance_status_id IN('11','12') and ulbid='" . $_SESSION['ulbid'] . "' and gt.dept_id IN( $deptlist )";
		} else {
			$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
		    	and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and
		    	g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and emp_id='" . $emp_id . "'";
		}
	}
	
	else if ($status == 105) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('11') and g.grievance_status_id IN('11') and ulbid='" . $_SESSION['ulbid'] . "' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "'";
	} else if ($status == 7) {

		$query = "select COUNT(DISTINCT g.grievance_id) as num,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id
		and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status NOT IN('5','9','13') and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "'";
	} else if ($status == 8) {
		$query = "select count(g.grievance_id) as num,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
			g.app_type_id='" . $app_type_id . "' and gt.dept_id='" . $dept_id . "' and gt.emp_id='" . $emp_id . "' and
			g.grievance_status_id IN('2') and gt.disposal_status IN('2') and sla_status='2'";
	}

	if (isset($_POST['search'])) {
		if ($_POST['reference_no'] != '') {
			$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}
		if ($f_date != '' && $t_date != '') {
			$query .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
		$query .= " AND g.ward_id = '{$ward_id}' ";
		$query .= ' group by g.grievance_id';
	}
	
	$result = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($result)) {
		$total_pages = $row['num'];
	}

	/* ====================pagination code start========================= */	
	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	
	$cat3_id = !empty($_REQUEST['cat3_id'])?strip_tags($_REQUEST['cat3_id']):'';
	$grievance_status_id = !empty($_REQUEST['grievance_status_id'])?strip_tags($_REQUEST['grievance_status_id']):'';
	//echo"<pre>";print_r(isset($_GET['page']));echo"</pre>";die();
		
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

	$rs = mysqli_query($conn, $sql);
	$field_info = mysqli_fetch_fields($rs);
	$data=[];
	while ($row = mysqli_fetch_assoc($rs)) {
		foreach ($field_info as $fi => $f)
			$data[$row['grievance_id']][$f->name] = $row[$f->name];
	}

	//echo "<pre>";print_r($data);echo "</pre>";die();

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
	//$start=$start+1;

	//	print_r($online_applications);
	$tpl->assign('dept_id_sel', $dept_id);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('firstNumber', $start);
	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('status', $status);
	$tpl->assign('dept_id', $dept_id);

	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('reference_no', !empty($_POST['reference_no'])?$_POST['reference_no']:'');
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('data', $data);
	
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('mc_yn', $_SESSION['mc_yn']);
	
	$tpl->display('corp_comp_det1.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
