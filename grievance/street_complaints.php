<?php
require "config.php";
ini_set('display_errors', 0);

require_once('Smarty.class.php');
date_default_timezone_set('Asia/Kolkata');


$tpl = new Smarty();

$emplist = join("','", $_SESSION['emp_list']);

/* if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST['ty'] == 'yearwisefilter') {
		year_wise_flter($_POST);
	}
}
function year_wise_flter($RES)
{
	$_SESSION['filteryear'] = $RES['year'];
	return $_SESSION['filteryear'];
} */

//$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:date('Y');

if (isset($_POST['search'])) {	
	$f_date =!empty($_POST['f_date'])? date('Y-m-d', strtotime($_POST['f_date'])):'';
	$t_date =!empty($_POST['t_date'])? date('Y-m-d', strtotime($_POST['t_date'])):'';	
}else if(isset($_REQUEST['f_date']) && isset($_REQUEST['t_date'])){
	$f_date =!empty($_REQUEST['f_date'])? date('Y-m-d', strtotime($_REQUEST['f_date'])):'';
	$t_date =!empty($_REQUEST['t_date'])? date('Y-m-d', strtotime($_REQUEST['t_date'])):'';	
}else{
	$f_date ='';
	$t_date ='';	
}

$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:'';
$selectedDesg = !empty($_SESSION['filterdesg'])?$_SESSION['filterdesg']:'';
$selectedDept = !empty($_SESSION['employee_dept'])?$_SESSION['employee_dept']:'';
$selectedDesgnation = !empty($_SESSION['employee_desg'])?$_SESSION['employee_desg']:'';
$response = "";

if (isset($_SESSION['uid'])) {


	require_once('get_services.php');

	$obj = new get_services($_SESSION['uid']);

	require_once('connection.php');

	$conn = getconnection();
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

	/// In case of service 

	$wardid = $_REQUEST['dept_id']??'';
	$deptid = $_SESSION['dept_id']??'';
	
	$aptid1 = $_REQUEST['aptid'];

	$reference_no = $_REQUEST['reference_no'];

	$status1 = $_REQUEST['status'];

	$ulbid1 = $_SESSION['ulbid'];

	$user_type1 = $_SESSION['user_type'];

	$sla1 = $_REQUEST['sla'];

	$grievances_trns=$_SESSION['grievances_trns']??'grievances_transactions';

	$date = date('Y-m-d');

//echo "<pre>";print_r($_SESSION);echo "</pre>";die();

/////////////////////////////////////////////////////////////////// user type -- U

	if ($_SESSION['user_type'] == 'U') {

		// User type U	

		if ($_REQUEST['status'] == 0) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."' ";

		}else if ($_REQUEST['status'] == 21) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."'  and sla_status=1 ";

		}else if ($_REQUEST['status'] == 22) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."' and sla_status=2 ";

		}else if ($_REQUEST['status'] == 3891) {		

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."' and sla_status=1 ";

		}else if ($_REQUEST['status'] == 3892) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."' and sla_status=2 ";

		}else if ($_REQUEST['status'] == 13) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(13) and gt.disposal_status IN(13) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."' ";

		}else if ($_REQUEST['status'] == 11) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(11) and gt.disposal_status IN(11) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."' ";

		}else if ($_REQUEST['status'] == 12) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(12) and gt.disposal_status IN(12) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."' ";

		}else if ($_REQUEST['status'] == 6) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(6) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."' ";

		}else if ($_REQUEST['status'] == 510) {		

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(5,10) and g.ward_id='".$_REQUEST['ward_id']."' and g.street_id ='".$_REQUEST['street_id']."' ";

		}else if ($_REQUEST['status'] == 100) {	// table bottom totals	

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13)  ";

		}else if ($_REQUEST['status'] == 121) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and sla_status=1 ";

		}else if ($_REQUEST['status'] == 122) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and sla_status=2 ";

		}else if ($_REQUEST['status'] == 13891) {		

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9) and sla_status=1 ";

		}else if ($_REQUEST['status'] == 13892) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9) and sla_status=2 ";

		}else if ($_REQUEST['status'] == 113) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(13) and gt.disposal_status IN(13) ";

		}else if ($_REQUEST['status'] == 111) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(11) and gt.disposal_status IN(11) ";

		}else if ($_REQUEST['status'] == 112) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(12) and gt.disposal_status IN(12) ";

		}else if ($_REQUEST['status'] == 106) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(6) ";

		}else if ($_REQUEST['status'] == 1510) {		

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(5,10) ";

		}
	}
	
