<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	$langId = $_REQUEST['lang_id'];
	require_once('check_version.php');
	
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
	
	 $sql="select cat.cat_id,description,cat.telugu_description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag='1' and cu.ulbid='".$_REQUEST['ulbid']."' group by cat.cat_id order by sort_order";
	
	$data[0] = array('cat_id'=>'0','description'=>'--- select ---');
	if($rs=mysqli_query($conn,$sql))
	{
		$i=1;
		while($row = mysqli_fetch_assoc($rs))
		{
		  //  $data[]=array('cat_id'=>$row['cat_id'],'description'=>$row['description']."/".$row['telugu_description']);
		    if($langId==1){
			$data[]=array('cat_id'=>$row['cat_id'],'description'=>$row['description']);
		    }else{
		     $data[]=array('cat_id'=>$row['cat_id'],'description'=>$row['telugu_description']);   
		    }
			$i++;
		}
	}
	
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);
mysqli_close($conn);



?>