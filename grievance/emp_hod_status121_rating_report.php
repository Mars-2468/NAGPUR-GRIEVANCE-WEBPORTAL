<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);

require_once('Smarty.class.php');
$tpl = new Smarty();

if (!isset($_SESSION['uid'])) {
    echo "<script>window.location='index.php';</script>";
    exit;
}

require_once('get_services.php');
$obj = new get_services($_SESSION['uid']);

require_once('connection.php');
$conn = getconnection();

include('prepare_connection.php');

$threshold_date = '2024-09-01';
$ulbid = $_SESSION['ulbid'];

// ✅ Inputs (safe handling)
$department_id = (int)($_POST['department_id'] ?? 0);
$emp_id='';
if(isset($_SESSION['user_type'])&&($_SESSION['user_type']=='E')){
	
	$department_id=$_SESSION['dept_id']??'';
	$emp_id=$_SESSION['emp_id']??'';
	
}

$f_date = !empty($_POST['f_date']) ? date('Y-m-d', strtotime($_POST['f_date'])) : null;
$t_date = !empty($_POST['t_date']) ? date('Y-m-d', strtotime($_POST['t_date'])) : null;

// ✅ Build query dynamically
$sql = "SELECT rating_no, COUNT(emp_id) AS empcnt 
        FROM hod_feedback_to_emp 
        WHERE DATE(ts) >= ?";

$params = [$threshold_date];
$types = "s";

if ($department_id > 0) {
    $sql .= " AND dept_id = ?";
    $params[] = $department_id;
    $types .= "i";
}
if ($emp_id!='') {
    $sql .= " AND emp_id = ?";
    $params[] = $emp_id;
    $types .= "i";
}

if ($f_date && $t_date) {
    $sql .= " AND ts BETWEEN ? AND ?";
    $params[] = $f_date;
    $params[] = $t_date;
    $types .= "ss";
}

$sql .= " GROUP BY rating_no";

// ✅ Prepare once
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();

$data = [];
$total_employees = 0;

while ($row = $result->fetch_assoc()) {
    $rating = $row['rating_no'];
    $data[$rating] = $row;
    $total_employees += $row['empcnt'];
}

if (empty($data)) {
    $tpl->assign('msg', 'Record not found');
}

// ✅ Assign filters
$tpl->assign('fdate', $f_date);
$tpl->assign('tdate', $t_date);
$tpl->assign('department_id', $department_id);
$tpl->assign('total_employees', $total_employees);

// ✅ ULB applications
$stmt = $conn->prepare("SELECT trade_application, water_tap_application 
                        FROM ulb_online_application_map 
                        WHERE ulbid=?");
$stmt->bind_param("s", $ulbid);
$stmt->execute();
$res = $stmt->get_result();
$online_applications = $res->fetch_assoc() ?? [];

// ✅ Department list
$res = $conn->query("SELECT dept_id, dept_desc FROM dept_mst");
$dept_list = [0 => 'Select'];

while ($row = $res->fetch_assoc()) {
    $dept_list[$row['dept_id']] = $row['dept_desc'];
}

// ✅ Assign to template
$tpl->assign([
    'online_applications' => $online_applications,
    'dept_list' => $dept_list,
    'data' => $data,
    'services' => $obj->services,
    'main_icons' => $obj->main_icons,
    'uname' => $_SESSION['user_name'],
    'banner' => $_SESSION['banner'],
    'logo' => $_SESSION['logo'],
    'uid' => $_SESSION['uid'],
    'user_type' => $_SESSION['user_type'],
    'ulbid' => $ulbid,
    'app_type_list' => ['1' => 'Complaints', '2' => 'Services']
]);

$tpl->display('emp_hod_status121_rating_report.tpl');