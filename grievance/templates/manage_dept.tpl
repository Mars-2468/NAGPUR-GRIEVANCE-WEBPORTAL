{include file='header.tpl'}
{literal}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->

<script>

	function fill(dept_id, dept_desc, dept_marathi) {
		document.manage_dept.dept_id.value = dept_id;
		document.manage_dept.dept_desc.value = dept_desc;
		document.manage_dept.dept_marathi.value = dept_marathi;
	}

	function validateForm() {
		var dept_desc = document.manage_dept.dept_desc.value;
		if (dept_desc == '') {
			alert("Please Enter Department Name..!");
			return false;
		}

		return true;
	}

	function delete_rec(dept_id) {
		if (confirm('Do You Really Want To Delete This Record?')) {
			var csrf_token = $("#csrf_token").val();
			$.post('ajax_del_dept.php', {
				dept_id: dept_id,
				csrf_token: csrf_token
			}, function(data) {

				if (data == 1) {
					alert('Department Deleted Successfully..!');
					window.location = 'manage_dept.php';
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
</script>

<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('http://municipalservices.in/manage_dept.php #ref', function() {
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
				<h4>ADD / UPDATE DEPARTMENT DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				
				{if isset($msg)}
					<div class="{$class}">
						<button class="close" data-close="alert"></button>
						{$msg}
					</div>
				{/if}
				
				<form method="post" action="save_manage_dept.php" name="manage_dept" class="form-horizontal" onSubmit="return validateForm()">
						<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token" />
						<input type='hidden' name='dept_id' value='0'>
						<div class="form-body">					
							
							<div class="form-group">
								<label class="control-label col-md-4">Department Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
								<div class="col-md-4">
									<input name="dept_desc" type="text" id="dept_desc" size="30" maxlength='255' placeholder="Enter Department Name" data-required="1" class="form-control" data-type="text" onkeyup="funInputFielTypes(this)" required="required" autocomplete="off" />
									<div style="font-size:10px;color:red;" id="dept_descX"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Department Name In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
								<div class="col-md-4">
									<input type="text" name="dept_marathi" data-required="1" class="form-control" placeholder="Enter Department Name In Marathi" id="dept_marathi" data-type="text" onkeyup="funInputFielTypes(this)" required="required" autocomplete="off" />
									<div style="font-size:10px;color:red;" id="dept_marathiX"></div>
								</div>
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
				<h4>EXISTING DEPARTMENT DETAILS</h4>

			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius table-responsive">
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th style="text-align: center;">SR.NO</th>
							<th style="text-align: center;">DEPARTMENT NAME</th>
							<th style="text-align: center;">DEPARTMENT NAME IN MARATHI</th>
							<th style="text-align: center;">NO OF DESIGNATIONS</th>
							<th style="text-align: center;">NO OF EMPLOYEES</th>
							<th class="noExport" style="text-align: center;">EDIT</th>
							<!-- <th class="noExport" style="text-align: center;">
								<font color='white'>DELETE</font>
							</th> -->
						</tr>
					</thead>

					<tbody>

						{foreach from=$dept_list item=row key=dept_id}

						<tr>
							<td style="text-align: center;">{counter}</td>
							<td style="text-align: center;">{$row['dept_desc']}</td>
							<td style="text-align: center;">{$row['dept_marathi']}</td>
							<td style="text-align: center;">{$dept_list1[$dept_id].num_desg}</td>
							<td style="text-align: center;">{$dept_list1[$dept_id].num_emp}</td>
							<td class="noExport" style="text-align: center;">
								<!--old 25-04-24 <button class="btn btn-success" name='update' onclick="fill('{$dept_id}','{$row['dept_desc']}','{$row['dept_marathi']}')">
									<span class="fa fa-pencil"></span> Edit
								</button> -->
								<button class="btn btn-success" name='update' name='update' onclick="fill('{$dept_id}','{$row.dept_desc}','{$row.dept_marathi}')">
									<span class="fa fa-pencil"></span> Edit
								</button>
							</td>
							<!--old 25-04-24 <td>
								<input type="button" value="Delete" onclick="delete_rec('{$dept_id}')" class="btn btn-danger">
							</td> -->
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