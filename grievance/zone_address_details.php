<?php
require "config.php";
require_once('connection.php');

$conn = getconnection();

// Set header for JSON response
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

if (isset($_POST['zoneId']) && is_numeric($_POST['zoneId'])) {
    $zoneId = intval($_POST['zoneId']); // Sanitize input

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM ward_mst WHERE ward_id = ?");
    $stmt->bind_param("i", $zoneId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($data_row = $result->fetch_assoc()) {
        echo json_encode($data_row);
    } else {
        echo json_encode(['error' => 'Zone not found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Unauthenticated or invalid input']);
}
?>
