<?php
/*date_default_timezone_set('Asia/Calcutta');
require_once('send_sms.php');
require_once('sms_conf.php');
$mobile = $_REQUEST['mobile'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$sms="url: https://municipalservices.in/illiteratesurvey/\n";
$sms.="username :" . $username."\n Password: " . $password;*/

               // require_once('send_sms.php');
                $datetime = date('Y-m-d H:i:s');
				$otp    = rand(1000,9999);
				$emailotp = rand(1000,9999);
				$otpexpiredatetime1 = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($datetime)));
				
			
			
			
    		  $message1  = "hi this is test msg"."1234";
    		  $message   = str_replace (' ', ' ',$message1);
    		  $mobileno  = "9290188864";
			  //$message="hi";
			  $_REQUEST["user_name"] = 'abcd';
			  $uName = 'EFGH'; 
			  $otp = 1234;
        	$message1  = "Dear ".$_REQUEST["user_name"].",Thanks for downloading ".$uName." citizen buddy application,Your OTP for registration is ".$otp;
            $message   = str_replace (' ', ' ',$message1);
           // $message   = "Dear abcd,Thanks for downloading EFGH citizen buddy application,Your OTP for registration is 1234";

              $username="cdmatelangana";
              $encryp_password =sha1(trim('Cdmats@4321'));
              $senderid = "TSMCPL";
              $deptSecureKey="65ff1daa-95e8-49b5-a954-1a41a9bfabb3";
              
                $key=hash('sha512',trim($username).trim($senderid).trim($message).trim($deptSecureKey));
                $data = array(
                "username" => trim($username), 
                "password" => trim($encryp_password), 
                "senderid" => trim($senderid), 
                "content"  => trim($message), 
                "smsservicetype" =>"otpmsg", 
                "mobileno" => trim($mobileno),
                "key"      => trim($key)
                );
                post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data);
                
                function post_to_url($url, $data) 
                {
                    
                   // print_r($data);die();
                    $fields = '';
                    foreach($data as $key => $value) {
                    $fields .= $key . '=' . $value . '&';
                    }
                    rtrim($fields, '&');
                    $post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_POST, count($data));
                    curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($post); //result from mobile seva server
                    echo $result; //output from server displayed
                    curl_close($post);
                }
            
?>