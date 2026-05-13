{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->


<script>
	function getdesig(dept_id, i) {


		$.post("getdesig.php", {
			dept_id: dept_id
		}, function(data) {

			var arr = data.split("::");
			$("#desg_id" + i).html(arr[0]);



		})
	}

	function fun1() {
		alert();
		$("#manage_wards").submit();
	}

	function get_employees(dept_id) {


		$.post("ajax_get_employees2.php", {
			dept_id: dept_id
		}, function(data) {


			$("#emp_id").html(data);
			$("#emp_id2").html(data);
			$("#emp_id3").html(data);
			$("#emp_id4").html(data);





		})

	}

	function validateForm() {
		dept_id = $("#dept_id").val();
		emp_id = $("#emp_id").val();
		emp_id2 = $("#emp_id2").val();
		if (dept_id == 0) {
			alert('select Department');
			return false;
		}

		if (emp_id == 0) {
			alert('select Level 1 Employee');
			return false;
		}

		if (emp_id2 == 0) {
			alert('select Level 2 Employee');
			return false;
		}
	}

	function fun1() {
		$("#checkAll").click(function() {

			$("input:checkbox").prop('checked', $(this).prop("checked"));
		});

	}
</script>
{/literal}





<div class="row ">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar blue">
				<h4>Employee Complaint Map</h4>

			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">


				<center>

					<!--<a href="https://municipalservices.in/complaint_emp_map_report_street_wise.php"  class="btn-link" style="color:#FFF;"><span class="fa fa-clipboard"></span> Click Here  To Employee Complaint Mapping Report</a>-->
				</center>
				<br>

				<form method="post" action="ward_emp_complaint_map.php" name="manage_wards" id="manage_wards" class="form-horizontal" onSubmit="return validateForm()">
					<input type='hidden' name='ward_id' value='0'>
					<div class="form-body">
						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}



						<div class="col-md-6">
							<select class="form-control" name="cs_id[]" id="cs_id" multiple="multiple" size="10" style="width:100%">
								<option value="0" disabled>---Complaint---</option>
								{html_options options=$cs_list selected=$cs_id_sel}

							</select>
						</div>




						<div class="col-md-6">
							<label>Department:</label>
							<select class="form-control" name="dept_id" id="dept_id" onchange="get_employees(this.value)" style="margin-bottom:15px;">
								<option value="0">---Department---</option>
								{html_options options=$dept_list selected=$dept_id_sel}

							</select>
							<label>Level-1:</label>
							<select class="form-control" name="emp_id" id="emp_id" style="margin-bottom:15px;">
								<option value="0">---Select---</option>
								{html_options options=$emp_list selected=$emp_id_sel}
							</select>
							<label>Level-2:</label>
							<select class="form-control" name="emp_id2" id="emp_id2" style="margin-bottom:15px;">
								<option value="0">---Select---</option>
								{html_options options=$emp_list selected=$emp_id2_sel}
							</select>
							<label>Level-3:</label>
							<select class="form-control" name="emp_id3" id="emp_id3" style="margin-bottom:15px;">
								<option value="0">---Select---</option>
								{html_options options=$emp_list selected=$emp_id3_sel}
							</select>

							<label>Level-4:</label>
							<select class="form-control" name="emp_id4" id="emp_id4" style="margin-bottom:15px;">
								<option value="0">---Select---</option>
								{html_options options=$emp_list selected=$emp_id4_sel}
							</select>

							<div>
								<button type="submit" name="submit" class="btn btn-info">Get data</button>

							</div>
						</div>



				</form>

				<br>

				<div>{if isset($cs_id_sel)}</div>

				<table class="table-bordered table-striped table-condensed cf" width="100%">
					<thead>

						<tr style="background-color:#2c3e50; color:#FFF;">

							<th>select Check All <input type="checkbox" id="checkAll" onClick="fun1()" class="noExport" /></th>
						</tr>
					</thead>
				</table>


				<br>

				<form method="post" action="ward_emp_complaint_map.php" name="manage_wards" id="manage_wards" onSubmit="return validateForm()">
					<input type="hidden" name="dept_id_sel" value="{$dept_id_sel}">
					<input type="hidden" name="emp_id_sel" value="{$emp_id_sel}">
					<input type="hidden" name="cs_id_sel" value="{$cs_id_sel}">
					<input type="hidden" name="emp_id2_sel" value="{$emp_id2_sel}">
					<input type="hidden" name="emp_id3_sel" value="{$emp_id3_sel}">
					<input type="hidden" name="emp_id4_sel" value="{$emp_id4_sel}">

					<table id="map-data-table">
						<tbody>
							<tr>
								<td>
									{assign var="i" value="0"}
									{assign var="j" value="0"}

									{foreach from=$csid_list item=row2 key=cs_id}
									<br>
									<div style="clear:both;">{$cs_list[$cs_id][{$row2}]}{$cs_data[$row2]}</div>
									<br>
									<table class="table-bordered table-striped table-condensed cf" width="100%">
										<thead>

											<tr style="background-color:#2c3e50; color:#FFF;">

												<th>Ward</th>
												<th>Street</th>
												<th>Department</th>
												<th>Level-1</th>
												<th>Level-2</th>
												<th>Level-3</th>
												<th>Level-4</th>

											</tr>
										</thead>

										{foreach from=$ward_list2[$cs_id] item=row3 key=ward_id2}
										<tr>
											<td>{$ward_list2[$cs_id][$ward_id2]}</td>
										</tr>
										{foreach from=$street_list2[$cs_id][$ward_id2] item=row4 key=street_id2}
										<tr>
											<th></th>
											<th>{$street_list2[$cs_id][$ward_id2][$street_id2]}</th>

											<th>{$data2[$ward_id2][$cs_id][$street_id2].dept_id}</th>
											<th>{$data2[$ward_id2][$cs_id][$street_id2].emp_id}</th>
											<th>{$data2[$ward_id2][$cs_id][$street_id2].emp_id2}</th>
											<th>{$data2[$ward_id2][$cs_id][$street_id2].emp_id3}</th>
											<th>{$data2[$ward_id2][$cs_id][$street_id2].emp_id4}</th>

										</tr>
										{/foreach}
										{/foreach}
									</table>
									<table class="table-bordered table-striped table-condensed cf" width="100%">
										<thead>
											<tr>
												<th> ward </th>

											</tr>
										</thead>
										{assign var="ward_count" value=0}
										{foreach from=$ward_list[$cs_id] item=row key=ward_id}

										{if $street_list[$cs_id][$ward_id] neq ''}
										<tr>
											<td>


												<input type="checkbox" class="noExport" id="{'id'|cat:$ward_count}" onclick="checkall('{$ward_count}')"><strong>Ward: &nbsp;&nbsp;</strong>{$ward_list[$cs_id][$ward_id]}
												<br>

												{foreach from=$street_list[$cs_id][$ward_id] item=row2 key=street_id}

												<input type="checkbox" name="{'street_id'|cat:$i}" value="{$cs_id}-{$ward_id}-{$street_id}" class="{'street_class'|cat:$ward_count} noExport"> {$street_list[$cs_id][$ward_id][$street_id]} ..
												<br>
												{assign var="i" value=$i+1}
												{/foreach}



											</td>

										</tr>

										{/if}
										{assign var="ward_count" value=$ward_count+1}
										{/foreach}

										<input type="hidden" name="file_count" value="{$i}">





									</table>
									{/foreach}
									{foreach from=$data item=row key=cs_id}
									<input type="hidden" name="{'cs_id'|cat:$j}" value="{$data[$j]}">
									{assign var="j" value=$j+1}
									{/foreach}
									<input type="hidden" name="cs_count" value="{$j}">
									<div class="form-actions fluid">
										<div class="">
											<br>
											<center>
												<button type="submit" class="btn btn-info" name='save'>Submit</button>
												<button type="button" class="btn btn-danger">Cancel</button>
											</center>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>


					<!--<table class="table">
	<thead>
		<tr>
		<th> ward  </th>
		
		</tr>
	</thead>
	<form   method="post" action="ward_emp_complaint_map_new.php" name="manage_wards"  id="manage_wards" onSubmit="return validateForm()">
	<input type="hidden" name="dept_id_sel" value="{$dept_id_sel}">
	<input type="hidden" name="emp_id_sel" value="{$emp_id_sel}">
	<input type="hidden" name="cs_id_sel" value="{$cs_id_sel}">
	<input type="hidden" name="emp_id2_sel" value="{$emp_id2_sel}">
	<input type="hidden" name="emp_id3_sel" value="{$emp_id3_sel}">
	<input type="hidden" name="emp_id4_sel" value="{$emp_id4_sel}">
	{assign var="i" value="0"}
	{assign var="j" value="0"}
	{foreach from=$ward_list item=row key=ward_id} 
	
	<tr>
	<td>
	
	
	{$ward_list[$ward_id]}<input type="checkbox" name="{'ward_id'|cat:$i}" value="{$ward_id}">
	
	
	
	</td>
	
	</tr>
	{assign var="i" value=$i+1}
	{/foreach}
	
	<input type="hidden" name="file_count" value="{$i}">
	{foreach from=$data item=row key=cs_id}
	<input type="hidden" name="{'cs_id'|cat:$j}" value="{$data[$j]}">
	{assign var="j" value=$j+1}
	{/foreach}
	<input type="hidden" name="cs_count" value="{$j}">
	<tr>
    <td colspan="3">
	
			<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
						<button type="submit" class="btn btn-info" name='save'>Submit</button>
						<button type="button" class="btn btn-danger">Cancel</button>
						</div>
					</div>		
					</td>
                
                    
                    </tr>
					
	
			</table>	
			</form>-->
			</div>
		</div>
	</div>
</div>
{/if}


<div align='center'>
	<input type="button" onclick="mapTableToExcel('map-data-table', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</div>



{include file='footer_print.tpl'}


{include file='footer.tpl'}
{literal}
<script>
	function checkall(i) {


		if ($("#id" + i).is(':checked')) {

			$('.street_class' + i).each(function() {

				$(this).prop("checked", true);
			});

		} else {

			$('.street_class' + i).each(function() {
				$(this).prop("checked", false);
			});
		}



	}
	$(document).ready(function() {



		$("#checkAll").click(function() {

			$('input:checkbox').not(this).prop('checked', this.checked);


		});

	});
</script>
{/literal}