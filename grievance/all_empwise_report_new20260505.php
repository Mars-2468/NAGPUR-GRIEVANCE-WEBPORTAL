<?php
require "config.php";
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
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

	$aptid1 = $_REQUEST['aptid'];

	$emp_name = $_REQUEST['emp_name'];

	$status1 = $_REQUEST['status'];

	$ulbid1 = $_SESSION['ulbid'];

	$user_type1 = $_SESSION['user_type'];

	$sla1 = $_REQUEST['sla'];

	$_REQUEST['app_type_id'] = 1;

	$threshold_date='2024-09-01';//$_SESSION['threshold_date'];
	
//	echo "<pre>";print_r($_SESSION);echo "</pre>";die();
		
	$fdate =!empty($_POST['f_date'])? date('Y-m-d', strtotime($_POST['f_date'])):'';
	$tdate =!empty($_POST['t_date'])? date('Y-m-d', strtotime($_POST['t_date'])):'';	
	$tpl->assign('fdate',$fdate);
	$tpl->assign('tdate',$tdate);

	if ($user_type1 == 'U') {
	 	$sql = "select COUNT(DISTINCT g.grievance_id) as count,gt.emp_id,g.ward_id,g.street_id,g.date_regd from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id 
		and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) and g.cat3_id !='0' ";
	} else {
		$sql = "select COUNT(DISTINCT g.grievance_id) as count,gt.emp_id,ward_id,street_id,g.date_regd from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id 
		and gt.emp_id='" . $_SESSION['emp_id'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) and g.cat3_id !='0'";
	}
	
	 if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	} 
	
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	}
	
		
		$sql .= " group by gt.emp_id ";
	

	$tot['received']=0;

	if ($rs = mysqli_query($conn, $sql)) {		
		while ($row = mysqli_fetch_assoc($rs)) {
			$zid[$row['emp_id']] = $row['ward_id'];
			$sid[$row['emp_id']] = $row['street_id'];
			$data_list[$row['emp_id']]['received'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$emp_ids = array();
	
//echo "<pre>";print_r($sql);echo "</pre>";die();	
	
//Unresolved	

	if ($user_type1 == 'U') {
		$sql1 = "select COUNT(DISTINCT g.grievance_id) as count1,ward_id,street_id,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and g.cat3_id !='0'";
	} else {
		$sql1 = "select COUNT(DISTINCT g.grievance_id) as count1,ward_id,street_id,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and g.cat3_id !='0'";
	}
	
	

	if ($fdate != '' && $tdate != '') {

		$sql1 .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status ";
	} else {
		$sql1 .= " group by gt.emp_id,gt.disposal_status ";
	}

	if ($rs1 = mysqli_query($conn, $sql1)) {
		while ($row = mysqli_fetch_assoc($rs1)) {
			//print_r($row['emp_id']);
			$znid[$row['emp_id']] = $row['ward_id'];
			$stid[$row['emp_id']] = $row['street_id'];
			if ($row['emp_id'] != '') {
				$emp_ids[$row['emp_id']] = $row['emp_id'];
			}
			if ($row['disposal_status'] == 4) {
				$data_list[$row['emp_id']]['unresolved'] = $row['count1'];
				$tot['unresolved'] += $row['count1'];
			}
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

//echo "<pre>";print_r($emp_ids);echo "</pre>";die();	

//completed 

	//within sla

	if ($user_type1 == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(3,8,9)  and cat3_id !='0' and g.sla_status='1' ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and app_type_id='1' and g.grievance_status_id IN(3,8,9)  and cat3_id !='0' and g.sla_status='1'  ";
	}

	if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	}
	
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	} 
			
	$sql .= " group by gt.emp_id ";
	
	$tot['completed_within_sla']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_id']]['completed_within_sla'] = $row['count'];
		$tot['completed_within_sla'] += $row['count'];
	}
	
	//beyond sla
	
	
	if ($user_type1 == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(3,8,9)  and cat3_id !='0' and g.sla_status='2' ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and app_type_id='1' and g.grievance_status_id IN(3,8,9)  and cat3_id !='0' and g.sla_status='2'  ";
	}

	if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	} 
	
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	} 
		
		
		$sql .= " group by gt.emp_id ";
	
	$tot['completed_beyond_sla']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_id']]['completed_beyond_sla'] = $row['count'];
		$tot['completed_beyond_sla'] += $row['count'];
	}
		
