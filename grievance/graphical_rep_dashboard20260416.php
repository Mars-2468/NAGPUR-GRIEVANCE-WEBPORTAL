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
	include('prepare_connection.php');
	$conn = getconnection();

	function getTop10grievanceDepartmentWise()
	{
		$conn = getconnection();
		$sql = "SELECT count(`grievance_id`) as count , cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id FROM `grievances` g, cs_mst c, category_mst cm where g.cat3_id=c.cs_id and c.cat_id=cm.cat_id   group by cat3_id , ward_id order by count DESC";
		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {

			$comp_details[$row['cat3_id']][$row['ward_id']]['count'] = $row['count'];
			$tot[$row['cat3_id']]['total'] += $row['count'];
			$tot_wards[$row['ward_id']]['total'] += $row['count'];
			$total += $row['count'];

			$comp_details[$row['cat3_id']]['cat_id'] = $row['cat_id'];
			$comp_details[$row['cat3_id']]['sub_cat_id'] = $row['sub_cat_id'];
			$max_comp_details[$row['cat3_id']]['count'] += $row['count'];
			$max_comp_details[$row['cat3_id']]['cat3_id'] = $row['cat3_id'];
		}






		$column = array_column($max_comp_details, 'count');
		array_multisort($column, SORT_DESC, $max_comp_details);

		$max_comp_details = array_slice($max_comp_details, 0, 10);



		return $max_comp_details;
	}


	/// user satifaction
	$data['satisfaction'] = 0;
	// more than 3 stars users
	$sql = "select COUNT(grievance_id) as count from rating_mst where rating_no >=3";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$satisfied_citizens = $row['count'];

	// all users
	$sql = "select COUNT(grievance_id) as count from rating_mst";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$total_citizens = $row['count'];


	// satisaction

	$data['satisfaction'] = $satisfied_citizens / $total_citizens;

	/// Grievances resolved percentage

	$sql = "select * from grievances";
	$rs = mysqli_query($conn, $sql);
	$nr = mysqli_num_rows($rs);
	$data['total_grievances'] = $nr;
	// Resolved grievances

	$sql = "select * from grievances where grievance_status_id=9";
	$rs = mysqli_query($conn, $sql);
	$nr = mysqli_num_rows($rs);
	$data['total_grievances_resolved'] = $nr;

	$data['gr_resolved_percent'] = round($data['total_grievances_resolved'] / $data['total_grievances'] * 100);

	/**** Top 10 grievance department wise ****/

	$data['top_ten_grievances'] = getTop10grievanceDepartmentWise();





	$sql = "SELECT * from ward_mst order by sortOrder";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$ward_list[$row['ward_id']]['ward_name'] = $row['ward_desc'];
	}


	/*** close ****/















	mysqli_close($conn);
	$tpl->assign('grand_total_complaints', $grand_total_complaints);
	$tpl->assign('grand_c_avg_res_time', $grand_c_avg_res_time);
	$tpl->assign('current_category_name', $current_category_name);
	$tpl->assign('response_time', $response_time);
	$tpl->assign('ulb_list', $ulb_list);
	$tpl->assign('feedback_sub_options', $feedback_sub_options);
	$tpl->assign('users_list', $users_list);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('app_type_id', $_REQUEST['aptid']);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('cat_list', $cat_list);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('grievance_status_list', $grievance_status_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('graphical_rep_dashboard.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/


	echo "<script>window.location='index.php';</script>";
}
