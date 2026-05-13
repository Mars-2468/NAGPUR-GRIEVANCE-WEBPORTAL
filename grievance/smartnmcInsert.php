<?php
require "config.php";
require_once('connection.php');

$conn = getconnection();

$sql_list = "SELECT *  FROM  sib_dept_mst ORDER BY name ASC";
$rs_list= mysqli_query($conn,$sql_list);

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .error{
        color:red !important;
    }
    table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;
    }
    td,
    th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
    }
    tr:nth-child(even) {
		background-color: #dddddd;
    }
	
	.g220-img12 {
		width: 100px;
		/* height: 82px; */
		position: absolute;
		right: 178px;
		top: 20px;
		background: white;
		border-radius: 8px;
		padding: 5px;
	}
    .dataTables_wrapper .dataTables_paginate .paginate_button {
		padding: 0px !important;
    }
    .table {
		font-size: 14px !important;
    }
    .dataTables_filter label {
		display: flex !important;
		margin-bottom: 15px !important;
    }
    .allert-style1 {
		margin: 0px 121px 0px 117px;
	}



button.btn:disabled,
.btn:disabled {
    cursor: not-allowed !important;  /* force the cursor */
    opacity: 0.6 !important;         /* optional, greyed out */
    pointer-events: all !important;  /* allow the cursor to show */
}

	
	/* Smartphones (portrait and landscape) */
@media (min-width: 200px) and (max-width: 576px) {
  /* Styles for small mobile devices */
  	.ng75ylogo{ 
		position: absolute;    
		width: 62px;
		height: 62px !important; 
		right: 12%;
		top: -10%;
		background: white;
		border-radius: 8px;
		padding: 5px;
	}
}

/* Tablets (portrait) */
@media (min-width: 577px) and (max-width: 668px) {
  /* Styles for portrait tablets */
  	.ng75ylogo{ 
		position: absolute;    
		width: 62px;
		height: 62px !important; 
		right: 12%;
		top: -10%;
		background: white;
		border-radius: 8px;
		padding: 5px;
	}
}
/* Tablets (portrait) */
@media (min-width: 677px) and (max-width: 768px) {
  /* Styles for portrait tablets */
  	.ng75ylogo{ 
		position: absolute;    
		width: 60px;
		height: 60px !important; 
		right: 12%;
		top: -8%;
		background: white;
		border-radius: 8px;
		padding: 5px;
	}
}

/* Tablets (landscape) and small notebooks */
@media (min-width: 769px) and (max-width: 1020px) {
  /* Styles for landscape tablets or small laptops */
  	.ng75ylogo{ 
		position: absolute;    
		width: 60px;
		height: 60px !important; 
		right: 12%;
		top: 0.5%;
		background: white;
		border-radius: 8px;
		padding: 5px;
	}
}

/* Laptops / Notebooks (medium screens) */
@media (min-width: 1021px) and (max-width: 1100px) {
  /* Styles for laptops */
  	.ng75ylogo{ 
		position: absolute;    
		width: 62px;
		height: 62px !important; 
		right: 12%;
		top: 1.6%;
		background: white;
		border-radius: 8px;
		padding: 5px;
	}
}

/* Desktops and large screens */
@media (min-width: 1101px) and (max-width: 1160px) {
  /* Styles for large desktop monitors */
  	.ng75ylogo{ 
		position: absolute;    
		width: 66px;
		height: 66px !important; 
		right: 12%;
		top: 1%;
		background: white;
		border-radius: 8px;
		padding: 5px;
	}
}


/* Desktops and large screens */
@media (min-width: 1201px) and (max-width: 1280px) {
  /* Styles for large desktop monitors */
  	.ng75ylogo{ 
		position: absolute;    
		width: 66px;
		height: 66px !important; 
		right: 12%;
		top: 3%;
		background: white;
		border-radius: 8px;
		padding: 5px;
	}
}


/* Desktops and large screens */
@media (min-width: 1281px) {
  /* Styles for large desktop monitors */
  	.ng75ylogo{ 
		position: absolute;    
		width: 66px;
		height: 66px !important; 
		right: 12%;
		top: 5%;
		background: white;
		border-radius: 8px;
		padding: 5px;
	}
}
</style>
<style>
	.capththa {
		border: 1px solid #ccc;
		position: relative;
		left: 244px;
		top: -9px;
		background-image: url('/images/download.jpg');
		border-radius: 4px;
		width: 127px;
		text-align: center;
		color:
			red;
		font-weight: bold;
		letter-spacing: 10px;
		font-size: 16px;
	}

	@media (max-width: 767px) {
		#ref {
			display: block;
			margin-left: auto;
			margin-right: auto;
			text-align: center;
		}

		.col-md-4 {
			width: 100%;
			margin-top: 10px;
			text-align: center;
		}

		.control-label {
			margin: 0 auto;
		}

		.captcha-container {
			margin-top: 10px;
		}

		.capththa {
			left: 80px;
			top: 0px;
		}
	}
