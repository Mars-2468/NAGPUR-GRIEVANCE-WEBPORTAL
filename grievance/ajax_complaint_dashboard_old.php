<?php
        require "config.php";
        date_default_timezone_set('Asia/Calcutta');
	    ini_set('display_errors',0);
	    require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		$mergedulbs = 900;
		// Total received
		
		//echo $_SESSION['emp_id'] ;
		
		//$emplist =join(',',$_SESSION['emp_list']);
		$emplist = join("','",$_SESSION['emp_list']); 
		
		if($_SESSION['user_type']=='A')
				{
				
				 
				 //$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1'";
				$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";
				 
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				   if($_SESSION['ulbid']==(int)$mergedulbs)
				 {
				     $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and app_type_id='1' and cat3_id !='0' ";
				 }
				 else
				 {
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".strip_tags($_SESSION['ulbid'])."' and app_type_id='1' and cat3_id !='0' ";
				 }
				}
				else if($_SESSION['user_type']=='E')
				{
				    
				 
				// $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g,cs_mst c,ulbmst u where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='1'";
				  $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('".$emplist."') and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0'";
				 
				 $sql_od="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('".$emplist."') and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0'";
				 
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".strip_tags($_SESSION['uid'])."' and cat3_id !='0'";
				}
				
			else if($_SESSION['user_type']=='M')
				{
				//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";
				 
				 //$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1'";
				$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				 
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['total_received']=$row['date_regd'];
					
				 }
				 
				 
				 if($data[1]['total_received']=='')
				{
				    $data[1]['total_received']=0;
				}
				// resolved with in sla
				
					if($_SESSION['user_type']=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' ";
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				 if($_SESSION['ulbid']==(int)$mergedulbs)
				 {
				     $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and 
				  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
				 }
				 else
				 {
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".strip_tags($_SESSION['ulbid'])."' and 
				  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
				 }
				 
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('".$emplist."') and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' ";
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".strip_tags($_SESSION['uid'])."' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
				}
				else if($_SESSION['user_type']=='M')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				}
				
			//	echo $sql;
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['resolved_within_sla']=$row['date_regd'];
					
				 }
				 
				 
				 
				  if($data[1]['resolved_within_sla']=='')
				{
				    $data[1]['resolved_within_sla']=0;
				}
				// resolved beyond sla
				
					if($_SESSION['user_type']=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($_SESSION['user_type']=='U')
				{
				  if($_SESSION['ulbid']==(int)$mergedulbs)
				 {
				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and 
				  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				 }
				 else
				 {
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".strip_tags($_SESSION['ulbid'])."' and 
				  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				 }
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('".$emplist."') and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".strip_tags($_SESSION['uid'])."' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($_SESSION['user_type']=='M')
				{
				
				 
				$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['resolved_beyond_sla']=$row['date_regd'];
					
				 }
				 
				  if($data[1]['resolved_beyond_sla']=='')
				{
				    $data[1]['resolved_beyond_sla']=0;
				}
				 
				 // under progress with in sla
				 
				 if($_SESSION['user_type']=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				else if($_SESSION['user_type']=='U')
				{
    				if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where ulbid IN('208','210') and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
    				 }
    				 else
    				 {
    				 
    				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where ulbid='".strip_tags($_SESSION['ulbid'])."' and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
    				
    				 }
				 }
				else if($_SESSION['user_type']=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('".$emplist."') and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				 else if($_SESSION['user_type']=='M')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['pending_with_sla']=$row['date_regd'];
					
				 }
				 
				  if($data[1]['pending_with_sla']=='')
				{
				    $data[1]['pending_with_sla']=0;
				}
				 
				 
				 // under progress beyond sla
				 
				 if($_SESSION['user_type']=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
				else if($_SESSION['user_type']=='U')
				{
				    	if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and 
    				 app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
    				 }
    				 else
    				 {
    				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."' and 
    				 app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
    				 }
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				$sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and emp_id IN('".$emplist."') and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and cat3_id !='0'";
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
				if($_SESSION['user_type']=='M')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['pending_beyond_sla']=$row['date_regd'];
					
				 }
				 
				 if($data[1]['pending_beyond_sla']=='')
				{
				    $data[1]['pending_beyond_sla']=0;
				}
				 
				 
				/********pending Approval**********/	
				
				if($_SESSION['user_type']=='A')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances  where  grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
				
				}
				 if($_SESSION['user_type']=='U')
				{
				
					if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where 
	ulbid IN('208','210') and grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where 
	ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
		
    				 }
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='1' and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				if($_SESSION['user_type']=='M')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances  where  grievance_status_id='1' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['pendingforapproval']=$row['pendingforapproval'];
				}
				
				
				if($data[1]['pendingforapproval']=='')
				{
				    $data[1]['pendingforapproval']=0;
				}
			
				
				
			/********end pending approval****/	
			
			
			/********Financial implications**********/	
				
				if($_SESSION['user_type']=='A')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances where  grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
				
				}
				 if($_SESSION['user_type']=='U')
				{
				    
				    	if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as fin,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		$sql="select count(grievance_id) as fin,app_type_id from grievances where 
		ulbid='".$_SESSION['ulbid']."' and grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
    				 }
		
		
				}
				 if($_SESSION['user_type']=='E')
				{
				
		$sql="select count(g.grievance_id) as fin,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('".$emplist."') and grievance_status_id='6' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances g,ulbmst u,Districtmst d where  g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='6' and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
					if($_SESSION['user_type']=='M')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances where  grievance_status_id='6' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 {
				 $data[$row['app_type_id']]['fin']=$row['fin'];
				}
				
				
				if($data[1]['fin']=='')
				{
				    $data[1]['fin']=0;
				}
				
			
				
				
			/********end pending approval****/	
			
			
			
			
				/********Un resolved**********/	
				
				if($_SESSION['user_type']=='A')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances where grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
				
				}
				 if($_SESSION['user_type']=='U')
				{
				    
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as unresolved,app_type_id from grievances where ulbid IN('208','210') and grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		$sql="select count(grievance_id) as unresolved,app_type_id from grievances where ulbid='".$_SESSION['ulbid']."' and grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
    				 }
		
		
				}
				 if($_SESSION['user_type']=='E')
				{
				
		$sql="select count(g.grievance_id) as unresolved,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('".$emplist."') and grievance_status_id='4' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='4' and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				if($_SESSION['user_type']=='M')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances where grievance_status_id='4' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['unresolved']=$row['unresolved'];
				}
				
				if($data[1]['unresolved']=='')
				{
				    $data[1]['unresolved']=0;
				}
				
			
				
				
			/********end pending approval****/
			
			
			
			
				/******** Rejected **********/	
				
				if($_SESSION['user_type']=='A')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances where grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
				
				}
				 if($_SESSION['user_type']=='U')
				{
				    
				     if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as rejected,app_type_id from grievances where ulbid IN('208','210') and grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		                $sql="select count(grievance_id) as rejected,app_type_id from grievances where ulbid='".$_SESSION['ulbid']."' and grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
		
    				 }
		
				}
				 if($_SESSION['user_type']=='E')
				{
				
		$sql="select count(g.grievance_id) as rejected,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('".$emplist."') and grievance_status_id='10' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='10' and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				if($_SESSION['user_type']=='M')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances where grievance_status_id='10' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['rejected']=$row['rejected'];
				}
				
					if($data[1]['rejected']=='')
				{
				    $data[1]['rejected']=0;
				}
				
			
				
				
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			/** re-opened applicatons **/
				
				if($_SESSION['user_type']=='A')
		          {
		                
		                
		                
		                $sql3="select count(grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13') group by app_type_id,grievance_status_id";
		                
		            }
		            else if($_SESSION['user_type']=='U')
		            {
		                 if($_SESSION['ulbid']==(int)$mergedulbs)
            				 {
            				     $sql3 ="select count(gt.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid IN('208','210') and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
        				         $sql4 ="select count(g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('11','12') and ulbid IN('208','210') group by app_type_id, grievance_status_id";
            				 }
            				 else
            				 {
        		               
        		             $sql3 ="select count(gt.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."'  and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
        				     $sql4 ="select count(DISTINCT grievance_id) as count,grievance_status_id,app_type_id from grievances  where  grievance_status_id IN('11','12') and ulbid='".$_SESSION['ulbid']."' group by app_type_id, grievance_status_id";
            				 }
		                
		            }
		            else if($_SESSION['user_type']=='E')
				        {
				            $sql3 ="select count(gt.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and emp_id IN('".$emplist."') and gt.disposal_status IN('9','12') and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
				            $sql4 ="select count(DISTINCT g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('11','12') and gt.emp_id IN('".$emplist."') group by app_type_id, grievance_status_id";
				        }
				        else if($_SESSION['user_type']=='R')
		                {
		                    
		                   $sql3="select count(gt.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma='".$_SESSION['uid']."' and cat3_id !='0' and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
		                   $sql4="select count(g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma='".$_SESSION['uid']."' and cat3_id !='0' and gt.disposal_status IN('11','12')  group by app_type_id, grievance_status_id";
		                    
		                }
		                
		               if($_SESSION['user_type']=='M')
		          {
		                
		                
		                
		                $sql3="select count(grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13') and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by app_type_id,grievance_status_id";
		                
		            } 
		                
		                
		                $rs= mysqli_query($conn,$sql3);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed_tot[$row['app_type_id']]['13']['count']=$row['count'];
		                }
		                
		                if($reopened_completed_tot[1]['13']['count']=='')
		                {
		                    $reopened_completed_tot[1]['13']['count']=0;
		                }
		                
		              
		               // echo $sql4;
		                
		                $rs= mysqli_query($conn,$sql4);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed_tot[$row['app_type_id']][$row['grievance_status_id']]['count']=$row['count'];
		                }
		                
		                 if($reopened_completed_tot[1]['11']['count']=='')
		                {
		                    $reopened_completed_tot[1]['11']['count']=0;
		                }
		                
		                 if($reopened_completed_tot[1]['12']['count']=='')
		                {
		                    $reopened_completed_tot[1]['12']['count']=0;
		                }
		                
		                
		                // multiple times repeated complaints
		                
		               /* $sql="select IFNULL(count(DISTINCT gt.grievance_id),0) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and is_reopened_yn='1' group by app_type_id";
		                
		                $rs= mysqli_query($conn,$sql);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed_reopened[$row['app_type_id']]['count']=$row['count'];
		                }*/
				 
				 
		
				 
				 
				 
		
