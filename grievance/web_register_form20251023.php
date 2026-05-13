<?php
session_start();
error_reporting(0);

// if(!isset($_SESSION['com_reg_mobile'])){
//     header('Location: https://egovmars.in/csms/complaint_form.php');
// }
// echo $_SESSION['com_reg_mobile'];
// die();
// if(!isset($_SESSION['login_status']) && $_SESSION['login_status'] != 1){
//     $indexpage="complaint_form.php";
// 		 //header("location:$indexpage");
// 	echo "<script>window.location='$indexpage';</script>";
// }

require_once "connection.php";
include "prepare_connection.php";
$conn = getconnection();
$ulbid = 250;
mysqli_query($conn, "SET character_set_results=utf8");
mysqli_query($conn, "SET names=utf8");
mysqli_query($conn, "SET character_set_client=utf8");
mysqli_query($conn, "SET character_set_connection=utf8");
mysqli_query($conn, "SET character_set_results=utf8");
mysqli_query($conn, "SET collation_connection=utf8_general_ci");

$sql = $conn->prepare("select distid,ulbid,ulbname from ulbmst where ulbid=?");
$sql->bind_param("s", $ulbid);
$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc()) {
		$ulbName = $row["ulbname"];
		$distid = $row["distid"];
	}
}

$sql = $conn->prepare("select distid,distname from Districtmst where distid=?");
$sql->bind_param("s", $distid);
$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc()) {
		$distName = $row["distname"];
	}
}

$sql = $conn->prepare(
	"select ward_id,ward_desc,wards_marathi from ward_mst where ulbid=? order by ward_id ASC"
);
$sql->bind_param("s", $ulbid);
$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc()) {
		$ward_list[$row["ward_id"]] = $row["ward_desc"];
	}
}

$flag = 1;
$sql = $conn->prepare(
	"select cat.cat_id,description,cat.telugu_description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag=? and cu.ulbid=? order by description ASC"
);
$sql->bind_param("is", $flag, $ulbid);

$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc()) {
		// if($row['cat_id']==5)
		// {
		//       $cat_list[$row['cat_id']]=strtoupper($row['description']);
		// }

		if ($row["cat_id"] == 9 || $row["cat_id"] == 8) {
			$cat_list[$row["cat_id"]] =
				$row["description"] . "/" . $row["telugu_description"];
		} else {
			$cat_list[$row["cat_id"]] = ucwords(
				strtolower(
					$row["description"] . "/" . $row["telugu_description"]
				)
			);
		}
	}
}

$show_status = 1;
$sql = $conn->prepare(
	"select grievance_origin_id,grievance_origin_desc from grievance_origin_mst where show_status=?"
);
$sql->bind_param("i", $show_status);

$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc()) {
		$grievance_origin_list[$row["grievance_origin_id"]] =
			$row["grievance_origin_desc"];
	}
}

$sql = $conn->prepare("select open_comp_banner from users where ulbid=?");
$sql->bind_param("s", $ulbid);

$sql->execute();
$rs = $sql->get_result();

$row = $rs->fetch_assoc();
$banner = $row["open_comp_banner"];

$sql = $conn->prepare("SELECT * FROM `water_tank_det_mst` where ulbid=?");
$sql->bind_param("s", $ulbid);

$sql->execute();
$rs = $sql->get_result();

while ($row = $rs->fetch_assoc()) {
	$tanker_list[$row["water_tank_id"]] = $row["water_tank_desc"];
}



$conn->close();
?>

<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>:: New  Registration</title>

	<link rel="stylesheet" href="./css/bootstrap.css">
