{include file='header.tpl'}
{literal}

<script>
	function get_det(dept_id) {
		var select = document.getElementById("desg_id");
		select.options.length = 0;

		if (window.XMLHttpRequest)
			xmlhttp = new XMLHttpRequest();
		else
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var strArray = xmlhttp.responseText.split("___");
				var j = strArray.length;
				for (i = 0; i < j; i++) {
					var optArray = strArray[i].split(":::");
					select.options[select.options.length] = new Option(optArray[1], optArray[0]);
				}
			}
		}
		xmlhttp.open("GET", "get_designations.php?dept_id=" + dept_id, true);
		xmlhttp.send();
	}
	
	function get_street(ward_id) {
		var select1 = document.getElementById("street_id");
		select1.options.length = 0;

		if (window.XMLHttpRequest)
			xmlhttp = new XMLHttpRequest();
		else
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var strArray = xmlhttp.responseText.split("___");
				var j = strArray.length;
				for (i = 0; i < j; i++) {
					var optArray = strArray[i].split(":::");
					select1.options[select1.options.length] = new Option(optArray[1], optArray[0]);
				}
			}
		}
		xmlhttp.open("GET", "get_streets.php?ward_id=" + ward_id, true);
		xmlhttp.send();
	}
		
	function valRemarks(){
	
		var alphanumericsp=/^[A-Za-z0-9\s.,#\/&'-]+$/;
		var remarks = document.getElementById('remarks');
		
		if(!alphanumericsp.test(remarks.value))
		{
			alert("Please Enter only alphanumerics and [ .,#\/&'- ] only allowed! ");
			remarks.value="";
			return false;
		}
		
	}	
	
	function valAddress(){
	
		var alphanumericsp=/^[A-Za-z0-9\s.,#\/&'-]+$/;
		var address = document.getElementById('field_verification_address');
		
		if(!alphanumericsp.test(address.value))
		{
			alert("Please Enter only alphanumerics and [ .,#\/&'- ] only allowed! ");
			address.value="";
			return false;
		}
		
	}	
	
	function valReason(){
	
		var alphanumericsp=/^[A-Za-z0-9\s.,#\/&'-]+$/;
		var reason = document.getElementById('field_verification_reason');
		
		if(!alphanumericsp.test(reason.value))
		{
			alert("Please Enter only alphanumerics and [ .,#\/&'- ] only allowed! ");
			reason.value="";
			return false;
		}
		
	}
	
	function checkTitle(ele){
	
		var alphanumericsp=/^[A-Za-z0-9\s-_]+$/;
		
		if(!alphanumericsp.test(ele.value))
		{
			alert("Please Enter only alphanumerics,space and _ only allowed! ");
			ele.value="";
			return false;
		}
		
	}
	
	function checkFile(input) {
	//alert(input);
		let file = input.files[0];
		
		const allowedTypes = ["image/jpeg", "image/png", "application/pdf"]; // Allowed file types
		const maxSize = 5 * 1024 * 1024; // 5MB size limit

		if (file) {
			if (!allowedTypes.includes(file.type)) {
				alert("Invalid file type. Only JPG, PNG, and PDF allowed.");
				input.value = ""; // Reset field
			}else if (file.size > maxSize) {
				alert("File too large. Max 2MB allowed.");
				input.value = ""; // Reset field
			} 
		}
	}
				
	function validateForm() {
	
		var dept_id = document.field_visitor_form.dept_id.value;
		var desg_id = document.field_visitor_form.desg_id.value;
		var ward_id = document.field_visitor_form.ward_id.value;
		var street_id = document.field_visitor_form.street_id.value;
		var lat = document.field_visitor_form.lat.value;
		var lang = document.field_visitor_form.lang.value;
		var field_verification_reason = document.field_visitor_form.field_verification_reason.value;
		var field_verification_address = document.field_visitor_form.field_verification_address.value;
		
		var filter = /^[6-9]{1}[0-9]{9}$/;
		var patt1 = /^[\w]+[\w\s-./]+$/;
		
		var alphanumericsp=/^[A-Za-z0-9 ]+$/;
		var numeric=/^\d+$/;

		if(!alphanumericsp.test(field_verification_reason))
		{
			alert("Please Enter field verification reason! ");
			return false;
		}
		
		if(!alphanumericsp.test(field_verification_address))
		{
			alert("Please Enter field verification address! ");
			return false;
		}
		
		if (dept_id == '') {
			alert("Please Select Department..!");
			return false;
		}
				
		if (desg_id == '') {
			alert("Please Select designation..!");
			return false;
		}
		
		if (ward_id == '') {
			alert("Please Select ward..!");
			return false;
		}
		
		if (street_id == '') {
			alert("Please Select ward..!");
			return false;
		}
		
		const lat_lang_regex = /^[+-]?\d+(\.\d+)?$/;
		
		if(!lat_lang_regex.test(lat))
		{
			alert("Please Enter only decimal or float values only! ");
			return false;
		}

		if(!lat_lang_regex.test(lang))
		{
			alert("Please Enter only decimal or float values only! ");
			return false;
		}

		return true;
	}

	function delete_rec(id) {
//alert(id);
		if (confirm('Do Your Really Want To Delete This Record?')) {

			$.post('field_inspection_del.php', {
				id: id,				
			}, function(data) {

				if (data) {

					alert('Record Deleted Successfully..!');
					window.location = 'inspection.php';
				} else {
					alert('Error: Try Again..!');
				}
			});
		}
	}


	function delete_desg(i, emp_id, desg_id) {
		if (confirm('Do Your Really Want To Delete This Record?')) {
			$.post('ajax_delete_emp_desg.php', {
				emp_id: emp_id,
				desg_id: desg_id,
			}, function(data) {
				if (data == 1) {
					$('#trid' + i).css('display', 'none');
					alert('Deleted Successfully..!');
				} else {
					alert('Unable To Delete, Try Again..!');
				}
			});
		}
	}

	function get_designations(dept_id, i, code) {

		$.post('get_designations2.php', {
			dept_id
		}, function(data) {
			if (code == '2') {
				$("#desg_m" + i).html(data);
			} else {

				$("#desg_id" + i).html(data);
			}
		});
	}

	function get_streets(ward_id, i, code) {
//alert(ward_id);
		$.post('get_street_list.php', {
			ward_id
		}, function(data) {		

				$("#street_id" + i).html(data);
			
		});
	}

	function addAdvance() {

		var divcontent;
		var i = document.getElementById('cnt').value;

		var j = i - 1;

		var newdiv = document.createElement('tr');
		newdiv.setAttribute('id', i);
		newdiv.setAttribute('class', 'addrow');
		divcontent = "";
		
		divcontent = divcontent + "<td align='center' style='padding:5px;'>";
		divcontent = divcontent + "Doc Type:<input name='doctitle[]' type='text' class='form-control mytext' style='width:200px;' onchange='checkTitle(this)'>";
		divcontent = divcontent + "</td>";
		
		divcontent = divcontent + "<td align='left' style='padding:5px;'>";
		divcontent = divcontent + "File:<input name='docfiles[]'  type='file' class='form-control mytext' style='width:200px;' onchange='checkFile(this)'> ";
		divcontent = divcontent + "</td>";



		
		divcontent = divcontent + "<td align='left' style='padding:5px;'><input type='button' value='Remove' class='btn btn-default' style='margin-top: 20px;' onclick='fnRemove(" + i + ");' /></td>";

		divcontent = divcontent + "</tr>";


		newdiv.innerHTML = divcontent;
		document.getElementById('advance_div').appendChild(newdiv);

		document.getElementById('cnt').value = eval(document.getElementById('cnt').value) + 1;
	}

	function fnRemove(arg) {
		var d1 = document.getElementById(arg).parentNode;
		var d2 = document.getElementById(arg);
		d1.removeChild(d2);
		var arg = arg - 1;
		// document.getElementById('cnt').value=eval (document.getElementById('cnt').value) - 1 ;
	}

	function update_desg(id, i, emp_id) {

		dept_id = $("#dept_m" + i).val();
		desg_id = $("#desg_m" + i).val();
		$.post('ajax_update_desg.php', {
			id: id,
			desg_id: desg_id,
			dept_id: dept_id,
			emp_id: emp_id
		}, function(data) {
			alert(data);
		});
	}
</script>
<script>
	$(document).ready(function() {
		$("#od").click(function() {
			if (this.checked) {
				$("#od").val(1);
			} else {
				$("#od").val(0);
			}
		});
	});
</script>


<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('https://municipalservices.in/manage_emp.php #ref', function() {
				/// can add another function here
			});
		});
	}); //// End of Wait till page is loaded
