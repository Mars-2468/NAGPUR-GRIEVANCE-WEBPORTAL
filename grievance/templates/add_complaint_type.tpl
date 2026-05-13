{include file='header.tpl'}
{literal}
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<script> 
	function validateForm() {
		var errors = 0;

		var cs_desc = document.add_complaint_type.cs_desc.value;
		var telugu_description = document.add_complaint_type.telugu_description.value;
		var cat_id = document.add_complaint_type.cat_id.value;
		var sub_cat_id = document.add_complaint_type.sub_cat_id.value;
		if (cat_id == 0) {
			alert('Please Select Category..!');
			return false;
		}

		if (sub_cat_id == 0) {
			alert('Please Select Sub Category..!');
			return false;
		}


		if (cs_desc == '') {
			alert('Enter Complaint Type..!');
			return false;
		}

		if (telugu_description == '') {
			alert('Enter Complaint Type in Marathi..!');
			return false;
		}


	}

	function delete_rec(doc_id) {
		// var del = confirm("Are You Sure You Want To Delete This Record?");
		// if (del == true) {

		// 	$.post("delete_doc.php", {
		// 		doc_id: id
		// 	}, function(data) {
		// 		$("#" + id).hide();

		// 		$("#msg1").html(data);
		// 	});
		// } else {
		// 	return false;
		// }

		if (confirm('Do You Really Want To Delete This Record?')) {
			var csrf_token = $("#csrf_token").val();
			$.post('delete_doc.php', {
				doc_id: doc_id,
				csrf_token: csrf_token
			}, function(data) {
				//alert(data);
				if (data == 1) {
					alert('Document Deleted Successfully..!');
					window.location = 'add_document.php';
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


	function get_category(cat_id) {
		var select = document.getElementById("sub_cat_id");
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
		xmlhttp.open("GET", "get_subcategories.php?cat_id=" + cat_id, true);
		xmlhttp.send();

	}
</script>

<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('http://municipalservices.in/add_document.php #ref', function() {
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
				<h4>ADD COMPLAINT TYPE DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form name='add_complaint_type' method='POST' action='save_add_complaint_type.php' class="form-horizontal" onSubmit="return validateForm()">
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
						{if isset($smarty.session.msg)}
						<div class="{$smarty.session.class}">
							<button class="close" data-close="alert"></button>
							{$smarty.session.msg}
						</div>
						{/if}
						<div class="form-group">
							<!--old 26-04-24 <label class="control-label col-md-3">Category: <span class="required">* </span></label>
							<div class="col-md-8">-->
							<label class="control-label col-md-4">Select Category <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='cat_id' id='cat_id' onchange="get_category(this.value);" class="form-control" required="required" autocomplete="off">
									<option value='0'>--Select Category--</option>
									{html_options options=$category_list}
								</select>
							</div>
						</div>
						<div class="form-group">
							<!--old 26-04-24 <label class="control-label col-md-3">Sub Category: <span class="required">* </span></label>
							<div class="col-md-8">-->
							<label class="control-label col-md-4">Select Sub Category <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='sub_cat_id' id='sub_cat_id' class="form-control" required="required" autocomplete="off">
									<option value='0'>-- Select Sub Category --</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<!--old 26-04-24 <label class="control-label col-md-3">Complaint Type :<span class="required">* </span></label>
							<div class="col-md-8">-->
							<label class="control-label col-md-4">Complaint Type <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='cs_desc' id='cs_desc' type="text" data-required="1" class="form-control" placeholder="Enter Complaint Type" autocomplete="off" data-type="text" onkeyup="funInputFielTypes(this)" required="required" />
								<div style="font-size:10px;color:red;" id="cs_descX"></div>
							</div>
						</div>
						<div class="form-group">
							<!--old 26-04-24 <label class="control-label col-md-3">Complaint Type in Marathi :<span class="required">* </span></label>
							<div class="col-md-8">-->
							<label class="control-label col-md-4">Complaint Type In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='telugu_description' id='telugu_description' type="text" data-required="1" class="form-control" placeholder="Enter Complaint Type In Marathi" autocomplete="off" data-type="text" onkeyup="funInputFielTypes(this)" required="required" />
								<div style="font-size:10px;color:red;" id="telugu_descriptionX"></div>
							</div>
						</div>
						<div class="form-group">
							<!--old 26-04-24 <label class="control-label col-md-3">Level 1 SLA Days<span class="required">* </span></label>
							<div class="col-md-8">-->
							<label class="control-label col-md-4">Level 1 SLA Days <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='level_1' id='level_1' type="text" data-required="1" class="form-control" placeholder="Enter Level 1 SLA Days" autocomplete="off"  data-type="dnumber" onkeyup="funInputFielTypes(this)" required="required" />
								<div style="font-size:10px;color:red;" id="level_1X"></div>
							</div>
						</div>
						<div class="form-group">
							<!--old 26-04-24 <label class="control-label col-md-3">Level 2 SLA Days<span class="required">* </span></label>
							<div class="col-md-8">-->
							<label class="control-label col-md-4">Level 2 SLA Days <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='level_2' id='level_2' type="text" data-required="1" class="form-control" placeholder="Enter Level 2 SLA Days" autocomplete="off"  data-type="dnumber" onkeyup="funInputFielTypes(this)"  required="required" />
								<div style="font-size:10px;color:red;" id="level_2X"></div>
							</div>
						</div>

						<div class="form-group">
							<!--old 26-04-24 <label class="control-label col-md-3">Level 3 SLA Days<span class="required">* </span></label>
							<div class="col-md-8">-->
							<label class="control-label col-md-4">Level 3 SLA Days <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='level_3' id='level_3' type="text" data-required="1" class="form-control" placeholder="Enter Level 2 SLA Days" autocomplete="off"  data-type="dnumber" onkeyup="funInputFielTypes(this)"  required="required" />
								<div style="font-size:10px;color:red;" id="level_3X"></div>
							</div>
						</div>

						<!--old 26-04-24 <div class="form-actions fluid">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" class="btn btn-info" name='save' id="submitBtn" disabled>Submit</button>
							</div>
						</div> -->
						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
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




<div class="row" id="div_print">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar white">
				<h4>EXISTING COMPLAINT TYPES DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius table-responsive">
				<!-- <form action="" method="post"> -->
				<!--old 26-04-24 <table class="table table-striped table-bordered table-hover table-full-width"> -->
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th style="text-align: center;">SR.NO</th>
							<th style="text-align: center;">COMPLAINT NAME</th>
							<th style="text-align: center;">MARATHI COMPLAINT</th>
							<th class="noExport" style="text-align: center;">ACTION</th>
						</tr>
					</thead>

					<tbody>

						{foreach from=$doc_list item=row key=doc_id}
						<tr id="{$row.doc_id}">
							<td style="text-align: center;">{counter}</td>
							<td style="text-align: center;">{$row.cs_desc}</td>
							<!--10-06-2024 <td align="center">-->
							<td align="left">
								{$marathi_list[$doc_id]['telugu_description']}
								<!--10-06-2024 <input type="text" name="comp_marathi[]" value="{$marathi_list[$doc_id]['telugu_description']}"> -->
								<input type="hidden" name="cs_ids[]" value="{$doc_id}">
							</td>
							<td class="noExport" style="text-align: center;">
								<form action="update_complaint_type.php" method="post">
									<input type="hidden" name="csrf_token" value="{$csrf_token}" />
									<input type="hidden" name="cs_id" value="{$row.cs_id}">
									<input type="submit" class="btn btn-success" name="update" value="Edit">
								</form>
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
				<!--<input type="submit" class="btn btn-success" name="update" value="Update">
				</form>-->
			</div>
		</div>
	</div>
</div>

<!-- <br> -->
{include file='footer_print.tpl'}

{include file='footer.tpl'}