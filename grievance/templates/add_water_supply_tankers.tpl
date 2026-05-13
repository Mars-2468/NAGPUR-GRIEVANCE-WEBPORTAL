{include file='header.tpl'}
{literal}
<script>
function validateForm()
{
	var errors=0;
	
	$(".mytext").each(function(){
	
	
		var val_field=$(this).val();
		
		if(val_field =='')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});

	
	var value=$("#taker_number").val();
	if(value == '')
	 {
	  return false;
	 }
	
	
	
	/*
	
	var value=$("#mobile").val();
	var pattern = /^[7-9]{1}[0-9]{9}$/;
	if (!pattern.test(value)) {
         $("#mobile").css({"background-color": "pink"});
	alert('Invalid mobile number');
		
                return false;
	}
	else
	{
	 $("#mobile").css({"background-color": "white"});
	}
	
	*/
	
	

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
function tankervali()
{
         var value=$("#taker_number").val();
         if(value == '')
	 {
	  return false;
	 }
	var pattern = /^[A-Z]{2}\d{2}[A-Z]{2}\d{4}$/;
	 
	if (!pattern.test(value)) {
         $("#taker_number").css({"background-color": "pink"});
	    alert('Invalid Taker Number number');
		
                return false;
	}
		
	
}	
 $(document).ready(function()
{
  $(".datepick").datepicker({ minDate:+0,dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true});
  

  
  
});
function update_tanker(taker_number,name,mobile,address,tanker_id)
{
	
	$("#update_status").val('1');
	$("#taker_number").val(taker_number);
	$("#name").val(name);
	$("#mobile").val(mobile);
	$("#address").val(address);
	$("#tanker_id").val(tanker_id);
	
}
</script>


<script>
function delete_tanker_map(i)
{
    
    tanker_id_del=$("#tanker_id_del" + i).val();
    
    
        if (confirm("Are you sure you want to delete this record?"))
        {
        
                $.post("ajax_delete_tanker_map",{tanker_id:tanker_id_del},function(data)
                        	{
                        	    
                    	
                                	if(data==1)
                                	{
                                	    alert('Deleted Successfully');
                                	    window.location='add_water_supply_tankers.php';
                                	}
                                	else
                                	{
                                	    alert('Unable to delete , try again');
                                	}
                    	} );
        }
}



</script>

<script>
function addAdvance()
{
	
	
	var divcontent;
    var i = document.getElementById('cnt').value;
    var j = i-1;
	
     var newdiv = document.createElement('div');
     newdiv.setAttribute('id', i);
	 newdiv.setAttribute('class', 'form-group');
     divcontent="";
     
		    divcontent=divcontent + "<label class='control-label col-md-3'>Name: <span class='required'>* </span></label>";
            divcontent=divcontent + "<div class='col-md-8'><input name='name"+i+"' type='text' id='name"+i+"' size='30' maxlength='70' data-required='1' class='form-control' required/></div>";
            
            
             divcontent=divcontent + "<label class='control-label col-md-3'>Mobile: <span class='required'>* </span></label>";
            divcontent=divcontent + "<div class='col-md-8'><input name='mobile"+i+"' type='text' id='mobile"+i+"' size='30' maxlength='70' data-required='1' class='form-control' required/><input type='button' value='Remove' class='btn btn-danger' onclick='fnRemove(" + i +");' /></div>";
            divcontent=divcontent + "</div>";
            
            
            
            
            divcontent=divcontent + "</div>";
			
			
			
			newdiv.innerHTML = divcontent;                                  
			document.getElementById('advance_div').appendChild(newdiv);
   
			document.getElementById('cnt').value = eval (document.getElementById('cnt').value) + 1 ;
			
    
  }
  
  function fnRemove(arg)
{
	
	
	
	
    var d1=document.getElementById(arg).parentNode;
    var d2=document.getElementById(arg);
    d1.removeChild(d2); 
    var arg=arg-1;
  // document.getElementById('cnt').value=eval (document.getElementById('cnt').value) - 1 ;
   
   }
    
</script>
{/literal}





 <div class="row ">
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>ADD / UPDATE WATER TANK DETAILS</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               

               
			<form   method="post" action="add_water_supply_tankers.php" name="manage_emp"  class="form-horizontal" onSubmit="return validateForm()">
			
			
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
									<select class="form-control mytext" onchange="get_desgs(this.value)">
									     <option value="">--- select---</option>
									     {html_options options=$dept_list}
									 </select>
							</div>
					</div>
					
					
					
						<div class="form-group">
						<label class="control-label col-md-3">Level 1Employee : <span class="required">* </span></label>
							<div class="col-md-8">
									 <select class="form-control mytext" id="emp_id1" name="emp_id1">
									     <option value="">--- select---</option>
									 </select>
							</div>
					    </div>
					    
					    
					    <div class="form-group">
						<label class="control-label col-md-3">Leve2 1Employee : <span class="required">* </span></label>
							<div class="col-md-8">
									 <select class="form-control mytext" id="emp_id2" name="emp_id2">
									     <option value="">--- select---</option>
									 </select>
							</div>
					    </div>
					
						<div class="form-group">
						<label class="control-label col-md-3">Check Water Tankers <span class="required">* </span></label>
							<div class="col-md-8">
							    {assign var="i" value=1}
									 {foreach from=$water_tanker_list item=row key=water_tank_id}
									 
									 <input type="checkbox" name="{'tanker_id'|cat:$i}" id="{'tanker_id'|cat:$i}" value="{$water_tank_id}">{$water_tanker_list[$water_tank_id]}
									 <br>
									 {assign var="i" value=$i+1}
									 
									 {/foreach}
									 <input type="hidden" name="cnt" value="{$i}">
							</div>
					</div>
					
					
					
				
					
					
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<button type="button" class="btn btn-danger">Cancel</button>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>



 
<div class="row" id="div_print">
		<div >
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>EXISTING TANK Details</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
		<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
				<thead>
					
					<tr style="background-color:#2c3e50; color:#FFF;">
					  	<th>S.No</th>
					  	<th>Tank Name</th>
					  	<th>Level 1 Employee</th>
					  	<th>Level 1 Employee</th>
					    <th>Delete</th>
					    <th>Update</th>
					  	  	
					  </tr>
				</thead>
				
				<tbody>
					
					{assign var="j" value=1}
				 {foreach from=$data item=row key=tanker_id}
				
				  <tr>
				   	<td>{counter} </td>
					 <td>{$water_tanker_list2[$tanker_id]} </td>
					 <td>{$emp_list[$row.emp_id1]}</td>
					 <td>{$emp_list[$row.emp_id2]}</td>
					 
					 <td>
					     
					     
					         <input type="hidden" name="{'tanker_id_del'|cat:$j}" id="{'tanker_id_del'|cat:$j}" value="{$tanker_id}">
					         <input type="button"  value="Delete" class="btn btn-danger" onclick="delete_tanker_map('{$j}')">
					         
					    
					     
					     
                     </td>
                     <td>
                         <a href="update_water_supply_tankers.php?tid={$tanker_id}&eid1={$row.emp_id1}&eid2={$row.emp_id2}&dept_id={$row.dept_id}" class="btn btn-warning">Update</a>
                     </td>
                     <!--<td align="center">
                               <!--  <input type='radio' name='id' id='id'  value="{$row.id}"  >-->
                                 <!--<input type="button" class="btn btn-danger" value="DELETE" name='tanker_id' id='tanker_id' onclick="delete_rec('$row.tanker_id');">
                                                                </td>-->
				 
				 </tr>
				 {assign var="j" value=$j+1}
				  {/foreach}
						
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
{literal}
<script src='../js/jquery.min.js'></script>
<script>
    function get_desgs(dept_id)
    {
         $.post('ajax_get_employees2.php',{dept_id:dept_id},function(data)
        {
            
            $("#emp_id1").html(data);
            $("#emp_id2").html(data);
        });
    }
    
    function get_emps(dept_id)
    {
        $.post('ajax_get_employees2.php',{dept_id:dept_id},function(data)
        {
            
            $("#desg_id").html(data);
        });
    }
</script>
<script>
$(document).ready(function() {

$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });



             

}); 
</script>
{/literal}
{include file='footer_print.tpl'}
<br>



{include file='footer.tpl'}

