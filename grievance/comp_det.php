<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	 date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		if($_REQUEST['status']==0)
		{
		  $sql ="select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid=? and g.app_type_id=? and gt.disposal_status!= ? and gt.dept_id=? and gt.emp_id=?";
		
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $app_type_id = htmlspecialchars(strip_tags($_REQUEST['app_type_id']));
        		 $disposal_status = 5;
        		 $dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
        		 $emp_id = htmlspecialchars(strip_tags($_REQUEST['emp_id']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("siiii",$ulbid,$app_type_id,$disposal_status,$dept_id,$emp_id);
		    
		    
		    
		    
		    
		}
		else if($_REQUEST['status']==2)
		{
		     $sql ="select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid=? and g.app_type_id=? and gt.disposal_status!=? and gt.dept_id=? and gt.emp_id=? and (grievance_status_id = ? )";
		
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $app_type_id = htmlspecialchars(strip_tags($_REQUEST['app_type_id']));
        		 $disposal_status = 5;
        		 $dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
        		 $emp_id = htmlspecialchars(strip_tags($_REQUEST['emp_id']));
        		 $grievance_status_id = 2;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("siiiii",$ulbid,$app_type_id,$disposal_status,$dept_id,$emp_id,$grievance_status_id);
		    
		    
		    
		}
		else if($_REQUEST['status']==3)
		{
		    echo $sql ="select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid=? and g.app_type_id=? and gt.disposal_status!=? and gt.dept_id=? and gt.emp_id=?  and (grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? )";
		
		    
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $app_type_id = htmlspecialchars(strip_tags($_REQUEST['app_type_id']));
        		 $disposal_status = 5;
        		 $dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
        		 $emp_id = htmlspecialchars(strip_tags($_REQUEST['emp_id']));
        		 $grievance_status_id = 3;
        		 $grievance_status_id1 = 9;
        		 $grievance_status_id2 = 6;
        		 $grievance_status_id3 = 10;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("siiiiiiii",$ulbid,$app_type_id,$disposal_status,$dept_id,$emp_id,$grievance_status_id,$grievance_status_id1,$grievance_status_id2,$grievance_status_id3);
		    
		    
		    
		    
		}
		else if($_REQUEST['status']==4)
		{
		    $sql ="select g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid=? and g.app_type_id=? and gt.disposal_status!=? and gt.dept_id=? and gt.emp_id=?  and ( grievance_status_id = ? )";
		
		    
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $app_type_id = htmlspecialchars(strip_tags($_REQUEST['app_type_id']));
        		 $disposal_status = 5;
        		 $dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
        		 $emp_id = htmlspecialchars(strip_tags($_REQUEST['emp_id']));
        		 $grievance_status_id = 4;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("siiiii",$ulbid,$app_type_id,$disposal_status,$dept_id,$emp_id,$grievance_status_id);
		    
		    
		}
		
		$query->execute();
        $rs = $query->get_result();
	
		$field_info = $rs->fetch_fields();
		while($row= $rs->fetch_assoc())
		{
		     foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 
		}
		 
		
		 
			
         $sql="select cs_id,comp_desc from category3_mst where ulbid=?";
         
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $cs_type_id = htmlspecialchars(strip_tags($_REQUEST['cs_type_id']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
		
		
		
		
		
		if($_REQUEST['app_type_id']=='1')
		{
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		
		 
        		 $query = $conn->prepare($sql);
        		 
		}
		if($query->execute())
		{
		    $rs = $query->get_result();
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		

		
	              	$sql="select dept_id,dept_desc from dept_mst where ulbid=?";
	              	
	              	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 
			if($query->execute())
			{
			    $rs = $query->get_result();
				while($row = $rs->fetch_assoc())
					$dept_list[$row['dept_id']]=$row['dept_desc'];
			}
		
			
			$sql="select * from grievance_status_mst";
			
			
			     
        		 $query = $conn->prepare($sql);
        		 
        		 
			if($query->execute())
			{
			    $rs = $query->get_result();
				while($row = $rs->fetch_assoc())
					$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}
		
				
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$conn->close();
		
	
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
		
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('status_list',$status_list);
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);		
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('user_dept',$_SESSION['user_dept']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('comp_det.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>	