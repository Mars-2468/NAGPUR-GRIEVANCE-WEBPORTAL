<?php
ini_set('display_errors', 0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	 $sql="SELECT * FROM  `social_connect` where ulbid='".$_REQUEST['ulbid']."'";
	
	if($rs=mysqli_query($conn,$sql))
	{
		
		while($row = mysqli_fetch_assoc($rs))
		{
			$data[]=array('fb_link'=>$row['fb_link'],'twitter_link'=>$row['twitter_link']);
			
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