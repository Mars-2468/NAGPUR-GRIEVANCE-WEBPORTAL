<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();
$user_type = $_SESSION['user_type'];
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

$selectedYear = $_SESSION['filteryear'];
$response = "";

//echo "<pre>";print_r($_SESSION);echo "</pre>";die();

if (isset($_SESSION['uid'])) {
	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
	}

	$emplist = join("','", $_SESSION['emp_list']);
	$sql="SELECT dept_id,emp_id FROM hod_emp_map where emp_id IN ('".$emplist."') ";
	if($_SESSION['user_type']=='E'){
		$sql="SELECT d.dept_id from dept_mst d, hod_emp_map h where h.dept_id = d.dept_id and emp_id IN ('".$emplist."')";
	}
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
		$dept_list[$row['dept_id']]=$row['dept_id'];
	}
	//echo $sql;
	$deptlist = implode(',', $dept_list);
	//print_r($deptlist);

	if ($user_type == 'U') {

		if ($selectedYear) {
			/* $sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id and g.ulbid='" . strip_tags($_SESSION['ulbid']) . "' and g.app_type_id='1' and g.grievance_status_id IN(2,3,6,8,9,11,12,13) and gt.disposal_status IN(2,3,6,8,9,11,12,13) and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		 */
		
			$sql="SELECT COUNT(DISTINCT g.grievance_id) AS count,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) 
					AND gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) 
					AND g.cat3_id != 0 
					AND date_format(date_regd,'%Y') = '" . $selectedYear . "' ";
		
		} else {
			/* $sql ="SELECT count(DISTINCT g.grievance_id) as count,gt.dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id and g.ulbid='".strip_tags($_SESSION['ulbid'])."' and g.app_type_id='1' 
			and g.grievance_status_id IN(1,3,6,8,9,13,12,15) and gt.disposal_status IN(1,3,6,8,9,13,12,15) and g.cat3_id!=0 ";
		 */
		
		
			$sql="SELECT COUNT(DISTINCT g.grievance_id) AS count,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) 
					AND gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) 
					AND g.cat3_id != 0 ";
		
		}
		
	} else {
		if ($selectedYear) {
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "'  and dept_id IN( $deptlist ) and g.app_type_id='1' and gt.disposal_status != 5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
	
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "'  and dept_id IN( $deptlist ) and g.app_type_id='1' and gt.disposal_status != 5 and cat3_id !='0'";
		}
	}
	if (isset($_POST['search'])) {

		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by emp_dept";
	//echo $sql;     
	



	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['emp_dept']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

//echo "<pre>";print_r($data);echo "</pre>";die();
// underprogress within SLA

	if ($user_type == 'U') {
		if ($selectedYear) {
			//$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (2) 
					AND gt.disposal_status IN (2) 
					AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
					AND g.sla_status='1'
					AND g.cat3_id != 0 ";
		
		
		} else {
			//$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (2) 
					AND gt.disposal_status IN (2) 
					AND g.sla_status='1'
					AND g.cat3_id != 0 ";
		
		
		}
	} else {
		if ($selectedYear) {
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and dept_id IN( $deptlist ) and cat3_id !='0' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
	
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and dept_id IN( $deptlist ) and cat3_id !='0' and gt.disposal_status!='5'";
		}
	}


	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
		
	$sql .= " group by gt.dept_id";
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
	
// underprogress beyond SLA

	if ($user_type == 'U') {
		if ($selectedYear) {
			//$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (2) 
					AND gt.disposal_status IN (2) 
					AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
					AND g.sla_status='2'
					AND g.cat3_id != 0 ";
		
		
		} else {
			//$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (2) 
					AND gt.disposal_status IN (2) 
					AND g.sla_status='2'
					AND g.cat3_id != 0 ";
		
		
		}
	} else {
		if ($selectedYear) {
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and dept_id IN( $deptlist ) and cat3_id !='0' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
	
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and dept_id IN( $deptlist ) and cat3_id !='0' and gt.disposal_status!='5'";
		}
	}


	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
		
	$sql .= " group by gt.dept_id";
	//echo $sql;
	
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

	if ($user_type == 'U') {
		if ($selectedYear) {
			//$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (3,8,9) 
					AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
					AND g.sla_status='1'
					AND g.cat3_id != 0 ";
		
		
		} else {
			//$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (3,8,9) 
					AND g.sla_status='1'
					AND g.cat3_id != 0 ";
		
		
		}
	} else {
		if ($selectedYear) {
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and dept_id IN( $deptlist ) and cat3_id !='0' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
	
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and dept_id IN( $deptlist ) and cat3_id !='0' and gt.disposal_status!='5'";
		}
	}


	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
		
	$sql .= " group by gt.dept_id";
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

// completed beyond SLA

	if ($user_type == 'U') {
		if ($selectedYear) {
			//$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (3,8,9) 
					AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
					AND g.sla_status='2'
					AND g.cat3_id != 0 ";
		
		
		} else {
			//$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (3,8,9) 
					AND g.sla_status='2'
					AND g.cat3_id != 0 ";
		
		
		}
	} else {
		if ($selectedYear) {
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and dept_id IN( $deptlist ) and cat3_id !='0' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
	
			$sql = "SELECT count(DISTINCT gt.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and dept_id IN( $deptlist ) and cat3_id !='0' and gt.disposal_status!='5'";
		}
	}


	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
		
	$sql .= " group by gt.dept_id";
	//echo $sql;
	
	$tot['completed_beyond_sla']=0;
	
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data_list[$row['emp_dept']]['completed_beyond_sla'] = $row['count'];
			$tot['completed_beyond_sla'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

//echo "<pre>";print_r($data);echo "</pre>";die();


// reopend complaints


	if ($user_type == 'U') {
		if ($selectedYear) {
			/* $sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		 */
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (13) 
					AND gt.disposal_status IN (13)
					AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
					AND g.cat3_id != 0 ";
		
		} else {
			/* $sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5'";
		*/		
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id as emp_dept 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (13) 
					AND gt.disposal_status IN (13)
					AND g.cat3_id != 0 ";
		
		}
	} else {
		if ($selectedYear) {
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
	
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5'";
		}
	}

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by gt.dept_id";
	//echo $sql;


	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['reopened'] = $row['count'];
		$tot['reopened'] += $row['count'];
	}



	/// unresolvable complaints

	if ($user_type == 'U') {
		if ($selectedYear) {
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('4') and gt.disposal_status IN ('4') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('4') and gt.disposal_status IN ('4') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5'";
		}
	} else {
		if ($selectedYear) {
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('4') and gt.disposal_status IN ('4') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
	
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('4') and gt.disposal_status IN ('4') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5'";
		}
	}


	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by gt.dept_id";
	//echo $sql ;


	$rs = mysqli_query($conn, $sql);
	$tot['unresolved']=0;
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['unresolved'] =$row['count'];
		$tot['unresolved']+=$row['count'];
	}

	/********** FIN IMPLICATION **********************/


	if ($user_type == 'U') {
		
		if ($selectedYear) {
		
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS fin,g.app_type_id as app_type_id,gt.dept_id  
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
						AND g.app_type_id = '1' 
						AND g.grievance_status_id IN (6) 
						AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
						AND g.cat3_id != 0 ";
 		
		} else {
		
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS fin,gt.dept_id,g.app_type_id 
					FROM 
						grievances g
					INNER JOIN 
						".$_SESSION['grievances_trns']." gt 
						ON g.grievance_id = gt.grievance_id
					WHERE 
						g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
						AND g.app_type_id = '1' 
						AND g.grievance_status_id IN (6) 		
						AND g.cat3_id != 0 ";
		
		}
		
	} else {
		if ($selectedYear) {
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and g.grievance_status_id IN ('6') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5' and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
	
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' and g.grievance_status_id IN ('6') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5' and cat3_id !='0'";
		}
	}


	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by gt.dept_id";
	//echo $sql;
	
	$tot['fin']=0;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['dept_id']]['fin'] = $row['fin'];
		$tot['fin'] += $row['fin'];
	}
