<?php
ini_set('display_errors', 0);
	require_once('../connection.php');
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$sql="insert into complaint_types_mst
    (type_id, user_id, description) values('".$_REQUEST['type_id']."','".$_REQUEST['user_id']."','".$_REQUEST['description']."')";
	
	
	//echo $sql;
	
	if(mysqli_query($conn,$sql))
	{
		$data = array('status_code'=>'200','status_desc'=>'complaint sent Successfully');
		
	}
	else
		$data = array('status_code'=>'201','status_desc'=>'Please Try again');
	
	header("Content-type:application/json");	
	echo json_encode($data);
    mysqli_close($conn);

?>