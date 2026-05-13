<?php

session_start();
require_once('connection.php');
include('prepare_connection.php');
$conn = getconnection();


if (isset($_POST['zoneId'])) {

   $zoneId = $_POST['zoneId'];
   $sql_list = "SELECT *  FROM ward_mst where ward_id ='".$zoneId."' ";
   $rs_list  = mysqli_query($conn,$sql_list);
   $data_row = mysqli_fetch_assoc($rs_list); 
   echo json_encode($data_row);
  exit;
}
?>



