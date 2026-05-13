<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_GET['active'])) {
	$active_class = $_GET['active'];
}

if (isset($_SESSION['uid'])) {

	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	
	$ward_id=!empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,dept_id,disposal_status from grievances g, ".$_SESSION['grievances_trns']." gt where 
	g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and 
	gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) ";

	$sql .= " and g.ward_id = " . $ward_id . " ";
	$sql .= " group by gt.dept_id";
	//echo $sql;     

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['dept_id']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));
	
	//total completed 

	if ($_SESSION['ulbid'] == '3') {
		$sql = "select COUNT(DISTINCT gt.grievance_id) as count,dept_id ,disposal_status,g.date_regd,g.sla_status from grievances g, 
        ".$_SESSION['grievances_trns']." gt,cs_mst c where 
        g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and 
        g.sla_status='1' and gt.disposal_status!='5' and cat3_id !='0'  and gt.disposal_status IN(3,6,8,9,12)";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
    	app_type_id='1' and g.grievance_status_id IN(3,6,8,9,12) and cat3_id !='0' ";
	}

	$sql .= " and g.ward_id = " . $ward_id . " ";

	$sql .= " group by gt.dept_id";

	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {

			$data[$row['dept_id']]['completed'] += $row['count'];
			$tot['completed'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


//echo"<pre>";print_r($tot);echo"</pre>";die();

// total pending
	if ($_SESSION['ulbid'] == '3') {
		$sql = "select COUNT(DISTINCT gt.grievance_id) as count,dept_id,disposal_status,g.date_regd,g.sla_status from grievances g, 
	".$_SESSION['grievances_trns']." gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and 
           gt.disposal_status!='5' and cat3_id !='0'
          and gt.disposal_status IN('2') and g.grievance_status_id IN('2') ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id  FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
    				 app_type_id='1' and g.grievance_status_id IN(2,5,10,11,13) and gt.disposal_status IN(2,5,10,11,13)  and cat3_id !='0' ";

	}

	$sql .= " and g.ward_id = " . $ward_id . " ";

	$sql .= " group by gt.dept_id";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	//echo $sql6;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['dept_id']]['pending'] += $row['count'];

		$tot['pending'] += $row['count'];
	}

	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";
	
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	$sql = "select COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . $_SESSION['ulbid'] . "%'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$users_count = $row['user_count'];

	mysqli_close($conn);

	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('users_count', $users_count);
	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('ulb', $_SESSION['ulbid']);
	$tpl->assign('tot', $tot);
	$tpl->assign('data', $data);

	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('active_class', $active_class);

	$tpl->display('corp_dept_pendency_report.tpl');

} else {
	
	echo "<script>window.location='index.php';</script>";
}
