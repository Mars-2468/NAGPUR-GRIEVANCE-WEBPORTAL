{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->


<script>
function fill(ward_id,ward_desc)
{
	document.manage_wards.ward_id.value=ward_id;
	document.manage_wards.ward_desc.value=ward_desc;
} 

function delete_ward(ward_id)
{
	var msg= "Do you want to delete the selected Ward";
	var answer = confirm (msg);
	if (answer)
	{
		document.manage_wards_del.ward_id.value=ward_id;
		document.manage_wards_del.submit();
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
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Select Edition</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                <form method="post" name='manage_wards_del'  action="manage_wards_del.php">
			<input type='hidden' name='ward_id' vlaue=''>
			</form>
			<form   method="post" action="select_edition.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()">
			    <input type="hidden" name="token" value="{$token_id}" />
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Select Edition: <span class="required">* </span></label>
							<div class="col-md-5">
							{foreach from=$edition_list item=row key=id}
								<input type="radio" name="edition_no" id="edition_no" class="edition_no"
								{if $row.status eq '1' }checked {/if}value="{$id}" >&nbsp; &nbsp; <b>{$row.edition_no}</b><br>
								{/foreach}
							</div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
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




<!--<div class="row">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start --
                <div class="title-bar white">
                  <h4>EXISTING WARDS</h4>
                  
                </div>
                <!-- Title Bart End --
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
									<thead>
										<thead>
										<tr>
											<th>S.No</th>
											<th>Ward No / Description</th>
											<th>No of Streets Entered</th>
											<th >EDIT</td>
											<th>DELETE</th>
										</tr>
									</thead>
									</thead>
									<tbody>
									
									{foreach from=$ward_list item=ward_desc key=ward_id}
										<tr>
											<td>{counter}</td>
											<td>{$ward_desc}</td>
											<td>{$ward_list1[$ward_id]}</td>
											<td align="center">
                     
                      <button class="btn btn-success" name='update' onclick="fill('{$ward_id}','{$ward_desc}')">
                      <span class="fa fa-pencil"></span> Edit
                      </button>                     
                                           </td>
											<td align="center">
											{if !isset($ward_list1[$ward_id])}
					<!--<input type='radio' name='delete_ward' onChange="delete_ward('{$ward_id}')">	--
                      <button class="btn btn-danger" name='delete_ward' onChange="delete_ward('{$ward_id}')">
                      <span class="fa fa-trash"></span> Delete
                      </button>	
											{/if}										  </td>
					  </tr>
										{/foreach}
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>-->




{include file='footer.tpl'}

