<?php
session_start();
  date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
include('connection.php');
$conn = getconnection();

/*echo $uid=mysqli_real_escape_string($conn,strip_tags($_POST['username']));
echo $pwd=sha1($_POST['fk']);
exit;*/

$uid = mysqli_real_escape_string($conn, strip_tags($_POST['username']));
$pwd = sha1($_POST['fk']);

$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);
$code = mysqli_real_escape_string($conn, $_SESSION['code']);

$path = mysqli_real_escape_string($conn, $_POST['login_path']);
$sql1 = "select * from users where user_id=? and user_pwd=PASSWORD(?)";


$query = $conn->prepare($sql1);
$query->bind_param("ss", $uid, $pwd);

$query->execute();
$rs = $query->get_result();
$row = $rs->fetch_assoc();
//echo"<pre>";print_r($row);echo"</pre>";die();


if (count($row) > 0) {
	if ($row['is_blocked'] == '1') {
		$_SESSION['message'] = "<div class='alert alert-danger'>Dear $uid , Your login is blocked by admin, Please contact site admin. </div>";
		echo "<script>window.location.href='index.php';</script>";
	}
	
	// audit logs
	
	log_audit_trail($conn,$user_id=$row['user_id'], $action='login', $details='User logged in',$model='users',$record_id=$row['user_id'],$old='logout',$new='login');
		
	
 	setcookie("PHPSESSID", "", time() - 3600);
	session_regenerate_id(true);
	$sessid = md5(rand(0, 10000));
	setcookie(
		"PHPSESSID",
		session_id(),
		time() + (60 * 60 * 24 * 10),
		NULL,
		NULL,
		NULL,
		TRUE  // this is the httpOnly flag you need to set
	); 


/* setcookie(
    "user_session",   // Name
    "unique_session_id", // Value
    time() + 3600,    // Expiry (1 hour)
    "/",              // Path
    "example.com",    // Domain
    true,             // Secure (only over HTTPS)
    true,             // HttpOnly (can't be accessed by JavaScript)
    "Strict"          // SameSite (only for same-site requests)
);
 */

	//session_regenerate_id(true);

	if ($row['user_type'] == 'E') {
		$sql = "SELECT * FROM `emp_mst_od` WHERE emp_mobile like '" . $uid . "'";
		$rs2 = mysqli_query($conn, $sql);
		while ($row2 = mysqli_fetch_assoc($rs2)) {
			$emp_list[$row2['emp_id']] = $row2['emp_id'];
		}
	}

	$emp_list[$row['emp_id']] = $row['emp_id'];

	if ($row['user_type'] == 'E') {
		$sql = "SELECT COUNT(DISTINCT showcause_id) as showcause_id FROM show_case_emp_count Where emp_id = '" . $row['emp_id'] . "'";
		/*$rs2 = mysqli_query($conn, $sql);
		while ($row2 = mysqli_fetch_assoc($rs2)) {
			$showcause_id = $row2['showcause_id'];
		}*/
	}else{
		$sql = "SELECT COUNT(DISTINCT showcause_id) as showcause_id FROM show_case_emp_count";
	}
	$rs2 = mysqli_query($conn, $sql);
	while ($row2 = mysqli_fetch_assoc($rs2)) {
		$showcause_id = $row2['showcause_id'];
	}

	if ($row['user_type'] == 'E') {
		$sql = "SELECT COUNT(DISTINCT warning_id) as warning_id FROM show_case_response_logs Where emp_id = '" . $row['emp_id'] . "'";
		/*$rs2 = mysqli_query($conn, $sql);
		while ($row2 = mysqli_fetch_assoc($rs2)) {
			$warning_id = $row2['warning_id'];
		}*/
	}else{
		$sql = "SELECT COUNT(DISTINCT warning_id) as warning_id FROM show_case_response_logs";
	}
	$rs2 = mysqli_query($conn, $sql);
	while ($row2 = mysqli_fetch_assoc($rs2)) {
		$warning_id = $row2['warning_id'];
	}

	$ipAddress = $_SERVER['REMOTE_ADDR'];
	$_SESSION['user_id'] = $row['user_id'];
	$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	$_SESSION['uid'] = $uid;
	$username = $row['user_name'];
	$_SESSION['user_name'] = $row['user_name'];
	//$_SESSION['showcause_id'] = $showcause_id;
	//$_SESSION['warning_id'] = $warning_id;
	$_SESSION['ulbid'] = $row['ulbid'];
	$_SESSION['user_type'] = $row['user_type'];
	$_SESSION['sec_level'] = $row['sec_level'];
	$_SESSION['emp_id'] = $row['emp_id'];
	$_SESSION['emp_list'] = $emp_list;
	$_SESSION['mc_yn'] = $row['mc_yn'];
	$_SESSION['geotagging_status'] = $row['geotagging_status'];
	$_SESSION['ulb'] = $row['ulbid'];
	$_SESSION['update_previlize'] = $row['update_previlize'];
	$_SESSION['session_id'] = session_id();
	$_SESSION['is_mergedulbs'] = 0;
	
	
	if ($_SESSION['uid'] == 'CDMA' || $_SESSION['uid'] == 'superadmin' || $_SESSION['uid'] == 'mepma') {
		$sql2 = "select banner , logo_url from users where user_id =?";
		$user_id = $_SESSION['uid'];
		$query = $conn->prepare($sql2);
		$query->bind_param("s", $user_id);
	} elseif ($_SESSION['uid'] == 'hrms') {
		$sql2 = "select banner , logo_url from users where user_id =?";
		$user_id = $_SESSION['uid'];
		$query = $conn->prepare($sql2);
		$query->bind_param("s", $user_id);
	} else {
		$sql2 = "select banner , logo_url from users where ulbid=?";
		$ulbid = $row['ulbid'];
		$query = $conn->prepare($sql2);
		$query->bind_param("s", $ulbid);
	}

	$query->execute();
	$rs2 = $query->get_result();
	$row2 = $rs2->fetch_assoc();

	$_SESSION['banner'] = $row2['banner'];
	$_SESSION['logo'] = $row2['logo_url'];

	if ($_SESSION['user_type'] == 'C' || $_SESSION['user_type'] == 'CS' || $_SESSION['user_type'] == 'AG') {
		$_SESSION['banner'] = "http://municipalservices.in/images/cdma-banner.png";
	}
		
	$sql = "select * from session_users where user_id=?";
	
	$query = $conn->prepare($sql);
	$query->bind_param("s", $user_id);
	$query->execute();
	$rs = $query->get_result();
	$rows = $rs->fetch_assoc();
	//echo "<pre>";print_r($rows);echo "</pre>";die();	
	
/* 	if($rs->num_rows){   //$rs->num_rows<3
		
		$sql = "insert into session_users(user_id,ip_address,session_id,created_by,created_at) values(?,?,?,?,?) ";
		
		$user_id = $row['user_id'];
		$session_id = $_SESSION['session_id'];
		$created_by = $row['user_id'];
		$created_at = date('Y-m-d h:m:s');
		//echo "<pre>";print_r($created_by);echo "</pre>";die();
		$query = $conn->prepare($sql);
		$query->bind_param("sssss", $user_id,$ipAddress, $session_id, $created_by, $created_at);
		$query->execute();
		
	}else{	
	//die('ssss');
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
   			 $links = "https";
		else
     		$links = "http";     

			$links .= "://";     

			$links .= $_SERVER['HTTP_HOST'];
		
			log_audit_trail($conn,$user_id, $action='logout', $details='User login exceeded- logged out',$model='users',$record_id=$user_id,$old='login',$new='Manual logout');
						
		//echo "<script>window.location.href='index.php?msg=Login limit exceeded. Please log out from another device.';</script>";
		header("Location:" . $links . "/index.php?msg=Login limit exceeded. Please log out from another device.");
	   exit();
	} */
	
	$sql = "update users set login_status='1', session_id='".$_SESSION['session_id']."' where user_id='" . mysqli_real_escape_string($conn, $uid) . "'";
	$user_id = mysqli_real_escape_string($conn, $uid);
	$query = $conn->prepare($sql);
	$query->bind_param("s", $user_id);
	$query->execute();	

	$sql = "insert into login_details(ip,ulbid,user_id,type,login_throug_type)values(?,?,?,?,?)";
	$ipaddress = mysqli_real_escape_string($conn, $ipAddress);
	$ulbid = mysqli_real_escape_string($conn, $row['ulbid']);
	$uid = mysqli_real_escape_string($conn, $uid);
	$type = 1;
	$login_type = 1;
	$query = $conn->prepare($sql);
	$query->bind_param("sssii", $ipaddress, $ulbid, $uid, $type, $login_type);
	$query->execute();
	$sql = "select access_key from ulbmst where ulbid=?";
	$query = $conn->prepare($sql);
	$query->bind_param("s", $_SESSION['ulbid']);
	$query->execute();

	$rs = $query->get_result();
	$row = $rs->fetch_assoc();
	$_SESSION['access_key'] = $row['access_key'];
	if ($_SESSION['uid'] == 'hrms') {
		header('Location:mergeDepartments.php');
		exit;
	}
	if ($_SESSION['user_type'] == 'E' || $_SESSION['user_type'] == 'U' || $_SESSION['user_type'] == 'A' && $_SESSION['session_id']==$row['session_id']) {
		header('Location:ajax_dashboard.php');
		exit;
	}

	if ($_SESSION['uid'] == 'Boduppal') {
		echo "<script>window.location.href='ajax_dashboard.php';</script>";
	} else {
		if ($_SESSION['uid'] == 'mepma') {
			echo "<script>window.location.href='ajax_dashboard.php';</script>";
		}
		echo "<script>window.location.href='ajax_dashboard.php';</script>";
	}
	
} else {

	$_SESSION['message'] = "Invalid credentials";

	echo "<script>window.location.href='index.php';</script>";
}

$conn->close();
