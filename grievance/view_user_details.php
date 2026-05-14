<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

$msg='';

if (isset($_SESSION['uid'])) {
	
	$user_id=strip_tags(trim($_POST['user_id']))??null;

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
		
//echo "<pre>";print_r($user_id);echo "</pre>";die();						
	$tpl->assign("token", $_SESSION['token']);
	//echo "<pre>";print_r($result['path']);echo "</pre>";die();
	
	$tpl->assign('msg', $msg);
	
	$ulbid   = strip_tags($_SESSION['ulbid']);
	//$user_id = intval($user_id);

	if(in_array($user_id,['nagpur','superadmin','admin','CDMA'])){
		$sql = "SELECT  u.user_id,
						u.emp_id,
						u.user_name,
						u.user_mobile,
						u.user_type,
						u.has_access						
				FROM users u 
				WHERE u.ulbid = ? 
				AND u.user_id = ?";
	}else{
		$sql = "SELECT  u.user_id,
						u.emp_id,
						u.user_name,
						u.user_mobile,
						u.user_type,
						u.has_access,
						e.emp_dept,
						e.emp_desg
				FROM users u
				LEFT JOIN emp_mst e ON u.emp_id = e.emp_id
				WHERE u.ulbid = ? 
				AND u.user_id = ?";
	}

//echo "<pre>";print_r($sql);echo "</pre>";die();	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ss", $ulbid, $user_id);  // s = string, i = integer

	$stmt->execute();

	$result = $stmt->get_result();
	$data = $result->fetch_assoc();		
	
	
	// user logs ************************************************************

	$stmt = $conn->prepare("SELECT * FROM user_logs WHERE user_id = ? ORDER BY login_time DESC");
	$stmt->bind_param("s", $user_id);
	$stmt->execute();

	$result = $stmt->get_result();
	
	$user_logs_list = [];

	while ($row = mysqli_fetch_assoc($result)) {

		$user_logs_list[$row['user_id']][] = [
			'login_time'  => $row['login_time'],
			'logout_time' => $row['logout_time'],
			'user_log_status' => $row['user_log_status'],
		];
	}
//echo "<pre>";print_r($user_logs_list);echo "</pre>";die();		
	// user logs end *********************************************************
		
	$user_services=new get_services($user_id);	

	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" .htmlspecialchars($_SESSION['ulbid']) . "' order by dept_id";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select desg_id,desg_desc from desg_mst where ulbid='" .htmlspecialchars($_SESSION['ulbid']) . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$desg_list[$row['desg_id']] = $row['desg_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	if(!in_array($user_id,['nagpur','superadmin','admin','CDMA']) && !empty($data['emp_id'])){
		//$sql = "select e.emp_id,e.dept_id,e.desg_id,d.dept_desc,ds.desg_desc from emp_desg_map e,dept_mst d, desg_mst ds where e.dept_id=d.dept_id and e.desg_id=ds.desg_id and emp_id=".$data['emp_id'];
		
		$sql = "SELECT 
					e.emp_id,
					e.dept_id,
					e.desg_id,
					d.dept_desc,
					ds.desg_desc
				FROM emp_desg_map e, dept_mst d ,  desg_mst ds     
				WHERE e.dept_id=d.dept_id and e.desg_id=ds.desg_id and e.delete_status=0 and e.emp_id  = ".$data['emp_id']." ";
		
		if ($rs = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($rs)){
				$desg_list2[$row['dept_id']]['dept_id'] = $row['dept_desc'];
				$desg_list2[$row['dept_id']]['desg_id'] = $row['desg_desc'];
			}
		} else
			printf("Errormessage: %s\n", mysqli_error($conn));
	}else{
		$desg_list2=array();
	}

