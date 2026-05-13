<?php
	ini_set('display_errors', 0);
	session_start();
	require_once('../connection.php');
	$conn=getconnection();
 

//echo json_encode($_REQUEST['filteryear']); 	

$selectedYear = isset($_REQUEST['filteryear'])?$_REQUEST['filteryear']:'';

/* $sql = "
    SELECT COUNT(DISTINCT g.grievance_id) AS total
    FROM grievances g," . $_SESSION['grievances_trns'] . " gt 
    WHERE g.grievance_status_id IN (1,2,3,5,6,8,9,10,11,12,13)
"; */
$sql = "SELECT COUNT(DISTINCT g.grievance_id) AS total
FROM grievances g
INNER JOIN (
    SELECT gts.*
    FROM grievances_transactions gts
    INNER JOIN (
        SELECT grievance_id, MAX(transaction_id) AS latest_transaction_id
        FROM grievances_transactions
        GROUP BY grievance_id
    ) latest_gt 
        ON gts.grievance_id = latest_gt.grievance_id
        AND gts.transaction_id = latest_gt.latest_transaction_id
    WHERE gts.emp_id != ''
) gt 
    ON g.grievance_id = gt.grievance_id
WHERE 
    g.ulbid = '250'
    AND g.app_type_id = '1'
    AND g.grievance_status_id IN (2,3,5,6,8,9,10,11,12,13)
    AND gt.disposal_status IN (2,3,5,6,8,9,10,11,12,13)
    AND g.cat3_id != 0 ";
	
	if(!empty($selectedYear)) {
		$sql .="  and date_format(date_regd,'%Y') =".$selectedYear." ";
	}
	
	
	//echo $sql;
	
$result = $conn->query($sql);

$row = $result->fetch_assoc();

$tot_gr_registered = $row['total'];


$sql = "SELECT COUNT(DISTINCT g.grievance_id) AS total
FROM grievances g
INNER JOIN (
    SELECT gts.*
    FROM grievances_transactions gts
    INNER JOIN (
        SELECT grievance_id, MAX(transaction_id) AS latest_transaction_id
        FROM grievances_transactions
        GROUP BY grievance_id
    ) latest_gt 
        ON gts.grievance_id = latest_gt.grievance_id
        AND gts.transaction_id = latest_gt.latest_transaction_id
    WHERE gts.emp_id != ''
) gt 
    ON g.grievance_id = gt.grievance_id
WHERE 
    g.ulbid = '250'
    AND g.app_type_id = '1'
    AND g.grievance_status_id IN (3,6,8,9,12)
    AND g.cat3_id != 0 ";
	
	if(!empty($selectedYear)) {
		$sql .="  and date_format(date_regd,'%Y') =".$selectedYear." ";
	}

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$tot_gr_resolved = $row['total'];

//$remaining_grievances= $tot_gr_registered - $tot_gr_resolved;

$data = [
    "tot_gr_registered" => $tot_gr_registered,
    "tot_gr_resolved" => $tot_gr_resolved  
];

echo json_encode($data);

$conn->close();
?>
