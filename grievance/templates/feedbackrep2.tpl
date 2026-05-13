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
<CENTER><strong>FEEDBACK DETAILS</strong></CENTER>


    <div style="width:100%; overflow:scroll;">
	     <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
									
										<thead>
										  
										<tr class="mytr_bgcolor">
											<td>S.No</td>
											<td> Ulbname </td>
											<td>Excellent</td>
											<td>Good</td>
											{foreach from=$feedback_sub_options item=row key=sub_option_id}
											<td>{$feedback_sub_options[$sub_option_id]}</td>
											
											{/foreach}
											<td>Others</td>
										
											
											
										</tr>
										</thead>
										<tbody>
										{foreach from=$ulb_list item=row key=ulbid}
										<tr>
										    <td>{counter}</td>
										    <td><a href="feedback_dept_rep.php?ulbid={$ulbid}">{$ulb_list[$ulbid]}</a></td>
										    <td>{$feedback_count[$ulbid][5].count}</td>
										    <td>{$feedback_count[$ulbid][4].count}</td>
										    {foreach from=$feedback_sub_options item=row key=sub_option_id}
											<td>{$feedback_count[$ulbid][$sub_option_id].count}</td>
											
											{/foreach}
											<td>{$feedback_count[$ulbid][14].count}</td>
										    
										</tr>
										
										{/foreach}
										</tbody>
										
										
									
								
									<tfoot>
									    
									     <tr>
									         <td colspan="2"> Total </td>
									         <td>{$tot[5].tot}</td>
									         <td>{$tot[4].tot}</td>
									         {foreach from=$feedback_sub_options item=row key=sub_option_id}
											<td>{$tot[$sub_option_id].tot}</td>
											
											{/foreach}
									         <td>{$tot[14].tot}</td>
									       
									    </tr>
									    
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