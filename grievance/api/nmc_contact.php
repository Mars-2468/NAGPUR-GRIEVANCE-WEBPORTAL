<?php
	ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
        mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	require_once('../check_access_key.php');
	
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
    
	
	$langId=$_REQUEST['lang_id'];
	
	$sql="SELECT * FROM  `comm_tab` where ulbid='".$_REQUEST['ulbid']."' and user_type='55'";
	
	if($rs=mysqli_query($conn,$sql))
	{
	    $response['status_code'] = 200;
        $response['message'] = 'success';
		
		while($row = mysqli_fetch_assoc($rs))
		{
		    
		    if($langId==1){
			   $response['data'] = array('address'=>$row['nmc_address'], 'mobile' =>$row['mobile'], 'telephone' =>$row['land_line'], 'email' =>$row['email'] );
		    }else{
		       $response['data'] = array('address'=>$row['nmc_address'], 'mobile' =>$row['mobile'], 'telephone' =>$row['land_line'], 'email' =>$row['email'] );
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
echo json_encode($response);
mysqli_close($conn);




?>