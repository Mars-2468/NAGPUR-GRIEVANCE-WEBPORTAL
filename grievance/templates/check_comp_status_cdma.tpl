
	
	{literal}
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>-->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">



<script language='javascript'>
function getward(ulbid){
         //alert(ulbid);
        $.post("ajax_get_wards.php",{ulbid:ulbid},function(data)
	  {
	   	//alert(data);
			
	   	$("#ward_id").html(data);
	   
	  })
      }
function get_streets(ward_id){
         //alert(ward_id);
          $.post("ajax_getstreets.php",{ward_id:ward_id},function(data)
	  {
	   	//alert(data);
			
	   	$("#street_id2").html(data);
	  
	  })
       
      }

/*function get_streets(ward_id)
{
    //alert(ward_id);
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
*/


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


</script>

<link rel="stylesheet" href="../css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>

table tr:nth-child(odd) {
 background-color: #f1f1f1;
}
table tr:nth-child(even) {
 background-color: #ffffff;
}
</style>

{/literal}




<div >

<div >


<div class="row" style="background-color:#0b1c40;">
<div class="container">
<center>
<div style="font-size:25px;">
   
<strong>Commissioner Director of Municipal Administration </strong></div> 
<div style="margin-bottom:15px;">Government of Telangana</div>
</center>
</div>
<div style="background-color:#0066CC; color:#FFF; padding:5px; text-align:center; font-size:15px;"><strong>Search Complaint </strong></div>
</div>



<div id="area" class="container" >
<div >
<form name='check_comp_status' method='POST' action='check_comp_status_cdma.php' onSubmit="return validateForm();" >
<input type="hidden" name="ulbid" value="{$ulbid}">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="background-color:#FFF;">
    <td height="28" align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>

{if isset($data)}
 <tr >
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    
    <table  id='example' width="100%" border="1" cellpadding="0" cellspacing="0"  class="table">
    
  <tr style="background-color:#3366CC; color:#FFF; font-size:13px;">
    <th align="center" valign="middle" scope="col" style="width:40px;">S.No</th>
    <th align="center" valign="middle" scope="col" style="width:100px;">Complaint No</th>
    <th align="center" valign="middle" scope="col" style="width:120px;">Name &amp; Mobile</th>
    <th align="center" valign="middle" scope="col" style="width:150px;">Address</th>
    <th align="center" valign="middle" scope="col" style="width:300px;"><div style="width:300px;">Complaint Details</div></th>
    <th align="center" valign="middle" scope="col" style="width:100px;">Status</th>
  </tr>
  {foreach from=$data key=grievance_id item=row}
  <tr >
    <td align="center" valign="middle" style="width:40px;">{counter}</td>
    <td align="center" valign="middle" style="width:100px; word-wrap:break-word;"><a href="view_comp_det.php?grievance_id={$grievance_id}&id={$ulbid}" style="color:#FF6600;">{$grievance_id}</a></td>
    <td align="center" valign="middle" style="width:120px; word-wrap:break-word;">{$row.person_name} ({$row.mobile})</td>
    <td align="center" valign="middle" style="width:150px; word-wrap:break-word;"><div style="width:150px; padding:0px 5px 0px 5px;">{$row.hno},{$row.address}</div></td>
    <td align="center" valign="middle" style="width:300px; word-wrap:break-word; text-align:justify; padding:0px 10px 0px 10px;">
    <div style="width:300px; word-wrap:break-word;">{if $row.comp_desc eq ''}
    N/A.{elseif $row.comp_desc neq ''}{$row.comp_desc}{/if}
    </div>
    </td>
    <td align="center" valign="middle" style="width:100px; word-wrap:break-word;">{$grievance_status_list[$row.grievance_status_id]}</td>
  </tr>
  {/foreach}
</table>
<br />

    
	    
  </td>
    <td align="left" valign="top">&nbsp;</td>
 </tr>
 
