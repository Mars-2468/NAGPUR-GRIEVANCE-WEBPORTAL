<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	require_once('csrf.class.php');
    $csrf = new csrf();
	$tpl=new Smarty();

	
	$token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);
    
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include("prepare_connection.php");
		$conn=getconnection();
		
	
		 
		$sql =$conn->prepare("select ulbid from users where user_id=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['uid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		$row = $rs->fetch_assoc();
		
		 
		 
		 $ulbid=$row['ulbid'];	
		 	
		if($_POST['save'])
		
		{
		    if($token_id==$_POST['token']){
		        
		    if($_POST['date']!='')
		    {
		    $date = date('Y-m-d',strtotime($_POST['date']));
		    }
		$area_csc = strip_tags($_POST['area_csc']);
		$systems_provided = strip_tags($_POST['systems_provided']);
		$staff_deployed = strip_tags($_POST['staff_deployed']);
		$nodal_officer_name = strip_tags($_POST['nodal_officer_name']);
		$nodal_officer_number = strip_tags($_POST['nodal_officer_number']);
		$nodal_officer_desg = strip_tags($_POST['nodal_officer_desg']);
		$water_facility = strip_tags($_POST['water_facility']);
		$seating_arrangement = strip_tags($_POST['seating_arrangement']);
		$other = strip_tags($_POST['other']);
		
		$printers_provided = strip_tags($_POST['printers_provided']);
		$scanners_provided = strip_tags($_POST['scanners_provided']);
		$news_facility = strip_tags($_POST['news_facility']);
		$waiting_room = strip_tags($_POST['waiting_room']);
		$printed_app = strip_tags($_POST['printed_app']);
		$board_placed = strip_tags($_POST['board_placed']);
		$other_facilities = strip_tags($_POST['other_facilities']);
		$toilet_facility = strip_tags($_POST['toilet_facility']);
		$established = strip_tags($_POST['established']);
		$progress = strip_tags($_POST['progress']);
		
		if($_POST['completion_date']!= '')
		{
		$completion_date = date('Y-m-d',strtotime($_POST['completion_date']));
		}
		
             $target_dir = "images/";
             $filename = $_FILES["img_url"]["tmp_name"];
             $filename1 = $_FILES["side_view"]["tmp_name"];
             $filename2 = $_FILES["long_view"]["tmp_name"];
             $filename3 = $_FILES["water_pic"]["tmp_name"];
             $filename4 = $_FILES["pic2"]["tmp_name"];
             
            
             
             
            $img  = basename($_FILES["img_url"]["name"]);
            $img1 = basename($_FILES["side_view"]["name"]);
            $img2 = basename($_FILES["long_view"]["name"]);
            $img3 = basename($_FILES["water_pic"]["name"]);
            $img4 = basename($_FILES["pic2"]["name"]);
            
             $ext =  pathinfo($img, PATHINFO_EXTENSION);
             $ext1 = pathinfo($img1, PATHINFO_EXTENSION);
            $ext2 = pathinfo($img2, PATHINFO_EXTENSION);
            $ext3 = pathinfo($img3, PATHINFO_EXTENSION);
            $ext4 = pathinfo($img4, PATHINFO_EXTENSION);
            
            $uniquesavename=time().uniqid(rand()).".".$ext;
            $uniquesavename1=time().uniqid(rand()).".".$ext1;
            $uniquesavename2=time().uniqid(rand()).".".$ext2;
            $uniquesavename3=time().uniqid(rand()).".".$ext3;
            $uniquesavename4=time().uniqid(rand()).".".$ext4;
             
             
            $destFile =  $target_dir.$uniquesavename ;
            $destFile1 = $target_dir.$uniquesavename1;
            $destFile2 = $target_dir.$uniquesavename2;
            $destFile3 = $target_dir.$uniquesavename3;
            $destFile4 = $target_dir.$uniquesavename4;
             
             
             if($img != '')
             {
                if(move_uploaded_file($filename, $destFile))
                {
                   
                    
                     $upload = 1;
                }
                else
                {
                    
                   
                    $upload = 0;
                }
               
             }
             else
             {
                 $destFile = "";
                 $upload = 1;
             }
            if($img1 != '')
            {
                if(move_uploaded_file($filename1, $destFile1))
                {
                    $upload = 1;
                   
                }
                else
                {
                    $upload = 0;
                    
                }
            }
            else
            {
                $destFile1 = "";
                $upload = 1;
            }
            
            
            if($img2 != '')
            {
                if(move_uploaded_file($filename2, $destFile2))
                {
                    $upload = 1;
                    
                }
                else
                {
                    $upload = 0;
                   
                }
            }
            else
            {
                $destFile2 = "";
                $upload = 1;
            }
            
            
            
             if($img3 != '')
            {
                if(move_uploaded_file($filename3, $destFile3))
                {
                    $upload = 1;
                  
                }
                else
                {
                    $upload = 0;
                   
                }
            }
            else
            {
                $destFile3 = "";
                $upload = 1;
            }
            
            
            
            if($img4 != '')
            {
                if(move_uploaded_file($filename4, $destFile4))
                {
                    $upload = 1;
                   
                }
                else
                {
                    $upload = 0;
                   // echo "<script>alert('file5 not uploaded'); </script>";
                }
            }
            else
            {
                $destFile4 = "";
                $upload = 1;
            }
            
            
            
             
		if($upload == 1)		
		{
		    if(($destFile != "") && ($destFile1 != "") && ($destFile2 != "") && ($destFile3 != "") && ($destFile4 != ""))
		    {
		
                  $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , front_view , side_view ,
                 long_view , water_facility , pic, seating_arrangement , pic2 ,other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' , '$destFile' , '$destFile1', '$destFile2' ,'$water_facility' ,
                '$destFile3', '$seating_arrangement', '$destFile4' , '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' , '$toilet_facility' , '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' ,  front_view = '$destFile' ,side_view = '$destFile1' ,long_view = '$destFile2' , pic = '$destFile3' ,water_facility = '$water_facility' , seating_arrangement = '$seating_arrangement',
                 pic2 = '$destFile4' , other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established' , progress = '$progress' , completion_date = '$completion_date' "; 
            
               
                
                $ulbid=$ulbid;
                $date=$date;
                $area_csc=$area_csc;
                $systems_provided=$systems_provided;
                $staff_deployed=$staff_deployed;
                $nodal_officer_name=$nodal_officer_name;
                $nodal_officer_number=$nodal_officer_number;
                $nodal_officer_desg=$nodal_officer_desg;
                $destFile=$destFile;
                $destFile1=$destFile1;
                $destFile2=$destFile2;
                $water_facility=$water_facility;
                $destFile3=$destFile3;
                $seating_arrangement=$seating_arrangement;
                $destFile4=$destFile4;
                $other=$other;
                $printers_provided=$printers_provided;
                $scanners_provided=$scanners_provided;
                $news_facility=$news_facility;
                $waiting_room=$waiting_room;
                $printed_app=$printed_app;
                $board_placed=$board_placed;
                $other_facilities=$other_facilities;
                $toilet_facility=$toilet_facility;
                $established=$established;
                $progress=$progress;
                $completion_date=$completion_date;
                
		        $query=$conn->prepare($sql);
		        $query->bind_param("ssiiisissssisissiiiiiisiiss siiisisssssiissiiiiiiiiss",$ulbid,$date,$area_csc,$systems_provided,$staff_deployed,$nodal_officer_name,
		        $nodal_officer_number,$nodal_officer_desg,$destFile,$destFile1,$destFile2,$water_facility,$destFile3,
		        $seating_arrangement,$destFile4,$other,$printers_provided,$scanners_provided,$news_facility,$waiting_room,
		        $printed_app,$board_placed,$other_facilities,$toilet_facility,$established,$progress,$completion_date,
		        
		        $date,$area_csc,$systems_provided,$staff_deployed,$nodal_officer_name,$nodal_officer_number,
               $nodal_officer_desg,$destFile,$destFile1,$destFile2,$destFile3,$water_facility,
               $seating_arrangement,$destFile4,$other,$printers_provided,$scanners_provided,$news_facility,
               $waiting_room,$printed_app,$board_placed,$toilet_facility,$established,$progress,$completion_date);
		        
		        
		        
		    }
            
            
            else if( ($destFile2 != "") && ($destFile3 != "") && ($destFile4 != ""))
            {
                 $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , long_view ,
                  water_facility , pic, seating_arrangement , pic2 , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' ,'$destFile' ,'$water_facility' , '$destFile3',
                '$seating_arrangement',  '$destFile4', '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' , '$toilet_facility', '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' , long_view = '$destFile2' , water_facility = '$water_facility' ,  pic = '$destFile3', seating_arrangement = '$seating_arrangement',  pic2 = '$destFile4' , 
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established' , progress = '$progress' , completion_date = '$completion_date' ";  
            
                $ulbid=$ulbid;
                $date=$date;
                $area_csc=$area_csc;
                $systems_provided=$systems_provided;
                $staff_deployed=$staff_deployed;
                $nodal_officer_name=$nodal_officer_name;
                $nodal_officer_number=$nodal_officer_number;
                $nodal_officer_desg=$nodal_officer_desg;
                $destFile=$destFile;
                $water_facility=$water_facility;
                $destFile3=$destFile3;
                $seating_arrangement=$seating_arrangement;
                $destFile4=$destFile4;
                $other=$other;
                $printers_provided=$printers_provided;
                $scanners_provided=$scanners_provided;
                $news_facility=$news_facility;
                $waiting_room=$waiting_room;
                $printed_app=$printed_app;
                $board_placed=$board_placed;
                $other_facilities=$other_facilities;
                $toilet_facility=$toilet_facility;
                $established=$established;
                $progress=$progress;
                $completion_date=$completion_date;
                
		        $query=$conn->prepare($sql);
		        $query->bind_param("ssiiisissisissiiiiiisiiss siiisisssssiissiiiiiiiiss",$ulbid,$date,$area_csc,$systems_provided,$staff_deployed,
		        $nodal_officer_name,
		        $nodal_officer_number,$nodal_officer_desg,$destFile,$water_facility,$destFile3,
		        $seating_arrangement,$destFile4,$other,$printers_provided,$scanners_provided,$news_facility,$waiting_room,
		        $printed_app,$board_placed,$other_facilities,$toilet_facility,$established,$progress,$completion_date,
		        
		        $date,$area_csc,$systems_provided,$staff_deployed,$nodal_officer_name,$nodal_officer_number,
               $nodal_officer_desg,$destFile,$destFile1,$destFile2,$destFile3,$water_facility,
               $seating_arrangement,$destFile4,$other,$printers_provided,$scanners_provided,$news_facility,
               $waiting_room,$printed_app,$board_placed,$toilet_facility,$established,$progress,$completion_date);
                
                
                
                
            }
            
            else if(($destFile != "")  && ($destFile1 != "") && ($destFile2 != ""))
            {
                 $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , front_view , side_view ,long_view ,
                  water_facility , seating_arrangement , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' , '$destFile' , '$destFile1' , '$destFile2' ,'$water_facility',  
                '$seating_arrangement',  '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' , '$toilet_facility' , '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE date = '$date', area_csc= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' ,  front_view = '$destFile' , side_view = '$destFile1' , long_view = '$destFile2' , water_facility = '$water_facility' ,seating_arrangement = '$seating_arrangement',
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established', progress = '$progress' , completion_date = '$completion_date' "; 
            
                $ulbid=$ulbid;
                $date=$date;
                $area_csc=$area_csc;
                $systems_provided=$systems_provided;
                $staff_deployed=$staff_deployed;
                $nodal_officer_name=$nodal_officer_name;
                $nodal_officer_number=$nodal_officer_number;
                $nodal_officer_desg=$nodal_officer_desg;
                $destFile=$destFile;
                $destFile1=$destFile1;
                $destFile2=$destFile2;
                $water_facility=$water_facility;
                //$destFile3=$destFile3;
                $seating_arrangement=$seating_arrangement;
                $destFile4=$destFile4;
                $other=$other;
                $printers_provided=$printers_provided;
                $scanners_provided=$scanners_provided;
                $news_facility=$news_facility;
                $waiting_room=$waiting_room;
                $printed_app=$printed_app;
                $board_placed=$board_placed;
                $other_facilities=$other_facilities;
                $toilet_facility=$toilet_facility;
                $established=$established;
                $progress=$progress;
                $completion_date=$completion_date;
                
		        $query=$conn->prepare($sql);
		        $query->bind_param("ssiiisissssiissiiiiiisiiss siiisissssiisiiiiiiiiss",$ulbid,$date,$area_csc,$systems_provided,$staff_deployed,$nodal_officer_name,
		        $nodal_officer_number,$nodal_officer_desg,$destFile,$destFile1,$destFile2,$water_facility,
		        $seating_arrangement,$destFile4,$other,$printers_provided,$scanners_provided,$news_facility,$waiting_room,
		        $printed_app,$board_placed,$other_facilities,$toilet_facility,$established,$progress,$completion_date,
		        
		        $date,$area_csc,$systems_provided,$staff_deployed,$nodal_officer_name,$nodal_officer_number,
               $nodal_officer_desg,$destFile,$destFile1,$destFile2,$water_facility,
               $seating_arrangement,$other,$printers_provided,$scanners_provided,$news_facility,
               $waiting_room,$printed_app,$board_placed,$toilet_facility,$established,$progress,$completion_date);
                
                
            }
            
            else if(($destFile3 != "") && ($destFile4 != ""))
            {
                $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , 
                  water_facility , pic, seating_arrangement , pic2 , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' ,'$water_facility' , '$destFile3',
                '$seating_arrangement',  '$destFile4', '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' , '$toilet_facility', '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg'  ,  pic = '$destFile3', water_facility = '$water_facility', seating_arrangement = '$seating_arrangement',  pic2 = '$destFile4' , 
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established' , progress = '$progress' , completion_date = '$completion_date' ";  
            
                
                $ulbid=$ulbid;
                $date=$date;
                $area_csc=$area_csc;
                $systems_provided=$systems_provided;
                $staff_deployed=$staff_deployed;
                $nodal_officer_name=$nodal_officer_name;
                $nodal_officer_number=$nodal_officer_number;
                $nodal_officer_desg=$nodal_officer_desg;
                $water_facility=$water_facility;
                $destFile3=$destFile3;
                $seating_arrangement=$seating_arrangement;
                $destFile4=$destFile4;
                $other=$other;
                $printers_provided=$printers_provided;
                $scanners_provided=$scanners_provided;
                $news_facility=$news_facility;
                $waiting_room=$waiting_room;
                $printed_app=$printed_app;
                $board_placed=$board_placed;
                $other_facilities=$other_facilities;
                $toilet_facility=$toilet_facility;
                $established=$established;
                $progress=$progress;
                $completion_date=$completion_date;
                
		        $query=$conn->prepare($sql);
		        $query->bind_param("ssiiisisisissiiiiiisiiss siiisissiissiiiiiiiiss",$ulbid,$date,$area_csc,$systems_provided,$staff_deployed,$nodal_officer_name,
		        $nodal_officer_number,$nodal_officer_desg,$water_facility,$destFile3,
		        $seating_arrangement,$destFile4,$other,$printers_provided,$scanners_provided,$news_facility,$waiting_room,
		        $printed_app,$board_placed,$other_facilities,$toilet_facility,$established,$progress,$completion_date,
		        
		        $date,$area_csc,$systems_provided,$staff_deployed,$nodal_officer_name,$nodal_officer_number,
               $nodal_officer_desg,$destFile3,$water_facility,
               $seating_arrangement,$destFile4,$other,$printers_provided,$scanners_provided,$news_facility,
               $waiting_room,$printed_app,$board_placed,$toilet_facility,$established,$progress,$completion_date);
                
                
                
            }
            
            else if(($destFile != "")  && ($destFile1 == ""))
            {
                $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , front_view ,
                  water_facility , seating_arrangement , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' , '$destFile' , '$water_facility' ,
                '$seating_arrangement',  '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' , '$toilet_facility' , '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' ,  front_view = '$destFile'  , water_facility = '$water_facility' , seating_arrangement = '$seating_arrangement',
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established', progress = '$progress' , completion_date = '$completion_date' "; 
            }
            
            
            else if(($destFile != "")  && ($destFile1 != ""))
            {
                 $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , front_view , side_view ,
                  water_facility , seating_arrangement , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' , '$destFile' , '$water_facility' ,'$destFile1' , 
                '$seating_arrangement',  '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' , '$toilet_facility' , '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' ,  front_view = '$destFile'  , water_facility = '$water_facility' , side_view = '$destFile1'  ,seating_arrangement = '$seating_arrangement',
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established', progress = '$progress' , completion_date = '$completion_date' "; 
            }
            
            
            
            else if(($destFile == "")  && ($destFile1 != ""))
            {
                $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , side_view ,
                  water_facility , seating_arrangement , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' ,  '$destFile1' ,'$water_facility' ,
                '$seating_arrangement',  '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' ,'$toilet_facility' , '$established', '$progress' , '$completion_date' ) 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' ,side_view = '$destFile1' , water_facility = '$water_facility' , seating_arrangement = '$seating_arrangement',
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established= '$established' , progress = '$progress' , completion_date = '$completion_date' ";  
            }
            
            else if(($destFile == "")  && ($destFile1 == "") && ($destFile2 != ""))
            {
                 $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , 
                 long_view , water_facility , seating_arrangement , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established, progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' ,  '$destFile2' ,'$water_facility' ,
                '$seating_arrangement',  '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' ,'$toilet_facility', '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' ,long_view = '$destFile2' , water_facility = '$water_facility' , seating_arrangement = '$seating_arrangement',
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established' , progress = '$progress' , completion_date = '$completion_date' "; 
            }
            
            
            
            else if(($destFile3 != ""))
            {
                $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , 
                  water_facility , pic, seating_arrangement , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' ,'$water_facility' , '$destFile3',
                '$seating_arrangement',  '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' , '$toilet_facility', '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' , water_facility = '$water_facility' , pic = '$destFile3' , seating_arrangement = '$seating_arrangement',
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established' , progress = '$progress' , completion_date = '$completion_date' ";  
            }
            
            
             else if(($destFile4 != ""))
            {
                $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , 
                  water_facility ,  seating_arrangement , pic2 , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' ,'$water_facility' , 
                '$seating_arrangement',  '$destFile4', '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities' , '$toilet_facility', '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' , water_facility = '$water_facility' , seating_arrangement = '$seating_arrangement',  pic2 = '$destFile4' , 
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established' , progress = '$progress' , completion_date = '$completion_date' ";  
            }
            
            
            
            
            else
            {
                  $sql="INSERT INTO `csc_mst`(`ulbid`, date, `area_csc`, `systems_provided`, staff_deployed , nodal_officer_name , nodal_officer_number , nodal_officer_desg , 
                  water_facility , seating_arrangement , other , printers_provided , scanners_provided ,news_facility, waiting_room ,printed_app ,board_placed ,other_facilities , toilet_facility , established , progress , completion_date) VALUES
                ('$ulbid','$date','$area_csc','$systems_provided','$staff_deployed' , '$nodal_officer_name' , '$nodal_officer_number',  '$nodal_officer_desg' , '$water_facility' ,
                '$seating_arrangement',  '$other' , '$printers_provided' ,'$scanners_provided' ,'$news_facility' ,'$waiting_room', '$printed_app','$board_placed','$other_facilities', '$toilet_facility' , '$established' , '$progress' , '$completion_date') 
                ON DUPLICATE KEY UPDATE `date` = '$date', `area_csc`= '$area_csc', systems_provided = '$systems_provided', staff_deployed = '$staff_deployed' , nodal_officer_name = '$nodal_officer_name' ,
                nodal_officer_number = '$nodal_officer_number' , nodal_officer_desg = '$nodal_officer_desg' ,   water_facility = '$water_facility' , seating_arrangement = '$seating_arrangement',
                other = '$other' , printers_provided = '$printers_provided', scanners_provided = '$scanners_provided' ,
				news_facility = '$news_facility', waiting_room = '$waiting_room', printed_app = '$printed_app', 
                board_placed = '$board_placed' , other_facilities = 'other_facilities' , toilet_facility = '$toilet_facility' , established = '$established' , progress = '$progress' , completion_date = '$completion_date'"; 
            }

		 $rs = mysqli_query($conn,$sql);
		 
		 if($rs)
		 {
		     echo "<script>alert('Record Added Successfully'); </script>";
		 }
		 
		 else
		 {
		     echo "<script>alert('Insertion Failed'); </script>";
		 }
		 
		}
		
		}
		else
		 {
		     echo "<script>alert('Insertion Failed'); </script>";
		 }
		 
		}
		
	
		$sql =$conn->prepare("select c.*,e.* from csc_mst c ,est_mst e where c.established = e.est_id and c.ulbid =?");
		$sql->bind_param("s",$ulbid);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $data['ulbid']=$row['ulbid'];
		    $data['date']=$row['date'];
		    $data['area_csc']=$row['area_csc'];
		    $data['systems_provided']=$row['systems_provided'];
		    $data['staff_deployed']=$row['staff_deployed'];
		    $data['nodal_officer_name']=$row['nodal_officer_name'];
		    $data['nodal_officer_number']=$row['nodal_officer_number'];
		    $data['nodal_officer_desg']=$row['nodal_officer_desg'];
		    $data['water_facility']=$row['water_facility'];
		    $data['seating_arrangement']=$row['seating_arrangement'];
		    $data['other']= $row['other'];
		    $data['front_view'] =  $row['front_view'];
		    $data['side_view'] =  $row['side_view'];
		    $data['long_view'] =  $row['long_view'];
		    $data['pic'] = $row['pic'];
		    $data['pic2'] = $row['pic2'];
		    
		    $data['printers_provided'] = $row['printers_provided'];
		    $data['scanners_provided'] = $row['scanners_provided'];
		    $data['news_facility'] = $row['news_facility'];
		    $data['waiting_room'] = $row['waiting_room'];
		    $data['printed_app'] = $row['printed_app'];
		    $data['board_placed'] = $row['board_placed'];
		    $data['other_facilities'] = $row['other_facilities'];
		    $data['toilet_facility'] = $row['toilet_facility'];
		    $data['established'] = $row['established'];
		    $data['progress'] = $row['progress'];
		    $data['completion_date'] = $row['completion_date'];
		}
		
		$sql->close();
		
	
		
		$sql =$conn->prepare("select * from est_mst");
		
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		     $est_list[$row['est_id']]=$row['est_desc'];
		}
		
		$sql->close();
		
		
	    $tpl->assign('year_list',$year_list);
	    
	    
	    $sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql->close();
		
	   /* $sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	    
	      
	     $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
		 $tpl->assign('user_type',$_SESSION['user_type']);
		 $tpl->assign('online_applications',$online_applications);
	    
	    mysqli_close($conn);
	    $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
	    $tpl->assign('est_list',$est_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('data',$data);
		$tpl->assign('token_id',$token_id);
		$tpl->display('csc.tpl');
		
	}
	else
	{
	
		
		echo "<script>window.location='index.php';</script>";
	}
?>