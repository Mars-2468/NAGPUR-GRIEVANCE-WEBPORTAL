<?php
require "config.php";

ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('Smarty.class.php');
date_default_timezone_set('Asia/Kolkata');

$tpl = new Smarty();

//$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:date('Y');
$ward_id = !empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';
$hod_status2 = !empty($_SESSION['hod_status2'])?$_SESSION['hod_status2']:'';
$hod_status = !empty($_SESSION['hod_status'])?$_SESSION['hod_status']:'';
$user_name = !empty($_SESSION['user_name'])?$_SESSION['user_name']:'';
$uid = !empty($_SESSION['uid'])?$_SESSION['uid']:'';

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

/************************* pagination part start  **************************/
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	$start = ($page - 1) * $limit;
	$pageNumber=$start+1;
/************************* pagination part end  **************************/

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

	$aptid1 = !empty($_REQUEST['app_type_id'])?$_REQUEST['app_type_id']:'';

	$reference_no = !empty($_REQUEST['reference_no'])?$_REQUEST['reference_no']:'';

	$status1 = !empty($_REQUEST['status'])?$_REQUEST['status']:'';

	$ulbid1 = !empty($_SESSION['ulbid'])?$_SESSION['ulbid']:'';

	$user_type1 = $_SESSION['user_type'];

	$sla1 = !empty($_REQUEST['sla'])?$_REQUEST['sla']:'';
	$reference_no = !empty($_REQUEST['reference_no'])?$_REQUEST['reference_no']:'';

	$date = date('Y-m-d');

//echo "<pre>";print_r($_SESSION);echo "</pre>";die();

/////////////////////////////////////////////////////////////////// admin start

		// User type P			
		$sql="SELECT 
			g.*, 
			gt.file_url AS updated_image, 
			gt.disposed_date, 
			gt.dept_id, 
			gt.emp_id
		FROM 
			grievances g
		INNER JOIN 
			".$_SESSION['grievances_trns']." gt ON g.grievance_id = gt.grievance_id	
		WHERE 
			g.app_type_id = '1' 
			and g.ulbid = '250' 
			and g.cat3_id != '0'      
		";



		if ($_REQUEST['status'] == 100) { 	// table bottom totals	
			$sql.=" and g.grievance_status_id IN (2, 3, 5, 6, 8, 9, 10, 11, 12, 13) and gt.disposal_status IN (2, 3, 5, 6, 8, 9, 10, 11, 12, 13) ";
		
		}else if ($_REQUEST['status'] == 121) {			

				$sql .= " and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and sla_status=1 ";

		}else if ($_REQUEST['status'] == 122) {			

				$sql .= " and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and sla_status=2 ";

		}else if ($_REQUEST['status'] == 13891) {		

				$sql .= " and g.grievance_status_id IN(3,8,9) and sla_status=1 ";

		}else if ($_REQUEST['status'] == 13892) {		

				$sql .= " and g.grievance_status_id IN(3,8,9) and sla_status=2 ";

		}else if ($_REQUEST['status'] == 113) {			

				$sql .= " and g.grievance_status_id IN(13) and gt.disposal_status IN(13) ";

		}else if ($_REQUEST['status'] == 111) {			

				$sql .= " and g.grievance_status_id IN(11) and gt.disposal_status IN(11) ";

		}else if ($_REQUEST['status'] == 112) {			

				$sql .= " and g.grievance_status_id IN(12) and gt.disposal_status IN(12) ";

		}else if ($_REQUEST['status'] == 106) {			

				$sql .= " and g.grievance_status_id IN(6) ";

		}else if ($_REQUEST['status'] == 1510) {		

				$sql .= " and g.grievance_status_id IN(5,10) ";

		}
	

	if ($ward_id != '') {
		
		$sql .= " and g.ward_id=" . $ward_id . " ";

	}	

	if ($selectedYear != '') {
		
		$sql .= " and date_format(date_regd,'%Y')>='" . $selectedYear . "' ";

	}


	if (isset($_POST['search'])) {
		$reference_no=$_POST['reference_no'];
		if ($reference_no != '') {

			$sql .= " and g.grievance_id='" . $reference_no . "' ";

		}
	}
	
	if ($f_date!= '' && $t_date != '') {


		$f_date = date('Y-m-d', strtotime($f_date));

		$t_date = date('Y-m-d', strtotime($t_date));


		$sql .= " and date_format(date_regd,'%Y-%m-%d') between '" . $f_date . "' and '" . $t_date . "' ";
	}
	
	

	$sql .= " order by g.grievance_id DESC ";

