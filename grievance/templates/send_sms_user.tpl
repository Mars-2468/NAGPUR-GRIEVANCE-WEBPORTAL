{include file='header.tpl'}

<div  id="div_print" style="border:#999999 0px solid; ">
    
   <div class="boxed">
       <div class="title-bar blue"> <h4>SEND SMS TO USERS</h4></div>
       <div class="inner no-radius">
           
           {if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
			{/if}
			
			
			<form action="send_sms_user.php" method="POST" onsubmit="return validateForm()" id="sendsms">
                <div class="" style="width:100%; overflow:scroll;">
                <table   id='example' width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" >
                 <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">
                    
                	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
                	    <thead>
                	      <tr style="background-color:#2c3e50; color:#FFF;">
                		<th align="center" valign="middle">Enable/<br>Disable SMS</th>
                		
                		<th align="center" valign="middle">Reference No</th>
                		<th align="center" valign="middle">Name & Mobile</th>
                		<th align="center" valign="middle">Adress</th>	
                		<th align="center" valign="middle">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} Details</th>		
                		<th align="center" valign="middle">Status</th>
                		<th align="center" valign="middle">Received Date</th>
                		<th align="center" valign="middle">Amount</th>
                		<th align="center" valign="middle">Remarks</th>		
                	    </tr>
                	    </thead>
                	    
                		<tbody>
                		{assign var="i" value="0"}
                		{foreach from=$data key=grievance_id item=row}
                		
                		
                		<tr>
                			<td><input type="checkbox" name="check_list[]" value="{$i}" id="{'id'|cat:$i}" onclick="fun1('{$i}')"></td>
                			
                			
                			<!--<td>{$dept_list[$row.dept_id]}</td>-->
                			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
                			<td>{$row.person_name} ({$row.mobile})
                			 <input type="hidden" name="{'mobile'|cat:$i}" value="{$row.mobile}">
                			 <input type="hidden" name="{'app_name'|cat:$i}" value="{$row.person_name}">
                			<input type="hidden" name="{'subject'|cat:$i}" value="{$cs_list[$row.cat3_id]}">
                			 </td>
                			
                			<td>{$row.hno},{$row.address}</td>
                			<td>{$cs_list[$row.cat3_id]}</td>
                			<td>{$grievance_status_list[$row.grievance_status_id]}</td>
                			<td>{$row.date_regd|date_format:"%d-%m-%Y"}</td>
                			<td><input type="text" name="{'fees'|cat:$i}" id="{'fees'|cat:$i}" style="width:100px;"  disabled></td>
                			<td><textarea name="{'remarks'|cat:$i}" id="{'remarks'|cat:$i}" disabled></textarea></td>
                		</tr>
                		{assign var="i" value=$i+1}
                		{/foreach}
                		</tbody>
                	    
                	  </table>
                  </td>
                    <td align="left" valign="top">&nbsp;</td>
                 </tr>
                 
                
                </table>
                </div>
                <br>
                <center>
                <input type="submit" name="send_sms" value="Send SMS" class="btn btn-success btn-sm">
                </center>
                
                </form>
           
       </div>
       
   </div> 
    
    
    
    



</div>

<!--<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>-->
<br>

{include file='footer.tpl'}

{literal}
<script>
function fun1(i)
{
if(document.getElementById("id" + i).checked) {
    $("#fees" + i).removeAttr('disabled',false)
    $("#remarks" + i).removeAttr('disabled',false)
    $("#fees" + i).addClass('mytext');
    $("#remarks" + i).addClass('mytext');
    
} else {
    $("#fees" + i).attr('disabled',true)
    $("#remarks" + i).attr('disabled',true)
    $("#fees" + i).removeClass('mytext');
    $("#remarks" + i).removeClass('mytext');
}
}
function validateForm()
{

	if ($("#sendsms input:checkbox:checked").length > 0)
		{
			errors=0;
			
			$(".mytext").each(function(){
		
			var val_field=$(this).val();
			if(val_field=='')
			{
				($(this)).css({"background-color": "pink"});
				errors++;
			}
			else
			{
				($(this)).css({"background-color": "white"});
			}
			});
			
			if(errors==0)
			{
				return true;
			}
			else
			{
				alert("Please Enter Correct Value in High-lighted Fields - "+errors );
				return false;
			}
		}
		else
		{
		   alert('check any one of check box');
		   return false;
		   
		}
		
		


}
</script>
{/literal}