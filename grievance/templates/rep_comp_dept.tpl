{include file='header.tpl'}

<div  id="area" style="border:#999999 0px solid; min-height:305px; margin-top:5px;">
<CENTER><strong>VIEW COMPLAINTS DETAILS</strong></CENTER>

<table   id='example' width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" >
 <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="example">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">Department</th>
		<th align="center" valign="middle">Complaint No</th>
		<th align="center" valign="middle">Name & Mobile</th>
		<th align="center" valign="middle">Address</th>	
		<th align="center" valign="middle">Complaint Details</th>		
		<th align="center" valign="middle">Status</th>		
	    </tr>
	    </thead>
		<tbody>
		{foreach from=$data key=grievance_id item=row}
		<tr>
			<td>{counter}</td>
			<td>{$dept_list[$row.emp_dept]}</td>
			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
			<td>{$row.person_name} ({$row.mobile})</td>
			
			<td>{$row.hno},{$row.address}</td>
			<td>{$row.comp_desc}</td>
			<td>{$grievance_status_list[$row.grievance_status_id]}</td>
		</tr>
		{/foreach}
		</tbody>
	    
	  </table>
  </td>
    <td align="left" valign="top">&nbsp;</td>
 </tr>
 

</table>

</div>

<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>

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