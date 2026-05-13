<?php
	ini_set('display_errors',0);
require_once('connection.php');
	$conn=getconnection();
	$ulbid=$_REQUEST['id'];
	
	    
	     $sql = $conn->prepare("select ulbid,ulbname from ulbmst");
		
				$sql->execute();
			    $rs=$sql->get_result();
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$ulb_list[$row['ulbid']]=$row['ulbname'];
		}
	
       
        $sql = $conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=?");
		$sql->bind_param("s",$ulbid);
				$sql->execute();
			    $rs=$sql->get_result();
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		$flag=1;
		$sql = $conn->prepare("select cat.cat_id,description from category_mst cat,complaint_ulbmap cu,cs_mst cm where cu.cs_id=cm.cs_id and cm.cat_id=cat.cat_id and cu.flag=? and cu.ulbid=?");
		$sql->bind_param("is",$flag,$ulbid);
				$sql->execute();
			    $rs=$sql->get_result();
		 
		if($rs)
		{
			while($row = $rs->fetch_assoc())	
				$cat_list[$row['cat_id']]=$row['description'];
		}
		 $show_status=1;
		
		$sql = $conn->prepare("select grievance_origin_id,grievance_origin_desc from grievance_origin_mst where show_status=?");
		$sql->bind_param("i",$show_status);
				$sql->execute();
			    $rs=$sql->get_result();
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		
	    $sql = $conn->prepare("select open_comp_banner from users where ulbid=?");
		$sql->bind_param("s",$ulbid);
				$sql->execute();
			    $rs=$sql->get_result();
		$row = $rs->fetch_assoc();
		$banner=$row['open_comp_banner'];
		
		
		$sql = $conn->prepare("SELECT * FROM `water_tank_det_mst` where ulbid=?");
		$sql->bind_param("s",$ulbid);
				$sql->execute();
			    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $tanker_list[$row['water_tank_id']]=$row['water_tank_desc'];
		    
		}
		
		
		$conn->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

<title>:: New Complaint Registration</title>

 <link rel="stylesheet" href="../css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
.footer_div {
    width: 100%;
    height: 25px;
    text-align: center;
    background-color: #0054a6;
    color: #FFF;
    font-family: "Myriad Pro";
    font-size: 14px;
    font-weight: normal;
    padding-top: 5px;
    clear: both;
    margin: 0 auto;
	margin-top:10px;
	margin-bottom:0px;
}

</style>
<script>
function validateForm()
{
errors=0;
var mobile=$("#mobile").val();
	var patt1= /^\d{10}$/;
	if(!patt1.test(mobile))
    	{
		($('#mobile')).css({"background-color": "pink"});
		errors++;    	
	}
$(".mytext").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});



$(".dropdown").each(function(){
	
		var val_field=$(this).val();
		if(val_field=='0')
		{
			($(this)).css({"background-color": "pink"});
			errors++;
		}
		else
		{
			($(this)).css({"background-color": "white"});
		}
	});
		
    	
	if(errors==0)
	{
		return true;
	}
	else
	{
		alert("Please Enter Correct Value in High-lighted Fields - "+errors );
		return false;
	}
}
</script>
<script src='../js/jquery.min.js'></script>
<script>
$(document).ready(function() {

$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });
      

}); 
</script>

</head>

<body style="padding:0px; margin:0px;">




<div class="row" style="background-color:#c4eeff;">
<div class="container">
<center>


<br><br>
<div style="font-size:25px;">
<strong>Commissioner Director of Municipal Administration </strong></div> 
<div style="margin-bottom:15px;">Government of Telangana</div>


</center>
</div>
<div>
    <?php if(isset($_REQUEST['message'])){ echo $_REQUEST['message'];}?>
</div>
<div style="background-color:#0066CC; color:#FFF; padding:5px; text-align:center; font-size:15px;"><strong>New Complaint Registration</strong></div>
</div>


<div class="error"><center></center></div>



<br />
<br />
<div class="container">

<div style="clear:both; min-height:45px;">

<div class="btn btn-success pull-right">
<a href="check_comp_status_cdma.php" target="_blank" style="list-style:none; color:#FFF;">Search Grievance</a>

</div>
</div>
<br />

<?php  if($_REQUEST['status']==1){echo 'Complaint Registered successfully with Reference no '.$_REQUEST['ref_id'];}?>
  <div class="panel panel-info">
      <div class="panel-heading" style="text-align:center;"><strong>Grievance Redressal System</strong></div>
      <div class="panel-body">
      
      <form action="save_comp.php" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

