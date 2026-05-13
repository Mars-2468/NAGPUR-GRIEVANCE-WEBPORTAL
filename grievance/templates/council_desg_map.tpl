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
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Chairman & Vice Chairman Map:</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                

               
			<form name='add_council' id="add_council" method='POST' action='council_desg_map.php' class="form-horizontal">
			    <input type="hidden" name="token" value="{$token_id}" />
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
					<div class="form-group">
						<label class="control-label col-md-3">Select Chairman Ward: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='chairman_ward' id='chairman_ward' class="form-control" required>
								       		<option value='0'>--Select Ward--</option>
								       		{html_options options=$ward_list selected=$data.chairman_status}	
								       	</select>
							</div>
							<input type="hidden" name='chairman_ward_old' id='chairman_ward_old' value="{$data.chairman_status}" />
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Select Vice Chairman Ward: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='wise_chairman_ward' id='wise_chairman_ward' class="form-control" required>
								       		<option value='0'>--Select Ward--</option>
								       		{html_options options=$ward_list selected=$data.wise_chairman_status}	
								       	</select>
							</div>
							<input type="hidden" name='wise_chairman_ward_old' id='wise_chairman_ward_old' value="{$data.wise_chairman_status}" />
					</div>
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<button type="reset" class="btn btn-danger">Cancel</button>
						</div>
					</div>
					
					</form>





{include file='footer.tpl'}

