{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	<script>
    	function clearpage()
    	{
    		location.reload (true);
    	}
    	</script>
    	
    	
    	<script>
 var displayduration = "";
function fetchdept(i,emp_id,ward_id,cs_id,emp_id2,ward_desc)
{
displayduration = i;
	$.ajax({
	type: "POST",
	url: "fetchdept.php",
	data:{emp_id:emp_id,ward_id:ward_id,cs_id:cs_id,emp_id2:emp_id2,ward_desc:ward_desc},
	success: function(data){
	//alert(data);
	//var resarry= data.split('~~~');
	document.getElementById(i).innerHTML = data;
		//$("#".i).html(data);
		//$("#search-box1").show();
	}
	});
	
}
</script>
<script>
 
function editemp(emp_id,ward_id,ward_desc,cs_id,dept_id)
{

dept_id1 = dept_id.value;
//alert(dept_id1);
	
	$.ajax({
	type: "POST",
	url: "fetchemp.php",
	data:{emp_id:emp_id,ward_id:ward_id,cs_id:cs_id,dept_id:dept_id1,ward_desc:ward_desc},
	success: function(data){
	//alert(data);
	document.getElementById(displayduration).innerHTML = data;
		//$("#".i).html(data);
		//$("#search-box1").show();
	}
	});
	
}
</script>

<script>
function updaterecord(ward_id, cs_id)
{
	var emp_id = document.getElementById("emp_type").value;
	var emp_id1 = document.getElementById("empr_type").value;
	var dept_id = document.getElementById("dept_type").value;
	//alert(emp_id1);
	if(emp_id == '0') 
	{
	//alert(displayduration);
		alert('Please Select Employee');
	}
	else if(emp_id1 == '0')
	{
		alert('Please Select Responsible Employee');
	}
	else
	{
	//alert(emp_id);
		$.ajax({
		type: "POST",
		url: "updateemp.php",
		data:{emp_id:emp_id,ward_id:ward_id,cs_id:cs_id,emp_id1:emp_id1,dept_id:dept_id},
		success: function(data){
		//alert(data);
		if(data == '0')
		{
			alert('Something Went wrong please try later');
		}
		else
		{	
			alert('Record Updated Successfully');
			window.location.reload(true);
			//document.getElementById(displayduration).innerHTML = data;
		}
			//$("#".i).html(data);
			//$("#search-box1").show();
		}
		});
	}
	//alert('hi');
}
</script>

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





 <div class="row">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>Please Select Complaint From Bellow Drop Down To View/Edit Mapping</h4>
                  
                </div>
                <br>
                <form method="GET" action="complaint_emp_map_report.php" >
                <div class="col-md-4 col-md-offset-3">
                <select name="cs_id" id="cs_id" onChange="getrec(this)" class="form-control">
                <option value='0'>---SELECT--</option>
                {html_options options=$cs_list}
                </select>
                 </div>
                 <div class="col-md-2">
                  <input type="Submit" name="getr" value="Submit" class="btn btn-success">
                  </div>
                  <br>

                </form> 
                
                {assign  var="i" value=1}
                {foreach from=$cs_list1 item=row key=cat_id}

		<div class="">
                <!-- Title Bart Start -->
                <div class="title-bar success" style="clear:both; margin-top:20px;">
                  <h4>{$cs_list1[$cat_id]}</h4>
          </div> 
</div> 
                  
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
					<thead>
					<tr style="background-color:#2c3e50; color:#FFF;">
					<th>Ward </th>
					<th>Department</th>
					<th>Employee name</th>
					<th>Responsible Employee</th>
					<th>Update</th>
					</tr>
					
					</thead>
					<tbody>
					
					
					{foreach from=$ward_list item=row key=ward_id}
					{assign  var="emp_id" value=$data[$ward_id][$cat_id].emp_id}
					{assign  var="emp_id2" value=$data[$ward_id][$cat_id].emp_id2}
					{assign  var="dept_id" value=$data[$ward_id][$cat_id].dept_id}
					<tr id ='{$i}'>
					<td>{$ward_list[$ward_id]}</td>
					<td >{$dept_list[$dept_id]}</td>
					<td >{$emp_list[$emp_id]}</td>
					<td>{$emp_list[$emp_id2]}</td>
					
					<td>
					{if $emp_list[$emp_id] eq ''}
					{else}
					<a href="#" onclick = "fetchdept({$i},'{$emp_id}','{$ward_id}','{$cat_id}','{$emp_id2}','{$ward_list[$ward_id]}')" >Edit</a>
					{/if}
					</td>
					</tr>
					{assign var=$i value=$i++} 
					{/foreach}
					</tbody>
									
					</table>
		</div>
			

		{/foreach}








{include file='footer.tpl'}

