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


	//$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);
	//$code = mysqli_real_escape_string($conn, $_POST['code']);


	$sql = "select emp_id,emp_code,emp_name,emp_name_marathi,emp_dept,emp_desg,emp_mobile,od_status from emp_mst where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "' and delete_status='0' and emp_status='0' ";
	if (isset($_POST['search'])) {
		$sql = "select emp_id,emp_code,emp_name,emp_name_marathi,emp_dept,emp_desg,emp_mobile,od_status from emp_mst where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "' and delete_status='0' and emp_status='0' and emp_mobile like'%" . $_POST['mobile'] . "%' and emp_name like '%" . $_POST['emp_name'] . "%'";
	}
	if ($rs = mysqli_query($conn, $sql)) {
		$field_info = mysqli_fetch_fields($rs);
		while ($row = mysqli_fetch_assoc($rs)) {

			foreach ($field_info as $fi => $f)
				$data[$row['emp_id']][$f->name] = $row[$f->name];
		}


		$num_emp = mysqli_num_rows($rs);
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "select emp_id,emp_code,emp_name,emp_name_marathi,emp_dept,emp_desg,emp_mobile,od_status from emp_mst_od where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "' and delete_status='0' ";
	if (isset($_POST['search'])) {
		$sql = "select emp_id,emp_code,emp_name,emp_name_marathi,emp_dept,emp_desg,emp_mobile,od_status from emp_mst_od where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid'])) . "' and delete_status='0' and emp_mobile like '%" . $_POST['mobile'] . "%' and emp_name like '%" . $_POST['emp_name'] . "%'";
	}
	if ($rs = mysqli_query($conn, $sql)) {
		$field_info = mysqli_fetch_fields($rs);
		while ($row = mysqli_fetch_assoc($rs)) {

			foreach ($field_info as $fi => $f)
				$data[$row['emp_id']][$f->name] = $row[$f->name];
		}

		$num_emp = mysqli_num_rows($rs);
	}

//echo "<pre>";print_r($data[54]);echo "</pre>";die();

	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "' order by dept_id";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select desg_id,desg_desc from desg_mst where ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$desg_list[$row['desg_id']] = $row['desg_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select id,desg_id,dept_id,em.emp_id from emp_desg_map em,emp_mst e where em.delete_status = '0' and e.delete_status = '0' and e.emp_status='0' and em.emp_id=e.emp_id and e.ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$multi_desg_list[$row['emp_id']][$row['dept_id']][$row['desg_id']] = $row['desg_id'];
			$ids[$row['desg_id']] = $row['id'];

			$sql2 = "select desg_id,desg_desc from desg_mst where dept_id='" . $row['dept_id'] . "'";
			$rs2 = mysqli_query($conn, $sql2);
			while ($row1 = mysqli_fetch_assoc($rs2)) {
				$desg_list2[$row['dept_id']][$row1['desg_id']] = $row1['desg_desc'];
			}
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select id,desg_id,dept_id,em.emp_id from emp_desg_map em,emp_mst_od e where em.emp_id=e.emp_id and e.ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$multi_desg_list[$row['emp_id']][$row['dept_id']][$row['desg_id']] = $row['desg_id'];
			$ids[$row['desg_id']] = $row['id'];

			$sql2 = "select desg_id,desg_desc from desg_mst where dept_id='" . $row['dept_id'] . "'";
			$rs2 = mysqli_query($conn, $sql2);
			while ($row1 = mysqli_fetch_assoc($rs2)) {
				$desg_list2[$row['dept_id']][$row1['desg_id']] = $row1['desg_desc'];
			}
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


//echo "<pre>";print_r($multi_desg_list[239]);echo "</pre>";die();

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
	$tpl->assign('desg_list', $desg_list);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('code', $code);
	$tpl->display('manage_emp.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
?>