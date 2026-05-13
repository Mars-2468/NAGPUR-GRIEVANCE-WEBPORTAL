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


	$ratings_list=[
		1=>1,
		2=>2,
		3=>3,
		4=>4,
		5=>5,		
	];		
	$feedback_status_list=[
		0=>'Non Feedback',
		1=>'Feedback',
	];	
	
	$feedback_sentby_list=[
		'controlroom'=>'NMC Control Room',		
		'nagpur'=>'NMC User',		
		'citizen'=>'Citizen',
		'corporator'=>'Corporator',
		'mayor'=>'Mayor',
		'deputymayor'=>'Deputy Mayor',
	];
	
	

	$from_date =!empty($_REQUEST['from_date'])? date('Y-m-d', strtotime($_REQUEST['from_date'])):'';
	$to_date =!empty($_REQUEST['to_date'])? date('Y-m-d', strtotime($_REQUEST['to_date'])):'';	
	
//echo"<pre>";print_r($_REQUEST);echo"</pre>";die();

	$rating_num = isset($_REQUEST['rating_num']) ? $_REQUEST['rating_num'] : '';
	$person_name = isset($_REQUEST['person_name']) ? $_REQUEST['person_name'] : '';
	$mobile = isset($_REQUEST['mobile']) ? $_REQUEST['mobile'] : '';
	$grievance_id = isset($_REQUEST['grievance_id']) ? $_REQUEST['grievance_id'] : '';
	$feedback_status = ($_REQUEST['feedback_status'] != -1) ? ($_REQUEST['feedback_status']==1?1:0) : -1;
	$feedback_sentby = isset($_REQUEST['feedback_sentby']) ? $_REQUEST['feedback_sentby'] : '';
	$grievance_status_id = isset($_REQUEST['grievance_status_id']) ? $_REQUEST['grievance_status_id'] : '';
	$search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
	
	$fb_status=0;	
	$nfb_status=0;	

/************************* pagination part start  **************************/
	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	
	
	
	// Set variables
	$limit = 30; // Number of records per page
	
	$start = ($page - 1) * $limit;
	$pageNumber=$start+1;
	//echo"<pre>";print_r($start);echo"</pre>";die();
	
