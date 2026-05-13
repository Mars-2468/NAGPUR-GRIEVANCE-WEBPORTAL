<?php
require "config.php";
require_once('connection.php');
include('prepare_connection.php');

$conn = getconnection();

if (isset($_POST['dept_id'])) {
    $deptId = $_POST['dept_id'];
    $emp_id = $_POST['emp_id'];
    $ward_id = $_POST['ward_id'];
    $street_id = $_POST['street_id'];
    $cat3_id = $_POST['cat3_id'];

    $query="SELECT d.desg_id, d.desg_desc FROM emp_mst e, emp_map em, desg_mst d WHERE e.emp_id = em.emp_id2 and e.emp_desg = d.desg_id and em.dept_id = ? and em.emp_id = ? and em.ward_id = ? and em.street_id = ? and em.cs_id = ? GROUP BY d.desg_id ORDER BY d.desg_desc";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("iiiii", $deptId, $emp_id, $ward_id, $street_id,$cat3_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $designations = [];
        while ($row = $result->fetch_assoc()) {
            $designations[] = [
                'desg_id' => $row['desg_id'],
                'desg_desc' => $row['desg_desc']
            ];
        }
        echo json_encode($designations);
        $stmt->close();
    } else {
        echo json_encode([]);
    }
    $conn->close();
} else {
    echo json_encode([]);
}
?>
