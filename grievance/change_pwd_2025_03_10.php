<?php
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	 date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	session_start();

	// unset($_SESSION['otp'], $_SESSION['password']);
	// print_r($_SESSION['otp']);exit();
	if(isset($_SESSION['uid']))
	{
	    
	   
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');

		$getEmployeeMobileQuery = "SELECT * FROM users where user_id='".$_SESSION['uid']."' AND user_type='E' LIMIT 1";			
		$resultOfEmployee = $conn->query($getEmployeeMobileQuery);			
		$rowOfEmployee = $resultOfEmployee->fetch_assoc();
		$getUserMobileNumber = $rowOfEmployee['user_mobile'];

		if(isset($_POST['save']) && !empty($getUserMobileNumber))
		{
			$randomOTP=rand(10000,99999);
			$_SESSION['otp'] = $randomOTP;				
			$_SESSION['password']=$_POST['fk'];

			$getEmployeeMobileQuery = "SELECT * FROM users where user_id='".$_SESSION['uid']."'  LIMIT 1";			
			$resultOfEmployee = $conn->query($getEmployeeMobileQuery);			
			$rowOfEmployee = $resultOfEmployee->fetch_assoc();
			$getUserMobileNumber = $rowOfEmployee['user_mobile'];

			$sql = "INSERT INTO change_password_otp_verification (user_mobile, otp) VALUES (?,?)";
			$stmt = $conn->prepare($sql);
			$mobile = $getUserMobileNumber;				
			$stmt->bind_param("si", $mobile, $randomOTP);
			$rs=$stmt->execute();
			
			if($rs)
			{
				$message1 = "One Time Password (OTP) for NMC application logging is ".$randomOTP." Please use this OTP for logging NMCGov. Pls do not share this with any one, Valid for 5 minutes.";	
				$user_mobile = $mobile;
				$templateId = "1507166546678524968";
				$message =str_replace ( ' ', '%20', $message1);
				$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $user_mobile . "&message=" . $message;
				$message =str_replace ( ' ', '%20', $message1);
				$post = curl_init();
				curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($post, CURLOPT_URL, $url);
				curl_setopt($post, CURLOPT_POST, count($data));
				curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
				curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
				$result=curl_exec($post); //result from mobile seva server
				//output from server displayed
				curl_close($post);
				
				$tpl->assign('class','alert alert-success display-hide');
				$msg="OTP Sent to mobile number";
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$msg="Uable to save   ".mysql_error();
				}				

		}else{
					$user_password = sha1($_POST['fk']);					
					 $sql="update users set user_pwd=PASSWORD(?),show_pwd=?  where user_id=?";
					 $query=$conn->prepare($sql);
					 $password=$user_password;
					 $show_pwd=mysqli_real_escape_string($conn,strip_tags($_POST['password']));
					 $user_id=strip_tags($_POST['uid']);
					 $query->bind_param("sss",$password,$show_pwd,$user_id);
				     $rs=$query->execute();

				if($rs)
				{
					
					$tpl->assign('class','alert alert-success display-hide');
					$msg="You have changed your password Successfully";							
				}
				else
				{
					
					$tpl->assign('msg','alert alert-danger display-hide');
					$msg="Uable to save   ".mysql_error();
				}

		}	
			
		if(isset($_POST['otpverify']) && !empty($getUserMobileNumber) ){

		
			
			$sql = "SELECT * FROM change_password_otp_verification where user_mobile='".$_SESSION['uid']."' AND verified= '0' LIMIT 1";			
			$result = $conn->query($sql);			
			$row = $result->fetch_assoc();
			$user_mobile = $row['user_mobile'];
			$_SESSION['otp'] = $row['otp'];			
			// print_r($row);exit();
			$dbOTP = $row['otp'];	
			
		
			$_SESSION['password']=$_POST['password'];
			
			if($dbOTP==$_POST['otp']){
				
				$user_password = sha1($_POST['password']);					
				$sql="update users set user_pwd=PASSWORD(?),show_pwd=?  where user_id=?";
				$query=$conn->prepare($sql);
				$password=$user_password;				
				
				$show_pwd=mysqli_real_escape_string($conn,strip_tags($_POST['password']));
				$user_id=strip_tags($_POST['uid']);
				$query->bind_param("sss",$password,$show_pwd,$user_id);
				$rs=$query->execute();
				$updateStatusOfOtpVerificationTableQuery="update change_password_otp_verification set verified=?  where user_mobile=? AND verified=?";
				$queryOfOtpVerification=$conn->prepare($updateStatusOfOtpVerificationTableQuery);
				$verified = 1;
				$verif = 0;
				$queryOfOtpVerification->bind_param("isi",$verified,$getUserMobileNumber,$verif);
				$queryOfOtpVerification->execute();	

				if($rs)
				{
					
					$tpl->assign('class','alert alert-success display-hide');
					$msg="You have changed your password Successfully";
					unset($_SESSION['otp'], $_SESSION['password']);					
				}
				else
				{
					
					$tpl->assign('msg','alert alert-danger display-hide');
					$msg="Uable to save   ".mysql_error();
				}



			}else{
					//  print_r($_SESSION['otp']);exit();
					$tpl->assign('msg','alert alert-danger display-hide');
					$msg="Please enter valid otp ";
					
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

		$tpl->assign('msg',$msg);
		
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $online_applications['trade_application']=$row['trade_application'];
		  $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		$query->close();
		
		/*$sql=$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid=?");
    		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    		$sql->execute();
    		$rs=$sql->get_result();
    		$row = $rs->fetch_assoc();
    		$sql->close();*/

			// print_r($_SESSION['otp']);exit();
		 
	      $users_count=$row['user_count'];
	      $tpl->assign('users_count',$users_count);
	      $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
          $tpl->assign('ulbid',$_SESSION['ulbid']);
		  $tpl->assign('user_type',htmlspecialchars(strip_tags($_SESSION['user_type'])));
		  $tpl->assign('online_applications',$online_applications);
		  $tpl->assign('ward_list',$ward_list);
		  $tpl->assign('ward_list1',$ward_list1);
		  $tpl->assign('logo',$_SESSION['logo']);
		  $tpl->assign('services',$obj->services);
		  $tpl->assign('uname',$_SESSION['user_name']);
		  $tpl->assign('uid',$_SESSION['uid']);
		  $tpl->assign('otp',$_SESSION['otp']);
		  $tpl->assign('password',$_SESSION['password']);
		  $tpl->assign('main_icons',$obj->main_icons);
		  $tpl->assign('banner',$_SESSION['banner']);
		  $tpl->display('change_pwd.tpl');
	}
	else
	{


echo "<script>window.location='index.php';</script>";
	}
?>