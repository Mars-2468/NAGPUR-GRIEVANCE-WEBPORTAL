{include file='header.tpl'}
{literal}
<style>
td
{
width:250px;
}
* {
	margin: 0;
	padding: 0;
}

.container {
text-align: left;
}




.label_div {
	  width: 140px;
  float: left;
  line-height: 28px;
  margin-left: 83px;
}
.input_container {
	height: 30px;
	float: left;
}
.input_container input {
	height: 20px;
	width: 200px;
	padding: 3px;
	border: 1px solid #cccccc;
	border-radius: 0;
}
.input_container ul {
	width: 206px;
	border: 1px solid #eaeaea;
	position: absolute;
	z-index: 9;
	background: #f3f3f3;
	list-style: none;
}
.input_container ul li {
	padding: 2px;
}
.input_container ul li:hover {
	background: #eaeaea;
}
#country_list_id {
	display: none;
}


</style>
<script language='javascript'>
function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#apprec_id').val();
          var app_id= $('#app_id').val();
if(app_id == '0')
{
return false;

}
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_reports.php',
			type: 'POST',
			data: {keyword:keyword,app_id:app_id},
			success:function(data){

				$('#country_list_id').show();
				$('#country_list_id').html(data);
			}
		});
	} else {
		$('#country_list_id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	$('#apprec_id').val(item);
	// hide proposition list
	$('#country_list_id').hide();
}

/*
function validateForm()
{
	var errors=0;
	
	$(".float").each(function(){
		
		var patt=/^\d+(\.\d+)?$/;
		var val_field=$(this).val();
		
		if(!val_field.match(patt))
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});

             $(".dropdown").each(function(){
		
	
		var val_field=$(this).val();
		
		if(val_field == '0')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});

      $(".chr").each(function(){
		
	
		var val_field=$(this).val();
		
		if(val_field == '')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});
         
      


	
	if(errors==0)
	{
		
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
     

   
    
        
       
}
*/

</script>
{/literal}

<div style="border:#999999 1px solid; background-color:#d4f2ff;  min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<form name='days_application_report' method='POST' action='days_application_report.php' onSubmit="return validateForm();" >

<div class="my_heading">Application Reports</div>
<div id="area">
<br><br>
 <div class="container">
   
       
        
<form name='cuttoff_date' method='POST' action='cuttoff_date.php' onSubmit="return validateForm();" >



 <table width='97%' cellspacing="0"  border="1" cellpadding="5" id="example" style="border-collapse:collapse;">
<thead>

 	<tr style="background-color:#d1d1d1;"> 
<th>Sno</th>
            <th>Section Name </th>
            <th> Service Name </th>
 <th> Officer Responsible to render services </th>
  <th> Applicant Name </th>
  <th> Applicant  Phone </th>
  <th>  Applicant  Email </th>
    <th>  Application Receive date </th>
     <th>  Cuttoff Date </th>
      <th>  Remaining Days </th>
 <th>  Status Type </th>
 
       
       </tr>


</thead>
<tbody>

{foreach from=$data key=i item=row}
<tr>
  <td>{counter}</td>
    <td>{$section_list[$row.section_id]}</td>
      <td>{$service_list[$row.service_id]}</td>
<td>{$designation_list[$row.emp_responsible]}</td>
<td>{$row.apprec_name}</td>
<td>{$row.apprec_phone}</td>
<td>{$row.apprec_email}</td>
<td>{$row.recdate}</td>
<td>{$row.cutdate}</td>
<td>{$row.diff}</td>
<td>{$status_list[$row.status_id]}</td>

 </tr>

{/foreach}
</tbody>
</table>

</div>


</div><br>
<br>

{include file='footer_print.tpl'}
<br>
<br>

{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            