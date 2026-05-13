<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	$sql ="select cat_id,cat_desc from form_cat";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	$cat_list[$row['cat_id']]=$row['cat_desc'];
	$data[$row['cat_desc']]=array();
	}
	
	$sql="select * from form_sub_cat where ulbid='".$_REQUEST['ulbid']."'";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
		{
			$stuff= array();
			$stuff['sub_cat_desc']=$row['sub_cat_desc'];
			$stuff['file_url']=$row['file_url'];
			array_push($data[$cat_list[$row['cat_id']]], $stuff);
		
			//$data[$cat_list[$row['cat_id']]]=array('sub_cat_desc'=>$row['sub_cat_desc'],'file_url'=>$row['file_url']);
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