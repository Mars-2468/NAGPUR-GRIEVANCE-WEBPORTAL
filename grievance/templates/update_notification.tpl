{include file='header.tpl'}
{literal}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->

<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<!--  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
   <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">-->


<link rel="stylesheet" type="text/css" href="css/styles.css"><!-- Tempalet Skeleton CSS -->
<link rel="stylesheet" type="text/css" href="assets/editors/wysihtml5/bootstrap-wysihtml5.css" /><!-- wysihtml5 css -->
<!--<link rel="stylesheet" type="text/css" href="assets/editors/summernote/summernote.css"/><!-- summernote css -->



<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">



<!--<script>
$(document).ready(function()
{
$("#datepicker").datepicker("option","maxDate",0});
	$('#datepicker').on('changeDate', function(ev){
    $(this).datepicker('hide');
});
});
</script>-->

<script>
	function validateForm() {
	
	
	 var fileInput = $('#photo')[0].files[0];
        var errorMessage = $('#errorMessage');
        
        // Allowed file types (you can modify this based on your needs)
        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        var maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

        // Clear previous error and preview
        errorMessage.text('');
       
//alert(fileInput.size );
        // Check if a file is selected
        //if (!fileInput) {
         //   errorMessage.text('Please select a file.');
         //   return;
        //}
	
		description = $("#description").val();
		if (description == '') {
			alert("Please Enter Description..!");
			return false;
		}else if(!allowedTypes.includes(fileInput.type)) {
            errorMessage.text('Invalid file type. Allowed types are JPG, PNG, GIF, PDF, DOCX.');
            return false;
        }else if(fileInput.size > maxFileSize) {
            errorMessage.text('File size exceeds the 2MB limit.');
            return false;
        } else {
			return true;
		}
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
				<h4>UPDATE NOTIFICATION DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius table">
				<form name='' method='POST' action='save_update_notification.php' class="form-horizontal" onSubmit="return validateForm()" enctype="multipart/form-data">
					<input type="hidden" name="token" value="{$token_id}" />
					<input type='hidden' name='previous_image' value='{$data.photo}'>
					<input type='hidden' name='id' value='{$data.id}'>
					<div class="form-body">
						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Select Date: <span class="required">* </span></label>
							<div class="col-md-3"> -->
							<label class="control-label col-md-4">Select Date <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">	
								<input name='date' id="datepicker" type="text" data-required="1" class="form-control" value="{$data.date}" placeholder="Select Date" required="required" autocomplete="off" />
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Title: <span class="required">* </span></label>
							<div class="col-md-9"> -->
							<label class="control-label col-md-4">Title <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input class="wysihtml5 form-control" name="title" id="description" value="{$data.title}" placeholder="Enter Title" required="required" autocomplete="off">
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Title Marathi: <span class="required">* </span></label>
							<div class="col-md-9"> -->
							<label class="control-label col-md-4">Title Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input class="wysihtml5 form-control" name="title_marathi" id="title_marathi" value="{$data.title_marathi}" placeholder="Enter Title Marathi" required="required" autocomplete="off">
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Description: <span class="required">* </span></label>
							<div class="col-md-9"> -->
							<label class="control-label col-md-4">Description <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <textarea class="wysihtml5 form-control" rows="10" name="description" id="description" value="" required>{$data.description}</textarea> -->
								<textarea name='description' id='description' rows="2" cols="50" data-required="1" class="wysihtml5 form-control" placeholder="Enter Description" autocomplete="off" required="required">{$data.description}</textarea>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Description Marathi: <span class="required">* </span></label>
							<div class="col-md-9"> -->
							<label class="control-label col-md-4">Description Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<!-- <textarea class="wysihtml5 form-control" rows="10" name="description_marathi" id="description_marathi" value="" required>{$data.description_marathi}</textarea> -->
								<textarea name='description_marathi' id='description_marathi' rows="2" cols="50" data-required="1" class="wysihtml5 form-control" placeholder="Enter Description Mararthi" autocomplete="off" required="required">{$data.description_marathi}</textarea>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Photo: <span class="required"> </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Add Image <span class="required" style="color:red">  </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='photo' id='photo' class="form-control" type="file" accept=".jpg,.png,.gif,.jpeg" />
								<span id="errorMessage" class="error text-danger"></span>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-2">Previous Image: </label>
							<div class="col-md-5"> -->
							<label class="control-label col-md-4">Previous Image <span class="required" style="color:red">  </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<img src="{$data.photo}" width="75px" height="75px">
							</div>
						</div>
					</div>

					<div class="form-actions fluid">
						<!-- <div class="col-md-offset-3 col-md-9"> -->
						<div class="text-center">
							<input type="submit" class="btn btn-info" id="upload" name='save' value='Update'>
							<a href="add_notification.php"><button type="button" class="btn btn-danger">Back</button></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>



{include file='footer.tpl'}

{literal}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
<script>
	$(function() {
		$("#datepicker").datepicker({
			changeMonth: true,
			changeYear: true,
			maxDate: 0
		});
	});
</script>
<script src="assets/editors/wysihtml5/wysihtml5-0.3.0.js"></script><!-- wysihtml5 JS -->
<script src="assets/editors/wysihtml5/bootstrap-wysihtml5.js"></script><!-- wysihtml5 JS -->
<script src="assets/editors/summernote/summernote.js"></script><!-- summernote JS -->
<script src="assets/editors/ckeditor/ckeditor.js"></script><!-- Summernote js -->
<script src="js/page/editors.js"></script><!-- EDITOR PAGE JS -->
{/literal}