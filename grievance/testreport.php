<?php
require "config.php";
//include('responsible_sms.php');
?><?php
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	
	$tpl=new Smarty();
	 
	
	
	//require_once('sms_conf.php');
	//require_once('send_sms.php');	
	
	//echo "hi";
	

		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
	$sql ="SELECT em.street_id,em.ward_id,e.emp_id,e.emp_desg as desg_id,cs_id,e.ulbid,em.emp_id2 FROM `emp_map` em,emp_mst e,street_mst s where em.emp_id=e.emp_id and em.street_id=s.street_id and cs_id > 0 and cs_type_id ='1' order by e.ulbid ";
				
		$rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $data[$row['street_id']]['street_id']=$row['street_id'];
			         $data[$row['street_id']]['ward_id']=$row['ward_id'];
			         $data[$row['street_id']]['emp_id']=$row['emp_id'];
			         $data[$row['street_id']]['desg_id']=$row['desg_id'];
			         $data[$row['street_id']]['cs_id']=$row['cs_id'];
			         $data[$row['street_id']]['ulbid']=$row['ulbid'];
			         $data[$row['street_id']]['emp_id2']=$row['emp_id2'];
				}
				
			
	
    	
		
		
		$sql ="select * from emp_mst";
		$rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $emp_list[$row['emp_id']]=$row['emp_name'];
				}
				
				$sql ="SELECT * FROM `desg_mst`";
		$rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $desg_list[$row['desg_id']]=$row['desg_desc'];
				}
				
				
				
				$sql = "select * from ulbmst " ;
		         $rs=mysqli_query($conn,$sql);
		         while($row = mysqli_fetch_assoc($rs))
				{
				
			         $ulblist[$row['ulbid']]=$row['ulbname'];
				}
				
					$sql = "SELECT * FROM `ward_mst`" ;
		         $rs=mysqli_query($conn,$sql);
		         while($row = mysqli_fetch_assoc($rs))
				{
				
			         $wardlist[$row['ward_id']]=$row['ward_desc'];
				}
				
					$sql = "SELECT * FROM `street_mst`" ;
		         $rs=mysqli_query($conn,$sql);
		         while($row = mysqli_fetch_assoc($rs))
				{
				
			         $streelist[$row['street_id']]=$row['street_desc'];
				}
				
					$sql = "SELECT * FROM `cs_mst`" ;
		         $rs=mysqli_query($conn,$sql);
		         while($row = mysqli_fetch_assoc($rs))
				{
				
			         $cslist[$row['cs_id']]=$row['cs_desc'];
				}
		mysqli_close($conn);
		
		$tpl->assign('cslist',$cslist);
		$tpl->assign('streelist',$streelist);
		$tpl->assign('wardlist',$wardlist);
		$tpl->assign('ulblist',$ulblist);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('emp_list',$emp_list);
		

		$tpl->assign('feedback_count',$feedback_count);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('tot_complaints',$tot_complaints);
		$tpl->assign('res_complaints',$res_complaints);
		$tpl->assign('res_services',$res_services);
		$tpl->assign('datalist',$datalist);
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('origin_rep',$origin_rep);
		$tpl->assign('origin_list',$origin_list);

		$tpl->assign('tanker_enable_status',$tanker_enable_status);
		$tpl->assign('map',$map);
		$tpl->assign('pic',$pic);
		$tpl->assign('data',$data);
		$tpl->assign('data1',$data1);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('testreport.tpl');
	
?>
                            
                            
                            
                            
                            
                            