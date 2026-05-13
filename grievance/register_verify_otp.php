<?php
session_start();
error_reporting(0);

    
    require_once('connection.php');
	$conn=getconnection();
	$ulbid=250;
	
	date_default_timezone_set("Asia/kolkata");

		$verify_otp_status = 0;
		
		$verification_status = 0;
if (isset($_POST['otp'])) {
  //  print_r($_POST); exit;
    $otp = $_POST['otp_new'];
    $mb = $_POST['mb'];

    $sql = "select * from users_test where user_mobile='" . $mb . "' and otp_status=1";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($rs); 
    // $row['otp']; exit;
    if($otp == $row['otp']){
        $sql = "update users_test set otp_status=2 where otp='" . $otp . "' and user_mobile='" . $mb . "'";
        $rs = mysqli_query($conn, $sql);
        $url = "complaint_form.php";
            $verification_status = 1;
            echo "<script>window.location='" . $url . "';</script>";
            $message = "Updated OTP";
    }else{
            $otp_err_msg = "Invalid OTP";
    }

   
}

function validate_mobile($mobile)
{
    return preg_match('/^[0-9]{10}+$/', $mobile);
}
if (isset($_POST['mobileno'])) {
  //echo "ho"; exit;
        $stamp = date('Y-m-d H:i:s');
        $otpExpiryDate = date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime(($stamp))));
        $otp = rand(1000, 9999);
        $sql = "update users_test set  otp='" . $otp . "',emailOtp='" . $otp . "', otpdatetime = '".$stamp."' , otpexpiretime = '".$otpExpiryDate."' where user_mobile='" . $_POST['mobileno'] . "'";
            if(mysqli_query( $conn, $sql ) ){
                $_SESSION['mobilesubmit'] = 1;
                $_SESSION['otpstaus'] = 1;

            //$ulbid = $_POST['ulbid'];
            $user_mobile = $_POST['mobileno'];
        //	$mobilecheck = validate_mobile($user_mobile);
        
                $_SESSION['sel_mobile'] = $user_mobile;
                $_SESSION['ulbid'] = $ulbid;

                $ulbsql = "select * from ulbmst JOIN ulb_type ON ulb_type=ulb_type_id where ulbid='" . $_SESSION['ulbid'] . "'";
                $ulbrs1 = mysqli_query($conn, $ulbsql);

                $ulbName = mysqli_fetch_assoc($ulbrs1);

                $uName = $ulbName['ulbname'];
                $datetime = date('Y-m-d H:i:s');
                
                // $sms = "Dear ".substr($emp_name_list[$row1['emp_id']], 0, 28).", A Grievance from ".mysqli_real_escape_string($conn,strip_tags(substr($_POST['person_name'], 0, 28))).", Mobile No. ".mysqli_real_escape_string($conn,strip_tags($_POST['mobile'])).", ".substr($complaintType, 0, 28)." with Ref No ".$grievance_id."is allotted to you on ".date('d-m-Y H:i:s')." https://egovmars.in/csms/ Regards- CitizenServiceMonitoringCell ,NMCGOV";
                $sms = "One Time Password (OTP) for NMC application logging is ".$otp." Please use this OTP for logging NMCGov. Pls do not share this with any one, Valid for 5 minutes.";	
                $mobile = $user_mobile;
                $templateId = "1507166546678524968";
                $message =str_replace ( ' ', '%20', $sms);
                $url = "http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=" . $templateId . "&mobile=" . $mobile . "&message=" . $message;
                
                $post = curl_init();
                curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($post, CURLOPT_URL, $url);
                curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                $result=curl_exec($post);
                //print_r($result);
                $minutes_to_add = 5; 

            
                $sql = "insert into user_otp_logs(
                                user_ip,
                                mobile,
                                otp,
                                otp_date_time,
                                otp_expiry_date,
                                otp_status
                                
                                )values(
                                    '" . $_SERVER['REMOTE_ADDR'] . "',
                                    '" . $user_mobile . "',
                                    '" . $otp . "',
                                    '" . date('Y-m-d H:i:s') . "',
                                    '" . date('Y-m-d H:i:s', strtotime($stamp)) . "',
                                    '0'
                                    )";
                                mysqli_query($conn, $sql);

                                $otpstaus = 1;
                                $_SESSION['sel_mobile'];
                                
                        
                // 		$indexpage = 'complaint_form.php?id='.$_POST[ 'ulbid' ].'&status='.$status.'&ref_id='.$grievance_id;
                $indexpage = 'register_verify_otp.php';
                //header( "location:$indexpage" );
               // echo "<script>window.location='$indexpage';</script>";
            }else{
            }
}
		
		
		$conn->close();
		

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

<title>:: New Complaint Registration</title>

 <link rel="stylesheet" href="./css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>


.merror{
    color:red;
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
	margin-top:10px;
	margin-bottom:0px;
	}
