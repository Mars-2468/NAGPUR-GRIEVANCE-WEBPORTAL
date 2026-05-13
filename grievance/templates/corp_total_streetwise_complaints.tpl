{include file='corp_header.tpl'}
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

	<form method="POST" class="form-horizontal">
		<input type="hidden" name="ulbid" value="{$ulbid}">
		<input type="hidden" name="app_type_id" value="{$app_type_id}">
		<input type="hidden" name="reference_no" value="{$reference_no}">
		<input type="hidden" name="f_date" value="{$fdate}">
		<input type="hidden" name="t_date" value="{$tdate}">
		<input type="hidden" name="status" value="{$status}">
		<div class="boxed">
			<div class="title-bar blue " style="font-weight:bold;color:#FFF !important;">SEARCH FOR COMPLAINTS</div>

			<div class="inner no-radius">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-sm-6" for="usr">Complaint Id:</label>
						<div class="col-sm-6">
							<input type="text" class="phone-group form-control demoInputBox" name="reference_no" value="{$reference_no}" placeholder="Enter Complaint Id" autocomplete="off">
						</div>
					</div>
				</div>

				<div class="col-md-3">
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

				<div class="button-container">
					<input name="search" type="submit" class="btn btn-success" value="SEARCH">
					<a href="ajax_corp_dashboard.php" class="btn btn-warning" onclick="history.go(-1);">
						<i class="fa fa-backward"></i> Back
					</a>
				</div>
			</div>
		</div>
	</form>
</div>


<div class="boxed">
	<div class="inner no-radius">
