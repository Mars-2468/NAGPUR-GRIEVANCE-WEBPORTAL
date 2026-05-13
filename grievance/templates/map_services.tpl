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
	<form action="map_services.php" method="post">
	
	{assign var="i" value="0"}
 {foreach from=$cat_list item=row key=cat_id}
 
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>{$cat_list[$cat_id]}</h4>
                  </div>
                  <div class="inner no-radius">
                  {foreach from=$data[$cat_id] item=row2 key=cs_id}
                  
                  	<div><input type="checkbox" name="{'cs_id'|cat:$cs_id}" value="{$cs_id}-{$cat_id}" {if $comp_list["cs_id"|cat:$cs_id] eq '1'}checked=checked{/if}> {$data[$cat_id][$cs_id].cs_desc}
                  	{assign var="i" value=$i+1}
                    </div>
                  {/foreach}
                 
                </div>
 
 {/foreach}  
 <input type="hidden" name="cnt" value="{$i}"><br>

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