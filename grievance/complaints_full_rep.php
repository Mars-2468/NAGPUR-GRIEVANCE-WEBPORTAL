<?php
require "config.php";
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

$app_type_id = $_REQUEST['app_type_id'];
$emp_id = $_REQUEST['emp_id'];
$status = $_REQUEST['status'];
$dept_id = $_REQUEST['dept_id'];

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

	$cs_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
	$status1 = htmlspecialchars(strip_tags($_REQUEST['status']));
	$ulbid1 = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$user_type1 = htmlspecialchars(strip_tags($_SESSION['user_type']));
	$sla1 = htmlspecialchars(strip_tags($_REQUEST['sla']));

	$street_id = $_REQUEST['street_id'];
	//$ulbid=$_SESSION['ulbid'];
	$app_type_id = $_REQUEST['app_type_id'];
	$emp_id = $_REQUEST['emp_id'];
	$status = $_REQUEST['status'];
	$cs_id = $_REQUEST['cs_id'];


	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
	}

	$sql = "select ward_id, ward_desc from ward_mst where ulbid=?";


	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
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


	// if($_REQUEST['cs_id'] && $_REQUEST['status']=='0')
	// {
	// 	$sql2="SELECT COUNT(g.grievance_id) as num  FROM grievances g,cs_mst c 
	// 	where g.cat3_id=c.cs_id and ulbid=? and app_type_id=? and cat3_id=? ";

	// 	$ulbid = $ulbid1;

	// 	$app_type_id = 1;
	// 	$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
	// 	$query = $conn->prepare($sql2);
	// 	$query->bind_param("sii",$ulbid,$app_type_id,$cat3_id);
	// 	$query->execute();
	// 	$rs = $query->get_result();





	//     $row = $rs->fetch_assoc();

	//     $total_pages = $row['num'];

	//     $sql="SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc FROM grievances g,cs_mst c 
	//     where g.cat3_id=c.cs_id and ulbid=? and app_type_id=? and cat3_id=? ";
	// 	$ulbid = $ulbid1;
	// 	$app_type_id = 1;
	// 	$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
	// 	$query = $conn->prepare($sql);
	// 	$query->bind_param("sii",$ulbid,$app_type_id,$cat3_id);
	// }

	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '0') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			// $sql="SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc FROM grievances g,cs_mst c 
			// where g.cat3_id=c.cs_id and ulbid=? and app_type_id=? and cat3_id=? ";
			// $ulbid = $ulbid1;
			// $app_type_id = 1;
			// $cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			// $query = $conn->prepare($sql);
			// $query->bind_param("sii",$ulbid,$app_type_id,$cat3_id);

			/*echo $sql="SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile FROM grievances g,cs_mst c,grievances_transactions gt,emp_mst e 
			where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid=? and app_type_id=? and cat3_id=? ";
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$query = $conn->prepare($sql);
			$query->bind_param("sii",$ulbid,$app_type_id,$cat3_id);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile FROM grievances g,cs_mst c,grievances_transactions gt,
	    	emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile FROM grievances g,cs_mst c,grievances_transactions gt,
	        emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='" . $_REQUEST['app_type_id'] . "' and c.cs_id='" . $_REQUEST['cs_id'] . "' ";
		}
		$sqlExcel = "SELECT g.person_name as ApplicantName,g.mobile as ApplicantMobile,g.hno as HNo,g.address as Address,g.ward_id as Zone,g.street_id as Ward,g.comp_desc as ComplaintDetails,e.emp_name as EmployeeName,e.emp_mobile as EmployeeMobile,date_regd as ReceivedDate FROM grievances g,cs_mst c,grievances_transactions gt,emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' ";
	}

	/*23-05-24 if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '1') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			// $sql="SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile FROM grievances g,cs_mst c,grievances_transactions gt,
			// emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid=? and app_type_id=? and cat3_id=? ";
			// $ulbid = $ulbid1;
			// $app_type_id = 1;
			// $cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			// $query = $conn->prepare($sql);
			// $query->bind_param("sii",$ulbid,$app_type_id,$cat3_id);

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile FROM grievances g,cs_mst c,grievances_transactions gt,
	        emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile FROM grievances g,cs_mst c,grievances_transactions gt,
	        emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='" . $_REQUEST['app_type_id'] . "' and c.cs_id='" . $_REQUEST['cs_id'] . "' ";
		}
		$sqlExcel = "SELECT g.person_name as ApplicantName,g.mobile as ApplicantMobile,g.hno as HNo,g.address as Address,g.ward_id as Zone,g.street_id as Ward,g.comp_desc as ComplaintDetails,e.emp_name as EmployeeName,e.emp_mobile as EmployeeMobile,date_regd as ReceivedDate FROM grievances g,cs_mst c,grievances_transactions gt,emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' ";
	}*/

	/*** Pending within SLA ***/

	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '2') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$sql="SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,
			ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and 
			g.ulbid=?  and app_type_id=? and cat3_id=? and gt.disposal_status !=? and g.sla_status=1 ";

			$grievance_status_id1 = 3;
			$grievance_status_id2 = 6;
			$grievance_status_id3 = 8;
			$grievance_status_id4 = 10;
			$grievance_status_id5 = 4;
			$grievance_status_id6 = 11;
			$grievance_status_id7 = 9;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$disposal_status = 5;
			$query = $conn->prepare($sql);
			$query->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$disposal_status);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=1 ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and (g.grievance_status_id = 2 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=1 ";
		}
	}

	/*** Pending beyond SLA ***/


	//23-05-24 if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '3') {
		if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '8') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$sql="SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,
			ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and 
			g.ulbid=?  and app_type_id=? and cat3_id=? and gt.disposal_status !=? and g.sla_status=2 ";

			$grievance_status_id1 = 3;
			$grievance_status_id2 = 6;
			$grievance_status_id3 = 8;
			$grievance_status_id4 = 10;
			$grievance_status_id5 = 4;
			$grievance_status_id6 = 11;
			$grievance_status_id7 = 9;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$disposal_status = 5;
			$query = $conn->prepare($sql);
			$query->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$disposal_status);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and (g.grievance_status_id = 2 ) and 
			g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=2 ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,
			ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=2 ";
		}
	}

	/**** Resolved within SLA ****/


	//23-05-24 if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '4') {
		if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '3') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$sql="SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9  ) and 
			g.ulbid = ? and app_type_id=? and cat3_id=? and gt.disposal_status !=? and sla_status=1 ";

			$grievance_status_id1 = 3;
			$grievance_status_id2 = 8;
			$grievance_status_id3 = 10;
			$grievance_status_id4 = 4;
			$grievance_status_id5 = 9;
			$grievance_status_id6 = 12;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$disposal_status = 5;
			$query = $conn->prepare($sql);
			$query->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$disposal_status);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9 ) and 
			g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=1 ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9  ) and 
			g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=1 ";
		}
	}

	/** Resolved beyond SLA ****/

	//23-05-24 if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '5') {
		if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '9') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$sql="SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and  
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9 ) and 
			g.ulbid = ? and app_type_id=? and cat3_id=? and gt.disposal_status !=? and g.sla_status=2 ";

			$grievance_status_id1 = 3;
			$grievance_status_id2 = 8;
			$grievance_status_id3 = 10;
			$grievance_status_id4 = 4;
			$grievance_status_id5 = 9;
			$grievance_status_id6 = 12;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$disposal_status = 5;
			$query = $conn->prepare($sql);
			$query->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$disposal_status);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and  
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9 ) and 
			g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=2 ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and  
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=2 ";
		}
	}

	/*** REOPENED COMPLAINTS ***/

	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '5') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$sql="select g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = ? )  and  
			gt.disposal_status !=? and g.ulbid=? and app_type_id = ? and gt.emp_id= e.emp_id and cat3_id=? ";


			$grievance_status_id = 6;
			$disposal_status = 5;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$query = $conn->prepare($sql);
			$query->bind_param("iisii",$grievance_status_id,$disposal_status,$ulbid,$app_type_id,$cat3_id);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id  = 13 ) and gt.disposal_status!='5' and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id  = 13 ) and gt.disposal_status!='5' and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		}
		$sqlExcel = "SELECT g.person_name as ApplicantName,g.mobile as ApplicantMobile,g.hno as HNo,g.address as Address,g.ward_id as Zone,g.street_id as Ward,g.comp_desc as ComplaintDetails,e.emp_name as EmployeeName,e.emp_mobile as EmployeeMobile,date_regd as ReceivedDate
		from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
		(g.grievance_status_id  = 13 ) and gt.disposal_status!='5' and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
	}

	/*** REOPENED UnderProgress COMPLAINTS ***/

	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '105') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$sql="select g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = ? )  and  
			gt.disposal_status !=? and g.ulbid=? and app_type_id = ? and gt.emp_id= e.emp_id and cat3_id=? ";


			$grievance_status_id = 6;
			$disposal_status = 5;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$query = $conn->prepare($sql);
			$query->bind_param("iisii",$grievance_status_id,$disposal_status,$ulbid,$app_type_id,$cat3_id);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id  = 11 ) and gt.disposal_status!='5' and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id  = 11 ) and gt.disposal_status!='5' and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		}
		$sqlExcel = "SELECT g.person_name as ApplicantName,g.mobile as ApplicantMobile,g.hno as HNo,g.address as Address,g.ward_id as Zone,g.street_id as Ward,g.comp_desc as ComplaintDetails,e.emp_name as EmployeeName,e.emp_mobile as EmployeeMobile,date_regd as ReceivedDate
		from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
		(g.grievance_status_id  = 11 ) and gt.disposal_status!='5' and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
	}

	/*** REOPENED UnderProgress COMPLAINTS ***/

	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '7') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$sql="select g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = ? )  and  
			gt.disposal_status !=? and g.ulbid=? and app_type_id = ? and gt.emp_id= e.emp_id and cat3_id=? ";


			$grievance_status_id = 6;
			$disposal_status = 5;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$query = $conn->prepare($sql);
			$query->bind_param("iisii",$grievance_status_id,$disposal_status,$ulbid,$app_type_id,$cat3_id);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id  = 12 ) and gt.disposal_status NOT IN('5','9','13') and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id  = 12 ) and gt.disposal_status NOT IN('5','9','13') and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		}
		$sqlExcel = "SELECT g.person_name as ApplicantName,g.mobile as ApplicantMobile,g.hno as HNo,g.address as Address,g.ward_id as Zone,g.street_id as Ward,g.comp_desc as ComplaintDetails,e.emp_name as EmployeeName,e.emp_mobile as EmployeeMobile,date_regd as ReceivedDate
		from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
		(g.grievance_status_id  = 12 ) and gt.disposal_status NOT IN('5','9','13') and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
	}

	/*** REOPENED UnderProgress COMPLAINTS ***/

	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '108') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$sql="select g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = ? )  and  
			gt.disposal_status !=? and g.ulbid=? and app_type_id = ? and gt.emp_id= e.emp_id and cat3_id=? ";


			$grievance_status_id = 6;
			$disposal_status = 5;
			$ulbid = $ulbid1;
			$app_type_id = 1;g.grievance_status_id IN ('3','6','8','9','12','13') and gt.disposal_status !=5
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$query = $conn->prepare($sql);
			$query->bind_param("iisii",$grievance_status_id,$disposal_status,$ulbid,$app_type_id,$cat3_id);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id = 3 or g.grievance_status_id = 6 or g.grievance_status_id = 8 or g.grievance_status_id = 9 or g.grievance_status_id = 12 or g.grievance_status_id = 13 ) and gt.disposal_status !=5 and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id = 3 or g.grievance_status_id = 6 or g.grievance_status_id = 8 or g.grievance_status_id = 9 or g.grievance_status_id = 12 or g.grievance_status_id = 13 ) and gt.disposal_status !=5 and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		}
		$sqlExcel = "SELECT g.person_name as ApplicantName,g.mobile as ApplicantMobile,g.hno as HNo,g.address as Address,g.ward_id as Zone,g.street_id as Ward,g.comp_desc as ComplaintDetails,e.emp_name as EmployeeName,e.emp_mobile as EmployeeMobile,date_regd as ReceivedDate
		from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
		(g.grievance_status_id = 3 or g.grievance_status_id = 6 or g.grievance_status_id = 8 or g.grievance_status_id = 9 or g.grievance_status_id = 12 or g.grievance_status_id = 13 ) and gt.disposal_status !=5 and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
	}

	/*** Financial Implication ***/

	//23-05-24 if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '6') {
	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '10') {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$sql="select g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = ? )  and  
			gt.disposal_status !=? and g.ulbid=? and app_type_id = ? and gt.emp_id= e.emp_id and cat3_id=? ";


			$grievance_status_id = 6;
			$disposal_status = 5;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$query = $conn->prepare($sql);
			$query->bind_param("iisii",$grievance_status_id,$disposal_status,$ulbid,$app_type_id,$cat3_id);*/

			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = 6 )  and  
			gt.disposal_status !='5' and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		} else {
			$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = 6 ) and gt.disposal_status !='5' and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
		}
		$sqlExcel = "SELECT g.person_name as ApplicantName,g.mobile as ApplicantMobile,g.hno as HNo,g.address as Address,g.ward_id as Zone,g.street_id as Ward,g.comp_desc as ComplaintDetails,e.emp_name as EmployeeName,e.emp_mobile as EmployeeMobile,date_regd as ReceivedDate
		from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
		g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
		(g.grievance_status_id  = 6 ) and gt.disposal_status !='5' and g.ulbid='" . $ulbid1 . "' and app_type_id = '1' and gt.emp_id= e.emp_id and cat3_id='" . $_REQUEST['cs_id'] . "' ";
	}
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		$tpl->assign('fdate', $fdate);
		$tpl->assign('tdate', $tdate);
	}

	//echo $sql;

	// $query->execute();
	// $rs=$query->get_result();


	while ($row = $rs->fetch_assoc()) {
		$data[$row['grievance_id']]['grievance_id'] = $row['grievance_id'];
		$data[$row['grievance_id']]['person_name'] = $row['person_name'];
		$data[$row['grievance_id']]['hno'] = $row['hno'];
		$data[$row['grievance_id']]['address'] = $row['address'];
		$data[$row['grievance_id']]['ward_id'] = $row['ward_id'];
		$data[$row['grievance_id']]['street_id'] = $row['street_id'];
		$data[$row['grievance_id']]['mobile'] = $row['mobile'];
		$data[$row['grievance_id']]['comp_desc'] = $row['comp_desc'];
		$data[$row['grievance_id']]['emp_name'] = $row['emp_name'];
		$data[$row['grievance_id']]['emp_mobile'] = $row['emp_mobile'];
	}
	//echo $sql;

	//echo $sqlExcel;

	$_SESSION['myquery'] = $sqlExcel;
	//echo $sql;
	//echo "<br>";
	//echo $sqlExcel;

	$adjacents = 5;
	if ($_REQUEST['status'] == 0) {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			$query = "SELECT COUNT(g.grievance_id) as num  FROM grievances g,cs_mst c 
			where g.cat3_id=c.cs_id and ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' ";

			/*$query="SELECT COUNT(g.grievance_id) as num  FROM grievances g,cs_mst c 
			where g.cat3_id=c.cs_id and ulbid=? and app_type_id=? and cat3_id=? ";

			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$query = $conn->prepare($query);
			$query->bind_param("sii",$ulbid,$app_type_id,$cat3_id);*/
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,gt.emp_id FROM grievances g,cs_mst c,grievances_transactions gt,
			emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id='" . $_REQUEST['cs_id'] . "'";
		}
	} else if ($_REQUEST['status'] == 1) {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,gt.emp_id FROM grievances g,cs_mst c,grievances_transactions gt,
			emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "'";
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,gt.emp_id FROM grievances g,cs_mst c,grievances_transactions gt,
			emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id='" . $_REQUEST['cs_id'] . "'";
		}
	} else if ($_REQUEST['status'] == 2) {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$query="SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9  ) and 
			g.ulbid = ? and app_type_id=? and cat3_id=? and gt.disposal_status !=? and sla_status=1 ";

			$grievance_status_id1 = 3;
			$grievance_status_id2 = 8;
			$grievance_status_id3 = 10;
			$grievance_status_id4 = 4;
			$grievance_status_id5 = 9;
			$grievance_status_id6 = 12;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$disposal_status = 5;
			$query = $conn->prepare($sql);
			$query->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$disposal_status);*/

			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9  ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=1 ";
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9  ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=1 ";
		}
	} else if ($_REQUEST['status'] == 3) {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$query="SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and  
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9 ) and 
			g.ulbid = ? and app_type_id=? and cat3_id=? and gt.disposal_status !=? and g.sla_status=2 ";

			$grievance_status_id1 = 3;
			$grievance_status_id2 = 8;
			$grievance_status_id3 = 10;
			$grievance_status_id4 = 4;
			$grievance_status_id5 = 9;
			$grievance_status_id6 = 12;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$disposal_status = 5;
			$query = $conn->prepare($sql);
			$query->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$disposal_status);*/

			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and  
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=2 ";
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,
			rca,ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm, emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and g.cat3_id=ccm.cs_id and  
			(g.grievance_status_id = 3 or g.grievance_status_id = 8 or g.grievance_status_id = 9 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=2 ";
		}
	} else if ($_REQUEST['status'] == 4) {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$query="SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,
			ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and 
			g.ulbid=?  and app_type_id=? and cat3_id=? and gt.disposal_status !=? and g.sla_status=1 ";

			$grievance_status_id1 = 3;
			$grievance_status_id2 = 6;
			$grievance_status_id3 = 8;
			$grievance_status_id4 = 10;
			$grievance_status_id5 = 4;
			$grievance_status_id6 = 11;
			$grievance_status_id7 = 9;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$disposal_status = 5;
			$query = $conn->prepare($sql);
			$query->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$disposal_status);*/

			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,
			ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=1 ";
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,
			ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=1 ";
		}
	} else if ($_REQUEST['status'] == 5) {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$query="SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,
			ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and 
			g.ulbid=?  and app_type_id=? and cat3_id=? and gt.disposal_status !=? and g.sla_status=2 ";

			$grievance_status_id1 = 3;
			$grievance_status_id2 = 6;
			$grievance_status_id3 = 8;
			$grievance_status_id4 = 10;
			$grievance_status_id5 = 4;
			$grievance_status_id6 = 11;
			$grievance_status_id7 = 9;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$disposal_status = 5;
			$query = $conn->prepare($sql);
			$query->bind_param("siii", $ulbid, $app_type_id, $cat3_id, $disposal_status);*/

			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,
			ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=2 ";
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
			c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,rca,
			ca,disposal_remarks,gt.updated_by,gt.emp_id from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and gt.emp_id= e.emp_id and 
			(g.grievance_status_id = 2 ) and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.disposal_status !='5' and sla_status=2 ";
		}
	} else if ($_REQUEST['status'] == 6) {
		if ($_REQUEST['f_date'] == '' && $_REQUEST['t_date'] == '') {
			/*$query="SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = ? )  and  
			gt.disposal_status !=? and g.ulbid=? and app_type_id = ? and gt.emp_id= e.emp_id and cat3_id=? ";

			$grievance_status_id = 6;
			$disposal_status = 5;
			$ulbid = $ulbid1;
			$app_type_id = 1;
			$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$query = $conn->prepare($sql);
			$query->bind_param("iisii", $grievance_status_id, $disposal_status, $ulbid, $app_type_id, $cat3_id);*/

			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = 6 )  and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.emp_id= e.emp_id and gt.disposal_status !='5' ";
		} else {
			$query = "SELECT count(DISTINCT g.grievance_id) as num,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
			DATEDIFF(disposed_date,date_regd) AS target,gt.ts,ccm.cutt_off_time as target_days,
			rca,ca,disposal_remarks,gt.emp_id from grievances g , grievances_transactions gt,comp_cutofdays_map ccm ,emp_mst e where 
			g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and 
			(g.grievance_status_id  = 6 )  and g.ulbid = '" . $ulbid1 . "' and app_type_id='1' and cat3_id='" . $_REQUEST['cs_id'] . "' and gt.emp_id= e.emp_id and gt.disposal_status !='5' ";
		}
	}

	if ($fdate != '' && $tdate != '') {
		$query .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		$tpl->assign('fdate', $fdate);
		$tpl->assign('tdate', $tdate);
	}

	$result = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($result)) {
		$total_pages = $row['num'];
		//echo $row['num'];
	}

	$_SESSION['myquery'] = $sqlExcel;
	//echo $sql;

	//echo $query;



	$rs = mysqli_query($conn, $sql);
	$field_info = mysqli_fetch_fields($rs);
	while ($row = mysqli_fetch_assoc($rs)) {
		foreach ($field_info as $fi => $f)
			$data[$row['grievance_id']][$f->name] = $row[$f->name];
	}

	//pagination end



	////////////////////pagination end



	$conn->close();
	$tpl->assign('street_list', $street_list);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('users_list', $users_list);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('page', $page);

	//$tpl->assign('app_type_id',$app_type_id);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('status', $status);
	$tpl->assign('cs_id', $cs_id);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('ulbid', $_SESSION['ulbid']);
	//$tpl->assign('app_type_id',$_REQUEST['aptid']);
	$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('cat_id', $cat_id);
	$tpl->assign('cat_list', $cat_list);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('grievance_status_list', $grievance_status_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('f_date', $fdate);
	$tpl->assign('t_date', $tdate);
	$tpl->display('complaints_full_rep.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
