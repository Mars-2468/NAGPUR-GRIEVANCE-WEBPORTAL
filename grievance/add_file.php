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
	
	if (isset($_FILES)) {
		
		$field_visit_form_id = $_POST['field_visit_form_id'];
		$doctitle = sanitize_input($_POST['doctitle']);
		$docfile = $_FILES['docfile'];
		
		$created_by=$_SESSION['user_id'];
		
		$created_at=date('Y-m-d h:m:s');		
		$updated_at=date('Y-m-d h:m:s');		
				
		$sql = "select * from field_visit_form where ulbid='" . $_SESSION['ulbid'] . "' and id=".$field_visit_form_id."";
				
		$rs = mysqli_query($conn, $sql);
		
		$row =mysqli_fetch_assoc($rs);
				
		$dept_id = $row['dept_id'];
		$desg_id = $row['desg_id'];
		$ward_id = $row['ward_id'];
		$street_id = $row['street_id'];
		
		$result=uploadSingleFile($docfile);
		$msg=$result['msg'];
		
		if (!empty($result['path'])) {
					$sql = "insert into field_visit_form_docs(dept_id,desg_id,ward_id,street_id,ulbid,doc_title,doc_file,mime_type,created_at,created_by,field_visit_form_id) 
					values(".$dept_id.",".$desg_id.",".$ward_id.",".$street_id.",'".$ulbid."','".$doctitle."','".$result['path']."','".$result['mime_type']."','".$created_at."','".$created_by."',".$field_visit_form_id.")";
					
						//echo "<pre>";print_r($sql);echo "</pre>";die();
					
					mysqli_query($conn, $sql);	
		} 
		//echo"<pre>";print_r($result);echo"</pre>";die('  end');
		
		header("Location: view_inspection.php?fid=".$field_visit_form_id);
		exit();
	} 					
		
//echo "<pre>";print_r($data);echo "</pre>";die();
	//print_r($ids);
	mysqli_close($conn);
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


function uploadSingleFile($docfile) {
	
   // $maxsize = 5000000;	
   $result['msg']='';
   $result['path']='';
	$allowedFormats = ['jpg', 'jpeg', 'png', 'gif','pdf'];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

	$fileName = $docfile['name'];
	$fileType = $docfile['type'];
	$fileTmpName = $docfile['tmp_name'];
	$fileSize = $docfile['size'];
	$fileError = $docfile['error'];
	$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		 
	$fileMimeType = mime_content_type($fileTmpName);

	if (!in_array($fileExt, $allowedFormats)) {
		 $result['msg']=  "Invalid file format. Allowed: JPG, PNG, GIF.";
	}

	if (!in_array($fileMimeType, $allowedMimeTypes)) {
		 $result['msg']=  "Invalid file type detected! Possible security risk.";
	}

	// Validate file size (max 2MB)
	/* $maxSize = 5 * 1024 * 1024; // 2MB in bytes
	if ($fileSize > $maxSize) {
		 $result['msg']=  "File size exceeds 2MB.";
	} */

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