<?php
require_once 'validateFields_helper.php';

$bsurl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$bsurl .= "://" . $_SERVER['HTTP_HOST'];

function getconnection()
{

	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
		$link = "https";
	else
		$link = "http";

	$link .= "://";

	$link .= $_SERVER['HTTP_HOST'];

	$conn = mysqli_connect("localhost", "root", "", 'nmccsms') or die(mysqli_connect_error());

	/************************************ start session_users **************************************/

	//$session_timeout = 3600;// 1 hour    900 for 15mnts
	$session_timeout = 3600; //24*3600;// 1 day

	if (isset($_SESSION['last_activity'])) {
		// Calculate the time since the last activity
		$inactive_duration = time() - $_SESSION['last_activity'];

		// If inactive duration is greater than timeout, destroy the session
		if ($inactive_duration > $session_timeout) {

			$user_id = $_SESSION['user_id'];

			/************************************ start session_users **************************************/

				//$sql = "delete from session_users where user_id=? and session_id=?";
			/* 	$query = $conn->prepare($sql);
				$query->bind_param("ss", $_SESSION['user_id'], $_SESSION['session_id']);

				$query->execute(); */
				
				/* if ($query = $conn->prepare($sql)) {
					$query->bind_param("ss", $_SESSION['user_id'], $_SESSION['session_id']);  // 's' denotes the parameter type (string)
					$query->execute();
					$query->close();
				} */


				//echo "<pre>";print_r($session_count);echo "</pre>";die();

			/************************************ start session_users end **************************************/
			
			user_logout_audits($conn, $user_id,$_SESSION['log_id'],'Logout: Session timed out due to inactivity');

			session_unset(); // Unset all session variables
			session_destroy(); // Destroy the session
			session_start();
			// Redirect to login page with a timeout message
			log_audit_trail($conn, $user_id, $action = 'logout', $details = 'Session timed out due to inactivity', $model = 'users', $record_id = $user_id, $old = 'login', $new = 'Auto logout');
			
			$_SESSION['msg'] = "Session timed out due to inactivity.";
			header("Location:" . $link . "/grievance/index.php");
			//header("Location: /?msg=Session timed out due to inactivity.");
			exit();
		}
	}

	$_SESSION['logged_in'] = true;
	$_SESSION['last_activity'] = time();

	/************************************ end session time out **************************************/

	// warning and showcause notices related code

	$sql_date_adjust = 'UPDATE  show_case_response_logs sl LEFT JOIN grievances g ON g.grievance_id = sl.grievance_id SET sl.date_regd = g.date_regd';

	mysqli_query($conn, $sql_date_adjust);

	$sql_row_number = ' UPDATE show_case_response_logs e JOIN ( SELECT warning_id, ROW_NUMBER() OVER (PARTITION BY emp_id ORDER BY date_regd) AS rn FROM show_case_response_logs)cte 
							ON cte.warning_id=e.warning_id 
							SET e.row_number = cte.rn ';

	mysqli_query($conn, $sql_row_number);

	$_SESSION['grievances_trns'] = "(SELECT gts.* FROM grievances_transactions gts INNER JOIN ( SELECT grievance_id, MAX(transaction_id) AS latest_transaction_id FROM grievances_transactions GROUP BY grievance_id ) latest_gt ON gts.grievance_id = latest_gt.grievance_id AND gts.transaction_id = latest_gt.latest_transaction_id and gts.emp_id!='')";
	$_SESSION['threshold_date'] = "2024-09-01";
	
	/* setcookie(
		"PHPSESSID",
		session_id(),
		[
			"expires"  => time() + (60 * 60 * 24 * 10), // 10 days
			"path"     => "/",
			"domain"   => "",              // leave blank unless using subdomain
			"secure"   => true,            // cookie only sent over HTTPS
			"httponly" => true,            // no Javascript access
			"samesite" => "Lax"            // Strict / Lax / None
		]
	); */

	return $conn;
}

function log_audit_trail($conn, $user_id, $action, $details = '', $model, $record_id, $old, $new)
{
	//echo "<pre>";print_r($model);echo "</pre>";die();
	// Get the user's IP address
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$sql = "INSERT INTO audit_trails (user_id, action, action_time,details, ip_address,model,record_id,old,new) VALUES (?,?,?,?,?,?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("sssssssss", $user_id, $action, date('Y-m-d h:m:s'), $details, $ip_address, $model, $record_id, $old, $new);
	$stmt->execute();

	return null;
}

function user_login_audits($conn, $user_id,$user_log_status='Loggedin')
{
	//echo "<pre>";print_r($model);echo "</pre>";die();
	// Get the user's IP address
	$ip_address = $_SERVER['REMOTE_ADDR'];
	
	$login_time = date('Y-m-d H:i:s');

	
		
		$sql = $conn->prepare("
			INSERT INTO user_logs
			(user_id,user_log_status, ip_address, login_time)
			VALUES (?,?,?,?)
		");

		$sql->bind_param(
			"ssss",
			$user_id,	
			$user_log_status,	
			$ip_address,
			$login_time
		);

		$sql->execute();
		return  $conn->insert_id;
	
	
}
function user_logout_audits($conn, $user_id,$log_id,$user_log_status)
{
	//echo "<pre>";print_r($model);echo "</pre>";die();
	// Get the user's IP address
	$ip_address = $_SERVER['REMOTE_ADDR'];
		
		$logout_time = date('Y-m-d H:i:s');

		$sql = $conn->prepare("
			UPDATE user_logs
			SET logout_time = ?, 
			user_log_status = ? 
			WHERE id = ?
		");

		$sql->bind_param(
			"ssi",
			$logout_time,
			$user_log_status,
			$log_id
		);

		$sql->execute();
			
	return null;
}

function sendSMS($mobile, $sms, $templateId)
{

	$message = str_replace(' ', '%20', $sms);
	$url = "";

	$post = curl_init();
	curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($post, CURLOPT_URL, $url);
	curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

	return curl_exec($post);
}



function generateCaptchaCode($length = 6)
{
	return substr(str_shuffle('abcdefghjklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, $length);
}

function base_url()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
	return $protocol . $_SERVER['HTTP_HOST'] . '/';
}

function base_url_link()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
	return $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
}

function set_flash($msg, $class = "alert alert-info")
{
	$_SESSION['flash_msg']   = $msg;
	$_SESSION['flash_class'] = $class;
}

function get_flash()
{
	if (!isset($_SESSION['flash_msg'])) {
		return null;
	}

	$flash = [
		"msg"   => $_SESSION['flash_msg'],
		"class" => $_SESSION['flash_class']
	];

	// Show only once
	unset($_SESSION['flash_msg'], $_SESSION['flash_class']);

	return $flash;
}