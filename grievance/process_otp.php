<?php
session_start();
require_once('connection.php');
$conn = getconnection();

$verify_otp_status = 0;

$verification_status = 0;
if (isset($_POST['otp'])) {

    $ulbid = '250';//$_REQUEST['id'];
    $sql = $conn->prepare("select distid,ulbid,ulbname from ulbmst where ulbid=?");
    $sql->bind_param("s", $ulbid);
    $sql->execute();
    $rs = $sql->get_result();
		
    if ($rs) {

        while ($row = $rs->fetch_assoc()) {
            $ulbName = $row['ulbname'];
            $distid  = $row['distid'];
        }
    }
	
//echo $distid;exit;
    $sql = $conn->prepare("select distid,distname from Districtmst where distid=?");
    $sql->bind_param("s", $distid);
    $sql->execute();
    $rs = $sql->get_result();
    if ($rs) {
        while ($row = $rs->fetch_assoc())
            $distName  = $row['distname'];
    }

    $otp = strip_tags(trim($_POST['otp']));
    $mobile = (isset($_SESSION['sel_mobile'])) ? $_SESSION['sel_mobile'] : $_POST['mb'];
    $sql = "select * from user_otp_logs where otp='" . $otp . "' and mobile='" . $mobile . "' and otp_status=0";
    $rs = mysqli_query($conn, $sql);
    $nr = mysqli_num_rows($rs);

    $rs = mysqli_query($conn, $sql);
    $nr = mysqli_num_rows($rs);
    while ($row = mysqli_fetch_assoc($rs)) {
        //   print_r($row); exit();
        $date1 = $row['otp_expiry_date'];
    }
    $currentDate = date('Y-m-d H:i:s');
    $currentDate = date('Y-m-d H:i:s', strtotime($currentDate));

    if ($date1 > $currentDate) {
        // echo "Active";
        $expriry_status = 1;
        $verify_otp_status = 0;
    } else {
        // echo "Expired";
        $expriry_status = 0;
        $otp_err_msg = "Enter Valid OTP";
        $verify_otp_status = 1;
    }

//echo $expriry_status;exit;

    if ($nr > 0 && $expriry_status == 1) {
        $sql = "update user_otp_logs set otp_status=1 where otp='" . $otp . "' and mobile='" . $mobile . "'";
        if (mysqli_query($conn, $sql)) {
            $sql = "update users_test set otp_status=2 where user_mobile='" . $mobile . "'";
            $rs = mysqli_query($conn, $sql);
            $_SESSION['com_reg_mobile'] = $mobile;
            $_SESSION['login_status'] = 1;
            $_SESSION['ulbid'] = 250;
			
           // $url = "web_complaint_form.php?id=" . $_SESSION['ulbid'];
            $verification_status = 1;
           // echo "<script>window.location='" . $url . "';</script>";
			header("Location: web_complaint_form.php?id=" . $_SESSION['ulbid']);
			exit;
        } else {
			$_SESSION['flash_error_message'] = "Something went wrong . Try again!";
			header('Location: complaint_form.php');
			exit;
        }
    } else {
        $message = "Invalid OTP";
        $_SESSION['otpstaus'] = 1;
        $_SESSION['flash_error_message'] = "Invalid OTP!";
		header('Location: complaint_form.php');
		exit;
    }
}

$_SESSION['flash_error_message'] = "Invalid or expired OTP.";
header('Location: complaint_form.php');
exit;
?>
