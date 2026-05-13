<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {


	//session_regenerate_id();
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


	$emplist = join("','", $_SESSION['emp_list']);





	if ($_SESSION['user_type'] == 'A') {
		$sql = "select DISTINCT g.grievance_id,person_name,email,hno,address,ward_id,street_id,g.mobile,comp_subject,comp_desc,grievance_origin_id,
		  grievance_status_id,date_regd,cat3_id,file_no,app_type_id,mcat3_id,gt.dept_id,g.grievance_at_emp_level from grievances_transactions,emp_mst where grievances_transactions.emp_id=emp_mst.emp_id and 
			 disposal_status ='2' and app_type_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "%' and g.grievance_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ref_no'])) . "%' and 
			 g.person_name like '%" . trim(mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['applicant_name']))) . "%' and g.mobile like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])) . "%' and 
			 ward_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id'])) . "%' and gt.dept_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id'])) . "%' and 
			 g.cat3_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cat3_id'])) . "%' order by grievance_id desc";

		$sql2 = "select DISTINCT g.grievance_id,person_name,email,hno,address,ward_id,street_id,g.mobile,comp_subject,comp_desc,grievance_origin_id,
		  grievance_status_id,date_regd,cat3_id,file_no,app_type_id,mcat3_id,gt.dept_id,g.grievance_at_emp_level from grievances_transactions,emp_mst_od where grievances_transactions.emp_id=emp_mst.emp_id and 
			 disposal_status ='2' and app_type_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "%' and g.grievance_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ref_no'])) . "%' and 
			 g.person_name like '%" . trim(mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['applicant_name']))) . "%' and g.mobile like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])) . "%' and 
			 ward_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id'])) . "%' and gt.dept_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id'])) . "%' and 
			 g.cat3_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cat3_id'])) . "%' order by grievance_id desc";
	} else if ($_SESSION['user_type'] == 'U') {
		//$sql="select g.grievance_id,emp_dept,g.app_type_id from grievances_transactions gt,emp_mst e,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and gt.disposal_status ='2' and g.ulbid='".$_SESSION['ulbid']."' order by g.grievance_id desc";

		if ($_SESSION['mc_yn'] == 1) {
			$sql = "select DISTINCT g.grievance_id,person_name,email,hno,address,ward_id,street_id,g.mobile,comp_subject,comp_desc,grievance_origin_id,
		  grievance_status_id,date_regd,cat3_id,file_no,app_type_id,mcat3_id,gt.dept_id,g.grievance_at_emp_level from grievances_transactions gt,emp_mst e,grievances g where 
			 g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and gt.disposal_status IN('2','11','6','13') and g.ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and 
			 app_type_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "%' and g.grievance_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ref_no'])) . "%' and 
			 g.person_name like '%" . trim(mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['applicant_name']))) . "%' and g.mobile like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])) . "%' and 
			 ward_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id'])) . "%' and gt.dept_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id'])) . "%' and g
			 .cat3_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cat3_id'])) . "%' order by g.grievance_id desc";

			$sql2 = "select DISTINCT g.grievance_id,person_name,email,hno,address,ward_id,street_id,g.mobile,comp_subject,comp_desc,grievance_origin_id,
		  grievance_status_id,date_regd,cat3_id,file_no,app_type_id,mcat3_id,gt.dept_id,g.grievance_at_emp_level from grievances_transactions gt,emp_mst_od e,grievances g where 
			 g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and gt.disposal_status IN('2','11','6','13') and g.ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and 
			 app_type_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "%' and g.grievance_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ref_no'])) . "%' and 
			 g.person_name like '%" . trim(mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['applicant_name']))) . "%' and g.mobile like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])) . "%' and 
			 ward_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id'])) . "%' and gt.dept_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id'])) . "%' and g
			 .cat3_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cat3_id'])) . "%' order by g.grievance_id desc";
		} else {


			$sql = "select DISTINCT g.grievance_id,person_name,email,hno,address,ward_id,street_id,g.mobile,comp_subject,comp_desc,grievance_origin_id,
		  grievance_status_id,date_regd,cat3_id,file_no,app_type_id,mcat3_id,gt.dept_id,g.grievance_at_emp_level from grievances_transactions gt,emp_mst e,grievances g where 
			 g.grievance_id=gt.grievance_id 
			 and gt.emp_id=e.emp_id 
			 and gt.disposal_status IN('2','11','6') and g.ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and 
			 app_type_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "%' and g.grievance_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ref_no'])) . "%' and 
			 g.person_name like '%" . trim(mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['applicant_name']))) . "%' and g.mobile like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])) . "%' and 
			 ward_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id'])) . "%' and gt.dept_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id'])) . "%' and g
			 .cat3_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cat3_id'])) . "%' order by g.grievance_id desc";

			$sql2 = "select DISTINCT g.grievance_id,person_name,email,hno,address,ward_id,street_id,g.mobile,comp_subject,comp_desc,grievance_origin_id,
		  grievance_status_id,date_regd,cat3_id,file_no,app_type_id,mcat3_id,gt.dept_id,g.grievance_at_emp_level from grievances_transactions gt,emp_mst_od e,grievances g where 
			 g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and gt.disposal_status IN('2','11','6') and g.ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' and 
			 app_type_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "%' and g.grievance_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ref_no'])) . "%' and 
			 g.person_name like '%" . trim(mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['applicant_name']))) . "%' and g.mobile like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])) . "%' and 
			 ward_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id'])) . "%' and gt.dept_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id'])) . "%' and g
			 .cat3_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cat3_id'])) . "%' order by g.grievance_id desc";
		
		//echo "<pre>";print_r($sql);echo "</pre>";die();
		
		}
	} else if ($_SESSION['user_type'] == 'E') {

		//$sql="select g.grievance_id,emp_dept,g.app_type_id from grievances_transactions gt,emp_mst e,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and gt.disposal_status ='2' and g.ulbid='".$_SESSION['ulbid']."' and gt.emp_id='".$_SESSION['emp_id']."' order by g.grievance_id desc";

		$sql = "select DISTINCT g.grievance_id,person_name,email,hno,address,ward_id,street_id,g.mobile,comp_subject,comp_desc,grievance_origin_id,
		  grievance_status_id,date_regd,cat3_id,file_no,app_type_id,mcat3_id,gt.dept_id,g.grievance_at_emp_level from grievances_transactions gt,emp_mst e,grievances g where 
			 g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and gt.disposal_status IN('2','11','6') and g.ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' 
			 and gt.emp_id IN('" . $emplist . "') and app_type_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "%' and 
			 g.grievance_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ref_no'])) . "%' and g.person_name like '%" . trim(mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['applicant_name']))) . "%' and 
			 g.mobile like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])) . "%' and ward_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id'])) . "%' and 
			 gt.dept_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id'])) . "%' and g.cat3_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cat3_id'])) . "%' order by g.grievance_id desc";
		//echo $sql;

		$sql2 = "select DISTINCT g.grievance_id,person_name,email,hno,address,ward_id,street_id,g.mobile,comp_subject,comp_desc,grievance_origin_id,
		  grievance_status_id,date_regd,cat3_id,file_no,app_type_id,mcat3_id,gt.dept_id,g.grievance_at_emp_level from grievances_transactions gt,emp_mst_od e,grievances g where 
			 g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and gt.disposal_status IN('2','11','6') and g.ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' 
			 and gt.emp_id IN('" . $emplist . "') and app_type_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "%' and 
			 g.grievance_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ref_no'])) . "%' and g.person_name like '%" . trim(mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['applicant_name']))) . "%' and 
			 g.mobile like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile'])) . "%' and ward_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id'])) . "%' and 
			 gt.dept_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id'])) . "%' and g.cat3_id like '%" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cat3_id'])) . "%' order by g.grievance_id desc";
	}

	//echo $sql;
	if ($rs = mysqli_query($conn, $sql)) {
		$field_info = mysqli_fetch_fields($rs);
		while ($row = mysqli_fetch_assoc($rs)) {
			foreach ($field_info as $fi => $f)
				$data[$row['grievance_id']][$f->name] = $row[$f->name];
		}
	}
	if ($rs = mysqli_query($conn, $sql2)) {
		$field_info = mysqli_fetch_fields($rs);
		while ($row = mysqli_fetch_assoc($rs)) {
			foreach ($field_info as $fi => $f)
				$data[$row['grievance_id']][$f->name] = $row[$f->name];
		}
	}


	$sql = "select ward_id,ward_desc from ward_mst where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "'";

	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$ward_list[$row['ward_id']] = $row['ward_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "select dept_id,dept_desc from dept_mst where ulbid=" . mysqli_real_escape_string($conn, $_SESSION['ulbid']);

	if ($_SESSION['user_type'] == 'E') {
		$sql = "select dept_id,dept_desc from  emp_mst e,dept_mst dm  where e.emp_dept=dm.dept_id and e.emp_id='" . mysqli_real_escape_string($conn, $_SESSION['emp_id']) . "'";
	}




	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	if ($_SESSION['user_type'] == 'E') {
		$sql = "select dept_id,dept_desc from dept_mst dm, emp_mst_od e  where e.emp_dept=dm.dept_id and e.emp_id='" . mysqli_real_escape_string($conn, $_SESSION['emp_id']) . "'";
	}




	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));



	if ($_POST['app_type_id'] == '1') {
		$sql = "select cs_id,cs_desc as comp_desc,m.description from cs_mst cm,grievances g,category_mst m where
        		    g.cat3_id=cm.cs_id and cm.cat_id=m.cat_id and g.app_type_id='" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "' and 
        		    g.ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' group by g.cat3_id";
	} else {
		$sql = "select cs_id,cm.comp_desc from category3_mst cm,grievances g where g.cat3_id=cm.cs_id and 
        		    g.app_type_id='" . mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['app_type_id'])) . "' and g.ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "' group by g.cat3_id";
	}
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs)) {
			if ($row['description'] != '') {
				$string = "(" . $row['description'] . ")";
			} else {
				$string = $row['description'] = '';
			}
			$list[$row['cs_id']] = $row['comp_desc'] . $string;
		}
	}



	$sql = "select grievance_origin_id,grievance_origin_desc from grievance_origin_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$grievance_origin_list[$row['grievance_origin_id']] = $row['grievance_origin_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "select grievance_status_id,grievance_status_desc from grievance_status_mst";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$grievance_status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));




	$sql = "select * from standard_services";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$cat3_list[$row['cs_id']] = $row['cs_desc'];
	}

	$sql = "SELECT cat_id,description FROM  `category_mst` ";
		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {
			$cat_list[$row['cat_id']] = $row['description'];
		}

		$sql = "select c.cs_id,cs_desc,cam.cat_id,description from complaint_ulbmap c,cs_mst cm,category_mst cam where cam.cat_id=cm.cat_id and c.cs_id=cm.cs_id and c.ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "' and flag='1' order by cs_id";
		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {
			$cs_list[$row['description']][$row['cs_id']] = $row['cs_desc'] . " (" . $cat_list[$row['cat_id']] . ")";
			$cs_data[$row['cs_id']] = $cat_list[$row['cat_id']];
		}
	$tpl->assign('cs_data', $cs_data);
	$tpl->assign('cat_list', $cat_list);

