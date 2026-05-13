<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$sql ="select ulb_type from ulbmst where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($rs);
	$ulbtype=$row['ulb_type'];
	if($ulbtype=='1')
	{
		$ward="Select Division";
	}
	else
	{
	$ward="Select Ward";
	}
	
	$data[]=array('ward_id'=>"0",'ward_desc'=>$ward);
	
	if($_REQUEST['ulbid']=='095'){
	 $sql="select * from ward_mst where ulbid='".$_REQUEST['ulbid']."' order by sort_order asc";
		    }else{
	$sql="select ward_id,ward_desc from ward_mst where ulbid='".$_REQUEST['ulbid']."' GROUP BY ward_desc order by ward_id ASC";
		    }
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
				$data[]=array('ward_id'=>$row['ward_id'],'ward_desc'=>$row['ward_desc']);
			}
		}
		else
		{
			$data[] = array('ward_id'=>'0','ward_desc'=>'No Data Available');
		}
	}
	else
	{
	$data[] = array('ward_id'=>'0','ward_desc'=>'Query not executed');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>