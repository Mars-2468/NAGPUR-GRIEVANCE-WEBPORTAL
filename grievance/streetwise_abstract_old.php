<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

$user_type = $_SESSION['user_type'];
$ward_name = $_REQUEST['ward_name'];
if (isset($_SESSION['uid'])) {


	session_regenerate_id();
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();

	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
		//$tpl->assign('fdate',date('Y-m-d',strtotime($_REQUEST['f_date'])));
		//$tpl->assign('tdate',date('Y-m-d',strtotime($_REQUEST['t_date'])));

	}
	
	$sql = "select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_id,g.date_regd from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and g.cat3_id !='0' and 
	g.ward_id='" . $_REQUEST['dept_id'] . "'";

	/*$sql ="select COUNT(DISTINCT gt.grievance_id) as count,street_id as emp_id,g.date_regd  from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and
		g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status IN(2,9,8,4,6,10) and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and g.cat3_id !='0' and 
		g.ward_id='".$_REQUEST['dept_id']."'";*/

	/*if (isset($_POST['search'])) 
		{
			if ($ward_name != '') 
			{
				$sql .= " and street_id '" . $ward_name . "' group by g.street_id";
			}
			// $f_date = date('Y-m-d', strtotime($_POST['f_date']));
			// $t_date = date('Y-m-d', strtotime($_POST['t_date']));

			// if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '')
			if ($fdate != '' && $tdate != '') 
			{
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id";
			}
		} 
		else 
		{
			$sql .= " group by g.street_id";
		}*/
	if (isset($_POST['search'])) {
		if ($fdate != '' && $tdate != '') {
			$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id";
		} else {
			$sql .= "group by g.street_id";
		}
	} else {
		$sql .= "group by g.street_id";
	}

	//echo $sql;






	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			$data[$row['emp_id']]['count'] = $row['count'];
			$tot['received'] += $row['count'];
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$emp_ids = array();

	/*$sql1 ="select COUNT(DISTINCT g.grievance_id) as count1,street_id as emp_id,g.date_regd,g.sla_status from grievances g where g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and 
				g.cat3_id !='0' and g.ward_id='".$_REQUEST['dept_id']."' ";*/

	$sql1 = "select COUNT(DISTINCT g.grievance_id) as count1,street_id as emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, 
				  grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
				 gt.disposal_status!='5' and g.cat3_id !='0' and g.ward_id='" . $_REQUEST['dept_id'] . "' ";

	if ($fdate != '' && $tdate != '') {

		$sql1 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id,gt.disposal_status";
	} else {
		$sql1 .= "group by g.street_id";
	}
	//echo $sql1;
	if ($rs1 = mysqli_query($conn, $sql1)) {
		while ($row = mysqli_fetch_assoc($rs1)) {

			//print_r($row['emp_id']);

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

	$sql21 = "select COUNT(DISTINCT g.grievance_id) as count1,street_id as emp_id,g.date_regd,g.sla_status from grievances g where g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			g.ward_id='" . $_REQUEST['dept_id'] . "'  and g.sla_status='1' and grievance_status_id IN('3','9','8')  ";

	/*$sql21 ="select COUNT(DISTINCT g.grievance_id) as count1,street_id as emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt where 
				 g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and 
				 gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'  and g.sla_status='1' and
				 gt.disposal_status IN ('3','9','8')  and grievance_status_id IN('3','9','8')  ";*/

	$sql21 = "SELECT count(DISTINCT g.grievance_id) as count1,street_id as emp_id FROM grievances g where g.ulbid='" . $_SESSION['ulbid'] . "' and 
				g.app_type_id='1' and g.grievance_status_id IN('3','9','8') and g.sla_status=1 and cat3_id !='0' and g.ward_id='" . $_REQUEST['dept_id'] . "'";

	/*$sql21="SELECT count(DISTINCT g.grievance_id) as count1,street_id as emp_id,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
    		app_type_id='1' and grievance_status_id IN('3','9','8') and grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'";*/

	if ($fdate != '' && $tdate != '') {

		$sql21 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id,g.grievance_status_id";
	} else {
		$sql21 .= "group by g.street_id,g.grievance_status_id";
	}



	$rs21 = mysqli_query($conn, $sql21);
	while ($row = mysqli_fetch_assoc($rs21)) {
		$data_list[$row['emp_id']]['completed'] += $row['count1'];
		$tot['completed'] += $row['count1'];
	}
	$sql2 = "SELECT count(DISTINCT g.grievance_id) as count2,street_id as emp_id FROM grievances g where g.ulbid='" . $_SESSION['ulbid'] . "' and 
				g.app_type_id='1' and g.grievance_status_id IN('3','9','8') and g.sla_status=2 and cat3_id !='0' and g.ward_id='" . $_REQUEST['dept_id'] . "'";

	/*$sql2="SELECT count(DISTINCT gt.grievance_id) as count2,street_id as emp_id  FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
    			app_type_id='1' and grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'";*/



	if ($fdate != '' && $tdate != '') {

		$sql2 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id,g.grievance_status_id";
	} else {
		$sql2 .= "group by g.street_id";
	}

	$rs2 = mysqli_query($conn, $sql2);
	while ($row = mysqli_fetch_assoc($rs2)) {
		$data_list[$row['emp_id']]['completed_be_sla'] += $row['count2'];
		$tot['completed_be_sla'] += $row['count2'];
	}
	$sql31 = "SELECT count(DISTINCT g.grievance_id) as count1,street_id as emp_id FROM grievances g where g.ulbid='" . $_SESSION['ulbid'] . "' and 
			g.app_type_id='1' and g.grievance_status_id IN('2') and g.sla_status=1 and g.cat3_id !='0' and g.ward_id='" . $_REQUEST['dept_id'] . "'";

	/*$sql31="SELECT count(DISTINCT g.grievance_id) as count1,street_id as emp_id,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
    				 app_type_id='1' and grievance_status_id IN('2') and 
				 gt.disposal_status IN('2') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'";*/


	if ($fdate != '' && $tdate != '') {

		$sql31 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id,g.grievance_status_id";
	} else {
		$sql31 .= "group by g.street_id,g.grievance_status_id";
	}

	//echo $sql31;   

	$rs31 = mysqli_query($conn, $sql31);
	while ($row = mysqli_fetch_assoc($rs31)) {
		$data_list[$row['emp_id']]['pending'] += $row['count1'];
		$tot['pending'] += $row['count1'];
	}

	$sql3 = "select COUNT(DISTINCT g.grievance_id) as count2,street_id as emp_id,disposal_status,g.date_regd,g.sla_status from grievances g where 
				g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
				g.cat3_id !='0' and g.ward_id='" . $_REQUEST['dept_id'] . "' and grievance_status_id IN('2') and g.sla_status='2' ";

	/*$sql3 ="select COUNT(DISTINCT g.grievance_id) as count2,street_id as emp_id,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt where 
				g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and 
				gt.disposal_status!='5' and g.cat3_id !='0' and g.ward_id='".$_REQUEST['dept_id']."' and gt.disposal_status IN ('2') and grievance_status_id IN('2') and g.sla_status='2' ";*/

	$sql3 = "SELECT count(DISTINCT g.grievance_id) as count2,street_id as emp_id FROM grievances g where g.ulbid='" . $_SESSION['ulbid'] . "' and 
    			g.app_type_id='1' and g.grievance_status_id IN('2') and g.sla_status=2 and g.cat3_id !='0' and g.ward_id='" . $_REQUEST['dept_id'] . "'";

	/*$sql3="SELECT count(DISTINCT g.grievance_id) as count2,street_id as emp_id,disposal_status FROM grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and 
    			app_type_id='1' and grievance_status_id IN('2') and gt.disposal_status IN ('2') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5' and g.ward_id='".$_REQUEST['dept_id']."'";*/

	if ($fdate != '' && $tdate != '') {

		$sql3 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id,g.grievance_status_id";
	} else {
		$sql3 .= "group by g.street_id,g.grievance_status_id";
	}
	//echo $sql3; 
	$rs3 = mysqli_query($conn, $sql3);
	while ($row = mysqli_fetch_assoc($rs3)) {
		$data_list[$row['emp_id']]['pending_be_sla'] += $row['count2'];
		$tot['pending_be_sla'] += $row['count2'];
	}




	// reopened

	$sql = "select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g where g.cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('13') and g.ulbid='" . $_SESSION['ulbid'] . "' and g.ward_id='" . $_REQUEST['dept_id'] . "'";
	//$sql ="select COUNT(DISTINCT gt.grievance_id) as count,street_id  as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('13') and g.grievance_status_id IN('13') and ulbid='".$_SESSION['ulbid']."' and g.ward_id='".$_REQUEST['dept_id']."'";


	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id";
	} else {
		$sql .= "group by g.street_id";
	}
	//echo $sql;


	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopened'] += $row['count'];
		$tot['reopened'] += $row['count'];
	}

	// reopened under progress
	$sql = "select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g where g.cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN('11') and g.ulbid='" . $_SESSION['ulbid'] . "' and g.ward_id='" . $_REQUEST['dept_id'] . "'";
	//$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and gt.disposal_status IN('11') and g.grievance_status_id IN('11') and ulbid='".$_SESSION['ulbid']."' and g.ward_id='".$_REQUEST['dept_id']."'";

	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id";
	} else {
		$sql .= "group by g.street_id";
	}
	//echo $sql;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopened_pending'] += $row['count'];
		$tot['reopened_pending'] += $row['count'];
		//$data_list[$row['emp_dept']]['reopened_pending']=10;
	}


	// reopened Completed
	$sql = "select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g where g.cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and g.ulbid='" . $_SESSION['ulbid'] . "' and g.ward_id='" . $_REQUEST['dept_id'] . "'";
	//$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1'  and g.grievance_status_id IN ('12') and g.grievance_status_id IN('12') and ulbid='".$_SESSION['ulbid']."' and gt.disposal_status NOT IN('5','9') and g.ward_id='".$_REQUEST['dept_id']."'";

	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id";
	} else {
		$sql .= "group by g.street_id";
	}
	//echo $sql;
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {

		$data_list[$row['emp_dept']]['reopened_completed'] += $row['count'];
		$tot['reopened_completed'] += $row['count'];
		//$data_list[$row['emp_dept']]['reopened_pending']=10;
	}


	// rejected
	$sql = "select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g where g.cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('10') and g.ulbid='" . $_SESSION['ulbid'] . "' and g.ward_id='" . $_REQUEST['dept_id'] . "'";
	//$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN ('10') and g.grievance_status_id IN ('10') and gt.disposal_status!='5'  and ulbid='".$_SESSION['ulbid']."' and g.ward_id='".$_REQUEST['dept_id']."'";

	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id";
	} else {
		$sql3 .= "group by g.street_id";
	}
	//echo $sql;
	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_dept']]['rejected'] += $row['count'];
			$tot['rejected'] += $row['count'];
		}
	}

	// pending for approval

	// rejected
	$sql = "select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g where g.cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('1') and g.ulbid IN('" . $_SESSION['ulbid'] . "') and g.ward_id='" . $_REQUEST['dept_id'] . "'";
	//$sql ="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g where  cat3_id !='0' and g.app_type_id='1'  and g.grievance_status_id IN ('1')  and ulbid IN('".$_SESSION['ulbid']."') and g.ward_id='".$_REQUEST['dept_id']."'";


	if ($fdate != '' && $tdate != '') {

		$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id";
	} else {
		$sql3 .= " group by g.street_id";
	}

	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_dept']]['pending_approval'] += $row['count'];
			$tot['pending_approval'] += $row['count'];


			$data[$row['emp_dept']]['count'] += $row['count'];
			$tot['received'] += $row['count'];
		}
	}

	// Financial implications
	$sql3 = "select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g where g.cat3_id !='0' and g.app_type_id='1' 
			 	and g.grievance_status_id IN ('6') and g.ulbid='" . $_SESSION['ulbid'] . "' and g.ward_id='" . $_REQUEST['dept_id'] . "'";

	/*$sql3="select COUNT(DISTINCT g.grievance_id) as count,street_id as emp_dept from grievances g, grievances_transactions gt where 
				g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
			 	and g.grievance_status_id IN ('6') and g.grievance_status_id IN ('6') and ulbid='".$_SESSION['ulbid']."' and gt.disposal_status!='5' and ward_id='".$_REQUEST['dept_id']."'";*/
	//$sql ="select COUNT(DISTINCT g.grievance_id) as count,emp_id as emp_dept from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN ('6') and gt.disposal_status!='5'  and ulbid='".$_SESSION['ulbid']."' and gt.dept_id='".$_REQUEST['dept_id']."'";

	if ($fdate != '' && $tdate != '') {

		$sql3 .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' group by g.street_id";
	} else {
		$sql3 .= "group by g.street_id";
	}
	//echo $sql3;

	if ($rs = mysqli_query($conn, $sql3)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$data_list[$row['emp_dept']]['fin'] += $row['count'];
			$tot['fin'] += $row['count'];
		}
	}





	// print_r($emp_ids);

	$sql = "select street_id,street_desc from street_mst where ward_id like '" . $_REQUEST['dept_id'] . "'";
	//12-03-24 $sql="select street_id,street_desc from street_mst where ward_id like '".$_REQUEST['dept_id']."' and street_desc like '%" . $ward_name . "%'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$street_list[$row['street_id']] = $row['street_desc'];
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
	$tpl->assign('ward_name', $_REQUEST['ward_name']);
	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
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
	$tpl->display('streetwise_abstract.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
