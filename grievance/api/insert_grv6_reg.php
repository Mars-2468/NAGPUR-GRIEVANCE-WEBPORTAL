<?php
ini_set('display_errors', 0);
require_once('../connection.php');
//require_once('../send_sms.php');
//require_once('../sms_conf.php');

$conn = getconnection();
mysqli_set_charset($conn, 'utf8');

date_default_timezone_set('Asia/Calcutta');

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

//json_encode($data);exit;


if (!$data) {
    echo json_encode(['status_code' => '201', 'status_desc' => 'Invalid JSON input']);
    exit;
}

$apk_version = $data['apk_version'] ?? '';
require_once('check_version.php');

// Validate required fields
$requiredFields = ['person_name', 'hno', 'address', 'mobile', 'cs_id'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        echo json_encode(['status_code' => '201', 'status_desc' => "Missing field: $field"]);
        exit;
    }
}

// Fetch ward and street lists
$ward_list = $street_list = $cs_list = [];
$emp_name_list = $emp_dept_list = $emp_desg_list = $emp_mobile_list = [];

// Fetch ward list
$ward_query = "SELECT ward_id, ward_desc FROM ward_mst WHERE ulbid=?";
$stmt = $conn->prepare($ward_query);
$stmt->bind_param('s', $data['ulbid']);
$stmt->execute();
$rs = $stmt->get_result();
while ($row = $rs->fetch_assoc()) {
    $ward_list[$row['ward_id']] = $row['ward_desc'];
}

// Fetch street list
$street_query = "SELECT street_id, street_desc FROM street_mst WHERE ulbid=? ORDER BY street_desc";
$stmt = $conn->prepare($street_query);
$stmt->bind_param('s', $data['ulbid']);
$stmt->execute();
$rs = $stmt->get_result();
while ($row = $rs->fetch_assoc()) {
    $street_list[$row['street_id']] = $row['street_desc'];
}

// Fetch complaint type list
$rs = mysqli_query($conn, "SELECT cs_id, cs_desc as comp_desc FROM cs_mst");
while ($row = mysqli_fetch_assoc($rs)) {
    $cs_list[$row['cs_id']] = $row['comp_desc'];
}

// Get complaint record row
$sql = "SELECT cs_id, cat_id, sub_cat_id FROM cs_mst WHERE cs_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $data['cs_id']);
$stmt->execute();
$rs = $stmt->get_result();
$complaint_rec_row = $rs->fetch_assoc();

// Fetch employee data
foreach (['emp_mst', 'emp_mst_od'] as $table) {
    $emp_query = "SELECT emp_id, emp_name, emp_dept, emp_desg, emp_mobile FROM $table WHERE ulbid=?";
    $stmt = $conn->prepare($emp_query);
    $stmt->bind_param('s', $data['ulbid']);
    $stmt->execute();
    $rs = $stmt->get_result();
    while ($row = $rs->fetch_assoc()) {
        $emp_name_list[$row['emp_id']] = $row['emp_name'];
        $emp_dept_list[$row['emp_id']] = $row['emp_dept'];
        $emp_desg_list[$row['emp_id']] = $row['emp_desg'];
        $emp_mobile_list[$row['emp_id']] = $row['emp_mobile'];
    }
}

// File handling
$target_file = !empty($data['base64_filecontent']) ? createFile($data['base64_filecontent'], $data['imei']) : '#';

// Check for duplicate
$check_sql = "SELECT grievance_id FROM grievances WHERE app_type_id='1' AND person_name=? AND email='-' AND hno=? AND address=? AND ward_id=? AND street_id=? AND mobile=? AND comp_subject=? AND comp_desc=? AND grievance_origin_id='4' AND user_id=? AND lat=? AND lng=? AND cat3_id=? AND sub_cat_id=? AND ulbid=? AND tanker_type_id=?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param(
    'ssssssssssssssss',
    $data['person_name'], $data['hno'], $data['address'], $data['ward_id'], $data['street_id'], $data['mobile'],
    $data['comp_subject'], $data['comp_desc'], $data['imei'], $data['lat'], $data['lng'],
    $complaint_rec_row['cat_id'], $complaint_rec_row['sub_cat_id'], $data['ulbid'], $data['tanker_id']
);
$stmt->execute();
$rs = $stmt->get_result();

if ($rs->num_rows > 0) {
    $response = ['status_code' => '409', 'status_desc' => 'Duplicate grievance'];
} else {
    $insert_sql = "INSERT INTO grievances (app_type_id, person_name, email, hno, address, ward_id, street_id, mobile, comp_desc, grievance_origin_id, grievance_status_id, date_regd, user_id, lat, lng, file_url, cat3_id, mcat3_id, sub_cat_id, ulbid, tanker_type_id, device_os_id,grievance_at_emp_level) VALUES ('1', ?, ?, ?, ?, ?, ?, ?, ?, '4', '1', NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,'L1')";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param(
        'ssssiisssiisiiisss',
        $data['person_name'],  $data['email'],$data['hno'],$data['address'], $data['ward_id'], $data['street_id'], $data['mobile'],
        $data['comp_desc'], $data['imei'], $data['lat'], $data['lng'], $target_file,
        $complaint_rec_row['cat_id'], $complaint_rec_row['cat_id'], $complaint_rec_row['sub_cat_id'], $data['ulbid'], $data['tanker_id'], $data['deviceOs']
    );
	
    if ($stmt->execute()) {
        $grievance_id = $stmt->insert_id;
        $response = ['status_code' => '200', 'status_desc' => "Grievance registered successfully with ID: $grievance_id"];
	
		$sms="Dear " .  substr($data['person_name'], 0, 29) . ", Your Grievance regarding " . substr($data['comp_desc'], 0, 29) . " with " . $grievance_id . " allotted to " .  substr($data['mobile'], 0, 28) . " on " . date('d-m-Y H:i:s') . " Track your Application Status at " . substr("https://nmcnagpur.gov.in/g1",0,29) . " Regards, NMCGOV";

		$templateId = "1707172138939247588";

		$mobile =$data['mobile'];
							
		$result=sendSMS($mobile,$sms,$templateId);

   } else {
        $response = ['status_code' => '500', 'status_desc' => 'Database insertion error'];
    }
}

function createFile($base64_file_content, $imei)
{
    $base64File = strip_tags($base64_file_content);
    $fileContent = base64_decode($base64File);
    $comp_subject_as_filename = $imei . '_' . date('Y-m-d_H-i-s') . '.pdf';
    $savePath = "grievance/decPhotos/" . $comp_subject_as_filename;
    $dir = dirname($savePath);

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    file_put_contents($savePath, $fileContent);
    return $savePath;
}

echo json_encode($response);
mysqli_close($conn);
