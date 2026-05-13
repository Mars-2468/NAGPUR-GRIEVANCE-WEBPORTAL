<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {

	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	include('user_defined_functions.php');

	include('prepare_connection.php');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');
	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);

	//$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);
	//$code = mysqli_real_escape_string($conn, $_SESSION['code']);

	$sql = $conn->prepare("select dept_id,dept_desc,dept_marathi from dept_mst where ulbid=?");

	$sql->bind_param("s", $_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$dept_list[$row['dept_id']]['dept_desc'] = $row['dept_desc'];
		$dept_list[$row['dept_id']]['dept_marathi'] = $row['dept_marathi'];
	}
	$sql->close();

	$sql = $conn->prepare("select dept_id,count(desg_id) num_desg from desg_mst where ulbid=? group by dept_id");
	$sql->bind_param("s", $_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$dept_list1[$row['dept_id']]['num_desg'] = $row['num_desg'];
	}
	$sql->close();

	$delete_status = 0;
	$sql = $conn->prepare("select emp_dept,count(emp_id) num_emp from emp_mst where delete_status=? and ulbid=? group by emp_dept");
	$sql->bind_param("is", $delete_status, $_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$dept_list1[$row['emp_dept']]['num_emp'] = $row['num_emp'];
	}
	$sql->close();

	$sql = $conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
	$sql->bind_param("s", $_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	$sql->close();

	/** captcha generation ****/

	$code = rand(1000, 9999);

	$_SESSION['code'] = $code;

	/** close **/

	/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
	$sql->bind_param("s",$_SESSION['ulbid']);
	$sql->execute();
	$rs=$sql->get_result();
	$row = $rs->fetch_assoc($rs);
	$conn->close();*/
	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);

	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('online_applications', $online_applications);
	$conn->close();
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('dept_list1', $dept_list1);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('code', $code);
	$tpl->display('manage_dept.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}

