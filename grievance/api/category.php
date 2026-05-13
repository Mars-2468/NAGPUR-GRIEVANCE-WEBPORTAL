<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	$langId=$_REQUEST['lang_id'];
	require_once('check_version.php');
	require_once('../check_access_key.php');
	
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
	header("Content-Type: application/json");

//echo $_REQUEST['ulbid']; exit;
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
    
// 	 $sql="select cat.cat_id,description,cat.telugu_description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag='1' and cu.ulbid='".$_REQUEST['ulbid']."' group by cat.cat_id order by description";
	 
	 	 $sql="select cat_id,description,telugu_description from category_mst where ulbid='".$_REQUEST['ulbid']."' group by cat_id order by description";
	
	
	if($rs=mysqli_query($conn,$sql))
	{
		$i=1;
		$response['status_code'] = 200;
        $response['message'] = 'success';
		while($row = mysqli_fetch_assoc($rs))
		{
		    if($langId==1){
			    $data[]=array('cat_id'=>$row['cat_id'],'description'=>$row['description']);
    		}else{
    		   $data[]=array('cat_id'=>$row['cat_id'],'telugu_description'=>$row['telugu_description']); 
    		}
			$i++;
		}
		$response['data'] = $data;
	}
	else
		$data[0] = array('id'=>'0','desc'=>'0');
		$response['data'] = $data;
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);
mysqli_close($conn);



?>