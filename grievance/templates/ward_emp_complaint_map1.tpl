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
function get_employees(desg_id,i)
{
	
	var dept_id=$("#dept_id" +i ).val();
	$.post("ajax_get_employees.php",{dept_id:dept_id,desg_id:desg_id},function(data)
	  {
	   	
		var arr=data.split("::");	
	   	$("#emp_id" + i).html(arr[0]);
	   	$("#emp2_id" + i).html(arr[1]);
	   	
	  
	   
	   
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
                
			
			
			<form   method="post" action="ward_emp_complaint_map1.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
	<table class="table">
	<thead>
		<tr>
		<th> ward  </th>
		<th> Department </th>
		<th> Complaint  </th>
		
		<th> Designation </th>
		<th> Assign Employee</th>
		<th> Assign Responsible officer</th>
		</tr>
	</thead>
	
	
	{assign var="i" value="0"}
	{foreach from=$ward_list item=row key=ward_id}
	
	<tr>
	<td>
	
	
	{$ward_list[$ward_id]}
	
	<input type="hidden" name="{'ward_id'|cat:$i}" id="{'ward_id'|cat:$i}" value="{$ward_id}">
	</td>
	<td>
	<select class="form-control" onchange="getdesig(this.value,'{$i}');" name="{'dept_id'|cat:$i}" id="{'dept_id'|cat:$i}">
	<option value="0">---Department---</option>
	{html_options options=$dept_list selected=$map_list[$ward_id].dept_id}
	
	</select>
	</td>
	
	<td>
	<select class="form-control" name="{'cs_id'|cat:$i}" id="{'cs_id'|cat:$i}">
	<option value="0">---Complaint---</option>
	{html_options options=$cs_list selected=$map_list[$ward_id].cs_id}
	
	
	</select>
	</td>
	
	<td>
	<select class="form-control" name="{'desg_id'|cat:$i}" id="{'desg_id'|cat:$i}" onchange="get_employees(this.value,'{$i}')">
	<option value="0">---Designation---</option>
	{html_options options=$desg_list selected=$map_list[$ward_id].desg_id}
	
	</select>
	</td>
	
	<td>
	<table width="100%" id="entryForm" cellpadding="0"  cellspacing="0">
							
							<tr>
								<td width="100%" valign="top" class="FormBox" >
									<div id="assinedcol" >
									
									{foreach from=$emp_list item=row key=emp_id}
											<tr><td><input name="checkbox{$i}[]" type="checkbox" value="{$emp_list[$emp_id]['emp_id']}">{$emp_list[$emp_id]['emp_name']}</td></tr>
									{/foreach}	</div>
										<!--<input type="button" value="select all"
											onclick="SetAllCheckBoxes(document.forms[0].coloniesassigned,true);">
										<input type="button" value="unselect all"
											onclick="SetAllCheckBoxes(document.forms[0].coloniesassigned,false);"> -->
								</td>
							</tr>
						</table>

	
	<!-- <select class="form-control" name="{'emp_id'|cat:$i}" id="{'emp_id'|cat:$i}">
	<option value="0">---Employee---</option>
	{html_options options=$emp_list selected=$map_list[$ward_id].emp_id}
	
	</select> -->
	</td>
	
	<td>
	<!--<table width="100%" id="entryForm" cellpadding="0"  cellspacing="0">
							
							<tr>
								<td width="100%" valign="top" class="FormBox">
									<div id="assinedcol">
									
									{foreach from=$emp_list item=row key=emp_id}
											<tr><td><input name="checkbox1[]" type="checkbox" value="{$emp_list[$emp_id]['emp_id']}">{$emp_list[$emp_id]['emp_name']}</td></tr>
									{/foreach}	</div>
									<!--	<input type="button" value="select all"
											onclick="SetAllCheckBoxes(document.forms[0].coloniesassigned,true);">
										<input type="button" value="unselect all"
											onclick="SetAllCheckBoxes(document.forms[0].coloniesassigned,false);"> -->
							<!--	</td>
							</tr>
						</table> -->
	<select class="form-control" name="{'emp2_id'|cat:$i}" id="{'emp2_id'|cat:$i}">
	<option value="0">---Responsible officer---</option>
	{html_options options=$emp_list1 selected=$map_list[$ward_id].emp_id}
	
	
	</select>
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









{include file='footer.tpl'}

