{include file='header.tpl'}
{literal}

<script language='javascript'>

$(document).ready(function() {
              $('#section_id').change(function(e){
		var section_id= $('#section_id').val();
		$.post("ajax_officer_responsible.php", {'section_id' : section_id},function(data){

		$('#emp_responsible').html(data)
	});
		$("#emp_responsible").val('0');
		$( "#emp_responsible" ).trigger( "change" );
	});

}); 

function validateForm()
{
	var errors=0;
	
	$(".float").each(function(){
		
		var patt=/^\d+(\.\d+)?$/;
		var val_field=$(this).val();
		
		if(!val_field.match(patt))
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});

             $(".dropdown").each(function(){
		
	
		var val_field=$(this).val();
		
		if(val_field == '0')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});

      $(".chr").each(function(){
		
	
		var val_field=$(this).val();
		
		if(val_field == ' ')
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

<div style="border:#999999 1px solid; background-color:#d4f2ff;  margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center style="color:green;"><h3>{if isset($msg)}{$msg}{/if}</h3></center>
<form name='add_section' method='POST' action='add_services.php' onSubmit="return validateForm();" >

<div class="my_heading">Add Service</div>
<div id="area">
<table width="100%" height="100%" border="1" cellspacing="5" cellpadding="6" style="border-collapse:collapse;">
<tr>
	<td>Service Description: </td>
	<td><textarea rows="4" cols="30" name='service_desc' id='service_desc' class="chr">

           </textarea></td>
</tr>
<tr>
<td>Section: </td>       
 <td>

        <select  name='section_id' id='section_id'  class="dropdown">
       <option value='0'>--Select Section--</option>
        {html_options options=$section_list selected=$section_sel}
       </select>
        </td>
       

</tr>
<tr>
	<td>Time frame (days): </td>
	<td><input type='text' name='time_frame_days' id='time_frame_days' class="float" size='20' ></td>
</tr>
<tr>
       <td>Service Fee: </td>
	<td><input type='text' name='service_fee' id='service_fee' size='20'  class="float"></td>

      

</tr>
<tr>  
         <td>Officer Responsi ble to render services: </td>
	<td>
       <select name="emp_responsible" id="emp_responsible" >
       <option value='0'>--Select Emp Responsible--</option>
          
       </select>
       </td>
</tr>
<tr>

	<td>Officer to whom a grievance/complaint be made in case of delay or default of service: </td>
	<td>

     <select  name='officer_responsible' id='officer_responsible'  class="dropdown" >
       <option value='0'>--Select Officer Responsible--</option>
        {html_options options=$designation_list selected=$designation_list }
       </select>
          </td>
       

</tr>


<tr>
	<th colspan='2'>
		<input type='submit' name='save' value='Submit' class="mybtn">
	</th>
</tr>

</table>
</div>
</form>







</div>


{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            
                            