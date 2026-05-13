{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    	
 
    	



{/literal}




 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Push Notifications</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
			<form  method="post" action="push_notifications.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()" enctype="multipart/form-data">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Title <span class="required">* </span></label>
							<div class="col-md-8">
								<input type="text" name="title" data-required="1" class="form-control" id="dept_desc"/>
							</div>
					</div>
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Message <span class="required">* </span></label>
							<div class="col-md-8">
								<textarea type="text" rows="5" name="message" data-required="1" class="form-control" id="dept_desc" required/></textarea>
							</div>
					</div>
					
					
					<!--<div class="form-group">
						<label class="control-label col-md-3">C <span class="required">* </span></label>
							<div class="col-md-8">
								<input type="file" rows="5" name="" data-required="1" class="" id="dept_desc"/>
							</div>
					</div>-->
					
					
					
					
					
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




<!--<div class="row" id="div_print">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <!--<div class="title-bar white">
                  <h4>Wards</h4>
                  
                </div>
                <!-- Title Bart End -->
                <!--<div class="inner no-radius">
					<!--<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											<th>Ward</th>
											
											<th>EDIT</th>
											<th>DELETE</th>
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
											<td>
											<input type="button" value="Delete" onclick="delete_ward('{$ward_id}')" class="btn btn-danger">
											</td>
										</tr>
										{/foreach}
										
										
									</tbody>
								</table>-->
				<!--</div>
			</div>
		</div>

{include file='footer_print.tpl'}-->


{include file='footer.tpl'}

