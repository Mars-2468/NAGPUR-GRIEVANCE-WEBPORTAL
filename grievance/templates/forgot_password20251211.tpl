<html lang="en">
<!-- HEAD -->

<head>
    <!-- META TAG -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="REGISTER COMPLAINT / SERVICE,  Trade License , Water tax payment , Dharani Citizen Registration , e-office , Swachta App Statistics, Application Management, E-News, App Masters, Council ,
        Social Connect, Important Contacts, Media Coverage, Notifications, Smart Ideas Box, Citizen buddy,  Online Water Tap Application , Online Trade Application, Online Advertisement Application, Property Tax Self Assessment, Property Tax Calculator, Municipal Council" />
    <!-- END META TAG -->
    <title>Citizen services monitoring system </title>
    <link href="css/styles.css" rel="stylesheet"><!-- Trata template Basic CSS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,900" rel="stylesheet">
    <script src="js/cryptojs/rollups/md5.js"></script>
    <script src="js/cryptojs/components/md5.js"></script>
    <script>
   
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Mallanna&family=Suranna&display=swap" rel="stylesheet">
    <style>
        .counter-container{
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
</head>

<body class="log-screen">

  <div style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;text-align: center;">
    NAGPUR MUNICIPAL CORPORATION</div>
    
   <section id="content" class="m-t-lg wrapper-md ">
        <div class="nav-brand bounceInDown animated">
          <center>
            <div>
              <img src="images/nagpur_logo.png" width="120"> &nbsp;&nbsp;&nbsp;&nbsp;
              <img src="images/G20.png" width="150">
            </div>
            <div style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;">
              Citizen Service Monitoring System</div>
          </center>
        </div>
    
    
        <div class="row m-n animated wobble">
          <div class="col-md-4 col-md-offset-4 ">
              	<input type="hidden" name="" value="{$sent_otp_status}" id="sent_otp_status">
              	<input type="hidden" name="" value="{if isset($minutes)}{$minutes}{/if}" id="minutes">
              	<input type="hidden" name="" value="{if isset($seconds)}{$seconds}{/if}" id="seconds">
            {if $verify_otp_status eq 0}
            <section class="panel panels panel-primary">
              <header class="panel-heading text-center"> <strong>Forgot Password</strong> </header>
    
              <form action="" id="login-form" class="panel-body" method="post" autocomplete="off" >
                {if $sent_otp_status eq 0}
                <div class="send_otp">
                  <div class="form-group">
                    <label class="control-label">Mobile</label>
                    <input placeholder="Enter Mobile Number" class="form-control" type="text" name='mobile' id="mobile" autocomplete="off" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" required>
                     {if isset($mobile_error)}
                                <span class="text-danger">{$mobile_error}</span>
                            {/if}
                  <span id="mobile_err" class="text-danger"></span>
                  </div>
                  <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="btn btn-success col-md-offset-4" name="send_otp" onclick="return validateEmployee();">Send OTP</button>
                  </div>
                </div>
                {else}
                <div class="otp_frm">
                    <div class="form-group">
                        <label class="control-label">OTP</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                          <input placeholder="Enter OTP" class="form-control" type="text" name='otp' id="username" autocomplete="off" value="" required>
                            {if isset($otp_err)}
                                <span class="">{$otp_err}</span>
                            {/if}
                        </div>
                        <!--<label class="col-sm-2 control-label">Email</label>-->
                        <button type="submit" class="btn btn-success  col-sm-4" name="verify_otp">Verify OTP</button>
                    </div>
                    
                </div>
               
                {/if}
              </form>
              
            </section>
            {/if}
            
            {if $sent_otp_status eq 1 && $change_pwd_status eq 0}
                <div class="form-group">
                    <center>
                        <p id="countdown"></p>
                    </center>
                </div>
            {/if}
            {if $change_pwd_status eq 1}
            <section class="panel panels panel-primary ">
              <header class="panel-heading text-center"> <strong>Change Password</strong> </header>
    
    
              <form action="" id="login-form" class="panel-body" method="post" autocomplete="off" onsubmit="return validateForm()">
                <input type="hidden" name="login_path" value="https://www.aurangabadmahapalika.org/csms/">
                <div class="form-group">
                  <label class="control-label">New Password</label><input placeholder="Enter New Password" class="form-control" type="password" name='new_pwd' id="new_pwd" autocomplete="off" value="" required>
                </div>
    
                <div class="form-group">
                  <label class="control-label">Re Enter Password</label>
                  <input placeholder="Enter Re Enter Password" class="form-control" type="password" name="re_password" id="re_password" autocomplete="off" value="" required>
                  <input type="hidden" name="fk" id="fk">
                </div>
                <div class="form-group">
                  <div class="">
                    <!--   <input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" id="captcha" required="required" style="border-radius:3px;" onpaste="return false;" >-->
                    <input type="hidden" name="code" id="code" value="">
                  </div>
                </div>
    
                <button type="submit" class="btn btn-success  btn-block" name="change_password">Confirm</button>
    
              </form>
            </section>
              </div>
        </div>
    </section>
        {/if}
        
  <!-- JS -->
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui-1.10.3.js" type="text/javascript"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.backstretch.min.js"></script>
  <!--backstretch JS -->

  
    <script>
    function validateEmployee(){
        let mobile = $('#mobile').val();

        if(mobile.length > 10 ){
            $('#mobile_err').html('Please Enter Valid Number');
            return false
        }
        $('#mobile_err').html('');
        return true;
    }
    function validateForm() {
    
        var password = $("#new_pwd").val()
        var password1 = $("#re_password").val()
        var pswlen = password.length;
        
        if (password == password1) {
           
            var pwd = $("#password").val();
            var encpwd = CryptoJS.MD5(pwd);
            if ($("#fk").val(encpwd)) {
                return true;
            }
        }
        else {
            alert('Re-enter Password must match with New password.')
            return false;
        }
        return true;
    }
        let min = 5;
        let sec = 60;
        // if(min !='' && sec != ''){
        //     min = document.getElementById('minutes').value;
        //     sec = document.getElementById('seconds').value;
        // }
        var countdownElement = document.getElementById("countdown");
        var countdownDate = new Date().getTime() + (min * sec * 1000); // 5 minutes in milliseconds
        
        var countdownInterval = setInterval(function() {
        var now = new Date().getTime();
        var distance = countdownDate - now;
        
        var minutes = Math.floor(distance / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        countdownElement.innerHTML = "<strong>Time remaining : </strong>" + minutes + "m " + seconds + "s ";
        
        if (distance < 0) {
          clearInterval(countdownInterval);
          countdownElement.innerHTML = "Time's up!";
          window.location='/forgot_password.php';
        }
    }, 1000); // Update every second
      
    
        
    </script>
</body>

</html>