</style>
<title>::NMC Smart Box </title>
  <!-- Bootstrap 5.3.8 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!--<link 
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
  rel="stylesheet" 
  integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
  crossorigin="anonymous">

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
  crossorigin="anonymous"></script>
  
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
-->

</head>
<body>
  <div class="g220">
    <a href="https://www.g20.org/en"><img src="images/ng75yearslogo.png" class="img-fluid ng75ylogo"></a>
       <img src="images/header-nmc.jpg" class="img-fluid" style="width:100%">
  </div>
  <center>
    <div class="bg-success p-2 text-white mb-3">
      <h4>Smart Box Form</h4>
    </div>
  </center>
 <div class="container p-3">


  <?php 
  
  $code = generateCaptchaCode();

	$_SESSION['code'] = $code;
  
  if (isset($_SESSION['success_message'])) : ?>
    <div class="alert alert-success allert-style">
      <strong>Success!</strong> <?php echo $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); // Clear the session message ?>
  <?php endif; ?>
  
  <?php if (isset($_SESSION['error_message'])) : ?>
    <div class="alert alert-danger allert-style">
      <strong>Error!</strong> <?php echo $_SESSION['error_message']; ?>
    </div>
    <?php unset($_SESSION['error_message']); // Clear the session message ?>
  <?php endif; ?>
  
 
    <form action="smartnmcInsertAction.php" id='myForm' method="post" enctype="multipart/form-data">
      <div class="row align-items-end">
        <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="" name="name"  data-type="text" onkeyup="funInputFielTypes(this)" required >
			<div style="font-size:10px;color:red;" id="nameX"></div>
		  </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="text" class="form-control" id="mobile" minlength="10" maxlength="10" placeholder="" name="mobile" data-type="mobile" onkeyup="funInputFielTypes(this)" required>
          <div style="font-size:10px;color:red;" id="mobileX"></div>
		  </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="" name="email" data-type="email" onkeyup="funInputFielTypes(this)" required>
          <div style="font-size:10px;color:red;" id="emailX"></div>
		  </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="address" class="form-label">Address</label>
            <input type="address" class="form-control" id="address" placeholder="" name="address" data-type="address" onkeyup="funInputFielTypes(this)" required>
          <div style="font-size:10px;color:red;" id="addressX"></div>
		  </div>
        </div>
       
        <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="department" class="form-label">Select Department</label>
            <select class="form-select" id="department" name="department" required>
              <option value="">-select-</option>
              <?php $i=1; while($row = mysqli_fetch_assoc($rs_list)) { ?>
              <option value="<?php echo $row['id'];?>"><?php echo ucfirst($row['name'])?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-12">
          <div class="mb-3 mt-3">
           <label class="d-flex align-items-center gap-2">
				<span>Description</span>
				<button type="button"
						class="btn btn-danger text-white d-flex align-items-center"
						id="micBtn">
					<i class="fa fa-microphone"></i>
				</button>
			</label>

            <!-- <input type="text" class="form-control" id="description" placeholder="" name="description" value=""> -->
            <textarea class="form-control" id="description" placeholder="" name="description" data-type="sptext" onkeyup="funInputFielTypes(this)" oninput="updateCharCount()" required></textarea>
         
			<div style="font-size:10px;color:red;" id="descriptionX"></div>
			<div id="charCount" style="margin-top: 5px;">2000 characters remaining</div>		 
		 </div>
        </div>
				
		<div class="form-group" id="ref">
			<label class="control-label col-md-4">
				<!--<div style="border:1px solid #ccc;position: relative;left: 116px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;font-weight: bold;letter-spacing: 10px;font-size: 16px;" >-->
				<div class="capththa">
					<p id="captImg" style="margin-top: 10px;"><?php echo $code; ?></p>
				</div>
			</label>
			<div class="col-md-4">
				<!-- <input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" autocomplete="off" required="required" style="width: 385px;border-radius: 3px;" onpaste="return false;"> -->
				<input type="text" class="form-control" minlength="6" maxlength="6" name="captcha" id="captcha" placeholder="Enter Captcha" autocomplete="off" required="required" style="border-radius: 3px;" onpaste="return false;" data-type="captcha" onkeyup="funInputFielTypes(this)" >
				<input type="hidden" name="code" value="<?php echo $code; ?>">
				 <div style="font-size:10px;color:red;" id="captchaX"></div>
			</div>
		</div>
		
		
		<div class="col-md-6 col-md-offset-4">
			<p>Can't read the image? click <a id="buss" class="refreshCaptcha" style="cursor:pointer;">here</a> to refresh.</p>
		</div>

      </div>
  <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Submit</button>
  <div id="cooldownInfo" class="mt-2 text-danger"></div>
</form>

<div id="responseMsg" class="mt-3"></div>
	  
	  
	  
  
  </div>
  
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
  $('#myForm2').on('submit', function(e) {
    e.preventDefault(); // prevent form default submit

    var form = this;
    var formData = new FormData(form);

    $('#submitBtn').prop('disabled', true).text('Submitting...');

    $.ajax({
      url: $(form).attr('action'),
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
       
        startCooldown();  // Start the 20-sec cooldown after success
        form.reset();     // Optional: reset form after success
      },
      error: function() {
        $('#responseMsg').html('<div class="text-danger">Error submitting form.</div>');
        $('#submitBtn').prop('disabled', false).text('Submit');
      }
    });
  });

  function startCooldown() {
    var cooldownSeconds = 5;
    var $submitBtn = $('#submitBtn');
    var $cooldownInfo = $('#cooldownInfo');

    $submitBtn.prop('disabled', true);
    //$submitBtn.text('Please wait...');
    $submitBtn.text('Submit');
    $cooldownInfo.text('You can submit again in ' + cooldownSeconds + ' seconds.');

    var interval = setInterval(function() {
      cooldownSeconds--;
      $cooldownInfo.text('You can submit again in ' + cooldownSeconds + ' seconds.');

      if (cooldownSeconds <= 0) {
        clearInterval(interval);
        $submitBtn.prop('disabled', false).text('Submit');
        $cooldownInfo.text('');
      }
    }, 1000);
  }
});
</script>




