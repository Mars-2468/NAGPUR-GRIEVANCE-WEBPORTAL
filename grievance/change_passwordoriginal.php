<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	
	require_once('send_sms.php');
	require_once('sms_conf.php');
// 	print_r($_SESSION);
	
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		if(isset($_POST['save']))
		{
			 // echo $sql="insert into users(user_id,emp_id,user_pwd,user_name,user_mobile,ulbid,user_type,user_delete_status)
			 // values('".mysqli_real_escape_string($conn,trim($_POST['user_id']))."','".mysqli_real_escape_string($conn,strip_tags($_POST['emp_id']))."',PASSWORD('".mysqli_real_escape_string($conn,trim(sha1(md5($_POST['user_pwd1']))))."'),'".mysqli_real_escape_string($conn,strip_tags($_POST['user_name']))."','".mysqli_real_escape_string($conn,strip_tags($_POST['user_mobile']))."','".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."','E',0) 
			 // ON DUPLICATE KEY UPDATE user_pwd=PASSWORD('".mysqli_real_escape_string($conn,sha1(md5($_POST['user_pwd1'])))."'),user_name='".mysqli_real_escape_string($conn,strip_tags($_POST['user_name']))."',user_mobile='".mysqli_real_escape_string($conn,strip_tags($_POST['user_mobile']))."',emp_id='".mysqli_real_escape_string($conn,strip_tags($_POST['emp_id']))."'";
		
		     $sql="UPDATE users SET user_pwd = PASSWORD('".mysqli_real_escape_string($conn,sha1(md5($_POST['user_pwd1'])))."') WHERE user_id = '".$_SESSION['uid']."'";
		
			$insert_id = mysqli_query($conn,$sql);
			// print_r($insert_id);die;
			if($insert_id)
			{
			
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Successfully Added User');
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
				}

		}
		

		//print_r($online_applications);
	    $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('change_password.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>