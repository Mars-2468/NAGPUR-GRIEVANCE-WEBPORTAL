{include file='header.tpl'}
{literal}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->

<script>
	function validateForm() {
		var description = document.add_category.description.value;

		var dept_id = $("#dept_id").val();
		if (dept_id == '0') {
			alert("Select Department Name..!");
			return false;
		}

		if (description == '') {
			alert("Please Enter Description..!");
			return false;
		}

	}

	function fill(cat_id, descriptin, dept_id) {
		document.add_category.cat_id.value = cat_id;
		document.add_category.description.value = descriptin;
		document.add_category.type.value = 1;
		$("#dept_id").val(dept_id);

	}
</script>

<script language='javascript'>
	function validateForm1() {
		var errors = 0;
		$(".int1").each(function() {

			var patt = /^\d+$/;
			var val_field = $(this).val();
			if (!val_field.match(patt)) {
				($(this)).css({
					"background-color": "pink"
				});
				errors++;
			} else {
				($(this)).css({
					"background-color": "white"
				});
			}
		});

		$(".mytext").each(function() {

			var val_field = $(this).val();
			val_field = val_field.trim();
			if (val_field == '') {
				($(this)).css({
					"background-color": "pink"
				});
				errors++;
			} else {
				($(this)).css({
					"background-color": "white"
				});
			}
		});

		$(".combo1").each(function() {

			var val_field = $(this).val();
			if (val_field == '0') {
				($(this)).css({
					"background-color": "pink"
				});
				errors++;
			} else {
				($(this)).css({
					"background-color": "white"
				});
			}
		});

		if (errors == 0) {
			return true;
		} else {
			alert("Please Enter Correct Value In High-lighted Fields - " + errors);
			return false;
		}
	}
</script>

<script>
	$(document).ready(function() {
		$(".num").keypress(function(test) {
			if (test.which != 8 && test.which != 0 && (test.which < 48 || test.which > 57)) {
				return false;
			}
		});
	});
</script>

<script>
	function validation()

	{
		n = document.contact.mobile.value;

		if (n.length != 10) {
			alert("Please Enter Valid Number..!");
			contact.mobile.value = "";
		}
	}

	function delete_rec(id) {
		var del = confirm("Are You Sure You Want To Delete This Record?");
		if (del == true) {

			$.post("delete_comm_contact.php", {
				id: id
			}, function(data) {

				$("#" + id).hide();

				$("#msg1").html(data);
			});
		} else {
			return false;
		}
	}
