{include file='header.tpl'}
{literal}
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="actb.js"></script>
<script language="javascript" type="text/javascript" src="tablefilter.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
<script language="javascript">

function get_comp_det(grievance_id)
{
	
	document.forms["manage_comp_det"].submit();
}

function fun1(app_type_id)
{
   $.post('ajax_get_search_cat3ids.php',{app_type_id:app_type_id},function(data)
   {
       $("#cat3_id").html(data);
   });
}


</script>
{/literal}

<br />

<div class="boxed">
    
    <div class="title-bar success"><h4>Search Grievance</h4></div>
    
    <div class="inner no-radius">
        
        

        
        
        <div style="height: 96px; background-color: #ecfbfc; padding-top: 1px;">
<form action="search_grievance.php" method="post">  
    
                 <div class="form-body">
                     
                     <div class="form-group">
        					 
        							<div class="col-md-3">
        							    <label class="control-label">Select ULB</label>
        							    <select name="ulbid" id="ulbid" class="form-control">
        							        <option value="">--- select ---</option>
        							        {html_options options=$ulblist}
        							    </select>
        							    
        							
        							</div>
        							
					</div>
				
					<div class="form-group">
        						
        							<div class="col-md-3">
        							    <label class="control-label ">Reference No </label>
        							    <input type="text" name="ref_no" placeholder="File no" value="{$ref_no}" class="form-control">
        							
        							</div>
        							
					</div>
					
					<div class="form-group">
        						
        							<div class="col-md-3">
        							    <label class="control-label ">Name </label>
        							    <input type="text" name="applicant_name" placeholder="" value="" class="form-control">
        							
        							</div>
        							
					</div>
					
					<div class="form-group">
        						
        							<div class="col-md-3">
        							    <label class="control-label ">Mobile </label>
        							    <input type="text" name="mobile" placeholder="" value="" class="form-control">
        							
        							</div>
        							
					</div>
					
					<div class="col-md-2" style="padding-top: 25px;">	<input type="submit" name="search" value="Search" class="form-control btn btn-success"></div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
				 
						</div>
					</div>
				</div>
                
                
   
  </form>  
    
		</div>
		 
	<hr>
    
		
		<div style="color:red;text-align:center";><h3>{if isset($msg)}{$msg}{/if}</h3></div>
	
	
	

<div id="demo">
    
	<div >
	       <div  id="area">
<table  cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
<thead>
  <tr style="background-color:#2c3e50;">
  	<th  align='left'><font color='white'>S.No</font></th>
  	<th  align='left'><font color='white'>Mode</font></th>
  	<th  align='left'><font color='white'>File No</font></th>
  	<th  align='left'><font color='white'>Name & Mobile</font></th>
  	<th  align='left'><font color='white'>Ward</font></th>
  	<th  align='left'><font color='white'>Complaint/Service</font></th>
  	
  	<th  align='left'><font color='white'>Current status</font></th>
  	<th  align='left'><font color='white'>Employee</font></th> 
  	<th  align='left'><font color='white'>Update</font></th> 
  	
  </tr>
</thead>
<tbody>
{foreach from=$data key=grievance_id item=row}
<input type="hidden" name="app_type_id" value="{$row.app_type_id}">
<input type="hidden" name="cs_id" value="{$row.cat3_id}">
<tr>
	<td>{counter}</td>
	<td>
	{if $row.app_type_id eq '2'}
	Citizen Charter Counter
	{else}
	{$grievance_origin_list[$row.grievance_origin_id]}
	
	{/if}
	
	</td>
	{if $ulbid eq '207'}
	{if $row.app_type_id eq '2'}
	<td>{$row.file_no}</td>
	{else}
	<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
	{/if}
	{else}
	<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
	{/if}
	<td>{$row.person_name} ({$row.mobile})</td>
	<td>{$row.ward_desc}</td>
	
            <td ><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]} </label></td>
           
	
	<td>{$grievance_status_list[$row.grievance_status_id]}</td>
	<td>{$emp_list[$row.emp_id]}</td>
	<td>
	    
	    <form action="updateagentgrievance.php" method="post">
	        <input type="hidden" name="grievance_id" value="{$grievance_id}">
	        <input type="hidden" name="app_type_id" value="1">
	        <input type="submit" name="update" class="btn btn-warning" value="View & Rate">
	    </form>
	    
	</td>
	
</tr>
{/foreach}
</tbody>
</table>
	</div></div>
</div>

        
    </div>
    
</div>






{literal}
<script language="javascript" type="text/javascript">
	var table2_Props = 	{
							col_0: "none",
							col_1: "select",
							col_3: "select",
							col_5: "select",
							col_6: "none",
							display_all_text: " [ Show all ] ",
							sort_select: true ,
							paging: true ,
							paging_length: 6,
							alternate_rows: true
						};
	setFilterGrid( "example",table2_Props );
</script>
{/literal}
<div>
</div>
{include file='footer_print.tpl'}
{include file='footer.tpl'}