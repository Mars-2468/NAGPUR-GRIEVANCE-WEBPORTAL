<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	date_default_timezone_set('Asia/Calcutta');
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');		
		
		
		
		
		$sql ="select * from category3_mst where cs_type_id=? and ulbid=?";
		
		$cs_type_id = 2;
		$ulbid = $_SESSION['ulbid'];
		$query=$conn->prepare($sql);
		$query->bind_param("is",$cs_type_id,$ulbid);
        $query->execute();
        $rs=$query->get_result();
		
		
		while($row = $rs->fetch_array())
		{
			if($row['fee_type_id']==1){$row['variable']=$row['app_fee'];}else{$row['variable']=$row['fee_desc'];}
			if($row['fin_impl']==1){$row['fin_impl']='YES';}else{$row['fin_impl']='NO';}
			$data[$row['cs_id']]['dept_id']=$row['dept_id'];
			$data[$row['cs_id']]['comp_desc']=$row['comp_desc'];
			$data[$row['cs_id']]['telugu_description']=$row['telugu_description'];
			$data[$row['cs_id']]['cutt_of_time']=$row['cutt_of_time'];
			
			
			
			$data[$row['cs_id']]['app_fee']=$row['variable'];
			
			
			
			$data[$row['cs_id']]['fine_per_day']=$row['fine_per_day'];
			$data[$row['cs_id']]['fin_impl']=$row['fin_impl'];
			$data[$row['cs_id']]['sp_id']=$row['sp_id'];
			
		}
		
	
		

	$sql =$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=? order by ward_desc ASC");
		
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		   	$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		
		$sql->close();	
	

			
	$sql= $conn->prepare("select dept_id,dept_desc from dept_mst where ulbid=?");	
	$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
	$sql->execute();
	$rs=$sql->get_result();
	while($row = $rs->fetch_assoc())
	{
	   	$dept_list[$row['dept_id']]=$row['dept_desc']; 
	}
	
	$sql->close();		
			

	$sql= $conn->prepare("select sp_id,sp_desc from service_placed_mst");	
	
	$sql->execute();
	$rs=$sql->get_result();
	while($row = $rs->fetch_assoc())
	{
	   		$sp_list[$row['sp_id']]=$row['sp_desc']; 
	}
	
	$sql->close();	
	

		
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
		

	    $sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();
	      
	     $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
		
	
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
	
		
		$tpl->assign('data',$data);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('sp_list',$sp_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('update_services.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>