<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('http://localhost:8080/grievance/smartnmcInsert.php #ref', function() {
				/// can add another function here
			});
		});
	}); //// End of Wait till page is loaded
</script>



<script>
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
		message='First letter should not be empty!';
  }else{

//alert(type);

  // Validate based on input type
  switch (type) {
    case 'text':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-\.() ]+$/.test(value);
	  if (!isValid) 
	  message='Invalid characters! Use letters, numbers, -, _, . () or space.';
      break;
	
	case 'sptext':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,&()]+$/.test(value);
      if (!isValid) message = 'Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;	
	  
	case 'dnumber':
      isValid = /^[0-9]+$/.test(value);
      if (!isValid) message = 'Invalid number! Use digits only';
      break;
	  
	case 'fnumber':
      isValid = /^-?\d+(\.\d+)?$/.test(value);
      if (!isValid) message = 'Invalid number! Use digits, ., only';
      break;
	  	
	case 'dcaptcha':
      isValid = /^[0-9]{4}$/.test(value);
	  if (!isValid) message = 'Invalid Captcha! Use digits only and max length is 4 digits.';
	  break;
	  
    case 'address':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,&()\/]+$/.test(value);
      if (!isValid) message = 'Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;
	  
    case 'address2':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,()]+$/.test(value);
      if (!isValid) message = 'Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;


    case 'email':
      isValid = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|io)$/.test(value);
      if (!isValid) message = 'Enter a valid email like user@example.com';
      break;

    case 'mobile':
		
		isValid =  /^[6-9][0-9]{0,9}$/.test(value);
	  	  
		if (value.length < 10) {
			message = "Mobile number should be exactly 10 digits.";
			
		} else if (!isValid) {
			message = "Mobile number should start with 6, 7, 8, or 9.";
			
		} else {
			message = "";
			
		}
	  
      //if (!isValid) message = '? Enter a valid 10-digit mobile number starting with 6-9.';
      break;
	  
    case 'landline':
		
		isValid =  /^0\d{2,4}-?\d{6,8}$/.test(value);
	  	  
		if (value.length < 12) {
			message = "Landline number should be exactly 12 digits.";
			
		} else if (!isValid) {
			message = "Landline number should start with 0 to 4,only.";
			
		} else {
			message = "";
			
		}
	  
    
      break;	
	  
    case 'fax':
		
		isValid =  /^(\+?\d{1,3}[- ]?)?0\d{2,4}[- ]?\d{6,8}$/.test(value);
	  	  
		if (value.length < 12) {
			message = "Fax number should be exactly 12 digits.";
			
		} else if (!isValid) {
			message = "Fax number should start with 0 to 4,only.";
			
		} else {
			message = "";			
		}
	      
      break;

    case 'lat':
      const lat = parseFloat(value);
      isValid = !isNaN(lat) && lat >= -90 && lat <= 90;
      if (!isValid) message = 'Latitude must be between -90 and 90.';
      break;

    case 'lng':
      const lng = parseFloat(value);
      isValid = !isNaN(lng) && lng >= -180 && lng <= 180;
      if (!isValid) message = 'Longitude must be between -180 and 180.';
      break;
	  
	case 'url':
	   const pattern = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;
      isValid = pattern.test(value);
	
      if (!isValid) {
        message = 'Unsafe URL! Only allowed protocols are http,https, and mailto.';
      }
      break;
	  
    case 'date':
      isValid = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/.test(value);
      if (!isValid) message = 'Date must be in YYYY-MM-DD format.';
      break;

    case 'old_password':
      isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/.test(value);
      if (!isValid) {
        message = 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
      }
      break;
    case 'password':
      isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/.test(value);
      if (!isValid) {
        message = 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
      }
      break;

    case 'confirm-password':
	
      const originalPassword = document.getElementById('password').value.trim();
      isValid = value === originalPassword;
      if (!isValid) {
        message = 'Passwords do not match.';
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
        message = 'Passwords do not match.';
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
        message = 'Captcha should only contain alphanumerics.';
      }
      break;
	  
    case 'alphanumerics':
      isValid = /^[a-zA-Z0-9]*$/.test(value);
      if (!isValid) {
        message = 'Invalid characters, allows alphanumerics only.';
      }
      break;	
	  
    case 'alphanumerics_slash':
      isValid = /^[a-zA-Z0-9\/]*$/.test(value);
      if (!isValid) {
        message = 'Invalid characters, allows alphanumerics,and / only.';
      }
      break;
	  
	case 'multiplefiles':
      const files = ele.files;
      const maxFiles = 5; // you can customize max allowed files
      const maxSize = 2 * 1024 * 1024; // 2 MB per file

      const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

      if (files.length === 0) {
        isValid = false;
        message = '? Please select at least one file.';
      } else if (files.length > maxFiles) {
        isValid = false;
        message = `Maximum ${maxFiles} files allowed.`;
      } else {
        isValid = true;
        for (let i = 0; i < files.length; i++) {
          const ext = files[i].name.split('.').pop().toLowerCase();
          if (!allowedExtensions.includes(ext)) {
            isValid = false;
            message = `Invalid file type "${ext}". Allowed: ${allowedExtensions.join(', ').toUpperCase()}`;
            break;
          }
          if (files[i].size > maxSize) {
            isValid = false;
            message = `File "${files[i].name}" exceeds 2MB size limit.`;
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
          message = `Only ${allowed[type].join(', ').toUpperCase()} files allowed.`;
        }
      } else {
        isValid = false;
        message = `Please select a valid ${type} file.`;
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

<script>
function updateCharCount() {
    const max = 2000;
    const textarea = document.getElementById('description');
    const counter = document.getElementById('charCount');

    let length = textarea.value.length;
    if (length > max) {
        textarea.value = textarea.value.substring(0, max); // Trim extra chars
        length = max;
    }

    const remaining = max - length;
    counter.textContent = `${remaining} characters remaining`;

    if (remaining < 500) {
        counter.style.color = 'red';
    } else if (remaining < 1500) {
        counter.style.color = 'green';
    } else {
        counter.style.color = 'black';
    }
}

</script>



<script>
const micBtn = document.getElementById('micBtn');
const searchInput = document.getElementById('description');

let recognition;
let listening = false;

if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    recognition = new SpeechRecognition();

    recognition.lang = 'en-IN';      // English (India)
    recognition.continuous = false;
    recognition.interimResults = false;

    recognition.onstart = () => {
        listening = true;
        micBtn.innerHTML = '🎙️';
        micBtn.classList.add('btn-danger');
    };

    recognition.onend = () => {
        listening = false;
        micBtn.innerHTML = '🎤';
        micBtn.classList.remove('btn-danger');
    };

    recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript;
        searchInput.value = transcript;
        searchInput.focus();

        // Optional: auto-submit or trigger search
        // document.getElementById('searchForm').submit();
    };

    micBtn.onclick = () => {
        if (!listening) recognition.start();
        else recognition.stop();
    };

} else {
    micBtn.disabled = true;
    micBtn.title = "Speech recognition not supported";
}
</script>


</body>
</html>