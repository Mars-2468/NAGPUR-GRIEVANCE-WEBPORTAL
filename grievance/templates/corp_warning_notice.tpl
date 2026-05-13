{include file='corp_header.tpl'}
{literal}
<script language="javascript">
	$(document).ready(function() {

		$('#example> tbody > tr:odd').css("background-color", "lightblue");

	});
</script>

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

<style>
	th {
		text-align: center !important;
	}

	a {
		color: blue;
		text-decoration: underline;
	}

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


{/literal}
<div>
	<div class="boxed">
		<div class="title-bar blue" style="display: flex; justify-content: space-between; align-items: center;">
			<h4 style="margin: 0;">WARNING NOTICE LIST</h4>
		</div>
		<div class="inner no-radius">
			<form method="POST" class="form-horizontal">
				<input type="hidden" name="ulbid" value="{$ulbid}">
				<input type="hidden" name="emp_id" value="{$emp_id}">
				<input type="hidden" name="dept_id" value="{$dept_id1}">
				<input type="hidden" name="fdate" value="{$fdate}">
				<input type="hidden" name="tdate" value="{$tdate}">

				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-sm-6" for="usr">Employee Name:</label>
						<div class="col-sm-6">
							<input type="text" class="phone-group form-control demoInputBox" name="emp_name" value="{$emp_name}" placeholder="Enter Employee Name" autocomplete="off">
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
			</form>

			<div class="table-responsive" style="width:100%;">
				<div id="area">
					<table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
						<caption style="caption-side:top; text-align:center;font-size:16px;">
							<b>
								<CENTER><strong>VIEW WARNING NOTICE LIST DETAILS</strong></CENTER>
							</b>
						</caption>
						<thead>
							<tr style="background-color:#2c3e50; color:#FFF; text-align:center;">
								<th align='center'>S.No</th>
								<th align='center'>EMPLOYEE NAME </th>
								<th align='center'>DEPARTMENT NAME </th>
								<th align='center'>WARNING COUNT(S) </th>
							</tr>
						</thead>
						<tbody>

							{foreach from=$emp_list key=emp_id item=row}
							{if $emp_id ne ''}
								<tr>
									<td align='center'>{counter}</td>
								
								<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$emp_id].count neq ''}<a href="corp_all_warning_notice_list.php?ulbid={$ulbid}&app_type_id={$app_type_id}&emp_id={$emp_id}&status=war&dept_id={$emp_dept_list[$emp_id]}&f_date={$fdate}&t_date={$tdate}" style="text-decoration: none;">{$emp_list[$emp_id]}</a>{else}<b>{$emp_list[$emp_id]}</b>{/if}</td>
								<td align='center'><b>{$dept_list[$emp_dept_list[$emp_id]]}</b></td>
								<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$emp_id].count neq ''}<a href="corp_all_warning_notice_list.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=war&dept_id={$emp_dept_list[$emp_id]}&f_date={$fdate}&t_date={$tdate}" target="" style="text-decoration: none;">{$data[$emp_id].count}</a>{else}<b>-</b>{/if}</td>
														
								</tr>
							{/if}	
							{/foreach}

						</tbody>
						<tfoot>
							<td align='center' colspan="3"><strong style="color:black">Total</strong></td>
							{if $user_type eq 'U'}
							<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.received neq ''}<a href="corp_warningTotalNotices.php?ulbid={$ulbid}&app_type_id={$app_type_id}&status=war_all&f_date={$fdate}&t_date={$tdate}" style="text-decoration: none;"><b>{$tot.received}</b></a>{else}<b>0</b>{/if}</td>
							{else}
							<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.received neq ''}<a href="#" style="text-decoration: none;"><b>{$tot.received}</b></a>{else}<b>0</b>{/if}</td>
							{/if}
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>
<br>

<div>
	<center>
		<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export To Excel" class="btn btn-success">
		<button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
		<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
	</center>
</div>

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
			minDate: '2024-09-01',
            changeMonth: true,
            changeYear: true
		});
	});
</script>