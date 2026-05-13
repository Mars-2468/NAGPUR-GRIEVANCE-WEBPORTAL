{include file='header.tpl'}
{literal}
<script>



function validateForm()
{
var errors=0;
$(".dropdown").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='0')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});
	
	$(".mytext").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});
	
	if(errors==0)
	{
	return true;
	}
	else
	{
	alert('Please Provide validate data in heilighted fields');
	return false;
	}
}


</script>
{/literal}

 <div class="row ">
	<div class="col-lg-12">
	    <div style="width:100%; text-align:center; font-weight:bold; color:green;">{if isset($msg)}{$msg}{/if}</div>
	<form action="map_std_service_documents.php" method="post">
	
	<input type="hidden" name="token" value="{$token_id}"/>

 {foreach from=$service_list item=row key=cat_id}
 
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>{counter} ) {$service_list[$cat_id]}</h4>
                  </div>
                  <div class="inner no-radius">
                  {foreach from=$doc_list item=row2 key=doc_id}
                  
                  	<div><input type="checkbox" name="check_list[]" {$selected_list[$cat_id][$doc_id].string} value="{$cat_id}_{$doc_id}"> {$doc_list[$doc_id]}
                  	
                    </div>
                  {/foreach}
                 
                </div>
 
 {/foreach}  


<div class="col-md-2 col-md-offset-5"> <input type="submit" value="Save" name="save" class="btn btn-success"> </div>
 </form>            
	</div>
</div>

{include file='footer.tpl'}
{literal}
<script>
$(document).ready(function() {

$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });

$("#checkall").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});


$("#checkval").click(function(){
   $('#checkall').attr('checked', false); 
});

             

}); 
</script>
{/literal}