{include file='header.tpl'}

{literal}

<script>

function ajax_getvillages2(mandalId)
{
    $.post('ajax_getVillages.php',{mandalId:mandalId},function(data)
    {
        $("#villageid").html(data);
    });
}

function ajax_getvillages(mandalId)
{
    $.post('ajax_getVillages.php',{mandalId:mandalId},function(data)
    {
        $("#villageidg").html(data);
    });
}

function getMandals(distid)
{
    $.post('ajax_getMandal.php',{distid:distid},function(data)
    {
        $("#villageid").html(data);
    });
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function clickcheck(id)
{
    
    showareagrievance(id);
}

 

function showareagrievance(id)
{
    if($("#fromidg2").is(":checked")) 
    {
         $("#fromidareag2").show();
        $("#distidvillageg").attr('required',true);
        $("#mandalidg").attr('required',true);
        $("#villageidg").attr('required',true);
        
        var ulbid = $("#ulbid").val();
        mandalId=0;
        
        $.post('ajax_getVillages.php',{mandalId:mandalId,ulbid:ulbid},function(data)
        {
            $("#villageidg").html(data);
        });
        
        
    }
    else
    {
         $("#fromidareag2").hide();
        $("#distidvillageg").removeAttr('required');
        $("#mandalidg").removeAttr('required');
        $("#villageidg").removeAttr('required');
    }
}
function showarea(id)
{
  
    if(id=='1')
    {
        $("#fromidarea1").show();
        $("#ulbidvillage").prop('required',true);
        $("#fromidarea2").hide();
        $("#distidvillage,#mandalid,#villageid").prop('required',false);
        $("#fromidarea3").hide();
        $('#distidothers,#town,#village').prop('required',false);
    }
    else if(id=='2')
    {
        $("#fromidarea1").hide();
        $("#ulbidvillage").prop('required',false);
        $("#fromidarea2").show();
        $("#distidvillage,#mandalid,#villageid").prop('required',true);
        $("#fromidarea3").hide();
        $('#distidothers,#town,#village').prop('required',false);
    }
    else if(id=='3')
    {
        $("#fromidarea1").hide();
        $("#ulbidvillage").prop('required',false);
        $("#fromidarea2").hide();
        $("#distidvillage,#mandalid,#villageid").prop('required',false);
        $("#fromidarea3").show();
        $('#distidothers,#town,#village').prop('required',true);
    }
    
}
function clearForm()
{
    $("#app_type_id").val('');
    $('#form').html('');
}
function getCompform(cs_id,ulbid)
{
    
    
    if(cs_id == 1 && ulbid == 208)
    {
        //alert(ulbid);Select ULB
        $.post('get_serviceform2.php',{id:2},function(data)
        	{
        	    
        		$('#form2').html(data);
        		get_req_docs(cs_id);
        	}); 
        
    }
    
    
    else if(cs_id == 1 && ulbid == 209)
    {
        
        $.post('get_serviceform2.php',{id:2},function(data)
        	{
        	    
        		$('#form2').html(data);
        		get_req_docs(cs_id);
        	}); 
        
    }
    
    
     else if(cs_id == 1 && ulbid == 210)
    {
        
        $.post('get_serviceform2.php',{id:2},function(data)
        	{
        	    
        		$('#form2').html(data);
        		get_req_docs(cs_id);
        	}); 
        
    }
    
    else if(cs_id == 7 && ulbid == 208)
    {
        
         $.post('get_serviceform2.php',{id:2},function(data)
        	{
        	    
        		$('#form2').html(data);
        		get_req_docs(cs_id);
        	}); 
        
    }
    
    
    else if(cs_id == 7 && ulbid == 209)
    {
        
         $.post('get_serviceform2.php',{id:2},function(data)
        	{
        	    
        		$('#form2').html(data);
        		get_req_docs(cs_id);
        	}); 
        
    }
    
    else if(cs_id == 7 && ulbid == 210)
    {
        
         $.post('get_serviceform2.php',{id:2},function(data)
        	{
        	    
        		$('#form2').html(data);
        		get_req_docs(cs_id);
        	}); 
        
    }
    
    
    else
    {
    
        if(cs_id==1 || cs_id==6 || cs_id==14 || cs_id==18 || cs_id==7)
        {
            if(cs_id==1)
            {
                window.open('http://125.18.179.57:8081/Taxcal/getassessmentCMS.do','_blank');
            }
            if(cs_id==6)
            {
                window.open(href='http://125.18.179.57:8081/VLTTaxcal/getassessmentCMS.do','_blank');
            }
            if(cs_id==14)
            {
                window.open(href='http://epaycdma.telangana.gov.in:8081/Tradeapplication/etradeApplicationCMS.do','_blank');
            }
            if(cs_id==18)
            {
                window.open(href='http://epaycdma.telangana.gov.in:8081/Tradeapplication/getrenwalcms.do','_blank');
            }
            if(cs_id==7)
            {
                window.open(href='http://epaycdma.telangana.gov.in:8082/CDMA_Water/newWaterApplicationCMS.do','_blank');
            }
           	/*$.post('get_iframe.php',{cs_id:cs_id},function(data)
            	{
            	    
            		$('#form2').html(data);
            	}); */
        }
        else
        {
           
            $.post('get_serviceform2.php',{id:2},function(data)
            	{
            	    
            		$('#form2').html(data);
            		get_req_docs(cs_id);
            	}); 
        }
        
    }
    
    
}
function getform()
{
    id=1;
	if(id==1)
	{
	    var ulbid=$("#ulbid").val();
	    
        
        /*if(ulbid==500)
        {*/
          $('#form2').html('');
    	  $.post('call_center_complaint_form.php',{id:id,ulbid:ulbid},function(data)
            {
               
                $('#form').html(data);
                $('#datetimepicker1').datetimepicker();
                
                
                $.post('ajax_get_streetvendors_categories_callcenter.php',{},function(data)
        {
           
            $("#dept_id").html(data);
        
        });
        
                initialize();
            });
            
       
        
         
	}
	else
	{
	    $('#form2').html('');
	$.post('get_firstservices.php',{id:id},function(data)
	{
		$('#form').html(data);
		
	});
	
	//$('#form').html('Under construction');
	}
}
function otherstreet(streetid)
{
    
    $("#otherstreetdesc").removeAttr('required');
    $("#otherstreetdesc").hide();
    if(streetid == '100000')
    {
      
       $("#otherstreetdesc").show();
       $("#otherstreetdesc").attr('required',true);
        
    }
}
function get_streets(ward_id)
{
    $('#otherwoarddesc').removeAttr('required');
    $('#otherwoarddesc').hide();
$.post('ajax_getstreets.php',{ward_id:ward_id},function(data)
	{
		$('#street_id').html(data);
		
		if(ward_id == 100000)
		{
		    $('#otherwoarddesc').show();
		    $('#otherwoarddesc').attr('required','true');
		}
		
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
   
 var app_type_id=1;
 //alert($("#app_type_id").val());
 var ulbid=$("#ulbid").val();
 
var department_id = 1;
 
$.post('getcate3callcenter.php',{dept_id:dept_id,app_type_id:app_type_id,department_id:department_id,ulbid:ulbid},function(data)
	{
	  
	   
		if(app_type_id==1)
		{
		
		$('#cs_id').html(data);
		}
		else
		{
		    
		}
	
		
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
		
		get_det(dept_id);
		
	});

}
function get_req_docs(cs_id)
{
    
	var app_type_id=$("#app_type_id").val();
	var ward_id=$("#ward_id").val();
	var dept_id=$("#dept_id").val();
	
	$.post('getdoc2.php',{cs_id:cs_id,app_type_id:app_type_id,ward_id:ward_id,dept_id:dept_id},function(data)
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
var ulbid=$("#ulbid").val();
$.post('getempcutdetcallcenter.php',{cs_id:cs_id,app_type_id:app_type_id,ward_id:ward_id,ulbid:ulbid},function(data)
{
    
$("#cut_det").html(data);
});


}
function formSubmit()
{
    $("#form1").submit();
}

function getDepartmentCategories(departmentid)
{
    
  $.post('ajax_get_streetvendors_categories_callcenter.php',{departmentid:departmentid},function(data)
        {
            $("#dept_id").html(data);
        
        });
}
</script>

{/literal}
<style>.tab button {
  
  transition: 0.3s;
  width:100%;
}

.tabcontent {
  display: none;
  padding: 45px 12px;
 
}
.clearfix{
    overflow:hidden;
}
.form-data{
    margin:0 !important;
}
.form-data p{
    padding-left:0;
    padding-right:10px;
}
.form-data p label{
    font-size:12px;
    font-weight:400;
}
</style>
<div class="row">
	<div>
		<div class="boxed">
			<div class="title-bar blue">
	                  <h4> Register Grievance </h4>
	                  
	       </div>
	       <br><br>
	       <div class=" clearfix" style="display:flex;flex-wrap:wrap;justify-content:center;">
	           
<div class="tab clearfix row col-md-8">
    <div class="col-md-6">
  <button class="tablinks btn btn-info" onclick="openCity(event, 'London')">Enquiry  </button>
  </div>
  <div class="col-md-6">
  <button class="tablinks btn btn-warning" onclick="openCity(event, 'Paris')">Grievance</button>
   </div>
</div>
<div class="col-xs-12">
<div id="London" class="tabcontent" style="display:block;">
 	<form action="saveenquiry.php" method="POST">
 	 <div class="row">
 	      <div class="form-group col-md-4">
 	          <label>Enquiry Regarding<span class="text-danger">&nbsp;*</span></label>
 	         <select class="form-control" name="regid" id="regid" required>
								<option value="">---select---</option>
								 {html_options options=$reg_list}
 	          </select>
 	          
 	  </div> 
 	 
 	   <div class="form-group col-md-4">
 	          <label>name<span class="text-danger">&nbsp;*</span></label>
 	         <input type="text" class="form-control" name="personname" required>
 	          
 	  </div> 
 	   <div class="form-group col-md-4">
 	          <label>Mobile<span class="text-danger">&nbsp;*</span> </label>
 	         <input type="text" class="form-control" name="mobile" required onkeypress="return isNumber(event)" maxlength="10">
 	          
 	  </div> 
 	  <div class="form-group col-md-4">
 	       <label>From <span class="text-danger">&nbsp;*</span></label>
 	       <div class="form-data row">
 	    <p class="col-md-2">
 	      <input type="radio" id="fromid1" name="fromid" value="1" onclick="showarea(1)">
  <label for="male">ULB </label><br>
  
  </p>
  <p class="col-md-7">
  <input type="radio" id="fromid2" name="fromid" value="2" onclick="showarea(2)">
  <label for="female">Village in municipality</label><br>
  
  </p>
  <p class="col-md-3">
  <input type="radio" id="fromid3" name="fromid" value="3" onclick="showarea(3)">
  <label for="other">Others</label>
  
  </p>
   
 	  </div>    
 	  </div>
 	  
 	  <div class="label-cnt col-md-12" style="padding:0;display:none;" id="fromidarea1">
   <div class="form-group col-md-4">
 	          <label>ULB <span class="text-danger">&nbsp;*</span> </label>
 	         <select name="ulbid" class="form-control" id="ulbidvillage" required>
 	             <option value="">--- select ----</option>
 	             {html_options options=$ulblist}
 	        </select>
 	          
 </div>
 </div>
 	  <div class="label-cnt col-md-12" style="padding:0;display:none;" id="fromidarea2">
   <div class="form-group col-md-4">
 	          <label>Distrct <span class="text-danger">&nbsp;*</span></label>
 	         <select name="distidvillage" onchange="getMandals(this.value)" class="form-control" id="distidvillage" required>
 	             <option value="">--- select ----</option>
 	             {html_options options=$dist_list}
 	        </select>
 	          
 </div>
 	  <!--<div class="form-group col-md-4">
 	          <label>Mandal</label>
 	         <select name="mandalid" class="form-control" id="mandalid" required onchange="ajax_getvillages2(this.value)">
 	             <option value="">--- select ----</option>
 	             
 	        </select>
 	          
 	  </div>-->
 	  <div class="form-group col-md-4">
 	          <label>Village <span class="text-danger">&nbsp;*</span></label>
 	         <select name="villageid" class="form-control" id="villageid" required>
 	             <option value="">--- select ----</option>
 	             
 	        </select>
 	          
 	  </div>
  </div>
  
  <div class="label-cnt col-md-12" style="padding:0;display:none;" id="fromidarea3">
  <div class="form-group col-md-4">
 	          <label>Distrct <span class="text-danger">&nbsp;*</span></label>
 	         <select name="distidothers" class="form-control" id="distidothers" required>
 	             <option value="">--- select ----</option>
 	             {html_options options=$dist_list}
 	        </select>
 	          
 </div>
 	  <div class="form-group col-md-4">
 	          <label>Mandal <span class="text-danger">&nbsp;*</span></label>
 	         <input type="text" name="town" id="town" class="form-control" required>
 	          
 	  </div>
 	  <div class="form-group col-md-4">
 	          <label>Village <span class="text-danger">&nbsp;*</span></label>
 	         <input type="text" name="village" id="village" class="form-control" required>
 	          
 	  </div>
  </div>
 	   <div class="form-group col-md-12">
 	          <label>Remarks</label>
 	       <textarea name="remarks" class="form-control" type="text" style="height:100px;resize:inherit;"></textarea>
 	          
 	  </div> 
 	  <div class="form-group col-md-12">
 	      <center>
 	          <input type="submit" name="save" class="btn btn-success" value="Submit">
 	      </center>
 	  </div>
 	  </div>
 	    </form>
</div>

<div id="Paris" class="tabcontent">
  
  
  {if $formStatus eq '1'}
				
				<form action="#"  class="form-horizontal">
				    
				    <input type="hidden" name="appid" id="appid" value="{$app_type_id}">
				    
				    <div class="form-group">
						<label class="control-label col-md-3">Select ULB<span class="required">
						* </span>
						</label>
						<div class="col-md-8">
							<select class="form-control" name="ulbid" id="ulbid" onchange="getform()">
								<option value="">---select---</option>
								{html_options options=$ulblist}
								
							</select>
						</div>
					</div>
					
					<!--<div class="form-group">
						<label class="control-label col-md-3">Type of Application <span class="required">
						* </span>
						</label>
						<div class="col-md-8">
							<select class="form-control" name="app_type_id" id="app_type_id" onchange="getform(this.value)">
								<option value="">---select---</option>
								{html_options options=$app_type_list}
								
							</select>
						</div>
					</div>-->
					   
				</form>
				{/if}
				
				<div class="row">
	<div >
		<div class="boxed">
			
	        </div>
	        
	        
	         <div class="inner no-radius" style="background-color: #FFF; padding: 15px;">
		        <form action="register_comp_callcenter.php" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
		        <span id="form"></span>
		        <span id="form2"></span>
		        
		        </form>
	        </div>
	 </div>
</div>
  
  
  
  
  
  
</div>
</div>
	       </div>
	        <br><br>
	       
	                <div class="inner no-radius">
	                {if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
		
				
				
			{if $ulbid == '500'}
                        
                    {/if} 
				
			</div>
	
		</div>
	</div>

</div>
{if isset($filepath)}
<!--<a href="{$filepath}" target="_blank">Download Receipt </a>-->
{/if}



{literal}
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&key=AIzaSyAa5wPAKKYaDy2XYG9BhvMha3ltAegrJSc"></script>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
<script>

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                          'Error: The Geolocation service failed.' :
                          'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }
</script>






<script type='text/javascript'>//<![CDATA[
    
    function initialize() {
        //alert('okk');
        navigator.geolocation.getCurrentPosition(function(position)
        {
            var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        
            document.getElementById("lat").value = position.coords.latitude;
            document.getElementById("long").value = position.coords.longitude;
            var latitude=position.coords.latitude;
            var longitude=position.coords.longitude;
        
        });
             
		var myLatlng = new google.maps.LatLng(17.448690,78.449997);

        var myOptions = {
            zoom: 16,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        var marker = new google.maps.Marker({
            draggable: true,
            position: myLatlng,
            map: map,
            title: "Your location"
        });

        google.maps.event.addListener(marker, 'dragend', function (event) {
        
            document.getElementById("lat").value = event.latLng.lat();
            document.getElementById("long").value = event.latLng.lng();
            
            infoWindow.open(map, marker);
        });
    }
    
</script>
<script src='../js/jquery.min.js'></script>
<script>
$(document).ready(function() {
    
$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });
    
    
      
    
	});
	
	function get_det1(desg_id)
{
    
	var select1 = document.getElementById("emp_id");
	select1.options.length = 0;
	
	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	else
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var strArray = xmlhttp.responseText.split("___");
			var j=strArray.length;
			for(i=0;i<j;i++)
			{
				var optArray=strArray[i].split(":::");
				select1.options[select1.options.length] = new Option(optArray[1],optArray[0]);
			} 
		}
	}
	xmlhttp.open("GET","get_emps.php?desg_id="+desg_id,true);
	xmlhttp.send();

}
function get_det(dept_id)
{
    
	var select = document.getElementById("emp_desg");
	var select1 = document.getElementById("emp_id");
	select.options.length = 0;
	select1.options.length = 0;
	
	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	else
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var strArray = xmlhttp.responseText.split("___");
			//.alert(strArray);
			//console.log(strArray);
			var j=strArray.length;
			for(i=0;i<j;i++)
			{
				var optArray=strArray[i].split(":::");
				select.options[select.options.length] = new Option(optArray[1],optArray[0]);
			}
		}
	}
	//alert(dept_id);
	xmlhttp.open("GET","get_designations.php?dept_id="+dept_id,true);
	xmlhttp.send();

}

function oldCompCheckID()
{
    if($("#old_comp_check_id").is(":checked"))
    {
        //alert('checked');
        $('#datetimepicker_div_id').css('display','block');
        $('#datetimepicker').prop('required',true);
    }
    else
    {
        //alert('Not checked');
        $('#datetimepicker').val('');
        $('#datetimepicker_div_id').css('display','none');
        $('#datetimepicker').prop('required',false);
        
    }
}

function latLngCheckID(){
    if($("#lat_lng_check_id").is(":checked")){
        //alert('checked');
        initialize();
        $('#lat_lng_value_div_id').css('display','block');
        $('#google_maps_div_id').css('display','block');
        $('#lat').prop('required',true);
        $('#long').prop('required',true);
    }else{
        $('#lat_lng_value_div_id').css('display','none');
        $('#google_maps_div_id').css('display','none');
        $('#lat').prop('required',false);
        $('#long').prop('required',false);
    }
}
	</script>

{/literal}

{include file='footer.tpl'}
{literal}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script>
$(function () {
                $('#datetimepicker1').datetimepicker();
            });
</script>
<style>
.btn-primary {
  width: 100%;
}
</style>
{/literal}