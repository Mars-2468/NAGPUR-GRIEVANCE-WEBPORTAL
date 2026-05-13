<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		require_once('send_sms.php');
		require_once('sms_conf.php');
		
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');
		if(isset($_POST['send_sms']))
		{
			if(!$_POST['check_list']=='')
			{
			
			foreach($_POST['check_list'] as $val)
			{
				
				$app_name="app_name".$val;
				$mobile="mobile".$val;
				$subject="subject".$val;
				$fees="fees".$val;
				$remarks="remarks".$val;
				
				
			
			 $sms="Dear ".$_POST[$app_name]." Pay fees ".$_POST[$fees]." regarding to ".$_POST[$subject]." and Remarks ".mysqli_real_escape_string($conn,$_POST[$remarks])."- ".$_SESSION['uid'];
			
			send_sms($sms,$_POST[$mobile]);
			}
			
			$tpl->assign('class','alert alert-success display-hide');
			$msg="Message Sent Successfully";
			
			
			}
			else
			{
			$tpl->assign('class','alert alert-danger display-hide');
			$msg="Your not checked any check box";
			}
			
			$tpl->assign('msg',$msg);
			
		}
		
		
		
		$sql="select g.*,c.dept_id,c.cutt_of_time,DATEDIFF(disposed_date,date_regd) AS target from grievances 
		g,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id  
		and g.grievance_status_id NOT IN(?) and g.ulbid=? and gt.disposal_status !=? and g.app_type_id=? order by date_regd DESC";
		$query=$conn->prepare($sql);
		$grievance_status_id=3;
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$disposal_status=5;			
		$app_type_id=2;	
		
		$query->bind_param("isii",$grievance_status_id,$ulbid,$disposal_status,$app_type_id);
		$query->execute();
	    $rs=$query->get_result();
		

		if($rs)
		{
			$field_info = $rs->fetch_fields();
			while($row = $rs->fetch_assoc())
			{
				
					
					foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
			}

		}
				
	
		$tpl->assign('data',$data);

       
			
		$sql =$conn->prepare("select ward_id,ward_desc from ward_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   	$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		$sql->close();	
			
		
			
		$sql =$conn->prepare("select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=?");
		$grievance_status_id=5;
		$sql->bind_param("i",$grievance_status_id);
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   		$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		$sql->close();	
			
		
		
		$sql =$conn->prepare("select dept_id,dept_desc from dept_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
	    while($row = $rs->fetch_assoc())
		{
		   		$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		$tpl->assign('dept_list',$dept_list);
		$sql->close();
		
		
			
		$sql =$conn->prepare("select cs_id,comp_desc from category3_mst where ulbid=?");
		$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$sql->bind_param("s",$ulbid);
	    $sql->execute();
	    $rs=$sql->get_result();
	    if($_REQUEST['aptid']=='1')
		{
	
		$sql =$conn->prepare("select cs_id,cs_desc as comp_desc from cs_mst");
	    $sql->execute();
	    $rs=$sql->get_result();
		}
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
	
	    
	    
		$sql->close();	
			
		
					
		
		
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
    	$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	    $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('send_sms_user.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>