/////////////////////////////////////////////////////////////////// user type -- E

	if ($_SESSION['user_type'] == 'E') {

		// User type E	
		
		
		$sql = "
					SELECT 
						g.*,
						gt.file_url AS updated_image,
						gt.disposed_date,
						gt.dept_id,
						gt.emp_id,

						DATEDIFF(gt.disposed_date, g.date_regd) 
							- ccm.cutt_off_time 
							- IFNULL(g.holidays_added,0) AS no_of_days_exceed,

						DATE_ADD(g.date_regd, INTERVAL ss.cutt_off_time DAY) AS comp_date

					FROM grievances g

					INNER JOIN ".$grievances_trns." gt 
						ON g.grievance_id = gt.grievance_id

					LEFT JOIN ulbmst u 
						ON g.ulbid = u.ulbid

					LEFT JOIN cs_mst c 
						ON g.cat3_id = c.cs_id

					LEFT JOIN comp_cutofdays_map ccm 
						ON g.mcat3_id = ccm.cs_id

					LEFT JOIN standard_services ss 
						ON g.cat3_id = ss.cs_id

					WHERE 
						g.app_type_id = 1
						AND g.ulbid = '" . $_SESSION['ulbid'] . "'
						AND g.cat3_id != 0						
					";
		

		if (in_array($_REQUEST['status'],[0,1])) {			

				/* $sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,".$grievances_trns." gt,ulbmst u ,cs_mst c, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13)  ";
				*/
				$sql .= "
						AND g.grievance_status_id IN (2,3,5,6,8,9,10,11,12,13)
						AND gt.disposal_status IN (2,3,5,6,8,9,10,11,12,13)
					";
				
		}else if ($_REQUEST['status'] == 21) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2) and gt.disposal_status IN(2)   and sla_status=1 ";

		}else if ($_REQUEST['status'] == 22) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2) and gt.disposal_status IN(2)  and sla_status=2 ";

		}else if ($_REQUEST['status'] == '08') {			

				/* $sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2) and gt.disposal_status IN(2)  and sla_status=2 ";
				*/
				$sql .= "
						AND g.grievance_status_id IN (2)
						AND gt.disposal_status IN (2) AND g.sla_status=2
					";
					
		}else if ($_REQUEST['status'] == 3891) {		

			/* 	$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9)  and sla_status=1 ";
			*/
			$sql .= "	AND g.sla_status=1
						AND g.grievance_status_id IN (3,8,9)						
					";
					
		}else if ($_REQUEST['status'] == 3892) {			

				/* $sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9)  and sla_status=2 ";
				*/
				$sql .= "	AND g.sla_status=2
						AND g.grievance_status_id IN (3,8,9)						
					";
		}else if ($_REQUEST['status'] == '03') {		

			/* 	$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9)  and sla_status=1 ";
			*/
			$sql .= "	AND g.sla_status=1
						AND g.grievance_status_id IN (3,8,9)						
					";
					
		}else if ($_REQUEST['status'] == '060') {		

			/* 	$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9)  and sla_status=1 ";
			*/
			$sql .= "	
						AND g.grievance_status_id IN (5,10)	
					";
					
		}else if ($_REQUEST['status'] == '09') {			

				/* $sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9)  and sla_status=2 ";
				*/
				$sql .= "	AND g.sla_status=2
						AND g.grievance_status_id IN (3,8,9)						
					";
		}else if ($_REQUEST['status'] == 13) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(13) and gt.disposal_status IN(13)  ";

		}else if ($_REQUEST['status'] == '07') {			

				/* $sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(13) and gt.disposal_status IN(13)  ";
				*/
				$sql .= " AND g.grievance_status_id IN(12) ";
		}else if ($_REQUEST['status'] == 11) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(11) and gt.disposal_status IN(11)  ";

		}else if ($_REQUEST['status'] == 12) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(12) and gt.disposal_status IN(12)  ";

		}else if ($_REQUEST['status'] == 6) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(6)  ";

		}else if ($_REQUEST['status'] == 510) {		

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(5,10)  ";

		}else if ($_REQUEST['status'] == 100) {	// table bottom totals	

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13)  ";

		}else if ($_REQUEST['status'] == 121) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and sla_status=1 ";

		}else if ($_REQUEST['status'] == 122) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and sla_status=2 ";

		}else if ($_REQUEST['status'] == 13891) {		

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9) and sla_status=1 ";

		}else if ($_REQUEST['status'] == 13892) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(3,8,9) and sla_status=2 ";

		}else if ($_REQUEST['status'] == 113) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(13) and gt.disposal_status IN(13) ";

		}else if ($_REQUEST['status'] == 111) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(11) and gt.disposal_status IN(11) ";

		}else if ($_REQUEST['status'] == 112) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(12) and gt.disposal_status IN(12) ";

		}else if ($_REQUEST['status'] == 106) {			

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(6) ";

		}else if ($_REQUEST['status'] == 1510) {		

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(5,10) ";

		}else if ($_REQUEST['status'] == 4) {		

				/* $sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$grievances_trns." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and g.grievance_status_id IN(5,10) "; */
					
				$sql .= " AND g.grievance_status_id IN(6) ";
		}
	}

	if ($_SESSION['user_type'] == 'E') {
		
		$sql .= " and gt.emp_id=" . $_SESSION['emp_id'] . " ";
		
		if($wardid!=''){
			$sql .= " and g.ward_id=" . $wardid . " ";
		}
		if($deptid!=''){
			$sql .= " and gt.dept_id=" . $deptid . " ";
		}
		
	}

	if ($_SESSION['filteryear'] != '') {
		
		$sql .= " and date_format(date_regd,'%Y')>='" . $_SESSION['filteryear'] . "'";

	}

	if (isset($_POST['search'])) {

		if ($_POST['reference_no'] != '') {

			$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

		}
	}
		if ($f_date!= '' && $t_date != '') {


			$f_date = date('Y-m-d', strtotime($f_date));

			$t_date = date('Y-m-d', strtotime($t_date));


			$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $f_date . "' and '" . $t_date . "'";
		}
	
	$sql .= " order by g.grievance_id DESC";

