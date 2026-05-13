{include file='header.tpl'}
{literal}
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
	
table> thead> tr> th {
    color: #fff !important;
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
{/literal}
<br><br>
<div class="" style="margin-top: -45px;">


	<form method="POST" class="form-horizontal">
		<input type="hidden" name="ulbid" value="{$ulbid}">
		<input type="hidden" name="app_type_id" value="{$app_type_id}">
		<input type="hidden" name="reference_no" value="{$reference_no}">
		<input type="hidden" name="f_date" value="{$fdate}">
		<input type="hidden" name="t_date" value="{$tdate}">
		<input type="hidden" name="status" value="{$status}">
		<div class="boxed">
			<div class="title-bar blue"></div>

			<div class="inner no-radius">
				<div class="col-md-4">
					<div class="form-group">
						<!-- <label class="control-label col-sm-6" for="usr">Reference No:</label>
						<div class="col-sm-6">
							<input type="text" class="phone-group form-control demoInputBox" name="reference_no" value="{$reference_no}" placeholder="Enter Reference No" autocomplete="off">
						</div> -->
						<label class="control-label col-sm-6" for="usr">Complaint Id:</label>
						<div class="col-sm-6">
							<input type="text" class="phone-group form-control demoInputBox" name="reference_no" value="{$reference_no}" placeholder="Enter Complaint Id" autocomplete="off">
						</div>
					</div>
				</div>

<!--				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label col-sm-5" for="usr">From Date:</label>
						<div class="col-sm-7">
							<input type="text" class="phone-group form-control datepicker" name="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">
						</div>
					</div>
				</div>


				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label col-sm-5" for="usr">To Date:</label>
						<div class="col-sm-7">
							<input type="text" class="phone-group form-control datepicker" name="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">
						</div>
					</div>
				</div>
-->
				<!--19-06-2024 <div class="col-md-1" align="right"><input name="search" type="submit" class="btn btn-success" value="SEARCH"> </div>
				<div style="text-align:right;"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div> -->

				<div class="button-container">
					<input name="search" type="submit" class="btn btn-success" value="SEARCH">
					<!-- <a href="escaleted_grievance_rep.php" class="btn btn-warning" onclick="history.go(-1);">
						<i class="fa fa-backward"></i> Back
					</a> -->
				</div>
				<!-- <div style="text-align:right;"><a href="escaleted_emp_grievance_rep.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div> -->
			</div>
		</div>
	</form>
</div>
<!-- <div style="text-align:right;"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div>
</br></br></br> -->

<div class="boxed">
	<div class="inner no-radius">

		<div id="div_print" style="border:#999999 0px solid;">
			<div id="dataTableContainer">
				<!-- Data will be displayed here -->
			</div>
			<div id="area" style="width:100%; overflow:scroll; font-size:11px;">
				<table border="1" cellspacing="0" cellpadding="0" class="table table-bordered" id="data-table" width="100%">
					<caption style="caption-side:top; text-align:center;font-size:16px;">
						<b>
							<CENTER><strong>VIEW ESCALATION REPORT DETAILS</strong></CENTER>
						</b>
					</caption>
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
							<td align="center">{$pageNumber++}</td>

							{if $row.app_type_id eq '1'}
							<td align="center"><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
							{else}
							<td align="center"><label title="{$row.comp_desc}">{$dept_list[$row.section_id]}</label></td>
							{/if}
							<!--<td>{$dept_list[$row.dept_id]}</td>-->
							<td align="center" class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}" target="_blank">{$grievance_id}</a></td>
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
<!-- option2 pagination start -->
<nav>
    <ul class="pagination">
        {assign var="start_page" value=$pagination.current_page - $pagination.range}
        {assign var="end_page" value=$pagination.current_page + $pagination.range}
        {assign var="start_page" value=max(1, $start_page)}
        {assign var="end_page" value=min($pagination.total_pages, $end_page)}

        <!-- Previous Button -->
        {if $pagination.current_page > 1}
            <li><a href="?cat3_id={$cat3_id}&ward_id={$ward_id}&status_id={$status_id}&page={$pagination.current_page - 1}{$filter_query}">&laquo; Prev</a></li>
        {/if}

        <!-- First Page Button -->
        {if $start_page > 1}
            <li><a href="?cat3_id={$cat3_id}&ward_id={$ward_id}&status_id={$status_id}&page=1{$filter_query}">1</a></li>
            {if $start_page > 2}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
        {/if}

        <!-- Visible Page Numbers -->
        {section name=pages start=$start_page loop=$end_page}
            <li class="{if $pagination.current_page == $smarty.section.pages.index+1}active{/if}">
                <a href="?cat3_id={$cat3_id}&ward_id={$ward_id}&status_id={$status_id}&page={$smarty.section.pages.index+1}{$filter_query}">{$smarty.section.pages.index+1}</a>
            </li>
        {/section}
        <!-- Last Page Button -->
        {if $end_page < $pagination.total_pages}
            {if $end_page < $pagination.total_pages - 1}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
            <li><a href="?cat3_id={$cat3_id}&ward_id={$ward_id}&status_id={$status_id}&page={$pagination.total_pages}{$filter_query}">{$pagination.total_pages}</a></li>
        {/if}

        <!-- Next Button -->
        {if $pagination.current_page < $pagination.total_pages}
            <li><a href="?cat3_id={$cat3_id}&ward_id={$ward_id}&status_id={$status_id}&page={$pagination.current_page + 1}{$filter_query}">Next &raquo;</a></li>
        {/if}
    </ul>
</nav>
<!-- option2 pagination end -->
		</div>


	</div>
</div>
</div>

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
			changeMonth: true,
			changeYear: true
		});
	});
</script>