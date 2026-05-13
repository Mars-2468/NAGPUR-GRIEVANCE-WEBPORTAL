<?php
	error_reporting(0);
	session_start();
	header("Content-Type: application/json");
	require_once('../connection.php');
	$conn=getconnection();
	
	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
		
	$base_url='https://chhsambhajinagarmc.org/csms/api/';
	
	//var_dump($_REQUEST['adminform']);die();
	
  	if(isset($_REQUEST['user_id']))
  	{
  		$uid= $_REQUEST['user_id'];
  		$ulbid= $_REQUEST['ulbid'];
  		
  	
		$sql = "select * from users_test where user_id='".$uid."' ";//and ulbid='".$ulbid."'
	  	$res = mysqli_query($conn,$sql);
		$res2=$res;
		$row=mysqli_fetch_array($res2);
		$user_id=$row['user_id'].generateRandomString();
		$user_email=$row['user_email'].generateRandomString();
		$deleted_at = date('Y-m-d H:i:s');
		
		//echo json_encode($user_id); 
		
		$nr = mysqli_num_rows($res);
		
		
		
		if($nr > 0 )
		{
			
		    $sql ="update users_test set user_id='".$user_id."', user_email='".$user_email."' , is_blocked='y' , login_status='0' , otp_status='1', deleted_at='".$deleted_at."' where user_id='".$uid."' ";//and ulbid='".$ulbid."'
			
			//echo json_encode($sql); 
			
			mysqli_query($conn,$sql);
			
			$response['status_code'] = 200;
	      	$response['message'] = 'You have exited successfully!.';
		}
		else
		{
			$response['status_code'] = 100;
	      	$response['message'] = 'Invalid User';
		}
				
		if($_REQUEST['adminform']=='adminform'){
			session_destroy();
			session_start();
			$_SESSION['account_deleted']=$response['status_code'];
			$response['message'] = 'You have exited successfully!.';
						
		
			header('location:'.$base_url.'account-login.php');
			exit;
		}else{
			echo json_encode($response); 
		}
 	}
	
	function generateRandomString($length = 10) {
		//$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}

		return $randomString;
	}
	
	mysqli_close($conn);
?>
  