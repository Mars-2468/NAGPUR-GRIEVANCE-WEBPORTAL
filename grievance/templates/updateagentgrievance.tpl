{include file='header.tpl'}
{literal}
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">

<style>
    
    textarea
    {
        
        resize:none;
        
    }
    
</style>

<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script language="javascript">




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
			var j=strArray.length;
			for(i=0;i<j;i++)
			{
				var optArray=strArray[i].split(":::");
				select.options[select.options.length] = new Option(optArray[1],optArray[0]);
			}
			select1.options[select1.options.length] = new Option('Select Employee','0');
		}
	}
	
	xmlhttp.open("GET","get_designations.php?dept_id="+dept_id,true);
	xmlhttp.send();

}




function validateForm()
{

	var disposed_date=document.update_comp.disposed_date.value;
	var disposal_status_value=$("#disposal_status").val();
	var cat3_id = $("#cat3_id").val();
	var arr = [ 105,106,107,108,109,110,111,112,113,114,115,116,117,119,120,121,122,123,124,125,126,127,128 ];
	var fileToUpload = $('#fileToUpload').val();
	
	
	if(disposal_status=='0')
	{
		alert("Please Select Disposal Status");
		return false;
	}
    

		if((disposed_date=='')||(disposed_date=='0000-00-00'))
		{
			alert("Please Enter Disposal Date");
			return false;
		}
	
   
	if(disposal_status_value=='5')
	{
		var emp_dept_value=$("#emp_dept").val();
		var emp_desg_value=$("#emp_desg").val();
		var emp_id_value=$("#emp_id").val();
		if((emp_dept_value=='0')||(emp_desg_value=='0')||(emp_id_value=='0'))
		{
			alert("Please Select Employee to Whom Transferred");
			return false;
		}
	}
	
    
	if(cat3_id=='106' || cat3_id== '107' || cat3_id==108 || cat3_id==109 || cat3_id==110 || cat3_id==111 || cat3_id==112 || cat3_id==113 || cat3_id==114 || cat3_id==115 || cat3_id==116 || cat3_id==117 || cat3_id==119 || cat3_id==120 || cat3_id==121 || cat3_id==122 || cat3_id==123 || cat3_id==124 || cat3_id==125 || cat3_id==126 || cat3_id==127 || cat3_id==128)
	{
	   
	    if(fileToUpload == '')
	    {
	        alert('Upload image');
	        return false;
	    }
	}

		
	return true;
}





function toggle(disposal_status)
{
	var rows = $('table.someclass tr');
	var black = rows.filter('.black');
	if(disposal_status=='5')
		black.show();
	else
	{
		document.update_comp.emp_dept.selectedIndex=0;
		get_det(0);	
		black.hide();
	}
		
}


$(document).ready(function() {
   	var rows = $('table.someclass tr');
	var black = rows.filter('.black');
	black.hide();
});


</script>
<style>
<style>
    .ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
    .ui-timepicker-div dl { text-align: left; }
    .ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
    .ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
    .ui-timepicker-div td { font-size: 90%; }
    .ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
    .ui-timepicker-rtl{ direction: rtl; }
    .ui-timepicker-rtl dl { text-align: right; }
    .ui-timepicker-rtl dl dd { margin: 0 65px 10px 10px; }
    </style>
</style>
{/literal}

{if isset($data1)}
{if isset($msg)}
	<div class="{$class}">
		<button class="close" data-close="alert"></button>
		{$msg}
	</div>
	{/if}
<strong></strong>


<div class="boxed">
    
    <div class="title-bar blue"><h4>Update the Complaint Details</h4></div>
    <div class="inner no-radius">
       
       <div  id='comp_div'>
       <form  method="post" action="updateagentgrievance.php" name="update_comp" id="update_comp" onsubmit="return validateForm()" enctype="multipart/form-data">
<input type='hidden' name='grievance_id' value={$grievance_id}>
<input type='hidden' name='transaction_id' value={$transaction_id}>
<input type='hidden' name='file_no' value={$data1.file_no}>
<input type='hidden' name='app_type_id' value={$data1.app_type_id}>
<input type="hidden" name="cat3_id" value="{$data1.cat3_id}" id="cat3_id">


