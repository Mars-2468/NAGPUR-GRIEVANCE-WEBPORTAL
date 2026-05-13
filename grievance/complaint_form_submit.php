<?php
require "config.php";
error_reporting(0);


require_once('connection.php');
$conn = getconnection();
$ulbid = 250;

date_default_timezone_set("Asia/kolkata");

$verify_otp_status = 0;

$verification_status = 0;


//echo $_POST['terminate_otp']; die();

/* TERMINATE OTP REQUEST */
if (isset($_POST['terminate_otp'])) {
    // Clear session variables
    $_SESSION['otpstaus'] = 0;
    unset($_SESSION['mobilesubmit']);
    unset($_SESSION['sel_mobile']);
    unset($_SESSION['com_reg_mobile']);
    unset($_SESSION['login_status']);

    // Redirect back to the same page to refresh properly
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_POST['otp'])) {
    $ulbid = $_REQUEST['id'];

    // ✅ Get ULB details safely
    $stmt = $conn->prepare("SELECT distid, ulbid, ulbname FROM ulbmst WHERE ulbid = ?");
    $stmt->bind_param("s", $ulbid);
    $stmt->execute();
    $rs = $stmt->get_result();
    if ($rs && $row = $rs->fetch_assoc()) {
        $ulbName = $row['ulbname'];
        $distid  = $row['distid'];
    }

    // ✅ Get District details safely
    if (!empty($distid)) {
        $stmt = $conn->prepare("SELECT distid, distname FROM Districtmst WHERE distid = ?");
        $stmt->bind_param("s", $distid);
        $stmt->execute();
        $rs = $stmt->get_result();
        if ($rs && $row = $rs->fetch_assoc()) {
            $distName = $row['distname'];
        }
    }

    // ✅ Validate OTP input
    $otp = trim($_POST['otp']);
    $mobile = isset($_SESSION['sel_mobile']) ? $_SESSION['sel_mobile'] : trim($_POST['mb']);

    // Optional: basic input validation
    if (!preg_match('/^[0-9]{4}$/', $otp)) {
        $message = "Invalid OTP format.";
    } else {
        // ✅ Get OTP details safely
        $stmt = $conn->prepare("
            SELECT otp_expiry_date 
            FROM user_otp_logs 
            WHERE otp = ? AND mobile = ? AND otp_status = 0
        ");
        $stmt->bind_param("ss", $otp, $mobile);
        $stmt->execute();
        $rs = $stmt->get_result();
        $nr = $rs->num_rows;

        $date1 = null;
        if ($nr > 0 && $row = $rs->fetch_assoc()) {
            $date1 = $row['otp_expiry_date'];
        }

        $currentDate = date('Y-m-d H:i:s');
        $expriry_status = 0;
        $verify_otp_status = 1;

        if ($date1 && $date1 > $currentDate) {
            $expriry_status = 1;
            $verify_otp_status = 0;
        } else {
            $otp_err_msg = "Enter Valid OTP";
        }

        // ✅ If OTP is valid and not expired
        if ($nr > 0 && $expriry_status == 1) {

            // Mark OTP as used
            $stmt = $conn->prepare("UPDATE user_otp_logs SET otp_status = 1 WHERE otp = ? AND mobile = ?");
            $stmt->bind_param("ss", $otp, $mobile);
            if ($stmt->execute()) {

                // Update user table safely
                $stmt = $conn->prepare("UPDATE users_test SET otp_status = 2 WHERE user_mobile = ?");
                $stmt->bind_param("s", $mobile);
                $stmt->execute();

                // ✅ Set session and redirect securely
                $_SESSION['com_reg_mobile'] = $mobile;
                $_SESSION['login_status'] = 1;
                $_SESSION['ulbid'] = 250;

                header("Location: web_complaint_form.php?id=" . $_SESSION['ulbid']);
                exit;
            } else {
                echo "Something went wrong. Try again.";
            }
        } else {
            $message = "Invalid OTP or OTP expired.";
            $_SESSION['otpstaus'] = 1;
        }
    }
}

function validate_mobile($mobile)
{
    return preg_match('/^[0-9]{10}+$/', $mobile);
}

if (isset($_POST['mobileno'])) {
    $mobileno = strip_tags(trim($_POST['mobileno']));
    $ulbid    = strip_tags(trim($_POST['ulbid']));

    // Validate mobile number
    if (!preg_match('/^[0-9]{10}$/', $mobileno)) {
        $message = "Invalid Mobile Number";
    } else {
        // Step 1: Prepare the first query
        $stmt = $conn->prepare("SELECT * FROM users_test WHERE user_id = ?");
        $stmt->bind_param("s", $mobileno);
        $stmt->execute();
        $rs = $stmt->get_result();
        $row = $rs->fetch_assoc();

        if ($rs->num_rows > 0 && ($row['otp_status'] == '1' || $row['otp_status'] == '2')) {
			
			$mobilenumber=$row['user_mobile'];
			
            $_SESSION['mobilesubmit'] = 1;
            $_SESSION['sel_mobile'] = $mobileno;
            $_SESSION['ulbid'] = $ulbid;

            // Step 2: Prepared statement for ULB details
            $stmt2 = $conn->prepare("
                SELECT * FROM ulbmst 
                JOIN ulb_type ON ulb_type = ulb_type_id 
                WHERE ulbid = ?
            ");
            $stmt2->bind_param("s", $ulbid);
            $stmt2->execute();
            $ulbrs1 = $stmt2->get_result();
            $ulbName = $ulbrs1->fetch_assoc();

            $uName = $ulbName['ulbname'];
            $datetime = date('Y-m-d H:i:s');
            $otp = rand(1000, 9999);



			$sms = "One Time Password (OTP) for NMC application logging is " . $otp . " Please use this OTP for logging NMCGov. Pls do not share this with any one, Valid for 5 minutes.";
       
             
			$templateId = "1707170780475551415";
			
			
          
		   $result = sendSMS($mobilenumber, $sms, $templateId);

            // Calculate OTP expiry
            $time = new DateTime();
            $time->add(new DateInterval('PT5M'));
            $expiry = $time->format('Y-m-d H:i:s');

            // Step 3: Prepared statement for inserting OTP log
            $stmt3 = $conn->prepare("
                INSERT INTO user_otp_logs (
                    user_ip, mobile, otp, otp_date_time, otp_expiry_date, otp_status
                ) VALUES (?, ?, ?, ?, ?, 0)
            ");
            $ip = $_SERVER['REMOTE_ADDR'];
            $now = date('Y-m-d H:i:s');
            $stmt3->bind_param("sssss", $ip, $mobileno, $otp, $now, $expiry);
            $stmt3->execute();

            $_SESSION['otpstaus'] = 1;

        } else {
            $_SESSION['flash_message'] = "You are not a registered user";
            $indexpage = 'web_register_form.php?id=250&mobile=' . urlencode($mobileno);
            echo "<script>window.location='$indexpage';</script>";
            exit;
        }
    }
}


$conn->close();


?>