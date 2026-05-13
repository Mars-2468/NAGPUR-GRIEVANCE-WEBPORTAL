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
        	    if($_REQUEST['status']==0)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id='1' and cat3_id !='0' group by ulbid";
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0' group by g.ulbid order by ulbname";
        	        }
        	        if($_SESSION['user_type']=='M')
        	        {
        	            //$sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='1' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0' group by g.ulbid order by ulbname";
        	            $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==1)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where  
        	        app_type_id='1' and grievance_status_id='1' and cat3_id !='0' group by ulbid";
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  app_type_id='1' and grievance_status_id='1' and cat3_id !='0' and d.rdma='".$_SESSION['uid']."' group by g.ulbid";
        	        }
        	        if($_SESSION['user_type']=='M')
        	        {
        	           // $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  app_type_id='1' and grievance_status_id='1' and cat3_id !='0' and d.rdma='".$_SESSION['uid']."' group by g.ulbid";
        	           $sql="select count(grievance_id) as count,ulbid from grievances  where  
        	        app_type_id='1' and grievance_status_id='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==2)
        	    {
        	       $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('3','8','9') and 
        	        app_type_id='1' and sla_status='1' and cat3_id !='0' group by ulbid";
        	        
        	      if($_SESSION['user_type']=='M')
        	        {
        	             $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('3','8','9') and 
        	        app_type_id='1' and sla_status='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by ulbid";
        	        }
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid  from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN('3','8','9') and 
        	            app_type_id='1' and d.rdma='".$_SESSION['uid']."' and sla_status='1' and cat3_id !='0' group by ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('3','8','9') and 
        	        app_type_id='1' and sla_status='2' and cat3_id !='0' group by ulbid";
        	        
        	      
        	        if($_SESSION['user_type']=='M')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('3','8','9') and 
        	        app_type_id='1' and sla_status='2' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by ulbid";
        	        
        	        }
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN('3','8','9') and 
        	            app_type_id='1' and d.rdma='".$_SESSION['uid']."' and sla_status='2' and cat3_id !='0' group by ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	       $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('2') and 
        	        app_type_id='1' and sla_status='1' and cat3_id !='0' group by ulbid";
        	        
        	       if($_SESSION['user_type']=='M')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('2') and 
        	        app_type_id='1' and sla_status='1' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by ulbid";
        	        }
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN('2') and 
        	            app_type_id='1' and d.rdma='".$_SESSION['uid']."' and sla_status='1' and cat3_id !='0' group by ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	         $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('2') and 
        	        app_type_id='1' and sla_status='2' and cat3_id !='0' group by ulbid";
        	        
        	       if($_SESSION['user_type']=='M')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('2') and 
        	        app_type_id='1' and sla_status='2' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by ulbid";
        	        }
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN('2') and 
        	            app_type_id='1' and d.rdma='".$_SESSION['uid']."' and sla_status='2' and cat3_id !='0' group by ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id='1' and grievance_status_id='6' and cat3_id !='0' group by ulbid";
        	        if($_SESSION['user_type']=='M')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id='1' and grievance_status_id='6' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by ulbid";
        	        }
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id='1' and grievance_status_id='6' and d.rdma='".$_SESSION['uid']."'  and cat3_id !='0'
        	            group by ulbid";
        	        }
        	    }
        	    
        	    /** rejected ***/
        	    
        	    if($_REQUEST['status']==10)
        	    {
        	        
        	          $sql="select count(grievance_id) as count,ulbid from grievances where app_type_id='1' and grievance_status_id='10' and cat3_id !='0' group by ulbid";
        	          if($_SESSION['user_type']== 'M')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances where app_type_id='1' and grievance_status_id='10' and cat3_id !='0' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by ulbid";
        	        }
        	        
        	        if($_SESSION['user_type']== 'R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id='1' and grievance_status_id='10' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'
        	            group by g.ulbid";
        	        }
        	        
        	        
        	        
        	    }
        	    
        	    /*** un resolvable  ***/
        	     
        	    
        	    if($_REQUEST['status']==11)
        	    {
        	        
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id='1' and grievance_status_id='4' group by ulbid";
        	        if($_SESSION['user_type']== 'M')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id='1' and grievance_status_id='4' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) group by ulbid";
        	        }
        	        
        	        if($_SESSION['user_type']== 'R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id='1' and grievance_status_id='4' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'
        	            group by g.ulbid";
        	        }
        	        
        	        
        	    }
        	    
        	  
        	    
        	    
		}
		
		else if($_REQUEST['app_type_id']==2)
		{
        	    if($_REQUEST['status']==0)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id='2' and cat3_id !='0' group by ulbid";
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id='2' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0' group by g.ulbid order by ulbname";
        	        }
        	    }
        	    if($_REQUEST['status']==1)
        	    {
        	         $sql="select count(grievance_id) as count,ulbid from grievances  where  
        	        app_type_id='2' and grievance_status_id='1' and cat3_id !='0' group by ulbid";
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  app_type_id='2' and grievance_status_id='1' and cat3_id !='0' and d.rdma='".$_SESSION['uid']."' group by g.ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==2)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('3','8','9') and 
        	        app_type_id='2' and sla_status='1' and cat3_id !='0' group by ulbid";
        	        
        	      
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid  from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN('3','8','9') and 
        	            app_type_id='2' and d.rdma='".$_SESSION['uid']."' and sla_status='1' and cat3_id !='0' group by ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('3','8','9') and 
        	        app_type_id='2' and sla_status='2' and cat3_id !='0' group by ulbid";
        	        
        	      
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN('3','8','9') and 
        	            app_type_id='2' and d.rdma='".$_SESSION['uid']."' and sla_status='2' and cat3_id !='0' group by ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	       $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('2') and 
        	        app_type_id='2' and sla_status='1' and cat3_id !='0' group by ulbid";
        	        
        	      
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN('2') and 
        	            app_type_id='2' and d.rdma='".$_SESSION['uid']."' and sla_status='1' and cat3_id !='0' group by ulbid";
        	        }
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	         $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('2') and 
        	        app_type_id='2' and sla_status='2' and cat3_id !='0' group by ulbid";
        	        
        	      
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN('2') and 
        	            app_type_id='2' and d.rdma='".$_SESSION['uid']."' and sla_status='2' and cat3_id !='0' group by ulbid";
        	        }
        	        
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql="select count(g.grievance_id) as count,g.ulbid from grievances  where app_type_id='2' and grievance_status_id='6' and cat3_id !='0' group by ulbid";
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id='2' and grievance_status_id='6' and d.rdma='".$_SESSION['uid']."' and sla_status='2' and cat3_id !='0'
        	            group by ulbid";
        	        }
        	    }
        	    
        	    /** rejected ***/
        	    
        	    if($_REQUEST['status']==10)
        	    {
        	        
        	         $sql="select count(grievance_id) as count,ulbid from grievances where app_type_id='2' and grievance_status_id='10' and cat3_id !='0' group by ulbid";
        	        
        	        if($_SESSION['user_type']== 'R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id='2' and grievance_status_id='10' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'
        	            group by g.ulbid";
        	        }
        	        
        	        
        	        
        	    }
        	    
        	    /*** un resolvable  ***/
        	     
        	    
        	    if($_REQUEST['status']==11)
        	    {
        	        
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id='2' and grievance_status_id='4' group by ulbid";
        	        
        	        if($_SESSION['user_type']== 'R')
        	        {
        	            $sql="select count(grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id='2' and grievance_status_id='4' and d.rdma='".$_SESSION['uid']."' and cat3_id !='0'
        	            group by g.ulbid";
        	        }
        	        
        	        
        	    }
        	    
        	  
        	    
        	    
		}
		
		
		
		
	
		
		
		
			    $rs=mysqli_query($conn,$sql);				
				 
				 while($row = mysqli_fetch_assoc($rs))
				 {
				
			
				
				 
			
					 $data[$row['ulbid']]['count']+=$row['count'];
					 $tot+=$row['count'];
					
				
				 
				 
				}	
				
		
			$tpl->assign('tot',$tot);
			$tpl->assign('resolved_beyond_sla',$resolved_beyond_sla);
				
		
		if($_REQUEST['status'] == 0 || $_REQUEST['status'] == 1 || $_REQUEST['status'] == 2 || $_REQUEST['status'] == 6 || $_REQUEST['status'] == 10 || $_REQUEST['status'] == 11)
		{
		
			$rs=mysqli_query($conn,$sql);
	        while($row = mysqli_fetch_assoc($rs))
    		 {
    		   
    		   $data[$row['ulbid']]['count']=$row['count'];
    		   $total+=$row['count'];
    		  
    		 }
		}
            $tpl->assign('total',$total);
    	
		
		
		$sql ="select u.* from ulbmst u,Districtmst d where u.distid=d.distid";
		if($_SESSION['user_type']=='R')
		{
		    $sql.=" and d.rdma='".$_SESSION['uid']."'";
		}
		$rs=mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				
			         $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
		
		
	mysqli_close($conn);
		$tpl->assign('apptypes',array('1'=>'Complaints','2'=>'Services'));
	    $tpl->assign('status_desc',array('0'=>'Total Received','1'=>'Pending For Approval','2'=>'Completed Within SLA','3'=>'Completed Beyond SLA','4'=>'Pending Within SLA','5'=>'Pending Beyond SLA','6'=>'Financial Implication','10'=>'Rejected','11'=>'Un Resolvable'));
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
		$tpl->display('cdma_ulbwise_report.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>
                            
                            
                            
                            
                            
                            