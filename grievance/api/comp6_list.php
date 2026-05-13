<?php
ini_set('display_errors', 0);

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
	
	$sql ="select c.cs_id,c.chbot_comp_desc as comp_desc,c.chbot_comp_mr_desc from  cs_mst c,complaint_ulbmap cu where c.cs_id=cu.cs_id and cu.ulbid='".$_REQUEST['ulbid']."' and c.cs_id in(4,11,12,23,27,60) and cu.flag='1'";
	
	$data[]=array(''=>0,'cs_desc'=>'Select Complaint');
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
		{
			$data[]=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['comp_desc']."/".$row['chbot_comp_mr_desc']);
		}
	}
	else
		$data[0] = array('cs_id'=>'0','cs_desc'=>'No Complaints Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);
mysqli_close($conn);



?>