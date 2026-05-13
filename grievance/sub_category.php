<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 0);

require_once('Smarty.class.php');

$tpl = new Smarty();

if (isset($_SESSION['uid'])) {

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

	$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);

	$code = mysqli_real_escape_string($conn, $_SESSION['code']);
	
	$sql = $conn->prepare("select sub_cat_id,cat_id,description,description_marathi from subcategory_mst order by sub_cat_id ASC");
	// $sql->bind_param("s",$_SESSION['sub_cat_id']);
	$sql->execute();
	$rs = $sql->get_result();
	// print_r($rs->fetch_assoc());exit();

	while ($row = $rs->fetch_assoc()) {
		$subcategory_list[$row['sub_cat_id']]['cat_id'] = $row['cat_id'];
		$subcategory_list[$row['sub_cat_id']]['sub_cat_id'] = $row['sub_cat_id'];
		$subcategory_list[$row['sub_cat_id']]['description'] = $row['description'];
		$subcategory_list[$row['sub_cat_id']]['description_marathi'] = $row['description_marathi'];
	}
	$sql->close();

	$sql = $conn->prepare("select cat_id, description,telugu_description from category_mst where ulbid=?");
	$sql->bind_param("s", $_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();
	//    dd($rs->fetch_assoc());
	while ($row = $rs->fetch_assoc()) {
		$category_list[$row['cat_id']] = $row['description'];
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


	/* $sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");

	$sql->bind_param("s",$_SESSION['ulbid']);

	$sql->execute();

	$rs=$sql->get_result();

	$row = $rs->fetch_assoc();

	$conn->close();*/


	// print_r($subcategory_list);
	//   exit();

	$users_count = $row['user_count'];

	$tpl->assign('users_count', $users_count);

	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('online_applications', $online_applications);

	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));

	$tpl->assign('ulbid', $_SESSION['ulbid']);

	$tpl->assign('category_list', $category_list);

	$tpl->assign('subcategory_list', $subcategory_list);

	$tpl->assign('logo', $_SESSION['logo']);

	$tpl->assign('services', $obj->services);

	$tpl->assign('uname', $_SESSION['user_name']);

	$tpl->assign('uid', $_SESSION['uid']);

	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('banner', $_SESSION['banner']);

	$tpl->assign('code', $code);
	$flash = get_flash();		
	$tpl->assign("flash", $flash);
	$tpl->display('subcategory_mst.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}


	