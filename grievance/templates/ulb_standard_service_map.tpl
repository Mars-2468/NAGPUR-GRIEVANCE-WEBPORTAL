{include file='header.tpl'}

{literal}
<script>

</script>
{/literal}
<div class="row">
	<div>
		<div class="boxed">
			<div class="title-bar blue">
	                  <h4> State Service Mapping</h4>
	                  
	       </div>
	                <div class="inner no-radius">
	                {if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				<form action="state_service_map.php" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
				    
				    <input type="hidden" name="token" value="{$token_id}"/>
				    
				    <table class="table table-bordered">
				    {assign var="i" value=1}    
				   {foreach from=$standard_list item=row key=cs_id}
				   <tr style="background-color:#9fe8fa;">
				       <th>{$i} ) {$standard_list[$cs_id]}</th>
				   </tr>
    				   {foreach from=$standard_list_mapped item=row2 key=ulb_cs_id}
    				   <tr>
    				       <td><input type="checkbox" name="check_list[]" value="{$cs_id}-{$ulb_cs_id}" {$checked_values[$ulb_cs_id][$cs_id]}> {$standard_list_mapped[$ulb_cs_id]}</td>
    				   </tr>
    				   
    				   {/foreach}
				   {assign var="i" value=$i+1}
				   {/foreach}
				   <tr>
				       <td>
				           <center>
				           <input type="submit" name="save" value="save" class="btn btn-success">
				           </center>
				           </td>
				   </tr>
				   </table>
				   
				   </form>
				    
					
			
			</div>
	
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