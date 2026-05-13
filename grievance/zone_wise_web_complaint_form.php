<?php
require "config.php";
error_reporting(0);

/* if (!isset($_SESSION['com_reg_mobile'])) {
	header('Location: https://nmcnagpur.gov.in/grievance/complaint_form.php');
} */
// echo $_SESSION['com_reg_mobile'];
// die();

/* 
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != 1) {
	$indexpage = "complaint_form.php";
	//header("location:$indexpage");
	echo "<script>window.location='$indexpage';</script>";
} */

//echo "<pre>";print_r($_POST);echo "</pre>";die('ddd');

require_once('citizen_comp_connection.php');
//include('prepare_connection.php');
$conn = getconnection();
$ulbid = 250;
mysqli_query($conn, 'SET character_set_results=utf8');
mysqli_query($conn, 'SET names=utf8');
mysqli_query($conn, 'SET character_set_client=utf8');
mysqli_query($conn, 'SET character_set_connection=utf8');
mysqli_query($conn, 'SET character_set_results=utf8');
mysqli_query($conn, 'SET collation_connection=utf8_general_ci');

//var_dump($_SESSION['com_reg_mobile']);die();

$sql = "SELECT * FROM `grievances` WHERE `mobile` LIKE '" . $_SESSION['com_reg_mobile'] . "' AND `feedback_status` = 0 and grievance_status_id in(9,11,12,13)";
$rs = mysqli_query($conn, $sql);
$nr = mysqli_num_rows($rs);
//exit;
if ($nr > 0) {

	$redirect_url = "check_comp_status.php?id=250";
	header('Location: ' . $redirect_url);
} 

$sql = $conn->prepare("select distid,ulbid,ulbname from ulbmst where ulbid=?");
$sql->bind_param("s", $ulbid);
$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc()) {
		$ulbName = $row['ulbname'];
		$distid  = $row['distid'];
	}
}

$sql = $conn->prepare("select distid,distname from Districtmst where distid=?");
$sql->bind_param("s", $distid);
$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc())
		$distName  = $row['distname'];
}

$sql = $conn->prepare("select ward_id,ward_desc,wards_marathi from ward_mst where ulbid=? order by ward_id ASC");
$sql->bind_param("s", $ulbid);
$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc())
		$ward_list[$row['ward_id']] = $row['ward_desc'];
}

$flag = 1;
$sql = $conn->prepare("select cat.cat_id,description,cat.telugu_description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag=? and cu.ulbid=? order by description ASC");
$sql->bind_param("is", $flag, $ulbid);

$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc()) {
		// if($row['cat_id']==5)
		// {
		//       $cat_list[$row['cat_id']]=strtoupper($row['description']);
		// }

		if ($row['cat_id'] == 9 || $row['cat_id'] == 8) {
			$cat_list[$row['cat_id']] = $row['description'] . '/' . $row['telugu_description'];
		} else {
			$cat_list[$row['cat_id']] = ucwords(strtolower($row['description'] . '/' . $row['telugu_description']));
		}
	}
}

$show_status = 1;
$sql = $conn->prepare("select grievance_origin_id,grievance_origin_desc from grievance_origin_mst where show_status=?");
$sql->bind_param("i", $show_status);

$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc())
		$grievance_origin_list[$row['grievance_origin_id']] = $row['grievance_origin_desc'];
}

$sql = $conn->prepare("select open_comp_banner from users where ulbid=?");
$sql->bind_param("s", $ulbid);

$sql->execute();
$rs = $sql->get_result();

$row = $rs->fetch_assoc();
$banner = $row['open_comp_banner'];

$sql = $conn->prepare("SELECT * FROM `water_tank_det_mst` where ulbid=?");
$sql->bind_param("s", $ulbid);

$sql->execute();
$rs = $sql->get_result();

