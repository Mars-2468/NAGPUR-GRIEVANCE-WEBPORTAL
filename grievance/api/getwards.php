<?php
ini_set('display_errors',0);
	require_once('../connection.php');
	require_once('../check_access_key.php');
	$conn=getconnection();
	mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET names=utf8');
        mysqli_query($conn,'SET character_set_client=utf8');
        mysqli_query($conn,'SET character_set_connection=utf8');
        mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET collation_connection=utf8_general_ci');
        
    header("Content-Type: application/json");


	if($_REQUEST['access_key'] != ''){
      $check_access_key_status = ($access_key == $_REQUEST['access_key']) ?  1 : 0;

        if($check_access_key_status != 1){
        $response['status_code'] = 401;
          $response['message'] = 'unauthorized';
          echo json_encode($response);
          die;
        }
    }else{
        $response['status_code'] = 422;
        $response['message'] = 'Missing Access key';
        echo json_encode($response);
        die;
    }
    
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
	
	$data1=array('ward_id'=>0,'ward_desc'=>$ward);
	
	
	 $sql="select ward_id,ward_desc,wards_marathi from ward_mst where ulbid='".$_REQUEST['ulbid']."' order by ward_id";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
		    
		    $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            
            $response['data'] = array();
		    
		    array_push($response['data'],$data1);
		    
			while($rows = mysqli_fetch_assoc($rs))
			{
			   if($langId==1){ 
				     $data=array('ward_id'=>$rows['ward_id'],'ward_desc'=>$rows['ward_desc']);
			   }else{
			    	$data=array('ward_id'=>$rows['ward_id'],'ward_desc'=>$rows['wards_marathi']);   
			   }
		
				array_push($response['data'],$data);
				
				
			}
			
			
		}
		else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			$data = array('ward_id'=>'0','ward_desc'=>'No Data Available');
		}
		
		
		
	}
	else
	{
	    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
	$data = array('ward_id'=>'0','ward_desc'=>'Query not executed');
	}
	
	
	//array_push($response['data'],$data1);
		
	$indexedOnly = array();

foreach ($data as $rows) {
    $indexedOnly[] = array_values($rows);
}


//print_r($data);

echo json_encode($response);

mysqli_close($conn);


?>