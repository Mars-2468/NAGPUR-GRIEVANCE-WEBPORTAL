{include file='header.tpl'}
{literal}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>


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
  top:10%;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
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

.modal-content2 {
  background-color: #fefefe;
  margin: auto;
  top:10%; 
  padding: 20px;
  border: 1px solid #888;
  width: 40%;
}

.close2 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close2:hover,
.close2:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
 } 
  
</style>
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

	function valLat(){	
		var lat = document.getElementById('lat');		
		const lat_lang_regex = /^[+-]?\d+(\.\d+)?$/;		
		if(!lat_lang_regex.test(lat.value))
		{
			alert("Please Enter only decimal or float values only! ");
			lat.value="";
			return false;
		}
	}
	
	function valLang(){
	
		var lang = document.getElementById('lang');
		const lat_lang_regex = /^[+-]?\d+(\.\d+)?$/;
		if(!lat_lang_regex.test(lang.value))
		{
			alert("Please Enter only decimal or float values only! ");
			lang.value="";
			return false;
		}
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
		const maxSize = 2 * 1024 * 1024; // 2MB size limit

		if (file) {
			if (!allowedTypes.includes(file.type)) {
				alert("Invalid file type. Only JPG, PNG, and PDF allowed.");
				input.value = ""; // Reset field
			} else if (file.size > maxSize) {
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

		if (confirm('Do Your Really Want To Delete This Record?')) {

			$.post('field_inspection_del.php', {
				id: id,				
			}, function(data) {

				if (data == 1) {

					alert('Record Deleted Successfully..!');
					window.location = 'register_comp_field_inspection.php';
				} else {
					alert('Error: Try Again..!');
				}
			});
		}
	}


	function delFun(docfileid) {	
	
		const docfileId=docfileid.title;		
	
		if (confirm('Do Your Really Want To Delete This File?')) {
			$.post('ajax_del_file.php', {
				docfile_id: docfileId,	
			}, function(data) {
				if (data == 1) {
					alert('Deleted Successfully..!');
					location.reload();
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
	.card-container {
		display: flex;
		gap: 20px; /* Space between cards */
		padding:20px;
		width:100%;
		overflow-x:scroll;
	}

	.card {
		width: 200px;
		padding: 15px;
		border: 1px solid #ccc;
		border-radius: 10px;
		text-align: center;
		box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
	}
</style>

{/literal}


	<div class="row">
		<div>
			<div class="boxed">
				<!-- Title Bart Start -->
				<div class="title-bar success">
					<h4>FIELD VISIT DETAILS</h4>
				</div>
				<!-- Title Bart End -->
				<div class="inner no-radius">
							
							Zone : {$ward_list[$data['ward_id']]}<br>
							Ward : {$street_list[$data['street_id']]}<br>
					  Department : {$dept_list[$data['dept_id']]}<br>
					 Designation : {$desg_list[$data['desg_id']]}<br>
					 Created By : {$data['created_by']}<br>
					<!-- Verification Reason : {$data['field_verification_reason']}<br>
					 Verification Address : {$data['field_verification_address']}<br> -->
					 Remarks : <em>{$data['remarks']}</em><br>
					
				</div>
			</div>
			
			<div class="boxed">
				<!-- Title Bart Start -->
				<div class="title-bar success">
					<h4>FIELD VISIT DOCCUMENTS</h4>
					<span class="btn btn-primary" style="margin-right:5px;cursor:pointer;float:right;color:#FFFFFF" title="{$data['id']}" id="delBtn{$data['id']}" onclick="myFun2(this)"><i class="fa fa-plus"></i></span>
				</div>
				<!-- Title Bart End -->
				<div class="inner no-radius cols-md-12">
					<div class="card-container">
						{foreach from=$data2 item=row key=id}					
						
							<div class="col">
								<div class="card">
								  <img src="{$row['doc_file']}" class="card-img-top" alt="..." style="height:150px;width:150px;">
								  <div class="card-body">
									<h5 class="card-title">{$row['doc_title']}</h5>
									<p class="card-text" style="text-wrap: balance;"></p>
								  </div>
								  <div class="card-footer">
									<div class="card-text" style="text-wrap: balance;display:flex;justify-content:end">
									<span style="margin-right:5px;cursor:pointer;" title="{$row['doc_title']}-{$id}" id="myBtn{$id}" onclick="myFun(this)"><i class="fa fa-edit"></i></span>
									<span style="margin-right:5px;cursor:pointer;" title="{$id}" id="delBtn{$id}" onclick="delFun(this)"><i class="fa fa-trash"></i></span>
									<a href="{$row['doc_file']}" download><i class="fa fa-download" ></i></a>
									</div>
								  </div>
								</div>
							</div>							
													
						{/foreach}					
					</div>	
					<div class="d-flex justify-content-end" style="margin:10px;">
						<div><a class="btn btn-primary float-right" href="inspection.php">Back</a></div>
					</div>
				</div>
				
			
				
				
				
			</div>
		</div>
	</div>
	
				<!-- Modal -->
			<div id="myModal" class="modal">

			  <div class="modal-content">
				<div class="justify-content-end">
					<span id="close" class="close">&times;</span>
				</div>
				<div class="">
				<form action="upload_file.php" method="POST" enctype="multipart/form-data">
				  <div class="row mb-3">
					<label for="uploadfiles" class="col-sm-12 h3 col-form-label text-center">Upload file</label>
					<div class="col-sm-10">
					  <input type="hidden" name="field_visit_form_docs_id" class="form-control" id="cntnt">
					</div>
				  </div>  <br>
				  <div class="row mb-3">
					<label for="doctitle1" class="col-sm-2 col-form-label">Doc Type</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" name="doctitle" id="doctitle">
					</div>
				  </div> <br> 				  
				  <div class="row mb-3">
					<label for="docfile1" class="col-sm-2 col-form-label">File</label>
					<div class="col-sm-10">
					  <input type="file" class="form-control" name="docfile" id="docfile">
					</div>
				  </div> <br>
				  <div class="row mb-3">
					<label for="updates" class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">
					 <button type="submit" class="btn btn-primary">Update</button>
					</div>
				  </div>
				  
				  
				</form>
				
			  </div>
			  </div>

			</div>
    
	<!-- Modal2 -->
			<div id="myModal2" class="modal">

			  <div class="modal-content2">
				<div class="justify-content-end">
					<span id="close2" class="close2">&times;</span>
				</div>
				<div class="">
				<form action="add_file.php" method="POST" enctype="multipart/form-data">
				  <div class="row mb-3">
					<label for="uploadfiles" class="col-sm-12 h3 col-form-label text-center">Upload file</label>
					<div class="col-sm-10">
					  <input type="hidden" name="field_visit_form_id" class="form-control" id="cntnt2">
					</div>
				  </div>  <br>
				  <div class="row mb-3">
					<label for="doctitle1" class="col-sm-2 col-form-label">Doc Type</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" name="doctitle" id="doctitle2">
					</div>
				  </div> <br> 				  
				  <div class="row mb-3">
					<label for="docfile1" class="col-sm-2 col-form-label">File</label>
					<div class="col-sm-10">
					  <input type="file" class="form-control" name="docfile" id="docfile2">
					</div>
				  </div> <br>
				  <div class="row mb-3">
					<label for="updates" class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">
					 <button type="submit" class="btn btn-primary">Add</button>
					</div>
				  </div>
				  
				  
				</form>
				
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
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css" type="text/css" media="all">
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
  })();

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


<br>
<br>
<br>
<br>
{literal}

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

	var modal = document.getElementById("myModal");
	var span = document.getElementsByClassName("close")[0];

	function myFun(elem) {
	//alert(elem.id);
		var mybtn = document.getElementById(elem.id);
		var cntnt = document.getElementById("cntnt");
		var cnttl = document.getElementById("doctitle");
		//var img1=mybtn.value;
		//alert(img1);
		
		var title=mybtn.title;
		var titleArray = title.split("-");
		//alert(titleArray[0]);
		modal.style.display = "block";
		if(titleArray[0]){
			cnttl.value=titleArray[0];
			cntnt.value=titleArray[1];
		}		
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

	var modal2 = document.getElementById("myModal2");
	var span = document.getElementsByClassName("close2")[0];

	function myFun2(elem) {
			
	//alert(elem.id);
	
		var mybtn2 = document.getElementById(elem.id);
		var cntnt2 = document.getElementById("cntnt2");
		var img2=mybtn2.value;
		var title2=mybtn2.title;
		//alert(title2);
		modal2.style.display = "block";
		
		if(title2){
			cntnt2.value=title2;
		}			
		
	}

	span.onclick = function() {
	  modal2.style.display = "none";
	}

	window.onclick = function(event) {
	  if (event.target == modal) {
		modal2.style.display = "none";
	  }
	}

</script>

{/literal}

	{include file='footer.tpl'}