.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.mb_bg{
    background-image:url(images/mb_bg.jpg);
    height:600px;
    background-size: contain;
    background-position: bottom;
    background-repeat: repeat-x;
    background-color: #068fdd;
}

.dcenter{
    display: flex;
    justify-content: center;
    margin-top: 50px;
}










</style>

<?php if ($otpstaus == 1 && $_SESSION['mobilesubmit'] == 1) { ?>
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
<?php } ?>

<script>
function validateForm()
{
errors=0;
var mobile=$("#mobile").val();
	var patt1= /^\d{10}$/;
	if(!patt1.test(mobile))
    	{
		($('#mobile')).css({"background-color": "pink"});
		errors++;    	
	}
$(".mytext").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});



$(".dropdown").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='0')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});
		
    	
	if(errors==0)
	{
		return true;
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
}
</script>

<script src='../js/jquery.min.js'></script>

<script>
$(document).ready(function() {

$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });
    

}); 
</script>


</head>


<body style="padding:0px; margin:0px;">

<div class="row" style="background-color:#0b1c40;">
<div class="container">
<center>
<img src="<?//php echo $banner; ?>"  class="img-responsive">
</center>
</div>
<div>
    <?php if(isset($_REQUEST['message'])){ echo $_REQUEST['message'];}?>
</div>
<div style="background-color:#0066CC; color:#FFF; padding:5px; text-align:center; font-size:22px;">
<div class="container" style="line-height: 6px;     padding-bottom: 15px;">
	<img src="images/nagpur-logo.png" style="width:50px;"> 
<!-- <strong>New Problem Registration </strong> -->
<strong>NAGPUR MUNICIPAL CORPORATION   <br> नागपूर महानगरपालिका</strong>
<!--<img src="images/smart-city.png" style="width:50px;"> -->
</div>
</div>
</div>


<div class="error"><center></center></div>




<div class="container">

<!--<div class="text-center">-->
	
<!--	<img src="images/helpline.png" width="180">-->
<!--</div>-->


<div class="row" style="clear:both; min-height:45px; align-items: center;">



<!--<div class="col-md-10 text-center ">-->
<!--	<h3>SAMADHAAN COMPLAINT RESOLUTION SYSTEM / समाधान तक्रार निवारण प्रणाली</h3>-->
 <!-- District: <strong> <?php //echo $distName; ?> Aurangabad </strong>  -->
<!--</div>-->

<!--<div class="col-md-8 text-left ">
	<h2>COMPLAINT REGISTRATION / तक्रार नोंदणी</h2>
  District: <strong> <?php //echo $distName; ?> Aurangabad </strong>  
</div>-->


<!-- <div class="col-md-4 text-center ">
 ULB Name: <strong> <?php //echo $ulbName; ?> Aurangabad Municipal Corporation</strong>
</div> -->



<div class="col-md-4 pull-right text-right">
<a class="btn btn-primary " href="web_register_form.php?id=<?php echo $ulbid; ?>" target="_blank" style="list-style:none; color:#FFF;margin-top: 23px; margin-bottom: 23px;">Register </a>

<a class="btn btn-success " href="check_comp_status.php?id=<?php echo $ulbid; ?>" target="_blank" style="list-style:none; color:#FFF;margin-top: 23px; margin-bottom: 23px;">Check Status / तक्रार स्थिती तपासा</a>

</div>


