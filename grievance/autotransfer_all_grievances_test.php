<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
require_once('connection.php');
error_reporting(0);
$conn=getconnection();
exit;

$grievances_id = 1987;
//$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2'  ORDER BY `grievance_id` DESC";
$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2'";

// selecting the grievanes from the the above query 
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
	$cs_id = $row['cat3_id'];
	$date_regd = $row['date_regd'];
	
	$sql ="SELECT * FROM `comp_cutofdays_map` WHERE `cs_id` = '".$cs_id."'";
	$rs2 = mysqli_query($conn,$sql);
	$row2  = mysqli_fetch_assoc($rs2);
	
	 $disposable_days = $row2['cutt_off_time'];
	if(!empty($disposable_days)){
	//$disposable_days = $disposable_days;
	
	$Date=date('Y-m-d H:i:s');
	$cutoffdays = round($row2['cutt_off_time'] * 24 * 60);
	$endTime = strtotime("+".$cutoffdays." minutes", strtotime($row['date_regd']));
	$disposed_date1 = date ( 'Y-m-d H:i:s' , $endTime );
	
	
	
	
	}else{
	//$disposed_date1 = 
	}
	
	//$Date = "2010-09-17"; 
	
	//$disposed_date1 = date('Y-m-d H:i:s', strtotime($date_regd. ' + '.$disposable_days.' days'));
	
	
	$disposed_date = strtotime($disposed_date1);
	
	$todayDate = strtotime(date('Y-m-d H:i:s'));
	
	
	if($disposed_date < $todayDate){
	
	$sql ="update grievances set sla_status = '2', cutt_of_time='".$disposed_date1."' where grievance_id = '".$row['grievance_id']."'";
	mysqli_query($conn,$sql);
	echo "<br>";
	
	
	}
	
	
	
	
	
}



$sql ="select * from cs_mst";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
	
	$cs_list[$row['cs_id']] = $row['cs_desc'];
	
}

$link ="https://https://www.nmcnagpur.gov.in//grievance/";

