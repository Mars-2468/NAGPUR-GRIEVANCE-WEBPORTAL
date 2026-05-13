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

	$conn = mysqli_connect("localhost", "root", "", 'nagpurnewcsms_new') or die(mysqli_connect_error());

	/************************************ start session_users **************************************/

	//$session_timeout = 3600;// 1 hour    900 for 15mnts
	$session_timeout = 3600; //24*3600;// 1 day

	

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

function sendSMS($mobile, $sms, $templateId)
{

	$message = str_replace(' ', '%20', $sms);
	$url = "https://bulksmsservice.co.in/httpapi/v1/sendsms?api-token=1p,_7u4.ic9fdwje0z23)5th*nxmg8vosyklqa(r&numbers=" . $mobile . "&route=2&message=" . $message . "&sender=NMCGOV&template-id=" . $templateId;

	$post = curl_init();
	curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($post, CURLOPT_URL, $url);
	curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

	return curl_exec($post);
}

/*	//&priority=ndnd&stype=normal    -  add this end of every sms text
 	
	function sendSMS($mobile,$sms){		
		 
		$message = str_replace(' ', '%20', $sms);		
		return smsURL($mobile,$message);		
	}
	
	function smsURL($mobile,$message){
			
		$url="http://bhashsms.com/api/sendmsg.php?user=NMCGOV19&pass=123456&sender=NMCGov&phone=".$mobile."&text=".$message;

		$post = curl_init();
		curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($post, CURLOPT_URL, $url);
		curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);		
		
		return curl_exec($post);		
	} */

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

/* function encryptData($data, $key="my_secret_key_12345") {
    $cipher = "AES-256-CBC";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    
    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
    
    // Combine IV + encrypted data
    return base64_encode($iv . $encrypted);
}

function decryptData($data, $key="my_secret_key_12345") {
    $cipher = "AES-256-CBC";
    
    $data = base64_decode($data);
    $iv_length = openssl_cipher_iv_length($cipher);
    
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    
    return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
} */



    function encryptData($data, $key = '12345678901234567890123456789012') {
        $cipher = 'aes-256-cbc';
        $ivLen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLen);

        $encrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        if ($encrypted === false) return false;

        return bin2hex($iv . $encrypted); // safe for URL and storage
    }



    function decryptData($hexData, $key = '12345678901234567890123456789012') {
        $cipher = 'aes-256-cbc';
        $data = hex2bin($hexData);

        if ($data === false) return false;

        $ivLen = openssl_cipher_iv_length($cipher);
        $iv = substr($data, 0, $ivLen);
        $ciphertext = substr($data, $ivLen);

        $decrypted = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted !== false ? $decrypted : false;
    }
