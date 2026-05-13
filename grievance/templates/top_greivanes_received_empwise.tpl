{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">






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




<div class="row ">
	<div class="">
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar blue d-flex align-items-center justify-content-between mb-2">
				<h4>Top 10 Grievances Received (Grievance Type & Employee Wise)</h4>
				<!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
				<p class="m-0"><a href="reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<div id="area" class="table-responsive">
					<!--10-04-24 <table class="table table-striped table-bordered table-hover table-full-width" id="data-table"> -->
					<table id='data-table' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
						<caption style="caption-side:top; text-align:center;font-size:16px;">
								<CENTER><strong>VIEW TOP 10 GRIEVANCES RECEIVED (GRIEVANCE TYPE & EMPLOYEE WISE) DETAILS</strong></CENTER>
							</b>
						</caption>
						<thead>
							<tr style="background-color:#161D6E; color:#FFF;text-align:center;">
								<th>Sr.No</th>
								<th>COMPLAINTS NAME</th>
								<th>TOTAL</th>
								{foreach from=$ward_list item=row key=emp_id}

								<th>{$row.emp_name|upper} </th>
								{/foreach}
							</tr>
						<tbody>
							{foreach from=$max_comp_details item=row key=cs_id}

							<tr>
								<td align='center'>{counter}</td>
								<td><a href="">{$cs_list[$row.cat3_id]['desc']}</a></td>
								<td align='center'><a href="">{$tot[$row.cat3_id]['total']}</a></td>
								{foreach from=$ward_list item=row2 key=emp_id}
								<td align='center'><a href="">{$comp_details[$row.cat3_id][$emp_id]['count']}</a></td>
								{/foreach}


							</tr>


							{/foreach}
						</tbody>
						</thead>
						<tfoot>
							<!--<tr>
										<td colspan="2">Total</td>
										
										<td>{$total}</td>
										{foreach from=$ward_list item=row2 key=ward_id}
										<td>{$tot_wards[$ward_id]['total']}</td>
										{/foreach}
										
										
							</tr>-->
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