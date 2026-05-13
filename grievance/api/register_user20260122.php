<?php
ini_set('display_errors', 0);
require_once('../connection.php');
require_once('../send_sms.php');
require_once('../check_access_key.php');
$conn = getconnection();

date_default_timezone_set('Asia/Calcutta');

// Get JSON raw data from the request

//$json = file_get_contents('php://input');
//$data = json_decode($json, true);

$data= $_POST;

$data['user_mobile']=$data['user_id'];

//file_put_contents("user_data20251013.json", json_encode($data, JSON_PRETTY_PRINT));

$apk_version = $data['apk_version'] ?? '';
require_once('check_version.php');

// Access Key Validation
if (!empty($data['access_key'])) {
    $check_access_key_status = ($access_key == $data['access_key']) ? 1 : 0;
    if ($check_access_key_status != 1) {
        echo json_encode(['status_code' => 401, 'message' => 'unauthorized']);
        die;
    }
} else {
    echo json_encode(['status_code' => 422, 'message' => 'Missing Access key']);
    die;
}

// Input Validation
if (!empty($data["user_id"]) && !empty($data["user_name"])) {
    $ulbsql = "SELECT * FROM ulbmst JOIN ulb_type ON ulb_type=ulb_type_id WHERE ulbid='" . $data['ulbid'] . "'";
    $ulbrs1 = mysqli_query($conn, $ulbsql);
    $ulbName = mysqli_fetch_assoc($ulbrs1);
    $uName = $ulbName['ulbname'];

    if ($data['login_status'] == 1) {
        $sql = "SELECT * FROM users_test WHERE user_id='" . $data["user_id"] . "' AND id NOT IN('" . $data['id'] . "')";
        $rs = mysqli_query($conn, $sql);
        $nr = mysqli_num_rows($rs);
        $errors = 0;

        if ($nr > 0) {
            $response = ['status_code' => 100, 'msg' => "mobile number already existed", "version" => "1.1"];
            $errors++;
        }

        if ($errors == 0) {
            $sql = "UPDATE users_test SET user_id='" . $data["user_id"] . "', user_email='" . $data["user_email"] . "', user_name='" . $data["user_name"] . "', ulbid='" . $data['ulbid'] . "' WHERE id='" . $data["id"] . "'";
        } else {
            exit(json_encode($response));
        }
    } else {
        $sql = "SELECT * FROM users_test WHERE user_id='" . $data["user_id"] . "'";
        $rs = mysqli_query($conn, $sql);
        $nr = mysqli_num_rows($rs);
        $errors = 0;

        if ($nr > 0) {
            $response = ['status_code' => 100, 'msg' => "mobile number already existed", "version" => "1.1"];
            $errors++;
        }

        if ($errors == 0) {
            try {
                $sql = "INSERT INTO users_test(user_id, user_name, user_email, user_type, created_at, ulbid, login_status)
                        VALUES('" . $data["user_id"] . "','" . $data["user_name"] . "','" . $data["user_email"] . "','D','" . date("Y-m-d H:i:s") . "','" . $data['ulbid'] . "','2')";
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            exit(json_encode($response));
        }
    }


//echo json_encode($sql);

    if (mysqli_query($conn, $sql)) {
        // Send OTP
        $datetime = date('Y-m-d H:i:s');
        $otp = rand(1000, 9999);
        $otpexpiredatetime1 = date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime($datetime)));

        $updateuser = "UPDATE users_test SET otp='$otp', otpdatetime='$datetime', otpexpiretime='$otpexpiredatetime1', otp_status='1', emailOtp='$otp' 
                       WHERE user_id='" . $data["user_id"] . "' AND ulbid='" . $data['ulbid'] . "'";
        $updateres = mysqli_query($conn, $updateuser);

       // $sms = "One Time Password (OTP) for NMC application logging is $otp. Please use this OTP for logging NMCGov. Pls do not share this with anyone. Valid for 5 minutes.&priority=ndnd&stype=normal";
        $sms = "One Time Password (OTP) for NMC application logging is $otp. Please use this OTP for logging NMCGov. Pls do not share this with anyone. Valid for 5 minutes.";
        $user_mobile = $data["user_id"];
        $templateId='1707170780475551415';
		$result = sendSMS($user_mobile, $sms,$templateId);

        $eee = $data["user_email"];
        $mailbody = 'Dear ' . $data["user_name"] . ',<br>Thanks for downloading Smart Nagrik application,<br>Your OTP for registration is <b>' . $otp . '</b>';

        // Send email via ZeptoMail
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zeptomail.com/v1.1/email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                "bounce_address" => "madhu@bounce.egovindia.co.in",
                "from" => [
                    "address" => "noreply@egovindia.co.in",
                    "name" => "Municipal Services Email OTP for Registration"
                ],
                "to" => [[
                    "email_address" => [
                        "address" => $eee,
                        "name" => $data["user_name"]
                    ]
                ]],
                "subject" => "Municipal Services Email OTP for Registration",
                "htmlbody" => $mailbody
            ]),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Zoho-enczapikey YOUR_API_KEY_HERE",
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response_mail = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $response = [
            'status_code' => 200,
            'user_id' => $data["user_id"],
            'user_type' => 'D',
            'ulbid' => $data['ulbid'],
            'otp' => $otp,
            'emailotp' => $otp,
            'otp_status' => 1,
            'msg' => 'OTP sent to your mobile number',
            "version" => "1.1"
        ];
    } else {
        $response = ['status_code' => 100, 'msg' => "Try Again", "version" => "1.1"];
    }
} else {
    $response = ['status_code' => 100, 'msg' => "All fields are required", "version" => "1.1"];
}

exit(json_encode($response));
?>
