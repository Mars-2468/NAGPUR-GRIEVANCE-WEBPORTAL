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
		
		require_once('prepare_connection.php');
		$conn=getconnection();
		
		$errors=0;
		$error_mst="";
		
		if(isset($_POST['save']))
		{
		    if($token_id==$_POST['token']){
		    
		    $username=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['user_name']));
		    $useremail=strip_tags(preg_replace('/[^A-Za-z0-9.@_]/', ' ', $_POST['user_email']));
		     
		    if(preg_match('/[0-9]{10}$/',$_POST['user_mobile']))
		    {
		        $usermobile=$_POST['user_mobile'];
		    }
		    else
		    {
		        $errors++;
		        $error_mst.=" Invalid mobile number <br>";
		    
		    }
		    
			if($errors==0)
			{
			$sql =$conn->prepare("update users set user_name=?,user_email=?,user_mobile=? where user_id=? and ulbid=?");
			$sql->bind_param("sssss",$username,$useremail,$usermobile,$_SESSION['uid'],$_SESSION['ulbid']);
			if($sql->execute())
			{
			    $tpl->assign('msg','Successfully Updated');
			}
			else
			{
			    $tpl->assign('msg','Unable to Process, Please try again');
			}
			$sql->close();
			
			
			if($_POST['change_pwd']=='on')
			{
				$sql.=",user_pwd=PASSWORD('".$_POST['user_pwd2']."')";
				
				$sql =$conn->prepare("update users set user_pwd=PASSWORD(?) where user_id=? and ulbid=?");
    			$sql->bind_param("sss",htmlspecialchars(strip_tags($_POST['user_pwd2'])),htmlspecialchars(strip_tags($_SESSION['uid'])),htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    			if($sql->execute())
    			{
    			    $tpl->assign('msg','Successfully Updated');
    			}
    			else
    			{
    			    $tpl->assign('msg','Unable to Process, Please try again');
    			}
    			$sql->close();
    				
    				
    			}
			}
			else
			{
			    $tpl->assign('msg','Unable to Process, Please try again');
			}
		} 
		else {
		    
		    $tpl->assign('msg','Unable to Process, Please try again');
		}

		}

	
		
		$sql ="select user_name,user_mobile,user_email from users where user_id=?";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['uid'])));
		
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			$row = $rs->fetch_assoc();
			$data['user_name']=$row['user_name'];
			$data['user_mobile']=$row['user_mobile'];
			$data['user_email']=$row['user_email'];
		}
		
			
		$query->close();

       
		/*$sql=$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		$row = $rs->fetch_assoc();
		$sql->close();*/
		$conn->close();
		
		
        $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
				
		$tpl->assign('data',$data);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('update_profile.tpl');
	}
	else
	{
	
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>