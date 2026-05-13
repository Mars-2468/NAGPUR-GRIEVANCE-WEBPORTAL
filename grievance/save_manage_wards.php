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
$code = $_SESSION['code'];

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

	if (isset($_POST['save'])) {
		
		$captcha = $_POST['captcha'];
			
		if(!validateField($_POST['ward_desc'], 'text')['valid'] || !validateField($_POST['wards_marathi'], 'text')['valid']){
			$class= 'alert alert-danger display-hide';
			$msg = "Enter Valid Zone/ward Description..!";
			set_flash($msg,$class);
			header('Location: manage_wards.php');
			exit;
		}else{
			if ($captcha == $code) {
				$ward_description = $_POST['ward_desc'];// preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_desc']);
				$ward_martathi_description = $_POST['wards_marathi'];// $_POST['wards_marathi'];
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
						$class= 'alert alert-success display-hide';
						$msg = "The Record Successfully Saved..!";
					} else {
						$class= 'alert alert-danger display-hide';
						$msg = "Uable to save   " . $query->error;
					}
					$query->close();
				} else {
					$class= 'alert alert-danger display-hide';
					$msg = "Enter Valid Zone Description..!";
					
				} 
			}else {
				$class= 'alert alert-danger display-hide';
				$msg = "inValid captcha...!";
				
			}			
			set_flash($msg,$class);
			header('Location: manage_wards.php');
			exit;
						
		}
	}

	
} else {
	/*	$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
	echo "<script>window.location='index.php';</script>";
}

