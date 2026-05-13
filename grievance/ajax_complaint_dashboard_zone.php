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
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('get_services.php');
$obj = new get_services($_SESSION['uid']);
require_once('connection.php');
$conn = getconnection();

// 		print_r($_SESSION);

$mergedulbs = 900;
// Total received

//echo $_SESSION['emp_id'] ;

//$emplist =join(',',$_SESSION['emp_list']);
$emplist = join("','", $_SESSION['emp_list']);
$sql = "SELECT ward_id,emp_id FROM ward_comm_map where emp_id IN ('" . $emplist . "') ";
if ($_SESSION['user_type'] == 'E') {
	$sql = "SELECT d.ward_id from ward_mst d, ward_comm_map h where h.ward_id = d.ward_id and emp_id IN ('" . $emplist . "')";
}
if ($rs = mysqli_query($conn, $sql)) {
	while ($row = mysqli_fetch_assoc($rs))
		$dept_list[$row['ward_id']] = $row['ward_id'];
}
//echo $sql;
$deptlist = implode(',', $dept_list);
//print_r($deptlist);

if ($_SESSION['user_type'] == 'A') {


	//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1'";
	$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances where app_type_id='1' and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'U') {

	if ($_SESSION['ulbid'] == (int)$mergedulbs) {
		$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and app_type_id='1' and cat3_id !='0' ";
	} else {

		$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances where ulbid='" . strip_tags($_SESSION['ulbid']) . "' and app_type_id='1' and cat3_id !='0' ";
	}
} else if ($_SESSION['user_type'] == 'E') {


	// $sql="SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g,cs_mst c,ulbmst u where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='1'";

	/*01-03-24 $sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN($deptlist) and gt.disposal_status IN(2,9,8,4,6,10) 
	and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and app_type_id='1' and cat3_id !='0'";

	$sql_od = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN($deptlist) and gt.disposal_status IN(2,9,8,4,6,10) 
	and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and app_type_id='1' and cat3_id !='0'";

	$esc_sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN($deptlist) and app_type_id='1' and cat3_id !='0' and gt.disposal_status IN(2,9,8,4,6,10) 
	and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11)";*/

	$sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status != '5' and app_type_id='1' and cat3_id !='0'";

	$sql_od = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status != '5' and app_type_id='1' and cat3_id !='0'";

	$esc_sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and app_type_id='1' and cat3_id !='0' and gt.disposal_status NOT IN('5') and gt.is_escalated=1";
} else if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'M') {
	//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";

	//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1'";
	$sql = "SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

//echo $sql;

$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {


	$data[$row['app_type_id']]['total_received'] = $row['date_regd'];
}
$esc_total = 0;

if ($_SESSION['user_type'] == 'E') {
	$esc_rs = mysqli_query($conn, $esc_sql);
	while ($row2 = mysqli_fetch_assoc($esc_rs)) {
		$esc_total = $data[$row['app_type_id']]['total_received'] + $row2['date_regd'];
	}
}


if ($data[1]['total_received'] == '') {
	$data[1]['total_received'] = 0;
}


//Daily Received Grievances

$date = date('Y-m-d');

if ($_SESSION['user_type'] == 'A') {

	//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1'";
	$sql = "SELECT count(DISTINCT grievance_id) as date_regd,app_type_id FROM grievances where DATE(date_regd) = '".$date."' and app_type_id='1' and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'U') {

	if ($_SESSION['ulbid'] == (int)$mergedulbs) {
		$sql = "SELECT count(DISTINCT grievance_id) as date_regd,app_type_id FROM grievances where DATE(date_regd) = '".$date."' and ulbid IN('208','210') and app_type_id='1' and cat3_id !='0' ";
	} else {
		$sql = "SELECT count(DISTINCT grievance_id) as date_regd,app_type_id FROM grievances where DATE(date_regd) = '".$date."' and ulbid='" . strip_tags($_SESSION['ulbid']) . "' and app_type_id='1' and cat3_id !='0' ";
		//$sql = "SELECT count(DISTINCT grievance_id) as date_regd,app_type_id FROM grievances where ulbid='" . strip_tags($_SESSION['ulbid']) . "' and app_type_id='1' and grievance_status_id IN(2,9,8,4,6,10,13,12,11) and cat3_id !='0' ";
	}
} else if ($_SESSION['user_type'] == 'E') {

	// $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g,cs_mst c,ulbmst u where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='1'";
	$sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where DATE(date_regd) = '".$date."' and g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0'";

	$sql_od = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where DATE(date_regd) = '".$date."' and g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and cat3_id !='0'";

	$esc_sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where DATE(date_regd) = '".$date."' and g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and app_type_id='1' and cat3_id !='0' and disposal_status NOT IN('5') and gt.is_escalated=1";
} else if ($_SESSION['user_type'] == 'R') {
	$sql = "SELECT count(DISTINCT grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where DATE(date_regd) = '".$date."' and g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'M') {
	//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";

	//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1'";
	$sql = "SELECT count(DISTINCT grievance_id) as date_regd,app_type_id FROM grievances where DATE(date_regd) = '".$date."' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

//echo $sql;

$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {


	$data[$row['app_type_id']]['daily_received'] = $row['date_regd'];
}
$esc_total = 0;

if ($_SESSION['user_type'] == 'E') {
	$esc_rs = mysqli_query($conn, $esc_sql);
	while ($row2 = mysqli_fetch_assoc($esc_rs)) {
		$esc_total = $data[$row['app_type_id']]['daily_received'] + $row2['date_regd'];
	}
}

if ($data[1]['daily_received'] == '') {
	$data[1]['daily_received'] = 0;
}

//transferred complaints
if ($_SESSION['user_type'] == 'A') {


	//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1'";
	$sql = "SELECT ount(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'U') {



	$sql = "SELECT count(DISTINCT(gt.grievance_id)) as date_regd,app_type_id FROM grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . strip_tags($_SESSION['ulbid']) . "' and app_type_id='1' and cat3_id !='0' and gt.is_escalated='1'";
} else if ($_SESSION['user_type'] == 'E') {


	// $sql="SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g,cs_mst c,ulbmst u where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and app_type_id='1'";
	$sql = "SELECT  count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.is_escalated='1'";

	$sql_od = "SELECT count(DISTINCT g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and  g.ward_id IN( $deptlist ) and gt.disposal_status != '5' and app_type_id='1' and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(DISTINCT grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'M') {
	//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0'";

	//$sql="SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1'";
	$sql = "SELECT count(DISTINCT grievance_id) as date_regd,app_type_id FROM grievances  where app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {


	$data[$row['app_type_id']]['total_transferred'] = $row['date_regd'];
}


if ($data[1]['total_transferred'] == '') {
	$data[1]['total_transferred'] = 0;
}
// resolved with in sla

if ($_SESSION['user_type'] == 'A') {
	$sql = "SELECT ount(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' ";
} else if ($_SESSION['user_type'] == 'U') {

	if ($_SESSION['ulbid'] == (int)$mergedulbs) {
		$sql = "SELECT ount(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and 
		app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
	} else {
		$sql = "SELECT ount(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances where ulbid='" . strip_tags($_SESSION['ulbid']) . "' and 
		app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
	}
} else if ($_SESSION['user_type'] == 'E') {

	//$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and g.sla_status=1 and gt.is_escalated=0 and cat3_id !='0' ";

	/*$sql = "SELECT count(DISTINCT g.grievance_id) as date_regd,app_type_id FROM grievances g,cs_mst c,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and 
	g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";*/

	//19-03-24 $sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.is_escalated=0 and cat3_id !='0' ";

	//22-04-24 $sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.is_escalated=0 and cat3_id !='0' ";

	//31-05-24 $sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('3','8','9') and g.sla_status=1 and gt.is_escalated=0 and cat3_id !='0'";

	$sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' ";
} else if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(grievance_id) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'M') {


	$sql = "SELECT count(grievance_id) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

//echo $sql;

$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {


	$data[$row['app_type_id']]['resolved_within_sla'] = $row['date_regd'];
}

if ($data[1]['resolved_within_sla'] == '') {
	$data[1]['resolved_within_sla'] = 0;
}
// resolved beyond sla

if ($_SESSION['user_type'] == 'A') {


	$sql = "SELECT ount(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances where app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'U') {

	$sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances g where ulbid='" . strip_tags($_SESSION['ulbid']) . "' and 
	app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'E') {
	//19-03-24 $sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=2 and cat3_id !='0' ";

	//31-05-24 $sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0' ";

	$sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0' ";
} else if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . strip_tags($_SESSION['uid']) . "' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'M') {


	$sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances where app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

//	echo $sql;

$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {


	$data[$row['app_type_id']]['resolved_beyond_sla'] = $row['date_regd'];
}

if ($data[1]['resolved_beyond_sla'] == '') {
	$data[1]['resolved_beyond_sla'] = 0;
}

// under progress with in sla

if ($_SESSION['user_type'] == 'A') {
	$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and gt.disposal_status IN('2') and sla_status=1 and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'U') {
	if ($_SESSION['ulbid'] == (int)$mergedulbs) {
		$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances  where ulbid IN('208','210') and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
	} else {

		$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances  where ulbid='" . strip_tags($_SESSION['ulbid']) . "' and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
	}
} else if ($_SESSION['user_type'] == 'E') {
	//19-03-24 $sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('2') and gt.disposal_status IN('2') and sla_status=1 and cat3_id !='0'";

	$sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and gt.disposal_status != '5' and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'M') {


	$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

//echo $sql;
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {


	$data[$row['app_type_id']]['pending_with_sla'] = $row['date_regd'];
}

if ($data[1]['pending_with_sla'] == '') {
	$data[1]['pending_with_sla'] = 0;
}


// under progress beyond sla

if ($_SESSION['user_type'] == 'A') {


	$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances  where app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'U') {
	if ($_SESSION['ulbid'] == (int)$mergedulbs) {
		$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances where ulbid IN('208','210') and 
    	app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
	} else {
		$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances where ulbid='" . $_SESSION['ulbid'] . "' and 
    	app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
	}
} else if ($_SESSION['user_type'] == 'E') {
	//19-03-24 $sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances g,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.ward_id IN( $deptlist ) and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and cat3_id !='0'";
	$sql = "SELECT count(DISTINCT(g.grievance_id)) as date_regd,app_type_id FROM grievances g,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.ward_id IN( $deptlist ) and app_type_id='1' and g.grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and cat3_id !='0'";
} else if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances g,ulbmst u ,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0'";
}
if ($_SESSION['user_type'] == 'M') {


	$sql = "SELECT count(DISTINCT(grievance_id)) as date_regd,app_type_id FROM grievances  where  app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {


	$data[$row['app_type_id']]['pending_beyond_sla'] = $row['date_regd'];
}

if ($data[1]['pending_beyond_sla'] == '') {
	$data[1]['pending_beyond_sla'] = 0;
}


/********pending Approval**********/

if ($_SESSION['user_type'] == 'A') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as pendingforapproval,app_type_id from grievances  where  grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
}
if ($_SESSION['user_type'] == 'U') {

	if ($_SESSION['ulbid'] == (int)$mergedulbs) {
		$sql = "SELECT count(DISTINCT(grievance_id)) as pendingforapproval,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
	} else {
		$sql = "SELECT count(DISTINCT(grievance_id)) as pendingforapproval,app_type_id from grievances where 
		ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='1' and cat3_id !='0'";
	}
}

if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as pendingforapproval,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='1' and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0'";
}
if ($_SESSION['user_type'] == 'M') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as pendingforapproval,app_type_id from grievances where  grievance_status_id='1' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

