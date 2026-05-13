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
	    // session_regenerate_id();
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
		$sql=$conn->prepare("select ulbid from special_officers where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		$nr2=$rs->num_rows;
		
		
		if($nr2 > 0)
		{
		
		echo "<script>window.location='special_officers.php';</script>";
		}
		else
		{
		
		if(isset($_POST['save']))
		{
		
		if($token_id==$_POST['token']){
		
		$dat=date('dmy');
		$target_dir= "council/".$_SESSION['ulbid']."/";
		if (!file_exists($target_dir)) {
					mkdir($target_dir, 0777, true);
					$target_dir= "council/".$_SESSION['ulbid']."/".strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."/";
					if (!file_exists($target_dir)) {
					mkdir($target_dir, 0777, true);
					}
					
				}
				else
				{
				$target_dir= "council/".$_SESSION['ulbid']."/".strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['ward_id']))."/";
					if (!file_exists($target_dir)) {
					mkdir($target_dir, 0777, true);
					}
				}
				
				if($_FILES["img_url"]["name"]!="")
				{
				        $ext_array = array("php","css","js","doc","docx","pdf");
				        
        				$file = $_FILES["img_url"]["name"];
        				$ext = pathinfo($file, PATHINFO_EXTENSION);
        				
        				if(in_array($ext,$ext_array))
        				{
        				    die('Image extension is not accepted');
        				}
        				
        				$file_info = new finfo(FILEINFO_MIME_TYPE);
                        $mime_types_array = array('image/jpeg','image/gif','image/bmp','image/gif','image/png');
        				
        				$newfile =time().$_SESSION['ulbid'].$_POST['ward_id'].".".$ext;
        				$target_file = $target_dir. $newfile;
		                if(move_uploaded_file($_FILES["img_url"]["tmp_name"], $target_file))
		                {
		                     $finopath = $target_file;
		                    
					        $mime_type = $file_info->buffer(file_get_contents($finopath));
					       
					        if(!in_array($mime_type,$mime_types_array))
                                                {
                                                    unlink($finopath);
                                                    die('Invalid file type');
                                                    $target_file =$_POST['newimg'];
                                                   
                                                }
                                                else
                                                {
                                                    $target_file="https://" . $_SERVER['HTTP_HOST'] . "/csms/".$target_file;
                                                }
					                        
					                        
					                        
		                    
		                }
		                else
		                {
		                    $target_file =$_POST['newimg'];
		                }
                   	        
                }else
                {
                $target_file =$_POST['newimg'];

                }
                // print_r($target_file);die;
                //$target_file='';
                                
  
			$ward_id=strip_tags(preg_replace('/[^A-Za-z0-9]/','',$_POST['ward_id']));
			$cid = strip_tags(preg_replace('/[^A-Za-z0-9]/','',$_POST['cid']));
			$name= strip_tags(preg_replace('/[^A-Za-z0-9]/','',$_POST['name']));
			$name_marathi= strip_tags(preg_replace('/[^A-Za-z0-9]/','',$_POST['name_marathi']));
			$designation= strip_tags(preg_replace('/[^A-Za-z0-9]/','',$_POST['designation']));
			$mobile= strip_tags(preg_replace('/[^A-Za-z0-9]/','',$_POST['mobile']));
			$party= strip_tags(preg_replace('/[^A-Za-z0-9]/','',$_POST['party']));
			$img_url= $target_file;
			
			print_r($_POST);exit();
			
		$sql= "insert into council_mst(ward_id,cid,name,name_marathi,designation,mobile,party,img_url,ulbid) values(?,?,?,?,?,?,?,?,?)";
		$query=$conn->prepare($sql);
		$query->bind_param("sisssssss",$ward_id,$cid,$name,$name_marathi,$designation,$mobile,$party,$img_url,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$result=$query->execute();	
			
		if($result)
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
		
		/* end */	
		if(isset($_POST['ward_id']))
		{
			 	
		
				
				
		$ward_id=strip_tags(preg_replace('/[^A-Za-z0-9]/','',$_POST['ward_id']));		
				
		$sql=$conn->prepare("select * from council_mst where ward_id=? and ulbid=?");
		$sql->bind_param("ss",$ward_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		$tot_row=$rs->num_rows;		
		$field_info =$rs->fetch_fields();
		$row=$rs->fetch_assoc();
				
			
				$tpl->assign('ward_id',$row['ward_id']);
				$tpl->assign('name',$row['name']);
				$tpl->assign('name_marathi',$row['name_marathi']);
				$tpl->assign('designation',$row['designation']);
				$tpl->assign('banner',$_SESSION['banner']);
			    $tpl->assign('mobile',$row['mobile']);
			    $tpl->assign('main_icons',$obj->main_icons);
				$tpl->assign('party',$row['party']);
				$tpl->assign('img_url',$row['img_url']);
			    $tpl->assign('ward_id_sel',$_POST['ward_id']);
			
		
		}	
		
		 
		
		$sql ="select ward_id,ward_desc from ward_mst where ulbid=? order by ward_id";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
			$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		$query->close();
		

		
		
		$sql="select * from council_mst where ulbid=? and cid='2'";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		$data[$row['id']]['id']=$row['id'];
		$data[$row['id']]['ward_id']=$row['ward_id'];
		$data[$row['id']]['name']=$row['name'];
		$data[$row['id']]['name_marathi']=$row['name_marathi'];
		$data[$row['id']]['designation']=$row['designation'];
		$data[$row['id']]['mobile']=$row['mobile'];
		$data[$row['id']]['img_url']=$row['img_url'];
		$data[$row['id']]['ward_id']=$row['ward_id'];
		$data[$row['id']]['ulbid']=$row['ulbid'];
		}
		$query->close();
		
		
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $online_applications['trade_application']=$row['trade_application'];
		  $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		$query->close();
		
	/*	$sql=$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid=?");
    	$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    	$sql->execute();
    	$rs=$sql->get_result();
    	$row = $rs->fetch_assoc();
    	$sql->close();*/
	      
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
		mysqli_close($conn);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('online_applications',$online_applications);
		
		$tpl->assign('data',$data);
		$tpl->assign('desg_list',$desg_list);	
		$tpl->assign('ward_list',$ward_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('add_council.tpl');
	}
		
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
	}