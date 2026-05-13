<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	
	$tpl=new Smarty();
	 
	
	
	
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		
		require_once('prepare_connection.php');
		
		
	        
	
        	    if($_REQUEST['status']==0)
        	    {
        	        
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where cat3_id !=? group by ulbid";
        	        
        	        $query=$conn->prepare($sql);
        	        $cat3_id = 0;
        	        $query->bind_param("i",$cat3_id);
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and 
        	             d.rdma=? and cat3_id !=? group by g.ulbid order by ulbname";
        	             
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $query->bind_param("si",$rdma,$cat3_id);
        	             
        	        }
        	        
        	    }
        	    
        	    if($_REQUEST['status']==1)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where  
        	         grievance_status_id=? and cat3_id !=? group by ulbid";
        	         
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $query->bind_param("ii",$grievance_status_id,$cat3_id);
            	        
            	        
        	         
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and 
        	             grievance_status_id=? and cat3_id !=? and d.rdma=? group by g.ulbid";
        	             
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $query->bind_param("iis",$grievance_status_id,$cat3_id,$rdma);
        	             
        	             
        	             
        	        }
        	    }
        	    if($_REQUEST['status']==2)
        	    {
        	       $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN(?) and 
        	         sla_status=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("sii",$inclause,$sla_status,$cat3_id);
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid  from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	            d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("ssii",$inclause,$rdma,$sla_status,$cat3_id);
        	            
        	            
        	        }
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN(?) and 
        	         sla_status=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("sii",$inclause,$sla_status,$cat3_id);
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	             d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
        	             
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("ssii",$inclause,$rdma,$sla_status,$cat3_id);
        	             
        	             
        	             
        	        }
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	       $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN(?) and 
        	         sla_status=? and cat3_id !=? group by ulbid";
        	        
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=2;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("iii",$grievance_status_id,$sla_status,$cat3_id);
        	      
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	             d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
        	             
        	             
        	             
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=2;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("isii",$grievance_status_id,$rdma,$sla_status,$cat3_id);
        	             
        	             
        	        }
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	         $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN(?) and 
        	         sla_status=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=2;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("iii",$grievance_status_id,$sla_status,$cat3_id);
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	             d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
        	             
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=2;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("isii",$grievance_status_id,$rdma,$sla_status,$cat3_id);
        	             
        	             
        	        }
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where  grievance_status_id=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=6;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("ii",$grievance_status_id,$cat3_id);
        	        
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid  and grievance_status_id=? and d.rdma=?  and cat3_id !=?
        	            group by ulbid";
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=6;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("isi",$grievance_status_id,$rdma,$cat3_id);
        	            
        	            
        	        }
        	    }
        	    
        	    /** rejected ***/
        	    
        	    if($_REQUEST['status']==10)
        	    {
        	        
        	          $sql="select count(grievance_id) as count,ulbid from grievances where  grievance_status_id=? and cat3_id !=? group by ulbid";
        	          
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=10;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("ii",$grievance_status_id,$cat3_id);
        	          
        	          
        	        
        	        if($_SESSION['user_type']== 'R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid  and grievance_status_id=? and d.rdma=? and cat3_id !=?
        	            group by g.ulbid";
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=10;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("isi",$grievance_status_id,$rdma,$cat3_id);
        	            
        	        }
        	        
        	        
        	        
        	    }
        	    
        	    /*** un resolvable  ***/
        	     
        	    
        	    if($_REQUEST['status']==11)
        	    {
        	        
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where  grievance_status_id=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=4;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("i",$grievance_status_id);
        	        
        	        
        	        
        	        if($_SESSION['user_type']== 'R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and grievance_status_id=? and d.rdma=? and cat3_id !=?
        	            group by g.ulbid";
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=1;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=4;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("isi",$grievance_status_id,$rdma,$cat3_id);
        	            
        	            
        	            
        	        }
        	        
        	        
        	    }
        	    
        	  
        	    
        	    
		
		
		 if($_REQUEST['app_type_id']==2)
		{
        	    if($_REQUEST['status']==0)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=4;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("ii",$app_type_id,$cat3_id);
        	        
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and app_type_id=? and d.rdma=? and cat3_id !=? group by g.ulbid order by ulbname";
        	            
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=4;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("isi",$app_type_id,$rdma,$cat3_id);
            	        
        	        }
        	    }
        	    if($_REQUEST['status']==1)
        	    {
        	         $sql="select count(grievance_id) as count,ulbid from grievances  where  
        	        app_type_id=? and grievance_status_id=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("iii",$app_type_id,$grievance_status_id,$cat3_id);
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and u.distid=d.distid and  app_type_id='2' and grievance_status_id='1' and cat3_id !='0' and d.rdma='".mysqli_real_escape_string($conn,$_SESSION['uid'])."' group by g.ulbid";
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("iiis",$app_type_id,$grievance_status_id,$cat3_id,$rdma);
        	        }
        	    }
        	    if($_REQUEST['status']==2)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN(?) and 
        	        app_type_id=? and sla_status=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("siii",$inclause,$app_type_id,$sla_status,$cat3_id);
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid  from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	            app_type_id=? and d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
        	            
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("sisii",$inclause,$app_type_id,$rdma,$sla_status,$cat3_id);
        	        }
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN(?) and 
        	        app_type_id=? and sla_status='2' and cat3_id !='0' group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=2;
            	        $query->bind_param("siii",$inclause,$app_type_id,$sla_status,$cat3_id);
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	            app_type_id=? and d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
        	            
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=1;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("sisii",$inclause,$app_type_id,$rdma,$sla_status,$cat3_id);
        	            
        	            
        	            
        	            
        	        }
        	    }
        	    if($_REQUEST['status']==4)
        	    {
        	       $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN('2') and 
        	        app_type_id=? and sla_status=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=2;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("iiii",$grievance_status_id,$app_type_id,$sla_status,$cat3_id);
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	            app_type_id=? and d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
        	            
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=2;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("iisii",$grievance_status_id,$app_type_id,$rdma,$sla_status,$cat3_id);
        	            
        	            
        	            
        	        }
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	         $sql="select count(grievance_id) as count,ulbid from grievances where 
        	        grievance_status_id IN(?) and 
        	        app_type_id=? and sla_status=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=2;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=1;
            	        $query->bind_param("iiii",$grievance_status_id,$app_type_id,$sla_status,$cat3_id);
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances g ,Districtmst d,ulbmst u where 
        	            g.ulbid=u.ulbid and u.distid=d.distid and grievance_status_id IN(?) and 
        	            app_type_id=? and d.rdma=? and sla_status=? and cat3_id !=? group by ulbid";
        	            
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=2;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=2;
            	        $query->bind_param("iisii",$grievance_status_id,$app_type_id,$rdma,$sla_status,$cat3_id);
        	            
        	            
        	            
        	            
        	        }
        	        
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql="select count(g.grievance_id) as count,g.ulbid from grievances  where app_type_id=? and grievance_status_id=? and cat3_id !=? group by ulbid";
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=6;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=2;
            	        $query->bind_param("iii",$app_type_id,$grievance_status_id,$cat3_id);
        	        
        	        
        	        
        	        
        	        
        	        if($_SESSION['user_type']=='R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id=? and grievance_status_id=? and d.rdma=? and sla_status=? and cat3_id !=?
        	            group by ulbid";
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=6;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=2;
            	        $query->bind_param("iisii",$app_type_id,$grievance_status_id,$rdma,$sla_status,$cat3_id);
        	            
        	            
        	            
        	            
        	            
        	        }
        	    }
        	    
        	    /** rejected ***/
        	    
        	    if($_REQUEST['status']==10)
        	    {
        	        
        	         $sql="select count(grievance_id) as count,ulbid from grievances where app_type_id=? and grievance_status_id=? and cat3_id !=? group by ulbid";
        	         
        	         
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=10;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=2;
            	        $query->bind_param("iii",$app_type_id,$grievance_status_id,$cat3_id);
        	         
        	        
        	        if($_SESSION['user_type']== 'R')
        	        {
        	            $sql="select count(g.grievance_id) as count,g.ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id=? and grievance_status_id=? and d.rdma=? and cat3_id !=?
        	            group by g.ulbid";
        	            
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=10;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=2;
            	        $query->bind_param("iisi",$app_type_id,$grievance_status_id,$rdma,$cat3_id);
        	            
        	            
        	        }
        	        
        	        
        	        
        	    }
        	    
        	    /*** un resolvable  ***/
        	     
        	    
        	    if($_REQUEST['status']==11)
        	    {
        	        
        	        $sql="select count(grievance_id) as count,ulbid from grievances  where app_type_id=? and grievance_status_id=? group by ulbid";
        	        
        	        
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=4;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=2;
            	        $query->bind_param("ii",$app_type_id,$grievance_status_id);
        	        
        	        
        	        if($_SESSION['user_type']== 'R')
        	        {
        	            $sql="select count(grievance_id) as count,ulbid from grievances g,ulbmst u,Districtmst d where g.ulbid=u.ulbid and
        	            u.distid=d.distid and app_type_id=? and grievance_status_id=? and d.rdma=? and cat3_id !=?
        	            group by g.ulbid";
        	            
        	            $query=$conn->prepare($sql);
            	        $app_type_id=2;
            	        $rdma = $_SESSION['uid'];
            	        $cat3_id =0;
            	        $grievance_status_id=4;
            	        $rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
            	        $status_ids = array(3,8,9);
			            $inclause = implode(',', $status_ids);
			            $sla_status=2;
            	        $query->bind_param("iisi",$app_type_id,$grievance_status_id,$rdma,$cat3_id);
        	            
        	            
        	            
        	        }
        	        
        	        
        	    }
        	    
        	  
        	    
        	    
		}
		
		
		
			$query->execute();
			$rs=$query->get_result();
	
		
		
		
			   			
				 
				 while($row = $rs->fetch_assoc())
				 {
				
			
				
				 
			
					 $data[$row['ulbid']]['count']+=$row['count'];
					 $tot+=$row['count'];
					
				
				 
				 
				}	
				
		
			$tpl->assign('tot',$tot);
			$tpl->assign('resolved_beyond_sla',$resolved_beyond_sla);
				
		
		if($_REQUEST['status'] == 0 || $_REQUEST['status'] == 1 || $_REQUEST['status'] == 2 || $_REQUEST['status'] == 6 || $_REQUEST['status'] == 10 || $_REQUEST['status'] == 11)
		{
		
				$query->execute();
			
	        $rs=$query->get_result();
	        while($row = $rs->fetch_assoc())
    		 {
    		   
    		   $data[$row['ulbid']]['count']=$row['count'];
    		   $total+=$row['count'];
    		  
    		 }
		}
            $tpl->assign('total',$total);
    	
		$query->close();
		
		$sql ="select u.* from ulbmst u,Districtmst d where u.distid=d.distid";
		$query=$conn->prepare($sql);
		if($_SESSION['user_type']=='R')
		{
		    $sql.=" and d.rdma='".mysqli_real_escape_string($conn,$_SESSION['uid'])."'";
			$rdma = mysqli_real_escape_string($conn,$_SESSION['uid']);
			$query=$conn->prepare($sql);
			$query->bind_param("s",$rdma);
		}
		$query->execute();
		$rs=$query->get_result();
				while($row = $rs->fetch_assoc())
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
		$tpl->display('cdma_ulbwise_report1.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>
                            
                            
                            
                            
                            
                            