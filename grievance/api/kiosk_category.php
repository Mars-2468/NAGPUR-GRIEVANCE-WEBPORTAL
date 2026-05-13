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
	    $langId=$_REQUEST['lang_id'];
	$data[]=array('cat_id'=>0,'description'=>'select category');
	 $sql="select cat.cat_id,description,cat.marati_description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag='1' and cu.ulbid='".$_REQUEST['ulbid']."' group by cat.cat_id";
	
	
	if($rs=mysqli_query($conn,$sql))
	{
		$i=1;
		while($row = mysqli_fetch_assoc($rs))
		{
			$data[]=array('cat_id'=>$row['cat_id'],'description'=>$row['description']."/".$row['marati_description']);
			$i++;
		}
	}
	else
		$data[0] = array('id'=>'0','desc'=>'-');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);
mysqli_close($conn);



?>