<?php
ini_set('display_errors', 0);
	require_once('../connection.php');
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$sql ="select enable_status from tanker_enable_mst where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($rs);
	$status=$row['enable_status'];
	
	
	if($status=='1')
	{
		
		$data = array('status_code'=>'200','status_desc'=>'Proceed to request form');
		
	}
	else
	{
		$data = array('status_code'=>'201','status_desc'=>'This Service is not available for this Municipality');
	}
		
	echo json_encode($data);

mysqli_close($conn);
?>