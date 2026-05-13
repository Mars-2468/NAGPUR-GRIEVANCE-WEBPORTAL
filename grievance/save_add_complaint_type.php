<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);

require_once('Smarty.class.php');
require_once('csrf.class.php');
$csrf = new csrf();

$tpl = new Smarty();


$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);


if (isset($_SESSION['uid'])) {

	//session_regenerate_id();

	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	include('user_defined_functions.php');
	include('prepare_connection.php');


	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);


	$captcha =$_SESSION['code'];
	

	if (isset($_POST['save'])) {
		
		if(!validateField($_POST['code'], 'text')['valid'] || !validateField($_POST['cs_desc'], 'text')['valid'] || !validateField($_POST['telugu_description'], 'text')['valid'] || !validateField($_POST['level_1'], 'text')['valid'] || !validateField($_POST['level_2'], 'text')['valid'] || !validateField($_POST['level_3'], 'text')['valid']){
						
			$msg  = "Enter Valid complaint description or level1/level2/level3..!";
			$class = "alert alert-danger display-hide";
			set_flash($msg,$class);
			header('Location:add_complaint_type.php');
			exit;
		}else{
		
			$code =$_POST['code'];
			$catId = $_POST['cat_id'];
			$subCatId = $_POST['sub_cat_id'];
			$complaintType = $_POST['cs_desc']; //preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cs_desc']);
			$complaintTypeMarathi =  $_POST['telugu_description']; //$_POST['telugu_description'];
			$cs_type_id = 1;
			$swatchta_app_status_yn = 0;
			$swapp_cat_id = 0;
			$comp_cat = 0;
			$is_mepma = 0;
			$level1 = $_POST['level_1'];
			$level2 = $_POST['level_2'];
			$level3 = $_POST['level_3'];
			$ts = date("Y-m-d h:i:s");
			
			
			// print_r($_POST);exit();
			$sql = "insert into cs_mst(cat_id,sub_cat_id,cs_desc,telugu_description,cs_type_id,swatchta_app_status_yn,swapp_cat_id,comp_cat,is_mepma) values(?,?,?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("iisssssis", $catId, $subCatId, $complaintType, $complaintTypeMarathi, $cs_type_id, $swatchta_app_status_yn, $swapp_cat_id, $comp_cat, $is_mepma);
			$rs = $stmt->execute();
			$cs_id = $conn->insert_id;


			$queryOfCompCutOfDaysMap = "insert into comp_cutofdays_map(cs_id,cutt_off_time) values(?,?)";
			$stmtOfCompCutOfDaysMap = $conn->prepare($queryOfCompCutOfDaysMap);
			$stmtOfCompCutOfDaysMap->bind_param("ss", $cs_id, $level1);
			$resultOfCompCutOfDaysMap = $stmtOfCompCutOfDaysMap->execute();

			$queryOfLevelDisposabledaysMap = "insert into level_disposabledays_map(cs_id,L1,L2,L3) values(?,?,?,?)";
			$stmtOfLevelDisposabledaysMap = $conn->prepare($queryOfLevelDisposabledaysMap);
			$stmtOfLevelDisposabledaysMap->bind_param("ssss", $cs_id, $level1, $level2, $level3);
			$resultOfstmtOfLevelDisposabledaysMap = $stmtOfLevelDisposabledaysMap->execute();
			$fine_per_day = 0;
			$is_external_service = 0;

			$sql = "insert into standard_services(
				section_id,
				cs_desc,
				cs_id,
				cutt_off_time,
				fine_per_day,
				telugu_description,
				is_external_service
				)values(
				?,
				?,
				?,
				?,
				?,
				?,
				?
				)";

			$stmt = $conn->prepare($sql);
			$stmt->bind_param("isissss", $catId, $complaintType, $cs_id, $level1, $fine_per_day, $complaintTypeMarathi, $is_external_service);
			$rs = $stmt->execute();
			if($rs){
				$msg  = "Record successfully stored..!";
				$class = "alert alert-success display-hide";
			}
		}
	}
	set_flash($msg,$class);
	header('Location:add_complaint_type.php');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}


function sanitize_input($data) {

	//PHP
    // Remove unnecessary spaces
    $data = trim($data,"-+=\'\"");

    // Strip tags to prevent HTML and PHP code injection
    $data = strip_tags($data);

    // Convert special characters to HTML entities (e.g., < to &lt;)
    $data = htmlspecialchars($data);	

	$data = preg_replace('/[^a-zA-Z0-9_@()-]/', '', $data);	
		
    return $data;
}
