<?php
	error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
  	if(isset($_REQUEST['user_id']))
  	{
  		$uid= $_REQUEST['user_id'];
  		$ulbid= $_REQUEST['ulbid'];
  		
  	
		$sql = "select * from users_test where user_id='".$uid."' ";//and ulbid='".$ulbid."'
	  	$res = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($res);
		if($nr > 0 )
		{
		    $sql ="update users_test set login_status='2',otp_status='1' where user_id='".$uid."' ";//and ulbid='".$ulbid."'
			mysqli_query($conn,$sql);
			
			$response['status_code'] = 200;
	      	$response['message'] = 'Logged Out';
		}
		else
		{
			$response['status_code'] = 100;
	      	$response['message'] = 'Invalid User';
		}
		echo json_encode($response); 
 	}
	mysqli_close($conn);
?>
  