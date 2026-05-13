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

<center><a href="swapp_ulb_rep.php" class="btn btn-success">ULB WISE STATISTICS</a></center>
<br><br>
<div id="idea">
<div class="boxed">
    
    <div class="title-bar blue"><h4>Swachhta statistics</h4></div>
    <div class="inner no-radius">
        
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
		<th align="center" valign="middle">Complaint Description</th>
		<th align="center" valign="middle">Received at ulb</th>
		<th align="center" valign="middle">Posted to swachhta dashboard</th>
		<th align="center" valign="middle">Pending</th>
		<th align="center" valign="middle">Resolved</th>
		<th align="center" valign="middle">Rejected</th>
		<!--<th align="center" valign="middle">Total</th>	-->
				
	    </tr>
	    
	   
	    </thead>
		<tbody>
		{assign var="i" value='0'}
		{foreach from=$cs_list key=cs_id item=row}
		<tr>
			<td>{counter}</td>
			<td><a href="swapp_details.php?cs_id={$cs_id}&ulbid={$ulbid}" target="_blank">{$cs_list[$cs_id]}</a></td>
			<td><a href="swapp_details_atul.php?cs_id={$cs_id}&ulbid={$ulbid}">{$received_ulb[$cs_id].count}</a></td>
			<td>{$received[$cs_id].count}</td>
			<td>{$pending[$cs_id].count}</td>
			<td>{$resolved[$cs_id].count}</td>
			<td>{$rejected[$cs_id].count}</td>
			<!--<td>{$tot1[$cs_id].count}</td>-->
			
			
		</tr>
		 
		{assign var="i" value=$i+1}
		{/foreach}
		<tr>
	       <th align="center" valign="middle">Total</th> 
	       <td></td>
	       <td>{$received_ulbtotal}</td>
	       <td>{$tot1}</td>
	       <td>{$tot2}</td>
	       <td>{$tot3}</td>
	       <td>{$tot4}</td>
	    </tr>
		</tbody>
	    
	  </table>
  </td>
    <td align="left" valign="top">&nbsp;</td>
 </tr>
 

</table>
        
    </div>
</div>
</div>



<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	
</center>
<br>

{include file='footer.tpl'}