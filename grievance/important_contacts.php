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
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');
		
		
		
		if(isset($_POST['save']))
		{
		
		    if($token_id==$_POST['token']){
		    
		
			
			if($_POST['update_status']==0)
			{
			
			 
			 
			 $sql="insert into imp_contacts(dept_id,name,designation,mobile,ulbid) values(?,?,?,?,?)";
			 $query=$conn->prepare($sql);
			 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
			 $name=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['name']));
			 $dept_id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id']));
			 $designation=mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['designation'])));
			 $mobile=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile']));
			 $query->bind_param("issss",$dept_id,$name,$designation,$mobile,$ulbid);
			 
			 
			 }
			 else
			 {
			
			  
			 $sql="update imp_contacts set dept_id=?,name=?,designation=?,mobile=? where id=?";
			 $query=$conn->prepare($sql);
			 $id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['id']));
			 $name=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['name']));
			 $dept_id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['dept_id'])));
			 $designation=mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['designation'])));
			 $mobile=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['mobile']));
			 $query->bind_param("isssi",$dept_id,$name,$designation,$mobile,$id); 
			  
			  
			 }
			
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
		else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
			}
			
		}
		
		if(isset($_POST['sort_order']))
		{
		
			for($i=0;$i<=$_POST['cnt'];$i++)
			{
				$orderid="orderid".$i;
				$id="id".$i;
				
			 $sql="update imp_contacts set sort_order=? where id=?";
			 $query=$conn->prepare($sql);
			 $id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST[$id]));
			 $sort_order=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST[$orderid]));
			 
			 $query->bind_param("ii",$sort_order,$id);
			 $query->execute();
					 
					 
				
			}
				$tpl->assign('class','alert alert-success display-hide');
				$msg="Successfully Updated  Details";
				$tpl->assign('msg',$msg);
		}
		
		/* end */	
		
		$desg_count=1;
		
		$sql=$conn->prepare("select * from imp_contacts where ulbid=?  order by sort_order");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		while($row=$rs->fetch_assoc())
		{
		  $data[$row['id']]['id']=$row['id'];
		$data[$row['id']]['name']=$row['name'];
		$data[$row['id']]['designation']=$row['designation'];
		$data[$row['id']]['mobile']=$row['mobile'];
		$data[$row['id']]['dept_id']=$row['dept_id'];
		$data[$row['id']]['ulbid']=$row['ulbid'];
		$data[$row['id']]['sort_order']=$row['sort_order'];
		
		$desg_count_list[$desg_count]=$desg_count;
		$desg_count++;  
		}
		
		$sql=$conn->prepare("select dept_id,dept_desc from dept_imp_mst where ulbid=?  order by dept_id");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
		$rs=$sql->get_result();
		if($rs)
		{
		 	while($row=$rs->fetch_assoc())
		{ 
		    	$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		}

			
		$sql =$conn->prepare("SELECT * FROM `ulb_online_application_map` where ulbid=?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql->close();
		
		
		/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	    
	      
	     $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	     $tpl->assign('user_type',$_SESSION['user_type']);
		 $tpl->assign('online_applications',$online_applications);
		 $conn->close();
	    $tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('desg_count_list',$desg_count_list);
		$tpl->assign('ulb',$_SESSION['ulbid']);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('data',$data);	
		$tpl->assign('desg_list',$desg_list);	
		$tpl->assign('ward_list',$ward_list);	
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('important_contacts.tpl');
		
	}
	else
	{
	
		
		echo "<script>window.location='index.php';</script>";
	}