<?php
require "config.php";
ini_set('display_errors',0);
require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$cs_id=htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			$sql = $conn->prepare("select r.*,g.* from grievances g , rating_mst r where g.grievance_id = r.grievance_id and g.cat3_id =? and r.ulbid=?");
			     $sql->bind_param("is",$cs_id,$ulbid);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		
		$data[$row['grievance_id']]['grievance_id']=$row['grievance_id'];
		$data[$row['grievance_id']]['name']=$row['name'];
		$data[$row['grievance_id']]['designation']=$row['designation'];
		$data[$row['grievance_id']]['mobile']=$row['mobile'];
		$data[$row['grievance_id']]['dept_id']=$row['dept_id'];
		$data[$row['grievance_id']]['ulbid']=$row['ulbid'];
		$data[$row['grievance_id']]['sort_order']=$row['sort_order'];
		
		
		}
	
		
	
		$sql = $conn->prepare("select dept_id,dept_desc from dept_imp_mst where ulbid=? order by dept_id");
			     $sql->bind_param("s",$ulbid);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			    
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		$sql = $conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
			     $sql->bind_param("s",$ulbid);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		

	        $tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
		$conn->close();
		
		$tpl->assign('desg_count_list',$desg_count_list);
		$tpl->assign('ulb',$_SESSION['ulbid']);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('data',$data);	
		$tpl->assign('desg_list',$desg_list);	
		$tpl->assign('ward_list',$ward_list);	
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('complaint_info.tpl');
		
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
	}