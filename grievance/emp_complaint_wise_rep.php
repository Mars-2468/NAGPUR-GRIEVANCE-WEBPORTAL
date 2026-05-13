<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {
	
	require_once('connection.php');
	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);

	$conn = getconnection();

	$aptid1 = $_REQUEST['aptid']??'';
	$status1 = $_REQUEST['status']??'';
	$ulbid1 = $_SESSION['ulbid']??'';	
	$sla1 = $_REQUEST['sla']??'';
	
	$grievances_trns = $_SESSION['grievances_trns'];
	
	$user_type = $_SESSION['user_type'];		
	$emp_id = $_SESSION['emp_id'];
	$dept_id = $_SESSION['dept_id'];


	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$f_date = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$t_date = date('Y-m-d', strtotime($_REQUEST['t_date']));
	}else{
		$f_date = '';
		$t_date = '';
	}
		$errors = [];
		if (isset($_POST['search'])) {

			// --- Validate Dates ---
			if (!empty($_POST['f_date']) && !empty($_POST['t_date'])) {

				// Convert and validate date format
				$f_date_raw = $_POST['f_date'];
				$t_date_raw = $_POST['t_date'];

				// Check valid date format (DD-MM-YYYY or YYYY-MM-DD)
				$f_date_obj = DateTime::createFromFormat('Y-m-d', $f_date_raw) ?: DateTime::createFromFormat('d-m-Y', $f_date_raw);
				$t_date_obj = DateTime::createFromFormat('Y-m-d', $t_date_raw) ?: DateTime::createFromFormat('d-m-Y', $t_date_raw);

				if ($f_date_obj && $t_date_obj) {
					$f_date = $f_date_obj->format('Y-m-d');
					$t_date = $t_date_obj->format('Y-m-d');

					// Check if from-date is earlier than to-date
					if ($f_date > $t_date) {
						$errors[] = "From date cannot be later than To date.";
					}

				} else {
					$errors[] = "Invalid date format.";
				}

			} elseif (!empty($_POST['f_date']) || !empty($_POST['t_date'])) {
				$errors[] = "Both From and To dates are required.";
			}else{
				$f_date = date('Y-m-d', strtotime($f_date));
				$t_date = date('Y-m-d', strtotime($t_date));
			}

			// --- Display or handle validation errors ---
			 $tpl->assign('errors', $errors);
		}
		
	$baseSql = " SELECT COUNT(DISTINCT g.grievance_id) AS count, g.cat3_id
				FROM grievances g
				JOIN $grievances_trns gt ON g.grievance_id = gt.grievance_id
				WHERE g.ulbid = '$ulbid1'
				AND g.app_type_id = '1'
				AND g.cat3_id != '0' ";		

	if ($f_date != '' && $t_date != '' && ($f_date < $t_date)) {
		$baseSql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";	
	}
	
	if ($user_type == 'E'){
	   if($emp_id!=''){
			$baseSql .= " AND gt.emp_id =".$emp_id." ";
	   } 	   
	   if($dept_id!=''){
			$baseSql .= " AND gt.dept_id =".$dept_id." ";
	   }
	}

//**********************************************************************		
	//$sql = "SELECT count(DISTINCT g.grievance_id) as count,cat3_id FROM grievances g, ".$grievances_trns." gt where g.grievance_id=gt.grievance_id  and ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id !='0' ";
	
	$sql = $baseSql . " AND g.grievance_status_id IN (2,3,6,8,9,11,12,13) 
					AND gt.disposal_status IN (2,3,6,8,9,11,12,13) ";	
	
	$sql .= " group by cat3_id";
	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['cat3_id']]['count'] = $row['count'];
			$tot['count'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));
	
	//echo $sql;exit;
