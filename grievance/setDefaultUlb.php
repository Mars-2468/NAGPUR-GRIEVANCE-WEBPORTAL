<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	 date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');
		if(isset($_POST['save']))
		{
				
					
					if($_POST['defaultULB'] !=3)
					{
					    $_SESSION['mergedULBs']=$_POST['defaultULB'];
					}
					
				     
				
				    $_SESSION['defaultUlb']=$_POST['defaultULB'];
				    
					$tpl->assign('class','alert alert-success display-hide');
					$msg="Default ULB is changed successfully";
				    $tpl->assign('msg',$msg);

		}

		
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $online_applications['trade_application']=$row['trade_application'];
		  $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		$query->close();
		
		$sql=$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid=?");
    		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    		$sql->execute();
    		$rs=$sql->get_result();
    		$row = $rs->fetch_assoc();
    		$sql->close();
		 
	      $users_count=$row['user_count'];
	      $tpl->assign('users_count',$users_count);
	      $tpl->assign('DefaultULB',$_SESSION['defaultUlb']);
	      $tpl->assign('mergedUlbs',$_SESSION['merged_ulbs']);
		  $tpl->assign('user_type',htmlspecialchars(strip_tags($_SESSION['user_type'])));
		  $tpl->assign('online_applications',$online_applications);
		  $tpl->assign('ward_list',$ward_list);
		  $tpl->assign('ward_list1',$ward_list1);
		  $tpl->assign('logo',$_SESSION['logo']);
		  $tpl->assign('services',$obj->services);
		  $tpl->assign('uname',$_SESSION['user_name']);
		  $tpl->assign('uid',$_SESSION['uid']);
		  $tpl->assign('main_icons',$obj->main_icons);
		  $tpl->assign('banner',$_SESSION['banner']);
		  $tpl->display('setDefaultUlb.tpl');
	}
	else
	{


echo "<script>window.location='index.php';</script>";
	}
?>