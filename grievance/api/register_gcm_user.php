<?php
	ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	date_default_timezone_set('Asia/Calcutta');
			
	if (isset($_REQUEST["regId"]))
	{ 
		$sql1="select * from gcm_users where gcm_regid='".$_REQUEST["regId"]."' and ulbid='".$_REQUEST['ulbId']."'";
		$rs1=mysqli_query($conn,$sql1);
		if(mysqli_num_rows($rs1)==0)
		{
			$sql="INSERT INTO gcm_users(gcm_regid,server_key, created_at,ulbid,mobile) VALUES('".$_REQUEST["regId"]."','".$_REQUEST['server_key']."',
			'".date("Y-m-d H:i:s")."','".$_REQUEST['ulbId']."','".$_REQUEST['mobile']."')";
			if(mysqli_query($conn,$sql))
			{
				$response=array('status_code'=>200,'msg'=>'Registration Completed',"version"=>"1.1");
			}
			else
			{    
				$response=array('status_code'=>1099,'msg'=>"Try Again","version"=>"1.1");
			}
		}
		else
		{    
			$response=array('status_code'=>1099,'msg'=>"Already Registered","version"=>"1.1");
		}
	}
	else
	{    
		$response=array('status_code'=>1099,'msg'=>"regId Missing","version"=>"1.1");
	}
	
	$encoded = json_encode ($response);
	header ('Content-type: application/json');
	exit ($encoded);

?>	