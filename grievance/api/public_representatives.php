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
        $langId=$_REQUEST['lang_id'];
	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$response['distic']=array();
	
	
	
	 $sql="select id,name,designation,mobile,party,img_url,name_marathi,designation_marathi from council_mst where cid='1' and ulbid='".$_REQUEST['ulbid']."'";
	 //$sql="select id,name,designation,mobile,party,img_url from council_mst where  ulbid='".$_REQUEST['ulbid']."'";
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
			if($langId==1){
		         $distic['designation']=$row['designation'];
		    	$distic['name']=$row['name'];
        		}else{
        		     $distic['designation']=$row['designation_marathi'];
        		     $distic['name']=$row['name_marathi'];
        		}
			 
			 
			$distic['mobile']=$row['id']."-".$row['mobile']; 
			$distic['party']=$row['party']; 
			$distic['img_url']=$row['img_url']; 
			$distic['designation']=$row['designation']; 
			$distic['designation']=$row['designation']; 
				 
	 		array_push($response["distic"], $distic);
	 
				
			}
			//$response['distic']=array();
		}
		else
		$data[0] = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available','status'=>'0');
	}
	else
		$data[0] = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available','status'=>'0');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>