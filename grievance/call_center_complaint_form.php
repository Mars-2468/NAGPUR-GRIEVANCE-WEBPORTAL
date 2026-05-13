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

		$sql=$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=?");
		$ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
		
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
	    $flag=1;
		$sql=$conn->prepare("select cat.cat_id,description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag=? and cu.ulbid=?");
		$ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$sql->bind_param("is",$flag,$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
		
		if($rs)
		{
			while($row = $rs->fetch_assoc())	
				$cat_list[$row['cat_id']]=$row['description'];
		}
		$show_status=1; 
		$grievance_origin_id_2=2;
		$grievance_origin_id_3=3;$grievance_origin_id_7=7;
		
		$sql=$conn->prepare("select grievance_origin_id,grievance_origin_desc from grievance_origin_mst where show_status=? and (grievance_origin_id=? or grievance_origin_id=? or grievance_origin_id=?)");
		$sql->bind_param("iiii",$show_status,$grievance_origin_id_2,$grievance_origin_id_3,$grievance_origin_id_7);
		$sql->execute();
		$rs = $sql->get_result();
	
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		
		
		$sql=$conn->prepare("select * from emp_mst where ulbid=?");
		$ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
	
		while($row = $rs->fetch_assoc())
		{
		$emp_list[$row['emp_id']]=$row['emp_name'];
		}
		
	
		$sql=$conn->prepare("select dept_id,dept_desc from dept_mst where ulbid=?");
		$ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
		
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
	
		
		/****************** getting holidays **********************/
		
		
		
		$sql = $conn->prepare("select date from public_holydays where ulbid=?");
		$ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		$holiday_list[$row['date']]=$row['date'];
		}
		$hdays=0;
		
		/********************************************************/
		
	
		$sql = $conn->prepare("select e.emp_id,e.emp_id2,c.cutt_of_time,c.app_fee,c.fine_per_day from emp_map e,category3_mst c where e.cs_id=c.cs_id and e.cs_id=?");
		$cs_id=htmlspecialchars(strip_tags($_REQUEST['cs_id']));
		$sql->bind_param("i",$cs_id);
		$sql->execute();
		$rs = $sql->get_result();
		$emp_det=$rs->fetch_assoc();
		
	
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
		
		
	
		$sql=$conn->prepare("SELECT * FROM `water_tank_det_mst` where ulbid=?");
		$ulbid=htmlspecialchars(strip_tags($_REQUEST['ulbid']));
		$sql->bind_param("s",$ulbid);
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $tanker_list[$row['water_tank_id']]=$row['water_tank_desc'];
		    
		}
		
		$sql="SELECT * FROM `Districtmst`";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$dist_list[$row['distid']]=$row['distname'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
		$sql="SELECT * FROM `mandal_mst` where ulbid='".$ulbid."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$mandal_list[$row['mandalid']]=$row['mandal_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
		
		$conn->close();
		
	}
	
	
?>
<div>
    
</div>

<div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<script>
     $('#datetimepicker1').datetimepicker({maxDate : new Date()});
</script>

