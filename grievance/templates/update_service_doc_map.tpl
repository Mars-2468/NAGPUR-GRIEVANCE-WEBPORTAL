{include file='header.tpl'}
{literal}
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/additional-methods.min.js"></script>
<script language='javascript'>



 // Load the Google Transliteration API

 google.load("elements", "1", {

       packages: "transliteration"

     });



 function onLoad() {

   var options = {

     sourceLanguage: 'en',

     destinationLanguage: ['te'],

     shortcutKey: 'ctrl+m',

     transliterationEnabled: true

   };



   // Create an instance on TransliterationControl with the required

   // options.

   var control =

       new google.elements.transliteration.TransliterationControl(options);



   // Enable transliteration in the textfields with the given ids.

   var ids = [ "description" ];

   control.makeTransliteratable(ids);



   // Show the transliteration control which can be used to toggle between

   // English and Hindi and also choose other destination language.

   control.showControl('translControl');

 }

 google.setOnLoadCallback(onLoad);



</script>
<script>

function getcats(dept_id)
{
	$.post('ajax_getcats.php',{dept_id:dept_id},function(data)
	{
	$("#cat_id").html(data);
	});
}
function get_csdesc(dept_id)
{
$.post('getcate3.php',{dept_id:dept_id,app_type_id:2},function(data)
	{
		
		$('#cs_id').html(data);
	});
}
function getform(id)
{
	if(id=='1')
	{
	$("#form_div").show();
	$("#service_div").hide();
	$("#app_fee").val('');
	}
	else
	{
	$("#form_div").show();
	$("#service_div").show();
	}
}
function get_cs_det(cs_id)
{
	
	$.post('ajax_get_cs_det.php',{cs_id:cs_id},function(data)
	{
		
		var arr=data.split("::");
		$("#timeframe").val(arr[0]);
		$("#app_fee").val(arr[1]);
		$("#fine").val(arr[2]);
		$("#comp_desc").val(arr[3]);
		$("#telugu_description").val(arr[4]);
		
		var ids=arr[5].split("-");
		
		idslength=ids.length;
		
		for(i=0;i<idslength;i++)
		{
		 $('#checkval' + ids[i]).attr('checked', true); 
		}
		
	});
}

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

function fun1(fee_type_id)
{

	if(fee_type_id==1)
	{
	
		$("#app_fee_div").css('display','block');
		$("#fee_desc_div").css('display','none');
		$("#app_fee").addClass('mytext');
		$("#fee_desc").removeClass('mytext');
		
	}
	else
	{
		$("#app_fee_div").css('display','none');
		$("#fee_desc_div").css('display','block');
		$("#app_fee").removeClass('mytext');
		$("#fee_desc").addClass('mytext');
	}
}

