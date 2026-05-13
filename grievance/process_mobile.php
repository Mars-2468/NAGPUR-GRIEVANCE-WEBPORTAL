<?php
session_start();
require_once('connection.php');
$conn = getconnection();


/* if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	
    $mobileno = trim($_POST['mobileno']);
    $ulbid = trim($_POST['ulbid']);

    if (!preg_match('/^\d{10}$/', $mobileno)) {
        $_SESSION['flash_message'] = 'Invalid mobile number.';
        header('Location: complaint_form.php');
        exit;
    }
	
	$_SESSION['mobilesubmit'] = 1;

    $stmt = $conn->prepare("SELECT user_mobile, otp_status FROM users_test WHERE user_id = ?");
    $stmt->bind_param("s", $mobileno);
    $stmt->execute();
    $rs = $stmt->get_result();
    $row = $rs->fetch_assoc();
	
	$user_mobile=$row['user_mobile'];

    if ($rs->num_rows > 0 && in_array($row['otp_status'], ['1', '2'])) {
        $otp = rand(1000, 9999);
        $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        $stmt = $conn->prepare("INSERT INTO users_test (user_ip, mobile, otp, otp_date_time, otp_expiry_date, otp_status)
                                VALUES (?, ?, ?, NOW(), ?, 0)");
        $ip = $_SERVER['REMOTE_ADDR'];
        $stmt->bind_param("ssss", $ip, $user_mobile, $otp, $expiry);
        $stmt->execute();

        $_SESSION['sel_mobile'] = $user_mobile;
        $_SESSION['ulbid'] = $ulbid;
        $_SESSION['otpstaus'] = 1;
        $_SESSION['flash_message'] = "OTP sent to $user_mobile.";

        $sms = "One Time Password (OTP) for NMC application logging is " . $otp . " Please use this OTP for logging NMCGov. Pls do not share this with any one, Valid for 5 minutes.";
                    
		$templateId = "1707170780475551415";
		          
		$result = sendSMS($user_mobile, $sms, $templateId);

    } else {
        $_SESSION['flash_message'] = "Not a registered user.";
    }

    header('Location: complaint_form.php');
    exit;
} */
	

if (isset($_POST['mobileno'])) {
	
	
    
	$ulbid = '250';//$_POST['ulbid'];
    	
	$mobileno = $_POST['mobileno'] ?? '';	
	
	$mobileno = strip_tags(trim($_POST['mobileno']));
	
	
	
	
	
	if (preg_match('/\D/', $mobileno)) {
		$_SESSION['flash_error_message'] = "Mobile number should contain only digits.";
		header("Location: complaint_form.php");
		exit;
	}	
	
	if (strlen($mobileno)>10 || strlen($mobileno)<10) {
		$_SESSION['flash_error_message'] = "Mobile number must be exactly 10 digits.";
		header("Location: complaint_form.php");
		exit;
	}
	
	if (has_sql_injection($mobileno)) {
		error_log("SQL Injection attempt detected: $mobileno");
		$_SESSION['flash_error_message'] = "Invalid input detected.";
		header("Location: complaint_form.php");
		exit;
	}
			
	$mobilecheck = validate_mobile($mobileno);

    ///////CHECKING USER REGISTERED OR NOT////////////
    $sql = "select * from users_test where user_id='" .  $mobileno . "' ";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($rs);	
	
    if (mysqli_num_rows($rs) > 0 && ($row['otp_status'] == '1' || $row['otp_status'] == '2')) {
	
	//$user_mobile=$row['user_mobile'];
	
	
	$user_mobile=!empty($row['user_mobile'])?$row['user_mobile']:$row['user_id'];
	

        $_SESSION['mobilesubmit'] = 1;

      
     
        if ($mobilecheck) {
            $_SESSION['sel_mobile'] = $user_mobile;
            $_SESSION['ulbid'] = $ulbid;

            $ulbsql = "select * from ulbmst JOIN ulb_type ON ulb_type=ulb_type_id where ulbid='" . $ulbid . "'";
            $ulbrs1 = mysqli_query($conn, $ulbsql);

            $ulbName = mysqli_fetch_assoc($ulbrs1);

            $uName = $ulbName['ulbname'];
            $datetime = date('Y-m-d H:i:s');
            $otp = rand(1000, 9999);
			
			$sms = "One Time Password (OTP) for NMC application logging is " . $otp . " Please use this OTP for logging NMCGov. Pls do not share this with any one, Valid for 5 minutes.";
       
			$templateId = "1707170780475551415";
		
            //$sms = "Dear ".substr($emp_name_list[$row1['emp_id']], 0, 28).", A Grievance from ".mysqli_real_escape_string($conn,strip_tags(substr($_POST['person_name'], 0, 28))).", Mobile No. ".mysqli_real_escape_string($conn,strip_tags($_POST['mobile'])).", ".substr($complaintType, 0, 28)." with Ref No ".$grievance_id."is allotted to you on ".date('d-m-Y H:i:s')." https://egovmars.in/csms/ Regards- CitizenServiceMonitoringCell ,NMCGOV";
           
            $result = sendSMS($user_mobile,$sms,$templateId);
			
            // print_r($result); exit;
            $minutes_to_add = 5;

            $time = new DateTime();
            $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

            $stamp = $time->format('Y-m-d H:i');
            $otpExpiryDate = strtotime("date('Y-m-d H:i:s') + 5 minute");

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

            $_SESSION['otpstaus'] = 1;
            header('Location: complaint_form.php');
			exit;
        } else {
						
			$_SESSION['flash_error_message'] = "Invalid Mobile no";           
			header('Location: complaint_form.php');
			exit;
        }
    } else {
        $_SESSION['flash_error_message'] = "Your not a registered user";
        
        $indexpage = 'web_register_form.php?id=250&mobile=' . $_POST['mobileno'];
        echo "<script>window.location='$indexpage';</script>";
    }
}

function validate_mobile($mobile)
{
    return preg_match('/^[0-9]{10}+$/', $mobile);
}


function has_sql_injection($input) {
	
	
	 // Decode URL-encoded characters (like %27)
    $value = urldecode(strtolower($input));

    // Block SQL keywords and special chars
    $patterns = [
        "/(\%27)|(\')|(\-\-)|(\%23)|(#)/i",                // quotes & comments
        "/\b(select|insert|update|delete|drop|union|sleep|benchmark|or|and)\b/i", // SQL keywords
        "/(\*|;|=|\(|\))/i"                                // suspicious symbols
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $value)) {
            return true;
        }
    }
    return false;
	
	
	
	
   /*  // Normalize to lowercase for matching
    $str = strtolower(urldecode($input));

    // Common SQLi indicators
    $patterns = [
        "/(\%27)|(\')|(\-\-)|(\%23)|(#)/i",     // quotes, comments
        "/\b(union|select|insert|update|delete|drop|sleep|benchmark|or|and)\b/i", // SQL keywords
        "/(\*|;|=|\(|\))/i"                     // SQL symbols
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $str)) {
            return true; // suspicious
        }
    }
    return false; */
}

?>
