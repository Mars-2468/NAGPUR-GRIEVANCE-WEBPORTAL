<?php
require "config.php";
require_once('dropdown_conn.php');
include('prepare_connection.php');

$conn = getconnection();

if (isset($_POST['dept_id'])) {
    $deptId = $_POST['dept_id'];
    $emp_id = $_POST['emp_id'];
    $ward_id = $_POST['ward_id'];
    $street_id = $_POST['street_id'];
    $cat3_id = $_POST['cat3_id'];

   // $query="SELECT d.desg_id,d.desg_desc FROM emp_mst e,emp_map em,emp_desg_map edm,desg_mst d WHERE e.emp_id=em.emp_id2 and em.emp_id2=edm.emp_id and em.dept_id=edm.dept_id and edm.desg_id=d.desg_id and em.dept_id=? and em.emp_id=? and em.ward_id=? and em.street_id=? and em.cs_id=?  ";
   $query="SELECT d.desg_id,d.desg_desc FROM emp_map e,emp_desg_map ed,desg_mst d where e.dept_id=? and e.emp_id=? and e.ward_id=? and e.street_id=? and e.cs_id=? and ed.emp_id=e.emp_id2 and ed.desg_id=d.desg_id";
 	
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("iiiii", $deptId, $emp_id,$ward_id,$street_id,$cat3_id);
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
