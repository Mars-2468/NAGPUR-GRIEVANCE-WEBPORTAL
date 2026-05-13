{include file='header.tpl'}

<div  id="div_print" style="border:#999999 0px solid; ">
<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</strong></CENTER>


    
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">Mode Of Application</th>
		<th align="center" valign="middle">{if $app_type_id eq '1'} Category {else} Department{/if}</th>
		<th align="center" valign="middle">Employee Name</th>
		<th align="center" valign="middle">Total</th>
			
	    </tr>
	    </thead>
		<tbody>
		{foreach from=$data key=grievance_id item=row}
		<tr>
		   
			<td>{counter}</td>
			{if $origin_id eq '0'}
			<td>{$origin_list['1']}</td>
			{else}
			<td>{$origin_list[$origin_id]}</td>
			{/if}
			{if $row.app_type_id eq '1'}
            <td ><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
            {else}
            <td ><label title="{$row.comp_desc}">{$dept_list[$row.dept_id]}</label></td>
            {/if}
			<td>{$emp_list[$row.emp_id]}</td>
			<td align="center"><a href="origin.php?ulbid={$ulbid}&originid={$row.grievance_origin_id}&cat3_id={$row.cat3_id}&emp_id={$row.emp_id}&grievance_status_id={$gstatus_id}">{$row.count}</a></td>
			
		</tr>
		{/foreach}
		</tbody>
	    
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