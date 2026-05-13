<?php 
require "config.php"; 
$bsurl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$bsurl .= "://" . $_SERVER['HTTP_HOST'];

?>
<html lang="en">
      <!-- HEAD -->
  

<head>

    <!-- META TAG -->
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="REGISTER COMPLAINT / SERVICE,  Trade License , Water tax payment , Dharani Citizen Registration , e-office , Swachta App Statistics, Application Management, E-News, App Masters, Council ,
Social Connect, Important Contacts, Media Coverage, Notifications, Smart Ideas Box, Citizen buddy,  Online Water Tap Application , Online Trade Application, Online Advertisement Application, Property Tax Self Assessment, Property Tax Calculator, Municipal Council"/>
	<!-- END META TAG -->
	<link rel="icon" href="<?php echo $bsurl; ?>/grievance/images/favicon.png" />
    <title>Grievance Redressal System </title>
<link rel="icon" href="<?php echo $bsurl; ?>/grievance/images/favicon.png" />
    <link href="css/styles.css" rel="stylesheet"><!-- Trata template Basic CSS -->
   <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,900" rel="stylesheet">
   <script src="js/cryptojs/rollups/md5.js"></script>
    <script src="js/cryptojs/components/md5.js"></script>
	
	 <!-- end STYLESHEET -->
	
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script>
        function validateForm()
        {
            var pwd=$("#password").val();
                var encpwd=CryptoJS.MD5(pwd);
                if($("#fk").val(encpwd))
                {
                   
                  return true;
                }
                return true;
        }
		
		function showPwd(){
		
		$("#password").attr('type','text');
		
		}
		
		function hidePwd(){
		
		$("#password").attr('type','password');
		
		}		

    </script>
	
	
    
    
    <link href="https://fonts.googleapis.com/css2?family=Mallanna&family=Suranna&display=swap" rel="stylesheet">
    
    
  </head>
      
  <body class="log-screen">
  
  <div style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;text-align: center;">NAGPUR MUNICIPAL CORPORATION</div>
		  <section id="content" class="m-t-lg wrapper-md ">
				  <div class="nav-brand bounceInDown animated">
				  <center>
				      <div>
				          <img src="images/nagpur_logo.png" width="120"  > &nbsp;&nbsp;&nbsp;&nbsp;
				          <img src="images/G20.png" width="150">
				          </div>
		<!--<div style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;">SAMADHAAN COMPLAINT RESOLUTION SYSTEM / समाधान तक्रार निवारण प्रणाली</div>-->
          <div style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;">Grievance Redressal System</div>
                      
<!--                      <div style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;">Citizen Service Monitoring System</div>-->
 
				      
				 <!--<img src="images/csms-newtitle.png"/ class="img-responsive">-->
				 </center>
				  </div>
				  
				  
				 <!--<div style="text-align:center; color:red;">Due to Temporary Maintenance, ULB logins are inactive </div> -->
				 
				  
				  
				<div class="row m-n animated wobble">
					<div class="col-md-4 col-md-offset-4 ">
						<section class="panel panels panel-primary"><header class="panel-heading text-center"> <strong>Departmental Log In</strong> </header>
							<?php if(isset($_SESSION['message'])){
							  echo "<div class='alert alert-danger'>".$_SESSION['message']."</div>";
							  unset($_SESSION['message']);
							}?>
							
						<style>
						.field-icon {
						  float: right;
						  margin-left: -25px;
						  margin-top: -25px;
						  position: relative;
						  z-index: 2;
						}
						<div id="otperror" class='alert alert-danger'></div>
						<div id="otpsuccess" class='alert alert-success'></div>
						</style>
							
							<form action="check_login.php" id="login-form" class="panel-body" method="post" autocomplete="off" onsubmit="return validateForm()">
								<input type="hidden" name="login_path" value="https://www.aurangabadmahapalika.org/csms/">
								<div class="form-group">
									<label class="control-label">Username</label>
									<input placeholder="Username" class="form-control" type="text" name='username' id="username" autocomplete="off" value="<?php echo $_POST['username'] ?? ''; ?>"  data-type="text" onkeyup="funInputFielTypes(this)" required>
								  <div id="usernameX" style="font-size:12px;color:red;"></div>
								</div>	
									
								 <div class="form-group">
									<label class=" control-label">Password</label>
									<div class="">
									  <input  type="password" class="form-control" name="password" id="password" required value="<?php echo $_POST['password'] ?? ''; ?>" autocomplete="off" placeholder="Password" data-type="password" onkeyup="funInputFielTypes(this)" >
									  <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
									  <div id="passwordX" style="font-size:12px;color:red;"></div>
									  <input type="hidden" name="fk" id="fk">
									</div>
								</div>
								
								<p> <img id="captchaImage" src="captcha2.php" alt="CAPTCHA"></p>
								<p>Can't read the image? click  <span class="text-primary" style="cursor:pointer;color:#0000ff;" onclick="refreshCaptcha()">Refresh</span> to refresh.</p>
								<div class="form-group">
								  
								  <div class="">
									
									<input type="text" class="form-control" name="captcha"  id="captcha" placeholder="Enter Captcha" id="captcha"  minlength="6" maxlength="6" required="required" style="border-radius:3px;" pattern="[A-Za-z0-9]{1,6}" title="Only letters and numbers, up to 6 characters" onpaste="return false;" data-type="ccaptcha" onkeyup="funInputFielTypes(this)" >
									<input type="hidden" name="captcha_code" id="captcha_code" value="<?php echo $_SESSION['code']; ?>">
								  <div id="captchaX" style="font-size:12px;color:red;"></div>
								 </div>
								</div>
								
								<div class="form-group">
								  
								  <div class="">
								  </div>
								</div>			
								<button type="button" class="form-control bg-success"  style="display:block;" onclick="onSubmit()" id="signInBtn">Sign in</button>
								
								<div id="otpSection" style="display:none;" >
								<span style="color:green">OTP Sent to your mobile!</span>
									<input type="text" class="form-control" name="otp"  id="otp" placeholder="Enter otp" minlength="4" maxlength="4" required="required" style="border-radius:3px;margin-bottom:15px;" pattern="[0-9]{1,4}" title="Only numbers, up to 4 digits" onpaste="return false;" data-type="dotp" onkeyup="funInputFielTypes(this)" >
									 <div id="otpX" style="font-size:12px;color:red;"></div>
									<button type="submit" class="btn btn-success  btn-block"  id="submitBtn" disabled>Sign In</button>
								
								</div>
							</form>
						</section>
						
						<!--<center>-->
						<!--	<img src="images/helpline.png" width="100">-->
						<!--	</center>
						
						<center style="font-size:16px; color:#000;">
						     <strong> <a href="/grievance/forgot_password.php">Forgot Password? </a> </strong>
						    
						</center>-->
						
						<center style="margin-top:35px;font-size:16px; color:#000;" >
							
						     <strong> <a href="/" style="color: red;"><?php if(!empty($_SESSION['msg'])){echo $_SESSION['msg']; session_destroy();} ?> </a> </strong>
						    
						</center>
						
					</div>
				</div>
		</section>
    <!-- JS -->
   
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-NNxAoPm2Y+nbDt6ro2RAt+ZrFkgNiNpA9dOTGxe4zYpUHPdL5EVI7NFO4Yl58N9k" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  
     