while ($row = $rs->fetch_assoc()) {
	$tanker_list[$row['water_tank_id']] = $row['water_tank_desc'];
}
//////////fetch registered data/////////
$sql = "select * from users_test where user_mobile='" . $_SESSION['com_reg_mobile'] . "' and otp_status=2";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
//print_r($row); exit;
/////////////fetch registered data////////////////

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

		#overlay {
			position: fixed;
			top: 0;
			z-index: 1200;
			width: 100%;
			height: 100%;
			display: none;
			background: rgba(0, 0, 0, 0.6);
		}

		.cv-spinner {
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.spinner {
			width: 40px;
			height: 40px;
			border: 4px #ddd solid;
			border-top: 4px #2e93e6 solid;
			border-radius: 50%;
			animation: sp-anime 0.8s infinite linear;
		}

		@keyframes sp-anime {
			100% {
				transform: rotate(360deg);
			}
		}


		@media (max-width: 767px) {
			.nav-header {
				font-size: 16px !important
			}

			.comp-txt {
				font-size: 16px !important
			}

			.comp-btn {
				text-align: center !important;
				float: none !important;
				margin-top: 0px
			}

			.comp-btn a {
				margin-top: 12px !important
			}
		}

		.comp-btn {
			float: right
		}
	</style>
	<script>
		function validateForm() {
			$("#overlay").fadeIn();
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

			$(document).on("change", "#f1", function() {
				if (this.files[0].size > 5000000) {
					toastr.error("Please upload file less than 5MB. Thanks!!");
					$(this).val('');
					errors++;
				}

			});
			if ($("#f1").val() == '') {
				toastr.error('Please upload file.');
				errors++;
			}
			if ($('#validate_captcha').attr('data-validate') == 'false') {
				errors++;
				$('#validate_captcha').css({
					"background-color": "pink"
				});
			} else {
				$('#validate_captcha').css({
					"background-color": "white"
				});
			}


			if (errors == 0) {
				//$("#submitBtn").prop("disabled", true);
				//return true;


				// Submit the form
				$("#myForm").submit();
				//$("#submitBtn").prop("disabled", true);
			} else {
				$("#overlay").fadeOut();
				toastr.error("Please Enter Correct Value in High-lighted Fields - " + (errors - 1));
				// 		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
				return false;
			}
		}
	</script>
	<script src='../js/jquery.min.js'></script>
	<script>
		$(document).ready(function() {

			$(".num").keypress(function(e) {

				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					return false;
				}
			});


		});
	</script>

</head>

<body style="padding:0px; margin:0px;">
	<div id="overlay">
		<div class="cv-spinner">
			<span class="spinner"></span>
		</div>
	</div>
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
		<div class="nav-header" style="background-color:#0066CC; color:#FFF; padding:5px; text-align:center; font-size:22px;">
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

	<div class="col-md-12">

		<div class="row" >

			<div class=" text-center">
				<h2 class="comp-txt">GENERATE QR CODES ZONE-WISE / झोननुसार QR कोड तयार करा.</h2>
				<!-- District: <strong> <?php //echo $distName; 
										?> Aurangabad </strong>  -->
			</div>

		</div>
		<br />

		<?php if ($_REQUEST['status'] == 1) {
			echo '<div class="alert alert-success success_msg" role="alert"><strong>Complaint Registered successfully with Reference no ' . $_REQUEST['ref_id'] . '<strong></div>';
		} ?>

<style>
.panel-body {
    padding: 35px;	
}
</style>
<div class="row">
    <div class="col-md-4 col-md-offset-4">

