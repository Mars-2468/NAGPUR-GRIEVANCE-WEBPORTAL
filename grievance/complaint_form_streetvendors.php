<?php

require_once('connection.php');
	$conn=getconnection();

  
    $sql = $conn->prepare("select ulbid,ulbname from ulbmst order by ulbname");
			     //$sql->bind_param("s",$ulbid);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$ulblist[$row['ulbid']]=$row['ulbname'];
		}
		
		$sql = $conn->prepare("select * from Districtmst order by distname");
			     //$sql->bind_param("s",$ulbid);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$distlist[$row['distid']]=$row['distname'];
		}
		
		
		
		
		
		$conn->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

<title>:: New Complaint Registration</title>

 <link rel="stylesheet" href="../css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Mallanna&display=swap" rel="stylesheet">


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

.form-group label span{
    font-family: 'Mallanna', sans-serif;
    font-size:18px;
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

<div class="row" style="background-color:#e3f6f5;">
<div class="container">
<center>

<img src="images/complaint_form_streetvendors.png" class="img-responsive">
</center>
</div>
<div>
    <?php if(isset($_REQUEST['message'])){ echo $_REQUEST['message'];}?>
</div>
<div style="background-color:#0066CC; color:#FFF;  padding:5px; text-align:center; font-size:15px;"><strong>New Complaint Registration <br> <span style="font-family: 'Mallanna', sans-serif;"> (కొత్త ఫిర్యాదు నమోదు      </span>)    </strong></div>
</div>


<div class="error"><center></center></div>



<br />
<br />
<div class="container">

<div style="clear:both; min-height:45px;">

<!--<div class="btn btn-danger pull-left">-->
<!--<a href="#" style="list-style:none; color:#FFF;">Back</a>-->
<!--</div>-->

<div class="btn btn-success pull-right">
<a href="check_comp_status.php?id=<?php echo $ulbid; ?>" target="_blank" style="list-style:none; color:#FFF;">Search Grievance</a>
</div>
</div>
<br />

<?php  if($_REQUEST['status']==1){echo 'Complaint Registered successfully with Reference no '.$_REQUEST['ref_id'];}?>
  <div class="panel panel-info">
      <div class="panel-heading" style="text-align:center;"><strong>Grievance Redressal System </strong></div>
      <div class="panel-body">
      
      <form action="save_comp_streetvendors.php" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">


		       
                <span id="form">
                    
                    
                    

    
    <div class="row">
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
        	<div class="form-group">
			<label>Category <span> (ఫిర్యాదు వర్గము)  </span>   </label>
			<select name="cat_id" id="cat_id" class="form-control dropdown" onchange="get_csdesc(this.value)" required>
			
				<option value="">---Select---</option>
								<?php
								foreach($cat_list as $cat_id=>$dept_desc)
								{
								?>
								
								<option value="<?php echo $cat_id; ?>"><?php echo $dept_desc; ?></option>
								
								<?php
								}
								?>
							</select>
		</div>
		
        </div>
        
       
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Complaint <span> (ఫిర్యాదు విషయము)  </span></label>
			<select name="cs_id" id="cs_id" class="form-control dropdown" onchange="fun1(this.value)" required>
			
				<option value="">---Select---</option>
			</select>
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>District <span> (జిల్లా) </span>    </label>
				<select name="distid" id="distid" class="form-control dropdown" onchange="get_ulblist(this.value)" required>
				<option value="">---Select---</option>
				<?php
				foreach($distlist as $distid=>$distname)
				{
				?>
				<option value="<?php echo $distid; ?>"><?php echo $distname; ?></option>
				<?php
				}
				?>
								
			</select>
		</div>
        </div>
        
       <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>ULB <span> (పురపాలక సంఘం పేరు)       </span></label>
			<select name="ulbid" id="ulbid" class="form-control dropdown" onchange="get_wards(this.value)" required>
				<option value="">---Select---</option>
				<?php
				foreach($ulblist as $ulbid=>$ulbname)
				{
				?>
				<option value="<?php echo $ulbid; ?>"><?php echo $ulbname; ?></option>
				<?php
				}
				?>
								
			</select>
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Ward <span> (వార్డు ) </span>   </label>
			<select name="ward_id" id="ward_id" class="form-control dropdown" onchange="get_streets(this.value)" required>
				<option value="">---Select---</option>
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
       
    
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Street <span> (వీధి) </span> </label>
			<select name="street_id" id="street_id" class="form-control dropdown" required>
			
				<option value="">---Select---</option>
			</select>
		</div>
        </div>
       
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Person Name <span> (మీ పేరు)</span> </label>
			<input type="text" name="person_name" id="person_name" placeholder="Person Name" class="form-control mytext" required>
			<input type="hidden" name="app_type_id" value="1">
		</div>
        </div>
        
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Mobile No. <span> (మొబైల్ నెంబర్ ) </span>   </label>
			<input type="text" name="mobile" id="mobile" placeholder="mobile" class="form-control num mytext" maxlength="10" required>
		</div>
        </div>
       
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Email <span> (మెయిల్ ఐడి ) </span>    </label>
			
			<input type="email" name="email" id="email" placeholder="email" class="form-control">
		</div>
        </div>
       
   
       
        <!--<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>House No <span> (ఇంటి నెంబర్) </span>    </label>
			<input type="text" name="hno" id="hno" placeholder="House no" class="form-control mytext">
		</div>
        </div>-->
        
        
        
        
        
        
            
	
        
    
        
        
         <!--<div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Subject / Regarding<span> (గురించి)</span>    </label>
			<input type="text" name="comp_subject" id="comp_subject" placeholder="Subject / Regarding" class="form-control mytext" required>
		</div>
        </div>-->
        <!-- end col-4 -->


        <!-- begin col-4 -->
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Photo<span> (సంబంధిత ఛాయా చిత్రము)  </span></label>
			<input type="file" name="f1" id="f1" class="form-control">
		</div>
        </div>
        
        
         <div class="col-md-3" style="display:none;" id="tanker_dropdown">
        
         
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
         <div class="col-md-10" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>address (చిరునామా)</label>
            
			<textarea name="address" id="address" rows="2" placeholder="Address" class="form-control mytext"></textarea>
		</div>
        </div>
       <div class="col-md-10" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label>Complaint Description (ఫిర్యదు వివరములు )</label>
			<textarea name="comp_desc" id="comp_desc" rows="5" placeholder="Description" class="form-control mytext" required></textarea>
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
				<!--<button type="reset" class="btn btn-danger">Cancel</button>-->
			</div>
		</div>
        </div>
        <!-- end col-4 -->
    </div>
    
   

</span>
		        
		        </form>
      </div>
    </div>

         
                
     </div>   
     <script>
     $(document).ready(function()
     {
         	$.post("../ajax_get_streetvendors_categories.php",{departmentid:2},function(data2)
			{
			    $("#cat_id").html(data2)
			});
     });
     
     function get_wards(ulbid)
     {
         $.post('../ajax_get_wards.php',{ulbid:ulbid},function(data)
		{
			$('#ward_id').html(data);
			
		});
     }
     function get_streets(ward_id)
	{
	$.post('../ajax_getstreets.php',{ward_id:ward_id},function(data)
		{
			$('#street_id').html(data);
		});
	}
	
	function get_csdesc(cat_id)
	{
	var ulbid=$("#ulbid").val();
	var cat_id=$("#cat_id").val();


	$.post('ajax_getstreetvendorscomplaints.php',{cat_id:cat_id,ulbid:ulbid},function(data)
		{
			$('#cs_id').html(data);
				
		});

	}
	
	function get_ulblist(distid)
	{
	    
        
        
        	$.post('ajax_get_ulblist.php',{distid:distid},function(data)
        		{
        			$('#ulbid').html(data);
        				
        		});

	}
	     
     </script>        
<br />

<div class="footer_div">Powered by - <a href="http://vmaxindia.com/" class="footerlinks" target="_blank" style="color:#00bff3; ">VMAX</a></div>


</body>
</html>
                            
                          