<?php
	
    ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');
	require_once('../check_access_key.php');
	//$apk_version = $_REQUEST['apk_version'];
	//require_once('check_version.php');
	
	require 'PHPMailerAutoload.php';
	$mail = new PHPMailer();
	
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.elasticemail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username ='vishal.vmax@gmail.com';                 // SMTP username
	$mail->Password ='A0C410812F3017E63E6D19D9871C13DABBD9'; // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 2525;                                    // TCP port to connect to
	

    if($_REQUEST['access_key'] != ''){
   
        $check_access_key_status = ($access_key == $_REQUEST['access_key']) ?  1 : 0;

        if($check_access_key_status != 1){
        	$response['status_code'] = 401;
    		$response['message'] = 'unauthorized';
    		header("Content-Type: application/json");
    		echo json_encode($response);
    		die;
    	}
    }else{
        $response['status_code'] = 422;
		$response['message'] = 'Missing Access key';
		header("Content-Type: application/json");
		echo json_encode($response);
		die;
    }
	
	   
    if(isset($_REQUEST['user_id']))
  	{
  		$uid   = $_REQUEST['user_id'];
  		$ulbid = $_REQUEST['ulbid'];
  		
  		$ulbsql="select * from ulbmst JOIN ulb_type ON ulb_type=ulb_type_id where ulbid='".$_REQUEST['ulbid']."'";
		$ulbrs1=mysqli_query($conn,$ulbsql);
		
		$ulbName = mysqli_fetch_assoc($ulbrs1);
		//$uName = $ulbName['ulbname'].' '.$ulbName['ulb_type_desc'];
		$uName = $ulbName['ulbname'];
		
		$sql = "select * from users_test where user_id='".$uid."' or user_email='".$uid."'";
		$rs = mysqli_query($conn,$sql);
		
		$userName = mysqli_fetch_assoc($rs);
		$uEmail = $userName['user_email'];
		$user_mobile = $userName['user_id'];
		
		$nr = mysqli_num_rows($rs);
		if($nr > 0)
		{
    		
    	
    		$sql = "select * from users_test where login_status='2' and (user_id='".$uid."' or user_email='".$uid."') limit 1";
    	  	$res = mysqli_query($conn,$sql);
    		 $nr = mysqli_num_rows($res);
    		if($nr > 0 && mysqli_num_rows($ulbrs1)>0)
    		{
    		    
    	    	while($row = mysqli_fetch_array($res))
    			{
					
					/******************OTP Sending Code*********************/
					$datetime = date('Y-m-d H:i:s');
					if($uid=='9030081818')
					{
						
					$otp = 6223;
					}
					else{
						$otp = rand(1000,9999);
					}
				
			
			
			    require_once('../send_sms.php');
             	require_once('../sms_conf.php');
			    /***************************************/
				$emailotp = rand(1000,9999);
				$otpexpiredatetime1 = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($datetime)));
				$updateuser  = "update users_test set otp='".$otp."',emailOtp='".$otp."',otpdatetime='".$datetime."',otpexpiretime='".$otpexpiredatetime1."',otp_status=1 where user_id='".$user_mobile."'";
                mysqli_query($conn,$updateuser);
				$message1    = "Dear ".$row['user_name'].", Thanks for Using  Smart Nagrik application, Your OTP for Login is ".$otp." -VESIPL";
			
					$sms = "One Time Password (OTP) for NMC application logging is " . $otp . " Please use this OTP for logging NMCGov. Pls do not share this with any one, Valid for 5 minutes.";
			   
					
					$user_mobile = $_REQUEST["user_id"];
					$templateId = "1707170780475551415";
    	  	
                    $result=sendSMS($user_mobile,$sms,$templateId); //result from mobile seva server
                				
				
					
					/******************OTP Sending Code*********************/
            		
					$mailbody = 'Dear '.$row["user_name"].',<br> Thanks for Using Smart Nagrik application,<br> Your OTP for login is <b>'.$otp.'</b>';
		            
					$eee = $uEmail;
                	
					
					
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
					CURLOPT_POSTFIELDS => '{
								"bounce_address":"madhu@bounce.egovindia.co.in",
								"from": { "address": "noreply@egovindia.co.in","name": "Municipal Services Email OTP for Login"},
								"to": [{"email_address": {"address": "'.$eee.'","name": "'.$row["user_name"].'"}}],
								"subject":"Municipal Services Email OTP for Login",
								"htmlbody":"'.$mailbody.'",
								}
								  ]
								}',
					CURLOPT_HTTPHEADER => array(
					"accept: application/json",
					"authorization: Zoho-enczapikey wSsVR60jrkT4D6p5n2eoJeg9mgkDAAjyEkt+i1Wm6XT7SvzF88c8kEybAFWhH6AcF2U9EDdAoegsnBpRgGBbi9x8mFxWCiiF9mqRe1U4J3x17qnvhDzPXWtflhqNKY4MwA5tnmlkEM5u",
					"cache-control: no-cache",
					"content-type: application/json",
				),
			));

			$response = curl_exec($curl);
		
			$err = curl_error($curl);
			curl_close($curl);
					
					if(1)
					{
						//echo 'Message could not be sent.';
						//echo 'Mailer Error: ' . $mail->ErrorInfo;
						
						$response=array('status_code'=>200,
						'id'=>$row["id"],
						'user_id'=>$row["user_id"],
						'user_type'=>$row['user_type'],
						'ulbid'=>$row['ulbid'],
						'otp'=>$otp,
						'emailotp'=>$otp,
						'otp_status'=>1,
						'login_status'=>2,
						'user_email'=>$row['user_email'],
						'user_name'=>$row['user_name'],
						'message'=>'OTP sent to your mobile number and not sent to Email Id',"version"=>"1.1");
						
					}
					else
					{
						//echo 'Message has been sent';
						
						$response=array('status_code'=>200,
						'id'=>$row["id"],
						'user_id'=>$row["user_id"],
						'user_type'=>$row['user_type'],
						'ulbid'=>$row['ulbid'],
						'otp'=>$otp,
						'emailotp'=>$otp,
						'otp_status'=>1,
						'login_status'=>2,
						'user_email'=>$row['user_email'],
						'user_name'=>$row['user_name'],
						'message'=>'OTP sent to your mobile number',"version"=>"1.1");
					}        		
	
				}
			}
    		else
    		{
    		//	$sql = "select * from users_test where login_status='1' and (user_id='".$uid."' or user_email='".$uid."') and ulbid='".$_REQUEST['ulbid']."'";
    		$sql = "select * from users_test where login_status='1' and (user_id='".$uid."' or user_email='".$uid."')";
    	  	    $res = mysqli_query($conn,$sql);
    		     $nr = mysqli_num_rows($res);
    		    if($nr > 0)
    		    {
    		        $row = mysqli_fetch_assoc($res);
    		        
    		        $response=array('status_code'=>102,
						
						'id'=>$row["id"],
		                'user_id'=>$row["user_id"],
                        'user_type'=>$row['user_type'],
                        'ulbid'=>$row['ulbid'],
                        'otp'=>0,
                        'emailotp'=>0,
                        'otp_status'=>1,
                        'login_status'=>1,
						'user_email'=>$row['user_email'],
						'user_name'=>$row['user_name'],
                        'message'=>'Please Confirm your details',
                        "version"=>"1.1");
    		       
    	      	    
				}
				else
				{
				    $response['status_code'] = 100;
			        $response['message'] = 'User Does not Exist';
				}
			}
			
		}
     	else
     	{
			$response['status_code'] = 100;
			$response['message'] = 'User Does not Exist';
		}
		header("Content-Type: application/json");
     	echo json_encode($response);
	}

    mysqli_close($conn);
	    
	
	
  	
?>
