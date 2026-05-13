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

	$app_type_id = $_REQUEST['app_type_id']??'';
	$origin_id = $_REQUEST['originid']??'';
	$ward_id = $_SESSION['zone_id']??'';
	
	
	$ulbid = $_REQUEST['ulbid'] ?? '';
$origin_id = $_REQUEST['originid'] ?? '';

$sql = "
SELECT 
    g.cat3_id,

    SUM(CASE WHEN g.grievance_status_id IN (3,6,8,9,12) THEN 1 ELSE 0 END) AS completed,
    SUM(CASE WHEN g.grievance_status_id = 1 THEN 1 ELSE 0 END) AS pendingforapproval,
    SUM(CASE WHEN g.grievance_status_id IN (2,11) THEN 1 ELSE 0 END) AS pending

FROM grievances g
JOIN ulbmst u ON g.ulbid = u.ulbid
JOIN Districtmst d ON u.distid = d.distid

WHERE g.app_type_id = 1
AND g.ulbid = ?
AND g.cat3_id != 0
";

$params = [$ulbid];
$types = "s";

// ward filter
if (!empty($ward_id)) {
    $sql .= " AND g.ward_id = ? ";
    $params[] = $ward_id;
    $types .= "i";
}

// RDMA filter
if ($_SESSION['user_type'] == 'R') {
    $sql .= " AND d.rdma = ? ";
    $params[] = $_SESSION['uid'];
    $types .= "s";
}

// origin filter
if ($origin_id == 3) {
    $sql .= " AND g.grievance_origin_id = 3 ";
} elseif ($origin_id != 0) {
    $sql .= " AND g.grievance_origin_id = ? ";
    $params[] = $origin_id;
    $types .= "i";
}

$sql .= " GROUP BY g.cat3_id";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$data2 = [
    'completed' => 0,
    'pendingforapproval' => 0,
    'pending' => 0,
    'total' => 0
];

while ($row = $result->fetch_assoc()) {

    $cid = $row['cat3_id'];

    $data2[$cid]['completed'] = $row['completed'];
    $data2[$cid]['pendingforapproval'] = $row['pendingforapproval'];
    $data2[$cid]['pending'] = $row['pending'];

    $row_total = $row['completed'] + $row['pendingforapproval'] + $row['pending'];

    $data2[$cid]['total'] = $row_total;

    // grand totals
    $data2['completed'] += $row['completed'];
    $data2['pendingforapproval'] += $row['pendingforapproval'];
    $data2['pending'] += $row['pending'];
    $data2['total'] += $row_total;
}

	//print_r($data3);

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
	$tpl->assign('ulbid', $_REQUEST['ulbid']);
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
	$tpl->display('corp_cat_origin.tpl');
} else {
	$msg = "You have not logged in, Please Login";
	$tpl->assign('msg', $msg);
	$tpl->display('user_login.tpl');
}
