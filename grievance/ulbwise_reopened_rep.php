<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
	    
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();	
		
		 if($_REQUEST['status'] !='13')
	        {
	            $sql ="select COUNT(grievance_id) as count ,app_type_id,ulbid from grievances where grievance_status_id=? and app_type_id=?  group by ulbid";
	             $query=$conn->prepare($sql);
	             
	            $grievance_status_id=strip_tags($_REQUEST['status']);
	            $app_type_id=strip_tags($_REQUEST['app_type_id']);
	            	$query->bind_param("ii",$grievance_status,$app_type_id);
	            
	            if($_SESSION['user_type']=='R')
	            {
	               
	                 $sql ="select IFNULL(count(g.grievance_id),0) as count,g.ulbid from grievances g,grievances_transactions gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma=? and gt.disposal_status=? and app_type_id=? group by ulbid";
	             $query=$conn->prepare($sql);
	                $rdma=$_SESSION['uid'];
	                 $app_type_id=strip_tags($_REQUEST['app_type_id']);
	                $query->bind_param("si", $rdma,$app_type_id);
	            }
	        }
	        else
	        {
	        $sql ="select COUNT(g.grievance_id) as count,ulbid from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !=? and g.app_type_id=? and gt.(disposal_status=? or disposal_status=?) and is_reopened_yn=? and g.grievance_status_id =? and gt.disposal_status!=? group by ulbid";
		   $query=$conn->prepare($sql);
		     $cat3_id=0;
		     $app_type_id=strip_tags($_REQUEST['app_type_id']);
		     	$disposal_status9=9;
				    	$disposal_status12=12;
				    		$is_reopened_yn=1;
		                  $grievance_status_id=13;
		                  $disposal_status=5;
		                   $query->bind_param("iiiiiii", $cat3_id, $app_type_id,$disposal_status9,$disposal_status12,$is_reopened_yn,$grievance_status_id, $disposal_status);
			if($_SESSION['user_type']=='R')
	            {
	               
	                 $sql ="select COUNT(gt.grievance_id) as count ,app_type_id,g.ulbid from grievances g,grievances_transactions gt, ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id  and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma=? and grievance_status_id=? and app_type_id=?  and gt.(disposal_status=? or disposal_status=?) and is_reopened_yn=? and g.grievance_status_id =? and gt.disposal_status!=? group by ulbid";
	            
	                 $query=$conn->prepare($sql);
	                   $rdma=strip_tags($_SESSION['uid']);
	                   $grievance_status_id=strip_tags($_REQUEST['status']);
	                   $app_type_id=strip_tags($_REQUEST['app_type_id']);
	                   $disposal_status9=9;
				    	$disposal_status12=12;
				    	$is_reopened_yn=1;
		                  $grievance_status_id=13;
		                  $disposal_status=5;
		                  $query->bind_param("siiiiiii",  $rdma, $grievance_status_id,$app_type_id,$disposal_status9,$disposal_status12,$is_reopened_yn,$grievance_status_id, $disposal_status);
		                  
	            }
	        }	
	        
	       
					$query->execute();
	    $rs=$query->get_result();
			  
		
		while($row = $rs->fetch_assoc())
				 
				{
				    $data[$row['ulbid']]['count']=$row['count'];
				    $data['total']+=$row['count'];
				}
				
				$query->close();
				$sql ="select * from ulbmst";
				$query=$conn->prepare($sql);
					$query->execute();
	    $rs=$query->get_result();
				
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
					$query->close();
				
			
			
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		$query=$conn->prepare($sql);
		$ulbid=strip_tags($_SESSION['ulbid']);
		$query->bind_param("s",$ulbid);
		
		$query->execute();
	    $rs=$query->get_result();
				
				while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
			$query->close();
		$sql ="select COUNT(id) as user_count from login_details where type=? and ulbid like ?"; 
		
			$query=$conn->prepare($sql);
			$type=1;
				$ulbid=strip_tags("%".$_SESSION['ulbid']."%");
		$query->bind_param("is",$type,$ulbid);
	      $query->execute();
	    $rs=$query->get_result();
	      
	      $row = $rs->fetch_assoc();
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		
		
		
			$query->close();
		$tpl->assign('status',$_REQUEST['status']);
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('data',$data);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('ulbwise_reopened_rep.tpl');
	}
	else
	{
		
		
		
		echo "<script>window.location='index.php';</script>";
		
		
	}
?>