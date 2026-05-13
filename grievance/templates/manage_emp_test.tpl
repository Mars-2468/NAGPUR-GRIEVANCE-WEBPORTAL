{include file='header.tpl'}
{literal}
<script>
function get_det(dept_id)
{
	var select = document.getElementById("emp_desg");
	select.options.length = 0;

	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	else
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var strArray = xmlhttp.responseText.split("___");
			var j=strArray.length;
			for(i=0;i<j;i++)
			{
				var optArray=strArray[i].split(":::");
				select.options[select.options.length] = new Option(optArray[1],optArray[0]);
			} 
		}
	}
	xmlhttp.open("GET","get_designations.php?dept_id="+dept_id,true);
	xmlhttp.send();

}

function fill(emp_id,emp_name,emp_mobile,emp_dept,emp_desg)
{
	document.manage_emp.emp_id.value=emp_id;
	document.manage_emp.emp_name.value=emp_name;
	document.manage_emp.emp_mobile.value=emp_mobile;
	$('#emp_dept').val(emp_dept);
	get_det(emp_dept);
	alert(emp_desg);
	$('#emp_desg').val(emp_desg);
	
} 
function validateForm()
{
	var emp_name=document.manage_emp.emp_name.value;
	var emp_dept=document.manage_emp.emp_dept.selectedIndex;	
	var emp_desg=document.manage_emp.emp_desg.selectedIndex;		
	var emp_mobile=document.manage_emp.emp_mobile.value;		
	var filter = /^[7-9]{1}[0-9]{9}$/;
	var patt1 = /^[\w]+[\w\s-./]+$/;		
	

	/*if(!patt1.test(emp_name))
	{
		alert("Please Enter  Correct value in Employee Name ");
		return false;
	}*/
	
	if(emp_dept=='0')
	{
		alert("Please Select Department");
		return false;
	}

	if(emp_desg=='0')
	{
		alert("Please Select Designation");
		return false;
	}

    	if(!filter.test(emp_mobile))
    	{
		alert("Please Enter Valid Mobile No");
		return false;    	
    	}

	return true;
}

function delete_rec(emp_id)
{
	if(confirm('Do Your really want to delete this record'))
	{
	
		$.post('ajax_del_emp.php',{emp_id:emp_id},function(data)
		{
		if(data==1)
		{
		alert('Employee deleted successfully');
		window.location='manage_emp.php';
		}
		else if(data=0)
		{
		alert('Unable to delete , Try again');
		}
		else
		{
		alert('Employee is mapped with wards You cannot delete this Employee, Need to Updaete wards Mapped with Employee ');
		}
		
		});
	}
}
function delete_desg(i,desg_id,emp_id)
{
	if(confirm('Do Your really want to delete this record'))
	{
	
		$.post('ajax_del_emp_desg.php',{emp_id:emp_id,desg_id:desg_id},function(data)
		{
			if(data==1)
			{
			$('#trid' + i).css('display','none');
			alert('Deleted successfully');
			}
			else
			{
			alert('Unable to delete , Try again');
			}
		});
	}
}

function get_designations(dept_id,i,code)
{
	
	$.post('get_designations2.php',{dept_id},function(data)
	{
		if(code=='2')
		{
		$("#desg_m" + i).html(data);
		}
		else
		{
		
		$("#desg_id" + i).html(data);
		}
	});
}


