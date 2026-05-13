<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

	    ini_set('display_errors',0);
	    require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');
		
		
		// Total received
		
		if($_SESSION['user_type']=='A')
				{
				
				 
				
				
				
				$sql1="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id=? and cat3_id !=?";
				$query = $conn->prepare($sql1);
				$app_type_id=2;
				$cat3_id=0;
				$query->bind_param("ii",$app_type_id,$cat3_id);
				
				 
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				  
				   
				 $sql1="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where ulbid=? and app_type_id=? and cat3_id !=?";  
				   $query = $conn->prepare($sql1);
				   $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				   $app_type_id=2;
				   $cat3_id=0;
				   $query->bind_param("sii",$ulbid,$app_type_id,$cat3_id);
				   
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				 
				 
				 $sql1="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where
				  g.grievance_id=gt.grievance_id and 
				 emp_id=? and gt.disposal_status !=? and app_type_id=? and cat3_id !=?";
				 $query =$conn->prepare($sql1);
				 $emp_id =htmlspecialchars(strip_tags($_SESSION['emp_id']));
				 $disposal_status=5;
				 $app_type_id=2;
				 $cat3_id=0;
				
				 $query->bind_param("siii",$emp_id,$disposal_status,$app_type_id,$cat3_id);
				}
				else if($_SESSION['user_type']=='R')
				{
				
				  
				  
				  $sql1="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u,Districtmst d 
				  where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? and cat3_id !=?";
				  $query =$conn->prepare($sql1);
				  $rdma =htmlspecialchars(strip_tags($_SESSION['uid']));
				  $app_type_id=2;
				  $cat3_id=0;
				  $query->bind_param("isi",$app_type_id,$rdma,$cat3_id);
				  
				}
			
				$query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		   	 $data[$row['app_type_id']]['total_received']=$row['date_regd'];
        		}
				 
				 
			     
				 
				 	 if($data[2]['total_received']=='')
				{
				    $data[2]['total_received']=0;
				}
				// resolved with in sla
				
					if($_SESSION['user_type']=='A')
				{
				
				 
				
				
				$sql="select count(grievance_id) as date_regd,app_type_id 
				from grievances  where 
			    (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and app_type_id=? and sla_status=? and cat3_id !=?";
				$query = $conn->prepare($sql);
		        $status_id_3=3;
		    	$status_id_8=8;
		    	$status_id_9=9;
		        $app_type_id=2;
				$cat3_id=0;
				$sla_status=1;
				$query->bind_param("iiiiii",$status_id_3,$status_id_8,$status_id_9,$app_type_id,$sla_status,$cat3_id);
				
				
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				
				
				$sql="select count(grievance_id) as date_regd,app_type_id 
				from grievances where (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) 
				and ulbid=? and app_type_id=? and 
				sla_status=? and cat3_id !=?";
				$query = $conn->prepare($sql);
		        $status_id_3=3;
		    	$status_id_8=8;
		    	$status_id_9=9;
		    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		        $app_type_id=2;
				$cat3_id=0;
				$sla_status=1;
				$query->bind_param("iiisiii",$status_id_3,$status_id_8,$status_id_9,$ulbid,$app_type_id,$sla_status,$cat3_id);
				
				
				
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				
				 
				  $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g 
				 where g.grievance_id=gt.grievance_id and emp_id=? and gt.disposal_status !=? and 
				 app_type_id=? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and sla_status=? and cat3_id !=?";
				 $query =$conn->prepare($sql);
				 $emp_id =htmlspecialchars(strip_tags($_SESSION['emp_id']));
				 $disposal_status=5;
				 $app_type_id=2;
				 $status_id_3=3;
		    	 $status_id_8=8;
		    	 $status_id_9=9;
		    	 $sla_status=1;
				 $cat3_id=0;
				 $query->bind_param("siiiiiii",$emp_id,$disposal_status,$app_type_id,$status_id_3,$status_id_8,$status_id_9,$sla_status,$cat3_id);
				 
				}
				else if($_SESSION['user_type']=='R')
				{
				
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where 
				 g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? and 
				 (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and sla_status=? and cat3_id !=?";
				  $query =$conn->prepare($sql);
				 $app_type_id=2;
				 $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				 $status_id_3=3;
		    	 $status_id_8=8;
		    	 $status_id_9=9;
		    	 $sla_status=1;
				 $cat3_id=0;
				 $query->bind_param("isiiiii",$app_type_id,$rdma,$status_id_3,$status_id_8,$status_id_9,$sla_status,$cat3_id);
				}
			
			     
				 
				 $query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		   	 $data[$row['app_type_id']]['resolved_within_sla']=$row['date_regd'];
        		}
				 
				 
				 
				 
				 if($data[2]['resolved_within_sla']=='')
				{
				    $data[2]['resolved_within_sla']=0;
				}
				// resolved beyond sla
				
					if($_SESSION['user_type']=='A')
				{
				
				 
			
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id=?
				 and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and sla_status=? and cat3_id !=?";
				$query = $conn->prepare($sql);
		        $status_id_3=3;
		    	$status_id_8=8;
		    	$status_id_9=9;
		        $app_type_id=2;
				$cat3_id=0;
				$sla_status=2;
				$query->bind_param("iiiiii",$app_type_id,$status_id_3,$status_id_8,$status_id_9,$sla_status,$cat3_id);
				 
				 
				 
				}
				else if($_SESSION['user_type']=='U')
				{
				 
				 
				  
				  $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where 
				  ulbid=?  and app_type_id=? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and 
				  sla_status=? and cat3_id !=?";
				  
				$query = $conn->prepare($sql);
		        $status_id_3=3;
		    	$status_id_8=8;
		    	$status_id_9=9;
		    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		        $app_type_id=2;
				$cat3_id=0;
				$sla_status=2;
				$query->bind_param("siiiiii",$ulbid,$app_type_id,$status_id_3,$status_id_8,$status_id_9,$sla_status,$cat3_id);
				  
				  
				  
				  
				  
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g 
				 where g.grievance_id=gt.grievance_id and emp_id=? and gt.disposal_status !=? and 
				 app_type_id=? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and sla_status=? and cat3_id !=?";
				 
				
				 $query =$conn->prepare($sql);
				 $emp_id =htmlspecialchars(strip_tags($_SESSION['emp_id']));
				 $disposal_status=5;
				 $app_type_id=2;
				 $status_id_3=3;
		    	 $status_id_8=8;
		    	 $status_id_9=9;
		    	 $sla_status=2;
				 $cat3_id=0;
				 $query->bind_param("siiiiiii",$emp_id,$disposal_status,$app_type_id,$status_id_3,$status_id_8,$status_id_9,$sla_status,$cat3_id);
				 
				
				 
				}
				else if($_SESSION['user_type']=='R')
				{
				
			
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d 
				 where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? and 
				 (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and sla_status=? and cat3_id !=?";
				 $query =$conn->prepare($sql);
				 $app_type_id=2;
				 $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				 $status_id_3=3;
		    	 $status_id_8=8;
		    	 $status_id_9=9;
		    	 $sla_status=2;
				 $cat3_id=0;
				 $query->bind_param("isiiiii",$app_type_id,$rdma,$status_id_3,$status_id_8,$status_id_9,$sla_status,$cat3_id);
				 
				 
				}
			
			    
				 $query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		   	 $data[$row['app_type_id']]['resolved_beyond_sla']=$row['date_regd'];
        		}
				 
				 
				  if($data[2]['resolved_beyond_sla']=='')
				{
				    $data[2]['resolved_beyond_sla']=0;
				}
				 
				 // under progress with in sla
				 
				 if($_SESSION['user_type']=='A')
				{
				
				 
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id=? and 
				 grievance_status_id IN(?) and sla_status=1 and cat3_id !='0'";
				 
				$query = $conn->prepare($sql);
		        $status_id_2=2;
		    	
		        $app_type_id=2;
				$cat3_id=0;
				$sla_status=1;
				$query->bind_param("iiii",$app_type_id,$status_id_2,$sla_status,$cat3_id);
				 
				 
				 
				}
				else if($_SESSION['user_type']=='U')
				{
				 
			
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."' and 
				 app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
				 $query = $conn->prepare($sql);
		        $status_id_2=2;
		    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		        $app_type_id=2;
				$cat3_id=0;
				$sla_status=1;
				$query->bind_param("siiii",$ulbid,$app_type_id,$status_id_2,$sla_status,$cat3_id);
				 
				 
				 
				}
				else if($_SESSION['user_type']=='E')
				{
				 
				
				 
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g 
				 where g.grievance_id=gt.grievance_id and emp_id=? and gt.disposal_status !=? and 
				 app_type_id=? and grievance_status_id IN(?) and sla_status=? and cat3_id !=?";
				 
				 
				 $query =$conn->prepare($sql);
				 $emp_id =htmlspecialchars(strip_tags($_SESSION['emp_id']));
				 $disposal_status=5;
				 $app_type_id=2;
				 $grievance_status_id=2;
		    	 $sla_status=1;
				 $cat3_id=0;
				 $query->bind_param("siiiiiii",$emp_id,$disposal_status,$app_type_id,$grievance_status_id,$sla_status,$cat3_id);
				 
				 
				 
				 
				 
				 
				}
				else if($_SESSION['user_type']=='R')
				{
				
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d 
				 where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? 
				 and grievance_status_id IN(?) and sla_status=? and cat3_id !=?";
				 
				 $query =$conn->prepare($sql);
				 $app_type_id=2;
				 $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				 $status_id_2=2;
		    	 
		    	 $sla_status=1;
				 $cat3_id=0;
				 $query->bind_param("isiii",$app_type_id,$rdma,$status_id_2,$sla_status,$cat3_id);
				 
				 
				}
			
			    
				 
				  $query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		   	 $data[$row['app_type_id']]['pending_with_sla']=$row['date_regd'];
        		}
				 
				 if($data[2]['pending_with_sla']=='')
				{
				    $data[2]['pending_with_sla']=0;
				}
				 
				 
				 // under progress beyond sla
				 
				 if($_SESSION['user_type']=='A')
				{
				
				 
			
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where app_type_id=? 
				 and grievance_status_id IN(?) and sla_status=? and cat3_id !=?";
				 
				 $query = $conn->prepare($sql);
		        $status_id_2=2;
		    	
		        $app_type_id=2;
				$cat3_id=0;
				$sla_status=2;
				$query->bind_param("iiii",$app_type_id,$status_id_2,$sla_status,$cat3_id);
				 
				 
				}
				else if($_SESSION['user_type']=='U')
				{
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances where ulbid=? and 
				 app_type_id=? and grievance_status_id IN(?) and sla_status=? and cat3_id !=?";
				$query = $conn->prepare($sql);
		        $status_id_2=2;
		    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		        $app_type_id=2;
				$cat3_id=0;
				$sla_status=2;
				$query->bind_param("siiii",$ulbid,$app_type_id,$status_id_2,$sla_status,$cat3_id);
				 
				}
				else if($_SESSION['user_type']=='E')
				{
				 
			
				 
				  $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g 
				 where g.grievance_id=gt.grievance_id and emp_id=? and gt.disposal_status !=? 
				 and app_type_id=? and grievance_status_id IN(?) and sla_status=? and cat3_id !=?";
				 
				 $query =$conn->prepare($sql);
				 $emp_id =htmlspecialchars(strip_tags($_SESSION['emp_id']));
				 $disposal_status=5;
				 $app_type_id=2;
				 $grievance_status_id=2;
		    	 $sla_status=2;
				 $cat3_id=0;
				 $query->bind_param("siiiii",$emp_id,$disposal_status,$app_type_id,$grievance_status_id,$sla_status,$cat3_id);
				 
				 
				}
				else if($_SESSION['user_type']=='R')
				{
				
				
				 
				 $sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where 
				 g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=?
				 and grievance_status_id IN(?) and sla_status=? and cat3_id !=?";
				 $query =$conn->prepare($sql);
				 $app_type_id=2;
				 $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				 $status_id_2=2;
		    	 
		    	 $sla_status=2;
				 $cat3_id=0;
				 $query->bind_param("isiii",$app_type_id,$rdma,$status_id_2,$sla_status,$cat3_id);
				 
				}
			
			      
				 $query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		   	   $data[$row['app_type_id']]['pending_beyond_sla']=$row['date_regd'];
        		}
				 
				 
				  if($data[2]['pending_beyond_sla']=='')
				{
				    $data[2]['pending_beyond_sla']=0;
				}
				 
				/********pending Approval**********/	
				
				if($_SESSION['user_type']=='A')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where grievance_status_id=? 
				and app_type_id=? and cat3_id !=?";
				
				 $query = $conn->prepare($sql);
		         $status_id_2=1;
		    	 $app_type_id=2;
				 $cat3_id=0;
				 $query->bind_param("iii",$status_id_2,$app_type_id,$cat3_id);
				
				
				
				}
				 if($_SESSION['user_type']=='U')
				{
				
            	
            		
            		$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances where 
            		ulbid=? and grievance_status_id=? and app_type_id=? and cat3_id !=?";
		            $query = $conn->prepare($sql);
    		        $status_id_2=1;
    		    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    		        $app_type_id=2;
    				$cat3_id=0;
    			
    				$query->bind_param("siii",$ulbid,$status_id_2,$app_type_id,$cat3_id);
				 
		
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as pendingforapproval,app_type_id from grievances g,ulbmst u,Districtmst d 
				where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id=? and app_type_id=? and 
				d.rdma=? and cat3_id !=?";
				
				 $query =$conn->prepare($sql);
				 $app_type_id=2;
				 $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				 $status_id_2=1;
		    	 $cat3_id=0;
				 $query->bind_param("iisi",$status_id_2,$app_type_id,$rdma,$cat3_id);
			
				}
				
				 
				
				 $query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		    $data[$row['app_type_id']]['pendingforapproval']=$row['pendingforapproval'];
        		}
				
				
				
				
				if($data[2]['pendingforapproval']=='')
				{
				    $data[2]['pendingforapproval']=0;
				}
				
				
			/********end pending approval****/	
			
			
			/********Financial implications**********/	
				
				if($_SESSION['user_type']=='A')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances where grievance_status_id=? 
				and app_type_id=? and cat3_id !=?";
				
				
				 $query = $conn->prepare($sql);
		         $status_id_2=6;
		    	 $app_type_id=2;
				 $cat3_id=0;
				 $query->bind_param("iii",$status_id_2,$app_type_id,$cat3_id);
				
				}
				 if($_SESSION['user_type']=='U')
				{
				
		$sql="select count(grievance_id) as fin,app_type_id from grievances where 
		ulbid=? and grievance_status_id=? and app_type_id=? and cat3_id !=?";
		
		            $query = $conn->prepare($sql);
    		        $status_id_2=6;
    		    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    		        $app_type_id=2;
    				$cat3_id=0;
    			
    				$query->bind_param("siii",$ulbid,$status_id_2,$app_type_id,$cat3_id);
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as fin,app_type_id from grievances g,ulbmst u,Districtmst d where 
				g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id=? and app_type_id=? and 
				d.rdma=? and cat3_id !=?";
			
			     $query =$conn->prepare($sql);
				 $app_type_id=2;
				 $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				 $status_id_2=6;
		    	 $cat3_id=0;
				 $query->bind_param("iisi",$status_id_2,$app_type_id,$rdma,$cat3_id);
			
			
				}
				 if($_SESSION['user_type']=='E')
				{
				
		$sql="select count(g.grievance_id) as fin,app_type_id from grievances g,grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and gt.emp_id=?  and grievance_status_id=? and 
		app_type_id=? and gt.disposal_status !=? and cat3_id !=?";
		
		         $query =$conn->prepare($sql);
				 $emp_id =htmlspecialchars(strip_tags($_SESSION['emp_id']));
				 $disposal_status=5;
				 $app_type_id=2;
				 $grievance_status_id=6;
		    	
				 $cat3_id=0;
				 $query->bind_param("siiiii",$emp_id,$grievance_status_id,$app_type_id,$disposal_status,$cat3_id);
		
				}
				
				
				
				$query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		   $data[$row['app_type_id']]['fin']=$row['fin'];
        		}
				
				
				
			if($data[2]['fin']=='')
				{
				    $data[2]['fin']=0;
				}
				
				
			/********end pending approval****/	
			
			
			
			
				/********Un resolved**********/	
				
				if($_SESSION['user_type']=='A')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances g,standard_services c,ulbmst u where  
				g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and  grievance_status_id=? and app_type_id=? and cat3_id !=?";
				 $query = $conn->prepare($sql);
		         $status_id_2=4;
		    	 $app_type_id=2;
				 $cat3_id=0;
				 $query->bind_param("iii",$status_id_2,$app_type_id,$cat3_id);
				}
				 if($_SESSION['user_type']=='U')
				{
				
		$sql="select count(grievance_id) as unresolved,app_type_id from grievances where 
		ulbid=? and grievance_status_id=? and app_type_id=? and cat3_id !=?";
		
		            $query = $conn->prepare($sql);
    		        $status_id_2=4;
    		    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
    		        $app_type_id=2;
    				$cat3_id=0;
    			
    				$query->bind_param("siii",$ulbid,$status_id_2,$app_type_id,$cat3_id);
		
				}
				 if($_SESSION['user_type']=='E')
				{
				
		$sql="select count(g.grievance_id) as unresolved,app_type_id from grievances g,grievances_transactions gt 
		where g.grievance_id=gt.grievance_id and gt.emp_id=? and grievance_status_id=?
		and app_type_id=? and gt.disposal_status !=? and cat3_id !=?";
		
		        $query =$conn->prepare($sql);
				 $emp_id =htmlspecialchars(strip_tags($_SESSION['emp_id']));
				 $disposal_status=5;
				 $app_type_id=2;
				 $grievance_status_id=4;
		    	
				 $cat3_id=0;
				 $query->bind_param("siiii",$emp_id,$grievance_status_id,$app_type_id,$disposal_status,$cat3_id);
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as unresolved,app_type_id from grievances g,ulbmst u,Districtmst d 
				where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id=? and app_type_id=? and 
				d.rdma=? and cat3_id !=?";
			
			     $query =$conn->prepare($sql);
				 $app_type_id=2;
				 $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				 $status_id_2=4;
		    	 $cat3_id=0;
				 $query->bind_param("iisi",$status_id_2,$app_type_id,$rdma,$cat3_id);
				}
				
				 
				
				$query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		   $data[$row['app_type_id']]['unresolved']=$row['unresolved'];
        		}
				
				
					if($data[2]['unresolved']=='')
				{
				    $data[2]['unresolved']=0;
				}
			
				
				
			/********end pending approval****/
			
			
			
			
				/******** Rejected **********/	
				
				if($_SESSION['user_type']=='A')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances where grievance_status_id=? 
				and app_type_id=? and cat3_id !=?";
				 $query = $conn->prepare($sql);
		         $status_id_2=10;
		    	 $app_type_id=2;
				 $cat3_id=0;
				 $query->bind_param("iii",$status_id_2,$app_type_id,$cat3_id);
				
				}
				 if($_SESSION['user_type']=='U')
				{
				
            		$sql="select count(grievance_id) as rejected,app_type_id from grievances where 
            		ulbid=? and grievance_status_id=? and app_type_id=? and cat3_id !=?";
            		$query = $conn->prepare($sql);
    		        $status_id_2=10;
    		    	$ulbid=$_SESSION['ulbid'];
    		        $app_type_id=2;
    				$cat3_id=0;
    			
    				$query->bind_param("siii",$ulbid,$status_id_2,$app_type_id,$cat3_id);
		
		
				}
				 if($_SESSION['user_type']=='E')
				{
				
        		$sql="select count(g.grievance_id) as rejected,app_type_id from grievances g,grievances_transactions 
        		gt where g.grievance_id=gt.grievance_id and gt.emp_id=? and grievance_status_id=?
        		and app_type_id=? and gt.disposal_status !=? and cat3_id !=?";
        		
        		$query =$conn->prepare($sql);
				 $emp_id =htmlspecialchars(strip_tags($_SESSION['emp_id']));
				 $disposal_status=5;
				 $app_type_id=2;
				 $grievance_status_id=10;
		    	
				 $cat3_id=0;
				 $query->bind_param("siiii",$emp_id,$grievance_status_id,$app_type_id,$disposal_status,$cat3_id);
		
				}
				
				if($_SESSION['user_type']=='R')
				{
				 
				$sql="select count(grievance_id) as rejected,app_type_id from grievances g,ulbmst u,Districtmst d where  
				g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id=? and app_type_id=? and 
				d.rdma=? and cat3_id !=?";
				$query =$conn->prepare($sql);
				 $app_type_id=2;
				 $rdma=htmlspecialchars(strip_tags($_SESSION['uid']));
				 $status_id_2=10;
		    	 $cat3_id=0;
				 $query->bind_param("iisi",$status_id_2,$app_type_id,$rdma,$cat3_id);
			
				}
				
				
				$query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		    $data[$row['app_type_id']]['rejected']=$row['rejected'];
        		}
				
				
				
					if($data[2]['rejected']=='')
				{
				    $data[2]['rejected']=0;
				}
			
				
				
			/********end pending approval****/
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			/** re-opened applicatons **/
				
				if($_SESSION['user_type']=='A')
		          {
		                
		                $sql ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id=? 
		                group by app_type_id";
		                $query =$conn->prepare($sql);
        				$grievance_status_id=11; 
        				$query->bind_param("i",$grievance_status_id);
		                
		                
		                $sql2 ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id=? 
		                group by app_type_id";
		                $query2 =$conn->prepare($sql2);
        				$grievance_status_id=12; 
        				$query2->bind_param("i",$grievance_status_id);
		                
		                
		            }
		            else if($_SESSION['user_type']=='U')
		            {
		                $sql ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id=? 
		                and ulbid=? group by app_type_id";
		                $query =$conn->prepare($sql);
        				$grievance_status_id=11; 
        				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
        				$query->bind_param("is",$grievance_status_id,$ulbid);
		                
		                
		                $sql2 ="select count(grievance_id) as count,app_type_id from grievances where grievance_status_id=? 
		                and ulbid=? group by app_type_id";
		                $query2 =$conn->prepare($sql2);
        				$grievance_status_id=12; 
        				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
        				$query2->bind_param("is",$grievance_status_id,$ulbid);
		            }
		            else if($_SESSION['user_type']=='E')
				        {
				        }
				        else if($_SESSION['user_type']=='R')
		                {
		                }
		                
		               
		                
		                $query->execute();
                		$rs=$query->get_result();
                		while($row = $rs->fetch_assoc())
                		{
                		     $reopened[$row['app_type_id']]['count']=$row['count'];
                		}
		                
		                $query2->execute();
                		$rs2=$query2->get_result();
                		while($row = $rs2->fetch_assoc())
                		{
                		     $reopened_completed[$row['app_type_id']]['count']=$row['count'];
                		}
		                
		                
		         
		
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
                                        
                                        
                                          // echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['total_received']."</a>";
                                        
                                            echo "<a href='tot_received.php?aptid=2&status=0&sla=0&user_type=".$_SESSION['user_type']."' target='_blank'>".$data[2]['total_received']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=0&sla=0&user_type=".$_SESSION['user_type']."' target='_blank'>".$data[2]['total_received']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=0&app_type_id=2&name=".$_SESSION['uid']."' target='_blank'>".$data[2]['total_received']."</a>";
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
                        
                        
                        
                        
                                        <?php if($_SESSION['user_type']=='U')
                                        {
                                                
                                            echo "<a href='tot_received.php?aptid=2&status=1&sla=0&user_type=".$_SESSION['user_type']."' target='_blank''>".$data[2]['pendingforapproval']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo $data[2]['pendingforapproval'];
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=1&app_type_id=2&name=".$_SESSION['uid']."' target='_blank'>".$data[2]['pendingforapproval']."</a>";
                                        }
                                        
                                        ?>
                        
                        </p>
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
                   
                   
                                         <?php if($_SESSION['user_type']=='U')
                                         {
                                        
                                        
                                       // echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['resolved_within_sla']."</a>";
                                        
                                         echo "<a href='tot_received.php?aptid=2&status=2&sla=1&user_type=".$_SESSION['user_type']."'>".$data[2]['resolved_within_sla']."</a>";
                                    
                                        }
                                        
                                        else if($_SESSION['user_type']=='E')
                                        {
                                             echo "<a href='tot_received.php?aptid=2&status=2&sla=1&user_type=".$_SESSION['user_type']."'>".$data[2]['resolved_within_sla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=2&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['resolved_within_sla']."</a>";
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
                                        
                                       // echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['resolved_beyond_sla']."</a>";
                                        
                                        echo "<a href='tot_received.php?aptid=2&status=2&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['resolved_beyond_sla']."</a>";
                                        
                             
                         }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=2&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['resolved_beyond_sla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['resolved_beyond_sla']."</a>";
                                        }
                                        
                                        ?>
                         
                         
                         
                         </p>                
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
        
        
        <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                       // echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['pending_with_sla']."</a>";
                                        
                                         echo "<a href='tot_received.php?aptid=2&status=3&sla=1&user_type=".$_SESSION['user_type']."'>".$data[2]['pending_with_sla']."</a>";
                                       
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=3&sla=1&user_type=".$_SESSION['user_type']."'>".$data[2]['pending_with_sla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=4&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['pending_with_sla']."</a>";
                                        }
                                        
                                        ?>
        
        
        
        
        </p>                                
                                    
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
             
             
             
              <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                         //echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['pending_beyond_sla']."</a>";
                                        
                                        
                                        echo "<a href='tot_received.php?aptid=2&status=3&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['pending_beyond_sla']."</a>";
                                        
                  
              }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=3&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['pending_beyond_sla']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['pending_beyond_sla']."</a>";
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
                                        
                                            echo "<a href='tot_received.php?aptid=2&status=6&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['fin']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=6&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['fin']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['fin']."</a>";
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
                                    <i class="fa fa-folder-open text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"><?php echo $reopened[2]['count'];?></p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened under progress</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa  text-large stat-icon "> <img src="images/reopen_comp.png"></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"><?php echo $reopened_completed[2]['count'];?></p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Reopened completed</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        
                         <div class="col-md-4 col-sm-6" style="clear:both">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-instagram">
                                    <i class="fa fa-times-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                            echo "<a href='tot_received.php?aptid=2&status=10&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['rejected']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=10&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['rejected']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=10&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['rejected']."</a>";
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
                                        
                                        
                                        
                                         <?php if($_SESSION['user_type']=='U'){
                                        
                                        
                                          // echo "<a href='rep_comp_dept_abs.php' target='_blank'>".$data[2]['unresolved']."</a>";
                                        
                                            echo "<a href='tot_received.php?aptid=2&status=11&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['unresolved']."</a>";
                                        }
                                        else if($_SESSION['user_type']=='E')
                                        {
                                            echo "<a href='tot_received.php?aptid=2&status=11&sla=2&user_type=".$_SESSION['user_type']."'>".$data[2]['unresolved']."</a>";
                                        }
                                        else
                                        {
                                            echo "<a href='cdma_ulbwise_report.php?status=11&app_type_id=2&name=".$_SESSION['uid']."'>".$data[2]['unresolved']."</a>";
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
			
			<?php mysqli_close($conn); ?>