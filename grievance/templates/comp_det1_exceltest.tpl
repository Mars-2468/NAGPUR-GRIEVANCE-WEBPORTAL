{include file='header.tpl'}

<br><br>
<div class="" style="margin-top: -45px;">
    <form method="POST" class="form-horizontal">

<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-6" for="usr">Reference No:</label>
  <div class="col-sm-6">
  <input type="text" class="phone-group form-control demoInputBox"  name="reference_no" value="{$reference_no}">
  </div>
</div>
</div>
<!--
<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr">Mobile No:</label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control demoInputBox"  name="mobile" value="{$mobile}">
  </div>
</div>
</div>
-->

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
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">Reference No</th>
		<th align="center" valign="middle">Name & Mobile</th>
		<th align="center" valign="middle">Adress</th>	
		<th align="center" valign="middle">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} Details</th>		
		<th align="center" valign="middle">Status</th>
		<th align="center" valign="middle">Received Date</th>
	    <th align="center" valign="middle" colspan="2">Actions</th>		
	    </tr>
	    </thead>
		<tbody>
		{foreach from=$data key=grievance_id item=row}
		<tr>
			<td>{counter}</td>
			
		
			<!--<td>{$dept_list[$row.dept_id]}</td>-->
			<td align="center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
			<td>{$row.person_name} ({$row.mobile})</td>
			
			<td>{$row.hno},{$row.address}</td>
			<td>{$cs_list[$row.cat3_id]} {if $app_type_id eq '1'} - {$row.comp_desc} {/if}</td>
			
			<td>{$status_list[$row.grievance_status_id]}</td>
			<td>{$row.date_regd|date_format:"%d-%m-%Y %H:%M:%S"}</td>
			
			
			
			
		
			<td>
			{if $ulbid eq '207'}
			{if $row.app_type_id eq '2'}
			<a href="receive_print_boduppal.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
			{else}
			<a href="receive_print_boduppal.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
			{/if}
			
			{else}
			{if $row.app_type_id eq '2'}
			<a href="receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
			{else}
			<a href="receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
			{/if}
			{/if}
			
			{if $row.grievance_status_id eq '2'}
			
			
			<form action="manage_comp_sel.php" method="post">
			    <input type="hidden" name="grievance_id" value="{$grievance_id}">
			    <input type="submit" name="update" value="Update">
			</form>
	
			
			{/if}
		
			</td>
		</tr>
		{/foreach}
		</tbody>
	    
	  </table>
 </div>

</div>
<form action="exporttoexcel.php" method="post">
<input type="hidden" name="app_type_id" value="{$app_type_id}"> 
<input type="hidden" name="emp_id" value="{$emp_id}">
<input type="hidden" name="status" value="{$status}">
<input type="hidden" name="dept_id" value="{$dept_id}">


<input type="submit" name="excel" value="export to excel">
</form>
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


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script>
$(function() {
    $( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>

















