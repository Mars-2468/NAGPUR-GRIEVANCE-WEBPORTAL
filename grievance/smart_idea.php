<?php
require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		//include('prepare_connection.php');
		$conn=getconnection();		
		mysqli_set_charset($conn, "utf8mb4"); 

			$sql=$conn->prepare("SELECT sib.*,u.distid,u.ulbname,u.ulb_type,u.ulb_grade,u.ulbnametelugu,d.rdma FROM smart_idea_box sib,ulbmst u,Districtmst d 
	        where u.ulbid=sib.ulbid and u.distid=d.distid and sib.ulbid LIKE ?");
	        
	        
	        $ulbid = '%'.$_SESSION['ulbid'].'%';
	        $sql->bind_param("s",$ulbid);
	        
	        if($_SESSION['user_type']=='R')
		    {
		    $sql.=" and d.rdma='".$_SESSION['uid']."'";
		    }
		    $sql->execute();
	        $rs = $sql->get_result();
		
		    if($rs->num_rows > 0)
			{ 
				$field_info = $rs->fetch_fields();
				while($row = $rs->fetch_assoc())
				{
						foreach($field_info as $fi => $f) 
							
							$ideas_list[$row['id']][$f->name]=$row[$f->name];
							
				}
				       
					
			}else
			{  
			   $tpl->assign('fail',$msg);
			}	
	 
	   //echo "<pre>";print_r($ideas_list); echo "</pre>";die();
	 
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $online_applications['trade_application']=$row['trade_application'];
		  $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		$query->close();
		
	/*	$sql=$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid=?");
    		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    		$sql->execute();
    		$rs=$sql->get_result();
    		$row = $rs->fetch_assoc();
    		$sql->close();*/
    		
	     $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	     $conn->close();
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('online_applications',$online_applications);
        $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('ideas_list',$ideas_list);
		$tpl->assign('data',$data);
		$tpl->assign('cnt',1);
		$tpl->assign('num_emp',$num_emp);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('smart_idea.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
		
	}
?>