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
		
		
		$app_type_id=$_REQUEST['app_type_id'];
		$emp_id=htmlspecialchars(strip_tags($_REQUEST['empid']));
     
	 	$status=htmlspecialchars(strip_tags($_REQUEST['status']));
		$dept_id=htmlspecialchars(strip_tags($_REQUEST['dept_id']));
		
		$sql=$conn->prepare("SELECT * FROM `feedback_sub_options`");
	
		$sql->execute();
		$rs=$sql->get_result();

		while($row = $rs->fetch_assoc())
		{
		    $feedbackoptions[$row['rating_no']][$row['feedback_id']]=$row['description'];
		}
		
	
		$feedbackoptions[1][0]='Very bad';
		$feedbackoptions[2][0]='Bad';
		$feedbackoptions[3][0]='Average';
		$feedbackoptions[4][0]='Good';
		$feedbackoptions[5][0]='Excellent';
		
		$tpl->assign('feedbackoptions',$feedbackoptions);
		    $empid=htmlspecialchars(strip_tags($_REQUEST['empid']));
        	$sql =$conn->prepare("select g.*,gt.emp_id,gt.alloted_date,gt.disposed_date,r.* from grievances g, grievances_transactions gt,rating_mst r where r.grievance_id=gt.grievance_id and gt.grievance_id=g.grievance_id  and gt.emp_id=? order by g.grievance_id DESC");
	        $sql->bind_param("i",$empid);
					
		  
		  $query =$conn->prepare("select count(g.grievance_id) as num from grievances g, grievances_transactions gt,rating_mst r where r.grievance_id=gt.grievance_id and gt.grievance_id=g.grievance_id  and gt.emp_id=? order by g.grievance_id DESC");
	        $query->bind_param("i",$empid);
					
	       
		
		$adjacents = 5;
		
		$query->execute();
		$result = $query->get_result();
		
			while($row= $result->fetch_assoc())
		{
	         $total_pages = $row['num'];
	       
	     }
		
		
		
		$sql->execute();
		$rs = $sql->get_result();
		 
		$field_info = $rs->fetch_fields(); 
		  	while($row= $rs->fetch_assoc())
		{
		     foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					 
		}
		  
		  //pagination end
		   
	    	$sql =$conn->prepare("select cs_id,comp_desc from category3_mst where ulbid=?");
	    	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				$sql->bind_param("s",$ulbid);
	
		if($_REQUEST['app_type_id']=='1')
		{
		$sql=$conn->prepare("select cs_id,cs_desc as comp_desc from cs_mst");
		}
		$sql->execute();
		$rs = $sql->get_result();
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		
	              $sql =$conn->prepare("select * from dept_mst where dept_id=?");
	              $dept_id=htmlspecialchars(strip_tags($_REQUEST['dept_id']));
	              $sql->bind_param("i",$dept_id);
	              $sql->execute();
	             $rs=  $sql->get_result();
			
				while($row = $rs->fetch_assoc())
				{
				    $dept_list[$row['dept_id']]=$row['dept_desc'];
				}
				 $sql =$conn->prepare("select * from ulbmst where ulbid =?");
				  $ulbid =htmlspecialchars(strip_tags($_REQUEST['ulbid']));
	              $sql->bind_param("s",$ulbid);
	              $sql->execute();
	             $rs=  $sql->get_result();
				
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
				$sql =$conn->prepare("select emp_id,emp_name from emp_mst where emp_id =?");
				 $emp_id = htmlspecialchars(strip_tags($_REQUEST['emp_id']));
	              $sql->bind_param("i",$emp_id);
	              $sql->execute();
	             $rs=  $sql->get_result();
			
				while($row =$rs->fetch_assoc())
				{
				    $emp_list[$row['emp_id']]=$row['emp_name'];
				}
				
				$tpl->assign('dept_list',$dept_list);
				$tpl->assign('ulb_list',$ulb_list);
				$tpl->assign('emp_list',$emp_list);
				
				$tpl->assign('dept_id',$_REQUEST['dept_id']);
				$tpl->assign('emp_id',$_REQUEST['emp_id']);
				$tpl->assign('ulbid',$_REQUEST['ulbid']);
				
			
			$sql =$conn->prepare("select * from grievance_status_mst");
	              
	              $sql->execute();
	             $rs=  $sql->get_result();
		
			if($rs)
			{
				while($row = $rs->fetch_assoc())
					$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}
		
				$sql=$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		
			$sql=$conn->prepare("select ulbname from ulbmst where ulbid=?");
				$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
		
		$row = $rs->fetch_assoc();
		$ulbname=$row['ulbname'];
		
		
		
			$sql=$conn->prepare("select dept_desc from dept_mst where dept_id=?");
			$dept_id =htmlspecialchars(strip_tags($_REQUEST['dept_id']));
				$sql->bind_param("i",$dept_id);
		$sql->execute();
		$rs = $sql->get_result();
		
		$row = $rs->fetch_assoc();
		$deptname=$row['dept_desc'];
		
		
			$sql=$conn->prepare("select emp_name from emp_mst where emp_id=?");
			$empid=htmlspecialchars(strip_tags($_REQUEST['empid']));
				$sql->bind_param("i",$empid);
		$sql->execute();
		$rs = $sql->get_result();
		
		
		$row = $rs->fetch_assoc();
		$empname=$row['emp_name'];
		
	
	$tpl->assign('user_type',$_SESSION['user_type']);
		$sql->close();
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('deptidsel',$_REQUEST['depid']);
		$tpl->assign('ulbidsel',$_REQUEST['ulbid']);
		$tpl->assign('ulbname',$ulbname);
		$tpl->assign('deptname',$deptname);
		$tpl->assign('empname',$empname);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('status_list',$status_list);
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);		
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('user_dept',$_SESSION['user_dept']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('feedback_grievance_rep.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
	}
?>	