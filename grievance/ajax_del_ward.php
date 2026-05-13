<?php
require "config.php";
ini_set('display_errors', 0);
if (isset($_POST['ward_id'])) {
	include('user_defined_functions.php');
	require_once('prepare_connection.php');

	if (!preg_match("/^[0-9]+$/", $_REQUEST['ward_id'])) // id
		die('Invalid Data Passed To Ward..!');
	else
		$ward_id = $_REQUEST['ward_id'];



	if (!empty($_POST['csrf_token'])) {

		if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) {

			if (!preg_match("/^[0-9]+$/", $ward_id)) {
				die('Invalid Data Passed To Ward..!');
			}

			$sql = "select ward_id from emp_map where ward_id=? and ulbid=?";

			$query = $conn->prepare($sql);
			$query->bind_param("is", $ward_id, htmlspecialchars(strip_tags($_SESSION['ulbid'])));
			$query->execute();
			$nr = $query->num_rows;
			$query->close();


			if ($nr > 0) {
				echo 2;
			} else {

				$sql = 'delete from ward_mst where ward_id=? and ulbid=?';
				$query = $conn->prepare($sql);
				$query->bind_param("is", $ward_id, htmlspecialchars(strip_tags($_SESSION['ulbid'])));
				if ($query->execute()) {
					echo 1;
				} else {
					echo 0;
				}
				$query->close();
			}
		} else {
			echo 3;
		}
	} else {
		echo 4;
	}
	$conn->close();
}
