<?php
ini_set('display_errors',0);
require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_POST['apk_version'];
	require_once('check_version.php');
	require_once('../check_access_key.php');
	
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
    header("Content-Type: application/json");
	
	if($_POST['access_key'] != ''){
	    //echo "gi"; exit;
      $check_access_key_status = ($access_key == $_POST['access_key']) ?  1 : 0;

        if($check_access_key_status != 1){
           
        $response['status_code'] = 401;
          $response['message'] = 'unauthorized';
          echo json_encode($response);
          return;
        }
    }else{
        $response['status_code'] = 422;
        $response['message'] = 'Missing Access key';
        echo json_encode($response);
        return ;
    }
    
	$lang_id=$_POST['lang_id'];
	
	$sql="select * from ward_mst where ward_id='".$_POST['zone_id']."' ";
	
	if($rs=mysqli_query($conn,$sql))
	{ 
	    if(mysqli_num_rows($rs) > 0)
		{
		    $row = mysqli_fetch_assoc($rs);
		    $response['status_code'] = 200;
        	$response['status_msg'] = 'success';
        	$response['data']['id'] = $row['ward_id'];
        	$response['data']['ward_name'] = $row['ward_desc'];
        	$response['data']['ward_address'] = $row['ward_address'];
        	$response['data']['ward_link'] = $row['ward_link'];
        // 	$response['data'] = array();    

        // 		while($row = mysqli_fetch_assoc($rs))
        // 		{
        		  
        // 			$data=array('ward_id'=>$row['ward_id'], 'ward_name'=>$row['ward_desc']);
        // 			array_push($response['data'],$data);
        // 		}
		}
		else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			array_push($response['data'],$data);
		}	
	}
// 	else
// 	{
// 	    $data = array('sno'=>'1','content_no'=>'0','edition_date'=>'No Data Available');
// 	    array_push($response['data'],$data);
// 	}
		
// 	$indexedOnly = array();

//     foreach ($data as $row) {
//         $indexedOnly[] = array_values($row);
//     }
    
    echo json_encode($response);
    
    mysqli_close($conn);


?>