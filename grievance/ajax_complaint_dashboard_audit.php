<style>
	.myshadow {
		-webkit-box-shadow: 2px 5px 16px 7px rgba(102, 102, 102, 0.5);
		-moz-box-shadow: 2px 5px 16px 7px rgba(102, 102, 102, 0.5);
		box-shadow: 2px 5px 16px 7px rgba(102, 102, 102, 0.5);
		border-radius: 10px;
		overflow: hidden;
	}
</style>


<?php


//$start_time = hrtime(true);

	require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors', 0);
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	$mergedulbs = 900;
	


	$emplist = join("','", $_SESSION['emp_list']);

	//$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:date('Y');
	$selectedYear = $_SESSION['filteryear'];
	$selectedDesg = $_SESSION['filterdesg'];
	$selectedDept = $_SESSION['employee_dept'];
	$selectedDesgnation = $_SESSION['employee_desg'];
	$response = "";
//echo "<pre>";print_r($selectedDept);echo "</pre>";die();
	// Total received

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";

	} else if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {

			$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and app_type_id='1' and cat3_id !='0' ";

		} else {

			if ($selectedYear) {				

				$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1' and g.grievance_status_id IN(2,3,6,8,9,11,12) and gt.disposal_status IN(2,3,6,8,9,11,12) and g.cat3_id!='0' AND YEAR(g.date_regd) = '" . $selectedYear . "'";

			} else {

				$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g, grievances_transactions gt where  g.grievance_id=gt.grievance_id and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1' and g.grievance_status_id IN(2,3,6,8,9,11,12,13) and gt.disposal_status IN(2,3,6,8,9,11,12,13) and g.cat3_id!='0' ";

			}
		}

	} else if ($_SESSION['user_type'] == 'E') {

		if ($selectedYear) { 

			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,g.app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id IN(2,3,6,8,9,11,12) and gt.disposal_status IN(2,3,6,8,9,11,12) and g.app_type_id='1' and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  and g.cat3_id!='0' AND YEAR(date_regd) = '" . $selectedYear . "'";

		} else {

			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,g.app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN(2,3,6,8,9,11,12) and g.grievance_status_id IN(2,3,6,8,9,11,12) and g.app_type_id='1' and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.cat3_id!='0' ";

		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */
		
	} else if ($_SESSION['user_type'] == 'R') {
	
		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'M') {
	
		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances where app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}
	
	
//echo "<pre>";print_r($sql);echo "</pre>";die();
	//echo $sql;
// TotalReceived

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['app_type_id']]['total_received'] = $row['count'];
	}
	$esc_total = 0;

	if ($_SESSION['user_type'] == 'E') {
		$esc_rs = mysqli_query($conn, $esc_sql);
		while ($row2 = mysqli_fetch_assoc($esc_rs)) {
			$esc_total = $data[$row['app_type_id']]['total_received'] + $row2['count'];
		}
	}


	if ($data[1]['total_received'] == '') {
		$data[1]['total_received'] = 0;
	}

	//Daily Received Grievances

	$date = date('Y-m-d');

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances where DATE(date_regd) = '" . $date . "' and app_type_id='1' and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
	
			$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances where DATE(date_regd) = '" . $date . "' and ulbid IN('208','210') and app_type_id='1' and cat3_id !='0' ";

		} else {
			
			if ($selectedYear) {
			
				$sql = "SELECT COUNT(DISTINCT grievance_id) AS count,app_type_id FROM grievances WHERE DATE(date_regd) = '" . $date . "' and ulbid='" . strip_tags($_SESSION['ulbid']) . "' and app_type_id='1' and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			
			} else {
			
				$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances where DATE(date_regd) = '" . $date . "' and ulbid='" . strip_tags($_SESSION['ulbid']) . "' and app_type_id='1' and cat3_id !='0' ";
		
			}
		}
		
	} else if ($_SESSION['user_type'] == 'E') {

		if ($selectedYear) {

			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,app_type_id FROM grievances_transactions gt,grievances g where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";

		} else {

			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,app_type_id FROM grievances_transactions gt,grievances g where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0'";

		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */


	} else if ($_SESSION['user_type'] == 'R') {
		
		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances g,ulbmst u ,Districtmst d where DATE(date_regd) = '" . $date . "' and g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'M') {
		
		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances where DATE(date_regd) = '" . $date . "' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}

	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data[$row['app_type_id']]['daily_received'] = $row['count'];
	}
	$esc_total = 0;

	if ($_SESSION['user_type'] == 'E') {
		$esc_rs = mysqli_query($conn, $esc_sql);
		while ($row2 = mysqli_fetch_assoc($esc_rs)) {
			$esc_total = $data[$row['app_type_id']]['daily_received'] + $row2['count'];
		}
	}


	if ($data[1]['daily_received'] == '') {
		$data[1]['daily_received'] = 0;
	}


	//Transferred complaints
	
	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'U') {

		if ($selectedYear) {
			
			$sql = "SELECT COUNT(DISTINCT grievance_id) AS count,app_type_id FROM grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . strip_tags($_SESSION['ulbid']) . "' and app_type_id='1' and gt.disposal_status =5 and g.grievance_status_id =5  and cat3_id !='0' and gt.is_escalated='1' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		} else {
			
			$sql = "SELECT count(DISTINCT(gt.grievance_id)) as count,app_type_id FROM grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . strip_tags($_SESSION['ulbid']) . "' and app_type_id='1' and gt.disposal_status =5 and g.grievance_status_id =5  and cat3_id !='0' and gt.is_escalated='1'";
		
		}
		
	} else if ($_SESSION['user_type'] == 'E') {

		if ($selectedYear) {
			
			$sql = "SELECT  count(DISTINCT(g.grievance_id)) as count,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status =5 and g.grievance_status_id =5  and gt.is_escalated='1' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		} else {
		
			$sql = "SELECT  count(DISTINCT(g.grievance_id)) as count,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "')   and gt.is_escalated='1'";
		
		}
		
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */


		
		
		
	} else if ($_SESSION['user_type'] == 'R') {

		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'M') {
		
		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data[$row['app_type_id']]['total_transferred'] = $row['count'];
	
	}

