{include file='header.tpl'}
<link rel="stylesheet" type="text/css" href="jquery-ui-1.8.17.custom.css"/>
{literal}
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script src="js/cryptojs/rollups/md5.js"></script>
    <script src="js/cryptojs/components/md5.js"></script>
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
		self.location.href='update_user.php?user_id='+user_id;
	}
}
function toggle(checked)
{
	if(checked)
	{
		document.update_user.user_pwd1.disabled=false;
		document.update_user.user_pwd2.disabled=false;
	}
	else
	{
		document.update_user.user_pwd1.value="";
		document.update_user.user_pwd2.value="";		
		document.update_user.user_pwd1.disabled=true;
		document.update_user.user_pwd2.disabled=true;	
	}
}
function validateForm()
{
	var user_mobile=document.update_user.user_id.value;
	var user_email=document.update_user.user_email.value;
	var checked=document.update_user.change_pwd.checked;
	
	var patt= /^[7-9]\d{9}$/;
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var patt1= /^[a-zA-Z][a-zA-Z0-9]{5,}$/;
				
    	if(!patt.test(user_mobile))
    	{
		alert("Please Enter Valid Mobile No");
		return false;    	
    	}
    	
    	if(user_email !='')
    	{
	    	if(!re.test(user_email))
	    	{
			alert("Please Enter Valid email");
			return false;    	
	    	} 
    	}   	
    	if(checked)
    	{
    		var user_pwd1=document.update_user.user_pwd1.value;
    		var user_pwd2=document.update_user.user_pwd2.value;
    		if(user_pwd1!=user_pwd2)
    		{
    			alert("Passwords donot match");
    			return false; 
    		}
    		else
    		{
    		    var pwd=$("#user_pwd1").val();
                var encpwd=CryptoJS.MD5(pwd);
                if($("#fk").val(encpwd))
                {
                   $("#user_pwd1").val('');
                   $("#user_pwd2").val('');
                  return true;
                }
    		}
	   	 

    		
    	}
    	
	return true;
}


</script>
{/literal}

<div>

<form name='update_user' method='POST' action='update_user.php' onSubmit="return validateForm();" >
    
<input type="hidden" name="token" value="{$token_id}"/>

<div class="row">
		<div >
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>UPDATE USER</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					{if isset($msg)}{$msg}{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Select User : <span class="required">* </span></label>
							<div class="col-md-5">
								<select name='user_id' onchange="get_det(this.value)" class="form-control">
									<option value='0'>--Select--</option>
									{html_options options=$user_list selected=$user_id_sel}
								</select>
							</div>
					</div>
				
					
					{if isset($data)}
						<br><br>
	<div id="area">
	    
<table width="100%" height="100%" border="0" cellspacing="3" cellpadding="0" class="table">

<tr>
	<th bgcolor='#0d76d9' colspan='4'><font color='white'>UPDATE PROFILE</font></th>
</tr>
<tr>
	<td>Name : </td>
	<td><input type='text' tabIndex="1" name='user_name' size='50' maxlength='100' value='{$data.user_name}'></td>
	<td>Change Password : </td>
	<td><input type='checkbox' tabIndex="4"  name='change_pwd' onchange="toggle(this.checked)"></td>
</tr>
<tr>
	<td>e-Mail : </td>
	<td><input type='text' tabIndex="2"  name='user_email' value='{$data.user_email}'></td>
	<td>New Password : </td>
	<td>
	    <input type='password' tabIndex="5"  name='user_pwd1' id="user_pwd1" disabled='disabled' autocomplete="off">
	    <input type="hidden" name="fk" id="fk">
	    </td>
</tr>
<tr>

	<td>Re Enter Password : </td>
	<td><input type='password' tabIndex="6"  name='user_pwd2' disabled='disabled' autocomplete="off"></td>
</tr>
<tr>
	<th colspan='4'>
	<center>
		<input type='submit' name='save' value='Update Profile' class="btn btn-success">
		</center>
	</th>
</tr>

</table>
</div>
		{/if} 			
					
					
				</div>
			</div>
		</div>

</div>










<!--<center><h3>UPDATE USER</h3>
Select User : 
<select name='user_id' onchange="get_det(this.value)">
	<option value='0'>--Select--</option>
	{html_options options=$user_list selected=$user_id_sel}
</select>
</center>
<br/><br/>

{if isset($data)}
<div id="area">
<table width="100%" height="100%" border="0" cellspacing="3" cellpadding="0">


<tr>
	<td>Name : </td>
	<td><input type='text' tabIndex="1" name='user_name' size='50' maxlength='100' value='{$data.user_name}'></td>
	<td>Change Password : </td>
	<td><input type='checkbox' tabIndex="4"  name='change_pwd' onchange="toggle(this.checked)"></td>
</tr>
<tr>
	<td>e-Mail : </td>
	<td><input type='text' tabIndex="2"  name='user_email' value='{$data.user_email}'></td>
	<td>New Password : </td>
	<td><input type='password' tabIndex="5"  name='user_pwd1' disabled='disabled'></td>
</tr>
<tr>
	<td>Mobile : </td>
	<td><input type='text' tabIndex="3"  name='user_mobile' value='{$data.user_mobile}'></td>
	<td>Re Enter Password : </td>
	<td><input type='password' tabIndex="6"  name='user_pwd2' disabled='disabled'></td>
</tr>
<tr>
	<th colspan='4'>
		<input type='submit' name='save' value='Update Profile' class="btn btn-success">
	</th>
</tr>

</table>
</div>-->
{/if} 
</form>


</div>


{include file='footer.tpl'}