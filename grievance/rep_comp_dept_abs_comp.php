<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();
$user_type = $_SESSION['user_type'];
$active_class = $_REQUEST['active']??'';

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

$selectedYear = $_SESSION['filteryear'];
$response = "";

if (isset($_SESSION['uid'])) {
	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
	}else{
		$fdate='';
		$tdate='';
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
				$fdate = date('Y-m-d', strtotime($f_date));
				$tdate = date('Y-m-d', strtotime($t_date));
			}

			// --- Display or handle validation errors ---
			 $tpl->assign('errors', $errors);
		}

	$emplist = join("','", $_SESSION['emp_list']);
	$emp_id = $_SESSION['emp_id']??'';
	$dept_id = $_SESSION['dept_id']??'';
	
	$sql="SELECT dept_id,emp_id FROM hod_emp_map where emp_id IN('".$emplist."') ";
	
	if($_SESSION['user_type']=='D'){
		$sql="SELECT d.dept_id from dept_mst d, hod_emp_map h where h.dept_id = d.dept_id and emp_id IN('".$emplist."')";
	} else if($_SESSION['user_type']=='E'){
		
		$sql="SELECT edm.dept_id FROM `emp_desg_map` edm,desg_mst d,dept_mst dp where edm.desg_id=d.desg_id and edm.dept_id=dp.dept_id and edm.emp_id=".$_SESSION['emp_id'];

		//$sql="SELECT d.dept_id from dept_mst d, emp_mst e where d.dept_id = e.emp_dept and emp_id IN('".$emplist."')";
	}
	
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs)){
			$dept_list[$row['dept_id']]=$row['dept_id'];
		}
	}
	//echo $sql;
	$deptlist = implode(',', $dept_list);
	
	//echo "<pre>";print_r($dept_list);echo "</pre>";die();

	// Base values
	$ulbid = $_SESSION['ulbid']; // safe casting
	$grievancesTrns = $_SESSION['grievances_trns'] ?? 'grievances_transactions';
	$yearCondition = $selectedYear ? "AND YEAR(date_regd) = '" . intval($selectedYear) . "'" : "";
	$cat3Condition = "AND g.cat3_id != 0";

	$baseSql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,
					gt.dept_id AS emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$grievancesTrns." gt ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '".$ulbid."'
					AND g.app_type_id = '1'           
					AND g.cat3_id!='0' ";

	if($selectedYear!=''){
		$baseSql.=" AND YEAR(date_regd) = " . $selectedYear . " ";
	}

