<link rel="stylesheet" type="text/css" href="jquery.tablescroll.css"/>
<link rel="stylesheet" type="text/css" href="jquery-ui-1.8.17.custom.css"/>
{literal}

<link rel="stylesheet" href="./css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">


<style>

table tr:nth-child(odd) {
 background-color: #f1f1f1;
}
table tr:nth-child(even) {
 background-color: #ffffff;
}


@media (max-width: 767px) {
            .nav-header {
                font-size: 10px !important;
            }
        }
        .nav-header {
            background-color: #0066CC;
            color: #FFF;
            padding: 5px;
            text-align: center;
            font-size: 22px;
        }


</style>

{/literal}

<body style="padding:0px; margin:0px;">

<div class="row" style="background-color:#0b1c40;">
<div class="container">

</div>

<div class="nav-header">
<div class="container" style="line-height: 6px;padding-bottom: 15px;">
	<img src="images/nagpur-logo.png" style="width:50px;"> 
<!-- <strong>New Problem Registration </strong> -->
<strong>NAGPUR MUNICIPAL CORPORATION /  <br> नागपूर महानगरपालिका</strong>
<!--<img src="images/smart-city.png" style="width:50px;"> -->
</div>
</div>
</div>

</div>




<div class="main_content">

<div class="form_bg_color">
<div style="padding:0px; height:auto;">
<div style="border:#FFFFFF 1px solid; border-radius:10px; " class="col-md-12">


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
    		        {$empt_list[$row.updated_by]['emp_name']}
    		    {else}
    		        {if $row.updated_by neq ''} 
    		            System
    		        {/if}
    		    {/if}
    		   
    		    </td>
    		<td align="center">{$row.disposal_remarks}</td>
			<td align="center">
			    <span class="btn quick_preview" data-src="{if $row.file_url eq ''}default-img.png{else} {$row.file_url} {/if}"><img src="{if $row.file_url eq ''}default-img.png{else} {$row.file_url} {/if}" width='50px' height='50px'></span>
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




<div style="padding-left:125px; padding-top:25px; font-size:11px;"></div>
</div>
</div>

</div>

{if $row.app_type_id eq '2'}
<center><INPUT TYPE="BUTTON" VALUE="BACK TO SEARCH RESULTS" ONCLICK="history.go(-1)" class="btn btn-success"></center>
<br />
{/if}





</div>


{include file='footer.tpl'}
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>

    $(document).on('click', '.quick_preview', function(e){
        Swal.fire({
          imageUrl: $(this).attr('data-src'),
          imageHeight: 350,
          imageAlt: 'A tall image',
          padding: '0.8em',
          showCloseButton: true,
          width: '600px',
           showConfirmButton: false
        })
    })
</script>