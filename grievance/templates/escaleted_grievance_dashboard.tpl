{include file='header.tpl'}
{literal}

<script>
	function fill(ward_id, ward_desc) {
		document.manage_wards.ward_id.value = ward_id;
		document.manage_wards.ward_desc.value = ward_desc;
	}

	function delete_ward(ward_id) {

		if (confirm('Do You really want to delete this record')) {

			$.post('ajax_del_ward.php', {
				ward_id: ward_id
			}, function(data) {
				if (data == 1) {
					alert('Ward deleted successfully');
					window.location = 'manage_wards.php';
				} else if (data == 0) {
					alert('Unable to delete , Try again');
				} else if (data == 2) {
					alert('Ward is mapped with employees You cannot delete this ward');
				}

			});
		}

	}

	function validateForm() {
		var ward_desc = document.manage_wards.ward_desc.value;
		if (ward_desc == '') {
			alert("Please Enter Ward No / Description");
			return false;
		}

		return true;
	}
</script>
{/literal}



<div class="">
	
	<div class="boxed">
		<form method="POST" action="" class="form-horizontal">
		<div class="inner no-radius" style="border-bottom-left-radius: 0px !important;border-bottom-right-radius: 0px !important;">
			{if !empty($errors)}
				{foreach $errors as $error}
					<p style="color:red;">{$error}</p>
				{/foreach}
			{/if}

			
			<div class="col-md-3" style="margin-right:15px;">
				<div class="form-group">
					<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">Select department</label>
					<select class="select2 form-select" name="department_id">						
						{foreach from=$cat_list key=k item=v}
							{if $department_id == $k}
								<option value='{$k}' selected>{$v}</option>
							{else}  
								<option value='{$k}'>{$v}</option>
							{/if}
						{/foreach}							
					</select>
				</div>
			</div>
			<div class="col-md-3" style="margin-right:15px;">
				<div class="form-group">
					<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">Select status</label>
					<select class="select2 form-select" name="status_id">						
						{foreach from=$status_list key=k item=v}
							{if $gstatus == $k}
								<option value='{$k}' selected>{$v}</option>
							{else}  
								<option value='{$k}'>{$v}</option>
							{/if}
						{/foreach}							
					</select>
				</div>
			</div>
			
			<div class="col-md-2" style="margin-right:15px;">
				<div class="form-group">
					<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
					<input type="text" class="phone-group form-control datepicker" name="f_date" id="f_date" value="{$fdate}" placeholder="Select from date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
					<div style="font-size:10px;color:red;" id="f_dateX"></div>
				</div>
			</div>
			<div class="col-md-2" style="margin-right:15px;">
				<div class="form-group">
					<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
					<input type="text" class="phone-group form-control datepicker" name="t_date" id="t_date" value="{$tdate}" placeholder="Select to date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
					<div style="font-size:10px;color:red;" id="t_dateX"></div>
				</div>
			</div>
			
			<div class="col-md-2">
				<div class="form-group" style="margin-top:31px;">
					<input name="search" type="submit" class="btn btn-success" value="Search" id="submitBtn" disabled>
				<a class="btn btn-dark" style="color:#FFF" href="">Reset</a>
				</div>
			</div>
		</div>		
	</form>
</div>
	
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
				<h4>Escalated grievance report</h4>
				<!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
				<p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
			</div>			
			
			<!-- Title Bart End -->
			<div class="inner no-radius" class="table-responsive">
				<div id="area" class="table-responsive">
					<!--10-04-24 <table class="table table-striped table-bordered table-hover table-full-width" id="data-table"> -->
					<table id='data-table' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
						<caption style="caption-side:top; text-align:center;font-size:16px;">
							<b>
								<CENTER><strong>VIEW ESCALATED GRIEVANCE REPORT DETAILS</strong></CENTER>
							</b>
						</caption>
						<thead>
							<tr style="background-color:#161D6E; color:#FFF;text-align:center;">
								<th>Sr.No</th>
								<th>COMPLAINTS NAME</th>
								<th>TOTAL</th>
								{foreach from=$ward_list item=row key=ward_id}
									<th>{$row.ward_name|upper} </th>
								{/foreach}
							</tr>
						<tbody>
							{foreach from=$max_comp_details item=row key=cs_id}

								<tr>
									<td align='center'>{counter}</td>
									<td class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="">{$cs_list[$row.cat3_id]['desc']}</a></td>
									<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="tot_escalations_received.php?cat3_id={$row.cat3_id}&ward_id=-1&status_id={$gstatus}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot[$row.cat3_id]['total']}</a></td>
									{foreach from=$ward_list item=row2 key=ward_id}
									<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="tot_escalations_received.php?cat3_id={$row.cat3_id}&ward_id={$ward_id}&status_id={$gstatus}&fdate={$f_date}&t_date={$tdate}" target="_blank">{$comp_details[$row.cat3_id][$ward_id]['count']}</a></td>
									{/foreach}
								</tr>

							{/foreach}
						</tbody>
						</thead>
						<tfoot>
							<tr>
								<td align='center' colspan="2"><strong>Total</strong></td>
								<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="">{$total}</a></td>
								{foreach from=$ward_list item=row2 key=ward_id}
									<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="">{$tot_wards[$ward_id]['total']}</a></td>
								{/foreach}
							</tr>
						</tfoot>
					</table>
				</div>
				{include file='footer_print.tpl'}

			</div>
		</div>
	</div>
</div>
{include file='footer.tpl'}

{literal}
<script>
	$(".num").keydown(function(event) {
		// Allow only backspace and delete
		if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9) {
			// let it happen, don't do anything
		} else {
			// Ensure that it is a number and stop the keypress
			if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
				event.preventDefault();
			}
		}
	});
</script>

{/literal}