</script>

<style>
table thead tr th{
background-color:#2c3e50 !important;
color:#FFF !important;
}

</style>


{/literal}

<div class="row">
	<div class="boxed">
		<div id="area">
		<div class="title-bar1 white d-flex bg-primary justify-content-between align-items-center p-2">
			<h4>USERS SERVICE DETAILS</h4>		
			<a href="all_user_logs.php" class="btn btn-outline-light">LOGS...</a>		
		</div>
		
		
			<div class="inner no-radius table-responsive" id="div_print">
			<div class="d-flex justify-content-between">
			
				<div class="col-sm-4">
				<h1> Active Logins : <span class="badge badge-info">{$is_active_count}</span></h1>
				</div>			
				<div class="col-sm-4">			
					<input type="text" id="tableSearch" class="form-control mb-3" placeholder="Search table..." >
				</div>
			</div>
			<table id="data-table" class="table table-striped table-bordered table-hover table-full-width"  width="100%">
					<thead>
						<tr >
							<th style="text-align: center;">SR.No</th>
							<th style="text-align: center;">USER ID</th>
							<th style="text-align: center;">EMP ID</th>
							<th style="text-align: center;">NAME</th>
							<th style="text-align: center;">MOBILE</th>
							<th style="text-align: center;">USER TYPE</th> 
							<th style="text-align: center;">LOG Status</th> 
							<th class="export" style="text-align: center;">DETAIL INFO</th>
						
						</tr>
					</thead>
					<tbody>
						<tr>
						
						{foreach from=$data item=row key=user_id}
						<tr>
							<td style="text-align: center;">{counter}</td>
							<td style="">{$row.user_id}</td>
							<td style="">{$row.emp_id}</td>
							<td style="">{$row.user_name}</td>
							<td style="text-align: center;">{$row.user_mobile}</td>
							<td style="text-align: center;">{$row.user_type}</td>
							{if $row.is_active}
								<td style="text-align: center;background-color:#00FF00;"><i class="fa fa-sign-in" style="font-size:18px;"></i></td> 
							{else} 
								<td style="text-align: center;background-color:#FF0000;color:#FFF;"><i class="fa fa-sign-out" style="font-size:18px;"></i></td> 
							{/if}							
							<td style="text-align: center;">
								<form action="view_user_details.php" method="post">
									<input type="hidden" name="user_id" value="{$user_id}">
									<input type="submit" class="btn btn-primary" name="update" value="View">
								</form>
							</td>
						
							
						</tr>
						
						{/foreach}
						
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>









	{literal}
	<script src='../js/jquery.min.js'></script>
	<script>
		$(document).ready(function() {

			$(".num").keypress(function(e) {

				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					return false;
				}
			});
		});

		function check_mobile(mobile) {
			$.post('ajax_mobile_check.php', {
				mobile: mobile
			}, function(data) {
				if (data == 1) {
					alert('This Mobile Number Is Already In Use, We Are Will Add These Employee As Deputation..!');
					$("#od").val('1');
					$("#emp_status").val('1');
					$("#od_area").css('display', 'block');
				}
			});
		}
	</script>
	{/literal}
	
	{literal}