// TotalTransferred

	if ($data[1]['total_transferred'] == '') {
		$data[1]['total_transferred'] = 0;
	}
	
	//echo "<pre>";print_r($sql);echo "</pre>";die();
	
	// Resolved with in sla

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' ";
	} else if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances where ulbid IN('208','210') and 
			app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
		} else {

			if ($selectedYear) {
					
				$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and 
				g.app_type_id='1' and g.grievance_status_id IN(3,6,8,9,12) and gt.disposal_status IN(3,6,8,9,12) and g.sla_status=1 and g.cat3_id!='0' AND YEAR(g.date_regd) = '" . $selectedYear . "'";
			
			} else {
				
			
				$sql = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and 
				g.app_type_id='1' and g.grievance_status_id IN(3,6,8,9,12) and gt.disposal_status IN(3,6,8,9,12) and g.sla_status=1  and g.cat3_id!='0'";

			}
		}
	} else if ($_SESSION['user_type'] == 'E') {

		if ($selectedYear) {
			
			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN('3','6','8','9','12') and app_type_id='1' and g.grievance_status_id IN('3','6','8','9','12') and g.sla_status=1 and gt.is_escalated=0 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		} else {
			
			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN('3','6','8','9','12') and app_type_id='1' and g.grievance_status_id IN('3','6','8','9','12') and g.sla_status=1 and gt.is_escalated=0 and cat3_id !='0'";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */



	} else if ($_SESSION['user_type'] == 'R') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and disposal_status IN('3','8','9') and sla_status=1 and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'M') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}

// ResolvedWithinSla

//echo "<pre>";print_r($sql);echo "</pre>";die();

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data[$row['app_type_id']]['resolved_within_sla'] = $row['count'];
		
	}

	if ($data[1]['resolved_within_sla'] == '') {
		$data[1]['resolved_within_sla'] = 0;
	}
	
	//echo"<pre>";print_r($sql);echo"</pre>";die();
	
	
	// Resolved beyond sla

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances where app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
	} else if ($_SESSION['user_type'] == 'U') {

		if ($selectedYear) {
			
			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,g.app_type_id FROM grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and 
			g.app_type_id='1' and g.grievance_status_id IN('3','6','8','9','12') and gt.disposal_status IN('3','6','8','9','12') and g.sla_status=2 and g.cat3_id !='0' AND YEAR(g.date_regd) = '" . $selectedYear . "'";
		
		} else {
			
			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,g.app_type_id FROM grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and 
			g.app_type_id='1' and g.grievance_status_id IN('3','6','8','9','12') and gt.disposal_status IN('3','6','8','9','12') and g.sla_status=2 and g.cat3_id !='0'";
		
		}
	} else if ($_SESSION['user_type'] == 'E') {

		if ($selectedYear) {
			
			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,g.app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status IN('3','6','8','9','12') and g.app_type_id='1' and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.grievance_status_id IN('3','6','8','9','12') and g.sla_status=2 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		} else {
	
			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count, g.app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status IN('3','6','8','9','12') and g.grievance_status_id IN('3','6','8','9','12') and g.sla_status=2 and ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1' and cat3_id !='0' ";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */

		
	} else if ($_SESSION['user_type'] == 'R') {

		$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,g.app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and disposal_status IN('3','8','9') and sla_status=2 and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'M') {

		$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,g.app_type_id FROM grievances where app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}

//	echo"<pre>";print_r($sql);echo"</pre>";die();
// ResolvedBeyondSla

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data[$row['app_type_id']]['resolved_beyond_sla'] = $row['count'];
	
	}

	if ($data[1]['resolved_beyond_sla'] == '') {
		$data[1]['resolved_beyond_sla'] = 0;
	}

