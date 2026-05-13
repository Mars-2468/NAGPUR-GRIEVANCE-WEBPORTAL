<?php	
	require "config.php";
	ini_set('display_errors',0);

	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_REQUEST['id']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		//include('prepare_connection.php');
		$conn=getconnection();
		function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

			    $dates = array();
			    $current = strtotime($first);
			    $last = strtotime($last);
			
			    while( $current <= $last ) {
			
			        $dates[] = date($output_format, $current);
			        $current = strtotime($step, $current);
			    }
			
			    return $dates;
			}

	
		
	    $sql ="select ward_id,ward_desc from ward_mst where ulbid=?";
	    $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		 	$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
	
		$sql ="select cat.cat_id,description from category_mst cat,complaint_ulbmap cu,cs_mst cm where 
		 cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag=? and cu.ulbid=?";
		
		$flag=1;
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("is",$flag,$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		 	$cat_list[$row['cat_id']]=$row['description'];
		}
				
		$sql="select grievance_origin_id,grievance_origin_desc from grievance_origin_mst where show_status=? and 
		(grievance_origin_id=? or grievance_origin_id=? or grievance_origin_id=? or grievance_origin_id=? )";
		
		if(in_array($_SESSION['uid'],$mayor_users)){		
			$sql .=" or grievance_origin_id=? ";		
		}		
		if(in_array($_SESSION['uid'],$deputy_mayor_users)){		
			$sql .=" or grievance_origin_id=? ";		
		}
		
		if(in_array($_SESSION['uid'],'nagpur')){		
			$sql .=" or grievance_origin_id=? or grievance_origin_id=? ";		
		}
		
		$query=$conn->prepare($sql);
		$show_status=1;
		$grievance_origin_id1=2;
	    $grievance_origin_id2=3;
		$grievance_origin_id3=7;
		$grievance_origin_id4=9;	
		
		//echo "<pre>";print_r($_SESSION['uid']);echo "</pre>";die();
		
		if(in_array($_SESSION['uid'],$mayor_users_dropdown)){
			$grievance_origin_id5=10;			
			$query->bind_param("iiiiii",$show_status,$grievance_origin_id1,$grievance_origin_id2,$grievance_origin_id3,$grievance_origin_id4,$grievance_origin_id5);
		}else if(in_array($_SESSION['uid'],$deputy_mayor_users_dropdown)){
			$grievance_origin_id6=11;			
			$query->bind_param("iiiiii",$show_status,$grievance_origin_id1,$grievance_origin_id2,$grievance_origin_id3,$grievance_origin_id4,$grievance_origin_id6);
		}else if(in_array($_SESSION['uid'],['nagpur'])){ 
			$grievance_origin_id5=10;
			$grievance_origin_id6=11;			
			$query->bind_param("iiiiiii",$show_status,$grievance_origin_id1,$grievance_origin_id2,$grievance_origin_id3,$grievance_origin_id4,$grievance_origin_id5,$grievance_origin_id6);
		}else{			
			$query->bind_param("iiiii",$show_status,$grievance_origin_id1,$grievance_origin_id2,$grievance_origin_id3,$grievance_origin_id4);
		}
					
		$query->execute();
		$rs=$query->get_result();
		
		//echo "<pre>";print_r($rs);echo "</pre>";die();
		
		if($rs)
		{
			while($row = $rs->fetch_assoc())
			$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		

		
		$sql ="select * from emp_mst where ulbid=?";
	    $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		 $emp_list[$row['emp_id']]=$row['emp_name'];
		}
				
		$sql ="select dept_id,dept_desc from dept_mst where ulbid=?";
	    $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		 	$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		/****************** getting holidays **********************/
				
		$sql ="select date from public_holydays where ulbid=?";
	    $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		 $holiday_list[$row['date']]=$row['date'];
		}
		$hdays=0;
				
		/********************************************************/
				
		$sql=$conn->prepare("select e.emp_id,e.emp_id2,c.cutt_of_time,c.app_fee,c.fine_per_day from emp_map e,category3_mst c 
		where e.cs_id=c.cs_id and e.cs_id=?");
		$cs_id=htmlspecialchars(strip_tags($_REQUEST['cs_id']));
    	$sql->bind_param("i",$cs_id);
    	$sql->execute();
    	$rs=$sql->get_result();
    	$emp_det = $rs->fetch_assoc();
				
		$date=date('Y-m-d');
		$date = strtotime("+".$emp_det['cutt_of_time']." days", strtotime($date));
		$date=date("d-m-Y", $date);
		$dates_range=date_range(date('Y-m-d'),$date);
		foreach($dates_range as $key=>$date)
		{
			if(in_array($date,$holiday_list))
			{
				$hdays++;
			}
		}
				
		$date = strtotime("+".$hdays." days", strtotime($date));
		$date=date("d-m-Y", $date);
				
		$sql ="SELECT * FROM `water_tank_det_mst` where ulbid=?";
	    $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $tanker_list[$row['water_tank_id']]=$row['water_tank_desc'];
		}
				
		$conn->close();
		
	}
	//echo "test";
	
