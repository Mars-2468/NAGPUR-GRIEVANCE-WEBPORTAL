{include file='header.tpl'}
{literal}
<script>
function validateForm()
{
	var errors=0;
	 var pattern = /^[7-9]{1}[0-9]{9}$/;
	
	
	

	if(errors==0)
	{
		return true;
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}

}

	
 $(document).ready(function()
{


  $(".datepick").datepicker({ minDate:+0,dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true});
  

  
  
});
</script>
<script>

function getsubcate()
{

$("#dept_id").val(0);
$("#ward_data").hide();


 var cat_id=$("#cat_id").val();

  $.post("getsubcate.php",{cat_id:cat_id},function(data)
  {

   $("#sub_cat_id").html(data);
  
  })
}
function getcate3()
{
$("#dept_id").val(0);
$("#ward_data").hide();
 var sub_cat_id=$("#sub_cat_id").val();

  $.post("getcate3.php",{sub_cat_id:sub_cat_id},function(data)
  {

   $("#cat3_id").html(data);
  
  })
}

function getdesig(dept_id)
{
 //var emp_id=$("#emp_id"+i).val();

 $.post("getdesig.php",{dept_id:dept_id},function(data)
  {
    
var arr=data.split("::");	
   $("#desg_id").html(arr[0]);
   $("#cat3_id").html(arr[1]);
   
   
  })
}
function getcomp_names(cat_id)
{
	
	$.post("getcate3.php",{cat_id:cat_id},function(data)
	  {
	    
	
	   $("#cat3_id").html(data);
	  
	   
	   
	  })
}

function getwards(desg_id)
{
	var dept_id=$("#dept_id").val();
	var cs_id=$("#cat3_id").val();
	
	$.post("ward_emp_map.php",{desg_id:desg_id,dept_id:dept_id,cs_id:cs_id},function(data)
	  {
	    
	
	   $("#advance_div").html(data);
	  
	   
	   
	  })
}
</script>
{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Employee Map</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               

               
			<form    class="form-horizontal">
			<input type='hidden' name='emp_id' value='0'>
				<div class="form-body">
				{if isset($msg)}
					<div class="{$class}">
						<button class="close" data-close="alert"></button>
						{$msg}
					</div>
				{/if}	
					
					<div class="form-group">
						<label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='dept_id' id='dept_id' onchange="getdesig(this.value);" class="form-control">
										<option value='0'>--Select Department--</option>
										{html_options options=$dept_list}
									</select>
							</div>
					</div>
					
					<!--<div class="form-group">
						<label class="control-label col-md-3">Category: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='cat_id' id='cat_id'  class="form-control" onchange='getcomp_names(this.value)'>
										<option value='0'>--Select Category--</option>
										
									</select>
							</div>
					</div>-->
					
					<div class="form-group">
						<label class="control-label col-md-3">Complaint / Serivice: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='cat3_id' id='cat3_id'  class="form-control">
										<option value='0'>--Select complaint/service --</option>
										
									</select>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='desg_id' id='desg_id' class="form-control" onchange="getwards(this.value)">
										<option value='0'>--Select Designation--</option>
									</select>
							</div>
					</div>
					
					
					</form>
					
				</div>
				
			
		</div>
		</div>
	</div>
</div>

<div class="row ">
	<div class="col-lg-12">
	<form  name="employee_map" id="employee_map" method="POST" action="employee_map.php"  class="form-horizontal" onSubmit="return validateForm()">
	
	<table class="table table-striped table-bordered table-hover table-full-width" id="advance_div">
	
	</table>
	
	</form>
	
	</div>
</div>	
	







{include file='footer.tpl'}

