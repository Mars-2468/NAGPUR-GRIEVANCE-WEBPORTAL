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
		
		/// In case of service 
		
		$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
	
				    
	        
    		
    				
    				
    				
    				
    		
				  		
        		
        
        
        $tpl->assign('hod_status',1);
        
        $tpl->assign('hod_status2',$_SESSION['hod_status2']);
        $tpl->assign('hod_status',$_SESSION['hod_status']);
        
    			    
    			    
    			    
    			    
    			    
        $tpl->assign('user_type',$_SESSION['user_type']);
        $tpl->assign('reopened_completed_tot',$reopened_completed_tot);	
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('cat_id',$cat_id);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('hod_rep.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>