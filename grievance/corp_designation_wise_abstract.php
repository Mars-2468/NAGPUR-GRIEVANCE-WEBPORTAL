<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {


	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	$ward_id=$_SESSION['zone_id']??'';
	/********** Complaints Received **********************/

	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_desg as emp_dept,disposal_status from grievances g, grievances_transactions gt , emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id and g.ulbid='250' and g.app_type_id='1' and cat3_id !='0' and gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and gt.disposal_status!='5' ";
	
	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
			$tpl->assign('fdate', date('Y-m-d', strtotime($_POST['f_date'])));
			$tpl->assign('tdate', date('Y-m-d', strtotime($_POST['t_date'])));
		}
	}

	$sql .= "group by emp_desg;";
	$tot['received']=0;
	$data=[];
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['emp_dept']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	/********** Complaints Reopend **********************/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_dept,disposal_status from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and g.grievance_status_id IN('13') and gt.disposal_status IN('13') and gt.disposal_status!='5' ";
	
	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {
			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";

	$rs1 = mysqli_query($conn, $sql);
	
	$data_list=[];
	
	while ($row = mysqli_fetch_assoc($rs1)) {
		$data_list[$row['emp_dept']]['reopened'] += $row['count'];
		$tot['reopened'] += $row['count'];
	}

	/********** Complaints Unresolved / Unresolvable **********************/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_dept,g.grievance_status_id,disposal_status from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and g.grievance_status_id IN('4') and gt.disposal_status IN('4') and gt.disposal_status!='5'";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";

	//echo $sql;


	$rs2 = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs2)) {
		$data_list[$row['emp_dept']]['unresolved'] = $row['count'];
		$tot['unresolved'] += $row['count'];
	}

	/********** Financial Implication Complaints **********************/

	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_desg as emp_dept,g.grievance_status_id,disposal_status from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id  and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and g.grievance_status_id IN('6') and gt.disposal_status IN('6') and gt.disposal_status!='5'";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";

	$rs3 = mysqli_query($conn, $sql);
			
	$tot['fin']=0;
	
	while ($row = mysqli_fetch_assoc($rs3)) {
		$data_list[$row['emp_dept']]['fin'] = $row['count'];
		$tot['fin'] += $row['count'];
	}

	/********* REJECTED ***********/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_dept,disposal_status from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and gt.disposal_status IN ('10') and g.grievance_status_id IN('10') and gt.disposal_status!='5'";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";
	$tot['rejected']=0;
	if ($rs4 = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs4)) {

			$data_list[$row['emp_dept']]['rejected'] = $row['count'];
			$tot['rejected'] += $row['count'];
		}
	}

	/********** Completed Within SLA Complaints **********************/

	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_desg as emp_dept,disposal_status from grievances g, grievances_transactions gt , 
	emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
	and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=1 and gt.disposal_status!='5'";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";
	$tot['completed']=0;
	if ($rs5 = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs5)) {
			$data_list[$row['emp_dept']]['completed'] = $row['count'];
			$tot['completed'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	/********** Completed Beyond SLA Complaints **********************/

	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_desg as emp_dept,disposal_status from grievances g, grievances_transactions gt , 
		emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id  and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
		and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=2 and gt.disposal_status!='5'";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";
	//echo $sql;

	$rs6 = mysqli_query($conn, $sql);
	$tot['completed_be_sla']=0;
	while ($row = mysqli_fetch_assoc($rs6)) {
		$data_list[$row['emp_dept']]['completed_be_sla'] = $row['count'];
		$tot['completed_be_sla'] += $row['count'];
	}

	/********** Pending Complaints **********************/

	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_desg as emp_dept,disposal_status from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id  and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and g.grievance_status_id IN('2') and gt.disposal_status IN('2') and sla_status=1 and gt.disposal_status!='5'";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";
	
	$rs7 = mysqli_query($conn, $sql);
	$tot['pending']=0;
	while ($row = mysqli_fetch_assoc($rs7)) {
		$data_list[$row['emp_dept']]['pending'] = $row['count'];
		$tot['pending'] += $row['count'];
	}

	/********** Pending_Be Complaints **********************/

	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_desg as emp_dept,disposal_status from grievances g, grievances_transactions gt , 
		emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id  and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
		and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and g.grievance_status_id IN('2') and gt.disposal_status IN('2') and sla_status=2 and gt.disposal_status!='5'";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";
	//echo $sql;

	$rs8 = mysqli_query($conn, $sql);
	//var_dump($row = mysqli_fetch_assoc($rs8));
	$tot['pending_be']=0;
	while ($row = mysqli_fetch_assoc($rs8)) {
		$data_list[$row['emp_dept']]['pending_be'] = $row['count'];
		$tot['pending_be'] += $row['count'];
	}

	/********** Pending For Approval Complaints **********************/
	
	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_desg as emp_dept,disposal_status from grievances g, grievances_transactions gt , 
		emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id  and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
		and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and g.grievance_status_id IN('1')  ";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
		}
	}
	
	$sql .= " group by emp_desg";
		
	$tot['pending_approval']=0;
	$rs9 = mysqli_query($conn, $sql);
	
	while ($row = mysqli_fetch_assoc($rs9)) {
		$data_list[$row['emp_dept']]['pending_approval'] = $row['count'];
		$tot['pending_approval'] += $row['count'];
		//$data[$row['emp_dept']]['count'] += $row['count'];
		//$tot['received'] += $row['count'];
	}

	/********** Reopened UnderProgress Complaints **********************/

	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_desg as emp_dept,g.grievance_status_id,disposal_status from grievances g, grievances_transactions gt , 
	emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id  and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
	and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and g.grievance_status_id IN('11') and gt.disposal_status IN('11','2') and cat3_id !='0'";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";

	$tot['reopend_underProgress']=0;
	$rs10 = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs10)) {
		$data_list[$row['emp_dept']][$row['grievance_status_id']]['reopend_underProgress'] = $row['count'];
		$tot['reopend_underProgress'] += $row['count'];
	}

	/********** Reopened Completed Complaints **********************/

	$sql = "select COUNT(DISTINCT gt.grievance_id) as count,emp_desg as emp_dept,grievance_status_id from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id  and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and grievance_status_id IN('12') and gt.disposal_status IN('5','9','13') and gt.disposal_status!='5'";

	if($ward_id!=''){
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if (isset($_POST['search'])) {

		$f_date = date('Y-m-d', strtotime($_POST['f_date']));
		$t_date = date('Y-m-d', strtotime($_POST['t_date']));

		if ($f_date != '' && $t_date != '') {

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
		}
	}

	$sql .= " group by emp_desg";

	$rs11 = mysqli_query($conn, $sql);
	$tot['reopend_completed']['count']=0;
	while ($row = mysqli_fetch_assoc($rs11)) {
		$data_list[$row['emp_dept']]['reopend_completed'] = $row['count'];
		$tot['reopend_completed']['count'] += $row['count'];
	}

	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "' order by dept_id";

	if ($_SESSION['user_type'] == 'E' || $_SESSION['user_type'] == 'D') {
		$sql = "select * from emp_desg_map wc,dept_mst w where w.dept_id=wc.dept_id and emp_id ='" . $_SESSION['uid'] . "'";
	}

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "SELECT desg_id, desg_desc FROM `desg_mst`";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$dept_list[$row['desg_id']] = $row['desg_desc'];
	}

	$sql = "select * from grievance_status_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs = mysqli_query($conn, $sql);
	$online_applications =[];
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}
	//	print_r($online_applications);
	$tpl->assign('user_type', $_SESSION['user_type']);
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
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('corp_designation_wise_abstract.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
