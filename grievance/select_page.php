<?php
require "config.php";
ini_set('display_errors',0);
require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		
		$sql ="select ward_id from council_mst where ulbid=? and cid=?";
		
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $cid = 2;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("si",$ulbid,$cid);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		
		
		
		$nr1 = $query->num_rows;
		
		$sql ="select ulbid from special_officers where ulbid=?";
		
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		
		
	
		$nr2 = $query->num_rows;
		if($nr1 > 0)
		{
		
		echo "<script>window.location='add_council.php';</script>";
		}
		else if($nr2)
		{
		
		echo "<script>window.location='special_officers.php';</script>";
		}
		else
		{
		
		$tpl->assign('ulb',$_SESSION['ulbid']);
	
		$tpl->assign('data',$data);	
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('select_page.tpl');
		
		}
		
		$conn->close();
		
	}
	else
	{
		
		
		
		echo "<script>window.location='index.php';</script>";
		
	}