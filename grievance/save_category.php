<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 0);

require_once('Smarty.class.php');

$tpl = new Smarty();

if (isset($_SESSION['uid'])) {

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


	$captcha = $_POST['captcha'];

	$code = $_SESSION['code'];


	if (isset($_POST['save'])) 
	{

//echo "<pre>";print_r($_POST);echo "</pre>";die();	
	
		if(!validateField($_POST['description'], 'text')['valid'] || !validateField($_POST['telugu_description'], 'text')['valid']){
			$tpl->assign('class', 'alert alert-danger display-hide');
			$msg = "Enter Valid Category name..!";
			$tpl->assign('msg', $msg);			
			header("Location: category.php");
			exit;
		}else{
			
				if ($captcha == $code) 
				{
					if (!empty($_POST['csrf_token'])) 
					{
						if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) 
						{
							$description =  $_POST['description']; //preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['description']);
							$description_marathi =  $_POST['telugu_description']; //$_POST['telugu_description'];
							$dept_id = 0;
							$ulbid = 250;
							$cs_type_id = 1;
							$sort_order = 0;
							$is_mepma = 0;

							if (!empty($description) && !empty($description_marathi)) 
							{
								if ($_POST['cat_id'] == '0') 
								{
									$sql = "insert into category_mst(dept_id,description,telugu_description,ulbid,cs_type_id,sort_order,is_mepma) values(?,?,?,?,?,?,?)";
									$query = $conn->prepare($sql);
									$query->bind_param("sssssis", $dept_id, $description, $description_marathi, $ulbid, $cs_type_id, $sort_order, $is_mepma);
								} else {
									// print_r($_POST);exit(); 
									$sql = "update category_mst set description=?,telugu_description=? where cat_id=?";
									$query = $conn->prepare($sql);
									$query->bind_param("ssi", $description, $description_marathi, $_POST['cat_id']);
								}
								if ($query->execute()) {
									$class= 'alert alert-success display-hide';
									$msg = "The Record Successfully Saved..!";
								} else {
									$class = 'alert alert-danger display-hide';
									$msg = "Uable to save   " . $query->error;
								}
								$query->close();
							} else {
								$class= 'alert alert-success display-hide';
								$msg = "Enter Valid Category Description..!";
							}
							
						} else {
							$class= 'alert alert-danger display-hide';
							$msg= 'Invalid Token..!';
						}
					} else {
						$class= 'alert alert-danger display-hide';
						$msg= 'Something Went Wrong..!';
					}
				} else {
					$class='alert alert-danger display-hide';
					$msg = "Invalid Captcha Code..!";
					
				}
			set_flash($msg,$class);	
			header("Location: category.php");
			exit;
			
		}
	}
	
} else {
	echo "<script>window.location='index.php';</script>";
}