?>

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
					<input type="text" name="person_name" id="person_name" placeholder="Enter Person Name" class="form-control mytext" data-type="text" onkeyup="funInputFielTypes(this)"  />
					<input type="hidden" name="app_type_id" value="<?php echo htmlspecialchars(strip_tags($_REQUEST['id'])); ?>">
					<div style="font-size:10px;color:red;" id="person_nameX"></div>
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Mobile Number <span class="required" style="color:red"> * </span> </label>
					<input type="text" name="mobile" id="mobile" placeholder="Enter Mobile Number" class="form-control num mytext" data-type="mobile" onkeyup="funInputFielTypes(this)" maxlength="10" />
					<div style="font-size:10px;color:red;" id="mobileX"></div>
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Email ID</label>

					<input type="email" name="email" id="email" placeholder="Enter Email ID" class="form-control" data-type="email" onkeyup="funInputFielTypes(this)" />
					<div style="font-size:10px;color:red;" id="emailX"></div>
				</div>
			</div>

		</div>


		<div class="row">

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>House Number <span class="required" style="color:red"> * </span> </label>
					<input type="text" name="hno" id="hno" placeholder="Enter House Number" class="form-control mytext" data-type="address" onkeyup="funInputFielTypes(this)" />
					<div style="font-size:10px;color:red;" id="hnoX"></div>
				</div>
			</div>

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Address <span class="required" style="color:red"> * </span> </label>
					<textarea name="address" id="address" placeholder="Enter Address" class="form-control mytext" data-type="address" onkeyup="funInputFielTypes(this)"></textarea>
					<div style="font-size:10px;color:red;" id="addressX"></div>
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
					<input type="text" name="comp_subject" id="comp_subject" placeholder="Enter Subject / Regarding" data-type="text" onkeyup="funInputFielTypes(this)" class="form-control mytext" />
					<div style="font-size:10px;color:red;" id="comp_subjectX"></div>
				</div>
			</div>
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Upload Photo</label>
					<input type="file" name="f1" id="f1" class="form-control" accept=".jpeg,.jpg,.png,.gif" data-type="image" onchange="funInputFielTypes(this)" />
					<span id="errorMessage" class="error text-danger" style="font-size:11px;"></span>
					<div style="font-size:10px;color:red;" id="f1X"></div>
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
			
			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div  id="datetimepicker_div_id" style="display:none;">
			<label style="margin-left:14px;">Select Date & Time</label>
			<div class='col-md-3 input-group date' style="padding-left: 14px;">
				<input type='text' class="form-control datepicker" id="datetimepicker" name="datetimepicker" placeholder="select date" data-type="date" onchange="funInputFielTypes(this)" />
				
				<div style="font-size:10px;color:red;" id="datetimepickerX"></div>		
			</div>
		</div>
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
		<div class="row" id="lat_lng_value_div_id" style="display:none;">

			<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label for="exampleFormControlSelect2 ">Latitude <span class="valid_red">*</span></label>
					<input type="text" class="form-control form-control-sm" name="lat" id="lat" onkeyup="numericFilter(this);" pattern="^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$" data-type="lat" onkeyup="funInputFielTypes(this)">
					<div style="font-size:10px;color:red;" id="latX"></div>
				</div>
			</div>

			<div class="col-md-3" style="margin-left:29px; margin-right:15px;">
				<div class="form-group">
					<label for="exampleFormControlSelect2">Longitude <span class="valid_red">*</span></label>
					<input type="text" class="form-control form-control-sm" name="lng" id="lng" onkeyup="numericFilter(this);" pattern="^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$" data-type="lng" onkeyup="funInputFielTypes(this)">
					<div style="font-size:10px;color:red;" id="langX"></div>
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
					<textarea name="comp_desc" id="comp_desc" rows="5" placeholder="Enter Description" class="form-control mytext" data-type="text" onkeyup="funInputFielTypes(this)"></textarea>
				<div style="font-size:10px;color:red;" id="comp_descX"></div>
				</div>
			</div>

			<div class="col-md-10" style="margin-left:15px; margin-right:15px;">
				<div class="form-group">
					<label>Endorsement</label>
					<textarea name="endorsement" id="endorsement" rows="5" placeholder="Enter Endorsement" class="form-control " data-type="text" onkeyup="funInputFielTypes(this)"></textarea>
				<div style="font-size:10px;color:red;" id="endorsementX"></div>
				</div>
			</div>


			<div class="row">
				<span id="cut_det"></span>
			</div>

			<div class="col-md-12">
				<div class="form-actions fluid">
					<div class="col-md-offset-5 col-md-3">
						<button type="submit" class="btn btn-info" name="save" id="submitBtn" disabled>Submit</button>
						<button type="reset" class="btn btn-danger">Cancel</button>
					</div>
				</div>
			</div>

		</div>
	</fieldset>
