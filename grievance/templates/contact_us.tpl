{include file='header.tpl'}
{literal}
<script>



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
    	
}


function fill(cat_id,descriptin,dept_id)
{
	
	document.add_category.cat_id.value=cat_id;
	document.add_category.description.value=descriptin;
	document.add_category.type.value=1;
	$("#dept_id").val(dept_id);
	
} 
</script>



<style>
    textarea{
    resize:none;    
    }
    
</style>






{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Add Address And Map Link:</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                

               
			<form name='add_category' method='POST' action='contact_us.php' class="form-horizontal" enctype="multipart/form-data" onSubmit="return validateForm()">
			
			<input type="hidden" name="token" value="{$token_id}"/>
			<input type='hidden' name='previous_image' value="{$data.file_url}">
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
					
					
					
					
					<!--<div class="form-group">
						<label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name="comm_name" type="text" id="comm_name"  data-required="1" class="form-control" value="{$data.comm_name}" required >
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name="mobile" type="number" maxlength="10" id="mobile1"  data-required="1" class="form-control num" value="{$data.mobile}" required />
							</div>
					</div>
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8">
							<input name="designation" type="text"  data-required="1" class="form-control" value="{$data.designation}" required />
							</div>
					</div>-->
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Upload Photo: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name="f1" type="file" id="f1"  data-required="1" class="form-control"/>
							</div>
					</div>
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Previous Photo: <span class="required">* </span></label>
							<div class="col-md-8">
									 <img src='{$data.file_url}' width="75px" height="75px">
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Address: <span class="required">* </span></label>
							<div class="col-md-8">
									 <textarea name="address" type="text" id="address" style="width:600px;height:200px;"  data-required="1" class="form-control" required />{$data.address}</textarea>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Map Link: <span class="required">* </span></label>
							<div class="col-md-8">
									 <textarea name="link" type="text" id="link" style="width:600px;height:100px;" data-required="1" class="form-control" required />{$data.link}</textarea>
							</div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<button type="button" class="btn btn-danger">Cancel</button>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>









{include file='footer.tpl'}

