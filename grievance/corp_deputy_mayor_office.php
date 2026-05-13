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

	$app_type_id = $_REQUEST['app_type_id'];
	$origin_id = $_REQUEST['originid'];
	


	$sql = "select g.*,count(cat3_id) as completed,cat3_id from grievances g, ulbmst u where g.ulbid=u.ulbid and 
	app_type_id='1' and g.ulbid like '%" . $_REQUEST['ulbid'] . "%' and grievance_status_id in ('3','4','6','10','9','13','12') ";

	if ($_SESSION['user_type'] == 'U') {
		if (($_SESSION['uid']!='') && in_array($_SESSION['uid'],$deputy_mayor_users)) {		
			$escaped_users = array_map(function($val) use ($conn) {
				return "'" . mysqli_real_escape_string($conn, $val) . "'";
			}, $deputy_mayor_users);

			$sql .= " AND g.user_id IN (" . implode(',', $escaped_users) . ") ";
		}else	
		$sql .= " and g.user_id='" . $_SESSION['uid'] . "'";
	}
	if ($_REQUEST['originid'] == 10) {
		//$sql.=" and grievance_origin_id IN('1','3')";
		$sql .= " and grievance_origin_id IN('10')";
	} else if ($_REQUEST['originid'] == 0) {
	} else {
		$sql .= "and grievance_origin_id='" . $_REQUEST['originid'] . "'";
	}
	$sql .= " group by cat3_id";

//echo $sql;die();

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data2[$row['cat3_id']]['completed'] = $row['completed'];
		$data2['completed'] += $row['completed'];
		$data2['total'] += $row['completed'];
	}


	$sql = "select g.*,count(cat3_id) as pendingforapproval,cat3_id from grievances g, ulbmst u where g.ulbid=u.ulbid
	and app_type_id='1' and g.ulbid like '%" . $_REQUEST['ulbid'] . "%' and grievance_status_id in ('1')  and g.cat3_id != '0'";
	if ($_SESSION['user_type'] == 'U') {
		if (($_SESSION['uid']!='') && in_array($_SESSION['uid'],$deputy_mayor_users)) {	
		
			$escaped_users = array_map(function($val) use ($conn) {
				return "'" . mysqli_real_escape_string($conn, $val) . "'";
			}, $deputy_mayor_users);

			$sql .= " AND g.user_id IN (" . implode(',', $escaped_users) . ") ";
		}else	
		$sql .= " and g.user_id='" . $_SESSION['uid'] . "'";
	}
	if ($_REQUEST['originid'] == 10) {
		//$sql.=" and grievance_origin_id IN('1','3')";
		$sql .= " and grievance_origin_id IN('10')";
	} else if ($_REQUEST['originid'] == 0) {
	} else {
		$sql .= "and grievance_origin_id='" . $_REQUEST['originid'] . "'";
	}
	$sql .= " group by cat3_id";

	//echo $sql ;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data2[$row['cat3_id']]['pendingforapproval'] = $row['pendingforapproval'];
		$data2['pendingforapproval'] += $row['pendingforapproval'];
		$data2['total'] += $row['pendingforapproval'];
	}



	$sql = "select g.*,count(cat3_id) as pending,cat3_id from grievances g,ulbmst u where g.ulbid=u.ulbid and app_type_id='1' and g.ulbid like '%" . $_REQUEST['ulbid'] . "%' and grievance_status_id in ('2','11') ";
	
	if ($_SESSION['user_type'] == 'U') {
		
		if (($_SESSION['uid']!='') && in_array($_SESSION['uid'],$deputy_mayor_users)) {	
		
			$escaped_users = array_map(function($val) use ($conn) {
				return "'" . mysqli_real_escape_string($conn, $val) . "'";
			}, $deputy_mayor_users);

			$sql .= " AND g.user_id IN (" . implode(',', $escaped_users) . ") ";
		}else	
		$sql .= " and g.user_id='" . $_SESSION['uid'] . "'";
	}
	
	
	if ($_REQUEST['originid'] == 10) {
		//$sql.=" and grievance_origin_id IN('1','3')";
		$sql .= " and grievance_origin_id IN('10')";
	} else if ($_REQUEST['originid'] == 0) {
	} else {
		$sql .= "and grievance_origin_id='" . $_REQUEST['originid'] . "'";
	}

	$sql .= "group by cat3_id";


//echo $sql;exit;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data2[$row['cat3_id']]['pending'] = $row['pending'];
		$data2['pending'] += $row['pending'];
		$data2['total'] += $row['pending'];
	}

	$sql = "select ward_id,ward_desc from ward_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$ward_list[$row['ward_id']] = $row['ward_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$grievance_status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	
	$sql = "select cs_id,cs_desc as comp_desc from cs_mst";

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			//$cs_list1[$row['cs_id']]=$row['cs_id'];
			$cs_list[$row['cs_id']] = $row['comp_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	//	print_r($cs_list);

	$sql = "select * from grievance_origin_mst where grievance_origin_id='" . $_REQUEST['originid'] . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$origin_list[$row['grievance_origin_id']] = $row['grievance_origin_desc'];
	}
	$origin_list[0] = "Website";

	$sql = "select * from grievance_status_mst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	}

	$sql = "select * from ulbmst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$ulb_list[$row['ulbid']] = $row['ulbname'];
	}


	function buildinclause($deputy_mayor_users){
			return array_map(function($val) use ($conn) {
			return "'" . mysqli_real_escape_string($conn, $val) . "'";
		}, $deputy_mayor_users);
	}

	mysqli_close($conn);

	//print_r($data2);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('ulb_list', $ulb_list);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('data2', $data2);
	$tpl->assign('data5', $data5);
	$tpl->assign('data3', $data3);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('origin_list', $origin_list);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('origin_id', $_REQUEST['originid']);

	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('grievance_status_list', $grievance_status_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('corp_deputy_mayor_office.tpl');
} else {
	$msg = "You have not logged in, Please Login";
	$tpl->assign('msg', $msg);
	$tpl->display('user_login.tpl');
}
