<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
//	if(isset($_SESSION['uid']) && $_SESSION['ip_address']==$_SERVER['REMOTE_ADDR'] && $_SESSION['user_agent']== $_SERVER['HTTP_USER_AGENT'])
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');
		
		
		
	    $sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid like ?");
	    $ulbid='%'.$_SESSION['ulbid'].'%';
		$sql->bind_param("s",$ulbid);
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();
	      
	      
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
		$conn->close();
		$tpl->assign('description',$row['description']);		
		$tpl->assign('dept_list',$dept_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('dpms.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>