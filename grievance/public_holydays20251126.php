<?php
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);

require_once('Smarty.class.php');
require_once('csrf.class.php');
$csrf = new csrf();
$tpl = new Smarty();
session_start();

$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
//require_once('sms_conf.php');
//require_once('send_sms.php');	

if (isset($_SESSION['uid'])) {
	session_regenerate_id();
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
	include('user_defined_functions.php');
	require_once('prepare_connection.php');
	$csrf_token = generateToken($csrf_prefix_token);
	$tpl->assign('csrf_token', $csrf_token);
	$captcha = mysqli_real_escape_string($conn, $_POST['captcha']);
	$code = mysqli_real_escape_string($conn, $_SESSION['code']);


		if (isset($_POST['save'])) {
		
		
		if(!validateField($_POST['desciption'], 'sptext') || !validateField($_POST['desciption_marathi'], 'sptext')){
			$tpl->assign('class', 'alert alert-danger display-hide');
			$msg = "Enter Valid Holiday Description/Marathi Description..!";
			$tpl->assign('msg', $msg);
		}else{
		
		
			/* if($captcha == $code){ */
				
				if (!empty($_POST['csrf_token'])) {
					if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {
						if ($token_id == $_POST['token']) {
							
							//echo "<pre>";print_r($_POST);echo "</pre>";die();
							
							$date = date('Y-m-d', strtotime($_POST['date']));
							
							$desciption = sanitize_input($_POST['desciption']); //preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['desciption']);
							$desciption_marathi =  sanitize_input($_POST['desciption_marathi']); //$_POST['desciption_marathi'];

							$sql = "insert into public_holydays(date,desciption,desciption_marathi,ulbid) values(?,?,?,?)";
							$query = $conn->prepare($sql);
							$query->bind_param("ssss", $date, $desciption, $desciption_marathi, $_SESSION['ulbid']);

							if ($query->execute()) {
								$tpl->assign('class', 'alert alert-success display-hide');
								$msg = "The Record Successfully Saved..!";
							} else {
								$tpl->assign('msg', 'alert alert-danger display-hide');
								$msg = "Uable to save   " . $query->error;
							}
							$query->close();
						} else {
							/*$tpl->assign('msg', 'alert alert-danger display-hide');
							$msg = "Uable to save   " . $query->error;*/
							$tpl->assign('class', 'alert alert-danger display-hide');
							$msg = "Enter Valid Holiday Description..!";
						}
						$tpl->assign('msg', $msg);
					} else {
						$tpl->assign('class', 'alert alert-danger display-hide');
						$tpl->assign('msg', 'Invalid token..!');
					}
				} else {
					$tpl->assign('class', 'alert alert-danger display-hide');
					$tpl->assign('msg', 'Something Went Wrong..!');
				}

			/* }
			else
			{
				$msg="Invalid Captcha Code";
				$tpl->assign('msg',$msg);
			} */
		}
	}

	$sql = $conn->prepare("select * from public_holydays where ulbid=? order by date");
	$sql->bind_param("s", htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$sql->execute();
	$rs = $sql->get_result();

	while ($row = $rs->fetch_assoc()) {
		//foreach($field_info as $fi => $f) 
		$doc_list[$row['id']]['date'] = $row['date'];
		$doc_list[$row['id']]['desciption'] = $row['desciption'];
		$doc_list[$row['id']]['desciption_marathi'] = $row['desciption_marathi'];
		//$doc_list[$row['id']][$f->name]=$row[$f->name];
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

	/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
	$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$sql->execute();
	$rs=$sql->get_result();
	$row = $rs->fetch_assoc();
	$conn->close();*/

	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);

	$tpl->assign('user_type', htmlspecialchars(strip_tags($_SESSION['user_type'])));

	$tpl->assign('online_applications', $online_applications);

	$tpl->assign('online_applications', $online_applications);
	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('code', $code);
	$tpl->assign('doc_list', $doc_list);
	$tpl->assign('token_id', $token_id);
	$tpl->display('public_holydays.tpl');
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