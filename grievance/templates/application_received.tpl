{include file='header.tpl'}
{literal}
<style>
td
{
width:250px;
}
</style>
<script language='javascript'>

$(document).ready(function() {




  $("#time_frame_days").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
 });

 $("#dvContainer").hide();
 
              $('#section_id').change(function(e){
		var section_id= $('#section_id').val();
		$.post("ajax_get_service.php", {'section_id' : section_id},function(data){

		$('#service_id').html(data);
	});
		$("#service_id").val('0');
		  $( "#service_id" ).trigger( "change" );
		
	});
	
	$("#time_frame_days").blur(function(){
	
	      var service_id= $('#service_id').val();
	      var time_frame_days= $('#time_frame_days').val();
	      
		$.post("ajax_get_service.php", {'service_id' : service_id,'time_frame_days' : time_frame_days},function(data){
		

		  var data1= data.replace(" ", "");

		  
		  document.getElementById("cutoff_date").value = data1;

		  
		 $('.cutoff_date').html(data1);
		   
	      });
	   
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




      /* $(".email").each(function(){
		
		

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
	});*/
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

<div style="border:#999999 1px solid;  background-color:#d4f2ff;  min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px; font-family:Arial, Helvetica, sans-serif; font-size:13px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<form name='application_received' method='POST' action='application_received.php' onSubmit="return validateForm();" >

<div class="my_heading">Application Received</div>
<div id="area"><br>
<br>

<table width="100%"  border="0" cellspacing="3" cellpadding="0"  style="border-collapse:collapse;">

<tr>
<td>Select Section: </td>       
 <td>

        <select  name='section_id' id='section_id'  class="dropdown">
       <option value='0'>--Select Section--</option>
        {html_options options=$section_list selected=$section_sel}
       </select>
        </td>
      <td>Select Service</td>
       <td>
       <select  name='service_id' id='service_id'  class="dropdown"  onchange="this.form.submit();">
       <option value='0'>--Select service--</option>
       {html_options options=$service_list selected=$service_sel}
       </select>

</td>

</tr>
</table>
<br>
<br>

</form>
{if isset($service_sel)}
<form name='application_received' method='POST' action='application_received.php' enctype="multipart/form-data" onSubmit="return validateForm();" >
<input type='hidden' name='section_id' id='section_id'  value='{$section_sel}' >
<input type='hidden' name='service_id' id='service_id'   value='{$service_sel}' >

{foreach from=$data key=service_id item=row}
<table border="1" style="border-collapse:collapse;">
<tr>
	<td>Time frame (days): </td>
	<td><input type='text' name='time_frame_days' id='time_frame_days' class="float" size='20' value="{$row.time_frame_days}" readonly></td>


	 <td>Officer Responsible to render services: </td>
	<td> 
	<input type='hidden' name='emp_responsible' id='emp_responsible' value="{$row.emp_responsible}" >
             <b> {$designation_list[$row.emp_responsible]}</b>
       </td>

</tr>
<tr>  
        </td> 
       <td>Cutoff Date: </td><td><input type="text" name="cutofdate" value="{$cutofdate|date_format:"%d-%m-%Y"}" readonly></td>
	<!--<td class="cutoff_date"> </td>
<input type='hidden' name='cutoff_date' id='cutoff_date'  style=" text-align=left;">-->

        <td>Officer to whom a grievance/complaint be made in case of delay or default of service: </td>
	<td>
	<input type='hidden' name='officer_responsible' id='officer_responsible' value="{$row.officer_responsible}" >
              <b> {$designation_list[$row.officer_responsible]}  </b>


	
       

</tr>



<tr>
<td>Applicant Name</td><td> <input type='text' name='apprec_name' id='apprec_name' class="chr" size='20' ></td>
<td> Phone No</td><td> <input type='text' name='apprec_phone' id='apprec_phone' class="phone" size='20' ></td>
</tr>
<tr>
<td>Email Id</td><td> <input type='text' name='apprec_email' id='apprec_email' class="email" size='20' ></td>
<td>Address</td><td> <textarea rows="4" cols="30" name='apprec_address' id='apprec_address'> </textarea></td>
</tr>
{/foreach}
<tr>
{if isset($added_service_list)}


 <table width='97%' cellspacing="0"  border="1" cellpadding="5" style="border-collapse:collapse;">
<thead>

 	<tr> 
            <th> Document Description </th>
            <th> Document Number </th>
            
       </tr>


</thead>
<tbody>

{foreach from=$added_service_list key=doc_id item=row}
<tr>
   <input type='hidden' name='doc_id[]' id='doc_id[]' value="{$row.doc_id}" size='20' >
    <td>{$row.doc_desc}</td>
      <td><input type='text' name='app_enter_docno[]' id='app_enter_docno' class="chr" size='40' > </td>
      
 </tr>

{/foreach}
</tbody>
</table>
<br> <br>
{/if}

</tr>
<tr>
	<th colspan='2'>
		<input type='submit' name='save' value='Add Details' style="background-color:#991f36; color:#FFF; border-radius:8px; cursor:pointer;">
	</th>
</tr>

</table>
{/if}

</div>


</form>







</div>


{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            