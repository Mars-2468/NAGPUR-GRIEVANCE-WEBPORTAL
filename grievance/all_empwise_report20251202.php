<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {
	//
	session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();


	$emp_name = $_REQUEST['emp_name'];

	$_REQUEST['app_type_id'] = 1;

	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
		// $tpl->assign('fdate', date('Y-m-d', strtotime($_REQUEST['f_date'])));
		// $tpl->assign('tdate', date('Y-m-d', strtotime($_REQUEST['t_date'])));
	}


	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id,ward_id,street_id,g.date_regd from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and
	g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and g.cat3_id !='0' ";

	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
	} 
	
	$sql .= " group by emp_id ";
	
	
	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$zid[$row['emp_id']] = $row['ward_id'];
			$sid[$row['emp_id']] = $row['street_id'];
			$data[$row['emp_id']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$emp_ids = array();

	$sql1 = "select COUNT(DISTINCT g.grievance_id) as count1,ward_id,street_id,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, 
				  ".$_SESSION['grievances_trns']." gt where 
				 g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
				 gt.disposal_status!='5' and g.cat3_id !='0'  ";

	if ($fdate != '' && $tdate != '') {

		$sql1 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		$sql1 .= "group by gt.emp_id,gt.disposal_status";
	}



	if ($rs1 = mysqli_query($conn, $sql1)) {
		while ($row = mysqli_fetch_assoc($rs1)) {

			//print_r($row['emp_id']);
			$znid[$row['emp_id']] = $row['ward_id'];
			$stid[$row['emp_id']] = $row['street_id'];
			if ($row['emp_id'] > 0 || $row['emp_id'] != '') {
				$emp_ids[$row['emp_id']] = $row['emp_id'];
			} else {
				$row['emp_id'] = 0;
				$emp_ids[$row['emp_id']] = $row['emp_id'];
			}




			if ($row['disposal_status'] == 4) {
				$data_list[$row['emp_id']]['unresolved'] = $row['count1'];
				$tot['unresolved'] += $row['count1'];
			}
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));



	$sql21 = "select COUNT(DISTINCT g.grievance_id) as count1,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, ".$_SESSION['grievances_trns']." gt where 
			g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.sla_status='1' and
			gt.disposal_status IN ('3','9','8')  and grievance_status_id IN('3','9','8')  ";


	$sql21 = "SELECT count(DISTINCT g.grievance_id) as count1,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
			app_type_id='1' and grievance_status_id IN('3','9','8') and grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' ";



	if ($fdate != '' && $tdate != '') {

		$sql21 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		$sql21 .= "group by gt.emp_id,gt.disposal_status";
	}



	$rs21 = mysqli_query($conn, $sql21);
	while ($row = mysqli_fetch_assoc($rs21)) {
		$data_list[$row['emp_id']]['completed'] += $row['count1'];
		$tot['completed'] += $row['count1'];
	}


	$sql2 = "SELECT count(DISTINCT gt.grievance_id) as count2,emp_id  FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
    				 app_type_id='1' and grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5' ";


	if ($fdate != '' && $tdate != '') {

		$sql2 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		$sql2 .= "group by gt.emp_id";
	}

	//echo $sql2;

	$rs2 = mysqli_query($conn, $sql2);
	while ($row = mysqli_fetch_assoc($rs2)) {
		$data_list[$row['emp_id']]['completed_be_sla'] += $row['count2'];
		$tot['completed_be_sla'] += $row['count2'];
	}


	$sql31 = "SELECT count(DISTINCT g.grievance_id) as count1,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
    				 app_type_id='1' and grievance_status_id IN('2') and 
				 gt.disposal_status IN('2') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' ";


	if ($fdate != '' && $tdate != '') {

		$sql31 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		$sql31 .= "group by gt.emp_id,gt.disposal_status";
	}

	// echo $sql31;   

	$rs31 = mysqli_query($conn, $sql31);
	while ($row = mysqli_fetch_assoc($rs31)) {
		$data_list[$row['emp_id']]['pending'] += $row['count1'];
		$tot['pending'] += $row['count1'];
	}


	$sql3 = "select COUNT(DISTINCT g.grievance_id) as count2,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, ".$_SESSION['grievances_trns']." gt where 
				 g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
				 gt.disposal_status!='5' and g.cat3_id !='0' and gt.dept_id='" . $_REQUEST['dept_id'] . "' and gt.disposal_status IN ('2') and grievance_status_id IN('2') and g.sla_status='2' ";


	$sql3 = "SELECT count(DISTINCT g.grievance_id) as count2,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
    				 app_type_id='1' and grievance_status_id IN('2') and gt.disposal_status IN ('2') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5' ";



	if ($fdate != '' && $tdate != '') {

		$sql3 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		$sql3 .= "group by gt.emp_id,gt.disposal_status";
	}

	$rs3 = mysqli_query($conn, $sql3);
	while ($row = mysqli_fetch_assoc($rs3)) {
		$data_list[$row['emp_id']]['pending_be_sla'] += $row['count2'];
		$tot['pending_be_sla'] += $row['count2'];
	}

	// reopened


	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('13')  and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' ";



	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id";
	} else {
		$sql .= "group by gt.emp_id";
	}

	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopened'] += $row['count'];
		$tot['reopened'] += $row['count'];
	}

	// reopened under progress

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and gt.disposal_status IN('11') and g.grievance_status_id IN('11') and ulbid='" . $_SESSION['ulbid'] . "' ";


	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id";
	} else {
		$sql .= "group by gt.emp_id";
	}
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopened_pending'] += $row['count'];
		$tot['reopened_pending'] += $row['count'];
		//$data_list[$row['emp_dept']]['reopened_pending']=10;
	}


	// reopened Completed

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and g.grievance_status_id IN ('12') and g.grievance_status_id IN('12') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status NOT IN('5','9') ";


	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id";
	} else {
		$sql .= "group by gt.emp_id";
	}
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopened_completed'] += $row['count'];
		$tot['reopened_completed'] += $row['count'];
		//$data_list[$row['emp_dept']]['reopened_pending']=10;
	}


	// rejected

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN ('10') and g.grievance_status_id IN ('10') and gt.disposal_status!='5'  and ulbid='" . $_SESSION['ulbid'] . "' ";


	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id";
	} else {
		$sql .= "group by gt.emp_id";
	}

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_dept']]['rejected'] += $row['count'];
			$tot['rejected'] += $row['count'];
		}
	}

	// Financial implications

	$sql3 = "select COUNT(g.grievance_id) as count,emp_id as emp_dept from grievances g, ".$_SESSION['grievances_trns']." gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
			 and g.grievance_status_id IN ('6') and g.grievance_status_id IN ('6') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' ";



	if ($fdate != '' && $tdate != '') {

		$sql3 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id";
	} else {
		$sql3 .= "group by gt.emp_id";
	}
	// echo $sql3;

	if ($rs = mysqli_query($conn, $sql3)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_dept']]['fin'] += $row['count'];
			$tot['fin'] += $row['count'];
		}
	}





	// print_r($emp_ids);

	//06-03-24 $sql="select emp_id,emp_name,emp_dept from emp_mst where emp_id IN ('".implode("','",$emp_ids)."')"; 
	$sql = "select emp_id,emp_name,emp_dept from emp_mst where emp_id IN ('" . implode("','", $emp_ids) . "') and emp_name like '%" . $emp_name . "%'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$emp_dept_list[$row['emp_id']] = $row['emp_dept'];
			$zone_ids[$row['emp_id']] = $row['ward_id'];
			//$street_ids[$row['emp_id']]=$row['street_id'];
		}
	}


	//06-03-24 $sql="select emp_id,emp_name from emp_mst_od where emp_id IN ('".implode("','",$emp_ids)."')";
	$sql = "select emp_id,emp_name from emp_mst_od where emp_id IN ('" . implode("','", $emp_ids) . "') and emp_name like '%" . $emp_name . "%'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$zone_ids[$row['emp_id']] = $row['ward_id'];
			//$street_ids[$row['emp_id']]=$row['street_id'];
		}
	}

	//07-03-24  $sql="select * from emp_map e , ward_mst w, street_mst s where e.ward_id=w.ward_id and e.street_id = e.street_id and emp_id IN ('".implode("','",$emp_ids)."')";
	$sql = "select * from emp_map e , ward_mst w, street_mst s where e.ward_id=w.ward_id and e.street_id = e.street_id and emp_id IN ('" . implode("','", $emp_ids) . "') and emp_name like '%" . $emp_name . "%'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {

			$zone_ids[$row['emp_id']] = $row['ward_desc'];
			$street_ids[$row['emp_id']] = $row['street_desc'];
		}
	}
	$sql = "select * from   ward_mst w, street_mst s where w.ward_id=s.ward_id ";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {

			$zone_ids1[$row['ward_id']] = $row['ward_desc'];
			$street_ids1[$row['street_id']] = $row['street_desc'];
		}
	}
	//  echo "<pre>";
	// print_r($street_ids1); 



	$sql = "select * from dept_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
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

	//print_r($zid);
	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('online_applications', $online_applications);

	mysqli_close($conn);



	$tpl->assign('emp_dept_list', $emp_dept_list);
	$tpl->assign('zone_ids', $zone_ids);
	$tpl->assign('zone_ids1', $zone_ids1);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('street_ids', $street_ids);
	$tpl->assign('street_ids1', $street_ids1);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet', '3' => 'Both'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('zid', $zid);
	$tpl->assign('sid', $sid);

	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);

	$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
	$tpl->assign('emp_name', $_REQUEST['emp_name']);
	$tpl->assign('dept_id1', $_REQUEST['dept_id']);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('data_list', $data_list);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('all_empwise_report.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
