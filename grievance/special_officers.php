<?php
require "config.php";
ini_set('display_errors',0);
require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		 $sql ="select ward_id from council_mst where ulbid=? and cid=?";
		         
		         
		         
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $cid = "2";
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("ss",$ulbid,$cid);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		
		 
		 $nr1 = $query->num_rows;
		if($nr1 > 0)
		{
		
		//header('location:add_council.php');
		echo "<script>window.location='add_council.php';</script>";
		}
		else
		{
		
		
		if(isset($_POST['save']))
		{
		
		
		
		if(is_uploaded_file($_FILES['f1']['tmp_name']))
		{
		
				$target_dir= "special_officers/";
		
				$file = $_FILES["f1"]["name"];
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				
				$ext_array = array("php","css","js","doc","docx","pdf");
				$ext = pathinfo($file, PATHINFO_EXTENSION);
        				
        				if(in_array($ext,$ext_array))
        				{
        				    die('Image extension is not accepted');
        				}
        				
				$newfile =time().$_SESSION['ulbid'].".".$ext;
				
				
		 		echo $target_file = $target_dir. $newfile;
		
		
		 		if(move_uploaded_file($_FILES["f1"]["tmp_name"], $target_file))
		 		{
		 		    
		 		    
		 		    	        $file_info = new finfo(FILEINFO_MIME_TYPE);
                               $mime_types_array = array('image/jpeg','image/gif','image/bmp','image/gif','image/png');
                               $finopath = $target_file;
		                       $mime_type = $file_info->buffer(file_get_contents($finopath));
		                       if(!in_array($mime_type,$mime_types_array))
                                                {
                                                    unlink($finopath);
                                                    die('Invalid file type');
                                                    
                                                   
                                                }
                                                else
                                                {
                                                    $target_file="http://municipalservices.in/".$target_file;
                                                }
		 		    
		 		    
		 		    
                   
                   		
                   	
                   
                  }
                  else{
                  $target_file=$_POST['previous_image'];
                  }
                  
                  //$target_file='';
			
			 $sql ="insert into special_officers(
			ulbid,
			name,
			designation,
			mobile,
			land_line,
			email,
			img_url) 
			values (?,
			?,
			?,
			?,
			?,
			?,
			?)ON DUPLICATE KEY UPDATE 
			name=?,
			designation=?,
			mobile=?,
			land_line=?,
			email=?,
			img_url=?
			";
			
			
			     $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			     $name = htmlspecialchars(strip_tags($_POST['name']));
			     $designation = mysqli_real_escape_string($conn,$_POST['designation']);
			     $mobile = htmlspecialchars(strip_tags($_POST['mobile']));
			     $land_line = htmlspecialchars(strip_tags($_POST['land_line']));
			     $email = htmlspecialchars(strip_tags($_POST['email']));
			     $target_file = $target_file;
			     
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("sssiissssiiss",$ulbid,$name,$designation,$mobile,$land_line,$email,$target_file,$name,$designation,$mobile,$land_line,$email,$target_file);
        		
			
			
			if($query->execute())
			{
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Saved Successfully ');
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
			}
		}
		}
		
		
		
		
		
		 $sql ="select * from special_officers where ulbid=?";
		 
		 
		 
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
		 
	 
		while($row = $rs->fetch_assoc())
		{
		
		
		$data['name']=$row['name'];
		$data['designation']=$row['designation'];
		$data['mobile']=$row['mobile'];
		$data['img_url']=$row['img_url'];
		$data['land_line']=$row['land_line'];
		$data['email']=$row['email'];
		
		
		}
		
		
		
			
		 
		$tpl->assign('ulb',$_SESSION['ulbid']);
	
		$tpl->assign('data',$data);	
		
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('special_officers.tpl');
		
		}
		
	}
	else
	{
		/*$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
		
		
	}