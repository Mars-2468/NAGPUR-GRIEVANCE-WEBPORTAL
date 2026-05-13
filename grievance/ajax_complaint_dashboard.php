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
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	$mergedulbs = 900;
	
	$emplist = join("','", $_SESSION['emp_list']);

	//$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:date('Y');
	$selectedYear = $_SESSION['filteryear']??'';
	$selectedDesg = $_SESSION['filterdesg']??'';
	$selectedDept = $_SESSION['employee_dept']??'';
	$selectedDesgnation = $_SESSION['employee_desg']??'';
	$response = "";
	$threshold_date='';//$_SESSION['threshold_date'];
	
	//echo "<pre>";print_r($selectedYear);echo "</pre>";die();
		
	// Total received start 

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";

	} else if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {

			$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and app_type_id='1' and cat3_id !='0' ";

		} else {
					$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
						FROM (
							SELECT 
								COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
							FROM 
								grievances g
							INNER JOIN 
								".$_SESSION['grievances_trns']." gt 
								ON g.grievance_id = gt.grievance_id
							WHERE 
								g.ulbid = '" . $_SESSION['ulbid'] . "' 
								AND g.app_type_id = '1' 
								AND g.grievance_status_id IN (2,3,5,6,8,9,10,11,12,13) 
								AND gt.disposal_status IN (2,3,5,6,8,9,10,11,12,13) 
								AND g.cat3_id != 0 ";	
					
					if(!empty($selectedYear)) {
						$sql .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
					}
					
					if (!empty($threshold_date)) {
						$sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
					}
					
					$sql .="  GROUP BY gt.dept_id ) AS subquery ";	
		}

	} else if ($_SESSION['user_type'] == 'E') {

		//$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,g.app_type_id FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "'  and g.cat3_id!='0' AND date_format(date_regd,'%Y') = '" . $selectedYear . "'";

		$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND gt.emp_id IN('" . $emplist . "')
						AND g.grievance_status_id IN (2,3,5,6,8,9,10,11,12,13) 
						AND gt.disposal_status IN (2,3,5,6,8,9,10,11,12,13) 
						AND g.cat3_id != 0 ";
						
		if (!empty($selectedYear)) { 						
			$sql = " AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "' ";
		}
		
		if (!empty($selectedDept)) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' ";
		}
		
		if (!empty($threshold_date)) {
			$sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
		}
					
		$sql .="  GROUP BY gt.dept_id ) AS subquery ";	
		

		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */
		
	} else if ($_SESSION['user_type'] == 'R') {
	
		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'M') {
	
		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances where app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}
	
//echo"<pre>";print_r($sql);echo"</pre>";die();

	$data=[];

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data[$row['app_type_id']]['total_received'] = $row['count'];
	}
	$esc_total = 0;

	if ($_SESSION['user_type'] == 'E') {
		$esc_rs = mysqli_query($conn, $sql);
		while ($row2 = mysqli_fetch_assoc($esc_rs)) {
			$esc_total = (int)$data[$row2['app_type_id']]['total_received'] + (int)$row2['count'];
		}
	}


	if ($data[1]['total_received'] == '') {
		$data[1]['total_received'] = 0;
	}

// TotalReceived End



