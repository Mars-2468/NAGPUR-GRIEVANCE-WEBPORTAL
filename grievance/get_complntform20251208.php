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
		include('prepare_connection.php');
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
		(grievance_origin_id=? or grievance_origin_id=? or grievance_origin_id=?)";
		$query=$conn->prepare($sql);
		$show_status=1;
		$grievance_origin_id1=2;
	    $grievance_origin_id2=3;
		$grievance_origin_id3=7;
		$query->bind_param("iiii",$show_status,$grievance_origin_id1,$grievance_origin_id2,$grievance_origin_id3);
		$query->execute();
		$rs=$query->get_result();
		
		
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
	echo "test";
	
?>

<div>

<fieldset>
    
    <!-- begin row -->
    <div class="row">
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Person Name</label>
			<input type="text" name="person_name" id="person_name" placeholder="Person Name" class="form-control mytext" />
			<input type="hidden" name="app_type_id" value="<?php echo $_REQUEST['id']; ?>">
		</div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Mobile No.</label>
			<input type="text" name="mobile" id="mobile" placeholder="mobile" class="form-control num mytext" maxlength="10"/>
		</div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Email</label>
			
			<input type="email" name="email" id="email" placeholder="email" class="form-control" />
		</div>
        </div>
        <!-- end col-4 -->
    </div>
    <!-- end row -->
    
    
    
    
    <div class="row">
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>House No</label>
			<input type="text" name="hno" id="hno" placeholder="House no" class="form-control mytext" />
		</div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>address</label>
			<textarea name="address" id="address" placeholder="Address" class="form-control mytext"></textarea>
		</div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Ward</label>
			<select name="ward_id" id="ward_id" class="form-control dropdown" onChange="get_streets(this.value)">
				<option value="0">---Select---</option>
				<?php
				foreach($ward_list as $ward_id=>$ward_desc)
				{
				?>
				<option value="<?php echo $ward_id; ?>"><?php echo $ward_desc; ?></option>
				<?php
				}
				?>
			</select>
		</div>
        </div>
        <!-- end col-4 -->
    </div>
    
    
    <div class="row">
        <!-- begin col-4 -->
        
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Street</label>
			<select name="street_id" id="street_id" class="form-control dropdown">
			
				<option value="0">---Select---</option>
			</select>
		</div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Category</label>
			<select name="dept_id" id="dept_id" class="form-control dropdown" onChange="get_csdesc(this.value)">
			
				<option value="0">---Select---</option>
				<?php
				foreach($cat_list as $cat_id=>$cat_desc)
				{
				?>
				<option value="<?php echo $cat_id; ?>"><?php echo $cat_desc; ?></option>
				<?php
				}
				?>
			</select>
		</div>
        </div>
        
        
        
        
        <!-- end col-4 -->
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Complaint / Service </label>
			<select name="cs_id" id="cs_id" class="form-control dropdown" onChange="fun1(this.value)">
			
				<option value="0">---Select---</option>
			</select>
		</div>
        </div>
    </div>
    
    
    
   <!-- <div class="row">
        <!-- begin col-4 
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Category</label>
			<select name="cat_id" id="cat_id" class="form-control dropdown" onchange="get_csdesc(this.value)">
				<option value="0">---Select---</option>
				
			</select>
		</div>
        </div>-->
        <!-- end col-4 -->
        <!-- begin col-4 -->
        
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Received Through</label>
			<select name="grievance_origin_id" id="grievance_origin_id" class="form-control dropdown">
			
				<option value="0">---Select---</option>
				<?php
				foreach($grievance_origin_list as $origin_id=>$origin_desc)
				{
				?>
				<option value="<?php echo $origin_id; ?>"><?php echo $origin_desc; ?></option>
				<?php
				}
				?>
			</select>
		</div>
        </div>
        <!-- end col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Subject / Regarding </label>
			<input type="text" name="comp_subject" id="comp_subject" placeholder="Subject / Regarding" class="form-control mytext" />
		</div>
        </div>
        
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Photo</label>
			<input type="file" name="f1" id="f1"  class="form-control" />
		</div>
        </div>
        
    </div>
    
    <div class="row">
        
        
         <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label> Departments </label>
			<select name='emp_dept' onchange="get_det(this.value);" class="form-control" id="emp_dept">
			
				<option value="0">---Select---</option>
				<?php
				foreach($dept_list as $dept_id=>$dept_desc)
				{
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
			<label> Designations </label>
			 <select name='emp_desg' id='emp_desg' onchange="get_det1(this.value);" class="form-control">
              <option value='0'>--Select Designation--</option>
            </select>
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label> Employee </label>
			 <select name='emp_id' id='emp_id' class="form-control">
              <option value='0'>--Select Employee--</option>
            </select>
		</div>
        </div>
        
    </div>
    
    <div class="row" style="display:none;" id="tanker_dropdown">
        
         <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Tanker</label>
			<select name="tanker_id" id="tanker_id" class="form-control">
			
				<option value="0">---Select---</option>
				<?php
				foreach($tanker_list as $tanker_id=>$tanker_desc)
				{
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
        <!-- begin col-4 -->
        
        <!-- end col-4 -->
        <!-- begin col-4 -->
        	<div class="col-md-10" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Complaint Description</label>
			<textarea name="comp_desc" id="comp_desc" rows="5" placeholder="Description" class="form-control mytext"></textarea>
		</div>
        </div>
        <!-- end col-4 -->
        
        
        
        
        <div class="col-md-10" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Endorsement</label>
			<textarea name="endorsement" id="endorsement" rows="5" placeholder="Endorsement" class="form-control "></textarea>
		</div>
        </div>
        
        
        <div class="row">
        <span id="cut_det"></span>
        </div>
        <!-- begin col-4 -->
        <div class="col-md-12">
		<div class="form-actions fluid">
			<div class="col-md-offset-5 col-md-3">
				<button type="submit" class="btn btn-info" name="save">Submit</button>
				<button type="reset" class="btn btn-danger">Cancel</button>
			</div>
		</div>
        </div>
        <!-- end col-4 -->
    </div>
    
    
</fieldset>
</div>