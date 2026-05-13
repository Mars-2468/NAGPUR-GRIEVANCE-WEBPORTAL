<?php
  ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	require_once('../check_access_key.php');
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET names=utf8');
    mysqli_query($conn,'SET character_set_client=utf8');
    mysqli_query($conn,'SET character_set_connection=utf8');
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	$langId=$_REQUEST['lang_id'];
	$sql="select * FROM about_municipality WHERE ulbid='".$_REQUEST['ulbid']."'";
	$rs=mysqli_query($conn,$sql);
	
	
    if($_REQUEST['access_key'] != ''){
          $check_access_key_status = ($access_key == $_REQUEST['access_key']) ?  1 : 0;
    
          if($check_access_key_status != 1){
            $response['status_code'] = 401;
          $response['message'] = 'unauthorized';
          header("Content-Type: application/json");
          echo json_encode($response);
          die;
        }
    }else{
        $response['status_code'] = 422;
        $response['message'] = 'Missing Access key';
        header("Content-Type: application/json");
        echo json_encode($response);
        die;
    }

	if(mysqli_num_rows($rs) > 0)
	{
		while($row = mysqli_fetch_assoc($rs))
		{
		    $response['status_code'] = 200;
            $response['message'] = 'success';
			//$data['description']=$row['description'];
			if($langId==1){
			    
    			$response['institutional_structure']=str_replace("&nbsp;", " ",strip_tags($row['description']));
    			$response['administrative_structure']=str_replace("&nbsp;", " ",strip_tags($row['desc2']));
			}else{
			    $response['institutional_structure']=str_replace("&nbsp;", " ",strip_tags($row['description_marathi']));
			    $response['administrative_structure']=str_replace("&nbsp;", " ",strip_tags($row['desc2_marathi']));
			    
			}
		}
	}else
		$data[] = array('error_code'=>'201','message'=>'No Data Available');
	    $indexedOnly = array();
        foreach ($data as $row) {
            $indexedOnly[] = array_values($row);
        }
    header("Content-type:application/json");    
    echo json_encode($response);




?>