/* ====================pagination code start========================= */	

	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	
	$start = ($page - 1) * $limit;
	
	$pageNumber=$start+1;
	$tpl->assign('pageNumber', $pageNumber);
	
	$pgrs=mysqli_query($conn,$sql);

	$sql.=" LIMIT ".$start.", ".$limit." ";	

	$total_rows=$pgrs->num_rows;

/* ====================pagination code end========================= */
//echo "<pre>";print_r($sql);echo "</pre>";die();

	$data = [];

	$rs = mysqli_query($conn, $sql);

	if (!$rs) {
		die("Query Error: " . mysqli_error($conn));
	}

	$field_info = mysqli_fetch_fields($rs);

	while ($row = mysqli_fetch_assoc($rs)) {
		if (!isset($row['grievance_id'])) continue;

		foreach ($field_info as $f) {
			$data[$row['grievance_id']][$f->name] = $row[$f->name] ?? null;
		}
	}

//echo"<pre>";print_r($data);echo"</pre>";die();
	
	$tpl->assign('data', $data);
	
/************************* pagination start  **************************/

	$total_pages = ceil($total_rows / $limit);
		// Generate pagination data
	$pagination = [
		'current_page' => $page,
		'total_pages' => $total_pages,
		'range' => 3 // Number of visible pages before/after the current page
	];
	
	/**************Filters***************/
	
		$filter_query = '';

		//echo "<pre>";print_r($data);echo "</pre>";die();
		
		if (!empty($fdate)) {
			$filter_query .= '&f_date=' . $fdate;
		}

		if (!empty($tdate)) {
			$filter_query .= '&t_date=' . $tdate;
		}

		if (!empty($reference_no)) {
			$filter_query .= '&reference_no=' . $reference_no;
		}
		
		//echo "<pre>";print_r($filter_query);echo "</pre>";die();

		$tpl->assign('filter_query', $filter_query);
		
	/************************************/
	
	//echo "<pre>";print_r($filter_query);echo "</pre>";die();

	$tpl->assign('filter_query', $filter_query);	
	$tpl->assign('pagination', $pagination);
	$tpl->assign('current_page', $page);
	$tpl->assign('total_pages', $total_pages);
	
	$tpl->assign('dept_id', $wardid);
	
