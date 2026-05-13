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
                <div class="title-bar blue">
                  <h4>File Upload</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               
<form method="post" action="form_upload.php" name="form_upload"  enctype="multipart/form-data" class="form-horizontal" onSubmit="return validateForm1()">
			
			<input type="hidden" name="token" value="{$token_id}" />
			<input type='hidden' name='uid' value='{$uid}'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
					<label class="control-label col-md-3">Category: <span class="required">* </span></label>
					<div class="col-md-5">
					<select name="cat_id" id="cat" class="form-control combo" required>
					<option value='0'>--SELECT--</option>
					{html_options options=$cat_list}
					</select>
					</div>
					</div>
					
					<div class="form-group">
					<label class="control-label col-md-3">Description: <span class="required">* </span></label>
				        <div class="col-md-5">
					<textarea name="desc" type="text" class="form-control mytext" ></textarea>
					</div>
					</div>
					
						<div class="form-group">
					<label class="control-label col-md-3">Description Marathi: <span class="required">* </span></label>
				        <div class="col-md-5">
					<textarea name="sub_cat_desc_marathi" type="text" class="form-control mytext" ></textarea>
					</div>
					</div>
					
					<div class="form-group">
                                        <label class="control-label col-md-3">Upload File</label>
                                        <div class="col-md-5">
                                        <input type="file" class="" id="f1" name="f1"></div>
                                        </div>   
					
					<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<!--<button type="reset" class="btn btn-danger">Cancel</button>-->
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>







<!------------->
{if isset($data)}
<div class="row" id="div_print">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Uploaded files</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											<th>Category</th>
											
											<th>Description</th>
											<th> Marathi</th>
											<th class="noExport">View</th>
											<th class="noExport">EDIT</th>
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$data item=row key=sub_cat_id}
										<tr>
											<td>{counter}</td>
											<td>{$cat_list[$row.cat_id]}</td>
											
											<td>{$row.sub_cat_desc}</td>
											<td>{$row.sub_cat_desc_marathi}</td>
                        					<td class="noExport">{if $row.file_url neq ''}<a href="{$row.file_url}" target="_blank">View</a>{/if}</td>
                        					<td class="noExport"><a href="update_form.php?sub_cat_id={$row.sub_cat_id}"><button class="btn btn-success"><span class="fa fa-pencil"></span> Edit</button></a></td>
										</tr>
										{/foreach}
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>

{include file='footer_print.tpl'}
{/if}
<!------------------->




<br>
{include file='footer.tpl'}

