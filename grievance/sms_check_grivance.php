<?php

	try {
			//$sms1 = "Dear " . $_POST['person_name'] . ", Your Grievance regarding " . substr($complaintType, 0, 30) . " with Ref No " . substr($grievance_id, 0, 30) . " was allotted to " . $emp_name_list[$row1['emp_id']] . " on " . date('d-m-Y H:i:s') . " is in process. Track your Application Status at https://tinyurl.com/2bfw2y96 Regards, NMCGOV";
			
			$emobile='8919820778';
			$ename='Shaganti Ravikumar';
			
			$emp_name_mobile=substr($ename,0,10).'('.$emobile.')';
			
			$person_name='some person name';		
			
			$sms1 = "Dear " .  substr($person_name, 0, 20) . ", Your Grievance regarding " . substr("burning lights of the city", 0, 30) . " with Ref No " . substr("12345", 0, 30) . " was allotted to " . $emp_name_mobile . " on " . date('d-m-Y H:i:s') . " is in process. Track your Application Status at https://nmcnagpur.gov.in/grievance/complaint_form.php Regards, NMCGOV";

			$templateId = "1707172138939247588";

			$mobile = '8919820778';
						
			$message = str_replace(' ', '%20', $sms1);
					
			$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
			
			
			$post = curl_init();
			
			curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($post, CURLOPT_URL, $url);
			curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
			
			$result=curl_exec($post);
			
			if($result){
				echo "success  ".$result;
			}else{
				echo 'sorry';
			}
			
		} catch (Exception $e) {

			echo '</br> <b> Exception Message: ' . $e->getMessage() . '</b>';
		}


?>