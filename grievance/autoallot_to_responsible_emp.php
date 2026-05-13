<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
require_once('connection.php');
error_reporting(0);
$conn = getconnection();

//exit;
//$grievances_id='14447';
$sql = "SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2'";
//$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2' and grievance_id='".$grievances_id."'";
$base_url = "https://www.nmcnagpur.gov.in/grievance/";
echo "<br>";
// selecting the grievanes from the the above query 
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
	$grievances_id = $row['grievances_id'];
	$cs_id = $row['cat3_id'];
	$date_regd = $row['date_regd'];

	$sql = "SELECT * FROM `comp_cutofdays_map` WHERE `cs_id` = '" . $cs_id . "'";
	$rs2 = mysqli_query($conn, $sql);
	$row2  = mysqli_fetch_assoc($rs2);

	$disposable_days = $row2['cutt_off_time'];
	if (!empty($disposable_days)) {
		//$disposable_days = $disposable_days;

		$Date = date('Y-m-d H:i:s');
		$cutoffdays = round($row2['cutt_off_time'] * 24 * 60);
		$endTime = strtotime("+" . $cutoffdays . " minutes", strtotime($row['date_regd']));
		echo $disposed_date1 = date('Y-m-d H:i:s', $endTime);

		//need to check disposed date here


	} else {
		//$disposed_date1 = 
	}

	//$Date = "2010-09-17"; 

	//$disposed_date1 = date('Y-m-d H:i:s', strtotime($date_regd. ' + '.$disposable_days.' days'));


	echo $disposed_date = strtotime($disposed_date1);

	echo $todayDate = strtotime(date('Y-m-d H:i:s'));

	echo "hi";
	if ($disposed_date < $todayDate) {

		echo $sql = "update grievances set sla_status = '2', cutt_of_time='" . $disposed_date1 . "' where grievance_id = '" . $row['grievance_id'] . "'";
		mysqli_query($conn, $sql);
		echo "<br>";
	}
}



$sql = "select * from cs_mst";
$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
	$cs_list[$row['cs_id']] = $row['cs_desc'];
}

//$link = "https://aurangabadmahapalika.org/csms/";
$link = "https://www.nmcnagpur.gov.in/grievance/";

echo $sql = "SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2' and sla_status = 2  and is_test_done = '0' ";

