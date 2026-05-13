{include file='header.tpl'}

{literal}


<script>
	$(document).ready(function() {
		$(".select2").select2();
	});
</script>
<script language='javascript'>
	function check_availability() {
		emp_id = $("#emp_id").val();

		//alert(emp_id);

		$.post('check_availability.php', {
			emp_id: emp_id
		}, function(data) {
			//alert(data);
			var arr = data.split("::");
			$("#user_id").val(arr[0].trim());
			$("#user_name").val(arr[1].trim());
			$("#user_mobile").val(arr[0].trim());
			$("#user_code").val(arr[3]);
		});
	}

	function validateForm() {
		var errors = 0;
		var user_mobile = document.add_user.user_mobile.value;
		var user_email = document.add_user.user_email.value;

		var patt = /^[7-9]\d{9}$/;
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var patt1 = /^[a-zA-Z][a-zA-Z0-9]{5,}$/;

		if (!patt.test(user_mobile)) {
			alert("Please Enter Valid Mobile No");
			errors++;
			return false;
		}

		if (!re.test(user_email)) {
			alert("Please Enter Valid email");
			errors++;
			return false;
		}

		var user_pwd1 = document.add_user.user_pwd1.value;
		var user_pwd2 = document.add_user.user_pwd2.value;
		if (user_pwd1 != user_pwd2) {
			alert("Passwords donot match");
			errors++;
			return false;
		}
		if (!patt1.test(user_pwd2)) {
			alert("Password must Start with letter and can contain letters/numbers, Atleast 6 characters");
			errors++;
			return false;
		}

		if (errors == 0) {
			var pwd = $("#user_pwd1").val();
			var encpwd = CryptoJS.MD5(pwd);
			if ($("#fk").val(encpwd)) {

				return false;
			}
			return false
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

<div>
	<div>
	
		{if $flash}
			<div class="{$flash.class}">
			<button class="close" data-close="alert"></button>
				{$flash.msg}
			</div>
		{/if}
	</div>
	<form name='add_user' method='POST' action='save_add_user.php' onSubmit="return validateForm();" autocomplete="off">
		<input type="hidden" name="csrf_token" value="{$csrf_token}" />
		<input type='hidden' name='emp_id' value='0'>
		<input type="hidden" name="cnt" id="cnt" value="0" />
		<input type="hidden" name="emp_status" id="emp_status" value="{$data.emp_status}">
		<div class="row">
			<div>
				<div class="boxed">
					<!-- Title Bart Start -->
					<div class="title-bar success">
						<h4>ADD NEW USER DETAILS</h4>
					</div>
					<!-- Title Bart End -->
					<div class="inner no-radius">
				

						<div class="form-group">
							<label class="control-label col-md-3" style="text-align:right;">Select Employee ID<span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span></label>
							<div class="col-md-5">
								<select id='emp_id' name="emp_id" onChange="check_availability()" class="select2 form-select" autocomplete="off" required="required">
									<option value="0" selected disabled>--- Select Employee ID ---</option>
									{html_options options=$emp_list}
								</select>
							</div>

							<br><br>
							<div id="area" class="table-responsive">
								<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
									<td width="14%">Username <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </td>
									<td width="28%"><input type='text' name='user_id' id='user_code' size='40' maxlength='25' class="form-control" placeholder="Username" required readonly autocomplete="off"></td>
									<td width="15%">Password <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </td>
									<td width="43%">
										<input type='password' name='password' id='password' class="form-control" placeholder="Enter Password" required  oninput="validatePassword()" autocomplete="off">
										<input type='hidden' name='fk' class="form-control" id="fk">
										  <div id="password_msg" class="error"></div>
									</td>
									<tr>
										<td>Re Enter Password <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </td>
										<td>
											<input type='password' name='confirm_password' id='confirm_password' class="form-control" placeholder="Enter Re Enter Password" required  oninput="validateConfirmPassword()" autocomplete="off">
											 <div id="confirm_password_msg" class="error"></div>
										</td>
										
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>

										<td>Employee Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </td>
										<td>
										<input type='text' name='user_name' id='user_name' class="form-control" placeholder="Enter Employee Name" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off">
										<div style="font-size:10px;color:red;" id="user_nameX" class="error"></div>
										</td>
										<td>Mobile No <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </td>
										<td><input type='text' name='user_mobile' minlength="10" maxlength="10" id='user_mobile' class="form-control" placeholder="Enter Mobile Number" required autocomplete="off"></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td></td>
										<td>&nbsp;</td>
										<td></td>
									</tr>
									<tr>
										<th colspan='5'>
											<center>
												<input type='submit' name='save' value='Update Profile' class="btn btn-success" id="submitBtn" disabled>
											</center>
										</th>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="row">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar blue">
				<h4>EXISTING USER DETAILS</h4>
			</div>
			<!-- Title Bart End sample_1-->
			<div class="inner no-radius table-responsive" id="div_print">
				<!-- <table class="table table-striped table-bordered table-hover table-full-width" id="data-table"> -->
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
					<thead style="background-color:#2c3e50; color:#FFF;">
						<th style="text-align: center;">SR.NO</th>
						<th style="text-align: center;">EMPLOYEE NAME</th>
						<th style="text-align: center;">DEPARTMENT NAME</th>
						<th style="text-align: center;">DESIGNATION NAME</th>
						<th style="text-align: center;">MOBILE NO</th>
						<th class="noExport" style="text-align: center;">ACTION</th>
					</thead>

					{foreach from=$data item=row key=emp_id}
					<tr align="center">
						<td>{counter}</td>
						<td>{$row.emp_name}</td>
						<td>{$dept_list[$row.emp_dept]}</td>
						<td>{$desg_list[$row.emp_desg]}</td>
						<td>{$row.emp_mobile}</td>
						<td class="noExport" style="text-align: center;">
							<form action="update_emp_status.php" method="post">
								<input type="hidden" name="csrf_token" value="{$csrf_token}" />
								<input type="hidden" name="emp_id" value="{$emp_id}">
								{if {$row.emp_status == 0}}
									<input type="submit" class="btn btn-primary" name="update" value="Active">
								{else}
									<input type="submit" class="btn btn-danger" name="update" value="Inactive">
								{/if}


								
							</form>
						</td>
					</tr>
					{/foreach}
				</table>
			</div>
		</div>
	</div>
</div>

{include file='footer_print.tpl'}

{include file='footer.tpl'}

{literal}



<script>
    // Password complexity regex
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/;

    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('confirm_password');
    const submitBtn = document.getElementById('submitBtn');

    function validatePassword() {
        const value = passwordField.value.trim();
        let message = '';

        if (!passwordRegex.test(value)) {
            message = '❌ Password must be at least 8 characters with uppercase, lowercase, number, and special character.';
            submitBtn.disabled = true;
        } else {
            message = '';
            // Only enable submit if confirm password matches
            if (confirmField.value === value && confirmField.value !== '') {
                submitBtn.disabled = false;
            }
        }

        document.getElementById('password_msg').innerText = message;
    }

    function validateConfirmPassword() {
        const passwordValue = passwordField.value.trim();
        const confirmValue = confirmField.value.trim();
        let message = '';

        if (confirmValue === '') {
            message = '';
            submitBtn.disabled = true;
        } 
        else if (confirmValue !== passwordValue) {
            message = '❌ Passwords do not match.';
            submitBtn.disabled = true;
        } 
        else if (!passwordRegex.test(confirmValue)) {
            message = '❌ Password must meet complexity rules.';
            submitBtn.disabled = true;
        } 
        else {
            message = '';
            submitBtn.disabled = false;
        }

        document.getElementById('confirm_password_msg').innerText = message;
    }
</script>
{/literal}