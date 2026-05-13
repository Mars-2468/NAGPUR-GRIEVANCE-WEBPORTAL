<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');

	
	$sql ="select c.cs_id as sub_cat_id,c.cat_id,c.cs_desc as sub_desc from  cs_mst c,complaint_ulbmap cu where c.cs_id=cu.cs_id and cu.ulbid='".$_REQUEST['ulbid']."' and cu.flag='1' and c.cat_id='".$_REQUEST['cat_id']."'";
    $rs=mysqli_query($conn,$sql);
  
	if(mysqli_num_rows($rs) > 0)
	{
		$i=1;
		$response=array('status_code'=>200,'message'=>'success');
		$response['data']=array();
		while($row = mysqli_fetch_assoc($rs))
		{
			$data=array('sno'=>$i,'sub_cat_id'=>$row['sub_cat_id'],'cat_id'=>$row['cat_id'],'sub_desc'=>$row['sub_desc']."/".$row['marathi_description']);
			array_push($response['data'],$data);
			$i++;
		}
	}
	else
		$response=array('status_code'=>100,'message'=>'fail');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>