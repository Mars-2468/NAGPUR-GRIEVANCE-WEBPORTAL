<?php
ini_set('display_errors', 0);

	require_once('../connection.php');
	$conn=getconnection();
	//$_REQUEST['edition_no'] ='1';
	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	$baseurl ="http://egovmars.in/csms/media_coverages/";
	
	
	//$sql="select id,images from add_content_image where content_no='".$_REQUEST['content_no']."' order by id desc";
	
	// $sql="select ac.description,aci.images from add_content_media_coverage ac,add_content_image aci where ac.content_no=aci.content_no and aci.content_no='".$_REQUEST['content_no']."'";
	$sql="select id,ac.title,ac.content_no,ac.edition_date,aci.images,description from add_content_media_coverage ac left join add_content_image aci on ac.content_no=aci.content_no where ac.content_no='".$_REQUEST['content_no']."'";
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
		         $arr = explode('media_coverages',$row['images']);
				
				$file = $baseurl.$arr[1];
				$data[]=array('uniq_id'=>$row['id'],'description'=>$row['description'],'img_url'=>$file);
			}
		}
		else
			$data[0] = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available');
	}
	else
		$data[0] = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);
mysqli_close($conn);



?>