$rs = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($rs)) {
	$grievances_id = $row['grievance_id'];
	//echo $row['grievance_at_emp_level'] . "entry level";
	if ($row['grievance_at_emp_level'] == 'L1') {
		echo "from l1 to l2 <br>";

		$disposed_date = strtotime(date('Y-m-d H:i:s', strtotime($row['cutt_of_time'])));
		date_default_timezone_set('Asia/Calcutta');
		$todayDate = strtotime(date('Y-m-d H:i:s'));
		echo date('Y-m-d H:i:s', $disposed_date);
		echo "gg";
		echo date('Y-m-d H:i:s', $todayDate);
		// $source = '2012-07-31';
		// $date = new DateTime($source);
		// echo $date->format('d.m.Y'); // 31.07.2012
		// echo $date->format('d-m-Y'); // 31-07-2012


		if ($disposed_date < $todayDate) {


			$sql = "update grievances set sla_status = '2', grievance_at_emp_level='L2' where grievance_id = '" . $row['grievance_id'] . "'";
			mysqli_query($conn, $sql);
			$sql = "select * from emp_map em, emp_mst e where em.emp_id=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn, $sql);
			$emp1 = mysqli_fetch_assoc($rs2);


			$sql = "select * from emp_map em, emp_mst e where em.emp_id2=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn, $sql);
			$emp2 = mysqli_fetch_assoc($rs2);








			// Get latest record of that grievance from grievance transactions table

			$sql = "select * from `grievances_transactions` WHERE `grievance_id` = '" . $row['grievance_id'] . "'  order by transaction_id desc limit 1";
			$rs3 = mysqli_query($conn, $sql);
			$row3 = mysqli_fetch_assoc($rs3);
			$trnsid = $row3['transaction_id'] + 1;



			/** get allotted date ***/

			$sql = "SELECT * FROM `grievances_transactions` WHERE `grievance_id` = '" . $grievances_id . "' and disposal_status=2 and emp_id='" . $emp1['emp_id'] . "'";
			$rs2 = mysqli_query($conn, $sql);
			$preveious_employee_allotteddate = mysqli_fetch_assoc($rs2);
			// get allotted date 


			// Transfering grievance to level 2 employee

			$sql = "update `grievances_transactions` set disposal_status='5' , is_escalated ='1' , disposed_date='" . date('Y-m-d H:i:s') . "' WHERE `grievance_id` = '" . $row['grievance_id'] . "'  AND `disposal_status` = 2";
			if (mysqli_query($conn, $sql)) {
				$sql = "insert into grievances_transactions(		
			grievance_id,
			transaction_id,
			emp_id,
			dept_id,
			desg_id,
			alloted_date,
			disposed_date,
			disposal_status,
			disposal_remarks,
			update_status,
			updated_by,
			origin_id
			)values(
			
			'" . $row['grievance_id'] . "',
			'" . $trnsid . "',
			'" . $emp2['emp_id2'] . "',
			'" . $emp2['dept_id'] . "',
			'" . $emp2['desg_id'] . "',
			'" . date('Y-m-d H:i:s') . "',
			'0000-00-00 00:00:00',
			'2',
			'Auto Allotted',
			'2',
			'System',
			'1'
			)";

				if (mysqli_query($conn, $sql)) {
					// send sms to L2 employee
					/*********sms strarts**************/
					// // echo $sms = "Dear ".$emp2['emp_name'].", Complaintfrom ".$row['person_name'].", Mobile No ".$row['mobile'].",regarding".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was allotted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is notresolved ".$base_url."Regards - Citizen ServiceMonitoring Cell ,NMCGOV";
					// // echo $sms = "Dear ".$emp2['emp_name'].", Complaint from ".$row['person_name'].", Mobile No ".$row['mobile']." , regarding ".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was allotted to  ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved ".$base_url." Regards- Citizen Service Monitoring Cell, NMCGOV";
					// $mobile=$emp2['emp_mobile'];
					// echo $sms = "Dear ".$emp2['emp_name'].", Complaint from ".$row['person_name'].", Mobile No ".$row['mobile']." , regarding ".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was allotted to  ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved ".$base_url."Regards- Citizen Service Monitoring Cell, NMCGOV";

					// // $mobile = '9492815677';
					// // $templateId = "1707166305992205791";
					// $templateId = "1707167653156033634";
					// $message = str_replace(' ', '%20', $sms);
					// $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
					// //require_once('aurangabad_sms_config.php');
					// $post = curl_init();
					// curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
					// curl_setopt($post, CURLOPT_URL, $url);
					// curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
					// $result = curl_exec($post); //result from mobile seva server

					$alloted_date = date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date']));
					//18-07-2024 echo $sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . $row['mobile'] . " , regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to " . substr($emp1['emp_name'], 0, 29) . " on " . date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date'])) . " is not resolved " . $base_url . "Regards- Citizen Service Monitoring Cell, NMCGOV";
					$sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . $row['mobile'] . " , regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to " . substr($emp1['emp_name'], 0, 29) . " on " . $alloted_date . " is not resolved " . $base_url . "Regards- Citizen Service Monitoring Cell, NMCGOV";
					$mobile = $emp2['emp_mobile'];
					// $templateId = "1707166305992205791";
					//01-08-2024 Dhanraj $templateId = "1707167653156033634";
					$templateId = "1707171326612386383";
					$message = str_replace(' ', '%20', $sms);
					$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
					//require_once('aurangabad_sms_config.php');
					$post = curl_init();
					curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($post, CURLOPT_URL, $url);
					curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
					$result = curl_exec($post); //result from mobile seva server
					/*********sms strarts**************/
					$sql = "insert into sms_response_logs(
					grievance_id,
					mobile,
					sms_content,
					response_content,
					datetime
					)values(
					'" . $row['grievance_id'] . "',
					'" . $mobile . "',
					'" . $message . "',
					" . $result . ",
					'" . date('Y-m-d H:i:s') . "'
					)";
					mysqli_query($conn, $sql);


					exit;
				}
			}
		} else {
			echo "in sla with level 1 employee";
		}
	} else if ($row['grievance_at_emp_level'] == 'L2') {
		echo "<br> from l2 to l3 <br>";
		$sql = "select * from emp_map em, emp_mst e where em.emp_id2=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
		$rs2 = mysqli_query($conn, $sql);
		$emp1 = mysqli_fetch_assoc($rs2);
		/** get allotted date ***/

		$sql = "SELECT * FROM `grievances_transactions` WHERE `grievance_id` = '" . $grievances_id . "' and disposal_status=2 and emp_id='" . $emp1['emp_id2'] . "'";
		$rs2 = mysqli_query($conn, $sql);
		$preveious_employee_allotteddate = mysqli_fetch_assoc($rs2);
		// get allotted date 

		echo "<br> check 1 <br>";
		$sql = "SELECT * FROM `level_disposabledays_map` WHERE `cs_id` LIKE '" . $row['cat3_id'] . "'";
		$rs2 = mysqli_query($conn, $sql);
		$disposabledays = mysqli_fetch_assoc($rs2);
		//$total_disposable_days = $disposabledays['L1'] + $disposabledays['L2'];
		$total_disposable_days =  $disposabledays['L2'];

		echo "<br> check 2 <br>";

		$cutoffdays = round($total_disposable_days * 24 * 60);


		$endTime = strtotime("+" . $cutoffdays . " minutes", strtotime($preveious_employee_allotteddate['alloted_date']));

		$disposed_date = date('Y-m-d H:i:s', $endTime);


		/*$disposed_date = date('Y-m-d H:i:s', strtotime($row['date_regd']. ' + '.$total_disposable_days.' days'));*/
		$disposed_date = strtotime($disposed_date);
		$todayDate = strtotime(date('Y-m-d H:i:s'));

		echo $disposed_date . "<br>";
		echo $todayDate . "<br>";
		echo date('Y-m-d H:i:s', $disposed_date);
		echo "gg";
		echo date('Y-m-d H:i:s', $todayDate);

		echo "<br> check 3 <br>";

		if ($disposed_date < $todayDate) {


			$sql = "update grievances set sla_status = '2', grievance_at_emp_level='L3'  where grievance_id = '" . $row['grievance_id'] . "'";
			mysqli_query($conn, $sql);

			/** getting present employee details and next level employee details ***/



			echo "<br> check 4 <br>";

			$sql = "select * from emp_map em, emp_mst e where em.emp_id3=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn, $sql);
			$emp2 = mysqli_fetch_assoc($rs2);


			/*** close ***/
			echo "<br> check 5 <br>";

			$sql = "select * from  `grievances_transactions`  WHERE `grievance_id` = '" . $row['grievance_id'] . "'  order by transaction_id desc limit 1";
			$rs3 = mysqli_query($conn, $sql);
			$row3 = mysqli_fetch_assoc($rs3);
			$trnsid = $row3['transaction_id'] + 1;



			echo "<br> check 6 <br>";



			// Transfering grievance to level 3 employee

			echo $sql = "update `grievances_transactions` set disposal_status='5', is_escalated ='1' , disposed_date='" . date('Y-m-d H:i:s') . "' WHERE `grievance_id` = '" . $row['grievance_id'] . "'  AND `disposal_status` = 2";





			/** close allotted date ***/


			if (mysqli_query($conn, $sql)) {
				echo "<br> check 7 <br>";
				$sql = "insert into grievances_transactions(
    			
    			grievance_id,
    			transaction_id,
    			emp_id,
    			dept_id,
    			desg_id,
    			alloted_date,
    			disposed_date,
    			disposal_status,
    			disposal_remarks,
    			update_status,
    			updated_by,
    			origin_id
    			)values(
    			'" . $row['grievance_id'] . "',
    			'" . $trnsid . "',
    			'" . $emp2['emp_id3'] . "',
    			'" . $emp2['dept_id'] . "',
    			'" . $emp2['desg_id'] . "',
    			'" . date('Y-m-d H:i:s') . "',
    			'0000-00-00 00:00:00',
    			'2',
    			'Auto Allotted',
    			'2',
    			'System',
    			'1'
    			)";
				echo "<br> check 8 <br>";
				if (mysqli_query($conn, $sql)) {
					echo "<br> check final <br>";

					/*********sms strarts**************/
					// send sms to L3 employee

					// //  $sms ="Dear ".$emp2['emp_name'].", Complaint from ".$row['person_name'].", Mobile No. ".$row['mobile'].",regarding ".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was alloted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved aurangabadmahapalika.org/csms Regards - Citizen Service Monitoring Cell ,AMCORP";
					// // 	$sms ="Dear ".$emp2['emp_name'].", Complaintfrom ".$row['person_name'].", Mobile No ".$row['mobile'].",regarding".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was allotted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is notresolved aurangabadmahapalika.org/csmsRegards - Citizen ServiceMonitoring Cell ,NMCGOV";
					// // 	$sms = "Dear ".$emp2['emp_name'].", Complaintfrom ".$row['person_name'].", Mobile No ".$row['mobile'].",regarding".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was allotted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is notresolved aurangabadmahapalika.org/csmsRegards - Citizen ServiceMonitoring Cell ,NMCGOV";
					// // echo $sms = "Dear ".$emp2['emp_name']." , Complaintfrom ".$row['person_name']." , Mobile No. ".$row['mobile']." regarding".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was allotted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved ".$base_url."Regards - Citizen Service Monitoring Cell ,NMCGOV";
					// echo $sms = "Dear ".$emp2['emp_name'].", Complaint from ".$row['person_name'].", Mobile No ".$row['mobile'].", regarding ".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was allotted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved ".$base_url." Regards- Citizen Service Monitoring Cell, NMCGOV";
					// // $mobile = $emp2['emp_mobile'];
					// $mobile = '9492815677';
					// $templateId = "1707167653159897717";
					// $message =str_replace ( ' ', '%20', $sms);
					// $url ="http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
					// //require_once('aurangabad_sms_config.php');
					// $post = curl_init();
					// curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
					// curl_setopt($post, CURLOPT_URL, $url);
					// curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
					// $result=curl_exec($post); //result from mobile seva server

					$alloted_date = date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date']));
					// Dear {#var#}, Complaint from {#var#}, Mobile No {#var#}, regarding {#var#} with Ref No : {#var#} was allotted to {#var#} on {#var#} is not resolved {#var#} Regards- Citizen Service Monitoring Cell, NMCGOV
					// echo $sms = "Dear " . $emp2['emp_name'] . " , Complaintfrom " . $row['person_name'] . " , Mobile No. " . $row['mobile'] . " regarding" . $cs_list[$row['cat3_id']] . " with Ref No : " . $row['grievance_id'] . " was allotted to " . $emp1['emp_name'] . " on " . date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date'])) . " is not resolved " . $base_url . "Regards - Citizen Service Monitoring Cell ,NMCGOV";
					//18-07-2024 echo $sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . substr($row['mobile'], 0, 29) . ", regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to  " . substr($emp1['emp_name'], 0, 29) . " on " . date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date'])) . " is not resolved https://www.nmcnagpur.gov.in//grievance/ Regards- Citizen Service Monitoring Cell, NMCGOV";
					echo $sms = "Dear " . substr($emp2['emp_name'], 0, 29) . ", Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . substr($row['mobile'], 0, 29) . ", regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to  " . substr($emp1['emp_name'], 0, 29) . " on " . $alloted_date . " is not resolved https://www.nmcnagpur.gov.in//grievance/ Regards- Citizen Service Monitoring Cell, NMCGOV";
					$mobile = $emp2['emp_mobile'];
					// $mobile = '9492815677';
					//01-08-2024 Dhanraj $templateId = "1707167653159897717";
					$templateId = "1707171326612386383";
					$message = str_replace(' ', '%20', $sms);
					$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
					//require_once('aurangabad_sms_config.php');
					$post = curl_init();
					curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($post, CURLOPT_URL, $url);
					curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
					$result = curl_exec($post); //result from mobile seva server
					/*********sms ends**************/
					$sql = "insert into sms_response_logs(
					grievance_id,
					mobile,
					sms_content,
					response_content,
					datetime
					)values(
					'" . $row['grievance_id'] . "',
					'" . $mobile . "',
					'" . $message . "',
					" . $result . ",
					'" . date('Y-m-d H:i:s') . "'
					)";
					mysqli_query($conn, $sql);

					exit;
				}
			}
		} else {
			echo "in sla with level 2";
		}
	} else if ($row['grievance_at_emp_level'] == 'L3') {
		echo "from l3 to l4";
		$sql = "select * from emp_map em, emp_mst e where em.emp_id3=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
		$rs2 = mysqli_query($conn, $sql);
		$emp1 = mysqli_fetch_assoc($rs2);
		/** get allotted date ***/

		echo $sql = "SELECT * FROM `grievances_transactions` WHERE `grievance_id` = '" . $grievances_id . "' and disposal_status=2 and emp_id='" . $emp1['emp_id3'] . "'";
		$rs2 = mysqli_query($conn, $sql);
		$preveious_employee_allotteddate = mysqli_fetch_assoc($rs2);
		// get allotted date 


		$sql = "SELECT * FROM `level_disposabledays_map` WHERE `cs_id` LIKE '" . $row['cat3_id'] . "'";
		$rs2 = mysqli_query($conn, $sql);
		$disposabledays = mysqli_fetch_assoc($rs2);
		//$total_disposable_days = $disposabledays['L1'] + $disposabledays['L2'];
		$total_disposable_days =  $disposabledays['L3'];


		$cutoffdays = round($total_disposable_days * 24 * 60);


		$endTime = strtotime("+" . $cutoffdays . " minutes", strtotime($preveious_employee_allotteddate['alloted_date']));

		echo $disposed_date = date('Y-m-d H:i:s', $endTime);








		/*$disposed_date = date('Y-m-d H:i:s', strtotime($row['date_regd']. ' + '.$total_disposable_days.' days'));*/
		$disposed_date = strtotime($disposed_date);
		$todayDate = strtotime(date('Y-m-d H:i:s'));


		if ($disposed_date < $todayDate) {


			$sql = "update grievances set sla_status = '2', grievance_at_emp_level='L4', is_test_done = '1'  where grievance_id = '" . $row['grievance_id'] . "'";
			mysqli_query($conn, $sql);

			/** getting present employee details and next level employee details ***/





			$sql = "select * from emp_map em, emp_mst e where em.emp_id4=e.emp_id and ward_id='" . $row['ward_id'] . "' and street_id='" . $row['street_id'] . "' and cs_id='" . $row['cat3_id'] . "' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn, $sql);
			$emp2 = mysqli_fetch_assoc($rs2);


			/*** close ***/


			$sql = "select * from  `grievances_transactions`  WHERE `grievance_id` = '" . $row['grievance_id'] . "'  order by transaction_id desc limit 1";
			$rs3 = mysqli_query($conn, $sql);
			$row3 = mysqli_fetch_assoc($rs3);
			$trnsid = $row3['transaction_id'] + 1;







			// Transfering grievance to level 3 employee

			$sql = "update `grievances_transactions` set disposal_status='5' , is_escalated ='1' , disposed_date='" . date('Y-m-d H:i:s') . "' WHERE `grievance_id` = '" . $row['grievance_id'] . "'  AND `disposal_status` = 2";

			/** close allotted date ***/


			if (mysqli_query($conn, $sql)) {
				$sql = "insert into grievances_transactions(
			
			grievance_id,
			transaction_id,
			emp_id,
			dept_id,
			desg_id,
			alloted_date,
			disposed_date,
			disposal_status,
			disposal_remarks,
			update_status,
			updated_by,
			origin_id
			)values(
			
			'" . $row['grievance_id'] . "',
			'" . $trnsid . "',
			'" . $emp2['emp_id4'] . "',
			'" . $emp2['dept_id'] . "',
			'" . $emp2['desg_id'] . "',
			'" . date('Y-m-d H:i:s') . "',
			'0000-00-00 00:00:00',
			'2',
			'Auto Allotted',
			'2',
			'System',
			'1'
			)";

				if (mysqli_query($conn, $sql)) {
					/*********sms strarts**************/
					// send sms to L4 employee

					// //  $sms ="Respected Sir, Complaint from ".$row['person_name'].", Mobile No. ".$row['mobile'].",regarding ".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was alloted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved aurangabadmahapalika.org/csms Regards - Citizen Service Monitoring Cell ,AMCORP";

					// // 	echo $sms ="Respected Sir, Complaint from ".$row['person_name'].", Mobile No ".$row['mobile'].", regarding ".$cs_list[$row['cat3_id']]." with Ref No: ".$row['grievance_id']." was allotted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved ".$base_url."Regards - Citizen Service Monitoring Cell ,NMCGOV";
					// echo $sms ="Respected Sir, Complaint from ".$row['person_name'].", Mobile No ".$row['mobile'].", regarding {#var#} with Ref No : ".$cs_list[$row['cat3_id']]." was allotted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved ".$base_url." Regards- Citizen Service Monitoring Cell,NMCGOV";
					// $mobile=$emp2['emp_mobile'];
					// $templateId = "1707167653164540158";
					// $message =str_replace ( ' ', '%20', $sms);
					// $url ="http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
					// //require_once('aurangabad_sms_config.php');
					// $post = curl_init();
					// curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
					// curl_setopt($post, CURLOPT_URL, $url);
					// curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
					// $result=curl_exec($post); //result from mobile seva server

					// echo $sms ="Respected Sir, Complaint from ".$row['person_name'].", Mobile No ".$row['mobile'].", regarding ".$cs_list[$row['cat3_id']]." with Ref No: ".$row['grievance_id']." was allotted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved ".$base_url."Regards - Citizen Service Monitoring Cell ,NMCGOV";
					// echo $sms = "Respected Sir, Complaint from " . $row['person_name'] . ", Mobile No " . $row['mobile'] . ", regarding {#var#} with Ref No : " . $cs_list[$row['cat3_id']] . " was allotted to " . $emp1['emp_name'] . " on " . date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date'])) . " is not resolved " . $base_url . " Regards- Citizen Service Monitoring Cell,NMCGOV";

					$alloted_date = date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date']));
					//18-07-2024 echo $sms = "Respected Sir, Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . $row['mobile'] . ", regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to " . substr($emp1['emp_name'], 0, 29) . " on " . date('d-m-Y H:i:s', strtotime($preveious_employee_allotteddate['alloted_date'])) . " is not resolved https://www.nmcnagpur.gov.in//grievance/ Regards- Citizen Service Monitoring Cell, NMCGOV";
					echo $sms = "Respected Sir, Complaint from " . substr($row['person_name'], 0, 29) . ", Mobile No " . $row['mobile'] . ", regarding " . substr($cs_list[$row['cat3_id']], 0, 29) . " with Ref No : " . $row['grievance_id'] . " was allotted to " . substr($emp1['emp_name'], 0, 29) . " on " . $alloted_date . " is not resolved https://www.nmcnagpur.gov.in//grievance/ Regards- Citizen Service Monitoring Cell, NMCGOV";
					$mobile = $emp2['emp_mobile'];
					//01-08-2024 Dhanraj $templateId = "1707167653164540158";
					$templateId = "1707171326612386383";
					$message = str_replace(' ', '%20', $sms);
					$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
					//require_once('aurangabad_sms_config.php');
					$post = curl_init();
					curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($post, CURLOPT_URL, $url);
					curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
					$result = curl_exec($post); //result from mobile seva server


					/*********sms ends**************/
					$sql = "insert into sms_response_logs(
					grievance_id,
					mobile,
					sms_content,
					response_content,
					datetime
					)values(
					'" . $row['grievance_id'] . "',
					'" . $mobile . "',
					'" . $message . "',
					" . $result . ",
					'" . date('Y-m-d H:i:s') . "'
					)";
					mysqli_query($conn, $sql);

					exit;
				}
			}
		} else {
			echo "in sla with level 3";
		}
	}
}
