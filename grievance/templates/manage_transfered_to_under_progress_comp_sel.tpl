{include file='header.tpl'}
{literal}
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	textarea {

		resize: none;

	}

	div.grievance_image img {
		height: 120px;
		object-fit: contain;
		overflow: hidden;
	}
	   /* Styles for the thumbnail */
	.thumbnail {
		width: 30%;           
		object-fit: cover;
		border: 1px solid #ccc;
		margin: 0px;
	}
</style>

<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script language="javascript">
	function get_det1(desg_id) {
		var select1 = document.getElementById("emp_id");
		select1.options.length = 0;

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
					select1.options[select1.options.length] = new Option(optArray[1], optArray[0]);
				}
			}
		}

		xmlhttp.open("GET", "get_emps.php?desg_id=" + desg_id, true);
		xmlhttp.send();

	}

	function get_det(dept_id) {
		var select = document.getElementById("emp_desg");
		var select1 = document.getElementById("emp_id");
		select.options.length = 0;
		select1.options.length = 0;

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
				select1.options[select1.options.length] = new Option('Select Employee', '0');
			}
		}

		xmlhttp.open("GET", "get_designations.php?dept_id=" + dept_id, true);
		xmlhttp.send();

	}

	function validateForm() {

		var disposed_date = document.update_comp.disposed_date.value;
		var disposal_status_value = $("#disposal_status").val();
		var cat3_id = $("#cat3_id").val();
		var fileToUpload = $('#fileToUpload').val();
		var arr = [105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128];

		$('.req_msg').remove();
		let req_err_cnt = 0;
		/*29-05-24 $('.mandatory_field').each(function() {
			if ($(this).val() == '') {
				$('<p><span style="color:red;" class="req_msg">This Field is Required</span></p>').insertAfter(this);
				toastr.error($(this).attr('data-field') + ' is required');
				req_err_cnt++;
			}
		});*/

		$('.mandatory_field').each(function() {
			if ($(this).val() == '') {
				$('<p><span style="color:red;" class="req_msg">This field is required</span></p>').insertAfter(this);
				toastr.error($(this).attr('data-field') + ' is required', '', {
					closeButton: true,
					timeOut: 5000 // 5 seconds
				});
				req_err_cnt++;
			}
		});

		if (req_err_cnt > 0) {
			return false;
		}
		//23-05-24 if(disposal_status=='0')
		if (disposal_status_value == '0') {
			alert("Please Select Disposal Status..!");
			return false;
		}
		// alert(disposed_date);
		// if((disposed_date=='')||(disposed_date=='0000-00-00'))
		if ((disposed_date == '')) {
			alert("Please Enter Disposal Date..!");
			return false;
		}

		if (disposal_status_value == '5') {
			var emp_dept_value = $("#emp_dept").val();
			var emp_desg_value = $("#emp_desg").val();
			var emp_id_value = $("#emp_id").val();
			if ((emp_dept_value == '0') || (emp_desg_value == '0') || (emp_id_value == '0')) {
				alert("Please Select Employee to Whom Transferred");
				return false;
			}
		}

		if ($('#fileToUpload').files[0].size > 5000000) {
			toastr.error("Please upload file less than 5MB. Thanks!!");
			$('#fileToUpload').val('');
			return false
		}
		return false;

		if (cat3_id == '106' || cat3_id == '107' || cat3_id == 108 || cat3_id == 109 || cat3_id == 110 || cat3_id == 111 || cat3_id == 112 || cat3_id == 113 || cat3_id == 114 || cat3_id == 115 || cat3_id == 116 || cat3_id == 117 || cat3_id == 119 || cat3_id == 120 || cat3_id == 121 || cat3_id == 122 || cat3_id == 123 || cat3_id == 124 || cat3_id == 125 || cat3_id == 126 || cat3_id == 127 || cat3_id == 128) {

			if (fileToUpload == '') {
				alert('Upload image');
				return false;
			}
		}

		// Disable the submit button to prevent multiple submissions
		$('#submitBtn').prop('disabled', true);


		return true;
	}





	function toggle(disposal_status) {
		var rows = $('table.someclass tr');
		var black = rows.filter('.black');
		if (disposal_status == '5' || disposal_status == '10')
			black.show();

		else {
			document.update_comp.emp_dept.selectedIndex = 0;
			get_det(0);
			black.hide();
		}

	}

	$(document).on('change', '#disposal_status', function() { 
		let id = $(this).val(); 
		//alert(id==9);
		if(id == 9 || id == 12) {	
			$('#imageInput').attr('required', 'required');
			$('#mandatory_symbol').show()			
		}else {	
			$('#imageInput').removeAttr('required'); 	
			$('#dipd_on').show();
			$('#trnsd_on').hide();
			$('#mandatory_symbol').hide()	
		}
	});
	
	
	$(function() {
		// alert($('#disposal_status').val())
		if ($('#disposal_status').val() === 5) {
			$('#trnsd_on').show();
			$('#dipd_on').hide();
		} else {
			$('#trnsd_on').hide();
			$('#dipd_on').show();
		}
	})


	$(document).ready(function() {
		var rows = $('table.someclass tr');
		var black = rows.filter('.black');
		black.hide();
	});
