{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    	
 <script language='javascript'>
function validateForm1()
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

	$(".int2").each(function(){
	
		var patt=/^\d+$/;
		var val_field=$(this).val();
		if(!val_field.match(patt))
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			if (val_field.length != 6) 
			{
    				alert("Please enter correct pincode");
    				($(this)).css({"background-color": "pink"});
				errors++;
  			}
  			else
  			{
				($(this)).css({"background-color": "white"});
			}
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
	$(".datetime").each(function()
          {
            if( ($(this).val()=='') || ($(this).val()=='0000-00-00'))
            {
             $($(this)).css({"background-color": "pink"});
             errors++;
            }else
       $($(this)).css({"background-color": "white"});
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
function validateForm()
{
	var errors=0;
	var password=$("#password").val();
	var password_again=$("#password_again").val();
	var pattern =/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!@#_$, ]{8,}$/;
	
		   if(password=="")
			 {
			 
			 alert('Enter Password');
			 errors++;
			 }
		
			 
			 if(password_again!=password)
			 {
			
				
				errors++;
				
				alert('Enter same password');
				
				
			
			
			
			 }
			 if(errors==0)
			 {
			 }
			 else
			 {
			 return false;
			 }
}
</script>
{/literal}




 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>File Update</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                {if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
           {if isset($data)}    
               
<form method="post" action="update_form.php" name="update_form"  enctype="multipart/form-data" class="form-horizontal" onSubmit="return validateForm1()">
			
			<input type="hidden" name="token" value="{$token_id}"/>
			<input type='hidden' name='uid' value='{$uid}'>
			<input type='hidden' name='cat' value='{$data.sub_cat_id}'>
			<input type='hidden' name='pdf' value="{$data.file_url}">
				<div class="form-body">
				
				
					<div class="form-group">
					<label class="control-label col-md-3">Category: <span class="required">* </span></label>
					<div class="col-md-5">
					<select name="cat_id" id="cat" class="form-control combo" required>
					<option value='0'>--SELECT--</option>
					{html_options options=$cat_list selected=$cat}
					</select>
					</div>
					</div>
					
					<div class="form-group">
					<label class="control-label col-md-3">Description: <span class="required">* </span></label>
				        <div class="col-md-5">
					<textarea name="desc" type="text" class="form-control mytext">{$data.sub_cat_desc}</textarea>
					</div>
					</div>
					
						<div class="form-group">
					<label class="control-label col-md-3">Description Marathi: <span class="required">* </span></label>
				        <div class="col-md-5">
					<textarea name="sub_cat_desc_marathi" type="text" class="form-control mytext">{$data.sub_cat_desc_marathi}</textarea>
					</div>
					</div>
					
					<div class="form-group">
                                        <label class="control-label col-md-3">Upload File</label>
                                        <div class="col-md-5">
                                        <input type="file" class="" id="f1" name="f1"></div>
                                        </div>
                                        
                                        
                                        {if $data.file_url neq ''}
                                        <div class="form-group">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-5">
                                        <a href="{$data.file_url}" target="_blank"><font color="#5ab7ed">Click Here to view existing file</f></a></div>
                                        </div> 
                                        {/if}   
					
					<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
						<button type="submit" class="btn btn-info" name='update' value='Add / Update Ward'>Update</button>
						<a href="form_upload.php"><button type="button" class="btn btn-danger">Back</button></a>
						</div>
					</div>
					
				</div>
				
			</form>
			{/if}
			
		</div>
		</div>
	</div>
</div>












<br>
{include file='footer.tpl'}

