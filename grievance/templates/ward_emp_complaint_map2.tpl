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
                
			
			
			<form   method="post" action="ward_emp_complaint_map.php" name="manage_wards"  id="manage_wards" class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
				
				
	<select class="form-control" name="cs_id" id="cs_id">
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
	
	
   
						<button type="submit" class="btn btn-info">Get data</button>
						
				
				
		{if isset($cs_id_sel)}		
	<table class="table">
	<thead>
		<tr>
		<th> ward  </th>
		
		</tr>
	</thead>
	<form   method="post" action="ward_emp_complaint_map2.php" name="manage_wards"  id="manage_wards" class="form-horizontal" onSubmit="return validateForm()">
	<input type="hidden" name="dept_id_sel" value="{$dept_id_sel}">
	<input type="hidden" name="emp_id_sel" value="{$emp_id_sel}">
	<input type="hidden" name="cs_id_sel" value="{$cs_id_sel}">
	<input type="hidden" name="emp_id2_sel" value="{$emp_id2_sel}">
	{assign var="i" value="0"}
	{foreach from=$ward_list item=row key=ward_id}
	
	<tr>
	<td>
	
	
	{$ward_list[$ward_id]}<input type="checkbox" name="{'check'|cat:$i}" value="1" {if $data[$ward_id].flag eq '1'} checked {/if}>
	
	<input type="hidden" name="{'ward_id'|cat:$i}" value="{$ward_id}" >
	
	</td>
	
	</tr>
	{assign var="i" value=$i+1}
	{/foreach}
	
	<input type="hidden" name="file_count" value="{$i}">
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

