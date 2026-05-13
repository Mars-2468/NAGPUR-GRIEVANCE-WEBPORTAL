{include file='header.tpl'}
{literal}

<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="actb.js"></script>
<script language="javascript" type="text/javascript" src="tablefilter.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>

<script language="javascript">

    function get_comp_det(grievance_id) {

        document.forms["manage_comp_det"].submit();
    }
    function get_comp_det_emp(grievance_id) {

        document.forms["manage_comp_det_emp"].submit();
    }

    function fun1(app_type_id) {
        $.post('ajax_get_search_cat3ids.php', {
            app_type_id: app_type_id
        }, function(data) {
            $("#cat3_id").html(data);
        });
    }
	
</script>

{/literal}


<div class="boxed">

	<div class="row" style="background-color: #e3f6f5; ">
		
		<div style="background-color: #0066CC; color: #FFF; padding: 5px; font-size: 15px;display:flex; justify-content:space-between;align-items:center">
			<div>Complaint Details and Movements</div>			
			<div style=""><a href="emp_hod_status121_rating_list_report.php?rating_no={$rating_no}&department_id={$department_id}" class="btn btn-warning">Back</a></div>	
		</div>
      
	</div>
    
	<div class="inner no-radius table-responsive">
   
        
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table"   >
 

 <tr>
    
    <td align="left" valign="top">
    
<table width="100%" border="1" cellspacing="1" cellpadding="0" class="table"  style="font-size:13px;">

      <tr style="background-color:#3366CC; color:#FFF; " >
	  
        <th colspan='2' height="12" align="center" valign="middle">COMPLAINT DETAILS</td>
    </tr>


      <tr>
        <th height="12" width="100" align="left" style="padding-left:5px;" valign="middle" style="background-color:#3366CC; color:#FFF; ">Complaint Id</th>
        <td align="left" valign="middle" style="padding-left:10px;">{$data.grievance_id}</td>
    </tr>

      <tr>
        <th height="12" align="left" valign="middle" style="padding-left:5px;" style="background-color:#3366CC; color:#FFF; ">Name</th>
        <td align="left" valign="middle" style="padding-left:10px;">{$data.person_name}</td>
    </tr>

      <tr>
         <th height="12" align="left" valign="middle" style="padding-left:5px;" style="background-color:#3366CC; color:#FFF; ">Mobile</th>
        <td align="left" valign="middle" style="padding-left:10px;">{$data.mobile}</td>
    </tr>

      <tr>
        <th height="12" align="left" valign="middle" style="padding-left:5px;" style="background-color:#3366CC; color:#FFF; ">Address</th>
        <td align="left" valign="middle" style="padding-left:10px;">{$data.hno},{$data.address}, Locality : {$street_list[$data.street_id]} , Ward : {$ward_list[$data.ward_id]}</td>
    </tr>
     <tr>
        <th height="12" align="left" valign="middle" style="padding-left:5px;" style="background-color:#3366CC; color:#FFF; ">email</th>
        <td align="left" valign="middle" style="padding-left:10px;">{$data.email}</td>
    </tr>    
    
      <tr>
        <th height="12" align="left" valign="middle" style="padding-left:5px;" style="background-color:#3366CC; color:#FFF; ">Received Through</th>
        <td align="left" valign="middle" style="padding-left:10px;">{$grievance_origin_list[$data.grievance_origin_id]}</td>
    </tr>

      <tr>
         <th height="24" align="left" valign="middle" style="padding-left:5px;" style="background-color:#3366CC; color:#FFF; ">Subject</th>
        <td align="left" valign="middle" style="padding-left:10px;">{$data.comp_subject}</td>
    </tr>    

      <tr>
        <th height="24" align="left" valign="middle" style="padding-left:5px;" style="background-color:#3366CC; color:#FFF; ">Description</th>
        <td align="left" valign="middle" style=" padding:0px 10px 10px 10px; text-align:justify;">{$data.comp_desc}</td>
    </tr>
       <tr>
        <th height="12" align="left" valign="middle" style="padding-left:5px;" style="background-color:#3366CC; color:#FFF; ">Status</th>
        <td align="left" valign="middle" style="padding-left:10px;">{$grievance_status_list[$data.grievance_status_id]}</td>
    </tr>
	
	<tr>
        <th height="12" align="left" valign="middle" style="padding-left:5px;" style="background-color:#3366CC; color:#FFF; ">Complaint Photo</th>
		{if $data.file_url eq '#' || $data.file_url eq ''}
        <td align="left" valign="middle" style="padding-left:10px;">Photo not uploaded</td>
		{else}
		<td align="left" valign="middle" style="padding-left:10px;"><img src='{$data.file_url}' width="100px" height="100px"></td>
		{/if}
    </tr>
	
	
    {if $data.grievance_status_id neq '1'}
       
    <tr>
            <td colspan='2' border="1" align="center">
            
            <table>
            <tr>
			<br>
			<td height="12" align="center" valign="middle" colspan="1"><strong>GRIEVANCE MOVEMENT</strong></td>
			<br>
			<br>
       </tr>
            </table>
            
    		<table border="1"  class="table" style="font-size:13px;">        
            
    		<tr style="background-color:#3366CC; color:#FFF; ">
    			<th width="50">S.No</th>
    			<th width="100">Department</th>
    			<th>Designation</th>
    			<th>Employee</th>
    			<th>Contact</th>
    			<th>Allotted On</th>    			    			    			    			
    			<th>Status</th>
    			<th>Disposed On</th>
    			<th>Updated By</th>
    			<th>Remarks</th>
				<th>Resolved photo</th>
    		</tr>
  
    {foreach from=$data.transactions item=row key=transaction_id}
    	<tr>
    		<td align="center">{$transaction_id}</td>
    		<td align="center">{$empt_list[$row.emp_id]['emp_dept']}</td>
    		<td align="center">{$empt_list[$row.emp_id]['emp_desg']}</td>
    		<td align="center">{$empt_list[$row.emp_id]['emp_name']}</td>
    		<td align="center">{$empt_list[$row.emp_id]['emp_mobile']}</td>
    		<td align="center">{$row.alloted_date}</td>
    		<td align="center">
    		    {if $row.is_escalated eq '1' && $row.disposal_status eq '5'}
    		        Escalated
    		    {else}
    		       {$grievance_status_list[$row.disposal_status]}
    		    {/if}
    		</td>
    		<td align="center">{if $row.disposed_date eq '0000-00-00'}-{else} {$row.disposed_date} {/if}</td>
    		<td align="center">
    		    {if $row.updated_by neq '' && $row.updated_by neq 'System'}
    		        {$user_list[$row.updated_by]['user_name']}
    		    {else}
    		        {if $row.updated_by neq ''} 
    		            {$row.updated_by}
					{else}	
						-
    		        {/if}
    		    {/if}    		   
    		</td>
    		<td align="center">{$row.disposal_remarks}</td>
			<td align="center">
			    <span class="btn quick_preview" data-src="{if $row.file_url eq ''}default-img.png{else} {$row.file_url} {/if}"><img src="{if $row.file_url eq ''}default-img.png{else}{$row.file_url}{/if}" width='50px' height='50px'></span>
			</td>
    	</tr>
    	
    {/foreach}
    		</table>
     	</td>
    </tr> 
    {/if} 
    
