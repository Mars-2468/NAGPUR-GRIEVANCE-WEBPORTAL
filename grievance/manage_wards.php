<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
require_once('csrf.class.php');
$csrf = new csrf();
$tpl = new Smarty();

$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

if (isset($_SESSION['uid'])) {

	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	require_once('prepare_connection.php');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

	include('user_defined_functions.php');
	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);


	$code = $_SESSION['code'];

	if (isset($_POST['save'])) {
		
		$captcha = $_POST['captcha'];
			
		if(!validateField($_POST['ward_desc'], 'text')['valid'] || !validateField($_POST['wards_marathi'], 'text')['valid']){
			$tpl->assign('class', 'alert alert-danger display-hide');
			$msg = "Enter Valid Zone/ward Description..!";
			$tpl->assign('msg', $msg);
		}else{

			if ($token_id == $_POST['token']) {

				if ($captcha == $code) {

					if (!empty($_POST['csrf_token'])) {

						if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {

							$ward_description = $_POST['ward_desc'];// preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_desc']);
							$ward_martathi_description = $_POST['wards_marathi'];// $_POST['wards_marathi'];
							
							
							//echo "<pre>";print_r($ward_description.'  => '.$ward_martathi_description);echo "</pre>";die();
							
							//print_r($ward_martathi_description);exit();
							if (!empty($ward_description) && !empty($ward_martathi_description)) {

								// print_r($ward_martathi_description);exit();
								if ($_POST['ward_id'] == '0') {

									$sql = "insert into ward_mst(ward_desc,wards_marathi,ulbid) values(?,?,?)";
									$query = $conn->prepare($sql);
									$query->bind_param("sss", $ward_description, $ward_martathi_description, $_SESSION['ulbid']);
								} else {

									$sql = "update ward_mst set ward_desc=?,wards_marathi=? where ward_id=?";
									$query = $conn->prepare($sql);
									$query->bind_param("ssi", $ward_description, $ward_martathi_description, $_POST['ward_id']);
								}
								if ($query->execute()) {
									$tpl->assign('class', 'alert alert-success display-hide');
									$msg = "The Record Successfully Saved..!";
								} else {
									$tpl->assign('msg', 'alert alert-danger display-hide');
									$msg = "Uable to save   " . $query->error;
								}
								$query->close();
							} else {
								$tpl->assign('class', 'alert alert-danger display-hide');
								$msg = "Enter Valid Zone Description..!";
								$tpl->assign('msg', $msg);
							}

							$tpl->assign('msg', $msg);
						} else {
							$tpl->assign('class', 'alert alert-danger display-hide');
							$tpl->assign('msg', 'Invalid token..!');
						}
					} else {
						$tpl->assign('class', 'alert alert-danger display-hide');
						$tpl->assign('msg', 'Something Went Wrong..!');
					}
				} else {
					$tpl->assign('class', 'alert alert-danger display-hide');
					$msg = "Invalid Captcha Code..!";
					$tpl->assign('msg', $msg);
				}
			}
		}
	}

	$sql = $conn->prepare("select ward_id,ward_desc,wards_marathi from ward_mst where ulbid=? order by ward_id DESC");

	$sql->bind_param("s", $_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();

	while ($row = $rs->fetch_assoc()) {
		$ward_list[$row['ward_id']]['ward_desc'] = $row['ward_desc'];
		$ward_list[$row['ward_id']]['wards_marathi'] = $row['wards_marathi'];
	}
	$sql->close();

	$sql = $conn->prepare("select ward_id,count(street_id) num_streets from street_mst where ulbid=? group by ward_id");
	$sql->bind_param("s", $_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$ward_list1[$row['ward_id']] = $row['num_streets'];
	}
	$sql->close();
	//$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
	//printf( str_replace('?', '%s', $sql), $_SESSION['ulbid']);

	$sql = $conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");

	$sql->bind_param("s", $_SESSION['ulbid']);
	//printf( str_replace('?', '%s', $sql), $_SESSION['ulbid']);
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
	$row = $rs->fetch_assoc();
	$conn->close();*/

	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$conn->close();
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('ward_list1', $ward_list1);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('code', $code);
	$tpl->assign('token_id', $token_id);
	$flash = get_flash();		
	$tpl->assign("flash", $flash); 
	$tpl->display('manage_wards.tpl');
} else {
	/*	$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
	echo "<script>window.location='index.php';</script>";
}

