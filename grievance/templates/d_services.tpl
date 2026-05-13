{include file='header.tpl'}

<div  id="div_print" style="border:#999999 0px solid; ">
<CENTER><strong>RECIEVED {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE REQUESTS{/if}</strong></CENTER>


    
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">{if $app_type_id eq '1'} Category {else} Department{/if}</th>
		<th align="center" valign="middle">No' of{if $app_type_id eq '1'} Complaints {else} Service Requests{/if}</th>
		
	    </tr>
	    </thead>
		<tbody>
		{foreach from=$data key=grievance_id item=row}
		
		<tr>
			<td>{counter}</td>
			
			{if $row.app_type_id eq '1'}
            <td ><label title="{$row.comp_desc}">{$cs_list[$row.cs_id]}</label></td>
            {else}
            <td ><label title="{$row.comp_desc}">{$dept_list[$row.dept_id]}</label></td>
            {/if}
			
			<td align="center"><a href="e_services.php?aptid={$app_type_id}&status={$status}&user_type={$user_type}&{if $app_type_id eq '1'}cs_id={$row.cs_id}{else}dept_id={$row.dept_id}{/if}&sla={$sla}">{$row.count}</a></td>
			
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