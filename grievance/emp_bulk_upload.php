<?php
require "config.php";
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Calcutta');

require_once('get_services.php');
require_once('connection.php');
$conn = getconnection();


if (isset($_POST["submit"])) {

	if ($_FILES['file']['name']) {
		$filename = explode(".", $_FILES['file']['name']);
		if ($filename[1] == 'csv') {
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			while ($data = fgetcsv($handle)) //handling csv file 
			{
				echo $item1 = $data[1].'-'. $data[4]."<br>";
				
				
				// $item2 = mysqli_real_escape_string($connect, $data[1]);
				// //insert data from CSV file 
				mysqli_real_escape_string($conn, strip_tags($data[4]));
				$query = "update emp_mst_od set emp_code='" . $data[1] . "' where emp_mobile='" . $data[4] . "'";
				mysqli_query($conn, $query);
			}
			fclose($handle);
			echo "employee details updated sucessfully imported";
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>employee bulk upload</title>
</head>

<body>
	<form method="post" enctype="multipart/form-data">
		<label>Select Employee CSV File:</label>
		<input type="file" name="file">
		<br>
		<input type="submit" name="submit" value="Import">
	</form>
</body>

</html>