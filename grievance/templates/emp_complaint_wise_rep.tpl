{include file='header.tpl'}
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



<div class="" style="margin-top: -45px;">
   
<div class="boxed">
    
    <div class="title-bar blue"></div>
    <div class="inner no-radius">
	{if !empty($errors)}
		{foreach $errors as $error}
			<p style="color:red;">{$error}</p>
		{/foreach}
	{/if}
	<form name="search1" action="" method="post">
        <div class="col-md-3" style="margin-right:15px;">
          <div class="form-group">
            <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>

            <input type="text" class="phone-group form-control datepicker" name="f_date" id="f_date" value="{$fdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
			<div style="font-size:10px;color:red;" id="f_dateX"></div>
          </div>
        </div>


        <div class="col-md-3" style="margin-right:15px;">
          <div class="form-group">
            <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>

            <input type="text" class="phone-group form-control datepicker" name="t_date" id="t_date" value="{$tdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
			<div style="font-size:10px;color:red;" id="t_dateX"></div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group" style="margin-top:31px;">
            <input name="search" type="submit" class="btn btn-success" value="SEARCH" id="submitBtn" disabled>
          </div>
        </div>


  </form>
      </div>


    </div>


</div>

<div class="boxed">


  <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
    <h4>Complaint Wise Report</h4>
    <!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
    <p class="m-0"><a href="reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
  </div>



  <div class="inner no-radius">
    <div id="area" class="table-responsive">

      <table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
        <caption style="caption-side:top; text-align:center;font-size:16px;">
          <b>
            <CENTER><strong>VIEW COMPLAINT WISE REPORT DETAILS</strong></CENTER>
          </b>
        </caption>
        <thead>
          <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
            <th align='center' rowspan='2'> S.No </th>
            <!--	<th align='center'> Id </th>-->
            <th align='center' rowspan='2'> CATEGORY TYPE </th>
            <th align='center' rowspan='2'> GRIEVANCE </th>
            <!-- <th align='center' colspan='2'> RECEIVED </th>

            <th align='center' colspan='2'> PENDING </th> -->
            <th align='center' rowspan='2'> RECEIVED </th>
            <th align='center' colspan='2'> UNDER PROGRESS </th>
            <th align='center' colspan='2'>REDRESSED </th>
            <th align='center' rowspan='2'> RESOLVED </th>
            <th align='center' rowspan='2'>REOPENED </th>
            <th align='center' rowspan='2'>REOPENED UNDERPROGRESS </th>
            <th align='center' rowspan='2'>REOPENED COMPLETED </th>
            <th align='center' rowspan='2'> FINANCIAL IMPLICATIONS </th>
            <th align='center' rowspan='2'> PENDING FOR APPROVAL </th>
            <th align='center' rowspan='2'> REJECTED </th>
            <th align='center' rowspan='2'> UNRESOLVED </th>
            <th align='center' rowspan='2'> % OF COMPLETE </th>
          </tr>

          <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">

            <th align='center'>WITHIN SLA </th>
            <th align='center'>BEYOND SLA </th>
            <th align='center'>WITHIN SLA </th>
            <th align='center'>BEYOND SLA </th>

          </tr>

        </thead>
        <tbody>
          {assign var ="total_received" value="0"}
          {assign var ="pending_within_sla" value="0"}
          {assign var ="pending_beyond_sla" value="0"}
          {assign var ="resolved_within_sla" value="0"}
          {assign var ="resolved_beyond_sla" value="0"}
          {assign var ="tot_resolved" value="0"}
          {assign var ="reopened" value="0"}
          {assign var ="reopend_underProgress" value="0"}
          {assign var ="reopend_completed" value="0"}
          {assign var ="fin_implication" value="0"}
          {assign var ="pending_apprvl" value="0"}
          {assign var ="rejected" value="0"}
          {assign var ="unresolved" value="0"}
          {assign var ="percent" value="0"}


          {foreach from=$cs_list item=row key=cs_id}

          {$totreopend_underProgress = $totreopend_underProgress + $cs_list[$cs_id][11].reopend_underProgress}
          {$totreopend_completed = $totreopend_completed + $cs_list[$cs_id].reopend_completed}
          <tr>
            <td align='center'>{counter}</td>
            <td align='center'>{$cat_list[$cat_id[$cs_id].cat_id]}</td>
            <!--12-03-24 <td align='center'><a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=0&f_date={$fdate}&t_date={$tdate}">{$cs_list[$cs_id]}</a> -->
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank">{$cs_list[$cs_id]}</a>  
            <!-- <td align='center'><a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=0&f_date={$fdate}&t_date={$tdate}">{$data[$cs_id].count}</a></td> -->
            <!--23-05-24 <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].total_received neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=1&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].total_received}</a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].pending_within_sla neq ''}<a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=2&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].pending_within_sla}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].pending_beyond_sla neq ''}<a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=3&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].pending_beyond_sla}</a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].resolved_within_sla neq ''}<a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=4&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].resolved_within_sla}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].resolved_beyond_sla neq ''}<a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=5&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].resolved_beyond_sla}</a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].tot_resolved neq ''}<a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=6&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].tot_resolved}</a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].reopened neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=5&f_date={$fdate}&t_date={$tdate}" target="">{$data[$cs_id].reopened} </a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id][11].reopend_underProgress neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=6&f_date={$fdate}&t_date={$tdate}" target="">{$data[$cs_id][11].reopend_underProgress} </a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].reopend_completed neq ''}<a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=7&f_date={$fdate}&t_date={$tdate}" target="">{$data[$cs_id].reopend_completed} </a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].fin_implication neq ''}<a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=6&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].fin_implication}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].pending_apprvl neq ''}<a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=7&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].pending_apprvl}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].rejected neq ''}<a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=8&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].rejected}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].unresolved neq ''}<a href="emp_complaints_full_rep.php?app_type_id=1&cs_id={$cs_id}&status=8&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].unresolved}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].percent neq ''}{$data[$cs_id].percent}{else}-{/if}</td> 
			-->

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].total_received neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].total_received}</a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].pending_within_sla neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=2&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].pending_within_sla}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].pending_beyond_sla neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=8&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].pending_beyond_sla}</a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].resolved_within_sla neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=3&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].resolved_within_sla}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].resolved_beyond_sla neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=9&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].resolved_beyond_sla}</a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].tot_resolved neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=108&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].tot_resolved}</a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].reopened neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=5&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].reopened} </a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id][11].reopend_underProgress neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=105&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id][11].reopend_underProgress} </a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].reopend_completed neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=7&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].reopend_completed} </a>{else}-{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].fin_implication neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=10&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].fin_implication}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].pending_apprvl neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=7&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].pending_apprvl}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].rejected neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=8&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].rejected}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].unresolved neq ''}<a href="emp_complaints_full_rep.php?ulbid={$ulbid}&app_type_id=1&cs_id={$cs_id}&status=8&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$cs_id].unresolved}</a>{else}-{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$cs_id].percent neq ''}{$data[$cs_id].percent}{else}-{/if}</td>
          </tr>
          {/foreach}

        </tbody>
        <tfoot>
          <td align='center' colspan='3'><strong>Total</strong></td>
          <!--<td align='center'>{$tot.total_received}</td>


          <td align='center'>{$tot.resolved_within_sla}</td>
          <td align='center'>{$tot.resolved_beyond_sla}</td>

          <td align='center'>{$tot.pending_within_sla}</td>
          <td align='center'>{$tot.pending_beyond_sla}</td>

          <td align='center'>{$tot.fin_implication}</td>
          <td align='center'>{$tot.pending_apprvl}</td>
          <td align='center'>{$tot.rejected}</td>
          <td align='center'>{$tot.unresolved}</td>
          <td align='center'>{$tot.percent}</td>-->

          <td align='center'><strong>{if $tot.total_received neq ''}{$tot.total_received}{else}0{/if}</strong></td>

          <td align='center'><strong>{if $tot.pending_within_sla neq ''}{$tot.pending_within_sla}{else}0{/if}</strong></td>
          <td align='center'><strong>{if $tot.pending_beyond_sla neq ''}{$tot.pending_beyond_sla}{else}0{/if}</strong></td>
          
          <td align='center'><strong>{if $tot.resolved_within_sla neq ''}{$tot.resolved_within_sla}{else}0{/if}</strong></td>
          <td align='center'><strong>{if $tot.resolved_beyond_sla neq ''}{$tot.resolved_beyond_sla}{else}0{/if}</strong></td>
          
          <td align='center'><strong>{if $tot.tot_resolved neq ''}{$tot.tot_resolved}{else}0{/if}</strong></td>
          <td align='center'><strong>{if $tot.reopened neq ''}{$tot.reopened}{else}0{/if}</strong></td>

          <td align='center'><strong>{if $tot.reopend_underProgress neq ''}{$tot.reopend_underProgress}{else}0{/if}</strong></td>
          <td align='center'><strong>{if $tot.reopend_completed neq ''}{$tot.reopend_completed}{else}0{/if}</strong></td>

          <td align='center'><strong>{if $tot.fin_implication neq ''}{$tot.fin_implication}{else}0{/if}</strong></td>
          <td align='center'><strong>{if $tot.pending_apprvl neq ''}{$tot.pending_apprvl}{else}0{/if}</strong></td>
          <td align='center'><strong>{if $tot.rejected neq ''}{$tot.rejected}{else}0{/if}</strong></td>
          <td align='center'><strong>{if $tot.unresolved neq ''}{$tot.unresolved}{else}0{/if}</strong></td>
          <td align='center'><strong>{if $tot.percent neq ''}{$tot.percent}{else}0{/if}</strong></td>
        </tfoot>
      </table>
    </div>

    <br>
    
  </div>
</div>




<br>




<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>

{include file='footer_print.tpl'}

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
