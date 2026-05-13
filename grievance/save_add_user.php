<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();


require_once('send_sms.php');
require_once('sms_conf.php');


if (isset($_SESSION['uid'])) {
	
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');
	include('user_defined_functions.php');
	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);

	if (isset($_POST['save'])) {

		//echo "<pre>";print_r($_POST);echo "</pre>";die();
			
		if(!validateField($_POST['password'], 'password')['valid'] || !validateField($_POST['confirm_password'], 'password',$_POST['password'])['valid']){
		//die('if');
			$msg  = "Enter valid password/confirm_password..!";
			$class = "alert alert-danger display-hide";
			set_flash($msg,$class);
			header('Location: add_user.php');
			exit;
		}else{
			//die('else');
			//$_POST['user_pwd1']=$_POST['password'];
			//$_POST['user_pwd2']=$_POST['confirm_password'];
			
			//echo "<pre>";print_r($_POST);echo "</pre>";die();
			
			
	/* 		$sql = "insert into users(user_id,emp_id,user_pwd,user_name,user_mobile,ulbid,user_type,user_delete_status)
				  values('" . mysqli_real_escape_string($conn, trim($_POST['user_id'])) . "','" . mysqli_real_escape_string($conn, strip_tags($_POST['emp_id'])) . "',PASSWORD('" . mysqli_real_escape_string($conn, trim(sha1(md5($_POST['user_pwd1'])))) . "'),'" . mysqli_real_escape_string($conn, strip_tags($_POST['user_name'])) . "','" . mysqli_real_escape_string($conn, strip_tags($_POST['user_mobile'])) . "','" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "','E',0) 
				  ON DUPLICATE KEY UPDATE user_pwd=PASSWORD('" . mysqli_real_escape_string($conn, sha1(md5($_POST['user_pwd1']))) . "'),user_name='" . mysqli_real_escape_string($conn, strip_tags($_POST['user_name'])) . "',user_mobile='" . mysqli_real_escape_string($conn, strip_tags($_POST['user_mobile'])) . "',emp_id='" . mysqli_real_escape_string($conn, strip_tags($_POST['emp_id'])) . "'";
			$insert_id = mysqli_query($conn, $sql); */
			// print_r($insert_id);die;
			
			
			// Collect and sanitize input
$user_id     = trim($_POST['user_id']);
$emp_id      = strip_tags($_POST['emp_id']);
$user_pwd    = sha1(md5($_POST['password'])); // as in your original code
$user_name   = strip_tags($_POST['user_name']);
$user_mobile = strip_tags($_POST['user_mobile']);
$ulbid       = strip_tags($_SESSION['ulbid']);


//echo "<pre>";print_r($_SESSION['ulbid']);echo "</pre>";die();


// Prepare the SQL statement with placeholders
$sql = "INSERT INTO users 
        (user_id, emp_id, user_pwd, user_name, user_mobile, ulbid, user_type, user_delete_status)
        VALUES (?, ?, PASSWORD(?), ?, ?, ?, 'E', 0)
        ON DUPLICATE KEY UPDATE 
            user_pwd = PASSWORD(?),
            user_name = ?,
            user_mobile = ?,
            emp_id = ?";

// Initialize prepared statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param(
    "ssssssssss", 
    $user_id, $emp_id, $user_pwd, $user_name, $user_mobile, $ulbid,
    $user_pwd, $user_name, $user_mobile, $emp_id
);

			
			
			
			if ($stmt->execute()) {
				$insert_id = $stmt->insert_id; 
				$service_array = array('change_pwd', 'complaints_sla', 'employee_escalated_complaints', 'manage_comp', 'reports', 'rep_comp_dept_abs_comp', 'ward_wise_abstract');
				foreach ($service_array as $val) {
					// Assuming your table name is 'services'
					$sql = "INSERT INTO users_services (user_id,service_id,`status`) VALUES ('$user_id','$val','1')";
					mysqli_query($conn, $sql);
				}


				$sql = "select e.emp_id,e.emp_name,e.emp_mobile,u.ulbname from emp_mst e, ulbmst u where e.ulbid=u.ulbid and e.emp_id='" . strip_tags($_POST['emp_id']) . "'";
				$rs = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($rs);

				$emp_name = $row['emp_name'];
				$emp_mobile = $row['emp_mobile'];
				$ulbname = $row['ulbname'];

				$sms = "Dear " . $emp_name . " Account is created in you on Citizen Servie Monitoring System https://aurangabadmahapalika.org/csms/, your Username is " . mysqli_real_escape_string($conn, strip_tags($_POST['user_id'])) . " and password is " . $_POST['user_pwd1'] . " -Grievance Monitoring Cell," . $ulbname;


				$templateId = "1207161725833582877";
				send_sms($sms, $emp_mobile, $templateId);

				$class='alert alert-success display-hide';
				$msg= 'Successfully Added User..!';
			} else {
				$class = 'alert alert-danger display-hide';
				$msg= 'Unable to Process, Please try again..!';
			}
			
		// Close statement
$stmt->close();	
			
		set_flash($msg,$class);
		header('Location: add_user.php');
		exit;
		}
	}

} else {
	$msg = "You have not logged in, Please Login..!";
	$tpl->assign('msg', $msg);
	$tpl->display('user_login.tpl');
}
