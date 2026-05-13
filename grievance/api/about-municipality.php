<?php
    date_default_timezone_set('Asia/Calcutta');
    ini_set('display_errors',1);
	require_once('../Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']) && $_SESSION['ip_address']==$_SERVER['REMOTE_ADDR'] && $_SESSION['user_agent']== $_SERVER['HTTP_USER_AGENT'])
	{
	    
	    session_regenerate_id();
		require_once('../get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('../prepare_connection.php');
		if(isset($_POST['save']))
		{
		
		
		    
           $sql ="insert into about_municipality(ulbid,description) values (?,?) ON DUPLICATE KEY UPDATE ulbid=?,description=? ";
				
			$ulbid=strip_tags($_SESSION['ulbid']);
			$description=mysqli_real_escape_string($conn,strip_tags($_POST['description']));
			
			$query=$conn->prepare($sql);
			$query->bind_param("ssss",$ulbid,$description,$ulbid,$description);
			
			if($query->execute())
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
		 $sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		 
		 $ulbid=strip_tags($_SESSION['ulbid']);
		 
		 $query=$conn->prepare($sql);
		 
		 $query->bind_param("s",$ulbid);
		 
		
		
		if(!$query->execute())
            {
            echo "Query not executed 2";
            }
           $rs2=$query->get_result();
           
		while($row=$rs2->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
	$sql ="select description from about_municipality where ulbid=?";
	    
	    $ulbid=strip_tags($_SESSION['ulbid']);
		 
		 $query=$conn->prepare($sql);
		 
		 $query->bind_param("s",$ulbid);
		 
		//$rs =mysqli_query($conn,$sql);
		
		if(!$query->execute())
            {
            echo "Query not executed 3";
            }
            
           $rs3=$query->get_result();
		    //$rs = mysqli_query($conn,$sql);
		    
		    $row =$rs3->fetch_assoc();
		
		  $sql ="select COUNT(id) as user_count from login_details where type= ? and ulbid like ? "; 
		  
		  $type='1';
		  $ulbid="%".$_SESSION['ulbid']."%";
		  
		  $query=$conn->prepare($sql); 
		  $query->bind_param("is",$type,$ulbid);
		    
		    if(!$query->execute())
            {
            echo "Query not executed 4";
            }
            
           $rs4=$query->get_result();
	       //$rs = mysqli_query($conn,$sql);
	       $row = $rs4->fetch_assoc();
	      
	      $users_count=$row['user_count'];
	      $tpl->assign('users_count',$users_count);
		
            mysqli_close($conn);
		
		
		

	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('description',$row['description']);		
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