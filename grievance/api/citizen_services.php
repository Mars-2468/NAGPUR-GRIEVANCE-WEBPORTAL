<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	
	$langId=$_REQUEST['lang_id'];
	$sql="select comp_desc as service_name,cutt_of_time as working_days from category3_mst where ulbid='".$_REQUEST['ulbid']."' and cs_type_id='2' order by working_days ASC";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
		{
			$data[]=array('service_name'=>$row['service_name'],'working_days'=>$row['working_days']);
		}
	}
	else
		$data[0] = array('service_name'=>'0','working_days'=>'No Data Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);
mysqli_close($conn);



?>