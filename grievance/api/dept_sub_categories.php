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
	//$_POST['cat_id'] =1;
	
	$langId=$_REQUEST['lang_id'];
	
	$sql ="SELECT * FROM `subcategory_mst` where cat_id='".$_REQUEST['cat_id']."'";
	//echo $sql;
	
	if($rs=mysqli_query($conn,$sql))
	{
		$i=1;
		while($row = mysqli_fetch_assoc($rs))
		{
		    if($langId==1){
			$data[]=array('sno'=>$i,'sub_cat_id'=>$row['sub_cat_id'],'cat_id'=>$row['cat_id'],'sub_desc'=>$row['description']);
		}else{
		    $data[]=array('sno'=>$i,'sub_cat_id'=>$row['sub_cat_id'],'cat_id'=>$row['cat_id'],'sub_desc'=>$row['description_marathi']);
		}
			
			$i++;
		}
	}
	else
		$data[0] = array('sub_cat_id'=>'0','cat_id'=>'-','sub_desc'=>'-');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>