{include file='header.tpl'}
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /> Data Table CSS -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
	/* Your regular styles go here */

	.button-container {
		text-align: right;
		margin-top: 10px;
	}

	.button-container .btn {
		margin: 0 5px;
	}

	@media (max-width: 768px) {
		.button-container {
			text-align: center;
		}

		.button-container .btn {
			display: block;
			width: 80%;
			margin: 10px auto;
			max-width: 300px;
			/* Optional: to limit the button's width on larger mobile screens */
		}
	}

	@media print {

		/* Set the page to landscape mode */
		@page {
			size: landscape;
		}

		/* Additional print styles if needed */
		body {
			font-size: 12pt;
			margin: 1cm;
			/* Adjust margins as needed */
		}
	}
	table thead tr th{
	color:#FFF !important;
	}
</style>

<script>
	function print_div() {
		var divContents = $("#area").html();
		var printWindow = window.open();
		printWindow.document.write(divContents);
		printWindow.document.close();
		printWindow.print();

	}
</script>
<br><br>
<div class="" style="margin-top: -45px;">


	<form method="POST" action="" class="form-horizontal">
		<input type="hidden" name="ulbid" value="{$ulbid}">
		<input type="hidden" name="app_type_id" value="{$app_type_id}">
		<input type="hidden" name="reference_no" value="{$reference_no}">
		<input type="hidden" name="f_date" value="{$fdate}">
		<input type="hidden" name="t_date" value="{$tdate}">
		<input type="hidden" name="status" value="{$status}">
		<div class="boxed">
			<div class="title-bar blue" style="color:#FFF !important; font-weight:bold !important;">
				<div style="display:flex;justify-content:space-between;align-items:center">
					<div>ESCALATION FILTERS</div>
					<div>
						<a href="ajax_dashboard.php" class="btn btn-warning" onclick="history.go(-1);">
							<i class="fa fa-backward"></i> Back
						</a>
					</div>
				</div>
			</div>


			<div class="inner no-radius" style="border-bottom-left-radius: 0px !important;border-bottom-right-radius: 0px !important;">
				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">Select department</label>
						<select class="form-control" name="department_id">						
							{foreach from=$dept_lists key=k item=v}
								{if $department_id == $k}
									<option value='{$k}' selected>{$v}</option>
								{else}  
									<option value='{$k}'>{$v}</option>
								{/if}
							{/foreach}							
						</select>
					</div>
				</div>
				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">Select status</label>
						<select class="form-control" name="status_id">						
							{foreach from=$status_list key=k item=v}
								{if $gstatus == $k}
									<option value='{$k}' selected>{$v}</option>
								{else}  
									<option value='{$k}'>{$v}</option>
								{/if}
							{/foreach}							
						</select>
					</div>
				</div>
				
				<div class="col-md-2" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="f_date" value="{$fdate}" placeholder="Select from date" autocomplete="off">
					</div>
				</div>
				<div class="col-md-2" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="t_date" value="{$tdate}" placeholder="Select to date" autocomplete="off">
					</div>
				</div>
				
				<div class="col-md-2">
					<div class="form-group" style="margin-top:31px;">
						<input name="search" type="submit" class="btn btn-success" value="SEARCH">
					<a class="btn btn-primary" style="color:#" href="">Reset</a>
					</div>
				</div>
				
				
				
				
			</div>



		</div>
	</form>
</div>
<!-- <div style="text-align:right;"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div>
</br></br></br> -->

