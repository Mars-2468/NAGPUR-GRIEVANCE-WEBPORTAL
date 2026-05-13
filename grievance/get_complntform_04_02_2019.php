<?php
require "config.php";
ini_set('display_errors', 0);
 
require_once('Smarty.class.php');
$tpl = new Smarty();

if (isset($_REQUEST['id'])) {
	require_once('get_services.php');
	$obj = new get_services($_SESSION['uid']);
	require_once('connection.php');
	$conn = getconnection();
	function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d')
	{

		$dates = array();
		$current = strtotime($first);
		$last = strtotime($last);

		while ($current <= $last) {

			$dates[] = date($output_format, $current);
			$current = strtotime($step, $current);
		}

		return $dates;
	}

	$sql = $conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=?");
	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("s", $ulbid);
	$sql->execute();
	$rs = $sql->get_result();

	if ($rs) {
		while ($row = $rs->fetch_assoc())
			$ward_list[$row['ward_id']] = $row['ward_desc'];
	}
	$flag = 1;
	$sql = $conn->prepare("select cat.cat_id,description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag=? and cu.ulbid=?");
	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("is", $flag, $ulbid);
	$sql->execute();
	$rs = $sql->get_result();

	if ($rs) {
		while ($row = $rs->fetch_assoc())
			$cat_list[$row['cat_id']] = $row['description'];
	}

	$sql = $conn->prepare("select sc.cat_id,sc.description from subcategory_mst sc,cs_mst cm where  sc.sub_cat_id=cm.sub_cat_id and cu.flag=? and cu.ulbid=? ");
	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("is", $flag, $ulbid);
	$sql->execute();
	$rs = $sql->get_result();

	if ($rs) {
		while ($row = $rs->fetch_assoc())
			$sub_cat_list[$row['sub_cat_id']] = $row['description'];
	}


	$show_status = 1;
	$grievance_origin_id_2 = 2;
	$grievance_origin_id_3 = 3;
	$grievance_origin_id_7 = 7;

	$sql = $conn->prepare("select grievance_origin_id,grievance_origin_desc from grievance_origin_mst where show_status=? and (grievance_origin_id=? or grievance_origin_id=? or grievance_origin_id=?)");
	$sql->bind_param("iiii", $show_status, $grievance_origin_id_2, $grievance_origin_id_3, $grievance_origin_id_7);
	$sql->execute();
	$rs = $sql->get_result();

	if ($rs) {
		while ($row = $rs->fetch_assoc())
			$grievance_origin_list[$row['grievance_origin_id']] = $row['grievance_origin_desc'];
	}


	$sql = $conn->prepare("select * from emp_mst where ulbid=?");
	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("s", $ulbid);
	$sql->execute();
	$rs = $sql->get_result();

	while ($row = $rs->fetch_assoc()) {
		$emp_list[$row['emp_id']] = $row['emp_name'];
	}


	$sql = $conn->prepare("select dept_id,dept_desc from dept_mst where ulbid=?");
	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("s", $ulbid);
	$sql->execute();
	$rs = $sql->get_result();

	if ($rs) {
		while ($row = $rs->fetch_assoc())
			$dept_list[$row['dept_id']] = $row['dept_desc'];
	}


	/****************** getting holidays **********************/



	$sql = $conn->prepare("select date from public_holydays where ulbid=?");
	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("s", $ulbid);
	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$holiday_list[$row['date']] = $row['date'];
	}
	$hdays = 0;

	/********************************************************/


	$sql = $conn->prepare("select e.emp_id,e.emp_id2,c.cutt_of_time,c.app_fee,c.fine_per_day from emp_map e,category3_mst c where e.cs_id=c.cs_id and e.cs_id=?");
	$cs_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
	$sql->bind_param("i", $cs_id);
	$sql->execute();
	$rs = $sql->get_result();
	$emp_det = $rs->fetch_assoc();


	$date = date('Y-m-d');
	$date = strtotime("+" . $emp_det['cutt_of_time'] . " days", strtotime($date));
	$date = date("d-m-Y", $date);
	$dates_range = date_range(date('Y-m-d'), $date);
	foreach ($dates_range as $key => $date) {
		if (in_array($date, $holiday_list)) {
			$hdays++;
		}
	}


	$date = strtotime("+" . $hdays . " days", strtotime($date));
	$date = date("d-m-Y", $date);



	$sql = $conn->prepare("SELECT * FROM `water_tank_det_mst` where ulbid=?");
	$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("s", $ulbid);
	$sql->execute();
	$rs = $sql->get_result();
	while ($row = $rs->fetch_assoc()) {
		$tanker_list[$row['water_tank_id']] = $row['water_tank_desc'];
	}

	$conn->close();
}