//echo"<pre>";print_r($cs_data);echo"<pre>";die();

	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . mysqli_real_escape_string($conn, $_SESSION['ulbid']) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}


	$sql = "select COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . $_SESSION['ulbid'] . "%'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);

	//	print_r($online_applications);

	$tpl->assign('online_applications', $online_applications);

	//mysqli_free_result($rs);

	//print_r($ward_list);


	$tpl->assign('grievance_status_list', $grievance_status_list);
	$tpl->assign('app_type_id', $_POST['app_type_id']);
	$tpl->assign('ref_no', $_POST['ref_no']);
	$tpl->assign('applicant_name', $_POST['applicant_name']);
	$tpl->assign('mobile', $_POST['mobile']);
	$tpl->assign('ward_id', $_POST['ward_id']);
	$tpl->assign('dept_id', $_POST['dept_id']);
	$tpl->assign('list', $list);
	$tpl->assign('cat3_id', $_POST['cat3_id']);



	mysqli_close($conn);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('app_type_list', array('1' => 'Complaints', '2' => 'Services'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('cs_list', $cs_list);
	$tpl->assign('cat3_list', $cat3_list);
	$tpl->assign('data', $data);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('grievance_origin_list', $grievance_origin_list);

	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('uid', $_SESSION['uid']);
	$flash = get_flash();		
	$tpl->assign("flash", $flash); 	
	$tpl->display('manage_comp.tpl');
} else {
	

	echo "<script>window.location='index.php';</script>";
}
?>