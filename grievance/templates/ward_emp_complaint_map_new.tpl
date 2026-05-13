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

function validateForm()
{
	dept_id=$("#dept_id").val();
	emp_id=$("#emp_id").val();
	emp_id2=$("#emp_id2").val();
	if(dept_id==0)
	{
	alert('select Department');
	return false;
	}
	
	if(emp_id==0)
	{
	alert('select Level 1 Employee');
	return false;
	}
	
	if(emp_id2==0)
	{
	alert('select Level 2 Employee');
	return false;
	}
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
                
              
               <center> 
		<button class="btn btn-primary">            
 <a href="http://www.municipalservices.in/complaint_emp_map_report.php" target="_blank" class="btn-link" style="color:#FFF;"><span class="fa fa-clipboard"></span> Click Here  To Employee Complaint Mapping Report</a></button>
 </center>
 	<br>
			
			<form   method="post" action="ward_emp_complaint_map.php" name="manage_wards"  id="manage_wards" class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
				
	<div class="col-md-4">			
	<select class="form-control" name="cs_id[]" id="cs_id" multiple="multiple" size="10" style="width:265px" >
	<option value="0">---Complaint---</option>
	{html_options options=$cs_list selected=$cs_id_sel}
	
	</select>   
    </div>
    
    
    
    
	<div class="col-md-6">
    
	<select class="form-control" name="dept_id" id="dept_id" onchange="get_employees(this.value)" style="margin-bottom:15px;">
	<option value="0">---Department---</option>
	{html_options options=$dept_list selected=$dept_id_sel}
	
	</select>
	
	<select class="form-control" name="emp_id" id="emp_id" style="margin-bottom:15px;">
	<option value="0">---Assigned Employee---</option>
	{html_options options=$emp_list selected=$emp_id_sel}
	</select>
	
	<select class="form-control" name="emp_id2" id="emp_id2" style="margin-bottom:15px;">
	<option value="0">---Responsible officer---</option>
	{html_options options=$emp_list selected=$emp_id2_sel}
	</select>
    
    <div >
						<button type="submit" name="submit" class="btn btn-info">Get data</button>
                        </div>
	</div>
	
   										
                                            
                                            	</form>
						
				
				
		<div >{if isset($cs_id_sel)}</div>
		
		<table class="table-bordered table-striped table-condensed cf" width="100%">
		<thead>
		
			<tr style="background-color:#2c3e50; color:#FFF;">
			
				<th>Check All</th>
			</tr>
		</thead>
		</table>


		<br>
		<form   method="post" action="ward_emp_complaint_map.php" name="manage_wards"  id="manage_wards" onSubmit="return validateForm()">
		<input type="hidden" name="dept_id_sel" value="{$dept_id_sel}">
		<input type="hidden" name="emp_id_sel" value="{$emp_id_sel}">
		<input type="hidden" name="cs_id_sel" value="{$cs_id_sel}">
		<input type="hidden" name="emp_id2_sel" value="{$emp_id2_sel}">
	
	
		{assign var="i" value="0"}
		{assign var="j" value="0"}
	
		{foreach from=$csid_list item=row2 key=cs_id}
		<br>

		
		<div style="clear:both;">{$cs_list[$cs_id]}</div>
		
			
		
		
		 
        <br>
		<table class="table-bordered table-striped table-condensed cf" width="100%">
		<thead>
		
			<tr style="background-color:#2c3e50; color:#FFF;">
			
				<th>Ward</th>
				<th>Department</th>
				<th>Assigned Employee</th>
				<th>Responsible Officer</th>
				
			</tr>
		</thead>
		
			{foreach from=$ward_list2[$cs_id] item=row3 key=ward_id2}
				<tr>

					<th>{$ward_list2[$cs_id][$ward_id2]}</th>
					<th>{$data2[$ward_id2][$cs_id].dept_id}</th>
					<th>{$data2[$ward_id2][$cs_id].emp_id}</th>
					<th>{$data2[$ward_id2][$cs_id].emp_id2}</th>
					
				</tr>
			{/foreach}
			</table>
			<table class="table-bordered table-striped table-condensed cf" width="100%">
			<thead>
				<tr>
				<th> ward  </th>
				
				</tr>
			</thead>
			
			{foreach from=$ward_list[$cs_id] item=row key=ward_id}
	
				<tr>
				<td>
				
				
				{$ward_list[$cs_id][$ward_id]} <input type="checkbox" name="{'ward_id'|cat:$i}" value="{$cs_id}-{$ward_id}">
				
				
				
				</td>
				
				</tr>
				{assign var="i" value=$i+1}
				{/foreach}
				
				<input type="hidden" name="file_count" value="{$i}">
				
				
						
						
			
			</table>
			{/foreach}
			{foreach from=$data item=row key=cs_id}
				<input type="hidden" name="{'cs_id'|cat:$j}" value="{$data[$j]}">
				{assign var="j" value=$j+1}
				{/foreach}
				<input type="hidden" name="cs_count" value="{$j}">
				
				<table>
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
	



		
	<!--<table class="table">
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
			</form>-->
		</div>
		</div>
	</div>
</div>
{/if}









{include file='footer.tpl'}

