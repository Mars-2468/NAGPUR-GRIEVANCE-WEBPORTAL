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
	
	$('#emp_desg').val(emp_desg);
	
} 
function validateForm()
{
	var emp_name=document.manage_emp.emp_name.value;
	var emp_dept=document.manage_emp.emp_dept.selectedIndex;	
	var emp_desg=document.manage_emp.emp_desg.selectedIndex;		
	var emp_mobile=document.manage_emp.emp_mobile.value;		
	var filter = /^[6-9]{1}[0-9]{9}$/;
	var patt1 = /^[\w]+[\w\s-./]+$/;		
	

	/*if(!patt1.test(emp_name))
	{
		alert("Please Enter  Correct value in Employee Name ");
		return false;
	}*/
	
	if(emp_name=='')
	{
		alert("Please Select Name");
		return false;
	}

	if(emp_mobile=='0')
	{
		alert("Please Select Mobile");
		return false;
	}

    	if(!filter.test(emp_mobile))
    	{
		alert("Please Enter Valid Mobile No");
		return false;    	
    	}
    	
    	var username =$("#username").val();
    	if(username=='')
    	{
    	    alert('Enter username');
    	    return false;
    	}
    	
    	var emp_status=$("#usernameStatus").val();
    	
    	if(emp_status=='1')
    	{
    	    alert('This username is alredy existed');
    	    return false;
    	}
    	
    	var password =$("#password").val();
    	if(password=='')
    	{
    	    alert('Enter Password');
    	    return false;
    	}

	return true;
}

function delete_rec(emp_id,od_status)
{
	if(confirm('Do Your really want to delete this record'))
	{

		$.post('ajax_del_emp.php',{emp_id:emp_id,od_status:od_status},function(data)
		{
		  // alert(data);
	        if(data==1)
	        {
	            alert('Employee deleted successfully');
	            window.location='manage_emp.php';
	        }
	        else
	        {
	            alert('Error: try again');
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
<script>

$(document).ready(function()
{
    $("#od").click(function()
    {
        if(this.checked)
        {
            $("#od").val(1);
        }
        else
        {
            $("#od").val(0);
        }
    });
});
</script>


<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('https://municipalservices.in/manage_emp.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>




{/literal}





 <div class="row ">
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4> UPDATE AGENT </h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                   
               

               
			<form   method="post" action="updateagent.php" name="manage_emp"  class="form-horizontal" onSubmit="return validateForm()">
			    <input type="hidden" name="csrf_token" value="{$csrf_token}"/>
			    <input type="hidden" name="user_id" value="{$user_id}">
		
				<div class="form-body">
				
				{if isset($msg)}
				<div class="alert alert-success">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
				
				
				
					<div class="form-group">
						<label class="control-label col-md-3">Name of Agent: <span class="required">*</span></label>
							<div class="col-md-8">
									 <input name='emp_name'  type="text" id="emp_name"   class="form-control" required="required" value="{$data.emp_name}"/>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Mobile: <span class="required">*</span></label>
							<div class="col-md-8">
									 <input name='emp_mobile' maxlenght='10' type="text" id="mobile" maxlength='10'  class="form-control num" onblur="check_mobile(this.value)" required="required" value="{$data.emp_mobile}"/>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Email: <span class="required"> </span></label>
							<div class="col-md-8">
									<input type="email" name='emp_email' class="form-control" value="{$data.user_email}"/>
							</div>
					</div>
					
				
					
					<div class="form-group">
						<label class="control-label col-md-3">Password</label> <span class="required">* </span></label>
							<div class="col-md-8">
									<input type="password" name='password' id="password" class="form-control"/>
							</div>
					</div>
					
					
					
					
					
					
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' >Submit</button>
						
						</div>
					</div>
				</div>
				
			</form>
		</div>
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


function checkusername(username)
{
    $.post('ajax_check_username.php',{username:username},function(data)
    {
        if(data==1)
        {
            alert("Username is already existed");
            $("#username").val("");
            $("#usernameStatus").val(1);
            
        }
        else
        {
            $("#usernameStatus").val(0);
        }
    })
    
}

function check_mobile(mobile)
    {
        $.post('ajax_mobile_check.php',{mobile:mobile},function(data)
        {
            if(data==1)
            {
                alert('This mobile number is already in use ');
                $("#od").val('1');
                $("#emp_status").val('1');
                $("#od_area").css('display','block');
            }
        });
    }
</script>
{/literal}

<br>

{include file='footer.tpl'}

