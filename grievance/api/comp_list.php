<?php
ini_set('display_errors', 0);

	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	require_once('../check_access_key.php');
	
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
	header("Content-Type: application/json");


	if($_REQUEST['access_key'] != ''){
      $check_access_key_status = ($access_key == $_REQUEST['access_key']) ?  1 : 0;

        if($check_access_key_status != 1){
        $response['status_code'] = 401;
          $response['message'] = 'unauthorized';
          echo json_encode($response);
          die;
        }
    }else{
        $response['status_code'] = 422;
        $response['message'] = 'Missing Access key';
        echo json_encode($response);
        die;
    }
    
	$langId=$_REQUEST['lang_id'];
	$sql ="select c.cs_id,c.cs_desc as comp_desc,c.telugu_description from  cs_mst c,complaint_ulbmap cu where c.sub_cat_id='".$_REQUEST['sub_cat_id']."' and c.cs_id=cu.cs_id and cu.ulbid='".$_REQUEST['ulbid']."' and cu.flag='1' ";
	
// 	$data[]=array('cs_id'=>0,'cs_desc'=>'Select Complaint');
	if($rs=mysqli_query($conn,$sql))
	{
	    $response['status_code'] = 200;
        $response['message'] = 'success';
		while($row = mysqli_fetch_assoc($rs))
		{
		  //  $data[]=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['telugu_description']."/".$row['telugu_description']);
		    if($langId==1){
			    $data[]=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['comp_desc']);
		    }else{
		        $data[]=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['telugu_description']);
		    }
		}
		$response['data'] = $data;
	}
	else
		$data[0] = array('cs_id'=>'0','cs_desc'=>'No Complaints Available');
		$response['data'] = $data;
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);
mysqli_close($conn);



?>