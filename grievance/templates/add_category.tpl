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
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Add / Update Category Details:</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                

               
			<form name='add_category' method='POST' action='add_category.php' class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='type' id='type' value='0'>
			<input type='hidden' name='cat_id' id='cat_id'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
					<div class="form-group">
						<label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='dept_id' id='dept_id' class="form-control">
								       		<option value='0'>--Select Department--</option>
								       		{html_options options=$dept_list}	
								       	</select>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Categpry Name: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name="description" type="text" id="description" size="30" maxlength='70' data-required="1" class="form-control"/>
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




<div class="row">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>EXISTING CATEGORIES</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
									<thead>
										
										<tr >
											<th>S.No</th>
											<th>Department</th>
											<th>Category Name</th>
											<th>Edit</th>
											
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$cat_list   key=id item=row}
									<tr>
										<td>{counter}</td>
										<td>{$dept_list[$cat_dept[$id]]}</td>
										<td>{$cat_list[$id]}</td>
										
										
										<td>
										<input type='radio' name='update' onchange="fill('{$id}','{$cat_list[$id]}',{$cat_dept[$id]})">
										</td>
										
									</tr>
									{/foreach}
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>




{include file='footer.tpl'}

