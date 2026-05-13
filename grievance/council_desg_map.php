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
		
		
	//echo $_SESSION['ulbid'];		
	if(isset($_POST['save']))
		{
			if($token_id==$_POST['token']){
		
			 
		$ward_id=$_POST['chairman_ward'];	
		$sql= "update council_mst set chairman_status='1' where ward_id=? and ulbid=?";
		$query=$conn->prepare($sql);
		$query->bind_param("ss",$ward_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$result=$query->execute();
		
		$wards_id=$_POST['wise_chairman_ward'];	
		$sql2= "update council_mst set wise_chairman_status='1' where ward_id=? and ulbid=?";
		$query2=$conn->prepare($sql2);
		$query2->bind_param("ss",$wards_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$result2=$query2->execute();
			
		if($result)
		{
    		$ward_id=$_POST['chairman_ward_old'];
    		if($_POST['chairman_ward'] != $ward_id){
        		$sql3= "update council_mst set chairman_status='' where ward_id=? and ulbid=?";
        		$query3=$conn->prepare($sql3);
        		$query3->bind_param("ss",$ward_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
        		$result3=$query3->execute();
    		}
			
    		$wards_id=$_POST['wise_chairman_ward_old'];
    		if($_POST['wise_chairman_ward'] != $wards_id){
        		$sql4= "update council_mst set wise_chairman_status='' where ward_id=? and ulbid=?";
        		$query4=$conn->prepare($sql4);
        		$query4->bind_param("ss",$wards_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
        		$result4=$query4->execute();
    		}
    		$tpl->assign('class','alert alert-success display-hide');
			$tpl->assign('msg','Saved Successfully ');
		}
		else
		{
			$tpl->assign('msg','alert alert-danger display-hide');
			$tpl->assign('msg','Unable to Process, Please try again');
		}	
			
			
		} else
		{
			$tpl->assign('msg','alert alert-danger display-hide');
			$tpl->assign('msg','Unable to Process, Please try again');
		}	
			
		}
		
		/* end */	
		
		$data['chairman_status']=0;
	    $data['wise_chairman_status']=0;
		
	
	    $sql="select c.ward_id,ward_desc,chairman_status,wise_chairman_status from ward_mst w,council_mst c where c.ward_id=w.ward_id and c.ulbid=? order by c.ward_id ";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $ward_list[$row['ward_id']]=$row['ward_desc'];
		if($data['chairman_status']==0)
		{
			if($row['chairman_status']==1)
			{
		$data['chairman_status']=$row['ward_id'];
			}
		}
		
		if($data['wise_chairman_status']==0)
		{
			if($row['wise_chairman_status']==1)
			{
			$data['wise_chairman_status']=$row['ward_id'];
			}
		}
		}
		$query->close();

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
		
		    /*$sql=$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid=?");
    		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
    		$sql->execute();
    		$rs=$sql->get_result();
    		$row = $rs->fetch_assoc();
    		$sql->close();*/
	      
	      
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	
	$tpl->assign('user_type',htmlspecialchars(strip_tags($_SESSION['user_type'])));
		
		$tpl->assign('online_applications',$online_applications);
			
		$conn->close();
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('data',$data);
		$tpl->assign('desg_list',$desg_list);	
		$tpl->assign('ward_list',$ward_list);	
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('council_desg_map.tpl');
		
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
	}