<div class="boxed">
	<div class="inner no-radius">

		<div id="div_print" style="border:#999999 0px solid;">
			<div id="dataTableContainer" style="padding:20px;">
				<!-- Data will be displayed here -->
					<caption style="caption-side:top; text-align:center;font-size:16px;">
						<b>
							<CENTER><strong>VIEW ESCALATION REPORT DETAILS</strong></CENTER>
						</b>
					</caption>
			</div>
			<div id="area" style="width:100%; overflow-x:scroll; font-size:11px;">
				<table border="1" cellspacing="0" cellpadding="0" class="table table-bordered" id="data-table" width="100%">
					
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
							<th align="center" valign="middle">S.No</th>
							<th align="center" valign="middle">{if $app_type_id eq '1'} Category {else} Department{/if}</th>
							<th align="center" valign="middle">
								<div style="width: 70px; word-wrap: break-word;">Reference No</div>
							</th>
							<th align="center" valign="middle" style="width: 70px; word-wrap: break-word;">Zone Name</th>
							<!-- <th align="center" valign="middle" style="width: 85px; word-wrap: break-word;">Ward Name</th> -->
							<th align="center" valign="middle">Name</th>
							<th align="center" valign="middle">Mobile</th>
							<th align="center" valign="middle">
								<div style="width: 55px; word-wrap: break-word;"> Address </div>
							</th>
							<th align="center" valign="middle">{if $app_type_id eq '1'} Complaint {else} SERVICE{/if} Details</th>
							<th align="center" valign="middle">Status</th>


							<th align="center" valign="middle">Updated image</th>



							<th align="center" valign="middle">Received Date</th>
							<th align="center" valign="middle">Cut off Date</th>
							<th align="center" valign="middle">Employee name & mobile</th>
							<!-- <th align="center" valign="middle">Department</th> -->
							{* <th align="center" valign="middle">No.of Holidays added</th> *}
							{* <th align="center" valign="middle">No.of Disposable days</th> *}
							{* <th align="center" valign="middle">To be completed date</th> *}
							<th align="center" valign="middle">Completed Date</th>
							<th align="center" valign="middle">No.of days exceeded</th>

							<th align="center" valign="middle" colspan="1">Actions</th>

							<!-- <th></th> -->
						</tr>
					</thead>
					<tbody style="background-color:#FFF;">
						{foreach from=$data key=grievance_id item=row}
						<tr>
							<td align="center">{counter}</td>

							{if $row.app_type_id eq '1'}
							<td align="center"><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
							{else}
							<td align="center"><label title="{$row.comp_desc}">{$dept_list[$row.section_id]}</label></td>
							{/if}
							<!--<td>{$dept_list[$row.dept_id]}</td>-->
							<td align="center" class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
							<!--<td align="center">{$row.eoffice_no}</td>-->
							<td align="center">{$ward_list[$row.ward_id]}</td>
							<!-- <td align="center">{$street_list[$row.street_id]}</td> -->
							<td align="center">{$row.person_name}</td>
							<td align="center">{$row.mobile}</td>

							<td align="center">{$row.hno},{$row.address}</td>
							{if $row.app_type_id eq '1'}
							<td align="center">{$cs_list[$row.cat3_id]}</td>
							{else}
							<td align="center">{$cs_list[$row.mcat3_id]}</td>
							{/if}

							<td align="center">{$grievance_status_list[$row.grievance_status_id]}</td>

							<td align="center">
								{if $row.updated_image neq ''}
								<img src="{{$row.updated_image}}" width='75' height='75'>
								{/if}
							</td>
							<!--<td>{$row.date_regd|date_format:"%d-%m-%Y %H:%M:%S"}</td>
							<td>{$row.cutt_of_date|date_format:"%d-%m-%Y %H:%M:%S"}</td>
							<td>{$row.disposed_date|date_format:"%d-%m-%Y"}</td>
							<td>{$row.num_days_exceeded}</td>-->

							<td align="center">{$row.date_regd|date_format:"%d-%m-%Y"}</td>




							{if $row.comp_date eq '1970-01-01 00:00:00'}
							<td align="center">-</td>
							{else}
							<td align="center">{$row.comp_date|date_format:"%d-%m-%Y"}</td>
							{/if}
							<td align="center">{$emp_list[$row.emp_id]}</td>
							<!-- <td>{$dept_list1[$row.dept_id]}</td> -->
							{* <td align="center">{$row.holidays_added}</td> *}
							{* <td align="center">{$row.target_days}</td> *}
							{* <td align="center">{$row.comp_date|date_format:"%d-%m-%Y"}</td> *}
							<td align="center">{$row.disposed_date|date_format:"%d-%m-%Y"}</td>
							<td align="center">{$row.no_of_days_exeed}</td>





							{if $action_status neq 'disable'}
							{/if}
							<!-- {if $row.grievance_status_id eq '2' && $update_previlize eq '0'} {/if}-->
							<td align="center">
								{if $row.grievance_status_id eq '2' }


								<form action="manage_comp_sel.php" method="post">
									<input type="hidden" name="grievance_id" value="{$grievance_id}">
									<input type="submit" name="update" value="Update">
								</form>


								{/if}

								{if $row.grievance_status_id eq '1'}


								<form action="view_pending_approval.php" method="post">
									<input type="hidden" name="grievance_id" value="{$grievance_id}">
									<input type="submit" name="update" value="Assign to employee">
								</form>


								{/if}

								<!-- {if $row.grievance_status_id eq '11'}


								<form action="manage_comp_sel.php" method="post">
									<input type="hidden" name="grievance_id" value="{$grievance_id}">
									<input type="submit" name="update" value="Update">
								</form>


								{/if}-->

							</td>


						</tr>
						{/foreach}
					</tbody>

				</table>

			</div>

		</div>


	</div>
