<?php

require "config.php";

ini_set('display_errors', 0);

require_once('Smarty.class.php');

$tpl = new Smarty();

$emplist = join("','", $_SESSION['emp_list']);

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

	$cat3_id = $_REQUEST['cat3_id'];
	$ward_id = $_REQUEST['ward_id'];
	
//echo "<pre>";print_r($_REQUEST);echo "</pre>";die();

	$aptid1 = $_REQUEST['aptid'];

	$reference_no = $_REQUEST['reference_no'];

	$status1 = $_REQUEST['status'];

	$ulbid1 = $_SESSION['ulbid'];

	$user_type1 = $_SESSION['user_type'];

	$sla1 = $_REQUEST['sla'];

	if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

		$fdate = date('Y-m-d', strtotime($_POST['f_date']));

		$tdate = date('Y-m-d', strtotime($_POST['t_date']));

		$query .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";
	}

if($ward_id!=-1){
	$sql = "SELECT g.*,gt.file_url as updated_image,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed FROM grievances g,
	grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.cat3_id=ccm.cs_id and app_type_id='1' and gt.is_escalated=1 and g.cat3_id='" . $cat3_id . "' and g.ward_id='" . $ward_id . "' ";
}else{
	$sql = "SELECT g.*,gt.file_url as updated_image,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added AS no_of_days_exeed FROM grievances g,
	grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.cat3_id=ccm.cs_id and app_type_id='1' and gt.is_escalated=1 and g.cat3_id='" . $cat3_id . "' ";
}
	/*$sql = "SELECT g.*,gt.file_url as updated_image, gt.disposed_date, gt.dept_id, gt.emp_id, DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed, DATE_ADD(date_regd, INTERVAL ss.cutt_off_time DAY) as comp_date  FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and
	app_type_id='1' and g.mcat3_id=ss.cs_id and gt.emp_id IN('" . $emplist . "') and gt.is_escalated='1'";*/


	/*23-04-24 $sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,g.eoffice_no as EofficeNo, person_name as PersonName, g.mobile as Mobile,g.address as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,date_regd as ComplaintRegisteredDate,disposed_date as ComplaintResolvedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as ComplaintToBeResolvedDate
	,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS NumberOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g, grievances_transactions gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and app_type_id='1' 
	and is_escalated=1 and gt.emp_id IN('" . $emplist . "') ";*/

	$sqlExcel = "SELECT c.cs_desc as CategoryName,g.grievance_id as RefrenceNo,w.ward_desc as ZoneName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,grievance_status_desc as Status ,date_regd as ReceivedDate,date_regd as ComplaintRegisteredDate,disposed_date as ComplaintResolvedDate, ccm.cutt_off_time+holidays_added as DisposableDays,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as ComplaintToBeResolvedDate
	,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS NumberOfdaysExceeded,emp_name as EmployeeName, emp_mobile as EmployeeMobile FROM grievances g, grievances_transactions gt,comp_cutofdays_map ccm,cs_mst c,grievance_status_mst gsm, emp_mst e,ward_mst w where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.ulbid='" . $_SESSION['ulbid'] . "' and g.cat3_id=ccm.cs_id and app_type_id='1' 
	and is_escalated=1 ";

	/*$sqlExcel = "SELECT c.cs_desc as CategoryName, g.grievance_id as ReferenceNo,w.ward_desc as ZoneName,s.street_desc as WardName, person_name as ApplicantName, g.mobile as Mobile,CONCAT(g.hno, ', ', g.address) as Address,c.cs_desc as ComplaintDetails,gsm.grievance_status_desc as Status ,date_regd as ReceivedDate from grievances g,ulbmst u ,cs_mst c, grievances_transactions gt,grievance_status_mst gsm,ward_mst w,street_mst s where g.grievance_id=gt.grievance_id 
	and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.app_type_id='1' and gt.emp_id IN('" . $emplist . "') and g.ward_id=w.ward_id and g.street_id=s.street_id and gt.disposal_status !=5 and cat3_id !='0' ";*/

	/*23-04-24 if (isset($_POST['search'])) {

		if ($_POST['reference_no'] != '') {

			$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

			$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}

		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') 
		{
			$f_date = date('Y-m-d', strtotime($_POST['f_date']));
			
			$t_date = date('Y-m-d', strtotime($_POST['t_date']));

			$sql .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' ";

			$sqlExcel .= " and date(date_regd) between '" . $f_date . "' and '" . $t_date . "' order by date_regd DESC";
		}
	}
	$sql .= " order by date_regd DESC";*/

	if (isset($_POST['search'])) {

		if ($_POST['reference_no'] != '') {

			$sql .= " and g.grievance_id='" . $_POST['reference_no'] . "'";

			$sqlExcel .= " and g.grievance_id='" . $_POST['reference_no'] . "'";
		}

		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {

			$sql .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "'";

			$sqlExcel .= " and date(date_regd) between '" . $fdate . "' and '" . $tdate . "' order by date_regd DESC";
		}
	}
	$sql .= " group by g.grievance_id order by g.grievance_id DESC";
	$sqlExcel .= ' group by g.grievance_id order by date_regd DESC';


	$query = "SELECT count(DISTINCT g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt, comp_cutofdays_map ccm, standard_services ss where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.mcat3_id=ccm.cs_id and g.cat3_id=c.cs_id and
	app_type_id='1' and g.mcat3_id=ss.cs_id and gt.emp_id IN('" . $emplist . "') and gt.is_escalated='1' ";


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

	//echo $sql;


	////////////////////pagination



	//$tbl_name="nalgonda_survey";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 5;



	/* 

	First get total number of rows in data table. 

	If you have a WHERE clause in your query, make sure you mirror it here.

	*/



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

	//echo $total_pages;

	/* Setup vars for query. */

	/*23-04-24 $targetpage = "tot_received.php"; 	//your file name  (the name of this file)

	$limit = 50; 								//how many items to show per page

	$page = $_GET['page'];

	if ($page)

		$start = ($page - 1) * $limit; 			//first item to display on this page

	else

		$start = 0;		*/						//if no page var is given, set start to 0



	/* Get data. */

	/*23-04-24 if ($f_date == '' || $t_date == '') {

		$sql .= " LIMIT $start, $limit";
	}*/

	// echo $sql;



	//$sql. = "SELECT * FROM $tbl_name order by submission_date desc LIMIT $start, $limit";

	//$rs = mysql_query($sql);



	/* Setup page vars for display. */



	/*23-04-24 if ($page == 0) $page = 1;					//if no page var is given, default to 1.

	$prev = $page - 1;							//previous page is page - 1

	$next = $page + 1;							//next page is page + 1

	$lastpage = ceil($total_pages / $limit);		//lastpage is = total pages / items per page, rounded up.

	$lpm1 = $lastpage - 1;	*/					//last page minus 1



	/* 

			Now we apply our rules and draw the pagination object. 

			We're actually saving the code to a variable in case we want to draw it more than once.

		*/

	//echo $lastpage;

	/*23-04-24 $pagination = "";

	if ($lastpage > 1) {

		$pagination .= "<div class=\"pagination\">";

		//previous button

		if ($page > 1)

			$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$prev\"><< previous</a>";

		else

			$pagination .= "<span class=\"disabled\"><< previous</span>";



		//pages	

		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up

		{

			for ($counter = 1; $counter <= $lastpage; $counter++) {

				if ($counter == $page)

					$pagination .= "<span class=\"current\">$counter</span>";

				else

					$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$counter\">$counter</a>";
			}
		} elseif ($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some

		{

			//close to beginning; only hide later pages

			if ($page < 1 + ($adjacents * 2)) {

				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {

					if ($counter == $page)

						$pagination .= "<span class=\"current\">$counter</span>";

					else

						$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$counter\">$counter</a>";
				}

				$pagination .= "...";

				$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$lpm1\">$lpm1</a>";

				$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$lastpage\">$lastpage</a>";
			}

			//in middle; hide some front and some back

			elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

				$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=1\">1</a>";

				$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=2\">2</a>";

				$pagination .= "...";

				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {

					if ($counter == $page)

						$pagination .= "<span class=\"current\">$counter</span>";

					else

						$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$counter\">$counter</a>";
				}

				$pagination .= "...";

				$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$lpm1\">$lpm1</a>";

				$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$lastpage\">$lastpage</a>";
			}

			//close to end; only hide early pages

			else {

				$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=1\">1</a>";

				$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=2\">2</a>";

				$pagination .= "...";

				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {

					if ($counter == $page)

						$pagination .= "<span class=\"current\">$counter</span>";

					else

						$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$counter\">$counter</a>";
				}
			}
		}



		//next button

		if ($page < $counter - 1)

			$pagination .= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$next\">next >></a>";

		else

			$pagination .= "<span class=\"disabled\">next >></span>";

		$pagination .= "</div>\n";
	}*/

	//////////////// pagination end



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

	mysqli_close($conn);
	//$_SESSION['update_previlize']

	$tpl->assign('street_list', $street_list);

	$tpl->assign('update_previlize', $_SESSION['update_previlize']);

	$tpl->assign('hod_status2', $_SESSION['hod_status2']);

	$tpl->assign('hod_status', $_SESSION['hod_status']);

	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('users_list', $users_list);

	$tpl->assign('status', $_REQUEST['status']);

	$tpl->assign('reference_no', $_REQUEST['reference_no']);

	$tpl->assign('sla', $_REQUEST['sla']);

	$tpl->assign('fdate', $fdate);

	$tpl->assign('tdate', $tdate);

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

	$tpl->display('tot_escalations_received.tpl');
} 
else 
{
	/*$msg="You have not logged in, Please Login";

	$tpl->assign('msg',$msg);

	$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
