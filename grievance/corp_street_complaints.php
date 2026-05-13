<?php
require "config.php";
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once('Smarty.class.php');
date_default_timezone_set('Asia/Kolkata');

$tpl = new Smarty();

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

//die('test');

//$ward_id = !empty($_SESSION['zone_id'])?$_SESSION['zone_id']:'';
$ward_id = $_REQUEST['ward_id']??'';
$street_id = $_REQUEST['street_id']??'';
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

	$aptid1 = $_REQUEST['aptid']??'';

	$reference_no = $_REQUEST['reference_no']??'';

	$status1 = $_REQUEST['status']??'';

	$ulbid1 = $_SESSION['ulbid']??'';

	$user_type1 = $_SESSION['user_type']??'';

	$sla1 = $_REQUEST['sla']??'';


	$date = date('Y-m-d');

//echo "<pre>";print_r($_SESSION);echo "</pre>";die();

/////////////////////////////////////////////////////////////////// admin start

$grievances_trns = $_SESSION['grievances_trns']; // validate this!

$baseSql = "
SELECT 
    g.*,
    gt.file_url AS updated_image,
    gt.disposed_date,
    gt.dept_id,
    gt.emp_id,
    DATEDIFF(gt.disposed_date, g.date_regd) 
        - ccm.cutt_off_time 
        - g.holidays_added AS no_of_days_exeed,
    DATE_ADD(g.date_regd, INTERVAL ss.cutt_off_time DAY) AS comp_date
FROM grievances g
INNER JOIN $grievances_trns gt 
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
     g.cat3_id != 0    
";

