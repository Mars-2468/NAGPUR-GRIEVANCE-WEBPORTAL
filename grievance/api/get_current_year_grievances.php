<?php	
	error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');


	$ulbid='250';
	
	$grievances_trns_api="(SELECT gts.* FROM grievances_transactions gts INNER JOIN ( SELECT grievance_id, MAX(transaction_id) AS latest_transaction_id FROM grievances_transactions GROUP BY grievance_id ) latest_gt ON gts.grievance_id = latest_gt.grievance_id AND gts.transaction_id = latest_gt.latest_transaction_id and gts.emp_id!='')";
		
	date_default_timezone_set('Asia/Calcutta');

	$current_year_month_from = "2025-04-01";  
	$current_year_month_to = date('Y-m-d');  
	
	// Total grievances

	$sql = "SELECT 	
            count(DISTINCT g.grievance_id) AS count,g.app_type_id			
			FROM 		
				grievances g			
			JOIN " . $grievances_trns_api . " gt ON g.grievance_id = gt.grievance_id			
			WHERE 		
				g.ulbid = '" . $ulbid . "' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN (2,3,5,6,8,9,10,11,12,13) 
				AND gt.disposal_status IN (2,3,5,6,8,9,10,11,12,13) 
				AND g.cat3_id != 0 AND DATE_FORMAT(g.date_regd, '%Y-%m-%d') BETWEEN ? AND ?";

	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $current_year_month_from,$current_year_month_to);
	$stmt->execute();

	$rs = $stmt->get_result();

	$totalCount = 0;

	if ($rs && $row = $rs->fetch_assoc()) {
		$totalCount = (int)$row['count'];
	} 
 
	// Total Inprocess
	$sql = "SELECT 	
            count(DISTINCT g.grievance_id) AS count,g.app_type_id			
			FROM 		
				grievances g			
			JOIN " . $grievances_trns_api . " gt ON g.grievance_id = gt.grievance_id			
			WHERE 		
				g.ulbid = '" . $ulbid . "' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN (2,11) 		
				AND g.cat3_id != 0 AND DATE_FORMAT(g.date_regd, '%Y-%m-%d') BETWEEN ? AND ?";
				
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $current_year_month_from,$current_year_month_to);
	$stmt->execute();

	$rs = $stmt->get_result();

	$totalInprocess = 0;

	if ($rs && $row = $rs->fetch_assoc()) {
		$totalInprocess = (int)$row['count'];
	}  
	
 	/* $allCount = [
		'total_grievance_count' => $totalCount,
		'total_inprocess_count' => $totalInprocess
	]; */ 

// Total completed
 
 $sql = "SELECT 	
            count(DISTINCT g.grievance_id) AS count,g.app_type_id			
			FROM 		
				grievances g			
			JOIN " . $grievances_trns_api . " gt ON g.grievance_id = gt.grievance_id			
			WHERE 		
				g.ulbid = '" . $ulbid . "' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN (3,6,8,9,12,13) 		
				AND g.cat3_id != 0 AND DATE_FORMAT(g.date_regd, '%Y-%m-%d') BETWEEN ? AND ?";
				
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $current_year_month_from,$current_year_month_to);
	$stmt->execute();

	$rs = $stmt->get_result();

	$totalCompleted = 0;

	if ($rs && $row = $rs->fetch_assoc()) {
		$totalCompleted = (int)$row['count'];
	} 

// Total Rejected
	 $sql = "SELECT 	
            count(DISTINCT g.grievance_id) AS count,g.app_type_id			
			FROM 		
				grievances g			
			JOIN " . $grievances_trns_api . " gt ON g.grievance_id = gt.grievance_id			
			WHERE 		
				g.ulbid = '" . $ulbid . "' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN (4) 		
				AND g.cat3_id != 0 AND DATE_FORMAT(g.date_regd, '%Y-%m-%d') BETWEEN ? AND ?";
				
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $current_year_month_from,$current_year_month_to);
	$stmt->execute();

	$rs = $stmt->get_result();

	$totalRejected = 0;

	if ($rs && $row = $rs->fetch_assoc()) {
		$totalRejected = (int)$row['count'];
	}  
	
	
	
// Total Approval Pending
	 $sql = "SELECT 	
            count(DISTINCT g.grievance_id) AS count,g.app_type_id			
			FROM 		
				grievances g			
			JOIN " . $grievances_trns_api . " gt ON g.grievance_id = gt.grievance_id			
			WHERE 		
				g.ulbid = '" . $ulbid . "' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN (1) 		
				AND g.cat3_id != 0 AND DATE_FORMAT(g.date_regd, '%Y-%m-%d') BETWEEN ? AND ?";
				
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $current_year_month_from,$current_year_month_to);
	$stmt->execute();

	$rs = $stmt->get_result();

	$totalApprovalPending = 0;

	if ($rs && $row = $rs->fetch_assoc()) {
		$totalApprovalPending = (int)$row['count'];
	} 	
			
// Total Transferes 
	 $sql = "SELECT 	
            count(DISTINCT g.grievance_id) AS count,g.app_type_id			
			FROM 		
				grievances g			
			JOIN " . $grievances_trns_api . " gt ON g.grievance_id = gt.grievance_id			
			WHERE 		
				g.ulbid = '" . $ulbid . "' 
				AND g.app_type_id = '1' 
				AND g.grievance_status_id IN (5,10) 				
				AND g.cat3_id != 0 AND DATE_FORMAT(g.date_regd, '%Y-%m-%d') BETWEEN ? AND ?";
				
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $current_year_month_from,$current_year_month_to);
	$stmt->execute();

	$rs = $stmt->get_result();

	$totalTransfers = 0;

	if ($rs && $row = $rs->fetch_assoc()) {
		$totalTransfers = (int)$row['count'];
	}  
	
	
	
	
 	$allCount = [
		'total_grievance_count' => $totalCount,
		'total_inprocess_count' => $totalInprocess,
		'total_completed_count' => $totalCompleted,
		//'total_approval_pending_count' => $totalApprovalPending,
		'total_rejected_count' => $totalRejected,		
		'total_transfers_count' => $totalTransfers,
	]; 

	
	//echo "<pre>";print_r($allCount);echo "<pre>"; die();
	
	echo json_encode($allCount);
	
	mysqli_close($conn);	

?>