{include file='corp_header.tpl'}
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

	<CENTER><strong>CATEGORY BASIS ULB WISE COMPLAINTS AVG RESPONSE TIME REPORT</strong></CENTER><br>
	<CENTER><strong>Category Name: {$current_category_name}
		</strong></CENTER>


	<div style="width:100%; overflow:scroll;">

		<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">

			<thead>

				<tr class="mytr_bgcolor">
					<td>S.No</td>
					<td> Ulbname </td>
					<td>No.of Resolved Services</td>
					<td>Services Avg Response Time[In Days]</td>

				</tr>
			</thead>
			<tbody>
				{foreach from=$ulb_list item=row key=ulbid}
				<tr>
					<td>{counter}</td>
					<td>{$ulb_list[$ulbid]}</td>
					<td>{$response_time[$ulbid]['complaints'].count}</td>
					<td>{$response_time[$ulbid]['complaints'].avg_res_time}</td>
				</tr>

				{/foreach}


			</tbody>




			<tfoot>

				<tr>

				</tr>
				<tr>
					<td>Total:</td>
					<td>--</td>


					<td>{$grand_total_complaints}</td>
					<td>{$grand_c_avg_res_time}</td>
				</tr>
			</tfoot>
		</table>

	</div>

</div>

<!--<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>

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
	
	text-decoration: none; /* no underline */
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
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

<center>
<div id="pagination" class="pagination" align="center">{$pagination}</div>
</center>
<br>
{include file='corp_footer.tpl'}