//Daily Received Grievances start

	$date = date('Y-m-d');

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances where DATE(date_regd) = '" . $date . "' and app_type_id='1' and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
	
			$sql = "SELECT count(DISTINCT grievance_id) as count,app_type_id FROM grievances where DATE(date_regd) = '" . $date . "' and ulbid IN('208','210') and app_type_id='1' and cat3_id !='0' ";

		} else {
			
			if ($selectedYear) {
			
				$sql = "SELECT COUNT(DISTINCT grievance_id) AS count,app_type_id FROM grievances WHERE date_format(date_regd,'%Y-%m-%d') = '" . $date . "' and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and cat3_id !='0' ";
				$sql .= " and date_format(date_regd,'%Y') = '" . $selectedYear . "' ";

			} else {
			
				$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where date_format(date_regd,'%Y-%m-%d') = '" . $date . "' and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and cat3_id !='0'  and grievance_status_id in(2,3,5,6,8,9,10,11,12,13) ";
		
			}
		}
		
	} else if ($_SESSION['user_type'] == 'E') {

		if ($selectedYear) {

			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,app_type_id FROM ".$_SESSION['grievances_trns']." gt,grievances g where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0' ";
			$sql .= " and date_format(date_regd,'%Y') = '" . $selectedYear . "' ";


		} else {

			$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,app_type_id FROM ".$_SESSION['grievances_trns']." gt,grievances g where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0'";

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
//echo"<pre>";print_r($sql);echo"</pre>";die();

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data[1]['daily_received'] = (int)$row['count'];
	}
	$esc_total = 0;

	if ($_SESSION['user_type'] == 'E') {
		$esc_rs = mysqli_query($conn, $sql);
		while ($row2 = mysqli_fetch_assoc($esc_rs)) {
			$esc_total = (int)$data[1]['daily_received'] + (int)$row2['count'];
		}
	}


	if ($data[1]['daily_received'] == '') {
		$data[1]['daily_received'] = 0;
	}

//Daily Received Grievances End
	
	//echo "<pre>";print_r($data[1]['total_transferred']);echo "</pre>";die();
	
// Resolved with in sla start 3,8,9

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' ";
	} else if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances where ulbid IN('208','210') and 
			app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
		} else {

			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
						FROM (
							SELECT 
								COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
							FROM 
								grievances g
							INNER JOIN 
								".$_SESSION['grievances_trns']." gt 
								ON g.grievance_id = gt.grievance_id
							WHERE 
								g.ulbid = '" . $_SESSION['ulbid'] . "' 
								AND g.app_type_id = '1' 
								AND g.grievance_status_id IN(3,8,9) 
								AND g.sla_status='1'
								AND g.cat3_id != 0 ";	
					
					if(!empty($selectedYear)) {
						$sql .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
					}
					
					if (!empty($threshold_date)) {
						$sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
					}
					
					$sql .="  GROUP BY gt.dept_id ) AS subquery ";	
			
			
			
			
		}
	} else if ($_SESSION['user_type'] == 'E') {

		if ($selectedYear) {
			
			//$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,app_type_id FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and app_type_id='1' and g.grievance_status_id IN('3','6','8','9') and g.sla_status=1 and gt.is_escalated=0 and cat3_id !='0' AND date_format(date_regd,'%Y') = '" . $selectedYear . "'";
		
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
						FROM (
							SELECT 
								COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
							FROM 
								grievances g
							INNER JOIN 
								".$_SESSION['grievances_trns']." gt 
								ON g.grievance_id = gt.grievance_id
							WHERE 
								g.ulbid = '" . $_SESSION['ulbid'] . "' 
								AND g.app_type_id = '1' 
								AND gt.emp_id IN('" . $emplist . "')
								AND g.grievance_status_id IN(3,8,9) 
								AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "' 
								AND g.sla_status='1'
								AND g.cat3_id != 0 ";
		
		
		} else {
			
			//$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,app_type_id FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and app_type_id='1' and g.grievance_status_id IN('3','6','8','9') and g.sla_status=1 and gt.is_escalated=0 and cat3_id !='0'";
		
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
						FROM (
							SELECT 
								COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
							FROM 
								grievances g
							INNER JOIN 
								".$_SESSION['grievances_trns']." gt 
								ON g.grievance_id = gt.grievance_id
							WHERE 
								g.ulbid = '" . $_SESSION['ulbid'] . "' 
								AND g.app_type_id = '1' 
								AND gt.emp_id IN(" . $emplist . ")
								AND g.grievance_status_id IN (3,8,9) 
								AND g.sla_status=1
								AND g.cat3_id != 0 ";
								
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' GROUP BY gt.dept_id ) AS subquery ";
		}else{
			$sql .="  GROUP BY gt.dept_id ) AS subquery ";
		}
		
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */



	} else if ($_SESSION['user_type'] == 'R') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and disposal_status IN('3','8','9') and sla_status=1 and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'M') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
	
	}

//echo "<pre>";print_r($sql);echo "</pre>";die();

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data[$row['app_type_id']]['resolved_within_sla'] = $row['count'];
		
	}

	if ($data[1]['resolved_within_sla'] == '') {
		$data[1]['resolved_within_sla'] = 0;
	}
		
// ResolvedWithinSla end

