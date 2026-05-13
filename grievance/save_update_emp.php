<?php
require "config.php";
ini_set('display_errors', 0);
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_SESSION['uid'])) {
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET names=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_query($conn, 'SET collation_connection=utf8_general_ci');
	
	if (isset($_POST['save'])) {
		
		if(!validateField($_POST['emp_name'], 'text')['valid'] || !validateField($_POST['emp_name_marathi'], 'text')['valid'] || !validateField($_POST['emp_desg'], 'dnumber')['valid']){
			$_SESSION['msg']  = "Enter Valid emp name or emp id level1/level2/level3..!";
			$_SESSION['class'] = "alert alert-danger display-hide";

			header('Location: update_emp.php');
			exit;
		}else{
		
			$emp_id = strip_tags($_POST['emp_id']);
			$emp_mobile = strip_tags($_POST['emp_mobile']);
			$emp_dept = strip_tags($_POST['emp_dept']);
			
			$stringcode = str_replace(" ", '_', strip_tags($_POST['emp_code']));
			
			$modifiedEmpCode = preg_replace('/^[^a-zA-Z0-9]+|[^a-zA-Z0-9]+$/', '', $stringcode);

			
			$emp_code = $modifiedEmpCode;
					
			$emp_name_marathi = $_POST['emp_name_marathi'];
			
			$emp_name = $_POST['emp_name'];
					
			$emp_desg = strip_tags($_POST['emp_desg']);
			$emp_id_numeric = is_numeric($emp_id);
			
			
			//echo "<pre>";print_r($emp_code);echo "</pre>";die();
		
			$table = $emp_id_numeric ? "emp_mst" : "emp_mst_od";
		
			// Check if the mobile number already exists
			$sql = "SELECT COUNT(*) AS count FROM $table WHERE emp_mobile = ? AND emp_id != ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("si", $emp_mobile, $emp_id);
			$stmt->execute();
			$stmt->bind_result($count);
			$stmt->fetch();
			$stmt->close();
		
		
		
			if ($count > 0) {
				
				$msg = 'Mobile Number is Already Existed..!';
				$class= 'alert alert-danger display-hide';
				
			} else {
				// Update employee details
				$sql = "UPDATE $table SET emp_dept = ?, emp_code = ?, emp_desg = ?, emp_name_marathi = ?, emp_name = ?, emp_mobile = ? WHERE emp_id = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("ssssssi", $emp_dept, $emp_code, $emp_desg, $emp_name_marathi, $emp_name, $emp_mobile, $emp_id);
		
				if ($stmt->execute()) {
					// Update user details
					$sql1 = "UPDATE users SET user_id = ?, user_pwd = PASSWORD(?), show_pwd = ? WHERE emp_id = ?";
					$stmt1 = $conn->prepare($sql1);
					$stmt1->bind_param("sssi", $emp_code, $emp_mobile, $emp_mobile, $emp_id);
					$stmt1->execute();
					$stmt1->close();
		
					// Update employee designations
					for ($i = 0; $i <= $_POST['cnt']; $i++) {
						$dept_id = "dept_id" . $i;
						$desg_id = 'desg_id' . $i;
		
						if (!empty($_POST[$dept_id]) && $_POST[$dept_id] != 0) {
							$sql2 = "SELECT COUNT(*) AS count FROM emp_desg_map WHERE emp_id = ? AND dept_id = ? AND desg_id = ?";
							$stmt2 = $conn->prepare($sql2);
							$stmt2->bind_param("iii", $emp_id, $_POST[$dept_id], $_POST[$desg_id]);
							$stmt2->execute();
							$stmt2->bind_result($count);
							$stmt2->fetch();
							$stmt2->close();
		
							if ($count == 0) {
								$sql3 = "INSERT INTO emp_desg_map (emp_id, dept_id, desg_id, flag) VALUES (?, ?, ?, 1)";
								$stmt3 = $conn->prepare($sql3);
								$stmt3->bind_param("iii", $emp_id, $_POST[$dept_id], $_POST[$desg_id]);
								$stmt3->execute();
								$stmt3->close();
							}
						}
					}
		
					$msg = 'Updated Successfully..!';					
					$class = 'alert alert-success display-hide';
		
					// Redirect to another page after a successful update
					header('Location: manage_emp.php');
					exit();
				} else {
					$msg = 'Error Updating Record..!';					
					$class='alert alert-danger display-hide';
				}
		
				$stmt->close();
			}
			
			$_SESSION['msg']  = $msg;
			$_SESSION['class'] = $class;

			header('Location: update_emp.php');
			exit;
		}	
	}
} else {
	$msg = "You have Not Logged In, Please Login..!";
	$tpl->assign('msg', $msg);
	$tpl->display('user_login.tpl');
}


function sanitize_input($sanitize_data) {

	//PHP
    // Remove unnecessary spaces
    $sanitize_data = trim($sanitize_data,"-+=\'\"");

    // Strip tags to prevent HTML and PHP code injection
    $sanitize_data = strip_tags($sanitize_data);

    // Convert special characters to HTML entities (e.g., < to &lt;)
    $sanitize_data = htmlspecialchars($sanitize_data);	

	//$sanitize_data = preg_replace('/[^a-zA-Z0-9_@()-]/', '', $sanitize_data);	
		
    return $sanitize_data;
}

?>