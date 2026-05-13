{include file='header.tpl'}
{literal}
 
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
<script>
	function fill(emp_id, dept_id) {
		//alert('hi');
		$('#emp_id').val(emp_id);
		$('#dept_id').val(dept_id);

		document.assign_dept_desgn.emp_id.value = emp_id;
		document.assign_dept_desgn.dept_id.value = dept_id;

		get_det(emp_id);
		get_det(dept_id);
	}

	/*function fill(emp_id, dept_id) {
		alert('hi');

		// Set the values in the form fields
		$('#emp_id').val(emp_id);
		$('#dept_id').val(dept_id);

		// Call functions to get additional details
		get_det(emp_id);
		get_det(dept_id);
	}*/

	function delete_hod(i, emp_id, dept_id) {
		if (confirm('Do Your Really Want To Delete This Record?')) {
			$.post('ajax_delete_map_dept.php', {
				emp_id: emp_id,
				dept_id: dept_id
			}, function(data) {
				if (data == 1) {
					$('#trid' + i).css('display', 'none');
					alert('Deleted Successfully..!');
					//location.reload(); // Refresh the page
				} else {
					alert('Unable To Delete, Try Again..!');
				}
			});
		}
	}

	function delete_ward(ward_id) {

		if (confirm('Do You Really Want To Delete This Record..!')) {
			var csrf_token = $("#csrf_token").val();
			$.post('ajax_del_ward.php', {
				ward_id: ward_id,
				csrf_token: csrf_token
			}, function(data) {


				if (data == 1) {
					alert('Zone  Deleted Successfully..!');
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


<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('http://municipalservices.in/assign_dept_desgn.php #ref', function() {
				/// can add another function here
			});
		});
	}); //// End of Wait till page is loaded
</script>

{/literal}


<div class="row ">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>MAPPING FOR DEPARTMENT DASHBOARD </h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">

				<form method="post" action="assign_dept_desgn.php" name="manage_emp" class="form-horizontal" onSubmit="return validateForm()">
					<!-- <input type="text" name="token" value="{$token_id}" /> -->
					<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token" />
					<input type='hidden' name='emp_id' value='0'>
					<input type="hidden" name="cnt" id="cnt" value="0" />
					<input type="hidden" name="dept_id" value="0">
					<div class="form-body">

						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}
						<div class="form-group">
							<label class="control-label col-md-4">Select Employee<span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='emp_id' id='emp_id' class="form-control" autocomplete="off" required="required">
									<option value='0'>--- Select Employee ---</option>
									{html_options options=$emp_list}
								</select>
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-5"> -->
							<label class="control-label col-md-4">Select Department <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='dept_id' id='dept_id' class="form-control" autocomplete="off" required="required">
									<option value='0'>-- Select Department --</option>
									{html_options options=$dept_list}
								</select>
							</div>
						</div>

						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name="save">Submit</button>
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
				<h4>EXISTING MAPPING FOR DEPARTMENT DASHBOARD DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius table-responsive">
				<form action="assign_dept_desgn.php" method="post" onSubmit="return validateForm2()">
					<input type="hidden" name="csrf_token" value="{$csrf_token}" />
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
						<caption style="caption-side:top;text-align:center;padding-top: 10px;padding-bottom: 10px;font-size:16px;">
							<b>
								<CENTER><strong>VIEW MAPPING FOR DEPARTMENT DASHBOARD DETAILS</strong></CENTER>
							</b>
						</caption>
						<thead>
							<tr style="background-color:#2c3e50; color:#FFF;">
								<th style="text-align: center;">SR.NO</th>
								<th style="text-align: center;">EMPLOYEE ID</th>
								<th style="text-align: center;">EMPLOYEE NAME</th>
								<th style="text-align: center;">DEPARTMENT NAME</th>
								<!-- 20-06-2024 <th class="noExport" style="text-align: center;">EDIT</th>-->
								<th class="noExport" style="text-align: center;">DELETE</th>
							</tr>
						</thead>

						<tbody>
							{assign var="i" value="0"}
							{foreach from=$data item=row key=emp_id}
							<tr id="{'trid'|cat:$i}">
								<td style="text-align: center;">{counter}</td>
								<td style="text-align: center;">{$row.emp_code}</td>
								<td style="text-align: center;">{$row.emp_name}</td>
								<td style="text-align: center;">{$row.dept_desc}</td>
								<!-- 20-06-2024 <td class="noExport" style="text-align: center;"> -->
								<!--<input type='radio' name='update' onchange="fill('{$desg_id}','{$row.dept_id}','{$row.desg_desc}')"> -->
								<!-- 20-06-2024 <input type="button" class="btn btn-primary" id="{'id11'|cat:$i}" onclick="fill('{$row.emp_id}','{$row.dept_id}')" value="Edit"> -->
								<!-- <button class="btn btn-success" name='update' onclick="fill('{$id}{$emp_id}','{$dept_id}')">
										<span class="fa fa-pencil"></span> Edit
									</button> -->
								<!-- 20-06-2024 </td>-->
								<td class="noExport" style="text-align: center;">
									<!-- <input type='radio' name='delete_hod' onchange="delete_hod('{$i}','{$row.emp_id}','{$row.dept_id}')"> Delete -->
									<span class="btn btn-danger" onclick="delete_hod('{$i}','{$row.emp_id}','{$row.dept_id}')" title="Delete">Delete</span>
								</td>
							</tr>
							{assign var="i" value=$i+1}
							{/foreach}
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
{include file='footer_print.tpl'}

{include file='footer.tpl'}

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

	/*function delete_desg1(desg_id) {
		//alert();

		var msg = "Do You Want To Delete The Selected Designation..!";
		var answer = confirm(msg);
		if (answer) {
			document.manage_desg_del.desg_id.value = desg_id;
			document.manage_desg_del.submit();
		}
	}*/
</script>
{/literal}