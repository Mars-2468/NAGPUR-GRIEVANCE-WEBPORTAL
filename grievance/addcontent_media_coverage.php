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
		include('prepare_connection.php');
		$conn=getconnection();		
		if(isset($_POST['save']))
		{

			 	$target_dir = "media/";

				$target_file1 = $target_dir . $_FILES["img_url"]["name"];
				
				
				$filename=$_FILES["img_url"]["name"];
				
				
				move_uploaded_file($_FILES["img_url"]["tmp_name"], $target_file1);
				
				
				
			 $sql ="insert into add_content (edition_no,description,img_url,ulbid) values(?,?,?,?)";
			 
			 $edition_no = htmlspecialchars(strip_tags($_POST['edition_no']));
			 $description = htmlspecialchars(strip_tags($_POST['description']));
			 $target_fiel1 = $target_file1;
			 $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			 $query=$conn->prepare($sql);
		     $query->bind_param(ssss,$edition_no,$description,$target_fiel1,$ulbid);
			
			
			if($query->execute())
			{
				
			
				$tpl->assign('class','alert alert-success display-hide');
				$msg="Successfully Updated  Details";
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$msg="Uable to insert   ".mysqli_error();
			}
			$tpl->assign('msg',$msg);
			$query->close();

		}

		$sql="SELECT * FROM add_edition";
		$query=$conn->prepare($sql);
		$query->execute();
		$rs=$query->get_result();
		
    		
		while($row = $rs->fetch_assoc())
		{
			$edition_list[$row['id']]=$row['edition_no'];
		}	
		
		$query->close();
		
		
	
				
		
		$tpl->assign('edition_list',$edition_list);
		$tpl->assign('logo',htmlspecialchars(strip_tags($_SESSION['logo'])));
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',htmlspecialchars(strip_tags($_SESSION['user_name'])));
		$tpl->assign('uid',htmlspecialchars(strip_tags($_SESSION['uid'])));
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',htmlspecialchars(strip_tags($_SESSION['banner'])));
		$tpl->display('addcontent_media_coverage.tpl');
	}
	else
	{

		
		echo "<script>window.location='index.php';</script>";
	}
?>