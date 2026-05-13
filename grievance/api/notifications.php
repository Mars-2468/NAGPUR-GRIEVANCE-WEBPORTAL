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
	$sql="select * from notification_mst where ulbid='".$_REQUEST['ulbid']."' order by ts DESC";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
		    $response['status_code'] = 200;
            $response['message'] = 'success';
			while($row = mysqli_fetch_assoc($rs))
			{
			    if($row['photo']!='')
			    {
			        $image=$row['photo'];
			    }else{
			        $image='http://municipalservices.in/No-image-found.jpg';
			    }
			    if($langId==1){
			        
			  	    $data[]=array('id'=>$row['id'], 'title'=>$row['title'], 'message'=>strip_tags($row['description']), 'date'=>date('d-m-Y',strtotime($row['date'])),'time'=>$row['time']);
			    }else{
			        $data[]=array('id'=>$row['id'], 'title'=>$row['title'], 'message'=>strip_tags($row['description_marathi']), 'date'=>date('d-m-Y',strtotime($row['date'])),'time'=>$row['time']);
			     
			    }
			    
			}
			$response['data'] = $data;
		}
		else
		{
			$data[] = array('dept_id'=>'0','description'=>'No Data Available');
			$response['data'] = $data;
		}
	}
	else
	{
	$data[] = array('dept_id'=>'0','dept_desc'=>'Query not executed');
	$response['data'] = $data;
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>