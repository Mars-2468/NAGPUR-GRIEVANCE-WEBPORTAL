<!-- input fields -->
<input type="hidden" id="hight_language" value="<?php echo $this->session->userdata('highliteclass'); ?>">
<!--- close --->

    </div><!-- sh-mainpanel -->
    
<script 
  src="<?php echo base_url(); ?>assets/js/bootstrap-fte.bundle.min.js"></script>
  
  
   
    <script src="<?php echo base_url(); ?>assets/lib/jquery-ui/jquery-ui.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    
 
    
    <script src="<?php echo base_url(); ?>assets/js/custome/costome.js"></script>
    
    
   

   <script src="<?php echo base_url(); ?>assets/js/shamcey.js"></script>
   
    
   
   <script>
       function changeLanguage(langId)
       {
          
           $.get('<?php echo base_url(); ?>/AddMenuController/changeLanguage',{langId:langId},function(data)
           {
             
               $("#lang").text(data);
              
              
              
               location.reload();
           });
       }
       
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
		message='❌ First letter should not be empty!';
  }else{

  // Validate based on input type
  switch (type) {
    case 'text':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-\.() ]+$/.test(value);
	
      if (!isValid) 
		  message='❌ Invalid text! Use letters, numbers, -, _, . () or space.';
      break;

    case 'spnamesnrols':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,&'()]+$/.test(value);
      if (!isValid) message = '❌ Invalid address! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;
	  
    case 'sptext':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,&()]+$/.test(value);
      if (!isValid) message = '❌ Invalid address! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;
	  
    case 'address':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,()]+$/.test(value);
      if (!isValid) message = '❌ Invalid address! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;

    case 'email':
      isValid = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|io)$/.test(value);
      if (!isValid) message = '❌ Enter a valid email like user@example.com';
      break;

    case 'mobile':
     /*  isValid = /^[6-9]\d{9}$/.test(value);
      if (!isValid) message = '❌ Enter a valid 10-digit mobile number starting with 6-9.';
	   */
	  isValid =  /^[6-9][0-9]{0,9}$/.test(value);
	  	  
		if (value.length < 10) {
			message = "❌ Mobile number should be exactly 10 digits.";
			
		} else if (!isValid) {
			message = "❌ Mobile number should start with 6, 7, 8, or 9.";
			
		} else {
			message = "";
			
		}
	  
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
	  	  
		if (value.length < 11) {
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

    case 'date':
      isValid = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/.test(value);
      if (!isValid) message = '❌ Date must be in MM/DD/YYYY or YYYY-MM-DD format.';
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
		var encpwd=CryptoJS.MD5(pwd);
		$("#password").val(encpwd);
		$("#confirm_password").val(encpwd);				
	  }
	  
      break;
	  
	case 'confirmpassword':
	
      const oPassword = $("#old_password").val();
      isValid = value === oPassword;
	  alert(isValid);
      if (!isValid) {
        message = '❌ Passwords do not match.';
      }
	  
	  if((value.length>=8) && (oPassword.length>=8) && isValid){	  
		var oldpwd=$("#old_password").val();
		var opwd=$("#password").val();
		var uencpwd=encryptBeforeSubmit(opwd,'password');
		var uencpwd2=encryptBeforeSubmit(opwd,'confirm_password');
		
		//$("#password").val(uencpwd);
		//$("#confirm_password").val(uencpwd);	
		
		if(oldpwd.length>=8){
		var oldencpwd=encryptBeforeSubmit(oldpwd,'old_password');
		//$("#old_password").val(oldencpwd);	
		}
		
		
	  }
	
    break; 

    case 'captcha':
      isValid = /^[a-zA-Z0-9-_]+$/.test(value);
      if (!isValid) {
        message = '❌ Captcha should only contain alphanumerics, hyphens (-), or underscores (_).';
      }
      break;
	  
    case 'url':
      isValid = sanitizeURL(ele.value);
      if (!isValid) {
        message = '❌ Unsafe URL! Only allowed protocols are http,https, and mailto.';
      }
      break;
	  
    case 'localurl':
      isValid = /^[a-zA-Z0-9-_/]+$/.test(value);
      if (!isValid) {
        message = '❌ Unsafe URL! should only contain alphanumerics, hyphens (-), underscores (_), and forward slash(/).';
      }
      break;

    case 'imfile':
    case 'image':
    case 'audio':
    case 'video':
      const file = ele.files[0];
	 // alert(type);
      if (file) {
        const ext = file.name.split('.').pop().toLowerCase();
        const allowed = {
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

/* function encryptBeforeSubmit(inputData) {
    const key = CryptoJS.enc.Utf8.parse("MySecretKey12345");    // Custom 16-byte key
    const iv  = CryptoJS.enc.Utf8.parse("MyCustomIV654321");    // Custom 16-byte IV

    const plainText = inputData;

    const encrypted = CryptoJS.AES.encrypt(plainText, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7
    });

   // document.getElementById(tagid).value = encrypted.toString();
    //document.getElementById("plainText").value = "";

    //return encrypted.toString();
	return encrypted.ciphertext.toString();
} */


function encryptBeforeSubmit(inputData, tagid) {
    const key = CryptoJS.enc.Utf8.parse("MySecretKey12345");    // Custom 16-byte key
    const iv  = CryptoJS.enc.Utf8.parse("MyCustomIV654321");    // Custom 16-byte IV

    const plainText = inputData;

    const encrypted = CryptoJS.AES.encrypt(plainText, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7
    });

    document.getElementById(tagid).value = encrypted.toString();
    //document.getElementById("plainText").value = "";

    return encrypted.toString();
}


function sanitizeURL(url) {
	
  try {
    const parsed = new URL(url, window.location.origin); // handles relative URLs too
    const allowedProtocols = ['http:', 'https:', 'mailto:','#'];
//alert(allowedProtocols.includes(parsed.protocol));
    if (allowedProtocols.includes(parsed.protocol)) {
		return true; // Unsafe scheme
    }else{
		return false;
	}
  } catch (e) {
    return ''; // Invalid URL format
  }
}

		</script> 

    
   
  </body>


</html>
