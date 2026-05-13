<?php
require "config.php";
error_reporting(0);

require_once('citizen_comp_connection.php');

$conn = getconnection();
$ulbid = 250;
mysqli_query($conn, 'SET character_set_results=utf8');
mysqli_query($conn, 'SET names=utf8');
mysqli_query($conn, 'SET character_set_client=utf8');
mysqli_query($conn, 'SET character_set_connection=utf8');
mysqli_query($conn, 'SET character_set_results=utf8');
mysqli_query($conn, 'SET collation_connection=utf8_general_ci');


//$zone_id=$_REQUEST['zone_id'];
$loc_of_gvp_id=$_REQUEST['loc_of_gvp_id']??'';

if($loc_of_gvp_id!=''){
	$loc_of_gvp_id=decryptData($loc_of_gvp_id);
}

//$dept_id=$_REQUEST['dept_id'];
//$sub_dept_id=$_REQUEST['sub_dept_id'];

$stmt = $conn->prepare("SELECT * FROM zone_ward_loc_mst WHERE id = ?");
$stmt->bind_param("i", $loc_of_gvp_id);
$stmt->execute();
$result = $stmt->get_result();
$crow = $result->fetch_assoc();

//echo "<pre>";print_r($row);echo "</pre>";die();

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

//41,42,43,49

	$sql ="select c.cs_id,c.cs_desc as comp_desc,c.telugu_description from  cs_mst c,complaint_ulbmap cu where c.cs_id=cu.cs_id and cu.ulbid='".$ulbid."' and c.cs_id in(41,42,43,49) and cu.flag='1'";
	
	$complaint_types[]=array(''=>0,'cs_desc'=>'Select Complaint');
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
		{
			$complaint_types[]=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['comp_desc']."/".$row['telugu_description']);
		}
	}
	else
		$complaint_types[0] = array('cs_id'=>'0','cs_desc'=>'No Complaints Available');
		
	//echo "<pre>";print_r($complaint_types);echo "</pre>";die();


$flag = 1;
$sql = $conn->prepare("select cat.cat_id,description,cat.telugu_description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag=? and cu.ulbid=? order by description ASC");
$sql->bind_param("is", $flag, $ulbid);

