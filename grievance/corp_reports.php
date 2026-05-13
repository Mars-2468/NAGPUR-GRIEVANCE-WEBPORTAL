<?php
session_start();
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


	$captcha = mysqli_real_escape_string($conn, $_SESSION['code']);
	$code = mysqli_real_escape_string($conn, $_POST['code']);


	if (isset($_POST['save'])) {

		/*if($captcha == $code)
		    {*/
		if (!empty($_POST['csrf_token'])) {



			if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {

				if ($token_id == $_POST['token']) {






					$document_description = preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($_POST['doc_desc'])));
					$doc_desc_marathi = strip_tags($_POST['doc_desc_marathi']);
					//   print_r($doc_desc_marathi);exit();

					$sql = "insert into doc_mst(doc_desc,doc_desc_marathi,ulbid) values(?,?,?)";
					$query = $conn->prepare($sql);
					$query->bind_param("sss", $document_description, $doc_desc_marathi, htmlspecialchars(strip_tags($_SESSION['ulbid'])));


					if ($query->execute()) {
						$tpl->assign('class', 'alert alert-success display-hide');
						$msg = "Successfully Saved";
					} else {
						$tpl->assign('msg', 'alert alert-danger display-hide');
						$msg = "Uable to save   " . $query->error;
					}
					$query->close();
				} else {

					$tpl->assign('msg', 'alert alert-danger display-hide');
					$msg = "Uable to save   " . $query->error;
				}
			} else {
				$tpl->assign('msg', 'Invalid token');
			}
		} else {
			$tpl->assign('msg', 'Something went wrong');
		}

		/* }
          else
                	{
                	   
                	    $msg="Invalid Captcha Code";
                		$tpl->assign('msg',$msg);
                		
                	}*/
	}



	$sql = $conn->prepare("select doc_id,doc_desc,doc_desc_marathi from doc_mst where ulbid=? order by doc_desc");

	$sql->bind_param("s", htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$sql->execute();
	$rs = $sql->get_result();

	while ($row = $rs->fetch_assoc()) {

		$doc_list[$row['doc_id']]['doc_desc'] = $row['doc_desc'];
		$doc_list[$row['doc_id']]['doc_desc_marathi'] = $row['doc_desc_marathi'];
	}


	$sql->close();





	$sql = $conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
	$sql->bind_param("s", htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}

	$sql->close();


	/** captcha generation ****/

	$code = rand(1000, 9999);

	$_SESSION['code'] = $code;




	/** close **/






	/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type=? and ulbid =?");
		$type=1;
		$sql->bind_param("is",$type,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/



	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);



	$tpl->assign('user_type', htmlspecialchars(strip_tags($_SESSION['user_type'])));

	$tpl->assign('online_applications', $online_applications);

	$sql->close();

	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('code', $code);
	$tpl->assign('doc_list', $doc_list);
	$tpl->assign('token_id', $token_id);
	$tpl->display('corp_reports.tpl');
} else {
	/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

	echo "<script>window.location='index.php';</script>";
}
?>