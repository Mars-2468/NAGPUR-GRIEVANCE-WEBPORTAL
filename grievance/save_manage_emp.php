<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();


if (isset($_SESSION['uid'])) {


	//session_regenerate_id();
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

	function generateRandomString($length)
	{
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}


	//$captcha = $_POST['captcha'];
	//$code = $_POST['code'];



	if (isset($_POST['save'])) {
		
		//echo "<pre>";print_r($_POST);echo "</pre>";die();

		if(!validateField($_POST['emp_name'], 'text')['valid'] || !validateField($_POST['emp_name_marathi'], 'text')['valid'] || !validateField($_POST['emp_code'], 'dnumber')['valid'] || !validateField($_POST['emp_mobile'], 'mobile')['valid']){
			$_SESSION['msg']  = "Enter Valid complaint description or level1/level2/level3..!";
			$_SESSION['class'] = "alert alert-danger display-hide";

			header("Location: manage_emp.php");
			exit;
		}else{

			if (!empty($_POST['csrf_token'])) {

				

					if ($_POST['od'] == 1) {
						$length = 10;

						$emp_id = generateRandomString($length);

						$sql = "insert into emp_mst_od(emp_id,emp_code,emp_name,emp_name_marathi,emp_dept,emp_desg,emp_mobile,ulbid,od_status) values('" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', '', $emp_id))) . "','" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_code']))) . "','" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_name']))) . "','" . mysqli_real_escape_string($conn, strip_tags($_POST['emp_name_marathi'])) . "'," . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_dept']))) . "," . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_desg']))) . ",'" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_mobile']))) . "','" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "','1')";
						if (mysqli_query($conn, $sql)) {
							if ($_POST['emp_id'] == '0') {
								$emp_id = mysqli_insert_id($conn);
							} else {
								$emp_id = $_POST['emp_id'];
							}

							for ($i = 0; $i <= $_POST['cnt']; $i++) {
								$dept_id = "dept_id" . $i;
								$desg_id = 'desg_id' . $i;
								if ($_POST[$dept_id] != 0) {
									$sql = "insert into emp_desg_map(emp_id,dept_id,desg_id,flag)values('" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $emp_id))) . "','" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST[$dept_id]))) . "','" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST[$desg_id]))) . "','1')ON DUPLICATE KEY UPDATE flag='1'";
									mysqli_query($conn, $sql);
								}
							}
						
							$msg = "Successfully Added Details..!";
							$_SESSION['msg']  = $msg;
							$_SESSION['class'] = "alert alert-success display-hide";

							header('Location: manage_emp.php');
							exit;
						}
					} else {

						if ($_POST['emp_id'] == '0') {
							$sql = "insert into emp_mst(emp_code,emp_name,emp_name_marathi,emp_dept,emp_desg,emp_mobile,ulbid) values('" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_code']))) . "','" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_name']))) . "','" . mysqli_real_escape_string($conn, strip_tags($_POST['emp_name_marathi'])) . "'," . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_dept']))) . "," . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_desg']))) . ",'" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_mobile']))) . "','" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "')";
						} else {
							$sql = "update emp_mst set emp_code='" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_code']))) . "',emp_name='" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_name']))) . "',emp_name_marathi=,'" . mysqli_real_escape_string($conn, strip_tags($_POST['emp_name_marathi'])) . "',emp_dept=" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_dept']))) . ",emp_desg=" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_desg']))) . ",emp_mobile='" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_mobile']))) . "' where emp_id=" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['emp_id'])));
						}

						//echo $sql;

						if (mysqli_query($conn, $sql)) {
							if ($_POST['emp_id'] == '0') {
								$emp_id = mysqli_insert_id($conn);
							} else {
								$emp_id = $_POST['emp_id'];
							}

							for ($i = 0; $i <= $_POST['cnt']; $i++) {
								$dept_id = "dept_id" . $i;
								$desg_id = 'desg_id' . $i;
								if ($_POST[$dept_id] != 0) {
									$sql = "insert into emp_desg_map(emp_id,dept_id,desg_id,flag)values('" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $emp_id))) . "','" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST[$dept_id]))) . "','" . mysqli_real_escape_string($conn, strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST[$desg_id]))) . "','1')ON DUPLICATE KEY UPDATE flag='1'";
									mysqli_query($conn, $sql);
								}
							}


							$tpl->assign('class', 'alert alert-success display-hide');
							$msg = "Successfully Added Details..!";
						} else {
							$tpl->assign('msg', 'alert alert-danger display-hide');
							$msg = "Check Your Mobile Number, Already Existed..!";
						}
					}
			$_SESSION['msg']  = $msg;
			$_SESSION['class'] = "alert alert-success display-hide";

			header('Location: manage_emp.php');
			exit;	
				
			} else {
				
				$msg = 'Something Went Wrong';
				$_SESSION['msg']  = $msg;
				$_SESSION['class'] = "alert alert-danger display-hide";

				header('Location: manage_emp.php');
				exit;
			}
			
		}
		

	}

} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
?>