<div class="panel panel-info">
    <div class="panel-heading text-center">
        <strong>Complaint Resolution System / तक्रार निराकरण प्रणाली</strong>
    </div>

    <div class="panel-body">

        <form action="create_zone_wise_qr_code_for_complaint_forms.php" id="myForm" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

            <input type="hidden" name="ulbid" value="<?php echo $ulbid; ?>" id="ulbid">

            <!-- Zone -->
            <div class="form-group">
                <label>Zone Name / झोनचे नाव</label>
                <select name="ward_id" id="ward_id" class="form-control" onchange="get_streets(this.value)" required>
                    <option value="">-Select-</option>
                    <?php foreach ($ward_list as $ward_id => $ward_desc) { ?>
                        <option value="<?php echo $ward_id; ?>"><?php echo $ward_desc; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Ward -->
            <div class="form-group">
                <label>Location / स्थान <span class="merror">*</span></label>
                <select name="street_id" id="street_id" class="form-control" required>
                    <option value="">-Select-</option>
                </select>               
            </div>

            
            <!-- Dynamic Section -->
            <div class="form-group">
                <span id="cut_det"></span>
            </div>

            <!-- Buttons -->
            <div class="form-group text-center" style="margin-top:15px;">
                <button type="submit" class="btn btn-success" name="save" id="submitBtn">Get QR-Code</button>
				<button type="reset" class="btn btn-danger" style="margin-right:10px;">Clear</button>
            </div>

        </form>

    </div>
</div>

	</div>
	</div>
	
	
	
	
	</div>



	</div>
	<!--//captch code start here

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
-->
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
			$.post('ajax_getLocations.php', {
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

		$(document).on("change", "#f1", function() {
			if (this.files[0].size > 5000000) {
				toastr.error("Please upload file less than 5MB. Thanks!!");
				$(this).val('');
			}
		});
		$(document).on("keyup", "#validate_captcha", function() {

			var captcha = $(this).val();

			if(captcha.length == 6){

				$.ajax({
					url: "get_captcha_string.php",
					dataType: 'text',
					cache: false,
					success: function(data){

						if(captcha == data){
							$('#validate_captcha').attr('data-validate','true');
							$("#submitBtn").prop("disabled", false);
							$('#captcha_error_msg').html('');
						}else{
							$('#validate_captcha').attr('data-validate','false');
							$("#submitBtn").prop("disabled", true);
							$('#captcha_error_msg').html('Please Enter a Valid Captcha').css('color','red');
						}

					}
				});

			}else{
				$("#submitBtn").prop("disabled", true);
			}

		});

		$(document).on("change", "#sub_id", function() {
			let sub_id = $(this).val();
			(sub_id == 7) ? $('#property_tx_dept').css('display', 'block'): $('#property_tx_dept').css('display', 'none');

			if (sub_id == 18 || sub_id == 7) {
				$('.property_tx_uptin_no').css('display', 'block');
				$('#property_tx_uptin_no').prop('required', true);
			} else {
				$('.property_tx_uptin_no').css('display', 'none');
				$('#property_tx_uptin_no').prop('required', false);
				$('#property_tx_uptin_no').val('');
			}
		});

		window.onpopstate = () => setTimeout(alert.bind(window, "Pop"), 0);
	</script>
	<?php if (isset($_SESSION['f1'])) { ?>
		<script>
			$(document).on('ready', function() {
				toastr.error('<?= $_SESSION['f1']; ?>');
			});
		</script>
	<?php } ?>
	<br />
<script>
function updateSubCountdown() {
	  const maxLength = 80;
   const textarea = document.getElementById('comp_subject');
    const charCount = document.getElementById('charSubCount');
    let currentLength = textarea.value.length;

    // Limit text if it exceeds max length
    if (currentLength > maxLength) {
        textarea.value = textarea.value.substring(0, maxLength);
        currentLength = maxLength;
    }

    const remaining = maxLength - currentLength;
    charCount.textContent = `${remaining} characters remaining`;

    // Set color
    if (currentLength < maxLength) {
        charCount.style.color = "green";
    } else {
        charCount.style.color = "red";
    }
}

function updateCountdown() {
    const maxLength = 1500;
    const textarea = document.getElementById('comp_desc');
    const charCount = document.getElementById('charCount');
    let currentLength = textarea.value.length;

    // Limit text if it exceeds max length
    if (currentLength > maxLength) {
        textarea.value = textarea.value.substring(0, maxLength);
        currentLength = maxLength;
    }

    const remaining = maxLength - currentLength;
    charCount.textContent = `${remaining} characters remaining`;

    // Set color
    if (currentLength < maxLength) {
        charCount.style.color = "green";
    } else {
        charCount.style.color = "red";
    }
}
</script>
	<!--<div class="footer_div">Powered by - <a href="http://vmaxindia.com/" class="footerlinks" target="_blank" style="color:#00bff3; ">VMAX</a></div>-->


</body>

</html>