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
<div >
	<div class="boxed">
	                <!-- Title Bart Start -->
		<div class="title-bar success">
			<h4>Add Service</h4>
			                  
		</div>
		                
			<div class="inner no-radius">
				<form action="category3_mst.php" class="form-horizontal" method="post" onsubmit="return validateForm()">
					<div class="form-body">
					{if $error_status eq '0'}
						<divclass="alert alert-success display-hide" >
						<button class="close" data-close="alert"></button>
						Data inserted successfully
						</div>
					{/if}	
					{if $error_status gt '0'}
						<div class="alert alert-danger display-hide"style="display:none">
							<button class="close" data-close="alert"></button>
							Unable to update Try .again
						</div>
					{/if}
						<div class="form-group">
							<label class="control-label col-md-3">Select <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="comp_type" id="comp_type" onchange="getform(this.value)">
								<option value="0">---select---</option>
									{html_options options=$app_type}
								</select>
							</div>
						</div>
						<div id="form_div" style="display:none"><!-------------------- form div ---------------->
						<div class="form-group">
							<label class="control-label col-md-3">Department <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="dept_id" id="dept_id">
								<option value="0">---select---</option>
									{html_options options=$dept_list}
								</select>
							</div>
						</div>
						
						<!--<div class="form-group">
							<label class="control-label col-md-3">Category <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="cat_id" id="cat_id">
								<option value="0">---select---</option>
								</select>
							</div>
						</div>-->
									
						<div class="form-group">
							<label class="control-label col-md-3">Service <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<textarea name='cat3_desc' id='cat3_desc' data-required="1" class="form-control mytext"></textarea>
							</div>
						</div>
						
						<div class="form-group"  id='translControl'>
							<label class="control-label col-md-3">తెలుగు <span class="required">
							 </span>
							</label>
							<div class="col-md-8">
								<textarea name='telugu_description' id='description' data-required="1" class="form-control"></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Time Frame<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<input type="text" name='timeframe' maxlength="2" id='timeframe' data-required="1" class="form-control mytext num"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Fine Per Day<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<input type="text" name='fine' id='fine' data-required="1" class="form-control mytext num"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Financial implication?<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<input type="checkbox" name='fin_impl' id='fin_impl'  value="1"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3"> Application Fee <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="fee_type_id" id="fee_type_id" onchange="fun1(this.value)">
								<option value="">--- Select---</option>
								{html_options options=$fee_type_list}
								</select>
							</div>
						</div>
						
						
						
						<div id='service_div'><!----------------- service div start here ------------->
							<div class="form-group" style="display:none;" id="app_fee_div">
								<label class="control-label col-md-3"> Fee <span class="required">
								* </span>
								</label>
								<div class="col-md-8">
									<input type="text" name='app_fee' id='app_fee' data-required="1" class="form-control  num"/>
								</div>
							</div>
						
							<div class="form-group" style="display:none;" id="fee_desc_div">
								<label class="control-label col-md-3"> Fee Description <span class="required">
								* </span>
								</label>
								<div class="col-md-8">
									<input type="text" name='fee_desc' id='fee_desc' data-required="1" class="form-control"/>
								</div>
							</div>
						</div><!----------------- service div closed here -------------->
						
						<div class="form-group">
							<label class="control-label col-md-3">Service request to be placed through <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<select class="form-control dropdown" name="sp_id" id="sp_id">
								<option value="0">---select---</option>
									{html_options options=$sp_list}
								</select>
							</div>
						</div>
						
						
						
						<div class="title-bar success">
							<h4>Select Required Documents</h4>
						</div>
						<div class="form-group">
						
						<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
							<thead>
								<tr style="background-color:#2c3e50; color:#FFF;"> <th> Sno  </th>
							         <th> Document Description</th>
							         <th>check all <br><input type="checkbox" name="checkall" value="checkall" id="checkall"></th>
							         <th> Required Status </th>
							       </tr>
							</thead>
							
							<tbody>
							{foreach from=$doc_list key=doc_id item=row}
								<tr>
								 <td> {counter} </td>
								    <td>{$row.doc_desc}</td>
								   <td> <input type="checkbox" name="check_doc_name[]" value="{$row.doc_id}" id="checkval"></td>
								   <td>
								   <select id="{'id'|cat:$row.doc_id}" name="{'required'|cat:$row.doc_id}">
								   <option value="mytext">-- select ---</option>
								   {html_options options=$mandatory_list}
								   </select>
								   
								   </td>
								 </tr>
							{/foreach}
							
							</tbody>
						
						</table>
						
						</div>
						
						
						
						<div class="form-actions fluid">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" class="btn btn-info" name="save">Submit</button>
								<button type="button" class="btn btn-danger">Cancel</button>
							</div>
						</div>
						</div><!----------------------- form div ------------------------>
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