<?php
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();
session_start();

if (isset($_SESSION['uid'])) {

	session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');


	$sql="select feedback_status,g.grievance_id,rm.rating_no,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_origin_id,grievance_status_id,date_regd from grievances g,rating_mst rm where  g.grievance_id=rm.grievance_id and grievance_status_id IN(3,6,8,9,12) and rm.rating_no IN(1,2,3,4,5) and ulbid like '%".strip_tags($_SESSION['ulbid'])."%' and app_type_id='1' ";
		
	$gsql=$conn->prepare($sql);
	$gsql->execute();
	$grs=$gsql->get_result();
	
	$star=[];
	$total_complaints=0;
	while($grow = $grs->fetch_assoc())
	{
							
		if($grow['rating_no']==1)
			$star[0]++;
		else if($grow['rating_no']==2)
			$star[1]++;
		else if($grow['rating_no']==3)
			$star[2]++;
		else if($grow['rating_no']==4)
			$star[3]++;
		else if($grow['rating_no']==5)
			$star[4]++;
		
		$total_complaints++;
	}		
	//echo "<pre>";print_r($star);echo "</pre>";die();
	
	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}

	mysqli_close($conn);
	
	$tpl->assign('total_complaints', $total_complaints);
	$tpl->assign('star', $star);
	
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('app_type_list', array('1' => 'Complaints', '2' => 'Services'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('controlroom_feedback_report.tpl');
	
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
?>