// total received**************************************************
   
    $sql = $baseSql. " AND g.grievance_status_id IN(1,2,3,6,8,9,11,12,13) 
             AND gt.disposal_status IN(1,2,3,6,8,9,11,12,13) ";

   if ($user_type == 'E'){
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
		
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	if ($user_type == 'U') {	
		if (!empty($emplist)) {
			$sql .= " AND gt.emp_id IN ({$emplist})";
		}		
	}
	$sql .= " group by emp_dept";
	$data=[];
	//echo "<pre>";print_r($sql);echo "</pre>";die();
	$tot['received']=0;
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['emp_dept']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

// underprogress within SLA *********************************************

    $sql = $baseSql . " AND g.grievance_status_id IN(2)
             AND gt.disposal_status IN(2)
             AND g.sla_status=1 ";

	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
   		
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
		
	if ($user_type == 'U') {
		if (!empty($emplist)) {
			// Ensure emplist is safe (e.g., from DB or sanitized input)
			$safeEmplist = implode(',', array_map('intval', explode(',', $emplist)));
			$sql .= " AND gt.emp_id IN ($safeEmplist)";
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
	
	//echo "<pre>";print_r($tot['underprogress_within_sla']);echo "</pre>";die();
	
// underprogress beyond SLA ***********************************************
		
	$sql = $baseSql . " AND g.grievance_status_id IN(2) AND gt.disposal_status IN(2) AND g.sla_status=2 ";

	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }	
	
	
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
		
	if ($user_type == 'U') {
		if (!empty($emplist)) {
			$sql.=" and emp_id IN( {$emplist} )  ";
		}
	}
	
	$sql .= " group by emp_dept";
	
	$tot['underprogress_beyond_sla']=0;
	
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data_list[$row['emp_dept']]['underprogress_beyond_sla'] = $row['count'];
			$tot['underprogress_beyond_sla'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));
	
	//echo "<pre>";print_r($sql);echo "</pre>";die();

// completed within SLA****************************************************

	$sql = $baseSql . " AND g.grievance_status_id IN(3,8,9) AND g.sla_status = 1 ";
	
	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
	
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
			
	if ($user_type == 'U') {	
		if (!empty($emplist)) {
			$sql.=" and emp_id IN( $emplist )  ";
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
	
	//echo "<pre>";print_r($data);echo "</pre>";die();

// completed beyond SLA*********************************************************
		
	$sql = $baseSql . " AND g.grievance_status_id IN(3,8,9) AND g.sla_status=2 ";
	
	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
			
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
			
	if ($user_type == 'U') {
		if (!empty($emplist)) {
			$sql.=" and emp_id IN( $emplist )  ";
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

//echo "<pre>";print_r($data_list);echo "</pre>";die();


// reopend complaints*********************************************************


	$sql = $baseSql . " AND g.grievance_status_id IN(13) AND gt.disposal_status IN(13) ";
	
	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
	
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	if ($user_type == 'U') {
		if(!empty($emplist)) {
			$sql.=" and emp_id IN( $emplist )  ";
		}		
	}
	
	$sql .= " group by emp_dept";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['reopened'] = $row['count'];
		$tot['reopened'] += $row['count'];
	}
//echo "<pre>";print_r($sql);echo "</pre>";die();
// unresolvable complaints ******************************************************

	$sql = $baseSql . " AND g.grievance_status_id IN (4) AND gt.disposal_status IN (4) ";
	
	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }

	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	if ($user_type == 'U') {	
		if(!empty($emplist)) {
			$sql.=" and emp_id IN( $emplist )  ";
		}
	}
	
	$sql .= " group by gt.emp_dept";

	$rs = mysqli_query($conn, $sql);
	$tot['unresolved']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['unresolved'] =$row['count'];
		$tot['unresolved']+=$row['count'];
	}

	/********** FIN IMPLICATION **********************/

	$sql = $baseSql . " AND g.grievance_status_id IN(6) ";
			
	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
		
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	if ($user_type == 'U') {
		if(!empty($emplist)) {
			$sql.=" and emp_id IN( $emplist )  ";
		}		
	}
	
	$sql .= " group by emp_dept";
	
	$tot['fin']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['fin'] = $row['count'];
		$tot['fin'] += $row['count'];
	}
//echo "<pre>";print_r($tot['fin']);echo "</pre>";die();	

/********* REJECTED ***********/

	$sql = $baseSql . " AND g.grievance_status_id IN (1) AND gt.disposal_status IN (1) ";

	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
	
	
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	if ($user_type == 'U') {
		if(!empty($emplist)){
			$sql.=" and emp_id IN( $emplist )  ";
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

	//echo "<pre>";print_r($data_list);echo "</pre>";die();	
	
/********* Complaints Reopened Under Progress ***********/

	$sql = $baseSql . " AND g.grievance_status_id IN (11) AND gt.disposal_status IN (11) ";
	
	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
	
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}

	if ($user_type == 'U') {	
		if(!empty($emplist)){
			$sql.=" and emp_id IN( $emplist )  ";
		}		
	}
	
	$sql .= " group by emp_dept";
	
	$rs = mysqli_query($conn, $sql);
	$tot['reopend_underProgress']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['reopend_underProgress'] = $row['count'];
		$tot['reopend_underProgress'] += $row['count'];
		$i += $row['count'];
	}

//echo "<pre>";print_r($tot[$row['grievance_status_id']]['reopend_underProgress']);echo "</pre>";die();
/********* Complaints Reopened Completed ***********/

	$sql = $baseSql . " AND g.grievance_status_id IN (12) ";
	
	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
		
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	if ($user_type == 'U') {
		if(!empty($emplist)){
			$sql.=" and emp_id IN( $emplist )  ";
		}		
	}
	
	$sql .= " group by emp_dept";
	
	$rs = mysqli_query($conn, $sql);
	
	$tot['reopened_completed']=0;
	
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['reopened_completed'] = $row['count'];
		$tot['reopened_completed'] += $row['count'];
	}
	
//echo "<pre>";print_r($sql);echo "</pre>";die();

//transfers*******************************************************************

	$sql = $baseSql . " AND g.grievance_status_id IN (5,10) AND gt.disposal_status IN (5,10) ";

	if ($user_type == 'E') {
	   if($emp_id!=''){
			$sql .= " AND gt.emp_id =".$emp_id." ";
	   } 
	   
	   if($dept_id!=''){
			$sql .= " AND gt.dept_id =".$dept_id." ";
	   }
    }
	
	if ($selectedYear) {
	
		$sql .= " AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "' ";
		
	}	
	
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '' && ($fdate < $tdate)) {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	if ($user_type == 'U') {	
		if(!empty($emplist)){
			$sql.=" and emp_id IN( $emplist )  ";
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

	$sql = "SELECT dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($_SESSION['user_type'] == 'D') {
		$sql = "SELECT d.dept_id,dept_desc from dept_mst d, hod_emp_map h where h.dept_id = d.dept_id and emp_id IN ('" . $emplist . "')";
	}else if ($_SESSION['user_type'] == 'E') {		
		$sql="SELECT edm.dept_id,dp.dept_desc FROM `emp_desg_map` edm,desg_mst d,dept_mst dp where edm.desg_id=d.desg_id and edm.dept_id=dp.dept_id and edm.emp_id=".$_SESSION['emp_id'];
	}

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)){
			$dept_list[$row['dept_id']] = $row['dept_desc'];
			$dept_list2[$row['dept_id']] = $row['dept_id'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

//echo "<pre>";print_r($dept_list);echo "</pre>";die();

	$dept_list1 = $dept_list2;

	$deptlist = implode(',', $dept_list1);
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
	$tpl->assign('status', $_REQUEST['status']);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('deptlist', $deptlist);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('active_class', $active_class);
	$flash = get_flash();		
	$tpl->assign("flash", $flash);  
	$tpl->display('rep_comp_dept_abs_comp.tpl');

} else {
	echo "<script>window.location='index.php';</script>";
}
?>