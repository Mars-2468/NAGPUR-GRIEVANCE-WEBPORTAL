{include file='header2.tpl'}
{literal}
<style>
textarea{
resize:none;
}

</style>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script> 
   <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> 

<script>
	$(document).ready(function()
	{
	var checked=$("input[name='underlrs2008']:checked").val();
	if(checked=='1')
	{
	$("#div_content").css('display','block');
	}
	else
	{
	$("#div_content").css('display','none');
	}
	
	
	
	var distid=$("#district_id").val();
	var ulbid=$("#ulbid_sel").val();
	
	$.post('ajax_getulbs.php',{distid:distid,ulbid:ulbid},function(data)
	{
		
		$("#ulbid").html(data);
	});
	
	$(".datepick").datepicker({dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});
	
	
	
	
	
	 $(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });
	
	
	
	
	});
	
	
function start_calc()
{
	
	var checked=$("input[name='radios']:checked").val();
	if(checked ==2 || checked==3)
	{
		$("#tot_extent_layout").css('display','block');
		$("#percent_open_space").attr('display',block);
	}
	else
	{
	$("#tot_extent_layout").css('display','none');
	$("#percent_open_space").css('display','none');
	}
	var percent_open_space=parseInt($("#percent_open_space").val());
	var plot_area=parseFloat($("#plot_area").val());
	
	var market_value=parseInt($("#market_value").val());
	var land_value=parseInt($("#land_value").val());
	var rate_land_use=parseInt($("#rate_land_use").val());
	if(isNaN(plot_area))
	{
	plot_area=0;
	}
	if(isNaN(market_value))
	{
	market_value=0;
	}
	if(isNaN(rate_land_use))
	{
	rate_land_use=0;
	}
	if(isNaN(land_value))
	{
	land_value=0;
	}
	
	var loc_slums=$('#located_in_slum_yn').val();
	
	
	$.post("ajax_tot_reg_charges.php",{plot_area:plot_area,market_value:market_value,land_value:land_value,loc_slums:loc_slums,checked:checked,percent_open_space:percent_open_space,rate_land_use:rate_land_use},function(data)
	{
	
	$("#total").text(data);
	$("#grand_total").val(data);
	
	});
	
}	
	
function removeread()
{
	var value=$("#land_of_use").val();
	
	if(value=='1' || value=='0')
	{
	$("#type_change").attr("disabled",true);
	$("#type_change").val('0');
	$("#rate_land_use").val('0');
	}
	else if(value=='2')
	{
	$("#type_change").attr("disabled",false);
	}
}
function sendurl()
{
	alert();
}