</div>

 <div class="panel panel-info">
            <div class="panel-heading" style="text-align:center;"><strong>Grievance Redressal System</strong></div>
            
            <div class="panel-body mb_bg">

                <?php if ($_SESSION['otpstaus'] == 0) { ?>

                    <form action="" class="form-horizontal" method="post">

                        <input type="hidden" name="ulbid" value="<?php echo $ulbid; ?>" id="ulbid">

                        <span id="form">


                            <div class="row dcenter">

                                <div class="col-md-5" style="margin-left:15px; margin-right:15px;">
                                    <div class="form-group">
                                        <label>Please enter your mobile number (10 digits) to continue </label>
                                        <input  type="text" name="mobileno" id="mobileno" placeholder="" value="<?php echo $user_mobile; ?>" class="form-control mytext numeric" maxlength="10" required autocomplete="off">
                                        <input type="hidden" name="app_type_id" value="1">
                                        <p class="text-danger"></p>
                                    </div>
                                </div>

                                <div class="col-md-2" style="padding-top: 24px;">

                                    <button type="submit" class="btn btn-success" name="save">Send OTP</button>
                                </div>



                            </div>

            </div>
            </span>

            </form>
        <?php } ?>
        <input type="hidden" id="otp_status" value="<?php echo $otpstaus;?>">
        <input type="hidden" id="mob_status" value="<?php echo $_SESSION['mobilesubmit'];?>">
        <input type="hidden" id="verify_otp_status" value="<?php echo $verify_otp_status;?>">
        <?php if ($_SESSION['otpstaus'] == 1 && $_SESSION['mobilesubmit'] == 1) {

        ?>

            <form action="register_verify_otp.php" method="post">
                <div class="row dcenter">

                    <div class="col-md-4" style="margin-left:15px; margin-right:15px;">
                        <div class="form-group">
                            <label>Enter OTP</label>
                            <input type="text" name="otp_new" id="otp" placeholder="" class="form-control mytext numeric" maxlength="4" required>
                            <input type="hidden" value="<?php echo (isset($_SESSION['sel_mobile']) ? $_SESSION['sel_mobile'] : '' );?>" name="mb">
                            <input type="hidden" value="<?php echo $_SESSION[ 'sel_mobile' ];?>" name="mb">
                            <p class="text-danger"></p>
                            <p class="text-danger" id='otp_err_msg'><?php echo  (isset($otp_err_msg )) ? $otp_err_msg  : '' ; ?></p>
                        </div>
                        
                        <div class="counter-container " > 
                            <span id="timer" style="font-family: 'Orbitron', sans-serif;"></span>
                        </div>
                        
                    </div>

                    <div class="col-md-3" style="padding-top: 24px;">
                        <button type="submit" class="btn btn-success" name="otp">Submit</button>
                        <button type="button" class="btn btn-success" onclick="resendotp()">Resend OTP</button>
                    </div>


                </div>
            </form>
            <form action="" id="resend_otp" method="post">
                <input type="hidden" value="<?php echo (isset($_SESSION['sel_mobile']) ? $_SESSION['sel_mobile'] : '' );?>" name="mobileno">
            </form>
        <?php } ?>
        </div>


    
  <?php  if($_REQUEST['status']==1){echo '<div class="alert alert-success" role="alert">Complaint Registered successfully with Reference no '.$_REQUEST['ref_id'].'</div>';}?>




    
    
   
    
  
        
        
    </div>

         
                
     </div> 
     <!--//captch code start here-->
	 
	
	 
	 
     <script>
    //Refresh Captcha
    function refreshCaptcha(){
        var img = document.images['captcha_image'];
        img.src = img.src.substring(
     0,img.src.lastIndexOf("?")
     )+"?rand="+Math.random()*1000;
    }
    </script>
     <script>
     function get_streets(ward_id)
	{
	$.post('ajax_getstreets.php',{ward_id:ward_id},function(data)
		{
			$('#street_id').html(data);
		});
	}
	
	function get_csdesc(cat_id)
	{
	
	var ulbid=$("#ulbid").val();
	


	$.post('ajax_getcomplaints.php',{cat_id:cat_id,ulbid:ulbid},function(data)
		{
			
			
			$('#cs_id').html(data);
				if(ulbid=='052' && cat_id=='3')
            		{
            		    $("#tanker_dropdown").css('display','block');
            		    $("#tanker_id").addClass('dropdown');
            		}
            		else
            		{
            		    $("#tanker_dropdown").css('display','none');
            		    $("#tanker_id").removeClass('dropdown');
            		}
		});

	}
	     
     </script>   
     
	  <script>
	 function get_sc_desc(dept_id)
	 {
   

 
var department_id = 1;
var app_type_id=1;
 
$.post('get_sub_cat.php',{dept_id:dept_id,app_type_id:app_type_id,department_id:department_id},function(data)
	{
	  
	   
		if(app_type_id==1)
		{
		
		$('#sub_id').html(data);
		}
		else
		{
		    
		}
	
		
		if(app_type_id=='1' && ulbid=='052' && dept_id=='3')
		{
		    $("#tanker_dropdown").css('display','block');
		    $("#tanker_id").addClass('dropdown');
		}
		else
		{
		    $("#tanker_dropdown").css('display','none');
		    $("#tanker_id").removeClass('dropdown');
		}
		
		get_det(dept_id);
		
	});

}




$(function(){
    let otp_status = $('#otp_status').val();
    let mob_status = $('#mob_status').val();
    let verify_otp_status = $('#verify_otp_status').val();
    
    (otp_status == 1 && mob_status == 1 && verify_otp_status == 0) ? initiateTimer() : '';
});

function initiateTimer(){
    document.getElementById('timer').innerHTML = 05 + ":" + 00;
    startTimer();
}
 
    function startTimer() {
      var presentTime = document.getElementById('timer').innerHTML;
      var timeArray = presentTime.split(/[:]+/);
      var m = timeArray[0];
      var s = checkSecond((timeArray[1] - 1));
      if(s==59){m=m-1}
      if(m<0){
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
      if (sec < 10 && sec >= 0) {sec = "0" + sec}; // add zero in front of numbers < 10
      if (sec < 0) {sec = "59"};
      return sec;
    }
    
    function resendotp(){
        $('#resend_otp').submit();
    }

	 </script>
	 
	 
<br />

<!--<div class="footer_div">Powered by - <a href="http://vmaxindia.com/" class="footerlinks" target="_blank" style="color:#00bff3; ">VMAX</a></div>-->


</body>
</html>
                            
                          