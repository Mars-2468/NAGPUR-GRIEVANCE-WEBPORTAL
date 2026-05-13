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

	$app_type_id = $_REQUEST['app_type_id'];
	$emp_id = $_REQUEST['emp_id'];
	$reference_no = $_REQUEST['reference_no'];
	$status = $_REQUEST['status'];
	$dept_id = $_REQUEST['dept_id'];


	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));
	}

	if ($_REQUEST['app_type_id'] == 1) {
		$table = "cs_mst";
		$fieldName = "c.cs_desc";
	} else {
		$table = "standard_services";
		$fieldName = "c.cs_desc";
	}

	if ($status == 100) {
		
	//total recieved
	
	//var_dump($_REQUEST['emp_id']);die();
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and 
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) and g.cat3_id !='0' ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and
		g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and g.cat3_id !='0' and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) ";

		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.=" and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.=" and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "' ";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
		
		
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
						
		//echo "<pre>";print_r($_SESSION['emp_id']);echo "</pre>";die();
		
	} else if ($status == 200) {
	
	// pending within sla
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and sla_status='1'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm  where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.grievance_status_id IN('2') and sla_status='1'";
		
		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
		
		//echo "<pre>";print_r($sql);echo "</pre>";die();	
		
	}else if ($status == 201) { 
		
		//pending beyond sla
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		g.sla_status='2' and gt.disposal_status IN (2) and g.grievance_status_id IN(2) and cat3_id !='0'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id
		and g.grievance_status_id=gsm.grievance_status_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN (2) and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";
		
		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		
		
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
		
	//echo "<pre>";print_r($sql);echo "</pre>";die();	
	
	} else if ($status == 202) {
	
		$sql = "SELECT g.*,gt.emp_id FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('2','13','11') and cat3_id !='0' and gt.disposal_status not in(5,13,11) ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('2','13','11') and cat3_id !='0' and gt.disposal_status NOT IN(5,13,11) and gt.disposal_status!='5'";

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
		
	} else if ($status == 300) {
		
		//completed within sla
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(3,8,9) and sla_status='1'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "' and g.grievance_status_id IN('2') and sla_status='2'";

		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}
		
		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
				
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
		
	//echo "<pre>";print_r($sql);echo "</pre>";die();	
	
	} else if ($status == 301) {
		
		//completed beyond sla
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		g.sla_status='2' and g.grievance_status_id IN(3,8,9) and cat3_id!=0 ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN (2) and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5'";

		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}
		
		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
		
		//echo "<pre>";print_r($sql);echo "</pre>";die();	
		
	} else if ($status == 302) {
		
		$sql = "SELECT g.*,gt.emp_id FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8','12','6','10') and cat3_id !='0' and gt.disposal_status NOT IN(12,5,13,11) ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN('3','9','8','12','6','10') and cat3_id !='0' and gt.disposal_status not in(12,5,13,11) and gt.disposal_status!='5' ";

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
	} else if ($status == 400) {
		
		//	reopened

		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "'  
		and g.grievance_status_id IN(13) and gt.disposal_status IN(13) and cat3_id !='0'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.grievance_status_id IN('3','9','8') and g.sla_status='1' and cat3_id !='0'";

		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}
		
		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
			
	} else if ($status == 401) {
		
		// reopened completed
		
		$sql = "select g.*,gt.emp_id,gt.disposal_status from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		 g.grievance_status_id IN(12) and gt.disposal_status IN(12) and cat3_id !='0' ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";

		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}
		
		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
	} else if ($status == 402) {
		
		// reopened under progress
		
		$sql = "select g.*,gt.emp_id,gt.disposal_status from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		 g.grievance_status_id IN(11) and gt.disposal_status IN(11) and cat3_id !='0' ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and sla_status=1 and cat3_id !='0' and gt.disposal_status!='5'";

		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}
		
		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
	} else if ($status == 500) {
		
		// Transfers
		
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "'  and
		g.grievance_status_id IN(5,10) and cat3_id!=0 ";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and
		g.grievance_status_id IN(5,10) ";

		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}
		
		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
	} else if ($status == 501) {
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and g.sla_status='2' and gt.disposal_status IN ('3','9','8') and g.grievance_status_id IN('3','9','8')";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and ulbid='" . $_SESSION['ulbid'] . "' and app_type_id='1' and g.grievance_status_id IN('3','9','8') and gt.disposal_status IN ('3','9','8') and sla_status=2 and cat3_id !='0' and gt.disposal_status!='5'";
		
		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}
		
		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
		$sql .= " group by g.grievance_id";
		$sqlExcel .= " group by g.grievance_id";
		//echo $sql;
	} else if ($status == 600) {
		
		// financial implications

		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and g.grievance_status_id IN(6) and cat3_id !='0'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.grievance_status_id IN(13) and cat3_id !='0'";
		
		if($_SESSION['user_type']=='U' && !empty($_REQUEST['emp_id'] )){
			
			$sql.=" and gt.emp_id=".$_REQUEST['emp_id'] ." ";
			
		}

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
			
		if($_SESSION['user_type']=='E'){
			
			$sql.=" and gt.emp_id=".$_SESSION['emp_id'] ." ";
			
		}
	} else if ($status == 601) {
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and gt.disposal_status IN (13) and g.grievance_status_id IN(13) and cat3_id !='0'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and g.grievance_status_id IN(13) and cat3_id !='0'";

		if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
			$sql .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
			$sqlExcel .= "and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' ";
		}
		$sql .= " group by g.grievance_id";
		$sqlExcel .= " group by g.grievance_id";
		//echo $sql;
	} else if ($status == 700) {
		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "' 
		and g.grievance_status_id IN('6') and cat3_id !='0'";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and
		gt.disposal_status=gsm.grievance_status_id and app_type_id='1' and gt.dept_id='" . $_REQUEST['dept_id'] . "' and gt.disposal_status !=5 and app_type_id='1' and g.grievance_status_id IN('6') and gt.disposal_status IN('6') and gsm.grievance_status_id IN('6') and cat3_id !='0' and gt.grievance_id IN(select gg.grievance_id from grievances gg where gg.grievance_status_id IN(6) and gt.is_escalated='0')";

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
		//$sql.= " group by g.grievance_id";
		$sqlExcel .= " group by g.grievance_id";
		//echo $sql;
	} else if ($status == 701) {

		$sql = "select g.*,gt.emp_id from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' 
		and gt.disposal_status!='5' and gt.disposal_status IN ('6') and grievance_status_id IN('6')";

		$sqlExcel = "SELECT g.grievance_id as ReferenceNo, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,IF(is_escalated=1,'Escalated',grievance_status_desc) as Status ,date_regd as ReceivedDate from grievances g,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id 
		and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and g.grievance_status_id IN(6) and cat3_id !='0'";

		if($_REQUEST['f_date']!= '' && $_REQUEST['t_date']!='')
		{
			$sql.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
			$sqlExcel.="and date(date_regd) between '".$fdate."' and '".$tdate."' ";
		}
		if (isset($_POST['search'])) {
			if ($_POST['reference_no'] != '') {
				$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
			}
			if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
				$fdate = date('Y-m-d', strtotime($_POST['f_date']));
				$tdate = date('Y-m-d', strtotime($_POST['t_date']));
				$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
				$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
			}
		}
		//$sql .= " group by g.grievance_id";
		$sql .= " order by date_regd DESC";
		$sqlExcel .= " group by g.grievance_id";
		//echo $sql;
		//echo $sqlExcel;
	}


	$_SESSION['myquery'] = $sqlExcel;

	$adjacents = 5;

	if ($status == 100) {

		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id andg.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status !=5 and g.cat3_id !='0' and 
		gt.dept_id='" . $_REQUEST['dept_id'] . "'";
	} else if ($status == 101) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where 
    		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status NOT IN('5','11','12','13') and cat3_id !='0'";
	}
	else if ($status == 102) {
	
		$query = "select COUNT(DISTINCT gt.grievance_id, gt.emp_id) as num,emp_id,ward_id,street_id,g.date_regd  from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and
		g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "'  and g.grievance_status_id IN(2,9,8,4,6,10,13,12,11) and g.cat3_id !='0' and gt.disposal_status NOT IN(5,13,12,11)";
	} else if ($status == 200) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and
		grievance_status_id IN('2') and sla_status='1'";
	} else if ($status == 201) {
		$query = "select count(g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where 
			g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
			gt.disposal_status!='5' and g.sla_status='1' and gt.disposal_status IN (2) and grievance_status_id IN(2)  ";
	} else if ($status == 202) {
		$query = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as num,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
			app_type_id='1' and grievance_status_id IN('2','13','11') 
		 	and cat3_id !='0' and gt.disposal_status not in(5,13,11) ";
	} else if ($status == 300) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and
		grievance_status_id IN('2') and sla_status='2'";
	} else if ($status == 301) {
		$query = "select count(g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and g.sla_status='2' and gt.disposal_status IN (2) and grievance_status_id IN(2)";
	} else if ($status == 302) {
		$query = "SELECT count(DISTINCT g.grievance_id,gt.emp_id) as num,emp_id,disposal_status FROM grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and ulbid='" . $_SESSION['ulbid'] . "' and 
		app_type_id='1' and g.grievance_status_id IN('3','9','8','12','6','10') and cat3_id !='0' and gt.disposal_status not in(12,5,13,11) ";
	} else if ($status == 400) {

		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.grievance_status_id IN('3','9','8') and gt.disposal_status IN('3','9','8') and sla_status=1 and cat3_id !='0'";

	} else if ($status == 401) {
		$query = "select count(g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and g.sla_status='1' and grievance_status_id IN('3','9','8') and cat3_id !='0' ";
	} else if ($status == 500) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where 
		g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.grievance_status_id IN(3,9,8) and sla_status='2'";
	} else if ($status == 501) {
		$query = "select count(g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and g.sla_status='2' and gt.disposal_status IN ('3','9','8')  and grievance_status_id IN('3','9','8')  ";
	} else if ($status == 600) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "' and g.grievance_status_id IN(13) and sla_status='2'";
	} else if ($status == 601) {
		$query = "select count(g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and gt.disposal_status IN (13) and g.grievance_status_id IN(13) ";
	} else if ($status == 700) {
		$query = "select count(DISTINCT g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id  and g.ulbid='" . $_SESSION['ulbid'] . "' and
		g.app_type_id='" . $_REQUEST['app_type_id'] . "' and gt.disposal_status!='5' and gt.dept_id='" . $_REQUEST['dept_id'] . "'  and g.grievance_status_id IN(6)";
	} else if ($status == 701) {
		$query = "select count(g.grievance_id) as num from grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.app_type_id='" . $_REQUEST['app_type_id'] . "' and 
		gt.disposal_status!='5' and gt.disposal_status IN (6) and g.grievance_status_id IN(6) ";
	}

	if (isset($_POST['search'])) {
		if ($_POST['reference_no'] != '') {
			$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}
		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
			$fdate = date('Y-m-d', strtotime($_POST['f_date']));
			$tdate = date('Y-m-d', strtotime($_POST['t_date']));
			$query .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	$query .= " order by date_regd DESC";

	$result = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_assoc($result)) {
		$total_pages = $row['num'];
		//echo $row['num'];
	}
	//echo $query;


	$rs = mysqli_query($conn, $sql);
	$field_info = mysqli_fetch_fields($rs);
	while ($row = mysqli_fetch_assoc($rs)) {
		foreach ($field_info as $fi => $f)
			$data[$row['grievance_id']][$f->name] = $row[$f->name];
	}

	//employee list

	$sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where ulbid=?");
	$sql->bind_param("s",$_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();
	while($row = $rs->fetch_assoc())
	{
	  $emp_list[$row['emp_id']]=$row['emp_name']."(".$row['emp_mobile'].")";  
	}
	
	$sql =$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst_od where ulbid=?");
	$sql->bind_param("s",$_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();
	while($row = $rs->fetch_assoc())
	{
	  $emp_list[$row['emp_id']]=$row['emp_name']."(".$row['emp_mobile'].")";  
	}



	$sql = "select cs_id,cs_desc as comp_desc from standard_services";

	if ($_REQUEST['app_type_id'] == '1') {
		$sql = "select cs_id,cs_desc as comp_desc from cs_mst";
	}
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$cs_list[$row['cs_id']] = $row['comp_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";
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
	mysqli_close($conn);
	$start = $start + 1;
	//	print_r($online_applications);

	$tpl->assign('app_type_id', $app_type_id);
	$tpl->assign('emp_id', $emp_id);
	$tpl->assign('reference_no', $reference_no);
	$tpl->assign('status', $status);
	$tpl->assign('dept_id', $dept_id);

	//$tpl->assign('dept_id', $_REQUEST['dept_id']);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('user_type', $_SESSION['user_type']);
	/*$tpl->assign('fdate', $_REQUEST['f_date']);
	$tpl->assign('tdate', $_REQUEST['t_date']);*/

	$tpl->assign('fdate', $fdate);
	$tpl->assign('tdate', $tdate);
	$tpl->assign('online_applications', $online_applications);
	//$tpl->assign('reference_no', $_POST['reference_no']);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('status_list', $status_list);
	//$tpl->assign('app_type_id', $_REQUEST['app_type_id']);
	$tpl->assign('data', $data);
	$tpl->assign('tot', $tot);
	//$tpl->assign('status', $_REQUEST['status']);
	$tpl->assign('sla', $_REQUEST['sla']);
	$tpl->assign('sno', $start);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('emp_list', $emp_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_dept', $_SESSION['user_dept']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->display('employeewise_grievances.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
?>