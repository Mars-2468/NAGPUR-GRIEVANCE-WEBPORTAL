<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 0);

require_once('Smarty.class.php');

$tpl = new Smarty();



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



	$sql = "select app_type_id,person_name,park_name,email,hno,address,ward_id,street_id,mobile,cat3_id,comp_desc,grievance_origin_id,grievance_status_id,date_regd,file_no,endorsement,mcat3_id,file_url from grievances where grievance_id='" . $_POST['grievance_id'] . "' and ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		$field_info = mysqli_fetch_fields($rs);

		$row = mysqli_fetch_assoc($rs);

		foreach ($field_info as $fi => $f)

			$data1[$f->name] = $row[$f->name];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));





	$sql = "select * from category3_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {

		$cat3_list[$row['cs_id']] = $row['comp_desc'];
	}



	$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='" . $_SESSION['ulbid'] . "' and delete_status='0' and emp_status='0'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$emp_list[$row['emp_id']]['emp_name'] = $row['emp_name'];

			$emp_list[$row['emp_id']]['emp_dept'] = $row['emp_dept'];

			$emp_list[$row['emp_id']]['emp_desg'] = $row['emp_desg'];

			$emp_list[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
		}
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));



	$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od where ulbid='" . $_SESSION['ulbid'] . "' and delete_status='0'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$emp_list[$row['emp_id']]['emp_name'] = $row['emp_name'];

			$emp_list[$row['emp_id']]['emp_dept'] = $row['emp_dept'];

			$emp_list[$row['emp_id']]['emp_desg'] = $row['emp_desg'];

			$emp_list[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
		}
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));



	try {
		if (isset($_POST['save'])) {

			$tpl->assign('msg', 'checking');
			$target_dir = "grievance/Update_Images/";

			$file_url = "";

			if (!empty($_FILES["fileToUpload"]["name"])) {

				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

				$uploadOk = 1;

				$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));



				$folder = date('dmy');

				// Check if folder already exists

				if (file_exists($target_dir . $folder)) {

					$target_dir = $target_dir . $folder;
				} else {

					if (mkdir($target_dir . $folder)) {

						$target_dir = $target_dir . $folder;
					}
				}



				// Check file size

				if ($_FILES["fileToUpload"]["size"] > 5000000) {

					$msg = "Sorry, your file is too large.";

					$uploadOk = 0;
				}

				// Allow certain file formats

				if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {

					$msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

					$uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error

				if ($uploadOk == 0) {

					//echo "Sorry, your file was not uploaded.";

					// if everything is ok, try to upload file

				} else {

					$temp = explode(".", $_FILES["fileToUpload"]["name"]);

					$newfilename = $temp[0] . '_' . $_POST['grievance_id'] . '_' . date('Y') . date('m') . date('d') . date('h') . date('i') . date('s') . '.' . end($temp);

					try {
						if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . '/' . $newfilename)) {

							$file_url = $target_dir . '/' . $newfilename;
						}
					} catch (Exception $ex) {
						die($ex->getMessage);
					}
				}
			}

			require_once('get_ulb_info.php');

			$ulb_info = get_ulb_info();



			$sql = "select * from grievance_status_mst";



			if ($rs = mysqli_query($conn, $sql)) {

				while ($row = mysqli_fetch_assoc($rs))

					$grievance_status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
			} else

				printf("Errormessage: %s\n", mysqli_error($conn));


			$sel_date = $_REQUEST['disposed_date'] . " " . date('H:i:s');
			$grievance_id = $_REQUEST['grievance_id'];
			$transaction_id = $_REQUEST['transaction_id'];
			$app_type_id = $_REQUEST['app_type_id'];
			$cat3_id = $_REQUEST['cat3_id'];
			$disposal_status = $_REQUEST['disposal_status'];
			$disposed_date = date('Y-m-d H:i:s', strtotime($sel_date));
			//old code change date 29-04-24 $disposal_remarks = $_REQUEST['disposal_remarks'];
			$dis_remark = str_replace("'", "", $_REQUEST['disposal_remarks']);
			$disposal_remarks = $dis_remark;
			$rca = $_REQUEST['rca'];
			$ca = $_REQUEST['ca'];
			$emp_id = $_REQUEST['emp_id'];
			$emp_dept = $_REQUEST['emp_dept'];
			$emp_desg = $_REQUEST['emp_desg'];

			// cs list

			$sql = "select cs_id , cs_desc as  comp_desc from cs_mst";

			$rs = mysqli_query($conn, $sql);

			while ($row = mysqli_fetch_assoc($rs)) {

				$cs_list[$row['cs_id']] = $row['comp_desc'];
			}


			if ($disposal_status != 5) {

				$sql = "select grievance_status_id from grievances where grievance_id='" . $grievance_id . "'";
				$rss = mysqli_query($conn, $sql);
				$rws = 	mysqli_fetch_assoc($rss);
				$previous_status = $rws['grievance_status_id'];

				if ($previous_status == 2) {
					$sql = "update grievances_transactions set disposed_date='" . $disposed_date . "',disposal_status='" . $disposal_status . "',disposal_remarks='" . $disposal_remarks . "',updated_by='" . $_SESSION['uid'] . "',origin_id='3',rca='" . $rca . "',ca='" . $ca . "',file_url='" . $file_url . "' where grievance_id='" . $grievance_id . "' and disposal_status='2'";
				} else {
					$sql = "update grievances_transactions set disposed_date='" . $disposed_date . "',disposal_status='" . $disposal_status . "',disposal_remarks='" . $disposal_remarks . "',updated_by='" . $_SESSION['uid'] . "',origin_id='3',rca='" . $rca . "',ca='" . $ca . "',file_url='" . $file_url . "' where grievance_id='" . $grievance_id . "' and disposal_status='11'";
				}

				if (mysqli_query($conn, $sql)) {
					$sql = "update grievances set grievance_status_id='" . $disposal_status . "' where grievance_id='" . $grievance_id . "'";
					//03-06-24 New Query $sql = "update grievances set g_emp_id='" . $emp_id . "' AND g_dept_id='" . $emp_dept . "' AND g_desg_id='" . $emp_desg . "' AND grievance_status_id='" . $disposal_status . "' where grievance_id='" . $grievance_id . "'";
					mysqli_query($conn, $sql);
				}
				//echo $sql;exit;
			} else {



				$sql = "select grievance_status_id from grievances where grievance_id='" . $grievance_id . "'";
				$rss = mysqli_query($conn, $sql);
				$rws = 	mysqli_fetch_assoc($rss);
				$previous_status = $rws['grievance_status_id'];

				$curstatus = 2;

				if ($previous_status == 11) {

					$curstatus = 11;
				}


				$sql = "select transaction_id from grievances_transactions where grievance_id='" . $grievance_id . "' order by transaction_id DESC limit 1";
				$trnsrs = mysqli_query($conn, $sql);
				$trnsrow  = mysqli_fetch_assoc($trnsrs);
				$transaction_id_old = $trnsrow['transaction_id'];

				// transaction id increment
				$transaction_id = $transaction_id_old + 1;

				$sql = "insert into grievances_transactions(
				grievance_id,
				transaction_id,
				emp_id,
				dept_id,
				alloted_date,
				disposal_status,
				updated_by,
				file_url
				)values(
				'" . $grievance_id . "',
				'" . $transaction_id . "',
				'" . $emp_id . "',
				'" . $emp_dept . "',
				'" . $disposed_date . "',
				'" . $curstatus . "',
				'" . $_SESSION['uid'] . "',
				'" . $file_url . "'
				)";

				if (mysqli_query($conn, $sql)) {
					$sql = "update grievances_transactions set disposed_date='" . $disposed_date . "',disposal_status='" . $disposal_status . "',disposal_remarks='" . $disposal_remarks . "',updated_by='" . $_SESSION['uid'] . "',origin_id='3',rca='" . $rca . "',ca='" . $ca . "' where grievance_id='" . $grievance_id . "' and transaction_id='" . $transaction_id_old . "'";
					mysqli_query($conn, $sql);
				}




				// employee lists

				$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='" . $_SESSION['ulbid'] . "' and delete_status='0' and emp_status='0'";

				if ($rs = mysqli_query($conn, $sql)) {

					while ($row = mysqli_fetch_assoc($rs)) {

						$emp_list[$row['emp_id']]['emp_name'] = $row['emp_name'];

						$emp_list[$row['emp_id']]['emp_dept'] = $row['emp_dept'];

						$emp_list[$row['emp_id']]['emp_desg'] = $row['emp_desg'];

						$emp_list[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
					}
				} else

					printf("Errormessage: %s\n", mysqli_error($conn));

				//print_r($emp_list);


				// sending sms


				$sql = "select * from grievances where grievance_id='" . $grievance_id . "'";
				$smsrs = mysqli_query($conn, $sql);
				$data1 = mysqli_fetch_assoc($smsrs);
			}

			if ($disposal_status == 5) {

				$sms = "Dear " . substr($data1['person_name'], 0, 29) . ", Your Grievance regarding " . substr($cs_list[$data1['cat3_id']], 0, 29) . " with Ref No " . $grievance_id . " is transferred and allotted to " . substr($emp_list[$emp_id]['emp_name'], 0, 29) . " on date " . $disposed_date . " Regards- Citizen Service Monitoring Cell, NMCGOV";
				$mobile = $data1['mobile'];
				$templateId = "1707167653174818169";
				$message = str_replace(' ', '%20', $sms);
				$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
				//require_once('aurangabad_sms_config.php');

				$post = curl_init();
				curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($post, CURLOPT_URL, $url);
				curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($post);
			} else if ($disposal_status == 10) {


				$sms = "Dear " . substr($data1['person_name'], 0, 29) . " , Your Grievance regarding " . substr($cs_list[$data1['cat3_id']], 0, 29) . " with Ref No " . $grievance_id . " is rejected " . substr($disposal_remarks, 0, 29) . " and disposed Regards- Citizen Service Monitoring Cell, NMCGOV";
				$mobile = $data1['mobile'];
				$templateId = "1707167653187557130";
				$message = str_replace(' ', '%20', $sms);
				$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
				//require_once('aurangabad_sms_config.php');
				$post = curl_init();
				curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($post, CURLOPT_URL, $url);
				curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($post);
			} else if ($disposal_status == 4) {
			} else if ($disposal_status == 9 || $disposal_status == 12) {

				$status_link = "https://tinyurl.com/2bfw2y96";

				$sms = "Dear " . substr($data1['person_name'], 0, 29) . ", Your Grievance regarding " . substr($cs_list[$data1['cat3_id']], 0, 30) . " with Ref No " . $grievance_id . " is resolved on " . $disposed_date . " Track your Application Status at " . $status_link . " Regards, NMCGOV";
				$mobile = $data1['mobile'];

				$templateId = "1707171687709782022";
				$message = str_replace(' ', '%20', $sms);

				$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
				//require_once('aurangabad_sms_config.php');
				$post = curl_init();
				curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($post, CURLOPT_URL, $url);
				curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($post);
			}






			echo "<script>alert('Updated Successfully..!'); window.location='manage_comp_test.php';</script>";
		}
	} catch (Exception $e) {
		return $e->getMessage();
	}


	// 		die('testing');



	$sql = "select ward_id,ward_desc from ward_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$ward_list[$row['ward_id']] = $row['ward_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select street_id,street_desc from street_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$street_list[$row['street_id']] = $row['street_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));


	$sql = "select dept_id,dept_desc from dept_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$dept_list[$row['dept_id']] = $row['dept_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select desg_id,desg_desc from desg_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$desg_list[$row['desg_id']] = $row['desg_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	$sql = "select grievance_origin_id,grievance_origin_desc from grievance_origin_mst";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs))

			$grievance_origin_list[$row['grievance_origin_id']] = $row['grievance_origin_desc'];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));


	if (isset($_POST['grievance_id'])) {

		$sql = "select app_type_id,mcat3_id,cat3_id,app_type_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_origin_id,grievance_status_id,date_regd from grievances where grievance_id='" . $_POST['grievance_id'] . "' and ulbid='" . $_SESSION['ulbid'] . "'";

		if ($rs = mysqli_query($conn, $sql)) {

			$field_info = mysqli_fetch_fields($rs);

			$row = mysqli_fetch_assoc($rs);

			foreach ($field_info as $fi => $f)

				$data1[$f->name] = $row[$f->name];
		} else

			printf("Errormessage: %s\n", mysqli_error($conn));

		$sql = "select transaction_id,emp_id,DATE_FORMAT(alloted_date, '%Y-%m-%d') AS alloted_date,disposed_date,disposal_status,disposal_remarks,app_type_id,rca,ca from grievances g, grievances_transactions gt where  g.grievance_id=gt.grievance_id and gt.grievance_id='" . $_POST['grievance_id'] . "' and disposal_status IN('2','11','6') order by transaction_id";

		if ($rs = mysqli_query($conn, $sql)) {

			$transaction_id = 0;

			while ($row = mysqli_fetch_assoc($rs)) {

				$data2[$row['transaction_id']]['emp_name'] = $emp_list[$row['emp_id']]['emp_name'];

				$data2[$row['transaction_id']]['emp_desg'] = $emp_list[$row['emp_id']]['emp_desg'];

				$data2[$row['transaction_id']]['emp_dept'] = $emp_list[$row['emp_id']]['emp_dept'];

				$data2[$row['transaction_id']]['emp_mobile'] = $emp_list[$row['emp_id']]['emp_mobile'];

				$data2[$row['transaction_id']]['alloted_date'] = $row['alloted_date'];

				$data2[$row['transaction_id']]['disposed_date'] = $row['disposed_date'];

				$data2[$row['transaction_id']]['disposal_status'] = $row['disposal_status'];

				$data2[$row['transaction_id']]['disposal_remarks'] = $row['disposal_remarks'];

				$data2[$row['transaction_id']]['rca'] = $row['rca'];

				$data2[$row['transaction_id']]['ca'] = $row['ca'];

				$transaction_id = $row['transaction_id'];

				$app_type_id = $row['app_type_id'];
			}

			$tpl->assign('data2', $data2);

			$tpl->assign('transaction_id', $transaction_id);
		}

		$tpl->assign('grievance_id', $_POST['grievance_id']);

		$tpl->assign('data1', $data1);

		if ($app_type_id == '1') {

			$sql_status = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('2','9','4','5','6') ORDER BY FIELD (grievance_status_id, 2,5,9,6,4)";

			$sql = "select grievance_status_id from grievances where grievance_id='" . $_POST['grievance_id'] . "'";

			$rs = mysqli_query($conn, $sql);

			$row = mysqli_fetch_assoc($rs);

			$status = $row['grievance_status_id'];

			if ($status == '11') {

				$sql_status = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('12','5')";
			}

			$sql = "select cs_id,cs_desc as comp_desc from cs_mst";
		} else {

			$sql_status = "select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id IN('2','5','9','6','4')";

			$sql = "select cs_id, cs_desc as comp_desc from standard_services";
		}

		$rs = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_assoc($rs)) {

			$cs_list[$row['cs_id']] = $row['comp_desc'];
		}

		$tpl->assign('cs_list', $cs_list);

		if ($rs = mysqli_query($conn, $sql_status)) {

			while ($row = mysqli_fetch_assoc($rs))
				$grievance_status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
		} else

			printf("Errormessage: %s\n", mysqli_error($conn));


	}

	if (isset($_POST['escalate_page'])) {

		$sql = "select * from grievances_transactions where grievance_id ='" . $_POST['grievance_id'] . "' and emp_id='" . $_SESSION['emp_id'] . "' order by transaction_id DESC limit 1";
		$rsesc = mysqli_query($conn, $sql);
		$trns_row  = mysqli_fetch_assoc($rsesc);
		$trns_id = $trns_row['transaction_id'];
		$tpl->assign('transaction_id', $trns_id);
	}


	mysqli_free_result($rs);

	mysqli_close($conn);




	$tpl->assign('app_type_id', $_POST['app_type_id']);

	$tpl->assign('ward_list', $ward_list);

	$tpl->assign('street_list', $street_list);

	$tpl->assign('desg_list', $desg_list);

	$tpl->assign('dept_list', $dept_list);

	$tpl->assign('grievance_origin_list', $grievance_origin_list);

	$tpl->assign('grievance_status_list', $grievance_status_list);

	$tpl->assign('main_icons', $obj->main_icons);

	$tpl->assign('banner', $_SESSION['banner']);

	$tpl->assign('user_type', $_SESSION['user_type']);

	$tpl->assign('services', $obj->services);

	$tpl->assign('uname', $_SESSION['user_name']);

	$tpl->assign('uid', $_SESSION['uid']);

	$tpl->display('manage_comp_sel_test.tpl');
} else {

	/*$msg="You have not logged in, Please Login";

		$tpl->assign('msg',$msg);

		$tpl->display('user_login.tpl');*/



	echo "<script>window.location='index.php';</script>";
}
?>