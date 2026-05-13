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
		if ($_GET['zone_id']) {
			$where = 'where ward_id="' . $_GET['zone_id'] . '"';
		} else {
			$where = '';
		}

		$sql = "SELECT count(grievance_id) as count,grievance_status_id FROM `grievances` $where GROUP by grievance_status_id";
		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {
			$data['count'][$row['grievance_status_id']] = $row['count'];
			if ($where) {
				$data['count']['zone'] = $row['ward_desc'];
			} else {
				$data['count']['zone'] = 'All';
			}
		}

		$sql = "select COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . $_SESSION['ulbid'] . "%'";
		$rs = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($rs);
		$users_count = $row['user_count'];
		$tpl->assign('users_count', $users_count);
		//	print_r($online_applications);
		$tpl->assign('user_type', $_SESSION['user_type']);

		$tpl->assign('ulbid', $_SESSION['ulbid']);
		$tpl->assign('ulb', $_SESSION['ulbid']);


		mysqli_close($conn);
		$tpl->assign('status_list', $status_list);
		$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet', '3' => 'Both'));
		$tpl->assign('data_list', $data);
		$tpl->assign('data', $data);
		$tpl->assign('tot', $tot);
		$tpl->assign('dept_list', $dept_list);
		$tpl->assign('services', $obj->services);
		$tpl->assign('uname', $_SESSION['user_name']);
		$tpl->assign('user_dept', $_SESSION['user_dept']);
		$tpl->assign('logo', $_SESSION['logo']);
		$tpl->assign('banner', $_SESSION['banner']);
		$tpl->assign('main_icons', $obj->main_icons);
		$tpl->assign('uid', $_SESSION['uid']);
		$tpl->display('corp_Zonalmapreports.tpl');
	} else {
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

		echo "<script>window.location='index.php';</script>";
	}
	?>	