{include file='header.tpl'}
{literal}
<script>


function validateForm()
{

	
}
</script>
{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Add </h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                <form method="post" name='manage_desg_del'  action="manage_desg_del.php">
		<input type='hidden' name='desg_id' vlaue=''>
		</form>

               
			<form   method="post" action="addcontent_media_coverage.php" name="manage_desg"  class="form-horizontal" enctype="multipart/form-data" onSubmit="return validateForm()">
			<input type='hidden' name='desg_id' value='0'>
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Editon: <span class="required">* </span></label>
							<div class="col-md-5">
									<select name='edition_no' id='edition_no' class="form-control">
								       		<option value='0'>--Select Editon--</option>
								       		{html_options options=$edition_list}	
								       	</select>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Description: <span class="required">* </span></label>
							<div class="col-md-5">
									 <textarea name="description" id="description" class="form-control char mytext"> </textarea>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Image: <span class="required">* </span></label>
							<div class="col-md-5">
									<input type="file" name="img_url" id="img_url" class="form-control char mytext" accept="image/x-png, image/gif, image/jpeg" /> 
							</div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<button type="button" class="btn btn-danger">Cancel</button>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>




<!--<div class="row">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start --
                <div class="title-bar white">
                  <h4>EXISTING DESIGNATIONS</h4>
                  
                </div>
                <!-- Title Bart End --
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
									<thead>
										
										<tr>
											<th>S.No</th>
											<th>Department</th>
											<th>Designation</th>
											<th>No of Employees</th>
											<th>EDIT</td>
											<th>DELETE</th>
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$desg_list item=row key=desg_id}
									<tr>
										<td>{counter}</td>
										<td>{$dept_list[$row.dept_id]}</td>
										<td>{$row.desg_desc}</td>
										<td>{$row.num_emp}</td>
										<td>
										<input type='radio' name='update' onchange="fill('{$desg_id}','{$row.dept_id}','{$row.desg_desc}')">			
										</td>
										<td>
										{if !isset($row.num_emp)}
											<input type='radio' name='delete_desg' onchange="delete_desg('{$desg_id}')">		
										{/if}
										</td>
									</tr>
									{/foreach}
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>-->




{include file='footer.tpl'}

