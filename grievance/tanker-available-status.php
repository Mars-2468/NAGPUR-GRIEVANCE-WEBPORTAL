<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	require_once('csrf.class.php');
    $csrf = new csrf();
	$tpl=new Smarty();
	
	
	$token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);
    
	if(isset($_SESSION['uid']))
	{
	    
	    
	  //  session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();	
		include('prepare_connection.php');
		if(isset($_POST['save']))
		{
		    
        if($token_id==$_POST['token']){
                
           $sql ="insert into tanker_enable_mst(ulbid,enable_status) values(?,?) ON DUPLICATE KEY UPDATE enable_status=?";
           $query=$conn->prepare($sql);
           $enable_status=$_POST['status'];
           $query->bind_param("sii",htmlspecialchars(strip_tags($_SESSION['ulbid'])),$enable_status,htmlspecialchars(strip_tags($_POST['status'])));     
			
			if($query->execute())
			{
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Successfully Updated Status');
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
			}
			
		} else {
		    
		       $tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
		    
		}	

		}

              
        $sql=$conn->prepare("select * from tanker_status_mst");
		$sql->execute();
		$rs=$sql->get_result();
		    while($row= $rs->fetch_assoc())
		{
		$status_list[$row['status_id']]=$row['status_desc'];
		}  
        
     
		
		$sql =$conn->prepare("select * from tanker_enable_mst where ulbid=?");
	    $sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	   
		while($row = $rs->fetch_assoc())
		{
		    $status=$row['enable_status'];
		}
		
		$sql->close();
	
		
		
        $sql="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		$ulbid = mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		
        $query->execute();
	    $rs=$query->get_result();	
	    while($row =$rs->fetch_assoc())	
		  {
		   $online_applications['trade_application']=$row['trade_application'];
		   $online_applications['water_tap_application']=$row['water_tap_application'];
		  }	
		  
		/*$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid =?";
	    $query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
	    $rs=$query->get_result();
	    $row=$rs->fetch_assoc();
	    $users_count=$row['user_count'];*/
	    $tpl->assign('users_count',$users_count);
	    
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('online_applications',$online_applications);
		
		$tpl->assign('online_applications',$online_applications);
        $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('status',$status);
		$tpl->assign('status_list',$status_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('street_list',$street_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('tanker-available-status.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>