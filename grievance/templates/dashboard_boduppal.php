<?php
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	
	//require_once('sms_conf.php');
	//require_once('send_sms.php');	
	
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		/** Total received / assigned **/
		
		
		if($_SESSION['user_type']=='A')
				{
				
				$sql="SELECT count(date_regd) as date_regd,app_type_id FROM grievances group by app_type_id";
				}
				else if($_SESSION['user_type']=='U')
				{
				 $sql="SELECT count(date_regd) as date_regd,app_type_id FROM grievances where ulbid='".$_SESSION['ulbid']."' group by app_type_id";
				}
				else if($_SESSION['user_type']=='E')
				{
				 $sql="SELECT count(g.grievance_id) as date_regd,app_type_id FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and emp_id='".$_SESSION['emp_id']."' group by g.app_type_id";
				}
			        $rs=mysqli_query($conn,$sql);
			         while($row = mysqli_fetch_assoc($rs))
				 {
				 	
		 
				 	  $data[$row['app_type_id']]['total_received']=$row['date_regd'];
					
				 }
		/** Resolved with in sla **/
		
		if($_SESSION['user_type']=='A')
				{
				
				  $sql="select count(grievance_id) as grievance_id,app_type_id from grievances where grievance_status_id NOT IN('3') group by app_type_id";
				  }
				  else if($_SESSION['user_type']=='U')
				  {
				  $sql="select count(g.grievance_id) as grievance_id,app_type_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3') and g.ulbid='".$_SESSION['ulbid']."' group by g.app_type_id";
				  }
				  else if($_SESSION['user_type']=='E')
				  {
				  $sql="select count(g.grievance_id) as grievance_id,app_type_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3') and gt.emp_id='".$_SESSION['emp_id']."' group by g.app_type_id";
				  }
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
				
				
				$data[$row['app_type_id']]['total_resolved']=$row['grievance_id'];
				
				}	
				
				
				
				
				
				/** Under progress  beyond SLA**/
				
				if($_SESSION['user_type']=='A')
				{
				 
				$sql="select g.grievance_id,app_type_id,date_regd from grievances where grievance_status_id NOT IN('3')";
				}
				else if($_SESSION['user_type']=='U')
				{
				 $sql="select g.grievance_id,app_type_id,date_regd from grievances g  where g.grievance_status_id NOT IN('3') and g.ulbid='".$_SESSION['ulbid']."'";
				}
				else if($_SESSION['user_type']=='E')
				{
				 $sql="select g.grievance_id,app_type_id,date_regd  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id NOT IN('3')  and gt.emp_id='".$_SESSION['emp_id']."'";
				}
				  $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 
				{
					$data[$row['app_type_id']]['pending_beyond_sla']+=1;
				}
				
				
				
				
		
		/** counting total services **/
		
		$sql ="select count(cs_id) total_services,cs_type_id from category3_mst where ulbid='".$_SESSION['ulbid']."' group by cs_type_id";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$map[$row['cs_type_id']]['total_services']=$row['total_services'];
		}
		
		/** assigned services **/
		
		$sql ="select count(cs_id) total_services_mapped,cs_type_id from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_id IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' and cs_type_id='2' group by cs_id) group by cs_type_id";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$map[$row['cs_type_id']]['total_services_mapped']=$row['total_services_mapped'];
		}
		
		/**/
		
		/** services not assigned **/
		$sql ="select count(cs_id) total_services_not_mapped,cs_type_id from category3_mst where ulbid='".$_SESSION['ulbid']."' and cs_id NOT IN(select cs_id from emp_map where ulbid='".$_SESSION['ulbid']."' and flag='1' group by cs_id) group by cs_type_id";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$map[$row['cs_type_id']]['total_services_not_mapped']=$row['total_services_not_mapped'];
		}
		/**/
		
		/** tanker reports **/
		
		 $sql="SELECT count(req_id) as count ,status FROM tanker_req where ulbid='".$_SESSION['ulbid']."' group by  status"; 
	                        $rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $tankertot+=$row['count'];
					 $tankers_list[$row['status']]=$row['count'];
				}
				
				
				$tpl->assign('tankers_list',$tankers_list);
				$tpl->assign('tankertot',$tankertot);
		
		/**/
		
		/** checking tanker request status enabled or disabled **/
		$sql ="select enable_status from tanker_enable_mst where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rs);
		$tanker_enable_status=$row['enable_status'];
		
		/**/
		
		
		
		$tpl->assign('tanker_enable_status',$tanker_enable_status);
		$tpl->assign('map',$map);
		$tpl->assign('data',$data);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('dashboard.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>
                            
                            
                            
                            
                            
                            