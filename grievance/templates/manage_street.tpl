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

<script>
	function fill(street_id, ward_id, street_desc, street_desc_marathi, wards_marathi) {
		document.manage_street.street_id.value = street_id;
		$('#ward_id').val(ward_id);
		document.manage_street.street_desc.value = street_desc;
		document.manage_street.street_desc_marathi.value = street_desc_marathi;
		document.manage_street.wards_marathi.value = wards_marathi;
	}

	function delete_street(street_id) {
		//var msg= "Do you want to delete the selected Street?";

		//var answer = confirm (msg);
		// 	if (answer)
		// 	{
		if (confirm('Do You Really Want To Delete This Record?')) {
			var csrf_token = $("#csrf_token").val();
			$.post('ajax_del_street.php', {
				street_id: street_id,
				csrf_token: csrf_token
			}, function(data) {
				//alert(data);
				if (data == 1) {
					alert('Ward Deleted Successfully..!');
					window.location = 'manage_street.php';
				} else if (data == 0) {
					alert('Unable To Delete, Try Again..!');
				} else if (data == 3) {
					alert('Invalid Token..!');
				} else if (data == 4) {
					alert('csrf error');
				}
			});
		}
	}

	function validateForm() {

		var ward_id = document.manage_street.ward_id.selectedIndex;
		if (ward_id == '0') {
			alert("Please Select Zone..!");
			return false;
		}


		var street_desc = document.manage_street.street_desc.value;
		if (street_desc == '') {
			alert("Please Enter Ward Description..!");
			return false;
		}
		return true;
	}
</script>

<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('http://egovmars.in/csms/manage_street.php #ref', function() {
				/// can add another function here
			});
		});
	}); //// End of Wait till page is loaded
</script>

{/literal}



<!--<strong>Add  / Update Department</strong><br />
<div style="border:#999999 1px solid; height:35px; margin-top:5px;">
<form method="post" action="manage_dept.php" name="manage_dept" onSubmit="return validateForm();" >
<input type='hidden' name='dept_id' value='0'>
<table width="100%" height="55" border="0" cellpadding="0" cellspacing="0">
  
      <tr>
        <td width="40%" align="left" valign="middle"><strong>&nbsp;&nbsp;Department Name
          <input name="dept_desc" type="text" id="dept_desc" size="30" maxlength="50" />
        </label></td>
        <td width="20%" align="left" valign="middle"><input type='submit' name='save' value='Save Department'></td>
      </tr>
 
      <tr>
        <th align="center" valign="middle" colspan='3'><strong>
        {if isset($msg)}<font color='green'>{$msg}</font> {/if}
        </th>
       </tr>
    
</table>
</form>
</div>-->

