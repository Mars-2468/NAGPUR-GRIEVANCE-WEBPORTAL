
</div>
</div>
</section>
  {literal}
<script>
window.addEventListener('load', function() {
    let loadTime = (performance.now() / 1000).toFixed(2);
    // Show on page
    const info = document.createElement('div');
    info.textContent = "Full page loaded in " + loadTime + " seconds.";
    info.style.position = "fixed";
    info.style.bottom = "10px";
    info.style.right = "10px";
    info.style.background = "#222";
    info.style.color = "#fff";
    info.style.padding = "6px 10px";
    info.style.borderRadius = "5px";
    info.style.fontSize = "13px";
    info.style.zIndex = 9999;
    document.body.appendChild(info);
});
</script>
{/literal}
    {literal}
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui-1.10.3.js" type="text/javascript"></script>
	
	<script src="js/bootstrap-hover-dropdown.min.js"></script>
	<script src="js/jquery.slimscroll.js"></script>
	<script src="js/jquery.totop.js"></script>
	<script src="js/main.js"></script>
    <script>
        $('.nav-item').on('click', function(){
            $('.nav-item').each(function(){
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            
        })
    </script>
	
	<script>
$(document).ready(function() {
  $('#myForm').on('submit', function(e) {
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
    var cooldownSeconds = 20;
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

  if (ele.value.charAt(0) === '') {
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
	  
	case 'spcontent':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,:;&()"'\u2013\u2019\s]+$/.test(value);
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
			message = "❌ Mobile number should be exactly 10 digits.";
			
		} else if (!isValid) {
			message = "❌ Mobile number should start with 6, 7, 8, or 9.";
			
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
      isValid = /^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/.test(value);
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

	case 'confirm_password':
		
		const originalPassword = document.getElementById('password').value.trim();
		const val = value.trim();

		// Validate confirm password against policy
		isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/.test(value);

		if(!isValid){
			message = '❌ Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
			break;
		}

		// Compare actual values, not length
		if(originalPassword === val){
			
			message = '';
			break;
		}
		
		if(originalPassword !== val){
			message = '❌ Passwords do not match.';
			break;
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
    case 'images':
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
          images: ['jpg', 'jpeg', 'png','gif'],
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


function encryptDataBeforeSubmit(inputData) {

    const key = CryptoJS.enc.Utf8.parse("MySecretKey12345");    // Custom 16-byte key
    const iv  = CryptoJS.enc.Utf8.parse("MyCustomIV654321");    // Custom 16-byte IV
   
   const encrypted = CryptoJS.AES.encrypt(inputData, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7
    });
 
    return encrypted.toString();
	
}

</script>


    <!-- Bootstrap JS 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

<script>
 $('#f_date, #t_date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    changeMonth: true,
    changeYear: true,
    changeDate: true
}); 
</script>

<script>
    $(function() {
        $(".datepicker").datepicker({
			 format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    changeMonth: true,
    changeYear: true,
    changeDate: true
        });
    });
</script>	

{/literal}
 </body>
</html>



                            