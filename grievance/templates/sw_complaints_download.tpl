{include file='header.tpl'}

<br><br>
<div class="" style="margin-top: -45px;">
    
    
    <div class="boxed">
        <div class="title-bar blue"><h4></h4></div>
        <div class="inner no-radius">
            
            <form method="POST" class="form-horizontal">
        
        
        
        
        



</br></br>


    <div style="width:100%;  margin-top:40px;">
	    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<!--<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">Person name</th>
		<th align="center" valign="middle">Mobile</th>
		<th align="center" valign="middle">Generic id</th>	
		<th align="center" valign="middle">Complaint registered date</th>		
		<th align="center" valign="middle">Complaint closed date</th>-->
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">Applicant name</th>
		<th align="center" valign="middle">Mobile Number</th>
		<th align="center" valign="middle">Generic ID</th>	
		<th align="center" valign="middle">Complaint Registered Date</th>	
			
	    </tr>
	    </thead>
	
		<tbody>
		{foreach from=$data key=generic_id item=row}
		<tr>
			<td>{counter}</td>
			<td>{$row.applicant_name}</td>
			<td>{$row.phone}</td>
			<td>{$row.generic_id}</td>
			<td>{$row.date_regd}</td>
		
		</tr>
		{/foreach}
		</tbody>
			<!--<tbody>
		{foreach from=$data key=grievance_id item=row}
		<tr>
			<td>{counter}</td>
			<td>{$row.person_name}</td>
			<td>{$row.mobile}</td>
			<td>{$row.generic_id}</td>
			<td>{$row.date_regd}</td>
			<td>{$row.sw_resolved_date}</td>
		
		</tr>
		{/foreach}
		</tbody>-->
	    
	  </table>
 </div>

</div>
            
            
            
            
            
        </div>
        
    </div>
    
    
    
 
 
 
 </div>






<!--<div align="right"><a href="#" ><button class="btn btn-warning" onclick="history.go(-1);"><i class="fa fa-backward"></i> Back</button></a></div>-->





{include file='footer_print.tpl'}

<div style="width:100%; text-align:center">
    
    
    <form action="exporttoexcel.php" method="post">
<input type="hidden" name="app_type_id" value="{$app_type_id}"> 
<input type="hidden" name="emp_id" value="{$emp_id}">
<input type="hidden" name="status" value="{$status}">
<input type="hidden" name="dept_id" value="{$dept_id}">


<input type="submit" name="excel" value="export All excel" class="btn btn-warning">
</form>
    
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

