function addAdvance()
{

 var divcontent;
    var i = document.getElementById('cnt').value;
   
	
    var j = i-1;
	
     var newdiv = document.createElement('tr');
     newdiv.setAttribute('id', i);
	 newdiv.setAttribute('class', 'addrow');
     divcontent="";
	 
	   divcontent=divcontent + "<td align='left' style='padding:5px;'>";
            divcontent=divcontent + "Department:<select name='dept_id"+i+"' id='dept_id"+i+"' class='validate[required] form-control mytext' style='width:200px;' onchange='get_designations(this.value,"+i+")'>";
            
            
            $.post("ajax_departments.php",function(data)
            {
            
            	$("#dept_id"+i).html(data);
            });
            
            
            divcontent=divcontent +"<option value='0'>---select---</option>";
			
            divcontent=divcontent +"</select>";
            divcontent=divcontent + "</td>"; 
            
            
            
            divcontent=divcontent + "<td align='left' style='padding:5px;'>";
            divcontent=divcontent + "Designation:<select name='desg_id"+i+"' id='desg_id"+i+"' class='validate[required] form-control mytext' style='width:200px;'>";
            divcontent=divcontent +"<option value='0'>---select---</option>";
			
            divcontent=divcontent +"</select>";
            divcontent=divcontent + "</td>"; 
            divcontent=divcontent + "<td align='left' style='padding:5px;'><input type='button' value='Remove' class='btn btn-default' onclick='fnRemove(" + i +");' /></td>";
            
            
            
            
	    divcontent=divcontent + "</tr>";
			
			divcontent=divcontent + "</tr>";
    

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
   
 function update_desg(id,i,emp_id)
 {
 
 	dept_id=$("#dept_m" + i).val();
 	desg_id=$("#desg_m" + i).val();
 	$.post('ajax_update_desg.php',{id:id,desg_id:desg_id,dept_id:dept_id,emp_id:emp_id},function(data)
 	{
 		alert(data);
 	});
 }
 
</script>
{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>ADD /UPDATE EMPLOYEE</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               

               
			<form   method="post" action="manage_emp_test.php" name="manage_emp"  class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='emp_id' value='0'>
			<input type="hidden" name="cnt" id="cnt" value="0"/>
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Name: <span class="required">* </span></label>
							<div class="col-md-8">
									<input name='emp_name' type="text" id="emp_name" size="30" maxlength='70' data-required="1" class="form-control"/>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
							<div class="col-md-8">
									 <input name='emp_mobile' maxlenght='10' type="text" id="mobile" maxlength='10'  class="form-control num"/>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Department: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='emp_dept' id='emp_dept' onchange="get_det(this.value);" class="form-control">
										<option value='0'>--Select Department--</option>
										{html_options options=$dept_list}
									</select>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Designation: <span class="required">* </span></label>
							<div class="col-md-8">
									<select name='emp_desg' id='emp_desg' class="form-control">
										<option value='0'>--Select Designation--</option>
									</select>
							</div>
					</div>
					
					<div class="form-group">
						<table class="table" id="advance_div">
						
						</table>
					</div>
					
					
					<div class="form-group">
						<input type="button" id="add" class="btn btn-success" name="add" onclick="addAdvance()" value="ADD ANOTHER DESIGNATION" style="font-size:12px;">
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
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>EXISTING DESIGNATIONS</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
									<thead>
										<tr  style="background-color:#2c3e50; color:#FFF;">
										  	<th>S.No</th>
										  	<th>Name</th>
										  	<th>Mobile</th>
										  	<th>Department</th>
										  	<th>Designation</th>
											<th>EDIT</th> 
											<th>DELETE</th> 	
										</tr>
									</thead>
									
									<tbody>
									{assign var="i" value="0"}
									{foreach from=$data key=emp_id item=row}
									<tr>
										<td>{counter}</td>
										<td>{$row.emp_name}</td>
										<td>{$row.emp_mobile}</td>
										<td>{$dept_list[$row.emp_dept]}</td>
										<td>{$desg_list[$row.emp_desg]} {if $multi_desg_list[$emp_id] neq ''}<span id="{'id'|cat:$emp_id}">(More Designations)</span>
										<div id="{'divid'|cat:$emp_id}" style="display:block">
										<table class="table">
										{foreach from=$dept_list item=row2 key=dept_id}
										
										{foreach from=$multi_desg_list[$emp_id][$dept_id] item=row3 key=desg_id}
										<tr id="{'trid'|cat:$i}">
										<td>
										<select name="{'dept_m'|cat:$i}" id="{'dept_m'|cat:$i}" onchange="get_designations(this.value,{$i},'2')">
										<option value='' >---select----</option>
										{html_options options=$dept_list selected=$dept_id}
										
										</select>
										</td>
										<td>
										<select name="{'desg_m'|cat:$i}" id="{'desg_m'|cat:$i}">
										<option value='' >---select----</option>
										{html_options options=$desg_list2[$dept_id] selected=$desg_id}
										
										</select>
										
										{$desg_list[$multi_desg_list[$emp_id][$desg_id]]}
										
										
										
										</td>
										<td><input type="button" class="btn btn-danger" onclick="update_desg('{$ids[$desg_id]}','{$i}','{$emp_id}')" value="Edite"></td>
										<td><input type="button" class="btn btn-danger" onclick="delete_desg('{$i}','{$desg_id}','{$emp_id}')" value="Delete"></td>
										</tr>
										{assign var="i" value=$i+1}
										{/foreach}
										{/foreach}
										</table>
										</div>
										{/if}</td>
										<td>
										
										
				<button class="btn btn-success" name="update" onclick="fill('{$emp_id }','{$row.emp_name}','{$row.emp_mobile}','{$row.emp_dept}','{$row.emp_desg}')">
                                 <span class="fa fa-pencil-square-o"></span>  Edit</button>								
										</td>
										<td>
										<input type="button" class="btn btn-danger"  value="Delete" onclick="delete_rec('{$emp_id}')">
										</td>
									
									</tr>
									
									{/foreach}
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>
{literal}
<script src='../js/jquery.min.js'></script>
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

