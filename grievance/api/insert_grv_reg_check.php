<?php
ini_set('display_errors', 0);

		require_once('../connection.php');
		require_once('../check_access_key.php');

		$conn = getconnection();	
		
		
		date_default_timezone_set('Asia/Calcutta');
		mysqli_query($conn, 'SET character_set_results=utf8');
		mysqli_query($conn, 'SET names=utf8');
		mysqli_query($conn, 'SET character_set_client=utf8');
		mysqli_query($conn, 'SET character_set_connection=utf8');
		mysqli_query($conn, 'SET character_set_results=utf8');
		mysqli_query($conn, 'SET collation_connection=utf8_general_ci');
		
		header("Content-Type: application/json");
				// Read the raw POST data
		$json = file_get_contents('php://input');

		// Decode the JSON data into a PHP associative array
		$data = json_decode($json, true);
$testmobile='8919820778';
//var_dump($data);
		
if ($data['street_id'] > 0) {

	if ($data['street_id'] != '' && $data['person_name'] != '' && $data['hno'] != '' && $data['address'] != '' && $data['mobile'] != '' && $data['cat3_id'] != '') {


		if ($data['access_key'] != '') {
			$check_access_key_status = ($access_key === $data['access_key']) ?  1 : 0;

			//echo $access_key;exit;
			if ($check_access_key_status != 1) {
				$response['status_code'] = 401;
				$response['message'] = 'unauthorized';
				echo json_encode($response);
				die;
			}
		} else {
			$response['status_code'] = 422;
			$response['message'] = 'Missing Access key';
			echo json_encode($response);
			die;
		}
		$apk_version = $data['apk_version'];
		require_once('check_version.php');

		date_default_timezone_set('Asia/Calcutta');
		//echo date('Y-m-d H:i:s');

		require_once('../send_sms.php');
		require_once('../sms_conf.php');


		$sql = "select ward_id,ward_desc from ward_mst where ulbid='" . $data['ulbid'] . "'";
		if ($rs = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($rs))
				$ward_list[$row['ward_id']] = $row['ward_desc'];
		} else
			printf("Errormessage: %s\n", mysqli_error($conn));

		$sql = "select street_id,street_desc from street_mst where ulbid='" . $data['ulbid'] . "' order by street_desc";
		if ($rs = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($rs))
				$street_list[$row['street_id']] = $row['street_desc'];
		}

		$sql = "select cs_id,cs_desc as comp_desc from cs_mst";
		$rs = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($rs)) {
			$cs_list[$row['cs_id']] = $row['comp_desc'];
		}



		$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='" . $data['ulbid'] . "'";
		if ($rs = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($rs)) {
				$emp_name_list[$row['emp_id']] = $row['emp_name'];
				$emp_dept_list[$row['emp_id']] = $row['emp_dept'];
				$emp_desg_list[$row['emp_id']] = $row['emp_desg'];
				$emp_mobile_list[$row['emp_id']] = $row['emp_mobile'];
			}
		}

		$sql = "select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od where ulbid='" . $data['ulbid'] . "'";
		if ($rs = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($rs)) {
				$emp_name_list[$row['emp_id']] = $row['emp_name'];
				$emp_dept_list[$row['emp_id']] = $row['emp_dept'];
				$emp_desg_list[$row['emp_id']] = $row['emp_desg'];
				$emp_mobile_list[$row['emp_id']] = $row['emp_mobile'];
			}
		}




		$dat = date('dmy');
		$target_dir = "../grievance/photos/" . $dat . "/";
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		chmod($target_dir, 0777);

		if ($_FILES["image"]["name"] != '') {
			$base = $_FILES["image"]["name"];

			$path = $_FILES["image"]["name"];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			if (!($ext == "jpg" || $ext == "png" || $ext == "PNG" || $ext == "JPG")) {

				die('Invalid file extension');
			}


			$target_file = $target_dir . time() . ".jpg";
			$file = time() . ".jpg";
			$binary = base64_decode($base);
			// header('Content-Type: image/jpeg; charset=utf-8');
			// echo 1;exit;
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				$target_file = "https://" . $_SERVER['HTTP_HOST'] . '/grievance/grievance/photos/' . $dat . '/' . $file;
				// $file_info = new finfo(FILEINFO_MIME_TYPE);
				$mime_types_array = array('image/jpeg', 'image/gif', 'image/bmp', 'image/gif', 'image/png');

				$finopath = $target_file;

		
			} else {
				$target_file = '#';
			}
		} else if ($data['image'] != '') {
			$base = $data['image'];
			$target_file = $target_dir . time() . ".jpg";
			$file = time() . ".jpg";
			$binary = base64_decode($base);
			header('Content-Type: image/jpeg; charset=utf-8');
		
			$target_file = "https://" . $_SERVER['HTTP_HOST'] . "/grievance/grievance/photos/" . $dat . '/' . $file;
		} else
			$target_file = '#';


		$sql = "select grievance_id from grievances where 
			app_type_id='1' and 
			person_name='" . $data['person_name'] . "' and 
			email='-' and 
			hno='" . $data['hno'] . "' and 
			address='" . $data['address'] . "' and 
			ward_id='" . $data['ward_id'] . "' and 
			street_id='" . $data['street_id'] . "' and 
			mobile='" . $data['mobile'] . "' and 
			comp_subject='" . $data['comp_subject'] . "' and 
			comp_desc='" . $data['comp_desc'] . "' and 
			grievance_origin_id='4' and 
			user_id='" . $data['imei'] . "' and 
			lat='" . $data['lat'] . "' and 
			lat='" . $data['lng'] . "' and 
			cat3_id='" . $data['cat3_id'] . "' and
			ulbid='" . $data['ulbid'] . "' and 
			tanker_type_id='" . $data['tanker_id'] . "'
			";

		$rs = mysqli_query($conn, $sql);
		$nr = mysqli_num_rows($rs);
		if ($nr > 0) {
			$msg = "Not Inserted";
		} else {

		$inputJSON = file_get_contents('php://input');
		$input = json_decode($inputJSON, true); // decode as associative array

			//echo $input;

			// Assign and sanitize inputs
			$app_type_id = '1';
			$person_name = $input['person_name'] ?? '';
			$email = $input['email'] ?? '';
			$hno = $input['hno'] ?? '';
			$address = $input['address'] ?? '';
			$ward_id = (int) ($input['ward_id'] ?? 0);
			$street_id = (int) ($input['street_id'] ?? 0);
			$mobile = $input['mobile'] ?? '';
			$comp_desc = $input['comp_desc'] ?? '';
			$grievance_origin_id = 4;
			$grievance_status_id = 1;
			$user_id = $input['imei'] ?? '';
			$lat = $input['lat'] ?? '';
			$lng = $input['lng'] ?? '';
			$file_url = $input['file_url'] ?? ''; // Assuming it's passed or previously uploaded
			$cat3_id = (int) ($input['cat3_id'] ?? 0);
			$mcat3_id = (int) ($input['cat3_id'] ?? 0);
			$sub_cat_id = (int) ($input['sub_cat_id'] ?? 0);
			$ulbid = $input['ulbid'] ?? '';
			$tanker_type_id = (int) ($input['tanker_id'] ?? 0);
			$device_os_id = (int) ($input['deviceOs'] ?? 0);
			$todaytime=date('Y-m-d H:i:s');
			// Prepare query
			$stmt = $conn->prepare("
				INSERT INTO grievances (
					app_type_id, person_name, email, hno, address,
					ward_id, street_id, mobile, comp_desc, grievance_origin_id,
					grievance_status_id, date_regd, user_id, lat, lng, file_url,
					cat3_id, mcat3_id, sub_cat_id, ulbid, tanker_type_id, device_os_id
				) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			");

			if (!$stmt) {
				throw new Exception("Prepare failed: " . $conn->error);
			}

			$stmt->bind_param(
				"sssssiissiisssssiiisis",
				$app_type_id, $person_name, $email, $hno, $address,
				$ward_id, $street_id, $mobile, $comp_desc, $grievance_origin_id,
				$grievance_status_id, $todaytime,$user_id, $lat, $lng, $file_url,
				$cat3_id, $mcat3_id, $sub_cat_id, $ulbid, $tanker_type_id, $device_os_id
			);

   			if ($stmt->execute()) {


				$grievance_id = mysqli_insert_id($conn);
				$sql = "select received from dashboard_count where app_type_id=1 and ulbid='" . $data['ulbid'] . "'";
				$rs = mysqli_query($conn, $sql);
				$rows = mysqli_fetch_assoc($rs);
				$received = $rows['received'] + 1;

				$sql = "update dashboard_count set received='" . $received . "' where app_type_id=1 and ulbid='" . $data['ulbid'] . "'";
				mysqli_query($conn, $sql);




				//Start of ULB response time report


				$ulbid = '';
				$cat3_id = '';
				$grievance_status_id = '';
				$date_regd = '';
				$disposed_date = '';
				$disposed_date = '';
				$response_time = '';
				$user_type = '';
				$dept_id = '';
				$merg_cs_id = '';
				$cs_type_id = '';

				$sql = "SELECT grievance_id,ulbid,cat3_id,grievance_status_id,app_type_id FROM `grievances` g where grievance_id=" . $grievance_id;
				//	echo $sql;exit;
				$rs = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($rs);

				//     $grievance_id=$row['grievance_id'];
				$ulbid = $row['ulbid'];
				$cat3_id = $row['cat3_id'];
				$grievance_status_id = $row['grievance_status_id'];





				//End of ULB response time report


				// calling api

				$sql = "select u.address as api_address,ulb_type_desc,ulbname,api_ulbname,access_key,lat,lng from ulb_type ut,ulbmst u where ut.ulb_type_id=u.ulb_type and u.ulbid='" . $data['ulbid'] . "'";
				$rs = mysqli_query($conn, $sql);
				$ulb_info = mysqli_fetch_assoc($rs);

				$sql = "select swatchta_app_status_yn,swapp_cat_id from cs_mst where cs_id='" . $data['cat3_id'] . "'";
				$rs = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($rs);
				$swatchta_app_status_yn = $row['swatchta_app_status_yn'];
				if ($row['swatchta_app_status_yn'] == '1') {


					$ch = curl_init();
					$data2 = array(
						'vendor_name' => $ulb_info['api_ulbname'],
						'access_key' => $ulb_info['access_key'],
						'mobileNumber' => $data['mobile'],
						'categoryId' => $row['swapp_cat_id'],
						'complaintLatitude' => $ulb_info['lat'],
						'complaintLongitude' => $ulb_info['lng'],
						'complaintLocation' => $ulb_info['api_address'],
						'complaintLandmark' => $ulb_info['api_address'],
						'fullName' => $data['person_name'],
						'userLatitude' => $data['lat'],
						'userLongitude' => $data['lng'],
						'userLocation' => trim($ulb_info['api_address']),
						'deviceOs' => 'external',
						'file' => $target_file,
						'complaintREQUESTedDate' => date("Y-m-d H:i:s")
					);


					curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/sbm/v1/REQUEST-complaint');
					curl_setopt($ch, CURLOPTdata, 1);
					curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
					curl_setopt($ch, CURLOPT_REQUESTFIELDS, $data2);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$output = curl_exec($ch);


					$arr = json_decode($output, TRUE);
					$generic_id = $arr['complaint']['generic_id'];
					//$complaint_id=substr($arr['complaint']['generic_id'],-7);
					$newarray = explode('C', $arr['complaint']['generic_id']);

					$complaint_id = $newarray[1];


					$sql = "update grievances set http_code='" . $arr['httpCode'] . "',code='" . $arr['code'] . "',generic_id='" . $arr['complaint']['generic_id'] . "',swatchta_app_status='1' where grievance_id='" . $grievance_id . "'";
					mysqli_query($conn, $sql);
				}



				$data = array('status_code' => '200', 'status_desc' => 'Complaint Registered Successfully With Grievance ID:' . $grievance_id);
		
				if ($data['dept_id'] == '3' && $data['ulbid'] == '052') {
					$sql1 = "SELECT emp_id1 as emp_id,dept_id  FROM water_tanker_emp_map WHERE  water_tank_id ='" . $data['tanker_id'] . "'  and ulbid='" . $data['ulbid'] . "'";
				} else {
					$sql1 = "SELECT ward_id,cs_id,emp_id,dept_id  FROM emp_map WHERE ward_id ='" . $data['ward_id'] . "'  and cs_id ='" . $data['cat3_id'] . "' and cs_type_id='1' and ulbid='" . $data['ulbid'] . "' and street_id='" . $data['street_id'] . "'";
				}

				$rs1 = mysqli_query($conn, $sql1);


				$aaa = 0;


				$sql = "select cs_id , cs_desc as  comp_desc from cs_mst";
				$rs = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($rs)) {
					$cs_list[$row['cs_id']] = $row['comp_desc'];
				}
				$complaintType = $cs_list[$data['cat3_id']];

				if (mysqli_num_rows($rs1) > 0) {

					$aaa = 1;

					$row1 = mysqli_fetch_assoc($rs1);
					$row1['emp_id'];


					$today = date("Y-m-d H:i:s");
					$grievance_id_sel = $grievance_id;
					$sql2 = "insert into grievances_transactions(grievance_id,transaction_id,emp_id,alloted_date,disposal_status,dept_id) values(" . $grievance_id_sel . ",1,'" . $row1['emp_id'] . "','" . $today . "',2,'" . $row1['dept_id'] . "')";



					if (mysqli_query($conn, $sql2)) {


						$sql = "update  grievances set sla_status='1',grievance_at_emp_level='L1' where grievance_id='" . $grievance_id . "'";
						mysqli_query($conn, $sql);

						$app_type_id = 1;
						$sql = "select under_progress_sla from dashboard_count where app_type_id='" . $app_type_id . "' and ulbid='" . $data['ulbid'] . "'";
						$rs = mysqli_query($conn, $sql);
						$rows = mysqli_fetch_assoc($rs);
						$under_progress_sla = $rows['under_progress_sla'] + 1;

						$sql = "update dashboard_count set under_progress_sla='" . $under_progress_sla . "' where app_type_id='" . $app_type_id . "' and ulbid='" . $data['ulbid'] . "'";
						mysqli_query($conn, $sql);




						if ($swatchta_app_status_yn == '1') {
							$ch = curl_init();
							$data3 = array(
								'statusId' => '3',
								'complaintId' => $complaint_id,
								'commentDescription' => 'Assigned to engineer',
								'deviceOs' => 'external',
								'vendor_name' => $ulb_info['ulbname'],
								'access_key' => $ulb_info['access_key'],
								'apiKey' => 'af4e61d75d2782a33eac7641e42bba6f'
							);


							curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/engineer/v1/complaint-status-update');
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
							curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
							curl_setopt($ch, CURLOPT_REQUESTFIELDS, http_build_query($data3));
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$output = curl_exec($ch);
							$arr = json_decode($output, TRUE);
							$sql = "update grievances_transactions set http_code='" . $arr['httpCode'] . "',code='" . $arr['code'] . "',id='" . $arr['complaint']['id'] . "' where grievance_id='" . $grievance_id . "'";
							mysqli_query($conn, $sql);
							$sql = "insert into swatchata_comp_status_map(generic_id,status_id,complaint_id)values('" . $generic_id . "','3','" . $arr['complaint']['id'] . "')";
							mysqli_query($conn, $sql);
							$sql = "update grievances set swatchta_app_status='3' where grievance_id='" . $grievance_id . "'";
							mysqli_query($conn, $sql);
						}

						$sql = "SELECT cutt_off_time FROM `comp_cutofdays_map` where cs_id='" . $data['cat3_id'] . "'";
						$rs = mysqli_query($conn, $sql);
						$rw = mysqli_fetch_assoc($rs);
						$targetDays = $rw['cutt_off_time'];

						$date = date('Y-m-d');

						$sql = "select * from comp_cutofdays_map";
						$rs = mysqli_query($conn, $sql);
						while ($rw = mysqli_fetch_assoc($rs)) {
							$cutofdates[$rw['cs_id']] = round($rw['cutt_off_time'] * 24 * 60);
						}
						$Date = date('Y-m-d H:i:s');

						$endTime = strtotime("+" . $cutofdates[$data['cat3_id']] . " minutes", strtotime(date('Y-m-d H:i:s')));

						$targetDate = date('d-m-Y H:i:s', $endTime);


						$sql = "select cs_id , cs_desc as  comp_desc from cs_mst";
						$rs = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_assoc($rs)) {
							$cs_list[$row['cs_id']] = $row['comp_desc'];
						}
						$complaintType = $cs_list[$_POST['cat3_id']];


						//$alloted_date = date('d-m-Y H:i:s', strtotime($_POST['alloted_date']));
						$alloted_date = date('d-m-Y H:i:s', strtotime($today));
						$sms = "Dear " . substr($emp_name_list[$row1['emp_id']], 0, 28) . ", A Grievance from " . mysqli_real_escape_string($conn, strip_tags(substr($data['person_name'], 0, 28))) . ", Mobile No. " . mysqli_real_escape_string($conn, strip_tags($data['mobile'])) . ", " . substr($complaintType, 0, 30) . " with Ref No " . $grievance_id_sel . " is allotted to you on " . $alloted_date . " https://nmcnagpur.gov.in/grievance/ Regards- CitizenServiceMonitoringCell ,NMCGOV";
						$mobile = !empty($testmobile)?$testmobile:$emp_mobile_list[$row1['emp_id']];
						$templateId = "1707167653152348289";
						$message = str_replace(' ', '%20', $sms);
						$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
						//require_once('aurangabad_sms_config.php');
						$post = curl_init();
						curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($post, CURLOPT_URL, $url);
						curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
						$result = curl_exec($post);
						$sql = "insert into sms_response_logs(
						grievance_id,
						mobile,
						sms_content,
						response_content,
						datetime
						)values(
						'" . $grievance_id . "',
						'" . $mobile . "',
						'" . $message . "',
						" . $result . ",
						'" . date('Y-m-d H:i:s') . "'
						)";
						mysqli_query($conn, $sql);

						
						$emp_name_mobile=substr($emp_name_list[$row1['emp_id']],0,16).'('.$emp_mobile_list[$row1['emp_id']].')';
					
						
						$sms1 = "Dear " . substr($data['person_name'], 0, 28) . ", Your Grievance regarding " . substr($complaintType, 0, 30) . " with Ref No " . substr($grievance_id_sel, 0, 30) . " was allotted to " . substr($emp_name_mobile, 0, 28) . " on " . date('d-m-Y H:i:s', strtotime($today)) . " is in process. Track your Application Status at ".substr("https://nmcnagpur.gov.in/g1",0,29)." Regards, NMCGOV";
						//echo "<br>";
						$templateId = "1707172138939247588";

						$mobile = !empty($testmobile)?$testmobile:$data['mobile'];

						$message = str_replace(' ', '%20', $sms1);
						$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
						//require_once('aurangabad_sms_config.php');
						$post = curl_init();
						curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($post, CURLOPT_URL, $url);
						curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
						$result = curl_exec($post);
						$sql = "insert into sms_response_logs(
						grievance_id,
						mobile,
						sms_content,
						response_content,
						datetime
						)values(
						'" . $grievance_id_sel . "',
						'" . $mobile . "',
						'" . $message . "',
						" . $result . ",
						'" . date('Y-m-d H:i:s') . "'
						)";
						mysqli_query($conn, $sql);

						/** closed ***/



						$sql2 = "update grievances set grievance_status_id=2 where grievance_id=" . $grievance_id_sel;
						mysqli_query($conn, $sql2);
					} else {

						$sms2 = "Dear " . substr($data['person_name'], 0, 5) . ", Thank you for using online Grievance Redressal system. Your Complaint has been successfully registered with reference number : " . $grievance_id . ". regarding " . substr($cs_list[$data['cat3_id']], 0, 28) . "," . substr($cs_list[$data['cat3_id']], 0, 5) . ", Regards - " . $ulb_info['ulbname'] . " ";

						$templateId = "1207161725758515114";

						send_sms($sms2, $data['mobile'], $templateId);
					}
				} 

			} else {
				$data = array('status_code' => '201', 'status_desc' => 'Please Try Again..!');
			}

		}
	} else {
		$data = array('status_code' => '201', 'status_desc' => 'Please Try Again..!');
	}
} else {
	$data = array('status_code' => '201', 'status_desc' => 'Please Select Street..!');
}
echo json_encode($data);
mysqli_close($conn);
?>