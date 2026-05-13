{include file='header.tpl'}
{literal}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<script src="js/jquery-tfo.min.js"></script>

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
		var emp_name_marathi = document.manage_emp.emp_name_marathi.value;
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


		var emp_status = $("#emp_status").val();
		var od_status = $("#od").val();
		if (emp_status == '1' && od_status == '0') {
			alert('This Mobile Number Is Already In Use, If Employee Is On Deputation, Check Below Checkbox..!');
			return false;
		}

		return true;
	}

	function delete_rec(emp_id, od_status) {

		if (confirm('Do Your Really Want To Delete This Record?')) {

			$.post('ajax_del_emp.php', {
				emp_id: emp_id,
				od_status: od_status
			}, function(data) {

				if (data == 1) {

					alert('Employee Deleted Successfully..!');
					window.location = 'manage_emp.php';
				} else {
					alert('Error: Try Again..!');
				}
			});
		}
	}

	/*old code changed 16-05-24 function delete_desg(i, desg_id, emp_id) {
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
	}*/
	function delete_desg(i, emp_id, desg_id) {
		if (confirm('Do Your Really Want To Delete This Record?')) {
			$.post('ajax_delete_emp_desg.php', {
				emp_id: emp_id,
				desg_id: desg_id,
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


	/*function addAdvance() {

		var divcontent;
		var i = document.getElementById('cnt').value;


		var j = i - 1;

		var newdiv = document.createElement('tr');
		newdiv.setAttribute('id', i);
		newdiv.setAttribute('class', 'addrow');
		divcontent = "";

		//divcontent=divcontent + "<td align='left' style='padding:5px;'>";
		divcontent = divcontent + "<td align='left' style='padding:5px;position: relative;left: 116px;'>";
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
		divcontent = divcontent + "<td align='left' style='padding:5px;'><input type='button' value='Remove' class='btn btn-default' onclick='fnRemove(" + i + ");' /></td>";




		divcontent = divcontent + "</tr>";

		divcontent = divcontent + "</tr>";


		newdiv.innerHTML = divcontent;
		document.getElementById('advance_div').appendChild(newdiv);

		document.getElementById('cnt').value = eval(document.getElementById('cnt').value) + 1;


	}*/

	function addAdvance() {

		var divcontent;
		var i = document.getElementById('cnt').value;


		var j = i - 1;

		var newdiv = document.createElement('tr');
		newdiv.setAttribute('id', i);
		newdiv.setAttribute('class', 'addrow');
		divcontent = "";

		//divcontent=divcontent + "<td align='left' style='padding:5px;'>";
		divcontent = divcontent + "<td align='center' style='padding:5px;'>";
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
<script>
	$(document).ready(function() {
		$("#od").click(function() {
			if (this.checked) {
				$("#od").val(1);
			} else {
				$("#od").val(0);
			}
		});
	});
</script>


<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('https://municipalservices.in/manage_emp.php #ref', function() {
				/// can add another function here
			});
		});
	}); //// End of Wait till page is loaded
</script>

{/literal}


<div class="row">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>ADD EMPLOYEE DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form method="post" action="save_manage_emp.php" name="manage_emp" class="form-horizontal" onSubmit="return validateForm()">
					<input type="hidden" name="csrf_token" value="{$csrf_token}" />
					<input type='hidden' name='emp_id' value='0'>
					<input type="hidden" name="cnt" id="cnt" value="0" />
					<input type="hidden" name="emp_status" id="emp_status" value="0">
					<div class="form-body">

						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}
										
						{if !empty($smarty.session.msg)}
							<div class="{$smarty.session.class}">
							<button class="close" data-close="alert"></button>
								{$smarty.session.msg}
							</div>							
						{/if}
						
						
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Employee Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_name' type="text" id="emp_name" size="30" maxlength='70' data-required="1" class="form-control" placeholder="Enter Employee Name" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required" />
								<div style="font-size:10px;color:red;" id="emp_nameX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Marathi Name: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Name In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_name_marathi' type="text" id="emp_name_marathi" size="30" maxlength='70' data-required="1" class="form-control" placeholder="Enter Name In Marathi" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required" />
								<div style="font-size:10px;color:red;" id="emp_name_marathiX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Employee ID: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Employee ID <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_code' type="text" id="emp_code" minlength='1' maxlength='10' data-required="1" oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '')" data-type="text" onkeyup="funInputFielTypes(this)" class="form-control" placeholder="Enter Employee ID" autocomplete="off" required="required" />
								<div style="font-size:10px;color:red;" id="emp_codeX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Mobile Number <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='emp_mobile' type="text" id="emp_mobile"  minlenght='10' maxlength='10' class="form-control num" onblur="check_mobile(this.value)" placeholder="Enter Mobile Number" data-type="mobile" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required" />
								<div style="font-size:10px;color:red;" id="emp_mobileX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Department <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='emp_dept' id='emp_dept' onchange="get_det(this.value);" class="form-control" autocomplete="off" required="required">
									<option value='0'>--- Select Department ---</option>
									{html_options options=$dept_list}
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
								</select>
							</div>
						</div>

						<div class="form-group" style="display:none;" id="od_area">
							<!-- <label class="control-label col-md-3">On Deputation: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">On Deputation <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="checkbox" name="od" id="od" value="0" autocomplete="off" required="required" checked>
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
							<!-- <div class="col-md-offset-3 col-md-9"> -->
							<div align="center">
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


