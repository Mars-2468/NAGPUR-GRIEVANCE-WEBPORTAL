{include file='header.tpl'}
{literal}
<style>
td
{
width:250px;
}
* {
	margin: 0;
	padding: 0;
}

.container {
text-align: left;
}




.label_div {
	width: 180px;
	float: left;
	line-height: 28px;
}
.input_container {
	height: 30px;
	float: left;
}
.input_container input {
	height: 20px;
	width: 200px;
	padding: 3px;
	border: 1px solid #cccccc;
	border-radius: 0;
}
.input_container ul {
	width: 206px;
	border: 1px solid #eaeaea;
	position: absolute;
	z-index: 9;
	background: #f3f3f3;
	list-style: none;
}
.input_container ul li {
	padding: 2px;
}
.input_container ul li:hover {
	background: #eaeaea;
}
#country_list_id {
	display: none;
}


</style>
<script language='javascript'>


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

      $(".myinput_number").each(function(){
		
	
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
         
      
     

	
	if(errors==0)
	{
		
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
     

   
    if($('.status_id').is(':checked')) 
           { 
          
            }
       else
       {
     alert("select At least One radio Button");
       return false;
        }
        
       
}
$(document).ready(function(){
    $(".datepick").datepicker({ maxDate:+250,dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true});

});

</script>
{/literal}

<div style="border:#999999 1px solid;  min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<form name='status_update' method='POST' action='status_update.php' onSubmit="return validateForm();" >

<div class="my_heading">Update Status</div>
<div id="area">
<br><br>
 <div class="container">
   
     
{foreach from=$data key=apprec_id item=row}
 <table>
<tr>
<td>Select Section: </td>       
 <td><b>{$section_list[$row.section_id]}</b></td>
<td>Select Service:</td>
<td><b>{$service_list[$row.service_id]}</b></td>

</tr>
<tr>
<td>Officer Responsible to render services: </td>       
 <td><b>{$designation_list[$row.emp_responsible]}</b></td>
<td>Cutoff Date:</td>
<td><b>{$row.cutoff_date}</b></td>

</tr>

<tr>
<td>Officer to whom a grievance/complaint be made in case of delay or default of service: </td>       
 <td><b>{$designation_list[$row.officer_responsible]}</b></td>
<td>Applicant Name</td>
<td><b>{$row.apprec_name}</b></td>

</tr>
<tr>
<td>Phone No: </td>       
 <td><b>{$row.apprec_phone}</b></td>
<td>Email Id</td>
<td><b>{$row.apprec_email}</b></td>
</tr>


{/foreach}  
<tr>
<td> &nbsp;</td>       
<td> &nbsp;</td>

</tr>
<tr>
<td> &nbsp;</td>       
<td> &nbsp;</td>

</tr>
         <input type="hidden" name="id" id="id" value="{$id}">
           
           
    <tr><td><b>Check The Status</b></td></tr> 
   
<tr>        
{foreach from=$status_list key=status_id item=row}


<td> 

 <input type="radio" name="status_id" id="{$row.status_id}" value="{$row.status_id}" class="status_id"  {if $row.status_id eq 6 && $status_id1 eq 6 } checked=checked{/if}   > {$row.status_name}

</td>

{/foreach}  
     </tr>  

<tr><td>Remarks: </td> 
<td>  <textarea rows="4" cols="30" name="remarks" id="remarks" >
 {$remarks}
</textarea>   </td>
<td>Select Date: </td> 
<td> <input type='text' class='datepick myinput_number' name='status_date' id="status_date" size='8' maxlength='8' value="{$status_date}">    <td>
</tr>

</table>    
 </form>

        
    </div>
<br>
<br>
<input type='submit' name='save' value='Save Details' style="background-color:#991f36; color:#FFF; border-radius:8px; cursor:pointer;">

<br>
<br>
</form>
</div>


</div>


{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            