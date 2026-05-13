{include file='header.tpl'}
{literal}

<script language='javascript'>

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


</script>
{/literal}

<div style="border:#999999 1px solid; background-color:#d4f2ff; min-height: 350px; margin-top:5px; width:1004px; margin:0 auto; padding: 10px;">
<center>{if isset($msg)}{$msg}{/if}</center>
<form name='update_service_reports' method='POST' action='service_reports.php' onSubmit="return validateForm();" >

<div class="my_heading">Service Reports</div>
<div id="area">
<br><br>
{if isset($data)}

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
 <th>  CutoffDate </th>
<th>  Submited Date </th>
<th>  Status </th>
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
<td>{$row.cutdate}</td>
<td>{$row.stadate}</td>
<td>{$status_list[$row.status_id]}</td>
 </tr>

{/foreach}

</tbody>
</table>
{else}

 <table width='97%' cellspacing="0"  border="1" cellpadding="5" id="example" style="border-collapse:collapse;">
<thead>

 	<tr style="background-color:#d1d1d1;"> 
     <th>Sno</th>
<th> Section Name </th>
 <th> Service Name </th>
 <th> Pending </th>
  <th>Completed </th>
  <th> Rejected</th>
  <th> Not Aplicable</th>
   <th>ON Hold</th>
  <th>With in SLA </th>
  <th>Out of SLA </th>
  <th>Total </th>
       </tr>


</thead>
<tbody>

{foreach from=$service_count key=i item=row}
<tr>
  <td>{counter}</td>
 <td>{$section_list[$row.section_id]}</td>
  <td>{$service_list[$row.service_id]}</td>
<td><a href="update_service_reports.php?service_id={$row.service_id}&type=1">{$row.pending}</a></td>
<td><a href="update_service_reports.php?service_id={$row.service_id}&type=2">{$row.completed}</a></td>
<td><a href="update_service_reports.php?service_id={$row.service_id}&type=3">{$row.rejected}</a></td>
<td><a href="update_service_reports.php?service_id={$row.service_id}&type=4">{$row.not_app}</a></td>
<td><a href="update_service_reports.php?service_id={$row.service_id}&type=6">{$row.on_hold}</a></td>

   <td><a href="update_service_reports.php?service_id={$row.service_id}&type=b">{$row.beforetim}</a></td>
   <td><a href="update_service_reports.php?service_id={$row.service_id}&type=o">{$row.outoftime}</a></td>
  <td><a href="update_service_reports.php?service_id={$row.service_id}&type=t">{$row.totcount}</a></td>


 </tr>

{/foreach}
</tbody>
</table>

{/if}
</div>


</div>
{include file='footer_print.tpl'}

{include file='footer.tpl'}
                            
                            
                            
                            
                            
                            
                            