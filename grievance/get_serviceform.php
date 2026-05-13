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

		$sql="select ward_id,ward_desc from ward_mst where ulbid=?";
		
		 $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		 $query1 = $conn->prepare($sql);
		 $query1->bind_param("s",$ulbid); 
		
		
		if($query1->execute())
		{
		    $rs=$query1->get_result();
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		
		$sql="select dept_id,dept_desc from dept_mst where ulbid=?";
		$query1 = $conn->prepare($sql);
		$query1->bind_param("s",$ulbid); 
		
		if($query1->execute())
		{
		    $rs=$query1->get_result();
			while($row = $rs->fetch_assoc())
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		$origin_list=array('1'=>'Telephone','2'=>'Counter');
		
		$conn->close();
	}
	
	
?>

<div>

<fieldset>
    
    <!-- begin row -->
    <div class="row">
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Person Name</label>
			<input type="hidden" name="grievance_origin_id" id="grievance_origin_id" value="3" />
			<input type="text" name="person_name" id="person_name" placeholder="Person Name" class="form-control mytext" />
			<input type="hidden" name="app_type_id" value="<?php echo strip_tags(htmlspecialchars($_REQUEST['id'])); ?>">
		</div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Mobile No.</label>
			<input type="text" name="mobile" id="mobile" placeholder="mobile" class="form-control mytext" />
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
			<label>Address</label>
			<textarea name="address" id="address" placeholder="Address" class="form-control mytext"></textarea>
		</div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Ward</label>
			<select name="ward_id" id="ward_id" class="form-control dropdown" onchange="get_streets(this.value)">
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
			<label>Department</label>
			<select name="emp_dept" id="dept_id" class="form-control dropdown" onchange="get_csdesc(this.value)">
			
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
        <!-- end col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Service </label>
			<select name="cs_id" id="cs_id" class="form-control dropdown" onchange="get_req_docs(this.value)">
			
				<option value="0">---Select---</option>
			</select>
		</div>
        </div>
        
    </div>
    
    
    
    <div class="row">
    
    <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Remarks</label>
			<textarea name="remarks" id="remarks" placeholder="Remarks" class="form-control"></textarea>
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
        
        <div class="row">
            <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Photo</label>
			<input type="file" name="f1" id="f1"  class="form-control" />
		</div>
        </div>
        </div>
        
    
    
        <!-- begin col-4 -->
       <!-- <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Category</label>
			<select name="cat_id" id="cat_id" class="form-control dropdown" onchange="get_csdesc(this.value)">
				<option value="0">---Select---</option>
				
			</select>
		</div>-->
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        
        
       
        <!-- end col-4 -->
        <!-- begin col-4 -->
        
        <!-- end col-4 -->
    </div>
    
    <div class="row">
    <div class="col-d-12">
    <span id="docs"></span>
    </div>
    </div>
    
    <div class="row">
       
        
        
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