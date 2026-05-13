<?php
require "config.php";
error_reporting(0);

  require_once('connection.php');
  $con = getconnection();

  // Fetch data from the database
  $query = "SELECT * FROM users";
  $result = mysqli_query($conn, $query);

  if (!$result) {
      die("Query failed: " . mysqli_error($conn));
  }

  // Convert the result set into an associative array
  $data = array();
  while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
  }

  // Close the database connection
  mysqli_close($conn);

  // Return data as JSON
  header('Content-Type: application/json');
  echo json_encode($data);
?>
