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



	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	include('prepare_connection.php');
	$conn = getconnection();
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

	function getExtension($str)
	{

		$i = strrpos($str, ".");
		if (!$i) {
			return "";
		}
		$l = strlen($str) - $i;
		$ext = substr($str, $i + 1, $l);
		return $ext;
	}

	if (isset($_POST['save'])) {
		if ($token_id == $_POST['token']) {

			$edition_date = date('Y-m-d', strtotime($_POST['edition_date']));





			$sql = "insert into add_content_media_coverage(title,title_marathi,description,desciption_marathi,edition_date,ulbid) values(?,?,?,?,?,?)";
			$query = $conn->prepare($sql);
			$title = mysqli_real_escape_string($conn, strip_tags($_POST['title']));
			$title_marathi = mysqli_real_escape_string($conn, strip_tags($_POST['title_marathi']));
			$description = mysqli_real_escape_string($conn, strip_tags($_POST['description']));
			$desciption_marathi = mysqli_real_escape_string($conn, strip_tags($_POST['desciption_marathi']));
			$edition_date = date('Y-m-d', strtotime($_POST['edition_date']));
			$ulbid = mysqli_real_escape_string($conn, $_SESSION['ulbid']);
			$query->bind_param("ssssss", $title,$title_marathi, $description,$desciption_marathi, $edition_date, $ulbid);


			
				$result = $query->execute();
			
			if ($result) {

				$content_no = $conn->insert_id;
				$j = 0;
				$target_path = "media_coverages/";
				for ($i = 0; $i < count($_FILES['file']['name']); $i++) {

					$image = $_FILES["file"]["name"][$i];
					$uploadedfile = $_FILES['file']['tmp_name'][$i];
					if ($image) {
						$filename = stripslashes($_FILES['file']['name'][$i]);
						$extension = strtolower(getExtension($filename));
						if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
							echo 'Unkonwn Extension';
							$errors = 1;
						} else {
							$newname = time() . $i . "." . $extension;
							$size = filesize($_FILES['file']['tmp_name'][$i]);

							if ($extension == "jpg" || $extension == "jpeg") {
								$uploadedfile = $_FILES['file']['tmp_name'][$i];
								$src = imagecreatefromjpeg($uploadedfile);
							} else if ($extension == "png") {
								$uploadedfile = $_FILES['file']['tmp_name'][$i];
								$src = imagecreatefrompng($uploadedfile);
							} else {
								$src = imagecreatefromgif($uploadedfile);
							}
							list($width, $height) = getimagesize($uploadedfile);

							$newwidth = 256;
							$newheight = 256;

							$tmp = imagecreatetruecolor($width, $height);



							imagecopyresampled($tmp, $src, 0, 0, 0, 0, $width, $height, $width, $height);

							imagecopyresampled($tmp1, $src, 0, 0, 0, 0, $width, $height, $width, $height);

							$filename = "media_coverages/" . $newname;


							imagejpeg($tmp, $filename, 100); //file name also indicates the folder where to save it to


							imagedestroy($src);
							imagedestroy($tmp);
							$target_file1 = "https://" . $_SERVER['HTTP_HOST'] . "/csms/" . $filename;


							$sql_img = "insert into add_content_image (content_no,images) values(?,?)";
							$query = $conn->prepare($sql_img);
							$content_no = mysqli_real_escape_string($conn, strip_tags($content_no));
							$images = mysqli_real_escape_string($conn, $target_file1);
							$query->bind_param("is", $content_no, $images);
							$result = $query->execute();
						}
					}
				}

				$tpl->assign('class', 'alert alert-success display-hide');
				$msg = "Successfully Updated  Details";
			} else {
				print_r($query->error);
				$tpl->assign('msg', 'alert alert-danger display-hide');
				$msg = "Uable to insert ";
			}

			$tpl->assign('msg', $msg);
		}
	}

	$sql = $conn->prepare("SELECT * FROM add_content_media_coverage where ulbid=? order by edition_date DESC");
	$ulbid = mysqli_real_escape_string($conn, strip_tags($_SESSION['ulbid']));
	$sql->bind_param("s", $ulbid);
	$sql->execute();
	$rs = $sql->get_result();

	while ($row = $rs->fetch_assoc()) {
		$data[$row['content_no']]['title'] = $row['title'];
		$data[$row['content_no']]['description'] = $row['description'];
		$data[$row['content_no']]['title_marathi'] = $row['title_marathi'];
		$data[$row['content_no']]['desciption_marathi'] = $row['desciption_marathi'];
		$data[$row['content_no']]['edition_date'] = date('d-m-Y', strtotime($row['edition_date']));
	}

	$sql->close();


	$sql = $conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
	$sql->bind_param("s", $_SESSION['ulbid']);
	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$online_applications['trade_application'] = $row['trade_application'];
		$online_applications['water_tap_application'] = $row['water_tap_application'];
	}

	$sql->close();



	/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/

	$users_count = $row['user_count'];
	$tpl->assign('users_count', $users_count);
	$tpl->assign('user_type', $_SESSION['user_type']);
	$tpl->assign('online_applications', $online_applications);

	$tpl->assign('villages', array('208' => 'Jillelguda', '210' => 'Meerpet'));
	$tpl->assign('ulbid', $_SESSION['ulbid']);
	$tpl->assign('data', $data);
	$tpl->assign('logo', $_SESSION['logo']);
	$tpl->assign('services', $obj->services);
	$tpl->assign('uname', $_SESSION['user_name']);
	$tpl->assign('uid', $_SESSION['uid']);
	$tpl->assign('main_icons', $obj->main_icons);
	$tpl->assign('banner', $_SESSION['banner']);
	$tpl->assign('token_id', $token_id);
	$tpl->display('media_coverage.tpl');
} else {

	echo "<script>window.location='index.php';</script>";
}
