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
	
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
	    $app_type_id=$_REQUEST['app_type_id'];
	   
        $ulbid=$_REQUEST['ulbid'];
        $status=$_REQUEST['status'];
		$dept_id=$_REQUEST['dept_id'];
	
		
		
	$sql ="select * from grievances where ulbid='".$_REQUEST['ulbid']."'";	
		
		
	
		
		
		
		
		
	
		if($rs=mysqli_query($conn,$sql))
        		{
        			$field_info = mysqli_fetch_fields($rs);
        			while($row = mysqli_fetch_assoc($rs))
        			{
        			
        				
                			
                				
                					foreach($field_info as $fi => $f) 
                					$data[$row['grievance_id']][$f->name]=$row[$f->name];
        					 
        			}
        			
        	
        			
        		}
        		else
        		echo mysqli_error($conn);
    	
		
		
	$sql ="select e.*,d.dept_desc from emp_mst e,dept_mst d where e.emp_dept=d.dept_id and e.emp_id='".$_REQUEST['ulbid']."'";
		$rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $ulb_list[$row['emp_id']]=$row['emp_name'];
			         $dept_list[$row['emp_dept']]=$row['dept_desc'];
			         
				}
				$sql ="select e.*,d.dept_desc from emp_mst_od e,dept_mst d where e.emp_dept=d.dept_id and e.emp_id='".$_REQUEST['ulbid']."'";
		$rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $ulb_list[$row['emp_id']]=$row['emp_name'];
			         $dept_list[$row['emp_dept']]=$row['dept_desc'];
			         
				}
				
	       
				
		$sql="select cs_id,dept_desc as comp_desc from category3_mst c,dept_mst d where c.dept_id=d.dept_id";
		
		if($_REQUEST['app_type_id']=='1')
		{
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		}
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
			
			
			$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
		
		$sql = "select * from ulbmst where ulbid = '".$_REQUEST['id']."' " ;
		         $rs=mysqli_query($conn,$sql);
		         while($row = mysqli_fetch_assoc($rs))
				{
				
			         $ulblist[$row['ulbid']]=$row['ulbname'];
				}
		
		mysqli_close($conn);
		$tpl->assign('ulbname',$ulblist[$_REQUEST['id']]);	
		$tpl->assign('status',$_REQUEST['status']);		
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('dept_id',$_REQUEST['dept_id']);
	    $tpl->assign('ulbid_sel',$_REQUEST['ulbid']);
		$tpl->assign('apptypes',array('1'=>'Complaints','2'=>'Services'));
	    $tpl->assign('status_desc',array('0'=>'Total Received','2'=>'Completed Within SLA','3'=>'Completed Beyond SLA','4'=>'Pending Within SLA','5'=>'Pending Beyond SLA','6'=>'Financial Implication'));
	    $tpl->assign('app_type_id',$_REQUEST['app_type_id']);
	    $tpl->assign('status',$_REQUEST['status']);
	    $tpl->assign('ulb_list',$ulb_list);
	    $tpl->assign('ulb_list1',$ulb_list1);
		$tpl->assign('preg',$_POST['regionid']);
		$tpl->assign('pulb',$_POST['ulbid']);
		$tpl->assign('pdist',$_POST['distid']);
		$tpl->assign('region_list',$region_list);
		$tpl->assign('dist_list',$dist_list);
        $tpl->assign('pagination',$pagination);
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
		$tpl->display('showall.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>
                            
                            
                            
                            
                            
                            