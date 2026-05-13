{include file='header.tpl'}
{literal}
<script>
function fill(dept_id,dept_desc)
{
	document.manage_dept.dept_id.value=dept_id;
	document.manage_dept.dept_desc.value=dept_desc;
} 

function validateForm()
{
	var dept_desc=document.manage_dept.dept_desc.value;		
	if(dept_desc=='')
	{
		alert("Please Enter Department Name");
		return false;
	}

	return true;
}

function delete_rec(dept_id)
{
	if(confirm('Do you really want to delete this record'))
	{
	      var csrf_token=$("#csrf_token").val();
		$.post('ajax_del_dept.php',{dept_id:dept_id,csrf_token:csrf_token},function(data)
		{
		   
		    
			if(data==1)
			{
			alert('Deleted successfully');
			window.location='manage_dept.php';
			}
			else if(data==0)
			{
			alert('Unable to delete try again');
			}
			else if(data==3)
		    {
		    alert('Invalid token');
		    }
		    else if(data==4)
		    {
		    alert('csrf error');
		    }
		});
	}
}
</script>


<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('http://municipalservices.in/manage_dept.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>	


{/literal}



<div class="row" id="div_print">
		<div >
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4> Merge Designations </h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                    <form action="" method="POST">
					 <table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
  <tbody>
      <tr style="background-color:#2c3e50; color:#FFF;">
          <td>Department</td>
          <td colspan="2">Designation</td>
      </tr>
	  <tr >
	  <td rowspan="5"> Engineering </td>
	  <td rowspan="3">Deputy Executive Engineers</td>
	  <td><input type="checkbox"> M.Thirupathi</td>
	  </tr>
    <tr>
      <td><input type="checkbox">
      P. Srinivasulu</td>
    </tr>
    <tr>
      <td><input type="checkbox">
      Venkatesh</td>
    </tr>
    <tr>
      <td>Assistant Engineers </td>
      <td><input type="checkbox">
      Sri. P. Arun Kumar</td>
    </tr>
    <tr>
      <td>Technical Officer </td>
      <td><input type="checkbox">
      Smt. Mamatha</td>
    </tr>
    <tr>
      <td rowspan="4">Town Planning Section</td>
      <td rowspan="2">Assistant City Planner</td>
      <td> <input type="checkbox">
      Sri. B.Vandanam</td>
    </tr>
    <tr>
      <td> <input type="checkbox">
      Sri. Srinivas Yadav</td>
    </tr>
    <tr>
      <td rowspan="2">Town Planning Supervisor</td>
      <td><input type="checkbox">
      Smt. G. Anuradha</td>
    </tr>
    <tr>
      <td><input type="checkbox">
      Sri. Sai Kiran</td>
    </tr>
    
  </tbody>
</table>
                    <input type="submit" name="save" value="save" class="btn btn-success"/>
					
					
				</div>
			</div>
		</div>

{include file='footer_print.tpl'}
{include file='footer.tpl'}

