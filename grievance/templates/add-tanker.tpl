{include file='header.tpl'}
{literal}
<script>
function validateForm()
{
	var errors=0;
	
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

	
	var value=$("#taker_number").val();
	if(value == '')
	 {
	  return false;
	 }
	
	
	
	
	
	var value=$("#mobile").val();
	var pattern = /^[7-9]{1}[0-9]{9}$/;
	if (!pattern.test(value)) {
         $("#mobile").css({"background-color": "pink"});
	alert('Invalid mobile number');
		
                return false;
	}
	else
	{
	 $("#mobile").css({"background-color": "white"});
	}
	
	
	
	

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
function tankervali()
{
         var value=$("#taker_number").val();
         if(value == '')
	 {
	  return false;
	 }
	var pattern = /^[A-Z]{2}\d{2}[A-Z]{2}\d{4}$/;
	 
	if (!pattern.test(value)) {
         $("#taker_number").css({"background-color": "pink"});
	    alert('Invalid Taker Number number');
		
                return false;
	}
		
	
}	
 $(document).ready(function()
{
  $(".datepick").datepicker({ minDate:+0,dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true});
  

  
  
});
function update_tanker(taker_number,name,mobile,address,tanker_id)
{
	
	$("#update_status").val('1');
	$("#taker_number").val(taker_number);
	$("#name").val(name);
	$("#mobile").val(mobile);
	$("#address").val(address);
	$("#tanker_id").val(tanker_id);
	
}
</script>
<script>
function delete_rec(tanker_id)
{
var del=confirm("Are you sure you want to delete this record?");
        if (del==true){
        
        $.post("delete_tanker.php",{tanker_id:tanker_id},function(data)
	{
	
	$("#"+tanker_id).hide();
	
	$("#msg1").html(data);
	});
	} else {
            return false;
        }
}



</script>

<script>
function addAdvance()
{
	
	
	var divcontent;
    var i = document.getElementById('cnt').value;
    var j = i-1;
	
     var newdiv = document.createElement('div');
     newdiv.setAttribute('id', i);
	 newdiv.setAttribute('class', 'form-group');
     divcontent="";
     
		    divcontent=divcontent + "<label class='control-label col-md-3'>Name: <span class='required'>* </span></label>";
            divcontent=divcontent + "<div class='col-md-8'><input style='margin-bottom:5px;' name='name"+i+"' type='text' id='name"+i+"' size='30' maxlength='70' data-required='1' class='form-control' required/></div>";
            
            
             divcontent=divcontent + "<label class='control-label col-md-3'>Mobile: <span class='required'>* </span></label>";
            divcontent=divcontent + "<div class='col-md-8'><input name='mobile"+i+"' type='text' id='mobile"+i+"' size='30' maxlength='70' data-required='1' class='form-control' required/><input type='button' value='Remove' class='btn btn-danger' onclick='fnRemove(" + i +");' style='margin-top:5px;'/></div>";
            divcontent=divcontent + "</div>";
            
            
            
            
            divcontent=divcontent + "</div>";
			
			
			
			newdiv.innerHTML = divcontent;                                  
			document.getElementById('advance_div').appendChild(newdiv);
   
			document.getElementById('cnt').value = eval (document.getElementById('cnt').value) + 1 ;
			
    
  }
  
  function fnRemove(arg)
{
	
	
	
	
    var d1=document.getElementById(arg).parentNode;
    var d2=document.getElementById(arg);
    d1.removeChild(d2); 
    var arg=arg-1;
  // document.getElementById('cnt').value=eval (document.getElementById('cnt').value) - 1 ;
   
   }
    
</script>
{/literal}





 <div class="row ">
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>ADD / UPDATE TANKER DETAILS</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               

               
			<form   method="post" action="add-tanker.php" name="manage_emp"  class="form-horizontal" onSubmit="return validateForm()">
			
			<input type="hidden" name="token" value='{$token_id}'/>
			<input type='hidden' name='update_status' value='0' id="update_status">
			<input type='hidden' name='tanker_id' value='' id="tanker_id">
			<input type="hidden" name="cnt" id="cnt" value="1" />
			
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Tanker Number: <span class="required">* </span></label>
							<div class="col-md-8">
									<input name='taker_number' type="text" id="taker_number" size="30" maxlength='70' data-required="1" class="form-control" required/>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8">
									<input name='name' type="text" id="name" size="30" maxlength='70' data-required="1" class="form-control" required/>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name='mobile' maxlenght='10' type="text" id="mobile" maxlength='10'  class="form-control num" required/>
							</div>
					</div>
					
					
					<div class="form-group">
						<label class="control-label col-md-3"></label>
							<div class="col-md-8">
									 <input type="button" onclick="addAdvance()" value="Add Another Name and Mobile" class="btn btn-success"/>
							</div>
					</div>
					
					<span id="advance_div"></span>
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Address <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name='address' maxlenght='10' type="text" id="address"  class="form-control" required/>
							</div>
					</div>
					
					
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<button type="reset" class="btn btn-danger">Cancel</button>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>



 
<div class="row" id="div_print">
		<div>
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>EXISTING TANKERS</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
		<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
				<thead>
					
					<tr style="background-color:#2c3e50; color:#FFF;">
					  	<th>S.No</th>
					  	<th>Tanker Number</th>
					  	<th>Name</th>
					  	<th>Mobile</th>
					  	<th>Address</th>
					  	<th>Edit</th>
					  	<!--<th>Delete</th>-->
					  	  	
					  </tr>
				</thead>
				
				<tbody>
					
					{assign var="i" value=1}
				 {foreach from=$tanker_mst_list item=row key=req_id}
				  <tr>
				   	<td>{counter} </td>
					 <td>{$row.taker_number} </td>
					 <td>{$row.name}</td>
					 <td>{$row.mobile}</td>
					 <td>{$row.address}</td>
					 <td>
					     
					     <form action="update_tankers.php" method="POST">
					         <input type="hidden" name="tanker_id" value="{$row.tanker_id}">
					         <input type="submit" name="submit" value="UPDATE" class="btn btn-success">
					         
					     </form>
					     
					     
                     </td>
                     <!--<td align="center">
                               <!--  <input type='radio' name='id' id='id'  value="{$row.id}"  >-->
                                 <!--<input type="button" class="btn btn-danger" value="DELETE" name='tanker_id' id='tanker_id' onclick="delete_rec('$row.tanker_id');">
                                                                </td>-->
				 
				 </tr>
				 {assign var="i" value=$i+1}
				  {/foreach}
						
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
{literal}
<script src='../js/jquery.min.js'></script>
<script>
$(document).ready(function() {

$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });



             

}); 
</script>
{/literal}
{include file='footer_print.tpl'}
<br>



{include file='footer.tpl'}

