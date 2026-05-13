<?php
require "config.php"; 
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
include('connection.php');
$conn = getconnection();

/*echo $uid=mysqli_real_escape_string($conn,strip_tags($_POST['username']));
echo $pwd=sha1($_POST['fk']);
exit;*/

//echo "<pre>";print_r($_POST);echo "</pre>";die();

$uid = strtolower(mysqli_real_escape_string($conn, strip_tags($_POST['username'])));
$pwd = sha1($_POST['fk']);

$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);
$captcha_code = mysqli_real_escape_string($conn, $_SESSION['captcha_code']);

if($captcha_code!=$captcha){
	$_SESSION['message'] = "Invalid Captcha!";
	echo "<script>window.location.href='index.php';</script>";
	exit;
}

$path = mysqli_real_escape_string($conn, $_POST['login_path']);

$sql1 = "select * from users where user_id=? and user_pwd=PASSWORD(?)";


$query = $conn->prepare($sql1);
$query->bind_param("ss", $uid, $pwd);

$query->execute();
$rs = $query->get_result();
$row = $rs->fetch_assoc();


//echo "<pre>";print_r($_POST['otp']);echo "</pre>";
//echo "<pre>";print_r($row['otp']);echo "</pre>";die();

/* if((($row['user_id']==='nagpur')) && ($row['otp']!=$_POST['otp'])){	
	$_SESSION['message'] = "Invalid OTP";
	echo "<script>window.location.href='index.php';</script>";
	exit;
}
*/

//if(!in_array($row['user_id'],$admin_level_users)){
	/* if(intval($row['otp']) !== intval($_POST['otp'])){	
		$_SESSION['message'] = "Invalid OTP";
		echo "<script>window.location.href='index.php';</script>";
		exit;
	} */
//} 

if (count($row) > 0) {
	
if ($row['is_blocked'] == '1') {
	$_SESSION['message'] = "<div class='alert alert-danger'>Dear $uid , Your login is blocked by admin, Please contact site admin. </div>";
	echo "<script>window.location.href='index.php';</script>";
}

// user login status start *****************************************

$_SESSION['log_id'] = (int)user_login_audits($conn, $row['user_id']);
	
$is_active = 1; // true
$userid = $row['user_id'];

$sql = $conn->prepare("UPDATE users SET is_active=? WHERE user_id=?");
$sql->bind_param("is", $is_active, $userid);

$sql->execute();

// user login status end *******************************************	

if($row['user_type']=='P'){
					
	$sql = $conn->prepare("
		SELECT 
			cu.user_id,
			cu.zone_id,
			cu.ward_id,
			zm.ward_desc,
			wm.street_desc
		FROM corporator_users cu
		LEFT JOIN ward_mst zm ON cu.zone_id = zm.ward_id
		LEFT JOIN street_mst wm ON cu.ward_id = wm.street_id
		WHERE cu.user_id = ?
	");

	$sql->bind_param("s", htmlspecialchars(strip_tags($row['user_id'])));
	$sql->execute();
	$rs = $sql->get_result();
	//echo "<pre>";print_r($rs);echo "</pre>";die();
	$user_data = [];

	while ($rows = $rs->fetch_assoc()) {
		//echo "<pre>";print_r($row);echo "</pre>";
		$user_data['user_id'] = $rows['user_id'];
		$user_data['zone_id'] = $rows['zone_id'];
		$user_data['ward_id'] = $rows['ward_id'];
		$user_data['zone_name'] = $rows['ward_desc'];
		$user_data['ward_name'] = $rows['street_desc'];
	} 

}else{
	$user_data['user_id'] = null;
	$user_data['zone_id'] = null;
	$user_data['ward_id'] = null;
    $user_data['zone_name'] = null;
    $user_data['ward_name'] = null;
}
	//echo "<pre>";print_r($user_data);echo "</pre>";die(); 
		
	
	//setcookie("PHPSESSID", "", time() - 3600);
	//session_regenerate_id(true);
	$sessid = md5(rand(0, 10000));
/* 	setcookie(
		"PHPSESSID",
		session_id(),
		time() + (60 * 60 * 24 * 10),
		NULL,
		NULL,
		NULL,
		TRUE  // this is the httpOnly flag you need to set
	); */

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
	$_SESSION['ward_id'] = $user_data['ward_id'];
	$_SESSION['zone_id'] = $user_data['zone_id'];
	$_SESSION['zone_name'] = $user_data['zone_name'];
	$_SESSION['ward_name'] = $user_data['ward_name'];
	$_SESSION['user_id'] = $row['user_id'];
	$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	$_SESSION['uid'] = $uid;
	$username = $row['user_name'];
	$_SESSION['user_name'] = $row['user_name'];
	$_SESSION['showcause_id'] = $showcause_id;
	$_SESSION['warning_id'] = $warning_id;
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
	//$_SESSION['last_activity'] =  time();
	
	
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
	$sql = "update users set login_status='1' where user_id='" . mysqli_real_escape_string($conn, $uid) . "'";
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
	if ($_SESSION['user_type'] == 'E' || $_SESSION['user_type'] == 'U' || $_SESSION['user_type'] == 'A') {
		header('Location:ajax_dashboard.php');
		exit;
	}
	if ($_SESSION['user_type'] == 'P' ) {
		header('Location:ajax_corp_dashboard.php');
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

	/*}
		// captcha end above
		}
		else
		{
		    
		   
			
		echo "<script>alert('Invalid Captcha Code');window.location.href='index.php';</script>";
			
		
		}*/
		
		
		
} else {

	$_SESSION['message'] = "Invalid credentials";

	echo "<script>window.location.href='index.php';</script>";
}

$conn->close();
