{include file='header.tpl'}
{literal}

<script src="js/cryptojs/rollups/md5.js"></script>
<script src="js/cryptojs/components/md5.js"></script>

<script>
	function validateForm() {
		var errors = 0;
		var old_password = $("#old_password").val();
		var password = $("#password").val();
		var password_again = $("#password_again").val();
		var pattern = /^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!@#_$, ]{8,}$/;

		if (old_password == "") {

			alert('Enter Old Password..!');
			errors++;
		}
		
		if (password == "") {

			alert('Enter Password..!');
			errors++;
		}


		if (password_again != password) {


			errors++;

			alert('Enter Same Password..!');

		}

		if (errors == 0) {
			var opwd = $("#old_password").val();
			var pwd = $("#password").val();
			var encpwd = CryptoJS.MD5(pwd);
			var oencpwd = CryptoJS.MD5(opwd);
			if ($("#fk").val(encpwd)) {
				$("#ofk").val(oencpwd);
				return true;
			}
		} else {
			return false;
		}
	}
</script>
<style>
    .error { color: red; font-size: 0.9em; }
    .success { color: green; font-size: 0.9em; }
</style>
{/literal}




<div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar blue">
				<h4>CHANGE YOUR PASSWORD</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">

				<form method="post" action="change_password.php" name="manage_wards" class="form-horizontal" onSubmit="return validateForm()">
					<input type='hidden' name='uid' value='{$uid}'>
					<div class="form-body">
					
					{if $flash}
						<div class="{$flash.class}">
						<button class="close" data-close="alert"></button>
							{$flash.msg}
						</div>
					{/if}
						<div class="form-group">
							<label class="control-label col-md-4">Enter Old Password <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span></label>
							<div class="col-md-4">
								<input name="old_password" type="password" id="old_password" value="{$old_password}" {if ($old_password)} readonly {/if} data-required="1" class="form-control" placeholder="Enter Old Password"  oninput="validateOldPassword()" autocomplete="off" required />
								<input type="hidden" id="ofk" name="ofk">
								 <div id="old_password_msg" class="error"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Enter New Password <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span></label>
							<div class="col-md-4">
								<input name="password" type="password" id="password" value="{$password}" {if ($password)} readonly {/if} data-required="1" class="form-control" placeholder="Enter New Password"  oninput="validateNewPassword()" autocomplete="off" required />
								<input type="hidden" id="fk" name="fk">
								 <div id="new_password_msg" class="error"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Re- Type Password <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span></label>
							<div class="col-md-4">
								<input name="password_again" type="password" id="password_again" value="{$password}" {if ($password)} readonly {/if} data-required="1" class="form-control" placeholder="Enter Re- Type Password" oninput="validateConfirmPassword()" autocomplete="off" required />
								 <div id="confirm_password_msg" class="error"></div>
							</div>
						</div>
						{if isset($otp)}					
						<div class="form-group">
							<label class="control-label col-md-4">OTP Verification <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span></label>
							<div class="col-md-4">
								<input name="otp" type="text" id="otp" data-required="1" class="form-control" placeholder="Enter OTP Verification" autocomplete="off" required />
							</div>
						</div>
						{/if}
						{if isset($otp)}
						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name='otpverify' value='Add / Update Ward'>Submit</button>
							</div>
						</div>
						{else}
						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
								<button type="reset" class="btn btn-danger">Cancel</button>
							</div>
						</div>
						{/if}
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<br>
{include file='footer.tpl'}


{literal}

<script>
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/;

    const oldField = document.getElementById('old_password');
    const newField = document.getElementById('password');
    const confirmField = document.getElementById('password_again');
    const submitBtn = document.getElementById('submitBtn');

    let validOld = false, validNew = false, validConfirm = false;

    function validateOldPassword() {
        const val = oldField.value.trim();
        if (val === '') {
            document.getElementById('old_password_msg').innerText = '❌ Old password cannot be empty.';
            validOld = false;
        } else {
            document.getElementById('old_password_msg').innerText = '';
            validOld = true;
        }
        toggleSubmit();
    }

    function validateNewPassword() {
        const val = newField.value.trim();
        if (!passwordRegex.test(val)) {
            document.getElementById('new_password_msg').innerText = '❌ Must include uppercase, lowercase, number & special symbol, 8+ characters.';
            validNew = false;
        } 
        else if (val === oldField.value.trim() && val !== "") {
            document.getElementById('new_password_msg').innerText = '❌ New password cannot be the same as old password.';
            validNew = false;
        }
        else {
            document.getElementById('new_password_msg').innerText = '';
            validNew = true;
        }
        validateConfirmPassword(); // update confirm status in real-time
        toggleSubmit();
    }

    function validateConfirmPassword() {
        const newVal = newField.value.trim();
        const confirmVal = confirmField.value.trim();

        if (confirmVal === '') {
            document.getElementById('confirm_password_msg').innerText = '';
            validConfirm = false;
        }
        else if (confirmVal !== newVal) {
            document.getElementById('confirm_password_msg').innerText = '❌ Passwords do not match.';
            validConfirm = false;
        }
        else {
            document.getElementById('confirm_password_msg').innerText = '';
            validConfirm = true;
        }
        toggleSubmit();
    }

    function toggleSubmit() {
        submitBtn.disabled = !(validOld && validNew && validConfirm);
    }
</script>

{/literal}