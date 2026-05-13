{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->


<script>
function getdesig(dept_id,i)
{
 

 $.post("getdesig.php",{dept_id:dept_id},function(data)
  {
    
	var arr=data.split("::");	
   $("#desg_id" + i).html(arr[0]);
  
   
   
  })
}
function fun1()
{
alert();
$("#manage_wards").submit();
}
function get_employees(dept_id)
{
	
	
	$.post("ajax_get_employees2.php",{dept_id:dept_id},function(data)
	  {
	   	
			
	   	$("#emp_id").html(data);
	   	$("#emp_id2").html(data);
	   	
	   	
	  
	   
	   
	  })
	
}
</script>
{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Employee Complaint Map</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                
                <a href="http://www.municipalservices.in/complaint_emp_map_report.php" target="_blank"> Employee Complaint Map Report</a>
                
			
			
			<form   method="post" action="ward_emp_complaint_map_new.php" name="manage_wards"  id="manage_wards" class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
				
				
	<select class="form-control" name="cs_id[]" id="cs_id" multiple="multiple" size="10" class="form-control" style="width:300px" >
	<option value="0">---Complaint---</option>
	{html_options options=$cs_list selected=$cs_id_sel}
	
	</select>
	
	<select class="form-control" name="dept_id" id="dept_id" onchange="get_employees(this.value)">
	<option value="0">---Department---</option>
	{html_options options=$dept_list selected=$dept_id_sel}
	
	</select>
	
	<select class="form-control" name="emp_id" id="emp_id">
	<option value="0">---Assigned Employee---</option>
	{html_options options=$emp_list selected=$emp_id_sel}
	</select>
	
	<select class="form-control" name="emp_id2" id="emp_id2">
	<option value="0">---Responsible officer---</option>
	{html_options options=$emp_list selected=$emp_id2_sel}
	</select>
	
	
   
						<button type="submit" name="submit" class="btn btn-info">Get data</button>
						</form>
						
				
				
		{if isset($cs_id_sel)}	


<br>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Ward</th>
				<th>Department</th>
				<th>Assigned Employee</th>
				<th>Responsible Officer</th>
				
			</tr>
		</thead>
		{foreach from=$cs_list item=row2 key=cs_id}
		{foreach from=$ward_list2 item=row3 key=$ward_id2}
			<tr>
				<th>{$ward_list2[$ward_id2]}</th>
				<th>{$data2[$ward_id2][$cs_id].dept_id}</th>
				<th>{$data2[$ward_id2][$cs_id].emp_id}</th>
				<th>{$data2[$ward_id2][$cs_id].emp_id2}</th>
				
			</tr>
		{/foreach}
		{/foreach}
	
	</table>



		
	<table class="table">
	<thead>
		<tr>
		<th> ward  </th>
		
		</tr>
	</thead>
	<form   method="post" action="ward_emp_complaint_map_new.php" name="manage_wards"  id="manage_wards" onSubmit="return validateForm()">
	<input type="hidden" name="dept_id_sel" value="{$dept_id_sel}">
	<input type="hidden" name="emp_id_sel" value="{$emp_id_sel}">
	<input type="hidden" name="cs_id_sel" value="{$cs_id_sel}">
	<input type="hidden" name="emp_id2_sel" value="{$emp_id2_sel}">
	{assign var="i" value="0"}
	{assign var="j" value="0"}
	{foreach from=$ward_list item=row key=ward_id}
	
	<tr>
	<td>
	
	
	{$ward_list[$ward_id]}<input type="checkbox" name="{'ward_id'|cat:$i}" value="{$ward_id}">
	
	
	
	</td>
	
	</tr>
	{assign var="i" value=$i+1}
	{/foreach}
	
	<input type="hidden" name="file_count" value="{$i}">
	{foreach from=$data item=row key=cs_id}
	<input type="hidden" name="{'cs_id'|cat:$j}" value="{$data[$j]}">
	{assign var="j" value=$j+1}
	{/foreach}
	<input type="hidden" name="cs_count" value="{$j}">
	<tr>
    <td colspan="3">
	
			<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
						<button type="submit" class="btn btn-info" name='save'>Submit</button>
						<button type="button" class="btn btn-danger">Cancel</button>
						</div>
					</div>		
					</td>
                
                    
                    </tr>
					
	
			</table>	
			</form>
		</div>
		</div>
	</div>
</div>
{/if}









{include file='footer.tpl'}