//echo"<pre>";print_r($sql);echo"</pre>";die();
	
	
// Resolved beyond sla start 3,8,9

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances where app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
	} else if ($_SESSION['user_type'] == 'U') {
		
		$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
						FROM (
							SELECT 
								COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
							FROM 
								grievances g
							INNER JOIN 
								".$_SESSION['grievances_trns']." gt 
								ON g.grievance_id = gt.grievance_id
							WHERE 
								g.ulbid = '" . $_SESSION['ulbid'] . "' 
								AND g.app_type_id = '1' 
								AND g.grievance_status_id IN(3,8,9) 
								AND g.sla_status='2'
								AND g.cat3_id != 0 ";	
					
					if(!empty($selectedYear)) {
						$sql .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
					}
					
					if (!empty($threshold_date)) {
						$sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
					}
					
					$sql .="  GROUP BY gt.dept_id ) AS subquery ";
		
		
		
	} else if ($_SESSION['user_type'] == 'E') {

		if ($selectedYear) {
			
			//$sql = "SELECT count(DISTINCT(g.grievance_id)) as count,g.app_type_id FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and g.grievance_status_id IN('3','6','8','9') and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and g.sla_status=2 and cat3_id !='0' and date_format(date_regd,'%Y') = '" . $selectedYear . "'";
		
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
					FROM (
						SELECT 
							COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
						FROM 
							grievances g
						INNER JOIN 
							".$_SESSION['grievances_trns']." gt 
							ON g.grievance_id = gt.grievance_id
						WHERE 
							g.ulbid = '" . $_SESSION['ulbid'] . "' 
							AND g.app_type_id = '1' 
							AND gt.emp_id IN('" . $emplist . "')
							AND g.grievance_status_id IN (3,8,9) 
							AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
							AND g.sla_status='2'
							AND g.cat3_id != 0 ";
		
		} else {
	
			//$sql = "SELECT count(DISTINCT(g.grievance_id)) as count, g.app_type_id FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and emp_id IN('" . $emplist . "') and g.grievance_status_id IN('3','6','8','9') and g.sla_status=2 and ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' ";
		
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
					FROM (
						SELECT 
							COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
						FROM 
							grievances g
						INNER JOIN 
							".$_SESSION['grievances_trns']." gt 
							ON g.grievance_id = gt.grievance_id
						WHERE 
							g.ulbid = '" . $_SESSION['ulbid'] . "' 
							AND g.app_type_id = '1' 
							AND gt.emp_id IN('" . $emplist . "')
							AND g.grievance_status_id IN (3,8,9) 
							AND g.sla_status='2'
							AND g.cat3_id != 0 ";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' GROUP BY gt.dept_id ) AS subquery ";
		}else{
			$sql .="  GROUP BY gt.dept_id ) AS subquery ";
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

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data[$row['app_type_id']]['resolved_beyond_sla'] = $row['count'];
	
	}

	if ($data[1]['resolved_beyond_sla'] == '') {
		$data[1]['resolved_beyond_sla'] = 0;
	}
// ResolvedBeyondSla End

//echo"<pre>";print_r($data[1]['resolved_beyond_sla']);echo"</pre>";die();

// under progress with in sla start 2

	if ($_SESSION['user_type'] == 'A') {
		
		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'U') {
		
		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			
			$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where ulbid IN('208','210') and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
		
		} else {
			
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND g.grievance_status_id IN(2) 
						AND gt.disposal_status IN(2)
						AND g.sla_status='1'
						AND g.cat3_id != 0 ";	
			
			if(!empty($selectedYear)) {
				$sql .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
			}
			
			if (!empty($threshold_date)) {
				$sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
			}
			
			$sql .="  GROUP BY gt.dept_id ) AS subquery ";			
			
		}
		
	} else if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			//$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN(2) and g.grievance_status_id IN(2) and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and g.sla_status=1 and cat3_id !='0' and (gt.is_reopened_yn='0' || gt.is_reopened_yn is null) and date_format(date_regd,'%Y') = '" . $selectedYear . "'";
		
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND gt.emp_id IN('" . $emplist . "')
						AND g.grievance_status_id IN (2) 
						AND gt.disposal_status IN (2) 
						AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
						AND g.sla_status='1'
						AND g.cat3_id != 0 ";
		
		} else {
			
			//$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN(2) and g.grievance_status_id IN(2) and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and g.sla_status=1 and cat3_id !='0' and (gt.is_reopened_yn='0' || gt.is_reopened_yn is null) ";
		
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND gt.emp_id IN('" . $emplist . "')
						AND g.grievance_status_id IN(2) 
						AND gt.disposal_status IN(2) 
						AND g.sla_status='1'
						AND g.cat3_id != 0 ";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' GROUP BY gt.dept_id ) AS subquery ";
		}else{
			$sql .="  GROUP BY gt.dept_id ) AS subquery ";
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
		
		$data[1]['under_progress_with_sla'] = $row['count'];
	
	}
	
	if ($data[1]['under_progress_with_sla'] == '') {
		$data[1]['under_progress_with_sla'] = 0;
	} 

//  under progress with in sla end

	//echo"<pre>";print_r($sql);echo"</pre>";die();

// under progress beyond sla start 2

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
	
	} else if ($_SESSION['user_type'] == 'U') {
		
		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			
			$sql = "SELECT count(grievance_id) as count,app_type_id FROM grievances where ulbid IN('208','210') and 
			app_type_id='1' and grievance_status_id IN(2) and sla_status=2 and cat3_id !='0'";
		
		} else {
					
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND g.grievance_status_id IN(2) 
						AND gt.disposal_status IN(2)
						AND g.sla_status='2'
						AND g.cat3_id != 0 ";	
			
			if(!empty($selectedYear)) {
				$sql .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
			}
			
			if (!empty($threshold_date)) {
				$sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
			}
			
			$sql .="  GROUP BY gt.dept_id ) AS subquery ";	
			
			
		}
		
	} else if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			//$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g,ulbmst u,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and emp_id IN('" . $emplist . "') and app_type_id='1' and g.grievance_status_id IN(2) and sla_status=2 and gt.disposal_status IN(2) and cat3_id !='0' AND date_format(date_regd,'%Y') = '" . $selectedYear . "'";
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND gt.emp_id IN('" . $emplist . "')
						AND g.grievance_status_id IN (2) 
						AND gt.disposal_status IN (2) 
						AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
						AND g.sla_status='2'
						AND g.cat3_id != 0 ";
		
		} else {
			
			//$sql = "SELECT count(DISTINCT g.grievance_id) as count,g.app_type_id FROM grievances g,ulbmst u,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and emp_id IN('" . $emplist . "') and app_type_id='1' and g.grievance_status_id IN(2) and sla_status=2 and gt.disposal_status IN(2) and cat3_id !='0' ";
		
		
			$sql = "SELECT SUM(grievance_count) AS count,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND gt.emp_id IN('" . $emplist . "')
						AND g.grievance_status_id IN (2) 
						AND gt.disposal_status IN (2) 
						AND g.sla_status='2'
						AND g.cat3_id != 0 ";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' GROUP BY gt.dept_id ) AS subquery ";
		}else{
			$sql .="  GROUP BY gt.dept_id ) AS subquery ";
		}
		
		/* if ($selectedDesgnation) { 
			$sql .=" and gt.desg_id = '".$selectedDesgnation."' ";
		} */

