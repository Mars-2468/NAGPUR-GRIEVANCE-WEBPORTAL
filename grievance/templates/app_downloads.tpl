{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
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
<script>
function get_dists(rdmaid)
{
	$.post('ajax_getdists2.php',{rdmaid:rdmaid},function(data)
	{
		$("#distid").html(data);
	});
}


function get_ulbs(distid)
{
	$.post('ajax_getulbs2.php',{distid:distid},function(data)
	{
		$("#ulbid").html(data);
	});
}

</script>

{/literal}

<!--
<form action="app_downloads.php" method="POST">
  <div>
<div class="col-md-3">
<div class="form-group">
  <label  for="selectbasic">Select Region</label>
  <div>
    <select id="regionid" name="regionid" class="form-control" onchange="get_dists(this.value)">
     <option value="">---select---</option>
     {html_options options=$region_list selected=$region_id_sel}
    </select>
  </div>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
  <label for="selectbasic">Select District</label>
  <div>
    <select id="distid" name="distid" class="form-control" onchange="get_ulbs(this.value)">
      <option value="">---select---</option>
      {html_options options=$dist_list selected=$dist_id_sel}
      
      
    </select>
  </div>
</div>
</div>

<div class="col-md-3"> 
<div class="form-group">
  <label for="selectbasic">Select ULB</label>
  <div>
    <select id="ulbid" name="ulbid" class="form-control">
      <option value="">---select---</option>
      {html_options options=$ulb_list selected=$ulbid_id_sel}
      
    </select>
  </div>
</div>
</div>

<div class="form-group">
<input style="margin-top:25px;" type="submit" name="search1" value="Search" class="btn btn-success">

</div>
</div>
  
  </form>
  -->
  
<div class="row" id="div_print">
 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>ULB APP Installations</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
			<form  method="post" action="entry_app_downloads.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				
			<table class="table table-bordered" id="example">
			    <thead>
			        
			        <tr style="background-color:#2c3e50; color:#FFF;">
			            <th>Sno</th>
			            <th>District Name</th>
			            <th>ULB Name</th>
			            <th>No.of Previous Apps Installations</th>
			            <th>No.of Previous Active Installations</th>
			            
			            <th>No.of Present Apps Installations</th>
			            <th>No.of Present Active Installations</th>
			            
			            <th>% Apps Installations</th>
			            <th>% Active Installations</th>
			            
			            
			        </tr>
			    </thead>
				{assign var="i" value=0}
				<tbody>
				{foreach from=$ulb_list item=row key=ulbid}
				<tr>
				    	    <td>{counter} </td>
				    	    <td>{$dist_list[$ulbid]}</td>
					        <td>{$ulb_list[$ulbid]} </td>
							<td>{$data[$ulbid].no_of_downloads}</td>
							<td>{$data[$ulbid].no_of_active_installations}</td>
							<td>{$data[$ulbid].present_no_of_downloads}</td>
							<td>{$data[$ulbid].present_no_of_active_installations}</td>
							<td>{$data[$ulbid].percent_no_of_downloads}</td>
							<td>{$data[$ulbid].percent_no_of_active_installations}</td>
							
					
					</tr>
					{assign var="i" value=$i+1}
				{/foreach}
				</tbody>
				<tfoot>
				    <tr>
				    <td colspan="3">Total</td>
				    <td>{$total.no_of_downloads}</td>
				    <td>{$total.no_of_active_installations}</td>
				    <td>{$total.present_no_of_downloads}</td>
				    <td>{$total.present_no_of_active_installations}</td>
				    <td></td>
				    <td></td>
				</tr>
				    
				</tfoot>
				
			</table>
				
			</form>
		</div>
		</div>
	</div>
</div>

</div>



{include file='footer_print.tpl'}


{include file='footer.tpl'}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    	<script>
    	$(document).ready(function() {
    $('#example').DataTable({
        "bPaginate": false,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });
} );
    	
</script>

