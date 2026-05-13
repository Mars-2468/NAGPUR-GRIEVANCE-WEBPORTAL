{include file='corp_header.tpl'}
{literal}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->

<script>
	function get_det(dept_id) {
		var select = document.getElementById("emp_desg");
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

	function fill(emp_id, emp_name, emp_mobile, emp_dept, emp_desg) {
		document.manage_emp.emp_id.value = emp_id;
		document.manage_emp.emp_name.value = emp_name;
		document.manage_emp.emp_mobile.value = emp_mobile;
		$('#emp_dept').val(emp_dept);
		get_det(emp_dept);

		$('#emp_desg').val(emp_desg);
	}

	function validateForm() {
		var emp_name = document.manage_emp.emp_name.value;
		var emp_name_marathi = document.manage_emp.emp_name_marathi.value;
		var emp_dept = document.manage_emp.emp_dept.selectedIndex;
		var emp_desg = document.manage_emp.emp_desg.selectedIndex;
		var emp_mobile = document.manage_emp.emp_mobile.value;
		var filter = /^[6-9]{1}[0-9]{9}$/;
		var patt1 = /^[\w]+[\w\s-./]+$/;


		/*if(!patt1.test(emp_name))
		{
			alert("Please Enter  Correct value in Employee Name ");
			return false;
		}*/

		if (emp_dept == '0') {
			alert("Please Select Department..!");
			return false;
		}

		if (emp_desg == '0') {
			alert("Please Select Designation..!");
			return false;
		}

		if (!filter.test(emp_mobile)) {
			alert("Please Enter Valid Mobile No..!");
			return false;
		}


		var emp_status = $("#emp_status").val();
		var od_status = $("#od").val();
		if (emp_status == '1' && od_status == '0') {
			alert('This Mobile Number Is Already In Use, If Employee Is On Deputation, Check Below Checkbox..!');
			return false;
		}

		return true;
	}

	function delete_rec(emp_id, od_status) {

		if (confirm('Do Your Really Want To Delete This Record?')) {

			$.post('ajax_del_emp.php', {
				emp_id: emp_id,
				od_status: od_status
			}, function(data) {

				if (data == 1) {

					alert('Employee Deleted Successfully..!');
					window.location = 'manage_emp.php';
				} else {
					alert('Error: Try Again..!');
				}
			});
		}
	}

	function delete_desg(i, desg_id, emp_id) {
		if (confirm('Do Your Really Want To Delete This Record?')) {

			$.post('ajax_del_emp_desg.php', {
				emp_id: emp_id,
				desg_id: desg_id
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


	function addAdvance() {

		var divcontent;
		var i = document.getElementById('cnt').value;


		var j = i - 1;

		var newdiv = document.createElement('tr');
		newdiv.setAttribute('id', i);
		newdiv.setAttribute('class', 'addrow');
		divcontent = "";

		divcontent = divcontent + "<tr><td align='left' style='padding:5px;width:10%'>";
		divcontent = divcontent + "Department:<select name='dept_id" + i + "' id='dept_id" + i + "' class='validate[required] form-control mytext' style='width:200px;' onchange='get_designations(this.value," + i + ")'>";


		$.post("ajax_departments.php", function(data) {

			$("#dept_id" + i).html(data);
		});


		divcontent = divcontent + "<option value='0'>--- Select Department ---</option>";

		divcontent = divcontent + "</select>";
		divcontent = divcontent + "</td>";

		divcontent = divcontent + "<td align='left' style='padding:5px;width:10%'>";
		divcontent = divcontent + "Designation:<select name='desg_id" + i + "' id='desg_id" + i + "' class='validate[required] form-control mytext' style='width:200px;'>";
		divcontent = divcontent + "<option value='0'>--- Select Designation ---</option>";

		divcontent = divcontent + "</select>";
		divcontent = divcontent + "</td>";
		divcontent = divcontent + "<td align='left' style='padding:5px;'><br><input type='button' value='Remove' class='btn btn-default bg-danger' onclick='fnRemove(" + i + ");' /></td>";

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
	table,
	th,
	td {

		border-collapse: collapse;
	}

	table.center {
		margin-left: 20%;
	}
</style>

{/literal}

<div class="row">
	<div>
		<div class="boxed">

			<div class="title-bar blue" style="display: flex; justify-content: space-between; align-items: center;">
				<h4 style="margin: 0;">SHOW CAUSE NOTICE</h4>
				<!--
				<a href="corp_show_cause_notice.php?active=tr-clmn" class="btn btn-warning" style="margin-left: auto;"><i class="fa fa-backward"></i> Back</a>
				-->
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">
				<div style="padding:20px">
					<div>
						<img src="https://mh.nagpurnmc.in/grievance/images/nagpurlg.png" style="height:50%;width:15%">
					</div><br>
					<h4 class="text-center" style="font-weight:bold"> नागपूर महानगरपालिका </h4>
					<h5 class="text-center" style="font-weight:normal"> महानगरपालिका मार्ग , सिविल लाईन्स नागपूर </h5>
					<br>
					<br>
					<br>

					<p>महानगरपालिका मार्ग , सिविल लाईन्स नागपूर</p>

					<p>जा.क्र.ना.म.पा/अति.आ./ {$showcause_id} / {$current_year} </p>
					<p>दिनांक - {$sms_notice_date}</p>
					<p>
					<h4 class="text-center" style="font-weight:bold"> कारणे दाखवा नोटीस </h4>
					</p>
					<p>प्रति,</p>
					<p>{$emp_name}</p>
					<br>
					<br>
					<p style="text-align:justify;line-height:2">
						ज्याअर्थी, नागरीकांकडून ई ग्रीव्हिअन्स द्वारे वि‍वि‍ध विभागाशी संबंधीत तक्रारी प्राप्त होत असतात. त्याअर्थी प्राप्त तक्रारी विहित ठरवून दिलेल्या कालावधीत निकाली काढणे आवश्यक असून देखील या बाबीची आपल्या स्तरावरून गांभीर्याने दखल घेतली जात नाही.
					</p>
					<p style="text-align:justify;line-height:2">
						ज्याअर्थी आपल्या विभागाकडे ई ग्रीव्हिअन्स द्वारे प्राप्त झालेली तक्रारी प्रलंबीत असल्याचे दिसून येते. या तक्रारी ची वेळेत दखल न घेतल्याने संगणकाद्वारे सदर तक्रार स्कॅल अप झालेल्या आहेत. त्याअर्थी आपण सदर प्रकरणी कार्यवाही करण्यास विलंब करून कर्तव्यात कसूर केल्याने “ महाराष्ट्र नागरी सेवा (वर्तणूक) नियम,1979” मधील नियम 3 चा आणि‍ महाराष्ट्र शासकिय कर्मचा-यांच्या बदल्याचे विनियमन आणि शासकिय कर्तव्ये पार पाडताना होणा-या विलंबास प्रतिबंध अधिनियम 2005 चा नियम 10(1) चा भंग केल्याचे स्पष्ट होत आहे.
					</p>
					<p style="text-align:justify;line-height:2">
						तरी सदरील प्रकरणाबाबतचा खुलासा ७ दिवसांत सादर करण्यात यावा. लेखी खुलासा प्राप्त न झाल्यास आपले काहीही म्हणणे नाही असे गृहीत धरून “महाराष्ट्र नागरी सेवा (शिस्त व अपिल) नियम,१९७९” नुसार शिस्तभंगाची कार्यवाही करण्यात येईल याची नोंद घ्यावी.
					</p>
					<table align="right">
						<tr>
							<td class="col-sm-4"></td>
							<td class="col-sm-4"></td>
							<td class="col-sm-1"></td>
							<td class="col-sm-4">
								<div class="text-center">
									<p><br><br><br><br><br><br>
									<div>
										<strong>
											डॉ अभिजीत चौधरी    
										</strong>
									</div>
									<div>
										<strong>
											आयुक्त तथा प्रशासक       
										</strong>
									</div>
									<div>
										<strong>
											नागपूर महानगरपालिका, नागपूर.
										</strong>
									</div>
									</p>
								</div>
							</td>
						</tr>
					</table>
				</div>
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

<br>

{include file='corp_footer.tpl'}