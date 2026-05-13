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

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$data[]=array('street_id'=>"0",'street_desc'=>'Select Street');
	 $sql="select street_id,street_desc,street_desc_marathi,wards_marathi FROM street_mst WHERE ward_id=".$_REQUEST['ward_id']." and ulbid='".$_REQUEST['ulbid']."' ORDER BY street_desc";
	//$fp=fopen('test.txt','a');
	//fwrite($fp,$sql);
//	fclose($fp);
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
		{
			if($langId==1){
			$data[]=array('street_id'=>$row['street_id'],'street_desc'=>$row['street_desc']);
			}else{
			$data[]=array('street_id'=>$row['street_id'],'street_desc'=>$row['street_desc_marathi']); 
			}
		}
	}
	else
		$data[0] = array('street_id'=>'0','street_desc'=>'No Streets Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>