?>

<div class="boxed">
                <!-- Title Bart Start -->
                <!-- <h4>Total Number of Complaints</h4>-->
               <div class="bash_heading row  m-b20"> Total Number of Grievances  </div> 
                <!-- Title Bart End -->
                <div >
				
                <div class="row dashboard-stats">
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <!---<i class="fa fa-cloud-download text-large stat-icon "></i>-->
									<br>
									<i class="fa fa-check-circle text-large stat-icon "></i>
									
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services.php?aptid=1&status=0&user_type={$user_type}&sla=0">{$data[1].total_received}</a></p>-->
                                    <p class="size-h1 no-margin countdown_first">
                                        <?php if($_SESSION['user_type']=='U'){
                                        
                                           
                                           echo "2203";
                                           
                                           
                                           // echo "<a href='tot_received.php?aptid=1&status=0&sla=0&user_type=".$_SESSION['user_type']."' target='_blank'>".$data[1]['total_received']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=0&sla=0&user_type=".$_SESSION['user_type']."' target='_blank'>".$data[1]['total_received']."</a>";
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='cdma_ulbwise_report.php?status=0&app_type_id=1&name=".$_SESSION['uid']."' target='_blank'>".$data[1]['total_received']."</a>";
                                            }
                                            else
                                            {
                                            
                                            echo "<a href='cdma_ulbwise_report.php?status=0&app_type_id=1&name=".$_SESSION['uid']."' target='_blank'>".$data[1]['total_received']."</a>";
                                        
                                            }
                                            }
                                        
                                        ?>
                                        
                                        
                                       
                                    </p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Received</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
								<br>
                                    <i class="fa fa-minus-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first">{if $data[1].pending_apprval eq ''}0{else}<a href="pending_approval.php?grievance_status_id=1&aptid=1">{$data[1].pending_apprval}</a>{/if}</p>-->
                        <p class="size-h1 no-margin countdown_first">
                            
                            <?php if($_SESSION['user_type']=='U'){
                                        
                                            echo "0";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo $data[1]['pendingforapproval'];
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='cdma_ulbwise_report.php?status=1&app_type_id=1&name=".$_SESSION['uid']."' target='_blank'>".$data[1]['pendingforapproval']."</a>";
                                            }
                                            else
                                            {
                                            echo "<a href='cdma_ulbwise_report.php?status=1&app_type_id=1&name=".$_SESSION['uid']."' target='_blank'>".$data[1]['pendingforapproval']."</a>";
                                        
                                            }
                                            }
                                        
                                        ?>
                            
                            
                             
                                    <p class="text-muted no-margin "><span style="color:#000;">Pending for Approval</span><br>
                                    (<?php echo "0.00 %"; ?> )
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
								<br>
                                    <i class="fa fa-check-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!-- <p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=1&user_type={$user_type}">{$data[1].resolved_withinsla}</a></p>-->
               <p class="size-h1 no-margin countdown_first">
                   
                   <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                        echo "593";
                                        
                                            //echo "<a href='tot_received.php?aptid=1&status=2&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_within_sla']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                             echo "<a href='tot_received.php?aptid=1&status=2&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_within_sla']."</a>";
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='cdma_ulbwise_report.php?status=2&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['resolved_within_sla']."</a>";
                                            }
                                            else
                                            {
                                            echo "<a href='cdma_ulbwise_report.php?status=2&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['resolved_within_sla']."</a>";
                                            }
                                                
                                            }
                                            
                                            
                                        
                                        ?>
                                        
                   
                   
                   </p>                   
                                    <p class="text-muted no-margin"><span style="color:#000;">Completed with in SLA</span><br>
                                    (<?php echo "26.93 %"; ?>)
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                         
                        
                        <div class="col-md-4 col-sm-6" style="clear:both;">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
								<br>
                                    <i class="fa text-large stat-icon "><img src="images/Beyond-icon.png"/></i>
									
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=2&user_type={$user_type}">{$data[1].resolved_beyond_sla}</a></p>-->
                     <p class="size-h1 no-margin countdown_first">
                         
                          <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                        echo "1573";
                                        
                                        
                                        
                                            //echo "<a href='tot_received.php?aptid=1&status=2&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_beyond_sla']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=2&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_beyond_sla']."</a>";
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['resolved_beyond_sla']."</a>";
                                            }
                                            else
                                            {
                                            echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['resolved_beyond_sla']."</a>";
                                        
                                            }
                                            }
                                            
                                            
                                        
                                        ?>
                         
                         
                         
                                        
                                    <p class="text-muted no-margin"><span style="color:#000;">Completed Beyond SLA</span><br>
                                    (<?php echo "71.40 %"; ?>)
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-instagram">
								<br>
                                    <i class="fa fa-refresh text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=2&sla=1&user_type={$user_type}">{$data[1].pending_within_sla}</a></p>-->
    <p class="size-h1 no-margin countdown_first">
        
                                        <?php if($_SESSION['user_type']=='U')
                                        {
                                        
                                            echo "17";
                                        
                                        
                                            //echo "<a href='tot_received.php?aptid=1&status=3&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_with_sla']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=3&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_with_sla']."</a>";
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='cdma_ulbwise_report.php?status=4&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['pending_with_sla']."</a>";
                                            }
                                            else
                                            {
                                            echo "<a href='cdma_ulbwise_report.php?status=4&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['pending_with_sla']."</a>";
                                            }
                                                
                                            }
                                        
                                        ?>
                                        
        
        
                                       
                                    
                                    <p class="text-muted no-margin"><span style="color:#000;">Under Progress with in SLA</span><br>
                                    (<?php echo "0.77 %"; ?> )
                                    
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                         
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-vimeo">
								<br>
                                    <i class="fa text-large stat-icon"><img src="images/under-pro.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=2&sla=2&user_type={$user_type}">{$data[1].pending_be_sla}</a></p>-->
         <p class="size-h1 no-margin countdown_first">
             
                                        <?php if($_SESSION['user_type']=='U')
                                        {
                                        
                                            echo "0";
                                            
                                            //echo "<a href='tot_received.php?aptid=1&status=3&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_beyond_sla']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=3&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_beyond_sla']."</a>";
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['pending_beyond_sla']."</a>";
                                            }
                                            else
                                            {
                                                echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['pending_beyond_sla']."</a>";
                                            }
                                                
                                            }
                                        
                                        ?>
                                        
             
             
             
             </p>                            
                                    <p class="text-muted no-margin"><span style="color:#000;">Under Progress Beyond SLA</span><br>
                                    (<?php echo "0.00 %"; ?>)
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        
                         <div class="col-md-4 col-sm-6" style="clear:both;">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
								<br>
                                    <i class="fa fa-inr text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        <?php if($_SESSION['user_type']=='U'){
                                        
                                            echo "2";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=6&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['fin']."</a>";
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['fin']."</a>";
                                            }
                                            else
                                            {
                                            echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['fin']."</a>";
                                            }
                                                
                                            }
                                        
                                        ?>
                                        
                                        
                                        
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Financial Implication</span>c
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-danger">
								<br>
                                    <i class="fa fa-folder text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                    echo "7";
                                        
                                        
                                            //echo "<a href='deptwise_reopened.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=13'>".$reopened_completed_tot[1][13]['count']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            //echo "<a href='grievances_reopenedemp.php?app_type_id=1&status=13&user_type=".$_SESSION['user_type']."'>".$reopened_completed_tot[1][13]['count']."</a>";
                                           echo $reopened_completed_tot[1][13]['count'];
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=13&name=".$_SESSION['uid']."'>".$reopened_completed_tot[1][13]['count']."</a>";
                                            }
                                            else
                                            {
                                            echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=13&name=".$_SESSION['uid']."'>".$reopened_completed_tot[1][13]['count']."</a>";
                                        
                                            }
                                            }
                                        
                                        ?>
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened</span>
                                    <br>
                                    (<?php echo " 0.32 %"; ?>)
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-danger">
								<br>
                                    <i class="fa fa-folder-open text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                           echo "0";
                                        
                                        
                                        
                                            //echo "<a href='deptwise_reopened.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=11'>".$reopened_completed_tot[1][11]['count']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                           // echo "<a href='grievances_reopenedemp.php?app_type_id=1&status=11&user_type=".$_SESSION['user_type']."'>".$reopened_completed_tot[1][11]['count']."</a>";
                                            echo $reopened_completed_tot[1][11]['count'];
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=11&name=".$_SESSION['uid']."'>".$reopened_completed_tot[1][11]['count']."</a>";
                                            }
                                            else
                                            {
                                            echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=11&name=".$_SESSION['uid']."'>".$reopened_completed_tot[1][11]['count']."</a>";
                                            }
                                        }
                                        
                                        ?>
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened underprogress</span>
                                    <br>
                                    (<?php echo "0.00 % "; ?>)</p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6" style="clear:both;">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
								<br>
                                    <i class="fa  text-large stat-icon "><img src="images/reopen_comp.png"></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                          echo "0";
                                          
                                            //echo "<a href='deptwise_reopened.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=12'>".$reopened_completed_tot[1][12]['count']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            //echo "<a href='grievances_reopenedemp.php?app_type_id=1&status=12&user_type=".$_SESSION['user_type']."'>".$reopened_completed_tot[1][12]['count']."</a>";
                                            echo $reopened_completed_tot[1][12]['count'];
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo $reopened_completed_tot[1][12]['count'];
                                            }
                                            else
                                            {
                                            echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=12&name=".$_SESSION['uid']."'>".$reopened_completed_tot[1][12]['count']."</a>";
                                            }
                                        }
                                        
                                        ?>
                                         
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened Completed</span>
                                    <br>
                                    (<?php echo "0.00"; ?>)</p>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
								<br>
                                    <i class="fa fa-thumbs-down text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                            echo "0";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo $reopened_completed_reopened[1]['count'];
                                        }
                                        else
                                        {
                                            echo $reopened_completed_reopened[1]['count'];
                                        }
                                        
                                        ?>
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened Completed - Reopened</span>
                                    <br>
                                    (<?php echo "0.00"; ?> %)</p>
                                </div>
                                
                                
                                
                               
                                
                                
                            </section>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                         <div class="col-md-4 col-sm-6" >
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-instagram">
								<br>
                                    <i class="fa fa-times-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                       
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                            echo "10";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=10&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['rejected']."</a>";
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='cdma_ulbwise_report.php?status=10&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['rejected']."</a>";
                                            }
                                            else
                                            {
                                            echo "<a href='cdma_ulbwise_report.php?status=10&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['rejected']."</a>";
                                            }
                                        }
                                        
                                        ?>
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Rejected</span>
                                    <br>
                                    (<?php echo "0.45";?> %)
                                    </p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
								<br>
                                    <i class="fa fa-thumbs-down text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                         <?php if($_SESSION['user_type']=='U')
                                         { 
                                             
                                             echo "1";
                                        
                                            //echo "<a href='tot_received.php?aptid=1&status=11&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['unresolved']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=11&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['unresolved']."</a>";
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo $data[1]['unresolved'];
                                            }
                                            else
                                            {
                                            echo "<a href='cdma_ulbwise_report.php?status=11&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['unresolved']."</a>";
                                            }
                                        }
                                        
                                        
                                        
                                        ?>
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Un Resolved</span>
                                    <br>
                                    (<?php echo "0.05";?> %)
                                    </p>
                                </div>
                                
                                
                                
                               
                                
                                
                            </section>
                        </div>
						
						
						<div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
								<br>
                                    <i class="fa fa-cloud-download text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services.php?aptid=1&status=0&user_type={$user_type}&sla=0">{$data[1].total_received}</a></p>-->
                                    <p class="size-h1 no-margin countdown_first">
                                        <?php if($_SESSION['user_type']=='U'){
                                        
                                           
                                           echo "<a href='ward_wise_abstract.php' target='_blank'>".$data[1]['total_received']."</a>";
                                           
                                           
                                           // echo "<a href='tot_received.php?aptid=1&status=0&sla=0&user_type=".$_SESSION['user_type']."' target='_blank'>".$data[1]['total_received']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='ward_wise_abstract.php?aptid=1&status=0&sla=0&user_type=".$_SESSION['user_type']."' target='_blank'>".$data[1]['total_received']."</a>";
                                        }
                                        else
                                        {
                                            if($_SESSION['user_type']=='M')
                                            {
                                                echo "<a href='ward_wise_abstract.php?status=0&app_type_id=1&name=".$_SESSION['uid']."' target='_blank'>".$data[1]['total_received']."</a>";
                                            }
                                            else
                                            {
                                            
                                            echo "<a href='ward_wise_abstract.php?status=0&app_type_id=1&name=".$_SESSION['uid']."' target='_blank'>".$data[1]['total_received']."</a>";
                                        
                                            }
                                            }
                                        
                                        ?>
                                        
                                        
                                       
                                    </p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Total wards complaints</span></p>
                                </div>
                            </section>
                        </div>
                        
                     </div>
                
                
                
				</div>
			</div>
		</div>
				
				
			</div><!-- /.tab-pane -->
			
			<?php
			mysqli_close($conn);
			?>