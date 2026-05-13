{include file='header.tpl'}

<div  id="div_print" style="border:#999999 0px solid;">
<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</strong></CENTER>


    <div style="width:100%; overflow:scroll;">
	    <table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id='example'>
	    <thead>
	      <tr style="background-color:#2c3e50; color:#FFF;">
		<th align="center" valign="middle">S.No</th>
		<th align="center" valign="middle">{if $app_type_id eq '1'} Category {else} Department{/if}</th>
		<th align="center" valign="middle">Reference No</th>
		<th align="center" valign="middle">e-office No</th>
		<th align="center" valign="middle">Name & Mobile</th>
		<th align="center" valign="middle">Adress</th>	
		<th align="center" valign="middle">COMPLAINTS Details</th>		
		<th align="center" valign="middle">Status</th>
		<th align="center" valign="middle">Swachhta app status</th>
		<th align="center" valign="middle">Received Date</th>
		<th align="center" valign="middle">Actions</th>
				
	    </tr>
	    </thead>
		<tbody>
		{foreach from=$data key=grievance_id item=row}
		<tr>
			<td>{counter}</td>
			
		
            <td>{$cm_list[$row.cat3_id]}</td>
            
			<!--<td>{$dept_list[$row.dept_id]}</td>-->
			<td align="center">{$grievance_id}</td>
			<td align="center">{$row.eoffice_no}</td>
			<td>{$row.person_name} ({$row.mobile})</td>
			
			<td>{$row.hno},{$row.address}</td>
			<td>{$com_list[$row.cat3_id]}</td>
			
			<td>{$grievance_status_list[$row.grievance_status_id]}</td>
			<td>{$app_status_list[$row.swatchta_app_status]}
			
			</td>
			
			
			<td>{$row.date_regd|date_format:"%d-%m-%Y"}</td>
			<td>
			    {if $row.generic_id eq ''}
			    
			   <input type="button"  value="Resubmit" id="resend" onclick="resendswachhappapi({$grievance_id})">
			    {/if}
			</td>
			
			
			
		
		
		</tr>
		{/foreach}
		</tbody>
	    
	  </table>
 </div>

</div>
{include file='footer_print.tpl'}
<!--<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>-->

{literal}

<script>
    function resendswachhappapi(grievanceid)
    {
        $.get('ajaxResendSwachhStatusResend.php',{grievance_id:grievanceid},function(data)
        {
            
            if(data==1)
            {
                alert('Complaint updated successfully');
                location.reload();
            }
            else
            {
                alert('Not updated . Try again');
            }
        })
    }
</script>




<style>
div.pagination {
	padding: 3px;
	margin: 3px;
}

div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	
	text-decoration: none; /* no underline */
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #000099;

	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
		border: 1px solid #000099;
		
		font-weight: bold;
		background-color: #000099;
		color: #FFF;
	}
	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;
	
		color: #DDD;
	}
	
</style>





{/literal}

<center>
<div id="pagination" class="pagination" align="center">{$pagination}</div>
</center>
<br>
{include file='footer.tpl'}