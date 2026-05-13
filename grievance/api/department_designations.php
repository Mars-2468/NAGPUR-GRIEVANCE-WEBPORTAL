<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
	
	 $sql="SELECT * FROM `desg_mst` where dept_id='".$_REQUEST['dept_id']."'";
	
	$data[0] = array('desg_id'=>'0','desg_desc'=>'--- select ---');
	if($rs=mysqli_query($conn,$sql))
	{
		$i=1;
		while($row = mysqli_fetch_assoc($rs))
		{
			$data[]=array('desg_id'=>$row['desg_id'],'desg_desc'=>$row['desg_desc']);
			$i++;
		}
	}
	
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);
mysqli_close($conn);



?>