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
		   
		        $disposal_status_5=5;
		        $sla_status_1 = 1;$app_type_id_1=1;
	            $sla_status_2= 2;$grievance_status_id_6=6;
	            $in1 = 8; $in2 = 9;	$in3 = 3; $in4 = 2;
        	    if($_REQUEST['status']==0 )
        	    {
        	           $ulbid= $_REQUEST['ulbid'];
        	           $app_type_id= $_REQUEST['app_type_id'];
        	           $dept_id= $_REQUEST['dept_id'];
        	            
        	          $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=? and g.app_type_id=? and gt.disposal_status!=? and gt.dept_id=? and g.ulbid=? group by gt.emp_id");
        	          $sql->bind_param("siiis",htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($ulbid)));
        	         
        	    }
        	   
        	    if($_REQUEST['status']==2 )
        	    {
        	          $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and (g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=?) and gt.disposal_status !=?  and g.app_type_id=? and dept_id=? and sla_status=? and g.ulbid=? group by gt.emp_id");
        	          $sql->bind_param("iiiiiiis",htmlspecialchars(strip_tags($in1)),htmlspecialchars(strip_tags($in2)),htmlspecialchars(strip_tags($in3)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($app_type_id_1)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($sla_status_1)),htmlspecialchars(strip_tags($ulbid)));
        	          
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and (g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=?)  and gt.disposal_status !=?  and g.app_type_id=? and dept_id=? and sla_status=? and g.ulbid=? group by gt.emp_id");
        	        $sql->bind_param("iiiiiiis",htmlspecialchars(strip_tags($in1)),htmlspecialchars(strip_tags($in2)),htmlspecialchars(strip_tags($in3)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($app_type_id_1)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($sla_status_2)),htmlspecialchars(strip_tags($ulbid)));
        	     
        	    }
        	    
        	    if($_REQUEST['status']==4)
        	    {
        	         $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN(?)  and gt.disposal_status !=?  and g.app_type_id=? and dept_id=? and sla_status=? and g.ulbid=? group by gt.emp_id");
        	         $sql->bind_param("iiiiis",htmlspecialchars(strip_tags($in4)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($app_type_id_1)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($sla_status_1)),htmlspecialchars(strip_tags($ulbid)));
        	        
        	    }
        	    if($_REQUEST['status']==5)
        	    {
        	        $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN(?)  and gt.disposal_status !=?  and g.app_type_id=? and dept_id=? and sla_status=? and g.ulbid=? group by gt.emp_id");
        	         $sql->bind_param("iiiiis",htmlspecialchars(strip_tags($in4)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($app_type_id_1)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($sla_status_2)),htmlspecialchars(strip_tags($ulbid)));
        	        
        	    }
        	    
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql = $conn->prepare("select e.emp_id,count(g.grievance_id) as count,g.ulbid from grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id  and app_type_id=? and grievance_status_id=? and g.ulbid=? and gt.disposal_status !=? and dept_id=? group by gt.emp_id");
        	         $sql->bind_param("iisii",htmlspecialchars(strip_tags($app_type_id_1)),htmlspecialchars(strip_tags($grievance_status_id_6)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($dept_id)));
        	       
        	    }
        	    
		}
		else if($_REQUEST['app_type_id']==2)
		{
		  
		        $ulbid= $_REQUEST['ulbid'];
        	    $app_type_id= $_REQUEST['app_type_id'];
        	    $dept_id= $_REQUEST['dept_id'];
		        $disposal_status_5=5;$cat3_id=0;
		        $sla_status_1 = 1;$app_type_id_2=2;
	            $sla_status_2= 2;$grievance_status_id_6=6;
	            $in1 = 8; $in2 = 9;	$in3 = 3; $in4 = 2;
	            
		     if($_REQUEST['status']==0 )
        	    {
        	           $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id=? and gt.disposal_status!=? and gt.dept_id=? and cat3_id != ? group by gt.emp_id");
        	         $sql->bind_param("iiii",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($cat3_id)));
        	           
        	    }
        	   
        	    if($_REQUEST['status']==2 )
        	    {
        	            $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and (g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=?)  and gt.disposal_status !=?  and g.app_type_id=? and dept_id=? and sla_status=? and g.ulbid=? group by gt.emp_id");
        	         $sql->bind_param("iiiiiiis",htmlspecialchars(strip_tags($in1)),htmlspecialchars(strip_tags($in2)),htmlspecialchars(strip_tags($in3)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($app_type_id_2)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($sla_status_1)),htmlspecialchars(strip_tags($ulbid)));
        	         
        	    }
        	    if($_REQUEST['status']==3)
        	    {
        	        $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and (g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=?)  and gt.disposal_status !=?  and g.app_type_id=? and dept_id=? and sla_status=? and g.ulbid=? group by gt.emp_id");
        	        $sql->bind_param("iiiiiiis",htmlspecialchars(strip_tags($in1)),htmlspecialchars(strip_tags($in2)),htmlspecialchars(strip_tags($in3)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($app_type_id_2)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($sla_status_2)),htmlspecialchars(strip_tags($ulbid)));
        	        
        	    }
        	    
        	    if($_REQUEST['status']==4)
        	    {
        	        $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN(?)  and gt.disposal_status !=?  and g.app_type_id=? and dept_id=? and sla_status=? and g.ulbid=? group by gt.emp_id");
        	        $sql->bind_param("iiiiis",htmlspecialchars(strip_tags($in4)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($app_type_id_2)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($sla_status_1)),htmlspecialchars(strip_tags($ulbid)));
        	         
        	    }
        	    if($_REQUEST['status']==5)
        	    {   
        	        $sql = $conn->prepare("select count(g.grievance_id) as count,gt.emp_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN(?)  and gt.disposal_status !=? and g.app_type_id=? and dept_id=? and sla_status=? and g.ulbid=? group by gt.emp_id");
        	         $sql->bind_param("iiiiis",htmlspecialchars(strip_tags($in4)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($app_type_id_2)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($sla_status_2)),htmlspecialchars(strip_tags($ulbid)));
        	       
        	    }
        	    
        	    if($_REQUEST['status']==6)
        	    {
        	        $sql = $conn->prepare("select e.emp_id,count(g.grievance_id) as count,g.ulbid from grievances g,grievances_transactions gt  where g.grievance_id=gt.grievance_id  and app_type_id=? and grievance_status_id=? and g.ulbid=? and gt.disposal_status !=? and dept_id=? group by gt.emp_id");
        	        $sql->bind_param("iisii",htmlspecialchars(strip_tags($app_type_id_1)),htmlspecialchars(strip_tags($grievance_status_id_6)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($disposal_status_5)),htmlspecialchars(strip_tags($dept_id)));
        	       
        	    }
		}
		
			   			
				 	$sql->execute();
		            $rs=$sql->get_result();
				 while($row = $rs->fetch_assoc())
				 {
				
			
					 $data[$row['emp_id']]['count']+=$row['count'];
					 $tot+=$row['count'];
					
				 
				}
				
			$tpl->assign('tot',$tot);
			$tpl->assign('resolved_beyond_sla',$resolved_beyond_sla);
		        
        $dept_id= $_REQUEST['dept_id'];	
        	    
		$sql = $conn->prepare("select * from emp_mst where emp_dept=?");
		$sql->bind_param("i",htmlspecialchars(strip_tags($dept_id)));
		$sql->execute();
		$rs=$sql->get_result();
		
				while($row = $rs->fetch_assoc())
				{
				
			         $ulb_list[$row['emp_id']]=$row['emp_name'];
				}
		 $sql->close();
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
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>
                      
                            