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

 $(".datepick").datepicker({ minDate:+0,dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true});
 
 
 	$(".numdig").keypress(function (e) {
	
         if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
       return false;
           }
           });
   
	
	

  
  
});
function chagestatus(i)
{
 var status=$("#status"+i).val();

  if(status == 2 )
    
      {
            
	    $("#amount_received"+i).addClass("mytext");
	       $("#delivery_date"+i).addClass("mytext");
      }
     else{
	

	    $("#amount_received"+i).removeClass("mytext");
	    $("#delivery_date"+i).removeClass("mytext");
	 }
	  
}

</script>


{/literal}

<div class="mywrapper">
<div class="top-strip">Update Request</div>

<div class="myinner-wrapper">
<div style="margin-left: 16%;padding: 5px;">
<span style="color:green;font-weight:bold;">{if isset($suc)}{$suc}{/if}</span>
<span style="color:red;font-weight:bold;">{if isset($fail)}{$fail}{/if}</span>
</div>

<div id="test"></div>



{if isset($tanker_req_list)}

<form name="update_tanker_req" id="update_tanker_req" method="POST" action="update_tanker_req.php" enctype="multipart/form-data" onSubmit="return validateForm()">


      <table border="1" cellpadding="10" cellspacing="10" width="100%" class="table table-bordered table-hover">
  <thead>

  <tr>
     <th  align="center" bgcolor="#dadada">Sno</th>
   <th  align="center" bgcolor="#dadada">Name</th>
   <th  align="center" bgcolor="#dadada">Mobile</th>
 <th  align="center" bgcolor="#dadada">Ward No</th>

 <th  align="center" bgcolor="#dadada">Street</th>
 <th  align="center" bgcolor="#dadada">Adresss</th>
  <th  align="center" bgcolor="#dadada">Amount</th>
 <th align="center" bgcolor="#dadada">Request Date</th>
  <th valign="top" bgcolor="#dadada">Tanker Number:</th >
  <th align="center" bgcolor="#dadada">Status</th>

  <th valign="top" bgcolor="#dadada">	Amount Received	:</th >
   <th valign="top" bgcolor="#dadada">	Delivery Date :</th >
        	
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
 <td align="center" >{$row.ward_id}
 </td>

 <td align="center" >{$row.street_id}
 </td>
  <td align="center" >{$row.req_address}
 </td>
 <td align="center" >{$row.amount}
 </td>
 <td align="center" >{$row.req_date} <br>  {$row.req_time}
 </td>
  <td align="center" >{$row.taker_number}
 </td>
 
 <td align="center" >
 <select name={"status"|cat:$i} id={"status"|cat:$i} class="form-control" onchange="chagestatus({$i});" >
<option value="0">--Select Status--</option>
{html_options options=$status_list  }
</select>
</td>
  
 

<td align="center" >
   <input tyepe="text" name={"amount_received"|cat:$i} id={"amount_received"|cat:$i} class="numdig form-control" >
</td>

 

<td align="center"  >
   <input tyepe="text" name={"delivery_date"|cat:$i} id={"delivery_date"|cat:$i} class="form-control datepicker" readonly>
</td>

 </tr>
 {assign var="i" value=$i+1}
  {/foreach}
<input type="hidden" name="file_count" id="file_count" value="{$i}">
</tbody>
</table>
<br><br>
<center> <input type ="submit" name="save"  class="btn btn-primary" value="save" ></center> 

</form>


{/if}










<form name="citizen_req" id="citizen_req" method="POST" action="citizen_req.php" enctype="multipart/form-data" onSubmit="return validateForm();">



</form>

</div>


</div>




{include file='footer.tpl'}

{literal}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
<script>
$(function() {
    $( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true,maxDate:0});
});
</script>
{/literal}