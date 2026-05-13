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
		
		
		 $sql = $conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		 $sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	
	    while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		
		
         $tpl->assign('online_applications',$online_applications);     	
		$tpl->assign('description',$row['description']);		
		$tpl->assign('dept_list',$dept_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('watertap_application.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>