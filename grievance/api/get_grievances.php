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
	
	
	
	date_default_timezone_set('Asia/Calcutta');
	
	$sql="select cs_id,cs_desc from cs_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['cs_desc'];
		}
	
	 $sql ="select g.grievance_status_id,g.grievance_id,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_status_desc,date_regd,
	file_url,cat3_id,g.ulbid,app_type_id,c.description from grievances g,grievance_status_mst gsm,cs_mst cm,category_mst c where g.cat3_id=cm.cs_id and 
	cm.cat_id=c.cat_id and g.grievance_status_id=gsm.grievance_status_id and user_id like '".$_REQUEST['imei']."' order by grievance_id desc ";
		
	//var_dump($sql);die();
	
	if($rs=mysqli_query($conn,$sql))
	{
		$i=1;
		if(mysqli_num_rows($rs)>0)
		{
		    
		    
		    $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            $response['data'] = array();
		    
		    
		    
			while($row = mysqli_fetch_assoc($rs))
			{
				if($row['app_type_id']=='2')
				{
					$sql="select cs_id,comp_desc from category3_mst where ulbid='".$row['ulbid']."'";
					if($rs=mysqli_query($conn,$sql))
					{
						while($row = mysqli_fetch_assoc($rs))
							$cs_list[$row['cs_id']]=$row['comp_desc'];
					}
					
				}
				$rating="";
				$comment="";
				if($row['grievance_status_id']=='3' || $row['grievance_status_id']=='8' ||  $row['grievance_status_id']=='9')
				{
			    $sql ="select rating_no,comment_desc from rating_mst where grievance_id='".$row['grievance_id']."' and imei_no='".$_REQUEST['imei']."'";
				$rs2=mysqli_query($conn,$sql);
				$row2=mysqli_fetch_assoc($rs2);
				$rating=$row2['rating_no'];
				$comment=$row2['comment_desc'];
				}
				
				
				if($row['file_url']=='')
				{
					$file_url='http://municipalservices.in/comm_address/noimage.png';
				}
				else
				{
					$file_url=$row['file_url'];
				}
				
				
				
				if($row['grievance_status_desc'] == 'Completed')
				{
				   
				   $data=array('sno'=>$i,'grievance_id'=>$row['grievance_id'],'address'=>$row['address'],'comp_desc'=>$row['comp_desc'],
				'date_regd'=>date('d-m-Y H:i:s',strtotime($row['date_regd'])),'grievance_status_desc'=>'Redressed',
				'file_url'=>$file_url,'subject'=>$cs_list[$row['cat3_id']]." (".$row['description'].")",'rating_no'=>$rating,'comment_desc'=>$comment); 
				 
				 
				 array_push($response['data'],$data);
				 
				    
				}
				
				else
				{
				   $data=array('sno'=>$i,'grievance_id'=>$row['grievance_id'],'address'=>$row['address'],'comp_desc'=>$row['comp_desc'],
				   'date_regd'=>date('d-m-Y H:i:s',strtotime($row['date_regd'])),'grievance_status_desc'=>$row['grievance_status_desc'],
				   'file_url'=>$file_url,'subject'=>$cs_list[$row['cat3_id']]." (".$row['description'].")",'rating_no'=>$rating,'comment_desc'=>$comment);
				  
				  
				  array_push($response['data'],$data);
				   
				}
				$i++;
			}
		}
		else
		{
		    
		    
		    
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
		    
			$data = array('grievance_id'=>'0','address'=>'N/A','comp_desc'=>'N/A','date_regd'=>'N/A','grievance_status_desc'=>'N/A','file_url'=>'N/A','subject'=>'N/A');
	
		}  
		
		
		
		
		}
	else
	{
	        $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
		$data = array('grievance_id'=>'0','address'=>'N/A','comp_desc'=>'N/A','date_regd'=>'N/A','grievance_status_desc'=>'N/A','file_url'=>'N/A','subject'=>'N/A');
	}
		
	$indexedOnly = array();
	
	foreach ($data as $row) {
	    $indexedOnly[] = array_values($row);
	}
	
	echo json_encode($response);
	
	mysqli_close($conn);	

?>