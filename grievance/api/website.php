<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	
	$sql = "Select * from website_mst where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($rs))
	{
		$data[]=array('website'=>$row['website']);
	}
	echo json_encode($data);
	
	//$array = json_decode($json, true);
//echo htmlentities($array[10]['distnametelugu'], NULL, 'UTF-8');
mysqli_close($conn);

?>