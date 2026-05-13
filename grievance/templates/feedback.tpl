{literal}

<link rel="stylesheet" href="./css/bootstrap.css">
 
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>

 


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>-->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">



<script language='javascript'>

function get_streets(ward_id)
{
	var select = document.getElementById("street_id");
	select.options.length = 0;

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
				if(optArray[0]=='0')
					select.options[select.options.length] = new Option('All','%');
				else
					select.options[select.options.length] = new Option(optArray[1],optArray[0]);				
				
				
			} 
		}
	}
	xmlhttp.open("GET","get_streets.php?ward_id="+ward_id,true);
	xmlhttp.send();
}



function validateForm()
{
	var mobile=document.check_comp_status.mobile.value;
	var patt= /^[7-9]\d{9}$|^$/;
			
    	if(!patt.test(mobile))
    	{
		alert("Please Enter Valid Mobile No");
		return false;    	
    	}
	return true;
}









</script>

    <!--<link rel="stylesheet" href="../css/bootstrap.css">-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Mallanna&display=swap" rel="stylesheet">

<style>

table tr:nth-child(odd) {
 /*background-color: #f1f1f1;*/
}
table tr:nth-child(even) {
 background-color: #ffffff;
}


tr td span{
    font-family: 'Mallanna', sans-serif;
    font-size:18px;
    font-weight:bold;
}


</style>

{/literal}

<body style="padding:0px; margin:0px;">

<div class="row" style="background-color:#0b1c40;">
<div class="container">
<center>

</center>
</div>

<div style="background-color:#0066CC; color:#FFF; padding:5px; text-align:center; font-size:22px;">
<div class="container">
	<img src="images/nagpur-logo.png" style="width:50px;"> 
<!-- <strong>New Problem Registration </strong> -->
<strong>NAGPUR MUNICIPAL CORPORATION / नागपूर महानगरपालिका</strong>
<!--<img src="images/smart-city.png" style="width:50px;"> -->
</div>
</div>
</div>


<div >

<div >


<div class="row" style="background-color:#e3f6f5;">
<div class="container">
<center>

</center>
</div>

<div style="background-color:#0066CC; color:#FFF; padding:5px; text-align:center; font-size:15px;"><strong>Search Complaint </strong></div>
</div>



<div id="area" class="container" style="margin-top:15px;">
<div style="float:left"><a href="web_complaint_form.php" class="btn btn-primary">Back</a></div>
<a href="user_logout.php" class="btn btn-danger" style="float: right;">Logout</a>
<!--<div style="float:right"><a href="user_logout.php" class="btn btn-primary">Logout</a></div>-->
<div >



<div class="panel panel-info"  style="margin-top:50px;">
<div class="panel-heading" style="text-align:center;">Feedback</div>
<div class="panel-body">

<form name='check_comp_status' method='POST' action='feedback.php' onSubmit="return validateForm();" >

<input type="hidden" name="ulbid" value="{$ulbid}">


<div class="row">

<div class="col-md-3">
<label>Name</label>
<input type="text" name="person_name" id="person_name"  value="{$grievances.person_name}" class="form-control" required readonly/>
</div>

<div class="col-md-3">
<label>Mobile No</label>
<input type="text" name="mobile" class="form-control" value="{$grievances.mobile}" required readonly/>
</div>

<div class="col-md-3">
<label>Ward</label>
<input type="text" name="ward" id="ward"  class=" form-control" value="{$grievances.ward_desc}" required readonly>
</div>

<div class="col-md-3">
<label>Street</label>
<input type="text" name="street" id="street"   class=" form-control" value="{$grievances.street_desc}" required readonly>
</div>

<div class="col-md-4" style="margin-top:10px;">
<label>Complaint Type</label>
<input type="text" name="complaint_type" class="form-control" value="{$grievances.cs_desc}" required>
</div>


<div class="col-md-3" style="margin-top:10px;">
<label>Rating</label>
<select name="grievance_status_id" id="grievance_status_id" class="form-control" required>
	<option value=''>-All-</option>
	 {foreach from=$rating_options item=row}
		<option value="{$row}">{$row}</option>
	 {/foreach}
	
</select>
</div>

<div class="col-md-3" style="margin-top:10px;" id="grievance_sub_options">
<label>Sub Options</label>
<select name="grievance_sub_options" id="grievance_sub_options" class="form-control" >
	<option value=''>-All-</option>
	 {foreach from=$sub_options item=row key=emp_id}
		<option value="{$row.sub_option_id}">{$row.description}</option>
	 {/foreach}
	
</select>
</div>
<div class="col-md-12" style="margin-top:10px;">
<label>Description</label>
<textarea name="description" class="form-control" ></textarea>
</div>


<div class="col-md-12 text-right" style="margin-top: 20px;">
<input type="hidden" name="grievance_id" class="form-control" value="{$grievances.grievance_id}" required>
<input type="hidden" name="mobile" class="form-control" value="{$grievances.mobile}" required>

 <input type="submit" name="save" id="save" value="Submit" class="excel_btn btn btn-success"/>
      <input type="reset" name="reset" id="reset" value="Reset" class="print_btn btn btn-danger"/>
	  
</div>





</div>


</form>

</div>

</div>











<div style="padding-left:125px; padding-top:25px; font-size:11px;"></div>


</div>
</div>
<!--<center>
	<INPUT TYPE="BUTTON" VALUE="BACK TO SEARCH SCREEN" ONCLICK="location.href='check_comp_status.php';">
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel">
	<input type='button' value='Print' onclick="print_div()">
</center>-->


</div>
<br />
<br />
<br />



</div>

{literal}

<script language="javascript" type="text/javascript">
	$(document).ready(function() {
  // Initially hide the Sub Options dropdown and set it as optional
  var subOptionsDropdown = $('#grievance_sub_options');
  subOptionsDropdown.hide();
  subOptionsDropdown.prop('required', false);

  // Attach change event handler to the Rating dropdown
  $('#grievance_status_id').change(function() {
    var selectedValues = $(this).val();
    var selectedValuesArray = Array.isArray(selectedValues) ? selectedValues : [selectedValues];

    // Check if any of the selected values are 3, 4, or 5
    var showSubOptions = selectedValuesArray.some(function(value) {
      return value === '1' || value === '2' || value === '3';
    });

    // Show or hide the Sub Options dropdown based on the condition
    if (showSubOptions) {
      subOptionsDropdown.show();
      subOptionsDropdown.prop('required', true);
    } else {
      subOptionsDropdown.hide();
      subOptionsDropdown.prop('required', false);
    }
  });
});
</script>





{/literal}
{include file='footer.tpl'}

{literal}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>-->
<script>
$(function() {
	var dates = $( "#from_date, #to_date" ).datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: "+0",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "from_date" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});
$(function() {
    $( ".datepick" ).datepicker({'maxDate':'0'});
});
</script>

{/literal}