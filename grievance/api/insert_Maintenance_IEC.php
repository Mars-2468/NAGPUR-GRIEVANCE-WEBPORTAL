<?php
	ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');

	if($_REQUEST['Typeid']==2 and !empty($_REQUEST['ulbid']))
	{
     
	    /**----4===Maintenance holes---*/
	if($_REQUEST['ulbid']!='' && $_REQUEST['Area']!='' && $_REQUEST['Wardno']!=''  && $_REQUEST['ConditionValue']!='' 	){
	 

    	    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0)
            {
                 $file_name = $_FILES["image"]["name"];
                 $file_type = $_FILES["image"]["type"];
                 $file_size = $_FILES["image"]["size"];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $file ="../sscgeotagging/Maintenance_holes/".rand().$_FILES["image"]["name"];
                       if(move_uploaded_file($_FILES["image"]["tmp_name"],$file)){
                         $image_path = str_replace("../","/",$file);
                         $filepath='http://municipalservices.in/'.$image_path;  
                        
                       }else{
                           $filepath='';
                       }
                 }
	         
               $sqluld = "SELECT ulbname FROM ulbmst WHERE ulbid='".$_POST['ulbid']."'";
               $resultuld = mysqli_query($conn,$sqluld);
              if (mysqli_num_rows($resultuld) >  0) {
              // output data of each row
                  while($rowulb = mysqli_fetch_assoc($resultuld)) {
                       $ulbname=$rowulb["ulbname"];
                  }
              }
                $sqluld1 = "SELECT ward_desc FROM ward_mst WHERE ward_id='".$_POST['Wardno']."'";
                       $resultuld1 = mysqli_query($conn,$sqluld1);
                          if (mysqli_num_rows($resultuld1) >  0) {
                          // output data of each row
                              while($rowulb1 = mysqli_fetch_assoc($resultuld1)) {
                                   $ward_desc=$rowulb1["ward_desc"];
                              }
                          }
              $sqlMST = "SELECT Id FROM MHolesMst ORDER BY Id DESC LIMIT 1";
               $resultMST = mysqli_query($conn,$sqlMST);
              if (mysqli_num_rows($resultMST) >  0) {
                  // output data of each row
                  while($rowMST = mysqli_fetch_assoc($resultMST)) {
                       $lastid=$rowMST["Id"];
                  }
                    $val = $lastid+1;
                    $newid= str_pad($val,4,"0",STR_PAD_LEFT); // 0001
               }else{
                    $newid=0001; 
               }
            $uniqid=$ulbname.'/'.$ward_desc.'/'.$newid;
       $sql ="INSERT INTO `MHolesMst`
       ( `ulbid`, `Area`,`Wardno`, `UniqueId`, `ConditionValue`, `SewerLineLength`, `CaptureImagePath`, `latitude`,`longitude`,`Date`, `DateTime`) 
       values(
       '".mysqli_real_escape_string($conn,$_POST['ulbid'])."','".mysqli_real_escape_string($conn,$_POST['Area'])."','".$_POST['Wardno']."',
       '".mysqli_real_escape_string($conn,$uniqid)."','".mysqli_real_escape_string($conn,$_POST['ConditionValue'])."','".mysqli_real_escape_string($conn,$_POST['SewerLineLength'])."',
       '".$filepath."','".$_POST['latitude']."','".$_POST['longitude']."','".$_POST['DateTime']."','".$_POST['DateTime']."')";
	   $rs = mysqli_query($conn,$sql);
		if($rs)
			{
			    
			    $response['status_code']=200;
	            $response['message']='Geo Tagging successful.  Unique maintenance hole id - '.$uniqid;
			}else{
			    $response['status_code']=300;
	            $response['message']='Data Not inserting';
			    
			}
	}else{
	    $response['status_code']=100;
	    $response['message']='Fill all required fields';
	}
	
	}
	elseif($_REQUEST['Typeid']==3 and !empty($_REQUEST['ulbid']))
	{
	    /****3=IEC Hoardings***/
	if($_REQUEST['ulbid']!='' && $_REQUEST['Area']!=''&& $_REQUEST['Wardno']!='' && $_REQUEST['Slum_Unplanned_colony']!='' && $_REQUEST['latitude']!='' && $_REQUEST['longitude']!='' ){
	 
		   if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0)
            {
                 $file_name = $_FILES["image"]["name"];
                 $file_type = $_FILES["image"]["type"];
                 $file_size = $_FILES["image"]["size"];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $file ="../sscgeotagging/IECHoardings/".rand().$_FILES["image"]["name"];
                       if(move_uploaded_file($_FILES["image"]["tmp_name"],$file)){
                         $image_path = str_replace("../","/",$file);
                         $filepath='http://municipalservices.in/'.$image_path;  
                        
                       }else{
                           $filepath='';
                       }
                 }
    	   
	   $sqluld = "SELECT ulbname FROM ulbmst WHERE ulbid='".$_POST['ulbid']."'";
               $resultuld = mysqli_query($conn,$sqluld);
              if (mysqli_num_rows($resultuld) >  0) {
              // output data of each row
                  while($rowulb = mysqli_fetch_assoc($resultuld)) {
                       $ulbname=$rowulb["ulbname"];
                  }
              }
               $sqluld1 = "SELECT ward_desc FROM ward_mst WHERE ward_id='".$_POST['Wardno']."'";
                       $resultuld1 = mysqli_query($conn,$sqluld1);
                          if (mysqli_num_rows($resultuld1) >  0) {
                          // output data of each row
                              while($rowulb1 = mysqli_fetch_assoc($resultuld1)) {
                                   $ward_desc=$rowulb1["ward_desc"];
                              }
                          }
              $sqlMST = "SELECT Id FROM IECHoardings ORDER BY Id DESC LIMIT 1";
               $resultMST = mysqli_query($conn,$sqlMST);
              if (mysqli_num_rows($resultMST) >  0) {
                  // output data of each row
                  while($rowMST = mysqli_fetch_assoc($resultMST)) {
                       $lastid=$rowMST["Id"];
                  }
                    $val = $lastid+1;
                    $newid= str_pad($val,4,"0",STR_PAD_LEFT); // 0001
               }else{
                    $newid=0001; 
               }
            $uniqid=$ulbname.'/'.$ward_desc.'/'.$newid;
        $sql ="INSERT INTO `IECHoardings`
       ( `ulbid`, `UniqueId`,`Area`,`Wardno`,`Slum_Unplanned_colony`, `CaptureImagePath`, `latitude`, `longitude`,`Date`, `DateTime`) 
       values(
       '".mysqli_real_escape_string($conn,$_POST['ulbid'])."','".mysqli_real_escape_string($conn,$uniqid)."'
         ,'".mysqli_real_escape_string($conn,$_POST['Area'])."'
         ,'".$_POST['Wardno']."'
         ,'".$_POST['Slum_Unplanned_colony']."','".$filepath."','".$_POST['latitude']."','".$_POST['longitude']."','".$_POST['DateTime']."','".$_POST['DateTime']."')";
	    $rs = mysqli_query($conn,$sql);
		if($rs)
			{
			    
			    $response['status_code']=200;
	            $response['message']='Geo Tagging successful. Hoarding id -  '.$uniqid;
			}else{
			    $response['status_code']=300;
	            $response['message']='Data Not inserting';
			    
			}
	}else{
	    $response['status_code']=100;
	    $response['message']='Fill all required fields';
	}
	
	
	
	}

	else
	{
	    
	}
		
	echo json_encode($response);
mysqli_close($conn);

?>