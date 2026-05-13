<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	$sql="select * from council_mst where ulbid='".$_REQUEST['ulbid']."' and cid='3'";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
				$data[]=array('id'=>$row['id'],'name'=>$row['name'],'mobile'=>$row['mobile'],'img_url'=>$row['img_url']);
			}
		}
		else
		{
			$data[] = array('dept_id'=>'0','name'=>'Data Not Available');
		}
	}
	else
	{
	$data[] = array('dept_id'=>'0','dept_desc'=>'Query not executed');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>