{include file='header.tpl'}
{literal}


<script language='javascript'>
function validateForm()
{
	var errors=0;
	$(".int1").each(function(){
	
		var patt=/^\d+$/;
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



	$(".mytext").each(function(){
	
		var val_field=$(this).val();
		val_field = val_field.trim();
		if(val_field=='')
		{
		($(this)).css({"background-color": "pink"});
		errors++;
		}
		else
		{
		($(this)).css({"background-color": "white"});
		}
	});	
	
	
	$(".combo1").each(function(){
	
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
      

</script>

<script>
       $(document).ready(function()
       {
		$(".num").keypress(function (test)
		{
    			if (test.which != 8 && test.which != 0 && (test.which < 48 || test.which > 57)) 
    			{
    				return false;
        		}
      		}); 
      		
      		 });
      		 
 </script>

<script>

function validation()
 
 {


 n=document.special.mobile.value;
      
 

     if(n.length!=10)
     { 
      
      alert("Please Enter Valid Number");
      special.mobile.value="";
      
     }
  
  }
  
</script>



<script>
function delete_rec()
{
	if(confirm('Do you really want to delete This record'))
	{
		$.post('ajax_delete_spe_off.php',{},function(data)
		{
			if(data==1)
			{
			alert('Deleted successfully');
			window.location='select_page.php';
			}
			else
			{
			alert('Unable to delete , Try again');
			return false;
			}
		});
	}
}
</script>


<!--

<script>

function check()
{
	var mobile=$("#mobile").val();
	var user_id=$("#user_id").val();
	$.post("check_mobile.php",{mobile:mobile,user_id:user_id},function(data)
	{
	alert(data);
	});
}

</script>

-->


{/literal}





 <div class="row ">
	<div class="">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Special Officers</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                

               
			
					
					
					<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}


<form  name="special" method="POST" action="special_officers.php" enctype="multipart/form-data" onSubmit="return validateForm();" class="form-horizontal">
<input type="hidden" name="cid" value="3">
<input type="hidden" name="previous_image" value="{$data.img_url}">

					<div class="form-group">
						<label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8">
			 <input type="text" name="name" id="name"  class="form-control mytext"  value="{$data.name}" >
							</div>
						</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8">
		 <input type="text" name="designation" id="designation"  class="form-control mytext" value="{$data.designation}" >
							</div>
						</div>
					
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Mobile No: <span class="required"> </span></label>
							<div class="col-md-8">
		<input type="text" name="mobile" id="mobile"  class="form-control int1 num"  value="{$data.mobile}" onblur="validation()">
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Land Line No: <span class="required"> </span></label>
							<div class="col-md-8">
	<input type="text" name="land_line" id="land_line"  class="form-control int1 num" maxlength="10" value="{$data.land_line}">
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Email ID: <span class="required"> </span></label>
							<div class="col-md-8">
			<input type="email" name="email" id="email"  class="form-control mytext"  value="{$data.email}" >
							</div>
					</div>
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Photo: <span class="required">* </span></label>
							<div class="col-md-8">
			<input type="file" name="f1" id="f1"  class="form-control mytext" maxlength="10" accept="image/*" >
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Previous Photo: <span class="required">* </span></label>
							<div class="col-md-8">
							{if $data.img_url eq ''}
							
							Photo Not Uploaded
							{else}
									<img src="{$data.img_url}" width="75px" height="75px">
							{/if}
							</div>
					</div>
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<button type="button" class="btn btn-danger" onclick="delete_rec()">Delete This Record</button>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>









{include file='footer.tpl'}

