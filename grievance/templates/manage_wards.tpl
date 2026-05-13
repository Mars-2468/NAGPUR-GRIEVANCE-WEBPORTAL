{include file='header.tpl'}
{literal}
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
<!--
<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('http://egovmars.in/csms/manage_wards.php #ref', function() {
				/// can add another function here
			});
		});
	}); //// End of Wait till page is loaded
</script>
-->
<script>
	function fill(ward_id, ward_desc, wards_marathi) {
		document.manage_wards.ward_id.value = ward_id;
		document.manage_wards.ward_desc.value = ward_desc;
		document.manage_wards.wards_marathi.value = wards_marathi;

	}

	function delete_ward(ward_id) {

		if (confirm('Do You Really Want To Delete This Record..!')) {
			var csrf_token = $("#csrf_token").val();
			$.post('ajax_del_ward.php', {
				ward_id: ward_id,
				csrf_token: csrf_token
			}, function(data) {


				if (data == 1) {
					alert('Zone Deleted Successfully..!');
					window.location = 'manage_wards.php';
				} else if (data == 0) {
					alert('Unable To Delete, Try Again..!');
				} else if (data == 2) {
					alert('Zone Is Mapped With Employees You Cannot Delete This Zone..!');
				} else if (data == 3) {
					alert('Invalid Token..!');
				} else if (data == 4) {
					alert('csrf error');
				}
			});
		}
	}

	function validateForm() {
		var ward_desc = document.manage_wards.ward_desc.value;
		if (ward_desc == '') {
			alert("Please Enter Zone No / Description..!");
			return false;
		}
		return true;
	}
</script>
{/literal}



<div class="row">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>ADD / UPDATE ZONES DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form method="post" action="save_manage_wards.php" name="manage_wards" class="form-horizontal" onSubmit="return validateForm1()">
					<input type="hidden" name="token" value="{$token_id}" />
					<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token" />
					<input type='hidden' name='ward_id' value='0'>
					<div class="form-body">

					
						{if $flash}
							<div class="{$flash.class}">
							<button class="close" data-close="alert"></button>
								{$flash.msg}
							</div>
						{/if}
						<div class="form-group">
							<label class="control-label col-md-4">Zone Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="text" name="ward_desc" data-required="1" class="form-control" id="ward_desc" placeholder="Enter Zone Name" autocomplete="off" data-type="text" onkeyup="funInputFielTypes(this)" required="required">
								<div style="font-size:10px;color:red;" id="ward_descX"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Zone Name In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="text" name="wards_marathi" data-required="1" class="form-control" placeholder="Enter Zone Name In Marathi" id="wards_marathi" data-type="text" onkeyup="funInputFielTypes(this)" required="required" autocomplete="off" />
								<div style="font-size:10px;color:red;" id="wards_marathiX"></div>
							</div>
						</div>

						<div class="form-group" id="ref">
							<label class="control-label col-md-4">
								<!--<div style="border:1px solid #ccc;position: relative;left: 116px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;font-weight: bold;letter-spacing: 10px;font-size: 16px;" >-->
								<div class="capththa">
									<p id="captImg" style="margin-top: 10px;">{$code}</p>
								</div>
							</label>
							<div class="col-md-4">
								<!-- <input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" autocomplete="off" required="required" style="width: 385px;border-radius: 3px;" onpaste="return false;"> -->
								<input type="text" class="form-control" name="captcha" id="captcha" minlength="4" maxlength="4" placeholder="Enter Captcha" autocomplete="off" required="required" style="border-radius: 3px;" onpaste="return false;" data-type="dcaptcha" onkeyup="funInputFielTypes(this)">
								<input type="hidden" name="code" value="{$code}">
								<div style="font-size:10px;color:red;" id="captchaX"></div>
							</div>
						</div>

						<div class="col-md-6 col-md-offset-4">
							<p>Can't read the image? click <a href="" id="buss" class="refreshCaptcha" style="cursor:pointer;">here</a> to refresh.</p>
						</div>

						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name="save" id="submitBtn" disabled>Submit</button>
								<button type="button" class="btn btn-danger" onclick="this.form.reset();">Cancel</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row" id="div_print">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar white">
				<h4>EXISTING ZONES DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<!-- old 24-04-24 <div class="inner no-radius">
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th align="center">S.No</th>
							<th>ZONE NAME</th>
							<th>ZONE MARARTHI</th>
							<th>EDIT</th>
							<th>DELETE</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$ward_list item=row key=ward_id}
							<tr align='center'>
								<td>{counter}</td>
								<td>{$row['ward_desc']}</td>
								<td>{$row['wards_marathi']}</td>
								<td>
									<button class="btn btn-success" name='update' onclick="fill('{$ward_id}','{$row['ward_desc']}','{$row['wards_marathi']}')">
										Edit
									</button>

								</td>
								<td>
									<input type="button" value="Delete" onclick="delete_ward('{$ward_id}')" class="btn btn-danger">
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>-->
			<div class="inner no-radius table-responsive">
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th style="text-align: center;">SR.NO</th>
							<th style="text-align: center;">ZONE NAME</th>
							<th style="text-align: center;">ZONE NAME IN MARARTHI</th>
							<th class="noExport" style="text-align: center;">EDIT</th>
							<th class="noExport" style="text-align: center;">DELETE</th>
						</tr>
					</thead>
					<tbody>
						{assign var="counter" value=$firstNumber+1}
						{foreach from=$ward_list item=row key=ward_id}
						<tr align="center">
							<td>{$counter}</td>
							{assign var="counter" value=$counter+1}
							<td>{$row['ward_desc']}</td>
							<td>{$row.wards_marathi}</td>
							<td class="noExport">
								<button class="btn btn-success" name='update' name='update' onclick="fill('{$ward_id}','{$row.ward_desc}','{$row.wards_marathi}')">
									<span class="fa fa-pencil"></span> Edit
								</button>
							</td>
							<td class="noExport">
								<input type="button" value="Delete" onclick="delete_ward('{$ward_id}')" class="btn btn-danger">
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
{include file='footer_print.tpl'}


{include file='footer.tpl'}