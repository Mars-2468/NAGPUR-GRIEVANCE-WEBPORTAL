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
	    //$_POST['cat_id'] =1;
	
	$sql ="select cat.cat_id,description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag='1' and cu.ulbid='".$_REQUEST['ulbid']."' order by description ASC";
	$rs=mysqli_query($conn,$sql);
	 $nr = mysqli_num_rows($rs);
	if($rs)
		{
		    $response['status_code'] = 200;
            $response['message'] = 'success';
			while($row = $rs->fetch_assoc())
			{
				
				if($row['cat_id'] == 9 || $row['cat_id'] == 8){
				     $cat_list[$row['cat_id']]= array($row['cat_id'],$row['description']);
				}
				else{
				    $cat_list[$row['cat_id']]= array($row['cat_id'],ucwords(strtolower($row['description'])));
				}
				
			
			}
			foreach($cat_list as $key => $dept){
			    $data[] = array('dept_id'=>$dept[0],'title'=>$dept[1]);
			}
			
			$response['data'] = $data;
		}
	
// 	if($nr > 0)
// 	{
// 	    $response['status_code'] = 200;
//         $response['message'] = 'success';
// 		$i=1;
// 		while($row = mysqli_fetch_assoc($rs))
// 		{
// 			$data[]=array('sno'=>$i,'dept_id'=>$row['cat_id'],'description'=>$row['description']);
// 			$i++;
// 		}
// 		$response['data'] = $data;
// 	}
// 	else
// 		$data[0] = array('dept_id'=>'0','description'=>'-');
// 		$response['data'] = $data;
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>