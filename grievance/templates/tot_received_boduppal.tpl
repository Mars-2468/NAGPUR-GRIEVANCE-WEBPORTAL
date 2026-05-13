{include file='boduppal_header.tpl'}
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->



<br><br>
<div class="" style="margin-top: -45px;">
    <form method="POST" class="form-horizontal">

    <div class="boxed">
    <div class="title-bar blue"></div>
    
    <div class="inner no-radius">
<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-6" for="usr">Reference No:</label>
  <div class="col-sm-6">
  <input type="text" class="phone-group form-control demoInputBox"  name="reference_no" value="{$reference_no}">
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
 
  <div class="col-md-1" align="right"><input name="search" type="submit" class="btn btn-success" value="SEARCH"> </div>   
   
   
   </div>
   
   </div>
   
 </form>
 </div>
</br></br></br>





 <div class="boxed">
    <div class="title-bar blue"></div>
    
    <div class="inner no-radius">

<div  id="div_print" style="border:#999999 0px solid;">
<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</strong></CENTER>


    <div style="width:100%; overflow:scroll; font-size:11px;">
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="" id="data-table" width="100%">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">{if $app_type_id eq '1'} Category {else} Department{/if}</th>
		<th align="center" valign="middle"><div style="width: 45px; word-wrap: break-word;">Reference No</div></th>
		<th align="center" valign="middle">e-office No</th>
		<th align="center" valign="middle">Name</th>
		<th align="center" valign="middle">Mobile</th>
		<th align="center" valign="middle">
		 <div style="width: 55px; word-wrap: break-word;"> Address </div>
		    </th>	
		<th align="center" valign="middle">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} Details</th>		
		<th align="center" valign="middle">Status</th>
		<th align="center" valign="middle">Received Date</th>
		<th align="center" valign="middle">Cutt of Date</th>
		<th align="center" valign="middle">Employee name & mobile</th>
		<th align="center" valign="middle">Department</th>
		<th align="center" valign="middle">No.of Holidays added</th>
		<th align="center" valign="middle">No.of Disposable days</th>
		<th align="center" valign="middle">To be completed date</th>
		<th align="center" valign="middle">Completed Date</th>
		<th align="center" valign="middle">No.of days exceeded</th>
		
		<th align="center" valign="middle" colspan="1">Actions</th>	
		<th></th>
	    </tr>
	    </thead>
		<tbody style="background-color:#FFF;">
		{foreach from=$data key=grievance_id item=row}
		<tr>
			<td>{counter}</td>
			
			{if $row.app_type_id eq '1'}
            <td ><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
            {else}
            <td ><label title="{$row.comp_desc}">{$dept_list[$row.section_id]}</label></td>
            {/if}
			<!--<td>{$dept_list[$row.dept_id]}</td>-->
			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
			<td align="center">{$row.eoffice_no}</td>
			<td>{$row.person_name}</td>
			<td>{$row.mobile}</td>
			
			<td>{$row.hno},{$row.address}</td>
			{if $row.app_type_id eq '1'}
			<td>{$cs_list[$row.cat3_id]}</td>
			{else}
			<td>{$cs_list[$row.mcat3_id]}</td>
			{/if}
			
			<td>{$grievance_status_list[$row.grievance_status_id]}</td>
			<!--<td>{$row.date_regd|date_format:"%d-%m-%Y %H:%M:%S"}</td>
			<td>{$row.cutt_of_date|date_format:"%d-%m-%Y %H:%M:%S"}</td>
			<td>{$row.disposed_date|date_format:"%d-%m-%Y"}</td>
			<td>{$row.num_days_exceeded}</td>-->
			
			<td>{$row.date_regd|date_format:"%d-%m-%Y"}</td>
			
			
           		
			
			{if $row.comp_date eq '1970-01-01 00:00:00'}
			<td>-</td>
	        {else}
			<td>{$row.comp_date|date_format:"%d-%m-%Y"}</td>
			{/if}
			<td>{$emp_list[$row.emp_id]}</td>
			<td>{$dept_list1[$row.dept_id]}</td>
			<td>{$row.holidays_added}</td>
			<td>{$row.target_days}</td>
			<td>{$row.comp_date|date_format:"%d-%m-%Y"}</td>
			<td>{$row.disposed_date|date_format:"%d-%m-%Y"}</td>
			<td>{$row.no_of_days_exeed}</td>
			
		
		
			
			
			<td>
			{if $row.grievance_status_id eq '2'}
			
			
			<form action="manage_comp_sel.php" method="post">
			    <input type="hidden" name="grievance_id" value="{$grievance_id}">
			    <input type="submit" name="update" value="Update">
			</form>
	
			
			{/if}
			
			{if $row.grievance_status_id eq '1'}
			
			
			<form action="view_pending_approval.php" method="post">
			    <input type="hidden" name="grievance_id" value="{$grievance_id}">
			    <input type="submit" name="update" value="Assign to employee">
			</form>
	
			
			{/if}
		
			</td>
		</tr>
		{/foreach}
		</tbody>
	    
	  </table>
	  
 </div>

</div>


</div>
</div>
</div>

{include file='footer_print.tpl'}
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

<div style="width:100%; text-align:center">
    
    
    <form action="exporttoexcel.php" method="post">



<input type="submit" name="excel" value="export All excel" class="btn btn-warning">
</form>
    
</div>
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