<input type="hidden" name="form_key" value="1" id="form_key">
		       
                <span id="form">

    <!-- begin row -->
    <div class="row">
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Person Name *</label>
			<input type="text" name="person_name" id="person_name" placeholder="Person Name" class="form-control mytext">
			<input type="hidden" name="app_type_id" value="1">
		</div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Mobile No *</label>
			<input type="text" name="mobile" id="mobile" placeholder="mobile" class="form-control num mytext" maxlength="10">
		</div>
        </div>
       
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Email</label>
			
			<input type="email" name="email" id="email" placeholder="email" class="form-control">
		</div>
        </div>
        <!-- end col-4 -->
    </div>
    
    <div class="row">
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>House No *</label>
			<input type="text" name="hno" id="hno" placeholder="House no" class="form-control mytext">
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>address *</label>
			<input type="text" name="address" id="address" placeholder="Address" class="form-control mytext">
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>ULB *</label>
			<select name="ulbid" id="ulbid" class="form-control dropdown" onchange="getward(this.value);">
				<option value="0">---Select---</option>
				<?php
				foreach($ulb_list as $ulbid=>$ulb_desc)
				{
				?>
				<option value="<?php echo $ulbid; ?>"><?php echo $ulb_desc; ?></option>
				<?php
				}
				?>
								
			</select>
		</div>
        </div>
        
    </div>
    
    
    <div class="row">
        <!-- begin col-4 -->
         <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Ward *</label>
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
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Street *</label>
			<select name="street_id" id="street_id" class="form-control dropdown" onchange="get_cs(this.value)">
			
				<option value="0">---Select---</option>
				<?php
				foreach($cat_list as $cat_id=>$description)
								{
								?>
								
								<option value="<?php echo $cat_id; ?>"><?php echo $description; ?></option>
								
								<?php
								}
								?>
								
			</select>
		</div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
            
		<div class="form-group">
			<label>Category *</label>
			<select name="cat_id" id="cat_id" class="form-control dropdown" onchange="get_csdes(this.value)" >
			    <!--onchange="get_csdesc(this.value)"-->
			
				<option value="0">---Select---</option>
					<?php
							foreach($cs_list as $cs_id=>$cs_desc)
								{
								?>
								
								<option value="<?php echo $cs_id; ?>"><?php echo $cs_desc; ?></option>
								
								<?php
								}
								?>	
							</select>
		</div>
		
        </div>
        
        <!-- end col-4 -->
        
        
    </div>
    
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="row">
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Complaint / Service *</label>
			<select name="cs_id" id="cs_id" class="form-control dropdown" onchange="fun1(this.value)">
			
				<option value="0">---Select---</option>
			</select>
		</div>
        </div>
        
        
         <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Subject / Regarding *</label>
			<input type="text" name="comp_subject" id="comp_subject" placeholder="Subject / Regarding" class="form-control mytext">
		</div>
        </div>
        <!-- end col-4 -->


        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Photo</label>
			<input type="file" name="f1" id="f1" class="form-control">
		</div>
        </div>
        
        
         <div class="col-md-3" style="display:none;" id="tanker_dropdown">
        
         
		<div class="form-group">
			<label>Tanker *</label>
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
       <div class="col-md-10" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label> Complaint Description * </label>
			<textarea name="comp_desc" id="comp_desc" rows="5" placeholder="Description" class="form-control mytext"></textarea>
		</div>
        </div>
        <!-- end col-4 -->
        </div>
        
        <div class="row">
        <span id="cut_det"></span>
        </div>
        <!-- begin col-4 -->
        <div class="col-md-12">
		<div class="form-actions fluid">
			<div class="col-md-offset-5 col-md-3">
				<button type="submit" class="btn btn-success" name="save">Submit</button>
				<button type="reset" class="btn btn-danger">Cancel</button>
			</div>
		</div>
        </div>
       
    </div>
    
</span>
		        
		        </form>
      </div>
    </div>
     
                
     </div>   
     <script>
     
      function getward(ulbid){
         
        var ward_id = $('#ulbid').val();
       
        $.post('ajax_get_wards.php',{ulbid:ulbid,ward_id:ward_id},function(data)
		{
		
		$('#ward_id').html(data);
		
    		 $.post('ajax_get_category.php',{ulbid:ulbid},function(data2)
    		{
    		    
    			$('#cat_id').html(data2);
    		});
		
		
		});  
      
          
      }
      
      
     function get_streets(ward_id)
	{
	$.post('../ajax_getstreets.php',{ward_id:ward_id},function(data)
		{
			$('#street_id').html(data);
		});
	}
	
	
	 function get_csdes(cat_id)
	{
	    
	$.post('../ajax_getcomplaints.php',{cat_id:cat_id},function(data)
		{
		   
			$('#cs_id').html(data);
		});
	}
	
	function get_csdesc(cat_id)
	{
	var ulbid=$("#ulbid").val();
	


	$.post('ajax_getcomplaints.php',{cat_id:cat_id,ulbid:ulbid},function(data)
		{
			
			
			$('#cs_id').html(data);
				if(ulbid=='052' && cat_id=='3')
            		{
            		    $("#tanker_dropdown").css('display','block');
            		    $("#tanker_id").addClass('dropdown');
            		}
            		else
            		{
            		    $("#tanker_dropdown").css('display','none');
            		    $("#tanker_id").removeClass('dropdown');
            		}
		});

	}
	     
     </script>        
<br />

<div class="footer_div">Powered by - <a href="http://vmaxindia.com/" class="footerlinks" target="_blank" style="color:#00bff3; ">VMAX</a></div>


</body>
</html>
                            
                           