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
	   //echo $emp_id=$_REQUEST['emp_id'];
        $ulbid=$_REQUEST['ulbid'];
        $status=$_REQUEST['status'];
		$dept_id=$_REQUEST['dept_id'];
		///????????????????????admin(CDMA)
		if($_REQUEST['app_type_id']==1)
		{
        	    if($_REQUEST['status']==0 )
        	    {
        	           $sql="select g.*,c.cat_id,gt.ts,ccm.cutt_off_time as target_days,disposed_date,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id  and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.emp_id='".$_REQUEST['ulbid']."' order by date_regd DESC";
        	           if($_SESSION['user_type']=='M')
        	        {
        	           $sql="select g.*,c.cat_id,gt.ts,ccm.cutt_off_time as target_days,disposed_date,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,  DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g,cs_mst c,grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id  and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.emp_id='".$_REQUEST['ulbid']."' and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) order by date_regd DESC";
        	        }

        	    }
        	    if($_REQUEST['status']==1)
        	    {
        	        
        	        $sql="select g.ulbid,g.*,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,
        	        ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g ,comp_cutofdays_map ccm,
        	        ulbmst u where  g.cat3_id=ccm.cs_id and g.ulbid=u.ulbid and g.grievance_status_id ='1' and g.app_type_id='1' and 
        	        g.cat3_id='".$_REQUEST['dept_id']."' and g.ulbid='".$_REQUEST['ulbid']."'";
        	        if($_SESSION['user_type']=='M')
        	        {
        	           $sql="select g.ulbid,g.*,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,
        	        ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g ,comp_cutofdays_map ccm,
        	        ulbmst u where  g.cat3_id=ccm.cs_id and g.ulbid=u.ulbid and g.grievance_status_id ='1' and g.app_type_id='1' and 
        	        g.cat3_id='".$_REQUEST['dept_id']."' and g.ulbid='".$_REQUEST['ulbid']."' and cat3_id IN(105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126) ";
        	        }
        	    }
        	    
        	    if($_REQUEST['status']==2)
        	    {
        	        
        	        $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,comp_cutofdays_map ccm  where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' having target <= target_days";
        	         if($_SESSION['user_type']=='M')
        	        {
        	          $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,comp_cutofdays_map ccm  where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' having target <= target_days and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) ";
        	        }
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,comp_cutofdays_map ccm  where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' having target > target_days ";
        	         if($_SESSION['user_type']=='M')
        	        {
        	          $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,comp_cutofdays_map ccm  where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' having target > target_days and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) ";
        	        }
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	           $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."'  having target <= target_days";
        	           if($_SESSION['user_type']=='M')
        	        {
        	          $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."'  having target <= target_days and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
        	        }
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	        $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id  and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' having target > target_days";
        	        if($_SESSION['user_type']=='M')
        	        {
        	          $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id  and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' having target > target_days and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127)";
        	        }
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	         $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g,ulbmst u,grievances_transactions gt,comp_cutofdays_map ccm  where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id='6' and gt.emp_id='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 order by ulbname";
        	          if($_SESSION['user_type']=='M')
        	        {
        	          $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g,ulbmst u,grievances_transactions gt,comp_cutofdays_map ccm  where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id='6' and gt.emp_id='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) order by ulbname";
        	        }
        	    }
        	    
        	    if($_REQUEST['status']==10)
        	    {
        	         $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g,ulbmst u,grievances_transactions gt,comp_cutofdays_map ccm  where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id='10' and gt.emp_id='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 order by ulbname";
        	          if($_SESSION['user_type']=='M')
        	        {
        	          $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date,gt.disposal_status,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed from grievances g,ulbmst u,grievances_transactions gt,comp_cutofdays_map ccm  where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id='10' and gt.emp_id='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 and cat3_id IN(105,106,107,108,109,110,111,114,119,122,123,125,126,127) order by ulbname";
        	        }
        	    }
        	    
		}
		else if($_REQUEST['app_type_id']==2)
		{
		     if($_REQUEST['status']==0)
        	    {
        	          $sql ="select count(g.grievance_id) as count,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='".$_REQUEST['ulbid']."' and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.disposal_status!='5' and gt.dept_id='".$_REQUEST['dept_id']."' group by gt.emp_id";
        	    }
        	    
        	     if($_REQUEST['status']==1)
        	    {
        	        
        	        $sql="select g.ulbid,g.*,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time DAY) as comp_date,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(NOW(),date_regd)-ccm.cutt_of_time  AS no_of_days_exeed from grievances g ,category3_mst ccm,ulbmst u where  g.cat3_id=ccm.cs_id and g.ulbid=u.ulbid and g.grievance_status_id ='1' and g.app_type_id='2' and g.cat3_id='".$_REQUEST['dept_id']."' and g.ulbid='".$_REQUEST['ulbid']."'";
        	    }
        	    
        	    if($_REQUEST['status']==2)
        	    {
        	        
        	        $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time DAY) as comp_date,gt.disposal_status,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_of_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,category3_mst ccm  where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','9','8')  and gt.disposal_status !=5  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['ulbid']."' having target <= target_days";
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time DAY) as comp_date,gt.disposal_status,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_of_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,category3_mst ccm  where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','9','8')  and gt.disposal_status !=5  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['ulbid']."' having target > target_days";
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	          // $sql="select e.emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time DAY) as comp_date,gt.disposal_status,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_of_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,category3_mst ccm,emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and app_type_id='2' and gt.emp_id='".$_REQUEST['ulbid']."'  having target <= target_days";
        	           $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time DAY) as comp_date,gt.disposal_status,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_of_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,category3_mst ccm where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and app_type_id='2' and gt.emp_id='".$_REQUEST['ulbid']."'  having target <= target_days";
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	        $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time DAY) as comp_date,gt.disposal_status,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_of_time  AS no_of_days_exeed from grievances g , grievances_transactions gt,category3_mst ccm where g.grievance_id=gt.grievance_id  and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('2') and gt.disposal_status !=5  and app_type_id='2' and gt.emp_id='".$_REQUEST['ulbid']."' having target > target_days";
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	         $sql="select gt.dept_id as emp_dept,g.ulbid,g.*,disposed_date,DATEDIFF(NOW(),date_regd) AS target,DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time DAY) as comp_date,gt.disposal_status,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,date_regd)-ccm.cutt_of_time  AS no_of_days_exeed from grievances g,ulbmst u,grievances_transactions gt,category3_mst ccm  where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and app_type_id='2' and grievance_status_id='6' and gt.emp_id='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 order by ulbname";
        	    }
		}
		
		
		
		
		
	
	
	
	
	
	
	
		$adjacents = 5;
		
		if($_REQUEST['app_type_id']==1)
		{
        	    if($_REQUEST['status']==0 )
        	    {
        	           $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.emp_id='".$_REQUEST['ulbid']."' order by date_regd DESC";

        	    }
        	    if($_REQUEST['status']==1)
        	    {
        	        
        	         $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt  where g.grievance_id=gt.grievance_id and 
        	        g.grievance_status_id ='1' and g.app_type_id='1' and g.cat3_id='".$_REQUEST['dept_id']."' and g.ulbid='".$_REQUEST['ulbid']."'";
        	    }
        	    
        	   
        	    if($_REQUEST['status']==2)
        	    {
        	        
        	        $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt   where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' and sla_status='1'";
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt   where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' and sla_status='2'";
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	           $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt   where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' and sla_status='1'";
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	        $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt   where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='1' and gt.emp_id='".$_REQUEST['ulbid']."' and sla_status='2'";
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	         $query="count(g.grievance_id) as num from grievances g , grievances_transactions gt from grievances g,grievances_transactions gt where  g.grievance_id=gt.grievance_id and app_type_id='1' and grievance_status_id='6' and gt.emp_id='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 ";
        	    }
        	    
		}
		else if($_REQUEST['app_type_id']==2)
		{
		      if($_REQUEST['status']==0 )
        	    {
        	           $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt  from grievances g where g.grievance_id=gt.grievance_id  and g.app_type_id='".$_REQUEST['app_type_id']."' and gt.emp_id='".$_REQUEST['ulbid']."' order by date_regd DESC";

        	    }
        	    if($_REQUEST['status']==1)
        	    {
        	        
        	        $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt  where g.grievance_status_id ='1' and g.app_type_id='2' and g.cat3_id='".$_REQUEST['dept_id']."' and g.ulbid='".$_REQUEST['ulbid']."'";
        	    }
        	    
        	   
        	    if($_REQUEST['status']==2)
        	    {
        	        
        	        $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt   where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['ulbid']."' and sla_status='1'";
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt   where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','9')  and gt.disposal_status !=5  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['ulbid']."' and sla_status='2'";
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	           $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt   where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['ulbid']."' and sla_status='1'";
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	        $query="select count(g.grievance_id) as num from grievances g , grievances_transactions gt   where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['ulbid']."' and sla_status='2'";
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	         $query="count(g.grievance_id) as num from grievances g , grievances_transactions gt from grievances g,grievances_transactions gt where  g.grievance_id=gt.grievance_id and app_type_id='1' and grievance_status_id='6' and gt.emp_id='".$_REQUEST['ulbid']."' and gt.disposal_status !=5 ";
        	    }
		}	
		
		
	//echo $query;	
		
		
	$result=mysqli_query($conn,$query);
		
		while($row=mysqli_fetch_assoc($result))
		{
	         $total_pages = $row['num'];
	          $row['num'];
	     }
		
		
		
		
		
		
	$targetpage = "empwiserep.php"; 	//your file name  (the name of this file)
		$limit = 20; 								//how many items to show per page
	  	$page = $_GET['page'];
		if($page) 
		 	$start = ($page - 1) * $limit; 			//first item to display on this page
		else
			$start = 0;	
		  $sql.= " LIMIT $start, $limit";
		  if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev = $page - 1;							//previous page is page - 1
		$next = $page + 1;							//next page is page + 1
	    $lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;	
		  
		 $pagination = "";
		if($lastpage > 1)
		{	
		    
			 $pagination .= "<div class=\"pagination\">";
			//previous button
			if ($page > 1) 
		
				$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$prev\"><< previous</a>";
					
			else
				$pagination.= "<span class=\"disabled\"><< previous</span>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
				$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$counter\">$counter</a>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
				$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$lastpage\">$lastpage</a>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$lastpage\">$lastpage</a>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$counter\">$counter</a>";					
					}
				}
			}
			
			//next button
			if ($page < $counter - 1) 
				$pagination.= "<a href=\"$targetpage?app_type_id=$app_type_id&status=$status&ulbid=$ulbid&dept_id=$dept_id&page=$next\">next >></a>";
			else
				$pagination.= "<span class=\"disabled\">next >></span>";
			 $pagination.= "</div>\n";
		  	
		}	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
		
			
				
		
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
		$tpl->display('empwiserep.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>
                            
                            
                            
                            
                            
                            