<div class="row">
	<div>
		<form method="post" action="manage_emp.php" name="manage_emp1" class="form-horizontal" onSubmit="return validateForm1()">
			<!-- Mobile no <input type="text" name="mobile" value="{$mobile}">
			name <input type="text" name="emp_name" value="{$emp_name}"><input type="submit" value="search" name="search"> -->
			<div class="form-group">
				<label class="control-label col-md-2">Employee Name <span style="margin-left:10px;"> : </span> </label>
				<div class="col-md-3">
			<input type="text" name="emp_name" class="form-control"
			   value="{$emp_name}" placeholder="Search Employee Name"
			   autocomplete="off"
			   pattern="[A-Za-z0-9 ]+"
			   title="Only alphabets, numbers, and spaces are allowed">

				</div>
				<label class="control-label col-md-2">Mobile Number <span style="margin-left:10px;"> : </span> </label>
				<div class="col-md-3">
					<input type="text" name="mobile" class="form-control" value="{$mobile}" Placeholder="Search Mobile Number"  data-type="mobile" onkeyup="funInputFielTypes(this)"  autocomplete="off">
					<div style="font-size:10px;color:red;" id="mobileX"></div>
				</div>
				<div class="col-md-2">
					<!--<input type="submit" value="search" name="search">-->
					<button type="submit" class="btn btn-info" name='search' >Search</button>
				</div>
			</div>
		</form>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar white">
				<h4>EXISTING DESIGNATION DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div id="area">
				<div class="inner no-radius table-responsive" id="div_print">
					<!-- <table class="table table-striped table-bordered table-hover table-full-width" id="data-table"> -->
					<table class="table table-striped table-bordered table-hover table-full-width"  width="100%">
						<thead>
							<tr style="background-color:#2c3e50; color:#FFF;">
								<th style="text-align: center;">SR.No</th>
								<th style="text-align: center;">EMP ID</th>
								<th style="text-align: center;">EMPLOYEE NAME</th>
								<th style="text-align: center;">MARATHI NAME</th>
								<th style="text-align: center;">MOBILE NO.</th>
								<th style="text-align: center;">DEPARTMENT</th>
								<th style="text-align: center;">DESIGNATION</th>
								<th class="export" style="text-align: center;">EDIT</th>
								<th class="export" style="text-align: center;">DELETE</th>
							</tr>
						</thead>
						<tbody>
							{assign var="i" value="0"}
							{foreach from=$data key=emp_id item=row}
							<tr align="center">
								<td>{counter}</td>

								<td>{$row.emp_code}</td>
								<td>{$row.emp_name}-{$row.emp_id}</td>
								<td>{$row.emp_name_marathi}</td>
								<td>{$row.emp_mobile}</td>
								<td>{$dept_list[$row.emp_dept]}</td>
								<td>{$desg_list[$row.emp_desg]} {if $multi_desg_list[$emp_id] neq ''}<span id="{'id'|cat:$emp_id}">(More Designations)</span>
									<div id="{'divid'|cat:$emp_id}" style="display:block">
										<table id="data-table" class="table" width="100%">
											{foreach from=$dept_list item=row2 key=dept_id}

											{foreach from=$multi_desg_list[$emp_id][$dept_id] item=row3 key=desg_id}
											<tr id="{'trid'|cat:$i}">
												<td>
													<select name="{'dept_m'|cat:$i}" id="{'dept_m'|cat:$i}" onchange="get_designations(this.value,{$i},'2')">
														<option value=''>--- Select ----</option>
														{html_options options=$dept_list selected=$dept_id}
													</select>
												</td>
												<td>
													<select name="{'desg_m'|cat:$i}" id="{'desg_m'|cat:$i}">
														<option value=''>--- Select ----</option>
														{html_options options=$desg_list2[$dept_id] selected=$desg_id}
													</select>
													{$desg_list[$multi_desg_list[$emp_id][$desg_id]]}
												</td>
												<td>
													<span class="btn btn-success" onclick="update_desg('{$ids[$desg_id]}','{$i}','{$emp_id}')" title="Edit"><i class="fa fa-pencil-square"></i></span>
													<!-- <input type="button" class="btn btn-danger" onclick="update_desg('{$ids[$desg_id]}','{$i}','{$emp_id}')" value="Edit">-->
												</td>
												<td>
													<span class="btn btn-danger" onclick="delete_desg('{$i}','{$emp_id}','{$desg_id}')" title="Delete"><i class="fa fa-trash"></i></span>
													<!--<input type="button" class="btn btn-danger" onclick="delete_desg('{$i}','{$desg_id}','{$emp_id}')" value="Delete">-->
												</td>
											</tr>
											{assign var="i" value=$i+1}
											{/foreach}
											{/foreach}
										</table>
									</div>
									{/if}
								</td>
								<td>
									<form action="update_emp.php" method="post">
										<input type="hidden" name="csrf_token" value="{$csrf_token}" />
										<input type="hidden" name="emp_id" value="{$emp_id}">
										<input type="submit" class="btn btn-success" name="update" value="Edit">
									</form>
								</td>
								<td>
									<input type="button" class="btn btn-danger" value="Delete" onclick="delete_rec('{$emp_id}','{$row.od_status}')">
								</td>
							</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
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

		function check_mobile(mobile) {
			$.post('ajax_mobile_check.php', {
				mobile: mobile
			}, function(data) {
				if (data == 1) {
					alert('This Mobile Number Is Already In Use, We Are Will Add These Employee As Deputation..!');
					$("#od").val('1');
					$("#emp_status").val('1');
					$("#od_area").css('display', 'block');
				}
			});
		}
	</script>
	{/literal}
	{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css" type="text/css" media="all">
<div style="display:none" id="pdf-text"></div>
<style>
	/* Your regular styles go here */

	@media print {

		/* Set the page to landscape mode */
		@page {
			size: landscape;
		}

		/* Additional print styles if needed */
		body {
			font-size: 12pt;
			margin: 1cm;
			/* Adjust margins as needed */
		}
	}
</style>
<script language='javascript'>
  var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,',
      template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
      base64 = function(s) {
        return window.btoa(unescape(encodeURIComponent(s)))
      },
      format = function(s, c) {
        return s.replace(/{(\w+)}/g, function(m, p) {
          return c[p];
        })
      }
    return function(table, name) {

      if (!table.nodeType) table = document.getElementById(table)
      var ctx = {
        worksheet: name || 'Worksheet',
        table: table.innerHTML
      }
      window.location.href = uri + base64(format(template, ctx))
    }
  })();

  var mapTableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,',
      template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
      base64 = function(s) {
        return window.btoa(unescape(encodeURIComponent(s)))
      },
      format = function(s, c) {
        return s.replace(/{(\w+)}/g, function(m, p) {
          return c[p];
        })
      }
    return function(table, name) {
      // if (!table.nodeType) table = document.getElementById(table)
      let theString = $("#" + table).html();
      let theResult = strRemove("input[type=checkbox]", theString);
      var ctx = {
        worksheet: name || 'Worksheet',
        table: theResult
      }
      window.location.href = uri + base64(format(template, ctx))
    }
  })()
