<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

$msg='';
$id=!empty($_POST['id'])?$_POST['id']:'';

//var_dump($id);die();

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

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
	
		
//echo "<pre>";print_r($_POST);echo "</pre>";die();

	if (isset($_POST['save']) && ($_POST['token'] === $_SESSION['token'])) {


		if(!validateField($_POST['remarks'], 'sptext')){
			if(!empty($_POST['doctitle']))
			foreach($_POST['doctitle'] as $docTitle){
				if( !validateField($doctTitle, 'text')){
					$msg  = "Enter valid doctitle!";
					$class = "alert alert-danger display-hide";
					set_flash($msg,$class);
					header('Location: inspection.php');
					exit;
				}
			}
			
			$msg  = "Enter valid remarks..!";
			$class = "alert alert-danger display-hide";
			set_flash($msg,$class);
			header('Location: inspection.php');
			exit;
		}else{

		$dept_id = $_POST['dept_id'];
		$desg_id = $_POST['desg_id'];
		$ward_id = $_POST['ward_id'];
		$street_id = $_POST['street_id'];
		$lat = $_POST['lat'];
		$lang = $_POST['lang'];
		$field_verification_reason = $_POST['field_verification_reason'];
		$field_verification_address = $_POST['field_verification_address'];
		$remarks = $_POST['remarks'];
		$ulbid=$_SESSION['ulbid'];
		$created_by=$_SESSION['user_id'];
		//$created_at=date('Y-m-d h:m:s');
		$updated_at=date('Y-m-d h:m:s');
				
		$sql = "update field_visit_form set dept_id=".$dept_id.",desg_id=".$desg_id.",ward_id=".$ward_id.",street_id=".$street_id.",lat='".$lat."',lang='".$lang."',field_verification_reason='".$field_verification_reason."',field_verification_address='".$field_verification_address."',remarks='".$remarks."',ulbid='".$ulbid."',updated_at='".$updated_at."',created_by='".$created_by."' where id=".$id."";	
		
		mysqli_query($conn, $sql);
		
			/* 	
				if (mysqli_query($conn, $sql)) {			
						
					foreach ($doctitle as $key=>$value) {
						
						$result=uploadFile($docfiles,$key);
						$msg=$result['msg'];
						if (!empty($result['path'])) {
							$sql = "insert into field_visit_form_docs(dept_id,desg_id,ward_id,street_id,ulbid,doc_title,doc_file,mime_type,created_at,created_by) 
							values(".$dept_id.",".$desg_id.",".$ward_id.",".$street_id.",'".$ulbid."','".$value."','".$result['path']."','".$result['mime_type']."','".$created_at."','".$created_by."')";
							mysqli_query($conn, $sql);
						} 
						
					}			
				}	 					
			*/
			$msg  = "Updated successfully!";
			$class = "alert alert-success display-hide";
			unset($_SESSION['token']);
			set_flash($msg,$class);
			header("Location: inspection.php");
			exit();
		}
	} 					
	
	$tpl->assign("token", $_SESSION['token']);
	//echo "<pre>";print_r($result['path']);echo "</pre>";die();
	
	$tpl->assign('msg', $msg);

	$sql = "select * from  field_visit_form where ulbid='" . mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid']))."' ";
	
	if ($id!='') {
		$sql .= " and id =" . $id . " ";
	}
	
	
	if ($rs = mysqli_query($conn, $sql)) {
		$field_info = mysqli_fetch_fields($rs);
		while ($row = mysqli_fetch_assoc($rs)) {

			foreach ($field_info as $fi => $f)
				$data[$row['id']][$f->name] = $row[$f->name];
		}

		$num_emp = mysqli_num_rows($rs);
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$data=$data[$id];

//echo "<pre>";print_r($data);echo "</pre>";die();

	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "' order by dept_id";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select desg_id,desg_desc from desg_mst where ulbid='" . mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['ulbid'])) . "'";
	if ($rs = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($rs))
			$desg_list[$row['desg_id']] = $row['desg_desc'];
	} else
		printf("Errormessage: %s\n", mysqli_error($conn));

//echo "<pre>";print_r($desg_list);echo "</pre>";die();

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

	//echo "<pre>";print_r($data);echo "</pre>";die();
	
	//print_r($ids);
	mysqli_close($conn);

	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('data', $data);
	$tpl->assign('field_verification_reason', $field_verification_reason);
	$tpl->assign('field_address', $field_address);
	$tpl->assign('remarks', $remarks);
	$tpl->assign('num_emp', $num_emp);
	$tpl->assign('dept_list', $dept_list);
	$tpl->assign('ward_list', $ward_list);
	$tpl->assign('desg_list', $desg_list);
	$tpl->assign('street_list', $street_list);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('code', $code);
	$flash = get_flash();		
	$tpl->assign("flash", $flash); 
	$tpl->display('update_inspection.tpl');
} else {
	echo "<script>window.location='index.php';</script>";
}

function sanitize_input($data) {
	
    // Strip tags to prevent HTML and PHP code injection
    $data = strip_tags($data);

    // Convert special characters to HTML entities (e.g., < to &lt;)
    $data = htmlspecialchars($data);
	
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
		//$result['path']= $base_url.'/'.htmlspecialchars($fileDestination);
		$result['path']= $base_url.'/grievance/'.htmlspecialchars($fileDestination);
        $result['msg']= "File uploaded successfully: " ;
        $result['mime_type']= $fileType;
    } else {
         $result['msg']=  "Failed to move uploaded file.";
    }

return  $result;
}








?>