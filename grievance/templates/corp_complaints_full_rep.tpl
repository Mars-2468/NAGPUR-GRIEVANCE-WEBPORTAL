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

	<div class="boxed">
		<div class="title-bar blue">
			<h4>COMPLAINT WISE REPORT DETAILS</h4>
		</div>
		<div class="inner no-radius">

			<form method="POST" class="form-horizontal">
				<input type="hidden" name="ulbid" value="{$ulbid}">
				<input type="hidden" name="app_type_id" value="{$app_type_id}">
				<input type="hidden" name="emp_id" value="{$emp_id}">
				<input type="hidden" name="f_date" value="{$fdate}">
				<input type="hidden" name="t_date" value="{$tdate}">
				<input type="hidden" name="status" value="{$status}">
				<!--<div class="col-md-3">
						<div class="form-group">
							<label class="control-label col-sm-6" for="usr">Reference No:</label>
							<div class="col-sm-6">
								<input type="text" class="phone-group form-control demoInputBox" name="reference_no" value="{$reference_no}">
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label col-sm-5" for="usr">Mobile No:</label>
							<div class="col-sm-7">
								<input type="text" class="phone-group form-control demoInputBox"  name="mobile" value="{$mobile}">
							</div>
						</div>
					</div>-->
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-sm-5" for="usr">From Date:</label>
						<div class="col-sm-7">
							<input type="text" class="phone-group form-control datepicker" name="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-sm-5" for="usr">To Date:</label>
						<div class="col-sm-7">
							<input type="text" class="phone-group form-control datepicker" name="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">
						</div>
					</div>
				</div>

				<div class="button-container">
					<input name="search" type="submit" class="btn btn-success" value="SEARCH">
					<a href="corp_complaint_wise_rep.php" class="btn btn-warning" onclick="history.go(-1);">
						<i class="fa fa-backward"></i> Back
					</a>
				</div>
			</form>

			</div>

		<div id="div_print" style="border:#999999 0px solid;">
			
			<div style="width:100%;">
				<div id="area" class="table-responsive">
					<table width="100%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
						<caption style="caption-side:top; text-align:center;font-size:16px;">
							<b>
								{if $status eq '0' || $status eq '1' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN RECEIVED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '0' || $status eq '1' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE RECEIVED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '2' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN UNDER PROGRESS WITHIN SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '2' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE UNDER PROGRESS WITHIN SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '8' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN UNDER PROGRESS BEYOND SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '8' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE UNDER PROGRESS BEYOND SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '3' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN COMPLETED WITHIN SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '3' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE COMPLETED WITHIN SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '9' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN COMPLETED BEYOND SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '9' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE COMPLETED BEYOND SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '5' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN REOPENED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '5' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE REOPENED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '105' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN REOPENED UNDER PROGRESS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '105' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE REOPENED UNDER PROGRESS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '108' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN TOTAL RESOLVED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '108' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE TOTAL RESOLVED PROGRESS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '7' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN REOPENED COMPLETED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '7' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE REOPENED COMPLETED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '10' && $user_type eq 'P' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN FINANCIAL IMPLICATIONS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '10' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE FINANCIAL IMPLICATIONS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{else}
								<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINT {else} SERVICE{/if} DETAILS</strong></CENTER>
								{/if}
							</b>
						</caption>
						<thead>
							<!-- <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
								<th align="center" valign="middle">S.No</th>
								<th align="center" valign="middle">PERSON NAME</th>
								<th align="center" valign="middle">MOBILE No</th>
								<th align="center" valign="middle">HNo</th>
								<th align="center" valign="middle">ADDRESS</th>-->
							<!--old not open  <th align="center" valign="middle">Ward</th>
								<th align="center" valign="middle">Street</th> -->
							<!--<th align="center" valign="middle">ZONE NAME</th>
								<th align="center" valign="middle">WARD NAME</th>
								<th align="center" valign="middle">COMPLAINT DESCRIPTION</th>
								<th align="center" valign="middle">EMPLOYEE NAME</th>
								<th align="center" valign="middle">EMPLOYEE MOBILE</th>
							</tr> -->
							<tr style="background-color:#2c3e50; color:#FFF;">
								<th align="center" valign="middle" style="width: 50px; text-align: center; vertical-align: middle;">SR.No</th>
								<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">PERSON NAME</th>
								<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">MOBILE No</th>
								<th align="center" valign="middle" style="width: 100px; text-align: center; vertical-align: middle;">HNo</th>
								<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">ADDRESS</th>
								<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">ZONE NAME</th>
								<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">WARD NAME</th>
								<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">COMPLAINT DESCRIPTION</th>
								<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">EMPLOYEE NAME</th>
								<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">EMPLOYEE MOBILE</th>


							</tr>
						</thead>
						<tbody>
							{foreach from=$data item=row key=grievance_id}
							<tr>
								<td align="center">{$pageNumber++}</td>
								<td align="center">{$row.person_name}</td>
								<td align="center">{$row.mobile}</td>
								<td align="center">{$row.hno}</td>
								<td align="center">{$row.address}</td>
								<td align="center">{$ward_list[$row.ward_id]}</td>
								<td align="center">{$street_list[$row.street_id]}</td>
								<td>{$row.comp_desc}</td>
								<td align="center">{$row.emp_name}</td>
								<td align="center">{$row.emp_mobile}</td>

							</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
		</div>
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
            <li><a href="?ulbid=250&app_type_id=1&cs_id={$cs_id}&status={$status}&page={$pagination.current_page - 1}">&laquo; Prev</a></li>
        {/if}

        <!-- First Page Button -->
        {if $start_page > 1}
            <li><a href="?ulbid=250&app_type_id=1&cs_id={$cs_id}&status={$status}&page=1">1</a></li>
            {if $start_page > 2}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
        {/if}

        <!-- Visible Page Numbers -->
        {section name=pages start=$start_page loop=$end_page}
            <li class="{if $pagination.current_page == $smarty.section.pages.index+1}active{/if}">
                <a href="?ulbid=250&app_type_id=1&cs_id={$cs_id}&status={$status}&page={$smarty.section.pages.index+1}">{$smarty.section.pages.index+1}</a>
            </li>
        {/section}
        <!-- Last Page Button -->
        {if $end_page < $pagination.total_pages}
            {if $end_page < $pagination.total_pages - 1}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
            <li><a href="?ulbid=250&app_type_id=1&cs_id={$cs_id}&status={$status}&page={$pagination.total_pages}">{$pagination.total_pages}</a></li>
        {/if}

        <!-- Next Button -->
        {if $pagination.current_page < $pagination.total_pages}
            <li><a href="?ulbid=250&app_type_id=1&cs_id={$cs_id}&status={$status}&page={$pagination.current_page + 1}">Next &raquo;</a></li>
        {/if}
    </ul>
</nav>
<!-- option2 pagination end -->
			
	
</div>


<div style="width:100%; text-align:center">
	<form action="exporttoexcel.php" method="post">
		<input type="hidden" name="app_type_id" value="{$app_type_id}">
		<input type="hidden" name="emp_id" value="{$emp_id}">
		<input type="hidden" name="status" value="{$status}">
		<input type="hidden" name="sla" value="{$sla}">
		<input type="hidden" name="cs_id" value="{$cs_id}">
		<input type="hidden" name="user_type" value="{$user_type}">
		<input type="submit" name="excel" value="Export To Excel" class="btn btn-success">
		<button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('data-table', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
		<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
	</form><br>
</div>
{include file='corp_footer.tpl'}


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
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