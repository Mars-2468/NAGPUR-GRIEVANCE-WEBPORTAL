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
	
	 $sql="select ac.title,ac.content_no,ac.edition_date,aci.images from add_content_media_coverage ac,add_content_image aci where ac.content_no=aci.content_no and ac.ulbid='".$_REQUEST['ulbid']."' group by content_no order by ac.edition_date DESC";
	 
	 	$rs = mysqli_query($conn, $sql);
	
		if(mysqli_num_rows($rs) > 0)
		{
		    
		    
		    $response['status_code'] = 200;
        	$response['status_msg'] = 'success';
        	    
        	 $response['data'] = array();  
		    
		    
			$i=1;
			
			while($row = mysqli_fetch_assoc($rs))
			{
				
				$data=array('sno'=>$i,'title'=>$row['title'],'content_no'=>$row['content_no'],'edition_date'=>date("d-m-Y",strtotime($row['edition_date'])),'file_url'=>$row['images']);
				$i++;
			}
		}
		
		
		else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			$data = array('dept_id'=>'0','description'=>'No Data Available');
		}
		
		array_push($response['data'],$data);
		
		
		
	//else
	 //$data[0] = array('status_code'=>'201','status_desc'=>'Data not available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>