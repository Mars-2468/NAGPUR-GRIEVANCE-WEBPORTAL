<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" href="<?php echo $bsurl; ?>/grievance/images/favicon.png" />
  
    <title>:: New Complaint Registration</title>

    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!--
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-NNxAoPm2Y+nbDt6ro2RAt+ZrFkgNiNpA9dOTGxe4zYpUHPdL5EVI7NFO4Yl58N9k" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  
    <style>
        .merror {
            color: red;
        }

        .footer_div {
            width: 100%;
            height: 25px;
            text-align: center;
            background-color: #0054a6;
            color: #FFF;
            font-family: "Myriad Pro";
            font-size: 14px;
            font-weight: normal;
            padding-top: 5px;
            clear: both;
            margin: 0 auto;
            margin-top: 10px;
            margin-bottom: 0px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .mb_bg {
            background-image: url(images/mb_bg.jpg);
            height: 600px;
            background-size: contain;
            background-position: bottom;
            background-repeat: repeat-x;
            background-color: #068fdd;
        }

        .dcenter {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }
        .register-btn{margin-right:8px}
        @media (max-width: 767px) {
            .nav-header{font-size:16px !important}
            .comp-btn{text-align:center !important}
            .dcenter{display: flex;
    justify-content: center;
    margin-top: 50px;
    flex-direction: column !important}
    .submit-btn{text-align:center; padding-top:0px !important; margin-bottom:275px !important}
    .mb_bg{height:auto !important}
    .check-btn{margin-top:0px !important}
    .counter-container{position:static !important}
}


        .alert {
            padding: 20px;
            background-color: green;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>

    <?php if ($_SESSION['otpstaus'] == 1 && $_SESSION['mobilesubmit'] == 1) { ?>
        <style>
            .counter-container {
                border: 2px dashed gray;
                width: 80px;
                font-size: 23px;
                display: flex;
                justify-content: center;
                background: black;
                color: white;
                position: absolute;
                border-radius: 5px;
            }
        </style>
    <?php } ?>

    <script>
        function validateForm() {
            errors = 0;
            var mobile = $("#mobile").val();
            var patt1 = /^\d{10}$/;
            if (!patt1.test(mobile)) {
                ($('#mobile')).css({
                    "background-color": "pink"
                });
                errors++;
            }
            $(".mytext").each(function() {

                var val_field = $(this).val();
                if (val_field == '') {
                    ($(this)).css({
                        "background-color": "pink"
                    });
                    errors++;
                } else {
                    ($(this)).css({
                        "background-color": "white"
                    });
                }
            });



            $(".dropdown").each(function() {

                var val_field = $(this).val();
                if (val_field == '0') {
                    ($(this)).css({
                        "background-color": "pink"
                    });
                    errors++;
                } else {
                    ($(this)).css({
                        "background-color": "white"
                    });
                }
            });


            if (errors == 0) {
                return true;
            } else {
                alert("Please Enter Correct Value in High-lighted Fields - " + errors);
                return false;
            }
        }
    </script>
<!--
    <script src='../js/jquery.min.js'></script>
-->
    <script>
        $(document).ready(function() {

            $(".num").keypress(function(e) {

                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });


        });
    </script>

    <script>
        function downloadPDF() {
            // Redirect to the PHP script to trigger download
            window.location.href = 'user_manual_citizens_script.php?download_pdf=true';

            // Refresh the current page after a short delay
            setTimeout(function() {
                window.location.reload();
            }, 1000); // 1000 milliseconds = 1 second
        }
    </script>

</head>


<body style="padding:0px; margin:0px;">

    <div class="row" style="background-color:#0b1c40;">
       <!-- <div class="container">
            <center>
                <img src="<? //php echo $banner; 
                            ?>" class="img-responsive">
            </center>
        </div> -->
        <div>
            <?php if (isset($_REQUEST['message'])) {
                echo $_REQUEST['message'];
            } ?>
        </div>
        <div  class="nav-header" style="background-color:#0066CC; color:#FFF; padding:5px; text-align:center; font-size:22px;">
            <div class="container" style="line-height: 6px;     padding-bottom: 15px;">
                <img src="images/nagpur-logo.png" style="width:50px;">
                <!-- <strong>New Problem Registration </strong> -->
                <strong>NAGPUR MUNICIPAL CORPORATION <br> नागपूर महानगरपालिका</strong>
                <!--<img src="images/smart-city.png" style="width:50px;"> -->
            </div>
        </div>
    </div>


    <div class="error">
        <center></center>
    </div>




    <div class="container">

        <!--<div class="text-center">-->

        <!--	<img src="images/helpline.png" width="180">-->
        <!--</div>-->


        <div class="row" style="clear:both; min-height:45px; align-items: center;">



            <!--<div class="col-md-10 text-center ">-->
            <!--	<h3>SAMADHAAN COMPLAINT RESOLUTION SYSTEM / समाधान तक्रार निवारण प्रणाली</h3>-->
            <!-- District: <strong> <?php //echo $distName; 
                                    ?> Aurangabad </strong>  -->
            <!--</div>-->

            <!--<div class="col-md-8 text-left ">
	<h2>COMPLAINT REGISTRATION / तक्रार नोंदणी</h2>
  District: <strong> <?php //echo $distName; 
                        ?> Aurangabad </strong>  
</div>-->


            <!-- <div class="col-md-4 text-center ">
 ULB Name: <strong> <?php //echo $ulbName; 
                    ?> Aurangabad Municipal Corporation</strong>
</div> -->



            <div class="col-md-6 pull-right text-right comp-btn">
                <a class="btn btn-primary register-btn" href="web_register_form.php" target="_blank" style="list-style:none; color:#FFF;margin-top: 23px; margin-bottom: 23px;">Register </a>

                <button class="btn btn-warning register-btn" onclick="downloadPDF()"><i class="far fa-file-pdf"></i> User Manual</button>

                <a class="btn check-btn btn-success " href="check_comp_status.php?id=<?php echo $ulbid; ?>" target="_blank" style="list-style:none; color:#FFF;margin-top: 23px; margin-bottom: 23px;">Check Status / तक्रार स्थिती तपासा</a>

            </div>


        </div>

        <div class="panel panel-info">
            <div class="panel-heading" style="text-align:center;"><strong>Grievance Redressal System</strong></div>
            <?php
            if (isset($_SESSION['flash_message'])) {
                $message = $_SESSION['flash_message'];
                unset($_SESSION['flash_message']); ?>

                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?php echo $message; ?>
                </div>
            <?php    } ?>

            <div class="panel-body mb_bg">

                <?php if ($_SESSION['otpstaus'] == 0) { ?>

                    <form action="" class="form-horizontal" method="post">

                        <input type="hidden" name="ulbid" value="<?php echo $ulbid; ?>" id="ulbid">

                        <span id="form">


                            <div class="row dcenter">

                                <div class="col-md-5" style="margin-left:15px; margin-right:15px;">
                                    <div class="form-group">
                                        <label>Please enter your mobile number (10 digits) to continue </label>
                                        <input type="text" name="mobileno" id="mobileno" placeholder="" value="<?php echo $_SESSION['user_mobile']; ?>" class="form-control mytext numeric" maxlength="10" required autocomplete="off" data-type="mobile" onkeyup="funInputFielTypes(this)">
                                        <input type="hidden" name="app_type_id" value="1">
										<div id="mobilenoX" style="font-size:14px;color:red;"></div>
                                        <p class="text-danger"></p>
                                    </div>
                                </div>

                                <div class="col-md-2 submit-btn" style="padding-top: 24px;">

                                    <button type="submit" class="btn btn-success" name="save" id="submitBtn" disabled>Send OTP</button>
                                </div>



                            </div>

            </div>
            </span>

            </form>
        <?php } ?>
        <input type="hidden" id="otp_status" value="<?php echo $_SESSION['otpstaus']; ?>">
        <input type="hidden" id="mob_status" value="<?php echo $_SESSION['mobilesubmit']; ?>">
        <input type="hidden" id="verify_otp_status" value="<?php echo $verify_otp_status; ?>">
        <?php if ($_SESSION['otpstaus'] == 1 && $_SESSION['mobilesubmit'] == 1) {
            $_SESSION['otpstaus_CHECK'] = 5;
        ?>

            <form action="" method="post">
                <div class="row dcenter">

                    <div class="col-md-4" style="margin-left:15px; margin-right:15px;">
                        <div class="form-group">
                            <label>Enter OTP</label>
                            <input type="text" name="otp" id="otp" placeholder="" class="form-control mytext numeric" maxlength="4"  data-type="dotp" onkeyup="funInputFielTypes(this)" required>
                            <div id="otpX" style="font-size:14px;color:red;"></div>
							<input type="hidden" value="<?php echo (isset($_SESSION['sel_mobile']) ? $_SESSION['sel_mobile'] : ''); ?>" name="mb">
                            <p class="text-danger"></p>
                            <p class="text-danger" id='otp_err_msg'><?php echo (isset($otp_err_msg)) ? $otp_err_msg  : ''; ?></p>
                        </div>

                        <div class="counter-container">
                            <span id="timer" style="font-family: 'Orbitron', sans-serif;"></span>
                        </div>

                    </div>

                    <div class="col-md-6 text-center" style="padding-top: 24px; margin-bottom:275px">
                      
                        <button type="button" class="btn btn-warning" onclick="resendotp()">Resend OTP</button>
                        <button type="submit" class="btn btn-success" name="save" id="submitBtn" disabled>Submit</button>
						<button type="submit" name="terminate_otp" value="terminateOTP" class="btn btn-danger" onclick="terminateOTP()">Terminate OTP</button>
					</div>


                </div>
            </form>
            <form action="" id="resend_otp" method="post">
                <input type="hidden" value="<?php echo (isset($_SESSION['sel_mobile']) ? $_SESSION['sel_mobile'] : ''); ?>" name="mobileno">
            </form>
        <?php } ?>
        </div>



        <?php if ($_REQUEST['status'] == 1) {
            echo '<div class="alert alert-success" role="alert">Complaint Registered successfully with Reference no ' . $_REQUEST['ref_id'] . '</div>';
        } ?>











    </div>



    </div>
    <!--//captch code start here-->




    <script>
        //Refresh Captcha
        function refreshCaptcha() {
            var img = document.images['captcha_image'];
            img.src = img.src.substring(
                0, img.src.lastIndexOf("?")
            ) + "?rand=" + Math.random() * 1000;
        }
    </script>
    <script>
        function get_streets(ward_id) {
            $.post('ajax_getstreets.php', {
                ward_id: ward_id
            }, function(data) {
                $('#street_id').html(data);
            });
        }

        function get_csdesc(cat_id) {

            var ulbid = $("#ulbid").val();



            $.post('ajax_getcomplaints.php', {
                cat_id: cat_id,
                ulbid: ulbid
            }, function(data) {


                $('#cs_id').html(data);
                if (ulbid == '052' && cat_id == '3') {
                    $("#tanker_dropdown").css('display', 'block');
                    $("#tanker_id").addClass('dropdown');
                } else {
                    $("#tanker_dropdown").css('display', 'none');
                    $("#tanker_id").removeClass('dropdown');
                }
            });

        }
    </script>

    <script>
        function get_sc_desc(dept_id) {



            var department_id = 1;
            var app_type_id = 1;

            $.post('get_sub_cat.php', {
                dept_id: dept_id,
                app_type_id: app_type_id,
                department_id: department_id
            }, function(data) {


                if (app_type_id == 1) {

                    $('#sub_id').html(data);
                } else {

                }


                if (app_type_id == '1' && ulbid == '052' && dept_id == '3') {
                    $("#tanker_dropdown").css('display', 'block');
                    $("#tanker_id").addClass('dropdown');
                } else {
                    $("#tanker_dropdown").css('display', 'none');
                    $("#tanker_id").removeClass('dropdown');
                }

                get_det(dept_id);

            });

        }




        $(function() {
            let otp_status = $('#otp_status').val();
            let mob_status = $('#mob_status').val();
            let verify_otp_status = $('#verify_otp_status').val();

            (otp_status == 1 && mob_status == 1 && verify_otp_status == 0) ? initiateTimer(): '';
        });

        function initiateTimer() {
            document.getElementById('timer').innerHTML = 05 + ":" + 00;
            startTimer();
        }

        function startTimer() {
            var presentTime = document.getElementById('timer').innerHTML;
            var timeArray = presentTime.split(/[:]+/);
            var m = timeArray[0];
            var s = checkSecond((timeArray[1] - 1));
            if (s == 59) {
                m = m - 1
            }
            if (m < 0) {
                $('#verify_otp_status').val(1);
                $('#otp_err_msg').html('Please click on Resend OTP')
                return
            }

            document.getElementById('timer').innerHTML =
                m + ":" + s;
            console.log(m)

            setTimeout(startTimer, 1000);

        }

        function checkSecond(sec) {
            if (sec < 10 && sec >= 0) {
                sec = "0" + sec
            }; // add zero in front of numbers < 10
            if (sec < 0) {
                sec = "59"
            };
            return sec;
        }

        function resendotp() {
            $('#resend_otp').submit();
        }
		function terminateOTP(){
			$('#otp').removeAttr('required');
		}

    </script>
    <script>
	// all fields validations final

	let globalCntVal = 0;

function funInputFielTypes(ele) {
  const type = ele.getAttribute('data-type');
  const id = ele.id;
  //const errorField = document.getElementById(id + 'X');
  	var errorField = $('#' + ele.id + 'X');
  const submitBtn = document.getElementById('submitBtn');

  let value = ele.value.trim();
  let wasInvalid = ele.getAttribute('data-invalid') === 'true';
  let isValid = true;
  let message = '';

  if (ele.value.charAt(0) === ' ') {
		ele.value = '';
		message='❌ First letter should not be empty!';
  }else{

//alert(type);

  // Validate based on input type
  switch (type) {
    case 'text':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-\.() ]+$/.test(value);
	  if (!isValid) 
	  message='❌ Invalid characters! Use letters, numbers, -, _, . () or space.';
      break;
	
	case 'sptext':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,&()]+$/.test(value);
      if (!isValid) message = '❌ Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;	
	  
	case 'dnumber':
      isValid = /^[0-9]+$/.test(value);
      if (!isValid) message = '❌ Invalid number! Use digits only';
      break;
	  
	case 'fnumber':
      isValid = /^-?\d+(\.\d+)?$/.test(value);
      if (!isValid) message = '❌ Invalid number! Use digits, ., only';
      break;
	  	
	case 'dcaptcha':
      isValid = /^[0-9]{4}$/.test(value);
	  if (!isValid) message = '❌ Invalid Captcha! Use digits only and max length is 4 digits.';
	  break;
	  
    case 'address':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,&()\/]+$/.test(value);
      if (!isValid) message = '❌ Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;
	  
    case 'address2':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,()]+$/.test(value);
      if (!isValid) message = '❌ Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;


    case 'email':
      isValid = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|io)$/.test(value);
      if (!isValid) message = '❌ Enter a valid email like user@example.com';
      break;

    case 'mobile':
		
		isValid =  /^[6-9][0-9]{0,9}$/.test(value);
	  	  
		if (value.length < 10) {
			message = "❌ Mobile number should be digits only. And exactly 10 digits.";
			
		} else if (!isValid) {
			message = "❌ Mobile number should  be digits only. And start with 6, 7, 8, or 9.";
			
		} else {
			message = "";
			
		}
	  
      //if (!isValid) message = '❌ Enter a valid 10-digit mobile number starting with 6-9.';
      break;
	  
    case 'landline':
		
		isValid =  /^0\d{2,4}-?\d{6,8}$/.test(value);
	  	  
		if (value.length < 12) {
			message = "❌ Landline number should be exactly 12 digits.";
			
		} else if (!isValid) {
			message = "❌ Landline number should start with 0 to 4,only.";
			
		} else {
			message = "";
			
		}
	  
    
      break;	
	  
    case 'fax':
		
		isValid =  /^(\+?\d{1,3}[- ]?)?0\d{2,4}[- ]?\d{6,8}$/.test(value);
	  	  
		if (value.length < 12) {
			message = "❌ Fax number should be exactly 12 digits.";
			
		} else if (!isValid) {
			message = "❌ Fax number should start with 0 to 4,only.";
			
		} else {
			message = "";			
		}
	      
      break;

    case 'lat':
      const lat = parseFloat(value);
      isValid = !isNaN(lat) && lat >= -90 && lat <= 90;
      if (!isValid) message = '❌ Latitude must be between -90 and 90.';
      break;

    case 'lng':
      const lng = parseFloat(value);
      isValid = !isNaN(lng) && lng >= -180 && lng <= 180;
      if (!isValid) message = '❌ Longitude must be between -180 and 180.';
      break;
	  
	case 'url':
	   const pattern = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;
      isValid = pattern.test(value);
	
      if (!isValid) {
        message = '❌ Unsafe URL! Only allowed protocols are http,https, and mailto.';
      }
      break;
	  
    case 'date':
      isValid = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/.test(value);
      if (!isValid) message = '❌ Date must be in YYYY-MM-DD format.';
      break;

    case 'old_password':
      isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/.test(value);
      if (!isValid) {
        message = '❌ Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
      }
      break;
    case 'password':
      isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/.test(value);
      if (!isValid) {
        message = '❌ Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
      }
      break;

    case 'confirm-password':
	
      const originalPassword = document.getElementById('password').value.trim();
      isValid = value === originalPassword;
      if (!isValid) {
        message = '❌ Passwords do not match.';
      }
	  
	  if((value.length>=8) && (originalPassword.length>=8) && isValid){	  
		var pwd=$("#password").val();
		var encpwd=encryptDataBeforeSubmit(pwd);
		$("#password").val(encpwd);
		$("#confirm_password").val(encpwd);				
	  }
	  
      break;
	  
	case 'confirmpassword':
	
      const oPassword = document.getElementById('password').value.trim();
      isValid = value === oPassword;
      if (!isValid) {
        message = '❌ Passwords do not match.';
      }
	 
	  if((value.length>=8) && (oPassword.length>=8) && isValid){	  
		var oldpwd=$("#old_password").val();
		var opwd=$("#password").val();
		var uencpwd=encryptDataBeforeSubmit(opwd);
		
		$("#password").val(uencpwd);
		$("#confirm_password").val(uencpwd);	
		
		if(oldpwd.length>=8){
		var oldencpwd=encryptDataBeforeSubmit(oldpwd);
		$("#old_password").val(oldencpwd);	
		}
		
		
	  }
	  
      break; 

    case 'captcha':
      isValid = /^[a-zA-Z0-9]+$/.test(value);
      if (!isValid) {
        message = '❌ Captcha should only contain alphanumerics.';
      }
      break;
	  
    case 'dotp':
      isValid = /^[0-9]{4}$/.test(value);
      if (!isValid) {
        message = '❌ OTP must be exactly 4 digits and numbers only.';
      }
      break;
	  
    case 'alphanumerics':
      isValid = /^[a-zA-Z0-9]*$/.test(value);
      if (!isValid) {
        message = '❌  Invalid characters, allows alphanumerics only.';
      }
      break;	
	  
    case 'alphanumerics_slash':
      isValid = /^[a-zA-Z0-9\/]*$/.test(value);
      if (!isValid) {
        message = '❌  Invalid characters, allows alphanumerics,and / only.';
      }
      break;
	  
	case 'multiplefiles':
      const files = ele.files;
      const maxFiles = 5; // you can customize max allowed files
      const maxSize = 2 * 1024 * 1024; // 2 MB per file

      const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

      if (files.length === 0) {
        isValid = false;
        message = '❌ Please select at least one file.';
      } else if (files.length > maxFiles) {
        isValid = false;
        message = `❌ Maximum ${maxFiles} files allowed.`;
      } else {
        isValid = true;
        for (let i = 0; i < files.length; i++) {
          const ext = files[i].name.split('.').pop().toLowerCase();
          if (!allowedExtensions.includes(ext)) {
            isValid = false;
            message = `❌ Invalid file type "${ext}". Allowed: ${allowedExtensions.join(', ').toUpperCase()}`;
            break;
          }
          if (files[i].size > maxSize) {
            isValid = false;
            message = `❌ File "${files[i].name}" exceeds 2MB size limit.`;
            break;
          }
        }
      }
      break;
	  
	case 'pdfonly':
	case 'imfile':
    case 'image':
    case 'audio':
    case 'video':
      const file = ele.files[0];
	 // alert(type);
      if (file) {
        const ext = file.name.split('.').pop().toLowerCase();
        const allowed = {
          pdfonly: ['pdf'],
          imfile: ['jpg', 'jpeg', 'png','pdf'],
          image: ['jpg', 'jpeg', 'png'],
          audio: ['mp3', 'wav', 'ogg'],
          video: ['mp4', 'webm', 'ogg']
        };
        isValid = allowed[type].includes(ext);
        if (!isValid) {
          message = `❌ Only ${allowed[type].join(', ').toUpperCase()} files allowed.`;
        }
      } else {
        isValid = false;
        message = `❌ Please select a valid ${type} file.`;
      }
      break;

    default:
      break;
  }
}
  // Show or clear error
  if (!isValid) {
    errorField.html(message);
    if (!wasInvalid) {
      globalCntVal++;
      ele.setAttribute('data-invalid', 'true');
    }
  } else {
     errorField.html('');
    if (wasInvalid) {
      globalCntVal--;
      ele.setAttribute('data-invalid', 'false');
    }
  }

  // Enable or disable submit
  submitBtn.disabled = globalCntVal > 0;
}

    </script>


    <br />

    <!--<div class="footer_div">Powered by - <a href="http://vmaxindia.com/" class="footerlinks" target="_blank" style="color:#00bff3; ">VMAX</a></div>-->


</body>

</html>