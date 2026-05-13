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
	$baseurl ="https://aurangabadmahapalika.org/csms/media_coverages/";
	
	 //$sql="select ac.title,ac.content_no,ac.edition_date,aci.images from add_content_media_coverage ac,add_content_image aci where ac.content_no=aci.content_no and ac.ulbid='".$_REQUEST['ulbid']."' group by content_no order by ac.edition_date DESC";
	 $sql="select ac.title,ac.content_no,ac.edition_date,aci.images from add_content_media_coverage ac left join add_content_image aci on ac.content_no=aci.content_no where ac.ulbid='".$_REQUEST['ulbid']."' group by content_no order by ac.edition_date DESC";
	 	$rs = mysqli_query($conn, $sql);
	 	
	
		if(mysqli_num_rows($rs) > 0)
		{
		    $data['status_code'] =200;
		    $data['status_desc'] ='Success';
		    $data['medialist'] = array();
		    
			$i=1;
			
			while($row = mysqli_fetch_assoc($rs))
			{
		
				$arr = explode('media_coverages',$row['images']);
				
				$file = $baseurl.$arr[1];
		
				array_push($data['medialist'],array('sno'=>$i,'title'=>$row['title'],'content_no'=>$row['content_no'],'edition_date'=>date("d-m-Y",strtotime($row['edition_date'])),'file_url'=>$file));
				//$data[]=array('sno'=>$i,'title'=>$row['title'],'content_no'=>$row['content_no'],'edition_date'=>date("d-m-Y",strtotime($row['edition_date'])),'file_url'=>$row['images']);
				$i++;
			}
		}
	else
	{
	    $data['status_code'] =201;
		    $data['status_desc'] ='Data not found';
		    $data['medialist'] = array();
	 
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>