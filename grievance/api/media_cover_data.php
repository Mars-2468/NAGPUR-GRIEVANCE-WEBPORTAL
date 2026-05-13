<?php
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	//$_REQUEST['edition_no'] ='1';
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
	
	//$sql="select id,images from add_content_image where content_no='".$_REQUEST['content_no']."' order by id desc";
	
	 $sql="select ac.description,aci.images from add_content_media_coverage ac,add_content_image aci where ac.content_no=aci.content_no and aci.content_no='".$_REQUEST['content_no']."'";
	
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
		    
		    $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            $response['data'] = array();
		    
		    
		    
			while($row = mysqli_fetch_assoc($rs))
			{
				$data=array('uniq_id'=>$row['id'],'description'=>$row['description'],'img_url'=>$row['images']);
				
				
				array_push($response['data'],$data);
				
			}
		}
		else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			$data = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available');
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