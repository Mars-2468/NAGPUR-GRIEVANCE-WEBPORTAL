<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {


	//session_regenerate_id();
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



/************************* pagination part start  **************************/
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	//echo"<pre>";print_r(isset($_GET['page']));echo"</pre>";die();
	// Set variables
	$fb_status=0;	
	$limit = 30; // Number of records per page
	
	$start = ($page - 1) * $limit;
	$pageNumber=$start+1;
/************************* pagination part end  **************************/
	
	// testing start
	
	//$sql="select feedback_status,g.grievance_id,rm.rating_no,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,rm.comment_desc,grievance_origin_id,grievance_status_id,date_regd,rating_given_by from grievances g,rating_mst rm where  g.grievance_id=rm.grievance_id and grievance_status_id IN(3,6,8,9,12) and ulbid like '%".strip_tags($_SESSION['ulbid'])."%' and app_type_id='1' ";
	
	$sql="select feedback_status,g.grievance_id,rm.rating_no,person_name,email,hno,mobile,address,w.ward_desc,s.street_desc,comp_desc,grievance_origin_id,grievance_status_id,date_regd,rating_given_by,rating_given_ref from grievances g,rating_mst rm, ward_mst w,street_mst s where  g.grievance_id=rm.grievance_id and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN(3,6,8,9,12) and g.ulbid like '%".strip_tags($_SESSION['ulbid'])."%' and app_type_id='1' ";

		
		
		//echo"<pre>";print_r($_REQUEST['rating']);echo"</pre>";die();
		$rating=!empty($_REQUEST['rating'])?$_REQUEST['rating']:$_GET['rating'];
		if($rating==12345){
			$sql.=" and rating_no IN(1,2,3,4,5) ";
		}else{
			$sql.=" and rating_no=". $rating ." ";
		}
						
		$sql.="  order by g.grievance_id desc";	
		
		
		/************************* pagination part start  **************************/

		$pg_sql=$sql;
		
		$sql.=" LIMIT ".$start.", ".$limit." ";	
		
		$pgrs=mysqli_query($conn,$pg_sql);
		
		$total_rows=$pgrs->num_rows;
		
		while($pqrow = mysqli_fetch_assoc($pgrs))
		{			
			//if($pqrow['feedback_status']!=0)
				$fb_status++;
		}
						
		/************************* pagination part end  **************************/
					
		$rs=mysqli_query($conn,$sql);
		
		$field_info = mysqli_fetch_fields($rs);
		
		while($row = mysqli_fetch_assoc($rs))
		{
			foreach($field_info as $fi => $f) 
				$data[$row['grievance_id']][$f->name]=$row[$f->name];
			
				//$fb_status++;
			
		}
	// testing end
	
	
	
	$tpl->assign('data',$data);
	
	// testing ending
	

	$sql="select ward_id,ward_desc from ward_mst where ulbid='".$ulbid."'";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
			$ward_list[$row['ward_id']]=$row['ward_desc'];
	}
	else
		printf("Errormessage: %s\n", mysqli_error($conn));
		
		
	$sql="select street_id,street_desc from street_mst where ulbid='".$ulbid."' order by street_desc";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
			$street_list[$row['street_id']]=$row['street_desc'];
	}	
	
	$sql="select grievance_id,comment_desc,rating_no from rating_mst";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs)){
			$feedback_list[$row['grievance_id']]['comment_desc']=$row['comment_desc'];
			$feedback_list[$row['grievance_id']]['rating_no']=$row['rating_no'];
		}
	}

	$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
			$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
	}
	else
		printf("Errormessage: %s\n", mysqli_error($conn));

	
	//echo "<pre>";print_r($data);echo "</pre>";die();

	$sql="select user_id,user_name from users where ulbid='".$_SESSION['ulbid']."'";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
			$user_list[$row['user_id']]=$row['user_name'];
	}
	else
		printf("Errormessage: %s\n", mysqli_error($conn));
	
	
	/************************* pagination start  **************************/
	
		
	// Query to fetch paginated data


	// Calculate total pages
	
	$total_pages = ceil($total_rows / $limit);
	


	// Generate pagination data
	$pagination = [
		'current_page' => $page,
		'total_pages' => $total_pages,
		'range' => 3 // Number of visible pages before/after the current page
	];
			
	$filter_query = '';

	//echo "<pre>";print_r($data);echo "</pre>";die();
	
	if (!empty($rating)) {
		$filter_query .= '&rating=' . urlencode($rating);
	}

	$tpl->assign('filter_query', $filter_query);
	


	$tpl->assign('pageNumber', $pageNumber);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('current_page', $page);
	$tpl->assign('total_pages', $total_pages);
	
	/************************* pagination end  **************************/
	
		
	mysqli_close($conn);
		
			//echo "<pre>";print_r($user_list['nagpur']);echo "</pre>";die('hhhhhhhhhh');
	
	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}

	mysqli_close($conn);
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('app_type_list', array('1' => 'Complaints', '2' => 'Services'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);

	$tpl->assign('grievance_list',$grievance_list);	
	$tpl->assign('street_list',$street_list);	
	$tpl->assign('feedback_list',$feedback_list);	
	$tpl->assign('user_list',$user_list);	
		
	$tpl->assign('ward_list',$ward_list);
	$tpl->assign('grievance_status_list',$grievance_status_list);
	$tpl->assign('fb_status',$fb_status);	
	
	$tpl->assign('data', $data);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('controlroom_grievance_ratingwise_list.tpl');
} else {
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
?>