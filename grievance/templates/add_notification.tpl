{include file='header.tpl'}
{literal}

<script>
	function validateForm() {
	
		var errorMessaged = $('#errorMessaged');
            
        errorMessaged.text('');
		var date1 = $("#datepicker").val();		  
		 
		if(!isValidDateWithDayValidation(date1)){
			errorMessaged.text('Invalid date type. Allowed date type is yyyy-mm-dd only.');
			return false;
		}
		
	
		description = $("#description").val();
		
		var fileInput = $('#photo')[0].files[0];
        var errorMessage = $('#errorMessage');
        
        // Allowed file types (you can modify this based on your needs)
        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        var maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

        // Clear previous error and preview
        errorMessage.text('');
       		
		if (description == '') {
			alert("Please Enter Description..!");
			return false;
		}else if(!allowedTypes.includes(fileInput.type)) {
            errorMessage.text('Invalid file type. Allowed types are JPG, PNG,JPEG, and PDF.');
            return false;
        }else if(fileInput.size > maxFileSize) {
            errorMessage.text('File size exceeds the 2MB limit.');
            return false;
        } else {
			return true;
		}
		
	
		
		/* if (description == '') {
			alert("Please Enter Description..!");
			return false;
		} else {
			return true;
		} */
	}
	
	function isValidDateWithDayValidation(dateString) {
    // The date regex for YYYY-MM-DD
    var regex = /^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
    
    if (!regex.test(dateString)) {
        return false; // If it doesn't match the basic format
    }

    // Extract year, month, and day from the date string
    var parts = dateString.split('-');
    var year = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10) - 1; // Month is zero-indexed in JavaScript
    var day = parseInt(parts[2], 10);

    // Check if the date is valid using the Date object
    var date = new Date(year, month, day);

    // Return true if the day, month, and year match, else false
    return date.getFullYear() === year && date.getMonth() === month && date.getDate() === day;
}


	function fill(cat_id, descriptin, dept_id) {

		document.add_category.cat_id.value = cat_id;
		document.add_category.description.value = descriptin;
		document.add_category.type.value = 1;
		$("#dept_id").val(dept_id);

	}
</script>

