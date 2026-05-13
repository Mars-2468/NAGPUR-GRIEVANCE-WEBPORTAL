{include file='header.tpl'}
<link rel="stylesheet" type="text/css" href="jquery-ui-1.8.17.custom.css"/>
{literal}
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script language='javascript'>
function toggle(checked)
{
	if(checked)
	{
		document.update_profile.user_pwd1.disabled=false;
		document.update_profile.user_pwd2.disabled=false;
	}
	else
	{
		document.update_profile.user_pwd1.value="";
		document.update_profile.user_pwd2.value="";		
		document.update_profile.user_pwd1.disabled=true;
		document.update_profile.user_pwd2.disabled=true;	
	}
}
function validateForm()
{
	var user_mobile=document.update_profile.user_mobile.value;
	var user_email=document.update_profile.user_email.value;
	var checked=document.update_profile.change_pwd.checked;
	
	var patt= /^[7-9]\d{9}$/;
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var patt1= /^[a-zA-Z][a-zA-Z0-9]{5,}$/;
				
    	if(!patt.test(user_mobile))
    	{
		alert("Please Enter Valid Mobile No");
		return false;    	
    	}
    	
    	if(!re.test(user_email))
    	{
		alert("Please Enter Valid email");
		return false;    	
    	}    	
    	if(checked)
    	{
		var user_pwd1=document.update_profile.user_pwd1.value;
		var user_pwd2=document.update_profile.user_pwd2.value;
		if(user_pwd1!=user_pwd2)
		{
			alert("Passwords donot match");
			return false; 
		}
	   	if(!patt1.test(user_pwd2))
	    	{
			alert("Password must Start with letter and can contain letters/numbers, Atleast 6 characters");
			return false;    	
    		}    

    		
    	}
    	
	return true;
}


</script>
{/literal}

<div >
<form name='update_profile' method='POST' action='update_profile.php' onSubmit="return validateForm();" autocomplete="off">

<input type="hidden" name="token" value="{$token_id}" />
<div class="row">
		<div >
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>Update Profile</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table width="100%" height="100%" border="1" cellspacing="3" cellpadding="0" class="table-bordered table-striped table-condensed cf">
{if isset($data)}

<tr>
	<td>Name : </td>
	<td><input type='text' tabIndex="1" name='user_name' size='50' maxlength='100' value='{$data.user_name}'></td>
	<td>Change Password : </td>
	<td><input type='checkbox' tabIndex="4"  name='change_pwd' onChange="toggle(this.checked)"></td>
</tr>
<tr>
	<td>e-Mail : </td>
	<td><input type='text' tabIndex="2"  name='user_email' value='{$data.user_email}'></td>
	<td>New Password : </td>
	<td><input type='password' tabIndex="5"  name='user_pwd1' disabled='disabled' autocomplete="off"></td>
</tr>
<tr>
	<td>Mobile : </td>
	<td><input type='text' tabIndex="3"  name='user_mobile' value='{$data.user_mobile}'></td>
	<td>Re Enter Password : </td>
	<td><input type='password' tabIndex="6"  name='user_pwd2' disabled='disabled' autocomplete="off"></td>
</tr>
<tr>
	<th colspan='4' ="center">
	<center>
		<input type='submit' name='save' value='Update Profile' class="btn btn-success">
		</center>
	</th>
</tr>
{/if} 
</table>
				</div>
			</div>
		</div>

</div>


</form>


</div>


{include file='footer.tpl'}