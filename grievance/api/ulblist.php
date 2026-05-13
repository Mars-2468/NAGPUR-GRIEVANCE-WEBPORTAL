<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$response['ulblist']=array();
	
		$ulblist['ulbid']=0;
		$ulblist['ulbname']="Select Municipality";
		
	array_push($response["ulblist"], $ulblist);
	
	$sql = "Select u.*,ut.ulb_type_desc from ulbmst u,ulb_type ut where u.ulb_type=ut.ulb_type_id and u.distid = '".$_REQUEST['distid']."' and u.ulbid NOT IN('500') order by ulbname";
	$rs = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    $ulblist['ulbid']=$row['ulbid'];
		$ulblist['ulbname']=$row['ulbname']." ".$row['ulb_type_desc'];

	     $sql1 = "Select * from tanker_enable_mst  where ulbid = '".$row['ulbid']."'";
		 $rs1 = mysqli_query($conn, $sql1);
    	while($row1 = mysqli_fetch_assoc($rs1))
    	{
    	     $ulblist['tanker_status']= $row1['enable_status'];
    	}
    	
    	
		array_push($response["ulblist"], $ulblist);
	}
	
	
	
	echo json_encode($response);
	
	//$array = json_decode($json, true);
//echo htmlentities($array[10]['distnametelugu'], NULL, 'UTF-8');
mysqli_close($conn);

?>