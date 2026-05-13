<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('Smarty.class.php');
$tpl = new Smarty();
$user_type = $_SESSION['user_type'];
$ward_id = !empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';
$active_class='';
if (isset($_GET['active'])) {
	$active_class = $_GET['active'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST['ty'] == 'yearwisefilter') {
		year_wise_flter($_POST);
	}
}
function year_wise_flter($RES)
{
	$_SESSION['filteryear'] = $RES['year'];
	return $_SESSION['filteryear'];
}

$selectedYear = isset($_SESSION['filteryear'])? $_SESSION['filteryear']:'';

if (isset($_SESSION['uid'])) {
	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	$f_date=isset($_REQUEST['f_date'])?$_REQUEST['f_date']:'';
	$t_date=isset($_REQUEST['t_date'])?$_REQUEST['t_date']:'';
	if ($f_date!= '' && $t_date!= '') {
		$fdate = date('Y-m-d', strtotime($f_date));
		$tdate = date('Y-m-d', strtotime($t_date));
	}else{
		$fdate='';
		$tdate='';
	}
	
	$status = isset($_REQUEST['status'])?$_REQUEST['status']:'';
	$sla = isset($_REQUEST['sla'])?$_REQUEST['sla']:'';
	
	
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
			$fdate = date('Y-m-d', strtotime($f_date));
			$tdate = date('Y-m-d', strtotime($t_date));
		}

		// --- Display or handle validation errors ---
		 $tpl->assign('errors', $errors);
	}

	// Base values
	$ulbid = intval($_SESSION['ulbid']); // safe casting
	$grievancesTrns = !empty($_SESSION['grievances_trns'])?$_SESSION['grievances_trns']: 'grievances_transactions';

	$baseSql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				LEFT JOIN 
					".$grievancesTrns." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . $ulbid . "'						
					AND g.app_type_id = '1'
					AND g.cat3_id != 0 	
					";
	if($ward_id){
		$baseSql .= " AND g.ward_id=".$ward_id."  ";
	}	
	
	if($selectedYear){
		$baseSql .= " AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "' ";
	}
	
	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (2,3,5,6,8,9,10,11,12,13) 
			AND gt.disposal_status IN (2,3,5,6,8,9,10,11,12,13) 		
			";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";
	
//	echo "<pre>";print_r($sql);echo "</pre>";die();
	$tot['received']=0;
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['emp_dept']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

// underprogress within SLA
    // For user type 'U' (basic user)
	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (2) 
			AND gt.disposal_status IN (2) 		
			AND g.sla_status=1 		
			";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";

	//echo $sql;
	
	$tot['underprogress_within_sla']=0;
	
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data_list[$row['emp_dept']]['underprogress_within_sla'] = $row['count'];
			$tot['underprogress_within_sla'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));
	
// underprogress beyond SLA

	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (2) 
			AND gt.disposal_status IN (2) 		
			AND g.sla_status=2 		
			";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept ";
	
	$tot['underprogress_beyond_sla']=0;
	
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data_list[$row['emp_dept']]['underprogress_beyond_sla'] = $row['count'];
			$tot['underprogress_beyond_sla'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));
	
	//echo "<pre>";print_r($data);echo "</pre>";die();

// completed within SLA


