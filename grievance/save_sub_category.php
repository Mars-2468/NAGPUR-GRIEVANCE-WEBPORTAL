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

	$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);

	$code = mysqli_real_escape_string($conn, $_SESSION['code']);

	if (isset($_POST['save'])) {
		
		
		if(!validateField($_POST['description'], 'text')['valid'] || !validateField($_POST['description_marathi'], 'text')['valid']){
			$tpl->assign('class', 'alert alert-danger display-hide');
			$msg = "Enter Valid Description..!";
			$tpl->assign('msg', $msg);
			header("Location: sub_category.php");
			exit;
		}else{

			if ($captcha == $code) {

				if (!empty($_POST['csrf_token'])) {
//var_dump($_POST['csrf_token']);die();
					
						$description = $_POST['description']; //preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['description']);
						$description_marathi = $_POST['description_marathi']; //$_POST['description_marathi'];
						$catId = $_POST['cat_id'];

						if (!empty($description) && !empty($description_marathi)) {

							if ($_POST['sub_cat_id'] == '0') {

								$sql = "insert into subcategory_mst(cat_id,description,description_marathi) values(?,?,?)";

								$query = $conn->prepare($sql);

								$query->bind_param("iss", $catId, $description, $description_marathi);
							} else {
								$sql = "update subcategory_mst set cat_id=?,description=?,description_marathi=? where sub_cat_id=?";
								$query = $conn->prepare($sql);
								$query->bind_param("issi", $catId, $description, $description_marathi, $_POST['sub_cat_id']);
							}

							if ($query->execute()) {
								$tpl->assign('class', 'alert alert-success display-hide');
								$msg = "The Record Successfully Saved..!";
							} else {
								$tpl->assign('msg', 'alert alert-danger display-hide');
								$msg = "Uable to save   " . $query->error;
							}

							$query->close();
						} else {
							$tpl->assign('class', 'alert alert-success display-hide');
							$msg = "Enter Valid Ward Description";
						}
						
						$tpl->assign('msg', $msg);
						
					
				} else {
					$tpl->assign('class', 'alert alert-danger display-hide');
					$tpl->assign('msg', 'Something Went Wrong..!');
				}
			} else {
				$tpl->assign('class', 'alert alert-danger display-hide');
				$msg = "Invalid Captcha Code";
				$tpl->assign('msg', $msg);
			}
			header("Location: sub_category.php");
			exit;
		}
		
	}

	
} else {
	echo "<script>window.location='index.php';</script>";
}


	