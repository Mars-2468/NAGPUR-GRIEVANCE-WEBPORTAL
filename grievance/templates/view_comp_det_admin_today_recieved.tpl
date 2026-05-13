{include file='header.tpl'}
{literal}

<style>
div.grievance_image img {
		height:100%;
		width:100;
		object-fit: contain;
		overflow: hidden;
	}
	
	table thead tr th{
		color:#FFF !important;
	}
	
</style>
{/literal}




{if isset($data)}
<div style="text-align:right;"><button class="btn btn-warning" onclick="location.href='tot_received.php?aptid=1&status=111&sla=0&user_type={$user_type}'"><i class="fa fa-backward"></i> Back</button></div><br>
<div class="table-responsive" id="area">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">

        <table width="97%" border="0" cellspacing="2" cellpadding="0" class="display table table-striped table-bordered table-hover table-full-width dataTable" id="example">
          <tr style="background-color:#2c3e50; color:#FFF;">
            <th colspan='9' height="15" align="center" valign="middle">COMPLAINT DETAILS
      </td>
    </tr>

    <tr>
      <th height="15" align="left" valign="middle">ULB name</th>
      <td align="left" valign="middle">{$ulblist[$data.ulbid]}</td>
    </tr>
    <tr>
      <th height="15" align="left" valign="middle">Complaint Id</th>
      <td align="left" valign="middle">{$data.grievance_id}</td>
    </tr>

    <tr>
      <th height="15" align="left" valign="middle">Name</th>
      <td align="left" valign="middle">{$data.person_name}</td>
    </tr>

    <tr>
      <th height="15" align="left" valign="middle">Mobile</th>
      <td align="left" valign="middle">{$data.mobile}</td>
    </tr>

    <tr>
      <th height="15" align="left" valign="middle">Address</th>
      <td align="left" valign="middle">{$data.address}, Locality : {$street_list[$data.street_id]} , Ward : {$ward_list[$data.ward_id]}</td>
    </tr>
    <tr>
      <!-- <th height="15" align="left" valign="middle"  >email</th>
        <td align="left" valign="middle">{$data.email}</td> -->
      <th height="15" align="left" valign="middle">Complaint Type</th>
      <td align="left" valign="middle">{$cat_list[$data.cat3_id]}</td>
    </tr>

    <tr>
      <th height="15" align="left" valign="middle">Received Through</th>
      <td align="left" valign="middle">{$grievance_origin_list[$data.grievance_origin_id]}</td>
    </tr>

    {if $data.grievance_origin_id eq '8'}
    <tr>
      <th height="15" align="left" valign="middle">Garden Name</th>
      <td align="left" valign="middle">{$data.park_name}</td>
    </tr>
    {/if}

    <tr>
      <th height="15" align="left" valign="middle">Subject</th>
      <td align="left" valign="middle">{$data.comp_subject}</td>
    </tr>

    <tr>
      <th height="15" align="left" valign="middle">Description</th>
      <td align="left" valign="middle">{$data.comp_desc}</td>
    </tr>
    <tr>
      <th height="15" align="left" valign="middle">Status</th>
      <td align="left" valign="middle">{$grievance_status_list[$data.grievance_status_id]}</td>
    </tr>
    <tr>
      <th height="15" align="left" valign="middle">Date</th>
      <td align="left" valign="middle">{$data.date_regd|date_format:"%d-%m-%Y %H:%M:%S"}</td>
    </tr>

    <tr>
      <th height="15" align="left" valign="middle">Photo</th>
      {if $data.file_url eq '#' || $data.file_url eq ''}
      <td align="left" valign="middle">Photo Not Uploaded</td>
      {else}
		<td align="left" valign="middle">
			<div class="grievance_image"><a href="{if $data.file_url eq ''}default-img.png{else} {$data.file_url} {/if}" target="_blank"><img src="{if $data.file_url eq ''}default-img.png{else} {$data.file_url} {/if}" alt="Grievance Image" style="width:100px;height:100px;"></a></div>
		</td>     

	 {/if}
    </tr>

    <tr>
      <th height="15" align="left" valign="middle">Latitude & Langitude</th>

      <td align="left" valign="middle">{$data.lat},{$data.lng}</td>

    </tr>








    {if $data.grievance_status_id neq '1'}
    <tr>
      <th height="12" align="center" valign="middle" colspan="2">GRIEVANCE MOVEMENT</th>
    </tr>
    <tr>
      <td colspan='2' border="1" align="center">
        <table class="table table-striped1 table-bordered" border="1" >
          <tr style="background-color:#2c3e50; color:#FFF;">
            <th align="center">S.No</th>
            <th align="center">COMPLAINT TYPE</th>
            <th align="center">DESIGNATION</th>
            <th align="center">EMPLOYEE</th>
            <th align="center">EMPLOYEE CODE & LEVEL</th>
            <th align="center">CONTACT</th>
            <th align="center">ALLOTTED ON</th>
            <th align="center">STATUS</th>
            <th align="center">DISPOSED ON</th>
            <th align="center">REMARKS</th>
          </tr>

          {foreach from=$data.transactions item=row key=transaction_id}
          <tr>
            <td align="center">{$transaction_id}</td>
            <td align="center">{$cat_list[$data.cat3_id]}</td>
           <td align="center">
			
			{if !empty($desg_list[$row.desg_id]) }
			  {$desg_list[$row.desg_id]}
			{else}
			  {$empt_list[$row.emp_id]['emp_desg']}
			{/if}
			
			</td>
            <td align="center">{$emp_list[$row.emp_id]['emp_name']}-{$emp_list[$row.emp_id]['emp_mobile']}</td>
            <td align="center">
			
			{if !empty($row.emp_level) }
			  {$emp_list[$row.emp_id]['emp_code']} -<span style="color:green;"> {$row.emp_level}</span>
			{else}
			  {$emp_list[$row.emp_id]['emp_code']} - <span style="color:red;">{$data['grievance_at_emp_level']}</span>
			{/if}

			
			</td>
            <td align="center">{$emp_list[$row.emp_id]['emp_mobile']}</td>
            <td align="center">{$row.alloted_date}</td>
            <td align="center">{$grievance_status_list[$row.disposal_status]}</td>
            <td align="center">{if $row.disposed_date eq '0000-00-00'}-{else} {$row.disposed_date} {/if}</td>
            <td align="center">{$row.disposal_remarks}</td>
          </tr>

          {/foreach}
        </table>
      </td>
    </tr>
    {/if}



  </table>
  </td>
  <td align="left" valign="top">&nbsp;</td>
  </tr>
  </table>
  {/if}



</div>
<!-- 13-06-24  <br> -->

<!-- 13-06-24 <center>
  <input type='button' value='Print' onclick="print_div()" class="btn btn-success">
</center> -->


<!-- 13-06-24  <br> -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="width: 100%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span id="workname"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="my_image" src="first.jpg" style="width:800px; height:500px;" />
        <div id="map-canvas"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

{include file='footer.tpl'}
{literal}
	<script>
	  function fun1(file_url, work_name) {

		$("#my_image").attr("src", file_url);
		$("#myModal").modal();
		//get_det();
	  }
	</script>
{/literal}