{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    	
<style>
    
    table tr:nth-child(odd) {
 background-color: #f1f1f1;
}
table tr:nth-child(even) {
 background-color: #ffffff;
}
table.dataTable thead th, table.dataTable thead td {

padding:0px;
}

</style> 
    	


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


<form action="past3report.php" method="POST">
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
  
  
  
  
<div class="row" id="div_print">
 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>ULB Summery Report</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                    
                    
  <div>
      
      <a href="past3report.php?days_3=3&ulbid={$ulbid_id_sel}&distid={$dist_id_sel}&regionid={$region_id_sel}" class="btn btn-primary col-md-2" style="margin-right:5px;">Last 3Days</a>
      <a href="past3report.php?days_7=7&ulbid={$ulbid_id_sel}&distid={$dist_id_sel}&regionid={$region_id_sel}" class="btn btn-primary col-md-2"  style="margin-right:5px;">Last One week</a>
      <a href="past3report.php?days_30=30&ulbid={$ulbid_id_sel}&distid={$dist_id_sel}&regionid={$region_id_sel}" class="btn btn-primary col-md-2" style="margin-right:5px;">Last One month</a>
      <a href="past3report.php?days_60=60&ulbid={$ulbid_id_sel}&distid={$dist_id_sel}&regionid={$region_id_sel}" class="btn btn-primary col-md-2" style="margin-right:5px;">Last Two months</a>
      <a href="past3report.php?ulbid={$ulbid_id_sel}&distid={$dist_id_sel}&regionid={$region_id_sel}" class="btn btn-primary col-md-2">All</a>
  </div>
                    
                    <br> <br>
                    
			<form  method="post" action="entry_app_downloads.php" name="manage_wards"  class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				
				
		<div style="width:100%; overflow:auto;">

<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:13px;" class="display table-bordered table-striped table-condensed cf" id='example'>
    <thead>
  <tr style="background-color:#2c3e50; color:#FFF;">
    <td rowspan="3" align="center">S.No</td>
    <td rowspan="3" align="center">ULB Name</td>
    <td colspan="5" align="center">Complaint</td>
    <td colspan="5" align="center">Services</td>
  </tr>
  <tr style="background-color:#2c3e50; color:#FFF;">
    <td rowspan="2" align="center">Received</td>
    <td colspan="2" align="center">Redressed</td>
    <td colspan="2" align="center">Pending</td>
    <td rowspan="2" align="center">Received</td>
    <td colspan="2" align="center">Completed</td>
    <td colspan="2" align="center">Pending</td>
  </tr>
  <tr style="background-color:#2c3e50; color:#FFF;">
    <td align="center">Within SLA</td>
    <td align="center">Beyond SLA</td>
   <!-- <td align="center">Total</td>-->
    <td align="center">Within SLA</td>
    <td align="center">Beyond SLA</td>
    <!--<td align="center">Total</td>-->
    <td align="center">Within SLA</td>
    <td align="center">Beyond SLA</td>
    <!--<td align="center">Total</td>-->
    <td align="center">Within SLA</td>
    <td align="center">Beyond SLA</td>
    <!--<td align="center">Total</td>-->
  </tr>
  </thead>
  <tbody>
  {foreach from=$ulb_list item=row key=ulbid}
  {if $ulbid eq '207'} 
  {assign var='pending_beyond_sla' value=0} 
  {assign var='pending_within_sla' value=$comp_pending[$ulbid].withinsla + $comp_pending[$ulbid].beyondinsla }
  
  {assign var='pending_beyond_sla_ser' value=0} 
  {assign var='pending_within_sla_ser' value=$service_pending[$ulbid].withinsla + $service_pending[$ulbid].beyondinsla}
  
  {/if}
  <tr>
    <td align="center">{counter}</td>
    <td align="center">{$ulb_list[$ulbid]}</td>
    <td align="center">{$complaints[$ulbid].received}</td>
    <td align="center">{$comp_resolved[$ulbid].withinsla}</td>
    <td align="center">{$comp_resolved[$ulbid].beyondinsla}</td>
    <!--<td align="center">{$complaints[$ulbid].resolved}</td>-->
    <td align="center">{if $ulbid eq '207'}{$pending_within_sla}{else} {$comp_pending[$ulbid].withinsla}{/if}</td>
    <td align="center">{if $ulbid eq '207'}{$pending_beyond_sla}{else} {$comp_pending[$ulbid].beyondinsla}{/if}</td>
   <!-- <td align="center">{$complaints[$ulbid].pending}</td>-->
    <td align="center">{$services2[$ulbid].received}</td>
    <td align="center">{$service_resolved[$ulbid].withinsla}</td>
    <td align="center">{$service_resolved[$ulbid].beyondinsla}</td>
    <!--<td align="center">{$services2[$ulbid].resolved}</td>-->
    <td align="center">{if $ulbid eq '207'}{$pending_within_sla_ser}{else} {$service_pending[$ulbid].withinsla}{/if}</td>
    <td align="center">{if $ulbid eq '207'}{$pending_beyond_sla_ser}{else} {$service_pending[$ulbid].beyondinsla}{/if}</td>
    <!--<td align="center">{$services2[$ulbid].pending}</td>-->
  </tr>
  {/foreach}
 </tbody>
 <tfoot>
     
     <td colspan="2">Total</td>
     <td>{$data.comp_tot_received}</td>
     <td>{$data.comp_redressed_withinsla}</td>
     <td>{$data.comp_redressed_beyondinsla}</td>
     <td>{$data.comp_pending_withinsla + $comp_pending['207'].beyondinsla - 6}</td>
     <td>{$data.comp_pending_beyondsla - $comp_pending['207'].beyondinsla + 6}</td>
     <td>{$data.services_tot_reived}</td>
     <td>{$data.ser_redressed_resolvedsla}</td>
     <td>{$data.ser_redressed_beyondsla }</td>
     <td>{$data.ser_pending_withinsla + $service_pending['207'].beyondinsla - 2}</td>
     <td>{$data.ser_pending_beyondsla - $service_pending['207'].beyondinsla + 2}</td>
 </tfoot>
</table>


</div>
				
			</form>
		</div>
		</div>
	</div>
</div>

</div>



{include file='footer_print.tpl'}


{include file='footer.tpl'}

