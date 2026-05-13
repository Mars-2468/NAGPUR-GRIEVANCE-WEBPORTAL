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
		require_once('connection.php');
		$conn=getconnection();
		
		 
		   
		 
		if($_REQUEST['app_type_id']==1)
		{ 
		   
		             $ulbid =$_REQUEST['ulbid'];
		             $app_type_id =$_REQUEST['app_type_id'];
		             $disposal_status=5;$grievance_status_id=1;
		             $in1 = 3; $in2 = 8;	$in3 = 10; $in4 =4; $in5 =6; 
		             $app_type_id_1=1;
		             
        	    if($_REQUEST['status']==0 )
        	    {   
        	            $sql=$conn->prepare("select count(g.grievance_id) as count,e.emp_dept from grievances g, grievances_transactions gt,emp_mst e where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.app_type_id=? and gt.disposal_status!=? and g.ulbid=? group by e.emp_dept");
	                    $sql->bind_param("iis",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($disposal_status)),htmlspecialchars(strip_tags($ulbid)));
        	          
        	    }
        	     if($_REQUEST['status']==1 )
        	    {
        	           $sql=$conn->prepare("select count(g.grievance_id) as count,cat3_id as emp_dept from grievances g, cs_mst  c where  g.cat3_id=c.cs_id and g.app_type_id=? and  grievance_status_id=? and g.ulbid=? group by cat3_id");
	                   $sql->bind_param("iis",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)));
        	           
        	    }
        	   
        	    if($_REQUEST['status']==2 || $_REQUEST['status']==3)
        	    {
        	          $sql=$conn->prepare("select e.emp_dept,g.ulbid,g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status,ccm.cutt_off_time as target_days from emp_mst e ,grievances g , grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=?)  and gt.disposal_status !=?  and g.app_type_id=? and g.ulbid=?");
	                   $sql->bind_param("iiiiiis",htmlspecialchars(strip_tags($in1)),htmlspecialchars(strip_tags($in2)),htmlspecialchars(strip_tags($in3)),htmlspecialchars(strip_tags($in4)),htmlspecialchars(strip_tags($disposal_status)),htmlspecialchars(strip_tags($app_type_id_1)),htmlspecialchars(strip_tags($ulbid)));
        	          
        	    }
        	    if($_REQUEST['status']==4 || $_REQUEST['status']==5)
        	    {
        	         
        	         $sql=$conn->prepare("select e.emp_dept,g.ulbid,g.grievance_id,app_type_id,date_regd,disposed_date,ccm.cutt_off_time as target_days,DATEDIFF(NOW(),date_regd) AS target,ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,emp_mst e where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and gt.emp_id=e.emp_id and (g.grievance_status_id!=? or g.grievance_status_id!=? or g.grievance_status_id!=? or g.grievance_status_id!=? or g.grievance_status_id!=?)  and gt.disposal_status !=?  and app_type_id=? and g.ulbid=?");
	                 $sql->bind_param("iiiiiiis",htmlspecialchars(strip_tags($in1)),htmlspecialchars(strip_tags($in2)),htmlspecialchars(strip_tags($in3)),htmlspecialchars(strip_tags($in4)),htmlspecialchars(strip_tags($in5)),htmlspecialchars(strip_tags($disposal_status)),htmlspecialchars(strip_tags($app_type_id_1)),htmlspecialchars(strip_tags($ulbid)));
        	        
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	         $sql=$conn->prepare("select count(g.grievance_id) as count,e.emp_dept from grievances g, grievances_transactions gt,emp_mst e where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.app_type_id=? and gt.disposal_status!=? and g.ulbid=? and g.grievance_status_id=? group by e.emp_dept");
	                 $sql->bind_param("iisi",$app_type_id,$disposal_status,$ulbid,$in5);
        	      
        	    }
        	    
		}
		else if($_REQUEST['app_type_id']==2)
		{
		   
		             $ulbid =$_REQUEST['ulbid'];
		             $app_type_id =$_REQUEST['app_type_id'];
		             $disposal_status=5;$grievance_status_id=1;$grievance_status_id_6=6;
		             $in1 = 3; $in2 = 8;	$in3 = 10; $in4 =4; $in5 =6; $in6 =9;
		             $app_type_id_1=1; $app_type_id_2=2;
		     if($_REQUEST['status']==0)
        	    {
        	         $sql=$conn->prepare("select e.emp_dept,count(g.grievance_id) as count,gt.emp_id from grievances g, grievances_transactions gt,emp_mst e where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.ulbid=? and g.app_type_id=? and gt.disposal_status!=? and g.ulbid=? group by e.emp_dept");
	                 $sql->bind_param("siis",htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($disposal_status)),htmlspecialchars(strip_tags($ulbid)));
        	         
        	    }
        	    if($_REQUEST['status']==1 )
        	    {
        	        $sql=$conn->prepare("select count(g.grievance_id) as count,cat3_id as emp_dept from grievances g, category3_mst  c where  g.cat3_id=c.cs_id and g.app_type_id=? and  grievance_status_id=? and g.ulbid=? group by cat3_id");
	                 $sql->bind_param("iis",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)));
        	       
        	    }
        	    if($_REQUEST['status']==2 || $_REQUEST['status']==3)
        	    {
        	        $sql=$conn->prepare("select e.emp_dept,g.ulbid,g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status,ccm.cutt_of_time as target_days from emp_mst e ,grievances g , grievances_transactions gt,category3_mst ccm where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=?)  and gt.disposal_status !=?  and g.app_type_id=? and g.ulbid=?");
	                 $sql->bind_param("iiiiiis",htmlspecialchars(strip_tags($in1)),htmlspecialchars(strip_tags($in6)),htmlspecialchars(strip_tags($in3)),htmlspecialchars(strip_tags($in4)),htmlspecialchars(strip_tags($disposal_status)),htmlspecialchars(strip_tags($app_type_id_2)),htmlspecialchars(strip_tags($ulbid)));
        	       
        	        
        	    }
        	    if($_REQUEST['status']==4 || $_REQUEST['status']==5)
        	    {
        	        $sql=$conn->prepare("select e.emp_dept,g.ulbid,g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(NOW(),date_regd) AS target,gt.disposal_status,ccm.cutt_of_time as target_days from emp_mst e ,grievances g , grievances_transactions gt,category3_mst ccm where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.cat3_id=ccm.cs_id and (g.grievance_status_id=? or g.grievance_status_id!=? or g.grievance_status_id!=? or g.grievance_status_id!=? or g.grievance_status_id!=?)  and gt.disposal_status !=?  and g.app_type_id=? and g.ulbid=?");
	                 $sql->bind_param("iiiiiiis",htmlspecialchars(strip_tags($in1)),htmlspecialchars(strip_tags($in5)),htmlspecialchars(strip_tags($in6)),htmlspecialchars(strip_tags($in3)),htmlspecialchars(strip_tags($in4)),htmlspecialchars(strip_tags($disposal_status)),htmlspecialchars(strip_tags($app_type_id_2)),htmlspecialchars(strip_tags($ulbid)));
        	       
        	        
        	    }
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql=$conn->prepare("select count(g.grievance_id) as count,e.emp_dept from grievances g, grievances_transactions gt,emp_mst e where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.app_type_id=? and gt.disposal_status!=? and g.ulbid=? and g.grievance_status_id=? group by e.emp_dept");
	                 $sql->bind_param("iisi",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($disposal_status)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($grievance_status_id_6)));
        	        
        	        
        	    }
		}
				
				  $sql->execute();
	                $rs=$sql->get_result();
				 while($row = $rs->fetch_assoc())
				 {
				
				if($row['target'] <= $row['target_days'])
					 {
					    
					     
					 $data[$row['emp_dept']]['resolved_within_sla']+=1;
					 $resolved_within_sla+=1;
					 }
					 else
					 {
					    
					 $data[$row['emp_dept']]['resolved_beyond_sla']+=1;
					 $resolved_beyond_sla+=1;
					 }
				
				 
				 
				}	
				
		
			$tpl->assign('resolved_within_sla',$resolved_within_sla);
			$tpl->assign('resolved_beyond_sla',$resolved_beyond_sla);
				
		
		if($_REQUEST['status'] == 0 || $_REQUEST['status'] == 1 || $_REQUEST['status'] == 2 || $_REQUEST['status'] == 6 )
		{
		   
		    
		        $sql->execute();
	           $rs=$sql->get_result();
			
			
	        while($row = $rs->fetch_assoc())
    		 {
    		   
    		   $data[$row['emp_dept']]['count']=$row['count'];
    		   $total+=$row['count'];
    		  
    		 }
		}
            $tpl->assign('total',$total);
    	
				if($_REQUEST['status'] == 1)
				{
				
    				
    				  $sql=$conn->prepare("select * from cs_mst");
    				 
    				
    				 if($_REQUEST['app_type_id']=='2')
    				 {
    				     
    				      //echo $_REQUEST['ulbid'];
    				      
    				     $ulbid1 = $_SESSION['ulbid'];
    				     $sql=$conn->prepare("select cs_id,comp_desc as cs_desc from category3_mst where ulbid=?");
    				     $sql->bind_param("s",htmlspecialchars(strip_tags($ulbid1)));
    				      
    				     
    				 }
    		        
    		         $sql->execute();
    		         $rs = $sql->get_result();
    		         while($row = $rs->fetch_assoc())
    		         
    				{
    				
    			         $dept_list[$row['cs_id']]=$row['cs_desc'];
    				}
				}
				else
				{
				    $ulbid1 = $_SESSION['ulbid'];
				    $sql=$conn->prepare("select * from dept_mst where ulbid =?");
    				    $sql->bind_param("s",htmlspecialchars(strip_tags($ulbid1)));
				     
        		        $sql->execute();
    		         $rs = $sql->get_result();
    		         while($row = $rs->fetch_assoc())
    		         
        				{
        				
        			         $dept_list[$row['dept_id']]=$row['dept_desc'];
        				}
				}
				

		    $sql->close();
	     $tpl->assign('ulbid_sel',$_REQUEST['ulbid']);
		$tpl->assign('apptypes',array('1'=>'Complaints','2'=>'Services'));
	    $tpl->assign('status_desc',array('0'=>'Total Received','1'=>'Pending For Approval','2'=>'Completed Within SLA','3'=>'Completed Beyond SLA','4'=>'Pending Within SLA','5'=>'Pending Beyond SLA','6'=>'Financial Implication'));
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
		$tpl->display('ulb_cat_wise.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>
                            
                            
                            
                            
                            
                            