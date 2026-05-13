{include file='header.tpl'}
{literal} 

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
	
	var fileInput1 = $('#f1')[0].files[0];
		var fileInput2 = $('#f2')[0].files[0];
		
        var errorMessage1 = $('#errorMessage1');
        var errorMessage2 = $('#errorMessage2');
        var mb = $('#mobile1').val();
        var regx = '/^[6-9]\d{9}$/' ;
        // Allowed file types (you can modify this based on your needs)
		
        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        var maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
		
    //alert(allowedTypes.includes(fileInput1.type));
	
        // Clear previous error and preview
        errorMessage1.text('');
        errorMessage2.text('');
       		
		if(!allowedTypes.includes(fileInput1.type)) {
            errorMessage1.text('Invalid file type. Allowed types are JPG, PNG,JPEG, and PDF.');
            return false;
        }else if(fileInput1.size > maxFileSize) {
            errorMessage1.text('File size exceeds the 2MB limit.');
            return false;
        } else if(!allowedTypes.includes(fileInput2.type)) {
            errorMessage2.text('Invalid file type. Allowed types are JPG, PNG,JPEG, and PDF.');
            return false;
        }else if(fileInput2.size > maxFileSize) {
            errorMessage2.text('File size exceeds the 2MB limit.');
            return false;
        }else if(regx.test(mb)){
		errorMessage3.text('Mobile number not valid.');
            return false;
		}
	
	
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
	/* function validation()

	{
		n = document.contact.mobile.value;

		if (n.length != 10) {
			alert("Please Enter Valid Number......!");
			contact.mobile.value = "";
		}
	} */

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
				<form name='contact' method='POST' action='save_comm_contact.php' class="form-horizontal" enctype="multipart/form-data" >
					<input type="hidden" name="token" value="{$token_id}" />
					<input type='hidden' name='previous_building_image' value="{$data[$k].officebuilding}">
					<div class="form-body">
						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}
												
						{if $flash}
							<div class="{$flash.class}">
							<button class="close" data-close="alert"></button>
								{$flash.msg}
							</div>
						{/if}

						<div class="form-group">
							<!-- <label class="control-label col-md-3">HO/ Ward Office Name: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">HO/ Ward Office Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name="comm_name" type="text" id="comm_name" data-required="1" class="form-control" value="{$data[$k].comm_name}" placeholder="Enter HO/ Ward Office Name" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required">
								<div style="font-size:10px;color:red;" id="comm_nameX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Name Marathi: </label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Name In Marathi <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name="comm_name_marathi" type="text" id="comm_name_marathi" data-required="1" class="form-control" value="{$data[$k].comm_name_marathi}" data-type="text" onkeyup="funInputFielTypes(this)" placeholder="Enter Name In Marathi" autocomplete="off">
								<div style="font-size:10px;color:red;" id="comm_name_marathiX"></div>
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Mobile Number <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name="mobile" type="text" id="mobile" minlength="10" maxlength="10" data-required="1" class="form-control int1 num" value="{$data[$k].mobile}" onblur="validation()" placeholder="Enter Mobile Number" data-type="mobile" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required" />
							<div style="font-size:10px;color:red;" id="mobileX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Select Department <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name="user_type" class="form-control" autocomplete="off" required="required">
									<option selected disabled>-- Select Department --</option>
									{foreach from=$departments key=des item=department}
									<option value="{$department.id}">{$department.title}</option>
									{/foreach}
								</select>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Designation Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name="designation" id="designation" type="text" data-required="1" class="form-control" value="{$data[$k].designation}" placeholder="Enter Designation Name" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required" />
								<div style="font-size:10px;color:red;" id="designationX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Upload Photo: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Upload Photo <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <input name="f1" type="file" id="f1" data-required="1" class="form-control" /> -->
								<input name='f1' class="form-control" id='f1' type="file" autocomplete="off" data-type="image" onchange="funInputFielTypes(this)" required="required" />
							<div style="font-size:10px;color:red;" id="f1X"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Previous Photo: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Previous Photo <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<img id="img1Preview"  src='{if $data[$k].file_url eq ''}default-user.png{else} {$data[$k].file_url} {/if}' width="75px" height="75px" autocomplete="off" required="required">
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Email: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Email ID <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="email" id="email" name="email" data-required="1" class="form-control" value="{$data[$k].email}" data-type="email" onkeyup="funInputFielTypes(this)" placeholder="Enter Email ID" autocomplete="off" />
								<div style="font-size:10px;color:red;" id="emailX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Land Line: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Land Line <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="text" id="land_line" name="land_line" data-required="1" class="form-control" value="{$data[$k].land_line}" data-type="landline" onkeyup="funInputFielTypes(this)" placeholder="Enter Land Line" autocomplete="off" />
								<div style="font-size:10px;color:red;" id="land_lineX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Fax: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Fax <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="text" id="fax" name="fax" data-required="1" class="form-control" value="{$data[$k].fax}" data-type="fax" onkeyup="funInputFielTypes(this)" placeholder="Enter Fax" autocomplete="off" />
								<div style="font-size:10px;color:red;" id="faxX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Address: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Address <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <textarea class="form-control" name="address">{$data[$k].address}</textarea> -->
								<textarea name='address' id='address' rows="2" cols="50" data-required="1" class="form-control" placeholder="Enter Address" autocomplete="off" data-type="address" onkeyup="funInputFielTypes(this)">{$data[$k].address}</textarea>
								<div style="font-size:10px;color:red;" id="addressX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Address Marathi: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Address In Marathi <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <textarea class="form-control" name="address_marathi">{$data[$k].address_marathi}</textarea> -->
								<textarea name='address_marathi' id='address_marathi' rows="2" cols="50" data-required="1" class="form-control" placeholder="Enter Address In Marathi" autocomplete="off" data-type="address" onkeyup="funInputFielTypes(this)">{$data[$k].address_marathi}</textarea>
								<div style="font-size:10px;color:red;" id="address_marathiX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Map Link: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Map Link <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <textarea class="form-control" name="link">{$data[$k].link}</textarea> -->
								<input name='link' id='link' data-required="1" class="form-control" placeholder="Enter Map Link" value="{$data[$k].link}" data-type="url" onkeyup="funInputFielTypes(this)" autocomplete="off">
								<div style="font-size:10px;color:red;" id="linkX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Office Building Photo: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Office Building Photo <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <input name="f2" type="file" id="f2" data-required="1" class="form-control" /> -->
								<input name='f2' class="form-control" id='f2' type="file" autocomplete="off" data-type="image" onchange="funInputFielTypes(this)" required="required" />
								<div style="font-size:10px;color:red;" id="f2X"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Previous Office Building Photo: <span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Previous Office Building Photo <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<img id="img2Preview" src='{if $data[$k].officebuilding eq ''}default-img.png{else} {$data[$k].officebuilding} {/if}' width="75px" height="75px" autocomplete="off" required="required">
							</div>
						</div>
					</div>

					<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
							<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward' id="submitBtn" disabled>Create</button>
							<!-- <button type="reset" class="btn btn-danger">Cancel</button> -->
							<button type="button" class="btn btn-danger" onclick="this.form.reset();">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>


