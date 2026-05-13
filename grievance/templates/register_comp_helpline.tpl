{literal}
  
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
<script>
	function getform(id) {
    

		if (id == 1) {
			$.post('get_complntform.php', {
				id: id
			}, function(data) {
				$('#form').html(data);
			});
		} else {
  

			$.post('get_serviceform.php', {
				id: id
			}, function(data) {

				$('#form').html(data);
			});  

			//$('#form').html('Under construction');
		}
	}

	function get_streets(ward_id) {
		$.post('ajax_getstreets.php', {
			ward_id: ward_id
		}, function(data) {
			$('#street_id').html(data);
		});
	}

	function get_cats(dept_id) {
		$.post('ajax_getcats.php', {
			dept_id: dept_id
		}, function(data) {
			$('#cat_id').html(data);
		});
	}

	function get_csdesc(dept_id) {

		var app_type_id = $("#app_type_id").val();
		var ulbid = $("#ulbid").val();



		$.post('getcate3.php', {
			dept_id: dept_id,
			app_type_id: app_type_id
		}, function(data) {

			$('#cs_id').html(data);


			if (app_type_id == '1' && ulbid == '052' && dept_id == '3') {
				$("#tanker_dropdown").css('display', 'block');
				$("#tanker_id").addClass('dropdown');
			} else {
				$("#tanker_dropdown").css('display', 'none');
				$("#tanker_id").removeClass('dropdown');
			}
			get_det(dept_id);
		});

	}

	function get_req_docs(cs_id) {

		var app_type_id = $("#app_type_id").val();
		var ward_id = $("#ward_id").val();
		var dept_id = $("#dept_id").val();

		$.post('getdocs.php', {
			cs_id: cs_id,
			app_type_id: app_type_id,
			ward_id: ward_id,
			dept_id: dept_id
		}, function(data) {
			$('#docs').html(data);
		});
	}

	function validateForm() {
		errors = 0;
		var mobile = $("#mobile").val();
		var patt1 = /^\d{10}$/;
		if (!patt1.test(mobile)) {
			($('#mobile')).css({
				"background-color": "pink"
			});
			errors++;
		}
		$(".mytext").each(function() {

			var val_field = $(this).val();
			if (val_field == '') {
				($(this)).css({
					"background-color": "pink"
				});
				errors++;
			} else {
				($(this)).css({
					"background-color": "white"
				});
			}
		});

		$(".dropdown").each(function() {

			var val_field = $(this).val();
			if (val_field == '0') {
				($(this)).css({
					"background-color": "pink"
				});
				errors++;
			} else {
				($(this)).css({
					"background-color": "white"
				});
			}
		});


		$(document).on("change", "#f1", function() {
			if (this.files[0].size > 5000000) {
				toastr.error("Please upload file less than 5MB. Thanks!!");
				$(this).val('');
				errors++;
			}

		});
		if ($("#f1").val() == '') {
			toastr.error('Please Upload File..!');
			errors++;
		}

		if (errors == 0) {
			return true;
		} else {
			alert("Please Enter Correct Value In High-lighted Fields - " + errors);
			return false;
		}
	}

	function fun1(cs_id) {
		alert(qq);
		var app_type_id = $("#app_type_id").val();
		var ward_id = $("#ward_id").val();

		$.post('getempcutdet.php', {
			cs_id: cs_id,
			app_type_id: app_type_id,
			ward_id: ward_id
		}, function(data) {

			$("#cut_det").html(data);
		});
	}
</script>
{/literal}
<div class="row">
	<div>
		<div class="boxed">
			<div class="title-bar blue">
				<h4> Register Complaint / Service </h4>
			</div>
			<div class="inner no-radius">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}

				{if $ulbid eq '208' || $ulbid eq '210' || $ulbid eq '3'}

				<div class="form-group">
					<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">Village:</label>

					<select name="ulbid" class="form-control">
						<option value="">-- Select --</option>
						{html_options options=$villages selected=$ulb}
					</select>

				</div>

				{/if}




				<form action="#" class="form-horizontal">
					<input type="hidden" name="ulbid" id="ulbid" value="{$ulbid}">
					<input type="hidden" name="appid" id="appid" value="{$app_type_id}">
					<div class="form-group">
						<label class="control-label col-md-3">Type of Application <span class="required">
								* </span>
						</label>
						<div class="col-md-8">
							<select class="form-control" name="app_type_id" id="app_type_id" onchange="getform(this.value)">
								<option value="">---select---</option>
								{html_options options=$app_type_list}

							</select>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>

</div>
{if isset($filepath)}
<!--<a href="{$filepath}" target="_blank">Download Receipt ***</a>-->
{/if}
<div class="row">
	<div>
		<div class="boxed">

		</div>


		<div class="inner no-radius" style="background-color: #FFF; padding: 15px;">
			<form action="register_comp_helpline.php" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
				<span id="form"></span>

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

	function get_det1(desg_id) {

		var select1 = document.getElementById("emp_id");
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
		xmlhttp.open("GET", "get_emps.php?desg_id=" + desg_id, true);
		xmlhttp.send();

	}

	function get_det(dept_id) {

		var select = document.getElementById("emp_desg");
		var select1 = document.getElementById("emp_id");
		select.options.length = 0;
		select1.options.length = 0;

		if (window.XMLHttpRequest)
			xmlhttp = new XMLHttpRequest();
		else
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var strArray = xmlhttp.responseText.split("___");
				//alert(strArray);
				//console.log(xmlhttp.responseText);
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
</script>
{/literal}

{include file='footer.tpl'}