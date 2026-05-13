{include file='header.tpl'}

{literal}
<style>
.bash_heading{
	border-top: 1px solid #D5DDDF;
    text-align: left;
    padding: 10px !important;
    background-color: #fff;
	clear:both;
	font-weight:bold;
	font-size:16x;
	color:#000;
	}
</style>
<script>
function get_dists(rdmaid)

{
	$.post('ajax_getdists.php',{rdmaid:rdmaid},function(data)
	{
		$("#distid").html(data);
	});
}


function get_ulbs(distid)
{
	$.post('ajax_getulbs.php',{distid:distid},function(data)
	{
		$("#ulbid").html(data);
	});
}

</script>






{/literal}

  <!-- Breadcrumbs Start -->

  <!-- Breadcrumbs End -->
  
  
  
  
  
  
  <form action="ulbwise_report.php" method="POST">
  <div>
<div class="col-md-3">
<div class="form-group">
    
  <label  for="selectbasic">Select Region</label>
  <div>
    <select id="regionid" name="regionid" class="form-control" onchange="get_dists(this.value)" required>
     <option value="">---select---</option>
     {html_options options=$region_list selected=$preg}
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
      {html_options options=$dist_list2 selected=$pdist}
      
      
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
      {html_options options=$ulb_list2 selected=$pulb}
      
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
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>ULB Wise Report</h4>
                  
                </div>
                <!-- Title Bart End id="data-table"-->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width">
									
										<thead>
										<tr style="background-color:#2c3e50; color:#FFF;">
											<td rowspan="2">S.No</td>
											<td rowspan="2">ULB Name</td>
											<td colspan="2" align="center">Complaints</td>
											<td colspan="2" align="center">Services</td>
											
											
										</tr>
										
										
									
									<tr style="background-color:#2c3e50; color:#FFF;">
									<td align="center">Recieved</td>
									<td align="center">Resolved</td>
									<td align="center">Recieved</td>
									<td align="center">Resolved</td>
									
									</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$ulb_list1 key=ulbid item=row}
									<tr>
										<td>{counter}</td>
										<td>{$ulb_list[$ulbid]}</td>
										<td>{if $tot_complaints[$ulbid].servicecount neq ''}
						<a href="ulb_wise_report.php?ulbid={$ulbid}&app_type_id=1&id=1" target="_blank">{$tot_complaints[$ulbid].servicecount}</a>
										{else}-{/if}</td>
										<td>{if $res_complaints[$ulbid].servicecount neq ''}
						<a href="ulb_wise_report.php?ulbid={$ulbid}&app_type_id=1&id=2" target="_blank">{$res_complaints[$ulbid].servicecount}</a>
										{else}-{/if}</td>
										<td>{if $datalist[$ulbid].servicecount neq ''}
						<a href="ulb_wise_report.php?ulbid={$ulbid}&app_type_id=2&id=1" target="_blank">{$datalist[$ulbid].servicecount}</a>
										{else}-{/if}</td>
										<td>{if $res_services[$ulbid].servicecount neq ''}
						<a href="ulb_wise_report.php?ulbid={$ulbid}&app_type_id=2&id=2" target="_blank">{$res_services[$ulbid].servicecount}</a>
										{else}-{/if}</td>
										
										
									</tr>
									{/foreach}
									<tr style="background-color:#b5f2ea;">
									   <td colspan="2" align="center">Total</td>
									   <td>{$tot_rec_c}</td>
									   <td>{$tot_red_c}</td>
									   <td>{$tot_rec_s}</td>
									   <td>{$tot_red_s}</td>
									</tr>
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>
</div>
{include file='footer_print.tpl'}

  
  
  
  
  
  
  
  
                
                  
                  
                    
                
                

				
					
			  