</script>
<style>
	<style>.ui-timepicker-div .ui-widget-header {
		margin-bottom: 8px;
	}

	.ui-timepicker-div dl {
		text-align: left;
	}

	.ui-timepicker-div dl dt {
		height: 25px;
		margin-bottom: -25px;
	}

	.ui-timepicker-div dl dd {
		margin: 0 10px 10px 65px;
	}

	.ui-timepicker-div td {
		font-size: 90%;
	}

	.ui-tpicker-grid-label {
		background: none;
		border: none;
		margin: 0;
		padding: 0;
	}

	.ui-timepicker-rtl {
		direction: rtl;
	}

	.ui-timepicker-rtl dl {
		text-align: right;
	}

	.ui-timepicker-rtl dl dd {
		margin: 0 65px 10px 10px;
	}
</style>
</style>
{/literal}

{if isset($data1)}
{if isset($msg)}
<div class="{$class}">
	<button class="close" data-close="alert"></button>
	{$msg}
</div>
{/if}
<strong></strong>


<div class="boxed">

	<div class="title-bar blue">
		<h4>Update the Complaint Details</h4>
	</div>
	<div class="inner no-radius">

		<div id='comp_div'>
			<form method="post" action="manage_transfered_comp_sel.php" name="update_comp" id="update_comp" onsubmit="return validateForm()" enctype="multipart/form-data">
				<input type='hidden' name='grievance_id' value={$grievance_id}>
				<input type='hidden' name='transaction_id' value={$transaction_id}>
				<input type='hidden' name='file_no' value={$data1.file_no}>
				<input type='hidden' name='app_type_id' value={$data1.app_type_id}>
				<input type="hidden" name="cat3_id" id="cat3_id" value="{$data1.cat3_id}">

				<input type='hidden' name='dept_id' id="dept_id" value={$dept_id}>
				<input type="hidden" name="emp_lvl" id="emp_lvl" value="{$data1.grievance_at_emp_level}">
				<input type="hidden" name="emp_current_lvl" id="emp_current_lvl" value="{$emp_current_lvl}">
				<input type="hidden" name="Level1_emp_id" id="Level1_emp_id" value="{$Level1_emp_id}">
				<input type="hidden" name="ward_id" id="ward_id" value="{$data1.ward_id}">
				<input type='hidden' name='street_id' id="street_id" value={$data1.street_id}>

				<div class="table-responsive">
					<table width="100%" height="35" border="1" cellpadding="0" cellspacing="0" class="someclass table-bordered table-striped table-condensed cf">
						<tr>
							<td align="left" valign="middle"> Name: </td>
							<td align="left" valign="middle">{$data1.person_name}</td>
							<td align="left" valign="middle"> Address : </td>
							<td align="left" valign="middle">{$data1.hno} , {$data1.address}</td>
						</tr>
						<tr>
							<td align="left" valign="middle"> Ward & Street : </td>
							<td align="left" valign="middle">{$ward_list[$data1.ward_id]}/.{$street_list[$data1.street_id]}</td>
							<td align="left" valign="middle"> Mobile: </td>
							<td align="left" valign="middle">{$data1.mobile}</td>
						</tr>
						<tr>
							<td align="left" valign="middle"> Subject: </td>
							<td align="left" valign="middle">{$data2[$transaction_id]['comp_desc']}</td>
							<td align="left" valign="middle"> Received Through: </td>
							<td align="left" valign="middle">{$grievance_origin_list[$data1.grievance_origin_id]} - {$data1.grievance_id}</td>
						</tr>
						<tr>
							<td align="left" valign="middle"> Description: </td>
							<td align="left" valign="middle" style="word-wrap: break-word;">
								<div style="width:500px;">{$data1.comp_desc}</div>
							</td>
							<td align="left" valign="middle"> Present Status: </td>
							<td align="left" valign="middle"><b>{$grievance_status_list[$data1.grievance_status_id]}</b></td>
						</tr>
						{if $user_type neq 'U'}
						<tr>
							<td align="left" valign="middle"> Grievance Img </td>
							<td align="left" valign="middle" style="word-wrap: break-word;">
								<div class="grievance_image"><a href="{if $data1.file_url eq ''}default-img.png{else} {$data1.file_url} {/if}" target="_blank"><img src="{if $data1.file_url eq ''}default-img.png{else} {$data1.file_url} {/if}" alt="Grievance Image"></a></div>
							</td>
							<td align="left" valign="middle"> </td>
							<td align="left" valign="middle"><b></b></td>
						</tr>
						{/if}
						{if $user_type eq 'U'}
						<tr>

							<td align="left" valign="middle">Grievance Image</td>
							<td align="left" valign="middle">
								<div class="grievance_image">
									<a href="{if $data1.file_url eq ''}default-img.png{else} {$data1.file_url} {/if}" target="_blank"><img src="{if $data1.file_url eq ''}default-img.png{else} {$data1.file_url} {/if}" alt="Grievance Image"></a>
								</div>

							</td>
							<td align="left" valign="middle"> Endorsement: </td>
							<td align="left" valign="middle">{$data1.endorsement}</td>
						</tr>
						{/if}

						{if $data1.grievance_origin_id eq '8'}
						<tr>
							<td align="left" valign="middle">Garden Name</td>
							<td align="left" valign="middle">{$data1.park_name}</td>
						</tr>
						{/if}

						<tr>
							<th colspan='4'>GRIEVANCE MOVEMENT DETAILS</th>
						</tr>


						{foreach from=$data2 key=transaction_id item=row}
						<tr>
							<td align="left" valign="middle"> Allotted to: </td>
							<!-- <td align="left" valign="middle" colspan="3"> -->
							<td align="left" valign="middle" colspan="1">
								{$emp_list[$row.emp_id]['emp_name']} {$emp_list[$row.emp_id]['emp_mobile']} ({$desg_list[$emp_list[$row.emp_id]['emp_desg']]}) ,  {$dept_list[$row.dept_id]}
							</td>
							<td align="left" valign="middle"> Employee Level: </td>
							<td align="left" valign="middle">
								{if $data1.grievance_at_emp_level eq 'L1'} <b> Level - 1 </b>
								{elseif $data1.grievance_at_emp_level eq 'L2'} <b> Level - 2 </b>
								{elseif $data1.grievance_at_emp_level eq 'L3'} <b> Level - 3 </b>
								{elseif $data1.grievance_at_emp_level eq 'L4'} <b> Level - 4 </b>
								{/if}
							</td>
						</tr>
						{if $row.disposal_status eq '3' || $row.disposal_status eq '8' || $row.disposal_status eq '9'}
						<tr>

							<td align="left" valign="middle"> Allotted on: </td>
							<td align="left" valign="middle">
								{$row.alloted_date}
							</td>

							<td align="left" valign="middle"> Disposal Status: </td>
							<td align="left" valign="middle">
								{$grievance_status_list[$row.disposal_status]}
							</td>
						</tr>

						<tr>
							<td align="left" valign="middle"> Disposed on: </td>
							<td align="left" valign="middle">
								{$row.disposed_date}
							</td>
							<td align="left" valign="middle"> Remarks: </td>
							<td align="left" valign="middle">
								{$row.disposal_remarks}
							</td>
						</tr>
						{else}
						<tr>

							<td align="left" valign="middle"> Allotted on: </td>
							<td align="left" valign="middle">
								<input type="text" name="alloted_date" id="alloted_date" value="{$row.alloted_date}" readonly="readonly">
							</td>

							<td align="left" valign="middle"> Disposal Status: </td>
							<td align="left" valign="middle">
								<select name='disposal_status' id='disposal_status' onchange="toggle(this.value);" required="required">
									<option value='0'>--Select Status--</option>
									{html_options options=$grievance_status_list selected=$row.disposal_status}
								</select>

								<?php print_r($grievance_status_list); ?>
							</td>
						</tr>
						<tr>
							<td align="left" valign="middle"><span id="mandatory_symbol" style="display:none;color:red;">*</span>Upload Image : </td>
							<td align="left" valign="middle">
								<input type="file" id="imageInput" name="fileToUpload" class="" data-field="Upload Image" accept="image/*" onchange="showThumbnail(this)" />
							</td>
							<td align="left" valign="middle">
							Image Preview
							</td>
							<td align="left" valign="middle">
								 <div id="thumbnailPreview"> 
													 
										<img id="thumbnail" class="thumbnail" src="" alt="Thumbnail Preview" style="display:none;">
									
								</div>
							</td>
						</tr>
						{if $data1.grievance_at_emp_level eq 'L1'}
						<tr class="black">
							<td align="left" valign="middle"> Transferred to: </td>
							<td align="left" valign="middle" colspan='3'>
								<select name='emp_dept' id="emp_dept" onchange="fetchDesignations(this.value)">
									<option value='0'>--Select Department--</option>
									{html_options options=$dept_list}
								</select>

								<select name='emp_desg' id='emp_desg' onchange="fetchEmployees(this.value)">
									<option value='0'>--Select Designation--</option>
								</select>

								<select name='emp_id' id='emp_id'>
									<option value='0'>--Select Employee--</option>
								</select>
							</td>
						</tr>
						{else}
						<tr class="black">
							<td align="left" valign="middle"> Transferred to: </td>
							<td align="left" valign="middle" colspan='3'>
								<select name='emp_dept' id="emp_dept" onchange="get_det(this.value);">
									<option value='0'>--Select Department--</option>
									{html_options options=$dept_list}
								</select>
								<select name='emp_desg' id='emp_desg' onchange="get_det1(this.value);">
									<option value='0'>--Select Designation--</option>
								</select>
								<select name='emp_id' id='emp_id'>
									<option value='0'>--Select Employee--</option>
								</select>
							</td>
						</tr>
						{/if}
						<tr>
							<td align="left" valign="middle"> <span id="trnsd_on">Transferred on:</span><span id="dipd_on">Disposed on:</span> </td>
							<td align="left" valign="middle">
								<input type="text" name="disposed_date" id="datepicker" value="{" now"|date_format:'%Y-%m-%d'}" class="form-control input-medium" readonly required="required">
							</td>
							<td align="left" valign="middle"> Action taken: </td>
							<td align="left" valign="middle">
								<textarea name="disposal_remarks" class="mandatory_field" data-field="Action taken" style="width:300px;height:100px;">{$row.disposal_remarks}</textarea>
							</td>
						</tr>

						<tr></tr>
						<td align="left" valign="middle"> Root Cause Anlysis: </td>
						<td align="left" valign="middle">
							<textarea name="rca" id="rca" style="width:300px;height:100px;">{$row.rca}</textarea>
						</td>
						<td align="left" valign="middle"> Corrective Action: </td>
						<td align="left" valign="middle">
							<textarea name="ca" id="ca" style="width:300px;height:100px;">{$row.ca}</textarea>
						</td>
						</tr>

						{/if}

						{/foreach}

						<tr>
							<td bgcolor='#aeeff0' align="center" valign="middle" colspan='4'>
								<input type='submit' name='save' value='Submit' class="btn btn-success">
								<a href="manage_comp.php" class="btn btn-info"><i class="fa fa-backward"></i> Back</a>
							</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>

