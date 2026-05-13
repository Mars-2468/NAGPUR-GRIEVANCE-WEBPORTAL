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
	 body {
    
	  background-color:#E8E8E8 !important;
      /* Adjust margins as needed */
    }
</style>
<style>

.modal {
  display: none;
  position: fixed; 
  z-index: 1; 
  padding-top: 10px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%; 
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.4); 
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
<style>
.erating { 
width: 200px; 
margin-top: 10px;
padding: 4px 6px 0; 
height: 33px; 
overflow: hidden; 
display: inline-block 
}
.erating-input { 
position: absolute; 
left: 0; 
display: none 
}
.erating-star { 
display: block; 
float: right; 
width: 17px; 
height: 17px; 
margin-top: 1px; 
margin-left: 0; 
background: url(images/starimg1.png) 0 0px 
}
 .erating-input:checked~.erating-star { 
background-position: 0 15px 
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

<!--<div class="">
	<form method="POST" action="" class="form-horizontal">
		<div class="boxed">
		<input type="hidden" class="phone-group form-control datepicker" name="rating_no" value="{$rating_no}" placeholder="Select Date" autocomplete="off" >
			
			<div class="inner no-radius" style="border-bottom-left-radius: 0px !important;border-bottom-right-radius: 0px !important;">
				<div class="col-md-3" style="margin-right:15px;" >
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">Select department</label>
						<select class="select2 form-select" name="department_id">						
							{foreach from=$dept_list key=k item=v}
								{if $department_id == $k }
									<option value='{$k}' selected>{$v}</option>
								{else}  
									<option value='{$k}'>{$v}</option>
								{/if}
							{/foreach}							
						</select>
					</div>
				</div>
				<div class="col-md-2" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">
					</div>
				</div>
				<div class="col-md-2" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group" style="margin-top:31px;">
						<input name="search" type="submit" class="btn btn-success" value="Search">
						<a class="btn btn-dark text-white" type="button" href="">Reset</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>-->

<div class="boxed">
	<div style="padding:10px;background-color: #00AEEF;border-color: #00AEEF;display: flex;justify-content: space-between;align-items: center;text-color:#FFF;">
		<h5 style="color:#FFF;">Details of Employee Rating Report</h5>
		<!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
		<p class="m-0"><a href="employee_rating_report.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
	</div>



	<div class="inner no-radius">

		<div style="color:red;text-align:center";><h3>{if isset($msg)}{$msg}{/if}</h3></div>		
		
				<div id="demo">
					
					
				<div  id="area" class="table-responsive">
					<table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
							<caption style="caption-side:top; text-align:center;font-size:16px;">
								<div class="d-flex justify-content-between">
									<b>
										<CENTER><strong>VIEW OF EMPLOYEE RATING REPORT DETAILS</strong></CENTER>
									</b>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="myInput">
									</div>							
								</div>
							</caption>
						
						
						<thead>
							<tr style="background-color:#2c3e50;">
								<th  class="text-center" align='left'  style='vertical-align:middle' ><font color='white'>S.No</font></th>
								<th  class="text-center" align='left'  style='vertical-align:middle' ><font color='white'>Grievance</font></th>
								<th  class="text-center" align='left'  style='vertical-align:middle' ><font color='white'>Employee Name</font></th>
								<th  class="text-center" align='left'  style='vertical-align:middle' ><font color='white'>Department</font></th>
								<th  class="text-center" align='left'  style='vertical-align:middle' ><font color='white'>Rating</font></th>
							</tr>							
						</thead>
						<tbody id="myTable">
							{foreach from=$data key=emp_id item=row}
							<tr>
								<td class="text-center" >{counter}</td>
								<td><a href="comp_rating_det_admin.php?grievance_id={$emp_list[$row.emp_id]['grievance_id']}">{$emp_list[$row.emp_id]['grievance_id']}</a></td>
								<td>{$emp_list[$row.emp_id]['emp_name']}</td>
								<td>{$dept_list[$row.dept_id]}</td>
								<td class="text-center" >
								<div id="eform-id-{$emp_id}" class="d-flex justify-content-start align-items-center" name="eform_name{$emp_id}">
											
											<div class="erating">({$data[$emp_id]['rating_no']})
												<span>	
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-10" value="10"  {if $data[$emp_id]['rating_no']==10} checked {/if} onclick="return false;">
													<label for="erating-input-{$emp_id}-10" class="erating-star" title="10"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-9" value="9"  {if $data[$emp_id]['rating_no']==9} checked {/if} onclick="return false;">
													<label for="erating-input-{$emp_id}-9" class="erating-star" title="9"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-8" value="8"  {if $data[$emp_id]['rating_no']==8} checked {/if} onclick="return false;">
													<label for="erating-input-{$emp_id}-8" class="erating-star" title="8"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-7" value="7"  {if $data[$emp_id]['rating_no']==7} checked {/if} onclick="return false;">
													<label for="erating-input-{$emp_id}-7" class="erating-star" title="7"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-6" value="6"  {if $data[$emp_id]['rating_no']==6} checked {/if} onclick="return false;">
													<label for="erating-input-{$emp_id}-6" class="erating-star" title="6"></label>			
													
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-5" value="5"  {if $data[$emp_id]['rating_no']==5} checked {/if} onclick="return false;">
													<label for="erating-input-{$emp_id}-5" class="erating-star" title="5"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-4" value="4"  {if $data[$emp_id]['rating_no']==4} checked {/if} onclick="return false;">
													<label for="erating-input-{$emp_id}-4" class="erating-star" title="4"></label>
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-3" value="3"  {if $data[$emp_id]['rating_no']==3} checked {/if} onclick="return false;">
													<label for="erating-input-{$emp_id}-3" class="erating-star" title="3"></label>
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-2" value="2"  {if $data[$emp_id]['rating_no']==2} checked {/if} onclick="return false;" >
													<label for="erating-input-{$emp_id}-2" class="erating-star" title="2" readonly></label>
													<input type="radio" class="erating-input" id="erating-input-{$emp_id}-1" value="1"  {if $data[$emp_id]['rating_no']==1} checked {/if} onclick="return false;" >
													<label for="erating-input-{$emp_id}-1" class="erating-star" title="1" readonly></label>
												</span>	
											</div>
										</div>
								
								</td>	
							</tr>
						
							{/foreach}
						</tbody>
						
					</table>
					</div></div>
				</div>
			
								
				<!-- Modal -->
				<div id="myModal" class="modal">

				  <div class="modal-content">
					<div class="justify-content-end">
						<span class="close">&times;</span>
					</div>
					<p id="cnt">image displaying</p>
				  </div>

				</div>
		
			
		</div>
		
	</div>

	<br>
	<div>
		<center>
			<form action="exporttoexcel.php" method="post">
				<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export To Excel" class="btn btn-success" />
				<button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
				<input type='button' value='Print' onclick="print_div()" class="btn btn-danger" />
			</form><br>
		</center>
	</div>

</div>

<br>

{include file='footer.tpl'}


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>

<script>
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

function myFun(elem) {


var mybtn = document.getElementById(elem.id);
var cnt = document.getElementById("cnt");
var img1=mybtn.value;

 modal.style.display = "block";
  cnt.innerHTML="<img src="+img1+" alt='Image' style='width:100%;height:100%;'>";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>


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
	$(".num").keydown(function(event) {
		// Allow only backspace and delete
		if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9) {
			// let it happen, don't do anything
		} else {
			// Ensure that it is a number and stop the keypress
			if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
				event.preventDefault();
			}
		}
	});
</script>

<script>
    $(function() {
        $(".datepicker").datepicker({
			dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
