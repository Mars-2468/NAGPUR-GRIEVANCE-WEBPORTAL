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

$("#manage_wards").submit();
}
function get_employees(dept_id)
{
	
	
	$.post("ajax_get_employees2.php",{dept_id:dept_id},function(data)
	  {
	   	
			
	   	$("#emp_id").html(data);
	   	$("#emp_id2").html(data);
	   	$("#emp_id3").html(data);
	   	$("#emp_id4").html(data);
	   	
	   	
	  
	   
	   
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
/*function fun1()
{
$("#checkAll").click(function () {

    $("input:checkbox").prop('checked', $(this).prop("checked"));
});

}*/
</script>
{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Merge Services</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                
              
              
 	<br>
			
			<form   method="post" action="merg_depts.php" name="manage_wards"  id="manage_wards" class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
		<div class="row">		
				
            	<div class="col-md-4">			
            	<select class="form-control" name="dept_id" id="dept_id">
            	<option value="0">---Department---</option>
            	{html_options options=$dept_list selected=$dept_id_sel}
            	
            	</select>   
                </div>
                
                
                	<div class="col-md-4">
                        <button type="submit"  name="getdata" class="btn btn-info" onclick="fun2()">Get data</button>
                    </div>
        </div>
</form>
						
				{if isset($ulb_list)}
				<br><br><br>
				<form action="merg_depts.php" method="post">
				    <input type="hidden" name="dept_id_sel" value="{$dept_id_sel}">
				    {foreach from=$ulb_list item=row key=ulbid}
				    <div class="title-bar success">
                        <h4>{$ulb_list[$ulbid]}</h4>
                    </div>
                    <table class="table">
                        {foreach from=$admincs_list item=row2 key=admincsid}
                        <tr>
                            <th><span style="color:red"> Service Name : &nbsp;&nbsp;&nbsp; {$admincs_list[$admincsid]}</span></th>
                        </tr>
                        
                            
                            {foreach from=$cs_list[$ulbid] item=row3 key=cs_id}
                            
                            <tr>
                                <th><input type="checkbox" name="check_list[]" value="{$admincsid}-{$cs_id}-{$ulbid}" class="{$ulbid}__{$cs_id}" {if $data[$ulbid][$cs_id].id eq $admincsid} checked {/if} onclick="fun_color('{$ulbid}','{$cs_id}')"> &nbsp;&nbsp;&nbsp; <span class="{$ulbid}_{$cs_id}">{$cs_list[$ulbid][$cs_id]}</span></th>
                            </tr>
                            {/foreach}
                        
                        {/foreach}
                    </table>
				    {/foreach}
				    
				    <div class="col-md-4">
                        <button type="submit"  name="save" class="btn btn-info">Save</button>
                    </div>
				</form>
				
				{/if}
				
		

{literal}
<script>
function fun1(dept_id)
{
    $.post('ajax_get_admin_services.php',{dept_id:dept_id},function(data)
    {
        $("#cs_id").html(data);
    });
}
function fun_color(ulbid,csid)
{
    var classname=ulbid +"_"+csid;
     var checkboxclassname=ulbid +"__"+csid;
    
                if($("." + checkboxclassname).is(':checked')){
                 $("." + classname).css('color','blue');
            } else {
                $("." + classname).css('color','black');
            }
}
function fun2()
{
    var cs_id=$("#dept_id").val();
    if(cs_id==0)
    {
        alert('select Department');
        return false;
    }
    else
    {
        return true;
    }
}
$(document).ready(function() {



$("#checkAll").click(function(){

$('input:checkbox').not(this).prop('checked', this.checked);

   
});

}); 
</script>
{/literal}







{include file='footer.tpl'}

