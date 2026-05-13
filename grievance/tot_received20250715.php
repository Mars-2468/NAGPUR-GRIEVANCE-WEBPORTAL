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

$f_date =!empty($_POST['f_date'])? date('Y-m-d', strtotime($_POST['f_date'])):'';
$t_date =!empty($_POST['t_date'])? date('Y-m-d', strtotime($_POST['t_date'])):'';	
			

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

	$aptid1 = $_REQUEST['aptid'];

	$reference_no = $_REQUEST['reference_no'];

	$status1 = $_REQUEST['status'];

	$ulbid1 = $_SESSION['ulbid'];

	$user_type1 = $_SESSION['user_type'];

	$sla1 = $_REQUEST['sla'];


	$date = date('Y-m-d');

//echo "<pre>";print_r($_REQUEST);echo "</pre>";die();

/////////////////////////////////////////////////////////////////// admin start

	if ($_REQUEST['aptid'] == 1 && $_SESSION['user_type'] == 'U') {

		// User type U	

		if ($_REQUEST['status'] == 111 && $_REQUEST['sla'] == 0) {

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where DATE(g.date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0' and gt.disposal_status !=5 AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and cat3_id !='0'  and grievance_status_id in(2,3,5,6,8,9,10,11,12,13) " ;

	
				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status !=5 and cat3_id !='0' ";

			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {


					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));


					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			$sql .= " order by g.grievance_id DESC";
			$sqlExcel .= ' group by g.grievance_id order by date_regd DESC';
			//echo $sqlExcel;

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status !=5 and cat3_id !='0'";

			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= " order by date_regd DESC";

		}else if ($_REQUEST['status'] == 0 && $_REQUEST['sla'] == 0) {


			$sql = "SELECT g.*,gt.emp_id,gt.dept_id,gt.disposal_status FROM grievances g, ".$_SESSION['grievances_trns']." gt,ulbmst u ,cs_mst c where g.grievance_id=gt.grievance_id and
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and gt.disposal_status !=5";

			$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,grievance_status_desc as Status ,date_regd as ReceivedDate ,c.cs_desc as ComplaintDetails,emp_name as EmployeeName,emp_mobile as EmployeeMobile FROM grievances g, ".$_SESSION['grievances_trns']." gt,ulbmst u ,cs_mst c,grievance_status_mst gsm,emp_mst e where g.grievance_id=gt.grievance_id and
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and gt.disposal_status=gsm.grievance_status_id and gt.emp_id=e.emp_id and app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='1' and gt.emp_id IN('87') and (gt.disposal_status !=5 or (gt.disposal_status =5 and is_escalated=1))";

			if (isset($_POST['search'])) {
				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}
				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			$sql .= " order by date_regd DESC";

			$query = "SELECT count(grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' ";


			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= " order by date_regd DESC";
		}else if ($_REQUEST['status'] == 1 && $_REQUEST['sla'] == 0) {

			$sql = "select * from grievances where ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='1'";

			$sqlExcel = "select c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,cs_mst c,grievance_status_mst gsm where g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id='1' and app_type_id='1'";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}

			$sql .= " order by date_regd DESC";

			$query = "select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 

        		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='1'";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}


			$query .= " order by date_regd DESC";
		}else if (($_REQUEST['status'] == 201) && ($_REQUEST['sla'] == 0)) {
//user type U

			$sql = "Select g.grievance_id,g.ward_id,g.street_id,g.mcat3_id,g.cat3_id,g.date_regd,g.app_type_id,g.ulbid,g.grievance_status_id,g.person_name,g.mobile,g.address,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date,gt.disposal_status from grievances g,ulbmst u ,cs_mst c,grievances_trns gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('5','10') and g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1'";

		//	echo "<pre>";print_r($sql);echo "</pre>";die();

			/* $sql = "SELECT g.* ,gt.emp_id,gt.dept_id,gt.disposal_status FROM grievances g, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and
			g.ulbid='".strip_tags($_SESSION['ulbid'])."' and app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('5') and gt.disposal_status IN('2','5','10') ";
			*/
			
			if ($selectedYear) { 
				$sql .="   AND YEAR(g.date_regd) = '" . $selectedYear . "'  ";
			}
			
			$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,grievance_status_desc as Status ,date_regd as ReceivedDate ,c.cs_desc as ComplaintDetails,emp_name as EmployeeName,emp_mobile as EmployeeMobile FROM grievances g, ".$_SESSION['grievances_trns']." gt,ulbmst u ,cs_mst c,grievance_status_mst gsm,emp_mst e where g.grievance_id=gt.grievance_id and
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and gt.disposal_status=gsm.grievance_status_id and gt.emp_id=e.emp_id and app_type_id='1'"; 
			
			// $sql="SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='1' and gt.emp_id IN('87') and (gt.disposal_status =5 or (gt.disposal_status =5 and is_escalated=1))";

			if (isset($_POST['search'])) {
				
				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "' ";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}
				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
				
			}
			
			$sql .= " order by date_regd "; 

			$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('5') and gt.disposal_status IN('2','5','10') ";
			
			if ($selectedYear) { 
				$query .="  AND YEAR(g.date_regd) = '" . $selectedYear . "'  ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(g.date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			
			$query .= " order by date_regd DESC";
			
			//echo "<pre>";print_r($sql);echo "</pre>";die();
			
		} else if ($_REQUEST['status'] == 2 && $_REQUEST['sla'] == 1) {


			$sql = "SELECT g.*,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,

		ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,

		".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

		g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) ";


			$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,date_regd as ComplaintRegisteredDate,disposed_date as ComplaintResolvedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as ComplaintToBeResolvedDate

		,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS NumberOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g,

		".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

		g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and app_type_id='1' and g.grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) ";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$sql .= " order by date_regd DESC";


			$query = "SELECT count(grievance_id) as num FROM grievances g,cs_mst c,ulbmst u where g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 ";

			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}



			$query .= " order by date_regd DESC";
		} else if ($_REQUEST['status'] == 2 && $_REQUEST['sla'] == 2) {


			$sql = "SELECT g.*,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,

			ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,

			".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,date_regd as ComplaintRegisteredDate,disposed_date as ComplaintResolvedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as ComplaintToBeResolvedDate

			,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS NumberOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g,

			".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and app_type_id='1' and g.grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) ";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}

			$sql .= " order by date_regd DESC";

			$query = "SELECT count(grievance_id) as num FROM grievances g,cs_mst c,ulbmst u where g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 ";


			if (isset($_POST['search'])) {


				if ($_POST['reference_no'] != '') {

					$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}


				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}

			$query .= " order by date_regd DESC";
		} else if ($_REQUEST['status'] == 3 && $_REQUEST['sla'] == 1) {

//user type U
			$query = "SELECT count(grievance_id) as num FROM grievances g, cs_mst c,ulbmst u where g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=1";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}

			$query .= " order by date_regd DESC";

			$sql = "SELECT g.*,gt.emp_id,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,

			ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(NOW(),g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,

			".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) ";


			$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as ComplaintToBeCompletedDate,

			DATEDIFF(NOW(),g.date_regd)-ccm.cutt_off_time-holidays_added  AS NoOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g,

			".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and app_type_id='1' and g.grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) ";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}


				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$sql .= " order by date_regd DESC";
		} else if ($_REQUEST['status'] == 3 && $_REQUEST['sla'] == 2) {
//user type U

			$sql = "SELECT g.*,gt.emp_id,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,

			ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(NOW(),g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,

			".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and gt.disposal_status !=5 and 

			is_reopened_yn='0' ";


			$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as ComplaintToBeCompletedDate,

			DATEDIFF(NOW(),g.date_regd)-ccm.cutt_off_time-holidays_added  AS NoOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g,

			".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and app_type_id='1' and g.grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) ";

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}





				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$sql .= " order by date_regd DESC";


			$query = "SELECT count(grievance_id) as num FROM grievances g,cs_mst c,ulbmst u where g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=2";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}
			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 6) { 
		
//user type U

			if ($selectedYear) {

				$sql = "SELECT g.*,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed FROM grievances g,".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
				g.cat3_id=ccm.cs_id and app_type_id='1' and g.grievance_status_id IN ('6') and gt.disposal_status IN (6) and gt.disposal_status !=5 AND YEAR(date_regd) = '" . $selectedYear . "' and (is_reopened_yn='0' || is_reopened_yn is null)";

				$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate,date_regd as ComplaintRegisteredDate,disposed_date as ComplaintResolvedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd,
				INTERVAL ccm.cutt_off_time+holidays_added DAY) as ComplaintToBeResolvedDate ,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS NumberOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g, ".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id 
				and g.ulbid='" . $_SESSION['ulbid'] . "' and g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and g.ward_id=w.ward_id and g.street_id=s.street_id and app_type_id='1' and g.grievance_status_id IN ('6') and gt.disposal_status IN ('6') and gt.disposal_status !=5 AND YEAR(date_regd) = '" . $selectedYear . "' and (is_reopened_yn='0' || is_reopened_yn is null);";
			} else {

				$sql = "SELECT g.*,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed,gt.dept_id FROM grievances g,".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 
				g.cat3_id=ccm.cs_id and app_type_id='1' and g.grievance_status_id IN ('6') and gt.disposal_status IN (6) and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) ";

				$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate,date_regd as ComplaintRegisteredDate,disposed_date as ComplaintResolvedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd,
				INTERVAL ccm.cutt_off_time+holidays_added DAY) as ComplaintToBeResolvedDate ,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS NumberOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g, ".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id 
				and g.ulbid='" . $_SESSION['ulbid'] . "' and g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and g.ward_id=w.ward_id and g.street_id=s.street_id and app_type_id='1' and g.grievance_status_id IN ('6') and gt.disposal_status IN ('6') and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null);";
			}
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			$sql .= "  order by date_regd DESC";

			//echo $sql;

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 
				g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='6' and app_type_id='1' and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$query = "select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 
				g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='6' and app_type_id='1' and cat3_id !='0'";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query . " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}
				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}
			$query .= " order by date_regd DESC";
		} else if ($_REQUEST['status'] == 10) {


			$sql = "SELECT g.*,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,

			ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,

			".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id ='10' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,date_regd as ComplaintRegisteredDate,disposed_date as ComplaintResolvedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as ComplaintToBeResolvedDate

			,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS NumberOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g,

			".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and app_type_id='1' and g.grievance_status_id ='10' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) ";


			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}

			$sql .= " order by date_regd DESC";

			$query = "select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 

			g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='10' and app_type_id='1'";



			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}

			$query .= " order by date_regd DESC";
		} else if ($_REQUEST['status'] == 11) {


			$sql = "SELECT g.*,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,

				ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,

				".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

				g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id ='4' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";

			$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,date_regd as ComplaintRegisteredDate,disposed_date as ComplaintResolvedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as ComplaintToBeResolvedDate

				,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS NumberOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g,

				".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

				g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and app_type_id='1' and g.grievance_status_id ='4' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) ";



			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}


				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}

			$sql .= "  order by date_regd DESC";

			$query = "select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 

			g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='4' and app_type_id='1'";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}


			$query .= " order by date_regd DESC";
		}
	}



	/////////////////////////////////////////////////////////////////// Employee complaints start



	if ($_REQUEST['aptid'] == 1 && $_SESSION['user_type'] == 'E') {

		// User type E

		if ($_REQUEST['status'] == 111 && $_REQUEST['sla'] == 0) {

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and cat3_id !='0' and gt.disposal_status !=5 AND YEAR(date_regd) = '" . $selectedYear . "'";

				$esca_sql = "SELECT g.*,gt.file_url as updated_image FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and cat3_id !='0' and gt.disposal_status !=5 ";

				$esca_sql = "SELECT g.*,gt.file_url as updated_image FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and cat3_id !='0'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status !=5 and cat3_id !='0' ";
			}
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= ' group by g.grievance_id order by date_regd DESC';

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where DATE(date_regd) = '" . $date . "' and g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and cat3_id !='0'";
			}
			
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= " order by date_regd DESC";
			//echo $sql;
			//echo $sqlExcel;


		} else if ($_REQUEST['status'] == 100 && $_REQUEST['sla'] == 2) { 

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.disposal_status, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id IN (3,8,9) and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate, gt.disposal_status from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN (3,8,9) and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date,gt.disposal_status FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id IN (3,8,9) and cat3_id !='0' ";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate, gt.disposal_status from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN (3,8,9) and gsm.grievance_status_id IN (3,8,9) and cat3_id !='0' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}
			//$sql.=" order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status!=5 and g.grievance_status_id IN ('3','6','8','9','12') and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status!=5 and g.grievance_status_id IN ('3','6','8','9','12') and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null)";
			}
			
			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= " order by date_regd DESC";

			//echo $sqlExcel;

		} else if ($_REQUEST['status'] == 200 && $_REQUEST['sla'] == 2) {

			if ($selectedYear) {
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN('2') and g.grievance_status_id IN('2')  and cat3_id !='0'  and cat3_id !='0' and (gt.is_reopened_yn='0' || gt.is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate,gt.disposal_status from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.grievance_status_id IN('2','11') and cat3_id !='0' and gt.disposal_status IN('2','11') and g.ward_id=w.ward_id and g.street_id=s.street_id AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN('2') and g.grievance_status_id IN('2') and cat3_id !='0'  and cat3_id !='0' and (gt.is_reopened_yn='0' || gt.is_reopened_yn is null) ";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate,gt.disposal_status from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN('11') and cat3_id !='0' and g.grievance_status_id IN('11') and g.ward_id=w.ward_id and g.street_id=s.street_id ";
			}
			
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//$sql.=" order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";

			if ($selectedYear) {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN ('" . $emplist . "') and gt.disposal_status IN('2','11') and app_type_id='1' and g.grievance_status_id IN('2','11') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN ('" . $emplist . "') and gt.disposal_status IN('2','11') and app_type_id='1' and g.grievance_status_id IN('2','11') and cat3_id !='0'";
			}

			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}
		
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= " order by date_regd DESC";

		} else if ($_REQUEST['status'] == 0 && $_REQUEST['sla'] == 0) {


			if ($selectedYear) {
				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(g.date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date,gt.disposal_status FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and cat3_id !='0' and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13)  AND YEAR(date_regd) = '" . $selectedYear . "'";

				$esca_sql = "SELECT g.*,gt.file_url as updated_image FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(gt.disposed_date,g.date_regd) - ccm.cutt_off_time - g.holidays_added AS no_of_days_exeed, DATE_ADD(g.date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date,gt.disposal_status FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and cat3_id!='0' and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13)  ";

				$esca_sql = "SELECT g.*,gt.file_url as updated_image FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and cat3_id !='0'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate,gt.disposal_status from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status !=5 and cat3_id !='0' ";
			}
			
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			
			
			//echo "<pre>";print_r($sql);echo "</pre>";die();
			
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and cat3_id !='0'";
			}
			
			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}
			
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= " order by date_regd DESC";
			//echo $query;
		}else if ($_REQUEST['status'] == 201 && $_REQUEST['sla'] == 0) {

// user type E		

			$sql = "Select g.*,gt.* from grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN(5,10) and gt.emp_id IN('" . $emplist . "') and g.cat3_id!=0 and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' ";

			
			$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate,gt.disposal_status from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status IN('5','10') and cat3_id !='0' and g.grievance_status_id IN('5','10') and g.ward_id=w.ward_id and g.street_id=s.street_id ";
	
			if ($selectedYear) {
				
				$sql .= " AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel .= " AND YEAR(date_regd) = '" . $selectedYear . "'";
			}
			
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}

	//echo "<pre>";print_r($sql);echo "</pre>";die();
	
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "' ";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "' ";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//$sql.=" order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";

			if ($selectedYear) {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN ('" . $emplist . "') and gt.disposal_status IN('5','10') and gt.disposal_status IN('5','10') and app_type_id='1' and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN ('" . $emplist . "') and gt.disposal_status IN('5','10') and gt.disposal_status IN('5','10') and app_type_id='1' and cat3_id !='0'";
			}
			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= " order by date_regd DESC";
			
		} else if ($_REQUEST['status'] == 1 && $_REQUEST['sla'] == 0) {

			$sql = "select g.* from grievances g,cs_mst c,ulbmst u where g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='1' and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}


				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$sql .= " order by date_regd DESC";


			$query = "SELECT count(DISTINCT grievance_id) as num from grievances g,cs_mst c,ulbmst u where g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='1' and 
			gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {


					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= " order by date_regd DESC";
		} else if ($_REQUEST['status'] == 2 && $_REQUEST['sla'] == 1) {
	
	//within sla	

			if ($selectedYear) {
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "')  
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN(3,8,9) and sla_status=1 and gt.is_escalated=0 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('3','6','8','9','12') and sla_status=1 and gt.disposal_status IN('3','6','8','9','12') and cat3_id !='0' and gt.is_escalated=0 AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "')  
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN(3,8,9) and sla_status=1 and gt.is_escalated=0 and cat3_id !='0' ";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status IN('3','6','8','9','12') and cat3_id !='0' and gt.is_escalated=0 ";
			}
			
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//12-04-24 $sql .= "  order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT(g.grievance_id)) as num FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.is_escalated=0 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$query = "SELECT count(DISTINCT(g.grievance_id)) as num FROM ".$_SESSION['grievances_trns']." gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.is_escalated=0 and cat3_id !='0' ";
			}
			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= "  order by date_regd DESC";
			//echo $query;

		} else if ($_REQUEST['status'] == 2 && $_REQUEST['sla'] == 2) {
	//beyound sal

			if ($selectedYear) {
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN(3,8,9) and sla_status=2 AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN(3,8,9) and sla_status=2 and cat3_id !='0'  AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN(3,8,9) and sla_status=2  ";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN(3,8,9) and sla_status=2 and cat3_id !='0' ";
			}

			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}
		
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//12-04-24 $sql .= "  order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";
			//echo $sqlExcel; 

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";
			}

			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}
		
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= "  order by date_regd DESC";

		} else if ($_REQUEST['status'] == 3 && $_REQUEST['sla'] == 1) {
//user type E			
		
			if ($selectedYear) {
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and sla_status=1  and  (gt.is_reopened_yn='0' || gt.is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('2','11') and sla_status=1 and gt.disposal_status IN('2','11') and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and g.sla_status=1 and (gt.is_reopened_yn='0' || gt.is_reopened_yn is null) ";

//echo "<pre>";print_r($sql);echo "</pre>";die();

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('2','11') and sla_status=1 and gt.disposal_status IN('2','11') and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null)";
			}

			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}
		
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//12-04-24 $sql .= " order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,category3_mst c,ulbmst u , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,category3_mst c,ulbmst u , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";
			}
			
			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			
			$query .= " order by date_regd DESC";
			
		} else if ($_REQUEST['status'] == 3 && $_REQUEST['sla'] == 2) {

// user type E

			if ($selectedYear) {
				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date,gt.disposal_status FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN(2) and sla_status=2 and gt.disposal_status IN(2) and (is_reopened_yn='0' || is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date,gt.disposal_status FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN(2) and sla_status=2 and gt.disposal_status IN(2) and (is_reopened_yn='0' || is_reopened_yn is null)";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null)";
			}

			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//12-04-24 $sql .= "  order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";
			//echo $sqlExcel;

			if ($selectedYear) {
				$query = "SELECT count(DISTINCT g.grievance_id) as numFROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$query = "SELECT count(DISTINCT g.grievance_id) as numFROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";
			}

			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}
		
			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == '005') {
			
			if ($selectedYear) { 
				$sql = "SELECT DISTINCT g.grievance_id,g.ward_id,g.cat3_id,g.app_type_id,g.person_name,g.address,g.mobile,g.street_id,g.date_regd,g.grievance_status_id,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and c.cs_id=ccm.cs_id and ccm.cs_id=ss.cs_id and app_type_id='1' and g.grievance_status_id IN(13) and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN(13) and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and c.cs_id=ccm.cs_id and ccm.cs_id=ss.cs_id and app_type_id='1' and g.grievance_status_id IN(13) and cat3_id !='0'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN(13) and cat3_id !='0'";
			}
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//12-04-24 $sql .= "  order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";
			//echo $sqlExcel;

			if ($selectedYear) {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id IN('13','11','12') and gt.disposal_status NOT IN('5','9') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id IN('13','11','12') and gt.disposal_status NOT IN('5','9') and cat3_id !='0'";
			}
			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == '0019') {

			$sql = "SELECT g.*,gt.file_url as updated_image FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.disposal_status IN('13') and g.grievance_status_id IN('13') and cat3_id !='0'";

			$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
			and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status IN('13') and g.grievance_status_id IN('13') and cat3_id !='0'";

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//12-04-24 $sql .= "  order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";
			//echo $sqlExcel;

			$query = "SELECT count(DISTINCT g.grievance_id) as numFROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.disposal_status IN('13') and g.grievance_status_id IN('13') and cat3_id !='0'";

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == '601') {
			if ($selectedYear) {
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id IN(12) and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status !=5 and g.grievance_status_id IN('12') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id IN(12) and cat3_id !='0'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status !=5 and g.grievance_status_id IN('12') and cat3_id !='0'";
			}
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//12-04-24 $sql .= "  order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";
			//echo $sqlExcel;

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT g.grievance_id) as numFROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.disposal_status !=5 and g.grievance_status_id IN('12') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$query = "SELECT count(DISTINCT g.grievance_id) as numFROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.disposal_status !=5 and g.grievance_status_id IN('12') and cat3_id !='0'";
			}
			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == '503') {
			
			
			if ($selectedYear) {
				
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and g.grievance_status_id IN(11) and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status IN('11') and g.grievance_status_id IN('11') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			
			} else {
				
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.app_type_id='1' and g.grievance_status_id IN(11) and gt.disposal_status IN(11) and g.cat3_id !='0'";
//echo "<pre>";print_r($sql);echo "</pre>";die();
				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status IN('11') and g.grievance_status_id IN('11') and cat3_id !='0'";
			
			}
			
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}
			

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}

			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";
			//echo $sqlExcel;

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT g.grievance_id) as num, gt.disposal_status FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.disposal_status IN('11') and g.grievance_status_id IN('11') and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {
				$query = "SELECT count(DISTINCT g.grievance_id) as num, gt.disposal_status FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.disposal_status IN('11') and g.grievance_status_id IN('11') and cat3_id !='0'";
			}
			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 6) {
//user type E

			if ($selectedYear) {
				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('6') and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('6') and gt.disposal_status !=5 and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null) AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$sql = "SELECT g.*,gt.file_url as updated_image,gt.disposal_status, gt.disposed_date, gt.dept_id, gt.emp_id,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date FROM grievances g,cs_mst c,ulbmst u,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and
				g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('6') and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";

				$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
				and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('6') and gt.disposal_status !=5 and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null)";
			}
			if ($selectedDept) { 
				$sql .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}

			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";

			if ($selectedYear == '2023' || $selectedYear == '2024' || $selectedYear == '2025') {
				$query = "SELECT count(DISTINCT g.grievance_id) as num from grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and grievance_status_id='6' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0' AND YEAR(date_regd) = '" . $selectedYear . "'";
			} else {

				$query = "SELECT count(DISTINCT g.grievance_id) as num from grievances g,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and grievance_status_id='6' and app_type_id='1' and gt.disposal_status !=5 and cat3_id !='0'";
			}
			if ($selectedDept) { 
				$query .=" and gt.dept_id = '".$selectedDept."' ";
			}

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}
			$query .= "  order by date_regd DESC";

		} else if ($_REQUEST['status'] == 10) {

			$sql = "SELECT g.*,gt.file_url as updated_image FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('10')  and gt.disposal_status !=5";

			$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
			and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('10') and gt.disposal_status !=5 and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null)";

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//12-04-24 $sql .= " order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";


			$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('10')  and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}
			$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
		} else if ($_REQUEST['status'] == 11) {

			$sql = "SELECT g.*,gt.file_url as updated_image FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('4')  and gt.disposal_status !=5";

			/*12-04-24 $sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,cs_mst c,ulbmst u,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='1' and g.grievance_status_id ='4'  and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";*/

			$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, ".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
			and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and g.grievance_status_id IN('4') and gt.disposal_status !=5 and cat3_id !='0' and (is_reopened_yn='0' || is_reopened_yn is null)";

			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}
			//12-04-24 $sql .= " order by date_regd DESC";
			$sql .= " group by g.grievance_id order by g.grievance_id DESC";
			$sqlExcel .= " group by g.grievance_id order by g.grievance_id DESC";

			$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 
			g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('4')  and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}

				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));

					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}
			$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
		}

	}


	if ($_REQUEST['aptid'] == 2 && $_SESSION['user_type'] == 'E') {

		// User type U

		if ($_REQUEST['status'] == 0 && $_REQUEST['sla'] == 0) {

			$sql = "SELECT g.*,gt.disposed_date,gt.disposal_status FROM grievances g,ulbmst u ,standard_services c,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and 

			g.mcat3_id=c.cs_id and app_type_id='2' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status !=5 ";


			$sqlExcel = "SELECT c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,date_regd as ServiceRegisterDate grievance_status_desc as Status ,date_regd as ReceivedDate,gt.disposal_status FROM grievances g,ulbmst u ,standard_services c,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and 

			g.mcat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='2' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status !=5";


			if (isset($_POST['search'])) {


				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}


				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$sql .= "  order by date_regd DESC";


			$query = "SELECT count(g.grievance_id) as num FROM grievances g,ulbmst u ,standard_services c,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and

	            g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and gt.emp_id IN('" . $emplist . "') and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}





				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}


			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 1 && $_REQUEST['sla'] == 0) {

			$sql = "select g.* from grievances g,standard_services c,ulbmst u where 

            		g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='2' and gt.disposal_status !=5 and 

            		is_reopened_yn='0'";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}


			$sql .= "  order by date_regd DESC";


			$query = "select count(grievance_id) as num from grievances g,standard_services c,ulbmst u where 

		                    g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='2' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}

			$sql .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 2 && $_REQUEST['sla'] == 1) {

			$sql = "SELECT g.* FROM grievances g,standard_services c,ulbmst u,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			$sqlExcel = "SELECT c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,standard_services c,ulbmst u,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='2' and g.grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$sql .= "  order by date_regd DESC";
			$query = "SELECT count(g.grievance_id) as num FROM grievances g,standard_services c,ulbmst u,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}



			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 2 && $_REQUEST['sla'] == 2) {

			$sql = "SELECT g.* FROM grievances g,standard_services c,ulbmst u, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			$sqlExcel = "SELECT c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,standard_services c,ulbmst u,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='2' and g.grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}





				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}

			$sql .= " order by date_regd DESC";

			$query = "SELECT count(g.grievance_id) as num FROM grievances g,standard_services c,ulbmst u,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}





				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}


			$query .= " order by date_regd DESC";
		} else if ($_REQUEST['status'] == 3 && $_REQUEST['sla'] == 1) {

			$sql = "SELECT g.* FROM grievances g,standard_services c,ulbmst u, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";


			$sqlExcel = "SELECT c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,standard_services c,ulbmst u, ".$_SESSION['grievances_trns']." gt,grievance_status_desc gsm where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='2' and g.grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}

			$sql .= "  order by date_regd DESC";

			$query = "SELECT count(g.grievance_id) as num FROM grievances g,standard_services c,ulbmst u , ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";
				}
			}

			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 3 && $_REQUEST['sla'] == 2) {

			$sql = "SELECT g.* FROM grievances g,standard_services c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			$sqlExcel = "SELECT c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,standard_services c,ulbmst u, ".$_SESSION['grievances_trns']." gt,grievance_status_desc gsm where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='2' and g.grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {


				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "'";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$sql .= " order by date_regd DESC";


			$query = "SELECT count(g.grievance_id) as num FROM grievances g,standard_services c,ulbmst u, ".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}


				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}


			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 6) {


			$sql = "SELECT g.* FROM grievances g,standard_services c,ulbmst u .".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('6')  and gt.disposal_status !=5";



			$sqlExcel = "SELECT c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,standard_services c,ulbmst u,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='2' and g.grievance_status_id ='6' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}



			$sql .= "  order by date_regd DESC";



			$query = "SELECT count(g.grievance_id) num FROM grievances g,standard_services c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('6')  and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 10) {


			$sql = "SELECT g.* FROM grievances g,standard_services c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('10')  and gt.disposal_status !=5";



			$sqlExcel = "SELECT c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,standard_services c,ulbmst u,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='2' and g.grievance_status_id ='10' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$sql .= "  order by date_regd DESC";


			$query = "SELECT count(g.grievance_id) num FROM grievances g,standard_services c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('10')  and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}



			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 11) {


			$sql = "SELECT g.* FROM grievances g,cs_mst c,standard_services u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('4')  and gt.disposal_status !=5";



			$sqlExcel = "SELECT c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate FROM grievances g,standard_services c,ulbmst u,".$_SESSION['grievances_trns']." gt,grievance_status_mst gsm where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and app_type_id='2' and g.grievance_status_id ='4' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}

			$sql .= "  order by date_regd DESC";

			$query = "SELECT count(g.grievance_id) as num FROM grievances g,standard_services c,ulbmst u ,".$_SESSION['grievances_trns']." gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('" . $emplist . "') and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('4')  and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			if (isset($_POST['search'])) {


				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}

			$query .= "  order by date_regd DESC";
		}
	}



	if ($_REQUEST['aptid'] == 2 && $_SESSION['user_type'] == 'U') {

		// User type U

		if ($_REQUEST['status'] == 0 && $_REQUEST['sla'] == 0) {

			$sql = "SELECT g.* FROM grievances g,ulbmst u ,standard_services c where g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and 

	            g.ulbid='" . $_SESSION['ulbid'] . "'";



			$sqlExcel = "SELECT g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address 

	            FROM grievances g,ulbmst u where g.ulbid=u.ulbid and app_type_id='2' and g.ulbid='" . $_SESSION['ulbid'] . "' ";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}

			$sql .= "  order by date_regd DESC";

			$query = "SELECT count(grievance_id) as num FROM grievances g,ulbmst u ,standard_services c where g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and

	            g.ulbid='" . $_SESSION['ulbid'] . "'";



			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}

			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 1 && $_REQUEST['sla'] == 0) {

			$sql = "select g.* from grievances g,standard_services c,ulbmst u where 

		g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='2'";



			$sqlExcel = "select c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.comp_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,standard_services c,ulbmst u,grievance_status_mst gsm where 

		g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id='1' and app_type_id='2'";


			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}


				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}



			$sql .= "  order by date_regd DESC";




			$query = "select count(grievance_id) as num from grievances g,standard_services c,ulbmst u where 

		g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='1' and app_type_id='2'";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}

			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 2 && $_REQUEST['sla'] == 1) {

			/*$sql="SELECT * FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 

				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1";*/



			$sql = "select g.*,person_name,mobile,c.section_id,gt.emp_id,disposed_date,DATEDIFF(disposed_date,date_regd)-c.cutt_off_time  AS no_of_days_exeed,c.cutt_off_time as target_days,

	            DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as comp_date from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		 g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id IN('3','8','9') and app_type_id='2' and sla_status=1 and 

        		gt.disposal_status !=5 and is_reopened_yn='0'";


			$sqlExcel = "select c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.comp_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,c.cutt_off_time as DisposableDays,DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as ServiceToBeCompletedDate ,disposed_date as CompletedDate,DATEDIFF(disposed_date,date_regd)-c.cutt_off_time  AS NoOfdaysExceeded

	            from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u,grievance_status_mst gsm

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		 g.ulbid=u.ulbid and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('3','8','9') and app_type_id='2' and sla_status=1 and 

        		gt.disposal_status !=5 and is_reopened_yn='0'";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$sql .= "  order by date_regd DESC";


			$query = "SELECT count(grievance_id) as num FROM grievances g,standard_services c,ulbmst u where g.ulbid='" . $_SESSION['ulbid'] . "' and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}


				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}

			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 2 && $_REQUEST['sla'] == 2) {

			/* $sql="SELECT * FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 

				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2";*/



			$sql = "select g.*,person_name,mobile,c.section_id,gt.emp_id,disposed_date,DATEDIFF(disposed_date,date_regd)-c.cutt_off_time  AS no_of_days_exeed,c.cutt_off_time as target_days,

	            DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as comp_date from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id IN('3','8','9') and app_type_id='2' and sla_status=2 and 

        		gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			$sqlExcel = "select c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.comp_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,c.cutt_off_time as DisposableDays,DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as ServiceToBeCompletedDate ,disposed_date as CompletedDate,DATEDIFF(disposed_date,date_regd)-c.cutt_off_time  AS NoOfdaysExceeded

	            from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u,grievance_status_mst gsm

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		 g.ulbid=u.ulbid and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('3','8','9') and app_type_id='2' and sla_status=2 and 

        		gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}



			$sql .= " order by date_regd DESC";

			$query = "SELECT count(grievance_id) as num FROM grievances g,standard_services c,ulbmst u where g.ulbid='" . $_SESSION['ulbid'] . "' and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 ";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}
			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 3 && $_REQUEST['sla'] == 1) {

			/*$sql="SELECT * FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 

				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=1";*/



			$sql = "select g.*,person_name,mobile,c.section_id,gt.emp_id,c.section_id,DATEDIFF(NOW(),date_regd)-c.cutt_off_time  AS no_of_days_exeed,c.cutt_off_time as target_days,

	            DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as comp_date from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id IN('2') and app_type_id='2' and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			$sqlExcel = "select c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.comp_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,c.cutt_off_time as DisposableDays,DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as ToBeCompletedDate,DATEDIFF(NOW(),date_regd)-c.cutt_off_time  AS DaysExceeded

	             from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u,grievance_status_mst gsm

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		g.ulbid=u.ulbid and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('2') and app_type_id='2' and sla_status=1 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";

			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}


			$sql .= "  order by date_regd DESC";


			$query = "SELECT count(grievance_id) as num,app_type_id FROM grievances g,standard_services c,ulbmst u where g.ulbid='" . $_SESSION['ulbid'] . "' and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=1";


			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}

			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 3 && $_REQUEST['sla'] == 2) {

			/* $sql="SELECT * FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 

				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=2";*/



			$sql = "select g.*,person_name,mobile,c.section_id,gt.emp_id,DATEDIFF(NOW(),date_regd)-c.cutt_off_time  AS no_of_days_exeed,c.cutt_off_time as target_days,

	            DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as comp_date from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		 g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id IN('2') and app_type_id='2' and sla_status=2 and 

        		gt.disposal_status !=5 and is_reopened_yn='0'";



			$sqlExcel = "select c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.comp_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,c.cutt_off_time as DisposableDays,DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as ToBeCompletedDate,DATEDIFF(NOW(),date_regd)-c.cutt_off_time  AS DaysExceeded

	             from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u,grievance_status_mst gsm

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		 g.ulbid=u.ulbid and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id IN('2') and app_type_id='2' and sla_status=2 and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			if (isset($_POST['search'])) {

				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}





				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}



			$sql .= "  order by date_regd DESC";

			$query = "SELECT count(grievance_id) as num,app_type_id FROM grievances g,standard_services c,ulbmst u where g.ulbid='" . $_SESSION['ulbid'] . "' and 

				 g.ulbid=u.ulbid and g.mcat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=2";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}

			$query .= " order by date_regd DESC";
		} else if ($_REQUEST['status'] == 6) {


			/*$sql="select * from grievances g,cs_mst c,ulbmst u where 

		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='6' and app_type_id='1'";*/



			$sql = "SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,".$_SESSION['grievances_trns']." gt,standard_services ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

				  g.mcat3_id=ccm.cs_id and app_type_id='2' and grievance_status_id ='6' and gt.disposal_status !=5 and is_reopened_yn='0' ";



			$sqlExcel = "select c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.comp_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,c.cutt_off_time as DisposableDays,DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as ServiceToBeCompletedDate ,disposed_date as CompletedDate,DATEDIFF(disposed_date,date_regd)-c.cutt_off_time  AS NoOfdaysExceeded

	            from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u,grievance_status_mst gsm

	            where g.cat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id ='6' and app_type_id='2' and 

        		gt.disposal_status !=5 and is_reopened_yn='0'";


			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}



			$sql .= "  order by date_regd DESC";

			$query = "select count(grievance_id) as num from grievances g,standard_services c,ulbmst u where 

		g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='6' and app_type_id='2'";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}

			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 10) {


			$sql = "SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,".$_SESSION['grievances_trns']." gt,standard_services ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and 

				  g.mcat3_id=ccm.cs_id and app_type_id='2' and grievance_status_id ='10' and gt.disposal_status !=5 and is_reopened_yn='0'";



			$sqlExcel = "select c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.comp_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,c.cutt_off_time as DisposableDays,DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as ServiceToBeCompletedDate ,disposed_date as CompletedDate,DATEDIFF(disposed_date,date_regd)-c.cutt_off_time  AS NoOfdaysExceeded

	            from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u,grievance_status_mst gsm

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		 g.ulbid=u.ulbid and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id ='10' and app_type_id='2' and 

        		gt.disposal_status !=5 and is_reopened_yn='0'";



			if (isset($_POST['search'])) {


				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}



			$sql .= "  order by date_regd DESC";

			$query = "select count(grievance_id) as num from grievances g,standard_services c,ulbmst u where 

		g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='10' and app_type_id='2'";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}

			$query .= "  order by date_regd DESC";
		} else if ($_REQUEST['status'] == 11) {


			/*$sql="SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,".$_SESSION['grievances_trns']." gt,category3_mst ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 

				  g.mcat3_id=ccm.cs_id and app_type_id='2' and grievance_status_id ='4' and gt.disposal_status !=5 and is_reopened_yn='0'"; */

			
			$sql = "SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as 

			comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS 

			no_of_days_exeed FROM grievances g,".$_SESSION['grievances_trns']." gt,category3_mst ccm where g.grievance_id=gt.grievance_id and 

			g.ulbid='" . $_SESSION['ulbid'] . "' and 

			g.mcat3_id=ccm.cs_id and app_type_id='2' and grievance_status_id ='4' and gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";


			$sqlExcel = "select c.comp_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.comp_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,c.cutt_off_time as DisposableDays,DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY) as ServiceToBeCompletedDate ,disposed_date as CompletedDate,DATEDIFF(disposed_date,date_regd)-c.cutt_off_time  AS NoOfdaysExceeded

	            from grievances g,".$_SESSION['grievances_trns']." gt ,standard_services c,ulbmst u,grievance_status_mst gsm

	            where g.mcat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and

        		 g.ulbid=u.ulbid and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.grievance_status_id ='4' and app_type_id='2' and 

        		gt.disposal_status !=5 and (is_reopened_yn='0' || is_reopened_yn is null)";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

					$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

					$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
				}
			}


			$sql .= " order by date_regd DESC";


			$query = "select count(grievance_id) as num from grievances g,standard_services c,ulbmst u where 

		g.mcat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='" . $_SESSION['ulbid'] . "' and grievance_status_id='4' and app_type_id='2'";



			if (isset($_POST['search'])) {



				if ($_POST['reference_no'] != '') {

					$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
				}



				if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {



					$f_date = date('Y-m-d', strtotime($_POST['f_date']));

					$t_date = date('Y-m-d', strtotime($_POST['t_date']));



					$query .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";
				}
			}

			$query .= "  order by date_regd DESC";
		}
	}



	$_SESSION['myquery'] = $sqlExcel;

	//echo $sql;



	if ($f_date == '' || $t_date == '') {

		$result = mysqli_query($conn, $query);

		//$total_pages = mysql_fetch_array($result);

		while ($row = mysqli_fetch_assoc($result)) {

			$total_pages = $row['num'];

			//echo $row['num'];

		}
	}


	//////////////// pagination end