<div style="border:#999999 0px solid; height:400px; margin-top:5px;">



</div>
{/if}
<div>
</div>
{include file='footer.tpl'}
{literal}
<script type="text/javascript" src="minjs/jquery.min.js"></script>
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>-->
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script>
	function fetchDesignations(deptId) {
		
		const emp_id = document.getElementById('Level1_emp_id').value;
		const ward_id = document.getElementById('ward_id').value;
		const street_id = document.getElementById('street_id').value;
		const cat3_id = document.getElementById('cat3_id').value;
		
			const emp_desg1='dept_id='+deptId+' emp_id='+emp_id+' ward_id='+ward_id+' street_id='+street_id+' cat3_id='+cat3_id;
		
		//alert(emp_desg1);
	
		$('#emp_desg').empty().append("<option value='0'>--Select Designation--</option>");
		$('#emp_id').empty().append("<option value='0'>--Select Employee--</option>");

		if (deptId !== '0') {

			$.ajax({

				url: 'fetch_designations.php',
				type: 'POST',
				data: {
					dept_id: deptId,
					emp_id: emp_id,
					ward_id: ward_id,
					street_id: street_id,
					cat3_id: cat3_id
				},
				dataType: 'json',
				success: function(data) {

					if (data.length > 0) {
						$.each(data, function(index, item) {
							$('#emp_desg').append("<option value='" + item.desg_id + "'>" + item.desg_desc + "</option>");
						});
					} else {
						$('#emp_desg').append("<option value='0'>No designations available</option>");
					}
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error: ", status, error);
				}
			});
		}
	}
	
	function fetchEmployees(desgId) {
		const ward_id = document.getElementById('ward_id').value;
		const street_id = document.getElementById('street_id').value;
		const cat3_id = document.getElementById('cat3_id').value;
		const dept_id = document.getElementById('emp_dept').value;
		const desgdetails=' Dept:'+ dept_id+' Desg:'+desgId+' ward_id:'+ward_id+' street_id:'+street_id+' cat3_id:'+cat3_id;
	
	//alert(desgdetails);
	
		$('#emp_id').empty().append("<option value='0'>--Select Employee--</option>");

		if (desgId !== '0') {
			$.ajax({
				url: 'fetch_employees.php',
				type: 'POST',
				data: {
					emp_desg: desgId,
					ward_id: ward_id,
					street_id: street_id,
					cat3_id: cat3_id
				},
				dataType: 'json',
				success: function(data) {
					$.each(data, function(index, item) {
						$('#emp_id').append("<option value='" + item.emp_id2 + "'>" + item.emp_name + "</option>");
					});
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error: ", status, error);
				}
			});
		}
	}
	
	$(function() {
		let dsts = $('#disposal_status').val();
		if (["5", "4"].includes(dsts) === true) {
			$('#fileToUpload').removeClass('mandatory_field');
		} else {
			// $('#fileToUpload').addClass('mandatory_field');
		}
	});

	$(document).ready(function() {
		$('#fileToUpload').bind('change', function() {
			var a = (this.files[0].size);
			//alert(a);
			if (a > 20000000) {
				alert('large');
			};
		});
		$('#fileToUpload').change(function() {
			if (this.files[0].size > 5000000) {
				alert("Please upload file less than 5MB. Thanks!!");
				$(this).val('');
			}
		});

		$('#disposal_status').change(function() {
			let dsArr = ["5", "4"];
			let ds = $(this).val();
			if (dsArr.includes(ds) === true) {
				$('#fileToUpload').removeClass('mandatory_field');
			} else {
				$('#fileToUpload').addClass('mandatory_field');
			}
		});
	});
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
	$(function() {
		$("#datepicker").datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
</script>
 <script>
        function showThumbnail(input) {
            // Check if an image file is selected
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                // When the file is loaded, display the thumbnail
                reader.onload = function (e) {
                    var thumbnail = document.getElementById('thumbnail');
                   
                    thumbnail.src = e.target.result; // Set the image source
                 
                    thumbnail.style.display = 'block'; // Display the thumbnail
                };

                // Read the image file as a data URL
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

{/literal}