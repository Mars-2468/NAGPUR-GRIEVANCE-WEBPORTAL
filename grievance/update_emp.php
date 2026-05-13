<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {
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
	
	
	$sql = "select * from emp_mst where emp_id='" . $_POST['emp_id'] . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data['emp_id'] = $row['emp_id'];
		$data['emp_code'] = $row['emp_code'];
		$data['emp_name'] = $row['emp_name'];
		$data['emp_name_marathi'] = $row['emp_name_marathi'];
		$data['emp_dept'] = $row['emp_dept'];
		$data['emp_desg'] = $row['emp_desg'];
		$data['emp_mobile'] = $row['emp_mobile'];
	}


	$sql = "select * from emp_mst_od where emp_id='" . $_POST['emp_id'] . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data['emp_id'] = $row['emp_id'];
		$data['emp_code'] = $row['emp_code'];
		$data['emp_name'] = $row['emp_name'];
		$data['emp_name_marathi'] = $row['emp_name_marathi'];
		$data['emp_dept'] = $row['emp_dept'];
		$data['emp_desg'] = $row['emp_desg'];
		$data['emp_mobile'] = $row['emp_mobile'];
	}


	$sql2 = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs2 = mysqli_query($conn, $sql2);
	while ($row = mysqli_fetch_assoc($rs2)) {
		$dept_list[$row['dept_id']] = $row['dept_desc'];
	}

	$sql2 = "select desg_id,desg_desc from desg_mst where dept_id='" . $data['emp_dept'] . "'";
	$rs2 = mysqli_query($conn, $sql2);
	while ($row = mysqli_fetch_assoc($rs2)) {
		$desg_list[$row['desg_id']] = $row['desg_desc'];
	}




	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}

	//	print_r($online_applications);

	$tpl->assign('online_applications', $online_applications);


	//mysqli_free_result($rs);

	//print_r($ids);
	mysqli_close($conn);
	$tpl->assign('ids', $ids);
	$tpl->assign('desg_list', $desg_list);
	$tpl->assign('multi_desg_list', $multi_desg_list);
	$tpl->assign('data', $data);
	$tpl->assign('num_emp', $num_emp);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('desg_list', $desg_list);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->display('update_emp.tpl');
} else {
	$msg = "You have Not Logged In, Please Login..!";
	$tpl->assign('msg', $msg);
	$tpl->display('user_login.tpl');
}


function sanitize_input($sanitize_data) {

	//PHP
    // Remove unnecessary spaces
    $sanitize_data = trim($sanitize_data,"-+=\'\"");

    // Strip tags to prevent HTML and PHP code injection
    $sanitize_data = strip_tags($sanitize_data);

    // Convert special characters to HTML entities (e.g., < to &lt;)
    $sanitize_data = htmlspecialchars($sanitize_data);	

	//$sanitize_data = preg_replace('/[^a-zA-Z0-9_@()-]/', '', $sanitize_data);	
		
    return $sanitize_data;
}

?>