//echo "<pre>";print_r($tot['fin']);echo "</pre>";die();	

	/********* REJECTED ***********/


	if ($user_type == 'U') {
		if ($selectedYear) {
			//$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('10') and gt.disposal_status!='5' and ulbid='" . $_SESSION['ulbid'] . "' AND YEAR(date_regd) = '" . $selectedYear . "'";
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id  
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (1) 
					AND gt.disposal_status IN (1)
					AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
					AND g.cat3_id != 0 ";
		
		} else {
			//$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('10') and gt.disposal_status!='5' and ulbid='" . $_SESSION['ulbid'] . "'";
		
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,gt.dept_id,g.app_type_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (1) 
					AND gt.disposal_status IN (1)				
					AND g.cat3_id != 0 ";
		
		}
	} else {
		if ($selectedYear) {
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('10') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
		
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('10') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5'";
		}
	}


	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by gt.dept_id";
	
	$tot['rejected']=0;
	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['dept_id']]['rejected'] = $row['count'];
			$tot['rejected'] += $row['count'];
		}
	}

	//echo "<pre>";print_r($data_list['rejected']);echo "</pre>";die();	
	
	/********* Complaints Reopened Under Progress ***********/

	if ($user_type == 'U') {
		if ($selectedYear) {
			//$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id  as emp_dept,g.grievance_status_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
					AND g.grievance_status_id IN (11) 
					AND gt.disposal_status IN (11)
					AND g.cat3_id != 0 ";
		
		} else {
			//$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0'";
		
		$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id  as emp_dept,g.grievance_status_id
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (11) 
					AND gt.disposal_status IN (11)
					AND g.cat3_id != 0 ";
		
		}
	} else {
		if ($selectedYear) {
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and dept_id IN( $deptlist ) and g.app_type_id='1' and g.grievance_status_id IN('11') and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
		
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and dept_id IN( $deptlist ) and g.app_type_id='1' and g.grievance_status_id IN('11') and gt.disposal_status !=5 and cat3_id !='0'";
		}
	}

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	$sql .= " group by emp_dept";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	$tot['reopend_underProgress']=0;
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopend_underProgress'] = $row['count'];
		$tot['reopend_underProgress'] += $row['count'];
		$i += $row['count'];
	}

