{include file='header.tpl'}
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#example').dataTable();
		$('#myDataTable1').dataTable();

	});
</script>
<div id="div_print" style="border:#999999 0px solid;">
	<CENTER><strong>VIEW COMPLAINTS DETAILS</strong></CENTER>

	<!--<div align="right"><a href="#" ><button class="btn btn-warning" onclick="history.go(-1);"><i class="fa fa-backward"></i> Back</button></a></div>-->

	<div style="width:100%; overflow:scroll;">
		<div id="area">
			<table class="table table-striped table-bordered table-hover table-full-width" id="example">

				<thead>

					<tr class="mytr_bgcolor" style="background-color:#161D6E; color:#FFF;">
						<td>S.No</td>
						<td>Person name</td>
						<td>Mobile no </td>
						<td>Hno</td>
						<td>Address</td>
						<td>Ward</td>
						<td>Street</td>
						<td>Complaint Description</td>
						<td>Employee Name</td>
						<td>Employee Mobile</td>




					</tr>






				</thead>
				<tbody>
					{foreach from=$data item=row key=grievance_id}
					<tr>
						<td>{counter}</td>
						<td>{$row.person_name}</td>
						<td>{$row.mobile}</td>
						<td>{$row.hno}</td>
						<td>{$row.address}</td>
						<td>{$ward_list[$row.ward_id]}</td>
						<td>{$street_list[$row.street_id]}</td>
						<td>{$row.comp_desc}</td>
						<td>{$row.emp_name}</td>
						<td>{$row.emp_mobile}</td>

					</tr>
					{/foreach}
				</tbody>
				<tfoot>



				</tfoot>
			</table>
			<center>
				<a href="complaint_wise_rep.php" class="btn btn-success">Back</a>

			</center>

			<center>
				<div id="pagination" class="pagination" align="center">{$pagination}</div>
			</center>

			{include file='footer_print.tpl'}


		</div>

	</div>
</div>

<!--<center>
 	<input type="hidden" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='hidden' value='Print' onclick="print_div()" class="btn btn-danger">
</center>-->

{literal}






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


<br>
{include file='footer.tpl'}