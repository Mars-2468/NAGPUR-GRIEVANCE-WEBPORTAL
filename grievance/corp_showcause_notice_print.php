<?php
require "config.php";
date_default_timezone_set('Asia/Kolkata'); // Updated to the correct timezone identifier

// Temporarily enable error reporting for debugging
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once('Smarty.class.php');
$tpl = new Smarty();
$current_year = date('Y');
if (isset($_SESSION['uid'])) {

   // session_regenerate_id();
    require_once('get_services.php');
    $obj = new get_services($_SESSION['uid']);
    
    require_once('connection.php');
    $conn = getconnection();
    
    // Check if the connection is successful
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }
    
    // Set character set and collation
    mysqli_set_charset($conn, 'utf8');
    mysqli_query($conn, 'SET collation_connection = utf8_general_ci');
    
    include('user_defined_functions.php');
    $csrf_token = generateToken($csrf_prefix_token);
    $tpl->assign('csrf_token', $csrf_token);


	
	if ($_REQUEST['f_date'] != '' && $_REQUEST['t_date'] != '') {
		$fdate = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$tdate = date('Y-m-d', strtotime($_REQUEST['t_date']));

		$_REQUEST['f_date'] = date('Y-m-d', strtotime($_REQUEST['f_date']));
		$_REQUEST['t_date'] = date('Y-m-d', strtotime($_REQUEST['t_date']));
	}
	/* if ($_SESSION['user_type'] == 'E') {
		// Updated SQL query with JOIN
		$sql = "SELECT c.*,c.showcause_id As cid, sr.*, e.emp_id, e.emp_name FROM show_case_emp_count AS c LEFT JOIN show_case_response_logs AS sr ON c.emp_id = sr.emp_id AND c.datetime = sr.datetime LEFT JOIN emp_mst AS e ON c.emp_id = e.emp_id WHERE c.emp_id = '" . $_SESSION['emp_id'] . "' ORDER BY c.showcause_id DESC LIMIT 1";
	}
	else{
		$sql = "SELECT c.*,c.showcause_id As cid, sr.*, e.emp_id, e.emp_name FROM show_case_emp_count AS c LEFT JOIN show_case_response_logs AS sr ON c.emp_id = sr.emp_id AND c.datetime = sr.datetime LEFT JOIN emp_mst AS e ON c.emp_id = e.emp_id WHERE c.emp_id = '" . $_REQUEST['emp_id'] . "' ORDER BY c.showcause_id DESC LIMIT 1";
	} */
	
	/* if ($_SESSION['user_type'] == 'E') {
		// Updated SQL query with JOIN
		$sql = "SELECT sc.*, e.emp_id, e.emp_name FROM show_case_emp_count AS sc LEFT JOIN emp_mst AS e ON sc.emp_id = e.emp_id WHERE sc.emp_id = '" . $_SESSION['emp_id'] . "' and sc.showcause_id= '" . $_SESSION['showcause_id'] . "'";
	}
	else{
		$sql = "SELECT c.*,c.showcause_id As cid, sr.*, e.emp_id, e.emp_name FROM show_case_emp_count AS c LEFT JOIN show_case_response_logs AS sr ON c.emp_id = sr.emp_id AND c.datetime = sr.datetime LEFT JOIN emp_mst AS e ON c.emp_id = e.emp_id WHERE c.emp_id = '" . $_REQUEST['emp_id'] . "' ORDER BY c.showcause_id DESC LIMIT 1";
	}
	 */
	
	if ($_SESSION['user_type'] == 'E') {	
		$sql = "SELECT sc.*, e.emp_id, e.emp_name FROM show_case_response_logs AS sc, emp_mst AS e where sc.emp_id = e.emp_id and sc.emp_id = '" . $_SESSION['emp_id'] . "' and sc.warning_id= '" . $_REQUEST['warning_id'] . "'";
	}else{
		$sql = "SELECT sc.*, e.emp_id, e.emp_name FROM show_case_response_logs AS sc, emp_mst AS e where sc.emp_id = e.emp_id and sc.emp_id = '" . $_REQUEST['emp_id'] . "' and sc.warning_id= '" . $_REQUEST['warning_id'] . "'";
	}
	
	$rs = mysqli_query($conn, $sql);

	if (!$rs) {
		die('SQL query failed: ' . mysqli_error($conn));
	}
	$row = mysqli_fetch_assoc($rs);
	
	//echo"<pre>";print_r($sql);echo"</pre>";die();
	
	$date = new DateTime($row['datetime']);
	$formattedDate = $date->format('Y-m-d');
    // Assign values to Smarty template
	$tpl->assign('showcause_id', $showcause_id ?? null);
    $tpl->assign('emp_id', $emp_id ?? null);
    $tpl->assign('emp_name', $row['emp_name'] ?? null);
  	$tpl->assign('sms_notice_date', $formattedDate ?? null);
    $tpl->assign('current_year', $current_year ?? null);

    // Assign other data to Smarty template
    $tpl->assign('online_applications', $online_applications ?? []);
    $tpl->assign('user_type', $_SESSION['user_type'] ?? '');
    $tpl->assign('main_icons', $obj->main_icons ?? []);
    $tpl->assign('services', $obj->services ?? []);
    $tpl->assign('banner', $_SESSION['banner'] ?? '');
	$tpl->assign('fdate', $_REQUEST['f_date']);
	$tpl->assign('tdate', $_REQUEST['t_date']);

    mysqli_close($conn);

    $tpl->display('corp_showcause_notice_print.tpl');
} else {
    echo "<script>window.location='index.php';</script>";
}
?>