//echo "<pre>";print_r($sql);echo "</pre>";die();
		
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

// under progress beyond sla End

	//echo"<pre>";print_r($data[1]['under_progress_beyond_sla']);echo"</pre>";die();
	
//echo"<pre>";print_r($sql);echo"</pre>";die();

	
// Financial implications start

	if ($_SESSION['user_type'] == 'A') {

		$sql = "SELECT count(grievance_id) as fin,app_type_id from grievances where  grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
	}
	if ($_SESSION['user_type'] == 'U') {

		if ($_SESSION['ulbid'] == (int)$mergedulbs) {
			
			$sql = "SELECT count(grievance_id) as fin,app_type_id from grievances where 
			ulbid IN('208','210') and grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
		
		} else {
			
			$sql = "SELECT SUM(fin) AS fin,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS fin,g.app_type_id  as app_type_id,gt.dept_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND g.grievance_status_id IN(6) 
						AND g.cat3_id != 0 ";	
			
			if(!empty($selectedYear)) {
				$sql .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
			}
			
			if (!empty($threshold_date)) {
				$sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
			}
			
			$sql .="  GROUP BY gt.dept_id ) AS subquery ";	
			
		}
		
		
	}else if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			//$sql = "SELECT count(DISTINCT g.grievance_id) as fin,g.app_type_id from grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id='6' and app_type_id='1' and cat3_id !='0' AND date_format(date_regd,'%Y') = '" . $selectedYear . "'";
		
			$sql = "SELECT SUM(grievance_count) AS fin,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND gt.emp_id IN('" . $emplist . "')
						AND g.grievance_status_id IN (6) 
						AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
						AND g.cat3_id != 0 ";
		
		
		} else {
			
			//$sql = "SELECT count(DISTINCT g.grievance_id) as fin,g.app_type_id from grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
		
		$sql = "SELECT SUM(grievance_count) AS fin,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND gt.emp_id IN('" . $emplist . "')
						AND g.grievance_status_id IN (6) 
						AND g.cat3_id != 0 ";
		
		}
		
		if ($selectedDept) { 
			$sql .=" and gt.dept_id = '".$selectedDept."' GROUP BY gt.dept_id ) AS subquery ";
		}else{
			$sql .="  GROUP BY gt.dept_id ) AS subquery ";
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



//echo "<pre>";print_r($sql);echo "</pre>";die();	

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['fin'] = $row['fin'];
		
	}

	if ($data[1]['fin'] == '') {
		$data[1]['fin'] = 0;
	}

// Financial implications End


