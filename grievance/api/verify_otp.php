<?php
	error_reporting(0);
	require_once('../connection.php');
	require_once('../check_access_key.php');
	$conn = getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	date_default_timezone_set('Asia/Calcutta');
	
    header("Content-Type: application/json");


	if($_REQUEST['access_key'] != ''){
      $check_access_key_status = ($access_key == $_REQUEST['access_key']) ?  1 : 0;

        if($check_access_key_status != 1){
        $response['status_code'] = 401;
          $response['message'] = 'unauthorized';
          echo json_encode($response);
          die;
        }
    }else{
        $response['status_code'] = 422;
        $response['message'] = 'Missing Access key';
        echo json_encode($response);
        die;
    }
	
  	if(!empty($_REQUEST['otp']) && !empty($_REQUEST['emailotp']))
  	{
  		$uid   = $_REQUEST['user_id'];
  		$ulbid = $_REQUEST['ulbid'];
  		$otp   = $_REQUEST['otp'];
  		$emailotp   = $_REQUEST['emailotp'];
  		
  			
     	$ulbsql="select * from ulbmst where  ulbid='".$_REQUEST['ulbid']."'";
		$ulbrs1=mysqli_query($conn,$ulbsql);
		
		
		//$sql = "select * from users_test where user_id='".$uid."'  and ulbid ='".$_REQUEST['ulbid']."' and login_status='2'";
		
		$sql = "select * from users_test where user_id='".$uid."' and login_status='2'";
		$rs = mysqli_query($conn,$sql);
		$nr  = mysqli_num_rows($rs);
		
		if($nr > 0)
		{
		    $otp   = $_REQUEST['otp'];
  		    $emailotp   = $_REQUEST['otp'];
		}
		
		
		
		$sql = "select * from users_test where user_id='".$uid."'  and otp='".$otp."' and otp_status='1'";
	  	$res = mysqli_query($conn,$sql);
		$nr  = mysqli_num_rows($res);
		$error = 0;
		if($nr <= 0)
		{
		    $error++;
		    $response['status_code'] = 100;
	      	$response['message'] = 'Invalid Mobile Otp';
		}
		
		$sql = "select * from users_test where user_id='".$uid."'  and otp_status='1' and emailOtp='".$emailotp."'";
	  	$res = mysqli_query($conn,$sql);
		$nr2  = mysqli_num_rows($res);
		
		if($nr2 <= 0)
		{
		    $error++;
		    $response['status_code'] = 100;
	      	$response['message'] = 'Invalid Email Otp';
		}
		
		
		if($error==0)
		{
		
		
		    $updateuser="update users_test set otp='".$otp."',otp_status=2,login_status='2' where user_id='".$_REQUEST["user_id"]."'";
            $updateres = mysqli_query($conn,$updateuser);
			while($row = mysqli_fetch_array($res))
			{
			     	$response['status_code'] = 200;
			      	$response['message']     = 'Successfully Login';
			      	$response['user_id']     = $row['user_id'];
			      	$response['user_type']   = $row['user_type'];
			      	$response['otp_status']  = 2;
			      	$response['ulbid']       = $row['ulbid'];
			      	$response['username']       = $row['user_name'];
			}
		}
		else
		{
		    if($error==2)
		    {
		       $response['status_code'] = 100;
	      	   $response['message'] = 'Invalid Email and Mobile Otp'; 
		    }
		}
		
		 
 	}
 	else
 	{
 	    $response['status_code'] = 100;
	    $response['message'] = 'Please enter email and mobile otp';
 	}
 	 header("Content-Type: application/json");
 	echo json_encode($response);
	mysqli_close($conn);
?>
  