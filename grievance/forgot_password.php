<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
		
	require_once('send_sms.php');
	require_once('sms_conf.php');

	$verify_otp_status = 0;
	$sent_otp_status = 0;
    $change_pwd_status = 0;
	
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
        function curPageURL() {
            $pageURL = 'http';
            if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
              $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].'/grievance/';
            } else {
              $pageURL .= $_SERVER["SERVER_NAME"] ;
            }
            return $pageURL;
        }
        
         $tpl->assign('base_url', curPageURL());
		if(isset($_POST['send_otp']))
		{
		    if(isset($_POST['mobile'])){
		        
		        $_SESSION['mobile'] = $_POST['mobile'];
		        
		        $check_emp_query = "SELECT * FROM `users` WHERE `user_mobile` = '".$_POST['mobile']."' AND `user_type` = 'E'";
		        $ceq_res = mysqli_query($conn, $check_emp_query);
                $ceq_res_count = mysqli_num_rows($ceq_res);
		        if( $ceq_res_count > 0){
		            $user_mobile = $_POST['mobile'];
                    $datetime = date('Y-m-d H:i:s');
                    $otp = rand(1000, 9999);
                    
                    $minutes_to_add = 5;
                    $time = new DateTime();
                    $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                    $stamp = $time->format('Y-m-d H:i');
                    $otpExpiryDate = strtotime("date('Y-m-d H:i:s') + 5 minute");
                        
                    $sql = "insert into user_otp_logs(user_ip, mobile, otp, otp_date_time, otp_expiry_date, otp_status )
                    values('" . $_SERVER['REMOTE_ADDR'] . "', '" . $user_mobile . "', '" . $otp . "', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s', strtotime($stamp)) . "', '0' )";
                    
                    if(mysqli_query($conn, $sql)){
                        
                    	$sms = "Your OTP for CSMS password reset/change is ".$otp." and it is valid for 5 mins from now. DO NOT SHARE TO ANYONE. NMCGOV.";
                		$mobile = $user_mobile;
                	    $templateId = "1707167887923702557";
                	 /*    $message =str_replace ( ' ', '%20', $sms);
                	    $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                	    
                	    $post = curl_init();
                        curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($post, CURLOPT_URL, $url);
                        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                        $result=curl_exec($post); */
                        
						$result=sendSMS($mobile,$sms,$templateId);
                       
                    }
                    
    		        $sent_otp_status = 1;
		        }else{
		            $tpl->assign('mobile_error', 'Please Try with Registered Mobile Number.');
		        }
                
		    }
		    
		}
		if(isset($_POST['verify_otp']))
		{
		    if(isset($_POST['otp'])){
		        $otp = $_POST['otp'];
		        $mobile =  $_SESSION['mobile'];
		        $sql = "select * from user_otp_logs where otp='" . $otp . "' and mobile='" . $mobile . "' and otp_status=0";
                $rs = mysqli_query($conn, $sql);
                $nr = mysqli_num_rows($rs);
                
                if ($nr > 0){
                    while($row = mysqli_fetch_assoc($rs)){
                        $date1 = $row['otp_expiry_date'];
                    }
                    $currentDate = date('Y-m-d H:i:s');
                    $currentDate = date('Y-m-d H:i:s', strtotime($currentDate));
                    

                    
                    $dt1 = new DateTime($date1);
                    $dt2 = new DateTime($currentDate);
                    $interval = $dt1->diff($dt2);
                    
                    // echo $interval->format('%i');
                    // echo $interval->format('%s');
                    // die();
                    // $tpl->assign('minutes', $interval->format('%i'));
                    // $tpl->assign('seconds', $interval->format('%s'));
            
                    if ($date1 > $currentDate)
                    {
                        // echo "Active";
                        $expriry_status = 1;
                        $verify_otp_status = 0;
                    
                    }else{
                        $url = curPageURL()."/grievance/forgot_password.php";
                        echo "<script>window.location='" . $url . "';</script>";
                        // echo "Expired";
                        $expriry_status = 0;
                        $otp_err_msg = "Enter Valid OTP";
                        $verify_otp_status = 1;
                        $sent_otp_status = 1;
                    }
                }
                
                if ($nr > 0 && $expriry_status == 1) {
                    $sql = "update user_otp_logs set otp_status=1 where otp='" . $otp . "' and mobile='" . $mobile . "'";
                    if (mysqli_query($conn, $sql)) {
                            $sent_otp_status = 1;
            		        $verify_otp_status = 1;
            		        $change_pwd_status = 1;
                    } else {
                        echo "Something went wrong . Try again";
                    }
                } 
                
                else {
                    if($expriry_status == 0){
                        $tpl->assign('otp_expired', 'OTP expired');
                    }
                    $tpl->assign('otp_err', 'Invalid OTP');
                    
                    $otpstaus = 1;
                    $sent_otp_status = 1;
                }
		    }
		    
		}
		if(isset($_POST['change_password'])){

		    $sql="UPDATE users SET user_pwd = PASSWORD('".mysqli_real_escape_string($conn,sha1(md5($_POST['new_pwd'])))."') WHERE user_mobile = '". $_SESSION['mobile']."'";
		    
			$insert_id = mysqli_query($conn,$sql);
			if($insert_id)
			{
				$url = curPageURL();
                // print_r($url);exit();
                $message = "You have changed your password Successfully.";
                echo "<script>alert('$message');</script>";
                echo "<script>window.location='" . $url . "';</script>";

			}
			else
			{
                
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
			}
		}

        $tpl->assign('sent_otp_status', $sent_otp_status);
		$tpl->assign('verify_otp_status', $verify_otp_status);
        $tpl->assign('change_pwd_status', $change_pwd_status);
		$tpl->display('forgot_password.tpl');

?>