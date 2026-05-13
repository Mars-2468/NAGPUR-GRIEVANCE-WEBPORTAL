{include file='header.tpl'}
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
    $('#example').dataTable();
    $('#myDataTable1').dataTable();
   
    }); 
    
    
    </script>
    
<div  id="div_print" style="border:#999999 0px solid;">
<CENTER><strong>CATEGORY BASIS ULB WISE SERVICES  REPORT</strong></CENTER>


    <div style="width:100%; overflow:scroll;">
	     <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
									
										<thead>
										  
										<tr class="mytr_bgcolor">
											<td rowspan="2">S.No</td>
											<td rowspan="2"> Ulbname </td>
											<td rowspan="2"> Total received </td>
											<td rowspan="2"> Total resolved </td>
											<td rowspan="2"> Total Pending </td>
											{foreach from=$service_list item=row key=cs_id}
											<td colspan="3">{$service_list[$cs_id]}</td>
											{/foreach}
											
										</tr>
										<tr>
										    {foreach from=$service_list item=row key=cs_id}
											<td >Received</td>
											<td >Resolved</td>
											<td >Pending</td>
											{/foreach}
											
										</tr>
										
										</thead>
										<tbody>
										{foreach from=$ulb_list item=row key=ulbid}
										<tr>
										    <td>{counter}</td>
										    <td><a href="ulb_service_responsetime_inner.php?ulbid={$ulbid}">{$ulb_list[$ulbid]}</a></td>
										    <td>{$recieved[$ulbid]['received']}</td>
										    <td>{$resolved[$ulbid]['resolved']}</td>
										    <td>{$pending[$ulbid]['pending']}</td>
										    {foreach from=$service_list item=row2 key=cs_id}
											<td>{$recieved[$ulbid][$cs_id].received}</td>
											<td>{$resolved[$ulbid][$cs_id].resolved}</td>
											<td>{$pending[$ulbid][$cs_id].pending}</td>
											{/foreach}
											
										   
										</tr>
										
										{/foreach}
									
										
										</tbody>
										<tfoot>
										    <td colspan="2">Total</td>
										    <td>{$recieved.received}</td>
										    <td>{$resolved['resolved']}</td>
										    <td>{$pending['pending']}</td>
										    {foreach from=$service_list item=row2 key=cs_id}
											<td>{$recieved[$cs_id].total}</td>
											<td>{$resolved[$cs_id].total}</td>
											<td>{$pending[$cs_id].total}</td>
											{/foreach}
											
										</tfoot>
										
										
									
								
									
									    
									    
			</table>
           
   			  {include file='footer_print.tpl'}
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