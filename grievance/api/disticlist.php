<?php

require_once('../connection.php');
	$conn=getconnection();
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET names=utf8');
    mysqli_query($conn,'SET character_set_client=utf8');
    mysqli_query($conn,'SET character_set_connection=utf8');
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET collation_connection=utf8_general_ci');
    
    
	ini_set('display_errors', 0);
	$response['distic']=array();
	
		$distic['distid']=0;
		$distic['distname']="Select District";
		$distic['rdma']=0;
	array_push($response["distic"], $distic);
	$langId=$_REQUEST['lang_id'];
	$sql = "Select * from Districtmst order by distname";
	$rs = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($rs))
	{
		$distic['distid']=$row['distid'];
		if($langId==1){
		$distic['distname']=$row['distname'];
	}else{
	    $distic['distname']=$row['distnametelugu'];
	}
		$distic['rdma']=$row['rdma'];
		//$distic['distnametelugu']=$row['distnametelugu'];
		array_push($response["distic"], $distic);
	}
	echo json_encode($response);
	
	//$array = json_decode($json, true);
//echo htmlentities($array[10]['distnametelugu'], NULL, 'UTF-8');
mysqli_close($conn);

?>