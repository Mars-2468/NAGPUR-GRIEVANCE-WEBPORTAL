{include file='header.tpl'}
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
    $('#example').dataTable();
    $('#myDataTable1').dataTable();
   
    });  </script>
<div  id="div_print" style="border:#999999 0px solid;">
<CENTER><strong>VIEW COMPLAINTS DETAILS</strong></CENTER>
<br><br>

    <div style="width:100%; overflow:scroll;">
	     <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
									
										<thead>
										  
										<tr class="mytr_bgcolor">
											<td rowspan="2">S.No</td>
											<td rowspan="2">Ulbname</td>
											
											{foreach from=$cs_list item=row key=cs_id}
											<td colspan="3">{$cs_list[$cs_id]}</td>
												{/foreach}
										</tr>
										
										<tr>
										 
										 {foreach from=$cs_list item=row key=cs_id}
										   <td rowspan="2">Received</td>
											<td rowspan="2">Resolved</td>
											<td rowspan="2">Pending</td> 
										 {/foreach}
										    
										</tr>
										
									
									
									</thead>
									<tbody>
									    {foreach from=$ulb_list item=row key=ulbid}
									    <tr>
									        <td>{counter}</td>
									       <td>{$ulb_list[$ulbid]}</td>
									       
									       	{foreach from=$cs_list item=row2 key=cs_id}
									        <td>{$data[$ulbid][$cs_id].total_received}</td>
									        <td>{$data[$ulbid][$cs_id].resolved_within_sla}</td>
									        <td>{$data[$ulbid][$cs_id].pending_within_sla}</td>
									       
									        {/foreach}
			  
									    </tr>
									    {/foreach}
									</tbody>
									<tfoot>
									    
									    
									        <td colspan="2">Total</td>
									       	{foreach from=$cs_list item=row3 key=cs_id}
									        <td>{$tot[$cs_id].total_received}</td>
									        <td>{$tot[$cs_id].resolved_within_sla}</td>
									        <td>{$tot[$cs_id].pending_within_sla}</td>
									        
									        {/foreach}
									   
									    
									</tfoot>
			</table>
           
   			  {include file='footer_print.tpl'}
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