</script>
{/literal}
<div class="row">
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>ADD COMMISSIONER CONTACT DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form name='contact' method='POST' action='comm_contact.php' class="form-horizontal" enctype="multipart/form-data" onSubmit="return validateForm1()">
					<input type="hidden" name="token" value="{$token_id}" />
					<input type='hidden' name='previous_building_image' value="{$data[$k].officebuilding}">
					<div class="form-body">
						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}

						<div class="form-group">
							<!-- <label class="control-label col-md-3">HO/ Ward Office Name: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">HO/ Ward Office Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name="comm_name" type="text" id="comm_name" data-required="1" class="form-control" value="{$data[$k].comm_name}" placeholder="Enter HO/ Ward Office Name" autocomplete="off" required="required">
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Name Marathi: </label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Name In Marathi <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name="comm_name_marathi" type="text" id="comm_name_marathi" data-required="1" class="form-control" value="{$data[$k].comm_name_marathi}" placeholder="Enter Name In Marathi" autocomplete="off">
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Mobile Number <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name="mobile" type="text" id="mobile1" data-required="1" class="form-control int1 num" value="{$data[$k].mobile}" onblur="validation()" placeholder="Enter Mobile Number" autocomplete="off" required="required" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Designation Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name="designation" type="text" data-required="1" class="form-control" value="{$data[$k].designation}" placeholder="Enter Designation Name" autocomplete="off" required="required" />
							</div>

						</div>
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Select Department <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name="user_type" class="form-select" autocomplete="off" required="required">
									<option selected disabled>-- Select Department --</option>
									{foreach from=$departments key=des item=department}
									<option value="{$department.id}">{$department.title}</option>
									{/foreach}
								</select>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Upload Photo: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Upload Photo <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <input name="f1" type="file" id="f1" data-required="1" class="form-control" /> -->
								<input name='f1' class="form-control" id='f1' type="file" accept=".jpg,.png,.gif,.jpeg" autocomplete="off" required="required" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Previous Photo: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Previous Photo <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<img src='{if $data[$k].file_url eq ''}default-user.png{else} {$data[$k].file_url} {/if}' width="75px" height="75px" autocomplete="off" required="required">
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Email: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Email ID <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="email" id="email" name="email" data-required="1" class="form-control" value="{$data[$k].email}" placeholder="Enter Email ID" autocomplete="off" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Land Line: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Land Line <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="text" id="land_line" name="land_line" data-required="1" class="form-control" value="{$data[$k].land_line}" placeholder="Enter Land Line" autocomplete="off" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Fax: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Fax <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="text" id="fax" name="fax" data-required="1" class="form-control" value="{$data[$k].fax}" placeholder="Enter Fax" autocomplete="off" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Address: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Address <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <textarea class="form-control" name="address">{$data[$k].address}</textarea> -->
								<textarea name='address' id='address' rows="2" cols="50" data-required="1" class="form-control" placeholder="Enter Address" autocomplete="off">{$data[$k].address}</textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Address Marathi: <span class="required"> </span></label>
							<div class="col-md-8">
								<textarea class="form-control" name="address_marathi">{$data[$k].address_marathi}</textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Map Link: <span class="required"> </span></label>
							<div class="col-md-8">
								<textarea class="form-control" name="link">{$data[$k].link}</textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Office Building Photo: <span class="required">* </span></label>
							<div class="col-md-8">
								<input name="f2" type="file" id="f2" data-required="1" class="form-control" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Previous Office Building Photo: <span class="required">* </span></label>
							<div class="col-md-8">
								<img src='{if $data[$k].officebuilding eq ''}default-img.png{else} {$data[$k].officebuilding} {/if}' width="75px" height="75px">
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
							<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Create</button>
							<!-- <button type="button" class="btn btn-danger">Cancel</button> -->
							<button type="button" class="btn btn-danger" onclick="this.form.reset();">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar blue">
				<h4>Notifications</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">

					<thead>
						<tr>
							<th bgcolor="#dadada">S.No</th>
							<th bgcolor="#dadada">HO/ Ward Office Name</th>
							<th bgcolor="#dadada">Mobile</th>
							<th bgcolor="#dadada">Department</th>
							<th bgcolor="#dadada">Designation</th>
							<th bgcolor="#dadada">Previous Photo</th>
							<th bgcolor="#dadada">Email</th>

							<th bgcolor="#dadada">edit</th>
							<th bgcolor="#dadada">Delete</th>
						</tr>

					</thead>
					<tbody>

						{foreach from=$data key=k item=user}
						<tr id="{$user.id}">
							<td>{$k}</td>
							<td>{$data[$k].comm_name}</td>
							<td>{$data[$k].mobile}</td>
							<td>{$data[$k].dept}</td>
							<td>{$data[$k].designation}</td>
							<td><img src='{if $data[$k].file_url eq ''}default-user.png{else} {$data[$k].file_url} {/if}' width="75px" height="75px"></td>
							<td>{$data[$k].email}</td>
							<td>
								<a href="edit_comm_contact.php?id={$data[$k].id}" class="btn btn-success">Edit</a>
							</td>
							<td align="center">

								<button class="btn btn-danger" type="button" value="{$data[$k].id}" onclick="delete_rec(this.value);">
									<span class="fa fa-trash"></span> Delete</button>
							</td>
						</tr>
						{/foreach}


					</tbody>
				</table>
			</div>
			<span class="style1"></span>
		</div>
	</div>

</div>

{include file='footer.tpl'}
{literal}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
{/literal}