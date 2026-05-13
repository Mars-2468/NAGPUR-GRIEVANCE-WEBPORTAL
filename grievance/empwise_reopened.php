<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
if(isset($_SESSION['uid']))
	{
	    
	    
	    
	    //session_regenerate_id();
	    
	    //echo $_SESSIOIN['uid'];
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		$disposal_status=5;
		$grievance_status_id_13 =13;
		$is_reopened_yn=1;
		$disposal_status_9=9;
		$disposal_status_12=12;
		
		$ulbid=$_REQUEST['ulbid'];
		$app_type_id=$_REQUEST['app_type_id'];
		$dept_id=$_REQUEST['dept_id'];
		$status=$_REQUEST['status'];
		
		 if($_REQUEST['status'] !='13')
	        {
	            $sql=$conn->prepare("select COUNT(g.grievance_id) as count,emp_id  from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=? and g.app_type_id=? and gt.dept_id=? and gt.disposal_status=? and gt.disposal_status !=? group by gt.emp_id");
	            $sql->bind_param("siiii",$ulbid,$app_type_id,$dept_id,$status,$disposal_status);
	           
	        }
	        else
	        {
	        $sql=$conn->prepare("select COUNT(g.grievance_id) as count,emp_id  from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=? and g.app_type_id=? and gt.dept_id=?  and (gt.disposal_status=? or gt.disposal_status=?) and is_reopened_yn=? and g.grievance_status_id IN(?) group by gt.emp_id");
	        $sql->bind_param("siiiiii",$ulbid,$app_type_id,$dept_id,$disposal_status_9,$disposal_status_12,$is_reopened_yn,$grievance_status_id_13);
			
	        }
		   $sql->execute();
	        $rs=$sql->get_result();
			if($rs)
			{
			  while($row = $rs->fetch_assoc())
			    {
				    $data[$row['emp_id']]['count']=$row['count'];
				    $data['total']+=$row['count'];
			    }
		 	}
				$sql =$conn->prepare("select * from emp_mst where emp_dept =?");
				$sql->bind_param("i",$dept_id);
			
				 $sql->execute();
	            $rs=$sql->get_result();
				while($row = $rs->fetch_assoc())
				{
				    $emp_list[$row['emp_id']]=$row['emp_name'];
				}
				
					$sql =$conn->prepare("select * from ulbmst where ulbid =?");
				$sql->bind_param("s",$ulbid);
			
				 $sql->execute();
	            $rs=$sql->get_result();
			
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				$sql=$conn->prepare("select * from dept_mst where dept_id =?");
				$sql->bind_param("s",$ulbid);
			
				$sql->execute();
				$rs= $sql->get_result();
				
				while($row = $rs->fetch_assoc())
				{
				    $dept_list[$row['dept_id']]=$row['dept_desc'];
				}
				
			$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));	
			$sql= $conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
			$sql->bind_param("s",$ulbid1);
			$sql->execute();
				$rs= $sql->get_result();
			
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		$type=1;
		$ulbidlike ='%'.$_SESSION['ulbid'].'%';
	
		$sql= $conn->prepare("select COUNT(id) as user_count from login_details where type=? and ulbid like ?");
			$sql->bind_param("is",$type,$ulbidlike);
			$sql->execute();
				$rs= $sql->get_result();
			$row=$rs->fetch_assoc();
	
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);

	$tpl->assign('user_type',$_SESSION['user_type']);
		
	$sql->close();
		
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('status',$_REQUEST['status']);
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('dept_id',$_REQUEST['dept_id']);
		$tpl->assign('ulbid',$_REQUEST['ulbid']);
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
		$tpl->display('empwise_reopened.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
	}
?>