//Financial implecations
	
	
	if ($user_type1 == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(6)  and cat3_id !='0' ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and app_type_id='1' and g.grievance_status_id IN(6)  and cat3_id !='0' ";
	}

	if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	} 
	
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	} 
		
		
		$sql .= " group by gt.emp_id ";
	
	$tot['financial_implications']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_id']]['financial_implications'] = $row['count'];
		$tot['financial_implications'] += $row['count'];
	}
	
	
	//echo "<pre>";print_r($tot);echo "</pre>";die();
	
	
//pending	

	//within sla
	
	if ($user_type1 == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and cat3_id !='0' and g.sla_status='1' ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and cat3_id !='0' and g.sla_status='1' ";
	}

	if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	} 
	
	if ($fdate != '' && $tdate != '') {

		$sql31 .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	} else {
		$sql31 .= " group by gt.emp_id ";
	}
	
	$tot['pending_within_sla']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_id']]['pending_within_sla'] = $row['count'];
		$tot['pending_within_sla'] += $row['count'];
	}
	
	//beyound sla
	
	if ($user_type1 == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and cat3_id !='0' and g.sla_status='2' ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and cat3_id !='0' and g.sla_status='2'  ";
	}

	if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	} 
	
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	} 
		
		
		$sql .= " group by gt.emp_id ";
	
	$tot['pending_beyond_sla']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_id']]['pending_beyond_sla'] = $row['count'];
		$tot['pending_beyond_sla'] += $row['count'];
	}
		
//Reopened		
	
	if ($user_type1 == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and grievance_status_id IN(13) and cat3_id !='0' and gt.disposal_status IN(13) ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and app_type_id='1' and grievance_status_id IN(13) and cat3_id !='0' and gt.disposal_status IN(13) ";
	}

	if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	} 
	
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	} 
		
		
		$sql .= " group by gt.emp_id ";
		
	$tot['reopened']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_id']]['reopened'] = $row['count'];
		$tot['reopened'] += $row['count'];
	}
			
//Reopened completed		
	
	if ($user_type1 == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and grievance_status_id IN(12) and disposal_status IN(12) and cat3_id !='0' ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and app_type_id='1' and grievance_status_id IN(12) and disposal_status IN(12) and cat3_id !='0' ";
	}

	if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	} 
	
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	} 
		
		
		$sql .= " group by gt.emp_id ";
	
	$tot['reopened_completed']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_id']]['reopened_completed'] = $row['count'];
		$tot['reopened_completed'] += $row['count'];
	}

//Reopened under progress		
	
	if ($user_type1 == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and grievance_status_id IN(11) and disposal_status IN(11) and cat3_id !='0' ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and app_type_id='1' and grievance_status_id IN(11) and disposal_status IN(11) and cat3_id !='0' ";
	}

	if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	} 
	
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	} 
		
		
		$sql .= " group by gt.emp_id ";
	
	
	$tot['reopened_underprogress']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_id']]['reopened_underprogress'] = $row['count'];
		$tot['reopened_underprogress'] += $row['count'];
	}
	
