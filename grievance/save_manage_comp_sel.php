<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 0);

require_once('Smarty.class.php');

$tpl = new Smarty();

//echo "<pre>";print_r($_POST);echo "</pre>";die();



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



	$sql = "select grievance_id,app_type_id,person_name,park_name,email,hno,address,ward_id,street_id,mobile,cat3_id,comp_desc,grievance_origin_id,grievance_status_id,date_regd,file_no,endorsement,mcat3_id,file_url,grievance_at_emp_level from grievances where grievance_id='" . $_POST['grievance_id'] . "' and ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		$field_info = mysqli_fetch_fields($rs);

		$row = mysqli_fetch_assoc($rs);

		foreach ($field_info as $fi => $f)

			$data1[$f->name] = $row[$f->name];
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

		$grievance_at_emp_level= $row['grievance_at_emp_level'];
		//echo $grievance_at_emp_level;



	$sql = "select * from category3_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	$rs = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($rs)) {

		$cat3_list[$row['cs_id']] = $row['comp_desc'];
	}



	$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$emp_list[$row['emp_id']]['emp_id'] = $row['emp_id'];

			$emp_list[$row['emp_id']]['emp_name'] = $row['emp_name'];

			$emp_list[$row['emp_id']]['emp_dept'] = $row['emp_dept'];

			$emp_list[$row['emp_id']]['emp_desg'] = $row['emp_desg'];

			$emp_list[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
		}
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));



	$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od where ulbid='" . $_SESSION['ulbid'] . "'";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($row = mysqli_fetch_assoc($rs)) {

			$emp_list[$row['emp_id']]['emp_id'] = $row['emp_id'];

			$emp_list[$row['emp_id']]['emp_name'] = $row['emp_name'];

			$emp_list[$row['emp_id']]['emp_dept'] = $row['emp_dept'];

			$emp_list[$row['emp_id']]['emp_desg'] = $row['emp_desg'];

			$emp_list[$row['emp_id']]['emp_mobile'] = $row['emp_mobile'];
		}
	} else

		printf("Errormessage: %s\n", mysqli_error($conn));

	try {
		
		if (isset($_POST['save'])) {
						
			if(	!validateField($_POST['app_type_id'],'dnumber')['valid'] || 
				!validateField($_POST['disposed_date'],'date')['valid'] || 				
				!validateField($_POST['fileToUpload'],'image')['valid'] || 				
				!validateField($_POST['rca'],'sptext')['valid'] || 				
				!validateField($_POST['disposal_remarks'],'sptext')['valid'] || 
				!validateField($_POST['ca'],'sptext')['valid'] ){
				
				$msg  = "Enter Valid Action Taken/Corrective Action/Root Cause Anlysis fields of Grievance id = " . $_POST['grievance_id'];
				$class = "alert alert-danger display-hide";
				set_flash($msg,$class);
				header('Location: manage_comp.php');
				exit;
				
			}else{
				
				$msg= 'checking';
				$class = "alert alert-danger display-hide";
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
						$class = "alert alert-danger display-hide";
						$uploadOk = 0;
					}

					// Allow certain file formats

					if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {

						$msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
						$class = "alert alert-danger display-hide";
						$uploadOk = 0;
					}

					// Check if $uploadOk is set to 0 by an error

					if ($uploadOk == 0) {

						//echo "Sorry, your file was not uploaded.";

						// if everything is ok, try to upload file

					} else {

						$temp = explode(".", $_FILES["fileToUpload"]["name"]);

						$newfilename = $temp[0] . '_' . $_POST['grievance_id'] . '_' . date('Y') . date('m') . date('d') . date('h') . date('i') . date('s') . '.' . end($temp);
						$newfilename =strtolower(str_replace(" ","_",$newfilename));
	//echo "<pre>";print_r($newfilename);echo "</pre>";die();
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
				
				//$dis_remark = str_replace("'", "", $_REQUEST['disposal_remarks']);
				$dis_remark =  $_REQUEST['disposal_remarks'];//str_replace("'", "", $_REQUEST['disposal_remarks']);
				
				$disposal_remarks = $dis_remark;//$dis_remark;
				$rca =  $dis_remark;//$_REQUEST['rca'];
				$ca =  $dis_remark;//$_REQUEST['ca'];
				
				$emp_id = $_REQUEST['emp_id'];
				$emp_dept = $_REQUEST['emp_dept'];
				$emp_desg = $_REQUEST['emp_desg'];

				$emp_lvl = $_REQUEST['emp_lvl'];
				if($emp_lvl == 'L1'){
					$emp_current_lvl = 'L2';
				}elseif($emp_lvl == 'L2'){
					$emp_current_lvl = 'L3';
				}elseif($emp_lvl == 'L3'){
					$emp_current_lvl = 'L4';
				}
				// cs list
				
				$sql = "select cs_id , cs_desc as  comp_desc from cs_mst";

				$rs = mysqli_query($conn, $sql);

				while ($row = mysqli_fetch_assoc($rs)) {

					$cs_list[$row['cs_id']] = $row['comp_desc'];
				}

				if (in_array($disposal_status,[5, 10])){

					$sql = "select grievance_status_id from grievances where grievance_id='" . $grievance_id . "'";
					$rss = mysqli_query($conn, $sql);
					$rws = 	mysqli_fetch_assoc($rss);
							
					if ($disposal_status == 5) {

						$curstatus = 5;
					} else{
						$curstatus = 10;
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
					desg_id,
					alloted_date,
					disposed_date,
					disposal_status,
					updated_by,
					emp_level,
					file_url
					)values(
					'" . $grievance_id . "',
					'" . $transaction_id . "',
					'" . $emp_id . "',
					'" . $emp_dept . "',
					'" . $emp_desg . "',
					'" . $disposed_date . "',
					'0000-00-00 00:00:00',
					'" . $curstatus . "',
					'" . $_SESSION['uid'] . "',
					'" . $emp_current_lvl . "',
					'" . $file_url . "'
					)";

					if (mysqli_query($conn, $sql)) {
						$sql = "update grievances set grievance_status_id='" . $curstatus . "',cutt_of_time = '" . $disposed_date . "',grievance_at_emp_level = '" . $emp_current_lvl . "' where grievance_id='" . $grievance_id . "' ";
						mysqli_query($conn, $sql);
					}
					if (mysqli_query($conn, $sql)) {
						$sql = "update grievances_transactions set disposed_date='" . $disposed_date . "',disposal_status='" . $curstatus . "',disposal_remarks='" . $disposal_remarks . "',updated_by='" . $_SESSION['uid'] . "',origin_id='3',rca='" . $rca . "',ca='" . $ca . "' where grievance_id='" . $grievance_id . "' and transaction_id='" . $transaction_id_old . "'";
						mysqli_query($conn, $sql);
					}

					// employee lists

					$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='" . $_SESSION['ulbid'] . "'";

					if ($rs = mysqli_query($conn, $sql)) {

						while ($row = mysqli_fetch_assoc($rs)) {

							$emp_list[$row['emp_id']]['emp_id'] = $row['emp_id'];

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
				}else {

					$sql = "select grievance_status_id from grievances where grievance_id='" . $grievance_id . "'";
					$rss = mysqli_query($conn, $sql);
					$rws = 	mysqli_fetch_assoc($rss);
									
					$sql = "update grievances_transactions set disposed_date='" . $disposed_date . "',disposal_status='" . $disposal_status . "',disposal_remarks='" . $disposal_remarks . "',updated_by='" . $_SESSION['uid'] . "',origin_id='3',rca='" . $rca . "',ca='" . $ca . "',file_url='" . $file_url . "' where grievance_id='" . $grievance_id . "' order by transaction_id DESC limit 1";
					
					if (mysqli_query($conn, $sql)) {
						$sql = "update grievances set grievance_status_id='" . $disposal_status . "' where grievance_id='" . $grievance_id . "'";
						//03-06-24 New Query $sql = "update grievances set g_emp_id='" . $emp_id . "' AND g_dept_id='" . $emp_dept . "' AND g_desg_id='" . $emp_desg . "' AND grievance_status_id='" . $disposal_status . "' where grievance_id='" . $grievance_id . "'";
						mysqli_query($conn, $sql);
					}
					//echo $sql;exit;
				} 

				if ($disposal_status == 5 || $disposal_status == 10) {

					$sms = "Dear " . substr($data1['person_name'], 0, 29) . ", Your Grievance regarding " . substr($cs_list[$data1['cat3_id']], 0, 29) . " with Ref No " . $grievance_id . " is transferred and allotted to " . substr($emp_list[$emp_id]['emp_name'], 0, 29) . " on date " . $disposed_date . " Regards- Citizen Service Monitoring Cell, NMCGOV";
					$mobile = $data1['mobile'];
					$templateId = "1707167653174818169";
					
					$result=sendSMS($mobile,$sms,$templateId);
					
					/* $message = str_replace(' ', '%20', $sms);
					$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
					//require_once('aurangabad_sms_config.php');

					$post = curl_init();
					curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($post, CURLOPT_URL, $url);
					curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
					$result = curl_exec($post); */
					
					$msg='Grievance ( ' . $grievance_id . ' ) Transferred Successfully..!';
					$class = "alert alert-success display-hide";
				
					
				} else if ($disposal_status == 101111) {

					$sms = "Dear " . substr($data1['person_name'], 0, 29) . " , Your Grievance regarding " . substr($cs_list[$data1['cat3_id']], 0, 29) . " with Ref No " . $grievance_id . " is rejected " . substr($disposal_remarks, 0, 29) . " and disposed Regards- Citizen Service Monitoring Cell, NMCGOV";
					$mobile = $data1['mobile'];
					$templateId = "1707167653187557130";
					
					$result=sendSMS($mobile,$sms,$templateId);
					
					/* $message = str_replace(' ', '%20', $sms);
					$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
					//require_once('aurangabad_sms_config.php');
					$post = curl_init();
					curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($post, CURLOPT_URL, $url);
					curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
					$result = curl_exec($post); */
					
				} else if ($disposal_status == 4) {
				} else if ($disposal_status == 9 || $disposal_status == 12) {

					$status_link = "https://nmcnagpur.gov.in/g1";
					//28-05-24 $sms = "Dear " . substr($data1['person_name'], 0, 29) . " , Your Grievance regarding " . substr($cs_list[$data1['cat3_id']], 0, 30) . " with Ref No " . $grievance_id . " is resolved on " . $disposed_date . " Regards - Citizen Service Monitoring Cell ,NMCGOV";
					$sms = "Dear " . substr($data1['person_name'], 0, 29) . ", Your Grievance regarding " . substr($cs_list[$data1['cat3_id']], 0, 30) . " with Ref No " . $grievance_id . " is resolved on " . $disposed_date . " Track your Application Status at " . $status_link . " Regards, NMCGOV";
					$mobile = $data1['mobile'];
					//28-05-24 $templateId = "1707167653168579049";
					$templateId = "1707171687709782022";
					
					/* $message = str_replace(' ', '%20', $sms);
					//28-05-24 $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
					//04-07-2024 $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message . "status_link=" . $status_link;
					$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
					//require_once('aurangabad_sms_config.php');
					$post = curl_init();
					curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($post, CURLOPT_URL, $url);
					curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
					$result = curl_exec($post); */
					$msg='Grievance( ' . $grievance_id . ' ) Completed Successfully..!';
					$class = "alert alert-success display-hide";
					$result=sendSMS($mobile,$sms,$templateId);
					
				}
				
				//echo "<script>alert('Updated Successfully..!'); window.location='manage_comp.php';</script>";
			
				
				set_flash($msg,$class);
				header('Location: manage_comp.php');
				exit;
			}
		
		}
		
	} catch (Exception $e) {
		return $e->getMessage();
	}
	
	
	
} else {

		echo "<script>window.location='index.php';</script>";
}


