<?php
	require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	require_once('csrf.class.php');
    $csrf = new csrf();
	
	$token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);
    
	function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	}
	
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
			
			$sql=$conn->prepare("select * from notification_mst where ulbid=? and id=?");
			$id=htmlspecialchars(strip_tags($_REQUEST['id']));
			$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
			$sql->bind_param("si",$ulbid,$id);
			$sql->execute();
			$rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
			{
				
				$data['id']=$row['id'];
				$data['date']=$row['date'];
				$data['title']=$row['title'];
				$data['title_marathi']=$row['title_marathi'];
				$data['description']=$row['description'];
				$data['description_marathi']=$row['description_marathi'];
				$data['photo']=$row['photo'];
			}	
			
		}else{
			
			header('location:add_notification.php');
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
		$tpl->display('update_notification.tpl');
		
	}else{		
		echo "<script>window.location='index.php';</script>";
	}
