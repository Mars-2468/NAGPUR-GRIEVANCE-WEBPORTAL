<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		
		
		
		$sql2 ="SELECT emp_dept,emp.emp_id FROM `emp_map` emp, emp_mst e WHERE emp.emp_id=e.emp_id and `emp_id2` LIKE '".$_SESSION['emp_id']."' and emp_dept='".$_REQUEST['dept_id']."' group by emp.emp_id";
		$sql3 ="SELECT emp_dept,emp.emp_id2 FROM `emp_map` emp, emp_mst e WHERE emp.emp_id2=e.emp_id and `emp_id3` LIKE '".$_SESSION['emp_id']."' and emp_dept='".$_REQUEST['dept_id']."' group by emp.emp_id2";
		$sql4 ="SELECT emp_dept,emp.emp_id3 FROM `emp_map` emp, emp_mst e WHERE emp.emp_id3=e.emp_id and `emp_id4` LIKE '".$_SESSION['emp_id']."' and emp_dept='".$_REQUEST['dept_id']."' group by emp.emp_id3";
		
		    $rs2=mysqli_query($conn,$sql2);
			while($row = mysqli_fetch_assoc($rs2))
			    {
				    
				    $dept_ids[$row['emp_dept']] = $row['emp_dept'];
					$emp_ids[$row['emp_id']] = $row['emp_id'];
			    }
			$rs3=mysqli_query($conn,$sql3);
			while($row = mysqli_fetch_assoc($rs3))
			    {
				    
				    $dept_ids[$row['emp_dept']] = $row['emp_dept'];
					$emp_ids[$row['emp_id2']] = $row['emp_id2'];
			    }
			$rs4=mysqli_query($conn,$sql4);
			while($row = mysqli_fetch_assoc($rs4))
			    {
				    
				    $dept_ids[$row['emp_dept']] = $row['emp_dept'];
					$emp_ids[$row['emp_id3']] = $row['emp_id3'];
			    }
				
				
			$ids = join("','",$dept_ids); 
			
			$ids = $_REQUEST['dept_id'];
			$empids = join("','",$emp_ids); 
			
			
			
		
			
		
		
		 $sql ="select COUNT(DISTINCT gt.grievance_id) as count,disposal_status,sla_status,gt.emp_id from grievances g, grievances_transactions gt,emp_mst e where 
		                g.grievance_id=gt.grievance_id and gt.emp_id=e.emp_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and gt.disposal_status !='5'";
		                
				
		                
		              
		                
		                
		  if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			            $tpl->assign('fdate',date('Y-m-d',strtotime($_POST['f_date'])));
		                $tpl->assign('tdate',date('Y-m-d',strtotime($_POST['t_date'])));
			        }
			        
          }
          
			        
			       $sql.=" and e.emp_dept in ('$ids') and gt.emp_id in('$empids') group by gt.emp_id,gt.disposal_status,g.sla_status";
				   
				 
				  echo $sql;
			  
         
			if($rs=mysqli_query($conn,$sql))
			{
			  while($row = mysqli_fetch_assoc($rs))
			    {
				  
					
					$data[$row['emp_id']][$row['disposal_status']][$row['sla_status']]['count']+=$row['count'];
					$data[$row['emp_id']]['count']+=$row['count'];
					
					
					
					
					
			    }
		 	}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
			
			
			
			
				
			
        
      
		
	       $sql="select * from emp_mst where ulbid='".$_SESSION['ulbid']."' and emp_dept in ('$ids') and emp_id in('$empids')";
				
			if($rs=mysqli_query($conn,$sql))
			{
				while($row = mysqli_fetch_assoc($rs))
					$dept_list[$row['emp_id']]=$row['emp_name'];
			}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
				
			
			
			
			
			$sql="select * from grievance_status_mst";
			if($rs=mysqli_query($conn,$sql))
			{
				while($row = mysqli_fetch_assoc($rs))
					$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
				
				
				$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		  $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
		  
		  
	     $tpl->assign('users_count',$users_count);
	//	print_r($online_applications);
		
		
		$tpl->assign('zone_ids',$zone_ids);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('street_ids',$street_ids);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet','3'=>'Both'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('tot',$tot);
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);
		$tpl->assign('dept_id1',$_REQUEST['dept_id']);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
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
		$tpl->display('level_dept_empwise.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>	