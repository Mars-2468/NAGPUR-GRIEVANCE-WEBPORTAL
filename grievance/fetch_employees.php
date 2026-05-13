<?php
require "config.php";
require_once('dropdown_conn.php');
include('prepare_connection.php');

$conn = getconnection();

if (isset($_POST['emp_desg'])) {
    $ward_id = $_POST['ward_id'];
    $street_id = $_POST['street_id'];
    $cat3_id = $_POST['cat3_id'];

    $query="SELECT em.emp_id2, e.emp_name FROM emp_mst e, emp_map em WHERE e.emp_id = em.emp_id2 and em.ward_id = ? and em.street_id = ? and em.cs_id = ? GROUP BY em.emp_id2 ORDER BY e.emp_name";
	
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("iii",  $ward_id, $street_id,$cat3_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = [
                'emp_id2' => $row['emp_id2'],
                'emp_name' => $row['emp_name']
            ];
        }
        echo json_encode($employees);
        $stmt->close();
    } else {
        echo json_encode([]);
    } 
    $conn->close();
} else {
    echo json_encode([]);
}
?>
