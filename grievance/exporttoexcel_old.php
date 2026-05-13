<?php
require "config.php";
error_reporting(0);

// $status = isset($_POST['status']) ? $_POST['status'] : '';
// $sla = isset($_POST['sla']) ? $_POST['sla'] : '';

//if (isset($_POST['excel'])
if (isset($_POST['excel'])  && isset($_POST['status']) && isset($_POST['sla'])) {

  $status = $_POST['status'];
  $sla = $_POST['sla'];
  require_once('connection.php');
  $con = getconnection();

  // echo $_SESSION['myquery'];
  // exit;


  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
  }
  // echo $_SESSION['myquery'];
  // exit;
  $result_data = $con->query($_SESSION['myquery']);
  //print_r($result_data);exit;
  $results = array();
  
  if ($status == 0 && $sla == 0 ) {
    $filename = "RECEIVED COMPLAINT DETAILS.xls"; // File Name
  }
  elseif ($status == 100 && $sla == 2 ){
    $filename = "TOTAL RESOLVED COMPLAINT.xls"; // File Name
  }
  elseif ($status == 200 && $sla == 2 ){
    $filename = "TOTAL UNDERPROGRESS COMPLAINT.xls"; // File Name
  }
  elseif ($status == 6 ){
    $filename = "FINANCIAL IMPLICATIONS COMPLAINT.xls"; // File Name
  }
  elseif ($status == 2 && $sla == 1 ){
    $filename = "COMPLETED WITHIN SLA COMPLAINT.xls"; // File Name
  }
  elseif ($status == 3 && $sla == 1 ){
    $filename = "UNDER PROGRESS WITHIN SLA COMPLAINT.xls"; // File Name
  }
  elseif ($status == 2 && $sla == 2 ){
    $filename = "COMPLETED BEYOND SLA COMPLAINT.xls"; // File Name
  }
  elseif ($status == 3 && $sla == 2 ){
    $filename = "UNDER PROGRESS BEYOND SLA COMPLAINT.xls"; // File Name
  }
  elseif ($status == 501 ){
    $filename = "REOPENED UNDER PROGRESS COMPLAINT.xls"; // File Name
  }
  elseif ($status == 601 ){
    $filename = "REOPENED COMPLETED COMPLAINT.xls"; // File Name
  }
  else{
    $filename = "csmsreports.xls"; // File Name
  }
  //echo $filename;
  //die();

  //$filename = "csmsreports.xls"; // File Name
  // Download file
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  while ($row = mysqli_fetch_assoc($result_data)) {
    if (!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }

  //unset($_SESSION['myquery']);
  $con->close();
}
