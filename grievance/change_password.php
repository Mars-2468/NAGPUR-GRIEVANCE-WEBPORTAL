<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();


// unset($_SESSION['otp'], $_SESSION['password']);
// print_r($_SESSION['otp']);exit();
if (isset($_SESSION['uid'])) {


	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	//include('prepare_connection.php');

	$getEmployeeMobileQuery = "SELECT * FROM users where user_id='" . $_SESSION['uid'] . "' AND user_type='E' LIMIT 1";
	$resultOfEmployee = $conn->query($getEmployeeMobileQuery);
	$rowOfEmployee = $resultOfEmployee->fetch_assoc();
	$getUserMobileNumber = $rowOfEmployee['user_mobile'];

	if (isset($_POST['save'])) {
		
		//$_POST['password']='abcd@1234';
		
	

		if(!validateField($_POST['old_password'], 'password')['valid'] || !validateField($_POST['password'], 'password')['valid'] || !validateField($_POST['password_again'], 'password')['valid']){
			$msg  = "Enter Valid oldpassword/password/confirmpassword!";
			$class = "alert alert-danger display-hide";
			set_flash($msg,$class);
			header('Location:change_pwd.php');
			exit;
		}	

			//echo "<pre>";print_r(validateField($_POST['password'], 'password'));echo "</pre>";die();
		$old_password=sha1($_POST['ofk']);
		
		$isUserExisted = "select * from users where user_id=? and user_pwd=PASSWORD(?)";

		$query = $conn->prepare($isUserExisted);
		$query->bind_param("ss", $_SESSION['uid'],$old_password);

		$query->execute();
		$rs = $query->get_result();
		$row = $rs->fetch_assoc();	
			
		//echo"<pre>";print_r(empty($row));echo"</pre>";die();

		if(empty($row)){
			$msg="old password does not match!";
			$class= 'alert alert-danger display-hide';
			set_flash($msg,$class);
			header('Location: change_pwd.php');
			exit;
		}	
		
		$user_password = sha1($_POST['fk']);
		$sql = "update users set user_pwd=PASSWORD(?),show_pwd=?  where user_id=?";
		$query = $conn->prepare($sql);
		$password = $user_password;
				
		$show_pwd=encrypt_text($input_password, $secretKey);
		
		$user_id = strip_tags($_POST['uid']);
		$query->bind_param("sss", $password, $show_pwd, $user_id);
		$rs = $query->execute();

		if ($rs) {

			$class= 'alert alert-success display-hide';
			$msg = "You Have Changed Your Password Successfully..!";
			header('Location:logout.php');
			exit;
		} else {

			$class= 'alert alert-danger display-hide';
			$msg = "Uable To Save   " . mysql_error();
		}
	}

	if (isset($_POST['otpverify']) && !empty($getUserMobileNumber)) {



		$sql = "SELECT * FROM change_password_otp_verification where user_mobile='" . $getUserMobileNumber . "' AND verified= '0' order by id desc LIMIT 1";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$user_mobile = $row['user_mobile'];
		$_SESSION['otp'] = $row['otp'];
		// print_r($row);exit();
		$dbOTP = $row['otp'];


		$_SESSION['password'] = $_POST['password'];

		if ($dbOTP == $_POST['otp']) {

			$user_password = sha1($_POST['password']);
			$sql = "update users set user_pwd=PASSWORD(?),show_pwd=?  where user_id=?";
			$query = $conn->prepare($sql);
			$password = $user_password;

			$show_pwd=encrypt_text($input_password, $secretKey);
			
			$user_id = strip_tags($_POST['uid']);
			$query->bind_param("sss", $password, $show_pwd, $user_id);
			$rs = $query->execute();

			$updateStatusOfOtpVerificationTableQuery = "update change_password_otp_verification set verified=?  where user_mobile=? AND verified=?";
			$queryOfOtpVerification = $conn->prepare($updateStatusOfOtpVerificationTableQuery);
			$verified = 1;
			$verif = 0;
			$queryOfOtpVerification->bind_param("isi", $verified, $getUserMobileNumber, $verif);
			$queryOfOtpVerification->execute();

			if ($rs) {

				$class= 'alert alert-success display-hide';
				$msg = "You Have Changed Your Password Successfully..!";
				unset($_SESSION['otp'], $_SESSION['password']);
			} else {

				$class = 'alert alert-danger display-hide';
				$msg = "Uable To Save   " . mysql_error();
			}
		} else {
			//  print_r($_SESSION['otp']);exit();
			$class = 'alert alert-danger display-hide';
			$msg = "Please Enter Valid Otp..! ";
		}

		// if($rs)
		// {
		// 	print_r("one");exit();
		// 	$tpl->assign('class','alert alert-success display-hide');
		// 	$msg="You have changed your password Successfully";
		// 	unset($_SESSION['otp'], $_SESSION['password']);					
		// }
		// else
		// {
		// 	print_r($_POST['otp']);exit();
		// 	$tpl->assign('msg','alert alert-danger display-hide');
		// 	$msg="Uable to save   ".mysql_error();
		// }


	}

	set_flash($msg,$class);

	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid=?";
	$query = $conn->prepare($sql);
	$query->bind_param("s", htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$query->execute();
	$rs = $query->get_result();
	while ($row = $rs->fetch_assoc()) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	$query->close();

	/*$sql=$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid=?");
    		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    		$sql->execute();
    		$rs=$sql->get_result();
    		$row = $rs->fetch_assoc();
    		$sql->close();*/

	// print_r($_SESSION['otp']);exit();

	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('user_type', htmlspecialchars(strip_tags($_SESSION['user_type'])));
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('ward_list1', $ward_list1);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('otp', $_SESSION['otp']);
	$tpl->assign('password', $_SESSION['password']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('banner', $_SESSION['banner']);
	$flash = get_flash();		
	$tpl->assign("flash", $flash); 
	$tpl->display('change_pwd.tpl');
} else {


	echo "<script>window.location='index.php';</script>";
}



function encrypt_text($plain_text, $secretKey) {
    // Generate an encryption key from the secretKey
    $key = hash('sha256', $secretKey, true);
    
    // Define the cipher method (AES-256-CBC)
    $cipher_method = 'AES-256-CBC';
    
    // Generate an initialization vector (IV) for encryption (must be random and 16 bytes for AES-256-CBC)
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
    
    // Encrypt the text
    $encrypted_text = openssl_encrypt($plain_text, $cipher_method, $key, 0, $iv);
    
    // Return the encrypted text along with the IV (IV is needed for decryption)
    return base64_encode($encrypted_text . '::' . $iv);
}


//decrypt
function decrypt_text($encrypted_text, $secretKey) {
    // Extract the encrypted data and IV from the encoded string
    list($encrypted_data, $iv) = explode('::', base64_decode($encrypted_text), 2);
    
    // Generate the same encryption key from the secretKey
    $key = hash('sha256', $secretKey, true);
    
    // Define the cipher method (AES-256-CBC)
    $cipher_method = 'AES-256-CBC';
    
    // Decrypt the text
    $decrypted_text = openssl_decrypt($encrypted_data, $cipher_method, $key, 0, $iv);
    
    return $decrypted_text;
}
