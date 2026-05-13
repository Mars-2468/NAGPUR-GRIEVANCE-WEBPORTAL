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
            divcontent=divcontent + "<div class='col-md-8'><input name='name"+i+"' type='text' id='name"+i+"' size='30' maxlength='70' data-required='1' class='form-control' required/></div>";
            
            
             divcontent=divcontent + "<label class='control-label col-md-3'>Mobile: <span class='required'>* </span></label>";
            divcontent=divcontent + "<div class='col-md-8'><input name='mobile"+i+"' type='text' id='mobile"+i+"' size='30' maxlength='70' data-required='1' class='form-control' required/><input type='button' value='Remove' class='btn btn-danger' onclick='fnRemove(" + i +");' /></div>";
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
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>ADD / UPDATE TANKER DETAILS</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               

               
			<form   method="post" action="update_tankers.php" name="manage_emp"  class="form-horizontal" onSubmit="return validateForm()">
			
			<input type="hidden" name="token" value="{$token_id}"/>
			<input type='hidden' name='tanker_id' value='{$tanker_id}' id="tanker_id">
			<input type="hidden" name="cnt" id="cnt" value="{$i}" />
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
									<input name='taker_number' type="text" id="taker_number" size="30" value="{$data.taker_number}" maxlength='70' data-required="1" class="form-control" required/>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8">
									<input name='name' type="text" id="name" size="30" value="{$data.name}" maxlength='70' data-required="1" class="form-control" required/>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name='mobile' maxlenght='10' type="text" id="mobile" value="{$data.mobile}" maxlength='10'  class="form-control num" required/>
							</div>
					</div>
					<span id="advance_div">
					{foreach from=$data2 item=row key=key}
						<div class="form-group" id="{$key}">
						<label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8">
									<input name={'name'|cat:$key} type="text" id={'name'|cat:$key} size="30" maxlength='70' data-required="1" class="form-control" required value="{$row.name}"/>
							</div>
					
						<label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name={'mobile'|cat:$key} maxlenght='10' type="text" name={'mobile'|cat:$key} maxlength='10'  class="form-control num" required value="{$row.mobile}"/><input type="button" value="Remove" class="btn btn-danger" onclick="fnRemove('{$key}');" />
							</div>
					</div>
					{/foreach}
					</span>
					
					<div class="form-group">
						<label class="control-label col-md-3"></label>
							<div class="col-md-8">
									 <input type="button" onclick="addAdvance()" value="Add Another Name and Mobile" class="btn btn-success"/>
							</div>
					</div>
					
					
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Address <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name='address' maxlenght='10' type="text" value="{$data.address}" id="address"  class="form-control" required/>
							</div>
					</div>
					
					
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<button type="reset" class="btn btn-danger">Cancel</button>
						<a href="add-tanker.php" class="btn btn-warning">BACK</a>
						</div>
					</div>
				</div>
				
			</form>
		</div>
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

<br>



{include file='footer.tpl'}

