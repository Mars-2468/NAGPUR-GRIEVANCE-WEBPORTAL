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
	
	$sql="select * from notification_mst where ulbid='".$_REQUEST['ulbid']."' order by ts DESC";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	   
	    
		if(mysqli_num_rows($rs) > 0)
		{
		    
		    
		    $response['status_code'] = 200;
        	$response['status_msg'] = 'success';
        	    
        	 $response['data'] = array();    
        	    
        	    
        	    
		    
			while($row = mysqli_fetch_assoc($rs))
			{
			    if($row['photo']!='')
			    {
			        $image=$row['photo'];
			    }else{
			        $image='http://egovmars.in/No-image-found.jpg';
			    }
				$data=array('id'=>$row['id'],'date'=>date('d-m-Y',strtotime($row['date'])),'time'=>$row['time'],'description'=>strip_tags($row['description']),'image'=>$image);
			
			    array_push($response['data'],$data);
			    
			}
		}
		else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			$data = array('dept_id'=>'0','description'=>'No Data Available');
		}
		
		
		
	}
	
	else
	{
	      
        	     $response['status_code'] = '100';
                 $response['status_msg'] = 'Failure';
        	    
        	
	    $data = array('dept_id'=>'0','dept_desc'=>'Query not executed');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

	 

echo json_encode($response);

mysqli_close($conn);


?>