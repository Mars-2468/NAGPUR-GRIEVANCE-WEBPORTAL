<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
	    
	    echo $_SESSIOIN['uid'];
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();	
		
		
		
		$sql="select * from standard_services";
		
		
		         
        		 $query = $conn->prepare($sql);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		while($row=$rs->fetch_assoc())
		{
		    $data1[$row['cs_id']]=$row['cs_desc'];
		}
		$data1[0]="Others";
		
	
		
		$sql="select count(g.grievance_id)as num,g.app_type_id,g.ulbid,g.cat3_id,u.ulbid,c.cs_id,c.merg_cs_id from 
		grievances g,category3_mst c,ulbmst u where g.app_type_id='2' and g.ulbid=u.ulbid and g.cat3_id=c.cs_id group by c.merg_cs_id";
		
		
		         
        		 
        		 $query = $conn->prepare($sql);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		while($row=$rs->fetch_assoc())
		{
		    $data2[$row['merg_cs_id']]['num']=$row['num'];
		}
		
		
		$sql ="select ulbid,COUNT(grievance_id) as count,grievance_status_id from grievances where grievance_origin_id='4' and ulbid NOT IN('500') group by ulbid,grievance_status_id";
		
		         
        		 $query = $conn->prepare($sql);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		while($row = $rs->fetch_assoc())
		{
		    $data[$row['ulbid']][$row['grievance_status_id']]['count']=$row['count'];
		    $data[$row['grievance_status_id']]['total']+=$row['count'];
		}

	$sql ="select * from grievance_status_mst";
	 
        		  
        		 $query = $conn->prepare($sql);
        		  
        		 $query->execute();
        		 $rs = $query->get_result();
	
		while($row = $rs->fetch_assoc())
		{
		    $status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		
		
		
			$sql ="select * from ulbmst";
			
			
			     
        		  
        		 $query = $conn->prepare($sql);
        		 
        		 $query->execute();
        		 $rs = $query->get_result();
			
		while($row = $rs->fetch_assoc())
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		}
				
			
		$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like ?"; 
		
		         $ulbid = "%".$_SESSION['ulbid']."%";
        		 
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		
	      
	      $row = $rs->fetch_assoc();
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);

	$tpl->assign('user_type',$_SESSION['user_type']);
		$conn->close();
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('data',$data);	
		$tpl->assign('data1',$data1);
		$tpl->assign('data2',$data2);
		$tpl->assign('status_list',$status_list);
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('statewisereport.tpl');
	}
	else
	{
	
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>


