<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
    

	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	require_once('csrf.class.php');
    $csrf = new csrf();
	$tpl=new Smarty();
	
	 $token_id = $csrf->get_token_id();
     $token_value = $csrf->get_token($token_id);
     
	if(isset($_SESSION['uid']))
	{
	    
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		//require_once('connection.php');
		//$conn=getconnection();
		
		require_once('prepare_connection.php');
		
		include('user_defined_functions.php');
		$csrf_token=generateToken($csrf_prefix_token);
		$tpl->assign('csrf_token',$csrf_token);
	 	$code=mysqli_real_escape_string($conn,$_SESSION['code']);
		

	     
             
              // echo "<pre>"; print_r($_SESSION);die;
              if($_SESSION['geotagging_status']==1){
	         $sql="select * from geotagging_cat_mst where ParentId=0";
           	 $rs=mysqli_query($conn,$sql);
          
            	while($row = mysqli_fetch_assoc($rs))
	     	{
		    	$geotagginglist[]=array('Id'=>$row['Id'],'Description'=>$row['Description']);
		    }
		     $sqlsub="select * from geotagging_cat_mst where ParentId=1";
           	 $rssub=mysqli_query($conn,$sqlsub);
           	 	while($rows = mysqli_fetch_assoc($rssub))
            {
		    	$geotaggingsublist[]=array('Id'=>$rows['Id'],'Description'=>$rows['Description']);
		    }
		    if($_SESSION['ulb']=='095'){
		      $sqlward="select * from ward_mst where ulbid='".$_SESSION['ulb']."' order by sort_order asc";
		    }else{
		       $sqlward="select * from ward_mst where ulbid='".$_SESSION['ulb']."' GROUP BY ward_desc order by ABS(ward_desc)";  
		    }
		      
           	 $rsward=mysqli_query($conn,$sqlward);
           	 	while($rswards = mysqli_fetch_assoc($rsward))
            {
		    	$geowardlist[]=array('ward_id'=>$rswards['ward_id'],'ward_desc'=>$rswards['ward_desc']);
		    }
	         $search['suld']=$_SESSION['ulb'];
		   
              }else{
              	echo "<script>window.location='index.php';</script>";    
              } ?>
 
 <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <meta name="description" content="REGISTER COMPLAINT / SERVICE,  Trade License , Water tax payment , Dharani Citizen Registration , e-office , Swachta App Statistics, Application Management, E-News, App Masters, Council ,
       Social Connect, Important Contacts, Media Coverage, Notifications, Smart Ideas Box, Citizen buddy,  Online Water Tap Application , Online Trade Application, Online Advertisement Application, Property Tax Self Assessment, Property Tax Calculator, Municipal Council"/>
      <title>citizen services monitoring system</title>
      <link rel="stylesheet" type="text/css" href="css/styles.css"><!-- Tempalet Skeleton CSS -->
	  <link rel="stylesheet" type="text/css" href="assets/pickers/daterange-picker/daterangepicker-bs3.css"/>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/jquery-ui.min.js"></script>
      <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
      <script src="js/modernizr.js"></script>
	  <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
	  <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  	
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <style>.ui-datepicker .ui-datepicker-title {
    margin: 0 2.3em;
    line-height: 1.8em;
    text-align: center;
    color: #333;
    }</style>
</head>
<body>
	












 <div class="row ">
	<div >
		<div class="boxed m-0" style="margin:0px;">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4>Geotagging Map Locations</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
		    <form method="post" action=""  >
			      <div class="form-body">
				 	 
					 	<div class="row justify-content-center">
					<div class="col-md-2">
					    <div class="form-group1">
                          <label  >Type:</label> 
                          <select class="form-control" name="type" required id="dropdown_change">
                               <option value="">-select-</option>
                              <?php foreach($geotagginglist as $row) { ?>
							         <option value='<?php echo $row['Id'] ?>'  ><?php echo $row['Description'] ?></option>
							  <?php } ?>
						  </select>
                        </div>
					</div>
					
    				 <div class="col-md-2" style="display:none" id="sub_type" >
    					    <div class="form-group1">
                              <label  >Sub Type:</label>
                              <select class="form-control" name="subtype" id="subdrop">
    							        <option value="">-select-</option>
    							        <?php foreach($geotaggingsublist as $rows) { ?>
							                <option value='<?php echo $rows['Id'] ?>'  ><?php echo $rows['Description'] ?></option>
							            <?php } ?>
    							       
    							    </select>
                            </div>
    					</div>
    					 <div class="col-md-2" style=""  >
    					    <div class="form-group1">
                              <label  >Wards</label>
                              <select class="form-control" name="Wardno" >
    							        <option value="">-select-</option>
    							         <?php foreach($geowardlist as $rowss) { ?>
							                <option value='<?php echo $rowss['ward_id'] ?>'  ><?php echo $rowss['ward_desc'] ?></option>
							            <?php } ?>
    							        
    							    </select>
                            </div>
    					</div>
					<div class="col-md-2" style="">
                        <div class="form-group1">
                          <label class="" style="">From Date:</label>
                           <input type="text" class="phone-group form-control datepicker"    autocomplete="off" name="f_date" value="">
                         
                        </div>
                        </div>      
                        
                        
                        <div class="col-md-2" style="">
                        <div class="form-group1">
                          <label class="" style="">To Date:</label>
                          
                          <input type="text" class="phone-group form-control datepicker"    autocomplete="off" name="t_date" value="">
                          <input type="hidden"name="ulb" value='<?php echo $search['suld']; ?>'>
                          <input type="hidden"name="uid" value='<?php echo $_SESSION['uid']; ?>'>
                        </div>
                        </div>
                        <div class="col-md-1" style="">
                        <div class="form-group1">
                          <label class="" style="">&nbsp;</label>
                          
                         <button type="submit" class="btn btn-info" name="save">Get Map</button>
						 
                        </div>
                        </div>
					</div>
					
				 
					
					 
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>

<?php include('geotagging-exportmap1.php'); ?>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
 
<script>
$(function() {
    $(".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>
<script>
    $(document).ready(function(){
     $("#dropdown_change").change(function(){
         
        if($("#dropdown_change").val()==1){
            $("#sub_type").css("display", "block");  
            
            $('#subdrop').attr("required", true);
        }else{
            $("#sub_type").css("display", "none"); 
            $ 
             $('#subdrop').attr("required", false);
        }
   
     });
   });
      
</script>
 
 </body>
 </html>
<?php
		
	}
	else
	{
	/*	$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		echo "<script>window.location='index.php';</script>";
	}
?>