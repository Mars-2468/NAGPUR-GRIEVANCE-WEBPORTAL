<?php
require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	   //  session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		if(isset($_POST['save']))
		{
			
			
		
		    $sql="update about_municipality set description='".mysqli_real_escape_string($conn,$_POST['description'])."', description_marathi='".mysqli_real_escape_string($conn,$_POST['description_marathi'])."', desc2='".mysqli_real_escape_string($conn,$_POST['desc2'])."', desc2_marathi='".mysqli_real_escape_string($conn,$_POST['desc2_marathi'])."' where ulbid='".$_SESSION['ulbid']."'";
            // $sql ="insert into about_municipality(ulbid,description,description_marathi) values ('".strip_tags($_SESSION['ulbid'])."','".mysqli_real_escape_string($conn,$_POST['description'])."','".mysqli_real_escape_string($conn,$_POST['description_marathi'])."') ON DUPLICATE KEY UPDATE ulbid='".strip_tags($_SESSION['ulbid'])."',description='".mysqli_real_escape_string($conn,$_POST['description'])."',description_marathi='".mysqli_real_escape_string($conn,$_POST['description_marathi'])."'";
			 
			
			if(mysqli_query($conn,$sql))
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
		 $sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".strip_tags($_SESSION['ulbid'])."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
	$sql ="select description,description_marathi,desc2,desc2_marathi from about_municipality where ulbid='".strip_tags($_SESSION['ulbid'])."'";
		$rs = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rs);
		$description = $row['description'];
		$administrative_desc = $row['desc2'];
		//print_r($row['description_marathi']);exit();
		$description_marathi = $row['description_marathi'];
		$administrative_desc_marathi = $row['desc2_marathi'];
		  $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
		
       mysqli_close($conn);
		
		
		
	//	print_r($online_applications);
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('description',$description);
		$tpl->assign('administrative_desc',$administrative_desc);
		$tpl->assign('description_marathi',$description_marathi);
		$tpl->assign('administrative_desc_marathi',$administrative_desc_marathi);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);	
		$tpl->assign('dept_list',$dept_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('about-municipality.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>