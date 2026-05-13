<?php
require "config.php"; 
require_once('connection.php');
$conn = getconnection();

// Get POST values safely
$uid = trim($_POST['username'] ?? '');
$pwd = sha1(trim($_POST['password'] ?? ''));

//sha1($_POST['fk']);


// Validate input
/* if (empty($uid) || empty($pwd)) {
    exit("Invalid input");
} */

// Fetch user
//$sql = "SELECT * FROM users WHERE user_id = ? and user_pwd=PASSWORD(?)";
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $uid);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();
//$row && password_verify($pwd, $row['user_pwd']

if ($row['user_id']!=='nagpur') {
    // Generate OTP
    $otp = rand(1000, 9999);
    $user_mobile = '8919820778';//$row['user_mobile'];

    // Update OTP securely
    $updateSql = "UPDATE users SET otp_status = ?, otp = ? WHERE user_mobile = ?";
    $updateStmt = $conn->prepare($updateSql);
    $otp_status = 2;

    $updateStmt->bind_param("iis", $otp_status, $otp, $user_mobile);
    $updateStmt->execute();

    // Send SMS
	$sms = "One Time Password (OTP) for NMC application logging is " . $otp . " Please use this OTP for logging NMCGov. Pls do not share this with any one, Valid for 5 minutes.";
       
	$templateId = "1707170780475551415";

	//$sms = "Dear ".substr($emp_name_list[$row1['emp_id']], 0, 28).", A Grievance from ".mysqli_real_escape_string($conn,strip_tags(substr($_POST['person_name'], 0, 28))).", Mobile No. ".mysqli_real_escape_string($conn,strip_tags($_POST['mobile'])).", ".substr($complaintType, 0, 28)." with Ref No ".$grievance_id."is allotted to you on ".date('d-m-Y H:i:s')." https://egovmars.in/csms/ Regards- CitizenServiceMonitoringCell ,NMCGOV";
   
	$result = sendSMS($user_mobile,$sms,$templateId);   
	
	echo "SUCCESS";
	exit;
} else {
    echo "FAIL";
	exit;
}


?>
