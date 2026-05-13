{include file='header.tpl'}
{literal}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
var _URL = window.URL || window.webkitURL;
/*$(document).ready(function()
{
$("#img_url").change(function (e) {

    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
           
			if(this.width > 256 && this.height > 256)
			{
				alert('Please upload width less than 256 and height less than 256');
				$("#img_url").val('');
				return false;
			}
        };
        img.src = _URL.createObjectURL(file);
    }
});
});*/

function delete_rec(id)
{
	
	if(confirm('Do Your really want to delete this record'))
	{
	
		$.post('ajax_del_enew_content.php',{id:id},function(data)
		{
		 if(data==0)
		{
		alert('Unable to delete , Try again');
		}
		else if(data==1)
		{
		alert('Deleted Successfully');
		window.location='addcontent.php';
		}
		
		});
	}

} 

</script>
{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Update E-News Content</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               
{if $flash}
	<div class="{$flash.class}">
	<button class="close" data-close="alert"></button>
		{$flash.msg}
	</div>
{/if}
               
		<form   method="post" action="update-enew-content.php" name="manage_desg"  class="form-horizontal" enctype="multipart/form-data" onSubmit="return validateForm()">
			
			<input type="hidden" name="token" value="{$token_id}"/>
			
			<input type='hidden' name='previous_image' value='{$data.img_url}'>
			<input type='hidden' name='id' value='{$data.id}'>
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Editon: <span class="required">* </span></label>
							<div class="col-md-5">
									<select name='edition_no' id='edition_no' class="form-control" required >
								       		<option value='0'>--Select Editon--</option>
								       		{html_options options=$edition_list selected=$data.edition_no}	
								       	</select>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Description: <span class="required">* </span></label>
							<div class="col-md-5">
									 <textarea name="description" id="description" class="form-control char mytext" data-type="sptext" onkeyup="funInputFielTypes(this)" required >{$data.description}</textarea>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Image: </label>
							<div class="col-md-5">
									<input type="file" name="img_url" id="img_url"  class="form-control char mytext" accept="image/x-png, image/gif, image/jpeg" data-type="image" onchange="funInputFielTypes(this)" /> 
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Previous Image: </label>
							<div class="col-md-5">
									<img src="{$data.img_url}" width="75px" height="75px">
							</div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward' id="submitBtn" disabled>Submit</button>
						<a href="addcontent.php" class="btn btn-danger">Back To List</a>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>









{include file='footer.tpl'}

