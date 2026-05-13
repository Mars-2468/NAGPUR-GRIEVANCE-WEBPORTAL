<?php
require "config.php";
require_once('connection.php');
include('prepare_connection.php');
$conn = getconnection();

if(isset($_REQUEST['emp_id']) && isset($_REQUEST['ward_id'])) {
    
    //17-07-2024 $sql="DELETE FROM ward_comm_map WHERE emp_id=? and ward_id=?";
    $sql="DELETE FROM ward_comm_map WHERE emp_id=? and ward_id=?";
    //17-07-2024 $sql="UPDATE ward_comm_map SET delete_status=1 WHERE emp_id=? and ward_id=?";
    $emp_id = strip_tags($_REQUEST['emp_id']);
    $ward_id = strip_tags($_REQUEST['ward_id']);
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $emp_id, $ward_id);
    echo $query->execute();
    
    $query->close();
}
