<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {
	$tpl->assign('msg', $_SESSION['msg']);
	echo $_SESSION['msg'];

	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	include('prepare_connection.php');
	$conn = getconnection();
	include('user_defined_functions.php');
	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);

	$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);
	$code = mysqli_real_escape_string($conn, $_SESSION['code']);


	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');


	/*17-07-2024 old Code if (isset($_POST['save'])) {*/

		/*if($captcha == $code)
		    {*/
		/*17-07-2024 old Code if (!empty($_POST['csrf_token'])) {

			if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {


				$emp_id = preg_replace('/[^0-9]+$/', ' ', $_POST['emp_id']);
				$ward_id = preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']);


				if (!empty($emp_id) && !empty($ward_id)) {


					$sql = "insert into ward_comm_map(emp_id,ward_id) values(?,?)";
					$query = $conn->prepare($sql);
					$query->bind_param("ii", $emp_id, $ward_id);




					if ($query->execute()) {

						//$sql1 = "update emp_mst set emp_dept=? where emp_desg=?";
						//$query1 = $conn->prepare($sql1);
						//$query1->bind_param("ss", $ward_id, $_POST['desg_id']);
						//if ($query1->execute()) {
						$tpl->assign('class', 'alert alert-success display-hide');
						$msg = "Zone Mapped Successfully..!";
						//}

						// 	$tpl->assign('class','alert alert-success display-hide');
						// $msg="Successfully Updated  Details";
					} else {
						$tpl->assign('msg', 'alert alert-danger display-hide');
						$msg = "Uable to save   " . $query->error;
					}
					$query->close();
				} else {
					$tpl->assign('class', 'alert alert-danger display-hide');
					$msg = "Please Select Employee..!";
				}

				$tpl->assign('msg', $msg);
			} else {
				$tpl->assign('msg', 'Invalid token..!');
			}
		} else {
			$tpl->assign('msg', 'Something went wrong..!');
		}

		/*}

				else
                	{
                	   
                	    $msg="Invalid Captcha Code";
                		$tpl->assign('msg',$msg);
                		
                	}*/
	/*17-07-2024 old Code }*/

	if (isset($_POST['save'])) {

		if (!empty($_POST['csrf_token'])) {
	
			if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {
	
				$emp_id = preg_replace('/[^0-9]+$/', ' ', $_POST['emp_id']);
				$ward_id = preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']);
	
				if (!empty($emp_id) && !empty($ward_id)) {
	
					// Check if the record already exists
					$sql_check = "SELECT COUNT(*) FROM ward_comm_map WHERE emp_id = ? AND ward_id = ?";
					$query_check = $conn->prepare($sql_check);
					$query_check->bind_param("ii", $emp_id, $ward_id);
					$query_check->execute();
					$query_check->bind_result($count);
					$query_check->fetch();
					$query_check->close();
	
					if ($count == 0) {
						// Insert the new record
						$sql = "INSERT INTO ward_comm_map(emp_id, ward_id) VALUES(?, ?)";
						$query = $conn->prepare($sql);
						$query->bind_param("ii", $emp_id, $ward_id);
	
						if ($query->execute()) {
							$tpl->assign('class', 'alert alert-success display-hide');
							$msg = "Zone Mapped Successfully..!";
						} else {
							$tpl->assign('msg', 'alert alert-danger display-hide');
							$msg = "Unable to save: " . $query->error;
						}
						$query->close();
					} else {
						$tpl->assign('class', 'alert alert-danger display-hide');
						$msg = "Record already exists!";
					}
				} else {
					$tpl->assign('class', 'alert alert-danger display-hide');
					if (empty($emp_id)){
						$msg = "Please Select Employee..!";
					} elseif(empty($ward_id)){
						$msg = "Please Select Zone..!";
					}
				}
	
				$tpl->assign('msg', $msg);
			} else {
				$tpl->assign('msg', 'Invalid token..!');
			}
		} else {
			$tpl->assign('msg', 'Something went wrong..!');
		}
	}	
	$sql = "select e.emp_code,e.emp_name,d.ward_desc,em.emp_id,em.ward_id from emp_mst e,ward_comm_map em,ward_mst d where em.emp_id=e.emp_id and em.ward_id=d.ward_id and e.ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "' and e.delete_status='0' and e.emp_status='0' order by em.id";
	if (isset($_POST['search'])) {
		$sql = "select emp_id,emp_code,emp_name,emp_name_marathi,emp_dept,emp_desg,emp_mobile,od_status from emp_mst where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "' and delete_status='0' and emp_status='0' and emp_mobile like'%" . $_POST['mobile'] . "%' and emp_name like '%" . $_POST['emp_name'] . "%'";
	}
	
	$data = []; // Initialize the data array

	if ($rs = mysqli_query($conn, $sql)) {
		$field_info = mysqli_fetch_fields($rs);

		while ($row = mysqli_fetch_assoc($rs)) {
			$row_data = [];
			foreach ($field_info as $f) {
				$row_data[$f->name] = $row[$f->name];
			}
			$data[] = $row_data;
		}

		$num_emp = mysqli_num_rows($rs);
	}
	/*foreach ($data as $employee) {
		echo "Employee ID: " . $employee['emp_id'] . "<br>";
		echo "Employee Name: " . $employee['emp_name'] . "<br>";
		echo "Departments: " . $employee['departments'] . "<br><br>";
	}*/ else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select emp_id,emp_name from emp_mst where ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "' and delete_status='0' and emp_status='0' order by emp_id";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$emp_list[$row['emp_id']] = $row['emp_name'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select ward_id,ward_desc from ward_mst where ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "' order by ward_id";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['ward_id']] = $row['ward_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}


	/** captcha generation ****/

	$code = rand(1000, 9999);

	$_SESSION['code'] = $code;




	/** close **/


	$sql = "select COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "%'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);

	//	print_r($online_applications);

	$tpl->assign('online_applications', $online_applications);

	// 			print_r($data);
	//mysqli_free_result($rs);

	//print_r($ids);
	mysqli_close($conn);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('ids', $ids);
	$tpl->assign('mobile', $_POST['mobile']);
	$tpl->assign('emp_name', $_POST['emp_name']);
	$tpl->assign('desg_list2', $desg_list2);
	$tpl->assign('multi_desg_list', $multi_desg_list);
	$tpl->assign('data', $data);
	$tpl->assign('num_emp', $num_emp);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('desg_list', $desg_list);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('code', $code);
	$tpl->display('assign_zone_desgn.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
