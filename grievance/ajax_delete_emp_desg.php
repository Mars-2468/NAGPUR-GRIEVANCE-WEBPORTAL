<?php
require "config.php";
require_once('connection.php');
include('prepare_connection.php');
$conn = getconnection();

if(isset($_REQUEST['emp_id']) && isset($_REQUEST['desg_id'])) {
    $sql = "UPDATE emp_desg_map SET delete_status = '1' WHERE emp_id=? AND desg_id=?";
    $emp_id = strip_tags($_REQUEST['emp_id']);
    $desg_id = strip_tags($_REQUEST['desg_id']);
    
    

    $query = $conn->prepare($sql);
    $query->bind_param("ii", $emp_id, $desg_id);

    echo $query->execute();

   
    
    $query->close();
}

