<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

$msg='';

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

	if (isset($_POST['save'])) {
		
		if(!validateField($_POST['remarks'], 'sptext')['valid']){
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
		$created_at=date('Y-m-d h:m:s');
		$updated_at=date('Y-m-d h:m:s');
		
		$doctitle = $_POST['doctitle'];
		$docfiles = $_FILES['docfiles'];
				
		$sql = "insert into field_visit_form(dept_id,desg_id,ward_id,street_id,lat,lang,field_verification_reason,field_verification_address,remarks,ulbid,created_at,created_by) 
		values(".$dept_id.",".$desg_id.",".$ward_id.",".$street_id.",'".$lat."','".$lang."','".$field_verification_reason."','".$field_verification_address."','".$remarks."','".$ulbid."','".$created_at."','".$created_by."')";	
		
		if (mysqli_query($conn, $sql)) {
			
			$last_id=mysqli_insert_id($conn);
				//var_dump($last_id);die();
			foreach ($doctitle as $key=>$value) {
				
				$result=uploadFile($docfiles,$key);
								
				if(!empty($result['imgerr'])) {
					$msg="Invalid file format. Allowed: JPG, PNG, GIF.!";
					$class = "alert alert-danger display-hide";
					set_flash($msg,$class);
					header('Location: inspection.php');
					exit;
				}
				
				$msg=$result['msg'];
				
				if(empty($result['path'])) {
					$msg="Invalid file format. Allowed: JPG, PNG, GIF.!";
					$class = "alert alert-danger display-hide";
					set_flash($msg,$class);
					header('Location: inspection.php');
					exit;
				}
				
				if (!empty($result['path'])) {
					$sql = "insert into field_visit_form_docs(dept_id,desg_id,ward_id,street_id,ulbid,doc_title,doc_file,mime_type,created_at,created_by,field_visit_form_id) 
					values(".$dept_id.",".$desg_id.",".$ward_id.",".$street_id.",'".$ulbid."','".$value."','".$result['path']."','".$result['mime_type']."','".$created_at."','".$created_by."',".$last_id.")";
					mysqli_query($conn, $sql);
				} 
				
			}			
		}						
		$class = "alert alert-success display-hide";
		$msg="Record stored successfully!";
		set_flash($msg,$class);
		header("Location: inspection.php");
		exit();
	} 	
	
	} 					
	
	
} else {
	echo "<script>window.location='index.php';</script>";
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
		 //$result['msg']=  "Invalid file format. Allowed: JPG, PNG, GIF.";
		 $result['imgerr']='';
		 return false;
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



