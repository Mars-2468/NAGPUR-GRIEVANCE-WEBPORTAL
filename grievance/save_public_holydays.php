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

	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);
	$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);
	$code = mysqli_real_escape_string($conn, $_SESSION['code']);


	if (isset($_POST['save'])) {
		
		
		if(!validateField($_POST['desciption'], 'sptext')['valid'] || !validateField($_POST['desciption_marathi'], 'sptext')['valid']){
			$class= 'alert alert-danger display-hide';
			$msg = "Enter Valid Holiday Description/Marathi Description..!";
			set_flash($msg,$class);
			header("Location: public_holydays.php");
			exit;
		}else{
		
		
			/* if($captcha == $code){ */
				
				if (!empty($_POST['csrf_token'])) {
					if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {
						if ($token_id == $_POST['token']) {
							
							//echo "<pre>";print_r($_POST);echo "</pre>";die();
							
							$date = date('Y-m-d', strtotime($_POST['date']));
							
							$desciption = $_POST['desciption']; //preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['desciption']);
							$desciption_marathi =  $_POST['desciption_marathi']; //$_POST['desciption_marathi'];

							$sql = "insert into public_holydays(date,desciption,desciption_marathi,ulbid) values(?,?,?,?)";
							$query = $conn->prepare($sql);
							$query->bind_param("ssss", $date, $desciption, $desciption_marathi, $_SESSION['ulbid']);

							if ($query->execute()) {
								$class= 'alert alert-success display-hide';
								$msg = "The Record Successfully Saved..!";
							} else {
								$class='alert alert-danger display-hide';
								$msg = "Uable to save   " . $query->error;
							}
							$query->close();
						} else {
							/*$tpl->assign('msg', 'alert alert-danger display-hide');
							$msg = "Uable to save   " . $query->error;*/
							$class= 'alert alert-danger display-hide';
							$msg = "Enter Valid Holiday Description..!";
						}
						
					} else {
						$class= 'alert alert-danger display-hide';
						$msg= 'Invalid token..!';
					}
				} else {
					$class= 'alert alert-danger display-hide';
					$msg= 'Something Went Wrong..!';
				}

				set_flash($msg,$class);
				header("Location: public_holydays.php");
				exit;

			/* }
			else
			{
				$msg="Invalid Captcha Code";
				$tpl->assign('msg',$msg);
			} */
		}
		set_flash($msg,$class);
		header("Location: public_holydays.php");
		exit;
	}

} else {
	echo "<script>window.location='index.php';</script>";
}
	
