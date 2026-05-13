<?php
	ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');
	if($_REQUEST['Typeid']==4 and !empty($_REQUEST['ulbid']))
	{
     
	    /**----4===IIHL---*/
	if($_REQUEST['ulbid']!='' && $_REQUEST['HHno']!='' && $_REQUEST['ResidentName']!='' && $_REQUEST['Area']!=''  && $_REQUEST['Wardno']!=''  && $_REQUEST['MobileNo']!=''
	&& $_REQUEST['HHToiletFacility']!='' && $_REQUEST['YesOrNoValue']!='' ){
	 

    	    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0)
            {
                 $file_name = $_FILES["image"]["name"];
                 $file_type = $_FILES["image"]["type"];
                 $file_size = $_FILES["image"]["size"];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $file ="../sscgeotagging/iihl/".rand().$_FILES["image"]["name"];
                       if(move_uploaded_file($_FILES["image"]["tmp_name"],$file)){
                         $image_path = str_replace("../","/",$file);
                         $filepath='http://municipalservices.in/'.$image_path;  
                        
                       }else{
                           $filepath='';
                       }
                 }else{
                     $filepath=''; 
                     
                 }
	   
       $sql ="INSERT INTO `HhlData`
       ( `ulbid`, `HHno`, `ResidentName`, `Area`,`Wardno`, `MobileNo`, `HHToiletFacility`, `YesOrNoValue`, `IsGeoTagged`, `CaptureImagePath`, `latitude`,`longitude`,`Date`, `DateTime`) 
       values(
       '".mysqli_real_escape_string($conn,$_POST['ulbid'])."','".mysqli_real_escape_string($conn,$_POST['HHno'])."','".mysqli_real_escape_string($conn,$_POST['ResidentName'])."','".mysqli_real_escape_string($conn,$_POST['Area'])."','".$_POST['Wardno']."','".mysqli_real_escape_string($conn,$_POST['MobileNo'])."','".mysqli_real_escape_string($conn,$_POST['HHToiletFacility'])."','".mysqli_real_escape_string($conn,$_POST['YesOrNoValue'])."',
       '".mysqli_real_escape_string($conn,$_POST['IsGeoTagged'])."','".$filepath."','".$_POST['latitude']."','".$_POST['longitude']."','".$_POST['DateTime']."','".$_POST['DateTime']."')";
	    $rs = mysqli_query($conn,$sql);
		if($rs)
			{
			    
			    $response['status_code']=200;
	            $response['message']='Inserted success';
			}else{
			    $response['status_code']=300;
	            $response['message']='Data Not inserting';
			    
			}
	}else{
	    $response['status_code']=100;
	    $response['message']='Fill all required fields';
	}
	
	}
	elseif(($_REQUEST['Typeid']==5 || $_REQUEST['Typeid']==6 || $_REQUEST['Typeid']==7 ) and !empty($_REQUEST['ulbid']))
	{
	    /**----$_REQUEST['Typeid']==5*//**----$_REQUEST['Typeid']==6===COMMUNITY TOILETS---*//**----$_REQUEST['Typeid']==7===OTHER TOILETS---*/
	if($_REQUEST['ulbid']!='' && $_REQUEST['Area']!=''  && $_REQUEST['Wardno']!=''  && $_REQUEST['latitude']!='' && $_REQUEST['longitude']!='' ){
	 
		   if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0)
            {
                 $file_name = $_FILES["image"]["name"];
                 $file_type = $_FILES["image"]["type"];
                 $file_size = $_FILES["image"]["size"];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if($_REQUEST['Typeid']==5){
                    $file ="../sscgeotagging/public_toilets/".rand().$_FILES["image"]["name"];
                    }elseif($_REQUEST['Typeid']==6){
                      $file ="../sscgeotagging/Community_toilets/".rand().$_FILES["image"]["name"];   
                    }
                    elseif($_REQUEST['Typeid']==7){
                      $file ="../sscgeotagging/other_toilets/".rand().$_FILES["image"]["name"];    
                    }
                       if(move_uploaded_file($_FILES["image"]["tmp_name"],$file)){
                         $image_path = str_replace("../","/",$file);
                         $filepath='http://municipalservices.in/'.$image_path;  
                        
                       }else{
                           $filepath='';
                       }
                 }
    	   
	   
       $sql ="INSERT INTO `public_community_other_toilets` ( `ulbid`, `ToiletID`, `Area`,`Wardno`, `CaptureImagePath`, `latitude`, `longitude`,`Date`, `DateTime`) 
       values(  '".mysqli_real_escape_string($conn,$_POST['ulbid'])."','".mysqli_real_escape_string($conn,$_POST['Typeid'])."','".mysqli_real_escape_string($conn,$_POST['Area'])."','".$_POST['Wardno']."','".$filepath."','".$_POST['latitude']."','".$_POST['longitude']."','".$_POST['DateTime']."','".$_POST['DateTime']."')";
	    $rs = mysqli_query($conn,$sql);
		if($rs)
			{
			    
			    $response['status_code']=200;
	            $response['message']='Inserted success';
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
	    $response['status_code']=100;
	    $response['message']='Somthing Went Worng';   
	}
		
	echo json_encode($response);
    mysqli_close($conn);

?>