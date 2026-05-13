{include file='header.tpl'}
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

<script>
	function fill(ward_id, ward_desc) {
		document.manage_wards.ward_id.value = ward_id;
		document.manage_wards.ward_desc.value = ward_desc;
	}

	function delete_ward(ward_id) {

		if (confirm('Do You really want to delete this record')) {

			$.post('ajax_del_ward.php', {
				ward_id: ward_id
			}, function(data) {
				if (data == 1) {
					alert('Ward deleted successfully');
					window.location = 'manage_wards.php';
				} else if (data == 0) {
					alert('Unable to delete , Try again');
				} else if (data == 2) {
					alert('Ward is mapped with employees You cannot delete this ward');
				}

			});
		}

	}

	function validateForm() {
		var ward_desc = document.manage_wards.ward_desc.value;
		if (ward_desc == '') {
			alert("Please Enter Ward No / Description");
			return false;
		}

		return true;
	}
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
			<div class="title-bar blue"></div>
			<!-- <div class="inner no-radius">
				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">
					</div>
				</div>


				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group" style="margin-top:31px;">
						<input name="search" type="submit" class="btn btn-success" value="SEARCH">
					</div>
				</div>
			</div>-->
		</div>
	</form>
</div>

<div class="boxed">

	<div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
		<h4>Category Max Grievance Resolved Complaints Report</h4>
		<!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
		<p class="m-0"><a href="reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
	</div>



	<div class="inner no-radius">
		<div id="area" class="table-responsive">

			<table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
				<caption style="caption-side:top; text-align:center;font-size:16px;">
					<b>
						<CENTER><strong>VIEW CATEGORY MAX GRIEVANCE RESOLVED COMPLAINT DETAILS</strong></CENTER>
					</b>
				</caption>
				<thead>
					<tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
						<th align='center'> S.No </th>
						<th align='center'> COMPLAINTS NAME </th>
						<th align='center'> TOTAL </th>
						{foreach from=$ward_list item=row key=ward_id}

						<th align='center'>{$row.ward_name|upper} </th>
						{/foreach}
					</tr>

				</thead>
				<tbody>

					{foreach from=$max_comp_details item=row key=cs_id}

					<tr>
						<td align='center'>{counter}</td>

						<td class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="">{$cs_list[$row.cat3_id]['desc']}</a></td>
						<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="">{$tot[$row.cat3_id]['total']}</a></td>

						{foreach from=$ward_list item=row2 key=ward_id}
						<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="">{$comp_details[$row.cat3_id][$ward_id]['count']}</a></td>
						{/foreach}
						{/foreach}

				</tbody>
				<tfoot>
					<td align='center' colspan="2"><strong>Total</strong></td>
					<td align='center'><a href="">{$total}</a></td>
					{foreach from=$ward_list item=row2 key=ward_id}
					<td align='center'><a href="">{$tot_wards[$ward_id]['total']}</a></td>
					{/foreach}
				</tfoot>
			</table>
		</div>

		<br>
		<div>
			<center>
				<!-- <input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success"/>
        <input type='button' value='Print' onclick="print_div()" class="btn btn-danger" />
        <button class="btn btn-info" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> All PDF</button> -->
				<!-- <input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export All Excel" class="btn btn-success" />
        <button class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export All PDF</button>
        <input type='button' value='Print' onclick="print_div()" class="btn btn-danger" /> -->
				<form action="exporttoexcel.php" method="post">
					<!-- <input type="hidden" name="status" value="{$status}">
          <input type="hidden" name="sla" value="{$sla}">
          <input type="hidden" name="user_type" value="{$user_type}">
          <input type="submit" name="excel" value="Export All Excel" class="btn btn-success"/> -->
					<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export To Excel" class="btn btn-success" />
					<button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
					<input type='button' value='Print' onclick="print_div()" class="btn btn-danger" />
				</form><br>
			</center>
		</div>


	</div>
</div>




<br>




<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
{include file='footer.tpl'}



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
<script>
   $(".num").keydown(function(event) {
    // Allow only backspace and delete
    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ) {
        // let it happen, don't do anything
    }
    else {
        // Ensure that it is a number and stop the keypress
        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault(); 
        }   
    }
});
    
    
</script>