function validateForm()
{
var errors=0;
	var checked=$("input[name='radios']:checked").val();
	
	
	if(typeof checked=="undefined")
	{
	alert('Select plot type');
	return false;
	}
	
	
	
	
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
	
	
	if(errors==0)
	{
		
		
		var mobile1=$("#phone").val();
		var mobile2=$("#mobile2").val();
		
		
		
		
		
		var pattern = /^[7-9]{1}[0-9]{9}$/;
	
			if (!pattern.test(mobile1)) {
		         
			alert('Invalid mobile number');
				
		          ($(this)).css({"background-color": "pink"});
				errors++;
		           }
		           else
		           {
		           ($(this)).css({"background-color": "white"});
				
		           }
		           
		          
		           
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
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
}
function showmodel()
{



	var checked=$("input[name='radios']:checked").val();
	var percent_open_space=parseInt($("#percent_open_space").val());
	var plot_area=parseFloat($("#plot_area").val());	
	var market_value=parseInt($("#market_value").val());
	var land_value=parseInt($("#land_value").val());
	var rate_land_use=parseInt($("#rate_land_use").val());
	if(isNaN(plot_area))
	{
	plot_area=0;
	}
	if(isNaN(market_value))
	{
	market_value=0;
	}
	if(isNaN(rate_land_use))
	{
	rate_land_use=0;
	}
	if(isNaN(land_value))
	{
	land_value=0;
	}
	
	var loc_slums=$('#located_in_slum_yn').val();
	
	$("#add_tables").html('<img src=images/loader.gif>');
	$.post("ajax_tables.php",{plot_area:plot_area,market_value:market_value,land_value:land_value,loc_slums:loc_slums,checked:checked,percent_open_space:percent_open_space,rate_land_use:rate_land_use},function(data)
	{
	
	
	$("#add_tables").html(data);
	$("#myModal").model();
	});
	
	
	
}


function otherdoc()
{
	//var other=$("input[name='other']:checked");
	
	var check=document.getElementById('other').checked;
	if(check)
	{
	$('#other_doc').attr('disabled',false);
	}
	else
	{
	$('#other_doc').attr('disabled',true);
	}
	
}
function showdiv(val)
{
	if(val=='1')
	{
	$("#div_content").css('display','block');
	}
	else
	{
	$("#div_content").css('display','none');
	}
}

function check_format(value,id,unique)
{
	if(unique==1)
	{
	var pattern = /^[7-9]{1}[0-9]{9}$/;
	
	if (!pattern.test(value)) {
         
	alert('Invalid mobile number');
		
           return false;
           }
	
	}
	
	if(unique==2)
	{
	pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if (!pattern.test(value)) {
         
	alert('Invalid Email');
		
           return false;
           }
	}
}
function setrate()
{
	type_change=$("#type_change").val();
	ulbid=$("#ulbid").val();
	
	$.post("ajax_get_rateoflanduse.php",{type_change:type_change,ulbid:ulbid},function(data)
	{
	
	$("#rate_land_use").trigger("change");
	$("#rate_land_use").val(data);
	
	});
}

function getulbs(ulbid)
{
	
	
	var distid=$("#district_id").val();
	
	$.post('ajax_getulbs.php',{distid:distid,ulbid:ulbid},function(data)
	{
		$("#ulbid").html(data);
	});
}
function check_amount(id)
{
	var amount=parseInt($("#amount").val());
	var total=parseInt($("#grand_total").val());
	
	if(amount > total)
	{
	alert('Enter amount equla or greater than Penal Charges Payable');
		$("#" + id).val('');
		return false;
	}
	if(total > 20000)
	{
		if(amount <10000)
		{
		alert('Enter amount Equal or more than 10000');
		$("#" + id).val('');
		return false;
		}
	}
	if(total <=20000)
	{
	var amounttobepaid =total/2;
		if(amount < amounttobepaid)
		{
			alert('Enter amount minimum '+ amounttobepaid);
			$("#" + id).val('');
			return false;
		}
	}
}
function check_ifsc_code(ifsccode)
{
	var dd_no =$("#dd_no").val();
	var ifsccode=$("#ifsc_code").val();
	
	$.post('ajax_getbankdet.php',{ifsccode:ifsccode,dd_no:dd_no},function(data)
	{
		if(data==1)
		{
		alert('This DDno is already existed');
		$("#dd_no").val('');
		}
		else if(data==2)
		{
		alert('We have no found any bank details with this IFSC code ');
		$("#ifsc_code").val('');
		$("#bank_details").text('');
		}
		else
		{
		var arr=data.split("::");
		var bank_details=arr[0]+","+arr[1];
		$("#bank_details").text(bank_details);
		$("#bank_id").val(arr[2]);
		}
	});
}
</script>


{/literal}

<div class="main_box">


<div style="width:80%;">
{if isset($error_list)}
<ul>
{foreach from=$error_list item=row key=key}
	<li>{$error_list[$key]}</li>
{/foreach}
</ul>
{/if}
</div>


<div class="myheading2">APPLICATION FOR REGULARIZATION OF UNAPPROVED LAYOUT / PLOT </div>
<div class="runtext">

<div class="form-group" style=" width:800px; margin:auto; margin-top:10px; height:40px; font-size:13px;">

<form action="app_lrs.php" method="post" enctype="multipart/form-data" onSubmit="return validateForm()">

<input type="hidden" name="user_id" value="{$uid}">
<input type="hidden" name="ulbid_sel" id="ulbid_sel" value="{$ulbid}">
<input type="hidden" name="grand_total" id="grand_total">

<label style="text-align:right; float:left;">APPLYING FOR REGULARIZATION OF</label>
<div >
<label class="radio-inline" for="radios-0" style="float:left; margin-left:20px;">
<input id="radios0" type="radio"  value="1" name="radios" onclick="start_calc()" checked>
INDIVIDUAL PLOT
</label>
<label class="radio-inline" for="radios-1">
<input id="radios1" type="radio"  value="2" name="radios" onclick="start_calc()" >
TOTAL LAYOUT
</label>
<label class="radio-inline" for="radios-2">
<input id="radios2" type="radio"  value="3" name="radios" onclick="start_calc()">
PART OF LAYOUT
</label>
</div>
</div>

<form style="font-size:13px;">
<div style="border:1px dashed #CCCCCC; height:290px; padding-top:0px; background-color:#efe9d7; border-radius:10px;">

<div style="text-align:center; margin-bottom:20px; border-bottom:1px #333 solid; padding:5px 0px;  border-radius:10px; color:#FFF; background-color:#2ebb99;"><strong>Applicant Details</strong></div>

<table width="100%" border="0">
  <tr height="40">
    <td width="257" align="right">Name of the Applicant:</td>
    <td width="2">&nbsp;</td>
    <td width="256" align="left" valign="middle">
    <div class="form-group"> <input type="text" class="form-control mytext" name="applicant_name" id="applicant_name" placeholder="Enter Applicant name" style="width:200px;" value="{$appl_name_sel}"></div>    </td>
    <td width="29" align="left" valign="middle">&nbsp;</td>
    <td width="115" align="right" valign="middle">Locality:</td>
    <td width="10" align="left" valign="middle">&nbsp;</td>
    <td width="435" align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext" name="locality" id="locality" placeholder="Locality" style="width:200px;" value="{$locality_sel}"/>
    </div></td>
  </tr>
  <tr height="40">
    <td align="right">Father / Husband:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle">
    <div class="form-group"> <input type="text" class="form-control mytext" name="fh_name" id="fh_name" placeholder="Enter Father / Husband" style="width:200px;" value="{$fh_name_sel}"></div>    </td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">City/Town:</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext" name="city" id="city" placeholder="Enter City/Town" style="width:200px;" value="{$city_sel}"/>
    </div></td>
  </tr>
  <tr height="40">
    <td align="right">Age: </td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext num" name="age" id="age" placeholder="Enter Age" style="width:200px;" maxlength="2" value="{$age_sel}"/>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Mobile No. 1:</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control num mytext" name="phone" id="phone" placeholder="Enter mobile number" style="width:200px;" onblur="check_format(this.value,this.id,'1')" maxlength="10" value="{$phone_sel}"/>
    </div></td>
  </tr>
  <tr>
    <td align="right">Occupation: </td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext" name="occupation" id="occupation" placeholder="Enter Occupation" style="width:200px;" value="{$occupation_sel}"/>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Mobile No. 2:</td>
    <td align="left" valign="middle">&nbsp;</td>
     <td align="left" valign="middle"><div class="form-group">
       <input type="text" class="form-control num" name="mobile2" id="mobile2" placeholder="Enter mobile number" style="width:200px;" onblur="check_format(this.value,this.id,'1')" maxlength="10" value="{$mobile2_sel}"/>
     </div></td>
  </tr>
  
  <tr height="40">
    <td align="right">Door No:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext" name="door_no" id="door_no" placeholder="Enter Door No." style="width:200px;" value="{$door_no_sel}"/>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Email:</td>
    <td align="left" valign="middle">&nbsp;</td>
     <td align="left" valign="middle"><div class="form-group">
       <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email" style="width:200px;" onblur="check_format(this.value,this.id,'2')" value="{$email_sel}"/>
     </div></td>
  </tr>
  <tr height="40">
    <td height="21" align="right">Street:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext" name="street" id="street" placeholder="Enter Street" style="width:200px;" value="{$street_sel}"/>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>

</div>


<div style="border:1px dashed #CCCCCC; height:310px; padding-top:0px; background-color:#c8e7ff; border-radius:10px;">

<div style="text-align:center; margin-bottom:20px; border-bottom:1px #333 solid; padding:5px 0px;  border-radius:10px; color:#FFF; background-color:#2d3e52;"><strong>Location Details</strong></div>

<table width="100%" border="0">
  <tr height="0">
    <td align="right">Your Applying For</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr height="0">
    <td align="right">{if isset($user_type)}<br>Select District{else} Select District:{/if}</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <select class="form-control dropdown" name="district_id" id="district_id" style="width:200px;" onchange="getulbs('{$ulbid}')">
        <option value="0">-Select-</option>
        
        {html_options options=$dist_list selected=$district_id_sel}
      
      </select>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Select ULB:</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <select class="form-control dropdown" name="ulbid" id="ulbid" style="width:200px;" onchange="setrate()">
        <option value="0">-Select-</option>
      </select>
    </div></td>
  </tr>
  <tr height="40">
  
  
    <td align="right">Name of the Layout/Colony:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext" name="name_of_layout" id="name_of_layout" placeholder="Enter Layout/Colony" style="width:200px;" value="{$name_of_layout_sel}"/>
    </div></td>
   
    
   
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Revenue Mandal:</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">
    <div class="form-group">
      <input type="text" name="mandal_id" id="mandal_id"  class="form-control mytext" style="width:200px;" placeholder="Mandal" value="{$mandal_id_sel}"/>
    </div></td>
  </tr>
  <tr height="40">
    <td width="254" align="right">Survey No:</td>
    <td width="10">&nbsp;</td>
    <td width="247" align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext" name="survey_no" id="survey_no" placeholder="Enter Survey No" style="width:200px;" value="{$survey_no_sel}"/>
    </div></td>
    <td width="43" align="left" valign="middle">&nbsp;</td>
    <td width="112" align="right" valign="middle">Revenue Village:</td>
    <td width="10" align="left" valign="middle">&nbsp;</td>
    <td width="425" align="left" valign="middle">
    <div class="form-group">
      <input type="text" id="village_id" name="village_id" class="form-control mytext" placeholder="village" style="width:200px;" value="{$village_id_sel}"/>
    </div></td>
  </tr>
  <tr height="40">
    <td align="right">Plot No:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" name="plot_no" id="plot_no" class="form-control" placeholder="Plot No" style="width:200px;" value="{$plot_no_sel}"/>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Election Ward Number :</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" name="ward" id="ward" class="form-control num" placeholder="Ward number" style="width:200px;" value="{$ward_sel}"/>
    </div></td>
  </tr>
  <tr height="40">
    <td align="right">Locality:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext" id="locality2" name="locality2" placeholder="Enter Locality" style="width:200px;" value="{$locality2_sel}"/>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    
  </tr>
  <tr height="40">
    <td align="right">Located in Slums:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <select id="located_in_slum_yn" class="form-control dropdown" name="located_in_slum_yn" style="width:200px;" onchange="start_calc()">
        <option value="0">-Select-</option>
        {html_options options=$yn_list selected=$located_in_slum_yn_sel}
      </select>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>

</div>


<div style="border:1px dashed #CCCCCC; height:340px; padding-top:0px; background-color:#d4ffe0; border-radius:10px;">

<div style="text-align:center; margin-bottom:20px; border-bottom:1px #333 solid; padding:5px 0px;  border-radius:10px; color:#FFF; background-color:#24a246;"><strong>Details of the Layout / Plot</strong></div>

<table width="90%" border="0" align="center">
  <tr >
    <td  colspan="3" align="right">
    <div style="display:none;">
    <table width="100%" border="0">
  <tr>
    <td align="right">Total Extent of Layout (in Acs.)</td>
    <td>&nbsp;</td>
    <td><div class="form-group"> <input type="text" class="form-control float" id="tot_extent_layout" name="tot_extent_layout" placeholder="Enter Extent of Layout" style="width:200px;" {if isset($tot_extent_layout_sel)}value="{$tot_extent_layout_sel}" {else}value="0" {/if} readonly></div></td>
  </tr>
</table>
    </div>    </td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle">
    <table width="100%" border="0">
  <tr>
    <td width="47%" align="right">Width of Approach Road in meters:</td>
    <td width="4%">&nbsp;</td>
    <td width="49%"><div class="form-group">
      <input type="text" class="form-control mytext float" id="width_road_approach" name="width_road_approach" placeholder="Enter Road in meters" style="width:200px;" value="{$width_road_approach_sel}"/>
    </div></td>
  </tr>
</table>    </td>
    </tr>
 
  <tr height="40">
    <td align="right">Plot area (in Sq. m):</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle">
    <div class="form-group"> <input type="text" class="form-control mytext float" name="plot_area" id="plot_area" placeholder="Enter Plot area" style="width:200px;" onchange="start_calc()" value="{$plot_area_sel}"></div>    </td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Width of Roads proposed in Meters:</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext float" id="width_road_proposed" name="width_road_proposed" placeholder="Enter proposed in Meters" style="width:200px;" value="{$width_road_proposed_sel}"/>
    </div></td>
  </tr>
  <tr height="40">
    <td align="right">Layout plan drawn to scale enclosed duly showing the dimensions and boundaries of the plots, roads and open spaces:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle">
    <div class="form-group">
       <select id="boundaries_plot_yn" class="form-control dropdown" name="boundaries_plot_yn" style="width:200px;">
<option value="0">-Select-</option>
{html_options options=$yn_list selected=$boundaries_plot_yn_sel}
</select>
    </div>    </td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">As Per:</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">
    <div class="form-group">
      <select id="asper" class="form-control dropdown" name="asper" style="width:200px;">
        <option value="0">-Select-</option>
        {html_options options=$asper_list selected=$asper}
      </select>
    </div></td>
  </tr>
  
  <tr>
    <td height="32" colspan="3" align="center"><table width="100%" border="0">
      <tr>
        <td align="right">Latest Land value (Sub-Registrar value) of the plot Rs . per sq.yds as on 28.10.2015:</td>
        <td>&nbsp;</td>
        <td><div class="form-group">
          <input type="text" class="form-control mytext float" name="market_value" id="market_value" placeholder="Enter Market value" style="width:200px;" onchange="start_calc()"  value="{$market_value_sel}"/>
        </div></td>
      </tr>
    </table></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle">
  <div style="display:none;">  
    <table width="100%" border="0">
      <tr>
        <td width="49%" align="right">Percentage of open space provided:</td>
        <td width="3%">&nbsp;</td>
        <td width="48%">
        <div class="form-group">
      <input type="text" class="form-control float" id="percent_open_space" name="percent_open_space" placeholder="Enter Space provided" style="width:200px;" onchange="start_calc()" {if isset($percent_open_space_sel)} value="{$percent_open_space_sel}" {else} value="0" {/if} readonly/>
    </div></td>
      </tr>
    </table>
    </div>
    
    </td>
    </tr>
  <tr>
    <td height="32" align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Land value (Sub-Registrar Value) Rs. per sq. yards as on the date of registration of plot:</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext float" id="land_value" name="land_value" placeholder="Land Value" style="width:200px;" onchange="start_calc()" value="{$land_value_sel}"/>
    </div></td>
  </tr>
</table>

</div>



<div style="border:1px dashed #CCCCCC; height:auto; min-height:117px; padding-top:0px; background-color:#fff8eb; border-radius:10px;">

<div style="text-align:center; margin-bottom:20px; border-bottom:1px #333 solid; padding:5px 0px;  border-radius:10px; color:#FFF; background-color:#344860;">Layout Plan drawn to scale enclosed duly showing the dimensions and boundaries of the plots, roards and open spaces</div>

<table width="100%" border="0">
 
  <tr height="40">
    <td align="center">If Any application made under LRS 2008:
   
   
      <input type="radio" class="mytext num" name="underlrs2008" id="underlrs2008" placeholder="Enter Plot area" value="1" onclick="showdiv('1')" {if $underlrs2008_sel eq '1'} checked {/if} />
      Yes
  <input type="radio" class="mytext num" name="underlrs2008" id="underlrs2008" placeholder="Enter Plot area" value="2" onclick="showdiv('2')" {if $underlrs2008_sel eq '1'} {else} checked  {/if}/>
      No 
	  </div>
	  </td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>

<br />
<div style="display:none;" id="div_content">
<table width="100%" border="0">
  <tr>
    <td width="24%" align="right">File No:</td>
    <td width="1%">&nbsp;</td>
    <td width="24%" align="left"><div class="form-group">
      <input type="text" class="form-control" name="file_no" id="file_no" placeholder="Enter Plot area" style="width:200px;" onchange="start_calc()" value="{$file_no_sel}"/>
    </div></td>
    <td width="1%">&nbsp;</td>
    <td width="16%" align="right">DD No:</td>
    <td width="1%">&nbsp;</td>
    <td width="33%" align="left"><div class="form-group">
      <input type="text" class="form-control num" name="dd_no2" id="dd_no2" placeholder="Enter DD No" style="width:200px;" onchange="start_calc()" value="{$dd_no2_sel}"/>
    </div></td>
  </tr>
  
  
  
  
  
  <tr>
    <td align="right">Bank Name:</td>
    <td>&nbsp;</td>
    <td align="left"><div class="form-group">
      <input type="text" class="form-control" name="bank_name2008" id="bank_name2008" placeholder="Enter Bank Name" style="width:200px;" onchange="start_calc()" value="{$app_date_sel}"/>
    </div></td>
    <td>&nbsp;</td>
    <td align="right">Branch Name:</td>
    <td>&nbsp;</td>
    <td align="left"><div class="form-group">
      <input type="text" class="form-control" name="branch_name2008" id="branch_name2008" placeholder="Enter Branch Name" style="width:200px;" onchange="start_calc()" value="{$dd_date_sel}"/>
    </div></td>
  </tr>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  <tr>
    <td align="right">Date of Application:</td>
    <td>&nbsp;</td>
    <td align="left"><div class="form-group">
      <input type="text" class="form-control datepick" name="app_date" id="app_date" placeholder="Enter Date of Application" style="width:200px;" onchange="start_calc()" value="{$app_date_sel}"/>
    </div></td>
    <td>&nbsp;</td>
    <td align="right">DD Date:</td>
    <td>&nbsp;</td>
    <td align="left"><div class="form-group">
      <input type="text" class="form-control datepick" name="dd_date" id="dd_date" placeholder="Enter DD Date" style="width:200px;" onchange="start_calc()" value="{$dd_date_sel}"/>
    </div></td>
  </tr>
  <tr>
    <td align="right">Amount Paid: </td>
    <td>&nbsp;</td>
    <td align="left"><div class="form-group">
      <input type="text" class="form-control" name="amount_paid" id="amount_paid" placeholder="Enter Amount Paid" style="width:200px;" onchange="start_calc()" value="{$amount_paid_sel}"/>
    </div></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
</table>
<br><br>
</div>
</div>



<div style="border:1px dashed #CCCCCC; height:280px; padding-top:0px; background-color:#f5e8fc; border-radius:10px;">

<div style="text-align:center; margin-bottom:20px; border-bottom:1px #333 solid; padding:5px 0px;  border-radius:10px; color:#FFF; background-color:#9958bc;"><strong>LANDUSE</strong></div>

<table width="100%" border="0">
  <tr height="40">
    <td width="286" height="26" align="right">Land use of the site as per Master Plan:</td>
    <td width="10">&nbsp;</td>
    <td width="212" align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control float" id="land_use" name="tot_extent_layout2" placeholder="Enter Extent of Layout" style="width:200px;"/>
    </div></td>
    <td width="12" align="left" valign="middle">&nbsp;</td>
    <td width="240" align="right" valign="middle">Whether the site is falling in prohibited areas, namely, G.O.Ms.No.111 MA, dt. 8.3.1996 relating Osmansagar and Himayath sagar catchment area:</td>
    <td width="10" align="left" valign="middle">&nbsp;</td>
    <td width="266" align="left" valign="middle"><span class="form-group">
      
    </span>
      <div class="form-group">
        <select id="falling_prohibited_areas_yn" class="form-control dropdown" name="falling_prohibited_areas_yn" style="width:200px;">
          <option value="0">-Select-</option>
          
        
{html_options options=$yn_list selected=$falling_prohibited_areas_yn_sel}

      
        </select>
      </div></td>
  </tr>
  <tr height="40">
    <td align="right"> Weather Change of Land Required?</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <select class="form-control dropdown" name="land_of_use" id='land_of_use' style="width:200px;" onchange="removeread()">
        <option value="0">-Select-</option>
        
{html_options options=$yn_list}

      </select>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr height="40">
    <td align="right">Type of change:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <select class="form-control" name="type_change" id='type_change' style="width:200px;"  disabled="disabled" onchange="setrate()">
        <option value="0">-Select-</option>
        
        {html_options options=$type_change_list}
      
      </select>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Recreational use/Industrial use/Water Body / Openspace use as per notified Master Plan/Zonal development plan:</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">
      <select id="recreational_use" class="form-control dropdown" name="recreational_use" style="width:200px;">
        <option value="0">-Select-</option>
        {html_options options=$yn_list selected=$recreational_use_sel}
      </select>    </td>
  </tr>
  <tr height="40">
    <td align="right">Rate of change of land value:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle">
    <input type="text" class="form-control" id="rate_land_use" name="rate_land_use" value="0" style="width:200px;" onchange="start_calc()" readonly/>    </td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">  </td>
  </tr>
</table>

</div>


<table width="50%" border="1" align="center">
 <tr>
   <td width="50%" align="center" valign="middle"> PENAL <br />
   CHARGES PAYABLE </td>
   <td width="50%" align="center" valign="middle"> 
   <span id="anchor"></span>
   
   
   <a href="#" data-toggle="modal" data-target="#myModal" onclick="showmodel()"><strong>Rs. <span id="total"></span></strong></a>
  
   
   </td>
 </tr>
</table>









<div style="border:1px dashed #CCCCCC; height:180px; padding-top:0px; background-color:#ffccc3; border-radius:10px;">

<div style="text-align:center; margin-bottom:20px; border-bottom:1px #333 solid; padding:5px 0px;  border-radius:10px; color:#FFF; background-color:#be3e25;"><strong>Demand Draft / Pay Order</strong></div>

<table width="100%" border="0">
  <tr height="40">
    <td width="256" align="right">Amount:</td>
    <td width="10">&nbsp;</td>
    <td width="251" align="left" valign="middle">
    <div class="form-group"> <input type="text" class="form-control mytext float" id="amount" name="amount" placeholder="Enter Amount" style="width:200px;" onblur="check_amount(this.id)" value="{$amount_sel}"></div>    </td>
    <td width="35" align="left" valign="middle">&nbsp;</td>
    <td width="197" align="right" valign="middle">IFSC Code: </td>
    <td width="30" align="left" valign="middle">&nbsp;</td>
    <td width="322" align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control dropdown" name="ifsc_code" id='ifsc_code' style="width:200px;" onblur="check_ifsc_code(this.value)">
       <input type="hidden" name="bank_id" id="bank_id">
    </div></td>
  </tr>
  <tr height="40">
    <td align="right">D.D.No:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle">
    <div class="form-group"> <input type="text" class="form-control mytext num" id="dd_no" name="dd_no" placeholder="Enter D.D.No" style="width:200px;" value="{$dd_no_sel}" onblur="check_ifsc_code(this.value)"></div>    </td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">Bank Details:</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">
    <div class="form-group">
      <span id="bank_details"></span>
    </div></td>
  </tr>
  <tr height="40">
    <td align="right">Date:</td>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><div class="form-group">
      <input type="text" class="form-control mytext datepick" id="date" name="date" placeholder="Enter Date" style="width:200px;" value="{$date_sel}"/>
    </div></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>

</div>


<div style="border:1px dashed #CCCCCC; height:auto; padding-top:0px; background-color:#eaeced; border-radius:10px;">

<div style="text-align:center; margin-bottom:20px; border-bottom:1px #333 solid; padding:5px 0px;  border-radius:10px; color:#FFF; background-color:#3797e1;"><strong>Attached Documents</strong></div>

<table width="100%" border="0">
{assign var="i" value=1}
{foreach from=$doc_list item=row key=doc_id}

{if $i % 2 eq '0'}
  <tr height="40" style="background-color:#FFF;">
		    <td width="101" align="left">&nbsp;</td>
		    <td width="656" align="left">{$doc_list[$doc_id]}</td>
		    <td width="29">&nbsp;</td>
		    <td width="296" align="left" valign="middle">
		    <div class="form-group">
		    
		    
		   <div class="checkbox checkbox-success">
			<input type="checkbox" name="check_list[]" value="{$doc_id}" class="styled" style="width:16px;height:16px;" >
			<label for="checkbox3">
		                            
		                 </label>
			</div>
		  <input type="hidden" name="{'doc_id'|cat:$i}" value="{$doc_id}">
		
		  </div>    
		</td>
    		<td width="27" align="left" valign="middle">&nbsp;</td>
    </tr>
{else}	  
	  
	  <tr height="40"  style="background-color:#bec3c7;">
	    <td align="left">&nbsp;</td>
	    <td align="left">{$doc_list[$doc_id]}</td>
	    <td>&nbsp;</td>
	    <td align="left" valign="middle">
	    <div class="form-group">
	    
	    
	    {if $doc_id eq '99'}
	    
	   	<input type="checkbox" name="other" id="other" value="{$doc_id}" class="styled" onclick="otherdoc()" style="width:16px;height:16px;">
		<input type="text" name="other_doc" id="other_doc" disabled>
			
	    <input type="hidden" name="{'doc_id'|cat:$i}" value="{$doc_id}">
	    
	    
	    
	   
	    {else}
	    
	    <div class="checkbox checkbox-success">
			<input type="checkbox" name="check_list[]" value="{$doc_id}" class="styled" style="width:16px;height:16px;">
			<label for="checkbox3">
		                            
		                 </label>
			</div>
	    <input type="hidden" name="{'doc_id'|cat:$i}" value="{$doc_id}">
	    
	        </td>
	        {/if}
	    <td align="left" valign="middle">&nbsp;</td>
	    </tr>
    {/if}
    {assign var="i" value=$i+1}
    {/foreach}
    <input type="hidden" name="file_count" value="{$i}">
</table>
<br>
<br>






</div>
<br />

<div style="width:100px; margin:0 auto;"> <button type="submit" name="save" class="btn btn-danger ">Submit</button></div>
</form>










</div>

</div>
<br />
<br />
 
 
 <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:90%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        
        
        
        
        <span id="add_tables"></span>
        
        
        
         </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     
      </div>
    </div>
  </div>
</div>
 
 
 
{include file='footer.tpl'}
                            