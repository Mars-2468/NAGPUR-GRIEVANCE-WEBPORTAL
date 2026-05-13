{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    		

    	
 
    	


<script>
function fill(ward_id,ward_desc)
{
	document.manage_wards.ward_id.value=ward_id;
	document.manage_wards.ward_desc.value=ward_desc;
} 

function delete_rec(cs_id)
{
	
	if(confirm('Do Your really want to delete this record'))
	{
	
		$.post('ajax_del_service.php',{cs_id:cs_id},function(data)
		{
		if(data==1)
		{
		alert('Service deleted successfully');
		window.location='update_services.php';
		}
		else if(data==0)
		{
		alert('Unable to delete , Try again');
		}
		else if(data==2)
		{
		alert('This service is mapped with employees, First change employees from this service , Then only You can delete this service');
		}
		
		});
	}

} 

function validateForm()
{
	var ward_desc=document.manage_wards.ward_desc.value;		
	if(ward_desc=='')
	{
		alert("Please Enter Ward No / Description");
		return false;
	}

	return true;
}
</script>
{/literal}




 




<div class="row" id="div_print">
		<div >
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>EXISTING SERVICES</h4>
                  
                </div>
                <!-- Title Bart End sample_1-->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
									
										<thead style="background-color:#2c3e50; color:#FFF;">
										
											<th>S.No</th>
											<th>Department</th>
											<th>Service Name</th>
											<th>Cut of days</th>
											<th>Fees</th>
											<th>Fine Per day</th>
											<th>Financial Implications</th>
											<th>Service Placed Through</th>
											
											<th>EDIT</th>
											<th>DELETE</th>
										
									</thead>
									
									
									
									{foreach from=$data item=row key=cs_id}
										<tr>
											<td>{counter}</td>
											<td>{$dept_list[$row.dept_id]}</td>
											<td>{$row.comp_desc}{if $row.telugu_description neq ''}/{$row.telugu_description}{else}{/if} 
											
											</td>
											<td>{$row.cutt_of_time}</td>
											<td>{$row.app_fee}</td>
											<td>{$row.fine_per_day}</td>
											<td>{$row.fin_impl}</td>
											<td>{$sp_list[$row.sp_id]}</td>
											<td align="center">
											
											 
                     <form action="update_service_doc_map.php" method="post">
                     
                     		<input type="hidden" name="cs_id" value="{$cs_id}">
	                      <button class="btn btn-success" name='update' type="submit">
	                      <span class="fa fa-pencil"></span> Edit
	                      </button>
	             </form>                     
                                           </td>
											<td align="center">
											{if !isset($ward_list1[$ward_id])}
					
                     <!-- <button class="btn btn-danger" onClick="delete_rec('{$cs_id}')">
                      <span class="fa fa-trash"></span> Delete
                      </button>	-->
		       {/if}</td>
					  </tr>
					 				{/foreach}
										
										
									
								</table>
				</div>
			
		</div>
</div>


{include file='footer_print.tpl'}

<br>

{include file='footer.tpl'}

