<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {

	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	include('prepare_connection.php');
	$conn = getconnection();
	
	$data['satisfaction'] = 0;
	
	$sql = "select COUNT(grievance_id) as count from rating_mst where rating_no >=3";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$satisfied_citizens = $row['count'];

	// all users
	$sql = "select COUNT(grievance_id) as count from rating_mst";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$total_citizens = $row['count'];

	$data['satisfaction'] = $satisfied_citizens / $total_citizens;

	$sql = "select * from grievances";
	$rs = mysqli_query($conn, $sql);
	$nr = mysqli_num_rows($rs);
	$data['total_grievances'] = $nr;
	// Resolved grievances

	$sql = "select * from grievances where grievance_status_id=9";
	$rs = mysqli_query($conn, $sql);
	$nr = mysqli_num_rows($rs);
	$data['total_grievances_resolved'] = $nr;

	$data['gr_resolved_percent'] = round($data['total_grievances_resolved'] / $data['total_grievances'] * 100);

	$sql = "SELECT * from ward_mst order by sortOrder";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$ward_list[$row['ward_id']]['ward_name'] = $row['ward_desc'];
	}

	mysqli_close($conn);
	
	$tpl->assign('data', $data);
	
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('graphical_rep_dashboard.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
