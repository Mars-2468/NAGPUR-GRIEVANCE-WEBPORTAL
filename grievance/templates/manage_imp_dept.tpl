{include file='header.tpl'}
{literal}
<script>
function fill(dept_id,dept_desc)
{
	document.manage_dept.dept_id.value=dept_id;
	document.manage_dept.dept_desc.value=dept_desc;
} 

function validateForm()
{
	var dept_desc=document.manage_dept.dept_desc.value;		
	if(dept_desc=='')
	{
		alert("Please Enter Department Name");
		return false;
	}

	return true;
}

function delete_rec(dept_id)
{
    if(confirm('Do you really want to delete this record'))
	{
		$.post('ajax_del_imp_dept.php',{dept_id:dept_id},function(data)
		{
			if(data==1)
			{
			alert('Deleted successfully');
			window.location='manage_imp_dept.php';
			}
			else if(data==0)
			{
			alert('Unable to delete try again');
			}
			else
			{
			alert(data);
			}
		});
	}
	
	

      /*  if(confirm('Do You really want to delete this record'))
	    {
	    var csrf_token=$("#csrf_token").val();
		$.post(ajax_del_imp_dept.php',{dept_id:dept_id,csrf_token:csrf_token},function(data)
		{
			//alert(data);
			if(data==1)
			{
			alert('Deleted successfully');
			window.location='manage_imp_dept.php';
			}
			else if(data==0)
		    {
		    alert('Unable to delete , Try again');
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
	}*/


}
</script>


<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('http://municipalservices.in/manage_imp_dept.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>
{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Add Department</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
			<form  method="post" action="manage_imp_dept.php" name="manage_dept"  class="form-horizontal" onSubmit="return validateForm()">
			    <input type="hidden" name="token" value="{$token_id}"/>
			     <input type="hidden" name="csrf_token" value="{$csrf_token}"/>

			<input type='hidden' name='dept_id' value='0'>
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Department <span class="required">* </span></label>
							<div class="col-md-8">
								<input type="text" name="dept_desc" data-required="1" class="form-control" id="dept_desc" required/>
							</div>
					</div>
					
					
					
					<div class="form-group" id="ref">
						<label class="control-label col-md-3">
						    <div style="border:1px solid #ccc;position: relative;left: 116px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;
font-weight: bold;letter-spacing: 10px;font-size: 16px;" >
						        <p id="captImg" style="margin-top: 10px;">{$code}</p>
						    </div>
						</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" required="required" style="width: 385px;
border-radius: 3px;" onpaste="return false;" >
                    <input type="hidden" name="code" value="{$code}">
							</div>
							
					</div>
					
					<div class="col-md-6 col-md-offset-3">
                     <p>Can't read the image? click <a  id="buss" class="refreshCaptcha" style="cursor:pointer;">here</a> to refresh.</p>
					</div>
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name="save">Submit</button>
						<button type="button" class="btn btn-danger">Cancel</button>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>




<div class="row" id="div_print">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>Departments</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											<th>Department</th>
											
											<th>EDIT</th>
											<th>DELETE</th>
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$dept_list item=dept_desc key=dept_id}
										<tr>
											<td>{counter}</td>
											<td>{$dept_desc}</td>
											
											<td>
											
                        <button class="btn btn-success" name='update' onclick="fill('{$dept_id}','{$dept_desc}')">
                      <span class="fa fa-pencil"></span> Edit
                      </button>
                                            
											</td>
											<td>
											<input type="button" value="Delete" onclick="delete_rec('{$dept_id}')" class="btn btn-danger">
											
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