//echo"<pre>";print_r($data[1]['resolved_beyond_sla']);echo"</pre>";die();
	// under progress with in sla

	if ($_SESSION['user_type'] == 'A') {
		
		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'U') {
		
		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			
			$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where ulbid IN('208','210') and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
		
		} else {
			
			if ($selectedYear) {
				
				$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1' and g.grievance_status_id IN('2','11') and gt.disposal_status IN('2','11') and g.sla_status=1 and g.cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			
			} else {
				
				$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1' and g.grievance_status_id IN('2','11') and gt.disposal_status IN('2','11') and g.sla_status=1 and g.cat3_id !='0'";
			
			}
			
		}
		
	} else if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN('2','11') and g.grievance_status_id IN('2','11') and g.app_type_id='1' and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.sla_status=1 and cat3_id !='0' and (gt.is_reopened_yn='0' || gt.is_reopened_yn is null)  AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		} else {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN('2','11') and g.grievance_status_id IN('2','11') and g.app_type_id='1' and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.sla_status=1 and cat3_id !='0' and (gt.is_reopened_yn='0' || gt.is_reopened_yn is null) ";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */



	} else if ($_SESSION['user_type'] == 'R') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'M') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}
	
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['under_progress_with_sla'] = $row['count'];
	
	}
	
	if ($data[1]['under_progress_with_sla'] == '') {
		$data[1]['under_progress_with_sla'] = 0;
	} 

	//echo"<pre>";print_r($sql);echo"</pre>";die();
	//echo"<pre>";print_r($data[1]['under_progress_with_sla']);echo"</pre>";die();

	// under progress beyond sla

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'U') {
		
		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			
			$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances where ulbid IN('208','210') and 
			app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
		
		} else {
			
			if ($selectedYear) {
				
				$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
				g.app_type_id='1' and grievance_status_id IN('2','11') and gt.disposal_status IN('2','11') and g.sla_status=2 and g.cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			
			} else {
				
				$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
				g.app_type_id='1' and grievance_status_id IN('2','11') and gt.disposal_status IN('2','11') and g.sla_status=2 and g.cat3_id !='0'";
			
			}
		}
		
	} else if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and emp_id IN('" . $emplist . "') and app_type_id='1' and g.grievance_status_id IN('2','11') and sla_status=2 and gt.disposal_status IN('2','11') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		} else {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and emp_id IN('" . $emplist . "') and app_type_id='1' and g.grievance_status_id IN('2','11') and sla_status=2 and gt.disposal_status IN('2','11') and cat3_id !='0' ";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */


		
	} else if ($_SESSION['user_type'] == 'R') {
		
		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
	
	}
	if ($_SESSION['user_type'] == 'M') {
		
		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0' IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['under_progress_beyond_sla'] = $row['count'];
	
	}
	
	if ($data[1]['under_progress_beyond_sla'] == '') {
		
		$data[1]['under_progress_beyond_sla'] = 0;
	
	}

	//echo"<pre>";print_r($data[1]['under_progress_beyond_sla']);echo"</pre>";die();
	
	/********pending Approval**********/

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as pendingforapproval,app_type_id from grievances where grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
	}
	if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			
			$sql = "SELECT count(grievance_id) as pendingforapproval,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
		
		} else {
			
			if ($selectedYear) {
				
				$sql = "SELECT count(grievance_id) as pendingforapproval,app_type_id from grievances where 
				ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='1' and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			
			} else {
				
				$sql = "SELECT count(grievance_id) as pendingforapproval,app_type_id from grievances where 
				ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
			
			}
		}
	}

	if ($_SESSION['user_type'] == 'R') {

		$sql = "SELECT count(grievance_id) as pendingforapproval,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='1' and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0'";
	}
	if ($_SESSION['user_type'] == 'M') {

		$sql = "SELECT count(grievance_id) as pendingforapproval,app_type_id from grievances  where  grievance_status_id='1' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	}

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['pendingforapproval'] = $row['pendingforapproval'];
	
	}


	if ($data[1]['pendingforapproval'] == '') {
		
		$data[1]['pendingforapproval'] = 0;
		
	}

	//echo"<pre>";print_r($data[1]['pendingforapproval']);echo"</pre>";die();

	
	/********Financial implications**********/

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as fin,app_type_id from grievances where  grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
	}
	if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			
			$sql = "SELECT count(grievance_id) as fin,app_type_id from grievances where 
			ulbid IN('208','210') and grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
		
		} else {
			
			if ($selectedYear) {

				$sql = "SELECT COUNT(g.grievance_id) as fin,g.app_type_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.cat3_id !='0' and g.app_type_id='1' 
				and g.grievance_status_id IN ('6') and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status=6 AND YEAR(date_regd) = '" . $selectedYear . "' ";
			
			} else {

				$sql = "SELECT COUNT(g.grievance_id) as fin,g.app_type_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.cat3_id !='0' and g.app_type_id='1' 
				and g.grievance_status_id IN ('6') and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status=6 ";
			
			}
		}
	}
	if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as fin,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id='6' and app_type_id='1' and gt.disposal_status =6 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		} else {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as fin,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id='6' and app_type_id='1' and gt.disposal_status =6 and cat3_id !='0'";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */


	}

	if ($_SESSION['user_type'] == 'R') {

		$sql = "SELECT count(grievance_id) as fin,app_type_id from grievances g,ulbmst u,Districtmst d where  g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='6' and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0'";
	}
	if ($_SESSION['user_type'] == 'M') {

		$sql = "SELECT count(grievance_id) as fin,app_type_id from grievances where  grievance_status_id='6' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	}

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['fin'] = $row['fin'];
		
	}

	if ($data[1]['fin'] == '') {
		$data[1]['fin'] = 0;
	}

	// Un-Resolved

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as unresolved,app_type_id from grievances where grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
	}
	if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			
			$sql = "SELECT count(grievance_id) as unresolved,app_type_id from grievances where ulbid IN('208','210') and grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
		
		} else {
			
			if ($selectedYear) {
				
				$sql = "SELECT count(grievance_id) as unresolved,app_type_id from grievances where ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='4' and app_type_id='1' and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			
			} else {
				
				$sql = "SELECT count(grievance_id) as unresolved,app_type_id from grievances where ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
			
			}
		}
	}
	
	if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as unresolved,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id='4' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		} else {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as unresolved,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id='4' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */


	}

	if ($_SESSION['user_type'] == 'R') {

		$sql = "SELECT count(grievance_id) as unresolved,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='4' and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0'";
	
	}
	if ($_SESSION['user_type'] == 'M') {

		$sql = "SELECT count(grievance_id) as unresolved,app_type_id from grievances where grievance_status_id='4' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['unresolved'] = $row['unresolved'];
		
	}

	if ($data[1]['unresolved'] == '') {
		
		$data[1]['unresolved'] = 0;
		
	}

	// Rejected 

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as rejected,app_type_id from grievances where grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
	
	}
	
	if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			
			$sql = "SELECT count(grievance_id) as rejected,app_type_id from grievances where ulbid IN('208','210') and grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
		
		} else {
			
			if ($selectedYear) {
				
				$sql = "SELECT count(grievance_id) as rejected,app_type_id from grievances where ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='10' and app_type_id='1' and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			
			} else {
				
				$sql = "SELECT count(grievance_id) as rejected,app_type_id from grievances where ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
			
			}
		}
	}
	
	if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as rejected,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id='10' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		} else {
			
			$sql = "SELECT count(DISTINCT g.grievance_id) as rejected,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id='10' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */


	}

	if ($_SESSION['user_type'] == 'R') {

		$sql = "SELECT count(grievance_id) as rejected,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='10' and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0'";
	
	}
	
	if ($_SESSION['user_type'] == 'M') {

		$sql = "SELECT count(grievance_id) as rejected,app_type_id from grievances where grievance_status_id='10' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['rejected'] = $row['rejected'];
	
	}

	if ($data[1]['rejected'] == '') {
		
		$data[1]['rejected'] = 0;
		
	}

	// re-opened applicatons 

	if ($_SESSION['user_type'] == 'A') {

		$sql3 = "SELECT count(grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13') group by app_type_id,grievance_status_id";
	} else if ($_SESSION['user_type'] == 'U') {

		if ($selectedYear) {
			
			$sql111213 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id, gt.disposal_status from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('13','11','12') and gt.disposal_status IN('13','11','12') AND YEAR(date_regd) = '" . $selectedYear . "' ";
			
			$sql13 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id, gt.disposal_status from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('13') and gt.disposal_status IN('13') AND YEAR(date_regd) = '" . $selectedYear . "' ";
			
			$sql12 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('12') and gt.disposal_status IN('13') AND YEAR(date_regd) = '" . $selectedYear . "' ";
			
			$sql11 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('11') and gt.disposal_status IN('13') AND YEAR(date_regd) = '" . $selectedYear . "' ";
		
			$sqlTr = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status IN(5,10) and g.grievance_status_id IN(5,10) AND YEAR(date_regd) = '" . $selectedYear . "' group by app_type_id";
			
			//$sqlTr = "Select count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,(SELECT * FROM grievances_transactions gi WHERE transaction_id = ( SELECT MAX(t.transaction_id) FROM grievances_transactions t WHERE t.grievance_id = gi.grievance_id ) )gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('5','10') and g.grievance_status_id IN('5','10') and g.cat3_id!=0 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1' AND YEAR(date_regd) = '" . $selectedYear . "'";
			
			$sqlEsc ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  and `is_escalated` = 1 AND YEAR(date_regd) = '" . $selectedYear . "' ";

		
		} else {
					
			$sql111213 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id,gt.disposal_status from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('13','11','12') and gt.disposal_status IN('13','11','12') ";
			
			$sql13 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id,gt.disposal_status from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('13') ";
			
			$sql12 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('12') ";
			
			$sql11 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('11') ";
			
			//$sqlTr = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status IN(5,10) and g.grievance_status_id IN(5,10) group by app_type_id";
			
			$sqlTr = "Select count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,(SELECT * FROM grievances_transactions gi WHERE transaction_id = ( SELECT MAX(t.transaction_id) FROM grievances_transactions t WHERE t.grievance_id = gi.grievance_id ) )gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('5','10') and g.cat3_id!=0 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1' ";
			
			$sqlEsc ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  and `is_escalated` = 1  ";

		}
		
	} else if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			$sql111213 = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id,gt.disposal_status from grievances g,cs_mst c,ulbmst u ,grievances_transactions gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and c.cs_id=ccm.cs_id and ccm.cs_id=ss.cs_id and emp_id IN('" . $emplist . "') and gt.disposal_status IN('13','11','12') and g.grievance_status_id IN('13','11','12') AND YEAR(date_regd) = '" . $selectedYear . "' and g.app_type_id=1 ";
			
			$sql13 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id,gt.disposal_status from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status IN('13') and g.grievance_status_id IN('13') AND YEAR(date_regd) = '" . $selectedYear . "' and g.app_type_id=1 and ulbid='" . strip_tags($_SESSION['ulbid']) . "' ";
			
			$sql12 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id,gt.disposal_status from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status =12 and g.grievance_status_id =12 and gt.emp_id IN('" . $emplist . "') AND YEAR(date_regd) = '" . $selectedYear . "' and g.app_type_id=1 and ulbid='" . strip_tags($_SESSION['ulbid']) . "'  ";
			
			$sql11 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id,gt.disposal_status from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status =11 and g.grievance_status_id =11 and gt.emp_id IN('" . $emplist . "') AND YEAR(date_regd) = '" . $selectedYear . "' and g.app_type_id=1 and ulbid='" . strip_tags($_SESSION['ulbid']) . "' ";
			
			//$sqlTr = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id,gt.disposal_status from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and and gt.disposal_status IN(5,10) and g.grievance_status_id IN(5,10) and gt.emp_id IN('" . $emplist . "') AND YEAR(date_regd) = '" . $selectedYear . "' g.app_type_id=1 and ulbid='" . strip_tags($_SESSION['ulbid']) . "' group by app_type_id";
		
			$sqlTr = "Select count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,(SELECT * FROM grievances_transactions gi WHERE transaction_id = ( SELECT MAX(t.transaction_id) FROM grievances_transactions t WHERE t.grievance_id = gi.grievance_id ) )gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('5','10') and g.grievance_status_id IN('5','10') and gt.emp_id IN('" . $emplist . "') and g.cat3_id!=0 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1' AND YEAR(date_regd) = '" . $selectedYear . "'";
			
			$sqlEsc ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  and `is_escalated` = 1 AND YEAR(date_regd) = '" . $selectedYear . "' ";

		} else {
				$sql111213 = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id,gt.disposal_status from grievances g,cs_mst c,ulbmst u ,grievances_transactions gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and c.cs_id=ccm.cs_id and ccm.cs_id=ss.cs_id and emp_id IN('" . $emplist . "') and gt.disposal_status IN('13','11','12') and g.grievance_status_id IN('13','11','12') and g.app_type_id=1 ";
		
			//$sql111213 = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status IN('13','11','12') and g.grievance_status_id IN('13','11','12') and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  ";
			
			$sql13 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status IN('13') and g.grievance_status_id IN('13') and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  ";
			
			$sql12 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status =12 and g.grievance_status_id =12 and gt.emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  ";
			
			$sql11 = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status =11 and g.grievance_status_id =11 and gt.emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  ";
			
			//$sqlTr = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN(5,10) and g.grievance_status_id IN(5,10) and gt.emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  group by app_type_id";
		
			$sqlTr = "Select count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,(SELECT * FROM grievances_transactions gi WHERE transaction_id = ( SELECT MAX(t.transaction_id) FROM grievances_transactions t WHERE t.grievance_id = gi.grievance_id ) )gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('5','10') and g.grievance_status_id IN('5','10') and gt.emp_id IN('" . $emplist . "') and g.cat3_id!=0 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1'";
			
			
			$sqlEsc ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  and `is_escalated` = 1 ";

	
			//echo "<pre>";print_r($sqlTr);echo "</pre>";die();

		}
		
		/*if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		 if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */


		
	} else if ($_SESSION['user_type'] == 'R') {
		
			$sql3 = "SELECT count(gt.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0' and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
			
			$sql4 = "SELECT count(g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0' and gt.disposal_status IN('11','12')  group by app_type_id, grievance_status_id";
	
	}

	if ($_SESSION['user_type'] == 'M') {

			$sql3 = "SELECT count(DISTINCT grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13')  group by app_type_id,grievance_status_id";
		
	}
	
	
	
	if ($selectedDept) { 		
		$sql111213 .= "  and gt.dept_id = '".$selectedDept."' ";

		$sql13 .= " and gt.dept_id = '".$selectedDept."' ";

		$sql12 .= "  and gt.dept_id = '".$selectedDept."' ";

		$sql11 .= "  and gt.dept_id = '".$selectedDept."' ";
		$sqlTr .= "  and gt.dept_id = '".$selectedDept."' ";
		$sqlEsc .= "  and gt.dept_id = '".$selectedDept."' ";
	}

	$sql111213 .= "  group by app_type_id ";

	$sql13 .= " group by app_type_id ";

	$sql12 .= "  group by app_type_id ";

	$sql11 .= "  group by app_type_id ";

	
	
	//echo $sql111213;