//*************************************************************************	
	
	//$sql = "SELECT count(DISTINCT grievance_id) as grievance_id,cat3_id FROM grievances where ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id !='0'";

	$sql = $baseSql . " AND g.grievance_status_id IN (2,3,6,8,9,11,12,13) 
					AND gt.disposal_status IN (2,3,6,8,9,11,12,13) ";	
	
	$sql .= " group by cat3_id";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['total_received'] = $row['count'];
		$tot['total_received'] += $row['count'];
	}

	/**** resolved with in sla ****/

	//$sql = "SELECT COUNT(DISTINCT grievance_id) as resolved_within_sla,cat3_id from grievances where grievance_status_id IN('3','8','9') and ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id !='0' and sla_status='1' ";

	$sql = $baseSql . " AND g.grievance_status_id IN (3,8,9) AND g.sla_status=1 ";	
	
	$sql .= " group by cat3_id";

	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['resolved_within_sla'] = $row['count'];
		$tot['resolved_within_sla'] += $row['count'];
	}

	/*** resolved beyond sla ****/

	//$sql = "SELECT COUNT(DISTINCT grievance_id) as resolved_beyond_sla,cat3_id from grievances where grievance_status_id IN('3','8','9') and ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id !='0' and sla_status='2'";

	$sql = $baseSql . " AND g.grievance_status_id IN (3,8,9) AND g.sla_status=2 ";	
	
	$sql .= " group by cat3_id";



	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['resolved_beyond_sla'] = $row['count'];
		$tot['resolved_beyond_sla'] += $row['count'];
	}

	/**** pending with in sla ***/

	//$sql = "SELECT COUNT(DISTINCT grievance_id) as pending_within_sla,cat3_id from grievances where grievance_status_id IN('2') and ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id !='0' and sla_status='1'";
	
	$sql = $baseSql . " AND g.grievance_status_id IN (2) AND gt.disposal_status IN (2) AND g.sla_status=1 ";	
	
	$sql .= " group by cat3_id";


	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['pending_within_sla'] = $row['count'];
		$tot['pending_within_sla'] += $row['count'];
	}


	/**** pending with beyond sla ***/

	//$sql = "SELECT COUNT(DISTINCT grievance_id) as pending_beyond_sla,cat3_id from grievances where grievance_status_id IN('2') and ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id !='0' and sla_status='2'";

	$sql = $baseSql . " AND g.grievance_status_id IN (2) AND gt.disposal_status IN (2) AND g.sla_status=2 ";	
	
	$sql .= " group by cat3_id";
	
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['pending_beyond_sla'] = $row['count'];
		$tot['pending_beyond_sla'] += $row['count'];
	}
		
	$sql = $baseSql . " AND g.grievance_status_id IN (13) AND gt.disposal_status IN (13) ";	
	
	$sql .= " group by cat3_id";


	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['reopened'] = $row['count'];
		$tot['reopened'] += $row['count'];
	}

	// reopened UnderProgress complaints


	/* $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,g.grievance_status_id,cat3_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' 
	and g.app_type_id='1' and g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' ";
 */	
 
 	$sql = $baseSql . " AND g.grievance_status_id IN (11) AND gt.disposal_status IN (11) ";	
	
	$sql .= " group by cat3_id";

	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']][$row['grievance_status_id']]['reopend_underProgress'] += $row['count'];
		$tot['reopend_underProgress'] += $row['count'];
	}

	// reopened Complaints

	/* $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,g.grievance_status_id,cat3_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' 
		and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' ";
 */	
 
 	$sql = $baseSql . " AND g.grievance_status_id IN (12) ";	
	
	$sql .= " group by cat3_id";

	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['reopend_completed'] += $row['count'];
		$tot['reopend_completed'] += $row['count'];
	}

	/**** Fin Implication ***/
	//$sql = "SELECT COUNT(DISTINCT g.grievance_id) as fin_implication,cat3_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and g.grievance_status_id IN ('6') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status IN ('6') and cat3_id !='0'";
	
	$sql = $baseSql . " AND g.grievance_status_id IN (6) ";	
	
	$sql .= " group by cat3_id";


	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['fin_implication'] += $row['count'];
		$tot['fin_implication'] += $row['count'];
	}


	/**** Pending For Apporval ***/

	//$sql = "SELECT COUNT(DISTINCT grievance_id) as pending_apprvl,cat3_id from grievances where grievance_status_id ='1' and ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id !='0'";

	$sql = $baseSql . " AND g.grievance_status_id IN (1) ";	
	
	$sql .= " group by cat3_id";


	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['pending_apprvl'] += $row['count'];
		$tot['pending_apprvl'] += $row['count'];
	}

	
	/**** Rejected ***/

	//$sql = "SELECT COUNT(DISTINCT grievance_id) as rejected,cat3_id from grievances where grievance_status_id ='10' and ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id !='0'";

	
	$sql = $baseSql . " AND g.grievance_status_id IN (1) ";	
	
	$sql .= " group by cat3_id";

	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['rejected'] += $row['count'];
		$tot['rejected'] += $row['count'];
	}


	/**** Unresolved ***/

	//$sql = "SELECT COUNT(DISTINCT grievance_id) as unresolved,cat3_id from grievances where grievance_status_id ='4' and ulbid='" . $ulbid1 . "' and app_type_id='1' and cat3_id !='0'";

	$sql = $baseSql . " AND g.grievance_status_id IN (4) ";	
	
	$sql .= " group by cat3_id";


	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['cat3_id']]['unresolved'] += $row['count'];
		$tot['unresolved'] += $row['count'];
	}

//************************************************************************************

	$sql = "select * from ulbmst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$ulb_list[$row['ulbid']] = $row['ulbname'];
	}


	$sql = "select cat_id,cs_id,cs_desc from cs_mst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$cs_list[$row['cs_id']] = $row['cs_desc'];
		$cat_id[$row['cs_id']]['cat_id'] = $row['cat_id'];

		$total[$row['cs_id']]['tot_resolved'] = $data[$row['cs_id']]['tot_resolved'];
		$data[$row['cs_id']]['percent'] = number_format(($total[$row['cs_id']]['tot_resolved'] / $data[$row['cs_id']]['total_received']) * 100, 0);
		if ($data[$row['cs_id']]['percent'] == 'nan') {
			$data[$row['cs_id']]['percent'] = 0;
		}
	}

	//23-05-24 $tot['resolved'] = $tot['resolved_within_sla'] + $tot['resolved_beyond_sla'] + $tot['fin_implication'] + $tot['unresolved'] + $tot['rejected'];
	$tot['percent'] = number_format(($tot['tot_resolved'] / $tot['total_received']) * 100, 2);
	if ($tot['percent'] == 'nan') {
		$tot['percent'] = 0;
	}

	$sql = "select cat_id,description from category_mst";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$cat_list[$row['cat_id']] = $row['description'];
	}

	$sql = "select COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "%'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);
	mysqli_close($conn);


	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('fdate', $f_date);
	$tpl->assign('tdate', $t_date);

	$tpl->assign('emp_id', $dept_id);
	$tpl->assign('users_list', $users_list);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('app_type_id', $_REQUEST['aptid']);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('cat_id', $cat_id);
	$tpl->assign('cat_list', $cat_list);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('grievance_status_list', $grievance_status_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('emp_complaint_wise_rep.tpl');
} else {
	$msg = "You have not logged in, Please Login";
	$tpl->assign('msg', $msg);
	$tpl->display('user_login.tpl');
}
