<?php

	require_once('../connection.php');
	ini_set('display_errors',0);
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');
	
	/*$result=array();
	$result['data']=array();*/
	
	/*$result=array('status_code'=>'200','message'=>'success');
	$result['data']=array();
	$array=array('aaa'=>'aaa');
	array_push($result['data'],$array);
	$array=array('bbb'=>'bbb');
	
	array_push($result['data'],$array);
	echo json_encode($result);*/
	
	
	
	
	
	
	
	$sql="select cs_id,cs_desc from cs_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['cs_desc'];
		}
		
		$i=1;
	$nrstatus=1;

    
	
	

	
	 
	
	$sql ="select g.grievance_status_id,grievance_id,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_status_desc,date_regd,
	file_url,cat3_id,g.ulbid,app_type_id,c.description from grievances g,grievance_status_mst gsm,cs_mst cm,category_mst c where g.cat3_id=cm.cs_id and 
	cm.cat_id=c.cat_id and g.grievance_status_id=gsm.grievance_status_id and user_id like '".$_REQUEST['imei']."' and  g.grievance_status_id IN('3','8','9') and 
	grievance_id NOT IN(select grievance_id from rating_mst where imei_no='".$_REQUEST['imei']."') order by grievance_id desc ";
	
	
	if($rs=mysqli_query($conn,$sql))
	{
		
		if(mysqli_num_rows($rs)>0)
		{
		    $result=array('status_code'=>'200','message'=>'success');
		    
		    $result['data']=array();
		    
			
			
			
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
				'date_regd'=>date('d-m-Y H:i:s',strtotime($row['date_regd'])),'grievance_status_desc'=>'Redressed','file_url'=>$file_url,
				'subject'=>$cs_list[$row['cat3_id']]." (".$row['description'].")",'rating_no'=>$rating,'comment_desc'=>$comment);
				  
				}
				
				else
				{
					
				$data=array('sno'=>$i,'grievance_id'=>$row['grievance_id'],'address'=>$row['address'],'comp_desc'=>$row['comp_desc'],
				'date_regd'=>date('d-m-Y H:i:s',strtotime($row['date_regd'])),'grievance_status_desc'=>$row['grievance_status_desc'],'file_url'=>$file_url,
				'subject'=>$cs_list[$row['cat3_id']]." (".$row['description'].")",'rating_no'=>$rating,'comment_desc'=>$comment);
				
				}
				
				
				array_push($result['data'],$data);
				
				
				$i++;
			}
			
		}
		else
		{
		    $nrstatus=0;
		}
	//	else
			//$data[0] = array('grievance_id'=>'0','address'=>'N/A','comp_desc'=>'N/A','date_regd'=>'N/A','grievance_status_desc'=>'N/A','file_url'=>'N/A','subject'=>'N/A');
	}
	
		$sql ="select g.grievance_status_id,grievance_id,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_status_desc,date_regd,
	file_url,cat3_id,g.ulbid,app_type_id,c.description from grievances g,grievance_status_mst gsm,cs_mst cm,category_mst c where g.cat3_id=cm.cs_id and 
	cm.cat_id=c.cat_id and g.grievance_status_id=gsm.grievance_status_id and user_id like '".$_REQUEST['imei']."' and  g.grievance_status_id IN('12') and 
	grievance_id IN(select grievance_id from rating_mst where imei_no='".$_REQUEST['imei']."' and resolved_id='12') order by grievance_id desc ";
	$rs=mysqli_query($conn,$sql);
	if(mysqli_num_rows($rs)>0)
	{
	    if($nrstatus==0)
	    {
	        $result=array('status_code'=>'200','message'=>'success');
	        $result['data']=array();
	    }
	    
	    $nrstatus=1;
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
				
	            $data=array('sno'=>$i,'grievance_id'=>$row['grievance_id'],'address'=>$row['address'],'comp_desc'=>$row['comp_desc'],
				'date_regd'=>date('d-m-Y H:i:s',strtotime($row['date_regd'])),'grievance_status_desc'=>$row['grievance_status_desc'],'file_url'=>$file_url,
				'subject'=>$cs_list[$row['cat3_id']]." (".$row['description'].")",'rating_no'=>$rating,'comment_desc'=>$comment);
				array_push($result['data'],$data);
			}
	}
	else
	{
	    
	    if($nrstatus <=0)
	    {
	        $nrstatus=0;
	    }
	
		
	}
	
	
	
	if($nrstatus==0)
	{
	    $result=array('status_code'=>'100','message'=>'fail');
	}
		
	$indexedOnly = array();
	
	foreach ($data as $row) {
	    $indexedOnly[] = array_values($row);
	}
	
	//$data['result']=$data;
	
	echo json_encode($result);
	
	mysqli_close($conn);	

?>