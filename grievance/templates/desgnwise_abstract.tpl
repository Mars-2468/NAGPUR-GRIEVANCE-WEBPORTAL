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



<!--<div class="" style="margin-top: -45px;">
	<form method="POST" class="form-horizontal">


		<div class="boxed">

			<div class="title-bar blue"></div>
			<div class="inner no-radius">
				<!--{if $ulb eq '208' || $ulb eq '210' || $ulb eq '3'}
				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">Village:</label>

						<select name="ulbid" class="form-control">
							<option value="">--select--</option>
							{html_options options=$villages selected=$ulb}
						</select>

					</div>
				</div>
				{/if}-
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


			</div>


		</div>


	</form>
</div>-->

<!--<div style="text-align:right;"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div>-->

<div class="" style="margin-top: -45px;">
  <form method="POST" class="form-horizontal">
    <input type="hidden" name="ulbid" value="{$ulbid}">
    <input type="hidden" name="app_type_id" value="{$app_type_id}">
    <input type="hidden" name="dept_id" value="{$dept_id1}">

    <div class="boxed">
      <div class="title-bar blue"></div>
      <div class="inner no-radius">
        <!--{if $ulb eq '208' || $ulb eq '210' || $ulb eq '3'}
                <div class="col-md-3" style="margin-right:15px;">
                    <div class="form-group">
                        <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">Village:</label>

                        <select name="ulbid" class="form-control">
                            <option value="">--select--</option>
                            {html_options options=$villages selected=$ulb}
                        </select>

                    </div>
                </div>
                {/if}-->
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

      </div>
    </div>
  </form>
</div>

<div class="boxed">


  <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
    <h4>DESIGNATION WISE ABSTRACT REPORT</h4>
    <!-- <p class="m-0"><a href="reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
    <div style="text-align:right;"><a href="designation_wise_abstract.php" class="btn btn-warning" onclick="history.go(-1);"><i class="fa fa-backward"></i> Back</a></div>
  </div>



  <div class="inner no-radius">
    <div id="area" class="table-responsive">

      <table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
        <caption style="caption-side:top; text-align:center;font-size:16px;">
          <b>
            <CENTER><strong>VIEW DESIGNATION WISE ABSTRACT REPORT DETAILS</strong></CENTER>
          </b>
        </caption>
        <thead>
          <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
            <th align='center' rowspan='2'> S.No </th>
            <th align='center' rowspan='2'> DESIGNATION NAME </th>
            <th align='center' rowspan='2'> RECEIVED </th>
            <th align='center' colspan='2'> PENDING </th>
            <th align='center' colspan='2'>COMPLETED </th>
            <th align='center' rowspan='2'> PENDING FOR APPROVAL </th>
            <th align='center' rowspan='2'>UN RESOLVABLE </th>
            <th align='center' rowspan='2'>REOPENED </th>
            <th align='center' rowspan='2'>REOPENED UNDERPROGRESS </th>
            <th align='center' rowspan='2'>REOPENED COMPLETED </th>
            <th align='center' rowspan='2'>REJECTED </th>
            <th align='center' rowspan='2'>FINANCIAL IMPLICATION </th>
          </tr>

          <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">

            <th align='center'>WITHIN SLA </th>
            <th align='center'>BEYOND SLA </th>
            <th align='center'>WITHIN SLA </th>
            <th align='center'>BEYOND SLA </th>

          </tr>

        </thead>
        <tbody>

          {foreach from=$street_list key=dept_id item=row}

          <tr>
            <td align='center'>{counter}</td>
            <td class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=0&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$street_list[$dept_id]}</a></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$dept_id].count neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=0&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$dept_id].count}</a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].pending neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=2&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].pending}</a>{else}-{/if}</a></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].pending_be_sla neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=8&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].pending_be_sla}</a>{else}-{/if}</a></td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].completed neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=3&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].completed}</a>{else}-{/if}</a></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=9&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].completed_be_sla}</a></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].pending_approval neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=1&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].pending_approval}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].unresolved neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=4&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].unresolved}</a>{else}-{/if}</a></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].reopened neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=5&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].reopened}</a>{else}-{/if}</a></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].reopened_pending neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=6&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].reopened_pending}</a>{else}-{/if}</a></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].reopened_completed neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=7&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].reopened_completed}</a>{else}-{/if}</a></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].rejected neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].rejected}</a>{else}-{/if}</a></td>
            <!--<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{$data_list[$dept_id].rejected}</td>-->
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].fin neq ''}<a href="designation_complaints.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=60&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$dept_id].fin}</a>{else}-{/if}</a></td>
          </tr>
          {/foreach}

        </tbody>
        {if $user_type eq 'U'}
        <tfoot>
          <td align='center' colspan='2'><strong>Total</strong></td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="designation_complaints.php?ulbid={$ulbid}&dept_id={$dept_id1}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=100">{$tot.received}</a></td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.pending gt 0}<a href="designation_complaints.php?app_type_id=1&status=02&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}"> {$tot.pending} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.pending_be_sla gt 0}<a href="designation_complaints.php?app_type_id=1&status=08&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}"> {$tot.pending_be_sla} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.completed gt 0}<a href="designation_complaints.php?app_type_id=1&status=03&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$tot.completed} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.completed_be_sla gt 0}<a href="designation_complaints.php?app_type_id=1&status=09&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$tot.completed_be_sla} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.pending_approva gt 0} <a href="designation_complaints.php?app_type_id=1&status=01&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}"> {$tot.pending_approval} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.unresolved gt 0}<a href="designation_complaints.php?app_type_id=1&status=04&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$tot.unresolved} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.reopened gt 0}<a href="designation_complaints.php?app_type_id=1&status=05&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$tot.reopened} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.reopened_pending gt 0}<a href="designation_complaints.php?app_type_id=1&status=06&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$tot.reopened_pending} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.reopened_completed gt 0}<a href="designation_complaints.php?app_type_id=1&status=07&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$tot.reopened_completed} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.rejected gt 0}<a href="designation_complaints.php?app_type_id=1&status=&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}">{$tot.rejected} </a>{else}<strong>0</strong>{/if}</td>
          <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.fin gt 0}<a href="designation_complaints.php?app_type_id=1&status=060&dept_id={$dept_id1}&f_date={$fdate}&t_date={$tdate}"> {$tot.fin} </a>{else}<strong>0</strong>{/if}</td>
        </tfoot><br>

        <!-- @endif -->
        {else}
        <!-- @if($user_type eq 'E') -->


        <!-- @endif -->
        {/if}
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