<div style="display:none" id="pdf-text"></div>
<style>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

 <script>
      async function exportToExcel() {
    let workbook = new ExcelJS.Workbook();
    let worksheet = workbook.addWorksheet("Field Inspection Data");

    // Define header row with custom styles
    let headerRow = worksheet.addRow(["SR.No", "ZONE", "WARD", "DEPARTMENT", "DESIGNATION", "VERIFICATION REASON", "ADDRESS", "REMARKS"]);
    const headerColors = ["FF5733", "33A1FF", "28A745", "FFC107", "9B59B6", "000000", "FF0000", "FF4500"]; // Custom colors for each column header

    // Apply styles to header cells
    headerRow.eachCell((cell, colNumber) => {
        cell.font = { bold: true, color: { argb: "FFFFFF" } }; // White text
        cell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: headerColors[5] } }; // Apply color based on column
        cell.alignment = { horizontal: "center", vertical: "middle" }; // Center text
        cell.border = {
            top: { style: "thin", color: { argb: "000000" } },  // Black top border
            left: { style: "thin", color: { argb: "000000" } },  // Black left border
            bottom: { style: "thin", color: { argb: "000000" } },  // Black bottom border
            right: { style: "thin", color: { argb: "000000" } }   // Black right border
        };
    });

    // Extract table data and add rows
    let table = document.getElementById("data-table");
    for (let i = 2; i < table.rows.length; i++) {  // Skipping the first row since it's already added as header
        let row = [];
        for (let j = 0; j < table.rows[i].cells.length; j++) {
            row.push(table.rows[i].cells[j].innerText);
        }
        worksheet.addRow(row);
    }

    // Adjust column widths based on content
    worksheet.columns.forEach(col => {
        let maxLength = 0;
        col.eachCell({ includeEmpty: true }, (cell) => {
            let cellValue = cell.value ? cell.value.toString() : ''; // Convert value to string
            maxLength = Math.max(maxLength, cellValue.length);  // Get maximum length of the content
        });
        col.width = maxLength < 10 ? 10 : maxLength + 2; // Set minimum width to 10 and add extra padding
    });

    // Save the file
    workbook.xlsx.writeBuffer().then(buffer => {
        let blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
        saveAs(blob, "InspectionExcel.xlsx");
    });
}
    </script>

