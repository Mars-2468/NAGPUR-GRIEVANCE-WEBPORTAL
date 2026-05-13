<?php
	
	ini_set('display_errors',0);
	require_once('../connection.php');
	require_once('../send_sms.php');
	require_once('../check_access_key.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	date_default_timezone_set('Asia/Calcutta');
	
	require 'PHPMailerAutoload.php';
	$mail = new PHPMailer();
	
// 	 header("Content-Type: application/json");

//echo $_REQUEST['access_key'];

//echo $_REQUEST['user_name'];


	if($_REQUEST['access_key'] != ''){
      $check_access_key_status = ($access_key == $_REQUEST['access_key']) ?  1 : 0;

        if($check_access_key_status != 1){
        $response['status_code'] = 401;
          $response['message'] = 'unauthorized';
          echo json_encode($response);
          die;
        }
    }else{
        $response['status_code'] = 422;
        $response['message'] = 'Missing Access key';
        echo json_encode($response);
        die;
    }
	
	
	if(!empty($_REQUEST["user_id"]) && !empty($_REQUEST["user_name"])) //&& !empty($_REQUEST["user_email"])
	{ 
		$ulbsql="select * from ulbmst JOIN ulb_type ON ulb_type=ulb_type_id where  ulbid='".$_REQUEST['ulbid']."'";
		$ulbrs1=mysqli_query($conn,$ulbsql);
		
		$ulbName = mysqli_fetch_assoc($ulbrs1);
		//$uName = $ulbName['ulbname'].' '.$ulbName['ulb_type_desc'];
		
		$uName = $ulbName['ulbname'];
		
		
		
		
	
	/*	$sql1="select * from users_test where user_id='".$_REQUEST["user_id"]."'";
		$rs1=mysqli_query($conn,$sql1);
		if(mysqli_num_rows($rs1)==0 && (mysqli_num_rows($ulbrs1)>0))
		{*/
		    if($_REQUEST['login_status']==1)
    		{
    		    
    		    //$sql ="select * from users_test where user_id='".$_REQUEST["user_id"]."' and ulbid='".$_REQUEST["ulbid"]."' and id not in('".$_REQUEST['id']."')";
    		    $sql ="select * from users_test where user_id='".$_REQUEST["user_id"]."' and id not in('".$_REQUEST['id']."')";
    		    $rs = mysqli_query($conn,$sql);
    		    $nr = mysqli_num_rows($rs);
    		    $errors=0;
    		    if($nr > 0)
    		    {
    		        $response=array('status_code'=>100,'msg'=>"mobile number already existed","version"=>"1.1");
    		        $errors++;
    		    }
    		     //$sql ="select * from users_test where user_email='".$_REQUEST["user_email"]."' and ulbid='".$_REQUEST["ulbid"]."' and id not in('".$_REQUEST['id']."')";
    		    /* $sql ="select * from users_test where user_email='".$_REQUEST["user_email"]."' and id not in('".$_REQUEST['id']."')";
    		     $rs = mysqli_query($conn,$sql);
    		     $nr2 = mysqli_num_rows($rs);
    		      if($nr2 > 0)
        		    {
        		        $response=array('status_code'=>100,'msg'=>"Email already existed","version"=>"1.1");
        		        $errors++;
        		    }*/
        		   
        		   if($errors==0) 
        		   {
    		    
		 	         $sql ="update users_test set user_id='".$_REQUEST["user_id"]."',user_email='".$_REQUEST["user_email"]."',user_name='".$_REQUEST["user_name"]."',ulbid='".$_REQUEST['ulbid']."' where id='".$_REQUEST["id"]."'";
    		       } 
    		       else
    		       {
    		           $encoded = json_encode ($response);
	                   //header ('Content-type: application/json');
	                   exit ($encoded);
    		           
    		       }
    		}
    		else
    		{
    		    //$sql ="select * from users_test where user_id='".$_REQUEST["user_id"]."' and ulbid='".$_REQUEST["ulbid"]."'";
    		    $sql ="select * from users_test where user_id='".$_REQUEST["user_id"]."'";
    		    $rs = mysqli_query($conn,$sql);
    		    $nr = mysqli_num_rows($rs);
    		    $errors=0;
    		    if($nr > 0)
    		    {
    		        $response=array('status_code'=>100,'msg'=>"mobile number already existed","version"=>"1.1");
    		        $errors++;
    		    }
    		     /*$sql ="select * from users_test where user_email='".$_REQUEST["user_email"]."' and ulbid='".$_REQUEST["ulbid"]."'";
    		     $rs = mysqli_query($conn,$sql);
    		     $nr2 = mysqli_num_rows($rs);
    		      if($nr2 > 0)
        		    {
        		        $response=array('status_code'=>100,'msg'=>"Email already existed","version"=>"1.1");
        		        $errors++;
        		    }*/
        		    
        		    
        		   
        		   if($errors==0) 
        		   {
    		            
    		            try{
    		                $sql="INSERT INTO users_test(user_id,user_name,user_email,user_type,created_at,ulbid,login_status) VALUES('".$_REQUEST["user_id"]."','".$_REQUEST["user_name"]."','".$_REQUEST["user_email"]."','D','".date("Y-m-d H:i:s")."','".$_REQUEST['ulbid']."','1')";
    		            }
    		            catch(exception $e){
    		                echo $e->getMessage();
    		            }
    		            
		 	         
    		       } 
    		       else
    		       {
    		           $encoded = json_encode ($response);
	                   header ('Content-type: application/json');
	                   exit ($encoded);
    		           
    		       }
    		    
    		}
    		
			if(mysqli_query($conn,$sql))
			{
			   // require_once('../send_sms.php');
             //	require_once('../sms_conf.php');
			    /***************************************/
				$datetime = date('Y-m-d H:i:s');
				$otp      = rand(1000,9999);
				$emailotp = rand(1000,9999);
				$otpexpiredatetime1 = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($datetime)));
				$updateuser  ="update users_test set otp='".$otp."',otpdatetime='".$datetime."',otpexpiretime='".$otpexpiredatetime1."',otp_status='1',emailOtp='".$otp."'  where user_id='".$_REQUEST["user_id"]."' and ulbid='".$_REQUEST['ulbid']."'";
				$updateres   = mysqli_query($conn,$updateuser);
				//  $message1    = "Dear ".$_REQUEST["user_name"].", Thanks for downloading ".$uName." citizen buddy application, Your OTP for registration is ".$otp.'-TSMCPL';
				 //$message1    = "Dear ".$_REQUEST["user_name"].", Thanks for downloading Smart Nagrik application, Your OTP for registration is ".$otp.' -VESIPL';
				//$message     = str_replace ( ' ', ' ', $message1);
				
				$message1="Dear Customer, Your OTP for Login is ".$otp.". Use this OTP to Validate, Thank you. Regards, AMCORP";
				$message =str_replace ( ' ', '%20', $message1);
				$user_mobile = $_REQUEST["user_id"];
				//$templateId = "1707170780475551415";
				
				$data = [];
                    
			  /*$username="cdmatelangana";
              $encryp_password =sha1(trim('Cdmats@4321'));
              $senderid = "TSMCPL";
              $deptSecureKey="65ff1daa-95e8-49b5-a954-1a41a9bfabb3";
              
              $templateId = "1707161226431975743";
			
                    $key=hash('sha512',trim($username).trim($senderid).trim($message1).trim($deptSecureKey));
                    $data = array(
                    "username" => trim($username),
                    "password" => trim($encryp_password),
                    "senderid" => trim($senderid),
                    "content"  => trim($message1),
                    "smsservicetype" =>"otpmsg",
                    "mobileno" =>trim($user_mobile),
                    "key"      => trim($key),
                    'templateid' => $templateId
                    );
                    

                    $url = "https://msdgweb.mgov.gov.in/esms/sendsmsrequestDLT";
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
                    //echo $result; //output from server displayed
                    curl_close($post);*/
				
		    	//send_sms($message,$user_mobile);
			
				
				$message1 = "One Time Password (OTP) for NMC application logging is ".$otp." Please use this OTP for logging NMCGov. Pls do not share this with any one, Valid for 5 minutes.";	
				$user_mobile = $_REQUEST["user_id"];
				$templateId = "1707170780475551415";
				$message =str_replace ( ' ', '%20', $message1);
				$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $user_mobile . "&message=" . $message;
			
				
				
			
				
				//$url ="https://manage.smssolutions.in/smsapi/index?key=35FD85B7BD7DA4&campaign=0&routeid=16&type=text&contacts=".$user_mobile."&senderid=VESIPL&msg=".$message;
				
				//$url ="http://smsatm.net/v3/api.php?username=ASCDCL&apikey=c01f32640f54e44f7660&senderid=AMCGOV&templateid=1707164421981494371&mobile=".$user_mobile."&message=".$message;
				//$url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=1707170780475551415&mobile=" . $user_mobile . "&message=" . $message;
				///echo $message;
				
				
				$post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_POST, count($data));
                    curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post); //result from mobile seva server
                    
                    //output from server displayed
                    curl_close($post);
				
				
				/***************************************/
				
				$eee = $_REQUEST["user_email"];
				$mailbody = 'Dear '.$_REQUEST["user_name"].',<br> Thanks for downloading Smart Nagrik application,<br> Your OTP for registration is <b>'.$otp.'</b>';
				
				/*$mail->isSMTP();                                          // Set mailer to use SMTP
				$mail->Host = 'smtp.elasticemail.com';                    // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                                   // Enable SMTP authentication
				$mail->Username ='vishal.vmax@gmail.com';                 // SMTP username
				$mail->Password ='A0C410812F3017E63E6D19D9871C13DABBD9';  // SMTP password
				$mail->SMTPSecure = 'tls';                                // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 2525;                                       // TCP port to connect to
				
				$eee = $_REQUEST["user_email"];
				
				//$mail->setFrom('noreply@tsmcpl.in', $ulbName['ulbname'].' '.$ulbName['ulb_type_desc']);
				$mail->setFrom('cdma@egovindia.in', $ulbName['ulbname'].' '.$ulbName['ulb_type_desc']);
				$mail->ClearReplyTos();
				$mail->addReplyTo('cdmasites@gmail.com', $ulbName['ulbname'].' '.$ulbName['ulb_type_desc']);
				$mail->addAddress($eee, '');     // Add a recipient
				$mail->isHTML(true);   
				
				$mail->Subject = 'Municipal Services Email OTP for Registration';
				
				$mail->Body = $mailbody;*/
				
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
                    "from": { "address": "noreply@egovindia.co.in","name": "Municipal Services Email OTP for Registration"},
                    "to": [{"email_address": {"address": "'.$eee.'","name": "'.$_REQUEST["user_name"].'"}}],
                    "subject":"Municipal Services Email OTP for Registration",
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
//print_r($response);
$err = curl_error($curl);
curl_close($curl);
				
				
				
				if(!$mail->send())
				{
					//echo 'Message could not be sent.';
					//echo 'Mailer Error: ' . $mail->ErrorInfo;
					
					$response=array('status_code'=>200,
					'user_id'=>$_REQUEST["user_id"],
					'user_type'=>'D',
					'ulbid'=>$_REQUEST['ulbid'],
					'otp'=>$otp,
					'emailotp'=>$otp,
					'otp_status'=>1,
					'msg'=>'OTP sent to your mobile number',"version"=>"1.1");
					
				}
				else
				{
					//echo 'Message has been sent';
					
					$response=array('status_code'=>200,
					'user_id'=>$_REQUEST["user_id"],
					'user_type'=>'D',
					'ulbid'=>$_REQUEST['ulbid'],
					'otp'=>$otp,
					'emailotp'=>$otp,
					'otp_status'=>1,
					'msg'=>'OTP sent to your mobile number',"version"=>"1.1");
				} 
				
				
			}
			else
			{    
			    
			    $sql ="SELECT * FROM `users_test` WHERE `user_id` LIKE '".$_REQUEST['user_id']."' and ulbid='".$_REQUEST['ulbid']."'";
			    $rs=mysqli_query($conn,$sql);
			    $nr = mysqli_query($conn,$sql);
			    if($nr > 0)
			    {
			        $row = mysqli_fetch_assoc($rs);
			        
			        
			        
			        if($row['id'] != $_REQUEST['id'])
			        {
			            
			            $response=array('status_code'=>100,'msg'=>"mobile number already existed","version"=>"1.1");
			        }
			        else
			        {
			            
        			    //$sql ="SELECT * FROM `users_test` WHERE `user_email` LIKE '".$_REQUEST["user_email"]."' and ulbid='".$_REQUEST['ulbid']."'";
        			   /* $sql ="SELECT * FROM `users_test` WHERE `user_email` LIKE '".$_REQUEST["user_email"]."'";
        			    $rs=mysqli_query($conn,$sql);
        			    $nr = mysqli_query($conn,$sql);
        			    if($nr > 0)
        			    {
        			        $row = mysqli_fetch_assoc($rs);
        			         if($row['id'] != $_REQUEST['id'])
			                    {
        			              $response=array('status_code'=>100,'msg'=>"Email already existed","version"=>"1.1");
			                    }
        			    }
        			    else
        			    {
        			        
        			    }*/
			        }
			        
			        
			        
			        
			        
			    }
			    else
			    {
			    
			    
    			   /* //$sql ="SELECT * FROM `users_test` WHERE `user_email` LIKE '".$_REQUEST["user_email"]."' and ulbid='".$_REQUEST["ulbid"]."'";
    			    $sql ="SELECT * FROM `users_test` WHERE `user_email` LIKE '".$_REQUEST["user_email"]."'";
    			    $rs=mysqli_query($conn,$sql);
    			    $nr = mysqli_query($conn,$sql);
    			    if($nr > 0)
    			    {
    			        if($row['id'] != $_REQUEST['id'])
			                    {
        			              $response=array('status_code'=>100,'msg'=>"Email already existed","version"=>"1.1");
			                    }
			                    
    			    }*/
			    }
			    
			    
				//$response=array('status_code'=>100,'msg'=>"Try Again","version"=>"1.1");
			}
	/*	}
		else
		{    
			$response=array('status_code'=>100,'msg'=>"Already Registered","version"=>"1.1");
		}*/
	}
	else
	{    
		$response=array('status_code'=>100,'msg'=>"All fileds are required","version"=>"1.1");
	}
	
	$encoded = json_encode ($response);
// 	header ('Content-type: application/json');
	exit ($encoded);
	
?>	