<?php
require "config.php";
ini_set('display_errors', 0);
if (isset($_POST['street_id'])) {
	include('user_defined_functions.php');
	require_once('prepare_connection.php');
	require_once('connection.php');
	$conn = getconnection();

	if (!preg_match("/^[0-9]+$/", $_REQUEST['street_id'])) // id
	{
		die('Invalid Data Passed To Street..!');
	}

	$street_id = $_REQUEST['street_id'];

	if (!empty($_POST['csrf_token'])) {

		if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {

			if (!preg_match("/^[0-9]+$/", $street_id)) {
				die('Invalid Data Passed To Street..!');
			}
			
			$sql = 'delete from street_mst where street_id=? and ulbid=?';
			$query = $conn->prepare($sql);
			$query->bind_param("is", $street_id, htmlspecialchars(strip_tags($_SESSION['ulbid'])));
			if ($query->execute()) {
				echo 1;
			} else {
				echo 0;
			}
			$query->close();
		} else {
			echo 3;
		}
	} else {
		echo 4;
	}
	$conn->close();
}
