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
		require_once('prepare_connection.php');
	
		$sql='select service_id,service_name from services order by service_type,service_name';
		
		$sql=$conn->prepare("select service_id,service_name from services order by service_type,service_name");
		
		
		
		if($sql->execute())
		{
		    $rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
				$service_list[$row['service_id']]=$row['service_name'];
		}
		else
			printf("Errormessage: %s\n", $sql->error);	
		$sql->close();	
					
		if(isset($_POST['save']))
		{
		    
            if($token_id==$_POST['token']){
                
			foreach($service_list as $service_id=>$service_name)
			{
				$var="service_id__".$service_id;
				if (array_key_exists($var, $_POST))
				{
			
					   $status=1;
					   $user_id= mysqli_real_escape_string($conn,$_POST['user_id']);
					   $service_id= mysqli_real_escape_string($conn,$service_id);
					   
					   $sql = "insert into users_services(
					    user_id,
					    service_id,
					    status
					    ) values(
					   '".$user_id."',
					   '".$service_id."',
					   '".$status."'
					   ) 
					   ON DUPLICATE KEY UPDATE 
					   status='".$status."'";
					  
					   
					   //$sql->bind_param("ssi",$user_id,$service_id,$status);
					  
				}
				else
				{
				     $status=0;
				      $user_id= mysqli_real_escape_string($conn,$_POST['user_id']);
					   $service_id= mysqli_real_escape_string($conn,$service_id);
					   
					   $sql = "insert into users_services(
					    user_id,
					    service_id,
					    status
					    ) values(
					   '".$user_id."',
					   '".$service_id."',
					   '".$status."'
					   ) 
					   ON DUPLICATE KEY UPDATE 
					   status='".$status."'";
					   
				}
				//echo $sql;
				
				if(mysqli_query($conn,$sql))
				{
					$tpl->assign('class','alert alert-success display-hide');
					$tpl->assign('msg','Successfully Updated');
				}
				else
				{
					$tpl->assign('msg','alert alert-danger display-hide');
					$tpl->assign('msg','Unable to Update');
				}
			
			}
			
			$sql = $conn->prepare("insert into users_services(user_id,service_id,status)values(?,?,?)");
			$pwd = 'change_pwd';$status=1;
			$user_id= mysqli_real_escape_string($conn,$_POST['user_id']);
			$sql->bind_param("ssi",$user_id,$pwd,$status);
				$sql->execute();
			
			    $rs = $sql->get_result();
			$obj=new get_services($_SESSION['uid']);
		}
	}
		if(isset($_REQUEST['user_id']))
		{
		
			$sql =$conn->prepare("select user_name,user_mobile,user_email from users where user_id=?");
			$user_id= mysqli_real_escape_string($conn,$_REQUEST['user_id']);
			$sql->bind_param("s",$user_id);
			$sql->execute();
			
			    $rs = $sql->get_result();
				$row = $rs->fetch_assoc();
				$data['user_name']=$row['user_name'];
				$data['user_mobile']=$row['user_mobile'];
				$data['user_email']=$row['user_email'];
				$tpl->assign('data',$data);
				
			$sql->close();
	
			$sql =$conn->prepare("select service_id,status from users_services where user_id=?");
			$user_id= mysqli_real_escape_string($conn,$_REQUEST['user_id']);
			$sql->bind_param("s",$user_id);
			
			
			if($sql->execute())
			{
			    $rs=$sql->get_result();
				while($row = $rs->fetch_assoc())
				{
					$var="service_id__".$row['service_id'];
					$data_services[$var]=$row['status'];
				}
				$tpl->assign('data_services',$data_services);
			}
			else
				printf("Errormessage: %s\n", $sql->error);

			$tpl->assign('user_id_sel',$_REQUEST['user_id']);	
			
			$sql->close();
			
		}

		$sql =$conn->prepare("select user_id,user_name from users where ulbid=? and user_delete_status=? order by user_name");
		$user_delete_status=0;
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("si",$ulbid,$user_delete_status);
		
		if($sql->execute())
		{
		    $rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
				$user_list[$row['user_id']]=$row['user_name']." (".$row['user_id'].")";
		}
		
			
            /*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
            $ulbid = mysqli_real_escape_string($conn,$_SESSION['ulbid']);
    		$sql->bind_param("s",$ulbid);
    		$sql->execute();
    	    $rs=$sql->get_result();
    	    $row = $rs->fetch_assoc();*/
    	    $conn->close();
    	    
    	    
	     $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
			
				
		$tpl->assign('user_list',$user_list);	
		$tpl->assign('service_list',$service_list);
		
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('update_user_services.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>