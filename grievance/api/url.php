<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	if($_REQUEST['ulbid']!='')
	{
        	
        	
        	$sql = "select * from ulb_url where ulbid = '".$_REQUEST['ulbid']."' " ;
        	$rs = mysqli_query($conn,$sql);
        	
        	if($rs)
        	{
        	
                	    $response['status_code'] = '200';
                	    $response['message'] = 'success';
                	    
                	    
                	    
                	    $response['data'] = array();
                	
                	
                	while($row = mysqli_fetch_assoc($rs))
                	{
                	    
                	    
                	    $data['url_type'] = $row['url_type'];
                	    $data['url']  = $row['url'];
                	    $data['id'] = $row['id'];
                	    
                	    
                	    array_push($response['data'],$data);
                	    
                	    
                	    
                	}
                	
        	}
        	
        	else
        	{
        	    
        	     $response['status_code'] = '100';
                 $response['message'] = 'Failure/No data';
        	    
        	}
                	
        	    
        	
        	
	}
	
	
	
	
/*	$sql="select description FROM about_municipality WHERE ulbid='".$_REQUEST['ulbid']."'";
	$rs=mysqli_query($conn,$sql);
	
	if(mysqli_num_rows($rs) > 0)
	{
		while($row = mysqli_fetch_assoc($rs))
		{
			//$data['description']=$row['description'];
			$data['description']=str_replace("&nbsp;", " ",strip_tags($row['description']));
		}
	}
	else
		$data[] = array('error_code'=>'201','message'=>'No Data Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}
*/




echo json_encode($response);




?>