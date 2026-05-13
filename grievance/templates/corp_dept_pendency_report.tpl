{include file='corp_header.tpl'}
{literal}

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

{/literal}


<div class="boxed">
    <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
        <h4>Department wise pendency report</h4>
        <!-- <p class="m-0"><a href="ajax_corp_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
        <p class="m-0"><a href="corp_reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
    </div>

    <div class="inner no-radius">
        <div id="area">
            <table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
                <caption style="caption-side:top; text-align:center;font-size:16px;">
                    <b>
                        <CENTER><strong>VIEW DEPARTMENT WISE PENDENCY REPORT DETAILS</strong></CENTER>
                    </b>
                </caption>
                <thead>
                    <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
                        <th> S.No </th>
                        <th> DEPARTMENT </th>
                        <th> TOTAL </th>
                        <th> TOTAL PENDING </th>
                        <th>TOTAL RESOLVED </th>
                    </tr>
                </thead>
                <tbody>
                   {foreach from=$dept_list key=dept_id item=row}

                    <tr>
                        <td align='center'>{counter}</td>
                        <td class="{if $active_class eq 'tr-clmn'}activ_column{/if}"><a href="corp_inner_pendancy_report.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}">{$dept_list[$dept_id]}</a></td>
                        <td align='center' class="{if $active_class eq 'tr-clmn'}activ_column{/if}">{if $data[$dept_id].count neq ''}<a href="corp_inner_pendancy_report.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="">{$data[$dept_id].count}</a>{else}-{/if}</td>
                        <td align='center' class="{if $active_class eq 'pwsla-clmn'}activ_column{/if}">{if $data[$dept_id].pending neq ''}<a href="corp_inner_pendancy_report.php?app_type_id=1&dept_id={$dept_id}&status=107&f_date={$fdate}&t_date={$tdate}&sla_status=2" target="">{$data[$dept_id].pending}</a>{else}-{/if}</a></td>
                        <td align='center' class="{if $active_class eq 'rwsla-clmn'}activ_column{/if}">{if $data[$dept_id].completed neq ''}<a href="corp_inner_pendancy_report.php?app_type_id=1&dept_id={$dept_id}&status=108&f_date={$fdate}&t_date={$tdate}" target="">{$data[$dept_id].completed}</a>{else}-{/if}</a></td>
					</tr>
                    {/foreach}

                </tbody>

                <tfoot>
                    <td align='center' colspan='2'><b>Total</b></td>
                    <td align='center'>{if $tot['received'] gt 0}<a href="corp_inner_pendancy_report.php?app_type_id=1&dept_id={$dept_id}&status=100&f_date={$fdate}&t_date={$tdate}">{$tot['received']}</a>{else}{$tot['received']}{/if}</td>
					<td align='center'>{if $tot['pending'] gt 0}<a href="corp_inner_pendancy_report.php?app_type_id=1&dept_id={$dept_id}&status=800&f_date={$fdate}&t_date={$tdate}">{$tot['pending']}</a>{else}{$tot['pending']}{/if}</td>
                    <td align='center'>{if $tot['completed'] gt 0}<a href="corp_inner_pendancy_report.php?app_type_id=1&dept_id={$dept_id}&status=900&f_date={$fdate}&t_date={$tdate}">{$tot['completed']}</a>{else}{$tot['completed']}{/if}</td>
                </tfoot>
            </table>
        </div>

      


    </div>
</div>

<br>
{include file='footer_print.tpl'}
<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
{include file='corp_footer.tpl'}

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
