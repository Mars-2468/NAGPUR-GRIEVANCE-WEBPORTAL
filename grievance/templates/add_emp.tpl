{include file='header.tpl'}
{literal}

<script language='javascript'>

$(document).ready(function() {

}); 

function validateForm()
{
	var errors=0;
	
	var emp_id=document.add_emp.emp_id.value;
	var patt1= /^\d{10}$/;
	if(!patt1.test(emp_id))
    	{
		($('#emp_id')).css({"background-color": "pink"});
		errors++;    	
	}
	else
		($('#emp_id')).css({"background-color": "white"});
	
	$(".int").each(function(){
		if(!$(this).prop('disabled'))
		{
			if((isNaN($(this).val()))||(parseInt($(this).val())<0)||($(this).val()=='')) 
			{
				($(this)).css({"background-color": "pink"});
				errors++;
			}
			else if(Math.floor($(this).val()) != $(this).val())
			{
				($(this)).css({"background-color": "pink"});
				errors++;
			}
			else
			{
				($(this)).css({"background-color": "white"});
			}
		}


	});
	
	$(".combo").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='0')
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

<div style="border:#999999 1px solid; height:350px; margin-top:5px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<form name='add_emp' method='POST' action='add_emp.php' onSubmit="return validateForm();" >

<center><h3>Add New Employee</h3></center>
<br/><br/>
<div id="area">
<table width="100%" height="100%" border="0" cellspacing="3" cellpadding="0">
<tr>
	<td>Employee Name : </td>
	<td><input type='text' name='emp_name' id='emp_name' size='50' maxlength='100'></td>

</tr>


<tr>
	<td>Employee Section : </td>
	<td>
	<select name='section_id' id='section_id' class="combo">
	<option value='0'>--Select--</option>
	{html_options options=$section_list}
</select>
	</td>

</tr>



<tr>
	<th colspan='2'>
		<input type='submit' name='save' value='Add Details'>
	</th>
</tr>

</table>
</div>
</form>


</div>


{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            
                            