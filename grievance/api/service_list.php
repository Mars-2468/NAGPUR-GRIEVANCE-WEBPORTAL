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
	  $sql ="select cs_id,comp_desc,telugu_description from category3_mst where ulbid='".$_REQUEST['ulbid']."' and dept_id='".$_REQUEST['dept_id']."'";
	
	if($rs=mysqli_query($conn,$sql))
	{
	
		while($row = mysqli_fetch_assoc($rs))
		{
		   if($langId==1){
		    	$data[]=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['comp_desc']);   
		   }else{
		       	$data[]=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['telugu_description']);
		   }
		
		}
	}
	else
	{
		$data[0] = array('cs_id'=>'0','cs_desc'=>'Service Not Available');
	}
		
	
	$indexedOnly = array();
	//print_r($data);

/*foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}*/

/*foreach($data as $v) {
    $output[key($v)] = current($v);
}
echo json_encode($output);*/

echo json_encode($data);
mysqli_close($conn);



?>