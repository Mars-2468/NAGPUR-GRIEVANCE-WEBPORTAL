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
function delete_rec(id,edition_no)
{

var del=confirm("Are you sure you want to delete this record?");
        if (del==true){
        
        $.post("ajax_delete_imp_contacts.php",{id:id},function(data)
	{
		
		 if(data==1)
		{
			alert('Record deleted successfully');
			window.location='important_contacts.php';
		}
		else if(data==2)
		{
		alert('Unable to delete , Try again');
		return false;
		}
	
        });
}
}
function fun1(id,dept_id,name,designation,mobile)
{
	$("#id").val(id);
	$("#dept_id").val(dept_id);
	$("#name").val(name);
	$("#designation").val(designation);
	$("#mobile").val(mobile);
	$("#update_status").val(1);
	
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


{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Important Contacts</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                

               
			
					
					
					<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}


<form   method="POST" action="important_contacts.php" enctype="multipart/form-data" onSubmit="return validateForm();" class="form-horizontal">

<input type="hidden" name="token" value="{$token_id}"/>
<input type="hidden" name="update_status" id="update_status" value="0">
<input type="hidden" name="id" id="id">


					<div class="form-group">
						<label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-8">
									 <select name="dept_id"  id="dept_id" class="form-control mytext"  required>
									 <option value="">---select---</option>
									 {html_options options=$dept_list}
									 
									 </select>
							</div>
						</div>

					<div class="form-group">
						<label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input type="text" name="name" id="name"  class="form-control mytext"  required>
							</div>
						</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input type="text" name="designation" id="designation"  class="form-control mytext" required>
							</div>
						</div>
					
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Mobile No/ Land Line no: <span class="required"> </span></label>
							<div class="col-md-8">
			<input type="text" name="mobile" id="mobile"  class="form-control" maxlength="10" required>
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


<div  id="div_print" style="border:#999999 0px solid;">

<div class="row">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Co-Option Members</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                <form action="important_contacts.php" method="post" onSubmit="return validateForm2()">
					<table class="table table-striped table-bordered table-hover table-full-width" >
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											
											<th>Department</th>
											<th>Name</th>
											<th>Designation</th>
											<th>Mobile</th>
											<th>Sort Order</th>
											<th>Edit</th>
											<th>Delete</th>
											
										</tr>
									</thead>
									
									<tbody>
									{assign var="i" value="0"}
									{foreach from=$data   key=id item=row}
									<input type="hidden" name="{'id'|cat:$i}" value="{$id}">
									<tr>
										<td>{counter}</td>
										<td>{$dept_list[$row.dept_id]}</td>
										<td>{$row.name}</td>
										<td>{$row.designation}</td>
										<td>{$row.mobile}</td>
										
										<td>
										<select id="{'orderid'|cat:$i}" name="{'orderid'|cat:$i}">
										<option value="">--select--</option>
										{html_options options=$desg_count_list selected=$row.sort_order}
										</select>
										
										</td>
										
										<td>
							<button type="button" name="update" class="btn btn-primary" onclick="fun1('{$row.id}','{$row.dept_id}','{$row.name}','{$row.designation}','{$row.mobile}')">Update</button>
										</td>
										
										<td>
										<input type='button' value="Delete" class="btn btn-danger" onclick="delete_rec('{$row.id}')">
										</td>
										
									</tr>
									{assign var="i" value=$i+1}
									{/foreach}
									<tr>
									
									<td colspan="8">
									<input type="hidden" name="cnt" value="{$i}">
								    <center><!--<input type="submit" name="sort_order" value="update" class="btn btn-success"></center>-->
									</td>
									
									</tr>	
										
									</tbody>
									
									
								</form>
								</table>
				</div>
			</div>
		</div>

</div>
{include file='footer_print.tpl'}

{include file='footer.tpl'}