//echo "<pre>";print_r($sqlTr);echo "</pre>";die();

	$rs = mysqli_query($conn, $sql111213);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$reopened_completed_tot[$row['app_type_id']][111213]['count'] = $row['count'];
	
	}

	if ($reopened_completed_tot[1][111213]['count'] == '') {
		
		$reopened_completed_tot[1][111213]['count'] = 0;
	
	}

//echo"<pre>";print_r($sqlTr);echo"</pre>";die();
	//echo $sql13;
	
	$rs = mysqli_query($conn, $sql13);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$reopened_completed_tot[$row['app_type_id']][13]['count'] = $row['count'];
	
	}

	if ($reopened_completed_tot[1][13]['count'] == '') {
		
		$reopened_completed_tot[1][13]['count'] = 0;
	
	}


	//echo $sql11;

	$rs = mysqli_query($conn, $sql11);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$reopened_completed_tot[$row['app_type_id']][11]['count'] = $row['count'];
	
	}
	if ($reopened_completed_tot[1][11]['count'] == '') {
		
		$reopened_completed_tot[1][11]['count'] = 0;
	
	}

	//echo $sql12;
	
	$rs = mysqli_query($conn, $sql12);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$reopened_completed_tot[$row['app_type_id']][12]['count'] = $row['count'];
	
	}
	
	if ($reopened_completed_tot[1]['12']['count'] == '') {
		
		$reopened_completed_tot[1]['12']['count'] = 0;
	
	}
	
	$rs = mysqli_query($conn, $sqlTr);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$reopened_completed_tot[$row['app_type_id']]['Transfered']['count'] = $row['count'];
	
	}
	
	if ($reopened_completed_tot[1]['Transfered']['count'] == '') {
		
		$reopened_completed_tot[1]['Transfered']['count'] = 0;
	
	}
	
	$rs = mysqli_query($conn, $sqlEsc);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$reopened_completed_tot[$row['app_type_id']]['Escalated']['count'] = $row['count'];
	
	}
	
	if ($reopened_completed_tot[1]['Escalated']['count'] == '') {
		
		$reopened_completed_tot[1]['Escalated']['count'] = 0;
	
	}




	if ($_SESSION['user_type'] == 'U') {

		if ($selectedYear) {
			
			
			$sqlLogs ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  and `is_escalated` = 1 AND YEAR(date_regd) = '" . $selectedYear . "' ";

		
		} else {
					
				
			$sqlLogs ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `audit_trails` g, cs_mst c, category_mst cm , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  and `is_escalated` = 1  ";

		}
		
	} else if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			
			$sqlLogs ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  and `is_escalated` = 1 AND YEAR(date_regd) = '" . $selectedYear . "' ";

		} else {
			
				
			$sqlLogs ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "'  and `is_escalated` = 1 ";

	
		}
		
	
	}

	$rs = mysqli_query($conn, $sqlLogs);
	
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$user_logs[$row['user_id']]['count'] = $row['count'];
	
	}
	
	if ($user_logs[$row['user_id']]['count'] == '') {
		
		$user_logs[$row['user_id']]['count'] = 0;
	
	}
	

	$sql="SELECT edm.dept_id, d.dept_desc FROM `emp_desg_map` edm,dept_mst d where edm.dept_id=d.dept_id and edm.emp_id=".$_SESSION['emp_id'];

	$rs = mysqli_query($conn, $sql);
	
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$user_dept_list[$row['dept_id']] = $row['dept_desc'];
	
	}

	$sql="SELECT edm.dept_id,edm.desg_id, d.desg_desc,dp.dept_desc FROM `emp_desg_map` edm,desg_mst d,dept_mst dp where edm.desg_id=d.desg_id and edm.dept_id=dp.dept_id and edm.emp_id=".$_SESSION['emp_id'];
	
	$rs = mysqli_query($conn, $sql);
	$field_info = mysqli_fetch_fields($rs);
	while ($row = mysqli_fetch_assoc($rs)) {
		$dept_desg_id=$row['dept_id'].':'.$row['desg_id'];		
		$employee_dept_desg_list[$dept_desg_id]=$row['dept_desc'].' - '.$row['desg_desc'];		
		//foreach ($field_info as $fi => $f)
			//$user_dept_desg_list[$row['desg_id']][$f->name] = $row[$f->name];
	}
	
	//echo "<pre>";print_r($_SESSION);echo "</pre>";die();


	?>

	<div class="boxed">
		<!-- Title Bart Start -->
		<!-- <h4>Total Number of Complaints</h4>-->
		<div class="bash_heading row m-b20">
			<div class="" style="display: flex;justify-content: space-between;align-items: center;">
				<!--11-07-2024 <div>Total Number Of Grievances</div> -->
				<div><?php if ($_SESSION['user_type'] == 'U'){ ?>
					TOTAL NUMBER OF <span style="color: red;">GRIEVANCES</span>
				<?php } else if($_SESSION['user_type'] == 'E'){ ?>
					TOTAL NUMBER OF 
					<?php 
						$user_name = $_SESSION['user_name'];
						$user_name_uppercase = strtoupper($user_name);
						echo '<span style="color: red;">' . htmlspecialchars($user_name_uppercase) . '</span>';
					?> 
					DASHBOARD
				<?php }else{?>
					TOTAL NUMBER OF <span style="color: red;">GRIEVANCES</span>
				<?php }
				?>
				</div>
				<div>
					<style>
					.form-control2 {
							display: block;
							height: 34px;
							padding: 6px 12px;
							font-size: 14px;
							line-height: 1.42857143;
							color: #555;
							background-color: #fff;
							background-image: none;
							border: 1px solid #ccc;
							border-radius: 4px;
							-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
							box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
							-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
							-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
							transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
						}
					</style>
					<div class="d-flex align-items-center ms-2" style="display: flex; justify-content: space-between; align-items: center;">
						
						<?php if($_SESSION['user_type']=='E'){ ?>
						
							<h6 id="designationLabel" style="padding-right: 10px;">Designation:</h6>
							<select id="designationSelect" name="designation" class="form-control2" style="width:auto !important;" onchange="getSelectedDesignation()">
								<option value="0">-All Designations-</option>							
								<?php foreach($employee_dept_desg_list as $key=>$value){ ?>
								<?php if($key){ ?>
								<option value="<?php echo $key ?>" <?php if ($selectedDesg == $key) echo 'selected'; ?>> <?php echo $value; ?></option>
								<?php }else{ ?>
								<option value="<?php echo $key ?>"> <?php echo $value; ?></option>
								<?php }
								} ?>
							</select>
							<input type="hidden" id="designationSelectHidden" name="designation" value="" />
						
						<?php } ?>
						
						&nbsp;&nbsp;&nbsp;
						
							<h6 id="yearLabel" style="padding-right: 10px;">Year:</h6>
							<select id="yearSelect" name="year" class="form-control" onchange="getSelectedYear()">
								<option value="0">-All Report-</option>
								<option value="2024" <?php if ($selectedYear == '2024') echo 'selected'; ?>>2024</option>
								<option value="2023" <?php if ($selectedYear == '2023') echo 'selected'; ?>>2023</option>
							</select>
							<input type="hidden" id="yearSelectHidden" name="year" value="" />						
						
					</div>
				</div>
			</div>
		</div>

		<!-- Title Bart End -->
		<div id="dashData">

			<div class="row dashboard-stats">
				<!-- <div class="col-md-4 col-sm-6"> -->
				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-success">
							<!---<i class="fa fa-cloud-download text-large stat-icon "></i>-->
							<br>
							<i class="fa fa-check-circle text-large stat-icon "></i>

						</div>
						<div class="panel-right panel-icon bg-reverse">
							<!--<p class="size-h1 no-margin countdown_first"><a href="services.php?aptid=1&status=0&user_type={$user_type}&sla=0">{$data[1].total_received}</a></p>-->
							<p class="size-h1 no-margin countdown_first">
								<?php								
							$total_grievance_recieved=23959;//$data[1]['total_received']
								if ($_SESSION['user_type'] == 'U') {

									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-clmn'>" . $total_grievance_recieved . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
								
									echo "<a href='tot_received.php?aptid=1&status=0&sla=0&user_type=" . $_SESSION['user_type'] . "' >" . $data[1]['total_received'] . "</a>";
								
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='cdma_ulbwise_report.php?status=0&app_type_id=1&name=" . $_SESSION['uid'] . "' >" . $data[1]['total_received'] . "</a>";
									
									} else {

										echo "<a href='cdma_ulbwise_report.php?status=0&app_type_id=1&name=" . $_SESSION['uid'] . "' >" . $data[1]['total_received'] . "</a>";
									
									}
								}
								?>
							</p>
							<p class="text-muted no-margin"><span style="color:#000;">Received</span></p>
						</div>
					</section>
				</div>

				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-instagram">
							<br>
							<i class="fa fa-thumbs-up text-large stat-icon "></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">
							
								<?php 
								
								$daily_received = $data[1]['daily_received'];
								
								if ($_SESSION['user_type'] == 'U') {
									
									echo "<a href='tot_received.php?aptid=1&status=111&sla=0&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['daily_received'] . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=111&sla=0&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['daily_received'] . "</a>";
								
								} else {
									
									echo $data[1]['daily_received'];
								
								}
								?>
								
							</p>
							<p class="text-muted no-margin" style="color: #000;">
								<span style="color:#000;">Today's Received</span>
								<br>
								<span style="color:red;font-size: 9px;">(Do not Add Received Block)</span>
								<br>
								(<?php echo number_format($daily_received / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>
				<?php //echo $total_resolved;
				?>

				<!-- <div class="col-md-4 col-sm-6"> -->
				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-info">
							<br>
							<i class="fa text-large stat-icon "><img src="images/Beyond-icon.png" /></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
						
							<p class="size-h1 no-margin countdown_first">

								<?php 
									$total_grievance_resolved=20346;

									$total_resolved = $data[1]['resolved_within_sla'] + $data[1]['resolved_beyond_sla'] ;
									$total_under_progress = $data[1]['under_progress_beyond_sla'] + $data[1]['under_progress_with_sla'] ;

								if ($_SESSION['user_type'] == 'U') {

									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-totresolved' >" . $total_grievance_resolved . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=100&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $total_resolved . "</a>";
								
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $total_resolved . "</a>";
									
									} else {
										
										echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $total_resolved . "</a>";
									
									}
								}
								
								?>
							<p class="text-muted no-margin"><span style="color:#000;">Total Resolved</span><br>
								(<?php echo number_format($total_resolved / $data[1]['total_received'] * 100, 2); ?> % )
							</p>
						</div>
					</section>
				</div>

				<!-- <div class="col-md-4 col-sm-6"> -->
				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-vimeo">
							<br>
							<i class="fa text-large stat-icon"><img src="images/under-pro.png" /></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=2&sla=2&user_type={$user_type}">{$data[1].pending_be_sla}</a></p>-->
							<p class="size-h1 no-margin countdown_first">

								<?php
						
								$total_grievance_underprogress=309;//$total_under_progress

								if ($_SESSION['user_type'] == 'U') {
	
									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-totpending'>" . $total_grievance_underprogress . "</a>";

								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=200&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $total_under_progress . "</a>";
								
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $total_under_progress . "</a>";
									
									} else {
										
										echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $total_under_progress . "</a>";
									
									}
								}
								
								?>
							</p>
							<p class="text-muted no-margin"><span style="color:#000;">Total Under Progress</span><br>
								(<?php echo number_format($total_grievance_underprogress / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>

				<!-- <div class="col-md-4 col-sm-6"> -->
				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-success">
							<br>
							<i class="fa fa-inr text-large stat-icon "></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">
								<?php 
								$total_grievance_fin_impl=355;//$data[1]['fin']
								if ($_SESSION['user_type'] == 'U') {
							
									echo "<a href='tot_received.php?aptid=1&status=6&user_type=" . $_SESSION['user_type'] . "'>" . $total_grievance_fin_impl . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=6&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['fin'] . "</a>";
								
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['fin'] . "</a>";
									
									} else {
										
										echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['fin'] . "</a>";
									
									}
								}
								
								?>
							</p>
							
							<p class="text-muted no-margin "><span style="color:#000;">Total Resolved (Financial Implications)</span>
							</p>
						</div>
					</section>
				</div>


			
				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-lovender">
							<br>
							<i class="fa fa-check-circle text-large stat-icon "></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">

								<?php 
								
								$total_grievance_resolved_within_sla=15872;//$data[1]['resolved_within_sla'];

								if ($_SESSION['user_type'] == 'U') {

									echo "<a href='rep_comp_dept_abs_comp.php?active=rwsla-clmn' >" . $total_grievance_resolved_within_sla . "</a>";

								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=2&sla=1&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['resolved_within_sla'] . "</a>";
								
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='cdma_ulbwise_report.php?status=2&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['resolved_within_sla'] . "</a>";
									
									} else {
										
										echo "<a href='cdma_ulbwise_report.php?status=2&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['resolved_within_sla'] . "</a>";
									
									}
								}

								?>

							</p>
							<p class="text-muted no-margin"><span style="color:#000;">Completed within SLA</span><br>
								(<?php echo number_format($total_grievance_resolved_within_sla / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>


				<!-- <div class="col-md-4 col-sm-6"> -->
				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-info">
							<br>
							<i class="fa text-large stat-icon "><img src="images/Beyond-icon.png" /></i>

						</div>
						<div class="panel-right panel-icon bg-reverse">
							
							<p class="size-h1 no-margin countdown_first">

								<?php 
								
								$total_grievance_resolved_beyond_sla=4474;//$data[1]['resolved_beyond_sla']

								if ($_SESSION['user_type'] == 'U') {


									echo "<a href='rep_comp_dept_abs_comp.php?active=rdbsla-clmn' >" . $total_grievance_resolved_beyond_sla . "</a>";



									//echo "<a href='tot_received.php?aptid=1&status=2&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_beyond_sla']."</a>";
								} else if ($_SESSION['user_type'] == 'E') {
									echo "<a href='tot_received.php?aptid=1&status=2&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['resolved_beyond_sla'] . "</a>";
								} else {
									if ($_SESSION['user_type'] == 'M') {
										echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['resolved_beyond_sla'] . "</a>";
									} else {
										echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['resolved_beyond_sla'] . "</a>";
									}
								}
								?>
							</p>
							<p class="text-muted no-margin"><span style="color:#000;">Completed Beyond SLA</span><br>
								(<?php echo number_format($total_grievance_resolved_beyond_sla / $data[1]['total_received'] * 100, 2); ?> % )
							</p>
							
						</div>
					</section>
				</div>

				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-instagram">
							<br>
							<i class="fa fa-refresh text-large stat-icon "></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">

								<?php 
								$total_grievance_underprogress_within_sla=255;//$data[1]['under_progress_with_sla']
								if ($_SESSION['user_type'] == 'U') {

									echo "<a href='rep_comp_dept_abs_comp.php?active=pwsla-clmn' >" . $total_grievance_underprogress_within_sla . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=3&sla=1&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['under_progress_with_sla'] . "</a>";
								
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='cdma_ulbwise_report.php?status=4&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['under_progress_with_sla'] . "</a>";
									
									} else {
										
										echo "<a href='cdma_ulbwise_report.php?status=4&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['under_progress_with_sla'] . "</a>";
									
									}
									
								}
								
								?>
							</p>
							<p class="text-muted no-margin"><span style="color:#000;">Under Progress Within SLA</span><br>
								(<?php echo number_format($total_grievance_underprogress_within_sla / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>

			
				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-vimeo">
							<br>
							<i class="fa text-large stat-icon"><img src="images/under-pro.png" /></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">

								<?php 
								$total_grievance_underprogress_beyond_sla=54;//$data[1]['under_progress_beyond_sla']
								if ($_SESSION['user_type'] == 'U') {
							
									echo "<a href='rep_comp_dept_abs_comp.php?active=pdbsla-clmn'>" . $total_grievance_underprogress_beyond_sla . "</a>";

								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=3&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['under_progress_beyond_sla'] . "</a>";
								
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['under_progress_beyond_sla'] . "</a>";
									
									} else {
										
										echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['under_progress_beyond_sla'] . "</a>";
									
									}
								
								}
								
								?>
							</p>
							<p class="text-muted no-margin"><span style="color:#000;">Under Progress Beyond SLA</span><br>
								(<?php echo number_format($total_grievance_underprogress_beyond_sla / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>

				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-danger">
							<br>
							<i class="fa fa-folder text-large stat-icon "></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">

								<?php 
								$total_grievance_reopened=2944;//$reopened_completed_tot[1][111213]['count']
								if ($_SESSION['user_type'] == 'U') {
									
									echo "<a href='street_complaints.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=005&dept_id=32&f_date=&t_date='>" . $total_grievance_reopened . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
									
									if ($reopened_completed_tot[1][111213]['count'] > 0) {
											
										echo "<a href='tot_received.php?aptid=1&status=005&&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][111213]['count'] . "</a>";
									
									} else {
										
										echo "<a href='tot_received.php?aptid=1&status=005&&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][111213]['count'] . "</a>";
									
									}
									
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=13&name=" . $_SESSION['uid'] . "'>" . $reopened_completed_tot[1][111213]['count'] . "</a>";
									
									} else {
										
										echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=13&name=" . $_SESSION['uid'] . "'>" . $reopened_completed_tot[1][111213]['count'] . "</a>";
									
									}
								}
								
								?>
							</p>
							<p class="text-muted no-margin "><span style="color:#000;">Total Reopened</span>
								<br>
								(<?php echo number_format($total_grievance_reopened / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>
				
				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-success">
							<br>
							<i class="fa  text-large stat-icon "><img src="images/reopen_comp.png"></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">
								<?php 
								$total_grievance_reopened_completed=2858;//$reopened_completed_tot[1][12]['count']
								if ($_SESSION['user_type'] == 'U') {
									
									echo "<a href='street_complaints.php?app_type_id=1&status=600&f_date=&t_date=' >" . $total_grievance_reopened_completed . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=601&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][12]['count'] . "</a>";
									
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo $reopened_completed_tot[1][12]['count'];
										
									} else {
										
										echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=12&name=" . $_SESSION['uid'] . "'>" . $reopened_completed_tot[1][12]['count'] . "</a>";
									
									}
								}

								?>
							</p>
							<p class="text-muted no-margin "><span style="color:#000;">Reopened Completed</span>
								<br>
								(<?php echo number_format($total_grievance_reopened_completed / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>

				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-danger">
							<br>
							<i class="fa fa-folder-open text-large stat-icon "></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">

								<?php 
								
								$total_grievance_reopened_underprogress=84;//$reopened_completed_tot[1][11]['count']

								if ($_SESSION['user_type'] == 'U') {
									
									echo "<a href='street_complaints.php?app_type_id=1&status=502&f_date=&t_date='>" . $total_grievance_reopened_underprogress . "</a>";

								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=503&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][11]['count'] . "</a>";
									
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopened_completed_tot[1][11]['count'] . "</a>";
									
									} else {
										
										echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopened_completed_tot[1][11]['count'] . "</a>";
									
									}
								}

								?>
							</p>
							<p class="text-muted no-margin "><span style="color:#000;">Reopened Under Progress</span>
								<br>
								(<?php echo number_format($total_grievance_reopened_underprogress / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>	

				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-info">
							<br>
							<i class="fa fa-list text-large stat-icon "></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">

								<?php 
								
								if ($_SESSION['user_type'] == 'U') {
									
										echo "<a href='tot_received.php?aptid=1&status=201&sla=0&user_type=" . $_SESSION['user_type'] . "' >" . $reopened_completed_tot[1]['Transfered']['count'] . "</a>";
							
								} else if ($_SESSION['user_type'] == 'E') {
									
										echo "<a href='tot_received.php?aptid=1&status=201&sla=0&user_type=" . $_SESSION['user_type'] . "' >" . $reopened_completed_tot[1]['Transfered']['count'] . "</a>";
									
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopened_completed_tot[1]['Transfered']['count'] . "</a>";
									
									} else {
										
										echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopened_completed_tot[1]['Transfered']['count'] . "</a>";
									
									}
								}

								?>
							</p>
							<p class="text-muted no-margin "><span style="color:#000;">Transfered Grievances</span>
								<br>
								(<?php echo number_format($reopened_completed_tot[1]['Transfered']['count'] / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>				
				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-info">
							<br>
							<i class="fa fa-flag text-large stat-icon "></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">

								<?php 
								
								if ($_SESSION['user_type'] == 'U') {
									
										echo "<a href='escaleted_grievance_rep.php' >" . $reopened_completed_tot[1]['Escalated']['count'] . "</a>";
							
								} else if ($_SESSION['user_type'] == 'E') {
									
										echo "<a href='employee_escalated_complaints.php' >" . $reopened_completed_tot[1]['Escalated']['count'] . "</a>";
									
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopened_completed_tot[1]['Escalated']['count'] . "</a>";
									
									} else {
										
										echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopened_completed_tot[1]['Escalated']['count'] . "</a>";
									
									}
								}

								?>
							</p>
							<p class="text-muted no-margin "><span style="color:#000;">Escalated Grievances</span>
								<br>
								(<?php echo number_format($reopened_completed_tot[1]['Escalated']['count'] / $data[1]['total_received'] * 100, 2); ?> %)
							</p>
						</div>
					</section>
				</div>
				
				<!-- <div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-info">
							<br>
							<i class="fa fa-users text-large stat-icon "></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
							<p class="size-h1 no-margin countdown_first">
								<a href='user_logs_report.php' >Logs</a>
							</p>
							<p class="text-muted no-margin "><span style="color:#000;">User Logs</span>
								
							</p>
						</div>
					</section>
				</div>	-->			

			</div>
			
			<div class="row">

				<div class="col-md-4 col-sm-6">
					<section class="panel panel-box myshadow">
						<?php include 'piechart.php'; ?>
					</section>
				</div>

				<div class="col-md-4 col-sm-6">
					<section class="panel panel-box myshadow">
						<?php include 'completed_within_sla_piechart.php'; ?>
					</section>
				</div>

				<div class="col-md-4 col-sm-6">
					<section class="panel panel-box myshadow">
						<?php include 'pending_complaints_piechart.php'; ?>
					</section>
				</div>
				
			</div>
		</div>
	</div>
	</div>


	</div><!-- /.tab-pane -->


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script type="text/javascript">
		function getSelectedYear() {
			//alert('hi');
			var yearSelect = document.getElementById('yearSelect');
			var selectedYear = yearSelect.options[yearSelect.selectedIndex].value;
			var yearSelectHidden = document.getElementById('yearSelectHidden');
			var dashData = document.getElementById('dashData');

			// Set the value of hidden input
			yearSelectHidden.value = selectedYear;
			var ty = 'yearwisefilter';
			// Make AJAX request
			$.ajax({
				type: "POST",
				url: "ajax_dashboard.php",
				data: {
					year: selectedYear,
					ty: ty
				},
				success: function(response) {
					// Update dashData div with response
					//alert('hi');
					location.reload();
				},
				error: function(xhr, status, error) {
					//alert('hi');
					console.error("Error:", error);
				}
			});
		}
		
		function getSelectedDesignation() {
			//alert('hi');
			var designationSelect = document.getElementById('designationSelect');
			var selectedDesg = designationSelect.options[designationSelect.selectedIndex].value;
			var designationSelectHidden = document.getElementById('designationSelectHidden');
			var dashData = document.getElementById('dashData');
//alert(selectedDesg);
			// Set the value of hidden input
			designationSelectHidden.value = selectedDesg;
			var ty = 'designationwisefilter';
			// Make AJAX request
			$.ajax({
				type: "POST",
				url: "ajax_dashboard.php",
				data: {
					designation: selectedDesg,
					ty: ty
				},
				success: function(response) {
					// Update dashData div with response
					//alert(response);
					location.reload();
				},
				error: function(xhr, status, error) {
					//alert('hi');
					console.error("Error:", error);
				}
			});
		}
	</script>
<?php
	mysqli_close($conn);
	
//$end_time = hrtime(true);

		// Calculate Execution time (in Nanoseconds)
//$execution_time = $end_time - $start_time;

		// Convert to Seconds (1 second = 1 billion nanoseconds)
//$execution_time_in_seconds = $execution_time / 1e9;

//echo "Execution time: " . $execution_time_in_seconds . " seconds";
?>
