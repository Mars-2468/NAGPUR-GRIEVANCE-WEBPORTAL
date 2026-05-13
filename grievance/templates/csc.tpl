
{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script> <!--DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
  
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">

<script type="text/javascript">
$(document).ready(function(){
   $("#tap").change(function(){
       $(this).find("option:selected").each(function(){
           if($(this).attr("value")=="1"){
               $(".test").not(".pic").hide();
               $(".pic").show();
           }
           else if($(this).attr("value")=="Cash"){
               $(".test").not(".green13").hide();
               $(".green13").show();
           }
          
           else{
               $(".test").hide();
           }
       });
   }).change();
});
</script>


<script type="text/javascript">
$(document).ready(function(){
   $("#seating").change(function(){
       $(this).find("option:selected").each(function(){
           if($(this).attr("value")=="1"){
               $(".box1").not(".red").hide();
               $(".red").show();
           }
           else if($(this).attr("value")=="Cash"){
               $(".box1").not(".green14").hide();
               $(".green14").show();
           }
          
           else{
               $(".box1").hide();
           }
       });
   }).change();
});
</script>

    
    
  <script type="text/javascript">
$(document).ready(function(){
   $("#center").change(function(){
       $(this).find("option:selected").each(function(){
           if($(this).attr("value")=="1"){
               $(".true").not(".white").hide();
               $(".white").show();
           }
           else if($(this).attr("value")=="3"){
               $(".true").not(".green1").hide();
               $(".green1").show();
           }
          
           else{
               $(".true").hide();
           }
       });
   }).change();
});
</script>  
    
    
    
    
    
    
    
    
 <script language='javascript'>
function validateForm1()
{
	var errors=0;
	$(".int1").each(function(){
	
		var patt=/^\d+$/;
		var val_field=$(this).val();
		if(!val_field.match(patt))
		{
		($(this)).css({"background-color": "pink"});
		errors++;
		}
		else
		{
		($(this)).css({"background-color": "white"});
		}
	});

	$(".int2").each(function(){
	
		var patt=/^\d+$/;
		var val_field=$(this).val();
		if(!val_field.match(patt))
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			if (val_field.length != 6) 
			{
    				alert("Please enter correct pincode");
    				($(this)).css({"background-color": "pink"});
				errors++;
  			}
  			else
  			{
				($(this)).css({"background-color": "white"});
			}
		}
	});

	$(".mytext").each(function(){
	
		var val_field=$(this).val();
		val_field = val_field.trim();
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
	
		$(".int").each(function(){
	
		var patt=/^\d+$/;
		var val_field=$(this).val();
		
		if(!val_field.match(patt))
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});
	
	$(".float").each(function(){
		
		var patt=/^\d+(\.\d+)?$/;
		var val_field=$(this).val();
		
		if(!val_field.match(patt))
		{
		($(this)).css({"background-color": "pink"});
		errors++;
		}
		else
		{
		($(this)).css({"background-color": "white"});
		}
	});
	
	$(".combo").each(function(){
	
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
	$(".datetime").each(function()
          {
            if( ($(this).val()=='') || ($(this).val()=='0000-00-00'))
            {
             $($(this)).css({"background-color": "pink"});
             errors++;
            }else
       $($(this)).css({"background-color": "white"});
           });
           
     $(".datetime1").each(function()
          {
            if( ($(this).val()=='') )
            {
             $($(this)).css({"background-color": "pink"});
             errors++;
            }else
       $($(this)).css({"background-color": "white"});
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
      

</script>


<script>

function isFloat(evt) {

var charCode = (event.which) ? event.which : event.keyCode;
if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
  //alert('Please enter only no or float value');
  return false;
}
else {
  //if dot sign entered more than once then don't allow to enter dot sign again. 46 is the code for dot sign
  var parts = evt.srcElement.value.split('.');
  if (parts.length > 1 && charCode == 46)
    {
      return false;
    }


  return true;

}
}
</script>
    	

<script>
       $(document).ready(function(){
       $(".num").keypress(function (test){
    if (test.which != 8 && test.which != 0 && (test.which < 48 || test.which > 57)) {
    return false;
        }
      }); 
   });	
           
</script>




<script>
function validateForm()
{
	var errors=0;
	var password=$("#password").val();
	var password_again=$("#password_again").val();
	var pattern =/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!@#_$, ]{8,}$/;
	
		   if(password=="")
			 {
			 
			 alert('Enter Password');
			 errors++;
			 }
		
			 
			 if(password_again!=password)
			 {
			
				
				errors++;
				
				alert('Enter same password');
				
				
			
			
			
			 }
			 if(errors==0)
			 {
			 }
			 else
			 {
			 return false;
			 }
}
</script>



<script>
    
    function valid()
    {
        var id = $(".est").val();
        
 
        if(id == '1')
        {
           $(".datetime1").removeClass("datetime1"); 
        }
        
        if(id == '2')
        {
        
          $(".datetime").removeClass("datetime");
          $(".int1").removeClass("int1");
          $(".mytext").removeClass("mytext");
          $(".combo").removeClass("combo");
          $(".datetime1").removeClass("datetime1");
        }
        
        if(id == '3')
        {
          $(".datetime").removeClass("datetime");
          $(".int1").removeClass("int1");
          $(".mytext").removeClass("mytext");
          $(".combo").removeClass("combo"); 
          $(".datetime1").addClass("datetime1");
        }
    }
    
</script>




{/literal}




 <div class="row ">
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Update CSC Details</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               
<form method="post" action="csc.php" name="csc" enctype="multipart/form-data" class="form-horizontal" onSubmit="return validateForm1()">
    <input type="hidden" name="token" value="{$token_id}"/>
			<input type='hidden' name='uid' value='{$uid}'>
				<div class="form-body">
				    
				    
				    <div class="form-group" style="clear:both;">
  				    <label class="col-md-3 control-label" for="textinput">CSC Centre established</label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <select type="text"  id="center" name="established" class="form-control combo est" onchange="valid()">
                    <option value="0">-- Select --</option>
                    {html_options options=$est_list selected={$data.established} }
                    </select>
            	   </div>
                   </div>
                   
                   
                   <div class="white true">
				    
				     <div class="form-group white true" style="clear:both; display:none;">
					 <label class="control-label col-md-3">Date of CSC Started  <span class="required">* </span></label>
					 <div class="col-md-5">
					 <input name='date'  type="text" placeholder="Select Date"  id="datepicker" data-required="1" readonly="readonly" class="form-control datetime datepicker" value="{$data.date}"/>
					 </div>
					 </div>
				    
				    
				     <div class="form-group white true" style="clear:both; display:none;">
					 <label class="control-label col-md-3">Area of CSC (Sft)<span class="required">* </span></label>
					 <div class="col-md-5">
		<input name='area_csc'  type="text" placeholder="Enter Area" data-required="1" class="form-control" value="{$data.area_csc}" onkeypress="return isFloat(event)" required="required">
					 </div>
				     </div>
				     
				     
				     </div>
				     
				    
				     <div class="form-group white true" style="clear:both; display:none;">
					 <label class="control-label col-md-3">Number of Systems Provided  <span class="required">* </span></label>
					 <div class="col-md-5">
					 <input name='systems_provided' placeholder="Enter Number of Systems Provided"   type="text" data-required="1" class="form-control int1" value="{$data.systems_provided}" required="required">
					 </div>
				     </div>
				     
				     
				     <div class="form-group white true" style="clear:both; display:none;">
					 <label class="control-label col-md-3">Number of Printers Provided  <span class="required">* </span></label>
					 <div class="col-md-5">
					 <input name='printers_provided'  type="text" placeholder="Enter Number of Printers Provided"  data-required="1" class="form-control int1" value="{$data.printers_provided}" required="required">
					 </div>
				     </div>
				     
				     
				     <div class="form-group white true" style="clear:both; display:none;">
					 <label class="control-label col-md-3">Number of Scanners Provided  <span class="required">* </span></label>
					 <div class="col-md-5">
					 <input name='scanners_provided'  type="text" placeholder="Enter Number of Scanners Provided" data-required="1" class="form-control int1" value="{$data.scanners_provided}" required="required">
					 </div>
				     </div>
				     
				     
				     
				    
				    <div class="form-group white true" style="clear:both; display:none;">
					 <label class="control-label col-md-3">Number of Staff Deployed <span class="required">* </span></label>
					 <div class="col-md-5">
					 <input name='staff_deployed'  type="text" placeholder="Enter Number of Staff Deployed" data-required="1" class="form-control int1" value="{$data.staff_deployed}" required="required"/>
					 </div>
				     </div>
				     
				     
<div class="form-group input_more_fields_wrap white true" style="clear:both; display:none; margin-bottom: 0px; border:1px #333 solid; padding: 10px 0px 0px 10px;  margin-bottom: 10px; background-color:#dfdfdf;" >
          <div class="form-group" style="clear:both; ">
              <label class="col-md-3 control-label" for="selectbasic" style="text-align:right;">Nodal officer Name</label>
              <div class="col-md-5" style="margin-bottom:15px;">
                <input id="Name" name="nodal_officer_name" placeholder="Enter Nodal officer Name" class="form-control input-md ccc mytext" type="text" value="{$data.nodal_officer_name}">
              </div>
              </div>
            
            
            <div class="form-group white true" style="clear:both; display:none;">
              <label class="col-md-3 control-label" for="selectbasic" style="text-align:right;">Nodal officer mobile number</label>
              <div class="col-md-5" style="margin-bottom:15px;">
<input id="Tel" name="nodal_officer_number" placeholder="Enter Nodal officer mobile number" class="form-control input-md mobile1 mob ccc int1" type="text" 
maxlength="10" onchange="validatemobile()" value="{$data.nodal_officer_number}">
              </div>
            </div>
            
            
            
            <div class="form-group white true" style="clear:both; display:none;">
              <label class="col-md-3 control-label" for="selectbasic" style="text-align:right;">Nodal officer Designation</label>
              <div class="col-md-5" style="margin-bottom:15px;">
                <input id="Tel" name="nodal_officer_desg" placeholder="Enter Nodal officer Designation" class="form-control input-md mobile1 mob ccc mytext" type="text" onchange="validatemobile()" value="{$data.nodal_officer_desg}">
              </div>
            </div>
          
          </div>
				     
				    
					                    <div class="form-group white true" style="clear:both; display:none;">
                                        <label class="control-label col-md-3">Front View Photo</label>
                                        <div class="col-md-5">
                                            
                                        <input type="file" class="" id="f1" name="img_url" ><br>{if $data.front_view neq ''}<img src="{$data.front_view}" width="100" height = "100" >{/if}</div>
                                        </div>  
                                        
                                        
                                        <div class="form-group white true" style="clear:both; display:none;">
                                        <label class="control-label col-md-3">Side View Photo</label>
                                        <div class="col-md-5">
                                        <input type="file" class=""  name="side_view" ><br>{if $data.side_view neq ''}<img src="{$data.side_view}" width="100" height = "100" >{/if}</div>
                                        </div>  
                                        
                                        
                                        <div class="form-group white true" style="clear:both; display:none;">
                                        <label class="control-label col-md-3">Long View Photo</label>
                                        <div class="col-md-5">
                                        <input type="file" class=""  name="long_view" ><br>{if $data.long_view neq ''}<img src="{$data.long_view}" width="100" height = "100" >{/if}</div>
                                        </div>  
					
					
					
					<div class="form-group white true" style="clear:both; display:none; ">
  				    <label class="col-md-3 control-label" for="textinput">Water Facility Provided </label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <select type="text"  id="tap" name="water_facility" class="form-control combo">
                    <option value="0">-- Select --</option>
                    {if $data.water_facility eq 1}
                    <option value="1" selected>Yes</option>
                    <option value="2">No</option>
                    {/if}
                    
                    {if $data.water_facility eq 2}
                    <option value="1">Yes</option>
                    <option value="2" Selected>No</option>
                    {else if $data.water_facility eq ''}
                    <option value="1">Yes</option>
                    <option value="2" >No</option>
                     {/if}
                    </select>
            	   </div>
                   </div>
                   
                   
                   
                    <div class="form-group pic test" style="clear:both;display:none;">
                    <label class="control-label col-md-3">Upload Photo</label>
                    <div class="col-md-5" style="margin-bottom: 10px;">
                    <input type="file" class="pic test"  name="water_pic"><br>{if $data.pic neq ''}<img src="{$data.pic}" width="100" height = "100" >{/if}
                    </div>
                    </div>
                    
                    
                    
                    <div class="form-group white true" style="clear:both;display:none;">
  				    <label class="col-md-3 control-label" for="textinput">Seating Arrangement for Waiting Provided </label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <select type="text"  id="seating" name="seating_arrangement" class="form-control combo">
                    <option value="0">-- Select --</option>
                    {if $data.seating_arrangement eq 1}
                    <option value="1" selected>Yes</option>
                    <option value="2">No</option>
                    {/if}
                    
                    {if $data.seating_arrangement eq 2}
                    <option value="1">Yes</option>
                    <option value="2" Selected>No</option>
                    {else if $data.seating_arrangement eq ''}
                    <option value="1">Yes</option>
                    <option value="2" >No</option>
                     {/if}
                    </select>
            	   </div>
                   </div>
                   
                   
                   
                    <div class="form-group red box1" style="clear:both;display:none">
                    <label class="control-label col-md-3 red box1 white true">Upload Photo</label>
                    <div class="col-md-5">
                    <input type="file" class="red box1" id="f1" name="pic2" value=""><br>{if $data.pic2 neq ''}<img src="{$data.pic2}" width="100" height = "100" >{/if}</div>
                    </div>
                    </div>
                   
                   <!--<div class="form-group white true" style="clear:both; display:none;">
                   <label class="col-md-3 control-label" for="selectbasic" style="text-align:right;">Other Amenities</label>
                   <div class="col-md-5" style="margin-bottom:15px;">
                   <input id="Name" name="other" placeholder="Enter Other Amenities" class="form-control input-md ccc" type="text" value="{$data.other}">
                   </div>
                   </div>--->
                   
                   
                   
                   <div class="form-group white true" style="clear:both; display:none; ">
  				    <label class="col-md-3 control-label" for="textinput">News Papers Stand Facility Provided </label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <select type="text"  id="" name="news_facility" class="form-control combo">
                    <option value="">-- Select --</option>
                    {if $data.news_facility eq 1}
                    <option value="1" selected>Yes</option>
                    <option value="2">No</option>
                    {/if}
                    
                    {if $data.news_facility eq 2}
                    <option value="1">Yes</option>
                    <option value="2" Selected>No</option>
                    {else if $data.news_facility eq ''}
                    <option value="1">Yes</option>
                    <option value="2" >No</option>
                     {/if}
                    </select>
            	   </div>
                   </div>
                   
                   
                   <div class="form-group white true" style="clear:both; display:none; ">
  				    <label class="col-md-3 control-label" for="textinput">Air conditioned waiting room provided </label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <select type="text"  id="" name="waiting_room" class="form-control combo">
                    <option value="">-- Select --</option>
                    {if $data.waiting_room eq 1}
                    <option value="1" selected>Yes</option>
                    <option value="2">No</option>
                    {/if}
                    
                    {if $data.waiting_room eq 2}
                    <option value="1">Yes</option>
                    <option value="2" Selected>No</option>
                    {else if $data.waiting_room eq ''}
                    <option value="1">Yes</option>
                    <option value="2" >No</option>
                     {/if}
                    </select>
            	   </div>
                   </div>
                   
                   <div class="form-group white true" style="clear:both; display:none; ">
  				    <label class="col-md-3 control-label" for="textinput">Printed Application forms placed</label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <select type="text"  id="" name="printed_app" class="form-control combo">
                    <option value="">-- Select --</option>
                     {if $data.printed_app eq 1}
                    <option value="1" selected>Yes</option>
                    <option value="2">No</option>
                    {/if}
                    
                    {if $data.printed_app eq 2}
                    <option value="1">Yes</option>
                    <option value="2" Selected>No</option>
                    {else if $data.printed_app eq ''}
                    <option value="1">Yes</option>
                    <option value="2" >No</option>
                     {/if}
                    </select>
            	   </div>
                   </div>
                   
                   
                   <div class="form-group white true" style="clear:both; display:none; ">
  				    <label class="col-md-3 control-label" for="textinput">Citizen charter Services Board placed</label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <select type="text"  id="" name="board_placed" class="form-control combo">
                    <option value="">-- Select --</option>
                     {if $data.board_placed eq 1}
                    <option value="1" selected>Yes</option>
                    <option value="2">No</option>
                    {/if}
                    
                    {if $data.board_placed eq 2}
                    <option value="1">Yes</option>
                    <option value="2" Selected>No</option>
                    {else if $data.board_placed eq ''}
                    <option value="1">Yes</option>
                    <option value="2" >No</option>
                     {/if}
                    </select>
            	   </div>
                   </div>
                   
                   
                   <div class="form-group white true" style="clear:both; display:none; ">
  				    <label class="col-md-3 control-label" for="textinput">Toilet Facility Provided</label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <select type="text"  id="" name="toilet_facility" class="form-control combo">
                    <option value="">-- Select --</option>
                     {if $data.toilet_facility eq 1}
                    <option value="1" selected>Yes</option>
                    <option value="2">No</option>
                    {/if}
                    
                    {if $data.toilet_facility eq 2}
                    <option value="1">Yes</option>
                    <option value="2" Selected>No</option>
                    {else if $data.toilet_facility eq ''}
                    <option value="1">Yes</option>
                    <option value="2" >No</option>
                     {/if}
                    </select>
            	   </div>
                   </div>
                   
                   
                   <div class="form-group white true" style="clear:both; display:none; ">
                   <label class="col-md-3 control-label" for="selectbasic" style="text-align:right;">Other facilities and services provided, Please Mention</label>
                   <div class="col-md-5" style="margin-bottom:15px;">
                   <input id="Name" name="other_facilities"  class="form-control input-md ccc" type="text" value="{$data.other_facilities}">
                   </div>
                   </div>
                 
                     
                   
                    <!--<div class="form-group green1 true" style="clear:both; display:none; ">
  				    <label class="col-md-3 control-label" for="textinput">Construction/Setup in progress </label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <select type="text"  name="progress" class="form-control combo">
                    <option value="">-- Select --</option>
                    {if $data.progress eq 'Yes'}
                    <option value="Yes" selected>Yes</option>
                    <option value="No">No</option>
                    {/if}
                    
                    {if $data.progress eq 'No'}
                    <option value="Yes">Yes</option>
                    <option value="No" Selected>No</option>
                    {else if $data.progress eq ''}
                    <option value="Yes">Yes</option>
                    <option value="No" >No</option>
                     {/if}
                    </select>
            	   </div>
                   </div>-->
                   
                   
                    <div class="form-group green1 true" style="clear:both; display:none; ">
  				    <label class="col-md-3 control-label" for="textinput">Expected Starting Date</label>  
  		            <div class="col-md-5" style="margin-bottom: 10px;">
                    <input  name="completion_date"  class="form-control datepicker datetime1" type="text" value="{$data.completion_date}">
            	   </div>
                   </div>
					 
					<br>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<input type='hidden'  onclick="print_div()" class="btn btn-danger">
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>







<!---
{if isset($data)}
<div class="row" id="div_print">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					
				</div>
			</div>
		</div>


{/if}
<!------------------->




<br>
{include file='footer.tpl'}


{literal}
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
<script>
$(function() {
    $( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>
{/literal}