$rs = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($rs)) {
	$data[$row['app_type_id']]['pendingforapproval'] = $row['pendingforapproval'];
}


if ($data[1]['pendingforapproval'] == '') {
	$data[1]['pendingforapproval'] = 0;
}



/********end pending approval****/


/********Financial implications**********/

if ($_SESSION['user_type'] == 'A') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as fin,app_type_id from grievances where grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
}
if ($_SESSION['user_type'] == 'U') {

	if ($_SESSION['ulbid'] == (int)$mergedulbs) {
		$sql = "SELECT count(DISTINCT(grievance_id)) as fin,app_type_id from grievances where 
		ulbid IN('208','210') and grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
	} else {

		$sql = "SELECT count(DISTINCT(grievance_id)) as fin,app_type_id from grievances where 
		ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
	}
}
if ($_SESSION['user_type'] == 'E') {

	//19-03-24 $sql = "SELECT count(DISTINCT(grievance_id)) as fin,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and grievance_status_id='6' and gt.disposal_status IN (6) and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";

	$sql = "SELECT count(DISTINCT(g.grievance_id)) as fin,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and g.grievance_status_id='6' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
}

if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as fin,app_type_id from grievances g,ulbmst u,Districtmst d where  g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='6' and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0'";
}
if ($_SESSION['user_type'] == 'M') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as fin,app_type_id from grievances where  grievance_status_id='6' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