<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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

		.toast-container .toast-error {
			margin-top: 100px !important;
		}

		.success_msg {
			font-size: 23px;
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
	<script>
		function validateForm() {
			errors = 0;
			var mobile = $("#mobile").val();
			var patt1 = /^\d{10}$/;
			if (!patt1.test(mobile)) {
				($('#mobile')).css({ "background-color": "pink" });
				errors++;
			}

			

			if (errors == 0) {
				return true;
			}
			else {
				toastr.error("Please Enter Correct Value in High-lighted Fields - " + (errors - 1));
				// 		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
				return false;
			}
		}
	</script>
	<script src='../js/jquery.min.js'></script>
	<script>
		$(document).ready(function () {

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
		<!--<div class="container">
			<center>
				<img src="<? //php echo $banner; ?>" class="img-responsive">
			</center>
		</div> -->
		<div>
			<?php if (isset($_REQUEST["message"])) {
				echo $_REQUEST["message"];
			} ?>
		</div>
		<div style="background-color:#0066CC; color:#FFF; padding:5px; text-align:center; font-size:22px;">
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
			<!-- District: <strong> <?php
			//echo $distName;
			?> Aurangabad </strong>  -->
			<!--</div>-->

			<div class="col-md-8 text-left ">
				<h2>USER REGISTRATION </h2>
				<!-- District: <strong> <?php
				//echo $distName;
				?> Aurangabad </strong>  -->
			</div>


			<!-- <div class="col-md-4 text-center ">
 ULB Name: <strong> <?php
 //echo $ulbName;
 ?> Aurangabad Municipal Corporation</strong>
</div> -->



			<div class="col-md-4 pull-right text-right">

				<!-- <a class="btn btn-success " href="check_comp_status.php?id=<?php echo $ulbid; ?>" target="_blank"
					style="list-style:none; color:#FFF;margin-top: 23px;">Check Status / तक्रार स्थिती तपासा</a> -->
				<!-- <a href="user_logout.php" class="btn btn-danger"
					style="list-style:none; color:#FFF;margin-top: 23px;">Logout</a> -->
			</div>  


		</div>
		<br />

		<?php if ($_REQUEST["status"] == 1) {
			echo '<div class="alert alert-success success_msg" role="alert"><strong>Complaint Registered successfully with Reference no ' .
				$_REQUEST["ref_id"] .
				"<strong></div>";
		} ?> 
 			<?php 
            if(isset($_SESSION['flash_message'])) {
                $message = $_SESSION['flash_message'];
                unset($_SESSION['flash_message']); ?>
               
                <div class="alert">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                     <?php  echo $message; ?>
                </div>
                <?php    } ?>

		<div class="panel panel-info">
			<div class="panel-heading" style="text-align:center;"><strong>Complaint Resolution System / तक्रार निराकरण
					प्रणाली</strong></div>
			<div class="panel-body">

				<form action="save_registration.php" class="form-horizontal" method="post" enctype="multipart/form-data"
					onsubmit="return validateForm()">

					<input type="hidden" name="ulbid" value="<?php echo $ulbid; ?>" id="ulbid">
					<input type="hidden" name="reg_mob" value="<?php echo $_POST["mobile"]; ?>" >

					<span id="form">


						<div class="row">

							<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
								<div class="form-group">
									<label>Person Name / नाव <span class="merror">*</span> </label>
									<input type="text" name="person_name" id="person_name" placeholder="Name of Person " 
										class="form-control mytext"  data-type="text" onkeyup="funInputFielTypes(this)" required>
									<div id="person_nameX" style="font-size:10px;color:red;"></div>
									<input type="hidden" name="app_type_id" value="1">
									<p class="text-danger">
										<?php echo @$_SESSION["person_name"]; ?>
									</p>
								</div>
							</div>
							<?php if(isset($_POST["mobile"])){ ?>
							<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
								<div class="form-group">
									<label>Mobile No. / मोबाईल क्र. <span class="merror">*</span> </label>
									<input type="text" name="mobile" id="mobile" placeholder="Mobile No" value="<?php echo $_POST["mobile"]; ?>" class="form-control num mytext" maxlength="10"  data-type="mobile" onkeyup="funInputFielTypes(this)" required readonly>
									
									<div id="mobileX" style="font-size:10px;color:red;"></div>
									<p class="text-danger">
										<?php echo @$_SESSION["mobile"]; ?>
									</p>

								</div>
							</div>
							<?php }else{ ?>
								<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
								<div class="form-group">
									<label>Mobile No. / मोबाईल क्र. <span class="merror">*</span> </label>
									<input type="text" name="mobile" id="mobile" placeholder="Mobile No" class="form-control num mytext" maxlength="10"  data-type="mobile" onkeyup="funInputFielTypes(this)" required >
									<div id="mobileX" style="font-size:10px;color:red;"></div>
									<p class="text-danger">
										<?php echo @$_SESSION["mobile"]; ?>
									</p>

								</div>
							</div>
							<?php } ?>
							<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
								<div class="form-group">
									<label>Email / ईमेल <span class="merror"></span> </label>

									<input type="email" name="email" id="email" placeholder="E-Mail ID"
										class="form-control"  data-type="email" onkeyup="funInputFielTypes(this)">
										<div id="emailX" style="font-size:10px;color:red;"></div>
									<p class="text-danger">
										<?php echo @$_SESSION["email"]; ?>
									</p>
								</div>
							</div>
							

						</div>
						<div class="row">
       
	   <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
	   <div class="form-group">
		   <label>House No / घर क्र <span class="merror">*</span>   </label>
		   <input type="text" name="hno" id="hno" placeholder="House No/Plot No" class="form-control mytext" value="<?php echo $row['house_no'];?>"  data-type="address" onkeyup="funInputFielTypes(this)" required>
			<div id="hnoX" style="font-size:10px;color:red;"></div>
			<p class="text-danger">
				<?php echo @$_SESSION["hno"]; ?>
			</p>
	   </div>
	   </div>
	   
	   <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
	   <div class="form-group">
		   <label>Address / पत्ता <span class="merror">*</span>   </label>
		   <input type="text" name="address" id="address" placeholder="Address " class="form-control mytext"  value="<?php echo $row['address'];?>"  data-type="address" onkeyup="funInputFielTypes(this)" required>
			<div id="addressX" style="font-size:10px;color:red;"></div>
			<p class="text-danger">
				<?php echo @$_SESSION["address"]; ?>
			</p>	
	   </div>
	   </div>
	   
	  
	  
   </div>






						<div class="row">
							<!-- begin col-4 -->
							<div class="col-md-10" style="margin-left:15px; margin-right:15px;">
								<div class="form-group">
									<p class="text-danger">
										<?php echo @$_SESSION["captcha1"]; ?>
									</p>
									<div class="row">
										<div class="col-md-4">
											<label><strong>Enter Captcha / कॅप्चा प्रविष्ट करा:</strong></label><br />
											<input class="form-control" type="text" 
												data-validate="false" name="captcha" id="captcha" data-type="ccaptcha" maxlength="6" onkeyup="funInputFielTypes(this)" required autocomplete="off" />
											<div id="captchaX" style="font-size:10px;color:red;"></div>
										</div>
									</div>

									<p><br />
										<img src="get_captcha.php?rand=<?= rand(
											10,
											100
										) ?>" id='regenerate_captcha' style="border: 1px dashed gainsboro;filter: contrast(0.5);">

										<!--<img src="captcha.php?rand=<?php echo rand(); ?>" id='captcha_image'>-->
									</p>
									<p>Can't read the image?
										<a href='javascript: refreshCaptcha();'>click here</a>
										to refresh / प्रतिमा वाचू शकत नाही? रिफ्रेश करण्यासाठी येथे <a
											href='javascript: refreshCaptcha();'> क्लिक करा</a>
									</p>
								</div>
							</div>
							<!-- end col-4 -->
						</div>

						<div class="row">
							<!--<img src="get_captcha.php" id=''>-->

						</div>

						<div class="row">
							<span id="cut_det"></span>
						</div>
						<!-- begin col-4 -->
						<div class="col-md-12">
							<div class="form-actions fluid">
								<div class="col-md-offset-5 col-md-3">
								<!-- <input type="TEXT" value="<?php echo  $_SESSION[ 'captcha' ];?> "> -->
									<button type="submit" class="btn btn-success" name="save" id="submitBtn" disabled>Submit</button>
									<button type="reset" class="btn btn-danger">Cancel</button>
								</div>
							</div>
						</div>
						<!-- end col-4 -->
			</div>



			</span>

			</form>
		</div>
	</div>



	</div>
	<!--//captch code start here-->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
		integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
		integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script>
		//Refresh Captcha
		// function refreshCaptcha(){
		//     var img = document.images['captcha_image'];
		//     img.src = img.src.substring(
		//  0,img.src.lastIndexOf("?")
		//  )+"?rand="+Math.random()*1000;
		// }
		function refreshCaptcha() {
			var img = document.images['regenerate_captcha'];
			img.src = "get_captcha.php" + "?rand=" + Math.floor(Math.random() * 1000);;
		}
	</script>
	<script>
		function get_streets(ward_id) {
			$.post('ajax_getstreets.php', { ward_id: ward_id }, function (data) {
				$('#street_id').html(data);
			});
		}

		function get_csdesc(cat_id) {

			var ulbid = $("#ulbid").val();



			$.post('ajax_getcomplaints.php', { cat_id: cat_id, ulbid: ulbid }, function (data) {


				$('#cs_id').html(data);
				if (ulbid == '052' && cat_id == '3') {
					$("#tanker_dropdown").css('display', 'block');
					$("#tanker_id").addClass('dropdown');
				}
				else {
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

			$.post('get_sub_cat.php', { dept_id: dept_id, app_type_id: app_type_id, department_id: department_id }, function (data) {


				if (app_type_id == 1) {

					$('#sub_id').html(data);
				}
				else {

				}


				if (app_type_id == '1' && ulbid == '052' && dept_id == '3') {
					$("#tanker_dropdown").css('display', 'block');
					$("#tanker_id").addClass('dropdown');
				}
				else {
					$("#tanker_dropdown").css('display', 'none');
					$("#tanker_id").removeClass('dropdown');
				}

				get_det(dept_id);

			});

		}

		$(document).on("change", "#f1", function () {
			if (this.files[0].size > 5000000) {
				toastr.error("Please upload file less than 5MB. Thanks!!");
				$(this).val('');
			}
		});
		$(document).on("change", "#validate_captcha", function () {
			$.ajax({
				url: "get_captcha_string.php",
				dataType: 'text',
				cache: false,
				success: function (data) {
					console.log(data + '--' + $('#validate_captcha').val())
					if ($('#validate_captcha').val() == data) {
						// alert($('#validate_captcha').val());
						$('#validate_captcha').attr('data-validate', 'true');
						// alert()
					} else {
						$('#validate_captcha').attr('data-validate', 'false');
						toastr.error('Please Enter a Valid Captcha');
					}
					console.log(data)
				}
			});
		});
		$(document).on("change", "#sub_id", function () {
			let sub_id = $(this).val();
			(sub_id == 7) ? $('#property_tx_dept').css('display', 'block') : $('#property_tx_dept').css('display', 'none');
		});

		window.onpopstate = () => setTimeout(alert.bind(window, "Pop"), 0);

	</script>
	<?php if (isset($_SESSION["f1"])) { ?>
		<script>
			$(document).on('ready', function () {
				toastr.error('<?= $_SESSION["f1"] ?>');
			});

		</script>
	<?php } ?>
	<br />

	<!--<div class="footer_div">Powered by - <a href="http://vmaxindia.com/" class="footerlinks" target="_blank" style="color:#00bff3; ">VMAX</a></div>-->

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
	  if (!isValid) message = '❌ Invalid Captcha! Use digits only and max length is 6 digits.';
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
</body>

</html>