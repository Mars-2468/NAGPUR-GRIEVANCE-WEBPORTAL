{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    <script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('http://municipalservices.in/manage_wards.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>	


{/literal}

<div class="row" id="div_print">
		<div>
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>Underground Drinage Applications</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                    <div style="overflow:scroll;">
					<table class="table table-striped table-bordered table-hover table-full-width" id="example" width="100%">
									<thead>
										
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											<th>Applicant name</th>
											<th>H.no</th>
											<th>Address</th>
											<th>Ward</th>
											<th>Mobile</th>
											<th>Email</th>
											<th>Application <br> Type</th>
											<th>Area <br>of<br>Structure</th>
											<th>Drinage<br>pipe<br>Siz</th>
											<th>Water<br>Source<br>Details</th>
											<th>no.of Seats</th>
											<th>Property<br>Tax<br>Receipt</th>
											<th>Adhaar</th>
											<th>Food<br>Security<br>Card</th>
											<th>Date</th>
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$data item=row key=id}
										<tr>
											<td>{counter}</td>
											<td>{$row.applicant_name}</td>
											<td>{$row.hno}</td>
											<td>{$row.address}</td>
											<td>{$row.ward_desc}</td>
											<td>{$row.mobile}</td>
											<td>{$row.email}</td>
											<td>{$row.application_desc}</td>
											<td>
											    {if $row.file_type eq 'pdf'}
											    <a href="{$row.file_url}" target="_blank">Download PDF</a>
											    {else}
											    <img src="{$row.file_url}" width="75" height="75">
											    {/if}
											    </td>
											<td>{$row.size_desc}</td>
											<td>
											    {foreach from=$enclosures[$id] item=row3 key=key}
											    {$row3['water_source_name']}<br>
											    {/foreach}
											    
											</td>
											<td>{$row.toilet_seats}</td>
											<td>{$row.tax_receipt_yn}</td>
											<td>{$row.adhaar_yn}</td>
											<td>{$row.fsc_yn}</td>
											<td>{$row.date}</td>
											
											
										</tr>
										{/foreach}
										
										
									</tbody>
								</table>
					</div>			
				</div>
			</div>
		</div>

{include file='footer_print.tpl'}


{include file='footer.tpl'}

