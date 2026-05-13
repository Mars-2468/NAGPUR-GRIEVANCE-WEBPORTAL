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
		$abc = 'A';
		
		
		
		if($abc=='A')
				{
				
				 
				 //$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1'";
				$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";
				 
				}
				else if($abc=='U')
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
				else if($abc=='E')
				{
				    
				 
				// $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g,cs_mst c,ulbmst u where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='1'";
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".strip_tags($_SESSION['emp_id'])."' and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0'";
				 
				 $sql_od="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".strip_tags($_SESSION['emp_id'])."' and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0'";
				 
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".strip_tags($_SESSION['uid'])."' and cat3_id !='0'";
				}
				
			else if($abc=='M')
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
				
					if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' ";
				}
				else if($abc=='U')
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
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".strip_tags($_SESSION['emp_id'])."' and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' ";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".strip_tags($_SESSION['uid'])."' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
				}
				else if($abc=='M')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
				}
			
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
				
					if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='U')
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
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".strip_tags($_SESSION['emp_id'])."' and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".strip_tags($_SESSION['uid'])."' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='M')
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
				 
				 if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				else if($abc=='U')
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
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".strip_tags($_SESSION['emp_id'])."' and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				 else if($abc=='M')
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
				 
				 if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='U')
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
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
				if($abc=='M')
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
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances  where  grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
				
				}
				 if($abc=='U')
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
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='1' and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				if($abc=='M')
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
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances where  grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
				
				}
				 if($abc=='U')
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
				 if($abc=='E')
				{
				
		$sql="select count(g.grievance_id) as fin,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and grievance_status_id='6' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances g,ulbmst u,Districtmst d where  g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='6' and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
					if($abc=='M')
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
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances where grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
				
				}
				 if($abc=='U')
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
				 if($abc=='E')
				{
				
		$sql="select count(g.grievance_id) as unresolved,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and grievance_status_id='4' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='4' and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				if($abc=='M')
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
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances where grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
				
				}
				 if($abc=='U')
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
				 if($abc=='E')
				{
				
		$sql="select count(g.grievance_id) as rejected,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and grievance_status_id='10' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='10' and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				if($abc=='M')
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
				
				if($abc=='A')
		          {
		                
		                
		                
		                $sql3="select count(grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13') group by app_type_id,grievance_status_id";
		                
		            }
		            
		                
		                
		                $rs= mysqli_query($conn,$sql3);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed_tot[$row['app_type_id']][$row['grievance_status_id']]['count']=$row['count'];
		                }
		                
		               
		                
		              
		                
		                
		               
				 
				 
		
		$totalRcd =$data[1]['pendingforapproval'] + $data[1]['resolved_within_sla']+ $data[1]['resolved_beyond_sla']+ $data[1]['pending_with_sla']+$data[1]['pending_beyond_sla']+$data[1]['fin']+$reopened_completed_tot[1][13]['count']+$reopened_completed_tot[1][11]['count']+$reopened_completed_tot[1][12]['count']+$reopened_completed_reopened[1]['count']+$data[1]['rejected']+$data[1]['unresolved'];
				 
				 $pendingpercent = number_format($data[1]['pendingforapproval']/$data[1]['total_received']*100,2);
				 
				 $resolvedinslapercent = number_format($data[1]['resolved_within_sla']/$data[1]['total_received']*100,2);
				 $resolvedBeyondslapercent = number_format($data[1]['resolved_beyond_sla']/$data[1]['total_received']*100,2);
				 
				 $PendingInslapercent = number_format($data[1]['pending_with_sla']/$data[1]['total_received']*100,2);
				 $PendingBeyondslapercent = number_format($data[1]['pending_beyond_sla']/$data[1]['total_received']*100,2);
				 
				 $finimplicationspercent = number_format($data[1]['fin']/$data[1]['total_received']*100,2);
				 $reopenedPercent = number_format($reopened_completed_tot[1][13]['count']/$data[1]['total_received']*100,2);
				 $reopenedUnderProgresspercent = number_format($reopened_completed_tot[1][11]['count']/$data[1]['total_received']*100,2);
				 $reopenedCompletedpercent = number_format($reopened_completed_tot[1][12]['count']/$data[1]['total_received']*100,2);
				 $reopenedCompletedReopenedpercent = number_format($reopened_completed_reopened[1]['count']/$data[1]['total_received']*100,2);
				 $rejectedPercent = number_format($data[1]['rejected']/$data[1]['total_received']*100,2);
				 $unresolvedPercent = number_format($data[1]['unresolved']/$data[1]['total_received']*100,2);
				 
				 
				 
				$sql ="update totalcomplaints_dashboard set 
				 
				 totalReceived='".$totalRcd."',
				 pendingApproval='".$data[1]['pendingforapproval']."',
				 pendingPercent='".$pendingpercent."',
				 compInSla='".$data[1]['resolved_within_sla']."',
				 compInSlapercent='".$resolvedinslapercent."',
				 compbeyondSla='".$data[1]['resolved_beyond_sla']."',
				 compbeyondSlaPercent='".$resolvedBeyondslapercent."',
				 PendinginSla='".$data[1]['pending_with_sla']."',
				 PendinginSlaPercent='".$PendingInslapercent."',
				 PendingBeyondSla='".$data[1]['pending_beyond_sla']."',
				 PendingBeyondSlaPercent='".$PendingBeyondslapercent."',
				 financialImplication='".$data[1]['fin']."',
				 financialImplicationPercent='".$finimplicationspercent."',
				 reopend='".$reopened_completed_tot[1][13]['count']."',
				 reopendPercent='".$reopenedPercent."',
				 reopenedUnderprogress='".$reopened_completed_tot[1][11]['count']."',
				 reopenedUnderprogressPercent='".$reopenedUnderProgresspercent."',
				 reopenedCompleted='".$reopened_completed_tot[1][12]['count']."',
				 reopenedCompletedPercent='".$reopenedCompletedpercent."',
				 reopenedCompletedReopend='".$reopened_completed_reopened[1]['count']."',
				 reopenedCompletedReopendPercent='".$reopenedCompletedReopenedpercent."',
				 rejected='".$data[1]['rejected']."',
				 rejectedPercent='".$rejectedPercent."',
				 unResolved='".$data[1]['unresolved']."',
				 unResolvedPercent='".$unresolvedPercent."' where type='1'";
				 
				 mysqli_query($conn,$sql);
				 
				 
				 /*** servies ***/
				 
				 
				 if($abc=='A')
				{
				
				 
				$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='2' and cat3_id !='0'";
				 
				}
				else if($abc=='U')
				{
				 if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where ulbid IN('208','210') and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
				        $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where ulbid='".$_SESSION['ulbid']."' and app_type_id='2' and cat3_id !='0'";
				
    				 }
    				 }
				else if($abc=='E')
				{
				 
				  $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and 
				 emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['total_received']=$row['date_regd'];
					
				 }
				 
				 	 if($data[2]['total_received']=='')
				{
				    $data[2]['total_received']=0;
				}
				// resolved with in sla
				
					if($abc=='A')
				{
				
				 
				 $sql="select count(grievance_id) as date_regd,app_type_id 
				from grievances  where 
				grievance_status_id IN('3','8','9') and app_type_id='2' and sla_status='1' and cat3_id !='0'";
				}
				else if($abc=='U')
				{
				    
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as date_regd,app_type_id 
				from grievances where 
				grievance_status_id IN('3','8','9') and ulbid IN('208','210') and app_type_id='2' and sla_status='1' and cat3_id !='0'";
    				 }
    				 else
    				 {
				 
				  $sql="select count(grievance_id) as date_regd,app_type_id 
				from grievances where 
				grievance_status_id IN('3','8','9') and ulbid='".$_SESSION['ulbid']."' and app_type_id='2' and sla_status='1' and cat3_id !='0'";
    				 }
				}
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['resolved_within_sla']=$row['date_regd'];
					
				 }
				 
				 if($data[2]['resolved_within_sla']=='')
				{
				    $data[2]['resolved_within_sla']=0;
				}
				// resolved beyond sla
				
					if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='U')
				{
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210')  and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
    				 }
    				 else
    				 {
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."'  and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
    				 }
				}
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['resolved_beyond_sla']=$row['date_regd'];
					
				 }
				 
				  if($data[2]['resolved_beyond_sla']=='')
				{
				    $data[2]['resolved_beyond_sla']=0;
				}
				 
				 // under progress with in sla
				 
				 if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				else if($abc=='U')
				{
				 if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and 
				 app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
    				 }
    				 else
    				 {
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."' and 
				 app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
    				 }
				}
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['pending_with_sla']=$row['date_regd'];
					
				 }
				 
				 if($data[2]['pending_with_sla']=='')
				{
				    $data[2]['pending_with_sla']=0;
				}
				 
				 
				 // under progress beyond sla
				 
				 if($abc=='A')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='U')
				{
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and 
				 app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
    				 }
    				 else
    				 {
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."' and 
				 app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
    				 }
				}
				else if($abc=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
				else if($abc=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
				}
			
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['pending_beyond_sla']=$row['date_regd'];
					
				 }
				 
				 
				  if($data[2]['pending_beyond_sla']=='')
				{
				    $data[2]['pending_beyond_sla']=0;
				}
				 
				/********pending Approval**********/	
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where grievance_status_id='1' and app_type_id='2' and cat3_id !='0'";
				
				}
				 if($abc=='U')
				{
				    
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='1' and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where 
		ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='2' and cat3_id !='0'";
    				 }
		
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='1' and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['pendingforapproval']=$row['pendingforapproval'];
				}
				
				if($data[2]['pendingforapproval']=='')
				{
				    $data[2]['pendingforapproval']=0;
				}
				
				
			/********end pending approval****/	
			
			
			/********Financial implications**********/	
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances where grievance_status_id='6' and app_type_id='2' and cat3_id !='0'";
				
				}
				 if($abc=='U')
				{
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				    $sql="select count(grievance_id) as fin,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='6' and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		$sql="select count(grievance_id) as fin,app_type_id from grievances where 
		ulbid='".$_SESSION['ulbid']."' and grievance_status_id='6' and app_type_id='2' and cat3_id !='0'";
    				 }
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='6' and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				 if($abc=='E')
				{
				
		$sql="select count(g.grievance_id) as fin,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and grievance_status_id='6' and app_type_id='2' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['fin']=$row['fin'];
				}
				
			if($data[2]['fin']=='')
				{
				    $data[2]['fin']=0;
				}
				
				
			/********end pending approval****/	
			
			
			
			
				/********Un resolved**********/	
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances g,standard_services c,ulbmst u where  g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and  grievance_status_id='4' and app_type_id='2' and cat3_id !='0'";
				
				}
				 if($abc=='U')
				{
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				   $sql="select count(grievance_id) as unresolved,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='4' and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
				
		$sql="select count(grievance_id) as unresolved,app_type_id from grievances where 
		ulbid='".$_SESSION['ulbid']."' and grievance_status_id='4' and app_type_id='2' and cat3_id !='0'";
    				 }
		
		
				}
				 if($abc=='E')
				{
				
		$sql="select count(g.grievance_id) as unresolved,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and grievance_status_id='4' and app_type_id='2' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='4' and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['unresolved']=$row['unresolved'];
				}
				
				
					if($data[2]['unresolved']=='')
				{
				    $data[2]['unresolved']=0;
				}
			
				
				
			/********end pending approval****/
			
			
			
			
				/******** Rejected **********/	
				
				if($abc=='A')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances where grievance_status_id='10' and app_type_id='2' and cat3_id !='0'";
				
				}
				 if($abc=='U')
				{
				
				    if($_SESSION['ulbid']==(int)$mergedulbs)
    				 {
    				   $sql="select count(grievance_id) as rejected,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='10' and app_type_id='2' and cat3_id !='0'";
    				 }
    				 else
    				 {
		$sql="select count(grievance_id) as rejected,app_type_id from grievances where 
		ulbid='".$_SESSION['ulbid']."' and grievance_status_id='10' and app_type_id='2' and cat3_id !='0'";
    				 }
		
		
				}
				 if($abc=='E')
				{
				
		$sql="select count(g.grievance_id) as rejected,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and grievance_status_id='10' and app_type_id='2' and gt.disposal_status !=5 and cat3_id !='0'";
		
		
		
				}
				
				if($abc=='R')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances g,ulbmst u,Districtmst d where  g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='10' and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'";
			
				}
				
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				 $data[$row['app_type_id']]['rejected']=$row['rejected'];
				}
					if($data[2]['rejected']=='')
				{
				    $data[2]['rejected']=0;
				}
			
				
				
			/********end pending approval****/
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			/** re-opened applicatons **/
				
				if($abc=='A')
		          {
		                
		                $sql ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='11'  group by app_type_id";
		                $sql2 ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='12' group by app_type_id";
		            
		                
		                
		            }
		            else if($abc=='U')
		            {
		                 if($_SESSION['ulbid']==(int)$mergedulbs)
        				 {
        				   $sql ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='11' and ulbid IN('208','210') group by app_type_id";
    		                $sql2 ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='12' and ulbid IN('208','210') group by app_type_id";
        				 }
        				 else
        				 {
    		                $sql ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='11' and ulbid='".$_SESSION['ulbid']."' group by app_type_id";
    		                $sql2 ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id='12' and ulbid='".$_SESSION['ulbid']."' group by app_type_id";
        				 }
		                
		            }
		            else if($abc=='E')
				        {
				        }
				        else if($abc=='R')
		                {
		                }
		                
		                $rs= mysqli_query($conn,$sql);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened[$row['app_type_id']]['count']=$row['count'];
		                }
		                $rs= mysqli_query($conn,$sql2);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed[$row['app_type_id']]['count']=$row['count'];
		                }
		               
				 
				 
			$totalRcd =$data[2]['pendingforapproval'] + $data[2]['resolved_within_sla']+ $data[2]['resolved_beyond_sla']+ $data[2]['pending_with_sla']+$data[1]['pending_beyond_sla']+$data[2]['fin']+$reopened_completed_tot[12][13]['count']+$reopened_completed_tot[2][11]['count']+$reopened_completed_tot[2][12]['count']+$reopened_completed_reopened[2]['count']+$data[2]['rejected']+$data[2]['unresolved'];
				 $pendingpercent = number_format($data[2]['pendingforapproval']/$data[2]['total_received']*100,2);
				 
				 $resolvedinslapercent = number_format($data[2]['resolved_within_sla']/$data[2]['total_received']*100,2);
				 $resolvedBeyondslapercent = number_format($data[2]['resolved_beyond_sla']/$data[2]['total_received']*100,2);
				 
				 $PendingInslapercent = number_format($data[2]['pending_with_sla']/$data[2]['total_received']*100,2);
				 $PendingBeyondslapercent = number_format($data[2]['pending_beyond_sla']/$data[2]['total_received']*100,2);
				 
				 $finimplicationspercent = number_format($data[2]['fin']/$data[2]['total_received']*100,2);
				 $reopenedPercent = number_format($reopened_completed_tot[2][13]['count']/$data[2]['total_received']*100,2);
				 $reopenedUnderProgresspercent = number_format($reopened_completed_tot[2][11]['count']/$data[2]['total_received']*100,2);
				 $reopenedCompletedpercent = number_format($reopened_completed_tot[2][12]['count']/$data[2]['total_received']*100,2);
				 $reopenedCompletedReopenedpercent = number_format($reopened_completed_reopened[2]['count']/$data[2]['total_received']*100,2);
				 $rejectedPercent = number_format($data[2]['rejected']/$data[2]['total_received']*100,2);
				 $unresolvedPercent = number_format($data[2]['unresolved']/$data[2]['total_received']*100,2);
		$sql ="update totalcomplaints_dashboard set 
				 
				 totalReceived='".$totalRcd."',
				 pendingApproval='".$data[2]['pendingforapproval']."',
				 pendingPercent='".$pendingpercent."',
				 compInSla='".$data[2]['resolved_within_sla']."',
				 compInSlapercent='".$resolvedinslapercent."',
				 compbeyondSla='".$data[2]['resolved_beyond_sla']."',
				 compbeyondSlaPercent='".$resolvedBeyondslapercent."',
				 PendinginSla='".$data[2]['pending_with_sla']."',
				 PendinginSlaPercent='".$PendingInslapercent."',
				 PendingBeyondSla='".$data[2]['pending_beyond_sla']."',
				 PendingBeyondSlaPercent='".$PendingBeyondslapercent."',
				 financialImplication='".$data[2]['fin']."',
				 financialImplicationPercent='".$finimplicationspercent."',
				 reopend='".$reopened_completed_tot[2][13]['count']."',
				 reopendPercent='".$reopenedPercent."',
				 reopenedUnderprogress='".$reopened_completed_tot[2][11]['count']."',
				 reopenedUnderprogressPercent='".$reopenedUnderProgresspercent."',
				 reopenedCompleted='".$reopened_completed_tot[2][12]['count']."',
				 reopenedCompletedPercent='".$reopenedCompletedpercent."',
				 reopenedCompletedReopend='".$reopened_completed_reopened[2]['count']."',
				 reopenedCompletedReopendPercent='".$reopenedCompletedReopenedpercent."',
				 rejected='".$data[2]['rejected']."',
				 rejectedPercent='".$rejectedPercent."',
				 unResolved='".$data[2]['unresolved']."',
				 unResolvedPercent='".$unresolvedPercent."' where type='2'";
				 mysqli_query($conn,$sql);

			mysqli_close($conn);
			?>