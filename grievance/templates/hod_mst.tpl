{include file='header.tpl'}
{literal}
 
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->

<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('http://municipalservices.in/hod_mst.php #ref', function() {
				/// can add another function here
			});
		});
	}); //// End of Wait till page is loaded
</script>
<script>
	function get_det(dept_id) {
		var select = document.getElementById("emp_desg");
		select.options.length = 0;

		if (window.XMLHttpRequest)
			xmlhttp = new XMLHttpRequest();
		else
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var strArray = xmlhttp.responseText.split("___");
				var j = strArray.length;
				for (i = 0; i < j; i++) {
					var optArray = strArray[i].split(":::");
					select.options[select.options.length] = new Option(optArray[1], optArray[0]);
				}
			}
		}
		xmlhttp.open("GET", "get_designations.php?dept_id=" + dept_id, true);
		xmlhttp.send();

	}
</script>
<script>
	function delete_hod(dept_id) {

		if (confirm('Do You Really Want To Delete This Record..!')) {
			var csrf_token = $("#csrf_token").val();
			$.post('ajax_del_hod.php', {
				dept_id: dept_id,
				csrf_token: csrf_token
			}, function(data) {

				if (data == 1) {
					alert('Record Deleted Successfully..!');
					window.location = 'hod_mst.php';
				} else if (data == 0) {
					alert('Unable To Delete, Try again..!');
				} else if (data == 3) {
					alert('Invalid Token');
				} else if (data == 4) {
					alert('csrf error');
				}
				/*else if(data==2)
				{
				alert('Ward is mapped with employees You cannot delete this ward');
				}*/

			});
		}

	}
</script>



{/literal}


<div class="row">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>ADD HEAD OF THE DEPARTMENT DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form method="post" action="hod_mst.php" name="" class="form-horizontal" onSubmit="return validateForm()">
					<input type="hidden" name="token" value="{$token_id}" />
					<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token" />
					<div class="form-body">
						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}

						<div class="form-group">
							<!--old 26-04-24 <label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Select Department <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='dept_id' id='emp_dept' onchange="get_det(this.value);" class="form-control" required="required" autocomplete="off">
									<option value=''>-- Select Department --</option>
									{html_options options=$dp_list}
								</select>
							</div>
						</div>

						<div class="form-group">
							<!--old 26-04-24 <label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Select Designation <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='desg_id' id='emp_desg' class="form-control" autocomplete="off" required="required">
									<option value=''>-- Select Designation --</option>
								</select>
							</div>
						</div>

						<!--<div class="form-group" id="ref">
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
						</div>-->

						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
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
			<div class="title-bar white">
				<h4>EXISTING HEAD OF THE DEPARTMENT DETAILS</h4>
			</div>

			<div class="inner no-radius table-responsive">
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th style="text-align: center;">SR.NO</th>
							<th style="text-align: center;">DEPARTMENT NAME</th>
							<th style="text-align: center;">HOD DESIGNATION NAME</th>
							<!--<th class="noExport" style="text-align: center;">EDIT</th>-->
							<th class="noExport" style="text-align: center;">
								<font color='white'>DELETE</font>
							</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$data item=row key=dept_id}
						<tr>
							<td style="text-align: center;">{counter}</td>
							<td style="text-align: center;">{$dept_list[$row.dept_id]}</td>
							<td style="text-align: center;">{$desg_list[$row.desg_id]}</td>

							<!--<td>
									<button class="btn btn-success" name='update' onclick="fill('{$ward_id}','{$ward_desc}')">
										<span class="fa fa-pencil"></span> Edit
									</button>
								</td>-->
							<td style="text-align: center;">
								<input type="button" value="Delete" onclick="delete_hod('{$row.dept_id}')" class="btn btn-danger">
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