//echo "<pre>";print_r($desg_list2);echo "</pre>";die();

	$sql = "SELECT * FROM `ulb_online_application_map` where ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "'";
	$rs = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($rs)) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}

	/** captcha generation ****/

	$code = rand(1000, 9999);

	$_SESSION['code'] = $code;


	/** close **/


	$sql="select street_id,street_desc from street_mst where ulbid=?";
	
	 $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	 $query1 = $conn->prepare($sql);
	 $query1->bind_param("s",$ulbid); 
	
	
	if($query1->execute())
	{
		$rs=$query1->get_result();
		while($row = $rs->fetch_assoc())
			$street_list[$row['street_id']]=$row['street_desc'];
	}
	
	
	$sql="select ward_id,ward_desc from ward_mst where ulbid=?";
	
	 $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	 $query1 = $conn->prepare($sql);
	 $query1->bind_param("s",$ulbid); 
	
	
	if($query1->execute())
	{
		$rs=$query1->get_result();
		while($row = $rs->fetch_assoc())
			$ward_list[$row['ward_id']]=$row['ward_desc'];
	}
	
	$sql="select dept_id,dept_desc from dept_mst where ulbid=?";
	$query1 = $conn->prepare($sql);
	$query1->bind_param("s",$ulbid); 
	
	if($query1->execute())
	{
		$rs=$query1->get_result();
		while($row = $rs->fetch_assoc())
			$dept_list[$row['dept_id']]=$row['dept_desc'];
	}
	$origin_list=array('1'=>'Telephone','2'=>'Counter');


	$sql = "select COUNT(id) as user_count from login_details where type='1' and ulbid like '%" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "%'";
	$rs = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);

	//	print_r($online_applications);

	$tpl->assign('online_applications', $online_applications);
	
	//print_r($ids);
	mysqli_close($conn);

	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('data', $data);

	$tpl->assign('desg_list2', $desg_list2);
	$tpl->assign('user_logs_list', $user_logs_list);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('desg_list', $desg_list);
	$tpl->assign('street_list', $street_list);
	$tpl->assign('user_services', $user_services->services1);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('code', $code);
	
	//var_dump($_POST['uid']);die();
	
	if(in_array($user_id,['nagpur','superadmin','admin','CDMA'])){
		$tpl->display('view_admin_details.tpl');
	}else{
		$tpl->display('view_user_details.tpl');	
	}
	
} else {
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


function uploadFile($docfiles,$key) {
	
   // $maxsize = 5000000;	
   $result['msg']='';
   $result['path']='';
	$allowedFormats = ['jpg', 'jpeg', 'png', 'gif','pdf'];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

	$fileName = $docfiles['name'][$key];
	$fileType = $docfiles['type'][$key];
	$fileTmpName = $docfiles['tmp_name'][$key];
	$fileSize = $docfiles['size'][$key];
	$fileError = $docfiles['error'][$key];
	$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		 
	$fileMimeType = mime_content_type($fileTmpName);

	if (!in_array($fileExt, $allowedFormats)) {
		 $result['msg']=  "Invalid file format. Allowed: JPG, PNG, GIF.";
	}

	if (!in_array($fileMimeType, $allowedMimeTypes)) {
		 $result['msg']=  "Invalid file type detected! Possible security risk.";
	}

	// Validate file size (max 2MB)
	$maxSize = 2 * 1024 * 1024; // 2MB in bytes
	if ($fileSize > $maxSize) {
		 $result['msg']=  "File size exceeds 2MB.";
	}

	// Handle upload errors
	if ($fileError !== 0) {
		 $result['msg']=  "Error uploading file. Code: " . $fileError;
	}
	
	$uploadDir = "field_visitor_docs/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
		
	$newfile =time().$_SESSION['ulbid'].".".$fileExt;
    $fileDestination = $uploadDir . $newfile;
	
	$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
	$base_url = $scheme . "://" . $_SERVER['HTTP_HOST'] ;

//echo "<pre>";print_r($base_url);echo "</pre>";die();
    // Move file to server
    if (move_uploaded_file($fileTmpName, $fileDestination)) {
		$result['path']= $base_url.'/'.htmlspecialchars($fileDestination);
        $result['msg']= "File uploaded successfully: " ;
        $result['mime_type']= $fileType;
    } else {
         $result['msg']=  "Failed to move uploaded file.";
    }

return  $result;
}








?>