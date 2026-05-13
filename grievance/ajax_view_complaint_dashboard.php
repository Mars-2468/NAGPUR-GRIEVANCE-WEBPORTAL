<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
	    ini_set('display_errors',0);
	    require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();

		
		// Total received
		
		//echo $_SESSION['emp_id'] ;
		
		if($_SESSION['user_type']=='A')
				{
				
				 
				$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id=? and cat3_id !=?";
				 $query=$conn->prepare($sql);
				
				$app_type=1;
				$cat3_id=0;
				$query->bind_param("ii",$app_type,$cat3_id);
       
				 
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				  
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid=? and app_type_id=? and cat3_id !=? ";
				 
				  $query=$conn->prepare($sql);
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				$app_type_id=1;
				$cat3_id=0;
				$query->bind_param("sii",$ulbid,$app_type_id,$cat3_id);
				 
				 
				}
				else if($_SESSION['user_type']=='E')
				{
				    
				 
			
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id=? and gt.disposal_status !=? and app_type_id=? and cat3_id !=?";
				 $query=$conn->prepare($sql);
				$emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
				$disposal_status=5;
				$app_type_id=1;
				$cat3_id=0;
				$query->bind_param("iiii",$emp_id,$disposal_status,$app_type_id,$cat3_id);
				
				
				
				 $sql_od="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g 
				 where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and 
				 app_type_id='1' and cat3_id !='0'";
				 
			
			
			
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,
				 Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? and cat3_id !=?";
			
			$query=$conn->prepare($sql);
			$app_type_id=1;
			$rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
			$cat3_id=0;
			$query->bind_param("isi",$app_type_id,$rdma,$cat3_id);
				}
				
				$query->execute();
	    $rs=$query->get_result();
			        
			         while($row = $rs->fetch_assoc())
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
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and sla_status=? and cat3_id !=? ";
				$query=$conn->prepare($sql);
				$app_type_id=1;
				$id3=3;
				$id8=8;
				$id9=9;
				$sla_status=1;
				$cat3_id=0;
				$query->bind_param("iiiiii",$app_type_id,$id3,$id8,$id9,$sla_status,$cat3_id);
			
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				 
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."' and 
				  app_type_id=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and sla_status=? and cat3_id !=?";
				 	$query=$conn->prepare($sql);
				 	
			$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
			$app_type_id=1;
			$id3=3;
			$id8=8;
			$id9=9;
			$sla_status=1;
			$cat3_id=0;
				$query->bind_param("siiiiii",$ulbid,$app_type_id,$id3,$id8,$id9,$sla_status,$cat3_id);
			
		
			
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id=? and gt.disposal_status !=? and app_type_id=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and sla_status=? and cat3_id !=? ";
				$query=$conn->prepare($sql);
				
			$emp_id=$_SESSION['emp_id'];
			$disposal_status=5;
			$app_type_id=1;
			$id3=3;
			$id8=8;
			$id9=9;
			$sla_status=1;
			$cat3_id=0;
				$query->bind_param("iiiiiiii",$emp_id,$disposal_status,$app_type_id,$id3,$id8,$id9,$sla_status,$cat3_id);
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and sla_status=? and cat3_id !=?";
					$query=$conn->prepare($sql);
					
			$app_type_id=1;
			$rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
			$id3=3;
			$id8=8;
			$id9=9;
			$sla_status=1;
			$cat3_id=0;
				$query->bind_param("isiiiii",$app_type_id,$rdma,$id3,$id8,$id9,$sla_status,$cat3_id);
				    
				}
			
			        	$query->execute();
	    $rs=$query->get_result();
			  
			         while($row =  $rs->fetch_assoc())
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
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and sla_status=? and cat3_id !='0'";
				$query=$conn->prepare($sql);
					
			$app_type_id=1;
			$id3=3;
			$id8=8;
			$id9=9;
			$sla_status=2;
			$cat3_id=0;
				$query->bind_param("iiiiii",$app_type_id,$id3,$id8,$id9,$sla_status,$cat3_id);
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."' and 
				  app_type_id=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and sla_status=? and cat3_id !=?";
				
				    	$query=$conn->prepare($sql);
			$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
			$app_type_id=1;
			$id3=3;
			$id8=8;
			$id9=9;
			$sla_status=2;
			$cat3_id=0;
						$query->bind_param("siiiiii",$ulbid,$app_type_id,$id3,$id8,$id9,$sla_status,$cat3_id);
				    
				    
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id=? and gt.disposal_status !=? and app_type_id='1' and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and sla_status=? and cat3_id !=?";
					$query=$conn->prepare($sql);
					$emp_id=$_SESSION['emp_id'];
					$disposal_status=5;
					$app_type_id=1;
					$id3=3;
		  	        $id8=8;
			        $id9=9;
			        $sla_status=2;
		   	        $cat3_id=0;
						$query->bind_param("iiiiiiii",$emp_id,$disposal_status,$app_type_id,$id3,$id8,$id9,$sla_status,$cat3_id);
					
					
				    
				    
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and sla_status=? and cat3_id !=?";
				$query=$conn->prepare($sql);
					$app_type_id=1;
					$rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
					$id3=3;
		  	        $id8=8;
			        $id9=9;
			        $sla_status=2;
		   	        $cat3_id=0;
		   	        $query->bind_param("isiiiii",$app_type_id,$rdma,$id3,$id8,$id9,$sla_status,$cat3_id);
			
				}
			
			       	$query->execute();
	    $rs=$query->get_result();
			         while($row = $rs->fetch_assoc())
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
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id=? and grievance_status_id =? and sla_status=? and cat3_id !=?";
					$query=$conn->prepare($sql);
					
				    $app_type_id=1;
				    $grievance_status_id=2;
				    $sla_status=2;
		   	        $cat3_id=0;
		   	        $query->bind_param("iiii",$app_type_id, $grievance_status_id,$sla_status,$cat3_id);
				    
				    
				    
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where ulbid=? and app_type_id=? and grievance_status_id =? and sla_status=? and cat3_id !=?";
				$query=$conn->prepare($sql);
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				
				$app_type_id=1;
				 $grievance_status_id=2;
				    $sla_status=2;
		   	        $cat3_id=0;
		   	         $query->bind_param("siiii",$ulbid,$app_type_id, $grievance_status_id,$sla_status,$cat3_id);
				
			
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id=? and gt.disposal_status !=? and app_type_id=? and grievance_status_id =? and sla_status=? and cat3_id !=?";
					$query=$conn->prepare($sql);
					$emp_id=$_SESSION['emp_id'];
					$disposal_status=5;
					$app_type_id=1;
				    $grievance_status_id=2;
				    $sla_status=2;
		   	        $cat3_id=0;
					$query->bind_param("iiiii",$emp_id,	$disposal_status,$app_type_id,$grievance_status_id,$sla_status,$cat3_id);
					
				    
				    
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? and grievance_status_id =? and sla_status=? and cat3_id !=?";
			
				$query=$conn->prepare($sql);
				$app_type_id=1;
				$rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				$grievance_status_id=2;
				    $sla_status=2;
		   	        $cat3_id=0;
					$query->bind_param("isiii",$app_type_id,$rdma,$grievance_status_id,$sla_status,$cat3_id);
				
			
			
			
				}
			
			       	$query->execute();
	    $rs=$query->get_result();
			         while($row = $rs->fetch_assoc())
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
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id=? and grievance_status_id =? and sla_status=? and cat3_id !=?";
				$query=$conn->prepare($sql);
					$app_type_id=1;
				    $grievance_status_id=2;
				   $sla_status=2;
		   	        $cat3_id=0;
		   	        	$query->bind_param("iiii",$app_type_id,$grievance_status_id,$sla_status,$cat3_id);
			
			
			
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid=? and 
				 app_type_id=? and grievance_status_id =? and sla_status=? and cat3_id !=?";
					$query=$conn->prepare($sql);
					$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
					$app_type_id=1;
				    $grievance_status_id=2;
				   $sla_status=2;
		   	        $cat3_id=0;
		   	        	$query->bind_param("siiii",	$ulbid,$app_type_id,$grievance_status_id,$sla_status,$cat3_id);
					
				    
				    
				    
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and emp_id=? and gt.disposal_status !=? and app_type_id=? and grievance_status_id =? and sla_status=? and gt.disposal_status !=? and cat3_id !=?";
					$query=$conn->prepare($sql);
					
				    $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
				    $disposal_status=5;
				    $app_type_id=1;
				    $grievance_status_id=2;
				    $sla_status=2;
				    $disposal_status=5;
				     $cat3_id=0;
				     $query->bind_param("iiiiiii", $emp_id, $disposal_status, $app_type_id,$grievance_status_id,$sla_status, $disposal_status,$cat3_id);
				    
				    
				    
				    
				    
				}
				else if($_SESSION['user_type']=='R')
				{
				
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? and grievance_status_id =? and sla_status=? and cat3_id !=?";
			$query=$conn->prepare($sql);
			$app_type_id=1;
			$rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
			$grievance_status_id=2;
			$sla_status=2;
			 $cat3_id=0;
			  $query->bind_param("isiii",$app_type_id,$rdma,$grievance_status_id,$sla_status,$cat3_id);
				}
			
			      $query->execute();
	    $rs=$query->get_result();
			  
			         while($row = $rs->fetch_assoc())
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
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances  where  grievance_status_id=? and app_type_id=? and cat3_id !=?";
					$query=$conn->prepare($sql);
					
			$grievance_status_id=1;
			
			$app_type_id=1;
			
			$cat3_id=0;
			$query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
			
				}
				 if($_SESSION['user_type']=='U')
				{
				
		$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where 
	ulbid=? and grievance_status_id=? and app_type_id=? and cat3_id !=?";
		
		$query=$conn->prepare($sql);
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		
		$grievance_status_id=1;
		$app_type_id=1;
		$cat3_id=0;
			$query->bind_param("siii",$ulbid,$grievance_status_id,$app_type_id,$cat3_id);
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id=? and app_type_id=? and d.rdma=? and cat3_id !=?";
			
				$query=$conn->prepare($sql);
				$grievance_status_id=1;
				
				$rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
			$cat3_id=0;
				$query->bind_param("isi",$grievance_status_id,$rdma,$cat3_id);
			
				}
				
					$query->execute();
	    $rs=$query->get_result();	
				 
				 while($row =$rs->fetch_assoc())
				 
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
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances where  grievance_status_id=? and app_type_id=? and cat3_id !=?";
					$query=$conn->prepare($sql);
					
				$grievance_status_id=6;
				$app_type_id=1;
				
				    $cat3_id=0;
				    $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
				    
				}
				 if($_SESSION['user_type']=='U')
				{
				
		$sql="select count(grievance_id) as fin,app_type_id from grievances where 
		ulbid=? and grievance_status_id=? and app_type_id=? and cat3_id !=?";
			$query=$conn->prepare($sql);
			$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
			
		$grievance_status_id=6;
		$app_type_id=1;
		$cat3_id=0;
		 $query->bind_param("siii",	$ulbid,$grievance_status_id,$app_type_id,$cat3_id);
				}
				 if($_SESSION['user_type']=='E')
				{
				
		$sql="select count(g.grievance_id) as fin,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id=? and grievance_status_id=? and app_type_id=? and gt.disposal_status !=? and cat3_id !=?";
			$query=$conn->prepare($sql);
			$emp_id=$_SESSION['emp_id'];
			$grievance_status_id=6;
			$app_type_id=1;
			$disposal_status=5;
			$cat3_id=0;
			 $query->bind_param("iiii",	$emp_id,$grievance_status_id,$app_type_id,	$disposal_status,$cat3_id);
			
		
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances g,ulbmst u,Districtmst d where  g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id=? and app_type_id=? and d.rdma=? and cat3_id !=?";
				$query=$conn->prepare($sql);
				
			$grievance_status_id=6;
			$app_type_id=1;
			$rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
			$cat3_id=0;
			 $query->bind_param("iisi",	$grievance_status_id,$app_type_id,$rdma,$cat3_id);
			
			
				}
				
				  $query->execute();
	    $rs=$query->get_result();
			  
		
		while($row = $rs->fetch_assoc())
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
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances where grievance_status_id=? and app_type_id=? and cat3_id !=?";
				
				$query=$conn->prepare($sql);
				$grievance_status_id=4;
				$app_type_id=1;
				$cat3_id=0;
					 $query->bind_param("iii",	$grievance_status_id,$app_type_id,$cat3_id);
				
			
			
				}
				 if($_SESSION['user_type']=='U')
				{
				
		$sql="select count(grievance_id) as unresolved,app_type_id from grievances where ulbid=? and grievance_status_id=? and app_type_id=? and cat3_id !=?";
			$query=$conn->prepare($sql);
				$query=$conn->prepare($sql);
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				$grievance_status_id=4;
				$app_type_id=1;
				$cat3_id=0;
			 $query->bind_param("siii",	$ulbid,	$grievance_status_id,$app_type_id,$cat3_id);
		
				}
				 if($_SESSION['user_type']=='E')
				{
				
		$sql="select count(g.grievance_id) as unresolved,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id=? and grievance_status_id=? and app_type_id=? and gt.disposal_status !=? and cat3_id !=?";
		$query=$conn->prepare($sql);
		$emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
		
		$grievance_status_id=4;
				$app_type_id=1;
				$disposal_status=5;
				$cat3_id=0;
			 $query->bind_param("iiiii",$emp_id,$grievance_status_id,$app_type_id,$disposal_status,$cat3_id);
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id=? and app_type_id=? and d.rdma=? and cat3_id !=?";
				$query=$conn->prepare($sql);
				$grievance_status_id=4;
				$app_type_id=1;
				$rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				$cat3_id=0;
				 $query->bind_param("iisi",$emp_id,$grievance_status_id,$app_type_id,$rdma,$cat3_id);
				}
				
				  $query->execute();
	    $rs=$query->get_result();
			  
		
		while($row = $rs->fetch_assoc())
				 
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
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances where grievance_status_id=? and app_type_id=? and cat3_id !=?";
				
					$query=$conn->prepare($sql);
					
				    $grievance_status_id=10;
				    
				    $app_type_id=1;
				    $cat3_id=0;
				     $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
				    
				}
				 if($_SESSION['user_type']=='U')
				{
				
		$sql="select count(grievance_id) as rejected,app_type_id from grievances where ulbid=? and grievance_status_id=? and app_type_id=? and cat3_id !=?";
		
			$query=$conn->prepare($sql);
			$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
			 $grievance_status_id=10;
				    
				    $app_type_id=1;
				    $cat3_id=0;
				     $query->bind_param("siii",$ulbid,$grievance_status_id,$app_type_id,$cat3_id);
		
				}
				 if($_SESSION['user_type']=='E')
				{
				
		$sql="select count(g.grievance_id) as rejected,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id=? and grievance_status_id=? and app_type_id=? and gt.disposal_status !=? and cat3_id !=?";
			$query=$conn->prepare($sql);
			
		$emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
		 $grievance_status_id=10;
				$disposal_status=5;    
				    $app_type_id=1;
				      $cat3_id=0;
				        $query->bind_param("iiiii",$emp_id,$grievance_status_id,$disposal_status,$app_type_id,$cat3_id);
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id=? and app_type_id=? and d.rdma=? and cat3_id !=?";
			$query=$conn->prepare($sql);
				 $grievance_status_id=10;
			$app_type_id=1;
			$rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
			$cat3_id=0;
			$query->bind_param("iisii",$grievance_status_id,$app_type_id,$rdma,$cat3_id);
			
				}
				
				$query->execute();
	    $rs=$query->get_result();
			  
		
		while($row = $rs->fetch_assoc())
				 
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
		                
		                
		                
		                $sql3="select count(grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) group by app_type_id,grievance_status_id";
		                
		          	$query=$conn->prepare($sql);
		          	$id11=11;
		          	$id12=12;
		          	$id13=13;
		          		$query->bind_param("iii",$id11,$id12,$id13);
		          
		          
		            }
		            else if($_SESSION['user_type']=='U')
		            {
		                
		               
		            $sql3 ="select IFNULL(count(gt.grievance_id),0) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid=? and gt.(disposal_status=? or disposal_status=?) and is_reopened_yn=?  and g.grievance_status_id =? group by app_type_id";
				    	$query=$conn->prepare($sql);
				    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				    	$disposal_status9=9;
				    	$disposal_status12=12;
				    	$is_reopened_yn=1;
				    	$grievance_status_id=13;
				    	$query->bind_param("siiii",	$ulbid,	$disposal_status9,	$disposal_status12,$is_reopened_yn,	$grievance_status_id);
				    	
				    
				    
				    
				     $sql4 ="select IFNULL(count(g.grievance_id),0) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.(disposal_status=? or disposal_status=?) and ulbid=? group by app_type_id, grievance_status_id";
		            $query=$conn->prepare($sql);
		            	$disposal_status11=11;
				    	$disposal_status12=12;
				    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				    	$query->bind_param("iis",$disposal_status11,$disposal_status12,$ulbid);
		                
		            }
		            else if($_SESSION['user_type']=='E')
				        {
				            
				           
				          
				        
				        $sql3 ="select IFNULL(count(gt.grievance_id),0) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and emp_id=? and gt.(disposal_status=? or disposal_status=?) and is_reopened_yn=?  and g.grievance_status_id =? group by app_type_id";
				           $query=$conn->prepare($sql);
				           $emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
				           	$disposal_status9=9;
				    	$disposal_status12=12;
				    	$is_reopened_yn=1;
				    	$grievance_status_id=13;
				        $query->bind_param("iiiii",$emp_id,$disposal_status9,$disposal_status12,$is_reopened_yn,$grievance_status_id);
				        
				        
				        $sql4 ="select IFNULL(count(DISTINCT g.grievance_id),0) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.(disposal_status=? or disposal_status=?) and gt.emp_id=? group by app_type_id, grievance_status_id";
				        
				             $query=$conn->prepare($sql);
				             $disposal_status11=11;
				    	$disposal_status12=12;
				    	$emp_id=htmlspecialchars(strip_tags($_SESSION['emp_id']));
				    	 $query->bind_param("iii",$disposal_status11,$disposal_status12,$emp_id);
				            
				            
				        }
				        else if($_SESSION['user_type']=='R')
		                {
		                    
		                  
		                  
		                   $sql3="select IFNULL(count(gt.grievance_id),0) as count,app_type_id from grievances g,grievances_transactions gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma=? and cat3_id !=? and gt.(disposal_status=? or disposal_status=?) and is_reopened_yn=?  and g.grievance_status_id =? group by app_type_id";
		                    $query=$conn->prepare($sql);
		                    $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
		                    $cat3_id=0;
		                    	$disposal_status9=9;
				    	$disposal_status12=12;
				    	$is_reopened_yn=1;
		                  $grievance_status_id=13;
		                   $sql3->bind_param("siiiii",$rdma, $cat3_id,$disposal_status9,$disposal_status12,$is_reopened_yn,$grievance_status_id);
		                   
		                   
		                   
		                   $sql4="select IFNULL(count(g.grievance_id),0) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma=? and cat3_id !=? and gt.(disposal_status=? or disposal_status=?)  group by app_type_id, grievance_status_id";
		                    $sql4=$conn->prepare($sql);
		                    
		                      $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
		                    $cat3_id=0;
		                    	$disposal_status11=11;
				    	$disposal_status12=12;
		                     $sql4->bind_param("siii",$rdma, $cat3_id,$disposal_status11,$disposal_status12);
		                }
		                
		                
		                $sql3->execute();
	                    $rs3=$sql3->get_result();
		                
		                while($row = $rs3->fetch_assoc())
		                {
		                    $reopened_completed_tot[$row['app_type_id']]['13']['count']=$row['count'];
		                }
		                
		                if($reopened_completed_tot[1]['13']['count']=='')
		                {
		                    $reopened_completed_tot[1]['13']['count']=0;
		                }
		                
		              
		                
		                
		                 $sql4->execute();
	                    $rs4=$sql4->get_result();
		                
		                while($row = $rs4->fetch_assoc())
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
		                
		               
				 
				
				 	$query->close();
				 
				 
		
