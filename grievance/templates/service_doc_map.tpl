{include file='header.tpl'}
<style>
.dataTables_wrapper .dataTables_filter
{
  
  margin-left: 226px;
}
</style>
{literal}

<script language='javascript'>

$(document).ready(function() {

$("#checkall").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});


$("#checkval").click(function(){
   $('#checkall').attr('checked', false); 
});

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

<style>
table tr:nth-child(odd) {
 background-color: #f1f1f1;
}
table tr:nth-child(even) {
 background-color: #ffffff;
}
</style>


<div style="border:#999999 1px solid; background-color:#d4f2ff;  min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<div class="my_heading"> Service Document </div>
{if isset($added_service_list)}


 <table width='97%' cellspacing="0"  border="1" cellpadding="5" style="border-collapse:collapse;">
<thead>

 	<tr style="background-color:#d1d1d1;">
     <th width="10%"> So No  </th>
         <th> Document Description</th>
       </tr>


</thead>
<tbody>

{foreach from=$added_service_list key=doc_id item=row}
<tr>
 <td> {counter} </td>
    <td>{$row.doc_desc}</td>
 </tr>

{/foreach}
</tbody>
</table>
<br> <br>
{/if}

<form name='service_doc_map' method='POST' action='service_doc_map.php' onSubmit="return validateForm();" >


<div id="area">
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="3"  >

<tr>
<td width="34%"><b>Select Service:</b> </td>       
 <td width="29%">
        <select  name='service_id' id='service_id'  class="dropdown" style="width:300px;">
       <option value='0'>--Select Service--</option>
        {html_options options=$service_list selected=$service_sel}
       </select>
      </td>
        <td width="34%"><input type='submit' name='service_sear' value='Submit' class="mybtn">
	</td>

</tr>

</table>
</form>
<br>
{if isset($doc_list)}
<div class="my_heading"> Documents  </div>
<form name='service_doc_map' method='POST' action='service_doc_map.php' onSubmit="return validateForm();" >

<input type="hidden" name="service_id" value="{$service_sel}">
<br>
 <table id="example" border='1px' width='95%' style="border-collapse:collapse;">
<thead>

 	<tr style="background-color:#d1d1d1;"> 
    <th  width="10%"> Sno  </th>
         <th> Document Description</th>
         <th>check all <br><input type="checkbox" name="checkall" value="checkall" id="checkall"></th>
       </tr>


</thead>
<tbody>

{foreach from=$doc_list key=doc_id item=row}
<tr>
 <td> {counter} </td>
    <td>{$row.doc_desc}</td>
   <td> <input type="checkbox" name="check_doc_name[]" value="{$row.doc_id}" id="checkval"></td>
 </tr>

{/foreach}
</tbody>
</table>
<br> <br>
<center><input type='submit' name='save' value='Submit' class='mybtn'>
	</center>
{/if}

</div>


</form>








</div>


{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            
                            