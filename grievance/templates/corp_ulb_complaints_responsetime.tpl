{include file='corp_header.tpl'}

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').dataTable();
		$('#myDataTable1').dataTable();

	});
</script>

<div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
	<h4>Complaints Response Report</h4>
	<!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
	<p class="m-0"><a href="corp_reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
</div>

<div id="div_print" style="border:#999999 0px solid;">
	<!-- <CENTER><strong> COMPLAINTS AVG RESPONSE TIME REPORT</strong></CENTER> -->

	<div style="width:100%; overflow:scroll;">
		<div id="area">
			<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
				<caption style="caption-side:top; text-align:center;font-size:16px;">
					<b>
						<CENTER><strong>VIEW COMPLAINTS AVG RESPONSE TIME REPORT DETAILS</strong></CENTER>
					</b>
				</caption>
				<thead>

					<tr class="mytr_bgcolor" style="text-align:center;font-weight:bold;">
						<td>S.No</td>
						<td> </td>
						<td>NO. OF RESOLVED GRIEVANCES</td>
						<td>GRIEVANCES AVG RESPONSE TIME[IN DAYS]</td>
					</tr>
				</thead>
				<tbody>
					{foreach from=$ulb_list item=row key=ulbid}
					<tr style="text-align:center;">
						<td>{counter}</td>
						<td class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="corp_ulb_responsetime_inner_rep.php?app_type_id=1&ulbid={$ulbid}&f_date={$fdate}&t_date={$tdate}"> {$ulb_list[$ulbid]} </a></td>
						<td>{$ulbtotalcomplaints[$ulbid]['complaints'].count}</td>
						<td>{$response_time[$ulbid]['complaints'].avg_res_time}</td>

					</tr>

					{/foreach}


				</tbody>

				<tfoot>

					<!-- <tr>

					</tr> -->
					<tr style="text-align:center;">
						<!-- <td>Total:</td>
						<td>--</td> -->
						<td colspan="2"><strong>Total</strong></td>
						<td><strong>{$grand_total_complaints}</strong></td>
						<td><strong>{$grand_c_avg_res_time}</strong></td>

					</tr>
				</tfoot>
			</table>
		</div>
		
	</div>
</div>

<center>
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