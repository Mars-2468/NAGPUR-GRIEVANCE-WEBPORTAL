<?php
require "config.php";
ini_set('display_errors', 0);
if (isset($_POST['dept_id'])) 
{
	require_once('connection.php');
	include('user_defined_functions.php');
	require_once('prepare_connection.php');
	$conn = getconnection();

	if (!preg_match("/^[0-9]+$/", $_REQUEST['dept_id'])) // dept_id
	{
		die('Invalid Data Passed To Department..!');
	}

	$dept_id = $_REQUEST['dept_id'];

	$sql = $conn->prepare("select emp_dept from emp_mst where emp_dept=? and ulbid=?");
	$sql->bind_param("is", $dept_id, htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$sql->execute();
	$rs = $sql->get_result();
	$nr1 = $rs->num_rows;
	//$conn->close();

	if ($nr1 > 0) 
	{
		echo 'Employee Are Mapped With This Department, Change Employees From This Department..!';
	} 
	else 
	{
		$sql = $conn->prepare("select desg_id from desg_mst where dept_id=? and ulbid =?");
		$sql->bind_param("is", $dept_id, htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs = $sql->get_result();
		$nr2 = $rs->num_rows;
		//$conn->close();

		$sql = $conn->prepare("select dept_id from emp_map where dept_id=? and ulbid =?");
		$sql->bind_param("is", $dept_id, htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs = $sql->get_result();
		$nr3 = $rs->num_rows;

		if ($nr2 > 0) 
		{
			echo 'Designations Are Mapped With This Department, Change Designations From This Department..!';
		} 
		else if ($nr3 > 0) 
		{
			echo 'Complaints Mapped With This Department, Change Complaints Mapping From This Department..!';
		} 
		else if ($nr2 <= 0 && $nr3 <= 0) 
		{

			if (!empty($_POST['csrf_token'])) 
			{
				if (checkToken($_POST['csrf_token'], $csrf_prefix_token)) 
				{
					if (!preg_match("/^[0-9]+$/", $dept_id)) 
					{
						die('Invalid Data Passed To Department..!');
					}

					$sql = "delete from dept_mst where dept_id='" . $dept_id . "' and ulbid='" . $_SESSION['ulbid'] . "'";
					//$query=$conn->prepare($sql);
					//$query->bind_param("is",$dept_id,$_SESSION['ulbid']);
					if (mysqli_query($conn, $sql)) 
					{
						echo 1;
					} 
					else 
					{
						echo 0;
					}
					$query->close();
				} 
				else 
				{
					echo 3;
				}
			} 
			else 
			{
				echo 4;
			}
		}
	}
	$conn->close();
}
