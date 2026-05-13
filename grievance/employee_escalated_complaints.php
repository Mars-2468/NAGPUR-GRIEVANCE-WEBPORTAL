<?php
require "config.php";

ini_set('display_errors', 0);

require_once('Smarty.class.php');

$tpl = new Smarty();

$emplist = join("','", $_SESSION['emp_list']);
$selectedYear = !empty($_SESSION['filteryear'])?$_SESSION['filteryear']:'';
$selectedDesg = !empty($_SESSION['filterdesg'])?$_SESSION['filterdesg']:'';
$selectedDept = !empty($_SESSION['employee_dept'])?$_SESSION['employee_dept']:'';
$selectedDesgnation = !empty($_SESSION['employee_desg'])?$_SESSION['employee_desg']:'';

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

	$department_id = $_REQUEST['department_id'];

	$aptid1 = $_REQUEST['aptid'];

	$reference_no = $_REQUEST['reference_no'];

	$status1 = $_REQUEST['status'];

	$ulbid1 = $_SESSION['ulbid'];
	
	$gstatus=$_POST['status_id'];
		
		if(!strcmp($gstatus,"Resolved")){
			$grievance_status='3,6,8,9,12';			
		}else if(!strcmp($gstatus,"Pending")){
			$grievance_status='2,5,10,11,13';
		}else{
			$grievance_status='2,3,5,6,8,9,10,11,12,13';
		}	
		

	$user_type1 = $_SESSION['user_type'];

	$sla1 = $_REQUEST['sla'];

	if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

		$fdate = date('Y-m-d', strtotime($_POST['f_date']));

		$tdate = date('Y-m-d', strtotime($_POST['t_date']));

		$query .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
	}


	$sql = "SELECT g.*,gt.file_url as updated_image,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed FROM grievances g,
	".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.cat3_id=ccm.cs_id and app_type_id='1' and gt.is_escalated=1 and gt.emp_id IN('" . $emplist . "')";

	if ($selectedDept) { 
		$sql .=" and gt.dept_id = '".$selectedDept."' ";
	}

	$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,w.ward_desc as ZoneName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,date_regd as ComplaintRegisteredDate,disposed_date as ComplaintResolvedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as ComplaintToBeResolvedDate
	,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS NumberOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g, ".$_SESSION['grievances_trns']." gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e,ward_mst w where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and app_type_id='1' 
	and is_escalated=1 and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id ";


	if (isset($_POST['search'])) {

		if ($_POST['reference_no'] != '') {

			$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

			$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}

		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
			
			$sql .= " and g.grievance_status_id IN(".$grievance_status.") ";

			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";

			$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
		}
		if ($_POST['department_id'] != '') {

			$sql .= " and gt.dept_id='".$_POST['department_id']."' and g.grievance_status_id IN(".$grievance_status.") ";

			$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
		}
	}
	
	
	
	$sql .= " group by g.grievance_id order by g.grievance_id DESC";
	$sqlExcel .= ' group by g.grievance_id order by date_regd DESC';


	$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,".$_SESSION['grievances_trns']." gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and
	app_type_id='1' and g.mcat3_id=ss.cs_id and gt.emp_id IN('" . $emplist . "') and gt.is_escalated='1' ";

	if ($selectedDept) { 
		$query .=" and gt.dept_id = '".$selectedDept."' ";
	}

	if (isset($_POST['search'])) {

		if ($_POST['reference_no'] != '') {

			$query .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}

		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

			$query .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
		}
	}
	$query .= " order by date_regd DESC";

	$_SESSION['myquery'] = $sqlExcel;


	$adjacents = 5;

	//echo $query;

	if ($f_date == '' || $t_date == '') 
	{

		$result = mysqli_query($conn, $query);

		//$total_pages = mysql_fetch_array($result);

		while ($row = mysqli_fetch_assoc($result)) 
		{

			$total_pages = $row['num'];

			//echo $row['num'];

		}
	}

	


	//echo $sql;

	if ($rs = mysqli_query($conn, $sql)) {
		$field_info = mysqli_fetch_fields($rs);

		while ($row = mysqli_fetch_assoc($rs)) {
			foreach ($field_info as $fi => $f)

				$data[$row['grievance_id']][$f->name] = $row[$f->name];
		}
	}

	$tpl->assign('data', $data);

	$sql = "select ward_id,ward_desc from ward_mst";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$ward_list[$row['ward_id']] = $row['ward_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));



	$sql = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$grievance_status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));


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

	//print_r($dept_list);

	//	echo $row['dept_id'];

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
		
	$sql=$conn->prepare("select dept_id,dept_desc from dept_mst where ulbid=?");
		
	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("s",$ulbid);
	
	$sql->execute();
	$rs=$sql->get_result();
	$dept_lists[0]='Select';
	while($row = $rs->fetch_assoc())
	{
		$dept_lists[$row['dept_id']]=$row['dept_desc'];
	}	
	
	$status_list=[
		''=>'Select status',
		'Resolved'=>'Resolved',
		'Pending'=>'Pending',
	];

	mysqli_close($conn);
	//$_SESSION['update_previlize']

	$tpl->assign('street_list', $street_list);
	$tpl->assign('status_list', $status_list);

	$tpl->assign('update_previlize', $_SESSION['update_previlize']);

	$tpl->assign('hod_status2', $_SESSION['hod_status2']);

	$tpl->assign('hod_status', $_SESSION['hod_status']);

	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('users_list', $users_list);

	$tpl->assign('status', $_REQUEST['status']);
	$tpl->assign('department_id',$department_id);
	$tpl->assign('gstatus',$gstatus);
	$tpl->assign('reference_no', $_REQUEST['reference_no']);

	$tpl->assign('sla', $_REQUEST['sla']);

	$tpl->assign('fdate', $fdate);

	$tpl->assign('tdate', $tdate);

	$tpl->assign('pagination', $pagination);

	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('ulbid', $_SESSION['ulbid']);

	$tpl->assign('app_type_id', $_REQUEST['aptid']);

	$tpl->assign('cs_list', $cs_list);

	$tpl->assign('dept_lists', $dept_lists);

	$tpl->assign('dept_list1', $dept_list1);

	$tpl->assign('ward_list', $ward_list);

	$tpl->assign('banner', $_SESSION['banner']);

	$tpl->assign('logo', $_SESSION['logo']);

	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('grievance_status_list', $grievance_status_list);

	$tpl->assign('services', $obj->services);

	$tpl->assign('uname', $_SESSION['user_name']);

	$tpl->assign('uid', $_SESSION['uid']);

	$tpl->display('employee_escalated_complaints.tpl');
} 
else 
{
	echo "<script>window.location='index.php';</script>";
}
