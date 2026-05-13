<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../connection.php');

$conn = getconnection(); // mysqli connection

date_default_timezone_set('Asia/Calcutta');

$sql = "
    SELECT COUNT(DISTINCT grievance_id) AS total
    FROM grievances
    WHERE grievance_status_id IN (1,2,3,5,6,8,9,10,11,12,13)
";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$tot_gr_registered = $row['total'];


$sql = "
    SELECT COUNT(DISTINCT grievance_id) AS total
    FROM grievances
    WHERE grievance_status_id IN (3,6,8,9,12)
";

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