<script>
function onSubmit() {
    // Get elements
    var signInbtn = document.getElementById("signInBtn");
    var otpOption = document.getElementById("otpSection");
    var username = document.getElementById("username").value;
    var password = document.getElementById("fk").value;
    var otpsuccess = document.getElementById("otpsuccess");
    var otperror = document.getElementById("otperror");

    // Hide / Show sections
    signInbtn.style.display = "none";
    otpOption.style.display = "block";

    // Send OTP request
    $.post('send_otp_mobile.php', {
        username: username,
        password: password
    }, function (data) {
      //  console.log(data); // success response
		if(data)
			otpsuccess.value='OTP Sent to your mobile!';
	    else
			otperror.value='Invalid credentials!';	
    });
}

</script>   
  <script>
function refreshCaptcha() {
    document.getElementById("captchaImage").src = "captcha2.php?" + Date.now();
}
</script> 	 
	 <script>
		$(".toggle-password").click(function() {
		  $(this).toggleClass("fa-eye fa-eye-slash");
		  var input = $($(this).attr("toggle"));
		  if (input.attr("type") == "password") {
			input.attr("type", "text");
		  } else {
			input.attr("type", "password");
		  }
		});
	 </script>
     
     <script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
	   $('#butt').click(function(){
		  $('#ref').load('https://114.79.182.180/grievance/ #ref', function() {
			   /// can add another function here
		  });
	});
	   
	$('#login-form').disableAutoFill({
		passwordField: '.password',
		debugMode: false,
		randomizeInputName: true,
		callback: function() {
			return checkForm();
		}
	});
    
    function checkForm() {
        form = document.getElementById('login-form');
    
        if (form.password.value == '') {
            alert('Cannot leave Password field blank.');
            form.password.focus();
            return false;
        }
        if (form.username.value == '') {
            alert('Cannot leave User Id field blank.');
            form.username.focus();
            return false;
        }
        return true;
    }
   
}); //// End of Wait till page is loaded
</script>
    
    
<script>
/*function validateForm()
{
    var code = $("#code").val();
    
    var captcha = $("#captcha").val();
    
    if(code == captcha)
    {
        
        
               var username=$("#username").val();
                var pwd=$("#password").val();
                var encpwd=CryptoJS.MD5(pwd);
                if($("#fk").val(encpwd))
                {
                   
                  return true;
                }
                else
                {
                    return false;
                }
        
        
       // return true;
        
    }
    else
    {
        alert("Captcha Does Not Match");
        return false;
    }
}*/
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
	  
	case 'ccaptcha':
      isValid = /^[a-zA-Z0-9]{6}$/.test(value);
	  if (!isValid) message = '❌ Invalid Captcha! Use alphanumerics only and max length is 6 characters.';
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
  
    case 'password':
      isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-])[A-Za-z\d@$!%*?&#^()_+=\-]{8,}$/.test(value);
      if (!isValid) {
        message = '❌ Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
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
     
<!--<script>
		$.backstretch("http://egovindia.in/CSMS/images/signin.jpg");
	</script>
	JS -->
  </body>
   <!-- END BODY -->


</html>    
     
