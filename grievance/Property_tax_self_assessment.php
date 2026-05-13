<?php
date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']) && $_SESSION['ip_address']==$_SERVER['REMOTE_ADDR'] && $_SESSION['user_agent']== $_SERVER['HTTP_USER_AGENT'])
	{
	    
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		
		$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query = $conn->prepare($sql);
		$query->bind_param(s,$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		
		
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		  $sql ="select COUNT(id) as user_count from login_details where type=? and ulbid like ?"; 
		  $ulbid = "%".$_SESSION['ulbid']."%";
		  $type = 1;
		  
		  $query = $conn->prepare($sql);
		  $query->bind_param(is,$type,$ulbid);
		  $query->execute();
		  $rs=$query->get_result();
		  
	      $row = $rs->fetch_assoc();
	      
	      $users_count=$row['user_count'];
	      $tpl->assign('users_count',$users_count);
		$query->close();
         $tpl->assign('online_applications',$online_applications);     	
		$tpl->assign('description',$row['description']);		
		$tpl->assign('dept_list',$dept_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('Property_tax_self_assessment.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>