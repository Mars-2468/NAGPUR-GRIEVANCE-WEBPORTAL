<?php
	require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		
		
		
		$sql ="SELECT COUNT(grievance_id) AS count
FROM grievances
WHERE date_regd >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) 
  AND date_regd <= CURDATE()";
  
  $rs = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($rs);
  $data['last_week_records'] = $row['count'];
  
  $sql ="SELECT COUNT(grievance_id) AS count FROM grievances WHERE date_regd <= DATE_SUB(CURDATE(), INTERVAL 30 DAY);";
  $rs = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($rs);
  $data['greater_30days_records'] = $row['count'];
		
		
		  
	     $tpl->assign('users_count',$users_count);
		$conn->close();
        $tpl->assign('data',$data);   	
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('sub_cat_list',$sub_cat_list);		
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('disposable_days',$disposable_days);
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('grievance_month_report.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>