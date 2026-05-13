<?php
require "config.php";
ini_set('display_errors', 0);

require_once('Smarty.class.php');

$tpl = new Smarty();

if (isset($_SESSION['uid'])) {

	//session_regenerate_id();

	require_once('get_services.php');

	$obj = new get_services($_SESSION['uid']);

	require_once('connection.php');

	$conn = getconnection();

	$ward_id=$_SESSION['zone_id'];

	/// In case of service 

	$app_type_id = 1;

	if ($_REQUEST['originid'] !== '') {
		
		$sql = "select * from grievances where app_type_id = '1' and ulbid = '" . $_REQUEST['ulbid'] . "' ";

		if ($_REQUEST['originid'] == 0) {
			$sql .= " and grievance_origin_id in ('1','2','3','4','5','6','7','8')";
		} else if ($_REQUEST['originid'] == 3) {			
			$sql .= " and grievance_origin_id IN('3')";
		} else {

			$sql .= " and grievance_origin_id='" . $_REQUEST['originid'] . "'";
		}
	}

	if ($ward_id!='') {
		$sql .= " and ward_id=".$ward_id." ";
	}
	
	if ($_REQUEST['status'] == 100) {

		$sql .= " and grievance_status_id='1'";
	}

	if ($_REQUEST['status'] == 200) {
		$sql .= " and grievance_status_id in (2,11)";
	}

	if ($_REQUEST['status'] == 300) {

		$sql .= " and grievance_status_id in (3,6,8,9,12)";
	}
	if ($_REQUEST['status'] == 400) {

		$sql .= " and grievance_status_id in (1,2,3,6,8,9,11,12,13) ";
	}

/* ====================pagination code start========================= */	
	$page = !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	//echo $page;exit;
	$cat3_id = strip_tags($_REQUEST['cat3_id']);
	$grievance_status_id = strip_tags($_REQUEST['grievance_status_id']);
	
	$start = ($page - 1) * $limit;
	
	$pageNumber=$start+1;
	$tpl->assign('pageNumber', $pageNumber);
	$tpl->assign('cat3_id', $cat3_id);
	$tpl->assign('grievance_status_id', $grievance_status_id);
	

$pgrs=mysqli_query($conn,$sql);

$sql.=" LIMIT ".$start.", ".$limit." ";	

//echo "<pre>";print_r($sql);echo "</pre>";die();

$total_rows=$pgrs->num_rows;
/* ====================pagination code end========================= */	


	if ($rs = mysqli_query($conn, $sql)) {

		$field_info = mysqli_fetch_fields($rs);

		while ($row = mysqli_fetch_assoc($rs)) {

			if ($_REQUEST['originid'] !== '') {

				if ($row['target'] == "") {

					$row['target'] = 0;
				}

				if ($row['target'] <= $row['cutt_of_time']) {

					foreach ($field_info as $fi => $f)

						$data[$row['grievance_id']][$f->name] = $row[$f->name];
				}
			}
		}
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

//echo "<pre>";print_r($data);echo "</pre>";die();

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


	$sql = "select dept_id,dept_desc from dept_mst";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select cs_id,cs_desc as comp_desc from cs_mst";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$cs_list[$row['cs_id']] = $row['comp_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));


	if ($_REQUEST['originid'] == '0') {

		$originid = 1;
	} else {

		$originid = $_REQUEST['originid'];
	}

	$sql = "select * from grievance_origin_mst where grievance_origin_id='" . $originid . "'";

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {

		$origin_list[$row['grievance_origin_id']] = $row['grievance_origin_desc'];
	}



/************************* pagination start  **************************/

	$total_pages = ceil($total_rows / $limit);
		// Generate pagination data
	$pagination = [
		'current_page' => $page,
		'total_pages' => $total_pages,
		'range' => 3 // Number of visible pages before/after the current page
	];
	
	//echo "<pre>";print_r($filter_query);echo "</pre>";die();

	$tpl->assign('filter_query', $filter_query);	
	$tpl->assign('pagination', $pagination);
	$tpl->assign('current_page', $page);
	$tpl->assign('total_pages', $total_pages);
	
/************************* pagination end  **************************/

	$tpl->assign('origin_list', $origin_list);

	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('ulbid', $_SESSION['ulbid']);

	$tpl->assign('app_type_id', $app_type_id);

	$tpl->assign('cs_list', $cs_list);

	$tpl->assign('ward_list', $ward_list);

	$tpl->assign('origin_id', $_REQUEST['originid']);

	$tpl->assign('status', $_REQUEST['status']);

	$tpl->assign('ulb', $_REQUEST['ulbid']);

	$tpl->assign('banner', $_SESSION['banner']);

	$tpl->assign('logo', $_SESSION['logo']);

	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('grievance_status_list', $grievance_status_list);

	$tpl->assign('services', $obj->services);

	$tpl->assign('uname', $_SESSION['user_name']);

	$tpl->assign('uid', $_SESSION['uid']);

	$tpl->display('corp_Totalorigin.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}
