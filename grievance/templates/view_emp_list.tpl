{include file='header.tpl'}

<div style="border:#999999 1px solid; margin-top:5px;">

<center>

	{if isset($data)}
		<div id="area">
		<table border='1' id='example' width="100%" border="1" cellpadding="2">
			<tr>
				<th>S.No</th>
				<th>EMP ID</th>
				<th>Name</th>
				<th>Section</th>
				<th>Work Location</th>
				<th>Category</th>
			</tr>
			

			{foreach from=$data item=row key=emp_id}
			<tr>
				<td>{counter}</td>
				<td>{$emp_id}</td>
				<td>{$row.emp_name}</td>
				<td>{$section_list[$row.section_id]}</td>
				<td>{$division_list[$row.emp_div]}</td>
				<td>{$emp_cat_list[$row.emp_cat]}</td>

			</tr>
			{/foreach}

		</table>
	</div>
	{include file='footer_print.tpl'}
	{else}
	<h3>No Data Found</h3>
	{/if}
</center>
</div>
{include file='footer.tpl'}
                            
                            
                            
                            
                            