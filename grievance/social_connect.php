<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
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
	
		
		if(isset($_POST['save']))
		{
		
		
		    $sql ="insert into social_connect(ulbid,fb_link,twitter_link)values('".$_SESSION['ulbid']."','".trim(mysqli_real_escape_string($conn,$_POST['fb_link']))."','".trim(mysqli_real_escape_string($conn,$_POST['twitter_link']))."')ON DUPLICATE KEY UPDATE fb_link='".trim(mysqli_real_escape_string($conn,$_POST['fb_link']))."',twitter_link='".trim(mysqli_real_escape_string($conn,$_POST['twitter_link']))."'";
		    
			
			 
			
			if(mysqli_query($conn,$sql))
			{
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Saved Successfully ');
				}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
				}
				
				 $sql ="insert into website_mst(ulbid,website)values('".$_SESSION['ulbid']."','".trim(mysqli_real_escape_string($conn,$_POST['web_link']))."')ON DUPLICATE KEY UPDATE website='".trim(mysqli_real_escape_string($conn,$_POST['web_link']))."'";
		    
			
			 
			
			if(mysqli_query($conn,$sql))
			{
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Saved Successfully ');
				}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
				}

		}
		
		
		
               $sql="select * from social_connect where ulbid='".$_SESSION['ulbid']."'";
		   $i=1;
		   $rs=mysqli_query($conn,$sql);
		   $tot_row=mysqli_num_rows($rs);
		   if(mysqli_num_rows($rs)>0)
			{
			
				
				while($row = mysqli_fetch_assoc($rs))
				{
					$data['fb_link']=$row['fb_link'];
					$data['twitter_link']=$row['twitter_link'];
				}
				$tpl->assign('data',$data);
				
		 }
		 
		 $sql="select * from website_mst where ulbid='".$_SESSION['ulbid']."'";
		   $i=1;
		   $rs=mysqli_query($conn,$sql);
		   $tot_row=mysqli_num_rows($rs);
		   if(mysqli_num_rows($rs)>0)
			{
			
				
				while($row = mysqli_fetch_assoc($rs))
				{
					$data['web_link']=$row['website'];
					
				}
				$tpl->assign('data',$data);
				
		 }
			
		  $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	     
		mysqli_close($conn);	
		$tpl->assign('data',$data);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('social_connect.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>