<div class="title-bar blue " style="font-weight:bold;color:#FFF !important;">TOTAL STREETWISE COMPLAINTS</div>
		<div id="div_print" style="border:#999999 0px solid;">			

			<div id="dataTableContainer">
				
			</div>
			<div id="area" style="width:100%; overflow:scroll; font-size:13px;">
				<table border="1" cellspacing="0" cellpadding="0" class="table table-bordered" id="data-table" width="100%">
					<caption style="caption-side:top; text-align:center;font-size:16px;">
						<b>
							
						</b>
					</caption>
					<thead>
						
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th align="center" valign="middle" style="width: 50px; text-align: center; vertical-align: middle;">SR.No</th>
							<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">COMPLAINT CATEGORY </th>
							<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">
								<div style="width: 100px; word-wrap: break-word;">REFERENCE NO</div>
							</th>
							<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">ZONE NAME</th>
							<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">WARD NAME</th>
							<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">NAME</th>
							<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">MOBILE</th>
							<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">
								<div style="width: 250px; text-align: center; vertical-align: middle;"> ADDRESS </div>
							</th>
							<!--<th align="center" valign="middle">{if $app_type_id eq '1'} Complaint {else} SERVICE{/if} Details</th>	-->
							<th align="center" valign="middle" style="width: 100px; text-align: center; vertical-align: middle;">STATUS</th>

							<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">UPDATED IMAGE</th>

							<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">RECEIVED DATE</th>
							<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">CUT OFF DATE</th>
							<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">EMPLOYEE NAME & MOBILE</th>
							<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">DEPARTMENT</th>
							{* <th align="center" valign="middle">No.of Holidays Added</th> *}
							{* <th align="center" valign="middle">No.of Disposable Days</th> *}
							{* <th align="center" valign="middle">To be Completed Date</th> *}						
					

						</tr>
					</thead>
					<tbody style="background-color:#FFF;">
					
						{foreach from=$data key=grievance_id item=row}
						<tr>
							
							<td align="center">{$pageNumber++}</td>

							{if $row.app_type_id eq '1'}
							<td align="center"><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
							{else}
							<td align="center"><label title="{$row.comp_desc}">{$dept_list[$row.ward_id]}</label></td>
							{/if}
							<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">
								<a href="corp_grievance_view_comp_det_admin.php?ulbid={$ulbid}&app_type_id=1&page={$current_page}&status={$status}&ward_id={$ward_id}&grievance_id={$grievance_id}">
								
									<!-- {if {$row.grievance_origin_id} eq '1'}
									<b style="margin-right: 1px;">Web - </b>{$grievance_id}
									{elseif {$row.grievance_origin_id} eq '2'}
									<b style="margin-right: 1px;">Phone - </b>{$grievance_id}
									{elseif {$row.grievance_origin_id} eq '3'}
									<b style="margin-right: 1px;">Counter - </b>{$grievance_id}
									{elseif {$row.grievance_origin_id} eq '4'}
									<b style="margin-right: 1px;">App - </b>{$grievance_id}
									{elseif {$row.grievance_origin_id} eq '5'}
									<b style="margin-right: 1px;">WhatsApp - </b>{$grievance_id}
									{elseif {$row.grievance_origin_id} eq '6'}
									<b style="margin-right: 1px;">Facebook - </b>{$grievance_id}
									{elseif {$row.grievance_origin_id} eq '7'}
									<b style="margin-right: 1px;">EBC - </b>{$grievance_id}
									{elseif {$row.grievance_origin_id} eq '8'}
									<b style="margin-right: 1px;">Garden - </b>{$grievance_id}
									{else}
									{$grievance_id}
									{/if}	-->

								<b style="margin-right: 1px;">{$complaint_from[$row.grievance_origin_id]} - </b>{$grievance_id}
									
									
								</a>
							</td>
							<td align="center">{$ward_list[$row.ward_id]}</td>
							<td align="center">{$street_list[$row.street_id]}</td>
							<td align="center">{$row.person_name}</td>
							<td align="center">{$row.mobile}</td>

							<td align="center">{$row.hno},{$row.address}</td>
							
							<td align="center">{$grievance_status_list[$row.grievance_status_id]}</td>

							<td align="center">
								{if !empty($row.file_url) && !file_exists($row.file_url)}
									<img src="{{$row.file_url}}" width='75' height='75'>
								{else}
									<h5>NA</h5>
								{/if}
							</td>
							
							<td align="center">{$row.date_regd|date_format:"%d-%m-%Y"}</td>

							{if $row.cutt_of_time eq '1970-01-01 00:00:00'}
							<td align="center">-</td>
							{else}
							<td align="center">{$row.cutt_of_time|date_format:"%d-%m-%Y"}</td>
							{/if}
							<td align="center">{$emp_list[$row.emp_id]}</td>
							<td align="center">{$dept_list1[$row.dept_id]}</td>						
					
						</tr>
						{assign var=cnt value=$cnt+1}
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
            <li><a href="?ulbid=250&app_type_id=1&page={$pagination.current_page - 1}{$filter_query}">&laquo; Prev</a></li>
        {/if}

        <!-- First Page Button -->
        {if $start_page > 1}
            <li><a href="?ulbid=250&app_type_id=1&page=1{$filter_query}">1</a></li>
            {if $start_page > 2}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
        {/if}

        <!-- Visible Page Numbers -->
        {section name=pages start=$start_page loop=$end_page}
            <li class="{if $pagination.current_page == $smarty.section.pages.index+1}active{/if}">
                <a href="?ulbid=250&app_type_id=1&page={$smarty.section.pages.index+1}{$filter_query}">{$smarty.section.pages.index+1}</a>
            </li>
        {/section}

        <!-- Last Page Button -->
        {if $end_page < $pagination.total_pages}
            {if $end_page < $pagination.total_pages - 1}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
            <li><a href="?ulbid=250&app_type_id=1&page={$pagination.total_pages}{$filter_query}">{$pagination.total_pages}</a></li>
        {/if}

        <!-- Next Button -->
        {if $pagination.current_page < $pagination.total_pages}
            <li><a href="?ulbid=250&app_type_id=1&page={$pagination.current_page + 1}{$filter_query}">Next &raquo;</a></li>
        {/if}
    </ul>
</nav>
<!-- option2 pagination end -->
		</div>


	</div>
</div>
</div>


<br>

<div style="width:100%; text-align:center">

	<center>
		<form action="exporttoexcel.php" method="post">
			<input type="hidden" name="status" value="{$status}">
			<input type="hidden" name="sla" value="{$sla}">
			<input type="hidden" name="user_type" value="{$user_type}">
			<!-- <input type="submit" name="excel" value="Export All Excel" class="btn btn-warning"> -->
			<input type="submit" name="excel" value="Export All Excel" class="btn btn-success">
			<button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('data-table', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
			<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
		</form><br>
	</center>
</div>
{include file='corp_footer.tpl'}

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