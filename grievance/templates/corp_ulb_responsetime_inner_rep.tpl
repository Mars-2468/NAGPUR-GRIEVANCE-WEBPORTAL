{include file='corp_header.tpl'}
{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" media="all">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /> Data Table CSS -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
	.activ_column {
		background-color: #7ac18a;
		color: white !important;
	}

	.activ_column a {
		/*background-color: #54B435;*/
		color: #FFF !important;
		/*text-shadow: 0 0 3px #FFFF;*/
		text-decoration: underline #1C82AD;
	}

	a {
		color: blue;
		text-decoration: underline;
	}

	/* Your regular styles go here */

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

<script language='javascript'>
	var tableToExcel = (function() {
		var uri = 'data:application/vnd.ms-excel;base64,',
			template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
			base64 = function(s) {
				return window.btoa(unescape(encodeURIComponent(s)))
			},
			format = function(s, c) {
				return s.replace(/{(\w+)}/g, function(m, p) {
					return c[p];
				})
			}
		return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {
				worksheet: name || 'Worksheet',
				table: table.innerHTML
			}
			window.location.href = uri + base64(format(template, ctx))
		}
	})()
</script>
<script>
	function print_div() {
		var divContents = $("#area").html();
		var printWindow = window.open();
		printWindow.document.write(divContents);
		printWindow.document.close();
		printWindow.print();
	}
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').dataTable();
		$('#myDataTable1').dataTable();

	});
</script>

<script>
	$(document).ready(function() {
		$(".datepick").datepicker({
			maxDate: +2000,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true
		});

	});
</script>
{/literal}


<div class="" style="margin-top: -45px;">
	<form method="POST" class="form-horizontal">
		<div class="boxed">
			<div class="title-bar blue1"></div>
		</div>
	</form>
</div>

<div class="boxed">


	<div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
		<h4>CATEGORY WISE COMPLAINTS AVG RESPONSE TIME</h4>
		<!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
		<p class="m-0"><a href="corp_ulb_comp_resp_rep.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
	</div>

	<div class="inner no-radius">
		<div id="area" class="table-responsive">

			<table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
				<caption style="caption-side:top; text-align:center;font-size:16px;">
					<b>
						<CENTER><strong>VIEW CATEGORY WISE COMPLAINTS AVG RESPONSE TIME DETAILS</strong></CENTER>
					</b>
				</caption>
				<thead>
					<tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
						<th align='center'> S.No </th>
						<th align='center'> CATEGORY NAME </th>
						<th align='center'> NO. OF RESOLVED COMPLAINTS </th>
						<th align='center'> COMPLAINTS AVG RESPONSE TIME[IN DAYS] </th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$cat_list item=row key=cs_id}
						<tr>
							<td align='center'>{counter}</td>
							<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="corp-category-basis-ulb-wise-complaints-response-time.php?cat_id={$cs_id}" target="_blank">{$cat_list[$cs_id]}</a></td>
							<td align='center'>{$ulbtotalcomplaints[$cs_id]['complaints'].count}</td>
							<td align='center'>{$response_time[$cs_id]['complaints'].avg_res_time}</td>
						</tr>
					{/foreach}

				</tbody>
				<tfoot>
					<tr style="text-align:center;">
						<td colspan="2"><strong>Total</strong></td>
						<!-- <td align='center'>--</td> -->
						<td><strong>{$grand_total_complaints}</strong></td>
						<td><strong>{$grand_c_avg_res_time}</strong></td>
					</tr>
				</tfoot>
			</table>
		</div>

		<br>
		<div>
			<center>
					<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export To Excel" class="btn btn-success" />
					<button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
					<input type='button' value='Print' onclick="print_div()" class="btn btn-danger" />
			</center>
		</div>
	</div>
</div>

<br>


<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
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
        styles: { lineColor: [0, 0, 0], fontSize: 8, textColor: [0, 0, 0] }, 
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
        margin: { top: 20 },
        didDrawPage: function (data) {
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