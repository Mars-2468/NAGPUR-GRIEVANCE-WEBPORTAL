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
    <meta name="description"
        content="REGISTER COMPLAINT / SERVICE,  Trade License , Water tax payment , Dharani Citizen Registration , e-office , Swachta App Statistics, Application Management, E-News, App Masters, Council ,
Social Connect, Important Contacts, Media Coverage, Notifications, Smart Ideas Box, Citizen buddy,  Online Water Tap Application , Online Trade Application, Online Advertisement Application, Property Tax Self Assessment, Property Tax Calculator, Municipal Council" />
    <!-- END META TAG -->
    <link rel="icon" href="<?php echo $bsurl; ?>/grievance/images/favicon.png" />
    <title>Grievance Redressal System </title>
    <link rel="icon" href="<?php echo $bsurl; ?>/grievance/images/favicon.png" />
    <link href="css/styles.css" rel="stylesheet"><!-- Trata template Basic CSS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,900" rel="stylesheet">
    <script src="js/cryptojs/rollups/md5.js"></script>
    <script src="js/cryptojs/components/md5.js"></script>


    <script>
    function validateForm() {
        var pwd = $("#password").val();
        var encpwd = CryptoJS.MD5(pwd);
        if ($("#fk").val(encpwd)) {

            return true;
        }
        return false;
    }

    function showPwd() {

        $("#password").attr('type', 'text');

    }

    function hidePwd() {

        $("#password").attr('type', 'password');

    }
    </script>




    <link href="https://fonts.googleapis.com/css2?family=Mallanna&family=Suranna&display=swap" rel="stylesheet">

    <style>
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #ffffff;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loader {
        width: 50px;
        height: 50px;
        border: 5px solid #ddd;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }
    </style>

</head>

