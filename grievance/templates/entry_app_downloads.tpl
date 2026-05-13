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
function checknumbers(i,code)
{
    var errors=0;
    var ulb_downloads=parseInt($("#ulb_downloads" + i).val());
    var active_downloads=parseInt($("#active_downloads" +i ).val());
    var present_ulb_downloads=parseInt($("#present_ulb_downloads" + i).val());
    var present_active_downloads=parseInt($("#present_active_downloads" +i ).val());
    $("#percent_ulb_downloads" + i).val('');
    $("#percent_active_downloads" + i).val('');
    if(code==1)
    {
    
    
        if(active_downloads > ulb_downloads)
        {
            alert('Active Installations must be less than Total Installations');
            $("#active_downloads" + i).val('');
            $("#active_downloads" + i).val('');
            errors++;
        }
    }
    else if(code==2)
    {
        
        if(present_active_downloads > present_ulb_downloads)
        {
            alert('Active Installations must be less than Total Installations');
            $("#present_ulb_downloads" + i).val('');
            $("#present_active_downloads" + i).val('');
            errors++;
        }
        
    }
    
    if(errors==0)
    {
        
        downloadper = parseFloat((present_ulb_downloads-ulb_downloads)/present_ulb_downloads*100);
        if(isNaN(downloadper))
        {
            downloadper=0;
        }
        
        if(present_ulb_downloads==0)
        {
            $("#percent_ulb_downloads" + i).val('0');
        }
        else
        {
           $("#percent_ulb_downloads" + i).val(downloadper);
        }
        
        
        
        active_downloadper = parseFloat((present_active_downloads-active_downloads)/present_active_downloads*100);
        if(isNaN(active_downloadper))
        {
            active_downloadper=0;
        }
        if(present_active_downloads==0)
        {
            $("#percent_active_downloads" + i).val('0');
        }
        else
        {
        
           $("#percent_active_downloads" + i).val(active_downloadper);
        }
    }
    else
    {
        
    }
    
    
}
</script>
{/literal}




 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>App Installations Entry</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
			<form  method="post" action="entry_app_downloads.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
				<table class="table table-bordered">
				    <tr style="background-color:#CCC; ">
				        <th>SNo</th>
				        <th>ULB Name</th>
				        <th>Previous Android installations</th>
				        <th>Previous Current active installations</th>
				        <th>Present Total Number of Android installations</th>
				        <th>Present Current active installations</th>
				        <th>% of Android installations</th>
				        <th>% of Current active installations</th>
				    </tr>
				    {assign var="i" value=0}
				{foreach from=$ulb_list item=row key=ulbid}
				<tr>
				        <td>{counter}</td>
				        <td>{$ulb_list[$ulbid]}</td>
				        <td>
				            <input type="hidden" name="{'ulbid'|cat:$i}" id="{'ulbid'|cat:$i}" value="{$ulbid}">
				            <input type="text" name="{'ulb_downloads'|cat:$i}" data-required="1" class="form-control num" id="{'ulb_downloads'|cat:$i}" placeholder="Number of App Installations" value="{$data[$ulbid].no_of_downloads}" onblur="checknumbers('{$i}',1)"/>
				        </td>
				        <td>
				            <input type="text" name="{'active_downloads'|cat:$i}" data-required="1" class="form-control num" id="{'active_downloads'|cat:$i}" placeholder="Number of Active Installations" value="{$data[$ulbid].no_of_active_installations}" onblur="checknumbers('{$i}',1)"/>
				        </td>
				        <td>
				            <input type="text" name="{'present_ulb_downloads'|cat:$i}" data-required="1" class="form-control num" id="{'present_ulb_downloads'|cat:$i}" placeholder="Number of App Installations" value="{$data[$ulbid].present_no_of_downloads}" onblur="checknumbers('{$i}',2)"/>
				        </td>
				        <td>
				            <input type="text" name="{'present_active_downloads'|cat:$i}" data-required="1" class="form-control num" id="{'present_active_downloads'|cat:$i}" placeholder="Number of Active Installations" value="{$data[$ulbid].present_no_of_active_installations}" onblur="checknumbers('{$i}',2)"/>
				        </td>
				        <td>
				            <input type="text" name="{'percent_ulb_downloads'|cat:$i}" data-required="1" class="form-control num" id="{'percent_ulb_downloads'|cat:$i}" placeholder="Number of App Installations" value="{$data[$ulbid].percent_no_of_downloads}" readonly/>
				        </td>
				        <td>
				            <input type="text" name="{'percent_active_downloads'|cat:$i}" data-required="1" class="form-control num" id="{'percent_active_downloads'|cat:$i}" placeholder="Number of Active Installations" value="{$data[$ulbid].percent_no_of_active_installations}" readonly/>
				        </td>
				    </tr>
				
				{assign var="i" value=$i+1}
				{/foreach}
				</table>
				
				
					
				<input type="hidden" name="cnt" value="{$i}">
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

