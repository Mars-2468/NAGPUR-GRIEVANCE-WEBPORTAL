{include file='header.tpl'}
{literal} 

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
 

<div class="boxed">
    <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
        <h4>Search Complaint</h4>
        <!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
		<p class="m-0"><a href="reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
    </div>

    
    <div class="title-bar" style="background-color:#2c3e50;"><h4> Complaint No. </h4></div>
    
    <div class="inner no-radius">
        
        <div style="text-align:right; margin-top:0px; font-size:12px; font-weight:bold; color:blue;">To Search : Enter data in textbox and press ENTER</b></div>

       

        
        <div class="mb-3">
<form action="" method="post">    
    
    
    
                 <div class="form-body mb-3">
				{if $flash}
					<div class="{$flash.class}">
					<button class="close" data-close="alert"></button>
						{$flash.msg}
					</div>
				{/if} 
					<div class="form-group">
        						<label class="control-label col-md-2">Reference no: <span class="required">* </span></label>
        							<div class="col-md-5 mb-2">
        							    <input type="text" name="ref_no" placeholder="File no" value="{$ref_no}" class="form-control" required>
        							
        							</div>
        							<div class="col-md-2 mb-2">	<input type="submit" name="search" value="Search" class="form-control btn btn-success"></div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
					
						</div>
					</div>
				</div>
                
                
   
  </form>  
    
		</div>
<div class="clearfix"></div>
		 
	<hr>
    
		
		<div style="color:red;text-align:center";><h3>{if isset($msg)}{$msg}{/if}</h3></div>
	
	
	
<form name='manage_comp_det' id='manage_comp_det' action='search_complaint.php' method='POST'>
<div id="demo">
    
	<div >
	       <div  id="area" class="table-responsive">
<table  cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
<thead>
  <tr style="--bs-table-bg:#2c3e50 !important;">
  	<th  align='left'><font color='white'>S.No</font></th>
  	<th  align='left'><font color='white'>Mode</font></th>
  	<th  align='left'><font color='white'>File No</font></th>
  	<th  align='left'><font color='white'>Name & Mobile</font></th>
  	<th  align='left'><font color='white'>Ward</font></th>
  	<th  align='left'><font color='white'>Complaint/Service</font></th>
  	<th  align='left'><font color='white'>Departemnt</font></th> 
  	<th  align='left'><font color='white'>Current status</font></th>
  	<th  align='left'><font color='white'>Employee</font></th> 
  	<th  align='left'><font color='white'>Department</font></th>
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
	<td><a href="view_search_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
	{/if}
	{else}
	<td><a href="view_search_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
	{/if}
	<td>{$row.person_name} ({$row.mobile})</td>
	<td>{$ward_list[$row.ward_id]}</td>
		{if $row.app_type_id eq '1'}
            <td ><label style="font-weight:normal !important;" title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}  {if $data[$grievance_id].comp_desc neq ''} - {$data[$grievance_id].comp_desc} {/if}</label></td>
            {else}
            <td ><label style="font-weight:normal !important;"  title="{$row.comp_desc}">{$cat3_list[$row.cat3_id]}</label></td>
        {/if}
	<td>{$dept_list[$row.dept_id]}</td>
	<td>{$grievance_status_list[$row.grievance_status_id]}</td>
	<td>{$emp_list[$row.emp_id]}</td>
	<td>{$dept_list[$row.dept_id]}</td>
</tr>
{/foreach}
</tbody>
</table>
	</div></div>
</div>
</form>
        
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