<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Calcutta');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {


	//session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
		$tpl->assign('fdate', date('Y-m-d', strtotime($_REQUEST['f_date'])));
		$tpl->assign('tdate', date('Y-m-d', strtotime($_REQUEST['t_date'])));
	}
	/********** Complaints Received **********************/

	/*$sql ="select COUNT(DISTINCT gt.grievance_id) as count,street_id as emp_id,g.date_regd  from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
			g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and g.cat3_id !='0' and 
			g.ward_id='".$_REQUEST['dept_id']."'";*/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id from grievances g, grievances_transactions gt , emp_mst m , desg_mst d , grievance_status_mst gs where 
		 	g.grievance_id=gt.grievance_id and g.grievance_status_id = gs.grievance_status_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' 
		 	and g.grievance_status_id NOT IN(1) and gt.disposal_status NOT IN(5,11,12,13) and cat3_id !='0' and m.emp_desg='" . $_REQUEST['dept_id'] . "'";


	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg";
	} else {
		//$sql.=" group by g.street_id";
		$sql .= " group by emp_desg";
	}

	//echo $sql;		 

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['emp_id']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	/********** Complaints Unresolved / Unresolvable **********************/

	$emp_ids = array();
	/*$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, 
				grievances_transactions gt where 
				g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and 
				gt.disposal_status!='5' and g.cat3_id !='0' and g.ward_id='".$_REQUEST['dept_id']."' ";*/


	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id from grievances g, grievances_transactions gt , emp_mst m , desg_mst d , grievance_status_mst gs where 
		 		g.grievance_id=gt.grievance_id and g.grievance_status_id = gs.grievance_status_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' 
		 		and g.grievance_status_id IN('4') and gt.disposal_status NOT IN(5,11,12,13) and cat3_id !='0' and m.emp_desg='" . $_REQUEST['dept_id'] . "'";
	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id,gt.disposal_status";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg";
	} else {
		//$sql.="group by g.street_id,gt.disposal_status";
		$sql .= " group by emp_desg";
	}

	if ($rs1 = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs1)) {

			//print_r($row['emp_id']);

			if ($row['emp_id'] > 0 || $row['emp_id'] != '') {
				$emp_ids[$row['emp_id']] = $row['emp_id'];
			} else {
				$row['emp_id'] = 0;
				$emp_ids[$row['emp_id']] = $row['emp_id'];
			}

			if ($row['disposal_status'] == 4) {
				$data_list[$row['emp_id']]['unresolved'] = $row['count'];
				$tot['unresolved'] += $row['count'];
			}

			/*
		     if($row['disposal_status']==2)
			    {
			         $data_list[$row['emp_id']]['pending']+=$row['count'];
			         $tot['pending']+=$row['count'];
			    }
			    
			    */
		}

		//print_r($emp_ids);
		//echo $sql;

	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	/********** Completed Within SLA Complaints **********************/


	/*$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and 
			gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'  and g.sla_status='1' and
			gt.disposal_status IN ('3','9','8')  and grievance_status_id IN('3','9','8')  ";*/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id from grievances g, grievances_transactions gt , emp_mst m , desg_mst d , grievance_status_mst gs where 
		 	g.grievance_id=gt.grievance_id and g.grievance_status_id = gs.grievance_status_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' 
		 	and g.grievance_status_id NOT IN('3','9','8') and gt.disposal_status NOT IN(5,11,12,13) and cat3_id !='0' and sla_status=1 and m.emp_desg='" . $_REQUEST['dept_id'] . "'";

	/*$sql="SELECT count(DISTINCT g.grievance_id) as count,street_id as emp_id,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
    			app_type_id='1' and grievance_status_id IN('3','9','8') and grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'";*/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id !='0' and grievance_status_id IN('3','9','8') and gt.disposal_status NOT IN(5,11,12,13) and sla_status=1 and m.emp_desg='" . $_REQUEST['dept_id'] . "'";
	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id,gt.disposal_status";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql.="group by g.street_id,gt.disposal_status";
		$sql .= "group by emp_desg,g.grievance_status_id";
	}

	//echo $sql;   

	$rs21 = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs21)) {
		$data_list[$row['emp_id']]['completed'] += $row['count'];
		$tot['completed'] += $row['count'];
	}

	/********** Completed Beyond SLA Complaints **********************/

	/*$sql="SELECT count(DISTINCT gt.grievance_id) as count,street_id as emp_id  FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
    				 app_type_id='1' and grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'";*/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
				emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
				and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id !='0' and grievance_status_id IN('3','9','8') and gt.disposal_status NOT IN(5,11,12,13) and sla_status=2 and m.emp_desg='" . $_REQUEST['dept_id'] . "'";

	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id,gt.disposal_status";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql.="group by g.street_id";
		$sql .= "group by emp_desg";
	}

	$rs2 = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs2)) {
		$data_list[$row['emp_id']]['completed_be_sla'] += $row['count'];
		$tot['completed_be_sla'] += $row['count'];
	}

	/********** Pending Complaints **********************/

	/*$sql="SELECT count(DISTINCT g.grievance_id) as count,street_id as emp_id,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
    			app_type_id='".$_REQUEST['app_type_id']."' and grievance_status_id IN('2') and 
			gt.disposal_status IN('2') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'";*/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id !='0' and grievance_status_id IN('2') and gt.disposal_status NOT IN(5,11,12,13) and sla_status=1 and m.emp_desg='" . $_REQUEST['dept_id'] . "'";


	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id,gt.disposal_status";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql.="group by g.street_id,gt.disposal_status";
		$sql .= "group by emp_desg";
	}

	// echo $sql;   

	$rs31 = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs31)) {
		$data_list[$row['emp_id']]['pending'] += $row['count'];
		$tot['pending'] += $row['count'];
	}


	/********** Pending Be SLA Complaints **********************/

		/*$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and 
		gt.disposal_status!='5' and g.cat3_id !='0' and g.ward_id='".$_REQUEST['dept_id']."' and gt.disposal_status IN ('2') and grievance_status_id IN('2') and g.sla_status='2' ";*/

		$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
		emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
		and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id !='0' and grievance_status_id IN('2') and gt.disposal_status NOT IN(5,11,12,13) and sla_status=2 and m.emp_desg='" . $_REQUEST['dept_id'] . "'";

		/*$sql="SELECT count(DISTINCT g.grievance_id) as count,street_id as emp_id,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
		app_type_id='1' and grievance_status_id IN('2') and gt.disposal_status IN ('2') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'"; */

		$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
		emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
		and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id !='0' and grievance_status_id IN('2') and gt.disposal_status NOT IN(5,11,12,13) and sla_status=2 and m.emp_desg='" . $_REQUEST['dept_id'] . "'";

		if ($fdate != '' && $tdate != '') {

		//$sql3.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id,gt.disposal_status";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql3.="group by g.street_id,gt.disposal_status";
		$sql .= "group by emp_desg";
	}

	$rs3 = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs3)) {
		$data_list[$row['emp_id']]['pending_be_sla'] += $row['count'];
		$tot['pending_be_sla'] += $row['count'];
	}

	/********** Complaints Reopend **********************/

	//$sql ="select COUNT(DISTINCT gt.grievance_id) as count,street_id as emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('13')  and g.grievance_status_id IN('13') and ulbid='".$_SESSION['ulbid']."' and g.ward_id='".$_REQUEST['dept_id']."'";

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
				emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
				and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id !='0' and grievance_status_id IN('13') and gt.disposal_status IN('13') and sla_status=2 and m.emp_desg='" . $_REQUEST['dept_id'] . "'";

	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql3.="group by g.street_id";
		$sql .= "group by emp_desg";
	}
	//echo $sql;

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_id']]['reopened'] += $row['count'];
		$tot['reopened'] += $row['count'];
	}

	/********** Reopened UnderProgress Complaints **********************/


	//$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('11') and g.grievance_status_id IN('11') and ulbid='".$_SESSION['ulbid']."' and g.ward_id='".$_REQUEST['dept_id']."'";

	/*$sql ="select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
				emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
				and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and cat3_id !='0' and grievance_status_id IN('11') and gt.disposal_status IN('11') and sla_status=2 and emp_desg='".$_REQUEST['dept_id']."'";*/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,g.grievance_status_id,disposal_status from grievances g, grievances_transactions gt , 
				emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
				and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and g.grievance_status_id IN('11') and gt.disposal_status IN('11','2') and cat3_id !='0' and emp_desg='" . $_REQUEST['dept_id'] . "'";

	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql.="group by g.street_id";
		$sql .= "group by emp_desg";
	}

	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_id']]['reopened_pending'] += $row['count'];
		$tot['reopened_pending'] += $row['count'];
		//$data_list[$row['emp_id']]['reopened_pending']=10;
	}
	//echo $sql;


	/********** Reopened Completed Complaints **********************/

	//$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and gt.disposal_status IN('12') and ulbid='".$_SESSION['ulbid']."' and g.ward_id='".$_REQUEST['dept_id']."'";

	/*$sql ="select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
				emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
				and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and cat3_id !='0' and grievance_status_id IN('12') and gt.disposal_status NOT IN('5','9','13') and gt.disposal_status!='5' and m.emp_desg='".$_REQUEST['dept_id']."'";*/

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,grievance_status_id from grievances g, grievances_transactions gt , 
				emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
				and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='1' and cat3_id !='0' and grievance_status_id IN('12') and gt.disposal_status IN('5','9','13') and gt.disposal_status!='5' and m.emp_desg='" . $_REQUEST['dept_id'] . "'";

	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql.="group by g.street_id";
		$sql .= "group by emp_desg";
	}
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_id']]['reopened_completed'] += $row['count'];
		$tot['reopened_completed'] += $row['count'];
		//$data_list[$row['emp_id']]['reopened_completed']=10;
	}
	//echo $sql;

	/********* REJECTED ***********/

	//$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN ('10') and g.grievance_status_id IN ('10') and gt.disposal_status!='5'  and ulbid='".$_SESSION['ulbid']."' and g.ward_id='".$_REQUEST['dept_id']."'";

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id !='0' and grievance_status_id IN('10') and gt.disposal_status IN('10') and gt.disposal_status!='5' and m.emp_desg='" . $_REQUEST['dept_id'] . "'";

	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql.="group by g.street_id";
		$sql .= "group by emp_desg";
	}

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_id']]['rejected'] += $row['count'];
			$tot['rejected'] += $row['count'];
		}
	}

	/********** Pending For Approval Complaints **********************/

	//$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g where  cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('1')  and ulbid IN('".$_SESSION['ulbid']."') and g.ward_id='".$_REQUEST['dept_id']."'";

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
				emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
				and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id !='0' and grievance_status_id IN('1') and gt.disposal_status NOT IN(5,11,12,13) and sla_status=1 and m.emp_desg='" . $_REQUEST['dept_id'] . "'";

	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql.=" group by g.street_id";
		$sql .= "group by emp_desg";
	}

	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_id']]['pending_approval'] += $row['count'];
			$tot['pending_approval'] += $row['count'];


			$data[$row['emp_id']]['count'] += $row['count'];
			$tot['received'] += $row['count'];
		}
	}

	/********** Financial Implication Complaints **********************/

	/*$sql="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
			and g.grievance_status_id IN ('6') and g.grievance_status_id IN ('6') and ulbid='".$_SESSION['ulbid']."' and gt.disposal_status!='5' and ward_id='".$_REQUEST['dept_id']."'";*/

	//$sql ="select COUNT(g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN ('6') and gt.disposal_status!='5' and ulbid='".$_SESSION['ulbid']."' and gt.dept_id='".$_REQUEST['dept_id']."'";

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,emp_desg as emp_id,disposal_status from grievances g, grievances_transactions gt , 
			emp_mst m , desg_mst d where g.grievance_id=gt.grievance_id and gt.dept_id=m.emp_dept and gt.emp_id = m.emp_id and m.emp_desg = d.desg_id 
			and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and cat3_id !='0' and grievance_status_id IN('6') and gt.disposal_status IN('6') and gt.disposal_status!='5' and m.emp_desg='" . $_REQUEST['dept_id'] . "'";

	if ($fdate != '' && $tdate != '') {

		//$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' group by g.street_id";
		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by emp_desg,g.grievance_status_id";
	} else {
		//$sql.="group by g.street_id";
		$sql .= "group by emp_desg";
	}
	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_id']]['fin'] += $row['count'];
			$tot['fin'] += $row['count'];
		}
	}





	// print_r($emp_ids);

	//$sql="select street_id,street_desc from street_mst where ward_id like '".$_REQUEST['dept_id']."'";
	$sql = "select desg_id,desg_desc from desg_mst where desg_id like '" . $_REQUEST['dept_id'] . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			//$street_list[$row['street_id']]=$row['street_desc'];
			$street_list[$row['desg_id']] = $row['desg_desc'];
	}










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

	//	print_r($online_applications);
	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('online_applications', $online_applications);

	mysqli_close($conn);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet', '3' => 'Both'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('tot', $tot);
	$tpl->assign('street_list', $street_list);
	$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
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
	$tpl->display('desgnwise_abstract.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
