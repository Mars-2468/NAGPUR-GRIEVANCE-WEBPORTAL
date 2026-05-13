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


	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');


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





	/*if ($_REQUEST['status'] == 0) {
		$sql = "select g.*,gt.emp_id, gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.emp_id='" . $_REQUEST['emp_id'] . "' and cat3_id !='0'";

		/*$sql = "SELECT g.*, gt.emp_id, gt.ts AS last_updated_date, gt.disposed_date
			FROM grievances g
			JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id
			WHERE g.ulbid = '" . $_SESSION['ulbid'] . "'
			AND g.app_type_id = '" . $_REQUEST['app_type_id'] . "'
			AND gt.disposal_status != '5'
			AND gt.emp_id = '" . $_REQUEST['emp_id'] . "'
			AND cat3_id != '0'";*/
	//echo $sql;

	// Query to get the total count

	//$countSql = "SELECT COUNT(*) AS total_count
	//FROM grievances g
	//JOIN grievances_transactions gt ON g.grievance_id = gt.grievance_id
	//WHERE g.ulbid = '" . $_SESSION['ulbid'] . "'
	//AND g.app_type_id = '" . $_REQUEST['app_type_id'] . "'
	//AND gt.disposal_status != '5'
	//AND gt.emp_id = '" . $_REQUEST['emp_id'] . "'
	//AND cat3_id != '0'"; 



	/*$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and cat3_id !='0'";

		if ($_REQUEST['app_type_id'] == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		      g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and cat3_id !='0'";
		}

		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

			$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
			$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		}
	}*/
	if ($_REQUEST['status'] == 0) {
		$sql = "select g.*,gt.emp_id, gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.emp_id='" . $_REQUEST['emp_id'] . "' and cat3_id !='0'";

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and cat3_id !='0'";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and cat3_id !='0'";

		if ($_REQUEST['app_type_id'] == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		    g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and cat3_id !='0'";
		}

		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

		// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }


		//$sql ;
		//$sqlExcel ; 

	} else if ($_REQUEST['status'] == 2) {
		/*$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status NOT IN(5,11,13) and gt.emp_id='" . $_REQUEST['emp_id'] . "' and
		grievance_status_id IN('2','11','13')  ";

		$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and  g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status NOT IN(5,11,13)  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and
		g.grievance_status_id IN('2','11','13') ";*/

		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status NOT IN(5,11,13) and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('2')  ";

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and  g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status NOT IN(5,11,13)  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('2') ";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status NOT IN(5,11,13)  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('2') and cat3_id !='0'";

		if ($_REQUEST['app_type_id'] == 2) {
			/*$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and
			g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status NOT IN(5,11,13)  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and
			g.grievance_status_id IN('2','11','13') ";*/

			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and
			g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status NOT IN(5,11,13)  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and
			g.grievance_status_id IN('2') ";
		}

		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

		// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }
	} else if ($_REQUEST['status'] == 8) {
		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('2') and sla_status='2'";

		/*$sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and
		g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."' and gt.emp_id='".$_REQUEST['emp_id']."' and g.grievance_status_id IN('2') and sla_status='2'";*/

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and  g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('2') and sla_status='2'";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('2') and sla_status='2' and cat3_id !='0'";

		if ($_REQUEST['app_type_id'] == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "' and
		    g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and
		    g.grievance_status_id IN('2') and sla_status='2'";
		}

		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

		// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }


		//$sql ;
		//$sqlExcel ; 

	} else if ($_REQUEST['status'] == 3) {
		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.emp_id='" . $_REQUEST['emp_id'] . "'  and g.grievance_status_id IN('3','8','9') and sla_status='1'";

		/*$sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, 
		grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and 
		g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and 
		g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."' and 
		gt.emp_id='".$_REQUEST['emp_id']."'  and g.grievance_status_id IN('3','8','9') and g.sla_status = '1'";*/

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.emp_id='" . $_REQUEST['emp_id'] . "'  and g.grievance_status_id IN('3','8','9') and g.sla_status = '1'";*/
		
		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('3','8','9') and sla_status='1' and cat3_id !='0'";

		if ($_REQUEST['app_type_id'] == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "'  and 
		    g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'  and g.grievance_status_id IN('3','8','9') and g.sla_status = '1'";
		}


		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

		// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }
	} else if ($_REQUEST['status'] == 9) {
		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'  and grievance_status_id IN('3','8','9') and sla_status='2'";

		/* $sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g,
		grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and 
		g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and
		g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."' and 
		gt.emp_id='".$_REQUEST['emp_id']."'  and g.grievance_status_id IN('3','8','9') and sla_status='2'";*/

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and 
		gt.emp_id='" . $_REQUEST['emp_id'] . "'  and g.grievance_status_id IN('3','8','9') and sla_status='2'";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('3','8','9') and sla_status='2' and cat3_id !='0'";

		if ($_REQUEST['app_type_id'] == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "'  and
		    g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and 
		    gt.emp_id='" . $_REQUEST['emp_id'] . "'  and g.grievance_status_id IN('3','8','9') and sla_status='2'";
		}

		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
			// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }
	} else if ($_REQUEST['status'] == 4) {
		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'  and g.grievance_status_id IN('4')";

		// $sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."' and gt.emp_id='".$_REQUEST['emp_id']."'  and g.grievance_status_id IN('4')";

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'  and g.grievance_status_id IN('4')";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('4') and cat3_id !='0'";

		if ($_REQUEST['app_type_id'] == 2) {
			$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,cs_desc as Description,date_regd as ComplaintDate from grievances g, grievances_transactions gt,standard_services s where g.grievance_id=gt.grievance_id and g.mcat3_id=s.cs_id and g.ulbid='" . $_SESSION['ulbid'] . "'  and 
			g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.emp_id='" . $_REQUEST['emp_id'] . "'  and g.grievance_status_id IN('4')";
		}

		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

			$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
			$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		}
	} else if ($_REQUEST['status'] == 5) {
		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.dept_id='" . $_REQUEST['dept_id'] . "' and gt.emp_id='" . $_REQUEST['emp_id'] . "'";

		// $sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and g.grievance_status_id IN('13') and g.ulbid='".$_SESSION['ulbid']."' and gt.dept_id='".$_REQUEST['dept_id']."' and gt.emp_id='".$_REQUEST['emp_id']."'";

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and g.grievance_status_id IN('13') and g.ulbid='" . $_SESSION['ulbid'] . "'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('13') and cat3_id !='0'";

		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

		// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }
	//02-04-24 } else if ($_REQUEST['status'] == 6) {
	} else if ($_REQUEST['status'] == 105) {

		if ($_SESSION['user_type'] == 'E') {
			$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('11')  and ulbid='" . $_SESSION['ulbid'] . "'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'";
			//$sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.disposal_status IN('11')  and ulbid='".$_SESSION['ulbid']."' and gt.dept_id='".$_REQUEST['dept_id']."' and gt.emp_id='".$_REQUEST['emp_id']."'";

			/*$sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id 
			and g.grievance_status_id=s.grievance_status_id and gt.disposal_status IN('11')  and ulbid='" . $_SESSION['ulbid'] . "'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'";*/

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('11') and cat3_id !='0'";
		} else {
			$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('11') and g.grievance_status_id IN(11) and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_REQUEST['emp_id'] . "'";

			/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
        	grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id=s.grievance_status_id and gt.disposal_status IN('11') and g.grievance_status_id IN(11) and ulbid='" . $_SESSION['ulbid'] . "' ";*/

			$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
			and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status IN('11') and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('11') and cat3_id !='0'";
		}




		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

		// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }
	} else if ($_REQUEST['status'] == 7) {
		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and gt.disposal_status NOT IN('5','9') and ulbid='" . $_SESSION['ulbid'] . "'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'";
		//$sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.disposal_status IN('12')  and ulbid='".$_SESSION['ulbid']."' and gt.dept_id='".$_REQUEST['dept_id']."' and gt.emp_id='".$_REQUEST['emp_id']."'";

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
        grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.grievance_status_id IN ('12') and gt.disposal_status NOT IN('5','9') and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_REQUEST['emp_id'] . "'";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status NOT IN('5','9') and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('12') and cat3_id !='0'";

		/*11-03-24 if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
			$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		}*/
	} else if ($_REQUEST['status'] == 10) {
		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('6')  and ulbid='" . $_SESSION['ulbid'] . "'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'";
		//$sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.disposal_status IN('12')  and ulbid='".$_SESSION['ulbid']."' and gt.dept_id='".$_REQUEST['dept_id']."' and gt.emp_id='".$_REQUEST['emp_id']."'";

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
        grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.disposal_status IN('6')  and ulbid='" . $_SESSION['ulbid'] . "'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('6') and cat3_id !='0'";

		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

		// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }
	} else if ($_REQUEST['status'] == 100) {
		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and is_reopened_yn='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' ";

		// $sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and g.grievance_status_id IN('13') and g.ulbid='".$_SESSION['ulbid']."' and gt.dept_id='".$_REQUEST['dept_id']."' and gt.emp_id='".$_REQUEST['emp_id']."'";

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
        grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and is_reopened_yn='1' and g.grievance_status_id IN('13') and g.ulbid='" . $_SESSION['ulbid'] . "' ";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' is_reopened_yn='1' and g.grievance_status_id IN('13') and cat3_id !='0'";

		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

		// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }
	} else if ($_REQUEST['status'] == 200) {
		$sql = "select g.*,gt.emp_id,gt.ts as last_updated_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and is_reopened_yn='1' and gt.disposal_status IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_REQUEST['emp_id'] . "'";

		// $sqlExcel ="select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,date_regd as ComplaintDate,grievance_status_desc as Status,".$fieldName." as Details from grievances g, grievances_transactions gt,grievance_status_mst s,".$table." c where g.grievance_id=gt.grievance_id  and g.grievance_status_id=s.grievance_status_id and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and g.grievance_status_id IN('13') and g.ulbid='".$_SESSION['ulbid']."' and gt.dept_id='".$_REQUEST['dept_id']."' and gt.emp_id='".$_REQUEST['emp_id']."'";

		/*02-04-24 $sqlExcel = "select g.grievance_id as ReferenceNo,person_name as ApplicantName, mobile as Mobile,address as Address,comp_subject as Description,comp_desc,date_regd as ComplaintDate from grievances g, 
        grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and is_reopened_yn='1' and g.grievance_status_id IN('13') and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_REQUEST['emp_id'] . "'";*/

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, grievances_transactions gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and is_reopened_yn='1' and gt.disposal_status IN('13') and gt.emp_id='" . $_REQUEST['emp_id'] . "' and cat3_id !='0'";

		// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {

		// 	$sql .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// 	$sqlExcel .= "and date(date_regd) between '" . $_REQUEST['f_date'] . "' and '" . $_REQUEST['t_date'] . "' ";
		// }
	}

	/*if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
	{
		$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
	}*/
	if (isset($_POST['search'])) {
		if ($_POST['reference_no'] != '') {
			$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

			$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
			$sqlExcel .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= ' group by g.grievance_id';
	$sqlExcel .= ' group by g.grievance_id';

	//echo $sql;
	//echo $sqlExcel;


	$_SESSION['myquery'] = $sqlExcel;
	//echo $sql;
	//echo "<br>";
	//echo $sqlExcel;



	$adjacents = 5;
	if ($_REQUEST['status'] == 0) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and cat3_id !='0'";
	} else if ($_REQUEST['status'] == 2) {
		$query = "select count(DISTINCT g.grievance_id) as num,g.sla_status from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
		and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.emp_id='" . $_REQUEST['emp_id'] . "' and grievance_status_id IN('2') and sla_status='1'";
	} else if ($_REQUEST['status'] == 3) {

		$query = "select count(g.grievance_id) as num,g.sla_status,g.grievance_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
        g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('3','9','6','10') and sla_status='1'";
		// $query ="select count(g.grievance_id) as num,g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='055' and g.app_type_id='2' and gt.disposal_status!='5' and gt.dept_id='98' and gt.emp_id='2110' and grievance_status_id IN('3','9','6','10')";	
	} else if ($_REQUEST['status'] == 9) {

		$query = "select count(DISTINCT g.grievance_id) as num,g.sla_status,g.grievance_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
        g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and grievance_status_id IN('3','9','6','10') and sla_status='2'";
		// $query ="select count(g.grievance_id) as num,g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='055' and g.app_type_id='2' and gt.disposal_status!='5' and gt.dept_id='98' and gt.emp_id='2110' and grievance_status_id IN('3','9','6','10')";	
	} else if ($_REQUEST['status'] == 4) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'  and grievance_status_id IN('4')";
	} else if ($_REQUEST['status'] == 5) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
		and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "'  and  gt.emp_id='" . $_REQUEST['emp_id'] . "'";
	} else if ($_REQUEST['status'] == 100) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
		and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "'";
	} else if ($_REQUEST['status'] == 200) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  
		and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('9','12') and is_reopened_yn='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and emp_id='" . $_REQUEST['emp_id'] . "'";
	//02-04-24 } else if ($_REQUEST['status'] == 6) {
	} else if ($_REQUEST['status'] == 105) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('11')  and ulbid='" . $_SESSION['ulbid'] . "'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'";
	} else if ($_REQUEST['status'] == 7) {
		/*$query = "select count(DISTINCT g.grievance_id) as num from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('12')  
		and ulbid='" . $_SESSION['ulbid'] . "'  and gt.emp_id='" . $_REQUEST['emp_id'] . "'";*/
		$query = "select COUNT(DISTINCT g.grievance_id) as num,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1'  and g.grievance_status_id IN ('12') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status NOT IN('5','9') and gt.emp_id='" . $_REQUEST['emp_id'] . "' ";
	} else if ($_REQUEST['status'] == 8) {
		$query = "select count(DISTINCT g.grievance_id) as num,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5'  and gt.emp_id='" . $_REQUEST['emp_id'] . "' and g.grievance_status_id IN('2') and sla_status='2'";
	}

	/*07-03-24 if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
        {
            $query.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
        }*/

	if (isset($_POST['search'])) {
		if ($_POST['reference_no'] != '') {
			$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$query .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
		$query .= ' group by g.grievance_id';
	}
	//echo $query;

	$result = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($result)) {
		$total_pages = $row['num'];
		//echo $row['num'];
	}


	/*02-04-24 $targetpage = "all_empwise_comp_det.php"; 	//your file name  (the name of this file)
	//$limit = 20; 								//how many items to show per page
	$limit = 150; 								//how many items to show per page
	$page = $_GET['page'];
	if ($page)
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;
	$sql .= " LIMIT $start, $limit"; /////////////////////////////////////////////////////////////////////////////////////  dont forgot remove here
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages / $limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;

	$pagination = "";
	if ($lastpage > 1) {

		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1)

			$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$prev\"><< previous</a>";

		else
			$pagination .= "<span class=\"disabled\"><< previous</span>";

		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{
			for ($counter = 1; $counter <= $lastpage; $counter++) {
				if ($counter == $page)
					$pagination .= "<span class=\"current\">$counter</span>";
				else
					$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$counter\">$counter</a>";
			}
		} elseif ($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if ($page < 1 + ($adjacents * 2)) {
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$counter\">$counter</a>";
				}
				$pagination .= "...";
				$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$lpm1\">$lpm1</a>";
				$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$lastpage\">$lastpage</a>";
			}
			//in middle; hide some front and some back
			elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
				$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=1\">1</a>";
				$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=2\">2</a>";
				$pagination .= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$counter\">$counter</a>";
				}
				$pagination .= "...";
				$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$lpm1\">$lpm1</a>";
				$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$lastpage\">$lastpage</a>";
			}
			//close to end; only hide early pages
			else {
				$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=1\">1</a>";
				$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=2\">2</a>";
				$pagination .= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
					if ($counter == $page)
						//$pagination.= "<span class=\"current\">$counter</span>";
						$pagination .= "<span class=\"disabled\">$lastpage</span>";
					else
						$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$counter\">$counter</a>";
				}
			}
		}

		//next button
		if ($page < $counter - 1)
			$pagination .= "<a href=\"$targetpage?app_type_id=$app_type_id&emp_id=$emp_id&status=$status&dept_id=$dept_id&ulbid-$ulbid&page=$next\">next >></a>";
		else
			$pagination .= "<span class=\"disabled\">next >></span>";
		$pagination .= "</div>\n";
	}*/







	//echo $sql;



	$rs = mysqli_query($conn, $sql);
	$field_info = mysqli_fetch_fields($rs);
	while ($row = mysqli_fetch_assoc($rs)) {
		foreach ($field_info as $fi => $f)
			$data[$row['grievance_id']][$f->name] = $row[$f->name];
	}

	//pagination end


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
	mysqli_close($conn);

	//	print_r($online_applications);
	$tpl->assign('dept_id_sel', $_REQUEST['dept_id']);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('firstNumber', $start);
	$tpl->assign('user_type', $_SESSION['user_type']);

	//$tpl->assign('fdate', $_POST['f_date']);
	//$tpl->assign('tdate', $_POST['t_date']);

	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('status', $status);
	$tpl->assign('dept_id', $dept_id);

	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('reference_no', $_POST['reference_no']);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
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
	$tpl->display('all_empwise_comp_det.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