//echo "<pre>";print_r($sql);echo "</pre>";die();


	if ($rs = mysqli_query($conn, $sql)) {
		$field_info = mysqli_fetch_fields($rs);

		while ($row = mysqli_fetch_assoc($rs)) {
			foreach ($field_info as $fi => $f)
				$data[$row['grievance_id']][$f->name] = $row[$f->name];
		}
	}

//echo"<pre>";print_r($data);echo"</pre>";die();
	$tpl->assign('count1', $count1);
	$tpl->assign('data', $data);

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

	$tpl->assign('status', $_REQUEST['status']);

	$tpl->assign('date', $date);

	$tpl->assign('reference_no', $_REQUEST['reference_no']);

	$tpl->assign('sla', $_REQUEST['sla']);

	$tpl->assign('fdate', $_POST['f_date']);

	$tpl->assign('tdate', $_POST['t_date']);

	$tpl->assign('pagination', $pagination);

	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('ulbid', $_SESSION['ulbid']);

	$tpl->assign('app_type_id', $_REQUEST['aptid']);

	$tpl->assign('cs_list', $cs_list);

	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('dept_list1', $dept_list1);

	$tpl->assign('ward_list', $ward_list);

	$tpl->assign('banner', $_SESSION['banner']);

	$tpl->assign('logo', $_SESSION['logo']);

	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('grievance_status_list', $grievance_status_list);

	$tpl->assign('services', $obj->services);

	$tpl->assign('uname', $_SESSION['user_name']);

	$tpl->assign('uid', $_SESSION['uid']);

	$tpl->display('tot_received.tpl');
} else {

	echo "<script>window.location='index.php';</script>";
}