</div>
</div>


<!--<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>-->

{literal}






<style>
	div.pagination {
		padding: 3px;
		margin: 3px;
	}

	div.pagination a {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #AAAADD;

		text-decoration: none;
		/* no underline */
		color: #000099;
	}

	div.pagination a:hover,
	div.pagination a:active {
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

<div style="width:100%; text-align:center">


	<!-- <form action="exporttoexcel.php" method="post">
		<input type="submit" name="excel" value="export All excel" class="btn btn-warning">
	</form> -->
	<!-- <form action="exporttoexcel.php" method="post">
		<input type="hidden" name="status" value="{$status}">
		<input type="hidden" name="sla" value="{$sla}">
		<input type="hidden" name="user_type" value="{$user_type}">
		<input type="submit" name="excel" value="Export All Excel" class="btn btn-warning">
	</form><br>
	<button class="btn btn-info" id="download-pdf" onclick="exportTableToPDF('data-table', 'GrievanceReport')" value="Dashboard"></i> All PDF</button> -->

	<center>
		<form action="exporttoexcel.php" method="post">
			<input type="hidden" name="status" value="125">
			<input type="hidden" name="sla" value="125">
			<input type="hidden" name="user_type" value="{$user_type}">
			<!-- <input type="submit" name="excel" value="Export All Excel" class="btn btn-warning"> -->
			<input type="submit" name="excel" value="Export All Excel" class="btn btn-success">
			<button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('data-table', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
			<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
		</form><br>
	</center>
</div>
{include file='footer.tpl'}



<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>

<script>
	function exportTableToPDF(TableId, ReportName) {
		// Create a new jsPDF instance
		const doc = new jsPDF('landscape');
		doc.setFontSize(10);

		// Add a heading to the PDF
		//const captionText = document.querySelector('#' + TableId + ' caption').textContent;
		const captionElement = document.querySelector('#' + TableId + ' caption');
		const captionText = captionElement ? captionElement.textContent : "";

		const cleanedCaptionText = captionText.replace(/\s+/g, ' ').trim();
		const pageWidth = doc.internal.pageSize.width;
		const textWidth = doc.getStringUnitWidth(cleanedCaptionText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
		const x = (pageWidth - textWidth) / 2;
		doc.text(cleanedCaptionText, x, 15);

		// Generate the table from the HTML table with the specified TableId
		const table = document.getElementById(TableId);

		doc.autoTable({
			html: '#' + TableId,
			showFoot: "lastPage",
			styles: {
				lineColor: [0, 0, 0],
				fontSize: 8,
				textColor: [0, 0, 0]
			},
			headStyles: {
				fillColor: [173, 216, 230],
				lineWidth: 0.5,
				fontStyle: 'bold',
				halign: 'center',
				cellPadding: 1,
			},
			bodyStyles: {
				lineWidth: 0.5,
				halign: 'center',
				cellPadding: 1,
				alignment: 'center',
			},
			footStyles: {
				fillColor: [173, 216, 230],
				lineWidth: 0.5,
				halign: 'center',
				cellPadding: 1,
				alignment: 'center',
			},

			rowStyles: {
				lineColor: [0, 0, 0],
			},
			margin: {
				top: 20
			},
			didDrawPage: function(data) {
				// Modify the fill color of the footer on the last page
				if (typeof data.table !== "undefined" && data.pageNumber === data.table.finalYPage) {
					doc.setFillColor(255, 255, 255);
					doc.setTextColor(0, 0, 0);
					doc.rect(data.settings.margin.left, doc.internal.pageSize.height - 20, doc.internal.pageSize.width - data.settings.margin.left - data.settings.margin.right, 10, 'F');
				}
			},
		});

		doc.save(ReportName + '.pdf');
	}
</script>

<script>
	$(function() {
		$(".datepicker").datepicker({
			dateFormat: 'yy-mm-dd',
			//minDate: '2024-09-01',
			changeMonth: true,
			changeYear: true
		});
	});
</script>