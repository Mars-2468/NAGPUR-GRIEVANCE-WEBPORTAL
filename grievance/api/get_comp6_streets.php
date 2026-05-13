<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$data[]=array('street_id'=>"0",'street_desc'=>'Select Street');
	 $sql="select street_id,street_desc FROM street_mst WHERE ward_id=".$_REQUEST['ward_id']." and ulbid='".$_REQUEST['ulbid']."' ORDER BY street_desc";
	//$fp=fopen('test.txt','a');
	//fwrite($fp,$sql);
//	fclose($fp);
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
		{
			$data[]=array('street_id'=>$row['street_id'],'street_desc'=>$row['street_desc']);
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