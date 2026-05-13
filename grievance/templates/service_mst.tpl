{include file='header.tpl'}
{literal}

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
		
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
     

   
    
        
       
}


</script>
{/literal}

<div style="border:#999999 1px solid; background-color:#d4f2ff; min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<form name='update_service_reports' method='POST' action='service_reports.php' onSubmit="return validateForm();" >

<div class="my_heading">Service Reports</div>
<div id="area">

<br>
<br>

 <table width='97%' cellspacing="0"  border="1" cellpadding="5" id="example" style="border-collapse:collapse;">
<thead>

 	<tr  style="background-color:#d1d1d1;"> 
     	<th>Sno</th>
	<th> Section Name </th>
 	<th> Service Name </th>
 	<th> Time Frame Days </th>
 	
  	<th> Responsible Officer</th>
  	
       </tr>


</thead>
<tbody>

{foreach from=$data key=service_id item=row}
<tr>
  	<td>{counter}</td>
 	<td>{$section_list[$row.section_id]}</td>
  	<td>{$row.service_desc}</td>
	<td>{$row.time_frame_days}</td>
	
	<td>{$designation_list[$row.officer_responsible]}</td>
	


 </tr>

{/foreach}
</tbody>
</table>


</div>


</div>
<br>
<br>

{include file='footer_print.tpl'}
<br>
<br>

{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            