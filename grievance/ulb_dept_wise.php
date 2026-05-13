<?php
require "config.php";
//include('responsible_sms.php');
?><?php
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',1);
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
		
		
		if($_REQUEST['app_type_id']==1)
		{
        	    if($_REQUEST['status']==0 )
        	    {
        	        
        	        
        	        
        	        
        	           $sql ="select count(g.grievance_id) as count,dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id !='0' group by dept_id";
        	           if($_SESSION['user_type']=='M')
        	        {
        	            $sql ="select count(g.grievance_id) as count,dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by dept_id"; 
        	        }
        	           //echo $sql ="select count(g.grievance_id) as count,dm.dept_id as emp_dept from grievances g, grievances_transactions gt,dept_mst dm,category3_mst cm where g.grievance_id=gt.grievance_id and g.cat3_id=cm.cat3_id and cm.dept_id=dm.dept_id  and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' group by e.emp_dept";
        	    }
        	     if($_REQUEST['status']==1 )
        	    {
        	           $sql ="select count(g.grievance_id) as count,cat3_id from grievances g, cs_mst  c where  g.cat3_id=c.cs_id and g.app_type_id='".$_REQUEST['app_type_id']."' and  grievance_status_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id !='0' group by cat3_id";
        	           if($_SESSION['user_type']=='M')
        	        {
        	           $sql ="select count(g.grievance_id) as count,cat3_id from grievances g, cs_mst  c where  g.cat3_id=c.cs_id and g.app_type_id='".$_REQUEST['app_type_id']."' and  grievance_status_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by cat3_id";
        	        }
        	    }
        	   
        	    if($_REQUEST['status']==2)
        	    {
        	        
        	          
        	          $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9') and gt.disposal_status !=5  and g.app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='1' and cat3_id !='0' group by dept_id";
        	           if($_SESSION['user_type']=='M')
        	        {
        	           $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9') and gt.disposal_status !=5  and g.app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by dept_id";
        	        }
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9') and gt.disposal_status !=5  and g.app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='2' and cat3_id !='0' group by dept_id";
        	        if($_SESSION['user_type']=='M')
        	        {
        	           $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9') and gt.disposal_status !=5  and g.app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='2' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by dept_id";
        	        }
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	         
        	          $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and g.app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='1' and cat3_id !='0' group by dept_id";
        	          if($_SESSION['user_type']=='M')
        	        {
        	           $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and g.app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by dept_id";
        	        }
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	        $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and g.app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='2' and cat3_id !='0' group by dept_id";
        	        if($_SESSION['user_type']=='M')
        	        {
        	           $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and g.app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='2' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by dept_id";
        	        }
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql ="select count(g.grievance_id) as count,dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' and g.grievance_status_id='6' and cat3_id !='0' group by dept_id";
        	        if($_SESSION['user_type']=='M')
        	        {
        	           $sql ="select count(g.grievance_id) as count,dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' and g.grievance_status_id='6' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by dept_id";
        	        }
        	    }
        	    
        	     if($_REQUEST['status']==10)
        	    {
        	        $sql ="select count(g.grievance_id) as count,dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' and g.grievance_status_id='10' and cat3_id !='0' group by dept_id";
        	        if($_SESSION['user_type']=='M')
        	        {
        	           $sql ="select count(g.grievance_id) as count,dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' and g.grievance_status_id='10' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by dept_id";
        	        }
        	    }
        	    
        	    
        	    
		}
		else if($_REQUEST['app_type_id']==2)
		{
		    if($_REQUEST['status']==0 )
        	    {
        	            $sql ="select count(g.grievance_id) as count,dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id !='0' group by dept_id";
        	           //echo $sql ="select count(g.grievance_id) as count,dm.dept_id as emp_dept from grievances g, grievances_transactions gt,dept_mst dm,category3_mst cm where g.grievance_id=gt.grievance_id and g.cat3_id=cm.cat3_id and cm.dept_id=dm.dept_id  and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' group by e.emp_dept";
        	    }
        	     if($_REQUEST['status']==1 )
        	    {
        	           $sql ="select count(g.grievance_id) as count,cat3_id from grievances g, cs_mst  c where  g.cat3_id=c.cs_id and g.app_type_id='".$_REQUEST['app_type_id']."' and  grievance_status_id='1' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id !='0' group by cat3_id";
        	    }
        	   
        	    if($_REQUEST['status']==2)
        	    {
        	        
        	          //$sql="select e.emp_dept,g.ulbid,g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status,ccm.cutt_off_time as target_days from emp_mst e ,grievances g , grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','8','10','4')  and gt.disposal_status !=5  and g.app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."'";
        	           $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9') and gt.disposal_status !=5  and g.app_type_id='2' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='1' and cat3_id !='0' group by dept_id";
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9') and gt.disposal_status !=5  and g.app_type_id='2' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='2' and cat3_id !='0' group by dept_id";
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	         //$sql="select e.emp_dept,g.ulbid,g.grievance_id,app_type_id,date_regd,disposed_date,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd) AS target,ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and g.grievance_status_id NOT IN('3','8','10','4','6') and gt.disposal_status !=5  and app_type_id='1' and g.ulbid='".$_REQUEST['ulbid']."'";
        	          $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and g.app_type_id='2' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='1' and cat3_id !='0' group by dept_id";
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	        $sql ="select COUNT(g.grievance_id) as count , gt.dept_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and g.app_type_id='2' and g.ulbid='".$_REQUEST['ulbid']."' and sla_status='2' and cat3_id !='0' group by dept_id";
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql ="select count(g.grievance_id) as count,dept_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and g.ulbid='".$_REQUEST['ulbid']."' and g.grievance_status_id='6' and cat3_id !='0' group by dept_id";
        	    }
		}
		
		
		
			    $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 {
				
				    $data[$row['dept_id']]['count']+=$row['count'];
					 $tot+=$row['count'];
					 
				}	
				
		
			$tpl->assign('tot',$tot);
			$tpl->assign('resolved_beyond_sla',$resolved_beyond_sla);
				
		
		if($_REQUEST['status'] == 0 || $_REQUEST['status'] == 1 || $_REQUEST['status'] == 2 || $_REQUEST['status'] == 6 )
		{
		
			$rs=mysqli_query($conn,$sql);
	        while($row = mysqli_fetch_assoc($rs))
    		 {
    		   
    		   $data[$row['emp_dept']]['count']=$row['count'];
    		   $total+=$row['count'];
    		  
    		 }
		}
            $tpl->assign('total',$total);
    	
		
		
		
				
				if($_SESSION['user_type']!='M')
				{
				    $sql = "select * from dept_mst where ulbid = '".$_REQUEST['ulbid']."' " ;
				}
				else
				{
				 $sql = "select * from dept_mst where (ulbid = '".$_REQUEST['ulbid']."' and dept_desc like '%mepma%') or (ulbid = '".$_REQUEST['ulbid']."' and dept_desc like '%MEPMA%')" ;
				
				   // $sql = "select * from dept_mst where ulbid = '".$_REQUEST['ulbid']."' " ;
				}
				//echo $sql;
		         $rs=mysqli_query($conn,$sql);
		         while($row = mysqli_fetch_assoc($rs))
				{
				
			         $dept_list[$row['dept_id']]=$row['dept_desc'];
				}
				
				$sql = "select * from ulbmst where ulbid = '".$_REQUEST['ulbid']."' " ;
		         $rs=mysqli_query($conn,$sql);
		         while($row = mysqli_fetch_assoc($rs))
				{
				
			         $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
		mysqli_close($conn);
		$tpl->assign('ulbname',$ulb_list[$_REQUEST['ulbid']]);
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
		$tpl->assign('dept_list',$dept_list);

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
		$tpl->display('ulb_dept_wise.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>
                            
                            
                            
                            
                            
                            