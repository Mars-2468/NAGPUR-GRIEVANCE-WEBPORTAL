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
			$class= 'alert alert-danger display-hide';
			$msg = "Enter Valid Zone/ward/street Description..!";
			set_flash($msg,$class);
			header("Location: manage_street.php");
			exit;
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

								$class= 'alert alert-success display-hide';

								$msg = "The Record Successfully Saved..!";
							} else {

								$class= 'alert alert-danger display-hide';

								$msg = "Uable to save   " . $query->error;
							}

							$query->close();
						} else {

							$class= 'alert alert-danger display-hide';
							$msg = "Enter Valid Ward Description..!";
						}

					
					} else {
						$class= 'alert alert-danger display-hide';
						$msg= 'Invalid token..!';
					}
				} else {
					$class= 'alert alert-danger display-hide';
					$msg= 'Something Went Wrong..!';
				}
			} else {
				$class= 'alert alert-danger display-hide';
				$msg = "Invalid Captcha Code..!";
				
			}
			
			set_flash($msg,$class);
			header("Location: manage_street.php");
			exit;
		}
	}

	
} else {
	echo "<script>window.location='index.php';</script>";
}