<div id="div_print" style="border:#999999 0px solid;">
	<div class="row">
		<div class="col-lg-12">
			<div class="boxed">
				<!-- Title Bart Start -->
				<div class="title-bar white">
					<h4>EXISTING COMMISSIONER CONTACT DETAILS</h4>
				</div>
				<!-- Title Bart End -->
				<div class="inner no-radius table-responsive">
					<!-- <table class="table table-striped table-bordered table-hover table-full-width" id="data-table"> -->
					<table class="table table-striped table-bordered table-hover table-full-width" id="customTable" width="100%">
						<thead>
							<tr style="background-color:#2c3e50; color:#FFF;">
								<th style="text-align: center; color:white;">SR.NO</th>
								<th style="text-align: center; color:white;">HO/ WARD OFFICE NAME</th>
								<th style="text-align: center; color:white;">MOBILE NO</th>
								<th style="text-align: center; color:white;">DEPARTMENT</th>
								<th style="text-align: center; color:white;">DESIGNATION</th>
								<th style="text-align: center; color:white;">Previous Photo</th>
								<th style="text-align: center; color:white;">EMAIL ID</th>
								<!--<th>Notification</th>-->
								<th class="noExport" style="text-align: center; color:white;">EDIT</th>
								<th class="noExport" style="text-align: center; color:white;">PRIORITY</th>
								<!-- <th>DELETE</th> -->
								<th class="noExport" style="text-align: center;">
									<font color='white'>DELETE</font>
								</th>
							</tr>
						</thead>
						<tbody>

							{foreach from=$data key=k item=user}
							<tr id="{$user.id}" align="center">

								<td>{counter}</td>
								<td>{$data[$k].comm_name}</td>
								<td>{$data[$k].mobile}</td>
								<td>{$data[$k].dept}</td>
								<td>{$data[$k].designation}</td>
								<td><img src='{if $data[$k].file_url eq ''}default-user.png{else} {$data[$k].file_url} {/if}' width="75px" height="75px"></td>
								<td>{$data[$k].email}</td>
								<!--<td><a href="{$row.photo}" target="_blank">{$row.photo}</a></td>-->
								<td class="noExport">
									<a href="edit_comm_contact.php?id={$data[$k].id}" class="btn btn-success">Edit</a>
								</td>	
								<td class="noExport">
									{$data[$k].sortorder}
								</td>
								<td class="noExport">
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
</div>

{include file='footer_cust_fields_print.tpl'}

{include file='footer.tpl'}
{literal}


<script>
document.getElementById('f1').addEventListener('change', function() {
    let input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let preview = document.getElementById('img1Preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
});
document.getElementById('f2').addEventListener('change', function() {
    let input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let preview = document.getElementById('img2Preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
});
</script>
<script>
    
	 document.getElementById("exportBtn").addEventListener("click", function () {
        // Get the table and specify the columns to export (0-based index)
        const table = document.getElementById("customTable");
        const selectedColumns = [0,1, 2,3,4,6]; // Export "Name", "Email", and "City"

        // Extract data for the selected columns
        const rows = [];
        for (let i = 0; i < table.rows.length; i++) {
            const row = [];
            selectedColumns.forEach((colIndex) => {
                row.push(table.rows[i].cells[colIndex].innerText);
            });
            rows.push(row);
        }

        // Create a workbook and worksheet
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(rows);

        // Auto-adjust column widths
        const colWidths = rows[0].map((_, colIndex) => {
            const maxWidth = rows.reduce((max, row) => Math.max(max, row[colIndex].length), 0);
            return { wch: maxWidth + 2 }; // Add padding
        });
        worksheet["!cols"] = colWidths;

        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "CommissionerContactsTable");

        // Export to Excel
        XLSX.writeFile(workbook, "CommissionerContactsTable.xlsx");
    });
	
</script>

{/literal}