{else} 
  <tr >
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    <br>
    <table width="97%" border="0" cellspacing="5" cellpadding="0" class="table-bordered table-striped table-condensed cf">
      <tr  >
        <td width="15%" height="24" align="left" valign="middle">Name</td>
	<td width="3%" align="left" valign="middle">:</td>	
        <td width="24%" align="left" valign="middle"><input type="text" name="person_name" id="person_name" class="form-control"/></td>
        <td width="23%" height="24" align="right" valign="middle">Mobile No </td>
	<td width="3%" align="left" valign="middle">:</td>	
        <td width="32%" align="left" valign="middle"><input type="text" name="mobile" class="form-control"/></td>
    </tr>
      <tr  >
        <td height="24" align="left" valign="middle">ULB</td>
        <td align="left" valign="middle">:</td>
        <td align="left" valign="middle">
            <select name="ulbid" id="ulbid" class="form-control"  onchange="getward(this.value)" style="width: 100%;">
          <option value='%'>-All-</option>
          
	{html_options options=$ulb_list}
 	</select></td>
 	
        <td height="24" align="right" valign="middle">Ward</td>
        <td align="left" valign="middle">:</td>
        <td align="left" valign="middle">
            <select name="ward_id" id="ward_id" class="form-control"  onchange="get_streets(this.value)" style="width: 100%;">
          <option value='%'>-All-</option>
          
          
	{html_options options=$ward_list}
 	
        
        </select></td>
      </tr>
 
    <tr  >

	<!--<td width="27%" height="26" align="left" valign="middle">Ward Number</td>
	<td align="left" valign="middle">:</td>	
         <td align="left" valign="middle">
		<select name="ward_id" id="ward_id" onchange="get_streets(this.value)">
			<option value='%'>-All-</option>
			{html_options options=$ward_list}
		</select>
	</td>	-->
	
   <td height="33" align="left" valign="middle">Street</td>
	<td align="left" valign="middle">:</td>	
         <td align="left" valign="middle"><select name="street_id2" id="street_id2" class="form-control" style="width: 100%;">
           <option value='%'>-All-</option>
           
          
	{html_options options=$street_list}
 	
        
         </select></td>
  
		
    </tr>
  
  <tr  >
        <td width="15%" height="24" align="left" valign="middle">Period From</td>
	<td align="left" valign="middle">:</td>	
        <td align="left" valign="middle"><input type="text" name="from_date" id="from_date" readonly="readonly" class="datepick form-control"></td>
        <td width="23%" height="24" align="right" valign="middle">Period To</td>
	<td align="left" valign="middle">:</td>	
        <td align="left" valign="middle"><input type="text" name="to_date" id="to_date" readonly="readonly" class="datepick form-control"></td>
    </tr>
 
  <tr  >
        <td width="15%" height="24" align="left" valign="middle">Reference No:</td>
	<td align="left" valign="middle">:</td>	
        <td align="left" valign="middle"><input type="text" name="grievance_id" class="form-control"></td>
        <td width="23%" height="24" align="right" valign="middle">Status</td>
	<td align="left" valign="middle">:</td>	
         <td align="left" valign="middle">
		<select name="grievance_status_id" id="grievance_status_id" class="form-control">
			<option value='%'>-All-</option>
			{html_options options=$grievance_status_list}
		</select>	</td>	
    </tr> 
 </table></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr style="background-color:#FFF;">
    <td align="left" valign="top">&nbsp;</td>
    <td colspan="2" align="center" valign="top" >
    <br>

    <input type="submit" name="save" id="save" value="Submit" class="excel_btn btn btn-success"/>
      <input type="reset" name="reset" id="reset" value="Reset" class="print_btn btn btn-danger"/>
      
      </td>
    <td align="left" valign="top">&nbsp;</td>
   
  </tr>
{/if} 
</table>

</form>

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
	var table2_Props = 	{
							col_0: "none",
							col_1: "none",
							col_2: "none",
							col_3: "none",
							col_4: "none",
							col_5: "none",
							col_6: "none",
							col_7: "none",
							display_all_text: " [ Show all ] ",
							sort_select: true ,
							paging: true ,
							paging_length:5,
							alternate_rows: false
						};
	setFilterGrid( "example",table2_Props );

</script>

<script>
     
      


{/literal}
{include file='footer.tpl'}

{literal}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
<script>
$(function() {
    $( ".datepick" ).datepicker({'maxDate':'0'});
});
</script>

{/literal}
	