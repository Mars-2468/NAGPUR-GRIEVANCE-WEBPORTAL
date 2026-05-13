{include file='header.tpl'}

{literal}
<script>

</script>
{/literal}
<div class="row">
	<div>
		<div class="boxed">
			<div class="title-bar success">
	                  <h4> State Service Mapping </h4>
	                  
	       </div>
	                <div class="inner no-radius">
	                {if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				<form action="state_service_map.php" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
				    <input type="hidden" name="ulbid" id="ulbid" value="{$ulbid}">
				    <input type="hidden" name="appid" id="appid" value="{$app_type_id}">
				    
				    <div class="form-group">
				        <label class="control-label col-md-3" for="department">Department</label>
				        <div class="col-md-8">
				            
				            <select class="form-control" name="dept_id" id="dept_id" required='required' onchange="getStandardServices(this.value)">
								<option value="">---select---</option>
								{html_options options=$standard_dept_list}
							</select>
				            
				        </div>
				    </div>
				    
					<div class="form-group">
						<label class="control-label col-md-3">Type of Service <span class="required">
						* </span>
						</label>
						<div class="col-md-8">
							<select class="form-control" name="merg_cs_id" id="merg_cs_id" required='required'>
								<option value="">---select---</option>
							
							</select>
						</div>
					</div>
			
			</div>
	
		</div>
	</div>

</div>

<div class="row">
	<div >
		<div class="boxed">
			
	        </div>
	        
	        
	         <div class="inner no-radius" style="background-color: #FFF; padding: 15px;">
	             
		        
		       
		       {foreach from=$ulb_list item=row key=ulbid}
		       
		       <div class="row" style="border=1px; solod #3c3c3c">
		           <div class="col-md-3">{$ulb_list[$ulbid]} )</div>
		           <div class="col-md-9">
		               {foreach from=$ulb_services_list[$ulbid] item=row2 key=cs_id}
		               <input type="checkbox" name="check_list[]" value="{$cs_id}"> {$ulb_services_list[$ulbid][$cs_id]} <br>
		               {/foreach}
		           </div>
		       </div>
		       <br><br>
		       
		       
		       {/foreach}
		       
		        <input type="submit" name="save" value="SAVE" class="btn btn-success">
		        </form>
	        </div>
	 </div>
</div>

{literal}
<script src='../js/jquery.min.js'></script>
<script>
$(document).ready(function() {

$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });
    
    
    /*var appid=$("#appid").val();
    
    if(appid=='1' || appid=='2')
    {
    $("#app_type_id").val(appid);
    
    $("#app_type_id").trigger('change');
    }*/
    
	});
	
	function getStandardServices(dept_id)
	{
	    $.post('ajax_getstandardservices.php',{dept_id:dept_id},function(data)
	    {
	        
	        $("#merg_cs_id").html(data);
	    });
	}
	</script>
{/literal}

{include file='footer.tpl'}