//Transfered
	
	if ($user_type1 == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(5,10) and cat3_id !='0' ";
	} else {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and gt.emp_id='" . $_SESSION['emp_id'] . "' and app_type_id='1' and g.grievance_status_id IN(5,10) and cat3_id !='0' ";
	}

	 if (!empty($threshold_date)) {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') >= '" . $threshold_date . "' ";
	} 
	
	if ($fdate != '' && $tdate != '') {
		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $fdate . "' and '" . $tdate . "' ";
	} 
		
		
		$sql .= " group by gt.emp_id ";
	
	$tot['transfered']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_id']]['transfered'] = $row['count'];
		$tot['transfered'] += $row['count'];
	}
	
	
	
	
	
	// print_r($emp_ids);

	//05-03-24 $sql="select emp_id,emp_name,emp_dept from emp_mst where emp_id IN ('".implode("','",$emp_ids)."')";

	if ($user_type1 == 'U') {
		$sql = "select emp_id,emp_name,emp_dept from emp_mst where emp_id IN ('" . implode("','", $emp_ids) . "')  ";
	} else {
		$sql = "select emp_id,emp_name,emp_dept from emp_mst where emp_id IN ('" . $_SESSION['emp_id'] . "') ";
	}
	
	if(!empty($emp_name)){
		
		$sql.=" and emp_name like '%" . $emp_name . "%' order by emp_name asc ";
	}else{
		$sql.=" order by emp_name asc ";
	}
		
	
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$emp_dept_list[$row['emp_id']] = $row['emp_dept'];
			$zone_ids[$row['emp_id']] = $row['ward_id'];
			//$street_ids[$row['emp_id']]=$row['street_id'];
		}
	}
	//05-03-24 $sql="select emp_id,emp_name from emp_mst_od where emp_id IN ('".implode("','",$emp_ids)."')";
	
	//echo "<pre>";print_r($sql);echo "</pre>";die();

	if ($user_type1 == 'U') {
		$sql = "select emp_id,emp_name from emp_mst_od where emp_id IN ('" . implode("','", $emp_ids) . "') ";
	} else {
		$sql = "select emp_id,emp_name from emp_mst_od where emp_id IN ('" . $_SESSION['emp_id'] . "') ";
	}
	
	if(!empty($emp_name)){
		
		$sql.=" and emp_name like '%" . $emp_name . "%' order by emp_name asc ";
	}else{
		$sql.=" order by emp_name asc ";
	}
		
		
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$zone_ids[$row['emp_id']] = $row['ward_id'];
			//$street_ids[$row['emp_id']]=$row['street_id'];
		}
	}

// echo "<pre>"; print_r($emp_list);  echo "</pre>";die();
 
	if ($user_type1 == 'U') {
		$sql = "select * from emp_map e , ward_mst w, street_mst s where e.ward_id=w.ward_id and e.street_id = e.street_id and emp_id IN ('" . implode("','", $emp_ids) . "')";
	} else {
		$sql = "select * from emp_map e , ward_mst w, street_mst s where e.ward_id=w.ward_id and e.street_id = e.street_id and emp_id IN ('" . $_SESSION['emp_id'] . "')";
	}
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {

			$zone_ids[$row['emp_id']] = $row['ward_desc'];
			$street_ids[$row['emp_id']] = $row['street_desc'];
		}
	}
	$sql = "select * from ward_mst w, street_mst s where w.ward_id=s.ward_id ";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {

			$zone_ids1[$row['ward_id']] = $row['ward_desc'];
			$street_ids1[$row['street_id']] = $row['street_desc'];
		}
	}
	
	

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



	$sqls="SELECT combined.emp_id, combined.emp_code, combined.emp_name, combined.emp_name_marathi, combined.emp_dept, combined.emp_sub_dept, combined.emp_desg, combined.emp_mobile, combined.ulbid, combined.pincode, combined.mobile, combined.delete_status, combined.emp_status, combined.od_status FROM (SELECT * FROM emp_mst UNION ALL SELECT * FROM emp_mst_od) AS combined where combined.emp_id IN ('" . implode("','", $emp_ids) . "') and combined.emp_name like '%" . $emp_name . "%'";


 	if ($rs = mysqli_query($conn, $sqls)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emps_list[$row['emp_id']] = $row['emp_name'];
			$zones_ids[$row['emp_id']] = $row['ward_id'];
			//$street_ids[$row['emp_id']]=$row['street_id'];
		}
	} 