$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (3,8,9)		
			AND g.sla_status=1 		
			";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";
	
	//echo $sql;
	
	$tot['completed_within_sla']=0;
	
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data_list[$row['emp_dept']]['completed_within_sla'] = $row['count'];
			$tot['completed_within_sla'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

// completed beyond SLA

	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (3,8,9)		
			AND g.sla_status=2 		
			";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";
	
	//echo $sql;
	
	$tot['completed_beyond_sla']=0;
	
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data_list[$row['emp_dept']]['completed_beyond_sla'] = $row['count'];
			$tot['completed_beyond_sla'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

// reopend complaints

	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (13) AND gt.disposal_status IN (13) ";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";
	
	//echo $sql;exit;
	
	$rs = mysqli_query($conn, $sql);
	$tot['reopened']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['reopened'] = $row['count'];
		$tot['reopened'] += $row['count'];
	}

	/// unresolvable complaints

		$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (4) ";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";
	//echo $sql ;


	$rs = mysqli_query($conn, $sql);
	$tot['unresolved']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['unresolved'] =$row['count'];
		$tot['unresolved']+=$row['count'];
	}

	/********** FIN IMPLICATION **********************/

	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (6) ";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept ";
	
	
	$rs = mysqli_query($conn, $sql);
	$tot['fin']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['fin'] = $row['count'];
		$tot['fin'] += $row['count'];
	}
	
	//echo "<pre>";print_r($tot['fin']);echo "</pre>";die();	

	/********* REJECTED ***********/

	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (1) ";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";
	
	$tot['rejected']=0;
	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_dept']]['rejected'] = $row['count'];
			$tot['rejected'] += $row['count'];
		}
	}

	//echo "<pre>";print_r($data_list['rejected']);echo "</pre>";die();	
	
	/********* Complaints Reopened Under Progress ***********/

	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (11)
			AND gt.disposal_status IN (11) ";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";

	$rs = mysqli_query($conn, $sql);
	$tot['reopend_underProgress']=0;
	$i=0;
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopend_underProgress'] = $row['count'];
		$tot['reopend_underProgress'] += $row['count'];
		$i += $row['count'];
	}

//echo "<pre>";print_r($tot[$row['grievance_status_id']]['reopend_underProgress']);echo "</pre>";die();

/********* Complaints Reopened Completed ***********/

	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (12)
			AND gt.disposal_status IN (12) ";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";

//echo $sql;exit;
	
	$rs = mysqli_query($conn, $sql);
	$tot['reopened_completed']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['reopened_completed'] = $row['count'];
		$tot['reopened_completed'] += $row['count'];
	}

//transfers

	$sql=$baseSql;
	
	$sql.="	AND g.grievance_status_id IN (5,10) ";
			
	if (isset($_POST['search'])) {

		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by emp_dept";
		
	$rs = mysqli_query($conn, $sql);
	$tot['transfers']['count']=0;
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['transfers'] = $row['count'];
		$tot['transfers']['count'] += $row['count'];
	}

//echo "<pre>";print_r($tot['transfers']['count']);echo "</pre>";die();

	$sql = "SELECT dept_id,dept_desc from dept_mst  ";

		//$sql = "SELECT d.dept_id,dept_desc from dept_mst d, hod_emp_map h where h.dept_id = d.dept_id ";
	

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)){
			$dept_list[$row['dept_id']] = $row['dept_desc'];	
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

//echo "<pre>";print_r($dept_list);echo "</pre>";die();

	$deptlist =  array_keys($dept_list);
	//print_r($deptlist);

	$sql = "SELECT emp_id, emp_name, emp_mobile from emp_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {

		$emp_list[$row['emp_id']] = $row['emp_name'] . " - " . $row['emp_mobile'];

		$emp_mobile[$row['emp_id']] = $row['emp_mobile'];
	}



	$tpl->assign('emp_list', $emp_list);

	$tpl->assign('emp_mobile', $emp_mobile);



	$sql = "SELECT * from grievance_status_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs = mysqli_query($conn, $sql);
	$online_applications=[];
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	$sql = "SELECT COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . $_SESSION['ulbid'] . "%'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$users_count = $row['user_count'];


	$tpl->assign('users_count', $users_count);
	//	print_r($online_applications);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('username', $_SESSION['user_name']);

	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);

	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('ulb', $_SESSION['ulbid']);
	$tpl->assign('online_applications', $online_applications);
	mysqli_close($conn);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet', '3' => 'Both'));
	$tpl->assign('data_list', $data_list);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('status', $status);
	$tpl->assign('sla', $sla);
	$tpl->assign('deptlist', $deptlist);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	//$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('active_class', $active_class);
	$flash = get_flash();		
	$tpl->assign("flash", $flash);  
	$tpl->display('corp_rep_comp_dept_abs_comp.tpl');

} else {
	

	echo "<script>window.location='index.php';</script>";
}
?>