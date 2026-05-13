<?php
	error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET names=utf8');
    mysqli_query($conn,'SET character_set_client=utf8');
    mysqli_query($conn,'SET character_set_connection=utf8');
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
	$response['designations']=array();
	$langId=$_REQUEST['lang_id'];
	$sql = "Select id,designation,designation_marathi,mobile from council_mst where ulbid='".$_REQUEST['ulbid']."' and ward_id='0' and cid='1'";
	$rs = mysqli_query($conn, $sql);
	if(mysqli_num_rows($rs) > 0)
	{
		while($row = mysqli_fetch_assoc($rs))
		{
		    if($langId==1){
			    $distic['designation']=$row['designation'];
		    }else{
		        $distic['designation']=$row['designation_marathi'];
		    }
			    $distic['mobile']=$row['id']."-".$row['mobile'];
			
			array_push($response["designations"], $distic);
		}
	}
	else
	{
		$distic['designation']="Not available";
		$distic['mobile']="Not available";
		array_push($response["designations"], $distic);
		
	}
	echo json_encode($response);
	
	//$array = json_decode($json, true);
//echo htmlentities($array[10]['distnametelugu'], NULL, 'UTF-8');
mysqli_close($conn);

?>