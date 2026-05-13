<?php   
require "config.php"; //to ensure you are using same session
session_destroy(); //destroy the session
$_SESSION['login_status']= 0;
// unset()
session_start();
$_SESSION = []; //empty array. 
session_write_close(); 
$indexpage="/grievance/complaint_form.php";
echo "<script>window.location='$indexpage';</script>";
// header("location:".url()); //to redirect back to "index.php" after logging out
exit();
?>