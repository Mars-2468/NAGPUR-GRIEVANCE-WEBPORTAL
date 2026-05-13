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

	$captcha = $_POST['captcha'];
	$code =  $_SESSION['code'];

	if (isset($_POST['save'])) {
		
		if(!validateField($_POST['street_desc'], 'sptext')['valid'] || !validateField($_POST['wards_marathi'], 'sptext')['valid'] || !validateField($_POST['street_desc_marathi'], 'sptext')['valid']){
			$tpl->assign('class', 'alert alert-danger display-hide');
			$msg = "Enter Valid Zone/ward/street Description..!";
			$tpl->assign('msg', $msg);
		}else{

			if ($captcha == $code) {

				if (!empty($_POST['csrf_token'])) {

					if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {

						$street_description = $_POST['street_desc'];//preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['street_desc']);
						
						$ward_martathi_description = $_POST['wards_marathi'];//$_POST['wards_marathi'];
						$street_desc_marathi = $_POST['street_desc_marathi'];//$_POST['street_desc_marathi'];
						
						//echo "<pre>";print_r($ward_martathi_description);echo "</pre>";die();
						
						if (!empty($street_description) && !empty($ward_martathi_description) && !empty($street_desc_marathi)) {

							if ($_POST['street_id'] == '0') {

								$sql = "insert into street_mst(street_desc,street_desc_marathi,wards_marathi,ward_id,ulbid) values(?,?,?,?,?)";

								$query = $conn->prepare($sql);

								$query->bind_param("sssss", $street_description, $street_desc_marathi, $ward_martathi_description, $_POST['ward_id'], $_SESSION['ulbid']);
							} else {

								$sql = "update street_mst set street_desc=?,street_desc_marathi=?,wards_marathi=?,ward_id=? where street_id=?";

								$query = $conn->prepare($sql);

								$query->bind_param("sssii", $street_description, $street_desc_marathi, $ward_martathi_description, $_POST['ward_id'], $_POST['street_id']);
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
							$msg = "Enter Valid Ward Description..!";
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

	$sql = $conn->prepare("select ward_id,street_id,street_desc,street_desc_marathi,wards_marathi from street_mst where ulbid=? order by ward_id,street_desc ASC");

	$sql->bind_param("s", $_SESSION['ulbid']);

	$sql->execute();

	$rs = $sql->get_result();

	while ($row = $rs->fetch_assoc()) {

		$street_list[$row['street_id']]['street_desc'] = $row['street_desc'];
		$street_list[$row['street_id']]['wards_marathi'] = $row['wards_marathi'];
		$street_list[$row['street_id']]['street_desc_marathi'] = $row['street_desc_marathi'];
		$street_list[$row['street_id']]['ward_id'] = $row['ward_id'];
	}
	$sql->close();

	$sql = $conn->prepare("select ward_id, ward_desc,wards_marathi from ward_mst where ulbid=?");

	$sql->bind_param("s", $_SESSION['ulbid']);

	$sql->execute();

	$rs = $sql->get_result();

	while ($row = $rs->fetch_assoc()) {

		$ward_list[$row['ward_id']] = $row['ward_desc'];
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

	$users_count = $row['user_count'];

	$tpl->assign('users_count', $users_count);


	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('online_applications', $online_applications);

	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));

	$tpl->assign('ulbid', $_SESSION['ulbid']);

	$tpl->assign('ward_list', $ward_list);

	$tpl->assign('street_list', $street_list);

	$tpl->assign('logo', $_SESSION['logo']);

	$tpl->assign('services', $obj->services);

	$tpl->assign('uname', $_SESSION['user_name']);

	$tpl->assign('uid', $_SESSION['uid']);

	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('banner', $_SESSION['banner']);

	$tpl->assign('code', $code);
	$flash = get_flash();		
	$tpl->assign("flash", $flash); 
	$tpl->display('manage_street.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}