?>
<div>
 
</div>

<div>
<!--
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
-->	
	<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
	<script>
		$('#datetimepicker1').datetimepicker({
			maxDate: new Date()
		});
	</script>

	<fieldset>


		<div class="row">

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<!-- <label>Person Name</label> -->
					<label>Person Name <span class="required" style="color:red"> * </span> </label>
					<input type="text" name="person_name" id="person_name" placeholder="Enter Person Name" class="form-control mytext" />
					<input type="hidden" name="app_type_id" value="<?php echo htmlspecialchars(strip_tags($_REQUEST['id'])); ?>">
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Mobile Number <span class="required" style="color:red"> * </span> </label>
					<input type="text" name="mobile" id="mobile" placeholder="Enter Mobile Number" class="form-control num mytext" maxlength="10" />
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Email ID</label>

					<input type="email" name="email" id="email" placeholder="Enter Email ID" class="form-control" />
				</div>
			</div>

		</div>


		<div class="row">

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>House Number <span class="required" style="color:red"> * </span> </label>
					<input type="text" name="hno" id="hno" placeholder="Enter House Number" class="form-control mytext" />
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Address <span class="required" style="color:red"> * </span> </label>
					<textarea name="address" id="address" placeholder="Enter Address" class="form-control mytext"></textarea>
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Select Zone <span class="required" style="color:red"> * </span> </label>
					<select name="ward_id" id="ward_id" class="form-control dropdown" onChange="get_streets(this.value)">
						<option value="0">--- Select Zone ---</option>
						<?php
						foreach ($ward_list as $ward_id => $ward_desc) {
						?>
							<option value="<?php echo $ward_id; ?>"><?php echo $ward_desc; ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>

		</div>


		<div class="row">

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Select Ward <span class="required" style="color:red"> * </span> </label>
					<select name="street_id" id="street_id" class="form-control dropdown">

						<option value="0">--- Select Ward ---</option>
					</select>
					<u><a target="_blank" href="https://egovmars.in/csms/zone-ward-and-area-details.pdf">Click here to know your Ward</a></u>
				</div>
			</div>

			<!--<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Department</label>
					<select name="department_id" id="department_id" class="form-control dropdown" onchange="getDepartmentCategories(this.value)">

						<option value="0">---Select---</option>
						<option value="1">CDMA</option>
						<option value="2">MEPMA</option>
					</select>
				</div>
			</div>-->

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Select Category <span class="required" style="color:red"> * </span> </label>
					<select name="dept_id" id="dept_id" class="form-control dropdown" onChange="get_sc_desc(this.value)">
						<!-- //get_csdesc -->

						<option value="0">--- Select Category ---</option>
						<?php
						foreach ($cat_list as $cat_id => $cat_desc) {
						?>
							<option value="<?php echo $cat_id; ?>"><?php echo $cat_desc . "hi"; ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Select Sub Category <span class="required" style="color:red"> * </span> </label>
					<select name="sub_id" id="sub_id" class="form-control dropdown" onChange="get_csdesc(this.value)">

						<option value="0">--- Select Sub Category ---</option>
						<?php
						foreach ($sub_cat_list as $sub_cat_list => $sub_cat_desc) {
						?>
							<option value="0">--- Select ---</option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Select Complaint / Service <span class="required" style="color:red"> * </span> </label>
					<select name="cs_id" id="cs_id" class="form-control dropdown" onChange="fun1(this.value)">

						<option value="0">--- Select Complaint / Service ---</option>
					</select>
				</div>
			</div>
		</div>

		<!-- <div class="col-md-3" style="margin-left:0; margin-right:15px;">
			<div class="form-group">
				<label>Received Through</label>
				<select name="grievance_origin_id" id="grievance_origin_id" class="form-control dropdown">
					<option value="0">---Select---</option>
					<?php
					foreach ($grievance_origin_list as $origin_id => $origin_desc) {
					?>
						<option value="<?php echo $origin_id; ?>"><?php echo $origin_desc; ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>

		<div class="col-md-3" style="margin-left:22px; margin-right:15px;">
			<div class="form-group">
				<label>Subject / Regarding </label>
				<input type="text" name="comp_subject" id="comp_subject" placeholder="Subject / Regarding" class="form-control mytext" />
			</div>
		</div>


		<div class="col-md-3" style="margin-left:23px; margin-right:15px;">
			<div class="form-group">
				<label>Photo</label>
				<input type="file" name="f1" id="f1" class="form-control" />
			</div>
		</div> -->

		<div class="row">
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Select Received Through <span class="required" style="color:red"> * </span> </label>
					<select name="grievance_origin_id" id="grievance_origin_id" class="form-control dropdown">
						<option value="0">--- Select Received Through ---</option>
						<?php
						foreach ($grievance_origin_list as $origin_id => $origin_desc) {
						?>
							<option value="<?php echo $origin_id; ?>"><?php echo $origin_desc; ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Subject / Regarding <span class="required" style="color:red"> * </span> </label>
					<input type="text" name="comp_subject" id="comp_subject" placeholder="Enter Subject / Regarding" class="form-control mytext" />
				</div>
			</div>
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Upload Photo</label>
					<input type="file" name="f1" id="f1" class="form-control" />
					<span id="errorMessage" class="error text-danger" style="font-size:11px;"></span>
				</div>
			</div>
		</div>

		<!-- </div> -->

		<div class="row">
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label> Select Department </label>
					<select name='emp_dept' onchange="get_det(this.value);" class="form-control" id="emp_dept">

						<option value="0">--- Select Department ---</option>
						<?php
						foreach ($dept_list as $dept_id => $dept_desc) {
						?>
							<option value="<?php echo $dept_id; ?>"><?php echo $dept_desc; ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label> Select Designation </label>
					<select name='emp_desg' id='emp_desg' onchange="get_det1(this.value);" class="form-control">
						<option value='0'>--- Select Designation ---</option>
					</select>
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label> Select Employee </label>
					<select name='emp_id' id='emp_id' class="form-control">
						<option value='0'>--- Select Employee ---</option>
					</select>
				</div>
			</div>
		</div>

		<div class="row" style="display:none;" id="tanker_dropdown">
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Select Tanker</label>
					<select name="tanker_id" id="tanker_id" class="form-control">

						<option value="0">--- Select Tanker ---</option>
						<?php
						foreach ($tanker_list as $tanker_id => $tanker_desc) {
						?>
							<option value="<?php echo $tanker_id; ?>"><?php echo $tanker_desc; ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>If old complaint</label>
					<input type="checkbox" id="old_comp_check_id" name="old_comp_check_id" value="1" onclick="oldCompCheckID()">
				</div>
			</div>
		</div>
		<div class="row" id="datetimepicker_div_id" style="margin:-42px 15px 10px 0;display:none;">
			<label style="margin-left:14px;">Select Date & Time</label>
			<div class='col-md-3 input-group date' id='datetimepicker1' style="padding-left: 14px;">
				<input type='text' class="form-control" id="datetimepicker" name="datetimepicker" />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Select Location</label>
					<input type="checkbox" id="lat_lng_check_id" name="lat_lng_check_id" value="1" onclick="latLngCheckID()">
				</div>
			</div>
		</div>
		<div class="row" id="lat_lng_value_div_id" style="margin-left:0; margin-right:15px;margin-top: -42px;display:none;">

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label for="exampleFormControlSelect2 ">Latitude <span class="valid_red">*</span></label>
					<input type="text" class="form-control form-control-sm" name="lat" id="lat" onkeyup="numericFilter(this);" pattern="^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$">
				</div>
			</div>

			<div class="col-md-3" style="margin-left:29px; margin-right:15px;">
				<div class="form-group">
					<label for="exampleFormControlSelect2">Longitude <span class="valid_red">*</span></label>
					<input type="text" class="form-control form-control-sm" name="lng" id="long" onkeyup="numericFilter(this);" pattern="^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$">
				</div>
			</div>
		</div>
		<div class="row" id="google_maps_div_id" style="margin-left:-18px; margin-right:15px;display:none;">

			<div class="col-md-12">
				<div id="map_canvas" style="height:300px;border:1px solid #ccc;"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-10" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Complaint Description <span class="required" style="color:red"> * </span> </label>
					<textarea name="comp_desc" id="comp_desc" rows="5" placeholder="Enter Description" class="form-control mytext"></textarea>
				</div>
			</div>

			<div class="col-md-10" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Endorsement</label>
					<textarea name="endorsement" id="endorsement" rows="5" placeholder="Enter Endorsement" class="form-control "></textarea>
				</div>
			</div>


			<div class="row">
				<span id="cut_det"></span>
			</div>

			<div class="col-md-12">
				<div class="form-actions fluid">
					<div class="col-md-offset-5 col-md-3">
						<button type="submit" class="btn btn-info" name="save">Submit</button>
						<button type="reset" class="btn btn-danger">Cancel</button>
					</div>
				</div>
			</div>

		</div>
	</fieldset>
</div>