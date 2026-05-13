<html lang="en">

      <!-- HEAD -->

  



<head>

    <!-- META TAG -->

    <meta charset="utf-8">

    

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="REGISTER COMPLAINT / SERVICE,  Trade License , Water tax payment , Dharani Citizen Registration , e-office , Swachta App Statistics, Application Management, E-News, App Masters, Council ,

Social Connect, Important Contacts, Media Coverage, Notifications, Smart Ideas Box, Citizen buddy,  Online Water Tap Application , Online Trade Application, Online Advertisement Application, Property Tax Self Assessment, Property Tax Calculator, Municipal Council"/>

	<!-- END META TAG -->

	

    <title>Citizen services monitoring system </title>



    <link href="css/styles.css" rel="stylesheet"><!-- Trata template Basic CSS -->

   <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,900" rel="stylesheet">

   <script src="js/cryptojs/rollups/md5.js"></script>

    <script src="js/cryptojs/components/md5.js"></script>

	

	

    

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

		  <section id="content" class="m-t-lg wrapper-md ">

				  <div class="nav-brand bounceInDown animated">

				  <center>

				      <div>

				          <img src="images/arangabad.png" width="120" height="118">

				          

				          </div>

<div style="color:#2b3595; font-size:30px; font-weight:bold; font-family: 'Source Sans Pro', sans-serif;">Citizen Service Monitoring System</div>

<div style="color:#f16821; font-size:40px;  font-family: 'Mallanna', sans-serif; "><img src="images/title.png" width="230"></div>

				      

				 

				 </center>

				  </div>

				  

				  

				 

				  

				  

				  

				<div class="row m-n animated wobble">

					<div class="col-md-4 col-md-offset-4 ">

						<section class="panel panels panel-primary"><header class="panel-heading text-center"> <strong>LOG IN</strong> </header>

							<?php if(isset($_SESSION['message'])){

				  echo "<div class='alert alert-danger'>".$_SESSION['message']."</div>";

				  unset($_SESSION['message']);

				  }?>

							

							

							<form action="check_login.php" id="login-form" class="panel-body" method="post" autocomplete="off" onsubmit="return validateForm()">

							<input type="hidden" name="login_path" value="https://www.aurangabadmahapalika.org/csms/">

								<div class="form-group">

									<label class="control-label">Username</label><input placeholder="Username" class="form-control" type="text" name='username' id="username" autocomplete="off" value="" required>

								</div>

								<div class="form-group">

								    

									<label class="control-label">Password</label>

									<input  placeholder="Password" class="form-control" type="password" name="password"  id="password" autocomplete="off" value=""required >

									<input type="hidden" name="fk" id="fk">

									

								</div>

								

							

									

								

								

								

                

                <div class="form-group">

                  

                  <div class="">

                    

                 

                    <input type="hidden" name="code" id="code" value="<?php echo $_SESSION['code']; ?>">

                  </div>

                </div>

								

								

								

								<!--<a href="#" class="btn btn-facebook btn-block m-b-sm"><i class="fa fa-facebook pull-left"></i>Sign in with Facebook</a><a href="#" class="btn btn-twitter btn-block"><i class="fa fa-twitter pull-left"></i>Sign in with Twitter</a>-->

								<button type="submit" class="btn btn-success  btn-block">Sign in</button>

								

								 

							</form>

						</section>

						

						

						

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

      $('#ref').load('https://www.aurangabadmahapalika.org/csms/index.php #ref', function() {

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



</script>

     

     



  </body>

   <!-- END BODY -->





</html>    

     

