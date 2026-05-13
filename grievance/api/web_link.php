<?php
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	 $sql="SELECT * FROM  `website_mst` where ulbid='".$_REQUEST['ulbid']."'";
	
	if($rs=mysqli_query($conn,$sql))
	{
	    
	    if(mysqli_num_rows($rs) > 0)
		{
		    
		    
        		    $response['status_code'] = 200;
                	$response['status_msg'] = 'success';
                	    
                	 $response['data'] = array();  
        		
        		while($row = mysqli_fetch_assoc($rs))
        		{
        			$data=array('website'=>$row['website']);
        			
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