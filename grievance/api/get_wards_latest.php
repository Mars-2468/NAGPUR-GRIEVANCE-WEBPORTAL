<?php
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET names=utf8');
mysqli_query($conn,'SET character_set_client=utf8');
mysqli_query($conn,'SET character_set_connection=utf8');
mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	$langId=$_REQUEST['lang_id'];
	$sql ="select ulb_type from ulbmst where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($rs);
	$ulbtype=$row['ulb_type'];
	if($ulbtype=='1')
	{
		$ward="Select Division";
	}
	else
	{
	$ward="Select Ward";
	}
	
	    $response=array('status_code'=>200,'message'=>'success');
		$response['data']=array();
	
	$data=array('ward_id'=>0,'ward_desc'=>$ward);
	array_push($response['data'],$data);
	
	
	$sql="select ward_id,ward_desc,wards_marathi from ward_mst where ulbid='".$_REQUEST['ulbid']."' order by ward_id";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
			    if($langId==1){
				$data=array('ward_id'=>$row['ward_id'],'ward_desc'=>$row['ward_desc']);
			    }else{
			    $data=array('ward_id'=>$row['ward_id'],'ward_desc'=>$row['wards_marathi']);    
			    }
				array_push($response['data'],$data);
			}
		}
		else
		{
			$data[] = array('ward_id'=>'0','ward_desc'=>'No Data Available');
		}
	}
	else
	{
	$data[] = array('ward_id'=>'0','ward_desc'=>'Query not executed');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>