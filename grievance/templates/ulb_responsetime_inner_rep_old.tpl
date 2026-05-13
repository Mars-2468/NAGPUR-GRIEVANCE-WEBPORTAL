{include file='header.tpl'}
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript">
	$(document).ready(function() {
		$('#example').dataTable();
		$('#myDataTable1').dataTable();

	});
</script>

<div>

</div>

<div class="title-bar blue d-flex align-items-right justify-content-between mb-3">
	<h4></h4>
	<!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
	<p class="m-0"><a href="ulb_comp_resp_rep.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
</div>

<div id="div_print" style="border:#999999 0px solid;">
	<!-- <CENTER><strong>CATEGORY WISE COMPLAINTS AVG RESPONSE TIME</strong></CENTER> -->


	<div style="width:100%; overflow:scroll;">
		<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
			<caption style="caption-side:top; text-align:center;font-size:16px;">
				<b>
					<CENTER><strong>CATEGORY WISE COMPLAINTS AVG RESPONSE TIME</strong></CENTER>
				</b>
			</caption>
			<thead>

				<tr class="mytr_bgcolor">
					<td align='center'>S.No</td>
					<td align='center'> Category Name </td>
					<td align='center'>No. of Resolved Complaints</td>
					<td align='center'>Complaints Avg Response Time[In Days]</td>


				</tr>
			</thead>
			<tbody>
				{foreach from=$cat_list item=row key=cs_id}
				<tr>
					<td align='center'>{counter}</td>
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="category-basis-ulb-wise-complaints-response-time.php?cat_id={$cs_id}" target="_blank">{$cat_list[$cs_id]}</a></td>
					<td align='center'>{$ulbtotalcomplaints[$cs_id]['complaints'].count}</td>
					<td align='center'>{$response_time[$cs_id]['complaints'].avg_res_time}</td>

				</tr>

				{/foreach}


			</tbody>

			<tfoot>

				<tr>

				</tr>
				<tr>
					<td align='center' colspan='2'>Total</td>
					<!-- <td align='center'>--</td> -->
					<td align='center'>{$grand_total_complaints}</td>
					<td align='center'>{$grand_c_avg_res_time}</td>

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
{include file='footer.tpl'}