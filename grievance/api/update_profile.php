<?php
ini_set('display_errors', 0);
	require_once('../connection.php');
	$conn=getconnection();
	require_once('../check_access_key.php');
	date_default_timezone_set('Asia/Calcutta');

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	if($_REQUEST['access_key'] != ''){
      $check_access_key_status = ($access_key == $_REQUEST['access_key']) ?  1 : 0;

        if($check_access_key_status != 1){
        $response['status_code'] = 401;
          $response['message'] = 'unauthorized';
          header("Content-Type: application/json");
          echo json_encode($response);
          die;
        }
    }else{
        $response['status_code'] = 422;
        $response['message'] = 'Missing Access key';
        header("Content-Type: application/json");
        echo json_encode($response);
        die;
    }

	$sql="update users_test set user_name='".$_REQUEST["user_name"]."', user_email='".$_REQUEST["user_email"]."', age='".$_REQUEST["age"]."', address='".$_REQUEST["address"]."' where user_id='".$_REQUEST["user_id"]."' and ulbid='".$_REQUEST['ulbid']."'";
	
	
	
	//echo $sql;
	
	
	if(mysqli_query($conn,$sql))
	{
		
		$data = array('status_code'=>'200','status_desc'=>'profile updated Successfully');
		
	}
	else
		$data = array('status_code'=>'201','status_desc'=>'Please Try again');
		
	echo json_encode($data);
    mysqli_close($conn);

?>