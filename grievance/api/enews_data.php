<?php
ini_set('display_errors',0);
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
	
	//$sql="select id,images from add_content_image where content_no='".$_REQUEST['content_no']."' order by id desc";
	
	  $sql="select edition_date,img_url,description,description_marathi,ac.edition_no,ae.edition_no as edition_desc from add_content ac,add_edition ae where ac.edition_no=ae.id and ac.ulbid='".$_REQUEST['ulbid']."' and ac.edition_no='".$_REQUEST['edition_no']."'";
	
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
		    $response['status_code'] = 200;
            $response['message'] = 'success';
			while($row = mysqli_fetch_assoc($rs))
			{
			    if($langId==1){
				    $data=array('content_no'=>$row['edition_no'],'edition_date'=>date("d-m-Y",strtotime($row['edition_date'])),'description'=>$row['description'],'file_url'=>$row['img_url'],'edition_desc'=>$row['edition_desc']);
			    }else{
			     $data=array('content_no'=>$row['edition_no'],'edition_date'=>date("d-m-Y",strtotime($row['edition_date'])),'description'=>$row['description'],'description_marathi'=>$row['description_marathi'],'file_url'=>$row['img_url'],'edition_desc'=>$row['edition_desc']);
			    }
			}
			$response['data'] = $data;
		}
		else
			$data[0] = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available');
			$response['data'] = $data;
	}
	else
		$data[0] = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available');
		$response['data'] = $data;
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

header("Content-type:application/json");    
echo json_encode($response);

mysqli_close($conn);


?>