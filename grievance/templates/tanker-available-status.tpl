{include file='header.tpl'}
{literal}



<script>
function fill(street_id,ward_id,street_desc)
{
	document.manage_street.street_id.value=street_id;
	$('#ward_id').val(ward_id);
	document.manage_street.street_desc.value=street_desc;
} 

function delete_street(street_id)
{
	var msg= "Do you want to delete the selected Street?";
	var answer = confirm (msg);
	if (answer)
	{
		document.manage_street_del.street_id.value=street_id;
		document.manage_street_del.submit();
	}

} 

function validateForm()
{

	var ward_id=document.manage_street.ward_id.selectedIndex;		
	if(ward_id=='0')
	{
		alert("Please Select Ward");
		return false;
	}


	var street_desc=document.manage_street.street_desc.value;		
	if(street_desc=='')
	{
		alert("Please Enter Street Description");
		return false;
	}

	return true;
}

</script>
{/literal}

<div class="row ">
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Tanker Available Status:</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               <form method="post" name='manage_street_del'  action="manage_street_del.php">
                   
		<input type='hidden' name='street_id' vlaue=''>
		</form>
	<form   method="post" action="tanker-available-status.php" name="manage_street"  class="form-horizontal" onSubmit="return validateForm()">
			<input type="hidden" name="token" value="{$token_id}" />
			<input type='hidden' name='street_id' value='0'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}

					<div class="form-group">
						<label class="control-label col-md-3">Tanker Status:<span class="required">* </span></label>
							<div class="col-md-3">
								<select name='status' id='status' data-required="1" class="form-control">
							       		<option value='0'>--Select--</option>
							       		{html_options options=$status_list selected=$status}
							       	</select>
							</div>
					</div>
					
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<!--<button type="button" class="btn btn-danger">Cancel</button>-->
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>



{include file='footer.tpl'}

