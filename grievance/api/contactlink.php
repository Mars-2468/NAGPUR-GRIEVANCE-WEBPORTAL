<?php
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	 $sql="SELECT comm_name,designation,mobile,officebuilding,address,link FROM  `comm_tab` where ulbid='".$_REQUEST['ulbid']."'";
	
	if($rs=mysqli_query($conn,$sql))
	{
		
		while($row = mysqli_fetch_assoc($rs))
		{
		
		if($row['file_url']=="")
		{
		$row['file_url']="http://municipalservices.in/comm_address/"."noimage.png";
		}
			$data[]=array('comm_name'=>$row['comm_name'],'designation'=>$row['designation'],'mobile'=>$row['mobile'],'photo'=>$row['officebuilding'],'address'=>$row['address'],'link'=>$row['link']);
			
		}
	}
	else
	 $data[0] = array('address'=>'No Data Available','link'=>'No Data Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>