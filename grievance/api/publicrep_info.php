<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET names=utf8');
        mysqli_query($conn,'SET character_set_client=utf8');
        mysqli_query($conn,'SET character_set_connection=utf8');
        mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET collation_connection=utf8_general_ci');
        $langId=$_REQUEST['lang_id'];
	
	$arr=explode("-",$_REQUEST['mobile']);
	
	 $_REQUEST['id']=$arr[0];
	
	$sql = "Select * from council_mst where id='".$_REQUEST['id']."'";
	$rs = mysqli_query($conn, $sql);
	
	if(mysqli_num_rows($rs) > 0)
	{
	        $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            //$response['data'] = array();
            $response['designations']=array();
	
        	while($row = mysqli_fetch_assoc($rs))
        	{
        	if($langId==1){
		         $distic['designation']=$row['designation'];
		    	$distic['name']=$row['name'];
        		}else{
        		     $distic['designation']=$row['designation_marathi'];
        		     $distic['name']=$row['name_marathi'];
        		}
        		$distic['mobile']=$row['mobile'];
        		
        		$distic['img_url']=$row['img_url'];
        		
        		
        		
        		array_push($response["designations"], $distic);
        		
        	}
	}
	else
	{
	        $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			//$data = array('dept_id'=>'0','description'=>'No Data Available');
	}
	echo json_encode($response);
	
	//$array = json_decode($json, true);
//echo htmlentities($array[10]['distnametelugu'], NULL, 'UTF-8');
mysqli_close($conn);

?>