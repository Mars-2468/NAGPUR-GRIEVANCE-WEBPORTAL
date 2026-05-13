<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {


	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	/// In case of service 

	$cs_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
	$status1 = htmlspecialchars(strip_tags($_REQUEST['status']));
	$ulbid1 = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$user_type1 = htmlspecialchars(strip_tags($_SESSION['user_type']));
	$sla1 = htmlspecialchars(strip_tags($_REQUEST['sla']));

	$street_id = $_REQUEST['street_id'];





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


	if ($_REQUEST['cs_id']) {
		$sql2 = "SELECT COUNT(g.grievance_id) as num  FROM grievances g,cs_mst c 
        	         where g.cat3_id=c.cs_id and ulbid=? and app_type_id=? and cat3_id=? ";



		$ulbid = $ulbid1;

		$app_type_id = 1;
		$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
		$query = $conn->prepare($sql2);
		$query->bind_param("sii", $ulbid, $app_type_id, $cat3_id);
		$query->execute();
		$rs = $query->get_result();





		$row = $rs->fetch_assoc();

		$total_pages = $row['num'];

		$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc FROM grievances g,cs_mst c 
	                        where g.cat3_id=c.cs_id and ulbid=? and app_type_id=? and cat3_id=? ";




		$ulbid = $ulbid1;
		$app_type_id = 1;
		$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
		$query = $conn->prepare($sql);
		$query->bind_param("sii", $ulbid, $app_type_id, $cat3_id);
	}



	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '1') {



		$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile FROM grievances g,cs_mst c,grievances_transactions gt,
	                      emp_mst e where g.cat3_id=c.cs_id and g.grievance_id=gt.grievance_id and gt.emp_id= e.emp_id and g.ulbid=? and app_type_id=? and cat3_id=? ";


		$ulbid = $ulbid1;
		$app_type_id = 1;
		$cat3_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
		$query = $conn->prepare($sql);
		$query->bind_param("sii", $ulbid, $app_type_id, $cat3_id);
	}

	/**** Resolved within SLA ****/


	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '2') {

		$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
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
		$query->bind_param("siii", $ulbid, $app_type_id, $cat3_id, $disposal_status);
	}

	/** Resolved beyond SLA ****/

	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '3') {

		$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
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
		$query->bind_param("siii", $ulbid, $app_type_id, $cat3_id, $disposal_status);
	}


	/*** Pending within SLA ***/

	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '4') {

		$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
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
		$query->bind_param("siii", $ulbid, $app_type_id, $cat3_id, $disposal_status);
	}


	/*** Pending beyond SLA ***/


	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '5') {

		$sql = "SELECT g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,e.emp_name,e.emp_mobile,
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
		$query->bind_param("siii", $ulbid, $app_type_id, $cat3_id, $disposal_status);
	}

	/*** Financial Implication ***/

	if ($_REQUEST['cs_id'] && $_REQUEST['status'] == '6') {


		$sql = "select g.grievance_id,g.person_name,g.hno,g.address,g.ward_id,g.street_id,g.mobile,g.comp_desc,date_regd,disposed_date,e.emp_name,e.emp_mobile,
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
		$query->bind_param("iisii", $grievance_status_id, $disposal_status, $ulbid, $app_type_id, $cat3_id);
	}

	//echo $sql;

	$query->execute();
	$rs = $query->get_result();


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




	////////////////////pagination end



	$conn->close();
	$tpl->assign('street_list', $street_list);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('users_list', $users_list);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('app_type_id', $_REQUEST['aptid']);
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
	$tpl->display('complaints_full_rep_old.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
