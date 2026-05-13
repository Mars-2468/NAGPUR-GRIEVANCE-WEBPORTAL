<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	 $sql="SELECT * FROM  `social_connect` where ulbid='".$_REQUEST['ulbid']."'";
	
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs) > 0)
		{
		    
		    
        		    $response['status_code'] = 200;
                	$response['status_msg'] = 'success';
                	    
                	 $response['data'] = array(); 
        		while($row = mysqli_fetch_assoc($rs))
        		{
        			$data=array('fb_link'=>$row['fb_link'],'twitter_link'=>$row['twitter_link']);
        			
        		}
	      }
	    else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			$data = array('dept_id'=>'0','description'=>'No Data Available');
		}
		
		array_push($response['data'],$data);
	
	
	}
	else
	 $data[0] = array('fb_link'=>'No Data Available','twitter_link'=>'No Data Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>