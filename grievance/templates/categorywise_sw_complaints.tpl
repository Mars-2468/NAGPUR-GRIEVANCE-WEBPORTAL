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
<CENTER><strong> Swachhta statistics </strong></CENTER>

<div style="display:none" id="area1">

<textarea name="comp_desc" id="comp_desc" style="width:600px;height=200px;"></textarea>


<input type="hidden" name="cs_id" id="cs_id">
<button onclick="update_service2()">Update</button>

</div>
<!--
<table   id='example' width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" >
 <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="example">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle" rowspan="2">S.No</th>
		<th align="center" valign="middle" rowspan="2">Category</th>
		
		<th align="center" valign="middle" rowspan="2">Complaints Posted</th>
		<th align="center" valign="middle" rowspan="2">Complaints Available</th>
		
		<th align="center" valign="middle" colspan='5'><center>ULB Dashboard</center></th>
		<th align="center" valign="middle" colspan='5'><center>Swachhta Dashboard</center></th>
		</tr>
		<tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">Received at ulb</th>
		<th align="center" valign="middle">Pending at ulb</th>
		<th align="center" valign="middle">On job at ulb</th>
		<th align="center" valign="middle">Resolved at ulb</th>
		<th align="center" valign="middle">Rejected</th>
		<th align="center" valign="middle">Posted to swachhta dashboard</th>
		<th align="center" valign="middle">Open complaint</th>
		<th align="center" valign="middle">On the job</th>
		<th align="center" valign="middle">Resolved</th>
		<th align="center" valign="middle">Rejected</th>
	
				
	    </tr>
	    
	   
	    </thead>
		<tbody>
		{assign var="i" value='0'}
		{foreach from=$cs_list key=ulbid item=row}
		<tr>
			<td></td>
			<td><a href="#">{$cs_list[$ulbid]}</a></td>
			<td>{$ulbsdata[$ulbid].posted}</td>
			<td>{$ulbsdata[$ulbid].received_ulb-$ulbsdata[$ulbid].posted}</td>
			<td>{$ulbsdata[$ulbid].received_ulb}</td>
			<td>{$ulbsdata[$ulbid].pending}</td>
			<td>{$ulbsdata[$ulbid].underprogress}</td>
			<td>{$ulbsdata[$ulbid].resolved}</td>
			<td>{$ulbsdata[$ulbid].rejected}</td>
			<td>{$ulbsdata[$ulbid].posted}</td>
			<td>{$ulbsdata[$ulbid].opencomplaint}</td>
			<td>{$ulbsdata[$ulbid].onjob}</td>
			<td>{$ulbsdata[$ulbid].completed}</td>
			<td>{$ulbsdata[$ulbid].sw_rejected}</td>
			
			
		</tr>
		 
		{assign var="i" value=$i+1}
		{/foreach}
		<tr>
	       <th align="center" valign="middle">Total</th> 
	       <td></td>
	       <td>{$totals.posted}</td>
	        <td>{$totals.received_ulb-$totals.posted}</td>
	       
	       <td>{$totals.received_ulb}</td>
	       <td>{$totals.pending}</td>
	       <td>{$totals.underprogress}</td>
	       <td>{$totals.resolved}</td>
	       <td>{$totals.rejected}</td>
	       <td>{$totals.posted}</td>
	       <td>{$totals.opencomplaint}</td>
	       <td>{$totals.onjob}</td>
	       <td>{$totals.completed}</td>
	       <td>{$totals.sw_rejected}</td>
	    </tr>
		</tbody>
	    
	  </table>
  </td>
    <td align="left" valign="top">&nbsp;</td>
 </tr>
 

</table>-->

<table   id='example' width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" >
 <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="example">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle" rowspan="2">S.No</th>
		<th align="center" valign="middle" rowspan="2">Category</th>
		<th align="center" valign="middle" rowspan="2">Complaints Posted</th>
		
	
				
	    </tr>
	    
	   
	    </thead>
		<tbody>
		{assign var="i" value='0'}
		{foreach from=$cs_list key=ulbid item=row}
		<tr>
			<td>{counter}</td>
			<td><a href="#">{$cs_list[$ulbid]}</a></td>
			<td>{$ulbsdata[$ulbid].posted_to}</td>
		</tr>
		 
		{assign var="i" value=$i+1}
		{/foreach}
		<tr>
	       <th align="center" valign="middle">Total</th> 
	       <td></td>
	       <td>{$totals.posted_to}</td>
	        
	    </tr>
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
	
</center>
<br>

{include file='footer.tpl'}