{include file='header.tpl'}

{literal}
<script>
function getform(id)
{
	if(id==1)
	{
	$.post('get_complntform.php',{id:id},function(data)
	{
		$('#form').html(data);
	});
	}
	else
	{
	$.post('get_serviceform.php',{id:id},function(data)
	{
		$('#form').html(data);
	});
	
	//$('#form').html('Under construction');
	}
}
function get_streets(ward_id)
{
$.post('ajax_getstreets.php',{ward_id:ward_id},function(data)
	{
		$('#street_id').html(data);
	});
}
function get_cats(dept_id)
{
$.post('ajax_getcats.php',{dept_id:dept_id},function(data)
	{
		$('#cat_id').html(data);
	});
}
function get_csdesc(dept_id)
{
   
 var app_type_id=$("#app_type_id").val();
 var ulbid=$("#ulbid").val();
 
 /*if(ulbid==207 && dept_id==5 && app_type_id=='1')
 {
     alert('Call Toll Free No 180030022582 for Streetlight Complaints');
     $('#cs_id').html("<option value='0'>---select---</option>");
 }
 else
 /*{*/
 
$.post('getcate3.php',{dept_id:dept_id,app_type_id:app_type_id},function(data)
	{
		
		$('#cs_id').html(data);
	
		
		if(app_type_id=='1' && ulbid=='052' && dept_id=='3')
		{
		    $("#tanker_dropdown").css('display','block');
		    $("#tanker_id").addClass('dropdown');
		}
		else
		{
		    $("#tanker_dropdown").css('display','none');
		    $("#tanker_id").removeClass('dropdown');
		}
		
		
	});
 /*}*/
}
function get_req_docs(cs_id)
{
	var app_type_id=$("#app_type_id").val();
	var ward_id=$("#ward_id").val();
	var dept_id=$("#dept_id").val();
	
	$.post('getdocs.php',{cs_id:cs_id,app_type_id:app_type_id,ward_id:ward_id,dept_id:dept_id},function(data)
	{
		
	
		$('#docs').html(data);
	});
}
function validateForm()
{
errors=0;
var mobile=$("#mobile").val();
	var patt1= /^\d{10}$/;
	if(!patt1.test(mobile))
    	{
		($('#mobile')).css({"background-color": "pink"});
		errors++;    	
	}
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
		
    	
	if(errors==0)
	{
		return true;
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
}
function fun1(cs_id)
{
var app_type_id=$("#app_type_id").val();
var ward_id=$("#ward_id").val();
$.post('getempcutdet.php',{cs_id:cs_id,app_type_id:app_type_id,ward_id:ward_id},function(data)
{
$("#cut_det").html(data);
});


}
</script>
{/literal}
<div class="row">
	<div>
		<div class="boxed">
			<div class="title-bar success">
	                  <h4> Register Complaint / Service </h4>
	                  
	                </div>
	                <div class="inner no-radius">
	                {if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				<form action="#"  class="form-horizontal">
				    <input type="hidden" name="ulbid" id="ulbid" value="{$ulbid}">
				    <input type="hidden" name="appid" id="appid" value="{$app_type_id}">
					<div class="form-group">
						<label class="control-label col-md-3">Type of Application <span class="required">
						* </span>
						</label>
						<div class="col-md-8">
							<select class="form-control" name="app_type_id" id="app_type_id" onchange="getform(this.value)">
								<option value="">---select---</option>
								{html_options options=$app_type_list}
								
							</select>
						</div>
					</div>
				</form>
			</div>
	
		</div>
	</div>

</div>
{if isset($filepath)}
<!--<a href="{$filepath}" target="_blank">Download Receipt </a>-->
{/if}
<div class="row">
	<div >
		<div class="boxed">
			
	        </div>
	        
	        
	         <div class="inner no-radius" style="background-color: #FFF; padding: 15px;">
		        <form action="testing_insert_swtapp.php" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
		        <span id="form"></span>
		        
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