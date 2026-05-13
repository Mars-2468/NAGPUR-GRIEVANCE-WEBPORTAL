<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once('Smarty.class.php');
$tpl = new Smarty();
;
if (isset($_SESSION['uid'])) {


	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	include('prepare_connection.php');
	$conn = getconnection();

	$ward_id=!empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';

	$current_category_name = '';
	$cat_id = 0;
	if (isset($_REQUEST['cat_id'])) {

		$cat_id = $_REQUEST['cat_id'];
		$sql = $conn->prepare("SELECT * FROM cs_mst where cs_id=?");
		$cs_id = $cat_id;
		$sql->bind_param("i", $cs_id);
		$sql->execute();
		$rs = $sql->get_result();
		$row = $rs->fetch_assoc();
		$current_category_name = $row['cs_desc'];
	}

	$sql = "SELECT count(DISTINCT g.grievance_id) as count, g.ulbid, g.cat3_id 
	FROM grievances g, ".$_SESSION['grievances_trns']." gt WHERE g.grievance_id = gt.grievance_id 
	AND g.grievance_status_id IN (?, ?, ?, ?, ?, ?) 
	AND gt.disposal_status IN (?, ?, ?, ?, ?, ?)
	AND g.cat3_id != ? 
	AND g.app_type_id = ? 
	AND g.ulbid = ?
	AND g.ward_id = ?";
	$query = $conn->prepare($sql);

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
	$cat3_id = 0;
	$app_type_id = 1;
	$ulbid = $_SESSION['ulbid'];

	$query->bind_param("iiiiiiiiiiiiiisi", $id3, $id6, $id8, $id9, $id12, $id13, $ds1, $ds2, $ds3, $ds4, $ds5, $ds6, $cat3_id, $app_type_id, $ulbid,$ward_id);

	$rs = $query->execute();
	$rs = $query->get_result();

	while ($row = $rs->fetch_assoc()) {
		$ulbtotalcomplaints[$row['ulbid']]['complaints']['count'] = $row['count'];
		$grand_total_complaints += $row['count'];
	}
	$query->close();
	$tpl->assign('ulbtotalcomplaints', $ulbtotalcomplaints);

	$sql = $conn->prepare("SELECT * FROM `ulbmst` where ulbid=?");
	$ulbid = $_SESSION['ulbid'];
	$sql->bind_param("s", $ulbid);
	$sql->execute();
	$rs = $sql->get_result();

	//$grand_total_complaints=0;
	$grand_total_services = 0;
	$grand_total_c_days = 0;
	$grand_total_s_days = 0;

	while ($row = $rs->fetch_assoc()) {
		$count1 = '';
		$count2 = '';
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

		$sql = "SELECT g.response_time 
        FROM grievances g, ".$_SESSION['grievances_trns']." gt WHERE g.grievance_id = gt.grievance_id 
        AND g.grievance_status_id IN (?, ?, ?, ?, ?, ?) 
        AND gt.disposal_status IN (?, ?, ?, ?, ?, ?) 
        AND g.response_time != ? 
        AND g.ulbid = ? 
        AND g.cat3_id != ? 
        AND g.app_type_id = ?
		AND g.ward_id = ?";
		$query = $conn->prepare($sql);
		$ulbid = strip_tags($row['ulbid']);
		$response_time1 = '';
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
		$cat3_id = 0;
		$app_type_id = 1;
		$ulbid = strip_tags($_SESSION['ulbid']);

		$query->bind_param("iiiiiiiiiiiissiii", $id3, $id6, $id8, $id9, $id12, $id13, $ds1, $ds2, $ds3, $ds4, $ds5, $ds6, $response_time1, $ulbid, $cat3_id, $app_type_id,$ward_id);

		$query->execute();
		$rs3 = $query->get_result();
		$total_days = 0;

		while ($row3 = mysqli_fetch_assoc($rs3)) {

			$current_response_time = $row3['response_time'];
			$temp = explode(":", $current_response_time);
			if ($temp[0] > 0) {
				$total_days += $temp[0];
			}
			if ($temp[1] > 0) {
				$total_hours += $temp[1];
			}
			if ($temp[2] > 0) {
				$total_minutes += $temp[2];
			}
			if ($temp[3] > 0) {
				$total_seconds += $temp[3];
			}
		}
		$minutes_from_seconds = $total_seconds / 60;
		$total_minutes = $total_minutes + $minutes_from_seconds;
		$hours_from_minutes = $total_minutes / 60;
		$total_hours = $total_hours + $hours_from_minutes;
		$days_from_hours = $total_hours / 24;
		$total_days = $total_days + $days_from_hours;
		$response_time[$row['ulbid']]['complaints']['count'] = $total_days;
		$grand_total_c_days += $total_days;

		$total_complaints_avg_time = $total_days / $ulbtotalcomplaints[$row['ulbid']]['complaints']['count'];
		$response_time[$row['ulbid']]['complaints']['avg_res_time'] = round($total_complaints_avg_time);
	}

	$grand_c_avg_res_time = round($grand_total_c_days / $grand_total_complaints);

	$conn->close();
	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);

	mysqli_close($conn);
	$tpl->assign('grand_total_complaints', $grand_total_complaints);
	$tpl->assign('grand_c_avg_res_time', $grand_c_avg_res_time);
	$tpl->assign('current_category_name', $current_category_name);
	$tpl->assign('response_time', $response_time);
	$tpl->assign('ulb_list', $ulb_list);
	$tpl->assign('feedback_sub_options', $feedback_sub_options);
	$tpl->assign('users_list', $users_list);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('app_type_id', $_REQUEST['aptid']);
	$tpl->assign('cs_list', $cs_list);
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
	$tpl->display('corp_ulb_complaints_responsetime.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
?>