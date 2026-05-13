{include file='header.tpl'}
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->




<br><br>
<div class="" style="margin-top: -45px;">
    <form method="POST" class="form-horizontal" action="period_rep.php">

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


<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr"> Select Type </label>
  <div class="col-sm-7">
  <select name="app_type_id" id="app_type_id">
      <option value="">---select---</option>
      {html_options options=$app_type_list selected=$app_type_sel}
      
  </select>
  </div>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr"> Select Status </label>
  <div class="col-sm-7">
  <select name="status" id="status">
      <option value="">---select---</option>
      {html_options options=$grievance_status_list selected=$status_sel}
      
  </select>
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


{if isset($data)}

<div  id="div_print" style="border:#999999 0px solid;">
<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</strong></CENTER>
<center><!--Total Records :--> {$total_recordss}</center>


    <div style="width:100%; overflow:scroll;">
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">Complaint / Service name</th>
		<th align="center" valign="middle">Reference No</th>
		<th align="center" valign="middle">e-office No</th>
		<th align="center" valign="middle">Name & Mobile</th>
		<th align="center" valign="middle">Adress</th>	
		<th align="center" valign="middle">Complaint Description</th>		
		<th align="center" valign="middle">Status</th>
		<th align="center" valign="middle">Received Date</th>
		<th align="center" valign="middle">Completed Date</th>
		<th align="center" valign="middle">No.of Days to Complete</th>
	</tr>
	    </thead>
		<tbody>
		{foreach from=$data key=grievance_id item=row}
		<tr>
			<td>{counter}</td>
			
			{if $row.app_type_id eq '1'}
            <td ><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
            {else}
            <td ><label title="{$row.comp_desc}">{$service_list[$row.cat3_id]}</label></td>
            {/if}
			<!--<td>{$dept_list[$row.dept_id]}</td>-->
			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
			<td align="center">{$row.eoffice_no}</td>
			<td>{$row.person_name} ({$row.mobile})</td>
			<td>{$row.hno},{$row.address}</td>
			<td>{$row.comp_desc}</td>
			<td>{$grievance_status_list[$row.grievance_status_id]}</td>
		    <td>{$row.date_regd|date_format:"%d-%m-%Y %H:%M:%S"}</td>
			<td>{if $row.grievance_status_id neq '2' }{$row.disposed_date|date_format:"%d-%m-%Y %H:%M:%S"}{/if}</td>
			<td>{if $row.grievance_status_id neq '1' || $row.grievance_status_id neq '2'}{$row.target}{/if}</td>
			
			</tr>
		{/foreach}
		</tbody>
	    
	  </table>
	  
 </div>

</div>

{include file='footer_print.tpl'}
{/if}
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