</script>
<script>
  (function($) {
    strRemove = function(theTarget, theString) {
      return $("<div/>").append($(theTarget, theString).remove().end()).html();
    };
  })(jQuery);

  function print_div() {
    var selectorId = '';
    if ($("#area").is(':visible')) {
      selectorId = '#area';
    }

    if ($("#div_print").is(':visible')) {
      selectorId = '#div_print';
    }

    var theString = $(selectorId).html();
    var theResult = strRemove(".noExport", theString);
    var printWindow = window.open();
    printWindow.document.write(theResult);
    printWindow.document.close();
    printWindow.print();

  }
</script>


{/literal}



<div align='center'>
  <!-- <input type="button" onclick="tableToExcel('data-table', 'Sheet')" value="Export To Excel" class="btn btn-success">
  <button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('data-table', 'GrievanceReport')" value="Export To PDF"></i> Export To PDF</button> -->
  <input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</div>
<br>
<br>
<br>
<br>
{literal}

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>

<script>
   
   function exportTableToPDF(TableId, ReportName) {
    // Create a new jsPDF instance
    const doc = new jsPDF('landscape');
    doc.setFontSize(10);

    // Add a heading to the PDF
    //const captionText = document.querySelector('#' + TableId + ' caption').textContent;
	const captionElement = document.querySelector('#' + TableId + ' caption');
	const captionText = captionElement ? captionElement.textContent : "";

    const cleanedCaptionText = captionText.replace(/\s+/g, ' ').trim();
    const pageWidth = doc.internal.pageSize.width;
    const textWidth = doc.getStringUnitWidth(cleanedCaptionText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    const x = (pageWidth - textWidth) / 2;
    doc.text(cleanedCaptionText, x, 15);

    // Generate the table from the HTML table with the specified TableId
    const table = document.getElementById(TableId);

    doc.autoTable({
        html: '#' + TableId,
        showFoot: "lastPage",
        styles: { lineColor: [0, 0, 0], fontSize: 8, textColor: [0, 0, 0] }, 
        headStyles: {
            fillColor: [173, 216, 230],
            lineWidth: 0.5,
            fontStyle: 'bold',
            halign: 'center',
            cellPadding: 1,
        },
        bodyStyles: {
            lineWidth: 0.5,
            halign: 'center',
            cellPadding: 1,
            alignment: 'center',
        },
        footStyles: {
            fillColor: [173, 216, 230],
            lineWidth: 0.5,
            halign: 'center',
            cellPadding: 1,
            alignment: 'center',
        },
       
        rowStyles: {
            lineColor: [0, 0, 0],
        },
        margin: { top: 20 },
        didDrawPage: function (data) {
            // Modify the fill color of the footer on the last page
            if (typeof data.table !== "undefined" && data.pageNumber === data.table.finalYPage) {
                doc.setFillColor(255, 255, 255);
                doc.setTextColor(0, 0, 0);
                doc.rect(data.settings.margin.left, doc.internal.pageSize.height - 20, doc.internal.pageSize.width - data.settings.margin.left - data.settings.margin.right, 10, 'F');
            }
        },
    });

    doc.save(ReportName + '.pdf');
}
</script>

{/literal}

	{include file='footer.tpl'}