<?php
	error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
  	if(isset($_REQUEST['user_id']) && isset($_REQUEST['old_password']) && isset($_REQUEST['new_password']))
  	{
  		$uid= $_REQUEST['user_id'];
  		$oldpassword= $_REQUEST['old_password'];
  		$newpassword= $_REQUEST['new_password'];
  		$sql1 = "SELECT * from users where user_id='".$uid."' and user_pwd=PASSWORD('".$oldpassword."')";
  		$rs1 = mysqli_query($conn,$sql1); 
  		if( mysqli_num_rows($rs1) == 1)		
	 	{
		 	$sql = "UPDATE users set user_pwd=PASSWORD('".$newpassword."'),show_pwd='".$newpassword."' where user_id='".$uid."' and user_pwd=PASSWORD('".$oldpassword."') ";
		//$rs = mysqli_query($conn,$sql);
		//print_r($rs);
		  	if(mysqli_query($conn,$sql))
			{
				$response['status_code'] = 200;
				$response['message'] = 'Password Changed';
				
			}
			else
			{
				$response['status_code'] = 100;
			      	$response['message'] = 'Password Not Change';
			}
		}
		else
		{
			$response['status_code'] = 100;
		      	$response['message'] = 'Password Not Change';
		}
		echo json_encode($response); 
 	}
	mysqli_close($conn);
?>
  