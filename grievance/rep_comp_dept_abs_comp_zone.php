rep_comp_dept_abs_comp_zone.php
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
		/*18-03-24 $sql ="SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' 
		and gt.disposal_status NOT IN('5','11','12','13') and cat3_id !='0'";*/

		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' 
		and gt.disposal_status != 5 and cat3_id !='0'";

		/*$sql ="SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' 
		and gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and cat3_id !='0'";*/
	} else {
		/*28-03-24 $sql ="SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and 
		gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and cat3_id !='0'";*/

		/*22-04-24 $sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and gt.disposal_status != 5 and cat3_id !='0'";*/

		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "'  and dept_id IN( $deptlist ) and g.app_type_id='1' and gt.disposal_status != 5 and cat3_id !='0'";
	}
	if (isset($_POST['search'])) {
		/*$f_date = date('Y-m-d',strtotime($_POST['f_date']));
		$t_date = date('Y-m-d',strtotime($_POST['t_date']));

		if($f_date!= '' && $t_date!='')
		{
			$sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			$tpl->assign('fdate',date('Y-m-d',strtotime($_POST['f_date'])));
			$tpl->assign('tdate',date('Y-m-d',strtotime($_POST['t_date'])));
		}*/
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

	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count1,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, 
		grievances_transactions gt,cs_mst c where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and 
		g.sla_status='1' and gt.disposal_status!='5' and cat3_id !='0' and gt.disposal_status IN('3','9','8') and gt.disposal_status IN('3','9','8')";
	} else {
		/*22-04-24 $sql="SELECT count(DISTINCT g.grievance_id) as count1,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";*/

		/*11-04-24 $sql = "SELECT count(DISTINCT g.grievance_id) as count1,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
	}*/
	if ($user_type == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
	} else {
		/*22-04-24 $sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";*/

		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and dept_id IN( $deptlist ) and cat3_id !='0' and gt.disposal_status!='5'";
	}


	/*if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/
	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	//$sql.=" group by gt.dept_id,gt.disposal_status";
	$sql .= " group by gt.dept_id";


	//echo $sql;






	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data_list[$row['emp_dept']]['completed'] += $row['count'];
			$tot['completed'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));



	/// reopend complaints

	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql = "SELECT COUNT(g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('9','12') and
		is_reopened_yn='1' and g.grievance_status_id IN('13') and gt.disposal_status IN('13') and ulbid IN('208','210') and gt.disposal_status!='5' ";
	} else {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and gt.disposal_status IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' ";
	}*/
	if ($user_type == 'U') {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' ";
	} else {
		/*22-04-24 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' ";*/

		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5' ";
	}

	/*if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by gt.dept_id";

	//echo $sql;


	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['reopened'] += $row['count'];
		$tot['reopened'] += $row['count'];
	}




	/// unresolvable complaints
	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql = "SELECT COUNT(g.grievance_id) as count1,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
		and g.grievance_status_id IN ('4') and gt.disposal_status IN ('4') and ulbid IN('208','210') and gt.disposal_status!='5'";
	} else {
		$sql = "SELECT COUNT(g.grievance_id) as count1,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('4') and gt.disposal_status IN ('4') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5'";
	}*/

	if ($user_type == 'U') {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('4') and gt.disposal_status IN ('4') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5'";
	} else {
		/*22-04-24 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('4') and gt.disposal_status IN ('4') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5'";*/

		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('4') and gt.disposal_status IN ('4') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5'";
	}

	/*if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by gt.dept_id";
	//echo $sql ;


	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['unresolved']+=$row['count'];
		$tot['unresolved']+=$row['count'];
	}





	/********** FIN IMPLICATION **********************/



	/// unresolvable complaints
	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count1,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
		and g.grievance_status_id IN ('6') and gt.disposal_status IN (6) and ulbid IN('208','210') and gt.disposal_status!='5' ";
	} else {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count1,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('6') and gt.disposal_status IN (6) and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' ";
	}*/

	if ($user_type == 'U') {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.app_type_id='1' and g.grievance_status_id IN ('6') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' and cat3_id !='0'";
	} else {
		/*22-04-24 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.app_type_id='1' and g.grievance_status_id IN ('6') and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status!='5' and cat3_id !='0'";*/

		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.app_type_id='1' and g.grievance_status_id IN ('6') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5' and cat3_id !='0'";
	}

	/*if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by gt.dept_id";
	//echo $sql;



	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['fin'] += $row['count'];
		$tot['fin'] += $row['count'];
	}


	/********* REJECTED ***********/
	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count2,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' 
		and gt.disposal_status IN ('10') and g.grievance_status_id IN('10') and gt.disposal_status!='5'  and ulbid IN('208','210')";
	} else {
		$sql = "SELECT COUNT(DISTINCT DISTINCT gt.grievance_id) as count2,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN ('10') and g.grievance_status_id IN('10') and gt.disposal_status!='5'  and ulbid='" . $_SESSION['ulbid'] . "'";
	}*/

	if ($user_type == 'U') {
		$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('10') and gt.disposal_status!='5'  and ulbid='" . $_SESSION['ulbid'] . "'";
	} else {
		/*22-04-24 $sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('10') and gt.disposal_status!='5'  and ulbid='" . $_SESSION['ulbid'] . "'";*/

		$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('10') and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and gt.disposal_status!='5'";
	}

	/*if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by gt.dept_id";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_dept']]['rejected'] += $row['count'];
			$tot['rejected'] += $row['count'];
		}
	}


	// complaints completed beyond sla
	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count3,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt,cs_mst c where 
		g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and g.sla_status='2' and gt.disposal_status!='5' and cat3_id !='0'
		and (is_reopened_yn=0 or is_reopened_yn is NULL) and gt.disposal_status IN('3','9','8') and g.grievance_status_id IN('3','9','8')";
	} else {*/
		/*	$sql="SELECT count(DISTINCT g.grievance_id) as count3,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
		app_type_id='1' and grievance_status_id IN('3','9','8') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5'";  */

		// $sql="SELECT count(DISTINCT g.grievance_id) as count3,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
		// app_type_id='1' and grievance_status_id IN('3','9','8') and g.grievance_status_id IN('3','9','8') and g.grievance_status_id IN('3','9','8') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5'"; 

		/*22-04-24 $sql = "SELECT count(DISTINCT g.grievance_id) as count3,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and sla_status=2 and cat3_id !='0' and gt.disposal_status IN ('3','8','9') and g.grievance_status_id IN('3','8','9') and cat3_id !='0'";*/

		/*$sql ="SELECT COUNT(DISTINCT gt.grievance_id) as count3,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt,cs_mst c where 
		g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and g.sla_status='2' and gt.disposal_status!='5' and cat3_id !='0'
		and gt.disposal_status IN('3','9','8') and (is_reopened_yn=0 or is_reopened_yn is NULL)";*/
	/*}*/

	if ($user_type == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status != 5 and cat3_id !='0'";
	} else {
		/*22-04-24 $sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status != 5 and cat3_id !='0'";*/

		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and 
		app_type_id='1' and g.grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status != 5 and cat3_id !='0'";
	}


	/*if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
	}
	$sql .= " group by gt.dept_id";

	//echo $sql;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['completed_be_sla'] += $row['count'];
		$tot['completed_be_sla'] += $row['count'];
	}



	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql6 = "SELECT COUNT(DISTINCT gt.grievance_id) as count2,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, 
		grievances_transactions gt,cs_mst c where 
		g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and 
		gt.disposal_status!='5' and cat3_id !='0'
		and gt.disposal_status IN('2') and g.grievance_status_id IN('2') and g.sla_status = '1' ";
	} else {*/
		/*18-03-24 $sql6 = "SELECT count(g.grievance_id) as count2,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and grievance_status_id IN('2') and gt.disposal_status IN('2') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";*/

		/*22-04-24 $sql6 = "SELECT count(g.grievance_id) as count2,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";*/

		/*$sql6 ="SELECT COUNT(DISTINCT gt.grievance_id) as count2,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, 
		grievances_transactions gt,cs_mst c where 
		g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and 
		gt.disposal_status!='5' and cat3_id !='0'
		and gt.disposal_status IN('2') and g.sla_status = '1' ";*/
	/*}*/

	if ($user_type == 'U') {
		$sql = "SELECT count(g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('2') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
	} else {
		/*22-04-24 $sql = "SELECT count(g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('2') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";*/

		$sql = "SELECT count(g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and 
		app_type_id='1' and g.grievance_status_id IN('2') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
	}

	/*if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql6 .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	$sql .= " group by gt.dept_id";

	//echo $sql;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['pending'] += $row['count'];

		$tot['pending'] += $row['count'];
	}


	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql11 = "SELECT COUNT(DISTINCT gt.grievance_id) as count2,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt,cs_mst c where 
		g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and gt.disposal_status!='5' and cat3_id !='0'
		and gt.disposal_status IN('2') and g.grievance_status_id IN('2') and g.sla_status = '2' ";
	} else {*/
		/*22-04-24 $sql11 = "SELECT count(g.grievance_id) as count2,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and grievance_status_id IN('2') and gt.disposal_status IN('2') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5'";*/

		/*$sql11 ="SELECT COUNT(DISTINCT gt.grievance_id) as count2,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt,cs_mst c where 
		g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and gt.disposal_status!='5' and cat3_id !='0'
		and gt.disposal_status IN('2') and g.sla_status = '2' ";*/
	/*}*/

	if ($user_type == 'U') {
		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5'";
	} else {
		/*22-04-24 $sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5'";*/

		$sql = "SELECT count(DISTINCT g.grievance_id) as count,dept_id as emp_dept FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) and 
		app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5'";
	}

	/*if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	$sql .= " group by gt.dept_id";
	//echo $sql11;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$data_list[$row['emp_dept']]['pending_be'] += $row['count'];
		$tot['pending_be'] += $row['count'];
	}

	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and
		gt.disposal_status IN('11') and grievance_status_id IN('11') and ulbid IN('208','210') ";
	} else {*/
		/*$sql ="SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and
		g.grievance_status_id IN('11')  and gt.disposal_status IN('11') and ulbid='".$_SESSION['ulbid']."' ";*/

		/*28-03-24 $sql ="SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and
		g.grievance_status_id IN('11') and gt.disposal_status IN('11') and ulbid='".$_SESSION['ulbid']."' ";*/

		/*22-04-24 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and
		g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and ulbid='" . $_SESSION['ulbid'] . "' ";
	}*/

	if ($user_type == 'U') {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' 
		and g.app_type_id='1' and g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' ";
	} else {
		/*22-04-24 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' 
		and g.app_type_id='1' and g.grievance_status_id IN('11') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' ";*/

		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and dept_id IN( $deptlist ) 
		and g.app_type_id='1' and g.grievance_status_id IN('11') and gt.disposal_status !=5 and cat3_id !='0' ";
	}

	/*if(isset($_POST['search']))
	{
		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	$sql .= " group by emp_dept";
	//echo $sql;



	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']][$row['grievance_status_id']]['reopend_underProgress'] += $row['count'];
		$tot[$row['grievance_status_id']]['reopend_underProgress'] += $row['count'];
		$i += $row['count'];
	}



	// reopened completed

	/*22-04-24 if ($_SESSION['ulbid'] == '3') {
		$sql = "SELECT COUNT(g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and gt.disposal_status IN('12') and ulbid IN('208','210') and gt.disposal_status NOT IN('5','9','13')";
	} else {
		$sql = "SELECT COUNT(DISTINCT gt.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
		grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12')  and ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status NOT IN('5','9','13')";
	}*/

	if ($user_type == 'U') {
		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' 
		and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' ";
	} else {
		/*22-04-24 $sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' 
		and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and cat3_id !='0' ";*/

		$sql = "SELECT COUNT(DISTINCT g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and dept_id IN( $deptlist ) 
		and g.app_type_id='1' and g.grievance_status_id IN('12') and gt.disposal_status IN('9') and cat3_id !='0' ";
	}

	/*if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}*/

	if (isset($_POST['search'])) {
		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	$sql .= " group by gt.dept_id,gt.disposal_status";
	//echo $sql;



	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopend_completed'] += $row['count'];
		$tot['reopend_completed']['count'] += $row['count'];
	}


	$emplist = join("','", $_SESSION['emp_list']);

	$sql = "SELECT dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($_SESSION['user_type'] == 'E' || $_SESSION['user_type'] == 'D') {

		//$sql="SELECT d.dept_id,dept_desc from dept_mst d, hod_emp_map h where h.dept_id = d.dept_id and emp_id='".$_SESSION['emp_id']."'";
		$sql = "SELECT d.dept_id,dept_desc from dept_mst d, hod_emp_map h where h.dept_id = d.dept_id and emp_id IN ('" . $emplist . "')";
	}

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
			$dept_list2[$row['dept_id']] = $row['dept_id'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	//echo $sql;
	$dept_list1 = $dept_list2;
	//$deptlist = join("','",$_SESSION['emp_list']);
	//$deptlist  =join(',',$dept_list1 );
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

	//$tpl->display('rep_comp_dept_abs.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
