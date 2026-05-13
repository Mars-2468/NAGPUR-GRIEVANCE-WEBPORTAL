{include file='header.tpl'}
{literal}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->

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
	function fill(cat_id, description, telugu_description) {

		document.category.cat_id.value = cat_id;
		document.category.description.value = description;
		document.category.telugu_description.value = telugu_description;
	}

	function delete_category(cat_id) {
		//var msg= "Do you want to delete the selected Street?";

		//var answer = confirm (msg);
		// 	if (answer)
		// 	{
		if (confirm('Do You Really Want To Delete This Record?')) {
			var csrf_token = $("#csrf_token").val();
			$.post('ajax_del_category.php', {
				cat_id: cat_id,
				csrf_token: csrf_token
			}, function(data) {
				//alert(data);
				if (data == 1) {
					alert('Category Deleted Successfully..!');
					window.location = 'category.php';
				} else if (data == 0) {
					alert('Unable To Delete, Try again..!');
				} else if (data == 3) {
					alert('Invalid Token..!');
				} else if (data == 4) {
					alert('csrf error');
				}
			});
		}

	}

	function validateForm() {

		var ward_id = document.category.ward_id.selectedIndex;
		if (ward_id == '0') {
			alert("Please Select Zone..!");
			return false;
		}

		var street_desc = document.sub_category.street_desc.value;
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



<!--<strong>Add / Update Department</strong><br />
<div style="border:#999999 1px solid; height:35px; margin-top:5px;">
	<form method="post" action="manage_dept.php" name="manage_dept" onSubmit="return validateForm();">
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
				<h4>ADD / UPDATE CATEGORY DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form method="post" name='manage_street_del' action="manage_street_del.php">
					<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token" />

					<input type='hidden' name='street_id' vlaue=''>
				</form>
				<form method="post" action="save_category.php" name="category" class="form-horizontal" onSubmit="return validateForm()">
					<input type="hidden" name="csrf_token" value="{$csrf_token}" />

					<input type='hidden' name='cat_id' id="cat_id" value='0'>
					<div class="form-body">
						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}

						<!-- old 25-04-24 <div class="form-group">
							<label class="control-label col-md-3">Category Name:<span class="required">* </span></label>
							<div class="col-md-5">
								<input name="description" type="text" id="description" size="30" maxlength='255' data-required="1" class="form-control" required="required" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Marathi Description:<span class="required">* </span></label>
							<div class="col-md-5">
								<input name="telugu_description" type="text" id="telugu_description" size="30" maxlength='255' data-required="1" class="form-control" required="required" />
							</div>
						</div>

						<div class="form-group" id="ref">
							<label class="control-label col-md-3">
								<div style="border:1px solid #ccc;position: relative;left: 116px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;font-weight: bold;letter-spacing: 10px;font-size: 16px;">
									<p id="captImg" style="margin-top: 10px;">{$code}</p>
								</div>
							</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" required="required" style="width: 385px;border-radius: 3px;" onpaste="return false;">
								<input type="hidden" name="code" value="{$code}">
							</div>
						</div>

						<div class="col-md-6 col-md-offset-3">
							<p>Can't read the image? click <a id="buss" class="refreshCaptcha" style="cursor:pointer;">here</a> to refresh.</p>
						</div>

						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name='save' value='Add / Update Category'>Submit</button>-->
						<!--<button type="button" class="btn btn-danger" onclick="this.form.reset();">Cancel</button>-->
						<!--</div>
						</div>-->

						<div class="form-group">
							<label class="control-label col-md-4">Category Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name="description" type="text" id="description" size="30" maxlength='255' data-required="1" placeholder="Enter Category Name" class="form-control" autocomplete="off" required="required" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Category In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<textarea name='telugu_description' id='telugu_description' rows="2" cols="50" data-required="1" class="form-control" placeholder="Enter Category In Marathi" autocomplete="off" required="required"></textarea>
							</div>
						</div>

						<div class="form-group" id="ref">
							<label class="control-label col-md-4">
								<!--<div style="border:1px solid #ccc;position: relative;left: 116px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;font-weight: bold;letter-spacing: 10px;font-size: 16px;" >-->
								<!--old code comment for 3-5-24 <div style="border:1px solid #ccc;position: relative;left: 225px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;font-weight: bold;letter-spacing: 10px;font-size: 16px;"> -->
								<div class="capththa">
									<p id="captImg" style="margin-top: 10px;">{$code}</p>
								</div>
							</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" autocomplete="off" required="required" style="border-radius: 3px;" onpaste="return false;">
								<input type="hidden" name="code" value="{$code}">
							</div>
						</div>

						<div class="col-md-6 col-md-offset-4">
							<p>Can't read the image? click <a href="" id="buss" class="refreshCaptcha" style="cursor:pointer;">here</a> to refresh.</p>
						</div>

						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name="save" value="Add / Update Category">Submit</button>
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
				<h4>EXISTING CATEGORY DETAILS</h4>
			</div>
			<!-- Title Bart End sample_editable_1-->
			<div class="inner no-radius table-responsive">
				<!--old 25-04-24 <table class="table table-striped table-bordered table-hover table-bordered dataTable" id="data-table"> -->
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
					<thead>

						<tr style="background-color:#2c3e50; color:#FFF;">

							<th style="text-align: center;">SR.NO</th>
							<th style="text-align: center;">CATEGORY NAME</th>
							<th style="text-align: center;">CATEGORY IN MARATHI</th>
							<th class="noExport" style="text-align: center;">EDIT</th>
							<!-- <th class="noExport" style="text-align: center;">
								<font color='white'>DELETE</font>
							</th> -->
						</tr>


					</thead>
					<tbody>

						{foreach from=$category_list item=row key=cate_id}
						<tr>
							<td style="text-align: center;">{counter}</td>
							<td style="text-align: center;">{$row.description}</td>
							<td style="text-align: center;">{$row.telugu_description}</td>
							<td class="noExport" style="text-align: center;">
								<!--<input type='radio' name='update' onchange="fill('{$sub_cat_id}','{$row.description}')">-->
								<button class="btn btn-success" name='update' name='update' onclick="fill('{$row.cat_id}','{$row.description}','{$row.telugu_description}')">
									<span class="fa fa-pencil"></span> Edit
								</button>
							</td>
							<!--<td class="noExport">
											<input type='radio' name='delete_category'  onchange="delete_category('{$row.cat_id}')"><span class="fa fa-delete"></span> Delete		
										</td>-->
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