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

	function validateForm() {
		var emp_name = document.manage_emp.emp_name.value;
		var emp_dept = document.manage_emp.emp_dept.selectedIndex;
		var emp_desg = document.manage_emp.emp_desg.selectedIndex;
		var emp_mobile = document.manage_emp.emp_mobile.value;
		var filter = /^[6-9]{1}[0-9]{9}$/;
		var patt1 = /^[\w]+[\w\s-./]+$/;


		/*if(!patt1.test(emp_name))
		{
			alert("Please Enter  Correct value in Employee Name ");
			return false;
		}*/

		if (emp_dept == '0') {
			alert("Please Select Department..!");
			return false;
		}

		if (emp_desg == '0') {
			alert("Please Select Designation..!");
			return false;
		}

		if (!filter.test(emp_mobile)) {
			alert("Please Enter Valid Mobile No..!");
			return false;
		}
		return true;
	}

	function delete_rec(emp_id) {
		if (confirm('Do Your Really Want To Delete This Record?')) {

			$.post('ajax_del_emp.php', {
				emp_id: emp_id
			}, function(data) {
				if (data == 1) {
					alert('Employee Deleted Successfully..!');
					window.location = 'manage_emp.php';
				} else if (data = 0) {
					alert('Unable To Delete, Try Again..!');
				} else {
					alert('Employee Is Mapped With Wards You Cannot Delete This Employee, Need To Updaete Wards Mapped With Employee..!');
				}
			});
		}
	}

	function delete_desg(i, desg_id, emp_id) {
		if (confirm('Do Your Really Want To Delete This Record?')) {

			$.post('ajax_del_emp_desg.php', {
				emp_id: emp_id,
				desg_id: desg_id
			}, function(data) {
				if (data == 1) {
					$('#trid' + i).css('display', 'none');
					alert('Deleted Successfully..!');
				} else {
					alert('Unable To Delete, Try Again..!');
				}
			});
		}
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


	function addAdvance() {

		var divcontent;
		var i = document.getElementById('cnt').value;


		var j = i - 1;

		var newdiv = document.createElement('tr');
		newdiv.setAttribute('id', i);
		newdiv.setAttribute('class', 'addrow');
		divcontent = "";

		//divcontent = divcontent + "<td align='left' style='padding:5px;'>";
		divcontent=divcontent + "<td align='center' style='padding:5px;'>";
		divcontent = divcontent + "Department:<select name='dept_id" + i + "' id='dept_id" + i + "' class='validate[required] form-control mytext' style='width:200px;' onchange='get_designations(this.value," + i + ")'>";


		$.post("ajax_departments.php", function(data) {

			$("#dept_id" + i).html(data);
		});


		divcontent = divcontent + "<option value='0'>--- Select Department ---</option>";

		divcontent = divcontent + "</select>";
		divcontent = divcontent + "</td>";



		divcontent = divcontent + "<td align='left' style='padding:5px;'>";
		divcontent = divcontent + "Designation:<select name='desg_id" + i + "' id='desg_id" + i + "' class='validate[required] form-control mytext' style='width:200px;'>";
		divcontent = divcontent + "<option value='0'>--- Select Designation ---</option>";

		divcontent = divcontent + "</select>";
		divcontent = divcontent + "</td>";
		divcontent = divcontent + "<td align='left' style='padding:5px;'><input type='button' value='Remove' class='btn btn-default' style='margin-top: 20px;' onclick='fnRemove(" + i + ");' /></td>";


		divcontent = divcontent + "</tr>";

		divcontent = divcontent + "</tr>";


		newdiv.innerHTML = divcontent;
		document.getElementById('advance_div').appendChild(newdiv);

		document.getElementById('cnt').value = eval(document.getElementById('cnt').value) + 1;
	}

	function fnRemove(arg) {
		var d1 = document.getElementById(arg).parentNode;
		var d2 = document.getElementById(arg);
		d1.removeChild(d2);
		var arg = arg - 1;
		// document.getElementById('cnt').value=eval (document.getElementById('cnt').value) - 1 ;
	}

	function update_desg(id, i, emp_id) {

		dept_id = $("#dept_m" + i).val();
		desg_id = $("#desg_m" + i).val();
		$.post('ajax_update_desg.php', {
			id: id,
			desg_id: desg_id,
			dept_id: dept_id,
			emp_id: emp_id
		}, function(data) {
			alert(data);
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
				<form method="post" action="save_update_emp.php" name="manage_emp" class="form-horizontal" onSubmit="return validateForm()">
					<input type='hidden' name='emp_id' value="{$data.emp_id}">
					<input type='hidden' name='dept_id_prev' value="{$data.emp_dept}">
					<input type="hidden" name="cnt" id="cnt" value="0" />

					<div class="form-body">

						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Employee Name - {$data.emp_id} <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_name' type="text" id="emp_name" size="30" maxlength='70' data-required="1" class="form-control" value="{$data.emp_name}" placeholder="Enter Employee Name" autocomplete="off" required="required" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Marathi Name: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Name In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_name_marathi' type="text" id="emp_name_marathi" size="30" maxlength='70' data-required="1" class="form-control" value="{$data.emp_name_marathi}" placeholder="Enter Name In Marathi" autocomplete="off" required="required" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Employee ID: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Employee ID <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_code' type="text" id="emp_code" class="form-control" value="{$data.emp_code}" minlength='1' maxlength='10' data-required="1" oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '')" placeholder="Enter Employee ID" autocomplete="off" required="required" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Mobile Number <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_mobile' maxlenght='10' type="text" id="mobile" maxlength='10' class="form-control num" value="{$data.emp_mobile}" onblur="check_mobile(this.value)" placeholder="Enter Mobile Number" autocomplete="off" required="required" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Department <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='emp_dept' id='emp_dept' onchange="get_det(this.value);" class="form-control" autocomplete="off" required="required">
									<option value='0'>--- Select Department ---</option>
									{html_options options=$dept_list selected=$data.emp_dept}
								</select>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Designation <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='emp_desg' id='emp_desg' class="form-control" autocomplete="off" required="required">
									<option value='0'>--- Select Designation ---</option>
									{html_options options=$desg_list selected=$data.emp_desg}
								</select>
							</div>
						</div>

						<div class="form-group table-responsive">
							<table class="table" id="advance_div" style="width:100%">

							</table>
						</div>

						<!-- <div class="form-group">
							<input type="button" id="add" class="btn btn-success" name="add" onclick="addAdvance()" value="ADD ANOTHER DESIGNATION" style="font-size:12px;">
						</div> -->
						<div class="form-group">
							<div class="control-label col-md-4">
								<input type="button" id="add" class="btn btn-success" name="add" onclick="addAdvance()" value="ADD ANOTHER DESIGNATION" style="font-size:12px;">
							</div>
						</div>

						<div class="form-actions fluid">
							<!-- <div class="col-md-offset-3 col-md-9"> -->
							<div align="center">
								<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Update</button>
								<!--<button type="button" class="btn btn-danger">Cancel</button>-->
								<a href="manage_emp.php" class="btn btn-danger">Back</a>
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