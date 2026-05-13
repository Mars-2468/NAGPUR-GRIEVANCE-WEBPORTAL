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
	
 	$ward_id=$_REQUEST['ward_id'];
	//$desg_array=array('1'=>'Mayor','2'=>'Deputy Mayor','3'=>'Corporator');
	
	$langId=$_REQUEST['lang_id'];
	
	$sql="select ward_id,ward_desc from ward_mst where ulbid='".$_REQUEST['ulbid']."' order by ward_desc";
	$rs=mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
 	    $ward_list[$row['ward_id']]=$row['ward_desc'];
	}
	
	//echo $_REQUEST['ward_id'];
	
	//$arr=preg_split("-",$_REQUEST['ward_id']);
	$arr=explode("-",$_REQUEST['ward_id']);
	

	
	 $_REQUEST['ward_id']=$arr[0];
	 
	 if($arr[0]=='U')
	 {
	 $sql="select * from special_officers where  ulbid='".$_REQUEST['ulbid']."'";
	 $rs = mysqli_query($conn,$sql);
    	 if(mysqli_num_rows($rs) > 0)
    	 {
    	     
    	        $response['status_code'] = 200;
                $response['status_msg'] = 'success';
                $response['data'] = array();
                
            	 while($row = mysqli_fetch_assoc($rs))
            	 {
            	     
            	     if($row['img_url']=="")
            				{
            				$row['img_url']="http://municipalservices.in/comm_address/"."noimage.png";
            				}
            	 
            	            $data=array('name'=>$row['name'],'designation'=>$row['designation'],'mobile'=>$row['mobile'],'party'=>$row['party'],'img_url'=>$row['img_url']);
            	 
            	     
            	        array_push($response['data'],$data);
            	     
            	     
            	 }
            	 
    	 }
	 }
	 else
	 {
	 
      $sql="select ward_id,name,designation,mobile,party,img_url from council_mst where id='".$ward_id."' ";
	
	
	
//	$fp=fopen('test.txt','a');
//	fwrite($fp,$sql);
	//fclose($fp);
	
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
		        $response['status_code'] = 200;
                $response['status_msg'] = 'success';
                $response['data'] = array();
                
			while($row = mysqli_fetch_assoc($rs))
			{ 
			    
				 
	 			if($arr[1]==0)
	 			{
	 			$designation="Co- option Member";
	 			}
	 			else
	 			{
	 			
	 			$sql1="select ulb_type_id from ulbmst u,ulb_type ut where u.ulb_type=ut.ulb_type_id and ulbid='".$_REQUEST['ulbid']."'";
				$rs1 = mysqli_query($conn,$sql1);
				$row1 = mysqli_fetch_assoc($rs1);
				$ulb_type=$row1['ulb_type_id'];
				if($ulb_type=='1')
				{
					$designation="Corporator, Division- ";
				}
				else
				{
	 				$designation="councillor, ward- ";
	 			}
	 			}
	 				if($row['img_url']=="")
				{
				$row['img_url']="http://municipalservices.in/comm_address/"."noimage.png";
				}
				$data=array('name'=>$row['name'],'designation'=>$designation.$ward_list[$row['ward_id']],'mobile'=>$row['mobile'],'party'=>$row['party'],'img_url'=>$row['img_url']);
			
			    
			    
			    array_push($response['data'],$data);
			    
			    
			}
		}
		else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found'; 
		    $data = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available','status'=>'0');
		}
	}
	else
	{
	    $response['status_code'] = '100';
        $response['status_msg'] = 'No data Found'; 
		$data = array('uniq_id'=>'0','description'=>'No Data Available','img_url'=>'No Data Available','status'=>'0');
	}
		
		}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);
mysqli_close($conn);



?>