$sql->execute();
$rs = $sql->get_result();
if ($rs) {
	while ($row = $rs->fetch_assoc()) {
		
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
		/* 	if ($('#validate_captcha').attr('data-validate') == 'false') {
				errors++;
				$('#validate_captcha').css({
					"background-color": "pink"
				});
			} else {
				$('#validate_captcha').css({
					"background-color": "white"
				});
			} */


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

		<div class="row" style="clear:both; min-height:45px; align-items: center;">

			<div class="col-md-6 text-left">
				<h2 class="comp-txt">COMPLAINT REGISTRATION / तक्रार नोंदणी</h2>				
			</div>


		</div>
		<br />

		<?php if ($_REQUEST['status'] == 1) {
			echo '<div class="alert alert-success success_msg" role="alert"><strong>Complaint Registered successfully with Reference no ' . $_REQUEST['ref_id'] . '<strong></div>';
		} ?>

<style>
.badge-primary-custom {
    display: flex;
	justify-content:center;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    background-color: #007bff;
    border-radius: 0px;
    text-align: center;
    white-space: nowrap;
}
</style>
	<div class="panel panel-info">
		<div class="panel-heading" style="text-align:center;"><strong>Complaint Resolution System / तक्रार निराकरण प्रणाली</strong></div>
		      <!-- <div class="badge-primary-custom"><?php// echo $crow['loc_of_gvp']; ?></div> -->
     
		<div class="panel-body">

			<form action="save_public_comp.php" id="myForm" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
					
					<input type="hidden" name="ulbid" value="<?php echo $ulbid; ?>" id="ulbid">
					
					<input type="hidden" name="loc_of_gvp_id" value="<?php echo $crow['id']; ?>" id="loc_of_gvp_id">

					<div id="form">


						<div class="row">

							<div class="col-md-4">
								<div class="form-group col-md-12">
									<label>Person Name / नाव <span class="merror">*</span> </label>
								<input 
									type="text" 
									name="person_name" 
									id="person_name" 
									placeholder="Name of Person" 
									value="<?php echo $row['user_name']; ?>" 
									class="form-control mytext" 
									oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '')" 
									required>
								<input type="hidden" name="app_type_id" value="1">
									<p class="text-danger"><?php echo @$_SESSION['name']; ?></p>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group col-md-12">
									<label>Mobile No. / मोबाईल क्र. <span class="merror">*</span> </label>
								<input 
								type="text" 
								name="mobile" 
								id="mobile" 
								placeholder="Mobile No" 
								value="<?php echo (isset($_SESSION['com_reg_mobile'])) ? $_SESSION['com_reg_mobile'] : '' ?>" 
								class="form-control num mytext" 
								minlength="10" 
								maxlength="10"
								pattern="[6-9]{1}[0-9]{9}"
								oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)" 
								required>
								<p class="text-danger"><?php echo @$_SESSION['mobile']; ?></p>

								</div>
							</div>						
						</div>
			
						<div class="row">
							<input type="hidden" id="latitude" name="latitude" readonly>
							<input type="hidden" id="longitude" name="longitude" readonly>	
							<input type="hidden" name="address" id="address" placeholder="Address " class="form-control mytext" value="" readonly >
													
							<input type="hidden" id="latitude2" name="latitude2" value="<?php echo $crow['latitude'];?>" readonly>
							<input type="hidden" id="longitude2" name="longitude2" value="<?php echo $crow['longitude'];?>" readonly>
							
							<input type="hidden" name="zone_id" id="zone_id" placeholder="Zone Name" class="form-control mytext" value="<?php echo $crow['zone_id']; ?>" readonly required>
							<input type="hidden" name="ward_id" id="ward_id" placeholder="Ward Name" class="form-control mytext" value="<?php echo $crow['ward_id']; ?>" readonly required>
													
							<div class="col-md-4">
								<div class="form-group col-md-12">
									<label>Select Complaint Type / तक्रार प्रकार निवडा <span class="merror">*</span> </label>
									<select name="cs_id" id="cs_id" class="form-control dropdown" required>
									<?php
										foreach ($complaint_types as $key => $value) {
										?>
											<option value="<?php echo $value['cs_id']; ?>"><?php echo $value['cs_desc']; ?></option>
										<?php
										}
										?>

									</select>

								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group col-md-12">
									<label>Location / स्थान <span class="merror">*</span> </label>
									<input type="text" name="auto_location" id="auto_location" placeholder="Location / Regarding" value="<?php echo $crow['loc_of_gvp']; ?>" class="form-control mytext" maxlength="80" readonly>
								</div>
							</div>
							
							<div class="col-md-4" hidden>
								<div class="form-group col-md-12">
									<label>Subject / विषय <span class="merror">*</span> </label>
									<input type="text" name="comp_subject" id="comp_subject" placeholder="Subject / Regarding" class="form-control mytext" maxlength="80">
									<div id="charSubCount">80 characters remaining</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group col-md-12">
									<label>Photo / अटॅच फाईल <span class="merror"></span></label>
									<input type="file" name="f1" id="f1" class="form-control">
									<small style="margin-top: 6px; display: block; color: #999898;"><?php echo !empty($_SESSION['f1'])? "<p style='color: red;'>{$_SESSION['f1']}</p>": "( Max upto 2MB )"; $_SESSION['f1']=''; ?></small>
								</div>
							</div>

						</div>

						<div class="row">

							<div class="col-md-3" style="display:none;" id="tanker_dropdown">

								<div class="form-group">
									<label>Tanker</label>
									<select name="tanker_id" id="tanker_id" class="form-control">

										<option value="">-Select-</option>
										<?php
										foreach ($tanker_list as $tanker_id => $tanker_desc) {
										?>
											<option value="<?php echo $tanker_id; ?>"><?php echo $tanker_desc; ?></option>
										<?php
										}
										?>
									</select>
								</div>

							</div>

						</div>

						<div class="row">
							<!-- begin col-4 -->
							<div class="col-md-12">
								<div class="form-group col-md-12">
									<label>Complaint Description / तक्रारीचे संक्षिप्त <span class="merror">*</span> वर्णन <span class="merror">*</span> </label>
									<textarea 
										name="comp_desc" 
										id="comp_desc" 
										placeholder="Description" 
										class="form-control mytext" 
										rows="5" 
										maxlength="1500"
										oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); updateCountdown();" 
										required>
									</textarea>
								<div id="charCount">1500 characters remaining</div>
								</div>
							</div>
							<!-- end col-4 -->
						</div>

						<div class="d-flex" hidden>
							<!-- begin col-4 -->
							<div class="col-md-4">
								<div class="form-group col-md-12">
									<p class="text-danger"><?php echo @$_SESSION['captcha']; ?></p>
									<div class="row form-group">
										<div class="col-md-12">
											<label><strong>Enter Captcha / कॅप्चा प्रविष्ट करा:</strong></label><br />
											<input class="form-control" type="text" id="validate_captcha222" data-validate="false" name="captcha2222" minlength="6" maxlength="6"  pattern="[A-Za-z0-9]+" title="Only alphanumeric characters allowed" required1 autocomplete="off" />
											<span id="captcha_error_msg"></span>
										</div>
									</div>

									<p><br />
										<img src="get_captcha.php?rand=<?= (rand(10, 100)) ?>" id='regenerate_captcha' style="border: 1px dashed gainsboro;filter: contrast(0.5);">

										<!--<img src="captcha.php?rand=<?php echo rand(); ?>" id='captcha_image'>-->
									</p>
									<p>Can't read the image?
										<a href='javascript: refreshCaptcha();'>click here</a>
										to refresh / प्रतिमा वाचू शकत नाही? रिफ्रेश करण्यासाठी येथे <a href='javascript: refreshCaptcha();'> क्लिक करा</a>
									</p>
								</div>
							</div>
							<!-- end col-4 -->
						</div>

						<div class="row">
							<span id="cut_det"></span>
						</div>
						<!-- begin col-4 -->
						<div class="col-md-12" style="padding-bottom:12px">
							<div class="form-actions fluid">
								<div class="col-md-offset-5 col-md-3 text-center">
									<button type="submit" class="btn btn-success" name="save" id="submitBtn" value="Save" style="padding:8px 20px">Submit</button>
									<button type="reset" class="btn btn-danger" style="margin-right:12px; padding:8px 20px">Clear</button>
								</div>
							</div>
						</div>
						<!-- end col-4 -->
					</div>

			</form>
		</div>
	</div>


	<script>
		function refreshCaptcha() {
			var img = document.images['regenerate_captcha'];
			img.src = "get_captcha.php" + "?rand=" + Math.floor(Math.random() * 1000);;
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (pos) {

            let lat = pos.coords.latitude;
            let lng = pos.coords.longitude;

            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;

            // Reverse Geocoding (OpenStreetMap - FREE)
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("address").value = data.display_name;
                })
                .catch(() => {
                    document.getElementById("address").value = "Unable to fetch address";
                });

        });
    }
});
</script>

</body>

</html>