$rs = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($rs)) {
	$data[$row['app_type_id']]['fin'] = $row['fin'];
}


if ($data[1]['fin'] == '') {
	$data[1]['fin'] = 0;
}




/********end pending approval****/




/********Un resolved**********/

if ($_SESSION['user_type'] == 'A') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as unresolved,app_type_id from grievances where grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
}
if ($_SESSION['user_type'] == 'U') {

	if ($_SESSION['ulbid'] == (int)$mergedulbs) {
		$sql = "SELECT count(DISTINCT(grievance_id)) as unresolved,app_type_id from grievances where ulbid IN('208','210') and grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
	} else {

		$sql = "SELECT count(DISTINCT(grievance_id)) as unresolved,app_type_id from grievances where ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='4' and app_type_id='1' and cat3_id !='0'";
	}
}
if ($_SESSION['user_type'] == 'E') {
	//19-03-24 $sql = "SELECT count(DISTINCT(g.grievance_id)) as unresolved,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and grievance_status_id='4' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
	$sql = "SELECT count(DISTINCT(g.grievance_id)) as unresolved,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and g.grievance_status_id='4' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
}

if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as unresolved,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='4' and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0'";
}
if ($_SESSION['user_type'] == 'M') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as unresolved,app_type_id from grievances where grievance_status_id='4' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

$rs = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($rs)) {
	$data[$row['app_type_id']]['unresolved'] = $row['unresolved'];
}

if ($data[1]['unresolved'] == '') {
	$data[1]['unresolved'] = 0;
}




/********end Un resolved****/




/******** Rejected **********/

