{include file='header.tpl'}
<link rel="stylesheet" type="text/css" href="jquery-ui-1.8.17.custom.css"/>
{literal}
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script src="js/cryptojs/rollups/md5.js"></script>
<script src="js/cryptojs/components/md5.js"></script>
<script language='javascript'>

function check_availability()
{
		emp_id=$("#emp_id").val();
		
		//alert(emp_id);
		
		$.post('check_availability.php',{emp_id:emp_id},function(data)
		{
			//alert(data);
		var arr=data.split("::");
		$("#user_id").val(arr[0]);
		$("#user_name").val(arr[1]);
		$("#user_mobile").val(arr[0]);
		$("#user_code").val(arr[3]);
		
			
		});
	
	    
}


function validateForm()
{
    var errors =0;
	var user_mobile=document.add_user.user_mobile.value;
	var user_email=document.add_user.user_email.value;
	
	var patt= /^[7-9]\d{9}$/;
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var patt1= /^[a-zA-Z][a-zA-Z0-9]{5,}$/;
				
    
    	 	

	var user_pwd1=document.add_user.user_pwd1.value;
	var user_pwd2=document.add_user.user_pwd2.value;
	if(user_pwd1!=user_pwd2)
	{
		alert("Passwords donot match");
		errors++;
		return false; 
	}
   	if(!patt1.test(user_pwd2))
    	{
		alert("Password must Start with letter and can contain letters/numbers, Atleast 6 characters");
		errors++;
		return false;    	
	}    
   	
	if(errors == 0)
	{
	           var pwd=$("#user_pwd1").val();
                var encpwd=CryptoJS.MD5(pwd);
                if($("#fk").val(encpwd))
                {
                   
                  return false;
                }
                return false
	}
	else
	{
	    return false;
	}
}


</script>
{/literal}

<div >
<div>
{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
</div>
<form name='add_user' method='POST' action='change_password.php' onSubmit="return validateForm();" autocomplete="off">

<div class="row">
		<div >
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Change Password</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					
			

<br><br>
<div id="area">
<table width="100%"  border="0" cellspacing="3" cellpadding="0" class="table">

			
		<td width="15%">Password : </td>
		<td width="43%">
		    <input type='password' name='user_pwd1' id = "user_pwd1" class="form-control" required autocomplete="off">
		    <input type='hidden' name='fk' class="form-control" id="fk">
		    </td>
<tr>
	<td>Re Enter Password : </td>
	<td><input type='password' name='user_pwd2' class="form-control" required autocomplete="off"></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>


<tr>
	<th colspan='5'>
	<center>
		<input type='submit' name='save' value='Update Profile' class="btn btn-success">
		</center>
	</th>
</tr>

</table>
</div>

				</div>
			</div>
		</div>

</div>


</form>


</div>

<div class="row" id="div_print">
	


{include file='footer.tpl'}