/************************* pagination part end  **************************/
		if($_SESSION['user_id']=='controlroom'){
			$sql="select feedback_status,g.grievance_id,rm.rating_no,person_name,email,hno,mobile,address,w.ward_desc,s.street_desc,comp_desc,grievance_origin_id,grievance_status_id,date_regd,rating_given_by,rating_given_ref from grievances g,rating_mst rm, ward_mst w,street_mst s where  g.grievance_id=rm.grievance_id and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN(3,6,8,9) and g.ulbid like '%".strip_tags($_SESSION['ulbid'])."%' and app_type_id='1' ";
		}else{
			$sql="select feedback_status,g.grievance_id,rm.rating_no,person_name,email,hno,mobile,address,w.ward_desc,s.street_desc,comp_desc,grievance_origin_id,grievance_status_id,date_regd,rating_given_by,rating_given_ref from grievances g,rating_mst rm, ward_mst w,street_mst s where  g.grievance_id=rm.grievance_id and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN(3,6,8,9,12) and g.ulbid like '%".strip_tags($_SESSION['ulbid'])."%' and app_type_id='1' ";
		}
		
		if(!empty($person_name)){
			$sql.=" and person_name like '%".strip_tags($person_name)."%' ";
		}
				
		if(!empty($rating_num) && ($rating_num!= -1 )){
			$sql.=" and rating_no=". $rating_num ." ";
		}
			//echo "<pre>";print_r($sql);echo "</pre>";die();	
		if(!empty($mobile)){
			$sql.=" and mobile =".strip_tags($mobile)." ";
		}
		if(!empty($grievance_id)){
			$sql.=" and g.grievance_id=".strip_tags($grievance_id)." ";
		}
		
		if($feedback_status!=-1){
			$sql.=" and feedback_status=".$feedback_status." ";
		} 	
		
		if(!empty($feedback_sentby) && ($feedback_sentby!= -1) ){
			
			$sql.=" and rating_given_ref like '".$feedback_sentby."' ";
		}
		
		if(!empty($grievance_status_id)){
			$sql.=" and grievance_status_id=".strip_tags($grievance_status_id)." ";
		}
		if(!empty($from_date) && !empty($to_date)){
			$sql.=" and date_format(date_regd,'%Y-%m-%d') between '".$from_date."' and '".$to_date."' ";
		}

		
		$sql.="  order by g.grievance_id desc";	
		
		$pg_sql=$sql;
		
		$sql.=" LIMIT ".$start.", ".$limit." ";	
		
		//echo "<pre>";print_r($sql);echo "</pre>";die();
		
		$pgrs=mysqli_query($conn,$pg_sql);
		
		$total_rows=$pgrs->num_rows;
		
		while($row = mysqli_fetch_assoc($pgrs))
		{
		
			if($row['feedback_status']==1)
				$fb_status++;
			if($row['feedback_status']==0)
				$nfb_status++;
			
		}
		
			
		$rs=mysqli_query($conn,$sql);

		$field_info = mysqli_fetch_fields($rs);
		
		while($row = mysqli_fetch_assoc($rs))
		{
			foreach($field_info as $fi => $f) 
				$data[$row['grievance_id']][$f->name]=$row[$f->name];
			/* if($row['feedback_status']==1)
				$fb_status++;
			if($row['feedback_status']==0)
				$nfb_status++; */
			
		}
	
			
		

	$sql="select ward_id,ward_desc from ward_mst ";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
			$ward_list[$row['ward_id']]=$row['ward_desc'];
	}
	else
		printf("Errormessage: %s\n", mysqli_error($conn));
		
	
	$sql="select user_id,user_name from users where ulbid='".$_SESSION['ulbid']."'";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
			$user_list[$row['user_id']]=$row['user_name'];
	}
	else
		printf("Errormessage: %s\n", mysqli_error($conn));
		
	
		
		
	$sql="select street_id,street_desc from street_mst where ulbid='".$_SESSION['ulbid']."' order by street_desc";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
			$street_list[$row['street_id']]=$row['street_desc'];
	}	
		//echo "<pre>";print_r($street_list);echo "</pre>";die();
	$sql="select grievance_id,comment_desc,rating_no from rating_mst";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs)){
			$feedback_list[$row['grievance_id']]['comment_desc']=$row['comment_desc'];
			$feedback_list[$row['grievance_id']]['rating_no']=$row['rating_no'];
		}
	}
	
	
	
	if($_SESSION['user_id']=='controlroom'){
		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id not in(5,10,11,12,13)";
	}else{
		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";
	}
	
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
			$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
	}
	else
		printf("Errormessage: %s\n", mysqli_error($conn));
	mysqli_close($conn);
		

	
	
	//echo "<pre>";print_r($_SESSION);echo "</pre>";die();
	
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
		
	if (!empty($person_name)) {
		$filter_query .= '&person_name=' . urlencode($person_name);
	}
	if (!empty($mobile)) {
		$filter_query .= '&mobile=' . urlencode($mobile);
	}

	if (!empty($from_date)) {
		$filter_query .= '&from_date=' . urlencode($from_date);
	}

	if (!empty($to_date)) {
		$filter_query .= '&to_date=' . urlencode($to_date);
	}

	if (!empty($grievance_id)) {
		$filter_query .= '&grievance_id=' . urlencode($grievance_id);
	}

	if (!empty($grievance_status_id)) {
		$filter_query .= '&grievance_status_id=' . urlencode($grievance_status_id);
	}

	if (!empty($rating_num)) {
		$filter_query .= '&rating_num=' . urlencode($rating_num);
	}

	if (!empty($feedback_status)) {
		$filter_query .= '&feedback_status=' . urlencode($feedback_status);
	}

	if (!empty($feedback_sentby)) {
		$filter_query .= '&feedback_sentby=' . urlencode($feedback_sentby);
	}
	if (!empty($search)) {
		$filter_query .= '&search=' . urlencode($search);
	}

	$tpl->assign('filter_query', $filter_query);
	
	$tpl->assign('pagination', $pagination);
	$tpl->assign('current_page', $page);
	$tpl->assign('total_pages', $total_pages);
	
	/************************* pagination end  **************************/
	
	//echo "<pre>";print_r($data);echo "</pre>";die();
	
	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	
	mysqli_close($conn);
	$tpl->assign('pageNumber',$pageNumber);
	$tpl->assign('total_rows',$total_rows);
	$tpl->assign('data',$data);
	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('app_type_list', array('1' => 'Complaints', '2' => 'Services'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);

	$tpl->assign('user_list',$user_list);	
	$tpl->assign('ratings_list',$ratings_list);	
	$tpl->assign('feedback_status_list',$feedback_status_list);	
	$tpl->assign('feedback_status',$feedback_status);	
	$tpl->assign('rating_num',$rating_num);	
	$tpl->assign('feedback_sentby',$feedback_sentby);	
	$tpl->assign('street_list',$street_list);	
	$tpl->assign('feedback_list',$feedback_list);	
	$tpl->assign('feedback_sentby_list',$feedback_sentby_list);	
	$tpl->assign('fb_status',$fb_status);	
	$tpl->assign('nfb_status',$nfb_status);	
	$tpl->assign('ward_list',$ward_list);
	$tpl->assign('grievance_status_list',$grievance_status_list);
	$tpl->assign('from_date',$from_date);
	$tpl->assign('to_date',$to_date);
	$tpl->assign('grievance_id',$grievance_id);
	$tpl->assign('grievance_status_id',$grievance_status_id);
	$tpl->assign('grievance_status_id',$grievance_status_id);
	$tpl->assign('mobile',$mobile);
	$tpl->assign('person_name',$person_name);
	
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('controlroom_check_comp_status.tpl');
} else {
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
?>