<?php
require "config.php";
require_once('Smarty.class.php');
require_once('connection.php');
require_once('get_services.php');

ini_set('display_errors', 0);
//error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

if (!isset($_SESSION['uid'])) {
    header("Location: index.php");
    exit;
}

$conn = getconnection();
$tpl  = new Smarty();
$obj  = new get_services($_SESSION['uid']);

// ================= INPUTS =================
$ulbid       = $_SESSION['ulbid'];
$user_type   = $_SESSION['user_type'];
$ward_id     = $_SESSION['zone_id'] ?? null;

$app_type_id = $_GET['app_type_id'] ?? 1;
$status      = $_GET['status'] ?? 0;
$cs_id       = $_GET['cs_id'] ?? null;

$fdate = !empty($_GET['f_date']) ? date('Y-m-d', strtotime($_GET['f_date'])) : null;
$tdate = !empty($_GET['t_date']) ? date('Y-m-d', strtotime($_GET['t_date'])) : null;

// ================= PAGINATION =================

$page  = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
//$page  = max($page, 1);
$start = ($page - 1) * $limit;
$pageNumber = $start + 1;

// ================= BASE QUERY =================
$base_sql = "
FROM grievances g
LEFT JOIN ".$_SESSION['grievances_trns']." gt ON g.grievance_id = gt.grievance_id
LEFT JOIN emp_mst e ON gt.emp_id = e.emp_id
WHERE g.ulbid = ?
AND g.app_type_id = ?
";

$params = [$ulbid, $app_type_id];
$types  = "si";

// ================= CONDITIONS =================
if (!empty($cs_id)) {
    $base_sql .= " AND g.cat3_id = ? ";
    $params[] = $cs_id;
    $types .= "i";
}

switch ($status) {
    case 2:
        $base_sql .= " AND g.grievance_status_id = 2 AND gt.sla_status = 1 ";
        break;
    case 8:
        $base_sql .= " AND g.grievance_status_id = 2 AND gt.sla_status = 2 ";
        break;
    case 3:
        $base_sql .= " AND g.grievance_status_id IN (3,8,9) AND gt.sla_status = 1 ";
        break;
    case 9:
        $base_sql .= " AND g.grievance_status_id IN (3,8,9) AND gt.sla_status = 2 ";
        break;
    case 5:
        $base_sql .= " AND g.grievance_status_id = 13 ";
        break;
}

if (!empty($ward_id)) {
    $base_sql .= " AND g.ward_id = ? ";
    $params[] = $ward_id;
    $types .= "i";
}

if (!empty($fdate) && !empty($tdate)) {
    $base_sql .= " AND DATE(g.date_regd) BETWEEN ? AND ? ";
    $params[] = $fdate;
    $params[] = $tdate;
    $types .= "ss";
}

// ================= TOTAL COUNT =================
$count_sql = "SELECT COUNT(DISTINCT g.grievance_id) as total " . $base_sql;

$cstmt = $conn->prepare($count_sql);
$cstmt->bind_param($types, ...$params);
$cstmt->execute();
$cres = $cstmt->get_result();
$total_rows = $cres->fetch_assoc()['total'] ?? 0;

// ================= MAIN DATA =================
$data_sql = "
SELECT 
    g.grievance_id,
    g.person_name,
    g.hno,
    g.address,
    g.ward_id,
    g.street_id,
    g.mobile,
    g.comp_desc,
    e.emp_name,
    e.emp_mobile,
    g.date_regd
" . $base_sql . "
GROUP BY g.grievance_id
ORDER BY g.grievance_id DESC
LIMIT ?, ?
";

$params_data = $params;
$types_data  = $types . "ii";
$params_data[] = $start;
$params_data[] = $limit;

$stmt = $conn->prepare($data_sql);
$stmt->bind_param($types_data, ...$params_data);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// ================= MASTER DATA =================
$ward_list = [];
$street_list = [];

// Ward
$stmt = $conn->prepare("SELECT ward_id, ward_desc FROM ward_mst WHERE ulbid=? AND ward_id=?");
$stmt->bind_param("si", $ulbid, $ward_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $ward_list[$row['ward_id']] = $row['ward_desc'];
}

// Street
$stmt = $conn->prepare("SELECT street_id, street_desc FROM street_mst WHERE ulbid=? AND ward_id=?");
$stmt->bind_param("si", $ulbid, $ward_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $street_list[$row['street_id']] = $row['street_desc'];
}

// ================= EXTRA DATA =================
$online_applications = [];
$rs = mysqli_query($conn, "SELECT * FROM ulb_online_application_map WHERE ulbid='".mysqli_real_escape_string($conn,$ulbid)."'");
while ($row = mysqli_fetch_assoc($rs)) {
    $online_applications = $row;
}

$rs = mysqli_query($conn, "SELECT COUNT(id) as user_count FROM login_details WHERE type='1' AND ulbid LIKE '%".mysqli_real_escape_string($conn,$ulbid)."%'");
$row = mysqli_fetch_assoc($rs);
$users_count = $row['user_count'] ?? 0;

// ================= PAGINATION =================

$total_pages = ceil($total_rows / $limit);
		// Generate pagination data
	$pagination = [
		'current_page' => $page,
		'total_pages' => $total_pages,
		'range' => 3 // Number of visible pages before/after the current page
	];
// ================= FILTER QUERY =================
$filter_query = '';

if (!empty($cs_id)) $filter_query .= '&cs_id=' . urlencode($cs_id);
if (!empty($fdate)) $filter_query .= '&f_date=' . urlencode($fdate);
if (!empty($tdate)) $filter_query .= '&t_date=' . urlencode($tdate);
if (!empty($status)) $filter_query .= '&status=' . urlencode($status);

// ================= ASSIGN =================
$tpl->assign([
    'data' => $data,
    'pagination' => $pagination,
    'current_page' => $page,
    'total_pages' => $total_pages,
    'filter_query' => $filter_query,
    'pageNumber' => $pageNumber,
    'street_list' => $street_list,
    'ward_list' => $ward_list,
    'status' => $status,
    'user_type' => $user_type,
    'ulbid' => $ulbid,
    'cs_id' => $cs_id,
    'app_type_id' => $app_type_id,
    'services' => $obj->services,
    'main_icons' => $obj->main_icons,
    'uname' => $_SESSION['user_name'],
    'uid' => $_SESSION['uid'],
    'f_date' => $fdate,
    't_date' => $tdate,
	'banner'=>$_SESSION['banner'],
    'online_applications' => $online_applications,
    'users_count' => $users_count
]);

$tpl->display('corp_complaints_full_rep.tpl');

$conn->close();
?>