<body class="log-screen">

    <div
        style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;text-align: center;">
        NAGPUR MUNICIPAL CORPORATION</div>
    <section id="content" class="m-t-lg wrapper-md ">
        <div class="nav-brand bounceInDown animated">
            <center>
                <div>
                    <img src="images/nagpur_logo.png" width="120"> &nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="images/G20.png" width="150">
                </div>
                <div
                    style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;">
                    Grievance Redressal System</div>
            </center>
        </div>

        <div class="row m-n animated wobble">
            <div class="col-md-4 col-md-offset-4 ">
                <section class="panel panels panel-primary">
                    <header class="panel-heading text-center"> <strong>Departmental Log In</strong> </header>
                    <?php if (isset($_SESSION['message'])) {
                        echo "<div class='alert alert-danger'>" . $_SESSION['message'] . "</div>";
                        unset($_SESSION['message']);
                    } ?>

                    <style>
                    .field-icon {
                        float: right;
                        margin-left: -25px;
                        margin-top: -25px;
                        position: relative;
                        z-index: 2;
                    }
                    </style>

                    <form action="check_login.php" id="login-form" class="panel-body" method="post" autocomplete="off"
                        onsubmit="return validateForm()">
                        <input type="hidden" name="login_path" value="https://www.aurangabadmahapalika.org/csms/">
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <input placeholder="Username" class="form-control" type="text" name='username' id="username"
                                autocomplete="off" value="<?php echo $_POST['username'] ?? ''; ?>" data-type="text"
                                onkeyup="funInputFielTypes(this)" required>
                            <div id="usernameX" style="font-size:12px;color:red;"></div>
                        </div>

                        <div class="form-group">
                            <label class=" control-label">Password</label>
                            <div class="">
                                <input type="password" class="form-control" name="password" id="password" required
                                    value="<?php echo $_POST['password'] ?? ''; ?>" autocomplete="off"
                                    placeholder="Password" data-type="password" onkeyup="funInputFielTypes(this)">
                                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <div id="passwordX" style="font-size:12px;color:red;"></div>
                                <input type="hidden" name="fk" id="fk">
                            </div>
                        </div>

                        <p> <img id="captchaImage" src="captcha2.php" alt="CAPTCHA"></p>
                        <p>Can't read the image? click <span class="text-primary" style="cursor:pointer;color:#0000ff;"
                                onclick="refreshCaptcha()">Refresh</span> to refresh.</p>
                        <div class="form-group">

                            <div class="">

                                <input type="text" class="form-control" name="captcha" id="captcha"
                                    placeholder="Enter Captcha" id="captcha" minlength="6" maxlength="6"
                                    required="required" style="border-radius:3px;" pattern="[A-Za-z0-9]{1,6}"
                                    title="Only letters and numbers, up to 6 characters" onpaste="return false;"
                                    data-type="ccaptcha" onkeyup="funInputFielTypes(this)">
                                <input type="hidden" name="captcha_code" id="captcha_code"
                                    value="<?php echo $_SESSION['code']; ?>">
                                <div id="captchaX" style="font-size:12px;color:red;"></div>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="">
                            </div>
                        </div>

                        <div id="preloader" style="display:none;">
                            <div class="loader"></div>
                        </div>


                        <span style="color:red;display:none;" id="otperror" class='alert alert-danger'> </span>

                        <button type="button" class="form-control bg-success" style="display:block;"
                            onclick="onSubmit()" id="signInBtn">Sign in</button>



                        <div id="otpSection" style="display:none;">
                            <span style="color:green;" id="otpsuccess" class='alert alert-success'></span>
                            <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter otp"
                                minlength="4" maxlength="4" required="required"
                                style="border-radius:3px;margin-bottom:15px;" pattern="[0-9]{1,4}"
                                title="Only numbers, up to 4 digits" onpaste="return false;" data-type="dotp"
                                onkeyup="funInputFielTypes(this)">
                            <div id="otpX" style="font-size:12px;color:red;"></div>
                            <button type="submit" class="btn btn-success  btn-block" id="submitBtn" disabled>Sign
                                In</button>
                        </div>

                    </form>
                </section>

                <!--<center>-->
                <!--	<img src="images/helpline.png" width="100">-->
                <!--	</center>
						
						<center style="font-size:16px; color:#000;">
						     <strong> <a href="/grievance/forgot_password.php">Forgot Password? </a> </strong>
						    
						</center>-->

                <center style="margin-top:35px;font-size:16px; color:#000;">

                    <strong> <a href="/" style="color: red;"><?php if (!empty($_SESSION['msg'])) {
                                                                    echo $_SESSION['msg'];
                                                                    session_destroy();
                                                                } ?> </a> </strong>

                </center>

            </div>
        </div>
    </section>
    <!-- JS 

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-NNxAoPm2Y+nbDt6ro2RAt+ZrFkgNiNpA9dOTGxe4zYpUHPdL5EVI7NFO4Yl58N9k" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
-->
    <script src="<?php echo $bsurl; ?>/grievance/js/bootstrap-fte.bundle.min.js"></script>
    <link href="<?php echo $bsurl; ?>/grievance/css/bootstrap-fte.min.css" rel="stylesheet" >
    <script src="<?php echo $bsurl; ?>/grievance/js/jquery-tso.min.js"></script>

    <script>
    function onSubmit() {
        // Get elements
        var signInbtn = document.getElementById("signInBtn");
        var otpOption = document.getElementById("otpSection");
        var username = document.getElementById("username").value;
        var password = document.getElementById("fk").value;
        var otpsuccess = document.getElementById("otpsuccess");
        var otperror = document.getElementById("otperror");

        signInbtn.style.display = "none";

        $("#preloader").show();
        //alert('test');
        // Send OTP request
        $.post('send_otp_mobile.php', {
            username: username,
            password: password
        }, function(data) {

            //var data = JSON.parse(data);

            //alert(data); // success response
            if (data) {
                $("#preloader").hide();
                // Hide / Show sections
                otpsuccess.style.display = "block";
                otpOption.style.display = "block";
                otperror.style.display = "none";
                otpsuccess.innerHTML = 'OTP Sent to your mobile!';
            } else {
                $("#preloader").hide();
                otpsuccess.style.display = "none";
                otpOption.style.display = "none";
                signInbtn.style.display = "block";
                otperror.style.display = "block";
                otperror.innerHTML = 'OTP not sent!,something went wrong!';
            }
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
        $('#butt').click(function() {
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
            message = '❌ First letter should not be empty!';
        } else {

            //alert(type);

            // Validate based on input type
            switch (type) {
                case 'text':
                    isValid = /^[a-zA-Z0-9\u0900-\u097F _\-\.() ]+$/.test(value);
                    if (!isValid)
                        message = '❌ Invalid characters! Use letters, numbers, -, _, . () or space.';
                    break;

                case 'dcaptcha':
                    isValid = /^[0-9]{4}$/.test(value);
                    if (!isValid) message = '❌ Invalid Captcha! Use digits only and max length is 4 digits.';
                    break;

                case 'ccaptcha':
                    isValid = /^[a-zA-Z0-9]{6}$/.test(value);
                    if (!isValid) message = '❌ Invalid Captcha! Use alphanumerics only and max length is 6 characters.';
                    break;

                case 'password':
                    isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-])[A-Za-z\d@$!%*?&#^()_+=\-]{8,}$/
                        .test(value);
                    if (!isValid) {
                        message =
                            '❌ Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
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

</body>

</html>