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
		//require_once('connection.php');
		require_once('prepare_connection.php');
		//$conn=getconnection();
		
		if(isset($_POST['save']))
		{
		    
		    
		    
		    if($token_id==$_POST['token']){
		        
		    $errors=0;
		    if (preg_match("/[a-zA-Z0-9_]+$/", $_POST['user_name']))
		    {
		        $username=$_POST['user_name'];
		    }
		    else
		    {
		        $errors++;
		        $msg="Invalid User Name";
		       
		    }
		    
		    /*if(preg_match("/[0-9]{10}+$/", $_POST['user_mobile']))
		    {
		        $user_mobile=$_POST['user_mobile'];
		    }
		    else
		    {
		        $errors++;
		        $msg.="<br> Invalid Mobile Number";
		        
		    }*/
		    
		    
		    if(preg_match("/[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $_POST['user_email']))
		    {
		        $user_email=$_POST['user_email'];
		    }
		    else
		    {
		        $errors++;
		        $msg.="<br> Invalid Email Address";
		        
		    }
		    
		    $tpl->assign('msg',$msg);
		    
		    
		    if($errors==0)
		    {
		    
		
		   
		   $sql =$conn->prepare("update users set user_name=?,user_email=? where user_id=? and ulbid=?");
		   $sql->bind_param("sssss",htmlspecialchars(strip_tags($_POST['user_name'])),htmlspecialchars(strip_tags($_POST['user_email'])),htmlspecialchars(strip_tags($_POST['user_id'])),htmlspecialchars(strip_tags($_SESSION['ulbid'])));
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
			    
			    
		        $password2=sha1($_POST['fk']);
		     
		        $sql ="update users set user_pwd=PASSWORD('".$password2."') where user_id='".$_POST['user_id']."' and ulbid='".$_SESSION['ulbid']."'";
		       
		        if(mysqli_query($conn,$sql))
		        {
		            $tpl->assign('msg','Successfully Updated');
		        }
		        else
		        {
		            $tpl->assign('msg','Unable to Process, Please try again');
		        }
		        
				
			   /*$sql =$conn->prepare("update users set user_pwd=PASSWORD(?) where user_id=? and ulbid=?");
    		   $sql->bind_param("sss",$password2,$_POST['user_id'],$_SESSION['ulbid']);
    		   if($sql->execute())
    		   {
    		      
    		       $tpl->assign('msg','Successfully Updated');
    		   }
    		   else
    		   {
    		       $tpl->assign('msg','Unable to Process, Please try again');
    		   }
    		   $sql->close();*/
			}
			
			
		    }
		}
		
		}
		if(isset($_REQUEST['user_id']))
		{
			
			
			if(preg_match("/[0-9a-zA-Z_]+$/", $_REQUEST['user_id']))
		    {
		        
		        $user_id=$_REQUEST['user_id'];
		        $sql=$conn->prepare("select user_name,user_mobile,user_email from users where user_id=?");
			    $sql->bind_param("s",htmlspecialchars(strip_tags($user_id)));
			    $sql->execute();
			    
    		/*	if($sql->num_rows()==1)
    			{*/
    			    $rs=$sql->get_result();
    				$row = $rs->fetch_assoc();
    				$data['user_name']=$row['user_name'];
    				$data['user_mobile']=$row['user_mobile'];
    				$data['user_email']=$row['user_email'];
    				
    				$tpl->assign('data',$data);
    			/*}
    			else
    				$tpl->assign('msg','User Does not Exist');*/
    				
    				$sql->close();
		        
		        
		    }
		    else
		    {
		        
		        $tpl->assign('msg','Invalid user id');
		        
		    }
			
			
			
			
				
			$tpl->assign('user_id_sel',$_REQUEST['user_id']);	
			
		}
		
		
		
		


		
		
		$emp_delete_status=0;
		$sql=$conn->prepare("select user_id,user_name from users where ulbid=? and user_delete_status=? order by user_name");
		
		$sql->bind_param("si",htmlspecialchars(strip_tags($_SESSION['ulbid'])),$emp_delete_status);
		
		
		
		
		
		if($sql->execute())
		{
		    $rs = $sql->get_result();
			while($row = $rs->fetch_assoc())
				$user_list[$row['user_id']]=$row['user_name']." (".$row['user_id'].")";
		}
		else
			printf("Errormessage: %s\n", $sql->error());
			$sql->close();
					
		   $tpl->assign('user_list',$user_list);	
		
		/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();*/
	    $conn->close();
	    
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
		
	    $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('update_user.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>