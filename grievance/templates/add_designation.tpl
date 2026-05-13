{include file='header.tpl'}
{literal}

<script language='javascript'>

$(document).ready(function() {

}); 

function validateForm()
{
	var errors=0;
	
	var designation_desc=document.add_designation.designation_desc.value;
	var patt1= /^[A-Za-z ]{3,}$/;
	
	if(!patt1.test(designation_desc))
    	{
		($('#designation_desc')).css({"background-color": "pink"});
		errors++;    	
	}
	else
		($('#designation_desc')).css({"background-color": "white"});
	
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

<div style="border:#999999 1px solid; background-color:#d4f2ff; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<form name='add_designation' method='POST' action='add_designation.php' onSubmit="return validateForm();" >

<div class="my_heading">Add Designation</div>
<div id="area">
<br>
<br>

<table width="100%" height="30%" border="0" cellspacing="3" cellpadding="0">


<tr>
	<td>Designation Name : </td>
	<td><input type='text' name='designation_desc' id='designation_desc' size='50' maxlength='100'></td>


	<td>Applicable Section : </td>
	<td>
		<select name="section_id" id="section_id">
			<option value='0'>--All Sections--</option>
			{html_options options=$section_list}
		</select>
	</td>

</tr>

<tr>
	<th colspan='4'>
		<input type='submit' name='save' value='Add Details' class="mybtn">
	</th>
</tr>

</table>
</div>
</form>

<center><h3>Designations</h3></center>
<table id="example" width="100%" height="60%" border="1" cellspacing="3" cellpadding="0" style="border-collapse:collapse;">
<tr style="background-color:#d1d1d1;">
	<th>S.No</th>
	<th>Section</th>
	<th>Designation</th>
</tr>

{foreach from=$designation_list item=row key=designation_id}
<tr>
	<td>{counter}</td>
	<td>{$section_list[$row.section_id]}</td>
	<td>{$row.designation_desc}</td>
</tr>
{/foreach}

</table>

</div>


{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            
                            