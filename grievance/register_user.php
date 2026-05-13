<?php
	
	ini_set('display_errors',1);
	require_once('connection.php');
	require_once('send_sms.php');
	$conn=getconnection();

	date_default_timezone_set('Asia/Calcutta');

	if(isset($_POST['register'])){
	    if(!empty($_REQUEST["user_id"]) && !empty($_REQUEST["user_name"])) //&& !empty($_REQUEST["user_email"])
    	{ 
    		$ulbsql="select * from ulbmst JOIN ulb_type ON ulb_type=ulb_type_id where  ulbid='".$_REQUEST['ulbid']."'";
    		$ulbrs1=mysqli_query($conn,$ulbsql);
    		
    		$ulbName = mysqli_fetch_assoc($ulbrs1);
    		
    		$uName = $ulbName['ulbname'];
    		
    		    if($_REQUEST['login_status']==1)
        		{
        		    
        		    $sql ="select * from users_test where user_id='".$_REQUEST["user_id"]."' and id not in('".$_REQUEST['id']."')";
        		    $rs = mysqli_query($conn,$sql);
        		    $nr = mysqli_num_rows($rs);
        		    $errors=0;
        		    if($nr > 0)
        		    {
        		        $response=array('status_code'=>100,'msg'=>"mobile number already existed","version"=>"1.1");
        		        $errors++;
        		    }
            		   
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
    			    /***************************************/
    				$datetime = date('Y-m-d H:i:s');
    				$otp      = rand(1000,9999);
    				$emailotp = rand(1000,9999);
    				$otpexpiredatetime1 = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($datetime)));
    				$updateuser  ="update users_test set otp='".$otp."',otpdatetime='".$datetime."',otpexpiretime='".$otpexpiredatetime1."',otp_status='1',emailOtp='".$otp."'  where user_id='".$_REQUEST["user_id"]."' and ulbid='".$_REQUEST['ulbid']."'";
    				$updateres   = mysqli_query($conn,$updateuser);
    	
    				$message1="Dear Customer, Your OTP for Login is ".$otp.". Use this OTP to Validate, Thank you. Regards, AMCORP";
    				$message =str_replace ( ' ', '%20', $message1);
    				$user_mobile = $_REQUEST["user_id"];
    				
    				$data = [];
                        
    				
    				
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
    			    }
    			    
    			}
    	}
    	else
    	{    
    		$response=array('status_code'=>100,'msg'=>"All fileds are required","version"=>"1.1");
    	}
    	
    // 	$encoded = json_encode ($response);
    // 	header ('Content-type: application/json');
    // 	exit ($encoded);
    // 	
	}


?>	
	<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap');

            *, body {
                font-family: 'Poppins', sans-serif;
                font-weight: 400;
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeLegibility;
                -moz-osx-font-smoothing: grayscale;
            }
            
            html, body {
                height: 100%;
                background-color: #0066CC;
                overflow: hidden;
            }
            
            
            .form-holder {
                  display: flex;
                  flex-direction: column;
                  justify-content: center;
                  align-items: center;
                  text-align: center;
                  min-height: 100vh;
            }
            
            .form-holder .form-content {
                position: relative;
                text-align: center;
                display: -webkit-box;
                display: -moz-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex;
                -webkit-justify-content: center;
                justify-content: center;
                -webkit-align-items: center;
                align-items: center;
                padding: 60px;
            }
            
            .form-content .form-items {
                border: 3px solid #fff;
                padding: 40px;
                display: inline-block;
                width: 100%;
                min-width: 540px;
                -webkit-border-radius: 10px;
                -moz-border-radius: 10px;
                border-radius: 10px;
                text-align: left;
                -webkit-transition: all 0.4s ease;
                transition: all 0.4s ease;
            }
            
            .form-content h3 {
                color: #fff;
                text-align: left;
                font-size: 28px;
                font-weight: 600;
                margin-bottom: 5px;
            }
            
            .form-content h3.form-title {
                margin-bottom: 30px;
            }
            
            .form-content p {
                color: #fff;
                text-align: left;
                font-size: 17px;
                font-weight: 300;
                line-height: 20px;
                margin-bottom: 30px;
            }
            
            
            .form-content label, .was-validated .form-check-input:invalid~.form-check-label, .was-validated .form-check-input:valid~.form-check-label{
                color: #fff;
            }
            
            .form-content input[type=text], .form-content input[type=password], .form-content input[type=email], .form-content select {
                width: 100%;
                padding: 9px 20px;
                text-align: left;
                border: 0;
                outline: 0;
                border-radius: 6px;
                background-color: #fff;
                font-size: 15px;
                font-weight: 300;
                color: #8D8D8D;
                -webkit-transition: all 0.3s ease;
                transition: all 0.3s ease;
                margin-top: 16px;
            }
            
            
            .btn-primary{
                background-color: #6C757D;
                outline: none;
                border: 0px;
                 box-shadow: none;
            }
            
            .btn-primary:hover, .btn-primary:focus, .btn-primary:active{
                background-color: #495056;
                outline: none !important;
                border: none !important;
                 box-shadow: none;
            }
            
            .form-content textarea {
                position: static !important;
                width: 100%;
                padding: 8px 20px;
                border-radius: 6px;
                text-align: left;
                background-color: #fff;
                border: 0;
                font-size: 15px;
                font-weight: 300;
                color: #8D8D8D;
                outline: none;
                resize: none;
                height: 120px;
                -webkit-transition: none;
                transition: none;
                margin-bottom: 14px;
            }
            
            .form-content textarea:hover, .form-content textarea:focus {
                border: 0;
                background-color: #ebeff8;
                color: #8D8D8D;
            }
            
            .mv-up{
                margin-top: -9px !important;
                margin-bottom: 8px !important;
            }
            
            .invalid-feedback{
                color: #ff606e;
            }
            
            .valid-feedback{
               color: #2acc80;
            }
        </style>
    </head>
    <body>
     <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Registration</h3>
                        <form class="requires-validation" novalidate>

                            <div class="col-md-12">
                               <input class="form-control" type="text" name="user_name" placeholder="Full Name" required>
                               <div class="valid-feedback">Username field is valid!</div>
                               <div class="invalid-feedback">Username field cannot be blank!</div>
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="email" name="user_email" placeholder="E-mail Address" required>
                                 <div class="valid-feedback">Email field is valid!</div>
                                 <div class="invalid-feedback">Email field cannot be blank!</div>
                            </div>
                            
                            <div class="col-md-12">
                               <input class="form-control" type="text" name="user_id" placeholder="Mobile Number" required>
                               <div class="valid-feedback">Mobile field is valid!</div>
                               <div class="invalid-feedback">Mobile field cannot be blank!</div>
                            </div>
                            
                            <div class="form-button mt-3 d-flex justify-content-center">
                                <button id="submit" type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
    </html>