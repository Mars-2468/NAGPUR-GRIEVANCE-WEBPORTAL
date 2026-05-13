{include file='header.tpl'}
<link rel="stylesheet" type="text/css" href="jquery-ui-1.8.17.custom.css"/>
{literal}
<style>
table tr:nth-child(odd) {
 background-color: #f1f1f1;
}
table tr:nth-child(even) {
 background-color: #ffffff;
}
</style>

<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script language='javascript'>
function get_det(user_id)
{
	if(user_id==0)
    	{
		$("#area").hide();
		alert("Select User ID");
		return false;    	
	}
	else
	{
		$("#area").hide();
		self.location.href='update_user_services.php?user_id='+user_id;
	}
}

function validateForm()
{
	return true;
}


</script>
{/literal}

<div >

<form name='update_user_services' method='POST' action='update_user_services.php' onSubmit="return validateForm();" >

<input type="hidden" name="token" value="{$token_id}"/>

<div class="form-group">
						<label class="control-label col-md-3" style="text-align:right;">Select User : <span class="required">* </span></label>
							<div class="col-md-5">
								<select name='user_id' onchange="get_det(this.value)" class="form-control">
	<option value='0'>--Select--</option>
	{html_options options=$user_list selected=$user_id_sel}
</select>
							</div>
					</div>

<br><br>
<div>
{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
</div>
{if isset($data)}
<div id="area">
<table width="100%" height="100%" border="0" cellspacing="3" cellpadding="0" class="table">

<tr>
	<th bgcolor='#0d76d9' colspan='6'><font color='white'>ASSIGN / UPDATE SERVICES</font></th>
</tr>
<tr>
	<td>Name : </td>
	<td>{$data.user_name}</td>
	<td>e-Mail : </td>
	<td>{$data.user_email}</td>
	<td>Mobile : </td>
	<td>{$data.user_mobile}</td>

</tr>
<tr>
	<td colspan='6'><b>Check the Services you want to Assign to the selected user</b></td>
</tr>
<tr>
{foreach from=$service_list key=service_id item=service_name name=foo}
	
		<td colspan='2'>
			<input type='checkbox' name={"service_id__"|cat:$service_id} value='1'
			{if $data_services["service_id__"|cat:$service_id] eq '1'}checked=checked{/if}
			>
			{$service_name}

		</td>
		{if $smarty.foreach.foo.iteration %3==0}
		</tr><tr>
		{/if}
{/foreach}

</tr>

<tr>
	<th colspan='6'>
	<center>
		<input type='submit' name='save' value='Update Services' class="btn btn-success">
		</center>
	</th>
</tr>

</table>
<br>
<br>

</div>
{/if} 
</form>


</div>


{include file='footer.tpl'}