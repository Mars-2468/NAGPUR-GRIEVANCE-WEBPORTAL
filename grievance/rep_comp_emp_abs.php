<?php
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']))
	{
	    
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		 
		 //$sql ="select COUNT(g.grievance_id) as count,e.emp_id from grievances g, grievances_transactions gt,emp_mst e where g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='2' and gt.disposal_status!='5' and e.emp_dept='".$_REQUEST['dept_id']."' group by e.emp_id";
		 $sql="select COUNT(g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
		                g.grievance_id=gt.grievance_id and g.ulbid=? and g.app_type_id=? and 
		                gt.disposal_status!=?  and cat3_id !=?";
		                
		                $sql.=" group by gt.dept_id";
		                
		                
		                
		                 $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
                		 $app_type_id = 2;
                		 $disposal_status = 5;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("siii",$ulbid,$app_type_id,$disposal_status,$cat3_id);
                		  
		                
		                
		                
		 
			if($query->execute())
			{
			    $rs = $query->get_result();
			  while($row = $rs->fetch_assoc())
			    {
				$data[$row['emp_dept']]['count']=$row['count'];
			    }
		 	}
			

            
           
		 
	$sql ="select COUNT(g.grievance_id) as count1,dept_id as emp_dept,disposal_status,g.date_regd from grievances g, grievances_transactions gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid=? and g.app_type_id=? and gt.disposal_status!=? and cat3_id !=? ";
          
          $sql.="group by gt.dept_id,gt.disposal_status";
	
	                     $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
                		 $app_type_id = 2;
                		 $disposal_status = 5;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("siii",$ulbid,$app_type_id,$disposal_status,$cat3_id);
	 
	
	if($query->execute())
		{
		    $rs = $query->get_result();
		  while($row = $rs->fetch_assoc())
		    {
		     if($row['disposal_status']==3 || $row['disposal_status']==9 && $row['disposal_status']==6 && $row['disposal_status']==10)
			    {
			    $data_list[$row['emp_dept']]['completed']+=$row['count1'];
			    }
		     if($row['disposal_status']==4)
			    {
			    $data_list[$row['emp_dept']]['unresolved']=$row['count1'];
			    }
		     if($row['disposal_status']==2)
			    {
			    $data_list[$row['emp_dept']]['pending']+=$row['count1'];
			    }
						
		    }
	 	}
	
		
	       $sql="select emp_id,emp_name from emp_mst where emp_dept=?";
	       
	             $dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("i",$dept_id);
        		 $query->execute();
        		 
	       
	       
	       
	       
			if($rs = $query->get_result())
			{
				while($row = $rs->fetch_assoc())
					$emp_list[$row['emp_id']]=$row['emp_name'];
			}
		
			
			$sql="select * from grievance_status_mst";
			
			      
        		 $query = $conn->prepare($sql);
        		  
        		 $query->execute();
			
			
			if($rs = $query->get_result())
			{
				while($row = $rs->fetch_assoc())
					$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}
			
				$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
				
				
				 $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
				
				
				
				
	 
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
	 
		
	//	print_r($online_applications);
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
		
		$tpl->assign('status_list',$status_list);
		$tpl->assign('data_list',$data_list);		
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('user_dept',$_SESSION['user_dept']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('rep_comp_emp_abs.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>	