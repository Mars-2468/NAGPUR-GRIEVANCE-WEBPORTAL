{include file='header.tpl'}
<div style="text-align:right;"><button class="btn btn-warning" onclick="history.go(-1);"><i class="fa fa-backward"></i> Back</button></div>
<div><h4>ULB name : {$ulbname}</h4></div>
<div  id="div_print" style="border:#999999 0px solid;">
<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</strong></CENTER>


    <div style="width:100%; overflow:scroll;">
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">{if $app_type_id eq '1'} Category {else} Department{/if}</th>
		<th align="center" valign="middle">Reference No</th>
		<th align="center" valign="middle">e-office No</th>
		<th align="center" valign="middle">Name & Mobile</th>
		<th align="center" valign="middle">Adress</th>	
		<th align="center" valign="middle">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} Details</th>		
		<th align="center" valign="middle">Status</th>
		<th align="center" valign="middle">Received Date</th>
		<th align="center" valign="middle">No.of Disposable days</th>
		<th align="center" valign="middle">To be completed date</th>
		<th align="center" valign="middle">Completed Date</th>
		<th align="center" valign="middle">No.of days exceeded</th>
		
		<th align="center" valign="middle" colspan="2">Actions</th>		
	    </tr>
	    </thead>
		<tbody>
		{foreach from=$data key=grievance_id item=row}
		<tr>
			<td>{counter}</td>
			
		    {if $row.app_type_id eq '1'}
		    <td ><label title="{$row.comp_desc}"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$cs_list[$row.cat3_id]}</a></label></td>
		    {else}
            <td ><label title="{$row.comp_desc}"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$dept_list[$row.emp_dept]}</a></label></td>
            {/if}
            
			<!--<td>{$dept_list[$row.dept_id]}</td>-->
			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$row.eoffice_no}</a></td>
			<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$row.person_name} ({$row.mobile})</a></td>
			
			<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$row.hno},{$row.address}</a></td>
			<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$cs_list[$row.cat3_id]}</a></td>
			
			<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_status_list[$row.grievance_status_id]}</a></td>
			
			
			<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$row.date_regd|date_format:"%d-%m-%Y"}</a></td>
			<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$row.target_days}</a></td>
			<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$row.comp_date|date_format:"%d-%m-%Y"}</a></td>
			<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$row.disposed_date|date_format:"%d-%m-%Y"}</a></td>
			<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$row.no_of_days_exeed}</a></td>
			
		
			<td>
			{if $ulbid eq '207'}
			{if $row.app_type_id eq '2'}
			<a href="receive_print_boduppal.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
			{else}
			<a href="receive_print_boduppal.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
			{/if}
			
			{else}
			{if $row.app_type_id eq '2'}
			<a href="receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
			{else}
			<a href="receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
			{/if}
			{/if}
			
			{if $row.grievance_status_id eq '2'}
			
			
		
	
			
			{/if}
		
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