<script>
	function delete_rec(id) {
		var del = confirm("Are You Sure You Want To Delete This Record?");
		if (del == true) {

			$.post("delete_notification.php", {
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
				<h4>ADD NOTIFICATION DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form name='' method='POST' action='save_add_notification.php' class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="token" value="{$token_id}" />
					<div class="form-body">
					{if $flash}
						<div class="{$flash.class}">
						<button class="close" data-close="alert"></button>
							{$flash.msg}
						</div>
					{/if}

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Select Date: <span class="required">* </span></label>
							<div class="col-md-3"> -->
							<label class="control-label col-md-4">Select Date <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='date' id="date" type="text" data-required="1" class="form-control datepicker" placeholder="Select Date"  required="required" data-type="date" onkeyup="funInputFielTypes(this)" autocomplete="off" />
								<div style="font-size:10px;color:red;" id="dateX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Title: <span class="required">* </span></label>
							<div class="col-md-6"> -->
							<label class="control-label col-md-4">Title <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='title' id="title" type="text" data-required="1" class="form-control" placeholder="Enter Title" required="required" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off" />
								<div style="font-size:10px;color:red;" id="titleX"></div>
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-md-2">Title Marathi: <span class="required">* </span></label>
							<div class="col-md-6"> -->
							<label class="control-label col-md-4">Title Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='title_marathi' id="title_marathi" type="text" data-required="1" class="form-control" placeholder="Enter Title Marathi" required="required" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off" />
								<div style="font-size:10px;color:red;" id="title_marathiX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Description: <span class="required">* </span></label>
							<div class="col-md-9"> -->
							<label class="control-label col-md-4">Description <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <textarea class="wysihtml5 form-control " rows="10" name="description" id="description" required="required" autocomplete="off"></textarea> -->
								<textarea name='description' id='description' rows="2" cols="50" data-required="1" class="form-control" placeholder="Enter Description" autocomplete="off" data-type="sptext" onkeyup="funInputFielTypes(this)" required="required"></textarea>
								<div style="font-size:10px;color:red;" id="descriptionX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Description Marathi: <span class="required">* </span></label>
							<div class="col-md-9"> -->
							<label class="control-label col-md-4">Description Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <textarea class="wysihtml5 form-control" rows="10" name="description_marathi" id="description_marathi" required="required" autocomplete="off"></textarea> -->
								<textarea name='description_marathi' id='description_marathi' rows="2" cols="50" data-required="1" class="form-control" placeholder="Enter Description Mararthi" autocomplete="off" data-type="sptext" onkeyup="funInputFielTypes(this)" required="required"></textarea>
								<div style="font-size:10px;color:red;" id="description_marathiX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Photo: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Add Image <span class="required" style="color:red">  </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="file" name="photo" id="photo" class="form-control" accept=".jpg,.jpeg,.png,.gif" autocomplete="off" data-type="images" onchange="funInputFielTypes(this)" />
								<div style="font-size:10px;color:red;" id="photoX"></div>
							</div>
						</div>
					</div>

					<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
							<input type="submit" class="btn btn-info" id="submitBtn" name='save' value='Submit' disabled>
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


<div style="border:#999999 0px solid;">
	<div class="row">
		<div class="col-lg-12">
			<div class="boxed">
				<!-- Title Bart Start -->
				<div class="title-bar white">
					<h4>EXISTING NOTIFICATION DETAILS</h4>
				</div>
				<!-- Title Bart End -->
				<div class="inner no-radius table-responsive" id="div_print">
					<!-- <table class="table table-striped table-bordered table-hover table-full-width" id="data-table"> -->
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
						<thead>
							<tr style="background-color:#2c3e50; color:#FFF;">
								<!-- <th bgcolor="#dadada">SR.NO</th>
								<th bgcolor="#dadada">Date</th>
								<th bgcolor="#dadada">Image</th>
								<th bgcolor="#dadada">Title</th>
								<th bgcolor="#dadada">Title Marathi</th>
								<th bgcolor="#dadada">Description</th>
								<th bgcolor="#dadada">Description Marathi</th>-->
								<!--<th bgcolor="#dadada">Notification</th>-->
								<!--<th bgcolor="#dadada">Update</th>
								<th bgcolor="#dadada">Delete</th> -->

								<th style="text-align: center;">SR.NO</th>
								<th style="text-align: center;">DATE</th>
								<th style="text-align: center;">IMAGE</th>
								<th style="text-align: center;">TITLE</th>
								<th style="text-align: center;">TITLE MARATHI</th>
								<th style="text-align: center;">DESCRIPTION</th>
								<th style="text-align: center;">DESCRIPTION MARATHI</th>
								<!--<th>Notification</th>-->
								<th class="noExport" style="text-align: center;">UPDATE</th>
								<!-- <th>DELETE</th> -->
								<th class="noExport" style="text-align: center;">
									<font color='white'>DELETE</font>
								</th>
							</tr>
						</thead>
						<tbody>
							{foreach from=$doc_list item=row key=id}
								<tr id="{$row.id}" align="center">
									<td>{counter}</td>
									<td>{$row.date}</td>
									<td>
										<img src="{if $row.photo eq ''}default-img.png{else} {$row.photo} {/if}" width="70px" height="70px">
									</td>
									<td>{$row.title}</td>
									<td>{$row.title_marathi}</td>
									<td>{$row.description}</td>
									<td>{$row.description_marathi}</td>
									<!--<td><a href="{$row.photo}" target="_blank">{$row.photo}</a></td>-->
									<td class="noExport">
										<a href="update_notification.php?id={$id}" class="btn btn-success">Edit</a>
									</td>
									<td class="noExport">
										<!--  <input type='radio' name='id' id='id'  value="{$row.id}" > -->
										<button class="btn btn-danger" name='id' id='id' value="{$row.id}" onclick="delete_rec(this.value);">
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


{include file='footer_print.tpl'}

{include file='footer.tpl'}