?>

<div class="boxed">
                <!-- Title Bart Start -->
                <!-- <h4>Total Number of Complaints</h4>-->
               <div class="bash_heading row  m-b20"> Total Number of Complaints  </div> 
                <!-- Title Bart End -->
                <div >
				
                <div class="row dashboard-stats">
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa fa-cloud-download text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services.php?aptid=1&status=0&user_type={$user_type}&sla=0">{$data[1].total_received}</a></p>-->
                                    <p class="size-h1 no-margin countdown_first">
                                        <?php if($_SESSION['user_type']=='U'){
                                        
                                           
                                           //echo "<a href='rep_comp_dept_abs_comp.php' target='_blank'>".$data[1]['total_received']."</a>";
                                           
                                           
                                            echo "<a href='tot_received.php?aptid=1&status=0&sla=0&user_type=".$_SESSION['user_type']."' target='_blank'>".$data[1]['total_received']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=0&sla=0&user_type=".$_SESSION['user_type']."' target='_blank'>".$data[1]['total_received']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=0&app_type_id=1&name=".$_SESSION['uid']."' target='_blank'>".$data[1]['total_received']."</a>";
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
                                    <i class="fa fa-minus-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first">{if $data[1].pending_apprval eq ''}0{else}<a href="pending_approval.php?grievance_status_id=1&aptid=1">{$data[1].pending_apprval}</a>{/if}</p>-->
                        <p class="size-h1 no-margin countdown_first">
                            
                            <?php if($_SESSION['user_type']=='U'){
                                        
                                            echo "<a href='tot_received.php?aptid=1&status=1&sla=0&user_type=".$_SESSION['user_type']."'>".$data[1]['pendingforapproval']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo $data[1]['pendingforapproval'];
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=1&app_type_id=1&name=".$_SESSION['uid']."' target='_blank'>".$data[1]['pendingforapproval']."</a>";
                                        }
                                        
                                        ?>
                            
                            
                             
                                    <p class="text-muted no-margin "><span style="color:#000;">Pending for Approval</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
                                    <i class="fa fa-check-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!-- <p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=1&user_type={$user_type}">{$data[1].resolved_withinsla}</a></p>-->
               <p class="size-h1 no-margin countdown_first">
                   
                   <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                        //echo "<a href='rep_comp_dept_abs_comp.php' target='_blank'>".$data[1]['resolved_within_sla']."</a>";
                                        
                                        echo "<a href='tot_received.php?aptid=1&status=2&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_within_sla']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                             echo "<a href='tot_received.php?aptid=1&status=2&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_within_sla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=2&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['resolved_within_sla']."</a>";
                                        }
                                        
                                        ?>
                   
                   
                   </p>                   
                                    <p class="text-muted no-margin"><span style="color:#000;">Completed with in SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6" style="clear:both;">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
                                    <i class="fa text-large stat-icon "><img src="images/Beyond-icon.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=2&user_type={$user_type}">{$data[1].resolved_beyond_sla}</a></p>-->
                     <p class="size-h1 no-margin countdown_first">
                         
                          <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                       // echo "<a href='rep_comp_dept_abs_comp.php' target='_blank'>".$data[1]['resolved_beyond_sla']."</a>";
                                        
                                        echo "<a href='tot_received.php?aptid=1&status=2&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_beyond_sla']."</a>";
                                        
                              
                          }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=2&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_beyond_sla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['resolved_beyond_sla']."</a>";
                                        }
                                        
                                        ?>
                         
                         
                         
                                        
                                    <p class="text-muted no-margin"><span style="color:#000;">Completed Beyond SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-instagram">
                                    <i class="fa fa-refresh text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=2&sla=1&user_type={$user_type}">{$data[1].pending_within_sla}</a></p>-->
    <p class="size-h1 no-margin countdown_first">
        
                                        <?php if($_SESSION['user_type']=='U')
                                        {
                                        
                                            //echo "<a href='rep_comp_dept_abs_comp.php' target='_blank'>".$data[1]['pending_with_sla']."</a>";
                                        
                                        
                                            echo "<a href='tot_received.php?aptid=1&status=3&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_with_sla']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=3&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_with_sla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=4&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['pending_with_sla']."</a>";
                                        }
                                        
                                        ?>
        
        
                                       
                                    
                                    <p class="text-muted no-margin"><span style="color:#000;">Under Progress with in SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-vimeo">
                                    <i class="fa text-large stat-icon"><img src="images/under-pro.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=2&sla=2&user_type={$user_type}">{$data[1].pending_be_sla}</a></p>-->
         <p class="size-h1 no-margin countdown_first">
             
                                        <?php if($_SESSION['user_type']=='U')
                                        {
                                        
                                            //echo "<a href='rep_comp_dept_abs_comp.php' target='_blank'>".$data[1]['pending_beyond_sla']."</a>";
                                            
                                            echo "<a href='tot_received.php?aptid=1&status=3&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_beyond_sla']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=3&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_beyond_sla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['pending_beyond_sla']."</a>";
                                        }
                                        
                                        ?>
             
             
             
             </p>                            
                                    <p class="text-muted no-margin"><span style="color:#000;">Under Progress Beyond SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                         <div class="col-md-4 col-sm-6" style="clear:both;">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa fa-inr text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        <?php if($_SESSION['user_type']=='U'){
                                        
                                            echo "<a href='tot_received.php?aptid=1&status=6&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['fin']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=6&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['fin']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['fin']."</a>";
                                        }
                                        
                                        ?>
                                        
                                        
                                        
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Financial Implication</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-danger">
                                    <i class="fa fa-folder text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                    //echo "<a href='rep_comp_dept_abs_comp.php' target='_blank'>".$reopened_completed_tot[1][13]['count']."</a>";
                                        
                                        
                                        echo "<a href='deptwise_reopened.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=13'>".$reopened_completed_tot[1][13]['count']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            //echo "<a href='grievances_reopenedemp.php?app_type_id=1&status=13&user_type=".$_SESSION['user_type']."'>".$reopened_completed_tot[1][13]['count']."</a>";
                                           echo $reopened_completed_tot[1][13]['count'];
                                        }
                                        else
                                        {
                                            echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=13&name=".$_SESSION['uid']."'>".$reopened_completed_tot[1][13]['count']."</a>";
                                        }
                                        
                                        ?>
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-danger">
                                    <i class="fa fa-folder-open text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                           //echo "<a href='rep_comp_dept_abs_comp.php' target='_blank'>".$reopened_completed_tot[1][11]['count']."</a>";
                                        
                                             echo "<a href='deptwise_reopened.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=11'>".$reopened_completed_tot[1][11]['count']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                           // echo "<a href='grievances_reopenedemp.php?app_type_id=1&status=11&user_type=".$_SESSION['user_type']."'>".$reopened_completed_tot[1][11]['count']."</a>";
                                            echo $reopened_completed_tot[1][11]['count'];
                                        }
                                        else
                                        {
                                            echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=11&name=".$_SESSION['uid']."'>".$reopened_completed_tot[1][11]['count']."</a>";
                                        }
                                        
                                        ?>
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened underprogress</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6" style="clear:both;">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa  text-large stat-icon "><img src="images/reopen_comp.png"></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                          //echo "<a href='rep_comp_dept_abs_comp.php' target='_blank'>".$reopened_completed_tot[1][12]['count']."</a>";
                                          
                                            echo "<a href='deptwise_reopened.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=12'>".$reopened_completed_tot[1][12]['count']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            //echo "<a href='grievances_reopenedemp.php?app_type_id=1&status=12&user_type=".$_SESSION['user_type']."'>".$reopened_completed_tot[1][12]['count']."</a>";
                                            echo $reopened_completed_tot[1][12]['count'];
                                        }
                                        else
                                        {
                                            echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=12&name=".$_SESSION['uid']."'>".$reopened_completed_tot[1][12]['count']."</a>";
                                        }
                                        
                                        ?>
                                         
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened Completed</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
                                    <i class="fa fa-thumbs-down text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                            echo $reopened_completed_reopened[1]['count'];
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
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened Completed - Reopened</span></p>
                                </div>
                                
                                
                                
                               
                                
                                
                            </section>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                         <div class="col-md-4 col-sm-6" >
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-instagram">
                                    <i class="fa fa-times-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                       
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                            echo "<a href='tot_received.php?aptid=1&status=10&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['rejected']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=10&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['rejected']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=10&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['rejected']."</a>";
                                        }
                                        
                                        ?>
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Rejected</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
                                    <i class="fa fa-thumbs-down text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                         <?php if($_SESSION['user_type']=='U')
                                         { 
                                             
                                             //echo "<a href='rep_comp_dept_abs_comp.php' target='_blank'>".$data[1]['unresolved']."</a>";
                                        
                                            echo "<a href='tot_received.php?aptid=1&status=11&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['unresolved']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=1&status=11&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['unresolved']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=11&app_type_id=1&name=".$_SESSION['uid']."'>".$data[1]['unresolved']."</a>";
                                        }
                                        
                                        
                                        
                                        ?>
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Un Resolved</span></p>
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