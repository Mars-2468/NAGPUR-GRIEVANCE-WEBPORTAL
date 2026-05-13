{include file='header.tpl'}
{literal}
<script>



function validateForm()
{
var errors=0;
$(".dropdown").each(function(){
	
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
	
	$(".mytext").each(function(){
	
		var val_field=$(this).val();
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
	
	if(errors==0)
	{
	return true;
	}
	else
	{
	alert('Please Provide validate data in heilighted fields');
	return false;
	}
}

function fill(cs_id,cat_id,cs_desc)
{
	$("#update_status").val(1);
	$("#cs_id").val(cs_id);
	$("#cat_id").val(cat_id);
	$("#cat3_desc").val(cs_desc);
}
</script>
{/literal}
<div class="row ">
<div class="col-lg-12">
	<div class="boxed">
	                <!-- Title Bart Start -->
		<div class="title-bar success">
			<h4>Add Complaint</h4>
			                  
		</div>
		                
			<div class="inner no-radius">
				<form action="create_cs.php" class="form-horizontal" method="post" onsubmit="return validateForm()">
				<input type="hidden" name="update_status" value="0" id="update_status">
				<input type="hidden" name="cs_id" id="cs_id">
					<div class="form-body">
					{if $error_status eq '0'}
						<divclass="alert alert-success display-hide" >
						<button class="close" data-close="alert"></button>
						Data inserted successfully
						</div>
					{/if}	
					{if $error_status gt '0'}
						<div class="alert alert-danger display-hide"style="display:none">
							<button class="close" data-close="alert"></button>
							Unable to update Try .again
						</div>
					{/if}
						
						<div id="form_div"><!-------------------- form div ---------------->
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Category <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="cat_id" id="cat_id">
								<option value="0">---select---</option>
								{html_options options=$cat_list}
								</select>
							</div>
						</div>
									
						<div class="form-group">
							<label class="control-label col-md-3"> complaint Description <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<input type="text" name='cat3_desc' id='cat3_desc' data-required="1" class="form-control mytext"/>
							</div>
						</div>
						
						
						
						
						<div class="form-actions fluid">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" class="btn btn-info" name="save">Submit</button>
								<button type="button" class="btn btn-danger">Cancel</button>
							</div>
						</div>
						</div><!----------------------- form div ------------------------>
					</form>
				</div>
			</div>
                </div>
          </div>
</div>
                
<div class="row">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>EXISTING COMPLAINTS</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
									<thead>
										
										<tr >
											<th>S.No</th>
											
											<th>Category Name</th>
											<th>Complaint Name</th>
											<th>Edit</th>
											
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$data  key=id item=row}
									<tr>
										<td>{counter}</td>
										
										<td>{$cat_list[$row.cat_id]}</td>
										<td>{$row.cs_desc}</td>
										
										
										<td>
										<input type='radio' name='update' onchange="fill('{$row.cs_id}','{$row.cat_id}','{$row.cs_desc}')">
										</td>
										
									</tr>
									{/foreach}
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>

{include file='footer.tpl'}
{literal}
<script>
$(document).ready(function() {

$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });

$("#checkall").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});


$("#checkval").click(function(){
   $('#checkall').attr('checked', false); 
});

             

}); 
</script>
{/literal}