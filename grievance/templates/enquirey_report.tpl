{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    <script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('http://municipalservices.in/manage_wards.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>	

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
	    var csrf_token=$("#csrf_token").val();
		$.post('ajax_del_ward.php',{ward_id:ward_id,csrf_token:csrf_token},function(data)
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
		else if(data==3)
		{
		    alert('Invalid token');
		}
		else if(data==4)
		{
		    alert('csrf error');
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
		<div>
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4> Enquiries </h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											<th>Enquiry For</th>
											<th>Person name</th>
											<th>Mobile</th>
											<th>From</th>
											<th>District Name</th>
											<th>ULB Name</th>
											<th>Mandal Name</th>
											<th>Village Name</th>
											<th>Remarks</th>
											<th>Enq.Date</th>
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$data item=row key=id}
										<tr>
											<td>{counter}</td>
											<td>{$row.listdesc}</td>
											<td>{$row.name}</td>
											<td>{$row.mobile}</td>
											<td>{$row.fromid}</td>
											<td>{$row.distname}</td>
											<td>{$row.ulbname}</td>
											<td>{$row.mandalname}</td>
											<td>{$row.village_desc}..</td>
											<td>{$row.remarks}</td>
											<td>{$row.datetime}</td>
											
										
											
                       
										</tr>
										{/foreach}
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>

{include file='footer_print.tpl'}


{include file='footer.tpl'}

