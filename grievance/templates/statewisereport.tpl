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
                  <h4></h4>
                 
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
                  <h4></h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width"  id="data-table" width="100%">
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											<th>Service</th>
											<th>Received</th>
									   </tr>
									</thead>
									
									<tbody>
									    {foreach from=$data1 item=row key=cs_id}
										<tr>
											<td>{counter}</td>
											<td>{$data1[$cs_id]}</td>
											<td>{$data2[$cs_id]['num']}</td>
										
										</tr>
										{/foreach}
									
										
										
									</tbody>
									<!--<tfoot>
									    <tr>
									        <td colspan="2">Total</td>
									        	
											<td></td>
										
									    </tr>
									</tfoot>-->
								</table>
				</div>
			</div>
		</div>

{include file='footer_print.tpl'}


{include file='footer.tpl'}

