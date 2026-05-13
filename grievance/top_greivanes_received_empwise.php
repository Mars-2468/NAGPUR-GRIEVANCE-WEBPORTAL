<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {



	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	include('prepare_connection.php');
	$conn = getconnection();



	$sql = "SELECT count(DISTINCT g.grievance_id) as count ,cat3_id,description,cm.cat_id,c.sub_cat_id,emp_id FROM grievances g,grievances_transactions gt, cs_mst c, category_mst cm where g.grievance_id = gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id group by cat3_id , emp_id order by count DESC";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$comp_details[$row['cat3_id']][$row['emp_id']]['count'] = $row['count'];
		$tot[$row['cat3_id']]['total'] += $row['count'];
		$tot_wards[$row['emp_id']]['total'] += $row['count'];
		$total += $row['count'];

		$comp_details[$row['cat3_id']]['cat_id'] = $row['cat_id'];
		$comp_details[$row['cat3_id']]['sub_cat_id'] = $row['sub_cat_id'];
		$max_comp_details[$row['cat3_id']]['count'] += $row['count'];
		$max_comp_details[$row['cat3_id']]['cat3_id'] = $row['cat3_id'];
	}






	$column = array_column($max_comp_details, 'count');
	array_multisort($column, SORT_DESC, $max_comp_details);

	$max_comp_details = array_slice($max_comp_details, 0, 10);





	$sql = "SELECT emp_id, emp_name FROM emp_mst LIMIT 10";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$ward_list[$row['emp_id']]['emp_name'] = $row['emp_name'];
	}

	$sql = "SELECT * FROM `comp_cutofdays_map`";
	$query = $conn->prepare($sql);

	if (!$query->execute()) {
		echo "Query not executed 1";
	}
	$rs = $query->get_result();
	while ($row = $rs->fetch_assoc()) {
		$data[$row['cs_id']]['cutt_off_time'] = $row['cutt_off_time'];
	}


	$sql = "select cat_id, description from category_mst where ulbid= ? and cs_type_id= ?";

	$ulbid = '250';
	$cs_type_id = '1';

	$query = $conn->prepare($sql);
	$query->bind_param("si", $ulbid, $cs_type_id);

	if (!$query->execute()) {
		echo "Query not executed 2";
	}
	$rs3 = $query->get_result();

	while ($row = $rs3->fetch_assoc()) {
		$cat_list[$row['cat_id']] = $row['description'];
	}




	$sql = "select * from subcategory_mst";



	$query = $conn->prepare($sql);


	if (!$query->execute()) {
		echo "Query not executed 2";
	}
	$rs3 = $query->get_result();

	while ($row = $rs3->fetch_assoc()) {
		$sub_cat_list[$row['cat_id']][$row['sub_cat_id']] = $row['description'];
	}




	$sql = "select * from cs_mst";

	$query = $conn->prepare($sql);

	if (!$query->execute()) {
		echo "Query not executed 3";
	}
	$rs4 = $query->get_result();


	while ($row = $rs4->fetch_assoc()) {
		$cs_list[$row['cs_id']]['desc'] = $row['cs_desc'];
		$cs_list[$row['cs_id']]['cat_id'] = $row['cat_id'];
		$cs_list[$row['cs_id']]['sub_cat_id'] = $row['sub_cat_id'];
	}

	$sql = "select * from level_disposabledays_map";

	$query = $conn->prepare($sql);

	if (!$query->execute()) {
		echo "Query not executed 3";
	}
	$rs4 = $query->get_result();


	while ($row = $rs4->fetch_assoc()) {
		$disposable_days[$row['cs_id']]['L1'] = $row['L1'];
		$disposable_days[$row['cs_id']]['L2'] = $row['L2'];
		$disposable_days[$row['cs_id']]['L3'] = $row['L3'];
	}





	$row = $rs4->fetch_assoc();

	$tpl->assign('total', $total);
	$tpl->assign('tot_wards', $tot_wards);
	$tpl->assign('tot', $tot);
	$tpl->assign('comp_details', $comp_details);
	$tpl->assign('max_comp_details', $max_comp_details);
	$tpl->assign('ward_list', $ward_list);

	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);
	$conn->close();
	$tpl->assign('data', $data);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('sub_cat_list', $sub_cat_list);
	$tpl->assign('cat_list', $cat_list);
	$tpl->assign('disposable_days', $disposable_days);
	$tpl->assign('services', $obj->services);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('top_greivanes_received_empwise.tpl');
} else {


	echo "<script>window.location='index.php';</script>";
}
?>