<?php
require "config.php";
error_reporting(0);

// $status = isset($_POST['status']) ? $_POST['status'] : '';
// $sla = isset($_POST['sla']) ? $_POST['sla'] : '';

//if (isset($_POST['excel'])
if (isset($_POST['excel'])  && isset($_POST['status']) && isset($_POST['sla'])) {

  $status = $_POST['status'];
  $sla = $_POST['sla'];
  $user_type = $_POST['user_type'];
  $user_type1 = $_POST['user_type2'];
  $user_type2 = $_POST['user_type3'];
  require_once('connection.php');
  $con = getconnection();

  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
  }
  // echo $_SESSION['myquery'];
  //exit;
  $result_data = $con->query($_SESSION['myquery']);
  //print_r($result_data);exit;
  $results = array();

  if ($status == 'all' && $user_type == 'U') {
    $filename = "NO. OF COMPLAINTS REGISTERED"; // File Name
  }
  elseif ($status == 'all' && $user_type == 'E') {
    $filename = "NO. OF COMPLAINTS REGISTERED"; // File Name
  }
  elseif ($status == 'show' || $status == 'show_all'){
    $filename = "SHOW CAUSE NOTICE LIST"; // File Name
  }
  elseif ($status == 'war' || $status == 'war_all'){
    $filename = "WARNING NOTICE LIST"; // File Name
  }
  elseif ($status == 'L1' && $user_type == 'U') {
    $filename = "LEVEL 1 COMPLAINTS"; // File Name
  }
  elseif ($status == 'L1' && $user_type == 'E') {
    $filename = "LEVEL 1 COMPLAINTS"; // File Name
  }
  elseif ($status == 'L2' && $user_type == 'U') {
    $filename = "LEVEL 2 COMPLAINTS"; // File Name
  }
  elseif ($status == 'L2' && $user_type == 'E') {
    $filename = "LEVEL 2 COMPLAINTS"; // File Name
  }
  elseif ($status == 'L3' && $user_type == 'U') {
    $filename = "LEVEL 3 COMPLAINTS"; // File Name
  }
  elseif ($status == 'L3' && $user_type == 'E') {
    $filename = "LEVEL 3 COMPLAINTS"; // File Name
  }
  elseif ($status == 'L4' && $user_type == 'U') {
    $filename = "LEVEL 4 COMPLAINTS"; // File Name
  }
  elseif ($status == 'L4' && $user_type == 'E') {
    $filename = "LEVEL 4 COMPLAINTS"; // File Name
  }
  elseif ($status == 0 || $status == 100 && $sla == 0 || $status == 101 && $sla == 0 || $status == 102 && $sla == 0 || $status == 1000 && $sla == 0 && $user_type == 'E' ) {
    $filename = "EMPLOYEE RECEIVED COMPLAINT"; // File Name
  }
  elseif ($status == 801 && $sla == 0 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT RECEIVED COMPLAINT"; // File Name
  }elseif ($status == 801 && $sla == 0 && $user_type2 == 'Z' ) {
    $filename = "ZONE RECEIVED COMPLAINT"; // File Name
  }
  elseif ($status == 0 || $status == 100 && $sla == 0 || $status == 101 && $sla == 0 || $status == 102 && $sla == 0 || $status == 1000 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN RECEIVED COMPLAINT"; // File Name
  }
  elseif ($status == 107 && $sla == 2 || $status == 800 && $sla == 0 || $status == 21 && $sla == 0 && $user_type == 'U' ){
    $filename = "ADMIN TOTAL PENDING COMPLAINT"; // File Name
  }
  elseif ($status == 107 && $sla == 2 || $status == 800 && $sla == 0 || $status == 21 && $sla == 0 && $user_type == 'E' ){
    $filename = "EMPLOYEE TOTAL PENDING COMPLAINT"; // File Name
  }
  elseif ($status == 107 && $sla == 2 || $status == 800 && $sla == 0 || $status == 21 && $sla == 0 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT TOTAL PENDING COMPLAINT"; // File Name
  }
  elseif ($status == 108 || $status == 20 && $sla == 0 || $status == 900 && $sla == 0 || $status == 100 && $sla == 2 && $user_type == 'E' ){
    $filename = "ADMIN TOTAL RESOLVED COMPLAINT"; // File Name
  }
  elseif ($status == 108 || $status == 20 && $sla == 0 || $status == 900 && $sla == 0 || $status == 100 && $sla == 2 && $user_type == 'E' ){
    $filename = "EMPLOYEE TOTAL RESOLVED COMPLAINT"; // File Name
  }
  elseif ($status == 108 || $status == 20 && $sla == 0 || $status == 900 && $sla == 0 || $status == 802 && $sla == 2 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT TOTAL RESOLVED COMPLAINT"; // File Name
  }
  elseif ($status == 802 && $sla == 2 && $user_type2 == 'Z' ) {
    $filename = "ZONE TOTAL RESOLVED COMPLAINT"; // File Name
  }
  elseif ($status == 109 ) {
    $filename = "COMPLAINTS < 7 DAYS REPORT"; // File Name
  }
  elseif ($status == 110 ) {
    $filename = "COMPLAINTS > 30 DAYS REPORT"; // File Name
  }
  elseif ($status == 200 && $sla == 2 && $user_type == 'E' ){
    $filename = "EMPLOYEE TOTAL UNDERPROGRESS COMPLAINT"; // File Name
  }
  elseif ($status == 803 && $sla == 2 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT TOTAL UNDERPROGRESS COMPLAINT"; // File Name
  }
  elseif ($status == 803 && $sla == 2 && $user_type2 == 'Z' ) {
    $filename = "ZONE TOTAL UNDERPROGRESS COMPLAINT"; // File Name
  }
  elseif ($status == 700 && $sla == 0 || $status == 701 && $sla == 0 || $status == 6 && $sla == 0 || $status == 60 && $sla == 0 || $status == 10 && $sla == 0 || $status == 6 && $sla == 2 && $user_type == 'E' ){
    $filename = "EMPLOYEE FINANCIAL IMPLICATIONS COMPLAINT"; // File Name
  }
  elseif ($status == 700 && $sla == 0 || $status == 701 && $sla == 0 || $status == 6 && $sla == 0 || $status == 60 && $sla == 0 || $status == 10 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN FINANCIAL IMPLICATIONS COMPLAINT"; // File Name
  }
  elseif ($status == 6 && $sla == 0 || $status == 804 && $sla == 0 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT FINANCIAL IMPLICATIONS COMPLAINT"; // File Name
  }
  elseif ($status == 804 && $sla == 0 && $user_type2 == 'Z' ) {
    $filename = "ZONE FINANCIAL IMPLICATIONS COMPLAINT"; // File Name
  }
  elseif ($status == 302 && $sla == 0 || $status == 400 && $sla == 0 || $status == 401 && $sla == 0 || $status == 3 && $sla == 0 || $status == 4 && $sla == 0 || $status == 22 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN COMPLETED WITHIN SLA COMPLAINT"; // File Name
  }
  elseif ($status == 302 && $sla == 0 || $status == 400 && $sla == 0 || $status == 401 && $sla == 0 || $status == 3 && $sla == 0 || $status == 4 && $sla == 0 || $status == 22 && $sla == 0 || $status == 2 && $sla == 1 && $user_type == 'E' ){
    $filename = "EMPLOYEE COMPLETED WITHIN SLA COMPLAINT"; // File Name
  }
  elseif ($status == 22 && $sla == 0 || $status == 805 && $sla == 1 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT COMPLETED WITHIN SLA COMPLAINT"; // File Name
  }
  elseif ($status == 805 && $sla == 1 && $user_type2 == 'Z' ) {
    $filename = "ZONE COMPLETED WITHIN SLA COMPLAINT"; // File Name
  }
  elseif ($status == 200 && $sla == 0 || $status == 201 && $sla == 0 || $status == 202 && $sla == 0 || $status == 2 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN UNDER PROGRESS WITHIN SLA COMPLAINT"; // File Name
  }
  elseif ($status == 200 && $sla == 0 || $status == 201 && $sla == 0 || $status == 202 && $sla == 0 || $status == 2 && $sla == 0 || $status == 3 && $sla == 1 && $user_type == 'E' ){
    $filename = "EMPLOYEE UNDER PROGRESS WITHIN SLA COMPLAINT"; // File Name
  }
  elseif ($status == 807 && $sla == 1 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT UNDER PROGRESS WITHIN SLA COMPLAINT"; // File Name
  }
  elseif ($status == 807 && $sla == 1 && $user_type2 == 'Z' ) {
    $filename = "ZONE UNDER PROGRESS WITHIN SLA COMPLAINT"; // File Name
  }
  //28-03-24 elseif ($status == 500 || $status == 501 || $status == 5 || $status == 9 && $sla == 0 && $user_type == 'U' ) {
    elseif ($status == 500 && $sla == 0 || $status == 501 && $sla == 0 || $status == 9 && $sla == 0 || $status == 23 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN COMPLETED BEYOND SLA COMPLAINT"; // File Name
  }
  //28-03-24 elseif ($status == 500 || $status == 501 || $status == 9 || $status == 5 && $sla == 0 || $status == 2 && $sla == 2 && $user_type == 'E' ){
    elseif ($status == 500 && $sla == 0 || $status == 501 && $sla == 0 || $status == 9 && $sla == 0 || $status == 23 && $sla == 0 || $status == 2 && $sla == 2 && $user_type == 'E' ){
    $filename = "EMPLOYEE COMPLETED BEYOND SLA COMPLAINT"; // File Name
  }
  elseif ($status == 23 && $sla == 0 || $status == 806 && $sla == 2 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT COMPLETED BEYOND SLA COMPLAINT"; // File Name
  }
  elseif ($status == 806 && $sla == 2 && $user_type2 == 'Z' ) {
    $filename = "ZONE COMPLETED BEYOND SLA COMPLAINT"; // File Name
  }
  //12-03-24 elseif ($status == 3 || $status == 300 || $status == 8 && $sla == 0 && $user_type == 'U' ) {
    elseif ($status == 300 && $sla == 0 || $status == 301 && $sla == 0 || $status == 8 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN UNDER PROGRESS BEYOND SLA COMPLAINT"; // File Name
  }
  //12-03-24 elseif ($status == 3 || $status == 300 || $status == 301 || $status == 8 && $sla == 0 || $status == 3 && $sla == 2 && $user_type == 'E' ){
    elseif ($status == 300 && $sla == 0 || $status == 301 && $sla == 0 || $status == 8 && $sla == 0 || $status == 3 && $sla == 2 && $user_type == 'E' ){
    $filename = "EMPLOYEE UNDER PROGRESS BEYOND SLA COMPLAINT"; // File Name
  }
  elseif ($status == 808 && $sla == 2 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT UNDER PROGRESS BEYOND SLA COMPLAINT"; // File Name
  }
  elseif ($status == 808 && $sla == 2 && $user_type2 == 'Z' ) {
    $filename = "ZONE UNDER PROGRESS BEYOND SLA COMPLAINT"; // File Name
  }
  elseif ($status == 105 && $sla == 0 || $status == 500 && $sla == 0 || $status == 502 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN REOPENED UNDER PROGRESS COMPLAINT"; // File Name
  }
  elseif ($status == 501 && $sla == 0 || $status == 105 && $sla == 0 || $status == 503 && $sla == 0 && $user_type == 'E' ){
    $filename = "EMPLOYEE REOPENED UNDER PROGRESS COMPLAINT"; // File Name
  }
  elseif ($status == 811 && $sla == 0 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT REOPENED UNDER PROGRESS COMPLAINT"; // File Name
  }
  elseif ($status == 811 && $sla == 0 && $user_type2 == 'Z' ) {
    $filename = "ZONE REOPENED UNDER PROGRESS COMPLAINT"; // File Name
  }
  elseif ($status == 7 && $sla == 0 || $status == 600 && $sla == 0 || $status == 601 && $sla == 0 && $user_type == 'U' ){
    $filename = "ADMIN REOPENED COMPLETED COMPLAINT"; // File Name
  }
  elseif ($status == 601 && $sla == 0 || $status == 7 && $sla == 0 && $user_type == 'E' ){
    $filename = "EMPLOYEE REOPENED COMPLETED COMPLAINT"; // File Name
  }
  elseif ($status == 810 && $sla == 0 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT REOPENED COMPLETED COMPLAINT"; // File Name
  }
  elseif ($status == 810 && $sla == 0 && $user_type2 == 'Z' ) {
    $filename = "ZONE REOPENED COMPLETED COMPLAINT"; // File Name
  }
  elseif ($status == 5 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN TOTAL REOPENED COMPLAINT"; // File Name
  }
  elseif ($status == 5 && $sla == 0 && $user_type == 'E' ) {
    $filename = "EMPLOYEE TOTAL REOPENED COMPLAINT"; // File Name
  }
  elseif ($status == 809 && $sla == 0 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT TOTAL REOPENED COMPLAINT"; // File Name
  }
  elseif ($status == 111 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN TODAY'S RECEIVED COMPLAINT"; // File Name
  }
  elseif ($status == 111 && $sla == 0 && $user_type == 'E' ) {
    $filename = "EMPLOYEE TODAY'S RECEIVED COMPLAINT"; // File Name
  }
  elseif ($status == 111 && $sla == 0 && $user_type1 == 'D' ) {
    $filename = "DEPARTMENT TODAY'S RECEIVED COMPLAINT"; // File Name
  }
  elseif ($status == 111 && $sla == 0 && $user_type2 == 'Z' ) {
    $filename = "ZONE TODAY'S RECEIVED COMPLAINT"; // File Name
  }
  elseif ($status == 809 && $sla == 0 && $user_type2 == 'Z' ) {
    $filename = "ZONE TOTAL REOPENED COMPLAINT"; // File Name
  }
  elseif ($status == 1 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN PENDING FOR APPROVAL COMPLAINT"; // File Name
  }
  elseif ($status == 1 && $sla == 0 && $user_type == 'E' ) {
    $filename = "EMPLOYEE PENDING FOR APPROVAL COMPLAINT"; // File Name
  }
  elseif ($status == 4 && $sla == 0 && $user_type == 'U' ) {
    $filename = "ADMIN UN RESOLVABLE COMPLAINT"; // File Name
  }
  elseif ($status == 4 && $sla == 0 && $user_type == 'E' ) {
    $filename = "EMPLOYEE UN RESOLVABLE COMPLAINT"; // File Name
  }
  elseif ($status == 125 && $sla == 125 && $user_type == 'E' ){
    $filename = "ESCALATION REPORT COMPLAINT"; // File Name
  }
  elseif ($status == 'war' && $user_type == 'U' ){
    $filename = "SHOW CAUSE NOTICE LIST"; // File Name
  }
  else{
    //$filename = "csmsreports"; // File Name
    $filename = "GrievanceReport"; // File Name
  }
  //echo $filename;
  //die();

  //$filename = "csmsreports.xls"; // File Name

  // Set headers for CSV
  header('Content-Type: text/csv');
  //header('Content-Disposition: attachment; filename="database_data.csv"');
  header("Content-Disposition: attachment; filename=\"$filename.csv\"");

  // Create a file pointer connected to the output stream
  $output = fopen('php://output', 'w');

  // Output headers
  //$headers = array(' CategoryName', 'RefrenceNo', 'ZoneName', 'WardName', 'PersonName', 'Mobile', 'Address', 'ComplaintDetails', 'Status', 'ReceivedDate' ); // Replace with your column names
  fputcsv($output, $headers);

  // Output data
  // while ($row = mysqli_fetch_assoc($result_data)) {
  //     fputcsv($output, $row);
  // }

$flag = false;
while ($row = mysqli_fetch_assoc($result_data)) {
    if (!$flag) {
        // Display field/column names as the first row
        echo '"' . implode('","', array_keys($row)) . '"' . "\r\n";
        $flag = true;
    }
    array_walk($row, 'cleanData');
    echo '"' . implode('","', array_values($row)) . '"' . "\r\n";
}
  // Close the file pointer
  fclose($output);
}
?>
