{include file='header.tpl'}
{literal}


<!--<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<!--<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    	

<script>
function fill(ward_id,ward_desc)
{
	document.manage_wards.ward_id.value=ward_id;
	document.manage_wards.ward_desc.value=ward_desc;
} 

function delete_ward(ward_id)
{
	
	if(confirm('Do You really want to delete this record'))
	{
	
		$.post('ajax_del_ward.php',{ward_id:ward_id},function(data)
		{
		if(data==1)
		{
		alert('Ward deleted successfully');
		window.location='manage_wards.php';
		}
		else if(data==0)
		{
		alert('Unable to delete , Try again');
		}
		else if(data==2)
		{
		alert('Ward is mapped with employees You cannot delete this ward');
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




 <div class="row ">
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Add Wards</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
		
		</div>
		</div>
	</div>
</div>




<div class="row" id="div_print">
		<div>
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>Wards</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                    <table class="table table-striped table-bordered table-hover table-full-width"  id="data-table" width="100%">
                       	<thead>
										  
										<tr class="mytr_bgcolor">
											<td>S.No</td>
											<td> Complaint  Name </td>
											<td>Received</td>
										    <td>Resolved</td>
										    
											
										</tr>
										</thead>
										<tbody>
										    {foreach from=$cs_list item=row key=cs_id}
										<tr>
										    <td>{counter}</td>
										    <td>{$cs_list[$cs_id]}</td>
										    <td>{$received[$cs_id].count}</td>
										    <td>{$completed[$cs_id].count}</td>
										  </tr>
										    {/foreach}
										</tbody>
										<tfoot>
										    <tr>
										        <td colspan="2">Total</td>
										        <td>{$tot['received']}</td>
										        <td>{$tot['completed']}</td>
										    </tr>
										    
										</tfoot>
					</table>					
                    
                  <!--  <table class="table table-striped table-bordered table-hover table-full-width"  id="data-table" width="100%">
                       	<thead>
										  
										<tr class="mytr_bgcolor">
											<td>S.No</td>
											<td> Category Name </td>
											<td>No.of Resolved Services</td>
										    <td>Services Avg Response Time[In Days]</td>
										    <td>No. of days to be resolved in as per Citizen Charter</td></td>
											
										</tr>
										</thead>
										<tbody>
										{foreach from=$cat_list item=row key=cs_id}
										<tr>
										    <td>{counter}</td>
										    <td><a href="category-wise-ulb-response-time.php?cat_id={$cs_id}">{$cat_list[$cs_id]}</a></td>
										    <td>{$response_time[$cs_id]['services'].count}</td>
										   <td>{$response_time[$cs_id]['services'].avg_res_time}</td>
										   <td>{$timefrmaelist[$cs_id].timeframe}</td>
									
										</tr>
										
										{/foreach}
									
										
										</tbody>
										
										
									
								
									<tfoot>
									    
									     <tr>
									       
									    </tr>
	<tr>
										    <td>Total:</td>
										    <td>--</td>
										    <td>{$grand_total_services}</td>
										   <td>{$grand_s_avg_res_time}</td>
										    
										</tr>
									</tfoot>
                        </table>
                    
                  <!-- <table class="table table-striped table-bordered table-hover table-full-width"  id="data-table" width="100%">
							
							    <tbody>
							    {foreach from=$cs_list key=cs_id item=row}
							    <tr>
							    <td>sno</td>
							    <td>{$cs_list[$cs_id]}</td>
							    </tr>
							    
            							    {foreach from=$ward_list_notmapped[$cs_id] item=row key=ward_id}
            							    <tr style='background-color:yellow'>
            							    <td>{counter}</td>
            							    <td>{$ward_list[$ward_id]}</td>
            							    </tr>
            							    {/foreach}
							    
							    
							    {/foreach}
							    
							    </tbody>-->
							
				<!--	<table class="table table-striped table-bordered table-hover table-full-width"  id="data-table" width="100%">
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											<th>Ulbname</th>
											{foreach from=$status_list item=row key=status_id}
											<th>{$status_list[$status_id]}</th>
											{/foreach}
											
										
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$ulb_list item=row key=ulbid_id}
										<tr>
											<td>{counter}</td>
											<td>{$ulb_list[$ulbid_id]}</td>
											{foreach from=$status_list item=row2 key=status_id}
											<td>{$data[$ulbid_id][$status_id].count}</td>
											{/foreach}
											
											
                       
										</tr>
										{/foreach}
										
										
									</tbody>
									<tfoot>
									    <tr>
									        <td colspan="2">Total</td>
									        	{foreach from=$status_list item=row2 key=status_id}
											<td>{$data[$status_id].total}</td>
											{/foreach}
									    </tr>
									</tfoot>
								</table>-->
				</div>
			</div>
		</div>

{include file='footer_print.tpl'}


{include file='footer.tpl'}

