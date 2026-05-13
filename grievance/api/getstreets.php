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
	$data1=array('street_id'=>0,'street_desc'=>'Select Street');
	 $sql="select street_id,street_desc,street_desc_marathi FROM street_mst WHERE ward_id=".$_REQUEST['ward_id']." and ulbid='".$_REQUEST['ulbid']."' ORDER BY street_desc";
	//$fp=fopen('test.txt','a');
	//fwrite($fp,$sql);
	//fclose($fp);
	if($rs=mysqli_query($conn,$sql))
	{
	    
	    if(mysqli_num_rows($rs) > 0)
	    {
    	    
        	        $response['status_code'] = 200;
                    $response['status_msg'] = 'success';
                    $response['data'] = array();
                    
                     array_push($response['data'],$data1);
    	    
    	    
            		while($row = mysqli_fetch_assoc($rs))
            		{
            				if($langId==1){
            				    $data=array('street_id'=>$row['street_id'],'street_desc'=>$row['street_desc']);
            				}else{
            				    $data=array('street_id'=>$row['street_id'],'street_desc'=>$row['street_desc_marathi']);
            				}
            			//$data[$row['street_id']]['street_id'] = $row['street_id'];
            			//$data[$row['street_id']]['street_desc'] = $row['street_desc'];
            			
            			
            			array_push($response['data'],$data);
            			
            			
            		}
	    }
	
    	else
    	{ 
    	    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
    		$data = array('street_id'=>'0','street_desc'=>'No Streets Available');
    	}
    	
	}
	
	
	
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>