<div>
<table width="100%" height="35" border="1" cellpadding="0" cellspacing="0" class="someclass table-bordered table-striped table-condensed cf">
  <tr>
	<td align="left" valign="middle"> Date of Grievance: </td>
	<td align="left" valign="middle">{$data1.date_regd|date_format:"%d-%m-%Y"}</td>	
	<td align="left" valign="middle"> </td>
	<td align="left" valign="middle"></td>		
  </tr>
  <tr>
	<td align="left" valign="middle"> Name: </td>
	<td align="left" valign="middle">{$data1.person_name}</td>	
	<td align="left" valign="middle"> Address : </td>
	<td align="left" valign="middle">{$data1.hno} , {$data1.address}</td>		
  </tr>
  <tr>
	<td  align="left" valign="middle"> Ward & Street : </td>
	<td align="left" valign="middle">{$data1.ward_desc} & {$data1.street_desc}</td>	
	<td  align="left" valign="middle"> Mobile: </td>
	<td align="left" valign="middle">{$data1.mobile}</td>		
  </tr>
  <tr>
	<td  align="left" valign="middle"> Subject: </td>
	<td align="left" valign="middle">{$cs_list[$data1.cat3_id]}</td>
	<td  align="left" valign="middle"> Received Through: </td>
	<td align="left" valign="middle">{$grievance_origin_list[$data1.grievance_origin_id]}</td>		
 </tr>
  <tr>
	<td  align="left" valign="middle"> Description: </td>
	<td align="left" valign="middle" style="word-wrap: break-word;"><div style="width:500px;">{$data1.comp_desc}</div></td>
	<td align="left" valign="middle"> Present Status: </td>
	<td align="left" valign="middle"><b>{$grievance_status_list[$data1.grievance_status_id]}</b></td>		
 </tr>
 
 



<tr>
<th colspan='4'>GRIEVANCE MOVEMENT DETAILS</th>
</tr>

 
{foreach from=$data2 key=transaction_id item=row}
<tr>
	<td  align="left" valign="middle"> Allotted to: </td>
	<td align="left" valign="middle" colspan="3">
		{$row.emp_name} ({$row.emp_mobile}) , {$row.emp_desg} , {$row.emp_dept}
	</td>

</tr>
{if $row.grievance_status_id eq '3' || $row.grievance_status_id eq '8' || $row.grievance_status_id eq '9'}
  <tr>	

	<td  align="left" valign="middle"> Allotted on: </td>
	<td align="left" valign="middle">
		{$row.alloted_date|date_format:"%d-%m-%Y"}
	</td>

	<td  align="left" valign="middle"> Disposal Status: </td>
	<td align="left" valign="middle">
		{$grievance_status_list2[$row.disposal_status]}
	</td>		
</tr>

 <tr>	
	<td  align="left" valign="middle"> Disposed on: </td>
	<td align="left" valign="middle">
	{$row.disposed_date|date_format:"%d-%m-%Y"}
	</td>
	<td  align="left" valign="middle"> Remarks: </td>
	<td align="left" valign="middle">
	{$row.disposal_remarks}
	</td>
</tr> 

  <tr>	

	<td  align="left" valign="middle"> Rating: </td>
	<td align="left" valign="middle">
		<select name='disposal_status' id='disposal_status' onchange="calcrate(this.value);">
			<option value='0'>--Select Status--</option>
			{html_options options=$rating_status_list}
		</select>
	</td>

	<td  align="left" valign="middle"> Feedback sub options: </td>
	<td align="left" valign="middle">
		<select name='rating_sub_options' id='rating_sub_options' style="display:none;">
			<option value='0'>--Select Status--</option>
			{html_options options=$rating_suboptions_list}
		</select>
	</td>	
	
</tr>


 <tr style="display:none;" id="reopndarea">	
	<td  align="left" valign="middle"> Re-open on: </td>
	<td align="left" valign="middle">
	<input type="text" name="disposed_date" value=""   class="form-control input-medium" id="datepicker">
	</td>
	
	<td  align="left" valign="middle"> Remarks: </td>
	<td align="left" valign="middle">
	<textarea  name="disposal_remarks" style="width:300px;height:100px;" required>{$row.disposal_remarks}</textarea>
	</td>
</tr> 



{/if}

{/foreach}


 

 
 <tr>
	<td bgcolor='#aeeff0' align="center" valign="middle" colspan='4'>
		<input type='submit' name='save' value='Save Details' class="btn btn-success" >
		<a href="manage_comp.php" class="btn btn-info"><i class="fa fa-backward"></i> Back</a>
	</td>
	
	
	
	
 </tr>  
</table> 
</div>
</form> 

</div>
        
    </div>

</div>

<div style="border:#999999 0px solid; height:400px; margin-top:5px;">
    
    

</div>
{/if}
<div>
</div>
{include file='footer.tpl'}
{literal}
<script type="text/javascript" src="minjs/jquery.min.js"></script>
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>-->
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script>
    function calcrate(rate)
    {
        $("#rating_sub_options").hide();
        $("#reopndarea").hide();
        if(rate <= 3)
        {
            $("#rating_sub_options").show(); 
            $("#reopndarea").show();
        }
    }
</script>

<script>
$(function() {
    $( "#datepicker" ).datepicker({
        format:'dd-MM-yyyy',
    changeMonth: true,
    changeYear: true,'maxDate':'0'});
});

$(document).ready(function() {       
    $('#fileToUpload').bind('change', function() {
        var a=(this.files[0].size);
        //alert(a);
        if(a > 20000000) {
            alert('large');
        };
    });
});
</script>


 
{/literal}