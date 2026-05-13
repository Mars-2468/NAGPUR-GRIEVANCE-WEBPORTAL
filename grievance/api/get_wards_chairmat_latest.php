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


	
	$sql="select * from special_officers where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn,$sql);
	$nr = mysqli_num_rows($rs);
	if($nr > 0)
	{
	    $response=array('status_code'=>200,'message'=>'success');
	    $response['data']=array();
	    
	while($row = mysqli_fetch_assoc($rs))
			{
			    if($langId==1){
				$data=array('ward_id'=>"U-".$row['ulbid'],'ward_desc'=>$row['designation']);
			    }else{
			      $data=array('ward_id'=>"U-".$row['ulbid'],'ward_desc'=>$row['designation_marathi']);  
			    }
				array_push($response['data'],$data);
			}
	}
	else
	{
	        $response=array('status_code'=>200,'message'=>'success');
	        $response['data']=array();
	        
	
        	$sql1="select ulb_type_id from ulbmst u,ulb_type ut where u.ulb_type=ut.ulb_type_id and ulbid='".$_REQUEST['ulbid']."'";
        	$rs1 = mysqli_query($conn,$sql1);
        	$row1 = mysqli_fetch_assoc($rs1);
        	$ulb_type=$row1['ulb_type_id'];
        	
        	
        	$sql="select id,ward_id from council_mst where ulbid='".$_REQUEST['ulbid']."' and chairman_status='1'";
        	$rs = mysqli_query($conn,$sql);
        	$row = mysqli_fetch_assoc($rs);
        	if($ulb_type==1)
        	{
        	$level1='Mayor';
        	$level1Marathi='महापौर';
        	$level2='Deputy Mayor';
        	$level2Marathi='उपमहापौर';
        	}
        	else
        	{
        	$level1='Chairman';
        	$level1Marathi='अध्यक्ष';
        	$level2='Vice Chairman';
        	$level2Marathi='उपाध्यक्ष';
        	}
        	if($row['ward_id']!="")
        	{
        	if($langId==1){
        	$data=array('ward_id'=>$row['id']."-".$row['ward_id'],'ward_desc'=>$level1);
        	}else{
        	  $data=array('ward_id'=>$row['id']."-".$row['ward_id'],'ward_desc'=>$level1Marathi);  
        	}
        	array_push($response['data'],$data);
        	}
        	
        	
        	$sql="select id,ward_id,id from council_mst where ulbid='".$_REQUEST['ulbid']."' and wise_chairman_status='1'";
        	$rs = mysqli_query($conn,$sql);
        	$row = mysqli_fetch_assoc($rs);
        	if($row['ward_id']!="")
        	{
        	    if($langId==1){
        	$data=array('ward_id'=>$row['id']."-".$row['ward_id'],'ward_desc'=>$level2);
        	    }else{
        	      $data=array('ward_id'=>$row['id']."-".$row['ward_id'],'ward_desc'=>$level2Marathi);  
        	    }
        	array_push($response['data'],$data);
        	}
	
	
	 $sql="select c.id,c.ward_id,w.ward_desc,w.wards_marathi from ward_mst w,council_mst c where w.ward_id=c.ward_id and c.ulbid='".$_REQUEST['ulbid']."' and c.wise_chairman_status NOT IN('1') and chairman_status NOT IN('1') order by w.ward_id";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
			     if($langId==1){
				$data=array('ward_id'=>$row['id']."-".$row['ward_id'],'ward_desc'=>$row['ward_desc']);
			     }else{
			   $data=array('ward_id'=>$row['id']."-".$row['ward_id'],'ward_desc'=>$row['wards_marathi']);      
			     }
				array_push($response['data'],$data);
			}
		}
		else
		{
		    $response=array('status_code'=>100,'message'=>'fail');
			
		}
	}
	else
	{
	$response=array('status_code'=>100,'message'=>'query not executed');
	}
	
	$sql ="select id,ward_id,designation from council_mst where ulbid='".$_REQUEST['ulbid']."' and cid='3'";
	$rs=mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
			{
				$data[]=array('ward_id'=>$row['id']."-".$row['ward_id'],'ward_desc'=>$row['designation']);
				array_push($response['data'],$data);
			}
	
		
	}
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>