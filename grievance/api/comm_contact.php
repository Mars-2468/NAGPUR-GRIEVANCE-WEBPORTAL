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
	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$langId=$_REQUEST['lang_id'];
	
	 $sql="SELECT * FROM  `comm_tab` where ulbid='".$_REQUEST['ulbid']."'";
	
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

	if($rs=mysqli_query($conn,$sql))
	{
		$data['status_code'] = 200;
        $data['message'] = 'success';
		while($row = mysqli_fetch_assoc($rs))
		{
		    if($langId==1){
		        
    			$data=array(
        			'comm_name'=>$row['comm_name'],
        			'designation'=>$row['designation'],
        			'address'=>$row['address'],
        			'mobile'=>$row['mobile'],
        			'photo'=>$row['file_url'],
        			'email'=>$row['email'],
        			'land_line'=>$row['land_line'],
        			'fax'=>$row['fax'],
        			
        			
        			'lane1'=>$row['lane1'],
        			'lane2'=>$row['lane2'],
        			'lane3'=>$row['lane3'],
        			'lane4'=>$row['lane4'],
        			'lane5'=>$row['lane5']
        			);
		    }
		    else{
    		    $data=array(
    		    'comm_name'=>$row['comm_name_marathi'],
    			'designation'=>$row['designation_marathi'],
    			'address'=>$row['address_marathi'],
    			'mobile'=>$row['mobile'],
    			'photo'=>$row['file_url'],
    			'email'=>$row['email'],
    			'land_line'=>$row['land_line'],
    			'fax'=>$row['fax'],
    		
    		
    			
    			'lane1'=>$row['lane1'],
    			'lane2'=>$row['lane2'],
    			'lane3'=>$row['lane3'],
    			'lane4'=>$row['lane4'],
    			'lane5'=>$row['lane5']
    			);
		    }
			
		}
	}
	else
	 $data[0] = array('address'=>'No Data Available','link'=>'No Data Available');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}
header("Content-Type: application/json");
echo json_encode($data);
mysqli_close($conn);




?>