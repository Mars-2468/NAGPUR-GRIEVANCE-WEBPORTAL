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
	include('user_defined_functions.php');
	include('prepare_connection.php');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');
	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);

	$captcha = $_POST['captcha'];
	$code = $_SESSION['code'];

	if (isset($_POST['save'])) {

		if(!validateField($_POST['dept_desc'], 'text')['valid'] || !validateField($_POST['dept_marathi'], 'text')['valid']){
			$tpl->assign('class', 'alert alert-danger display-hide');
			$msg = "Enter Valid Department Description..!";
			$tpl->assign('msg', $msg);
			header("Location: manage_dept.php");
			exit;
		}else{

			if (!empty($_POST['csrf_token'])) {

				if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {

					$dept_description = $_POST['dept_desc']; // preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_desc']);
					$dept_marathi_description = $_POST['dept_marathi']; // $_POST['dept_marathi'];

					if (!empty($dept_description) && !empty($dept_marathi_description)) {

						if ($_POST['dept_id'] == '0') {

							$sql = "insert into dept_mst(dept_desc,dept_marathi,ulbid) values(?,?,?)";
							$query = $conn->prepare($sql);
							$query->bind_param("sss", $dept_description, $dept_marathi_description, $_SESSION['ulbid']);
						} else {

							$sql = "update dept_mst set dept_desc=?,dept_marathi=? where dept_id=?";
							$query = $conn->prepare($sql);
							$query->bind_param("ssi", $dept_description, $dept_marathi_description, $_POST['dept_id']);
						}
						if ($query->execute()) {
							$tpl->assign('class', 'alert alert-success display-hide');
							$msg = "The Record Successfully Saved..!";
						} else {
							$tpl->assign('msg', 'alert alert-danger display-hide');
							$msg = "Uable to save   " . $query->error;
						}
						$query->close();
					} else {
						$tpl->assign('class', 'alert alert-danger display-hide');
						$msg = "Enter Valid Ward Description..!";
					}
					
					$tpl->assign('msg', $msg);
					
				} else {
					
					$tpl->assign('class', 'alert alert-danger display-hide');
					$msg = 'Invalid Token..!';
					
				}
				
			} else {
				
				$tpl->assign('class', 'alert alert-danger display-hide');
				$msg = 'Something Went Wrong..!';
				
			}
		
		}
		//$tpl->assign('class', 'alert alert-danger display-hide');
	$tpl->assign('msg', $msg);
	header("Location: manage_dept.php");
	exit;	
	}
	


} else {
	echo "<script>window.location='index.php';</script>";
}