<div class="row ">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>ADD / UPDATE WARD DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">	
						
				<form method="post" name='manage_street_del' action="manage_street_del.php">
					<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token" />
					<input type='hidden' name='street_id' vlaue=''>
				</form>
				<form method="post" action="save_manage_street.php" name="manage_street" class="form-horizontal" onSubmit="return validateForm()">
					<input type="hidden" name="csrf_token" value="{$csrf_token}" />

					<input type='hidden' name='street_id' value='0'>
					<div class="form-body">
						
						{if $flash}
							<div class="{$flash.class}">
							<button class="close" data-close="alert"></button>
								{$flash.msg}
							</div>
						{/if}
						
						<div class="form-group">
							<label class="control-label col-md-4">Select Zone <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='ward_id' id='ward_id' data-required="1" class="form-control" required="required" autocomplete="off">
									<option value='0'>-- Select Zone --</option>
									{html_options options=$ward_list}
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Ward Description <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <input name="street_desc" type="text" id="street_desc" size="30" maxlength='255' placeholder="Enter Ward Description" data-required="1" class="form-control" required="required" autocomplete="off" /> -->
								<textarea name='street_desc' id='street_desc' rows="2" cols="50" data-required="1" class="form-control" placeholder="Enter Ward Description" autocomplete="off" data-type="sptext" onkeyup="funInputFielTypes(this)"  required="required"></textarea>
								<div style="font-size:10px;color:red;" id="street_descX"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Ward Description In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <input name="street_desc_marathi" type="text" id="street_desc_marathi" size="30" maxlength='255' placeholder="Enter Ward Marathi Description" data-required="1" class="form-control" required="required" autocomplete="off" /> -->
								<textarea name='street_desc_marathi' id='street_desc_marathi' rows="2" cols="50" data-required="1" class="form-control" placeholder="Enter Ward Description In Marathi" autocomplete="off" data-type="sptext" onkeyup="funInputFielTypes(this)"  required="required"></textarea>
								<div style="font-size:10px;color:red;" id="street_desc_marathiX"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Zone Description In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!--<input type="text" name="wards_marathi" data-required="1" placeholder="Enter Zone Name In Marathi" class="form-control" id="wards_marathi" required="required" autocomplete="off" />-->
								<textarea name='wards_marathi' id='wards_marathi' rows="2" cols="50" data-required="1" class="form-control" placeholder="Enter Zone Description In Marathi" autocomplete="off" data-type="sptext" onkeyup="funInputFielTypes(this)"  required="required"></textarea>
								<div style="font-size:10px;color:red;" id="wards_marathiX"></div>
							</div>
						</div>
						<div class="form-group" id="ref">
							<label class="control-label col-md-4">
								<!-- <div style="border:1px solid #ccc;position: relative;left: 116px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;font-weight: bold;letter-spacing: 10px;font-size: 16px;"> -->
								<!--old code comment for 3-5-24 <div style="border:1px solid #ccc;position: relative;left: 225px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;font-weight: bold;letter-spacing: 10px;font-size: 16px;"> -->
								<div class="capththa">
									<p id="captImg" style="margin-top: 10px;">{$code}</p>
								</div>
							</label>
							<div class="col-md-4">
								<!-- <input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" required="required" style="width: 385px;border-radius: 3px;" onpaste="return false;"> -->
								<input type="text" class="form-control" name="captcha" id="captcha" placeholder="Enter Captcha" required="required" style="border-radius: 3px;" minlength="4"  maxlength="4" data-type="dcaptcha" onkeyup="funInputFielTypes(this)" onpaste="return false;">
								<input type="hidden" name="code" value="{$code}">
								<div style="font-size:10px;color:red;" id="captchaX"></div>
							</div>

						</div>

						<div class="col-md-6 col-md-offset-4">
							<p>Can't read the image? click <a id="buss" class="refreshCaptcha" style="cursor:pointer;">here</a> to refresh.</p>
						</div>

						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward' id="submitBtn" disabled>Submit</button>
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
				<h4>EXISTING WARDS DETAILS</h4>
			</div>
			<!-- Title Bart End sample_editable_1-->
			<div class="inner no-radius table-responsive">
				<!-- <table class="table table-striped table-bordered table-hover table-bordered dataTable" id="data-table"> -->
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">

							<th style="text-align: center;">SR.NO</th>
							<th style="text-align: center;">ZONE NAME</th>
							<th style="text-align: center;">WARD DESCRIPTION</th>
							<th style="text-align: center;">WARD DESCRIPTION IN MARATHI</th>
							<th style="text-align: center;">ZONE DESCRIPTION IN MARATHI</th>
							<th class="noExport" style="text-align: center;">EDIT</th>
							<th class="noExport" style="text-align: center;">
								<font color='white'>DELETE</font>
							</th>
						</tr>
					</thead>
					<tbody>

						{foreach from=$street_list item=row key=street_id}
						<tr align="center">
							<td>{counter}</td>
							<td>{$ward_list[$row.ward_id]}</td>
							<td>{$row.street_desc}</td>
							<td>{$row.street_desc_marathi}</td>
							<td>{$row.wards_marathi}</td>
							<td class="noExport">
								<!--<input type='radio' name='update' onchange="fill('{$street_id}','{$row.ward_id}','{$row.street_desc}')">-->
								<button class="btn btn-success" name='update' name='update' onclick="fill('{$street_id}','{$row.ward_id}','{$row.street_desc}','{$row.street_desc_marathi}','{$row.wards_marathi}')">
									<span class="fa fa-pencil"></span> Edit
								</button>
							</td>
							<td class="noExport">
								<input type='radio' name='delete_street' onchange="delete_street('{$street_id}')"><span class="fa fa-delete"></span> Delete
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
<!-- <br> -->

{include file='footer.tpl'}