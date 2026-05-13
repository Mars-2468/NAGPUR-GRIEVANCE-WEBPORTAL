{include file='header.tpl'}
{literal}
 
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
<!--
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
<script>
	var _URL = window.URL || window.webkitURL;
	/*$(document).ready(function()
	{
	$("#img_url").change(function (e) {

	    var file, img;
	    if ((file = this.files[0])) {
	        img = new Image();
	        img.onload = function () {
	           
				if(this.width > 256 && this.height > 256)
				{
					alert('Please upload width less than 256 and height less than 256');
					$("#img_url").val('');
					return false;
				}
	        };
	        img.src = _URL.createObjectURL(file);
	    }
	});
	});*/

	function delete_rec(id) {

		//11-06-21 if(confirm('Do Your really want to delete this record'))
		if (confirm('Are You Sure You Want To Delete This Record?')) {
			$.post('ajax_del_enew_content.php', {
				id: id
			}, function(data) {
				if (data == 0) {
					alert('Unable to delete , Try again..!');
				} else if (data == 1) {
					alert('Record Deleted Successfully..!');
					window.location = 'addcontent.php';
				}
			});
		}
	}

	function validateForm() {
	
	
		var fileInput1 = $('#img_url')[0].files[0];
		
        var errorMessage1 = $('#errorMessage1');
      
      
        // Allowed file types (you can modify this based on your needs)
		
        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        var maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
		
  
        errorMessage1.text('');
       		
		if(!allowedTypes.includes(fileInput1.type)) {
            errorMessage1.text('Invalid file type. Allowed types are JPG, PNG,JPEG, and PDF.');
            return false;
        }else if(fileInput1.size > maxFileSize) {
            errorMessage1.text('File size exceeds the 2MB limit.');
            return false;
        }
	
		var errors = 0;
		$(".mytext").each(function() {
			var val_field = $(this).val();
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

		$(".combo").each(function() {
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
			alert("Please Enter Correct Value In High-Lighted Fields - " + errors);
			return false;
		}
	}
</script>

<style>
	div.pagination {
		padding: 3px;
		margin: 3px;
	}

	div.pagination a {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #AAAADD;

		text-decoration: none;
		/* no underline */
		color: #000099;
	}

	div.pagination a:hover,
	div.pagination a:active {
		border: 1px solid #000099;

		color: #000;
	}

	div.pagination span.current {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #000099;

		font-weight: bold;
		background-color: #000099;
		color: #FFF;
	}

	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;

		color: #DDD;
	}
</style>
{/literal}

<div class="row">
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<!--11-06-24 <div class="title-bar blue">
				<h4>Add Content</h4>
			</div> -->
			<div class="title-bar success">
				<h4>ADD / UPDATE CONTENT DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form method="post" name='manage_desg_del' action="manage_desg_del.php">
					<input type='hidden' name='desg_id' vlaue=''>
				</form>

				<form method="post" action="save_addcontent.php" name="manage_desg" class="form-horizontal" enctype="multipart/form-data" onSubmit="return validateForm()">
					<input type="hidden" name="token" value="{$token_id}" />
					<input type='hidden' name='desg_id' value='0'>
					<div class="form-body">

						{if $flash}
							<div class="{$flash.class}">
							<button class="close" data-close="alert"></button>
								{$flash.msg}
							</div>
						{/if}
					
						<div class="form-group">
							<!--11-06-24 <label class="control-label col-md-3">Edition: <span class="required">* </span></label>
							<div class="col-md-5"> -->
							<label class="control-label col-md-4">Select Edition <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='edition_no' id='edition_no' class="form-control combo" placeholder="Select Edition" autocomplete="off" required>
									<option value='0' selected disabled>-- Select Edition --</option>
									{html_options options=$edition_list}
								</select>
							</div>
						</div>

						<div class="form-group">
							<!--11-06-24 <label class="control-label col-md-3">Description: <span class="required">* </span></label>
							<div class="col-md-5">-->
							<label class="control-label col-md-4">Description <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<textarea name="description" id="description" rows="2" cols="50" data-required="1" class="form-control mytext" placeholder="Enter Description" data-type="sptext" onkeyup="funInputFielTypes(this)" autocomplete="off" required></textarea>
							<div style="font-size:10px;color:red;" id="descriptionX"></div>
							</div>
						</div>

						<div class="form-group">
							<!--11-06-24 <label class="control-label col-md-3">Image:</label>
							<div class="col-md-5"> -->
							<label class="control-label col-md-4">Add Image <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="file" name="img_url" id="img_url" class="form-control" accept="image/x-png, image/gif, image/jpeg" data-type="image" onchange="funInputFielTypes(this)" autocomplete="off" />
								<div style="font-size:10px;color:red;" id="img_urlX"></div>
							</div>
						</div>

						<!--11-06-24 <div class="form-actions fluid">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" class="btn btn-info" name="save" value='Add / Update Ward'>Submit</button>-->
						<!--<button type="reset" class="btn btn-danger">Cancel</button>-->
						<!--11-06-24 </div>
						</div> -->
						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name='save' value='Add / Update Content' id="submitBtn" disabled>Submit</button>
								<!--<button type="reset" class="btn btn-danger">Cancel</button>-->
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
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar white">
				<h4>EXISTING CONTENT DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius table-responsive">
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th style="text-align: center;">SR.NO</th>
							<th>EDITION NO</th>
							<th>DESCRIPTION</th>
							<th>IMAGE</th>
							<th>EDIT</td>
							<th>DELETE</th>
						</tr>
					</thead>

					<tbody>

						{foreach from=$data item=row key=id}
						<tr>
							<td>{counter}</td>
							<td>{$edition_list[$row.edition_no]}</td>
							<td>{$row.description}</td>
							<td><img src="{$row.img_url}" width="75px" height="75px"> </td>
							<td>
								<a href="update-enew-content.php?id={$id}" class="btn btn-success"> Update </a>
							</td>
							<td>
								{if !isset($row.num_emp)}
								<input type='button' onclick="delete_rec('{$id}')" value="Delete" class="btn btn-danger">
								{/if}
							</td>
						</tr>
						{/foreach}


					</tbody>
				</table>
			</div>
		</div>
	</div>







	<center>
		<div id="pagination" class="pagination" align="center">{$pagination}</div>
	</center>

	{include file='footer_print.tpl'}

	{include file='footer.tpl'}