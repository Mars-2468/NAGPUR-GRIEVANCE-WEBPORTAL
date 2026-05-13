{include file='header.tpl'}
{literal}



    	

    	
 
    	



{/literal}




 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Services SLA</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                    
                    <table class="display table-bordered table-striped table-condensed cf" id="data-table">
                        <thead>
                            <tr style="background-color:#161D6E; color:#FFF;">
                                <th>Sno</th>
                                <th>Service name</th>
                                <th>SLA</th>
                            </tr>
                        </thead>
                            <tbody>
                                {foreach from=$cat_list item=row key=cat_id}
                                <tr style="background-color:#D9FAFF; font-weight:bold; color:#000;">
                                    <td colspan="3">{$cat_list[$cat_id]}</td>
                                </tr>
                                {foreach from=$data[$cat_id] item=row2 key=cs_id}
                                <tr>
                                    <td>{counter}</td>
                                    <td>{$cs_list[$cs_id]}</td>
                                    <td>{$data[$cat_id][$cs_id].cutt_off_time}</td>
                                </tr>
                                {/foreach}
                                
                                {/foreach}
                            </tbody>
                       
                        </table>
                        
                        {include file='footer_print.tpl'}
			<!--<form  method="post" action="comp_cutoffdate_map.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				{assign var="i" value=0}
				{foreach from=$cat_list item=row key=cat_id}
					
						<div class="title-bar success"><h4>{$cat_list[$cat_id]}</h4> </div>
						{foreach from=$cs_list[$cat_id] item=row2 key=cs_id}
						<div class="form-group">
						<label class="control-label col-md-3">{$row2.desc} </label>
							<div class="col-md-8">
							    <input type="hidden" name="{'cs_id'|cat:$i}" id="{'cs_id'|cat:$i}" value="{$cs_id}">
								<!--<input type="text" name="{'cutt_of_time'|cat:$i}" data-required="1" class="form-control num" id="{'cutt_of_time'|cat:$i}" placeholder="No.of Disposable days" value="{$data[$cs_id].cutt_off_time}"/>--
								<span>{$data[$cs_id].cutt_off_time}</span>
							</div>
					</div>
					{assign var="i" value=$i+1}
					{/foreach}
				{/foreach}	
				<input type="hidden" name="cnt" value="{$i}">
				<!--	<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name="save">Submit</button>
						<button type="button" class="btn btn-danger">Cancel</button>
						</div>-->
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>








{include file='footer.tpl'}

{literal}
<script>
   $(".num").keydown(function(event) {
    // Allow only backspace and delete
    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ) {
        // let it happen, don't do anything
    }
    else {
        // Ensure that it is a number and stop the keypress
        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault(); 
        }   
    }
});
    
    
</script>
{/literal}

