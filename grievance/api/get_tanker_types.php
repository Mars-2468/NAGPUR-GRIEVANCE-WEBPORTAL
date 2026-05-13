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
	
	$sql ="select ulb_type from ulbmst where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($rs);
	$ulbtype=$row['ulb_type'];

	
	$data[]=array('tanker_type_id'=>0,'tanker_type_desc'=>'--- select tanker type----');
	
	
	
	$sql="SELECT * FROM `tanker_type_mst` where ulbid='".$_REQUEST['ulbid']."'";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
			    if($langId==1){
				$data[]=array('tanker_type_id'=>$row['tanker_type_id'],'tanker_type_desc'=>$row['tanker_type_desc']);
			    }else{
			    $data[]=array('tanker_type_id'=>$row['tanker_type_id'],'tanker_type_desc'=>$row['tanker_type_desc_marathi']);    
			    }
			}
		}
		else
		{
			$data[] = array('tanker_type_id'=>'0','tanker_type_desc'=>'No Data Available');
		}
	}
	else
	{
	$data[] = array('tanker_type_id'=>'0','tanker_type_desc'=>'Query not executed');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);



?>