{include file='header.tpl'}

{literal}

<script>
	function getCompform(cs_id, ulbid) {

		if (cs_id == 1 && ulbid == 208) {
			//alert(ulbid);
			$.post('get_serviceform2.php', {
				id: 2
			}, function(data) {

				$('#form2').html(data);
				get_req_docs(cs_id);
			});

		} else if (cs_id == 1 && ulbid == 209) {

			$.post('get_serviceform2.php', {
				id: 2
			}, function(data) {

				$('#form2').html(data);
				get_req_docs(cs_id);
			});

		} else if (cs_id == 1 && ulbid == 210) {

			$.post('get_serviceform2.php', {
				id: 2
			}, function(data) {

				$('#form2').html(data);
				get_req_docs(cs_id);
			});

		} else if (cs_id == 7 && ulbid == 208) {

			$.post('get_serviceform2.php', {
				id: 2
			}, function(data) {

				$('#form2').html(data);
				get_req_docs(cs_id);
			});

		} else if (cs_id == 7 && ulbid == 209) {

			$.post('get_serviceform2.php', {
				id: 2
			}, function(data) {

				$('#form2').html(data);
				get_req_docs(cs_id);
			});

		} else if (cs_id == 7 && ulbid == 210) {

			$.post('get_serviceform2.php', {
				id: 2
			}, function(data) {

				$('#form2').html(data);
				get_req_docs(cs_id);
			});

		} else {

			if (cs_id == 1 || cs_id == 6 || cs_id == 14 || cs_id == 18 || cs_id == 7) {
				$.post('get_iframe.php', {
					cs_id: cs_id
				}, function(data) {

					$('#form2').html(data);
				});
			} else {

				$.post('get_serviceform2.php', {
					id: 2
				}, function(data) {

					$('#form2').html(data);
					get_req_docs(cs_id);
				});
			}

		}


	}

	function getform(id) {
		if (id == 1) {
			var ulbid = $("#ulbid").val();

			if (ulbid == 500 || ulbid == 001) {
				$('#form2').html('');
				$.post('get_complntform_04_02_2019.php', {
					id: id
				}, function(data) {

					$('#form').html(data);
					$('#datetimepicker1').datetimepicker();
					initialize();
				});

			} else {

				$('#form2').html('');
				$.post('get_complntform.php', {
					id: id
				}, function(data) {
					$('#form').html(data);
				});
			}
		} else {
			$('#form2').html('');
			$.post('get_firstservices.php', {
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
			if (app_type_id == 1) {

				$('#cs_id').html(data);
			} else {

			}


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

		$.post('getdoc2.php', {
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


		if (errors == 0) {
			return true;
		} else {
			alert("Please Enter Correct Value in High-lighted Fields - " + errors);
			return false;
		}
	}

	function fun1(cs_id) {
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

				{if $ulbid == '500'}

				{/if}

			</div>

		</div>
	</div>

</div>
{if isset($filepath)}
<!--<a href="{$filepath}" target="_blank">Download Receipt </a>-->
{/if}
<div class="row">
	<div>
		<div class="boxed">

		</div>


		<div class="inner no-radius" style="background-color: #FFF; padding: 15px;">
			<form action="register_comp_helpline.php" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
				<span id="form"></span>
				<span id="form2"></span>

			</form>
		</div>
	</div>
</div>


{literal}
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&key=AIzaSyAa5wPAKKYaDy2XYG9BhvMha3ltAegrJSc"></script>
<script>
	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(browserHasGeolocation ?
			'Error: The Geolocation service failed.' :
			'Error: Your browser doesn\'t support geolocation.');
		infoWindow.open(map);
	}
</script>






<script type='text/javascript'>
	//<![CDATA[

	function initialize() {
		//alert('okk');
		navigator.geolocation.getCurrentPosition(function(position) {
			var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

			document.getElementById("lat").value = position.coords.latitude;
			document.getElementById("long").value = position.coords.longitude;
			var latitude = position.coords.latitude;
			var longitude = position.coords.longitude;

		});

		var myLatlng = new google.maps.LatLng(17.448690, 78.449997);

		var myOptions = {
			zoom: 16,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		var marker = new google.maps.Marker({
			draggable: true,
			position: myLatlng,
			map: map,
			title: "Your location"
		});

		google.maps.event.addListener(marker, 'dragend', function(event) {

			document.getElementById("lat").value = event.latLng.lat();
			document.getElementById("long").value = event.latLng.lng();

			infoWindow.open(map, marker);
		});
	}
</script>
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

	function oldCompCheckID() {
		if ($("#old_comp_check_id").is(":checked")) {
			//alert('checked');
			$('#datetimepicker_div_id').css('display', 'block');
			$('#datetimepicker').prop('required', true);
		} else {
			//alert('Not checked');
			$('#datetimepicker').val('');
			$('#datetimepicker_div_id').css('display', 'none');
			$('#datetimepicker').prop('required', false);

		}
	}

	function latLngCheckID() {
		if ($("#lat_lng_check_id").is(":checked")) {
			//alert('checked');
			initialize();
			$('#lat_lng_value_div_id').css('display', 'block');
			$('#google_maps_div_id').css('display', 'block');
			$('#lat').prop('required', true);
			$('#long').prop('required', true);
		} else {
			$('#lat_lng_value_div_id').css('display', 'none');
			$('#google_maps_div_id').css('display', 'none');
			$('#lat').prop('required', false);
			$('#long').prop('required', false);
		}
	}
</script>

{/literal}

{include file='footer.tpl'}
{literal}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script>
	$(function() {
		$('#datetimepicker1').datetimepicker();
	});
</script>
<style>
	.btn-primary {
		width: 100%;
	}
</style>
{/literal}