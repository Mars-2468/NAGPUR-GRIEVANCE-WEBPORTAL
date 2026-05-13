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
		
	
		
		
		
		if(isset($_POST['save']))
		{
		
			if(!empty($_POST['check_list']))
			{
			    if($token_id==$_POST['token']){
			    
			    
			    
			    $sql=$conn->prepare("delete from service_doc_map where ulbid=?");
			    $sql->bind_param("s",$_SESSION['ulbid']);
			    $sql->execute();
			    foreach($_POST['check_list'] as $val)
			    {
			        $arr=explode("_",$val);
			        $cs_id=$arr[0];
			        $doc_id=$arr[1];
			        $mandatory_status="mytext";
			        $flag="1";
			        $ulbid=$_SESSION['ulbid'];
			        
			        
			        
			        
			       $sql=$conn->prepare("insert into service_doc_map(cs_id,doc_id,mandatory_status,flag,ulbid) values(?,?,?,?,?)");
			       $sql->bind_param("iisis",$cs_id,$doc_id,$mandatory_status,$flag,$_SESSION['ulbid']);
			       $sql->execute();
			       
			      
			    }
			    $tpl->assign('msg','Updated successfully');
			    
			} else {
			    
			    $tpl->assign('msg','Not Updated');
			}
			}
			else
			{
			    $tpl->assign('msg','Please check atleast one check box');
			}
	
		}
		
		// previous selected documents
		
	
		
	$sql=$conn->prepare("select * from service_doc_map where ulbid=?");
	$sql->bind_param("s",$_SESSION['ulbid']);
	$sql->execute();
	$rs=$sql->get_result();
	while($row =$rs->fetch_assoc())
	{
	  $selected_list[$row['cs_id']][$row['doc_id']]['string']="checked";  
	}
	$sql->close();	
		// standard service list
	
	$sql=$conn->prepare("select * from standard_services order by cs_desc");

	$sql->execute();
	$rs=$sql->get_result();
	while($row =$rs->fetch_assoc())
	{
	 $service_list[$row['cs_id']]=$row['cs_desc'];  
	}
	$sql->close();	
		
		
		
		
	
	
		
	$sql=$conn->prepare("select * from doc_mst where ulbid=? order by doc_desc");
	$sql->bind_param("s",$_SESSION['ulbid']);
	$sql->execute();
	$rs=$sql->get_result();
	while($row =$rs->fetch_assoc())
	{
	 $doc_list[$row['doc_id']]=$row['doc_desc']; 
	}
	$sql->close();
		
			
		$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql->close();
		

	
	    /*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",$_SESSION['ulbid']);
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	      
	      $users_count=$row['user_count'];
	      $tpl->assign('users_count',$users_count);
		
		$tpl->assign('selected_list',$selected_list);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('service_list',$service_list);	
		$tpl->assign('doc_list',$doc_list);	
		$tpl->assign('app_type',array('1'=>'Complaint','2'=>'Service'));		
		$tpl->assign('data',$data);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('sub_cat_list',$sub_cat_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('map_std_service_documents.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>