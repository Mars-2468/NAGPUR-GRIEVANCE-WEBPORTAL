<?php
require_once  "config.php";
ini_set('display_errors',0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

date_default_timezone_set('Asia/Calcutta');

require_once('Smarty.class.php');
$tpl = new Smarty();
$user_type = $_SESSION['user_type'];

if (isset($_SESSION['uid'])) {


	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	$filteryear=$_SESSION['filteryear'];
	$ward_id=!empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';

//	echo "<pre>";print_r($_SESSION);echo "</pre>";die();

	$emplist = join("','", $_SESSION['emp_list']);
	
/* 	$f_date =!empty($_POST['f_date'])? date('Y-m-d', strtotime($_POST['f_date'])):'';
	$t_date =!empty($_POST['t_date'])? date('Y-m-d', strtotime($_POST['t_date'])):'';	 */
	
	$f_date = null;
	$t_date = null;
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

	$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,ward_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' AND g.grievance_status_id IN (2,3,5,6,8,9,10,11,12,13) AND gt.disposal_status IN (2,3,5,6,8,9,10,11,12,13)";

	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";
	//echo $sql; 

//echo"<pre>";print_r($sql);echo"</pre>";die();    

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['emp_dept']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	//completed	
	
	$sql = "SELECT count(DISTINCT g.grievance_id) as count,ward_id as emp_dept FROM grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
    	app_type_id='1' and g.grievance_status_id IN(3,8,9) and sla_status=1 and cat3_id !='0' ";
	
	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";
	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data_list[$row['emp_dept']]['completed'] = $row['count'];
			$tot['completed'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	// reopend complaints

	$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,ward_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  
		and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and gt.disposal_status IN('13') and ulbid='" . $_SESSION['ulbid'] . "'  ";
	
	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";

	$rs = mysqli_query($conn, $sql);
	$tot['reopened']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['reopened'] = $row['count'];
		$tot['reopened'] += $row['count'];
	}

	// unresolvable complaints

	$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,ward_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' 
		and g.grievance_status_id IN ('4') and ulbid='" . $_SESSION['ulbid'] . "'";

	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
		
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}

	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";
	//echo $sql ;


	$rs = mysqli_query($conn, $sql);
	$tot['unresolved']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['unresolved'] = $row['count'];
		$tot['unresolved'] += $row['count'];
	}

	/********** FIN IMPLICATION **********************/

	$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,ward_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' 
		and g.grievance_status_id IN (6) and ulbid='" . $_SESSION['ulbid'] . "'";

	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";

	$rs = mysqli_query($conn, $sql);
	$tot['fin']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['fin'] = $row['count'];
		$tot['fin'] += $row['count'];
	}

	/********* REJECTED ***********/

	$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,ward_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' 
		and g.grievance_status_id IN('10') and ulbid='" . $_SESSION['ulbid'] . "'";

	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";

	$tot['rejected']=0;

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {
			$data_list[$row['emp_dept']]['rejected'] = $row['count'];
			$tot['rejected'] += $row['count'];
		}
	}


	// complaints completed beyond sla
	
	$sql = "SELECT count(DISTINCT g.grievance_id) as count,ward_id as emp_dept FROM grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
    	g.app_type_id='1' and g.grievance_status_id IN(3,8,9) and g.sla_status=2 and cat3_id !='0' ";

	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['completed_be_sla'] = $row['count'];
		$tot['completed_be_sla'] += $row['count'];
	}

	//pending

	$sql = "SELECT count(g.grievance_id) as count,ward_id as emp_dept FROM grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
    	app_type_id='1' and g.grievance_status_id IN('2') and gt.disposal_status IN('2') and sla_status=1 and cat3_id !='0' ";

	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	$tot['pending']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['pending'] = $row['count'];
		$tot['pending'] += $row['count'];
	}


	//pending_be
	
	$sql = "SELECT count(DISTINCT g.grievance_id) as count,ward_id as emp_dept FROM grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and  ulbid='" . $_SESSION['ulbid'] . "' and 
    	app_type_id='1' and grievance_status_id IN('2') and gt.disposal_status IN('2') and sla_status=2 and cat3_id !='0' ";

	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	$tot['pending_be']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['pending_be'] = $row['count'];
		$tot['pending_be'] += $row['count'];
	}


	// pending for approval

	$sql = "SELECT count(DISTINCT grievance_id) as count,ward_id as emp_dept FROM grievances where grievance_status_id IN('1') and cat3_id !='0'";
	
	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}	

	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by ward_id ";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	$tot['pending_approval']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['pending_approval'] = $row['count'];
		$tot['pending_approval'] += $row['count'];

		/*$data[$row['emp_dept']]['count'] += $row['count'];
		$tot['received'] += $row['count'];*/
	}

	//reopend_underProgress

	$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,ward_id as emp_dept,g.grievance_status_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and
		g.grievance_status_id IN('11') and gt.disposal_status IN('11') and ulbid='" . $_SESSION['ulbid'] . "' ";

	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopend_underProgress'] = $row['count'];
		$tot['reopend_underProgress'] += $row['count'];
		$i += $row['count'];
	}

	// reopened completed

	$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,ward_id as emp_dept,g.grievance_status_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and ulbid='" . $_SESSION['ulbid'] . "'";

	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopend_completed'] = $row['count'];
		$tot['reopend_completed'] += $row['count'];
	}


	// transfered

	$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,ward_id as emp_dept,g.grievance_status_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN (5,10) and ulbid='" . $_SESSION['ulbid'] . "'";
	
	if(!empty($ward_id)){							
		$sql.=" and g.ward_id = ".$ward_id." ";						
	}
	
	if(!empty($filteryear)){							
		$sql.=" and date_format(g.date_regd,'%Y') = '".$filteryear."' ";						
	}
	
	if($f_date!= '' && $t_date!='' && ($f_date < $t_date)){		
		$sql.=" and date_format(g.date_regd,'%Y-%m-%d') between '".$f_date."' and '".$t_date."' ";
	}
	
	$sql .= " group by g.ward_id ";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['transfered'] += $row['count'];
		$tot['transfered']['count'] += $row['count'];
	}

	$sql = "select ward_id,ward_desc from ward_mst where ulbid='" . $_SESSION['ulbid'] . "' and ward_id=" . $ward_id . " ";

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['ward_id']] = $row['ward_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));



	$sql = "select * from grievance_status_mst";
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
	$sql = "select COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . $_SESSION['ulbid'] . "%'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);
	//	print_r($online_applications);
	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('fdate', $f_date);
	$tpl->assign('tdate', $t_date);

	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('ulb', $_SESSION['ulbid']);
	$tpl->assign('tot', $tot);
	$tpl->assign('online_applications', $online_applications);
	mysqli_close($conn);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet', '3' => 'Both'));
	$tpl->assign('data_list', $data_list);
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
	$tpl->display('corp_ward_wise_abstract.tpl');	
} else {
	echo "<script>window.location='index.php';</script>";
}