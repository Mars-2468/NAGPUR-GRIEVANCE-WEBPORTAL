
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="description" content="Nagpur Municipal Corporation">
    
    <meta name="keywords" content="Nagpur Municipal Corporation">

    <title> :: Dashboard</title>

   
   

    <!-- Styles -->
    
   <link href="<?php echo base_url(); ?>assets/css/core.min.css" rel="stylesheet">
   
    <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet">
    
    <link href="<?php echo base_url(); ?>assets/css/style.min.css" rel="stylesheet">
    
    <script src="<?php echo base_url(); ?>/assets/js/jquery.disableAutoFill.min.js"></script>
    
    <script src="<?php echo base_url(); ?>/assets/js/custome/sites/rollups/sha256.js"></script>
    
    <script src="<?php echo base_url(); ?>/assets/js/custome/sites/components/sha256.js"></script>
    
    
    
     
     <script src='<?php echo base_url(); ?>/assets/js/jquery-3.6.0.min.js'></script>
    
    <script src='<?php echo base_url(); ?>/assets/js/api.js'></script>
        
        
    <script>
    
    const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    function generateString(length) {
        let result = '';
        const charactersLength = characters.length;
        for ( let i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    
       
        
        function validateForm()
        {  
                var username=$("#username").val();
                var pwd=$("#password").val();
                var uniqs = $("#uniqs").val();
                var hash1 = $('#hash1').val();
                var hash2 = $('#hash2').val();
                var length = $('#length').val();
                
                var encpwd=CryptoJS.SHA256(pwd);
                var encpwd1 = hash1+encpwd;
                var encpwd2 = length+encpwd1;
                var encpwd3 = encpwd2+hash2;
            // alert(encpwd3);
                
                if($("#password").val(encpwd3))
                {
                   $("#password").val(encpwd3);
                   $("#fk").val(encpwd3);
                   //$("#uniqs").val(encuniqs);
                  return true;
                }
        }
    </script>
    
    <style>
        
        .btn-danger {
    background-color: #e90c8a;
    border-color: #c80072;
    color: #fff;
}
        
    </style>
    
    
    
    
    
    
    
  </head>
  

  <body>


    <div class="row no-gutters min-h-fullscreen bg-white">
      <div class="col-md-6 col-lg-7 col-xl-8 d-none d-md-block bg-img" style="background-size: cover;     background-position: initial; background-image: url(<?php echo base_url(); ?>assets/img/Bhusurvey.png)" data-overlay="5">

        <div class="row h-25 pl-50">
          <div class="col-md-10 col-lg-8 align-self-end">
          <!--  <img src="img/logo-light-lg.png" alt="...">
            <br><br><br>
            <h4 class="text-white">The admin is the best admin framework available online.</h4>-->
             
            <br><br>
          </div>
        </div>

      </div>

      
      <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">
          <div style="width:100%; text-align:center"><?php if($this->session->flashdata('error_message')){echo $this->session->flashdata('error_message');}?></div>
        <div class="px-80 py-30">
          <h3> LOGIN</h3>
         
          <br>
          <?php $attributes=array('class'=>'form-type-material', 'method'=>'post','id' => 'formLogin','onsubmit'=>' return validateForm()'); ?>
          
          <?php echo form_open('Login',$attributes);?>
          <div class="form-group">
                
              <input type="text" class="form-control" id="username" name="username" placeholder='username' autocomplete="off">
            
            </div>

            <div class="form-group">
              <input type="password" class="form-control"  name="password" id="password" placeholder='password' onchange="changePassword()" autocomplete="off">
              <input type="hidden" id="fk" name="fk">
              <input type="hidden" id="hash1"  value="<?php echo $hash1 ?>">
              <input type="hidden" id="hash2"  value="<?php echo $hash2 ?>">
              <input type="hidden" id="length"  value="<?php echo $length ?>">
              <!--<input type="hidden" id="uniqs" name="uniqs" value="<?php echo $this->session->userdata('uniqs'); ?>">-->
              
            </div>
            
            
            <!-- <div class="form-group">
              <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key'); ?>"></div> 
            <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
              
            </div> -->
            
            
            
            <!--<p id="captImg"><?php echo $captchaImg; ?></p>-->
            <!--    <p>Can't read the image? click <a href="javascript:void(0);" class="refreshCaptcha">here</a> to refresh.</p>-->
                
            <!--    <div class="form-group">-->
                  
            <!--      <div class="input-group">-->
                    
            <!--        <input type="text" class="form-control form-control-lg border-left-0" name="captcha" placeholder="Enter Captcha" autocomplete="off">-->
            <!--      </div>-->
            <!--    </div>-->
            <div class="form-group">
             <input type="submit" class="btn btn-bold btn-block btn-primary" name="submit" value="Submit" id="form-submit">
             <input type="button" onclick="location.href='/'" class="btn btn-bold btn-block btn-dark" name="submit" value="Cancel" id="form-submit">
        	</div>
          <?php echo form_close(); ?>

           	<?php if (isset($_GET['message']) && $_GET['message'] === 'session_expired'): ?>
				<div class="alert alert-danger">
					Your session has expired due to inactivity. Please log in again.
				</div>
			<?php endif; ?>
				<?php if (isset($_GET['new_message']) && $_GET['new_message'] === 'new_session'): ?>
				<div class="alert alert-danger">
					You have been logged out because new session was started.
				</div>
			<?php endif; ?>

          <hr class="w-30px">

        </div>
      </div>
    </div>

    <script>
    $(document).ready(function(){
        $('.refreshCaptcha').on('click', function(){
            $.get('<?php echo base_url().'Login/refresh'; ?>', function(data){
                $('#captImg').html(data);
            });
        });
    });
    function changePassword(){
            var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';    
            var password = $('#password').val();
            //alert(password);
            if(password != ''){
                var dd = encodeURIComponent(window.btoa(password));
                $('#password_con').val(dd);
                /*$.post('<?php echo base_url().'Login/changePassword'; ?>',{password:password,csrf_test_name: csrf_value},function(data){
                    //alert(data);
                    $('#password_con').val(data);
                });*/
            }
        }
        
       
    </script>


  </body>


</html>

