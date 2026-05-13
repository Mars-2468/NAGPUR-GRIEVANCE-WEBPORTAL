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
        $langId=$_REQUEST['lang_id'];
	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	  $sql ="select cs_id,comp_desc from category3_mst where ulbid='".$_REQUEST['ulbid']."' and dept_id='".$_REQUEST['dept_id']."'";
	
	if($rs=mysqli_query($conn,$sql))
	{
	
	    if(mysqli_num_rows($rs)>0)
	    {
	      
	        $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            $response['data'] = array();
	      
	      
	      
	
		while($row = mysqli_fetch_assoc($rs))
		{
		
		if($langId==1){
		    $data=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['comp_desc']);
		}else{
		    $data=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['telugu_description']); 
		}	
			
			array_push($response['data'],$data);
		}
	}
	else
	{
	    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
		$data = array('cs_id'=>'0','cs_desc'=>'Service Not Available');
		
		array_push($response['data'],$data);
		
		
	}
	
	
	
	
	}
	else
	{
	    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
		$data = array('cs_id'=>'0','cs_desc'=>'Service Not Available');
		
		array_push($response['data'],$data);
		
	}
		
	
	$indexedOnly = array();
	

echo json_encode($response);
mysqli_close($conn);



?>