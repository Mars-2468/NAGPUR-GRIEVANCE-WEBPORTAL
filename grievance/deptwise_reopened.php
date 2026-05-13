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
		$conn=getconnection();	
		
	        if($_REQUEST['status'] !='13')
	        {
	       $sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt 
	       where cat3_id !=? and  g.grievance_id=gt.grievance_id  and g.ulbid=? and 
	       g.app_type_id=? and gt.disposal_status=? group by gt.dept_id";
	       $cat3_id=0;
	       $ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
	       $app_type_id=htmlspecialchars(strip_tags($_REQUEST['app_type_id']));
	       $disposal_status=htmlspecialchars(strip_tags($_REQUEST['status']));
	       $query = $conn->prepare($sql);
	       $query->bind_param("isii",$cat3_id,$ulbid,$app_type_id,$disposal_status);
	        }
	        else
	        {
	
		 $sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt 
        		where g.grievance_id=gt.grievance_id  and cat3_id !=? and g.ulbid=? and 
        		g.app_type_id=? and (gt.disposal_status=? or gt.disposal_status=?) and is_reopened_yn=? 
        		and g.grievance_status_id IN(?) group by gt.dept_id";
        		$cat3_id=0;
    	        $ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
    	        $app_type_id=htmlspecialchars(strip_tags($_REQUEST['app_type_id']));
    	        $disposal_status1=9;
    	        $disposal_status2=12;
        		$is_reopened_yn=1;
        		$grievance_status_id=13;
        		$query = $conn->prepare($sql);
	            $query->bind_param("isiiiii",$cat3_id,$ulbid,$app_type_id,$disposal_status1,$disposal_status2,$is_reopened_yn,$grievance_status_id);
	        }
		 
			$query->execute();
		    $rs = $query->get_result();
		 	while($row = $rs->fetch_assoc())
			    {
				$data[$row['emp_dept']]['count']=$row['count'];
				$data['total']+=$row['count'];
			    }
				
		
				$sql=$conn->prepare("select * from dept_mst where ulbid=?");
			
				$ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
				$sql->bind_param("s",$ulbid);
				$sql->execute();
				$rs=$sql->get_result();
				while($row = $rs->fetch_assoc())
				{
				    $dept_list[$row['dept_id']]=$row['dept_desc'];
				}
				
				
				
			
				
				$sql ="select * from ulbmst where ulbid=?";
        		$query=$conn->prepare($sql);
        		$ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
        		$query->bind_param("s",$ulbid);
        		$query->execute();
        		$rs=$query->get_result();
        		while($row = $rs->fetch_assoc())
        		{
        		  $ulb_list[$row['ulbid']]=$row['ulbname'];
        		}
				
				
				
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		$query=$conn->prepare($sql);
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $online_applications['trade_application']=$row['trade_application'];
		  $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		$query->close();
		$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid like ?");
	    $ulbid='%'.$_SESSION['ulbid'].'%';
		$sql->bind_param("s",$ulbid);
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();
	    
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);

	$tpl->assign('user_type',$_SESSION['user_type']);
		
		

		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('status',$_REQUEST['status']);
		$tpl->assign('dept_list',$dept_list);
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
		$tpl->display('deptwise_reopened.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>