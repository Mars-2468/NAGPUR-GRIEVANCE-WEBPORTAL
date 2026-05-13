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
		
		
		///????????????????????admin(CDMA)
		if($_REQUEST['app_type_id']==1)
		{
        	    if($_REQUEST['status']==0 )
        	    {
        	          $sql ="select count(g.grievance_id) as count,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='".$_REQUEST['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	          if($_SESSION['user_type']=='M')
        	        {
        	           $sql ="select count(g.grievance_id) as count,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='".$_REQUEST['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by gt.emp_id";
        	        }
        	    }
        	   
        	    if($_REQUEST['status']==2 )
        	    {
        	        
        	          $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and dept_id='".$_REQUEST['dept_id']."' and sla_status='1' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	           if($_SESSION['user_type']=='M')
        	        {
        	           $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and dept_id='".$_REQUEST['dept_id']."' and sla_status='1' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by gt.emp_id";
        	        }
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and dept_id='".$_REQUEST['dept_id']."' and sla_status='2' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	        if($_SESSION['user_type']=='M')
        	        {
        	           $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and dept_id='".$_REQUEST['dept_id']."' and sla_status='2' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)  group by gt.emp_id";
        	        }
        	    }
        	    
        	    if($_REQUEST['status']==4)
        	    {
        	         $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='1' and dept_id='".$_REQUEST['dept_id']."' and sla_status='1' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	         if($_SESSION['user_type']=='M')
        	        {
        	           $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='1' and dept_id='".$_REQUEST['dept_id']."' and sla_status='1' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by gt.emp_id";
        	        }
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	        $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='1' and dept_id='".$_REQUEST['dept_id']."' and sla_status='2' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	        if($_SESSION['user_type']=='M')
        	        {
        	           $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='1' and dept_id='".$_REQUEST['dept_id']."' and sla_status='2' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)  group by gt.emp_id";
        	        }
        	    }
        	    
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql="select gt.emp_id,count(g.grievance_id) as count,g.ulbid from grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id  and app_type_id='1' and grievance_status_id='6' and g.ulbid='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 and dept_id='".$_REQUEST['dept_id']."' group by gt.emp_id";
        	        if($_SESSION['user_type']=='M')
        	        {
        	           $sql="select gt.emp_id,count(g.grievance_id) as count,g.ulbid from grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id  and app_type_id='1' and grievance_status_id='6' and g.ulbid='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 and dept_id='".$_REQUEST['dept_id']."' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by gt.emp_id";
        	        }
        	    }
        	    
        	    if($_REQUEST['status']==10)
        	    {
        	        $sql="select gt.emp_id,count(g.grievance_id) as count,g.ulbid from grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id  and app_type_id='1' and grievance_status_id='10' and g.ulbid='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 and dept_id='".$_REQUEST['dept_id']."' group by gt.emp_id";
        	        if($_SESSION['user_type']=='M')
        	        {
        	            $sql="select gt.emp_id,count(g.grievance_id) as count,g.ulbid from grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id  and app_type_id='1' and grievance_status_id='10' and g.ulbid='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 and dept_id='".$_REQUEST['dept_id']."' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by gt.emp_id";
        	        }
        	    }
        	    
		}
		else if($_REQUEST['app_type_id']==2)
		{
		     if($_REQUEST['status']==0 )
        	    {
        	          echo $sql ="select count(g.grievance_id) as count,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."' and
        	           cat3_id != '0' group by gt.emp_id";
        	    }
        	   
        	    if($_REQUEST['status']==2 )
        	    {
        	        
        	          $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='2' and dept_id='".$_REQUEST['dept_id']."' and sla_status='1' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='2' and dept_id='".$_REQUEST['dept_id']."' and sla_status='2' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	    }
        	    
        	    if($_REQUEST['status']==4)
        	    {
        	         $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='2' and dept_id='".$_REQUEST['dept_id']."' and sla_status='1' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	        $sql="select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='2' and dept_id='".$_REQUEST['dept_id']."' and sla_status='2' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	    }
        	    
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql="select e.emp_id,count(g.grievance_id) as count,g.ulbid from grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id  and app_type_id='1' and grievance_status_id='6' and g.ulbid='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 and dept_id='".$_REQUEST['dept_id']."' and g.ulbid='".$_REQUEST['ulbid']."' group by gt.emp_id";
        	    }
		}
		
		
		
			    $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 {
				
			
				
				
					 $data[$row['emp_id']]['count']+=$row['count'];
					 $tot+=$row['count'];
					 
				
				 
				 
				}	
				
		
			$tpl->assign('tot',$tot);
			$tpl->assign('resolved_beyond_sla',$resolved_beyond_sla);
				
		
	
    	
		
		
		$sql ="select * from emp_mst where emp_dept='".$_REQUEST['dept_id']."'";
		$rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $ulb_list[$row['emp_id']]=$row['emp_name'];
				}
				$sql ="select * from emp_mst_od where emp_dept='".$_REQUEST['dept_id']."'";
		$rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $ulb_list[$row['emp_id']]=$row['emp_name'];
				}
				
				$sql = "select * from ulbmst where ulbid = '".$_REQUEST['ulbid']."' " ;
		         $rs=mysqli_query($conn,$sql);
		         while($row = mysqli_fetch_assoc($rs))
				{
				
			         $ulblist[$row['ulbid']]=$row['ulbname'];
				}
		mysqli_close($conn);
		
		$tpl->assign('id',$_REQUEST['ulbid']);
		$tpl->assign('ulbname',$ulblist[$_REQUEST['ulbid']]);
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
		$tpl->display('cdma_empwise_report.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>
                            
                            
                            
                            
                            
                            