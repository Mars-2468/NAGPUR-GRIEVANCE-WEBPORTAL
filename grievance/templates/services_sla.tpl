{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    	
 
    	


<script>
function fill(ward_id,ward_desc)
{
	document.manage_wards.ward_id.value=ward_id;
	document.manage_wards.ward_desc.value=ward_desc;
} 

function delete_ward(ward_id)
{
	
	if(confirm('Do You really want to delete this record'))
	{
	
		$.post('ajax_del_ward.php',{ward_id:ward_id},function(data)
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
	<div class="">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Services SLA</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                    <div id="area">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
                        <thead>
                            <tr style="background-color:#161D6E; color:#FFF;">
                                <th>Sno</th>
                                <th>Service name</th>
                                <th>SLA</th>
                            </tr>
                            <tbody>
                                {foreach from=$cat_list item=row key=cat_id}
                                <tr style="background-color:#D9FAFF; font-weight:bold; color:#000;">
                                    <td colspan="3">{$cat_list[$cat_id]}</td>
                                </tr>
                                {foreach from=$cs_list[$cat_id] item=row2 key=cs_id}
                                <tr>
                                    <td>{counter}</td>
                                    <td>{$row2.desc}</td>
                                    <td>{$data[$cs_id].cutt_off_time}</td>
                                </tr>
                                {/foreach}
                                
                                {/foreach}
                            </tbody>
                        </thead>
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

