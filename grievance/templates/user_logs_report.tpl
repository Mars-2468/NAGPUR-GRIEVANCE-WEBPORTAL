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

				<!--19-06-2024 <div class="col-md-1" align="right"><input name="search" type="submit" class="btn btn-success" value="SEARCH"> </div>
				<div style="text-align:right;"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div> -->

				<div class="button-container">
					<input name="search" type="submit" class="btn btn-success" value="SEARCH">
					<a href="ajax_dashboard.php" class="btn btn-warning" onclick="history.go(-1);">
						<i class="fa fa-backward"></i> Back
					</a>
				</div>
			</div>
		</div>
	</form>
</div>


<div class="boxed">
	<div class="inner no-radius">

		<div id="div_print" style="border:#999999 0px solid;">			

			<div id="dataTableContainer">
				
			</div>
			<div id="area" style="width:100%; overflow:scroll; font-size:13px;">
				<table border="1" cellspacing="0" cellpadding="0" class="table table-bordered" id="data-table" width="100%">
					<caption style="caption-side:top; text-align:center;font-size:16px;">
						<b>
							
							<CENTER><strong>VIEW LOG DETAILS</strong></CENTER>
							
						</b>
					</caption>
					<thead>
						
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th align="center" valign="middle" style="width: 50px; text-align: center; vertical-align: middle;">S.No</th>
							<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">USER ID</th>
							<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">
								<div style="width: 150px; word-wrap: break-word;">PREVIOUS STATUS</div>
							</th>
							<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">
								<div style="width: 150px; word-wrap: break-word;">PRESENT STATUS</div>
							</th>
							<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">Action</th>
							<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">Action Time</th>

						</tr>
					</thead>
					<tbody style="background-color:#FFF;">						
						{foreach from=$userdata key=id item=row}
							<tr>							
								<td class="text-center">{counter}</td>	
								<td align="center">{$row.user_id}</td>
								<td align="center">{$row.old}</td>
								<td align="center">{$row.new}</td>
								<td align="center">{$row.details}</td>
								<td align="center">{$row.action_time}</td>
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