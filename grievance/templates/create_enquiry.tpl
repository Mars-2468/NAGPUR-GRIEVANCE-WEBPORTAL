{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    <script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('http://municipalservices.in/manage_wards.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>	

<script>
function fill(ward_id,ward_desc)
{
	document.manage_wards.id.value=ward_id;
	document.manage_wards.ward_desc.value=ward_desc;
} 






function delete_ward(ward_id)
{
	
	if(confirm('Do You really want to delete this record'))
	{
	    var csrf_token=$("#csrf_token").val();
		$.post('ajax_del_ward.php',{ward_id:ward_id,csrf_token:csrf_token},function(data)
		{
		   
		    
		if(data==1)
		{
		alert('Ward deleted successfully');
		window.location='manage_wards.php';
		}
		else if(data==0)
		{
		alert('Unable to delete , Try again');
		}
		else if(data==2)
		{
		alert('Ward is mapped with employees You cannot delete this ward');
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

function validateForm()
{
	var ward_desc=document.manage_wards.ward_desc.value;		
	if(ward_desc=='')
	{
		alert("Please Enter Ward No / Description");
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
                  <h4>Add Enquiry</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
			<form  method="post" action="create_enquiry.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()">
			    <input type="hidden" name="token" value="{$token_id}" />
			<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token"/>
			<input type='hidden' name='id' value='0'>
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Enquiry Name <span class="required">* </span></label>
							<div class="col-md-4">
								<input type="text" name="ward_desc" data-required="1" class="form-control" id="dept_desc"/ required="required">
							</div>
					</div>
					
					
				  
				
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name="save">Submit</button>
					
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>




<div class="row" id="div_print">
		<div>
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                    
                  <h4>Enquiry List</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											<th>Enquiry Name</th>
											<th>EDIT</th>
											
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$ward_list item=ward_desc key=ward_id}
										<tr>
											<td>{counter}</td>
											<td>{$ward_desc}</td>
											
											<td>
											
                        <button class="btn btn-success" name='update' onclick="fill('{$ward_id}','{$ward_desc}')">
                      <span class="fa fa-pencil"></span> Edit
                      </button>
                                            
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

