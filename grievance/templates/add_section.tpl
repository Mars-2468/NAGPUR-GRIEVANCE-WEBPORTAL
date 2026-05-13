{include file='header.tpl'}
{literal}

<script language='javascript'>

$(document).ready(function() {

}); 

function validateForm()
{
	var errors=0;
	
	$(".chr").each(function(){
		
	
		var val_field=$(this).val();
		
		if(val_field == '')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});
		
		
		
	$(".email").each(function(){
		
		

          var patt= /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;   



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
	
	
	 $(".phone").each(function(){
		
		var patt=/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/
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

function update(section_id,section_name,section_hphone,section_hemail,head_name)
{      
       $("#section_id").val(section_id);
        $("#section_name").val(section_name);
        $("#file_type_id").val('2');
       $("#head_name").val(head_name);
        $("#section_hphone").val(section_hphone);
         $("#section_hemail").val(section_hemail);
}


</script>
{/literal}

<div style="border:#999999 1px solid; height:450px; background-color:#d4f2ff; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<form name='add_section' method='POST' action='add_section.php' onSubmit="return validateForm();" >

<div class="my_heading">Add Section</div>
<div id="area">

<br><br>
<table width="100%" height="100%" border="0" cellspacing="3" cellpadding="0">
<tr>       <input type='hidden' name='file_type_id' id='file_type_id' value='1'>
           <input type='hidden' name='section_id' id='section_id' >
	<td>Section Name : </td>
	<td><input type='text' class="chr" name='section_name' id='section_name' size='25' maxlength='30'></td>
	<td>Section Head officer name : </td>
	<td><input type='text'   name='head_name' id='head_name' size='25' maxlength='30'></td>
</tr>
<tr>
	<td>Mobile No : </td>
	<td><input type='text' class="phone" name='section_hphone' id='section_hphone' size='25' maxlength='10'></td>
	<td>Email : </td>
	<td><input type='text'class="email" name='section_hemail' id='section_hemail' size='25' maxlength='30'></td>
</tr>


<tr>
	<th colspan='4'>
		<input type='submit' name='save' value='Save Details' class="mybtn">	</th>
    </tr>
</table>
</div>
</form>

<br/><br/>
<center><h3>Sections</h3>
<table width="100%" cellspacing="0"  border="1" cellpadding="5" style="border-collapse:collapse;">
<tr style="background-color:#d1d1d1;">

<td><strong>Sno</strong></td>
<td><strong>Section Name</strong></td>
<td><strong>Section Head officer name </strong></td>
<td><strong>Mobile No</strong></td>
<td><strong>Email</strong></td>

<td><strong>Update</strong></td>
</tr>
{foreach from=$data item=row key=section_name}
 
<tr>
<td>{counter}</td>
<td> {$row.section_name}</td>
<td> {$row.head_name}</td>
<td> {$row.section_hphone}</td>
<td> {$row.section_hemail}</td>
<td align="center">

<input type='radio' name='id' id='id '  value="50" class="id" onclick="update({$row.section_id},'{$row.section_name}','{$row.section_hphone}','{$row.section_hemail}','{$row.head_name}');">
</td>
</tr>
{/foreach}


</table>
</center>
</div>


{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            
                            