<?php
session_start();
require_once('connection.php');
$conn = getconnection();


  // Clear session variables
    $_SESSION['otpstaus'] = 0;
    unset($_SESSION['mobilesubmit']);
    unset($_SESSION['sel_mobile']);
    unset($_SESSION['com_reg_mobile']);
    unset($_SESSION['login_status']);

    // Redirect back to the same page to refresh properly
	$_SESSION['flash_error_message'] = "Terminated OTP.";
	header('Location: complaint_form.php');
    exit();

?>
