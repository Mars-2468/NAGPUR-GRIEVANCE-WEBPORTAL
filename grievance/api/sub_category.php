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
        
        $sql ="select * from category_mst where  cat_id='".$_REQUEST['cat_id']."'";
        // 	echo $sql;
        $rs=mysqli_query($conn,$sql);
        $nr = mysqli_num_rows($rs);
        $category_name  = '';
        $category_id  = '';
        if($nr > 0)
	    {
	        while($row = mysqli_fetch_assoc($rs))
		    {
		        $category_id = $row['cat_id'];
		        if($langId == 1){
		            $category_name = $row['description'];
		        }else{
		            $category_name =  $row['telugu_description'];
		        }
		        
		    }
	    }
        
        $sql ="select * from subcategory_mst where  cat_id='".$_REQUEST['cat_id']."'";
        // 	echo $sql;
        $rs=mysqli_query($conn,$sql);
        $nr = mysqli_num_rows($rs);
	 
	 
	
	
	if($nr > 0)
	{
	    $response['status_code'] = 200;
        $response['message'] = 'success';
        $response['category_name'] = preg_replace('~[\r\n]+~', '', $category_name);
        $response['category_id'] = $category_id;
        
		$i=1;
		while($row = mysqli_fetch_assoc($rs))
		{
		    
			$data[]=array('sno'=>$i,'sub_cat_id'=>$row['sub_cat_id'],'cat_id'=>$row['cat_id'],'sub_desc'=>$row['description']);
			$i++;
		}
		$response['data'] = $data;
	}
	else
		$data[0] = array('sub_cat_id'=>'0','cat_id'=>'-','sub_desc'=>'-');
		$response['data'] = $data;
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>