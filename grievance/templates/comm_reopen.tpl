{include file='header.tpl'}
{literal}
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<script>

function getcheckedvaues()
{
    
    $(".combo").removeClass('combo').css('background-color','#ffff');
    $(".mytext").removeClass('mytext').css('background-color','#ffff');
    
    
    $("input:checkbox[class=chk]:checked").each(function () {
            var value = $(this).val();
            $("#sub_option_id" + value).addClass('combo');
            $("#comment_desc" + value).addClass('mytext');
        });
        
        //return false;
        
       errors=validateForm();
       
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
    
function validateForm()
{
errors=0;

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
	
	return errors;
		
    	

}
</script>

{/literal}


<br><br>
<div class="" style="margin-top: -45px;">
    

<!--
<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-6" for="usr">Reference No:</label>
  <div class="col-sm-6">
  <input type="text" class="phone-group form-control demoInputBox"  name="reference_no" value="{$reference_no}">
  </div>
</div>
</div>

--->
<form action="comm_reopen.php" method="post">
<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr"> Refernece no </label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control"  name="ref_no" value="{$refno_sel}">
  </div>
</div>
</div>  

<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr">From Date:</label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control datepicker"  name="f_date" value="{$fdate}">
  </div>
</div>
</div>      


<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr">To Date:</label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control datepicker"  name="t_date" value="{$tdate}">
  </div>
</div>
</div>  
 
  <div class="col-md-4" align="right"><input name="search" type="submit" class="btn btn-success" value="SEARCH"> </div>   
   
 </form>
 </div>
</br></br></br></br></br></br>




<div  id="div_print" style="border:#999999 0px solid;">
<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</strong></CENTER>


    <div style="width:100%; overflow:scroll;">
        <form action="comm_reopen.php" method="post" onsubmit="return getcheckedvaues()">
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
	    <th align="center" valign="middle">Select</th>
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">{if $app_type_id eq '1'} Category {else} Department{/if}</th>
		<th align="center" valign="middle">Reference No</th>
		<th align="center" valign="middle">e-office No</th>
		<th align="center" valign="middle">Name & Mobile</th>
		<th align="center" valign="middle">Adress</th>	
		<th align="center" valign="middle">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} Details</th>		
		<th align="center" valign="middle">Status</th>
		<th align="center" valign="middle">Received Date</th>
		<th align="center" valign="middle">Cutt of Date</th>
		<th align="center" valign="middle">Employee name & mobile</th>
		<th align="center" valign="middle">No.of Holidays added</th>
		<th align="center" valign="middle">No.of Disposable days</th>
		<th align="center" valign="middle">To be completed date</th>
		<th align="center" valign="middle">Completed Date</th>
		<th align="center" valign="middle">No.of days exceeded</th>
	    <th>Action</th>
	    <th></th>
	    </tr>
	    </thead>
		<tbody>
		    {assign var="i" value=0}
		{foreach from=$data key=grievance_id item=row}
		<tr>
		    <td><input type="checkbox" name="check_list[]" value="{$i}" class="chk" id="{'id'|cat:$i}"></td>
			<td>{counter}</td>
			
			{if $row.app_type_id eq '1'}
            <td ><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
            {else}
            <td ><label title="{$row.comp_desc}">{$dept_list[$row.dept_id]}</label></td>
            {/if}
			<!--<td>{$dept_list[$row.dept_id]}</td>-->
			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
			<td align="center">{$row.eoffice_no}</td>
			<td>{$row.person_name} ({$row.mobile})</td>
			
			<td>{$row.hno},{$row.address}</td>
			<td>{$cs_list[$row.cat3_id]}</td>
			
			<td>{$grievance_status_list[$row.grievance_status_id]}</td>
			
			
			<td>{$row.date_regd|date_format:"%d-%m-%Y"}</td>
			
			
           		
			
			{if $row.comp_date eq '1970-01-01 00:00:00'}
			<td>-</td>
	        {else}
			<td>{$row.comp_date|date_format:"%d-%m-%Y"}</td>
			{/if}
			<td>{$emp_list[$row.emp_id]}</td>
			<td>{$row.holidays_added}</td>
			<td>{$row.target_days}</td>
			<td>{$row.comp_date|date_format:"%d-%m-%Y"}</td>
			<td>{$row.disposed_date|date_format:"%d-%m-%Y"}</td>
			<td>{$row.no_of_days_exeed}</td>
			<td>
			
			
			
			
			    <input type="hidden" name="{'generic_id'|cat:$i}" value="{$grievance_id}">
			    <input type="hidden" name="{'ulbid'|cat:$i}" value="{$row.ulbid}">
			    <input type="hidden" name="{'imei_no'|cat:$i}" value="{$uid}">
			    <input type="hidden" name="{'rating_no'|cat:$i}" value="3">
			    
			    select rating : <select name="{'sub_option_id'|cat:$i}" id="{'sub_option_id'|cat:$i}" class="">
			        <option value="0">---select---</option>
			        {html_options options=$sub_option_list}
			    </select>
			    
			
			</td>
			<td>
			    Remarks :  <textarea name="{'comment_desc'|cat:$i}" id="{'comment_desc'|cat:$i}"></textarea>
			</td>
		</tr>
		{assign var="i" value=$i+1}
		{/foreach}
		</tbody>
	    
	  </table>
	  <input type="submit" name="update" value="Reopen All" class="btn btn-success">
	  </form>
	  
	  
 </div>

</div>


<!--<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>-->

{literal}






<style>
div.pagination {
	padding: 3px;
	margin: 3px;
}

div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	
	text-decoration: none; /* no underline */
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #000099;

	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
		border: 1px solid #000099;
		
		font-weight: bold;
		background-color: #000099;
		color: #FFF;
	}
	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;
	
		color: #DDD;
	}
	
</style>





{/literal}

<center>
<div id="pagination" class="pagination" align="center">{$pagination}</div>
</center>
<br>
{include file='footer.tpl'}



<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script>
$(function() {
    $( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>