if($app_type_id!=''){
	$baseSql .= " AND g.app_type_id = $app_type_id ";
}
if($ulbid1!=''){
	$baseSql .= " AND g.ulbid = $ulbid1 ";
}
if($ward_id!=''){
	$baseSql .= " AND g.ward_id = $ward_id ";
}
if($street_id!=''){
	$baseSql .= " AND g.street_id = $street_id ";
}

		// User type P	

		if ($_REQUEST['status'] == 0) {			
			$sql = $baseSql . " and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13) ";
		}else if ($_REQUEST['status'] == 21) {			
			$sql = $baseSql . " and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and g.sla_status=1 ";
		}else if ($_REQUEST['status'] == 22) {			
			$sql = $baseSql . " and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and g.sla_status=2 ";
		}else if ($_REQUEST['status'] == 3891) {		
			$sql = $baseSql . " and g.grievance_status_id IN(3,8,9) and g.sla_status=1  ";
		}else if ($_REQUEST['status'] == 3892) {			
			$sql = $baseSql . " and g.grievance_status_id IN(3,8,9) and g.sla_status=2  ";
		}else if ($_REQUEST['status'] == 13) {			
			$sql = $baseSql . " and g.grievance_status_id IN(13) and gt.disposal_status IN(13)  ";

		}else if ($_REQUEST['status'] == 11) {			
			$sql = $baseSql . " and g.grievance_status_id IN(11) and gt.disposal_status IN(11)  ";

		}else if ($_REQUEST['status'] == 12) {			
			$sql = $baseSql . " and g.grievance_status_id IN(12) and gt.disposal_status IN(12)  ";

		}else if ($_REQUEST['status'] == 6) {			
			$sql = $baseSql . " and g.grievance_status_id IN(6)  ";

		}else if ($_REQUEST['status'] == 510) {		
			$sql = $baseSql . " and g.grievance_status_id IN(5,10) ";

		}else if ($_REQUEST['status'] == 100) {	// table bottom totals	
			$sql = $baseSql . " and g.grievance_status_id IN(2,3,5,6,8,9,10,11,12,13) and gt.disposal_status IN(2,3,5,6,8,9,10,11,12,13)  ";

		}else if ($_REQUEST['status'] == 121) {			
			$sql = $baseSql . " and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and g.sla_status=1  ";

		}else if ($_REQUEST['status'] == 122) {			
			$sql = $baseSql . " and g.grievance_status_id IN(2) and gt.disposal_status IN(2) and g.sla_status=2  ";

		}else if ($_REQUEST['status'] == 13891) {		
			$sql = $baseSql . " and g.grievance_status_id IN(3,8,9) and g.sla_status=1  ";

		}else if ($_REQUEST['status'] == 13892) {			
			$sql = $baseSql . " and g.grievance_status_id IN(3,8,9) and g.sla_status=2  ";

		}else if ($_REQUEST['status'] == 113) {			
			$sql = $baseSql . " and g.grievance_status_id IN(13) and gt.disposal_status IN(13) ";

		}else if ($_REQUEST['status'] == 111) {			
			$sql = $baseSql . " and g.grievance_status_id IN(11) and gt.disposal_status IN(11) ";

		}else if ($_REQUEST['status'] == 112) {			
			$sql = $baseSql . " and g.grievance_status_id IN(12) and gt.disposal_status IN(12) ";

		}else if ($_REQUEST['status'] == 106) {			
			$sql = $baseSql . " and g.grievance_status_id IN(6) ";

		}else if ($_REQUEST['status'] == 1510) {		
			$sql = $baseSql . " and g.grievance_status_id IN(5,10) ";
		}


	if ($ward_id != '') {		
		$sql .= " and g.ward_id=" . $ward_id . " ";
	}

	if (isset($_SESSION['filteryear']) && ($_SESSION['filteryear'] != '')) {
		
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
	
	
	
/* ====================pagination code start========================= */	
	$page = (int)!empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	$limit=(int)$limit;
	$start = ($page - 1) * $limit;
	
	$pageNumber=$start+1;
	$tpl->assign('pageNumber', $pageNumber);
	$pg_sql=$sql;
	$pgrs=mysqli_query($conn,$pg_sql);
	
	$sql .= " order by g.grievance_id DESC ";
	$sql.=" LIMIT ".$start.", ".$limit." ";	

//	echo "<pre>";print_r($pg_sql);echo "</pre>";die();

	$total_rows=$pgrs->num_rows;

/* ====================pagination code end========================= */
		

	if ($rs = mysqli_query($conn, $sql)) {
		$field_info = mysqli_fetch_fields($rs);

		while ($row = mysqli_fetch_assoc($rs)) {
			foreach ($field_info as $fi => $f)
				$data[$row['grievance_id']][$f->name] = $row[$f->name];
		}
	}

//echo"<pre>";print_r($data);echo"</pre>";die();
	
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

		if (!empty($dept_id)) {
			$filter_query .= '&dept_id=' . urlencode($dept_id);
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

		if (!empty($status)) {
			$filter_query .= '&status=' . urlencode($status);
		}
		
		//echo "<pre>";print_r($filter_query);echo "</pre>";die();

		$tpl->assign('filter_query', $filter_query);
		
	/************************************/
	
	//echo "<pre>";print_r($filter_query);echo "</pre>";die();

	$tpl->assign('filter_query', $filter_query);	
	$tpl->assign('pagination', $pagination);
	$tpl->assign('current_page', $page);
	$tpl->assign('total_pages', $total_pages);
	
/************************* pagination end  **************************/


	mysqli_close($conn);

	$tpl->assign('street_list', $street_list);

	$tpl->assign('update_previlize', $_SESSION['update_previlize']);

	$tpl->assign('hod_status2', $_SESSION['hod_status2']??'');

	$tpl->assign('hod_status', $_SESSION['hod_status']??'');

	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('users_list', $users_list);

	//$tpl->assign('status', $_REQUEST['status']);

	$tpl->assign('date', $date);

	$tpl->assign('reference_no', $reference_no);

	$tpl->assign('sla', $sla1);

	$tpl->assign('fdate', $f_date);

	$tpl->assign('tdate', $t_date);
	$tpl->assign('status', $status1);
	$tpl->assign('dept_id', $dept_id);

	//$tpl->assign('pagination', $pagination);

	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('ulbid', $_SESSION['ulbid']);

	$tpl->assign('app_type_id', $aptid1);

	$tpl->assign('cs_list', $cs_list);

	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('dept_list1', $dept_list1);

	$tpl->assign('ward_id', $ward_id);
	$tpl->assign('street_id', $street_id);
	$tpl->assign('ward_list', $ward_list);

	$tpl->assign('banner', $_SESSION['banner']);

	$tpl->assign('logo', $_SESSION['logo']);

	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('grievance_status_list', $grievance_status_list);

	$tpl->assign('services', $obj->services);

	$tpl->assign('uname', $_SESSION['user_name']);

	$tpl->assign('uid', $_SESSION['uid']);

	$tpl->display('corp_street_complaints.tpl');
} else {

	echo "<script>window.location='index.php';</script>";
}
