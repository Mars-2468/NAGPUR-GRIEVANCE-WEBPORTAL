{include file='header.tpl'}
{literal}
<script>
function check_availability()
{
	var user_id=document.add_user.user_id.value;
	var patt1= /^[a-zA-Z][a-zA-Z0-9]{4,}$/;
	if(!patt1.test(user_id))
    	{
		alert("User ID must Start with letter and can contain letters/numbers, 6-10 characters");
		return false;    	
	}
	else
	{
		if (window.XMLHttpRequest)
			xmlhttp=new XMLHttpRequest();
		else
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var str=xmlhttp.responseText;
				if(str==0)
				{
					$('#user_id').attr('readonly', true);
					$("#area").show();
				}
				else
				{
					alert("Already In use, Please select another ID");
					$("#area").hide();
				}
			}
		}
		xmlhttp.open("GET","check_availability.php?user_id="+user_id,true);
		xmlhttp.send();
	}
	    
}


function validateForm()
{
	var description=document.add_category.description.value;
	
	var dept_id=$("#dept_id").val();
	if(dept_id=='0')
	{
	alert("select department name");
		return false; 
	}


				
    	if(description =='')
    	{
		alert("Please Enter Description");
		return false;    	
    	}
    	
   	
	return true;
}


function fill(cat_id,descriptin,dept_id)
{
	
	document.add_category.cat_id.value=cat_id;
	document.add_category.description.value=descriptin;
	document.add_category.type.value=1;
	$("#dept_id").val(dept_id);
	
} 
</script>
{/literal}





 <div class="row ">
	<div class="">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Add Social Connect Link</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                

               
			<form name='add_category' method='POST' action='social_connect.php' class="form-horizontal" onSubmit="return validateForm()">
			
			<input type="hidden" name="token" value="{$token_id}"/>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Facebook Link: <span class="required">* </span></label>
							<div class="col-md-8">
									 <textarea name="fb_link" type="text" id="fb_link" size="30" maxlength='70' data-required="1" class="form-control" placeholder="Paste facebook link" required />{$data.fb_link}</textarea>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Twitter Link: <span class="required">* </span></label>
							<div class="col-md-8">
									 <textarea name="twitter_link" type="text" id="twitter_link" size="30" maxlength='70' data-required="1" class="form-control" placeholder="Paste twitter link" required />{$data.twitter_link}</textarea>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Website Link: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input type="url" name="web_link" class="form-control" placeholder="Paste websit url" required value="{$data.web_link}"/>
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









{include file='footer.tpl'}

