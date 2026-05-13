<?php
require "config.php";
//include('responsible_sms.php');
?><?php
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	
	$tpl=new Smarty();
	 
	
	
	//require_once('sms_conf.php');
	//require_once('send_sms.php');	
	
	//echo "hi";
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
	
		
		
				
	 $sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
	 $query=$conn->prepare($sql);
	 $query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	 $query->execute();
	 $rs=$query->get_result();
	 
		
		while($row = $rs->fetch_array())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
	      
	      $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like ?"; 
	      
	      $ulbid = "%".$_SESSION['ulbid']."%";
	      $query=$conn->prepare($sql);
	      $query->bind_param("s",htmlspecialchars(strip_tags($ulbid)));
	        $query->execute();
	        $rs=$query->get_result();
	      
	     
	      $row = $rs->fetch_array();
	      $users_count=$row['user_count'];
	      
	      $conn->close();
	      
	      
	   $tpl->assign('users_count',$users_count);
	   
	    $tpl->assign('ulb',$_SESSION['ulbid']);
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('feedback_count',$feedback_count);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('tot_complaints',$tot_complaints);
		$tpl->assign('res_complaints',$res_complaints);
		$tpl->assign('res_services',$res_services);
		$tpl->assign('datalist',$datalist);
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('origin_rep',$origin_rep);
		$tpl->assign('origin_list',$origin_list);

		$tpl->assign('tanker_enable_status',$tanker_enable_status);
		$tpl->assign('map',$map);
		$tpl->assign('pic',$pic);
		$tpl->assign('data',$data);
		$tpl->assign('data1',$data1);
		
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('tradeLicence.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>
                            
                            
                            
                            
                            
                            