// re-opened applicatons start

	if ($_SESSION['user_type'] == 'A') {

		$sql3 = "SELECT count(grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13') group by app_type_id,grievance_status_id";
	} else if ($_SESSION['user_type'] == 'U') {

		// reopened 
		
			$reopened_sql = "SELECT SUM(grievance_count) AS count,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND g.grievance_status_id IN(13) 
						AND gt.disposal_status IN(13) 
						AND g.cat3_id != 0 ";	
			
			if(!empty($selectedYear)) {
				$reopened_sql .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
			}
			
			if (!empty($threshold_date)) {
				$reopened_sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
			}
			
			$reopened_sql .="  GROUP BY gt.dept_id ) AS subquery ";	
		
		
			//reopen-completed 
			
			
		$reopened_completed_sql = "SELECT SUM(grievance_count) AS count,app_type_id 
				FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND g.grievance_status_id IN(12) 
						AND gt.disposal_status IN(12) 
						AND g.cat3_id != 0 ";	
			
			if(!empty($selectedYear)) {
				$reopened_completed_sql .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
			}
			
			if (!empty($threshold_date)) {
				$reopened_completed_sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
			}
			
			$reopened_completed_sql .="  GROUP BY gt.dept_id ) AS subquery ";	
		
		
			
			//reopen-under-progress		
		
				$reopened_under_progress_sql = "SELECT SUM(grievance_count) AS count,app_type_id 
					FROM (
						SELECT 
							COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
						FROM 
							grievances g
						INNER JOIN 
							".$_SESSION['grievances_trns']." gt 
							ON g.grievance_id = gt.grievance_id
						WHERE 
							g.ulbid = '" . $_SESSION['ulbid'] . "' 
							AND g.app_type_id = '1' 
							AND g.grievance_status_id IN(11) 
							AND gt.disposal_status IN(11) 
							AND g.cat3_id != 0 ";	

				if(!empty($selectedYear)) {
					$reopened_under_progress_sql .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
				}

				if (!empty($threshold_date)) {
					$reopened_under_progress_sql .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
				}

				$reopened_under_progress_sql .="  GROUP BY gt.dept_id ) AS subquery ";	
		
		
			//transfer		
		
				$sqlTr = "SELECT SUM(grievance_count) AS count,app_type_id 
					FROM (
						SELECT 
							COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
						FROM 
							grievances g
						INNER JOIN 
							".$_SESSION['grievances_trns']." gt 
							ON g.grievance_id = gt.grievance_id
						WHERE 
							g.ulbid = '" . $_SESSION['ulbid'] . "' 
							AND g.app_type_id = '1' 
							AND g.grievance_status_id IN(5,10) 						
							AND g.cat3_id != 0 ";	

				if(!empty($selectedYear)) {
					$sqlTr .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
				}

				if (!empty($threshold_date)) {
					$sqlTr .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
				}

				$sqlTr .="  GROUP BY gt.dept_id ) AS subquery ";	
		
		
		//Escalated
		
				$sqlEsc ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id,date_regd  
							FROM  grievances g, 
								  cs_mst c, 
								  category_mst cm , 
								  ".$_SESSION['grievances_trns']." gt 
							where g.grievance_id=gt.grievance_id and
                                  g.cat3_id=c.cs_id and  
								  c.cat_id=cm.cat_id and  
								  g.app_type_id=1 and  
								  g.ulbid='" . $_SESSION['ulbid'] . "'  and  
								  is_escalated = 1  ";
		
							if(!empty($selectedYear)) {
								$sqlEsc .="  and date_format(date_regd,'%Y') ='".$selectedYear."' ";
							}
							
							if (!empty($threshold_date)) {
								$sqlEsc .="  and date_format(date_regd,'%Y-%m-%d') >='".$threshold_date."' ";
							}
		
		
		
	} else if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			
			
			
			
			$reopened_sql = "SELECT SUM(grievance_count) AS count,app_type_id 
						FROM (
							SELECT 
								COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
							FROM 
								grievances g
							INNER JOIN 
								".$_SESSION['grievances_trns']." gt 
								ON g.grievance_id = gt.grievance_id
							WHERE 
								g.ulbid = '" . $_SESSION['ulbid'] . "' 
								AND g.app_type_id = '1' 
								AND g.grievance_status_id IN(13)
								AND gt.disposal_status IN(13)
								AND g.cat3_id != 0
								AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
								AND emp_id IN('" . $emplist . "')
							GROUP BY 
								gt.dept_id
						) AS subquery ";
			
			
			$reopened_under_progress_sql = "SELECT SUM(grievance_count) AS count,app_type_id 
						FROM (
							SELECT 
								COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
							FROM 
								grievances g
							INNER JOIN 
								".$_SESSION['grievances_trns']." gt 
								ON g.grievance_id = gt.grievance_id
							WHERE 
								g.ulbid = '" . $_SESSION['ulbid'] . "' 
								AND g.app_type_id = '1' 
								AND g.grievance_status_id IN(11)
								AND gt.disposal_status IN(11)
								AND g.cat3_id != 0
								AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
								AND emp_id IN('" . $emplist . "')
							GROUP BY 
								gt.dept_id
						) AS subquery ";
			
			
			
			$reopened_completed_sql = "SELECT SUM(grievance_count) AS count,app_type_id 
						FROM (
							SELECT 
								COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
							FROM 
								grievances g
							INNER JOIN 
								".$_SESSION['grievances_trns']." gt 
								ON g.grievance_id = gt.grievance_id
							WHERE 
								g.ulbid = '" . $_SESSION['ulbid'] . "' 
								AND g.app_type_id = '1' 
								AND g.grievance_status_id IN(12)
								AND gt.disposal_status IN(12)
								AND g.cat3_id != 0
								AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
								AND emp_id IN('" . $emplist . "')
							GROUP BY 
								gt.dept_id
						) AS subquery ";
			
			
	
			//$sqlTr = "Select count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,(SELECT * FROM grievances_transactions gi WHERE transaction_id = ( SELECT MAX(t.transaction_id) FROM grievances_transactions t WHERE t.grievance_id = gi.grievance_id ) )gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('5','10') and g.grievance_status_id IN('5','10') and gt.emp_id IN('" . $emplist . "') and g.cat3_id!=0 and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' AND date_format(date_regd,'%Y') = '" . $selectedYear . "'";
			
			
			$sqlTr = "SELECT SUM(grievance_count) AS count,app_type_id 
						FROM (
						SELECT 
							COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
						FROM 
							grievances g
						INNER JOIN 
							".$_SESSION['grievances_trns']." gt 
							ON g.grievance_id = gt.grievance_id
						WHERE 
							g.ulbid = '" . $_SESSION['ulbid'] . "' 
							AND g.app_type_id = '1' 
							AND gt.emp_id IN('" . $emplist . "')
							AND g.grievance_status_id IN (5,10) 
							AND date_format(date_regd,'%Y') = '" . $selectedYear . "'
							AND g.cat3_id != 0 ";
			
			
			
				if ($selectedDept) { 
					$sqlTr .=" and gt.dept_id = '".$selectedDept."' GROUP BY gt.dept_id ) AS subquery ";
				}else{
					$sqlTr .="  GROUP BY gt.dept_id ) AS subquery ";
				}
			
			
			$sqlEsc ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . $_SESSION['ulbid'] . "'  and `is_escalated` = 1 AND date_format(date_regd,'%Y') = '" . $selectedYear . "' ";

		} else {
			
			
			
			
				$reopened_sql = "SELECT SUM(grievance_count) AS count,app_type_id 
					FROM (
						SELECT 
							COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
						FROM 
							grievances g
						INNER JOIN 
							".$_SESSION['grievances_trns']." gt 
							ON g.grievance_id = gt.grievance_id
						WHERE 
							g.ulbid = '" . $_SESSION['ulbid'] . "' 
							AND g.app_type_id = '1' 
							AND g.grievance_status_id IN(13)
							AND gt.disposal_status IN(13)
							AND emp_id IN('" . $emplist . "')
							AND g.cat3_id != 0
						GROUP BY 
							gt.dept_id
					) AS subquery ";
		
		
				$reopened_under_progress_sql = "SELECT SUM(grievance_count) AS count,app_type_id 
					FROM (
						SELECT 
							COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
						FROM 
							grievances g
						INNER JOIN 
							".$_SESSION['grievances_trns']." gt 
							ON g.grievance_id = gt.grievance_id
						WHERE 
							g.ulbid = '" . $_SESSION['ulbid'] . "' 
							AND g.app_type_id = '1' 
							AND g.grievance_status_id IN(11)
							AND gt.disposal_status IN(11)
							AND emp_id IN('" . $emplist . "')
							AND g.cat3_id != 0
						GROUP BY 
							gt.dept_id
					) AS subquery ";
		
		
		
				$reopened_completed_sql = "SELECT SUM(grievance_count) AS count,app_type_id 
					FROM (
						SELECT 
							COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id,gt.dept_id
						FROM 
							grievances g
						INNER JOIN 
							".$_SESSION['grievances_trns']." gt 
							ON g.grievance_id = gt.grievance_id
						WHERE 
							g.ulbid = '" . $_SESSION['ulbid'] . "' 
							AND g.app_type_id = '1' 
							AND g.grievance_status_id IN(12) 
							AND gt.disposal_status IN(12)
							AND emp_id IN('" . $emplist . "')
							AND g.cat3_id != 0
						GROUP BY 
							gt.dept_id
					) AS subquery ";
		
	
				//$sqlTr = "Select count(DISTINCT g.grievance_id) as count,g.app_type_id from grievances g,(SELECT * FROM grievances_transactions gi WHERE transaction_id = ( SELECT MAX(t.transaction_id) FROM grievances_transactions t WHERE t.grievance_id = gi.grievance_id ) )gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('5','10') and g.grievance_status_id IN('5','10') and gt.emp_id IN('" . $emplist . "') and g.cat3_id!=0 and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1'";
		
				$sqlTr = "SELECT SUM(grievance_count) AS count,app_type_id 
					FROM (
					SELECT 
						COUNT(DISTINCT g.grievance_id) AS grievance_count,g.app_type_id  as app_type_id
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . $_SESSION['ulbid'] . "' 
						AND g.app_type_id = '1' 
						AND gt.emp_id IN('" . $emplist . "')
						AND g.grievance_status_id IN (5,10) 
						AND g.cat3_id != 0 ";
		
			
					
					if ($selectedDept) { 
						$sqlTr .=" and gt.dept_id = '".$selectedDept."' GROUP BY gt.dept_id ) AS subquery ";
					}else{
						$sqlTr .="  GROUP BY gt.dept_id ) AS subquery ";
					}
					
			
			$sqlEsc ="SELECT count(DISTINCT (gt.grievance_id)) as count, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . $_SESSION['ulbid'] . "'  and `is_escalated` = 1 ";

	
			//echo "<pre>";print_r($sqlTr);echo "</pre>";die();

		}

		
	} else if ($_SESSION['user_type'] == 'R') {
		
			$sql3 = "SELECT count(gt.grievance_id) as count,app_type_id from grievances g,".$_SESSION['grievances_trns']." gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0' and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
			
			$sql4 = "SELECT count(g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,".$_SESSION['grievances_trns']." gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0' and gt.disposal_status IN('11','12')  group by app_type_id, grievance_status_id";
	
	}

	if ($_SESSION['user_type'] == 'M') {

			$sql3 = "SELECT count(DISTINCT grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13')  group by app_type_id,grievance_status_id";
		
	}
	
	
	if ($selectedDept) { 	
			
	$sqlTr .= "  and gt.dept_id = '".$selectedDept."' ";
		$sqlEsc .= "  and gt.dept_id = '".$selectedDept."' ";
	}

//echo"";print_r($reopened_sql);die();

	$rs = mysqli_query($conn, $reopened_sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['reopened_count'] = $row['count'];
	
	}
		
	$rs = mysqli_query($conn, $reopened_under_progress_sql);
	
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['reopened_under_progress'] = $row['count'];
	}
		
	$rs = mysqli_query($conn, $reopened_completed_sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$data[$row['app_type_id']]['reopened_completed'] = $row['count'];
	
	}

//echo "<pre>";print_r($reopened_sql);echo "</pre>";die();	


// re-opened applicatons End	
	
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
			
			
			$sqlLogs ="SELECT count(DISTINCT (gt.grievance_id)) as count,gt.emp_id as user_id, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and g.app_type_id=1 and g.ulbid='" . $_SESSION['ulbid'] . "'  and `is_escalated` = 1 AND date_format(date_regd,'%Y') = '" . $selectedYear . "' ";

		
		} else {
					
				
			$sqlLogs ="SELECT count(DISTINCT (gt.grievance_id)) as count,gt.emp_id as user_id, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `audit_trails` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and g.app_type_id=1 and g.ulbid='" . $_SESSION['ulbid'] . "'  and `is_escalated` = 1  ";

		}
		
	} else if ($_SESSION['user_type'] == 'E') {
		
		if ($selectedYear) {
			
			
			$sqlLogs ="SELECT count(DISTINCT (gt.grievance_id)) as count,gt.emp_id as user_id, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . $_SESSION['ulbid'] . "'  and `is_escalated` = 1 AND date_format(date_regd,'%Y') = '" . $selectedYear . "' ";

		} else {
			
				
			$sqlLogs ="SELECT count(DISTINCT (gt.grievance_id)) as count,gt.emp_id as user_id, cat3_id,description,cm.cat_id,c.sub_cat_id,ward_id,g.app_type_id FROM `grievances` g, cs_mst c, category_mst cm , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and c.cat_id=cm.cat_id and emp_id IN('" . $emplist . "') and g.app_type_id=1 and g.ulbid='" . $_SESSION['ulbid'] . "'  and `is_escalated` = 1 ";

	
		}
		
	
	}

	$rs = mysqli_query($conn, $sqlLogs);
	$user_logs=[];
	while ($row = mysqli_fetch_assoc($rs)) {
		
		$user_logs[$row['user_id']]['count'] = $row['count'];
	
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
								<option value="2026" <?php if ($selectedYear == '2026') echo 'selected'; ?>>2026</option>
								<option value="2025" <?php if ($selectedYear == '2025') echo 'selected'; ?>>2025</option>
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
							
								if ($_SESSION['user_type'] == 'U') {

									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-clmn'>" . $data[1]['total_received'] . "</a>";
								
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
			


				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-info">
							<br>
							<i class="fa text-large stat-icon "><img src="images/Beyond-icon.png" /></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">
						
							<p class="size-h1 no-margin countdown_first">

								<?php 
								
								$total_resolved = (int)$data[1]['resolved_within_sla'] + (int)$data[1]['resolved_beyond_sla'] ;
								$total_resolved=!empty($total_resolved)?$total_resolved:0;
								
								$total_under_progress = (int)$data[1]['under_progress_beyond_sla'] + (int)$data[1]['under_progress_with_sla'] ;
								$total_under_progress=!empty($total_under_progress)?$total_under_progress:0;

								if ($_SESSION['user_type'] == 'U') {

									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-totresolved' >" . $total_resolved . "</a>";
								
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


				<div class="col-md-3 col-sm-6">
					<section class="panel panel-box myshadow">
						<div class="panel-left panel-icon bg-vimeo">
							<br>
							<i class="fa text-large stat-icon"><img src="images/under-pro.png" /></i>
						</div>
						<div class="panel-right panel-icon bg-reverse">

							<p class="size-h1 no-margin countdown_first">

								<?php

								if ($_SESSION['user_type'] == 'U') {
	
									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-totpending'>" . $total_under_progress . "</a>";

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
								(<?php echo number_format($total_under_progress / $data[1]['total_received'] * 100, 2); ?> %)
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
								
									$fin_implications=!empty($data[1]['fin'])?(int)$data[1]['fin']:0;
								
								if ($_SESSION['user_type'] == 'U') {
							
									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-totresolved-fin'>" . $fin_implications . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=6&user_type=" . $_SESSION['user_type'] . "'>" . $fin_implications . "</a>";
								
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $fin_implications . "</a>";
									
									} else {
										
										echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $fin_implications . "</a>";
									
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
								
								if ($_SESSION['user_type'] == 'U') {

									echo "<a href='rep_comp_dept_abs_comp.php?active=cmp-wthin-sla' >" . $data[1]['resolved_within_sla'] . "</a>";

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
								(<?php echo number_format($data[1]['resolved_within_sla'] / $data[1]['total_received'] * 100, 2); ?> %)
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

								<?php if ($_SESSION['user_type'] == 'U') {


									echo "<a href='rep_comp_dept_abs_comp.php?active=cmp-bnd-sla' >" . $data[1]['resolved_beyond_sla'] . "</a>";



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
								(<?php echo number_format($data[1]['resolved_beyond_sla'] / $data[1]['total_received'] * 100, 2); ?> % )
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
								if ($_SESSION['user_type'] == 'U') {

									echo "<a href='rep_comp_dept_abs_comp.php?active=pwsla-clmn' >" . $data[1]['under_progress_with_sla'] . "</a>";
								
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
								(<?php echo number_format($data[1]['under_progress_with_sla'] / $data[1]['total_received'] * 100, 2); ?> %)
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
								
								if ($_SESSION['user_type'] == 'U') {
							
									echo "<a href='rep_comp_dept_abs_comp.php?active=pdbsla-clmn'>" . $data[1]['under_progress_beyond_sla'] . "</a>";

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
								(<?php echo number_format($data[1]['under_progress_beyond_sla'] / $data[1]['total_received'] * 100, 2); ?> %)
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
								
								$reopen_count=!empty($data[1]['reopened_count'])?(int)$data[1]['reopened_count']:0;
								
								
								if ($_SESSION['user_type'] == 'U') {
									
									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-totpending-reopen-total'>" . $reopen_count . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
									
									if ($reopened_completed_tot[1][13]['count'] > 0) {
											
										echo "<a href='tot_received.php?aptid=1&status=005&&user_type=" . $_SESSION['user_type'] . "'>" . $reopen_count . "</a>";
									
									} else {
										
										echo "<a href='tot_received.php?aptid=1&status=005&&user_type=" . $_SESSION['user_type'] . "'>" . $reopen_count. "</a>";
									
									}
									
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=13&name=" . $_SESSION['uid'] . "'>" .$reopen_count . "</a>";
									
									} else {
										
										echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=13&name=" . $_SESSION['uid'] . "'>" . $reopen_count . "</a>";
									
									}
								}
								
								?>
							</p>
							<p class="text-muted no-margin "><span style="color:#000;">Reopened</span>
								<br>
								(<?php echo number_format($reopen_count / $data[1]['total_received'] * 100, 2); ?> %)
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
								
								$reopened_completed=!empty($data[1]['reopened_completed'])?(int)$data[1]['reopened_completed']:0;
															
								if ($_SESSION['user_type'] == 'U') {
									
									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-totpending-reopen-completed' >" . $reopened_completed . "</a>";
								
								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=601&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed . "</a>";
									
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo $reopened_completed_tot[1][12]['count'];
										
									} else {
										
										echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=12&name=" . $_SESSION['uid'] . "'>" . $reopened_completed . "</a>";
									
									}
								}

								?>
							</p>
							<p class="text-muted no-margin "><span style="color:#000;">Reopened Completed</span>
								<br>
								(<?php echo number_format($reopened_completed / $data[1]['total_received'] * 100, 2); ?> %)
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
								
								$reopen_under_progress=!empty($data[1]['reopened_under_progress'])?(int)$data[1]['reopened_under_progress']:0;
								
								if ($_SESSION['user_type'] == 'U') {
									
									echo "<a href='rep_comp_dept_abs_comp.php?active=tr-totpending-reopen-under-progress'>" . $reopen_under_progress  . "</a>";

								} else if ($_SESSION['user_type'] == 'E') {
									
									echo "<a href='tot_received.php?aptid=1&status=503&user_type=" . $_SESSION['user_type'] . "'>" . $reopen_under_progress  . "</a>";
									
								} else {
									
									if ($_SESSION['user_type'] == 'M') {
										
										echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopen_under_progress  . "</a>";
									
									} else {
										
										echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopen_under_progress . "</a>";
									
									}
								}

								?>
							</p>
							<p class="text-muted no-margin "><span style="color:#000;">Reopened Under Progress</span>
								<br>
								(<?php echo number_format($reopen_under_progress / $data[1]['total_received'] * 100, 2); ?> %)
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
									
										echo "<a href='tot_received.php?aptid=1&status=201&sla=0'>" . $reopened_completed_tot[1]['Transfered']['count'] . "</a>";
							
								} else if ($_SESSION['user_type'] == 'E') {
									
										echo "<a href='tot_received.php?aptid=1&status=201&sla=0'>" . $reopened_completed_tot[1]['Transfered']['count'] . "</a>";
									
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


	<script src="js/jquery-tso.min.js"></script>
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