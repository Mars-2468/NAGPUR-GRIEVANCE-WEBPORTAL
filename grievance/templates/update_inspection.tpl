{include file='header.tpl'}
{literal}
 
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
		divcontent = divcontent + "File Title:<input name='doctitle[]' type='text' class='form-control mytext' style='width:200px;' onchange='checkTitle(this)'>";
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

{/literal}


<div class="row">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>FIELD VISIT FORM</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<form method="post" action="" class="form-horizontal" name="field_visitor_form_update" onSubmit="return validateForm222()" enctype="multipart/form-data">
					<input type="hidden" name="token" value="{$token}" />
					<input type="hidden" name="id" value="{$data['id']}" />
					
						<input type="hidden" name="cnt" id="cnt" value="0" />
						<div class="form-body">

						{if isset($msg)}
						<div class="{$class}">
							<button class="close" data-close="alert"></button>
							{$msg}
						</div>
						{/if}
						
						<div class="form-group">							
							<label class="control-label col-md-4">Department <span class="required" style="color:red">  </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='dept_id' id='dept_id' onchange="get_det(this.value);" class="form-control" autocomplete="off">
									<option value='0'>--- Select Department ---</option>
									{html_options options=$dept_list selected=$data['dept_id']}
								</select>
							</div>
						</div>

						<div class="form-group">							
							<label class="control-label col-md-4">Designation <span class="required" style="color:red">  </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='desg_id' id='desg_id' class="form-control" autocomplete="off">
									<option value='0'>--- Select Designation ---</option>
									{html_options options=$desg_list selected=$data['desg_id']}	
								</select>
							</div>
						</div>
						<div class="form-group">							
							<label class="control-label col-md-4">Zone <span class="required" style="color:red">  </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='ward_id' id='ward_id' onchange="get_street(this.value);" class="form-control" autocomplete="off">
									<option value='0'>--- Select Zone ---</option>
									{html_options options=$ward_list selected=$data['ward_id']}
								</select>
							</div>
						</div>		
						<div class="form-group">
							
							<label class="control-label col-md-4">Ward <span class="required" style="color:red"> </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<select name='street_id' id='street_id' class="form-control" autocomplete="off" >
									<option value='0'>--- Select Ward ---</option>	
									{html_options options=$street_list selected=$data['street_id']}	
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-4">Latitude <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='lat' type="text" id="lat"  class="form-control " placeholder="Enter Latitude" autocomplete="off" value="{$data['lat']}" required="required" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Langitude <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='lang' type="text" id="lang"  class="form-control " placeholder="Enter Langitude" autocomplete="off" value="{$data['lang']}" required="required" readonly />
							</div>
						</div>

						<!-- <div class="form-group">
							<label class="control-label col-md-4">Field Verification Reason <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='field_verification_reason' type="text" id="field_verification_reason"  class="form-control" placeholder="Enter field verification reason" autocomplete="off" value="{$data['field_verification_reason']}" required="required" onchange="return valReason()" />
							</div>
						</div>

						<div class="form-group">						
							<label class="control-label col-md-4">Field Verification Address <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='field_verification_address' type="text" id="field_verification_address"  class="form-control"  placeholder="Enter field verification address" value="{$data['field_verification_address']}" autocomplete="off" required="required" onchange="return valAddress()" />
							</div>
						</div> -->
						<div class="form-group">						
							<label class="control-label col-md-4">Remarks <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='remarks' type="text" id="remarks"  class="form-control " placeholder="Enter field verification address" autocomplete="off" required="required" value="{$data['remarks']}"  onchange="return valRemarks()"/>
							</div>
						</div>
						<!--
						<div class="form-group">						
							<label class="control-label col-md-4">File Title <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='doctitle[]' type="text" class="form-control "  placeholder="Enter file" autocomplete="off" onchange="checkTitle(this)" />
							</div>
						</div>
						
						<div class="form-group">						
							<label class="control-label col-md-4">File <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='docfiles[]' type="file" class="form-control "  placeholder="Enter file" autocomplete="off" onchange="checkFile(this)" />
							</div>
						</div>
						
						
						<div class="form-group table-responsive">
							<table class="table" id="advance_div" style="width:100%">
							
							</table>
						</div>

						<div class="form-group">
							<div class="control-label col-md-4">
								<input type="button" id="add" class="btn btn-success" name="add" onclick="addAdvance()" value="ADD ANOTHER FILE" style="font-size:12px;">
							</div>
						</div>
						-->
						
						<div class="form-actions fluid" style="padding:10px;">
							<div align="center">
								<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
								<button type="button" class="btn btn-danger" onclick="this.form.reset();">Cancel</button>
							</div>
						</div>
					</div>
				</form>
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
        // Function to get location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Display position
        function showPosition(position) {
            document.getElementById("lat").value = position.coords.latitude;
            document.getElementById("lang").value = position.coords.longitude;
        }

        // Handle errors
        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }

        // Call function when page loads
        window.onload = getLocation;
    </script>
	
{/literal}

	{include file='footer.tpl'}