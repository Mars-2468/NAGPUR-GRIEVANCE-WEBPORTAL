{include file='header.tpl'}
{literal}
<script>
function del_service(cs_id,i)
{
if(confirm('Do you really want to delet this record?'))
{
$.post('ajax_del_service.php',{cs_id:cs_id},function(data)
{
	if(data==1)
	{
	alert('Record Deleted successfully');
	$("#id" + i).hide();
	}
	else
	{
	alert('Unable to update , Try again');
	}
})
}
}
function update_service(cs_id,comp_desc)
{

$("#comp_desc").val(comp_desc);
$("#cs_id").val(cs_id);
$("#area1").css('display','block');
}
function update_service2()
{
	var comp_desc=$("#comp_desc").val();
	var cs_id=$("#cs_id").val();
	
	$.post('ajax_service_update.php',{comp_desc:comp_desc,cs_id:cs_id},function(data)
	{
	if(data==1)
	{
	alert('Record updated successfully');
	$("#td" +cs_id ).text(comp_desc)
	}
	else
	{
	alert('Unable to update , Try again');
	}
	});
}
</script>
{/literal}

<div  id="area" style="border:#999999 0px solid; ">
<CENTER><strong>VIEW SERVICE/COMPLAINTS DETAILS</strong></CENTER>

<div style="display:none" id="area1">

<textarea name="comp_desc" id="comp_desc" style="width:600px;height=200px;"></textarea>


<input type="hidden" name="cs_id" id="cs_id">
<button onclick="update_service2()">Update</button>

</div>

<table   id='example' width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" >
 <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="example">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">Service Name</th>
		<th align="center" valign="middle">Department</th>
		<th align="center" valign="middle">Cut off Time</th>
		<th align="center" valign="middle">Application Fee</th>
		<th align="center" valign="middle">Fine Per day</th>
		<th align="center" valign="middle">Actions</th>	
				
	    </tr>
	    </thead>
		<tbody>
		{assign var="i" value='0'}
		{foreach from=$data key=cs_id item=row}
		<tr id="{'id'|cat:$i}">
			<td>{counter}</td>
			<td id="{'td'|cat:$cs_id}">{$row.comp_desc}<br>({$row.telugu_description})</td>
			
			<td>{$dept_list[$row.dept_id]}</td>
			<td>{$row.cutt_of_time}</td>
			<td>{$row.app_fee}</td>
			
			<td>{$row.fine_per_day}</td>
			<td>
			{if $sec_level neq 'C' && $sec_level neq 'A'}
			{if $code neq 1}
			{if $code eq '0'}
				{if $update_code[$cs_id] eq '1'}
				{if $cs_type_id eq '2'}
				<button class="btn btn-success" ><span class="fa fa-check-circle-o" onclick="update_service('{$row.cs_id}','{$row.comp_desc}',{$i})"> Update</span></button>
				{/if}
				{else}
				{if $cs_type_id eq '2'}
				<button onclick="del_service('{$row.cs_id}',{$i})" class="btn btn-danger"><span class="fa fa-pencil-square-o"> Delete</span></button>
				{/if}
				{/if}
			{else}
			{if $cs_type_id eq '2'}
			<button onclick="del_service('{$row.cs_id}',{$i})" class="btn btn-danger"><span class="fa fa-pencil-square-o"> Delete</span></button>
			{/if}
			{/if}
			
			{else}
			{if $cs_type_id eq '2'}
			<button class="btn btn-success"><span class="fa fa-check-circle-o" onclick="update_service('{$row.cs_id}','{$row.comp_desc}',{$i})"> Update</span></button>
			{/if}
			{/if}
			{/if}
			</td>
			
			
		</tr>
		{assign var="i" value=$i+1}
		{/foreach}
		</tbody>
	    
	  </table>
  </td>
    <td align="left" valign="top">&nbsp;</td>
 </tr>
 

</table>
<br>
</div>

<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>
<br>

{include file='footer.tpl'}