<script language='javascript'>
 
 function tableToExcelOLD(tabname,sheetname) {

            // Get table data
            var table = document.getElementById("data-table");
			
			var customHeaders = ["SR.No",
								"ZONE",
								"WARD", 
								"DEPARTMENT",
								"DESIGNATION",
								"VERIFICATION REASON",
								"ADDRESS",								
								"REMARS",
								];

            var data = [];
			
			data.push(customHeaders);

            // Loop through table rows and cells to build data array
            for (var i = 2, row;row = table.rows[i]; i++) {
                var rowData = [];
                for (var j = 0, col; col = row.cells[j]; j++) {
                    rowData.push(col.innerText);
                }
                data.push(rowData);
            }

            // Create a new workbook
            var wb = XLSX.utils.book_new();

            // Convert table data into a worksheet
            var ws = XLSX.utils.aoa_to_sheet(data);

            // Append worksheet to workbook
            XLSX.utils.book_append_sheet(wb, ws, sheetname);

            // Custom file name for the Excel file
            var customFileName = tabname+".xlsx";

            // Export workbook to Excel file
            XLSX.writeFile(wb, customFileName);
        }
		
		
		
  var mapTableToExcel = (function() {
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
      // if (!table.nodeType) table = document.getElementById(table)
      let theString = $("#" + table).html();
      let theResult = strRemove("input[type=checkbox]", theString);
      var ctx = {
        worksheet: name || 'Worksheet',
        table: theResult
      }
      window.location.href = uri + base64(format(template, ctx))
    }
  })()
</script>
<script>
  (function($) {
    strRemove = function(theTarget, theString) {
      return $("<div/>").append($(theTarget, theString).remove().end()).html();
    };
  })(jQuery);

  function print_div() {
    var selectorId = '';
    if ($("#area").is(':visible')) {
      selectorId = '#area';
    }

    if ($("#div_print").is(':visible')) {
      selectorId = '#div_print';
    }

    var theString = $(selectorId).html();
    var theResult = strRemove(".noExport", theString);
    var printWindow = window.open();
    printWindow.document.write(theResult);
    printWindow.document.close();
    printWindow.print();

  }
</script>


{/literal}



<div align='center'>
  <input type="button"  onclick="exportToExcel()" value="Export To Excel" class="btn btn-success">
  <button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('data-table', 'InspectionDetails')" value="Export To PDF"></i> Export To PDF</button> 
  <input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</div>
<br>
<br>
<br>
<br>
{literal}
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
  document.getElementById('tableSearch').addEventListener('keyup', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#data-table tbody tr');

    rows.forEach(row => {
      const rowText = row.textContent.toLowerCase();
      row.style.display = rowText.includes(searchValue) ? '' : 'none';
    });
  });
</script>
{/literal}

	{include file='footer.tpl'}