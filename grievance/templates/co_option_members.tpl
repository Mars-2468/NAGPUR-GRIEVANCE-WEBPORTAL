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


function fill(cat_id,descriptin,dept_id,id)
{
	document.add_category.id.value=id;
	document.add_category.cat_id.value=cat_id;
	document.add_category.description.value=descriptin;
	document.add_category.type.value=1;
	$("#dept_id").val(dept_id);
	
} 


function delete_council(id)
{
	
	if(confirm('Do You really want to delete this record'))
	{
	   	    var csrf_token=$("#csrf_token").val();
		$.post('ajax_del_council.php',{id:id,csrf_token:csrf_token},function(data)
		{           
		   //alert(data);
		    
		if(data==1)
		{
		alert('Ward deleted successfully');
		window.location='co_option_members.php';
		}
		else if(data==0)
		{
		alert('Unable to delete , Try again');
		}
		else if(data==2)
		{
		alert(' You cannot delete this ');
		}
		else if(data==3)
		{
		    alert('Invalid token');
		}
		else if(data==4)
		{
		    alert('csrf error');
		}
		
		});
	}

} 

</script>


<!--

<script>

function check()
{
	var mobile=$("#mobile").val();
	var user_id=$("#user_id").val();
	$.post("check_mobile.php",{mobile:mobile,user_id:user_id},function(data)
	{
	alert(data);
	});
}

</script>

-->

<script language='javascript'>
function validateForm()
{
	var errors=0;
	$(".int1").each(function(){
	
		var patt=/^\d+$/;
		var val_field=$(this).val();
		if(!val_field.match(patt))
		{
		($(this)).css({"background-color": "pink"});
		errors++;
		}
		else
		{
		($(this)).css({"background-color": "white"});
		}
	});



	$(".mytext").each(function(){
	
		var val_field=$(this).val();
		val_field = val_field.trim();
		if(val_field=='')
		{
		($(this)).css({"background-color": "pink"});
		errors++;
		}
		else
		{
		($(this)).css({"background-color": "white"});
		}
	});	
	
	
	$(".combo1").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='0')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});
	
	

	if(errors==0)
	{
		return true;
	}
	else
	{
	alert("Please Enter Correct Value in High-lighted Fields - "+errors );
       	return false;
	}
	
	
}
      

</script>

<script>
       $(document).ready(function()
       {
		$(".num").keypress(function (test)
		{
    			if (test.which != 8 && test.which != 0 && (test.which < 48 || test.which > 57)) 
    			{
    				return false;
        		}
      		}); 
      		
      		 });
      		 
 </script>

<script>

function validation()
 
 {


 n=document.members.mobile.value;
      
 

     if(n.length!=10)
     { 
      
      alert("Please Enter Valid Number");
      members.mobile.value="";
      
     }
  
  }
  
</script>

{/literal}





 <div class="row ">
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Co-option Members</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                

               
			<!--<form name='add_council' id="add_council" method='POST' action='add_council.php' class="form-horizontal">
			
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
					</div>--
					
					</form>-->
					
					
					<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}


<form name="members" method="POST" action="co_option_members.php" enctype="multipart/form-data" onSubmit="return validateForm();" class="form-horizontal">
    			
    			<input type="hidden" name="token" value="{$token_id}" />
    			<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token"/>	
<input type="hidden" name="cid" value="3">
<input type="hidden" name="id" value="{$data.id}">

					<div class="form-group">
						<label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input type="text" name="name" id="name"  class="form-control mytext">
							</div>
						</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8">
						<input type="text" name="designation" id="designation"  class="form-control mytext">
							</div>
						</div>
					
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Mobile No: <span class="required"> </span></label>
							<div class="col-md-8">
			<input type="text" name="mobile" id="mobile"  class="form-control num" onblur="validation()">
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
					<input type="file" name="img_url" id="img_url"  class="form-control" maxlength="10" accept="image/*">
							</div>
					</div>
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<button type="reset" class="btn btn-danger">Cancel</button>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>




<div class="row">
		<div >
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Co-Option Members</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											
											<th>Photo</th>
											<th>Name</th>
											<th>Designation</th>
											<th>Mobile</th>
											<th colspan='2'>Operations</th>
											
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$data   key=id item=row}
									<tr>
										<td>{counter}</td>
										<td>{if $row.img_url eq ''}No Photo{else}<img src='{$row.img_url}' width="75px" height="75px">{/if}</td>
										<td>{$row.name}</td>
										<td>{$row.designation}</td>
										<td>{$row.mobile}</td>
										
										<td>
							                <a href="edit_members.php?id={$row.id}"><button type="submit" name="update" class="btn btn-danger">Update</button></a>
							                	<input type="button" value="Delete" onclick="delete_council('{$id}')" class="btn btn-danger">
										</td>
										
									</tr>
									{/foreach}
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>


{include file='footer_print.tpl'}

{include file='footer.tpl'}

