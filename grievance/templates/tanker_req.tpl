{include file='header.tpl'}
{literal}
<script language='javascript'>
function validateForm()
{
	var errors=0;
	 var pattern = /^[7-9]{1}[0-9]{9}$/;
	$(".mytext").each(function(){
	
	
		var val_field=$(this).val();
		
		if(val_field =='')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});

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

 $(document).ready(function()
{

var rec=$("#file_count").val();

for (i = 1; i < rec; i++) {
	
		var req_id=$("#req_id"+i).val();
		
		 
			  $.post("ajax_provider.php",{req_id:req_id},function(data)
			  {  
				     var rec = data.split('----');
				       $("#ajaxdata").html(rec[0]);
			        
				
				  
				     $("#mobile"+i).html(rec[1]);
				 
				    
				     
		           });
		
	}
	
	
	
	   	$(".numdig").keypress(function (e) {
	
         if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
       return false;
           }
           });
   
   
	

  $(".datepick").datepicker({ minDate:+0,dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true});
  
  
});
function getname(i)
{
         
         
         
         var taker_number=$("#taker_number"+i).val();

    if(taker_number != '0' )
    
      {
             $("#amount"+i).addClass("mytext");
	      
      }
     else{
	

	    $("#amount"+i).removeClass("mytext");
	   
	 }
	 
	 
	 
         
          var taker_number=$("#taker_number"+i).val();
		
		 
			  $.post("ajax_gettanname.php",{taker_number:taker_number},function(data)
			  {  
				    
				 
				  
				     $("#taker_username"+i).val(data);
				   
				    
				     
		           });
}





</script>


{/literal}



<div class="boxed">
    <div class="title-bar blue"><h4>Assign Request</h4></div>
    <div class="inner no-radius">
        
        <div style="margin-left: 16%;padding: 5px;">
        <span style="color:green;font-weight:bold;">{if isset($suc)}{$suc}{/if}</span>
        <span style="color:red;font-weight:bold;">{if isset($fail)}{$fail}{/if}</span>
        </div>
        
        <div id="test"></div>
        
        
        {if isset($tanker_req_list)}

<form name="tanker_req" id="tanker_req" method="POST" action="tanker_req.php" enctype="multipart/form-data" onSubmit="return validateForm()">


    <table border="1" cellpadding="10" cellspacing="10" width="100%" class="table table-bordered table-hover">
  <thead>

  <tr style="background-color:#2c3e50; color:#FFF;">
     <th  align="center"  >Sno</th>
   <th  align="center"  >Name</th>
   <th  align="center"  >Mobile</th>
 <th  align="center"  >Ward No</th>

 <th  align="center"  >Street</th>
 <th  align="center"  >Adresss</th>
 <th align="center"  >Request Date</th>

  <th valign="top"  >Amount:</th >
    <th valign="top"  >Tanker Number:</th >
        <th valign="top"  >Tanker Driver:</th >
 </tr>
</thead>
<tbody>
{assign var="i" value=1}
 {foreach from=$tanker_req_list item=row key=req_id}
  <tr>
<input type="hidden" name={"req_id"|cat:$i}  id={"req_id"|cat:$i} value="{$row.req_id}">

 <td align="center" >{counter} </td>
 <td align="center" >{$row.req_name} </td>
 <td align="center" >{$row.req_mobile}
  </td>
 <td align="center" >{$ward_list[$row.ward_id]}
 </td>

 <td align="center" >{$street_list[$row.street_id]}
 </td>
  <td align="center" >{$row.req_address}
 </td>
  <td align="center" >{$row.req_date} <br>  {$row.req_time}
 </td>
 

<td align="center" >
   <input tyepe="text" name={"amount"|cat:$i} id={"amount"|cat:$i} class="numdig form-control" >
</td>

  <td align="center" >
 <select name={"taker_number"|cat:$i} id={"taker_number"|cat:$i} class="form-control"  onchange="getname({$i});">
<option value="0">--Select Provider--</option>
{html_options options=$taker_list  }
</select>
</td>

<td align="center"  >
   <input tyepe="text" name={"taker_username"|cat:$i} id={"taker_username"|cat:$i} class="form-control " readonly>
</td>

 </tr>
 {assign var="i" value=$i+1}
  {/foreach}
<input type="hidden" name="file_count" id="file_count" value="{$i}">
</tbody>
</table>
<br><br>
<center> <input type ="submit" name="submit"  class="btn btn-primary" value="save" ></center> 

</form>
{else}
<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>

{/if}
        
    </div>
    
    
</div>





{include file='footer.tpl'}