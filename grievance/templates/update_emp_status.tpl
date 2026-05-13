{include file='header.tpl'}
{literal}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->

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

	function fill(emp_id, emp_name, emp_mobile, emp_dept, emp_desg) {
		document.manage_emp.emp_id.value = emp_id;
		document.manage_emp.emp_name.value = emp_name;
		document.manage_emp.emp_mobile.value = emp_mobile;
		$('#emp_dept').val(emp_dept);
		get_det(emp_dept);

		$('#emp_desg').val(emp_desg);
	}

	function get_designations(dept_id, i, code) {

		$.post('get_designations2.php', {
			dept_id
		}, function(data) {
			if (code == '2') {
				$("#desg_m" + i).html(data);
			} else {

				$("#desg_id" + i).html(data);
			}
		});
	}
</script>
{/literal}


<div class="row">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>UPDATE EMPLOYEE DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form method="post" action="update_emp_status.php" name="manage_emp" class="form-horizontal">
					<input type='hidden' name='emp_id' value="{$data.emp_id}">
					<input type='hidden' name='dept_id_prev' value="{$data.emp_dept}">
					<input type='hidden' name='desg_id_prev' value="{$data.emp_desg}">
					<input type="hidden" name="emp_status" id="emp_status" value="{$data.emp_status}">
					<input type="hidden" name="cnt" id="cnt" value="0" />

					<div class="form-body">

						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}
						<div class="form-group">
							<label class="control-label col-md-4">Employee Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_name' type="text" id="emp_name" size="30" maxlength='70' data-required="1" class="form-control" value="{$data.emp_name}" placeholder="Enter Employee Name" autocomplete="off" required="required" readonly />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Name In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_name_marathi' type="text" id="emp_name_marathi" size="30" maxlength='70' data-required="1" class="form-control" value="{$data.emp_name_marathi}" placeholder="Enter Name In Marathi" autocomplete="off" required="required" readonly />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Employee ID <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_code' type="text" id="emp_code" size="30" maxlength='70' data-required="1" class="form-control" value="{$data.emp_code}" placeholder="Enter Employee ID" autocomplete="off" required="required" readonly />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Mobile Number <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_mobile' maxlenght='10' type="text" id="mobile" maxlength='10' class="form-control num" value="{$data.emp_mobile}" onblur="check_mobile(this.value)" placeholder="Enter Mobile Number" autocomplete="off" required="required" readonly />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Department Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='emp_dept' id='emp_dept' onchange="get_det(this.value);" class="form-control" autocomplete="off" required="required" readonly>
									<option value='0'>--- Select Department ---</option>
									{html_options options=$dept_list selected=$data.emp_dept}
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Designation Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='emp_desg' id='emp_desg' class="form-control" autocomplete="off" required="required" readonly>
									<option value='0'>--- Select Designation ---</option>
									{html_options options=$desg_list selected=$data.emp_desg}
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Employee Status <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='emp_status' id='emp_status' class="form-control" autocomplete="off" required="required">
									<option value=''>--- Select Employee Status ---</option>
									<option value='0' {if $data.emp_status=='0' }selected{/if}> Active</option>
									<option value='1' {if $data.emp_status=='1' }selected{/if}> Inactive</option>
								</select>
							</div>
						</div>

						<div class="form-actions fluid">
							<div align="center">
								<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Update</button>
								<a href="add_user.php" class="btn btn-danger">Back</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- </div>
</div>
</div> -->
{literal}
<script src='../js/jquery.min.js'></script>
<script>
	$(document).ready(function() {

		$(".num").keypress(function(e) {

			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});
	});
</script>
{/literal}

<!-- <br> -->

{include file='footer.tpl'}