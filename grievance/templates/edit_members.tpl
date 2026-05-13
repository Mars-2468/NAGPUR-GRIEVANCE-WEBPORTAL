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


function fun1()
{
	
	
	$("#add_council").submit();
	
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
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Update Co-Members:</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                

               
			<form name='add_council' id="add_council" method='POST' action='edit_members.php' class="form-horizontal">
			
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
					<!--<div class="form-group">
						<label class="control-label col-md-3">Ward: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='ward_id' id='ward_id' class="form-control" onchange="fun1()">
								       		<option value='0'>--Select Department--</option>
								       		{html_options options=$ward_list selected=$ward_id_sel}	
								       	</select>
							</div>
					</div>-->
					
					</form>


<form   method="POST" action="edit_members.php" enctype="multipart/form-data" onSubmit="return validateForm();">
<input type="hidden" name="id" value="{$data.id}">
<input type="hidden" name="img_url" value="{$data.img_url}">

					<div class="form-group">
						<label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input type="text" name="name" id="name" value="{$data.name}" class="form-control mytext"  required>
							</div>
						</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8">
						<input type="text" name="designation" id="designation" value="{$data.designation}" class="form-control mytext" required>
							</div>
						</div>
					
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Mobile No: <span class="required">* </span></label>
							<div class="col-md-8">
						<input type="text" name="mobile" id="mobile" value="{$data.mobile}" class="form-control mytext" maxlength="10" required>
							</div>
					</div>
					
					<!--<div class="form-group">
						<label class="control-label col-md-3">Party Name: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input type="text" name="party" id="party" value="{$party}" class="form-control mytext">
							</div>
					</div>-->
					
					<div class="form-group">
						<label class="control-label col-md-3">Photo: <span class="required">* </span></label>
					<div class="col-md-8">
					<input type="file" name="img_url" id="img_url"  class="form-control mytext" maxlength="10" accept="image/*">
							</div>
					</div>
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Previous Photo: <span class="required">* </span></label>
					<div class="col-md-8">
					<img src="{$data.img_url}" width="20%" height="10%">
							</div>
					</div>
					
					
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='update' value=''>Update</button>
						<a href="co_option_members.php"><button type="button" class="btn btn-danger">Back</button></a>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>








{include file='footer.tpl'}

