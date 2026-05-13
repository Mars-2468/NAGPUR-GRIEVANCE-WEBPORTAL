{include file='header.tpl'}

<div  id="div_print" style="border:#999999 0px solid; ">
<CENTER><strong>RECIEVED {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE REQUESTS{/if}</strong></CENTER>

<table   id='example' width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" >
 <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">{if $app_type_id eq '1'} Category {else} Department{/if}</th>
		<th align="center" valign="middle">Reference No</th>
		<th align="center" valign="middle">Name & Mobile</th>
		<th align="center" valign="middle">Adress</th>	
		<th align="center" valign="middle">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} Details</th>		
		<th align="center" valign="middle">Status</th>
		<th align="center" valign="middle">Actions</th>		
	    </tr>
	    </thead>
		<tbody>
		{foreach from=$data key=grievance_id item=row}
		<tr>
			<td>{counter}</td>
			
			{if $row.app_type_id eq '1'}
            <td ><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
            {else}
            <td ><label title="{$row.comp_desc}">{$dept_list[$row.dept_id]}</label></td>
            {/if}
			<!--<td>{$dept_list[$row.dept_id]}</td>-->
			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
			<td>{$row.person_name} ({$row.mobile})</td>
			
			<td>{$row.hno},{$row.address}</td>
			<td>{$cs_list[$row.cat3_id]}</td>
			<td>{$grievance_status_list[$row.grievance_status_id]}</td>
			<td>
			{if $ulbid eq '207'}
			{if $row.app_type_id eq '2'}
			<a href="receive_print_boduppal.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Reeceipt</a>
			{else}
			<a href="receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Reeceipt</a>
			{/if}
			{else}
			{if $row.app_type_id eq '2'}
			<a href="receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Reeceipt</a>
			{else}
			<a href="receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Reeceipt</a>
			{/if}
			{/if}
			</td>
		</tr>
		{/foreach}
		</tbody>
	    
	  </table>
  </td>
    <td align="left" valign="top">&nbsp;</td>
 </tr>
 

</table>

</div>
{include file='footer_print.tpl'}
<!--<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>-->
<br>
{literal}

<script language="javascript" type="text/javascript">
	var table2_Props = 	{
							col_0: "none",
							col_1: "none",
							col_2: "none",
							col_3: "none",
							col_4: "none",
							col_5: "none",
							col_6: "none",
							col_7: "none",
							display_all_text: " [ Show all ] ",
							sort_select: true ,
							paging: true ,
							paging_length:5,
							alternate_rows: false
						};
	setFilterGrid( "example",table2_Props );

</script>





{/literal}
{include file='footer.tpl'}