$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` LIKE '2' and sla_status = 2  and grievance_at_emp_level NOT IN('L4') ORDER BY `grievance_id` DESC"; 

$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
	if($row['grievance_at_emp_level'] == 'L1')
	{


		 $disposed_date = strtotime(date('Y-m-d H:i:s', strtotime($row['cutt_of_time'])));
	     $todayDate = strtotime(date('Y-m-d H:i:s'));
	
	
			if($disposed_date < $todayDate){
			
				
			$sql ="update grievances set sla_status = '2', grievance_at_emp_level='L2'  where grievance_id = '".$row['grievance_id']."'";
			mysqli_query($conn,$sql);
		 $sql ="select * from emp_map em, emp_mst e where em.emp_id=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn,$sql);
			$emp1 = mysqli_fetch_assoc($rs2);
			
			
			
			if(count($emp1) <=0)
			{
				echo $sql ="select * from emp_map em, emp_mst_od e where em.emp_id=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
			    $rs2 = mysqli_query($conn,$sql);
			    $emp1 = mysqli_fetch_assoc($rs2);
			}
			
			
			
			
			$sql ="select * from emp_map em, emp_mst e where em.emp_id2=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn,$sql);
			$emp2 = mysqli_fetch_assoc($rs2);
			
			if(count($emp2) <=0)
			{
				$sql ="select * from emp_map em, emp_mst_od e where em.emp_id2=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
			    $rs2 = mysqli_query($conn,$sql);
			    $emp2 = mysqli_fetch_assoc($rs2);
			}
			
			
			
			
			
		
			
			
			// Get latest record of that grievance from grievance transactions table
			
			$sql ="select * from  `grievances_transactions`  WHERE `grievance_id` = '".$row['grievance_id']."'  order by transaction_id desc limit 1";
			$rs3 = mysqli_query($conn,$sql);
			$row3 = mysqli_fetch_assoc($rs3);
			$trnsid = $row3['transaction_id'] + 1;
			
			
			
			/** get allotted date ***/
			
			$sql ="SELECT * FROM `grievances_transactions` WHERE `grievance_id` = '".$row['grievance_id']."' and disposal_status=2 and emp_id='".$emp1['emp_id']."'";
			$rs2 = mysqli_query($conn,$sql);
			$preveious_employee_allotteddate = mysqli_fetch_assoc($rs2);
			// get allotted date 
			
			
			
			
			
			
			// Transfering grievance to level 2 employee
			
			$sql ="update `grievances_transactions` set disposal_status ='5' , disposed_date='".date('Y-m-d H:i:s')."' WHERE `grievance_id` = '".$row['grievance_id']."'  AND `disposal_status` = 2";
			if(mysqli_query($conn,$sql)){
			$sql ="insert into grievances_transactions(
			
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
			
			'".$row['grievance_id']."',
			'".$trnsid."',
			'".$emp2['emp_id2']."',
			'".$emp2['dept_id']."',
			'".$emp2['desg_id']."',
			'".date('Y-m-d H:i:s')."',
			'0000-00-00 00:00:00',
			'2',
			'autoallotted',
			'2',
			'System',
			'1'
			)";
			
			if(mysqli_query($conn,$sql))
			{
		// send sms to L2 employee
		
		            echo $sms ="Dear ".$emp2['emp_name'].", Complaint from ".$row['person_name'].", Mobile No. ".$row['mobile'].",regarding ".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was alloted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved https://www.nmcnagpur.gov.in//grievance/ Regards - Citizen Service Monitoring Cell ,AMCORP";
					$mobile=$emp2['emp_mobile'];
				    $templateId = "1707166305992205791";
				    $message =str_replace ( ' ', '%20', $sms);
				    $url ="http://smsatm.net/v3/api.php?username=ASCDCL&apikey=c01f32640f54e44f7660&senderid=AMCGOV&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
				    //require_once('aurangabad_sms_config.php');
				    $post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post); //result from mobile seva server
					
					
		
		
		
			}
			}
			
			
			
			}else{
			echo "in sla with level 1 employee";
			}

	}
	else if($row['grievance_at_emp_level'] == 'L2'){
	
	        $sql ="select * from emp_map em, emp_mst e where em.emp_id2=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn,$sql);
			$emp1 = mysqli_fetch_assoc($rs2);
	/** get allotted date ***/
			
			$sql ="SELECT * FROM `grievances_transactions` WHERE `grievance_id` = '".$row['grievance_id']."' and disposal_status=2 and emp_id='".$emp1['emp_id2']."'";
			$rs2 = mysqli_query($conn,$sql);
			$preveious_employee_allotteddate = mysqli_fetch_assoc($rs2);
			// get allotted date 
		
		 
		 $sql ="SELECT * FROM `level_disposabledays_map` WHERE `cs_id` LIKE '".$row['cat3_id']."'";
		 $rs2 = mysqli_query($conn,$sql);
		 $disposabledays = mysqli_fetch_assoc($rs2);
		 //$total_disposable_days = $disposabledays['L1'] + $disposabledays['L2'];
		 $total_disposable_days =  $disposabledays['L2'];
		 
		 
		    $cutoffdays = round($total_disposable_days * 24 * 60);
		 
			echo $preveious_employee_allotteddate['alloted_date'];
			
			
			
			  
		      $endTime = strtotime("+".$cutoffdays." minutes", strtotime($preveious_employee_allotteddate['alloted_date']));
		    
		     $disposed_date = date ( 'Y-m-d H:i:s' , $endTime );
			 
			 
			  
			  
		 
		 
		 
		 
		 
		 
         /*$disposed_date = date('Y-m-d H:i:s', strtotime($row['date_regd']. ' + '.$total_disposable_days.' days'));*/
		 $disposed_date = strtotime($disposed_date);
	     $todayDate = strtotime(date('Y-m-d H:i:s'));
	
	
			if($disposed_date < $todayDate){
			
				
			$sql ="update grievances set sla_status = '2', grievance_at_emp_level='L3'  where grievance_id = '".$row['grievance_id']."'";
			mysqli_query($conn,$sql);
			
			/** getting present employee details and next level employee details ***/
			
			
			
			
			
			$sql ="select * from emp_map em, emp_mst e where em.emp_id3=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn,$sql);
			$emp2 = mysqli_fetch_assoc($rs2);
			
			if(count($emp2) <=0)
			{
				$sql ="select * from emp_map em, emp_mst_od e where em.emp_id3=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
				$rs2 = mysqli_query($conn,$sql);
				$emp2 = mysqli_fetch_assoc($rs2);
			}
			
			
			/*** close ***/
			
			
			$sql ="select * from  `grievances_transactions`  WHERE `grievance_id` = '".$row['grievance_id']."'  order by transaction_id desc limit 1";
			$rs3 = mysqli_query($conn,$sql);
			$row3 = mysqli_fetch_assoc($rs3);
			$trnsid = $row3['transaction_id'] + 1;
			
			
			
			
		
			
			
			// Transfering grievance to level 3 employee
			
			$sql ="update `grievances_transactions` set disposal_status ='5' , disposed_date='".date('Y-m-d H:i:s')."' WHERE `grievance_id` = '".$row['grievance_id']."'  AND `disposal_status` = 2";
			
		    
			
			
			
			/** close allotted date ***/
			
			
			if(mysqli_query($conn,$sql)){
			$sql ="insert into grievances_transactions(
			
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
			
			'".$row['grievance_id']."',
			'".$trnsid."',
			'".$emp2['emp_id3']."',
			'".$emp2['dept_id']."',
			'".$emp2['desg_id']."',
			'".date('Y-m-d H:i:s')."',
			'0000-00-00 00:00:00',
			'2',
			'autoallotted',
			'2',
			'System',
			'1'
			)";
			
			if(mysqli_query($conn,$sql))
			{
		
		
		
					// send sms to L2 employee
		
		            echo $sms ="Dear ".$emp2['emp_name'].", Complaint from ".$row['person_name'].", Mobile No. ".$row['mobile'].",regarding ".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was alloted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved https://www.nmcnagpur.gov.in//grievance/ Regards - Citizen Service Monitoring Cell ,AMCORP";
					$mobile=$emp2['emp_mobile'];
				    $templateId = "1707166305992205791";
				    $message =str_replace ( ' ', '%20', $sms);
				    $url ="http://smsatm.net/v3/api.php?username=ASCDCL&apikey=c01f32640f54e44f7660&senderid=AMCGOV&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
				    //require_once('aurangabad_sms_config.php');
				    $post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post); //result from mobile seva server
					
					
		
			}
			
			
			
			}
		}else{
		echo "in sla with level 2";
		}
	}
	else if($row['grievance_at_emp_level'] == 'L3'){
	
	$sql ="select * from emp_map em, emp_mst e where em.emp_id3=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn,$sql);
			$emp1 = mysqli_fetch_assoc($rs2);
	/** get allotted date ***/
			
			 $sql ="SELECT * FROM `grievances_transactions` WHERE `grievance_id` = '".$row['grievance_id']."' and disposal_status=2 and emp_id='".$emp1['emp_id3']."'";
			$rs2 = mysqli_query($conn,$sql);
			$preveious_employee_allotteddate = mysqli_fetch_assoc($rs2);
			// get allotted date 
		
		 
		 $sql ="SELECT * FROM `level_disposabledays_map` WHERE `cs_id` LIKE '".$row['cat3_id']."'";
		 $rs2 = mysqli_query($conn,$sql);
		 $disposabledays = mysqli_fetch_assoc($rs2);
		 //$total_disposable_days = $disposabledays['L1'] + $disposabledays['L2'];
		 $total_disposable_days =  $disposabledays['L3'];
		 
		 
		 $cutoffdays = round($total_disposable_days * 24 * 60);
			 
			  
		     $endTime = strtotime("+".$cutoffdays." minutes", strtotime($preveious_employee_allotteddate['alloted_date']));
		    
		      echo $disposed_date = date ( 'Y-m-d H:i:s' , $endTime ); 
			  
			  
		 
		 
		 
		 
		 
		 
         /*$disposed_date = date('Y-m-d H:i:s', strtotime($row['date_regd']. ' + '.$total_disposable_days.' days'));*/
		 $disposed_date = strtotime($disposed_date);
	     $todayDate = strtotime(date('Y-m-d H:i:s'));
	
	
			if($disposed_date < $todayDate){
			
				
			$sql ="update grievances set sla_status = '2', grievance_at_emp_level='L4'  where grievance_id = '".$row['grievance_id']."'";
			mysqli_query($conn,$sql);
			
			/** getting present employee details and next level employee details ***/
			
			
			
			
			
			$sql ="select * from emp_map em, emp_mst e where em.emp_id4=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn,$sql);
			$emp2 = mysqli_fetch_assoc($rs2);
			
			if(count($emp2)<=0)
			{
				$sql ="select * from emp_map em, emp_mst_od e where em.emp_id4=e.emp_id and ward_id='".$row['ward_id']."' and street_id='".$row['street_id']."' and cs_id='".$row['cat3_id']."' and cs_type_id='1' ";
			$rs2 = mysqli_query($conn,$sql);
			$emp2 = mysqli_fetch_assoc($rs2);
			}
			
			
			/*** close ***/
			
			
			$sql ="select * from  `grievances_transactions`  WHERE `grievance_id` = '".$row['grievance_id']."'  order by transaction_id desc limit 1";
			$rs3 = mysqli_query($conn,$sql);
			$row3 = mysqli_fetch_assoc($rs3);
			$trnsid = $row3['transaction_id'] + 1;
			
			
			
			
		
			
			
			// Transfering grievance to level 3 employee
			
			$sql ="update `grievances_transactions` set disposal_status ='5' , disposed_date='".date('Y-m-d H:i:s')."' WHERE `grievance_id` = '".$row['grievance_id']."'  AND `disposal_status` = 2";
			
		    
			
			
			
			/** close allotted date ***/
			
			
			if(mysqli_query($conn,$sql)){
			$sql ="insert into grievances_transactions(
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
			
			'".$row['grievance_id']."',
			'".$trnsid."',
			'".$emp2['emp_id4']."',
			'".$emp2['dept_id']."',
			'".$emp2['desg_id']."',
			'".date('Y-m-d H:i:s')."',
			'0000-00-00 00:00:00',
			'2',
			'autoallotted',
			'2',
			'System',
			'1'
			)";
			
			if(mysqli_query($conn,$sql))
			{
		
		
		
					// send sms to L2 employee
		
		            echo $sms ="Respected Sir, Complaint from ".$row['person_name'].", Mobile No. ".$row['mobile'].",regarding ".$cs_list[$row['cat3_id']]." with Ref No : ".$row['grievance_id']." was alloted to ".$emp1['emp_name']." on ".date('d-m-Y H:i:s',strtotime($preveious_employee_allotteddate['alloted_date']))." is not resolved https://www.nmcnagpur.gov.in//grievance/ Regards - Citizen Service Monitoring Cell ,AMCORP";
					$mobile=$emp2['emp_mobile'];
				    $templateId = "1707166306033419058";
				    $message =str_replace ( ' ', '%20', $sms);
				    $url ="http://smsatm.net/v3/api.php?username=ASCDCL&apikey=c01f32640f54e44f7660&senderid=AMCGOV&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
				    //require_once('aurangabad_sms_config.php');
				    $post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post); //result from mobile seva server
					
					
		
			}
			
			
			
			}
		}else{
		echo "in sla with level 3";
		}
	}
}


?>