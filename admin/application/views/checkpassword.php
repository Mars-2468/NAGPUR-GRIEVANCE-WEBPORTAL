<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--
 <script src="<?php //echo base_url(); ?>/assets/js/custome/cryptojs/rollups/md5.js"></script>
    <script src="<?php //echo base_url(); ?>/assets/js/custome/cryptojs/components/md5.js"></script>
-->

<div class="sh-pagebody">
    <?php if($this->session->flashdata('message')){?>
    <div class="text-center"> <strong> <?php echo $this->session->flashdata('message');?> </strong></div>
    <?php }?>

    <?php echo form_open_multipart('CheckPasswordController/updatePassword');?>
	
	<!-- custom one-time nonce -->
	<input type="hidden" name="form_nonce" value="<?= $form_nonce; ?>">

    <div class="row">
	


       <div class="form-group col-md-3">
            <label class=" control-label" for="textinput">Old Password <span class="tx-danger">*</span></label>  
            <div class="">
                <input id="old_password" name="old_password" placeholder="Enter Password" class="form-control input-md password" type="password" onpaste="return false;" onCopy="return false" onCut="return false" tabindex="6" autocomplete="off" data-type="old_password" onkeyup="funInputFielTypes(this)" required="required">
                <input type="hidden" id="ofk" name="ofk">
				 <div id="old_passwordX" style="font-size:10px;color:red;"></div>
            </div>
        </div> 
        <div class="form-group col-md-3">
            <label class=" control-label" for="textinput">Password<span class="tx-danger">*</span></label>  
            <div class="">
                <input id="password" name="password" placeholder="Enter Password" class="form-control input-md password" type="password" onpaste="return false;" onCopy="return false" onCut="return false" tabindex="6" autocomplete="off" data-type="password" onkeyup="funInputFielTypes(this)"  required="required">
                <input type="hidden" id="fk" name="fk">
				 <div id="passwordX" style="font-size:10px;color:red;"></div>
            </div>
        </div>
        
         <div class="form-group col-md-3">
            <label class=" control-label" for="textinput">Confirm Password<span class="tx-danger">*</span> </label>  
            <div class="">
                <input id="confirm_password" name="confirm_password" placeholder="Enter Password" class="form-control input-md password_again" type="password" onpaste="return false;" onCopy="return false" onCut="return false" tabindex="6" autocomplete="off" onkeyup="checkPasswordMatch()"  required="required">
            <div id="confirm_passwordX" style="font-size:10px;color:red;"></div>
			</div>
        </div>

        <div class="col-md-1">
            <button type="submit" value="Submit" name="submit" id="changepassword" class="btn btn-sm btn-primary"
                style="margin-top:32px;" >Submit</button> 
				
        </div>
    </div>

    <?php echo form_close(); ?>


</div>
<!-- Load CryptoJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<script>
function checkPasswordMatch() {
    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirm_password").value;
    const confirm_passwordX = document.getElementById("confirm_passwordX");
	const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=-]).{8,}$/;

    if (confirm.length === 0) {
        confirm_passwordX.innerHTML = '';
    } else if (!pattern.test(confirm)) {
        confirm_passwordX.innerHTML = "❌ Password must be at least 8 characters and include uppercase, lowercase, number, and special character.";
        confirm_passwordX.className = "invalid";
    } else if (password !== confirm) {
        confirm_passwordX.innerHTML = "❌ Passwords do not match.";
        confirm_passwordX.className = "invalid";
    } else {
        confirm_passwordX.innerHTML = "";		
        confirm_passwordX.className = "valid";
    }
}
// Function to hash and update hidden fields
function hashPasswords() {
	
	const key = CryptoJS.enc.Utf8.parse("<?= $key ?>");
    const iv  = CryptoJS.enc.Utf8.parse("<?= $iv ?>");

    var in_oldPwd = $("#old_password").val();
    var in_newPwd = $("#password").val();
    var in_confirmPwd = $("#confirm_password").val();
	
    const inOldPwd = CryptoJS.AES.encrypt(in_oldPwd, key, {
        iv: iv,
        padding: CryptoJS.pad.Pkcs7,
        mode: CryptoJS.mode.CBC
    });
	const inNewPwd = CryptoJS.AES.encrypt(in_newPwd, key, {
        iv: iv,
        padding: CryptoJS.pad.Pkcs7,
        mode: CryptoJS.mode.CBC
    });
	const inConfirmPwd = CryptoJS.AES.encrypt(in_confirmPwd, key, {
        iv: iv,
        padding: CryptoJS.pad.Pkcs7,
        mode: CryptoJS.mode.CBC
    });
	

    $("#old_password").val(inOldPwd.toString());
    $("#password").val(inNewPwd.toString());
    $("#confirm_password").val(inConfirmPwd.toString());
}

// Attach onkeyup event to password fields
$("#changepassword").on('click', function() {
    hashPasswords();
});


</script>