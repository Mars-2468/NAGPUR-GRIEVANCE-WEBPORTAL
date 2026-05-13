{include file='header.tpl'}
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
<!-- <div id="area"> -->
<div>


  <div class="boxed">

    <div class="title-bar blue">
      <h4>EMPLOYEE WISE REPORT</h4>
    </div>
    <div class="inner no-radius">
	{if !empty($errors)}
		{foreach $errors as $error}
			<p style="color:red;">{$error}</p>
		{/foreach}
	{/if}
      <form method="POST" class="form-horizontal">
        <input type="hidden" name="ulbid" value="{$ulbid}">
        <input type="hidden" name="app_type_id" value="{$app_type_id}">
        <input type="hidden" name="dept_id" value="{$dept_id1}">

        <div class="col-md-4">
          <div class="form-group">            
            <label class="control-label col-sm-6" for="usr">Employee Name:</label>
            <div class="col-sm-6">
              <input type="text" class="phone-group form-control demoInputBox" name="emp_name" id="emp_name" value="{$emp_name}" placeholder="Enter Employee Name" data-type="text" onkeyup="funInputFielTypes(this)" autocomplete="off">
             <div style="font-size:10px;color:red;" id="emp_nameX"></div>
			</div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label col-sm-5" for="usr">From Date:</label>
            <div class="col-sm-7">
              <input type="text" class="phone-group form-control datepicker" name="f_date" id="f_date" value="{$fdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
			<div style="font-size:10px;color:red;" id="f_dateX"></div>	
			</div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label col-sm-5" for="usr">To Date:</label>
            <div class="col-sm-7">
              <input type="text" class="phone-group form-control datepicker" name="t_date" id="t_date" value="{$tdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
			<div style="font-size:10px;color:red;" id="t_dateX"></div>	
			</div>
          </div>
        </div>

        <div class="button-container">
					<input name="search" type="submit" class="btn btn-success" value="SEARCH" id="submitBtn" disabled>
				
          <a href="reports.php" class="btn btn-warning" onclick="history.go(-1);">
						<i class="fa fa-backward"></i> Back
					</a>
				</div><br>
      </form>
</div><br>
      <div id="area" class="table-responsive">
        <table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
          <caption style="caption-side:top; text-align:center;font-size:16px;">
            <b>
              <CENTER><strong>VIEW EMPLOYEE WISE REPORT DETAILS</strong></CENTER>
            </b>
          </caption>
          <thead>
            <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
              <th align='center' rowspan='2'>S.No</th>
              <th align='center' rowspan='2'>EMPLOYEE NAME </th>
              <th align='center' rowspan='2'>DEPARTMENT NAME </th>
              <th align='center' rowspan='2'>ZONE NAME </th>
              <th align='center' rowspan='2'>WARD NAME </th>
              <th align='center' rowspan='2'>RECEIVED</th>
              <th align='center' colspan='2'>PENDING</th>
              <th align='center' colspan='2'>COMPLETED</th>
              <th align='center' rowspan='2'>UN Resolvable</th>
              <th align='center' rowspan='2'>REOPENED</th>
              <th align='center' rowspan='2'>REOPENED Underprogress</th>
              <th align='center' rowspan='2'>REOPENED Completed</th>
              <th align='center' rowspan='2'>REJECTED</th>
              <th align='center' rowspan='2'>FINANCIAL Implication</th>
            </tr>
            <tr style="background-color:#2c3e50; color:#FFF; text-align:center;">
              <th>With in SLA</th>
              <th>Beyond SLA</th>

              <th>With in SLA</th>
              <th>Beyond SLA</th>
            </tr>

          </thead>
          <tbody>

            {foreach from=$emp_list key=dept_id item=row}

            <tr>
              <td align='center'>{counter} <?php


                                            ?></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=0&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}">{$emp_list[$dept_id]}</a></td>
              <td align='center'>{$dept_list[$emp_dept_list[$dept_id]]}</td>
              <td align='center'>{$zone_ids1[$zid[$dept_id]]}</td>
              <td align='center'>{$street_ids1[$sid[$dept_id]]}</td>


              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$dept_id].count neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=0&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data[$dept_id].count}</a>{else}-{/if}</td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].pending neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=2&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].pending}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].pending_be_sla neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=8&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].pending_be_sla}</a>{else}-{/if}</td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].completed neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=3&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].completed}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].completed_be_sla neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=9&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].completed_be_sla}</a>{else}-{/if}</td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].unresolved neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=4&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].unresolved}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].reopened neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=5&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].reopened}</a>{else}-{/if}</a></td>
               <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].reopened_pending neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=105&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].reopened_pending}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].reopened_completed neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=7&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].reopened_completed}</a>{else}-{/if}</a></td>
              <td align='center'>{if $data_list[$dept_id].rejected neq ''}{$data_list[$dept_id].rejected}{else}-{/if}</td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$dept_id].fin neq ''}<a href="all_empwise_comp_det.php?app_type_id={$app_type_id}&emp_id={$dept_id}&status=10&dept_id={$emp_dept_list[$dept_id]}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$dept_id].fin}</a>{else}-{/if}</a></td>
            </tr>
            {/foreach}

          </tbody>
          <tfoot>
            <td align='center' colspan="5"><strong>Total</strong></td>
           
            <!-- <td align='center'><a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=100">{$tot.received}</a></td>  -->
            <!-- <td align='center'>{if $tot.pending gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=200">{$tot.pending}</a>{else}{$tot.pending}{/if}</td> -->
            <!-- <td align='center'>{if $tot.pending_be_sla gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=300">{$tot.pending_be_sla}</a>{else}{$tot.pending_be_sla}{/if}</td> -->
            <!-- <td align='center'>{if $tot.completed gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=400">{$tot.completed}</a>{else}{$tot.completed}{/if}</td>
              <td align='center'>{if $tot.completed_be_sla gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=500">{$tot.completed_be_sla}</a>{else}{$tot.completed_be_sla}{/if}</td>
              <td align='center'>{$tot.unresolved}</td>
              <td align='center'>{if $tot.reopened gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=600">{$tot.reopened}</a>{else}{$tot.reopened}{/if}</td>
              <td align='center'>{$tot.reopened_pending}</td>
              <td align='center'>{$tot.reopened_completed}</td>
              <td align='center'>{$tot.rejected}</td>
              <td align='center'>{if $tot.fin gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=700">{$tot.fin}</a>{else}{$tot.fin}{/if}</td> -->

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.received neq ''}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=101">{$tot.received}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.pending neq ''}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=201">{$tot.pending}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.pending_be_sla neq ''}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=301">{$tot.pending_be_sla}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.completed neq ''}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=401">{$tot.completed}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.completed_be_sla neq ''}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=501">{$tot.completed_be_sla}</a>{else}0{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot.unresolved neq ''}{$tot.unresolved}{else}0{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.reopened neq ''}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=601">{$tot.reopened}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot.reopened_pending neq ''}{$tot.reopened_pending}{else}0{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot.reopened_completed neq ''}{$tot.reopened_completed}{else}0{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot.rejected neq ''}{$tot.rejected}{else}0{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.fin neq ''}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=701">{$tot.fin}</a>{else}<strong>0</strong>{/if}</td>
          </tfoot>
        </table>
      </div>


    </div>

  </div>





</div>
<br>

<div>
  <center>
    <!-- <input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	  <input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
    <button class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export to PDF</button> -->
    <input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export To Excel" class="btn btn-success">
    <button class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
    <input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
  </center>
</div>

<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
{include file='footer.tpl'}

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
