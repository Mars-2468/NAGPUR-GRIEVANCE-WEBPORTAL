<?php
require "config.php"; 
require_once('connection.php');
$conn = getconnection();
date_default_timezone_set('Asia/Calcutta');
// Get POST values safely
$uid = trim($_POST['username'] ?? '');
$pwd = sha1(trim($_POST['password'] ?? ''));

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

if (!in_array($row['user_id'],$admin_level_users)) {
	
    // Generate OTP
    $otp = rand(1000, 9999);
    $user_mobile = $row['user_mobile'];

    // Update OTP securely
    $updateSql = "UPDATE users SET otp_status = ?, otp = ? WHERE user_mobile = ?";
    $updateStmt = $conn->prepare($updateSql);
    $otp_status = 2;

    $updateStmt->bind_param("iis", $otp_status, $otp, $user_mobile);
    $updateStmt->execute();

    // Send SMS
	$sms = "One Time Password (OTP) for NMC application logging is " . $otp . " Please use this OTP for logging NMCGov. Pls do not share this with any one, Valid for 5 minutes.";
       
	$templateId = "1707170780475551415";
   
	$result = sendSMS($user_mobile,$sms,$templateId);   
	
	$minutes_to_add = 5;

	$time = new DateTime();
	$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

	$stamp = $time->format('Y-m-d H:i');
	
	$obj = json_decode($result);
	
	
	if($obj->success==1){
	$sql = "insert into user_otp_logs(
				user_ip,
				mobile,
				otp,
				otp_date_time,
				otp_expiry_date,
				otp_status
				
				)values(
					'" . $_SERVER['REMOTE_ADDR'] . "',
					'" . $user_mobile . "',
					'" . $otp . "',
					'" . date('Y-m-d H:i:s') . "',
					'" . date('Y-m-d H:i:s', strtotime($stamp)) . "',
					'1'
					)";
	mysqli_query($conn, $sql);	
	}else{
		$sql = "insert into user_otp_logs(
				user_ip,
				mobile,
				otp,
				otp_date_time,
				otp_expiry_date,
				otp_status
				
				)values(
					'" . $_SERVER['REMOTE_ADDR'] . "',
					'" . $user_mobile . "',
					'" . $otp . "',
					'" . date('Y-m-d H:i:s') . "',
					'" . date('Y-m-d H:i:s', strtotime($stamp)) . "',
					'0'
					)";
	mysqli_query($conn, $sql);	
	}
	
	echo $result;
	exit;
	
} else {
	
    echo "FAIL";
	exit;
	
}

?>
