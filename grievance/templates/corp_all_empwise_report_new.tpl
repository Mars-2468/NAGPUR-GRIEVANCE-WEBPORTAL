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
 /*  th {
    text-align: center !important;
  }

  a {
    color: blue;
    text-decoration: underline;
  }

  Your regular styles go here */

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
 <style>
        table {
            border-collapse: collapse;         
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
           
            padding: 8px;
        }
        th a {
            text-decoration: none;
            color: #0a0a0a;
        }
        th a:hover {
            text-decoration: underline;
			color:red;
        }
		.total-row{
			color:red;
		}
    </style>

{/literal}
<!-- <div id="area"> -->
<div>



  <div class="boxed">

    <div class="title-bar blue">
      <h4>EMPLOYEE WISE PENDING REPORT</h4>
    </div>
    <div class="inner no-radius">

      <form method="POST" class="form-horizontal">
        <input type="hidden" name="ulbid" value="{$ulbid}">
        <input type="hidden" name="ulbid" value="{$ulbid}">
        <input type="hidden" name="dept_id" value="{$dept_id1}">

        <div class="col-md-4">
          <div class="form-group">
            <!-- <label class="control-label col-sm-6" for="usr">Reference No:</label>
						<div class="col-sm-6">
							<input type="text" class="phone-group form-control demoInputBox" name="reference_no" value="{$reference_no}" placeholder="Enter Reference No" autocomplete="off">
						</div> -->
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
					<a href="corp_reports.php" class="btn btn-warning" onclick="history.go(-1);">
						<i class="fa fa-backward"></i> Back
					</a>
				</div>
      </form>
     
      <div class="table-responsive" style="width:100%;">
        <div id="area">
          <table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
            <caption style="caption-side:top; text-align:center;font-size:16px;">
              <b>
                <CENTER><strong>VIEW EMPLOYEE WISE PENDING REPORT DETAILS </strong></CENTER>
              </b>
            </caption>
            <thead>
              <tr style="background-color:#2c3e50; color:#0a0a0a !important; text-align:center;cursor:pointer !important;">
          
				
				<th onclick="sortTable(0)"><a href="#" >S.NO </a>&#x25B2;&#x25BC;</th>
                <th onclick="sortTable(1)"><a href="#">EMPLOYEE NAME </a>&#x25B2;&#x25BC;</th>
                <th onclick="sortTable(2)"><a href="#">DEPARTMENT NAME </a>&#x25B2;&#x25BC;</th>
                <th onclick="sortTable(3)"><a href="#">ZONE NAME </a>&#x25B2;&#x25BC;</th>
                <th onclick="sortTable(4)"><a href="#">STREET NAME </a>&#x25B2;&#x25BC;</th>
                <th onclick="sortTable(5)"><a href="#">RECIEVED </a>&#x25B2;&#x25BC;</th>
             
				<th  onclick="sortTable(6)"><a href="#">PENDING WITHIN SLA</a>&#x25B2;&#x25BC;</th>
				<th  onclick="sortTable(7)"><a href="#">PENDING BEYOND SLA</a>&#x25B2;&#x25BC;</th>
                <th  onclick="sortTable(8)"><a href="#">COMPLETED WITHIN SLA</a>&#x25B2;&#x25BC;</th>
                <th  onclick="sortTable(9)"><a href="#">COMPLETED BEYOND SLA</a>&#x25B2;&#x25BC;</th>
                <th  onclick="sortTable(10)"><a href="#">REOPENED</a>&#x25B2;&#x25BC;</th>
                <th  onclick="sortTable(11)"><a href="#">REOPENED COMPLETED</a>&#x25B2;&#x25BC;</th>
                <th  onclick="sortTable(12)"><a href="#">REOPENED UNDER PROGRESS</a>&#x25B2;&#x25BC;</th>
                <th  onclick="sortTable(13)"><a href="#">FINANCIAL IMPLECATIONS</a>&#x25B2;&#x25BC;</th>
                <th  onclick="sortTable(14)"><a href="#">TRANSFERED</a>&#x25B2;&#x25BC;</th>
				
              </tr>
            </thead>
			
            <tbody>
             
			{foreach from=$emp_details_list key=emp_id item=row}
              <tr>
        		 
			  <td align='center'>{counter}</td>
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=100">{$row['emp_name']}</a></td>
			  <td>{$row['dept_name']}</td>
			  <td>{$row['zone_ids']}</td>
			  <td>{$row['street_ids']}</td>
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=100">{$emp_details_list[$emp_id]['received']}</a></td>
			  
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=200">{$emp_details_list[$emp_id]['pending_within_sla']}</a></td>
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=201">{$emp_details_list[$emp_id]['pending_beyond_sla']}</a></td>
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=300">{$emp_details_list[$emp_id]['completed_within_sla']}</a></td>
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=301">{$emp_details_list[$emp_id]['completed_beyond_sla']}</a></td>
			  
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=400">{$emp_details_list[$emp_id]['reopened']}</a></td>
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=401">{$emp_details_list[$emp_id]['reopened_completed']}</a></td>
			  
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=402">{$emp_details_list[$emp_id]['reopened_underprogress']}</a></td>
			  
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=600">{$emp_details_list[$emp_id]['financial_implications']}</a></td>
			 
			  <td><a class="text-primary" href="employeewise_grievances.php?ulbid={$ulbid}&emp_id={$emp_id}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=500">{$emp_details_list[$emp_id]['transfered']}</a></td>
			
			  
			  
			  </tr> 
			  
			  
              {/foreach}

            </tbody>
		 
            <tfoot>
			 <tr class="total-row">
              <th align='center' colspan="5" class="text-center"><strong style="color:black;">Total</strong></th>
              
              <th align='center'><a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=100">{$emp_details_list_total.received}</a></th>
			
              <th align='center'>{if $emp_details_list_total.pending_within_sla gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=200">{$emp_details_list_total.pending_within_sla}</a>{else}{$emp_details_list_total.pending_within_sla}{/if}</th>
              <th align='center'>{if $emp_details_list_total.pending_beyond_sla gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=201">{$emp_details_list_total.pending_beyond_sla}</a>{else}{$emp_details_list_total.pending_beyond_sla}{/if}</th>
              
			  <th align='center'>{if $emp_details_list_total.completed_within_sla gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=300">{$emp_details_list_total.completed_within_sla}</a>{else}{$emp_details_list_total.completed_within_sla}{/if}</th>
			  <th align='center'>{if $emp_details_list_total.completed_beyond_sla gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=301">{$emp_details_list_total.completed_beyond_sla}</a>{else}{$emp_details_list_total.completed_beyond_sla}{/if}</th>
			  
			  <th align='center'>{if $emp_details_list_total.reopened gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=400">{$emp_details_list_total.reopened}</a>{else}{$emp_details_list_total.reopened}{/if}</th>
			  <th align='center'>{if $emp_details_list_total.reopened_completed gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=401">{$emp_details_list_total.reopened_completed}</a>{else}{$emp_details_list_total.reopened_completed}{/if}</th>
			  <th align='center'>{if $emp_details_list_total.reopened_underprogress gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=402">{$emp_details_list_total.reopened_underprogress}</a>{else}{$emp_details_list_total.reopened_underprogress}{/if}</th>
			  <th align='center'>{if $emp_details_list_total.financial_implications gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=600">{$emp_details_list_total.financial_implications}</a>{else}{$emp_details_list_total.financial_implications}{/if}</th>
			  <th align='center'>{if $emp_details_list_total.transfered gt 0}<a href="employeewiseTotalGrievances.php?ulbid={$ulbid}&dept_id={$emp_dept_list[$dept_id]}&app_type_id={$app_type_id}&f_date={$fdate}&t_date={$tdate}&status=500">{$emp_details_list_total.transfered}</a>{else}{$emp_details_list_total.transfered}{/if}</th>
			
			</tr>
			</tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>





<!-- test code start -->
<style>
    th {
        cursor: pointer;
        background-color: #f2f2f2;
    }
    th:hover {
        background-color: #ddd;
    }
    .asc::after {
        content: " \u25B2"; /* Up arrow */
    }
    .desc::after {
        content: " \u25BC"; /* Down arrow */
    }
</style>

<!-- <table id="sortableTable" border="1">
    <thead>
        <tr>
            <th onclick="sortTable(0)">Name &#x25B2;&#x25BC;</th>
            <th onclick="sortTable(1)">Age &#x25B2;&#x25BC;</th>
            <th onclick="sortTable(2)">City &#x25B2;&#x25BC;</th>
            <th onclick="sortTable(3)">Phone &#x25B2;&#x25BC;</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Sagar</td>
            <td>30</td>
            <td>Hyderabad</td>
            <td>9909923146</td>
        </tr>
        <tr>
            <td>Anjali</td>
            <td>25</td>
            <td>Bangalore</td>
			 <td>9609923146</td>
        </tr>
        <tr>
            <td>Ravi</td>
            <td>35</td>
            <td>Chennai</td>
			 <td>9907923146</td>
        </tr>
    </tbody>
</table> -->
<script>
    let sortOrder = {}; // Object to store the current sort direction for each column

    function sortTable(columnIndex) {
        const table = document.getElementById("example");
        const rows = Array.from(table.tBodies[0].rows); // Get all rows from tbody
        const isNumeric = !isNaN(rows[0].cells[columnIndex].innerText.trim()); // Check if column data is numeric

        // Separate the total row if it exists
        const totalRow = document.querySelector(".total-row");
        if (totalRow) {
            totalRow.parentElement.removeChild(totalRow); // Temporarily remove the total row
        }

        // Toggle sort direction (asc/desc)
        sortOrder[columnIndex] = sortOrder[columnIndex] === "asc" ? "desc" : "asc";

        rows.sort((rowA, rowB) => {
            const cellA = rowA.cells[columnIndex].innerText.trim();
            const cellB = rowB.cells[columnIndex].innerText.trim();

            if (isNumeric) {
                return sortOrder[columnIndex] === "asc"
                    ? cellA - cellB
                    : cellB - cellA;
            } else {
                return sortOrder[columnIndex] === "asc"
                    ? cellA.localeCompare(cellB)
                    : cellB.localeCompare(cellA);
            }
        });

        // Re-append sorted rows to the table body
        rows.forEach(row => table.tBodies[0].appendChild(row));

        // Re-append the total row at the bottom
       /* if (totalRow) {
            table.tBodies[0].appendChild(totalRow);
        } */
		
		const tfoot = document.querySelector("table tfoot");
		if (totalRow) {
			tfoot.appendChild(totalRow);
		}
    }
</script>


<!-- test code end -->









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
		dateFormat: 'yy-mm-dd',
		minDate: '{$smarty.session.threshold_date}',
		changeMonth: true,
		changeYear: true
    });
  });
</script>