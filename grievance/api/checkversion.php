<?php
 error_reporting(0);
	
	require_once('../connection.php');
	$conn=getconnection();
	
	$apk_version = $_REQUEST['apk_version'];
	$ulbid = $_REQUEST['ulbid'];
	
	
 	$sql="SELECT * FROM  api_version WHERE version=".$apk_version;
 	$rs = mysqli_query($conn,$sql);
 	$nr = mysqli_num_rows($rs);
 	if($nr>0)
 	{
		
		$data['status_code'] = 200;
 		$data['status_message'] = 'Successfull';
		echo json_encode($data);
 		exit;

		
 	}
 	else{
 		$data['status_code'] = 350;
 		$data['status_message'] = 'Update Your Version';
		echo json_encode($data);
 		exit;

 	}

?>