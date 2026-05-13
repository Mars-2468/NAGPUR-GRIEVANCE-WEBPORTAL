<?php
 ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
	$langId==$_REQUEST['lang_id'];
	//echo $langId;
	$sql="select cat.cat_id,description,cat.telugu_description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag='1' and cu.ulbid='".$_REQUEST['ulbid']."' group by cat.cat_id";
	$rs=mysqli_query($conn,$sql);
	
	if(mysqli_num_rows($rs) > 0)
	{
		$i=1;
		$response=array('status_code'=>200,'message'=>'success');
		$response['data']=array();
		while($row = mysqli_fetch_assoc($rs))
		{
            if($langId==1){
                $data=array('cat_id'=>$row['cat_id'],'description'=>$row['description']);
            }else{
                $data=array('cat_id'=>$row['cat_id'],'telugu_description'=>$row['telugu_description']);
            }
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