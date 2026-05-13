{include file='header.tpl'}

<div  id="div_print" style="border:#999999 0px solid;">
    
     <div class="title-bar white">
                  <h4>
                      Department wise report -{$emp_list[$emp_id]} - {$dept_list[$dept_id]} - {$ulb_list[$ulbid]}
                  </h4>
                  
    </div>
<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE {/if} DETAILS</strong></CENTER>


    <div style="width:100%; overflow:scroll;">
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		
		<th align="center" valign="middle">Reference No</th>
		<th align="center" valign="middle">Name & Mobile</th>
		<th align="center" valign="middle">Adress</th>	
		<th align="center" valign="middle">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} Details</th>		
		<th align="center" valign="middle">Status</th>
		<th align="center" valign="middle">Received Date</th>
		<th align="center" valign="middle">Re-opened Date</th>
		<th align="center" valign="middle">Disposed Date</th>
	    <th align="center" valign="middle" colspan="2">File Movement</th>		
	    </tr>
	    </thead>
		<tbody>
		{foreach from=$data key=grievance_id item=row}
		<tr>
			<td>{counter}</td>
			
		
			<!--<td>{$dept_list[$row.dept_id]}</td>-->
			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
			<td>{$row.person_name} ({$row.mobile})</td>
			
			<td>{$row.hno},{$row.address}</td>
			<td>{$cs_list[$row.cat3_id]} {if $app_type_id eq '1'} - {$row.comp_desc} {/if}</td>
			
			<td>{$status_list[$row.grievance_status_id]}</td>
			<td>{$row.date_regd|date_format:"%d-%m-%Y %H:%M:%S"}</td>
			<td>{$row.alloted_date|date_format:"%d-%m-%Y %H:%M:%S"}</td>
			<td>{$row.disposed_date|date_format:"%d-%m-%Y %H:%M:%S"}</td>
			<td>
			    <a href="file_movment.php?gid={$grievance_id}">Click here</a>
		    </td>
		</tr>
		{/foreach}
		</tbody>
	    
	  </table>
 </div>

</div>
{include file='footer_print.tpl'}
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