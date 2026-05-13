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
	
	//$sql="select id,images from add_content_image where content_no='".$_REQUEST['content_no']."' order by id desc";
	
	  $sql="select description,description_marathi,img_url from add_content  where edition_no='".$_REQUEST['edition_no']."'";
	
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
				$data=array('uniq_id'=>$row['id'],'description'=>$row['description'],'img_url'=>$row['img_url']);
			}else{
			    $data=array('uniq_id'=>$row['id'],'description'=>$row['description_marathi'],'img_url'=>$row['img_url']);
			}
				
					array_push($response['data'],$data);
				
			}
		}
		else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			$data = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available');
			
				array_push($response['data'],$data);
	
		}
		
		
	
		
		}
	else
	{
	    $response['status_code'] = '100';
        $response['status_msg'] = 'No data Found';
		$data = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available');
	}	
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>