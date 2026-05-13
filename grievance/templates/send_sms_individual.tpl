{include file='header.tpl'}
<div id="area"  >

{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}






<div class="boxed">
    
    <div class=""></div>
    <div class="inner no-radius">
        
        <form action="send_sms_individual.php"  method="post">

			<label class="col-md-2 col-md-offset-2 control-label">Reference No:</label>
			
			<div class="col-md-3" ><input type="text" name="ref_no" id="ref_no" class="form-control"></div>
			
			<div class="col-md-2" ><input type="submit" name="search" value="Search" class="btn btn-success"></div>
		

</form>
        
    </div>
</div>



{if isset($data)}
<form action="send_sms_individual.php"  method="post" onsubmit="return validateForm()">
<input type="hidden" name="app_type_id" value="{$data.app_type_id}">
<input type="hidden" name="mobile" value="{$data.mobile}">
<input type="hidden" name="app_name" value="{$data.person_name}">
<input type="hidden" name="subject" value="{$cat3_list[$data.cat3_id]}">


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table  ">
 <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    
<table width="97%" border="0" cellspacing="2" cellpadding="0" class="display table table-striped table-bordered table-hover table-full-width dataTable" id="example" >
      <tr style="background-color:#2c3e50; color:#FFF;">
        <th colspan='9' height="15" align="center" valign="middle">SERVICE DETAILS</td>
    </tr>


      <tr>
        <th height="15" align="left" valign="middle"  >Reference No</th>
        <td align="left" valign="middle">{$data.grievance_id}</td>
    </tr>

      <tr>
        <th height="15" align="left" valign="middle"  >Name</th>
        <td align="left" valign="middle">{$data.person_name}</td>
    </tr>

      <tr>
         <th height="15" align="left" valign="middle"  >Mobile</th>
        <td align="left" valign="middle">{$data.mobile}</td>
    </tr>

      <tr>
        <th height="15" align="left" valign="middle"  >Address</th>
        <td align="left" valign="middle">{$data.hno},{$data.address}, Locality : {$street_list[$data.street_id]} , Ward : {$ward_list[$data.ward_id]}</td>
    </tr>
     <tr>
        <th height="15" align="left" valign="middle"  >email</th>
        <td align="left" valign="middle">{$data.email}</td>
    </tr>    
    
      <tr>
        <th height="15" align="left" valign="middle"  >Received Through</th>
        <td align="left" valign="middle">{$grievance_origin_list[$data.grievance_origin_id]}</td>
    </tr>

      <tr>
         <th height="15" align="left" valign="middle"  >Subject</th>
        <td align="left" valign="middle">{$cat3_list[$data.cat3_id]}</td>
    </tr>    

      <tr>
        <th height="15" align="left" valign="middle"  >Description</th>
        <td align="left" valign="middle">{$data.comp_desc}</td>
    </tr>
       <tr>
        <th height="15" align="left" valign="middle"  >Status</th>
        <td align="left" valign="middle">{$grievance_status_list[$data.grievance_status_id]}</td>
    </tr>
    
     <tr>
        <th height="15" align="left" valign="middle"  >Photo</th>
        <td align="left" valign="middle">{if $data.file_url neq ''}<img src='{$data.file_url}' width="100px" height="100px">{else} Photo Not Uploaded {/if}</td>
    </tr>


     <tr>
        <th height="15" align="left" valign="middle"  >Fee</th>
        <td align="left" valign="middle"><input type="text" name="fee" id="fee" class="num mytext"></td>
    </tr>
    <tr>
        <th height="15" align="left" valign="middle"  >Message</th>
        <td align="left" valign="middle"><textarea name="message" id="message" style="width:200px;height:75px;"></textarea></td>
    </tr>
    
     <tr>
        <th height="15" align="left" valign="middle"  ></th>
        <td align="left" valign="middle"><input type="submit" name="send_sms" value="Send SMS"></td>
    </tr>
   
    
 
    
</table>
  </td>
    <td align="left" valign="top">&nbsp;</td>
 </tr>
 </table>
 </form>
{/if} 



</div>
<br>


<br>

{include file='footer.tpl'}
{literal}
<script>
$(document).ready(function() {

$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });
}); 

function validateForm()
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
</script>
{/literal}