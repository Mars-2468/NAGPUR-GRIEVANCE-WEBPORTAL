<?php
session_start();

	ini_set('display_errors',0);
    date_default_timezone_set('Asia/Calcutta');
   
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	//echo "<pre>";print_r($_FILES);echo "</pre>";die();
	
	if(isset($_SESSION['uid']))
	{
   
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		
		//require_once('prepare_connection.php');
		$conn=getconnection();
		
		mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');		
		
	    $_SESSION['formStatus'] = 1; 
		/*	if($_SESSION['ulbid'] == '3')
    		{
    		  $_SESSION['formStatus'] = 0;  
    		}*/
		
		$tpl->assign('formStatus',$_SESSION['formStatus']);
        
		$sql="select grievance_origin_id,grievance_origin_desc from grievance_origin_mst where show_status=1";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
				
				//print_r($grievance_origin_list);
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));			
			
        //	$sql="select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
	
		$sql=$conn->prepare("select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid=? and delete_status='0' and emp_status='0'");
		$sql->bind_param("s",$_SESSION['ulbid']);	
		
		if($sql->execute())
		{
			$rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
			{
				$emp_name_list[$row['emp_id']]=$row['emp_name'];
				$emp_dept_list[$row['emp_id']]=$row['emp_dept'];
				$emp_desg_list[$row['emp_id']]=$row['emp_desg'];
				$emp_mobile_list[$row['emp_id']]=$row['emp_mobile'];
			}
		}
		
		//$sql="select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
		
		$sql=$conn->prepare("select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od where ulbid=? and delete_status='0'");
		$sql->bind_param("s",$_SESSION['ulbid']);
		
		
		if($sql->execute())
		{
			$rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
			{
				$emp_name_list[$row['emp_id']]=$row['emp_name'];
				$emp_dept_list[$row['emp_id']]=$row['emp_dept'];
				$emp_desg_list[$row['emp_id']]=$row['emp_desg'];
				$emp_mobile_list[$row['emp_id']]=$row['emp_mobile'];
			}
		}
	
		//$sql="select ward_id,ward_desc from ward_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
	
		$sql=$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=?");
		$sql->bind_param("s",$_SESSION['ulbid']);
	
		if($sql->execute())
		{
		    $rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		else
			printf("Errormessage: %s\n", $sql->error);	
			
			//$sql="select street_id,street_desc from street_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' order by street_desc";
		$sql=$conn->prepare("select street_id,street_desc from street_mst where ulbid=? order by street_desc");
	    $sql->bind_param("s",$_SESSION['ulbid']);	
			
			
		if($sql->execute())
		{
		    $rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
				$street_list[$row['street_id']]=$row['street_desc'];
		}
	
	    $sql->close();
		
		$sql ="select cs_id,comp_desc from category3_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
		
		$sql=$conn->prepare("select cs_id,comp_desc from category3_mst where ulbid=?");
	    $sql->bind_param("s",$_SESSION['ulbid']);
		
		$rs = $sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		$service_list[$row['cs_id']]=$row['comp_desc'];
		}
		
		$sql->close();
		
		// here is the save condition *******************
		
		$sql="select cat_id,description  from category_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' order by description ";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cat_list[$row['cat_id']]=$row['description'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));

		$sql="select sub_cat_id,cat_id,description  from subcategory_mst where status='1' order by description ";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$sub_cat_list[$row['sub_cat_id']]=$row['description'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
			$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		//	print_r($online_applications);
	
		$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	    $rs = mysqli_query($conn,$sql);
	    $row = mysqli_fetch_assoc($rs);
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
	
	    $tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);			
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('sub_cat_list',$sub_cat_list);
		mysqli_close($conn);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);
		$tpl->assign('ulbid',$_SESSION['ulbid']);			
		$tpl->assign('app_type_list',array('1'=>'Complaint','2'=>'Service'));		
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);
		$tpl->assign('street_list',$street_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$flash = get_flash();		
		$tpl->assign("flash", $flash); 		
		$tpl->display('corp_register_comp_helpline_newtest.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		echo "<script>window.location='index.php';</script>";
	}
		
?>