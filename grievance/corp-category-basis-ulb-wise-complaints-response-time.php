<?php
require "config.php";
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {

	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	$current_category_name = '';
	$cat_id = 0;
	$ward_id=!empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';
	
	if (isset($_REQUEST['cat_id'])) {

		$cat_id = $_REQUEST['cat_id']?? $cat_id;
		$sql = "SELECT * FROM `cs_mst` where cs_id= ? ";
		//$cat_id = $cat_id;

		$query = $conn->prepare($sql);
		$query->bind_param("i", $cat_id);

		if (!$query->execute()) {
			echo "Query not executed 1";
		}
		$rs1 = $query->get_result();


		$row = $rs1->fetch_assoc();

		$current_category_name = $row['cs_desc'];
	}

	$sql = "SELECT * FROM `ulbmst`";

	$query = $conn->prepare($sql);

	if (!$query->execute()) {
		echo "Query not executed 2";
	}
	$rs1 = $query->get_result();


	$grand_total_services = 0;
	$grand_total_s_days = 0;
	$total_resolved = 0;
	while ($row = $rs1->fetch_assoc()) {
		$count1 = 0;
		$count2 = 0;
		$days_from_hours = '';
		$total_hours = '';
		$hours_from_minutes = '';
		$total_minutes = '';
		$total_seconds = '';
		$minutes_from_seconds = '';
		$s_hours_from_minutes = '';
		$s_total_hours = '';
		$s_hours_from_minutes = '';
		$s_days_from_hours = '';
		$total_days_services = '';

		$ulb_list[$row['ulbid']] = $row['ulbname'];

		$sql = "SELECT count(DISTINCT g.grievance_id) as count, g.cat3_id 
		FROM grievances g, ".$_SESSION['grievances_trns']." gt, cs_mst c 
		WHERE g.grievance_id = gt.grievance_id 
		AND g.cat3_id = c.cs_id
		AND g.grievance_status_id IN (?, ?, ?, ?, ?, ?) 
		AND gt.disposal_status IN (?, ?, ?, ?, ?, ?)
		AND g.cat3_id = ? 
		AND g.app_type_id = ? 
		AND g.ulbid = ? 
		AND g.ward_id = ?";

		$id3 = 3;
		$id6 = 6;
		$id8 = 8;
		$id9 = 9;
		$id12 = 12;
		$id13 = 13;
		$ds1 = 3;  // Add the correct disposal_status values here
		$ds2 = 6;
		$ds3 = 8;
		$ds4 = 9;
		$ds5 = 12;
		$ds6 = 13;
		$cat3_id = $cat_id;  // Assuming $cat_id is set somewhere in your code
		$app_type_id = 1;
		$ulbid = strip_tags($_SESSION['ulbid']);

		$query = $conn->prepare($sql);
		$query->bind_param("iiiiiiiiiiiiiisi", $id3, $id6, $id8, $id9, $id12, $id13, $ds1, $ds2, $ds3, $ds4, $ds5, $ds6, $cat3_id, $app_type_id, $ulbid,$ward_id);

		if (!$query->execute()) {
			echo "Query not executed 3";
		}
		$rs2 = $query->get_result();

		$row2 = $rs2->fetch_assoc();
		$count2 = $row2['count'];

		$response_time[$row['ulbid']]['complaints']['count'] = $count2;
		$total_resolved += $count2;


		$sql4 = "SELECT response_time FROM `grievances` g, cs_mst c WHERE g.cat3_id=c.cs_id and g.ulbid=? 
		and 
		(
			grievance_status_id =? OR 
			grievance_status_id =? OR 
			grievance_status_id =? OR 
			grievance_status_id =? OR 
			grievance_status_id =? OR 
			grievance_status_id =? OR 
			grievance_status_id =? )  and app_type_id=?  and response_time!=? and cat_id= ?  and ward_id= ? ";

		$ulbid = $row['ulbid'];
		$id3 = '3';
		$id9 = '9';
		$id8 = '8';
		$id4 = '4';
		$id6 = '6';
		$id10 = '10';
		$id12 = '12';
		$app_type_id = '1';
		$response_time1 = '';
		$cat_id = $cat_id;

		$query = $conn->prepare($sql4);
		$query->bind_param("siiiiiiiiiii", $ulbid, $id3, $id9, $id8, $id4, $id6, $id10, $id12, $app_type_id, $response_time1, $cat_id,$ward_id);

		if (!$query->execute()) {
			echo "Query not executed 4";
		}
		$rs4 = $query->get_result();
		
		$s_total_minutes=0;
		$s_total_hours=0;
		$total_days_services=0;

		while ($row4 = $rs4->fetch_assoc()) {

			$current_services_response_time = $row4['response_time'];
			$temp1 = explode(":", $current_services_response_time);
			if ($temp1[0] > 0) {
				$total_days_services += $temp1[0];
			}

			if ($temp1[1] > 0) {
				$s_total_hours += $temp1[1];
			}
			if ($temp1[2] > 0) {
				$s_total_minutes += $temp1[2];
			}
		}

		$s_hours_from_minutes = (int)$s_total_minutes / 60;
		$s_total_hours = $s_total_hours + $s_hours_from_minutes;
		$s_days_from_hours = $s_total_hours / 24;
		$total_days_services = $total_days_services + $s_days_from_hours;
		$grand_total_s_days += $total_days_services;
		
		$total_servicess_avg_time = 0;

		if (!empty($count2) && $count2 > 0) {
			$total_servicess_avg_time = $total_days_services / $count2;
		}
		
		if ($row['ulbid'] != 211) {
			$response_time[$row['ulbid']]['complaints']['avg_res_time'] = number_format($total_servicess_avg_time, 2);
		}
	}

	//echo "<pre>";print_r($response_time);echo "</pre>";die();

	$sql6 = "SELECT count(DISTINCT grievance_id) as total_services_count FROM `complaints_map_info` WHERE response_time!=?
	        and status_id=? and cat3_id= ? ";

	$response_time12 = '';
	$status_id = '9';
	$merg_cs_id = $cat_id;
	$query = $conn->prepare($sql6);

	$query->bind_param("iii", $response_time12, $status_id, $merg_cs_id);

	if (!$query->execute()) {
		echo "Query not executed 5";
	}
	$rs6 = $query->get_result();

	$row6 = $rs6->fetch_assoc();

	$grand_total_services = $row6['total_services_count'];

	//$grand_s_avg_res_time = number_format($grand_total_s_days / $total_resolved, 2);

	$grand_s_avg_res_time = 0;

	if (!empty($total_resolved) && $total_resolved > 0) {
		$grand_s_avg_res_time = number_format($grand_total_s_days / $total_resolved, 2);
	}

	$response_time['grand_total_services'] = $grand_total_services;

	$response_time['grand_s_avg_res_time'] = $grand_s_avg_res_time;
	
	//echo "<pre>";print_r($response_time);echo "</pre>";die();
	
	$query->close();

	$tpl->assign('grand_s_avg_res_time', $grand_s_avg_res_time);
	$tpl->assign('total_resolved', $total_resolved);
	$tpl->assign('current_category_name', $current_category_name);
	$tpl->assign('response_time', $response_time);
	$tpl->assign('ulb_list', $ulb_list);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);	
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('corp-category-basis-ulb-wise-complaints-response-time.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
?>