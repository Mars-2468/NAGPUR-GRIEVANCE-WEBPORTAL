{include file='header.tpl'}

{literal}
<script>

</script>
{/literal}
<div class="row">
	<div>
		<div class="boxed">
			<div class="title-bar success">
	                  <h4> Services Disable </h4>
	                  
	                </div>
	                <div class="inner no-radius">
	                {if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				<form action="services_disable.php" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
				    <input type="hidden" name="ulbid" id="ulbid" value="{$ulbid}">
				    <input type="hidden" name="appid" id="appid" value="{$app_type_id}">
					
			
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
		           <div class="col-md-3"><strong>{$ulb_list[$ulbid]} :</strong></div>
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
	</script>
{/literal}

{include file='footer.tpl'}