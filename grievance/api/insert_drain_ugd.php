<?php
	ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');

	if(($_REQUEST['Typeid']==8 || $_REQUEST['Typeid']==9 )and !empty($_REQUEST['ulbid']))
	{
     
	    /**----8===Stormwater drain,9=Sewers / UGD---*/
	if($_REQUEST['ulbid']!=''  && $_REQUEST['Wardno']!=''){
	 

    	    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0)
            {
                 $file_name = $_FILES["image"]["name"];
                 $file_type = $_FILES["image"]["type"];
                 $file_size = $_FILES["image"]["size"];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $file ="../sscgeotagging/Drain_SewersUGD/".rand().$_FILES["image"]["name"];
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
               
            
       $sql ="INSERT INTO `Drain_SewersUGD`
       ( `ulbid`, `Typeid`,`AreaFrom`,`AreaTo`,`Wardno`, `Length`, `Remarks`,  `CaptureImagePath`, `latitude`,`longitude`,`Date`, `DateTime`) 
       values(
       '".mysqli_real_escape_string($conn,$_POST['ulbid'])."','".mysqli_real_escape_string($conn,$_POST['Typeid'])."','".mysqli_real_escape_string($conn,$_POST['AreaFrom'])."','".mysqli_real_escape_string($conn,$_POST['AreaTo'])."',
       '".$_POST['Wardno']."',
       '".mysqli_real_escape_string($conn,$_POST['Length'])."','".mysqli_real_escape_string($conn,$_POST['Remarks'])."',
       '".$filepath."','".$_POST['latitude']."','".$_POST['longitude']."','".$_POST['DateTime']."','".$_POST['DateTime']."')";
	   $rs = mysqli_query($conn,$sql);
		if($rs)
			{
			    
			    $response['status_code']=200;
	            $response['message']='Geo Tagging successful.';
			}else{
			    $response['status_code']=300;
	            $response['message']='Data Not inserting';
			    
			}
	}else{
	    $response['status_code']=100;
	    $response['message']='Fill all required fields';
	}
	
	}

		
	echo json_encode($response);
mysqli_close($conn);

?>