<fieldset>
    
     <!--Radio buttons-->
     <div class="row">
   
        <div class="form-group col-md-4">
 	       <label>From </label>
 	       <div class="form-data row">
 	    
  <p class="col-md-7">
  <input type="checkbox" id="fromidg2" name="fromidg" value="1" onclick="clickcheck(2)">
  <label for="female">Village in municipality</label><br>
  
  </p>
 
   
 	  </div>    
 	  </div>
 	  </div>
 	  <div  style="display:none;" id="fromidareag2">
 	  <div class="row">
 	  
 	  
 	  
   <!--<div class="form-group col-md-4">
 	          <label>Distrct</label>
 	         <select name="distidvillageg" class="form-control" id="distidvillageg">
 	             <option value="">--- select ----</option>
 	             <?php 
 	             foreach($dist_list as $key=>$val)
 	             {
 	                 ?>
 	                 <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
 	                 <?php
 	             }
 	             ?>
 	        </select>
 	          
 </div>-->
 	 <!-- <div class="form-group col-md-4">
 	          <label>Mandal</label>
 	         <select name="mandalidg" class="form-control" id="mandalidg" onchange="ajax_getvillages(this.value)">
 	             <option value="">--- select ----</option>
 	             <?php
 	              foreach($mandal_list as $key=>$val)
 	             {
 	                 ?>
 	                 <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
 	                 <?php
 	             }
 	             ?>
 	             
 	        </select>
 	          
 	  </div>-->
 	  <div class="form-group col-md-4">
 	          <label>Village</label>
 	         <select name="villageidg" class="form-control" id="villageidg" >
 	             <option value="">--- select ----</option>
 	             
 	        </select>
 	          
 	  </div>
  </div>
  
 </div>
    
   
    <div class="row">
        
        
       
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Person Name <span class="text-danger">&nbsp;*</span></label>
			<input type="text" name="person_name" id="person_name" placeholder="Person Name" class="form-control mytext" />
			<input type="hidden" name="app_type_id" value="<?php echo htmlspecialchars(strip_tags($_REQUEST['id'])); ?>">
			<input type="hidden" name="selulbid" value="<?php echo htmlspecialchars(strip_tags($_REQUEST['ulbid'])); ?>">
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Mobile No. <span class="text-danger">&nbsp;*</span></label>
			<input type="text" name="mobile" id="mobile" placeholder="mobile" class="form-control num mytext" onkeypress="return isNumber(event)" maxlength="10" pattern="[789][0-9]{9}"/>
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Alternative Mobile No.</label>
			<input type="text" name="altmobile" id="altmobile" placeholder="mobile" class="form-control num" maxlength="10" onkeypress="return isNumber(event)"/>
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Email</label>
			
			<input type="email" name="email" id="email" placeholder="email" class="form-control" />
		</div>
        </div>
        
         <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>House No <span class="text-danger">&nbsp;*</span></label>
			<input type="text" name="hno" id="hno" placeholder="House no" class="form-control mytext" />
		</div>
        </div>
        
         <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>address <span class="text-danger">&nbsp;*</span></label>
			<textarea name="address" id="address" placeholder="Address" class="form-control mytext"></textarea>
		</div>
        </div>
       
    </div>
    
    
    <div class="row">
        
       
        
       
       
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Ward <span class="text-danger">&nbsp;*</span></label>
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
				<option value="100000">Others</option>
			</select><br>
			<input type="text" class="form-control" name="otherwoarddesc" id='otherwoarddesc' placeholder="wardname" style='display:none'>
		</div>
        </div>
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Street <span class="text-danger">&nbsp;*</span></label>
			<select name="street_id" id="street_id" class="form-control dropdown" onchange="otherstreet(this.value)">
			
				<option value="0">---Select---</option>
			</select>
			<br>
			<input type="text" class="form-control" name="otherstreetdesc" id='otherstreetdesc' placeholder="street name" style='display:none;'>
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Category <span class="text-danger">&nbsp;*</span></label>
			<select name="dept_id" id="dept_id" class="form-control dropdown" onChange="get_csdesc(this.value)">
			
				<option value="0">---Select---</option>
				<?php
				foreach($cat_list as $cat_id=>$cat_desc)
				{
				?>
				<!--<option value="<?php echo $cat_id; ?>"><?php echo $cat_desc; ?></option>-->
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
			<label>Complaint / Service <span class="text-danger">&nbsp;*</span></label>
			<select name="cs_id" id="cs_id" class="form-control dropdown" onChange="fun1(this.value)">
			
				<option value="0">---Select---</option>
			</select>
		</div>
        </div>
        
         
        <div class="col-md-3" style="margin-left:22px; margin-right:15px;">
		<div class="form-group">
			<label>Subject / Regarding <span class="text-danger">&nbsp;*</span></label>
			<input type="text" name="comp_subject" id="comp_subject" placeholder="Subject / Regarding" class="form-control mytext" />
		</div>
        </div>
        
    </div>
    
   
        
        
      
        
    </div>
    
    
    
    <div class="row">
       
        
        	<div class="col-md-10" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Complaint Description <span class="text-danger">&nbsp;*</span></label>
			<textarea name="comp_desc" id="comp_desc" rows="5" placeholder="Description" class="form-control mytext"></textarea>
		</div>
        </div>
       
       
        
        
        <div class="row">
        <span id="cut_det"></span>
        </div>
       
        <div class="col-md-12">
		<div class="form-actions fluid">
			<div class="col-md-offset-5 col-md-3">
				<button type="submit" class="btn btn-info" name="save">Submit</button>
				
			</div>
		</div>
        </div>
       
    </div>
    
    
</fieldset>
</div>