//echo "<pre>";print_r($fields_data);echo "</pre>";die();

	mysqli_close($conn);

	foreach($emp_list as $key=>$value){
	
		$emp_details_list[$key]['emp_id']=$key;
		$emp_details_list[$key]['emp_name']=ucwords(trim($emp_list[$key])," ");
		$emp_details_list[$key]['dept_name']=ucwords(trim($dept_list[$emp_dept_list[$key]])," ");
		$emp_details_list[$key]['zone_ids']=ucwords(trim($zone_ids1[$zid[$key]])," ");
		$emp_details_list[$key]['street_ids']=ucwords(trim($street_ids1[$sid[$key]])," ");
		
		$emp_details_list[$key]['received']=$data_list[$key]['received'];
		$emp_details_list_total['received']+=$data_list[$key]['received'];
		
		$emp_details_list[$key]['pending_within_sla']=$data_list[$key]['pending_within_sla'];
		$emp_details_list_total['pending_within_sla']+=$data_list[$key]['pending_within_sla'];
		
		$emp_details_list[$key]['pending_beyond_sla']=$data_list[$key]['pending_beyond_sla'];
		$emp_details_list_total['pending_beyond_sla']+=$data_list[$key]['pending_beyond_sla'];
		
		$emp_details_list[$key]['completed_within_sla']=$data_list[$key]['completed_within_sla'];
		$emp_details_list_total['completed_within_sla']+=$data_list[$key]['completed_within_sla'];
		
		$emp_details_list[$key]['completed_beyond_sla']=$data_list[$key]['completed_beyond_sla'];
		$emp_details_list_total['completed_beyond_sla']+=$data_list[$key]['completed_beyond_sla'];
		
		$emp_details_list[$key]['reopened']=$data_list[$key]['reopened'];
		$emp_details_list_total['reopened']+=$data_list[$key]['reopened'];
		
		$emp_details_list[$key]['reopened_completed']=$data_list[$key]['reopened_completed'];
		$emp_details_list_total['reopened_completed']+=$data_list[$key]['reopened_completed'];
		
		$emp_details_list[$key]['reopened_underprogress']=$data_list[$key]['reopened_underprogress'];
		$emp_details_list_total['reopened_underprogress']+=$data_list[$key]['reopened_underprogress'];
		
		$emp_details_list[$key]['financial_implications']=$data_list[$key]['financial_implications'];
		$emp_details_list_total['financial_implications']+=$data_list[$key]['financial_implications'];
		
		$emp_details_list[$key]['transfered']=$data_list[$key]['transfered'];
		$emp_details_list_total['transfered']+=$data_list[$key]['transfered'];
		
	}
	

//echo "<pre>";print_r($_GET['column']);echo "</pre>";die();


/* $sort_column = $_GET['column'] ?? 'dept_id'; // Default column
$sort_order = $_GET['order'] ?? 'asc'; // Default order

//echo "<pre>";print_r($sort_order);echo "</pre>";die();

// Flip the order for the next click
$next_order = ($sort_order === 'asc') ? 'desc' : 'asc';

// Sort the array based on the selected column and order
usort($emp_details_list, function ($a, $b) use ($sort_column, $sort_order) {
    if ($sort_order === 'asc') {
        return $a[$sort_column] <=> $b[$sort_column];
    } else {
        return $b[$sort_column] <=> $a[$sort_column];
    }
});
 */

/* foreach($emp_details_list as $row){

echo "<pre>";print_r($emp_details_list);echo "</pre>";
}die(); */

	$tpl->assign('next_order', $next_order);
	$tpl->assign('emp_details_list', $emp_details_list);
	$tpl->assign('emp_details_list_total', $emp_details_list_total);
	
	
	
	$tpl->assign('emp_dept_list', $emp_dept_list);
	$tpl->assign('zone_ids', $zone_ids);
	$tpl->assign('zone_ids1', $zone_ids1);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('street_ids', $street_ids);
	$tpl->assign('street_ids1', $street_ids1);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet', '3' => 'Both'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('tot', $tot);
	$tpl->assign('zid', $zid);
	$tpl->assign('sid', $sid);
	$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
	$tpl->assign('emp_name', $_REQUEST['emp_name']);
	$tpl->assign('dept_id1', $_REQUEST['dept_id']);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('status_list', $status_list);
	$tpl->assign('data_list', $data_list);
	$tpl->assign('data', $data);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('all_empwise_report_new.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