if ($_SESSION['user_type'] == 'A') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as rejected,app_type_id from grievances where grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
}
if ($_SESSION['user_type'] == 'U') {

	if ($_SESSION['ulbid'] == (int)$mergedulbs) {
		$sql = "SELECT count(DISTINCT(grievance_id)) as rejected,app_type_id from grievances where ulbid IN('208','210') and grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
	} else {

		$sql = "SELECT count(DISTINCT(grievance_id)) as rejected,app_type_id from grievances where ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='10' and app_type_id='1' and cat3_id !='0'";
	}
}
if ($_SESSION['user_type'] == 'E') {
	//19-03-24 $sql = "SELECT count(DISTINCT(g.grievance_id)) as rejected,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and grievance_status_id IN ('10') and gt.disposal_status IN ('10') and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
	$sql = "SELECT count(DISTINCT(g.grievance_id)) as rejected,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and g.grievance_status_id='10' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
}

if ($_SESSION['user_type'] == 'R') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as rejected,app_type_id from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  grievance_status_id='10' and app_type_id='1' and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0'";
}
if ($_SESSION['user_type'] == 'M') {

	$sql = "SELECT count(DISTINCT(grievance_id)) as rejected,app_type_id from grievances where grievance_status_id='10' and app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
}

$rs = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($rs)) {
	$data[$row['app_type_id']]['rejected'] = $row['rejected'];
}

if ($data[1]['rejected'] == '') {
	$data[1]['rejected'] = 0;
}




















/** re-opened applicatons **/

if ($_SESSION['user_type'] == 'A') {

	$sql3 = "SELECT count(DISTINCT(grievance_id)) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13') group by app_type_id,grievance_status_id";
} else if ($_SESSION['user_type'] == 'U') {


	//$sql3 = "SELECT count(DISTINCT gt.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "'  and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
	//$sql4 = "SELECT count(DISTINCT gt.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "'  and is_reopened_yn='1'  and g.grievance_status_id IN('11') group by app_type_id";
	//$sql5 = "SELECT count(DISTINCT gt.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "'  and is_reopened_yn='1'  and g.grievance_status_id IN('12') group by app_type_id";

	$sql3 = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id from grievances g where ulbid='" . $_SESSION['ulbid'] . "'  and g.grievance_status_id IN('13') group by app_type_id";
	$sql4 = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id from grievances g  where  ulbid='" . $_SESSION['ulbid'] . "'  and  g.grievance_status_id IN('11') group by app_type_id";
	$sql5 = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id from grievances g  where  ulbid='" . $_SESSION['ulbid'] . "'   and g.grievance_status_id IN('12') group by app_type_id";
} else if ($_SESSION['user_type'] == 'E') {
	//$sql3 = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and  gt.disposal_status IN('11','12') and g.grievance_status_id IN('11','12')";
	/*19-03-14 $sql3 = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and  gt.disposal_status IN('13') and g.grievance_status_id IN('13') group by app_type_id, grievance_status_id";
	$sql4 = "SELECT count(DISTINCT g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('11')  and gt.disposal_status IN('11') and g.ward_id IN( $deptlist ) group by app_type_id, grievance_status_id";
	$sql5 = "SELECT count(DISTINCT g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status NOT IN('5','9','13') and  g.grievance_status_id IN('12') and g.ward_id IN( $deptlist ) group by app_type_id, grievance_status_id";*/
	//15-03-24 $sql5 = "SELECT count(DISTINCT g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('12') and  g.grievance_status_id IN('12') and g.ward_id IN( $deptlist ) group by app_type_id, grievance_status_id";
	$sql3 = "SELECT count(DISTINCT g.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ward_id IN( $deptlist ) and  gt.disposal_status !=5 and g.grievance_status_id IN('13') group by app_type_id";
	//This Date 22-04-24 Changed $sql4 = "SELECT count(DISTINCT g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('11') and  g.grievance_status_id IN('11') and g.ward_id IN( $deptlist ) group by app_type_id, grievance_status_id";
	$sql4 = "SELECT count(DISTINCT g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status !=5 and g.grievance_status_id IN('11') and g.ward_id IN( $deptlist ) group by app_type_id, grievance_status_id";
	$sql5 = "SELECT count(DISTINCT g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status !=5 and g.grievance_status_id IN('12') and g.ward_id IN( $deptlist ) group by app_type_id, grievance_status_id";
	// This Date 22-04-24 Changed $sql5 = "SELECT count(DISTINCT g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status NOT IN('5','9','13') and  g.grievance_status_id IN('12') and g.ward_id IN( $deptlist ) group by app_type_id, grievance_status_id";
} else if ($_SESSION['user_type'] == 'R') {

	$sql3 = "SELECT count(DISTINCT gt.grievance_id) as count,app_type_id from grievances g,grievances_transactions gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0' and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
	$sql4 = "SELECT count(DISTINCT g.grievance_id) as count,disposal_status as grievance_status_id,app_type_id from grievances g,grievances_transactions gt,ulbmst u,Districtmst d where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma='" . $_SESSION['uid'] . "' and cat3_id !='0' and gt.disposal_status IN('11','12')  group by app_type_id, grievance_status_id";
}

