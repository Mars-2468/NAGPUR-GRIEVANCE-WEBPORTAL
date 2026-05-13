{include file='header.tpl'}
{literal}
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	textarea {

		resize: none;

	}

	.hidden {
		display: none;
	}

	div.grievance_image img {
		height: 120px;
		object-fit: contain;
		overflow: hidden;
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
		if (disposal_status == '5')
			black.show();

		else {
			document.update_comp.emp_dept.selectedIndex = 0;
			get_det(0);
			black.hide();
		}

	}

	/*function toggle1(statusValue) {
		var actionTakenBlock = document.getElementById('action_taken_block');

		// Example logic: Show the Action Taken block if the status is '2'
		if (statusValue === '2' || statusValue === '9') {
			actionTakenBlock.style.display = 'table-row'; // Use 'table-row' to show the block in table row
		} else {
			actionTakenBlock.style.display = 'none';
		}
	}*/
	/*function toggle1(statusValue) {
		var actionTakenBlock = document.getElementById('action_taken_block');
		var selectBox = document.getElementById('disposal_remarks');

		// Show the Action Taken block if the status is '2' or '9'
		if (statusValue === '2' || statusValue === '5' || statusValue === '6' || statusValue === '9') {
			actionTakenBlock.style.display = 'table-row';

			// Clear current options
			selectBox.innerHTML = '<option value="0">--Select Remarks--</option>';

			// Add options based on statusValue
			if (statusValue === '2') {
				selectBox.innerHTML += '<option value="1" data-remark="Thank you for bringing this issue to our attention. We acknowledge receipt of your grievance and will review it promptly.">Thank you for bringing</option>';
			} else if (statusValue === '5') {
				selectBox.innerHTML += '<option value="1" data-remark="Transferred to Relevant Department: Thanks for using GRMS. The grievance has been forwarded to the department best equipped to handle it.">Transferred to Relevant Department</option>';
				selectBox.innerHTML += '<option value="2" data-remark="Transferred to Higher Authority: Thanks for using GRMS. The grievance has been escalated to a higher authority for resolution.">Transferred to Higher Authority</option>';
				selectBox.innerHTML += '<option value="3" data-remark="Jurisdictional Transfer: Thanks for using GRMS. We have Transfer your grievance to Concern officer for further action. You will receive an update soon.">Jurisdictional Transfer</option>';
			}else if (statusValue === '6') {
				selectBox.innerHTML += '<option value="1" data-remark="Budget Approval Pending: Thanks for using GRMS. Resolution requires financial approval which is currently pending.">Budget Approval Pending</option>';
				selectBox.innerHTML += '<option value="2" data-remark="Thanks for using GRMS. We apologize that we are unable to resolve your grievance at this time. We will continue to work on finding a solution and will keep you updated.">Thanks for using GRMS</option>';
			}else if (statusValue === '9') {
				selectBox.innerHTML += '<option value="1" data-remark="Issue Resolved: Thanks for using GRMS. The grievance has been fully addressed and resolved.">Resolved</option>';
				selectBox.innerHTML += '<option value="2" data-remark="Action Implemented: Thanks for using GRMS. The required action has been implemented successfully.">Action Implemented</option>';
				selectBox.innerHTML += '<option value="3" data-remark="Thanks for using GRMS. We have resolved your grievance. Please find the details of the resolution attached. Thank you for your understanding.">Details Attached</option>';
			}
		} else {
			actionTakenBlock.style.display = 'none';
		}
	}*/

	/*new function toggle1(statusValue) {
		var actionTakenBlock = document.getElementById('action_taken_block');
		var selectBox = document.getElementById('disposal_remarks_select');
		var textArea = document.getElementById('disposal_remarks_textarea');

		// Show the Action Taken block if the status is '2', '5', '6', or '9'
		if (statusValue === '2' || statusValue === '5' || statusValue === '6' || statusValue === '9') {
			actionTakenBlock.style.display = 'table-row';
			selectBox.style.display = 'inline';
			textArea.style.display = 'none';

			// Clear current options
			selectBox.innerHTML = '<option value="0">--Select Remarks--</option>';

			// Add options based on statusValue
			if (statusValue === '2') {
				selectBox.innerHTML += '<option value="1" data-remark="Thank you for bringing this issue to our attention. We acknowledge receipt of your grievance and will review it promptly.">Thank you for bringing</option>';
			} else if (statusValue === '5') {
				selectBox.innerHTML += '<option value="1" data-remark="Transferred to Relevant Department: Thanks for using GRMS. The grievance has been forwarded to the department best equipped to handle it.">Transferred to Relevant Department</option>';
				selectBox.innerHTML += '<option value="2" data-remark="Transferred to Higher Authority: Thanks for using GRMS. The grievance has been escalated to a higher authority for resolution.">Transferred to Higher Authority</option>';
				selectBox.innerHTML += '<option value="3" data-remark="Jurisdictional Transfer: Thanks for using GRMS. We have transferred your grievance to the concerned officer for further action. You will receive an update soon.">Jurisdictional Transfer</option>';
			} else if (statusValue === '6') {
				selectBox.innerHTML += '<option value="1" data-remark="Budget Approval Pending: Thanks for using GRMS. Resolution requires financial approval which is currently pending.">Budget Approval Pending</option>';
				selectBox.innerHTML += '<option value="2" data-remark="Thanks for using GRMS. We apologize that we are unable to resolve your grievance at this time. We will continue to work on finding a solution and will keep you updated.">Thanks for using GRMS</option>';
			} else if (statusValue === '9') {
				selectBox.innerHTML += '<option value="1" data-remark="Issue Resolved: Thanks for using GRMS. The grievance has been fully addressed and resolved.">Resolved</option>';
				selectBox.innerHTML += '<option value="2" data-remark="Action Implemented: Thanks for using GRMS. The required action has been implemented successfully.">Action Implemented</option>';
				selectBox.innerHTML += '<option value="3" data-remark="Thanks for using GRMS. We have resolved your grievance. Please find the details of the resolution attached. Thank you for your understanding.">Details Attached</option>';
			}
		} else {
			actionTakenBlock.style.display = 'table-row';
			selectBox.style.display = 'none';
			textArea.style.display = 'inline';
		}
	}*/

	// function toggle1(statusValue) {
	// 	var actionTakenBlock = document.getElementById('action_taken_block');
	// 	var selectBox = document.getElementById('disposal_remarks_select');
	// 	var textArea = document.getElementById('disposal_remarks_textarea');

	// 	// Show the Action Taken block if the status is '2', '5', '6', or '9'
	// 	if (statusValue === '2' || statusValue === '5' || statusValue === '6' || statusValue === '9') {
	// 		actionTakenBlock.style.display = 'table-row';

	// 		// Show select box and hide textarea
	// 		selectBox.style.display = 'inline';
	// 		textArea.style.display = 'none';

	// 		// Clear current options
	// 		selectBox.innerHTML = '<option value="0">--Select Remarks--</option>';

	// 		// Add options based on statusValue
	// 		if (statusValue === '2') {
	// 			selectBox.innerHTML += '<option value="1" data-remark="Thank you for bringing this issue to our attention. We acknowledge receipt of your grievance and will review it promptly.">Thank you for bringing</option>';
	// 		} else if (statusValue === '5') {
	// 			selectBox.innerHTML += '<option value="1" data-remark="Transferred to Relevant Department: Thanks for using GRMS. The grievance has been forwarded to the department best equipped to handle it.">Transferred to Relevant Department</option>';
	// 			selectBox.innerHTML += '<option value="2" data-remark="Transferred to Higher Authority: Thanks for using GRMS. The grievance has been escalated to a higher authority for resolution.">Transferred to Higher Authority</option>';
	// 			selectBox.innerHTML += '<option value="3" data-remark="Jurisdictional Transfer: Thanks for using GRMS. We have transferred your grievance to the concerned officer for further action. You will receive an update soon.">Jurisdictional Transfer</option>';
	// 		} else if (statusValue === '6') {
	// 			selectBox.innerHTML += '<option value="1" data-remark="Budget Approval Pending: Thanks for using GRMS. Resolution requires financial approval which is currently pending.">Budget Approval Pending</option>';
	// 			selectBox.innerHTML += '<option value="2" data-remark="Thanks for using GRMS. We apologize that we are unable to resolve your grievance at this time. We will continue to work on finding a solution and will keep you updated.">Thanks for using GRMS</option>';
	// 		} else if (statusValue === '9') {
	// 			selectBox.innerHTML += '<option value="1" data-remark="Issue Resolved: Thanks for using GRMS. The grievance has been fully addressed and resolved.">Resolved</option>';
	// 			selectBox.innerHTML += '<option value="2" data-remark="Action Implemented: Thanks for using GRMS. The required action has been implemented successfully.">Action Implemented</option>';
	// 			selectBox.innerHTML += '<option value="3" data-remark="Thanks for using GRMS. We have resolved your grievance. Please find the details of the resolution attached. Thank you for your understanding.">Details Attached</option>';
	// 		}

	// 		// Set the selected option if there is a previous value
	// 		var previousValue = document.getElementById('previous_status').value;
	// 		if (previousValue) {
	// 			selectBox.value = previousValue;
	// 		}
	// 	} else {
	// 		//actionTakenBlock.style.display = 'none';
	// 		actionTakenBlock.style.display = 'table-row';
	// 		selectBox.style.display = 'none';
	// 		textArea.style.display = 'inline';
	// 	}
	// }

	// window.onload = function() {
	// 	// Get the status value from a hidden input field or some other source
	// 	var statusValue = document.getElementById('previous_status').value;
	// 	if (statusValue) {
	// 		toggle1(statusValue);
	// 	}
	// }

	// Initial call to set the block visibility based on the current value
	// document.addEventListener('DOMContentLoaded', function() {
	// 	var currentStatus = document.getElementById('disposal_status').value;
	// 	toggle(currentStatus);
	// });

	function toggle1(statusValue) {
		var actionTakenBlock = document.getElementById('action_taken_block');
		var selectBox = document.getElementById('disposal_remarks_select');
		var textArea = document.getElementById('disposal_remarks_textarea');

		// Show the Action Taken block if the status is '2', '5', '6', or '9'
		if (statusValue === '2' || statusValue === '5' || statusValue === '6' || statusValue === '9') {
			actionTakenBlock.style.display = 'table-row';

			// Show select box and hide textarea
			selectBox.style.display = 'inline';
			textArea.style.display = 'none';

			// Clear current options and add options based on statusValue
			selectBox.innerHTML = '<option value="0" disabled selected>--Select Remarks--</option>';
			if (statusValue === '2') {
				selectBox.innerHTML += '<option value="1" data-remark="Thank you for bringing this issue to our attention. We acknowledge receipt of your grievance and will review it promptly.">Thank you for bringing this issue.</option>';
			} else if (statusValue === '5') {
				selectBox.innerHTML += '<option value="1" data-remark="Transferred to Relevant Department: Thanks for using GRMS. The grievance has been forwarded to the department best equipped to handle it.">Transferred to Relevant Department.</option>';
				selectBox.innerHTML += '<option value="2" data-remark="Transferred to Higher Authority: Thanks for using GRMS. The grievance has been escalated to a higher authority for resolution.">Transferred to Higher Authority.</option>';
				selectBox.innerHTML += '<option value="3" data-remark="Jurisdictional Transfer: Thanks for using GRMS. We have transferred your grievance to the concerned officer for further action. You will receive an update soon.">Jurisdictional Transfer.</option>';
			} else if (statusValue === '6') {
				selectBox.innerHTML += '<option value="1" data-remark="Budget Approval Pending: Thanks for using GRMS. Resolution requires financial approval which is currently pending.">Budget Approval Pending.</option>';
				selectBox.innerHTML += '<option value="2" data-remark="Thanks for using GRMS. We apologize that we are unable to resolve your grievance at this time. We will continue to work on finding a solution and will keep you updated.">Thanks for using GRMS.</option>';
			} else if (statusValue === '9') {
				selectBox.innerHTML += '<option value="1" data-remark="Issue Resolved: Thanks for using GRMS. The grievance has been fully addressed and resolved.">Issue Resolved.</option>';
				selectBox.innerHTML += '<option value="2" data-remark="Action Implemented: Thanks for using GRMS. The required action has been implemented successfully.">Action Implemented.</option>';
				selectBox.innerHTML += '<option value="3" data-remark="Thanks for using GRMS. We have resolved your grievance. Please find the details of the resolution attached. Thank you for your understanding.">Details Attached.</option>';
			}

			// Set the selected option if there is a previous value
			/*var previousValue = document.getElementById('previous_value').value;
			if (previousValue) {
				selectBox.value = previousValue;
			}*/
		} else {
			// Show the Action Taken block but hide select box and show textarea
			actionTakenBlock.style.display = 'table-row';
			selectBox.style.display = 'none';
			textArea.style.display = 'inline';

			// Set previous text area value if present
			/*var previousTextValue = document.getElementById('previous_text_value').value;
			if (previousTextValue) {
				textArea.value = previousTextValue;
			}*/
		}
	}

	window.onload = function() {
		// Get the status value from a hidden input field or some other source
		var statusValue = document.getElementById('previous_status').value;
		if (statusValue) {
			toggle1(statusValue);
		}
	}


	$(document).on('change', '#disposal_status', function() {
		let id = $(this).val();
		if (id == 5) {
			//    
			$('#trnsd_on').show();
			$('#dipd_on').hide();
		} else {
			$('#dipd_on').show();
			$('#trnsd_on').hide();
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
	.ui-timepicker-div .ui-widget-header {
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
			<form method="post" action="manage_comp_sel_test.php" name="update_comp" id="update_comp" onsubmit="return validateForm()" enctype="multipart/form-data">
				<input type='hidden' name='grievance_id' value={$grievance_id}>
				<input type='hidden' name='transaction_id' value={$transaction_id}>
				<input type='hidden' name='file_no' value={$data1.file_no}>
				<input type='hidden' name='app_type_id' value={$data1.app_type_id}>
				<input type="hidden" name="cat3_id" value="{$data1.cat3_id}" id="cat3_id">
				<input type="hidden" id="previous_status" value="{$data1.grievance_status_id}">


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
							<td align="left" valign="middle">{if $data1.app_type_id=='1'}{$cs_list[$data1.cat3_id]}{else}{$cs_list[$data1.mcat3_id]}{/if}</td>
							<td align="left" valign="middle"> Received Through: </td>
							<td align="left" valign="middle">{$grievance_origin_list[$data1.grievance_origin_id]}</td>
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
							<td align="left" valign="middle" colspan="3">
								{$row.emp_name} ({$row.emp_mobile}) , {$desg_list[$row.emp_desg]} , {$dept_list[$row.emp_dept]}
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
								<select name='disposal_status' id='disposal_status' onchange="toggle(this.value);toggle1(this.value);" required="required">
									<!--24-07-2024 <option value='0'>--Select Status--</option> -->
									<option value="0" disabled selected>--Select Status--</option>
									{html_options options=$grievance_status_list selected=$row.disposal_status}
								</select>

								<?php print_r($grievance_status_list); ?>
							</td>
						</tr>
						<tr>
							<td align="left" valign="middle">Upload Image : </td>
							<td align="left" valign="middle" colspan='3'>
								<input type="file" name="fileToUpload" class="" data-field="Upload Image" accept="image/*" />
							</td>
						</tr>
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
						<tr id="action_taken_block" style="display: none;">
							<td align="left" valign="middle"> <span id="trnsd_on">Transferred on:</span><span id="dipd_on">Disposed on:</span> </td>
							<td align="left" valign="middle">
								<input type="text" name="disposed_date" id="datepicker" value="{" now"|date_format:'%Y-%m-%d'}" class="form-control input-medium" readonly required="required">
							</td>
							<!--old 23-07-2024 <td align="left" valign="middle"> Action taken: </td>
							<td align="left" valign="middle">
								<textarea name="disposal_remarks" class="mandatory_field" data-field="Action taken" style="width:300px;height:100px;">{$row.disposal_remarks}</textarea>
							</td> -->
							<td align="left" valign="middle">Action Taken: </td>
							<td align="left" valign="middle">
								<select name="disposal_remarks" class="mandatory_field" data-field="Action taken" id="disposal_remarks_select" style="display: none;">
									<option value="0" disabled selected>--Select Remarks--</option>
								</select>
								<textarea name="disposal_remarks" class="mandatory_field" data-field="Action taken" id="disposal_remarks_textarea" style="width:300px; height:100px; display: none;">{$row.disposal_remarks}</textarea>
							</td>
						</tr>
						<!-- <tr id="action_taken_block" style="display: none;">
							<td align="left" valign="middle">Action Demo: </td>
							<td align="left" valign="middle">
								<select name="disposal_remarks" class="mandatory_field" data-field="Action taken" id="disposal_remarks">
									<option value="0">--Select Remarks--</option>
								</select>
							</td>
						</tr> -->

						<!-- <tr id="action_taken_block" style="display: none;">
							<td align="left" valign="middle">Action Demo: </td>
							<td align="left" valign="middle">
								<select name="disposal_remarks" class="mandatory_field" data-field="Action taken" id="disposal_remarks_select" style="display: none;">
									<option value="0">--Select Remarks--</option>
								</select>
								<textarea name="disposal_remarks" class="mandatory_field" data-field="Action taken" id="disposal_remarks_textarea" style="width:300px; height:100px; display: none;">{$row.disposal_remarks}</textarea>
							</td>
						</tr> -->


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
								<a href="manage_comp_test.php" class="btn btn-info"><i class="fa fa-backward"></i> Back</a>
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


{/literal}