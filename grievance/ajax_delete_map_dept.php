<?php
require "config.php";
require_once('connection.php');
include('prepare_connection.php');
$conn = getconnection();

if(isset($_REQUEST['emp_id']) && isset($_REQUEST['dept_id'])) {
    
    //17-07-2024 $sql="DELETE FROM hod_emp_map_test WHERE emp_id=? and dept_id=?";
    $sql="DELETE FROM hod_emp_map WHERE emp_id=? and dept_id=?";
    //17-07-2024 $sql="UPDATE hod_emp_map_test SET delete_status=1 WHERE emp_id=? and dept_id=?";
    $emp_id = strip_tags($_REQUEST['emp_id']);
    $dept_id = strip_tags($_REQUEST['dept_id']);
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $emp_id, $dept_id);
    echo $query->execute();
    
    $query->close();
}
