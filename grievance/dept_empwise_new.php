<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

$user_type = $_SESSION['user_type'];
$emp_name = $_REQUEST['emp_name'];
$dept_id = $_REQUEST['dept_id'];

if (isset($_GET['active'])) {
	$active_class = $_GET['active'];
}

if (isset($_SESSION['uid'])) {
	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
		//$tpl->assign('fdate', date('Y-m-d', strtotime($_REQUEST['f_date'])));
		//$tpl->assign('tdate', date('Y-m-d', strtotime($_REQUEST['t_date'])));
	}

	if ($user_type == 'U') {
		/*18-03-24 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,emp_id,ward_id,street_id,g.date_regd FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.dept_id = '" . $_REQUEST['dept_id'] . "' and gt.disposal_status IN(2,9,8,4,6,10) 
		and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and app_type_id='1' and cat3_id !='0'";*/
		
		/*08-07-2024 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,emp_id,dept_id,ward_id,street_id,g.date_regd FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.dept_id = '" . $_REQUEST['dept_id'] . "' and gt.disposal_status IN(2,9,8,4,6,10) and app_type_id='1' and cat3_id !='0'";*/
		
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept,dept_id,ward_id,street_id,g.date_regd FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.dept_id = '" . $_REQUEST['dept_id'] . "' and gt.disposal_status != 5 and cat3_id !='0'";
	} else {
		/*08-07-2024 $sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,emp_id,ward_id,street_id,g.date_regd from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and g.cat3_id !='0' and gt.dept_id='" . $_REQUEST['dept_id'] . "'";*/
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,emp_id,ward_id,street_id,g.date_regd from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!= 5 and g.cat3_id !='0' and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	}

	/*$sql ="select COUNT(DISTINCT gt.grievance_id) as count,emp_id,ward_id,street_id,g.date_regd from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
		g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and g.cat3_id !='0' and 
		gt.dept_id='".$_REQUEST['dept_id']."'";*/
	
	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id";
	} else {
		//$sql.=" group by gt.emp_id";
		$sql .= " group by emp_dept";
	}
	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {


		while ($row = mysqli_fetch_assoc($rs)) {
			$zid[$row['emp_dept']] = $row['ward_id'];
			$sid[$row['emp_dept']] = $row['street_id'];
			$data[$row['emp_dept']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$emp_ids = array();
	/*08-07-2024 if ($_SESSION['ulbid'] == '3') {
		$sql1 = "select COUNT(DISTINCT g.grievance_id) as count1,emp_id,ward_id,street_id,disposal_status,g.date_regd,g.sla_status from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and g.cat3_id !='0' and gt.dept_id='" . $_REQUEST['dept_id'] . "' ";
	} else {*/
		$sql1 = "select COUNT(DISTINCT g.grievance_id) as count1,ward_id,street_id,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and g.cat3_id !='0' and gt.dept_id='" . $_REQUEST['dept_id'] . "' ";
	//08-07-2024 }
	if ($fdate != '' && $tdate != '') {

		$sql1 .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		$sql1 .= " group by gt.emp_id,gt.disposal_status";
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

			/*
		     if($row['disposal_status']==2)
			    {
			         $data_list[$row['emp_id']]['pending']+=$row['count1'];
			         $tot['pending']+=$row['count1'];
			    }
			    
			    */
		}

		//print_r($emp_ids); 
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	/*08-07-2024 if ($_SESSION['ulbid'] == '3') {
		$sql21 = "select COUNT(DISTINCT g.grievance_id) as count1,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.sla_status='1' and
		gt.disposal_status IN ('3','9','8')  and (is_reopened_yn='0' or is_reopened_yn is NULL) ";
	} else {*/

		/*$sql21 ="select COUNT(DISTINCT g.grievance_id) as count1,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and 
		gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."'  and g.sla_status='1' and
		gt.disposal_status IN ('3','9','8')  and grievance_status_id IN('3','9','8')  ";*/

		/*18-03-24 $sql21 = "SELECT count(DISTINCT g.grievance_id) as count1,emp_id,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'";*/

		$sql21 = "SELECT count(DISTINCT g.grievance_id) as count1,emp_id as emp_dept,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
		
	//08-07-2024 }
	if ($fdate != '' && $tdate != '') {

		$sql21 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		$sql21.="group by emp_dept";
	}
	//echo $sql21;


	$rs21 = mysqli_query($conn, $sql21);
	while ($row = mysqli_fetch_assoc($rs21)) {
		$data_list[$row['emp_dept']]['completed'] += $row['count1'];
		$tot['completed'] += $row['count1'];
	}


		/*08-07-2024 if ($_SESSION['ulbid'] == '3') {
			$sql2 = "select COUNT(DISTINCT g.grievance_id) as count2,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and g.cat3_id !='0' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.sla_status='2'
			and gt.disposal_status IN ('3','9','8')  and gt.disposal_status IN('3','9','8') ";
		} else {*/
			$sql2 = "SELECT count(DISTINCT gt.grievance_id) as count2,emp_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
			app_type_id='1' and grievance_status_id IN('3','9','8') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
		//08-07-2024 }

	if ($fdate != '' && $tdate != '') {

		$sql2 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		$sql2 .= " group by emp_dept";
	}

	//echo $sql2;

	$rs2 = mysqli_query($conn, $sql2);
	while ($row = mysqli_fetch_assoc($rs2)) {
		$data_list[$row['emp_dept']]['completed_be_sla'] += $row['count2'];
		$tot['completed_be_sla'] += $row['count2'];
	}



	/*08-07-2024 if ($_SESSION['ulbid'] == '3') {
		$sql31 = "select COUNT(DISTINCT g.grievance_id) as count1,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, 
		grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and g.cat3_id !='0' and gt.dept_id='" . $_REQUEST['dept_id'] . "' and 
		gt.disposal_status IN('2') and grievance_status_id IN('2') and g.sla_status IN (1) ";
	} else {*/

		/*$sql31 ="select COUNT(DISTINCT g.grievance_id) as count1,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, 
		grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and 
		gt.disposal_status!='5' and g.cat3_id !='0' and gt.dept_id='".$_REQUEST['dept_id']."' and 
		gt.disposal_status IN('2')  and g.sla_status IN (1) ";*/

		$sql31 = "SELECT count(DISTINCT g.grievance_id) as count1,emp_id as emp_dept,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	//08-07-2024}

	if ($fdate != '' && $tdate != '') {

		$sql31 .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		//$sql31 .= " group by gt.emp_id,gt.disposal_status";
		$sql31 .= " group by emp_dept";
	}

	// echo $sql31;   

	$rs31 = mysqli_query($conn, $sql31);
	while ($row = mysqli_fetch_assoc($rs31)) {
		$data_list[$row['emp_dept']]['pending'] += $row['count1'];
		$tot['pending'] += $row['count1'];
	}


	/*08-07-2024 if ($_SESSION['ulbid'] == '3') {
		$sql3 = "select COUNT(DISTINCT g.grievance_id) as count2,emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and g.cat3_id !='0' and gt.dept_id='" . $_REQUEST['dept_id'] . "' and gt.disposal_status IN ('2')  and g.sla_status='2' ";
	} else {*/
		$sql3 = "select COUNT(DISTINCT g.grievance_id) as count2,emp_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and g.cat3_id !='0' and gt.dept_id='" . $_REQUEST['dept_id'] . "' and grievance_status_id IN('2') and g.sla_status='2' ";

		//$sql3="SELECT count(DISTINCT g.grievance_id) as count2,emp_id,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
		//app_type_id='1' and grievance_status_id IN('2') and gt.disposal_status IN ('2') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."'"; 
	//08-07-2024 }
	if ($fdate != '' && $tdate != '') {

		$sql3 .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id,gt.disposal_status";
	} else {
		$sql3 .= " group by emp_dept";
	}

	$rs3 = mysqli_query($conn, $sql3);
	while ($row = mysqli_fetch_assoc($rs3)) {
		$data_list[$row['emp_dept']]['pending_be_sla'] += $row['count2'];
		$tot['pending_be_sla'] += $row['count2'];
	}

	// reopened

	/*08-07-2024 if ($_SESSION['ulbid'] == '3') {
		$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('13')  and g.grievance_status_id IN('13') and ulbid IN('208','210') and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	} else {*/
		$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status!= 5 and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	//08-07-2024 }


	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by gt.emp_id";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_dept";
	} else {
		//$sql.="group by gt.emp_id";
		$sql .= "group by emp_dept";
	}

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopened'] += $row['count'];
		$tot['reopened'] += $row['count'];
	}
	//echo $sql;

	// reopened under progress
	/*08-07-2024 if ($_SESSION['ulbid'] == '3') {
		$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and gt.disposal_status IN('11') and g.grievance_status_id IN('11') and ulbid IN('208','210') and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	} else {*/
		//08-07-2024 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status !=5 and g.grievance_status_id IN('11') and ulbid='" . $_SESSION['ulbid'] . "' and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
		$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('11') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!=5 and dept_id='" . $_REQUEST['dept_id'] . "'";
	//08-07-2024 }

	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by gt.emp_id";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_dept";
	} else {
		//$sql.="group by gt.emp_id";
		$sql .= "group by emp_dept";
	}

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		/*08-07-2024 $data_list[$row['emp_dept']]['reopened_pending'] += $row['count'];
		$tot['reopened_pending'] += $row['count'];*/
		//$data_list[$row['emp_dept']]['reopened_pending']=10;
		$data_list[$row['emp_dept']][$row['grievance_status_id']]['reopened_pending'] += $row['count'];
		$tot[$row['grievance_status_id']]['reopened_pending'] += $row['count'];
		$i += $row['count'];
	}
	//echo $sql;


	// reopened Completed
	/*08-07-2024if ($_SESSION['ulbid'] == '3') {
		$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and g.grievance_status_id IN ('12') and g.grievance_status_id IN('12') and ulbid IN('208','210') and gt.disposal_status NOT IN('5','9') and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	} else {*/
		// $sql ="select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and g.grievance_status_id IN ('12') and g.grievance_status_id IN('12') and ulbid='".$_SESSION['ulbid']."' and gt.disposal_status NOT IN('5','9') and gt.dept_id='".$_REQUEST['dept_id']."'";
		//08-07-2024 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status IN('9') and gt.dept_id='" . $_REQUEST['dept_id'] . "'";

		$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status IN ('12') and dept_id='" . $_REQUEST['dept_id'] . "'";
	//08-07-2024 }

	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id";
	} else {
		$sql .= "group by emp_dept";
	}
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopened_completed'] += $row['count'];
		$tot['reopened_completed'] += $row['count'];
		//$data_list[$row['emp_dept']]['reopened_pending']=10;
	}


	// rejected
	/*08-07-2024 if ($_SESSION['ulbid'] == '3') {
		$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN ('10') and g.grievance_status_id IN ('10') and gt.disposal_status!='5'  and ulbid IN('208','210') and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	} else {*/
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status!=5 and g.grievance_status_id IN ('10') and gt.disposal_status!='5'  and ulbid='" . $_SESSION['ulbid'] . "' and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	//08-07-2024 }

	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id";
	} else {
		$sql .= "group by emp_dept";
	}

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_dept']]['rejected'] += $row['count'];
			$tot['rejected'] += $row['count'];
		}
	}

	// Financial implications

	/*08-07-2024 if ($_SESSION['ulbid'] == '3') {
		$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN ('6') and gt.disposal_status!='5'  and ulbid IN('208','210') and gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	} else {*/
		$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('6') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' and dept_id='" . $_REQUEST['dept_id'] . "'";
		//$sql ="select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN ('6') and gt.disposal_status!='5'  and ulbid='".$_SESSION['ulbid']."' and gt.dept_id='".$_REQUEST['dept_id']."'";
	//08-07-2024 }

	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by gt.emp_id";
	} else {
		$sql .= "group by emp_dept";
	}
	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_dept']]['fin'] += $row['count'];
			$tot['fin'] += $row['count'];
		}
	}





	// print_r($emp_ids);

	//07-03-24 $sql="select emp_id,emp_name,emp_dept from emp_mst where emp_id IN ('".implode("','",$emp_ids)."')"; 
	$sql = "select emp_id,emp_name,emp_dept from emp_mst where emp_id IN ('" . implode("','", $emp_ids) . "') and emp_name like '%" . $emp_name . "%'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$emp_dept_list[$row['emp_id']] = $row['emp_dept'];
			$zone_ids[$row['emp_id']] = $row['ward_id'];
			//$street_ids[$row['emp_id']]=$row['street_id'];
		}
	}


	//07-03-24 $sql="select emp_id,emp_name from emp_mst_od where emp_id IN ('".implode("','",$emp_ids)."')";
	$sql = "select emp_id,emp_name from emp_mst_od where emp_id IN ('" . implode("','", $emp_ids) . "') and emp_name like '%" . $emp_name . "%'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$emp_list[$row['emp_id']] = $row['emp_name'];
			$zone_ids[$row['emp_id']] = $row['ward_id'];
			//$street_ids[$row['emp_id']]=$row['street_id'];
		}
	}

	$sql = "select * from emp_map e , ward_mst w, street_mst s where e.ward_id=w.ward_id and e.street_id = e.street_id and emp_id IN ('" . implode("','", $emp_ids) . "')";
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
	$tpl->assign('tot', $tot);
	$tpl->assign('zid', $zid);
	$tpl->assign('sid', $sid);
	$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('emp_name', $_REQUEST['emp_name']);
	$tpl->assign('dept_id1', $_REQUEST['dept_id']);
	$tpl->assign('ulb', $_SESSION['ulbid']);
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

	$tpl->assign('users_count', $users_count);
	//	print_r($online_applications);
	
	$tpl->assign('active_class', $active_class);

	$tpl->display('dept_empwise_new.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
