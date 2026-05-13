<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		$app_type_id=htmlspecialchars(strip_tags($_REQUEST['app_type_id']));
		$emp_id=htmlspecialchars(strip_tags($_REQUEST['emp_id']));
      //	    echo	$ulbid=$_SESSION['ulbid'];
	 	$status=htmlspecialchars(strip_tags($_REQUEST['status']));
		$dept_id=htmlspecialchars(strip_tags($_REQUEST['dept_id']));
		
		
		if($_REQUEST['status'] !='13')
		{
		
	
		      $sql ="select g.*,gt.emp_id,gt.alloted_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid=? and 
		      g.app_type_id=? and g.grievance_status_id=? and gt.dept_id=? and gt.emp_id=? and gt.disposal_status !=? order by grievance_id DESC";
		      
		      	$query=$conn->prepare($sql);
		      	$ulbid=strip_tags($_REQUEST['ulbid']);
               	$app_type_id=strip_tags($_REQUEST['app_type_id']);
               	$grievance_status_id=strip_tags($_REQUEST['status']);
               	$dept_id=strip_tags($_REQUEST['dept_id']);
               	$emp_id=strip_tags($_REQUEST['emp_id']);
               	
               	$disposal_status=5;
		      	$query->bind_param("siiiii",$ulbid,$app_type_id,$grievance_status_id,$dept_id,$emp_id,$disposal_status);
		      
		      
	
		}
		else
		{
		    $sql ="select g.*,gt.emp_id,gt.alloted_date,gt.disposed_date from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid=? and 
		      g.app_type_id=? and gt.dept_id=? and gt.emp_id=? and is_reopened_yn=? and g.grievance_status_id =? order by grievance_id DESC";
		      	$query=$conn->prepare($sql);
		      	$ulbid=strip_tags($_REQUEST['ulbid']);
               	$app_type_id=strip_tags($_REQUEST['app_type_id']);
               	 	$dept_id=strip_tags($_REQUEST['dept_id']);
               	$emp_id=strip_tags($_REQUEST['emp_id']);
               	$is_reopened_yn=1;
		      	$grievance_status_id=13;
		      		$query->bind_param("siiiii",$ulbid,$app_type_id,$dept_id,$emp_id,$is_reopened_yn,$grievance_status_id);
		      
		      
		      
		      
		}
	
		
		$adjacents = 5;
			if($_REQUEST['status']==0)
		{
		     $query ="select count(g.grievance_id) as num,g.*,gt.emp_id from grievances g, grievances_transactions gt where 
		    g.grievance_id=gt.grievance_id  and g.ulbid=? and g.app_type_id=? and 
		    gt.disposal_status!=? and gt.dept_id=? and gt.emp_id=?";
		    
		      	$query=$conn->prepare($sql);
		      	$ulbid=strip_tags($_SESSION['ulbid']);
               	$app_type_id=strip_tags($_REQUEST['app_type_id']);
               	$disposal_status=5;
               	$dept_id=strip_tags($_REQUEST['dept_id']);
               	$emp_id=strip_tags($_REQUEST['emp_id']);
               	$query->bind_param("siiii",$ulbid,$app_type_id,$disposal_status,$dept_id,$emp_id);
		    
		}
		else if($_REQUEST['status']==2)
		{
		    $query ="select count(g.grievance_id) as num,g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid=? and g.app_type_id=? and gt.disposal_status!=? and gt.dept_id=? and gt.emp_id=? and grievance_status_id =?";
		    	$query=$conn->prepare($sql);
		    	$ulbid=strip_tags($_SESSION['ulbid']);
               	$app_type_id=strip_tags($_REQUEST['app_type_id']);
               	$disposal_status=5;
               	$dept_id=strip_tags($_REQUEST['dept_id']);
               	$emp_id=strip_tags($_REQUEST['emp_id']);
		    $grievance_status_id=2;
		    $query->bind_param("siiiii",$ulbid,$app_type_id,$disposal_status,$dept_id,$emp_id,$grievance_status_id);
		    
		}
		else if($_REQUEST['status']==3)
		{
          
               $query="select count(*) as num,g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=? and g.app_type_id=? and gt.disposal_status!=? and gt.dept_id=? and gt.emp_id=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =?)";
           $query=$conn->prepare($sql);
           
           $ulbid=055;
           $app_type_id=2;
           $disposal_status=5;
           $dept_id=98;
           $emp_id=2110;
           $id3=3;
           $id9=9;
        $id6=6;
             $id10=10;
             
              $query->bind_param("siiiiiiii",$ulbid,$app_type_id,$disposal_status,$dept_id,$emp_id,$id3,$id9,$id6,$id10);
           
        }
		
		else if($_REQUEST['status']==4)
		{
		    $query ="select count(g.grievance_id) as num,g.*,gt.emp_id from grievances g, grievances_transactions gt where g.grievance_id=gt.grievance_id  and g.ulbid=? and g.app_type_id=? and gt.disposal_status!=? and gt.dept_id=? and gt.emp_id=?  and grievance_status_id =?";
		     $query=$conn->prepare($sql);
		     
		     $ulbid=strip_tags($_SESSION['ulbid']);
		     $app_type_id=strip_tags($_REQUEST['app_type_id']);
		     $disposal_status=5;
		     $dept_id=strip_tags($_REQUEST['dept_id']);
		     $emp_id=strip_tags($_REQUEST['emp_id']);
		     $grievance_status_id=4;
		     $query->bind_param("siiiii",$ulbid,$app_type_id,$disposal_status,$dept_id,$emp_id,$grievance_status_id);
		    
		    
		    
		    
		}

		 	$query->execute();
	    $rs=$query->get_result();
		
		while($row=$rs->fetch_assoc())
		{
	         $total_pages = $row['num'];
	         
	     }
		
		
			$query->close();
		
	
		 
		
			
         $sql="select cs_id,comp_desc from category3_mst where ulbid=?";
         	$query=$conn->prepare($sql);
         		$ulbid=strip_tags($_SESSION['ulbid']);
		$query->bind_param("s",$ulbid);
		if($_REQUEST['app_type_id']=='1')
		{
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		 $query=$conn->prepare($sql);
		}
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
			$query->close();
		 
	



		
	              $sql ="select * from dept_mst where dept_id =?";
	              
	              	$query=$conn->prepare($sql);
	              	$dept_id=strip_tags($_REQUEST['dept_id']);
	              	$query->bind_param("i",$dept_id);
			$query->execute();
			 $rs=$query->get_result();
				while($row = $rs->fetch_assoc())
				{
				    $dept_list[$row['dept_id']]=$row['dept_desc'];
				}
					$query->close();
		 
				$sql ="select * from ulbmst where ulbid =?";
					$query=$conn->prepare($sql);
         		$ulbid=strip_tags($_REQUEST['ulbid']);
         		$query->bind_param("s",$ulbid);
				$query->execute();
			 $rs=$query->get_result();
				
				
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
					$query->close();
				$sql ="select emp_id,emp_name from emp_mst where emp_id =?";
					$query=$conn->prepare($sql);
         		$emp_id=strip_tags($_REQUEST['emp_id']);
         		$query->bind_param("i",$emp_id);
				$query->execute();
			 $rs=$query->get_result();
				while($row =$rs->fetch_assoc())
				{
				    $emp_list[$row['emp_id']]=$row['emp_name'];
				}
				$query->close();
				$tpl->assign('dept_list',$dept_list);
				$tpl->assign('ulb_list',$ulb_list);
				$tpl->assign('emp_list',$emp_list);
				
				$tpl->assign('dept_id',$_REQUEST['dept_id']);
				$tpl->assign('emp_id',$_REQUEST['emp_id']);
				$tpl->assign('ulbid',$_REQUEST['ulbid']);
				
			
			
			$sql="select * from grievance_status_mst";
			$query=$conn->prepare($sql);
			
			
			if($query->execute())
			{
			     $rs=$query->get_result();
				while($row = $rs->fetch_assoc())
					$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}
			$query->close();
				
				
				$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
				
					$query=$conn->prepare($sql);
         		$ulbid=strip_tags($_SESSION['ulbid']);
		$query->bind_param("s",$ulbid);
				$query->execute();
			 $rs=$query->get_result();
				 
	
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
			$query->close();

	$tpl->assign('user_type',$_SESSION['user_type']);
		$conn->close();
		$tpl->assign('online_applications',$online_applications);
		
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('status_list',$status_list);
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);		
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('user_dept',$_SESSION['user_dept']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('grievances_reopened.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>	