<?php
ini_set('display_errors', 0);
	require_once('../connection.php');
	$conn=getconnection();
	
	 $sql="SELECT * FROM  `website_mst` where ulbid='".$_REQUEST['ulbid']."'";
	
	if($rs=mysqli_query($conn,$sql))
	{
		
		while($row = mysqli_fetch_assoc($rs))
		{
			$data[]=array('website'=>$row['website']);
			
		}
	}
	else
	 $data[0] = array('fb_link'=>'No Data Available','twitter_link'=>'No Data Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>