/* ************************ pagination part start  ************************* */
		$pg_sql=$sql;
		
		$sql.=" LIMIT ".$start.", ".$limit." ";	
		
//echo "<pre>";print_r($sql);echo "</pre>";die();	
		
		$pgrs=mysqli_query($conn,$pg_sql);
		
			$total_rows=$pgrs->num_rows;
	//echo"<pre>";print_r($total_rows);echo"</pre>";die();
/* ************************ pagination part end  ************************* */

	if ($rs = mysqli_query($conn, $sql)) {
		$field_info = mysqli_fetch_fields($rs);

		while ($row = mysqli_fetch_assoc($rs)) {
			foreach ($field_info as $fi => $f)
				$data[$row['grievance_id']][$f->name] = $row[$f->name];
		}
	}

//echo"<pre>";print_r($data[11]['cutt_of_time']);echo"</pre>";die();
	
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



	if ($aptid1 == '1') {

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



/************************* pagination start  **************************/
	
		
	// Query to fetch paginated data


	// Calculate total pages
	
	$total_pages = ceil($total_rows / $limit);
	


	// Generate pagination data
	$pagination = [
		'current_page' => $page,
		'total_pages' => $total_pages,
		'range' => 3 // Number of visible pages before/after the current page
	];
			
	$filter_query = '';
	
	if (!empty($status)) {
		$filter_query .= '&status=' . urlencode($status);
	}
	
	if (!empty($fdate)) {
		$filter_query .= '&f_date=' . urlencode($fdate);
	}

	if (!empty($tdate)) {
		$filter_query .= '&t_date=' . urlencode($tdate);
	}

	if (!empty($reference_no)) {
		$filter_query .= '&reference_no=' . urlencode($reference_no);
	}


	//echo "<pre>";print_r($filter_query);echo "</pre>";die();

	$tpl->assign('filter_query', $filter_query);
	$tpl->assign('pageNumber', $pageNumber);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('current_page', $page);
	$tpl->assign('total_pages', $total_pages);
	
/************************* pagination end  **************************/

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


		$complaint_from=[
			'1'=>'Web',
			'2'=>'Phone',
			'3'=>'Counter',
			'4'=>'App',
			'5'=>'WhatsApp',
			'6'=>'Facebook',
			'7'=>'EBC',
			'8'=>'Garden',
		];



$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . $_SESSION['ulbid'] . "'";
	$rs = mysqli_query($conn, $sql);
	$online_applications=[];
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}

	mysqli_close($conn);

	$tpl->assign('street_list', $street_list);
	$tpl->assign('update_previlize', $_SESSION['update_previlize']);
	$tpl->assign('hod_status2', $hod_status2);
	$tpl->assign('hod_status', $hod_status);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('users_list', $users_list);
	$tpl->assign('status', $_REQUEST['status']);
	$tpl->assign('date', $date);
	$tpl->assign('complaint_from', $complaint_from);
	$tpl->assign('reference_no', $reference_no);
	$tpl->assign('sla', $sla1);
	$tpl->assign('fdate', $f_date);
	$tpl->assign('tdate', $t_date);
	$tpl->assign('pagination', $pagination);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('app_type_id', $aptid1);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('dept_list1', $dept_list1);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('grievance_status_list', $grievance_status_list);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $user_name);
	$tpl->assign('uid', $uid);
	$tpl->display('corp_total_street_complaints.tpl');
} else {

	echo "<script>window.location='index.php';</script>";
}
