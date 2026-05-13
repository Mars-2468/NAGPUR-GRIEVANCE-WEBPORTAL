{include file='header.tpl'}
{literal}
 
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
	function validateForm() {
		var errors = 0;

		$(".text").each(function() {

			var date = $(".text").val();

			if (date == '') {
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

	function delete_rec(id, edition_no) {

		var del = confirm("Are You Sure You Want To Delete This Record?");
		if (del == true) {

			$.post("ajax_delete_edition.php", {
				id: id,
				edition_no: edition_no
			}, function(data) {

				if (data == 0) {
					alert('Content Is Added With This Edition Number, First You Need To Delete Content, Then Only You Can Delete This Record..!');
					return false;
				} else if (data == 1) {

					alert('Record Deleted Successfully..!');
					window.location = 'add-edition.php';
				} else if (data == 2) {
					alert('Unable to delete, Try again..!');
					return false;
				}
			});
		}
	}

	function edite_rec(id, edition_date, edition_no, edition_no_marathi) {
		$("#id").val(id);
		$("#update_status").val('1');
		$("#datepicker").val(edition_date);
		$("#edition_no").val(edition_no);
		$("#edition_no_marathi").val(edition_no_marathi);
	}

	$(document).ready(function() {
		$(".datepick").datepicker({
			maxDate: +2000,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true
		});
	});
</script>
{/literal}


<div class="row">
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>ADD / UPDATE EDITION DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form name='add_edition' method='POST' action='add-edition.php' class="form-horizontal" onSubmit="return validateForm()">
					<input type="hidden" name="token" value="{$token_id}" />

					<input type='hidden' name='id' id="id">
					<input type='hidden' name='update_status' id="update_status" value="0">
					<div class="form-body">
						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Select Date: :<span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Select Date <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='edition_date' id="edition_date" type="text" data-required="1" class="form-control datepicker mytext" data-type="date" onkeyup="funInputFielTypes(this)" placeholder="Select Date" autocomplete="off" required="required" />
								<div style="font-size:10px;color:red;" id="edition_dateX"></div>
							</div>
						</div>

						<div class="form-group">
							<!-- <label class="control-label col-md-3">Edition :<span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Edition Name <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="text" name="edition_no" id="edition_no" class="form-control mytext" placeholder="Enter Edition Name" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required">
								<div style="font-size:10px;color:red;" id="edition_noX"></div>
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-md-3">Edition Marathi :<span class="required">* </span></label>
							<div class="col-md-8"> -->
							<label class="control-label col-md-4">Edition In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input type="text" name="edition_no_marathi" id="edition_no_marathi" class="form-control mytext" placeholder="Enter Edition In Marathi" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off" required="required">
							<div style="font-size:10px;color:red;" id="edition_no_marathiX"></div>
							</div>
						</div>

						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name='save' id="submitBtn" disabled>Submit</button>
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


<div class="row" id="div_print">
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar white">
				<h4>EXISTING EDITIONS DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius table-responsive">
				<!-- <table class="table table-striped table-bordered table-hover table-full-width" id="data-table"> -->
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th style="text-align: center;">SR.NO</th>
							<th style="text-align: center;">DATE</th>
							<th style="text-align: center;">EDITION NAME</th>
							<th class="noExport" style="text-align: center;">EDIT</th>
							<th class="noExport" style="text-align: center;">DELETE</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$edition_list item=row key=id}
						<tr id="{$row.id}" align="center">
							<td>{counter}</td>
							<td>{$row.edition_date|date_format:"%d-%m-%Y"}</td>
							<td>{$row.edition_no}</td>
							<!-- <td class="noExport"><input type='button' class="btn btn-warning" value="Edit" onclick="edite_rec('{$id}','{$row.edition_date}','{$row.edition_no}','{$row.edition_no_marathi}')"></td> -->
							<td class="noExport"><input type='button' class="btn btn-success" value="Edit" onclick="edite_rec('{$id}','{$row.edition_date}','{$row.edition_no}','{$row.edition_no_marathi}')"></td>
							<td class="noExport"><input type='button' value="Delete" class="btn btn-danger" onclick="delete_rec('{$id}','{$row.edition_no}')"></td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>

	{include file='footer_print.tpl'}

	{include file='footer.tpl'}
	{literal}
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
	<script>
		$(function() {
			$("#edition_date").datepicker({
				changeMonth: true,
				changeYear: true,
				  dateFormat: 'yy-mm-dd', 
				maxDate: 0
			});
		});
	</script>
	{/literal}