/************************* pagination end  **************************/	

	$sql = "select ward_id,ward_desc from ward_mst";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$ward_list[$row['ward_id']] = $row['ward_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	//$sql = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";
	$sql = "select grievance_status_id,grievance_status_desc from grievance_status_mst";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$grievance_status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

//echo"<pre>";print_r($data);echo"<pre>";die();


	$sql = "select dept_id,dept_desc from standard_departments";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$tpl->assign('dept_list', $dept_list);

	$sql = "select emp_id, emp_name, emp_mobile from emp_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {

		$emp_list[$row['emp_id']] = $row['emp_name'] . " - " . $row['emp_mobile'];

		$emp_mobile[$row['emp_id']] = $row['emp_mobile'];
	}



	$tpl->assign('emp_list', $emp_list);

	$tpl->assign('emp_mobile', $emp_mobile);


	$sql = "select cs_id,cs_desc as comp_desc from standard_services";



	if ($_REQUEST['aptid'] == '1') {

		$sql = "select cs_id,cs_desc as comp_desc from cs_mst";
	}

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$cs_list[$row['cs_id']] = $row['comp_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select user_id,user_name from users where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$users_list[$row['user_id']] = $row['user_name'];
	}



	//echo "<pre>";print_r($sql);echo "</pre>";die();


	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$dept_list1[$row['dept_id']] = $row['dept_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select * from street_mst";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$street_list[$row['street_id']] = $row['street_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));


	mysqli_close($conn);

	$tpl->assign('street_list', $street_list);

	$tpl->assign('update_previlize', $_SESSION['update_previlize']);

	$tpl->assign('hod_status2', $_SESSION['hod_status2']);

	$tpl->assign('hod_status', $_SESSION['hod_status']);

	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('users_list', $users_list);

	$tpl->assign('status', $status1);

	$tpl->assign('date', $date);

	$tpl->assign('reference_no', $_REQUEST['reference_no']);

	$tpl->assign('sla', $_REQUEST['sla']);

	$tpl->assign('fdate', $f_date);

	$tpl->assign('tdate', $t_date);

	$tpl->assign('pagination', $pagination);

	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('ulbid', $ulbid1);

	$tpl->assign('app_type_id', $_REQUEST['aptid']);

	$tpl->assign('cs_list', $cs_list);	

	$tpl->assign('dept_list1', $dept_list1);

	$tpl->assign('ward_list', $ward_list);

	$tpl->assign('banner', $_SESSION['banner']);

	$tpl->assign('logo', $_SESSION['logo']);

	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('grievance_status_list', $grievance_status_list);

	$tpl->assign('services', $obj->services);

	$tpl->assign('uname', $_SESSION['user_name']);

	$tpl->assign('uid', $_SESSION['uid']);

	$tpl->display('street_complaints.tpl');
} else {

	echo "<script>window.location='index.php';</script>";
}
