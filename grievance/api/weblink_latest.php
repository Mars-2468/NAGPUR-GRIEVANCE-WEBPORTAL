<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	 $sql="SELECT * FROM  `website_mst` where ulbid='".$_REQUEST['ulbid']."'";
	 $rs=mysqli_query($conn,$sql);
	 $nr =  mysqli_num_rows($rs);
	
	if($nr > 0)
	{
	    
	    
		
		$row = mysqli_fetch_assoc($rs);
		
		
			$response = array('status_code' => 200,'message' => 'success','website'=>$row['website']);
			
			
		
	}
	else
	 $response = array('status_code' => 100,'message' => 'fail');
		
		
	



echo json_encode($response);

mysqli_close($conn);


?>