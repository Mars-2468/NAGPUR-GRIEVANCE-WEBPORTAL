<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);

require_once('Smarty.class.php');
require_once('csrf.class.php');
$csrf = new csrf();
$tpl = new Smarty();


$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
//require_once('sms_conf.php');
//require_once('send_sms.php');	

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
	include('user_defined_functions.php');
	require_once('prepare_connection.php');
	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);
	$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);
	$code = mysqli_real_escape_string($conn, $_SESSION['code']);

	$sql = $conn->prepare("select * from public_holydays where ulbid=? order by date");
	$sql->bind_param("s", htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$sql->execute();
	$rs = $sql->get_result();

	while ($row = $rs->fetch_assoc()) {
		//foreach($field_info as $fi => $f) 
		$doc_list[$row['id']]['date'] = $row['date'];
		$doc_list[$row['id']]['desciption'] = $row['desciption'];
		$doc_list[$row['id']]['desciption_marathi'] = $row['desciption_marathi'];
		//$doc_list[$row['id']][$f->name]=$row[$f->name];
	}
	$sql->close();

	$sql = $conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
	$sql->bind_param("s", htmlspecialchars(strip_tags($_SESSION['ulbid'])));
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
	$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$sql->execute();
	$rs=$sql->get_result();
	$row = $rs->fetch_assoc();
	$conn->close();*/

	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);

	$tpl->assign('user_type', htmlspecialchars(strip_tags($_SESSION['user_type'])));

	$tpl->assign('online_applications', $online_applications);

	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('code', $code);
	$tpl->assign('doc_list', $doc_list);
	$tpl->assign('token_id', $token_id);
	$flash = get_flash();		
	$tpl->assign("flash", $flash); 
	$tpl->display('public_holydays.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
	
