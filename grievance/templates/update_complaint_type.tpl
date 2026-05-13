{include file='header.tpl'}
{literal}
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
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
			alert("Please Enter Correct Value In Employee Name..!");
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
		if (confirm('Do You Really Want To Delete This Record?')) {

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
		if (confirm('Do You Really Want To Delete This Record?')) {

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

		divcontent = divcontent + "<td align='left' style='padding:5px;'>";
		divcontent = divcontent + "Department:<select name='dept_id" + i + "' id='dept_id" + i + "' class='validate[required] form-control mytext' style='width:200px;' onchange='get_designations(this.value," + i + ")'>";


		$.post("ajax_departments.php", function(data) {

			$("#dept_id" + i).html(data);
		});


		divcontent = divcontent + "<option value='0'>---select---</option>";

		divcontent = divcontent + "</select>";
		divcontent = divcontent + "</td>";



		divcontent = divcontent + "<td align='left' style='padding:5px;'>";
		divcontent = divcontent + "Designation:<select name='desg_id" + i + "' id='desg_id" + i + "' class='validate[required] form-control mytext' style='width:200px;'>";
		divcontent = divcontent + "<option value='0'>---select---</option>";

		divcontent = divcontent + "</select>";
		divcontent = divcontent + "</td>";
		divcontent = divcontent + "<td align='left' style='padding:5px;'><input type='button' value='Remove' class='btn btn-default' onclick='fnRemove(" + i + ");' /></td>";




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
				<form method="post" action="save_update_complaint_type.php" name="manage_emp" class="form-horizontal" onSubmit="return validateForm()">
					<input type='hidden' name='cs_id' value="{$data.cs_id}">
					<input type="hidden" name="token" value="{$token_id}" />
					<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token" />
					<input type='hidden' name='doc_id' value='0'>

					<div class="form-body">

						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Category1: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Select Category <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='cat_id' id='cat_id' onchange="get_category(this.value);" class="form-control" required="required" autocomplete="off">
									<option value='0'>--Select Category--</option>
									{html_options options=$category_list selected=$data.cat_id}
								</select>
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Sub Category: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Select Sub Category <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='sub_cat_id' id='sub_cat_id' class="form-control" required="required" autocomplete="off">
									<option value='0'>--Select Sub Category--</option>
									{html_options options=$sub_category_list selected=$data.sub_cat_id}
								</select>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Complaint Type :<span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Complaint Type <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='cs_desc' id='cs_desc' type="text" data-required="1" value="{$data.cs_desc}" class="form-control" placeholder="Enter Complaint Type" data-type="text" onkeyup="funInputFielTypes(this)" required="required" autocomplete="off">
								<div style="font-size:10px;color:red;" id="cs_descX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Complaint Type in Marathi :<span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Complaint Type In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='telugu_description' id='telugu_description' value="{$data.telugu_description}" type="text" data-required="1" class="form-control" placeholder="Enter Complaint Type In Marathi" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required">
								<div style="font-size:10px;color:red;" id="telugu_descriptionX"></div>
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Level 1 SLA Days<span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Level 1 SLA Days <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='level_1' id='level_1' type="text" data-required="1" value="{$cdata.cutt_off_time}" class="form-control" placeholder="Enter Level 1 SLA Days" data-type="dnumber" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required">
								<div style="font-size:10px;color:red;" id="level_1X"></div>
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Level 2 SLA Days<span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Level 2 SLA Days <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='level_2' id='level_2' type="text" data-required="1" value="{$levelOfdata.L2}" class="form-control" placeholder="Enter Level 2 SLA Days"  data-type="dnumber" onkeyup="funInputFielTypes(this)"  autocomplete="off" required="required">
								<div style="font-size:10px;color:red;" id="level_2X"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Level 3 SLA Days<span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Level 3 SLA Days <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='level_3' id='level_3' type="text" data-required="1" value="{$levelOfdata.L3}" class="form-control" placeholder="Enter Level 2 SLA Days"  data-type="dnumber" onkeyup="funInputFielTypes(this)"  autocomplete="off" required="required">
								<div style="font-size:10px;color:red;" id="level_3X"></div>
							</div>
						</div>
						<div class="form-actions fluid">
							<!-- <div class="col-md-offset-3 col-md-9"> -->
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name='updatefrom' value='Add / Update Ward' id="submitBtn" disabled>Update</button>
								<a href="add_complaint_type.php" class="btn btn-danger">Back</a>
								<!--<button type="button" class="btn btn-danger">Cancel</button>-->
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