//echo "<pre>";print_r($tot[$row['grievance_status_id']]['reopend_underProgress']);echo "</pre>";die();


	/********* Complaints Reopened Completed ***********/

	if ($user_type == 'U') {
		if ($selectedYear) {			
			//$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id ,g.grievance_status_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "'
					AND g.grievance_status_id IN (12)
					AND gt.disposal_status IN (12)  					
					AND g.cat3_id != 0 ";
		
		} else {
			//$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0'";
		
		
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id ,g.grievance_status_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (12) 
					AND gt.disposal_status IN (12) 
					AND g.cat3_id != 0 ";
		
		}
	} else {
		if ($selectedYear) {			
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status IN('9') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		} else {
		
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status IN('9') and cat3_id !='0'";
		}
	}

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	$sql .= " group by gt.dept_id";
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	$tot['reopened_completed']=0;
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['dept_id']]['reopened_completed'] = $row['count'];
		$tot['reopened_completed'] += $row['count'];
	}



//transfers

	if ($user_type == 'U') { 
		if ($selectedYear) {		
			//$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
		
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id ,g.grievance_status_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
				
					AND g.grievance_status_id IN (5,10) 				
					AND g.cat3_id != 0 ";
		
		} else {
			//$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0'";
		
		
			$sql = "SELECT 
					COUNT(DISTINCT g.grievance_id) AS count,g.app_type_id as app_type_id,gt.dept_id ,g.grievance_status_id 
				FROM 
					grievances g
				INNER JOIN 
					".$_SESSION['grievances_trns']." gt 
					ON g.grievance_id = gt.grievance_id
				WHERE 
					g.ulbid = '" . strip_tags($_SESSION['ulbid']) . "' 
					AND g.app_type_id = '1' 
					AND g.grievance_status_id IN (5,10) 
					AND g.cat3_id != 0 ";
		
		}
	} else {
		
			$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status IN(5,10) and cat3_id !='0'";
	}
	
	
	
	
	if ($selectedYear) {
	
		$sql .= " AND date_format(g.date_regd,'%Y') = '" . $selectedYear . "' ";
		
	}	
	
	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	
	$sql .= " group by gt.dept_id";
	$rs = mysqli_query($conn, $sql);
	$tot['transfers']['count']=0;
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['dept_id']]['transfers'] = $row['count'];
		$tot['transfers']['count'] += $row['count'];
	}



//echo "<pre>";print_r($tot['transfers']['count']);echo "</pre>";die();

	$emplist = join("','", $_SESSION['emp_list']);

	$sql = "SELECT dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($_SESSION['user_type'] == 'E' || $_SESSION['user_type'] == 'D') {

		$sql = "SELECT d.dept_id,dept_desc from dept_mst d, hod_emp_map h where h.dept_id = d.dept_id and emp_id IN ('" . $emplist . "')";
	}

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
			$dept_list2[$row['dept_id']] = $row['dept_id'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));




/* foreach($dept_list as $key=>$value){
	echo "<pre>";print_r($value.' -> ');
	echo "<pre>";print_r($data[$key]);echo "</pre>";
}die();
 */





	//echo $sql;
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

	$tpl->display('rep_comp_dept_abs_comp.tpl');

} else {
	

	echo "<script>window.location='index.php';</script>";
}
?>