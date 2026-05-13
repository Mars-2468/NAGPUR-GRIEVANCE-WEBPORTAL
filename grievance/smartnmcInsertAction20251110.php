
<?php
session_start();
require_once('connection.php');
//include('prepare_connection.php');
require_once 'submission_throttle_helper.php';
$conn = getconnection();

$captcha_code=$_SESSION['code'];
$captcha=$_POST['captcha'];



/* // Limit: max 1 visits per 60 seconds
$is_allowed = rate_limit_check(1, 60);

//echo "<pre>";print_r($is_allowed);echo "</pre>";die();


if (!$is_allowed) {
	 $_SESSION['error_message'] = "Error: Limit: max 1 visits per 60 seconds!";
	header("Location: smartnmcInsert.php");
	exit;
} */

// Allow submission only every 10 seconds per user
check_submission_throttle('rating_form', 60);



if ($captcha_code==$captcha) {
	
  
 // Helper function to strip and validate HTML/script tags
function clean_input($field_name, $input) {
    $input = strip_tags($input);
    if (preg_match('/<[^>]*>/', $input)) {
        $_SESSION['error_message'] = "Error: HTML or script tag detected in '{$field_name}' field!";
        header("Location: smartnmcInsert.php");
        exit;
    }
	
	$input = preg_replace('/\bthis\s*=\s*null\b/i', '', $input);             
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Encode special chars
    return trim($input);   
}

// Clean and validate inputs
$name        = clean_input('Name', $_POST['name'] ?? '');
$mobile      = clean_input('Mobile', $_POST['mobile'] ?? '');
$email       = clean_input('Email', $_POST['email'] ?? '');
$address     = clean_input('Address', $_POST['address'] ?? '');
$idea_desc   = clean_input('Description', $_POST['description'] ?? '');
$department  = clean_input('Department', $_POST['department'] ?? '');
	
	
  // ECHO "HI"; exit();
  date_default_timezone_set('Asia/Calcutta');
  $date_new = date("Y-m-d H:i:s"); // time in India

$sql = "INSERT INTO smart_idea_box (
            ulbid, name, mobile, email, address, idea_desc, ts, imei, sib_dept_id, updated_through
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $ulbid = '250'; // or use a variable if dynamic
    $imei = $mobile;
    $updated_through = '1';

    $stmt->bind_param("ssssssssss", 
        $ulbid, $name, $mobile, $email, $address, $idea_desc, $date_new, $imei, $department, $updated_through
    );

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "The form has been submitted successfully.";
        header("Location: smartnmcInsert.php");
        exit;
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

}else{
	echo "Did not match the captcha!";
}

?>