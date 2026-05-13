
<html lang="en">
      <!-- HEAD -->
  

<head>
    <!-- META TAG -->
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="REGISTER COMPLAINT / SERVICE,  Trade License , Water tax payment , Dharani Citizen Registration , e-office , Swachta App Statistics, Application Management, E-News, App Masters, Council ,
Social Connect, Important Contacts, Media Coverage, Notifications, Smart Ideas Box, Citizen buddy,  Online Water Tap Application , Online Trade Application, Online Advertisement Application, Property Tax Self Assessment, Property Tax Calculator, Municipal Council"/>
	<!-- END META TAG -->
	
    <title>Grievance Redressal System </title>

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
    </script>
    
    
    <link href="https://fonts.googleapis.com/css2?family=Mallanna&family=Suranna&display=swap" rel="stylesheet">
    
    
  </head>
      
  <body class="log-screen">
  <div style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;text-align: center;">NAGPUR MUNICIPAL COPORATION</div>
		  <section id="content" class="m-t-lg wrapper-md ">
				  <div class="nav-brand bounceInDown animated">
				  <center>
				      <div>
				          <img src="images/aurangabad_logo.png" width="120"  >
				          
				          </div>
          <div style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;">Citizen Service Monitoring System</div>
 
				      
				 <!--<img src="images/csms-newtitle.png"/ class="img-responsive">-->
				 </center>
				  </div>
				  
				  
				 <!--<div style="text-align:center; color:red;">Due to Temporary Maintenance, ULB logins are inactive </div> -->
				  
				  
				  
				<div class="row m-n animated wobble">
					<div class="col-md-4 col-md-offset-4 ">
						<section class="panel panels panel-primary"><header class="panel-heading text-center"> <strong>LOG IN</strong> </header>
							
							
							
							<form action="check_login.php" id="login-form" class="panel-body" method="post" autocomplete="off" onsubmit="return validateForm()">
							<input type="hidden" name="login_path" value="http://43.242.214.64/csms/">
								<div class="form-group">
									<label class="control-label">Username</label><input placeholder="Username" class="form-control" type="text" name='username' id="username" autocomplete="off" value="" required>
								</div>
								<div class="form-group">
								    
									<label class="control-label">Password</label>
									<input  placeholder="Password" class="form-control" type="password" name="password"  id="password" autocomplete="off" value="" required >
									<input type="hidden" name="fk" id="fk">
									
								</div>
								
							
									
								
								
								<!--<div style="border:1px solid #ccc;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;
font-weight: bold;letter-spacing: 10px;font-size: 16px;" id="ref">
								<p id="captImg" style="margin-top: 10px;"><?php echo $code; ?></p>
								</div>
                <p>Can't read the image? click <a  id="butt" class="refreshCaptcha" style="cursor:pointer;">here</a> to refresh.</p>-->
                
                <div class="form-group">
                  
                  <div class="">
                    
                 <!--   <input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" id="captcha" required="required" style="border-radius:3px;" onpaste="return false;" >-->
                    <input type="hidden" name="code" id="code" value="<?php echo $_SESSION['code']; ?>">
                  </div>
                </div>
								
								
								
								<!--<a href="#" class="btn btn-facebook btn-block m-b-sm"><i class="fa fa-facebook pull-left"></i>Sign in with Facebook</a><a href="#" class="btn btn-twitter btn-block"><i class="fa fa-twitter pull-left"></i>Sign in with Twitter</a>-->
								<button type="submit" class="btn btn-success  btn-block">Sign in</button>
								
								<!--<a href="#" class="btn btn-white btn-block">Department Login</a> -->
							</form>
						</section>
						
						<!--<center style="font-size:16px; color:#000;">
						    For Support call <strong> 9030081818 </strong>
						    
						</center>-->
						
					</div>
				</div>
		</section>
    <!-- JS -->
    <script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui-1.10.3.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js"></script>
	 <script src="js/jquery.backstretch.min.js"></script><!--backstretch JS -->
     
     
     <script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#butt').click(function(){
      $('#ref').load('http://municipalservices.in/index.php #ref', function() {
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
     
     
<!--<script>
		$.backstretch("http://egovindia.in/CSMS/images/signin.jpg");
	</script>
	JS -->
  </body>
   <!-- END BODY -->


</html>    
     
