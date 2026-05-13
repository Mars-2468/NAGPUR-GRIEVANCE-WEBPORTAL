{include file='header.tpl'}
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
    $('#example').dataTable();
    $('#myDataTable1').dataTable();
   
    });  </script>
<div  id="div_print" style="border:#999999 0px solid;">
<CENTER><strong>VIEW SERVICE DETAILS</strong></CENTER>


    <div style="width:100%; overflow:scroll;">
	     <table class="table table-striped table-bordered table-hover table-full-width" id="example">
									
										<thead>
										  
										<tr class="mytr_bgcolor">
											<td rowspan="2">S.No</td>
											{if $app_type_id eq '1'}
											<td rowspan="2">Category Type</td>
											{else}
											<td rowspan="2"></td>
											{/if}
											<td rowspan="2">Service </td>
											<td rowspan="2">Received</td>
											
											<td colspan="2" align="center">Resolved</td>
											<td colspan="2" align="center">Pending</td>
											<td rowspan="2">Financial Implications</td>
											<td rowspan="2">% of Complete</td>
											
											
										</tr>
										
										
									
									<tr class="mytr_bgcolor">
									<td align="center">With in SLA</td>
									<td align="center">Beyond SLA</td>
									<td align="center">With in SLA</td>
									<td align="center">Beyond SLA</td>
									
									</tr>
									</thead>
									<tbody>
									    {foreach from=$cs_list item=row key=cs_id}
									    <tr>
									        <td>{counter}</td>
									        <td>{$cat_list[$cat_id]}</td>
									        <td>{$cs_list[$cs_id]}</td>
									        <td>{$data[$cs_id].total_received}</td>
									        
									        
									        <td>{$data[$cs_id].resolved_within_sla}</td>
									        <td>{$data[$cs_id].resolved_beyond_sla}</td>
									        
									        <td>{$data[$cs_id].pending_within_sla}</td>
									        <td>{$data[$cs_id].pending_beyond_sla}</td>
									        
									        <td>{$data[$cs_id].fin_implication}</td>
									        <td>{$data[$cs_id].percent}</td>
									    </tr>
									    {/foreach}
									</tbody>
									<tfoot>
									    
									     <tr>
									        <td colspan="3">Total</td>
									       
									        <td>{$tot.total_received}</td>
									        
									        
									        <td>{$tot.resolved_within_sla}</td>
									        <td>{$tot.resolved_beyond_sla}</td>
									        
									        <td>{$tot.pending_within_sla}</td>
									        <td>{$tot.pending_beyond_sla}</td>
									        
									        <td>{$tot.fin_implication}</td>
									        <td>{$tot.percent}</td>
									    </tr>
									    
									</tfoot>
			</table>
           
   			  
 </div>

</div>

<!--<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
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