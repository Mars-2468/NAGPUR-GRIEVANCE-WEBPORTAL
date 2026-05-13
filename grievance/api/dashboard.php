<?php
session_start();
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	
  	if(isset($_REQUEST['emp_id']))
  	{
  	    /** splitting empid as empid and user type, here we get empid and user type seperated with - **/
  	    
  	     $arr=explode("-",$_REQUEST['emp_id']);
  	  
  	    /*** setting emp id after spit the stirng **/
  	    $_REQUEST['emp_id']=$arr[0];
  	    $_SESSION['emp_id']=$arr[0];
  	    
  	    /** assign user type **/
  	    $user_type=$arr[1];
  	    /** setting ulbid **/
  	    $ulbid=$arr[2];
  	    /** setting user id **/
  	    $user_id=$arr[3];
  	    
  	    
  	    
  	    
  	    /** select user details in case of login ulb or commissioner **/
  	    
  	    if($user_type== 'U')
  	    {
  	        $sql ="select user_id as emp_name,user_mobile as emp_mobile, user_dept as dept_desc, ulbname,usr.ulbid  from users usr, ulbmst u where usr.ulbid=u.ulbid and 
  	        usr.ulbid='".$ulbid."' and usr.user_id='".$user_id."'";
  	    }
  	    else
  	    {
  	         $sql = "SELECT e.emp_id from emp_mst e, dept_mst d, desg_mst de, ulbmst u  where e.emp_mobile = '".$user_id."' 
  	        and e.emp_dept = d.dept_id and e.emp_desg = de.desg_id and e.ulbid = u.ulbid and delete_status='0'";
  	        
  	        $sql3 = "SELECT e.emp_id from emp_mst_od e, dept_mst d, desg_mst de, ulbmst u  where e.emp_mobile = '".$user_id."' 
  	        and e.emp_dept = d.dept_id and e.emp_desg = de.desg_id and e.ulbid = u.ulbid and delete_status='0'";
  	    }
  	    
  	    
  	    //echo $sql3;
  		
  		$res = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($res);
		while($row = mysqli_fetch_array($res))
		{
		     	$empids[] = $row['emp_id'];
		}
		
		// Retrieving details from on duputation tables
		
		$res3 = mysqli_query($conn,$sql3);
		$nr = mysqli_num_rows($res3);
		if($nr > 0)
		{
		    while($row = mysqli_fetch_array($res3))
    		{
    		     $empids[] = $row['emp_id'];
    		}
		}
		
  		$ids = join("','",$empids); 
  		$empid= $_REQUEST['emp_id'];
  		 if($user_type == 'U')
  	    {
  	        $sql="SELECT COUNT(DISTINCT grievance_id) as  date_regd FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."'";
  	    }
  	    else
  	    {
		$sql="SELECT IFNULL(count(DISTINCT g.grievance_id),0) as date_regd FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and 
		gt.emp_id IN('$ids') and g.app_type_id = 1 and gt.disposal_status !=5 and (is_reopened_yn='0' or is_reopened_yn is NULL)";
		
		
  	    }
  	    //echo $sql;
	  	$res = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($res);
		while($row = mysqli_fetch_array($res))
		{
		     	$response['total_assigned'] = $row['date_regd'];
		}
		//$sql="select IFNULL(count(g.grievance_id),0) as grievance_id,g.app_type_id  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id NOT IN('3','8')  and gt.emp_id='".$empid."' and TIMESTAMPDIFF(HOUR,date_regd,now()) <= 24 and g.app_type_id = 1";
		 if($user_type == 'U')
  	    {
  	         $sql="SELECT COUNT(grievance_id) as  grievance_id FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."' and 
  	        grievance_status_id IN('2') and sla_status='1'";
  	    }
  	    else
  	    {
		$sql="select IFNULL(count(g.grievance_id),0) as grievance_id,g.app_type_id  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and 
		g.grievance_status_id IN('2')  and gt.emp_id IN('$ids') and sla_status='1' and g.app_type_id = 1 and gt.disposal_status !=5 and (is_reopened_yn='0' or is_reopened_yn is NULL)";
		
		
		//$sql="select g.*,c.cat_id,DATEDIFF(NOW(),date_regd) AS target,gt.ts, ccm.cutt_off_time as target_days,rca,ca,disposal_remarks,gt.updated_by from grievances g,cs_mst c,grievances_transactions gt, comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.cat3_id=c.cs_id and g.grievance_status_id IN('2') and g.app_type_id='1' and gt.emp_id='".$emp_id."' and gt.disposal_status !=5 having target <= target_days order by date_regd DESC";
		
  	    }
		
		$rs=mysqli_query($conn,$sql);						 
		while($row = mysqli_fetch_assoc($rs))
		{		
			$response['pending_within_sla']=$row['grievance_id'];
		}
		
		
		
		
		
		//$sql="select IFNULL(count(g.grievance_id),0) as grievance_id,g.app_type_id  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id NOT IN('3','8')  and gt.emp_id='".$empid."' and TIMESTAMPDIFF(HOUR,date_regd,now()) > 24 and g.app_type_id = 1";
		
		 if($user_type == 'U')
  	    {
  	        $sql="SELECT COUNT(grievance_id) as  grievance_id FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."' and 
  	        grievance_status_id IN('2') and sla_status='2'";
  	    }
  	    else
  	    {
	/*	$sql="select IFNULL(count(g.grievance_id),0) as grievance_id,g.app_type_id  from grievances g , grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.emp_id='".$empid."' and DATEDIFF(now(),date_regd) > 2 and 
		g.app_type_id = 1 and gt.disposal_status !=5";*/
		
		$sql="select IFNULL(count(g.grievance_id),0) as grievance_id,g.app_type_id  from grievances g , grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.grievance_status_id IN('2')  and gt.emp_id IN('$ids') and sla_status='2' and 
		g.app_type_id = 1 and gt.disposal_status !=5 and (is_reopened_yn='0' or is_reopened_yn is NULL)";
  	    }
		$rs=mysqli_query($conn,$sql);				
		while($row = mysqli_fetch_assoc($rs))
		{
			$response['pending_beyond_sla']=$row['grievance_id'];
		}
		
		if($user_type == 'U')
  	    {
  	        $sql="SELECT COUNT(grievance_id) as  grievance_id FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."' and 
  	        grievance_status_id IN('3','8','10','4','9')";
  	    }
  	    else
  	    {
		$sql="select count(g.grievance_id) as grievance_id,g.app_type_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and 
		g.grievance_status_id IN('3','8','10','4','9') and gt.emp_id IN('$ids') and g.app_type_id = 1 and gt.disposal_status !=5";
  	    }
		$rs=mysqli_query($conn,$sql);				
		while($row = mysqli_fetch_assoc($rs))
		{
			$response['total_resolved']=$row['grievance_id'];
		} 
		
		
		if($user_type == 'U')
  	    {
  	        $sql="SELECT COUNT(grievance_id) as  grievance_id FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."' and grievance_status_id IN('6')";
  	    }
  	    else
  	    {
		$sql="select count(g.grievance_id) as grievance_id,g.app_type_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and 
		g.grievance_status_id IN('6')and gt.emp_id IN('$ids') and g.app_type_id = 1 and gt.disposal_status !=5 and (is_reopened_yn='0' or is_reopened_yn is NULL)";
  	    }
		$rs=mysqli_query($conn,$sql);				
		while($row = mysqli_fetch_assoc($rs))
		{
			$response['f_Implications']=$row['grievance_id'];
		} 
		
		
		            if($user_type == 'U')
		            {
		               $sql3 ="select IFNULL(count( DISTINCT grievance_id),0) as count,grievance_status_id from grievances where grievance_status_id IN('11','12','13') and ulbid='".$ulbid."' and app_type_id='1' group by app_type_id,grievance_status_id";
		            
		                
		            }
		            else 
				        {
				        $sql3 ="select IFNULL(count(gt.grievance_id),0) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and emp_id IN('$ids')  and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
				        $sql4 ="select IFNULL(count(DISTINCT g.grievance_id),0) as count,disposal_status as grievance_status_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('12') and gt.emp_id IN('$ids') and app_type_id='1'";
				        $sql5 ="select IFNULL(count(DISTINCT g.grievance_id),0) as count,disposal_status as grievance_status_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.disposal_status IN('11') and gt.emp_id IN('$ids') and app_type_id='1'";
				        }
				        
		                $rs= mysqli_query($conn,$sql3);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed_tot['13']['count']=$row['count'];
		                }
		                
		                
		                
		                $rs= mysqli_query($conn,$sql4);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed_tot[$row['grievance_status_id']]['count']=$row['count'];
		                }
		                
		                $rs= mysqli_query($conn,$sql5);
		                while($row = mysqli_fetch_assoc($rs))
		                {
		                    $reopened_completed_tot[$row['grievance_status_id']]['count']=$row['count'];
		                }
		                
		                
		                
		                
		                //echo $reopened_completed_tot['13']['count']; 
		                
		                if($reopened_completed_tot['13']['count']=='')
		                {
		                    $reopened_completed_tot['13']['count']=0;
		                }
		                if($reopened_completed_tot['11']['count']=='')
		                {
		                    $reopened_completed_tot['11']['count']=0;
		                }
		                if($reopened_completed_tot['12']['count']=='')
		                {
		                    $reopened_completed_tot['12']['count']=0;
		                }
		                
		                $response['resolved_you']=$reopened_completed_tot['13']['count'];
		                $response['assigned_you']=$reopened_completed_tot['11']['count'];
		                $response['reopen_completed']=$reopened_completed_tot['12']['count'];
		
		
		
		//	$response['status_code'] = 100;
		//	$response['emp_id'] = 0;
		   //   	$response['message'] = 'Incorrect Password';
		
		echo json_encode($response); 
 	}
	mysqli_close($conn);
?>
  