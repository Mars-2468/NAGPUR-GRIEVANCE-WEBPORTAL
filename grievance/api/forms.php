<?php

	require_once('../connection.php');
	$conn=getconnection();
	
	mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET names=utf8');
mysqli_query($conn,'SET character_set_client=utf8');
mysqli_query($conn,'SET character_set_connection=utf8');
mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET collation_connection=utf8_general_ci');

	$apk_version = $_REQUEST['apk_version'];
	$langId=$_REQUEST['lang_id'];
	require_once('check_version.php');
	
	ini_set('display_errors', 0);
	$sql ="select cat_id,cat_desc from form_cat";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	$cat_list[$row['cat_id']]=$row['cat_desc'];
	$data[$row['cat_desc']]=array();
	
	$sql="select * from form_sub_cat where ulbid='".$_REQUEST['ulbid']."' and cat_id='".$row['cat_id']."'";
	$rs2=mysqli_query($conn,$sql);
	$nr = mysqli_num_rows($rs2);
	
	if($nr > 0)
	{
		while($row2 = mysqli_fetch_assoc($rs2))
		{
			$stuff= array();
			if($langId==1){
			$stuff['sub_cat_desc']=$row2['sub_cat_desc'];
			}else{
			   $stuff['sub_cat_desc']=$row2['sub_cat_desc_marathi']; 
			}
			$stuff['file_url']=$row2['file_url'];
			
			array_push($data[$row['cat_desc']], $stuff);
		
			//$data[$cat_list[$row['cat_id']]]=array('sub_cat_desc'=>$row['sub_cat_desc'],'file_url'=>$row['file_url']);
		}
	}
	else{
			$stuff= array();
			$stuff['sub_cat_desc']='';
			$stuff['file_url']='';
			array_push($data[$row['cat_desc']], $stuff);
	}
	}
	//print_r($cat_list);
	
	
		
		
		
	$indexedOnly = array();
	

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>