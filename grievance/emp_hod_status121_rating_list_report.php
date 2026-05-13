<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);

require_once('Smarty.class.php');
$tpl = new Smarty();

// ✅ Inputs (safe)
$department_id = (int)($_REQUEST['department_id'] ?? 0);

$emp_id='';
if(isset($_SESSION['user_type'])&&($_SESSION['user_type']=='E')){
	
	$department_id=$_SESSION['dept_id']??'';
	$emp_id=$_SESSION['emp_id']??'';
	
}
$threshold_date = '2024-09-01';
$rating_no     = (int)($_REQUEST['rating_no'] ?? 0);
$f_date = !empty($_REQUEST['f_date']) ? date('Y-m-d', strtotime($_REQUEST['f_date'])) : null;
$t_date = !empty($_REQUEST['t_date']) ? date('Y-m-d', strtotime($_REQUEST['t_date'])) : null;

if ($rating_no <= 0) {
    echo "<script>window.location='index.php';</script>";
    exit;
}

// ✅ Load dependencies
require_once('get_services.php');
$obj = new get_services($_SESSION['uid']);

require_once('connection.php');
$conn = getconnection();

include('prepare_connection.php');

$ulbid = $_SESSION['ulbid'];

// ✅ Build query dynamically
$sql = "SELECT emp_id, grievance_id, dept_id, rating_no 
        FROM hod_feedback_to_emp 
        WHERE DATE(ts) >= ?";

$params = [$threshold_date];
$types  = "s";

if ($rating_no > 0) {
    $sql .= " AND rating_no = ?";
    $params[] = $rating_no;
    $types .= "i";
}
if ($emp_id !='') {
    $sql .= " AND emp_id = ?";
    $params[] = $emp_id;
    $types .= "i";
}
if ($department_id > 0) {
    $sql .= " AND dept_id = ?";
    $params[] = $department_id;
    $types .= "i";
}

if ($f_date && $t_date) {
    $sql .= " AND ts BETWEEN ? AND ?";
    $params[] = $f_date;
    $params[] = $t_date;
    $types .= "ss";
}

// ✅ Prepare once
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();

$data = [];
$total_employees = 0;

while ($row = $result->fetch_assoc()) {
    $emp = $row['emp_id'];
    $grievance_id = $row['grievance_id'];
    $data[$emp][$grievance_id]['emp_id'] = $row['emp_id'];
    $data[$emp][$grievance_id]['grievance_id'] = $row['grievance_id'];
    $data[$emp][$grievance_id]['dept_id'] = $row['dept_id'];
    $data[$emp][$grievance_id]['rating_no'] = $row['rating_no'];
    $total_employees++;
}


//echo "<pre>";print_r($data);echo "</pre>";die();

if (empty($data)) {
    $tpl->assign('msg', 'Record not found');
}

// ✅ Filters
$tpl->assign('fdate', $f_date);
$tpl->assign('tdate', $t_date);

// ✅ Online applications
$stmt = $conn->prepare("
    SELECT trade_application, water_tap_application 
    FROM ulb_online_application_map 
    WHERE ulbid=?
");
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

// ✅ Employee list (only needed ones)
$emp_list = [];
if (!empty($data)) {
    $ids = implode(',', array_keys($data));
    $res = $conn->query("SELECT emp_id, emp_name, emp_dept FROM emp_mst WHERE emp_id IN ($ids)");

    while ($row = $res->fetch_assoc()) {
        $emp_id = $row['emp_id'];
        $emp_list[$emp_id] = [
            'emp_id'        => $emp_id,
            'emp_name'      => $row['emp_name'],
            'emp_dept'      => $row['emp_dept'],
            'grievance_id'  => $data[$emp_id]['grievance_id'] ?? null
        ];
    }
}

// ✅ Assign everything
$tpl->assign([
    'online_applications' => $online_applications,
    'dept_list'           => $dept_list,
    'emp_list'            => $emp_list,
    'data'                => $data,
    'total_employees'     => $total_employees,
    'department_id'       => $department_id,
    'rating_no'           => $rating_no,
    'services'            => $obj->services,
    'main_icons'          => $obj->main_icons,
    'uname'               => $_SESSION['user_name'],
    'banner'              => $_SESSION['banner'],
    'logo'                => $_SESSION['logo'],
    'uid'                 => $_SESSION['uid'],
    'user_type'           => $_SESSION['user_type'],
    'ulbid'               => $ulbid,
    'app_type_list'       => ['1' => 'Complaints', '2' => 'Services']
]);

$tpl->display('emp_hod_status121_rating_list_report.tpl');