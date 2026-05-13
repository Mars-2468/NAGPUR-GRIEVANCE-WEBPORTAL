<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

require_once('send_sms.php');
require_once('sms_conf.php');

if (isset($_SESSION['uid'])) {

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
	include('user_defined_functions.php');
	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);
	
	$sql = "select emp_id,emp_name from emp_mst where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "' and delete_status=0";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$emp_list[$row['emp_id']] = $row['emp_name'];
	}

	$sql = "select emp_id,emp_name from emp_mst_od where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "' and delete_status=0";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$emp_list[$row['emp_id']] = $row['emp_name'];
	}

	$sql = "select e.*,u.user_id,show_pwd from emp_mst e,users u where e.emp_id=u.emp_id and e.ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "' and e.delete_status=0";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['emp_id']]['emp_name'] = $row['emp_name'];
		$data[$row['emp_id']]['emp_dept'] = $row['emp_dept'];
		$data[$row['emp_id']]['emp_desg'] = $row['emp_desg'];
		$data[$row['emp_id']]['emp_status'] = $row['emp_status'];
		$data[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
	}

	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$dept_list[$row['dept_id']] = $row['dept_desc'];
	}
	$sql = "select desg_id,desg_desc from desg_mst where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$desg_list[$row['desg_id']] = $row['desg_desc'];
	}


	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	$sql = "select COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "%'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);
	mysqli_close($conn);
	//print_r($online_applications);
	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('online_applications', $online_applications);

	$tpl->assign('desg_list', $desg_list);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('data', $data);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('banner', $_SESSION['banner']);
	$flash = get_flash();		
	$tpl->assign("flash", $flash);
	$tpl->display('add_user.tpl');
} else {
	$msg = "You have not logged in, Please Login..!";
	$tpl->assign('msg', $msg);
	$tpl->display('user_login.tpl');
}