</script>
{/literal}
<div class="row ">
<div class="col-lg-12">
	<div class="boxed">
	                <!-- Title Bart Start -->
		<div class="title-bar success">
			<h4>Update Service Documents</h4>
			<a class="btn btn-info"  href="http://municipalservices.in/update_services.php">Back</a>
			                  
		</div>
		                
			<div class="inner no-radius">
				<form action="update_service_doc_map.php" class="form-horizontal" method="post" onsubmit="return validateForm()">
				<input type="hidden" name="comp_type" value="2">
				<input type="hidden" name="dept_id" value="{$data.dept_id}">
				<input type="hidden" name="cs_id" value="{$data.cs_id}">
					<div class="form-body">
					{if $error_status eq '0'}
						<divclass="alert alert-success display-hide" >
						<button class="close" data-close="alert"></button>
						Data Updated successfully
						</div>
					{/if}	
					{if $error_status gt '0'}
						<div class="alert alert-danger display-hide"style="display:none">
							<button class="close" data-close="alert"></button>
							Unable to update Try .again
						</div>
					{/if}
						
						<div id="form_div" style="display:block"><!-------------------- form div ---------------->
						<!--<div class="form-group">
							<label class="control-label col-md-3">Department <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="dept_id" id="dept_id" onchange="get_csdesc(this.value)">
								<option value="0">---select---</option>
									{html_options options=$dept_list selected=$data.dept_id}
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Service <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="cs_id" id="cs_id" onchange="get_cs_det(this.value)">
								<option value="0">---select---</option>
								{html_options options=$cs_list selected=$data.cs_id}
								</select>
							</div>
						</div>-->
									
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Time Frame<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<input type="text" name='timeframe' id='timeframe' data-required="1" class="form-control mytext num" value="{$data.cutt_of_time}"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Fine Per Day<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<input type="text" name='fine' id='fine' data-required="1" class="form-control mytext num" value="{$data.fine_per_day}"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3"> Application Fee <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="fee_type_id" id="fee_type_id" onchange="fun1(this.value)">
								<option value="">--- Select---</option>
								{html_options options=$fee_type_list selected=$data.fee_type_id}
								</select>
							</div>
						</div>
						
						
						<div id='service_div'><!----------------- service div start here ------------->
							<div class="form-group" {if $data.fee_type_id eq '1'}{else}style="display:none;"{/if} id="app_fee_div">
								<label class="control-label col-md-3"> Fee <span class="required">
								* </span>
								</label>
								<div class="col-md-8">
									<input type="text" name='app_fee' id='app_fee' data-required="1" class="form-control  num" value="{$data.app_fee}"/>
								</div>
							</div>
						
							<div class="form-group" {if $data.fee_type_id eq '2'}{else}style="display:none;"{/if} id="fee_desc_div">
								<label class="control-label col-md-3"> Fee Description <span class="required" >
								* </span>
								</label>
								<div class="col-md-8">
									<input type="text" name='fee_desc' id='fee_desc' data-required="1" class="form-control" value="{$data.fee_desc}"/>
								</div>
							</div>
						</div><!----------------- service div closed here -------------->
						
						<div class="form-group">
							<label class="control-label col-md-3"> Service Name <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<input type="text" name='comp_desc' id='comp_desc' data-required="1" class="form-control " value="{$cs_list[$data.cs_id]}"/>
							</div>
						</div>
						<div class="form-group" id='translControl'>
							<label class="control-label col-md-3"> Service Name IN Telugu <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<input type="text" name='telugu_description' id='description' data-required="1" class="form-control" value="{$data.telugu_description}"/>
							</div>
						</div>
						
							<div class="form-group">
							<label class="control-label col-md-3"> Service request to be placed through  <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="sp_id" id="sp_id" onchange="fun1(this.value)">
								<option value="">--- Select---</option>
								{html_options options=$sp_list selected=$data.sp_id}
								</select>
							</div>
						</div>
						
						
						
						
						<div class="title-bar success">
							<h4>Select Required Documents</h4>
						</div>
						<div class="form-group">
						
						<table class="table table-striped table-bordered table-hover table-full-width" id="add_advance">
							<thead>
								<tr> <th> Sno  </th>
							         <th> Document Description</th>
							         <th>check all <br><input type="checkbox" name="checkall" value="checkall" id="checkall"></th>
							         <th> Mandatory Status </th>
							       </tr>
							</thead>
							
							<tbody>
							{foreach from=$doc_list key=doc_id item=row}
								<tr>
								 <td> {counter} </td>
								    <td>{$row.doc_desc}</td>
								   <td> <input type="checkbox" name="check_doc_name[]" value="{$row.doc_id}" id="{'checkval'|cat:$doc_id}" {$checked[$doc_id]}></td>
								   <td>
								   <select id="{'id'|cat:$row.doc_id}" name="{'required'|cat:$row.doc_id}">
								   <option value="mytext">-- select ---</option>
								   {html_options options=$mandatory_list selected=$required_status[$doc_id]}
								   </select>
								   
								   </td>
								 </tr>
							{/foreach}
							
							</tbody>
						
						</table>
						
						</div>
						</div><!----------------- service div closed here -------------->
						
						
						<div class="form-actions fluid">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" class="btn btn-info" name="save">Submit</button>
								<!--<button type="button" class="btn btn-danger">Cancel</button>-->
							</div>
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