if ($_SESSION['user_type'] == 'M') {
	$sql3 = "SELECT count(DISTINCT grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13')  group by app_type_id,grievance_status_id";
}
//echo $sql3;
$rs = mysqli_query($conn, $sql3);
while ($row = mysqli_fetch_assoc($rs)) {
	$reopened_completed_tot[$row['app_type_id']][13]['count'] = $row['count'];
}

if ($reopened_completed_tot[1]['13']['count'] == '') {
	$reopened_completed_tot[1]['13']['count'] = 0;
}


//echo $sql4;

$rs = mysqli_query($conn, $sql4);
while ($row = mysqli_fetch_assoc($rs)) {
	$reopened_completed_tot[$row['app_type_id']][11]['count'] = $row['count'];
}
if ($reopened_completed_tot[1]['11']['count'] == '') {
	$reopened_completed_tot[1]['11']['count'] = 0;
}

$rs = mysqli_query($conn, $sql5);
while ($row = mysqli_fetch_assoc($rs)) {
	$reopened_completed_tot[$row['app_type_id']][12]['count'] = $row['count'];
}
if ($reopened_completed_tot[1]['12']['count'] == '') {
	$reopened_completed_tot[1]['12']['count'] = 0;
}

//echo $sql5;


// multiple times repeated complaints

/* $sql="SELECT IFNULL(count(DISTINCT gt.grievance_id),0) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and ulbid='".$_SESSION['ulbid']."' and is_reopened_yn='1' group by app_type_id";
		                
		                $rs= mysqli_query($conn,$sql);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed_reopened[$row['app_type_id']]['count']=$row['count'];
		                }*/







?>