</table>
  </td>
    
 </tr>
</table>
		
		
		
    </div>
   
  


	
      
</div>

<strong></strong><br />

{literal}
<script language="javascript" type="text/javascript">
    var table2_Props = {
        col_0: "none",
        col_1: "select",
        col_3: "select",
        col_5: "select",
        col_6: "none",
        display_all_text: " [ Show all ] ",
        sort_select: true,
        paging: true,
        paging_length: 6,
        alternate_rows: true
    };
    setFilterGrid("example", table2_Props);
</script>



<script language="javascript" type="text/javascript">
	$(document).ready(function() {
  // Initially hide the Sub Options dropdown and set it as optional
  var subOptionsDropdown = $('#grievance_sub_options');
  subOptionsDropdown.hide();
  subOptionsDropdown.prop('required', false);

  // Attach change event handler to the Rating dropdown
  $('#grievance_status_id').change(function() {
    var selectedValues = $(this).val();
    var selectedValuesArray = Array.isArray(selectedValues) ? selectedValues : [selectedValues];

    // Check if any of the selected values are 3, 4, or 5
    var showSubOptions = selectedValuesArray.some(function(value) {
      return value === '1' || value === '2' || value === '3';
    });

    // Show or hide the Sub Options dropdown based on the condition
    if (showSubOptions) {
      subOptionsDropdown.show();
      subOptionsDropdown.prop('required', true);
    } else {
      subOptionsDropdown.hide();
      subOptionsDropdown.prop('required', false);
    }
  });
});
</script>
{/literal}
<div>
</div>

{include file='footer.tpl'}