</div>

<script>

	let globalCntVal = 0;

function funInputFielTypes(ele) {
  const type = ele.getAttribute('data-type');
  const id = ele.id;
  //const errorField = document.getElementById(id + 'X');
  	var errorField = $('#' + ele.id + 'X');
  const submitBtn = document.getElementById('submitBtn');

  let value = ele.value.trim();
  let wasInvalid = ele.getAttribute('data-invalid') === 'true';
  let isValid = true;
  let message = '';

  if (ele.value.charAt(0) === '') {
		ele.value = '';
		message='❌ First letter should not be empty!';
  }else{

//alert(type);

  // Validate based on input type
  switch (type) {
    case 'text':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-\.() ]+$/.test(value);
	  if (!isValid) 
	  message='❌ Invalid characters! Use letters, numbers, -, _, . () or space.';
      break;
	
	case 'sptext':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,&()]+$/.test(value);
      if (!isValid) message = '❌ Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;
	  
	case 'spcontent':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,:;&()"'\u2013\u2019\s]+$/.test(value);
      if (!isValid) message = '❌ Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;	
	  
	case 'dnumber':
      isValid = /^[0-9]+$/.test(value);
      if (!isValid) message = '❌ Invalid number! Use digits only';
      break;
	  
	case 'fnumber':
      isValid = /^-?\d+(\.\d+)?$/.test(value);
      if (!isValid) message = '❌ Invalid number! Use digits, ., only';
      break;
	  	
	case 'dcaptcha':
      isValid = /^[0-9]{4}$/.test(value);
	  if (!isValid) message = '❌ Invalid Captcha! Use digits only and max length is 4 digits.';
	  break;
	  
    case 'address':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,&()\/]+$/.test(value);
      if (!isValid) message = '❌ Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;
	  
    case 'address2':
      isValid = /^[a-zA-Z0-9\u0900-\u097F _\-.,()]+$/.test(value);
      if (!isValid) message = '❌ Invalid characters! Use letters, numbers, -, _, ., (, ), comma or space.';
      break;


    case 'email':
      isValid = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|io)$/.test(value);
      if (!isValid) message = '❌ Enter a valid email like user@example.com';
      break;

    case 'mobile':
		
		isValid =  /^[6-9][0-9]{0,9}$/.test(value);
	  	  
		if (value.length < 10) {
			message = "❌ Mobile number should be exactly 10 digits.";
			
		} else if (!isValid) {
			message = "❌ Mobile number should start with 6, 7, 8, or 9.";
			
		} else {
			message = "";
			
		}
	  
      //if (!isValid) message = '❌ Enter a valid 10-digit mobile number starting with 6-9.';
      break;
	  
    case 'landline':
		
		isValid =  /^0\d{2,4}-?\d{6,8}$/.test(value);
	  	  
		if (value.length < 12) {
			message = "❌ Landline number should be exactly 12 digits.";
			
		} else if (!isValid) {
			message = "❌ Landline number should start with 0 to 4,only.";
			
		} else {
			message = "";
			
		}
	  
    
      break;	
	  
    case 'fax':
		
		isValid =  /^(\+?\d{1,3}[- ]?)?0\d{2,4}[- ]?\d{6,8}$/.test(value);
	  	  
		if (value.length < 12) {
			message = "❌ Fax number should be exactly 12 digits.";
			
		} else if (!isValid) {
			message = "❌ Fax number should start with 0 to 4,only.";
			
		} else {
			message = "";			
		}
	      
      break;

    case 'lat':
      const lat = parseFloat(value);
      isValid = !isNaN(lat) && lat >= -90 && lat <= 90;
      if (!isValid) message = '❌ Latitude must be between -90 and 90.';
      break;

    case 'lng':
      const lng = parseFloat(value);
      isValid = !isNaN(lng) && lng >= -180 && lng <= 180;
      if (!isValid) message = '❌ Longitude must be between -180 and 180.';
      break;
	  
	case 'url':
	   const pattern = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;
      isValid = pattern.test(value);
	
      if (!isValid) {
        message = '❌ Unsafe URL! Only allowed protocols are http,https, and mailto.';
      }
      break;
	  
    case 'date':
      isValid = /^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/.test(value);
      if (!isValid) message = '❌ Date must be in YYYY-MM-DD format.';
      break;

    case 'old_password':
      isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/.test(value);
      if (!isValid) {
        message = '❌ Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
      }
      break;
	
	case 'password':
		isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/.test(value);
		if (!isValid) {
			message = '❌ Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
		}
    break;

	case 'confirm_password':
		
		const originalPassword = document.getElementById('password').value.trim();
		const val = value.trim();

		// Validate confirm password against policy
		isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/.test(value);

		if(!isValid){
			message = '❌ Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
			break;
		}

		// Compare actual values, not length
		if(originalPassword === val){
			
			message = '';
			break;
		}
		
		if(originalPassword !== val){
			message = '❌ Passwords do not match.';
			break;
		}
		
	break;
	  
	case 'confirmpassword':
	
      const oPassword = document.getElementById('password').value.trim();
      isValid = value === oPassword;
      if (!isValid) {
        message = '❌ Passwords do not match.';
      }
	 
	  if((value.length>=8) && (oPassword.length>=8) && isValid){	  
		var oldpwd=$("#old_password").val();
		var opwd=$("#password").val();
		var uencpwd=encryptDataBeforeSubmit(opwd);
		
		$("#password").val(uencpwd);
		$("#confirm_password").val(uencpwd);	
		
		if(oldpwd.length>=8){
		var oldencpwd=encryptDataBeforeSubmit(oldpwd);
		$("#old_password").val(oldencpwd);	
		}
		
		
	  }
	  
      break; 

    case 'captcha':
      isValid = /^[a-zA-Z0-9]+$/.test(value);
      if (!isValid) {
        message = '❌ Captcha should only contain alphanumerics.';
      }
      break;
	  
    case 'alphanumerics':
      isValid = /^[a-zA-Z0-9]*$/.test(value);
      if (!isValid) {
        message = '❌  Invalid characters, allows alphanumerics only.';
      }
      break;	
	  
    case 'alphanumerics_slash':
      isValid = /^[a-zA-Z0-9\/]*$/.test(value);
      if (!isValid) {
        message = '❌  Invalid characters, allows alphanumerics,and / only.';
      }
      break;
	  
	case 'multiplefiles':
      const files = ele.files;
      const maxFiles = 5; // you can customize max allowed files
      const maxSize = 2 * 1024 * 1024; // 2 MB per file

      const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

      if (files.length === 0) {
        isValid = false;
        message = '❌ Please select at least one file.';
      } else if (files.length > maxFiles) {
        isValid = false;
        message = `❌ Maximum ${maxFiles} files allowed.`;
      } else {
        isValid = true;
        for (let i = 0; i < files.length; i++) {
          const ext = files[i].name.split('.').pop().toLowerCase();
          if (!allowedExtensions.includes(ext)) {
            isValid = false;
            message = `❌ Invalid file type "${ext}". Allowed: ${allowedExtensions.join(', ').toUpperCase()}`;
            break;
          }
          if (files[i].size > maxSize) {
            isValid = false;
            message = `❌ File "${files[i].name}" exceeds 2MB size limit.`;
            break;
          }
        }
      }
      break;
	  
	case 'pdfonly':
	case 'imfile':
    case 'image':
    case 'images':
    case 'audio':
    case 'video':
      const file = ele.files[0];
	 // alert(type);
      if (file) {
        const ext = file.name.split('.').pop().toLowerCase();
        const allowed = {
          pdfonly: ['pdf'],
          imfile: ['jpg', 'jpeg', 'png','pdf'],
          image: ['jpg', 'jpeg', 'png'],
          images: ['jpg', 'jpeg', 'png','gif'],
          audio: ['mp3', 'wav', 'ogg'],
          video: ['mp4', 'webm', 'ogg']
        };
        isValid = allowed[type].includes(ext);
        if (!isValid) {
          message = `❌ Only ${allowed[type].join(', ').toUpperCase()} files allowed.`;
        }
      } else {
        isValid = false;
        message = `❌ Please select a valid ${type} file.`;
      }
      break;

    default:
      break;
  }
}
  // Show or clear error
  if (!isValid) {
    errorField.html(message);
    if (!wasInvalid) {
      globalCntVal++;
      ele.setAttribute('data-invalid', 'true');
    }
  } else {
     errorField.html('');
    if (wasInvalid) {
      globalCntVal--;
      ele.setAttribute('data-invalid', 'false');
    }
  }

  // Enable or disable submit
  submitBtn.disabled = globalCntVal > 0;
}


function encryptDataBeforeSubmit(inputData) {

    const key = CryptoJS.enc.Utf8.parse("MySecretKey12345");    // Custom 16-byte key
    const iv  = CryptoJS.enc.Utf8.parse("MyCustomIV654321");    // Custom 16-byte IV
   
   const encrypted = CryptoJS.AES.encrypt(inputData, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7
    });
 
    return encrypted.toString();
	
}

</script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

<script>
 $('#f_date, #t_date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    changeMonth: true,
    changeYear: true,
    changeDate: true
}); 
</script>

<script>
    $(function() {
        $(".datepicker").datepicker({
			 format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    changeMonth: true,
    changeYear: true,
    changeDate: true
        });
    });
</script>	