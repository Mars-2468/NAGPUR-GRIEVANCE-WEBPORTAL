<?php
	error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
  	if(isset($_REQUEST['user_id']))
  	{
  		$uid= $_REQUEST['user_id'];
  		$password= $_REQUEST['password'];		
		$sql = "select emp_id,user_type from users where user_id='".$uid."' and user_pwd=PASSWORD('".$password."')";
	  	$res = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($res);
		if($nr > 0 )
		{
			while($row = mysqli_fetch_array($res))
			{
			     	$response['status_code'] = 200;
			      	$response['message'] = 'Valid details';
			      	$response['emp_id'] = $row[0];
			      	$response['user_type'] = $row[1];
			}
		}
		else
		{
			$response['status_code'] = 100;
			$response['emp_id'] = 0;
		      	$response['message'] = 'Incorrect Password';
		}
		echo json_encode($response); 
 	}
	mysqli_close($conn);
?>
  