<div class="boxed">
	<!-- Title Bart Start -->
	<!-- <h4>Total Number of Complaints</h4>-->
	<div class="bash_heading row  m-b20"> Total Number of Grievances </div>
	<!-- Title Bart End -->
	<div>

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

							/*$total_resolved = $data[1]['resolved_beyond_sla'] + $data[1]['resolved_within_sla'];
							$total_pending = $data[1]['pending_beyond_sla'] + $data[1]['pending_with_sla'];*/
							//31-5-24 $total_resolved = $data[1]['resolved_beyond_sla'] + $data[1]['resolved_within_sla'] + $data[1]['fin'] + $reopened_completed_tot[1][12]['count'];
							$total_resolved = $data[1]['resolved_within_sla'] + $data[1]['resolved_beyond_sla'] + $data[1]['fin'] + $reopened_completed_tot[1][12]['count'] + $reopened_completed_tot[1][13]['count'];
							$total_pending = $data[1]['pending_beyond_sla'] + $data[1]['pending_with_sla'] + $reopened_completed_tot[1][11]['count'];

							if ($_SESSION['user_type'] == 'U') {


								echo "<a href='rep_comp_dept_abs_comp.php?active=tr-clmn'>" . $data[1]['total_received'] . "</a>";


								// echo "<a href='tot_received.php?aptid=1&status=0&sla=0&user_type=".$_SESSION['user_type']."' >".$data[1]['total_received']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								/*$data[1]['total_received'] = $total_resolved+
																			$data[1]['total_transferred']+
																			$reopened_completed_tot[1][13]['count']+
																			$total_pending + 
																			$data[1]['fin'];*/
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=0&sla=0&user_type=" . $_SESSION['user_type'] . "' >" . $data[1]['total_received'] . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=801&sla=0&user_type=" . $_SESSION['user_type'] . "' >" . $data[1]['total_received'] . "</a>";
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
							?>
							<?php if ($_SESSION['user_type'] == 'U') {
								echo "<a href='tot_received_zone.php?aptid=1&status=111&sla=0&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['daily_received'] . "</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								echo "<a href='tot_received_zone.php?aptid=1&status=111&sla=0&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['daily_received'] . "</a>";
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

			<!-- <div class="col-md-4 col-sm-6"> -->
			<div class="col-md-3 col-sm-6">
				<section class="panel panel-box myshadow">
					<div class="panel-left panel-icon bg-info">
						<br>
						<i class="fa text-large stat-icon "><img src="images/Beyond-icon.png" /></i>

					</div>
					<div class="panel-right panel-icon bg-reverse">
						<!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=2&user_type={$user_type}">{$data[1].resolved_beyond_sla}</a></p>-->
						<p class="size-h1 no-margin countdown_first">

							<?php if ($_SESSION['user_type'] == 'U') {


								echo "<a href='rep_comp_dept_abs_comp.php?active=rdbsla-clmn' >" . $total_resolved . "</a>";



								//echo "<a href='tot_received.php?aptid=1&status=2&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_beyond_sla']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=100&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $total_resolved . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=802&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $total_resolved . "</a>";
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


							if ($_SESSION['user_type'] == 'U') {

								echo "<a href='rep_comp_dept_abs_comp.php?active=rbsla-clmn' >" . $total_pending . "</a>";

								//echo "<a href='tot_received.php?aptid=1&status=3&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_beyond_sla']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=200&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $total_pending . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=803&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $total_pending . "</a>";
							} else {
								if ($_SESSION['user_type'] == 'M') {
									echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $total_pending . "</a>";
								} else {
									echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $total_pending . "</a>";
								}
							}

							?>




						</p>
						<p class="text-muted no-margin"><span style="color:#000;">Total Underprogress</span><br>
							(<?php echo number_format($total_pending / $data[1]['total_received'] * 100, 2); ?> %)
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
							<?php if ($_SESSION['user_type'] == 'U') {

								echo "<a href='tot_received.php?aptid=1&status=6&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['fin'] . "</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//echo "<a href='tot_received_zone.php?aptid=1&status=6&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['fin'] . "</a>";
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=6&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['fin'] . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=804&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['fin'] . "</a>";
							} else {
								if ($_SESSION['user_type'] == 'M') {
									echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['fin'] . "</a>";
								} else {
									echo "<a href='cdma_ulbwise_report.php?status=6&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['fin'] . "</a>";
								}
							}

							?>





						</p>
						<!-- <p class="text-muted no-margin "><span style="color:#000;">Financial Implications</span>
						</p> -->
						<p class="text-muted no-margin "><span style="color:#000;">Total Resolved (Financial Implications)</span>
						</p>
					</div>
				</section>
			</div>


			<!--<div class="col-md-4 col-sm-6">
                            <section class="panel panel-box myshadow">
                                <div class="panel-left panel-icon bg-lovender">
								<br>
                                    <i class="fa fa-minus-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first">{if $data[1].pending_apprval eq ''}0{else}<a href="pending_approval.php?grievance_status_id=1&aptid=1">{$data[1].pending_apprval}</a>{/if}</p>--
                        <p class="size-h1 no-margin countdown_first">
                            
                            <?php if ($_SESSION['user_type'] == 'U') {

								echo "<a href='tot_received.php?aptid=1&status=1&sla=0&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['pendingforapproval'] . "</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								echo $data[1]['pendingforapproval'];
							} else {
								if ($_SESSION['user_type'] == 'M') {
									echo "<a href='cdma_ulbwise_report.php?status=1&app_type_id=1&name=" . $_SESSION['uid'] . "' >" . $data[1]['pendingforapproval'] . "</a>";
								} else {
									echo "<a href='cdma_ulbwise_report.php?status=1&app_type_id=1&name=" . $_SESSION['uid'] . "' >" . $data[1]['pendingforapproval'] . "</a>";
								}
							}

							?>
                            
                            
                             
                                    <p class="text-muted no-margin "><span style="color:#000;">Pending for Approval</span><br>
                                    (<?php echo number_format($data[1]['pendingforapproval'] / $data[1]['total_received'] * 100, 2); ?> % )
                                    </p>
                                </div>
                            </section>
                        </div>-->

			<!-- <div class="col-md-4 col-sm-6"> -->
			<div class="col-md-3 col-sm-6">
				<section class="panel panel-box myshadow">
					<div class="panel-left panel-icon bg-lovender">
						<br>
						<i class="fa fa-check-circle text-large stat-icon "></i>
					</div>
					<div class="panel-right panel-icon bg-reverse">
						<!-- <p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=1&user_type={$user_type}">{$data[1].resolved_withinsla}</a></p>-->
						<p class="size-h1 no-margin countdown_first">

							<?php if ($_SESSION['user_type'] == 'U') {


								echo "<a href='rep_comp_dept_abs_comp.php?active=rwsla-clmn' >" . $data[1]['resolved_within_sla'] . "</a>";

								//echo "<a href='tot_received.php?aptid=1&status=2&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_within_sla']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=2&sla=1&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['resolved_within_sla'] . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=805&sla=1&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['resolved_within_sla'] . "</a>";
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
						<!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=3&sla=2&user_type={$user_type}">{$data[1].resolved_beyond_sla}</a></p>-->
						<p class="size-h1 no-margin countdown_first">

							<?php if ($_SESSION['user_type'] == 'U') {


								echo "<a href='rep_comp_dept_abs_comp.php?active=rdbsla-clmn' >" . $data[1]['resolved_beyond_sla'] . "</a>";



								//echo "<a href='tot_received.php?aptid=1&status=2&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['resolved_beyond_sla']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=2&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['resolved_beyond_sla'] . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=806&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['resolved_beyond_sla'] . "</a>";
							} else {
								if ($_SESSION['user_type'] == 'M') {
									echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['resolved_beyond_sla'] . "</a>";
								} else {
									echo "<a href='cdma_ulbwise_report.php?status=3&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['resolved_beyond_sla'] . "</a>";
								}
							}



							?>




						<p class="text-muted no-margin"><span style="color:#000;">Completed Beyond SLA</span><br>
							(<?php echo number_format($data[1]['resolved_beyond_sla'] / $data[1]['total_received'] * 100, 2); ?> % )
						</p>
					</div>
				</section>
			</div>

			<!-- <div class="col-md-4 col-sm-6"> -->
			<div class="col-md-3 col-sm-6">
				<section class="panel panel-box myshadow">
					<div class="panel-left panel-icon bg-instagram">
						<br>
						<i class="fa fa-refresh text-large stat-icon "></i>
					</div>
					<div class="panel-right panel-icon bg-reverse">
						<!--<p class="size-h1 no-margin countdown_first"><a href="services1.php?aptid=1&status=2&sla=1&user_type={$user_type}">{$data[1].pending_within_sla}</a></p>-->
						<p class="size-h1 no-margin countdown_first">

							<?php if ($_SESSION['user_type'] == 'U') {

								echo "<a href='rep_comp_dept_abs_comp.php?active=pwsla-clmn' >" . $data[1]['pending_with_sla'] . "</a>";


								//echo "<a href='tot_received.php?aptid=1&status=3&sla=1&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_with_sla']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=3&sla=1&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['pending_with_sla'] . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=807&sla=1&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['pending_with_sla'] . "</a>";
							} else {
								if ($_SESSION['user_type'] == 'M') {
									echo "<a href='cdma_ulbwise_report.php?status=4&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['pending_with_sla'] . "</a>";
								} else {
									echo "<a href='cdma_ulbwise_report.php?status=4&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['pending_with_sla'] . "</a>";
								}
							}

							?>





						<p class="text-muted no-margin"><span style="color:#000;">Under Progress within SLA</span><br>
							(<?php echo number_format($data[1]['pending_with_sla'] / $data[1]['total_received'] * 100, 2); ?> %)

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

							<?php if ($_SESSION['user_type'] == 'U') {

								echo "<a href='rep_comp_dept_abs_comp.php?active=rbsla-clmn' >" . $data[1]['pending_beyond_sla'] . "</a>";

								//echo "<a href='tot_received.php?aptid=1&status=3&sla=2&user_type=".$_SESSION['user_type']."'>".$data[1]['pending_beyond_sla']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=3&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['pending_beyond_sla'] . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=808&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['pending_beyond_sla'] . "</a>";
							} else {
								if ($_SESSION['user_type'] == 'M') {
									echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['pending_beyond_sla'] . "</a>";
								} else {
									echo "<a href='cdma_ulbwise_report.php?status=5&app_type_id=1&name=" . $_SESSION['uid'] . "'>" . $data[1]['pending_beyond_sla'] . "</a>";
								}
							}

							?>




						</p>
						<p class="text-muted no-margin"><span style="color:#000;">Under Progress Beyond SLA</span><br>
							(<?php echo number_format($data[1]['pending_beyond_sla'] / $data[1]['total_received'] * 100, 2); ?> %)
						</p>
					</div>
				</section>
			</div>

			<!-- <div class="col-md-4 col-sm-6"> -->
			<div class="col-md-3 col-sm-6">
				<section class="panel panel-box myshadow">
					<div class="panel-left panel-icon bg-danger">
						<br>
						<i class="fa fa-folder text-large stat-icon "></i>
					</div>
					<div class="panel-right panel-icon bg-reverse">
						<p class="size-h1 no-margin countdown_first">

						<?php $reopened = $reopened_completed_tot[1][13]['count'] + $reopened_completed_tot[1][11]['count'] + $reopened_completed_tot[1][12]['count'] ?>

							<?php if ($_SESSION['user_type'] == 'U') {


								echo "<a href='street_complaints.php?app_type_id=1&status=005&dept_id=32&f_date=&t_date='>" . $reopened . "</a>";


								//echo "<a href='deptwise_reopened.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=13'>".$reopened_completed_tot[1][13]['count']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//echo "<a href='grievances_reopenedemp.php?app_type_id=1&status=13&user_type=".$_SESSION['user_type']."'>".$reopened_completed_tot[1][13]['count']."</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=809&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "'>" . $reopened . "</a>";
								/*07-06-24 if ($reopened_completed_tot[1][13]['count'] > 0) {
									//01-06-24 echo "<a href='comp_det1.php?app_type_id=1&emp_id=" . $_SESSION['emp_id'] . "&status=200&f_date=$fdate&t_date=$tdate&user_type=" . $_SESSION['user_type'] . "'>" . $reopened . "</a>";
									echo "<a href='tot_received_zone.php?aptid=1&status=809&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "'>" . $reopened . "</a>";
								} else {

									//echo $reopened_completed_tot[1][13]['count'];
									echo $reopened_completed_tot[1][13]['count'] + $reopened_completed_tot[1][11]['count'] + $reopened_completed_tot[1][12]['count'];
								}*/
							} else {
								if ($_SESSION['user_type'] == 'M') {
									echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=13&name=" . $_SESSION['uid'] . "'>" . $reopened . "</a>";
								} else {
									echo "<a href='ulbwise_reopened_rep.php?app_type_id=1&status=13&name=" . $_SESSION['uid'] . "'>" . $reopened . "</a>";
								}
							}

							?>

						</p>
						<!--07-06-24 <p class="text-muted no-margin "><span style="color:#000;">Reopened</span> -->
						<p class="text-muted no-margin "><span style="color:#000;">Total Reopened</span>
							<br>
							(<?php echo number_format($reopened / $data[1]['total_received'] * 100, 2); ?> %)
						</p>
					</div>
				</section>
			</div>

			<!-- <div class="col-md-4 col-sm-6"> -->
			<div class="col-md-3 col-sm-6">
				<section class="panel panel-box myshadow">
					<div class="panel-left panel-icon bg-success">
						<br>
						<i class="fa  text-large stat-icon "><img src="images/reopen_comp.png"></i>
					</div>
					<div class="panel-right panel-icon bg-reverse">
						<p class="size-h1 no-margin countdown_first">
							<?php if ($_SESSION['user_type'] == 'U') {


								echo "<a href='street_complaints.php?app_type_id=1&status=600&f_date=&t_date=' >" . $reopened_completed_tot[1][12]['count'] . "</a>";

								//echo "<a href='deptwise_reopened.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=12'>".$reopened_completed_tot[1][12]['count']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//echo "<a href='street_complaints.php?app_type_id=1&status=601&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "&dept_dashboard_status=1'>" . $reopened_completed_tot[1][12]['count'] . "</a>";
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=601&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][12]['count'] . "</a>";
								//01-06-24 echo "<a href='tot_received_zone.php?aptid=1&status=809&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][12]['count'] . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=810&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][12]['count'] . "</a>";
								// echo $reopened_completed_tot[1][12]['count'];
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
							(<?php echo number_format($reopened_completed_tot[1][12]['count'] / $data[1]['total_received'] * 100, 2); ?> %)
						</p>
					</div>
				</section>
			</div>

			<!-- <div class="col-md-4 col-sm-6"> -->
			<div class="col-md-3 col-sm-6">
				<section class="panel panel-box myshadow">
					<div class="panel-left panel-icon bg-danger">
						<br>
						<i class="fa fa-folder-open text-large stat-icon "></i>
					</div>
					<div class="panel-right panel-icon bg-reverse">
						<p class="size-h1 no-margin countdown_first">

							<?php if ($_SESSION['user_type'] == 'U') {


								echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date=' >" . $reopened_completed_tot[1][11]['count'] . "</a>";



								//echo "<a href='deptwise_reopened.php?ulbid=".$_SESSION['ulbid']."&app_type_id=1&status=11'>".$reopened_completed_tot[1][11]['count']."</a>";
							} else if ($_SESSION['user_type'] == 'E') {
								//echo "<a href='street_complaints.php?app_type_id=1&status=501&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "&dept_dashboard_status=1 '>" . $reopened_completed_tot[1][11]['count'] . "</a>";
								//12-04-24 echo "<a href='tot_received_zone.php?aptid=1&status=501&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][11]['count'] . "</a>";
								//01-06-24 echo "<a href='tot_received_zone.php?aptid=1&status=810&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][11]['count'] . "</a>";
								echo "<a href='tot_received_zone.php?aptid=1&status=811&emp_id=" . $_SESSION['emp_id'] . "&f_date=&t_date=&user_type=" . $_SESSION['user_type'] . "'>" . $reopened_completed_tot[1][11]['count'] . "</a>";
								//echo $reopened_completed_tot[1][11]['count'];
							} else {
								if ($_SESSION['user_type'] == 'M') {
									echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopened_completed_tot[1][11]['count'] . "</a>";
								} else {
									echo "<a href='street_complaints.php?app_type_id=1&status=500&f_date=&t_date='>" . $reopened_completed_tot[1][11]['count'] . "</a>";
								}
							}

							?>
						</p>
						<p class="text-muted no-margin "><span style="color:#000;">Reopened underprogress</span>
							<br>
							(<?php echo number_format($reopened_completed_tot[1][11]['count'] / $data[1]['total_received'] * 100, 2); ?> %)
						</p>
					</div>
				</section>
			</div>

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











			<!--<div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
								<br>
                                    <i class="fa fa-thumbs-down text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">
                                        
                                        
                                         <?php if ($_SESSION['user_type'] == 'U') {

												echo $data[1]['total_transferred'];
											} else if ($_SESSION['user_type'] == 'E') {
												echo "<a href='tot_received_zone.php?aptid=1&status=300&sla=2&user_type=" . $_SESSION['user_type'] . "'>" . $data[1]['total_transferred'] . "</a>";
											} else {
												echo $data[1]['total_transferred'];
											}

											?>
                                        
                                        
                                        </p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Total Escalated</span>
                                    <br>
                                    (<?php echo number_format($data[1]['total_transferred'] / $data[1]['total_received'] * 100, 2); ?> %)</p>
                                </div>
                                
                                
                                
                               
                                
                                
                            </section>
                        </div>-->










		</div>




	</div>
</div>
</div>


</div><!-- /.tab-pane -->





<?php
mysqli_close($conn);
?>