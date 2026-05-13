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
  
  
  
  
  
  
  <form action="cdma_empwise_report.php" method="POST">
      <input type="hidden" name="app_type_id" value="{$app_type_id}">
      <input type="hidden" name="dept_id" value="{$dept_id}">
      
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
  
  
  
  
  
					<table  class="display table-bordered table-striped table-condensed cf" id="data-table">
									
										<thead>
										<tr style="background-color:#2c3e50; color:#FFF;">
											<td >S.No</td>
											<td >ULB name</td>
											<td >Emp Name</td>
											<td>Designation</td>
											<td>Employee Level</td>
											<td>Ward name</td>
											<td>Street name</td>
											<td>GRIEVANCE SUB CATEGORY</td>
										
										</tr>
										
										
									
									
									
								
									</thead>
									
									<tbody>
									
									{foreach from=$data key=key item=row}
									<tr>
									        <td >{counter}</td>
									        <td >{$ulblist[$row.ulbid]}</td>
											<td >{$emp_list[$row.emp_id]}</td>
											<td>{$desg_list[$row.desg_id]}</td>
											<td>1</td>
											<td>{$wardlist[$row.ward_id]}</td>
											<td>{$streelist[$row.street_id]} </td>
											<td>{$cslist[$row.cs_id]}</td>
										</tr>	
									{/foreach}
									</tbody>
									
								</table>
				
{include file='footer_print.tpl'}

  
  
  
  
  
  
  
  
                
                  
                  
                    
                
                

				
					
			  


