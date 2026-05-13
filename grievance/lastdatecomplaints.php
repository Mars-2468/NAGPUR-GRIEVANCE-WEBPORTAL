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
		
	
		
		
		//$sql="SELECT * FROM `ulbmst`";
		$sql="SELECT g.ulbid,u.ulbname,MAX(date_regd) as date from grievances g,ulbmst u WHERE g.ulbid=u.ulbid and app_type_id =1 GROUP BY g.ulbid";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		    $data[$row['ulbid']]['date']=date('d-m-Y H:i:s',strtotime($row['date']));
		     
		}
		
				
		
		
		
		mysqli_close($conn);
	  	  		
        $tpl->assign('ulb_list',$ulb_list);		
       $tpl->assign('data',$data);		
	
		$tpl->assign('pagination',$pagination);
	

	
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('lastdatecomplaints.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>