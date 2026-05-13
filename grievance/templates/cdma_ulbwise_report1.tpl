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
  
  
  
  
  
  
  <form action="cdma_ulbwise_report1.php" method="POST">
      <input type="hidden" name="app_type_id" value="{$app_type_id}">
  <div>
<div class="col-md-3">
<div class="form-group">
    
  <label  for="selectbasic">Select status</label>
  <div>
    <select id="status" name="status" class="form-control" >
     <option value="">---select---</option>
     {html_options options=$status_desc selected=$status}
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
					<table class="display table-bordered table-striped table-condensed cf" id="data-table">
									
										<thead>
										<tr style="background-color:#2c3e50; color:#FFF;">
											<td >S.No</td>
											<td >ULB Name</td>
											<td  align="center">{$apptypes[$app_type_id]} ({$status_desc[$status]})</td>
										
										</tr>
										
										
									
									
									
								
									</thead>
									
									<tbody>
									
									{foreach from=$ulb_list key=ulbid item=row}
									<tr>
										<td>{counter}</td>
										<!--<td>{if $status eq '1'}<a href="ulb_cat_wise1.php?ulbid={$ulbid}&status={$status}">{$ulb_list[$ulbid]}</a>{else}<a href="ulb_dept_wise1.php?ulbid={$ulbid}&status={$status}">{$ulb_list[$ulbid]}{/if}</a></td>----->
										<td>{$ulb_list[$ulbid]}</td>
										<td>
						    
						    
						    {$data[$ulbid].count} 
						   
						    
						    
						    
						   
									    </td>
										
										
									</tr>
									{/foreach}
									</tbody>
									<tfoot>
									<tr style="background-color:#b5f2ea;">
									   <td colspan="2" align="center">Total</td>
									   <td>
									       
									       
						    {$tot} 
						    
									       
									       
									   </td>
									   
									</tr>
								</tfoot>		
										
								
								</table>
				</div>
			</div>
		</div>
</div>
{include file='footer_print.tpl'}
{include file='footer.tpl'}

  
  
  
  
  
  
  
  
                
                  
                  
                    
                
                

				
					
			  


