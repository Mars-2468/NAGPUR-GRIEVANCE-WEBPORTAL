{include file='header.tpl'}
{literal}


{/literal}




 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Set Default ULB</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               
			<form   method="post" action="setDefaultUlb.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='uid' value='{$uid}'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Select Default ULB for this session: <span class="required">* </span></label>
							<div class="col-md-5">
								<select class="form-control" name="defaultULB">
								    <option value="">-- select --</option>
								    {html_options options=$mergedUlbs selected=$DefaultULB}
								</select>
							</div>
					</div>
					
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Set as Default ULB</button>
						
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>









<br>
{include file='footer.tpl'}

