<?php
ini_set('display_errors', 0);
require_once('../connection.php');
//require_once('../send_sms.php');
//require_once('../sms_conf.php');

$conn = getconnection();
mysqli_set_charset($conn, 'utf8');

date_default_timezone_set('Asia/Calcutta');

header("Content-Type: application/json");

	
	//var_dump($_REQUEST['adminform']);die();
	
  	if(isset($_REQUEST['user_id']))
  	{
  		$uid= $_REQUEST['user_id'];
  		$ulbid= $_REQUEST['ulbid'];
  		
  	
		$sql = "select * from users_test where user_id='".$uid."' ";//and ulbid='".$ulbid."'
	  	$res = mysqli_query($conn,$sql);
		//$res2=$res;
		$row=mysqli_fetch_array($res);
		
		$nr = mysqli_num_rows($res);
		
		
		if($nr > 0 )
		{
			$user_id=$row['user_id'].generateRandomString();
			$user_email=$row['user_email'].generateRandomString();
			$deleted_at = date('Y-m-d H:i:s');
			
		    $sql ="update users_test set user_id='".$user_id."', user_email='".$user_email."' , is_blocked='y' , login_status='0' , otp_status='1', deleted_at='".$deleted_at."' where user_id='".$uid."' ";//and ulbid='".$ulbid."'
			
			//echo json_encode($sql); 
			
			mysqli_query($conn,$sql);
			
			$response['status_code'] = 200;
	      	$response['message'] = 'You have exited successfully!.';
			echo json_encode($response); 
		}
		else
		{
			$response['status_code'] = 100;
	      	$response['message'] = 'Invalid User';
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
  