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
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();	
		include('prepare_connection.php');
	
if(isset($_POST['save']))
		{
		    if($token_id==$_POST['token']){
				
		$sql ="update add_edition set status=? where id=?";
		$status=1;
		$id=htmlspecialchars(strip_tags($_POST['edition_no']));
        $query=$conn->prepare($sql);
        $query->bind_param("ii",$status,$id);
		$rs=$query->execute();
		
		$sql ="update add_edition set status=? where id!=?";
		$status=0;
		$id=htmlspecialchars(strip_tags($_POST['edition_no']));
        $query=$conn->prepare($sql);
        $query->bind_param("ii",$status,$id);
		$res=$query->execute();
		
		$sql ="update add_content set status=? where edition_no=?";
		$status=1;
		$edition_no=htmlspecialchars(strip_tags($_POST['edition_no']));
        $query=$conn->prepare($sql);
        $query->bind_param("ii",$status,$edition_no);
		$resl=$query->execute();
		
		$sql ="update add_content set status=? where edition_no!=?";
		$status=0;
		$edition_no=htmlspecialchars(strip_tags($_POST['edition_no']));
        $query=$conn->prepare($sql);
        $query->bind_param("ii",$status,$edition_no);
		$reslt=$query->execute();
		
		
			if( $rs && $res && $resl && $reslt )
			{
					$tpl->assign('class','alert alert-success display-hide');
					$msg="Successfully Saved";
				}
				else
				{
					$tpl->assign('msg','alert alert-danger display-hide');
					$msg="Unable to save";
					}
				
				$tpl->assign('msg',$msg);
		}

		}
		

		
		$sql ="SELECT * FROM add_edition where ulbid=?";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $edition_list[$row['id']]['edition_no']=$row['edition_no'];
		  $edition_list[$row['id']]['status']=$row['status'];
		}
		$query->close();
		
		
		
		
		    /*$sql=$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid=?");
    		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    		$sql->execute();
    		$rs=$sql->get_result();
    		$row = $rs->fetch_assoc();
    		$sql->close();*/
	        $users_count=$row['user_count'];
	        $tpl->assign('users_count',$users_count);
	     
			
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);			
		$tpl->assign('edition_list',$edition_list);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('select_edition.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
		
	}
?>