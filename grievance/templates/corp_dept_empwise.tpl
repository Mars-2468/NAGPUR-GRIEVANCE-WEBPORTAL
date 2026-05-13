{include file='corp_header.tpl'}
{literal}
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /> Data Table CSS -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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


{/literal}
<!-- <div id="area"> -->
<div>


  <div class="boxed">

    <div class="title-bar blue">
      <h4>Department: {$dept_list[$dept_id1]}</h4>
    </div>
    <div class="inner no-radius">

      <!-- <form method="GET" class="form-horizontal"> -->
      <form method="GET" class="form-horizontal">
        <input type="hidden" name="ulbid" value="{$ulbid}">
        <input type="hidden" name="app_type_id" value="{$app_type_id}">
        <input type="hidden" name="dept_id" value="{$dept_id1}">

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
         
        </div><br>
      </form>
	  
	 </div> 
          <div id="area" class="table-responsive">
        <table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
          <caption style="caption-side:top; text-align:center;font-size:16px;">
            <b>
              <CENTER><strong class="title-bar">DEPARTMENT: {$dept_list[$dept_id1]|upper} COMPLAINT DETAILS</strong></CENTER>
            </b>
          </caption>
		  
		
		  <thead>
            <tr style="background-color:#2c3e50; color:#FFF; text-align:center;">
              <th align='center' rowspan='2'>S.No</th>
              <th align='center' rowspan='2'>EMPLOYEE NAME </th>
              <th align='center' rowspan='2'>ZONE NAME </th>
              <th align='center' rowspan='2'>WARD NAME </th>
              <th align='center' rowspan='2'>RECEIVED</th>
              <th align='center' colspan='2'>PENDING</th>
              <th align='center' colspan='2'>COMPLETED</th>
              <th align='center' rowspan='2'>UN RESOLVABLE</th>
              <th align='center' rowspan='2'>REOPENED</th>
              <th align='center' rowspan='2'>REOPENED UNDERPROGRESS</th>
              <th align='center' rowspan='2'>REOPENED COMPLETED</th>
              <th align='center' rowspan='2'>REJECTED</th>
              <th align='center' rowspan='2'>FINANCIAL IMPLICATION</th>
              <th align='center' rowspan='2'>TRANSFERES</th>
            </tr>
            <tr style="background-color:#2c3e50; color:#FFF; text-align:center;">
              <th>WITH IN SLA</th>
              <th>BEYOND SLA</th>

              <th>WITH IN SLA</th>
              <th>BEYOND SLA</th>
            </tr>

          </thead>
          <tbody>

            {foreach from=$emp_list key=emp_id item=row}
				{$emp_dept_id=$data_list[$emp_id]['dept_id']}
            <tr>
              <td align='center'>{counter}</td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=0&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}">{$emp_list[$emp_id]}-{$emp_id}-{$emp_dept_id}</a></td>

              <td align='center'>
			  {if $zid[$emp_id] neq ''}{$zone_ids1[$zid[$emp_id]]}{else}-{/if}
			  </td>
              <td align='center'>
			  {if $sid[$emp_id] neq ''}{$street_ids1[$sid[$emp_id]]}{else}-{/if}
			  </td>


              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].count neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=0&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].count}</a>{else}-{/if}</td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].pending_within_sla neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=2&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].pending_within_sla}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].pending_beyond_sla neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=8&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].pending_beyond_sla}</a>{else}-{/if}</td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].completed_within_sla neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=3&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].completed_within_sla}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].completed_beyond_sla neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=9&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].completed_beyond_sla}</a>{else}-{/if}</td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].unresolved neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=4&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].unresolved}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].reopened neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=5&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].reopened}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].reopened_pending neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=105&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].reopened_pending}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].reopened_completed neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=7&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].reopened_completed}</a>{else}-{/if}</a></td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].rejected neq ''}{$data_list[$emp_id].rejected}{else}-{/if}</td>
              <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].fin neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=10&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].fin}</a>{else}-{/if}</a></td>
           
		        <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$emp_id].transfers neq ''}<a href="corp_comp_det1.php?app_type_id={$app_type_id}&emp_id={$emp_id}&status=101&dept_id={$emp_dept_id}&f_date={$fdate}&t_date={$tdate}" target="">{$data_list[$emp_id].transfers}</a>{else}{$data_list[$emp_id].transfers} {/if}</td>
          

		   </tr>
            {/foreach}

          </tbody>		  
          <tfoot>

            <td align='center' colspan='4'><strong>Total</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.received gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=100">{$tot.received}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.pending_within_sla gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=21">{$tot.pending_within_sla}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.pending_beyond_sla gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=22">{$tot.pending_beyond_sla}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.completed_within_sla gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=3891">{$tot.completed_within_sla}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.completed_beyond_sla gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=3892">{$tot.completed_beyond_sla}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot.unresolved gt 0}{$tot.unresolved}{else}0{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.reopened gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=13">{$tot.reopened}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot.reopened_pending gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=11">{$tot.reopened_pending}</a>{else}0{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot.reopened_completed gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=12">{$tot.reopened_completed}</a>{else}0{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot.rejected gt 0}{$tot.rejected}{else}0{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.fin gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=6">{$tot.fin}</a>{else}<strong>0</strong>{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot.fin gt 0}<a href="corp_dept_employee_total_grievances.php?ulbid={$ulbid}&dept_id={$emp_dept_id}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=510">{$tot.transfers}</a>{else}<strong>{$tot.transfers}</strong>{/if}</td>
          </tfoot>
		  
		  
        </table>
		
		
      </div>


    </div>

  </div>





</div>
<br>

<div>
  <center>
    <input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export To Excel" class="btn btn-success">
    <button class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
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