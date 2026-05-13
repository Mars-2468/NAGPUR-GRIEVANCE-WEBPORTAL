<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	require_once('csrf.class.php');
    $csrf = new csrf();
	$tpl=new Smarty();

	
	$token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);
    
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
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
		if(isset($_POST['save']))
		{
		    if($token_id==$_POST['token']){

			 	$target_dir = "media/";

			
				
				
				$filename=$_FILES["img_url"]["name"];
				
				if(is_uploaded_file($_FILES["img_url"]["tmp_name"]))
				{
				
				$file = $_FILES["img_url"]["name"];
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				
				$ext_array = array("php","css","js","doc","docx","pdf");
				if(in_array($ext,$ext_array))
        				{
        				    die('Image extension is not accepted');
        				}
				
				$newfile =time().$_SESSION['ulbid'].".".$ext;
				$target_file = $target_dir. $newfile;
		                if(move_uploaded_file($_FILES["img_url"]["tmp_name"], $target_file))
		                {
		                    //echo "file uploaded";
		                }
		                else
		                {
		                    echo $_FILES["img_url"]["error"];
		                }
                   	        // $target_file="http://municipalservices.in/".$target_file;
                   	        $target_file=base_url() . "/grievance/".$target_file;
                                }
                                else
                                {
                                $target_file=$_POST['previous_image'];
                                }
                                
                                //echo $target_file;
                                
                               
				
		$edition_no=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$_POST['edition_no']));	
		$description=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$_POST['description']));
		//$description=$_POST['description'];
		$img_url=$target_file;	
		$id=$_REQUEST['id'];	
		
		 $sql ="update add_content set edition_no='".$edition_no."',description='".$description."',img_url='".$img_url."' where id='".$id."' and ulbid='".$_SESSION['ulbid']."'";
		if(mysqli_query($conn,$sql))
		{
		       $class='alert alert-success display-hide';
				$msg="Successfully Updated  Details";
		}
		else
		{
			$msg="Unable to insert";
		    $tpl->assign('msg',$msg);
			   
		}
		
		}

		}
		
		if(isset($_REQUEST['id']) || isset($_REQUEST['save']))
		{

			
			
		$sql=$conn->prepare("SELECT * FROM add_edition where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   $edition_list[$row['id']]=$row['edition_no'];
		}	
			
			
		
		$id=$_REQUEST['id'];	
		$sql=$conn->prepare("select * from add_content where ulbid=? and id=?");
		$sql->bind_param("si",htmlspecialchars(strip_tags($_SESSION['ulbid'])),$id);
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		  	    $data['id']=$row['id'];
				$data['edition_no']=$row['edition_no'];
				$data['description']=$row['description'];
				$data['img_url']=$row['img_url'];
		}	
			
			
		}
		else
		{
			set_flash($msg,$class);
			header('location:addcontent.php');
			exit;
		}
		
		
				
		$tpl->assign('data',$data);
		$tpl->assign('edition_list',$edition_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		
		$flash = get_flash();		
		$tpl->assign("flash", $flash); 
		$tpl->display('update-enew-content.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>