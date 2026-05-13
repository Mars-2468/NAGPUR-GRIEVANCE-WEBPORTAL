<?php
	require_once('../connection.php');
	$conn=getconnection();
	
  	if(isset($_REQUEST['emp_id']))
  	{
  	    /** splitting empid as empid and user type, here we get empid and user type seperated with - **/
  	    $arr=split("-",$_REQUEST['emp_id']);
  	    
  	    /*** setting emp id after spit the stirng **/
  	    $_REQUEST['emp_id']=$arr[0];
  	    
  	    /** assign user type **/
  	    $user_type=$arr[1];
  	    /** setting ulbid **/
  	    $ulbid=$arr[2];
  	    /** setting user id **/
  	    $user_id=$arr[3];
  	    
  	    
  	    /** select user details in case of login ulb or commissioner **/
  	    
  	    if($user_type== 'U')
  	    {
  	        $sql ="select user_id as emp_name,user_mobile as emp_mobile, user_dept as dept_desc, ulbname,usr.ulbid  from users usr, ulbmst u where usr.ulbid=u.ulbid and usr.ulbid='".$ulbid."' and usr.user_id='".$user_id."'";
  	    }
  	    else
  	    {
  	        $sql = "SELECT e.emp_name, e.emp_mobile, d.dept_desc, de.desg_desc, u.ulbname from emp_mst e, dept_mst d, desg_mst de, ulbmst u  where e.emp_id = '".$_REQUEST['emp_id']."' and e.emp_dept = d.dept_id and e.emp_desg = de.desg_id and e.ulbid = u.ulbid";
  	    }
  	    
  	    
  	    
  		
  		$res = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($res);
		while($row = mysqli_fetch_array($res))
		{
		     	$response['emp_name'] = $row['emp_name'];
		     	$response['Mobile'] = $row['emp_mobile'];
		     	$response['Section'] = $row['dept_desc'];
		     	$response['designation'] = $row['desg_desc'];
		     	$response['Ulbname'] = $row['ulbname'];
		}
  		
  		$empid= $_REQUEST['emp_id'];
  		 if($user_type == 'U')
  	    {
  	        $sql="SELECT COUNT(grievance_id) as  date_regd FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."'";
  	    }
  	    else
  	    {
		$sql="SELECT IFNULL(count(g.grievance_id),0) as date_regd FROM grievances_transactions gt,grievances g where g.grievance_id=gt.grievance_id and gt.emp_id='".$empid."' and g.app_type_id = 1 and gt.disposal_status !=5";
  	    }
	  	$res = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($res);
		while($row = mysqli_fetch_array($res))
		{
		     	$response['total_assigned'] = $row['date_regd'];
		}
		//$sql="select IFNULL(count(g.grievance_id),0) as grievance_id,g.app_type_id  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id NOT IN('3','8')  and gt.emp_id='".$empid."' and TIMESTAMPDIFF(HOUR,date_regd,now()) <= 24 and g.app_type_id = 1";
		 if($user_type == 'U')
  	    {
  	        $sql="SELECT COUNT(grievance_id) as  grievance_id FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."' and grievance_status_id NOT IN('3','8','6','10','4') and DATEDIFF(now(),date_regd) <= 2";
  	    }
  	    else
  	    {
		$sql="select IFNULL(count(g.grievance_id),0) as grievance_id,g.app_type_id  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id NOT IN('3','8','6','10','4')  and gt.emp_id='".$empid."' and DATEDIFF(now(),date_regd) <= 2 and g.app_type_id = 1 and gt.disposal_status !=5";
  	    }
		
		$rs=mysqli_query($conn,$sql);						 
		while($row = mysqli_fetch_assoc($rs))
		{		
			$response['pending_within_sla']=$row['grievance_id'];
		}
		//$sql="select IFNULL(count(g.grievance_id),0) as grievance_id,g.app_type_id  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id NOT IN('3','8')  and gt.emp_id='".$empid."' and TIMESTAMPDIFF(HOUR,date_regd,now()) > 24 and g.app_type_id = 1";
		
		 if($user_type == 'U')
  	    {
  	        $sql="SELECT COUNT(grievance_id) as  grievance_id FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."' and grievance_status_id NOT IN('3','8','6','10','4') and DATEDIFF(now(),date_regd) > 2";
  	    }
  	    else
  	    {
		$sql="select IFNULL(count(g.grievance_id),0) as grievance_id,g.app_type_id  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id NOT IN('3','8','6','10','4')  and gt.emp_id='".$empid."' and DATEDIFF(now(),date_regd) > 2 and g.app_type_id = 1 and gt.disposal_status !=5";
  	    }
		$rs=mysqli_query($conn,$sql);				
		while($row = mysqli_fetch_assoc($rs))
		{
			$response['pending_beyond_sla']=$row['grievance_id'];
		}
		
		if($user_type == 'U')
  	    {
  	        $sql="SELECT COUNT(grievance_id) as  grievance_id FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."' and grievance_status_id IN('3','8','10','4')";
  	    }
  	    else
  	    {
		$sql="select count(g.grievance_id) as grievance_id,g.app_type_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','10','4') and gt.emp_id='".$empid."' and g.app_type_id = 1 and gt.disposal_status !=5";
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
		$sql="select count(g.grievance_id) as grievance_id,g.app_type_id from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('6')and gt.emp_id='".$empid."' and g.app_type_id = 1 and gt.disposal_status !=5";
  	    }
		$rs=mysqli_query($conn,$sql);				
		while($row = mysqli_fetch_assoc($rs))
		{
			$response['f_Implications']=$row['grievance_id'];
		} 
		
		//	$response['status_code'] = 100;
		//	$response['emp_id'] = 0;
		   //   	$response['message'] = 'Incorrect Password';
		
		echo json_encode($response); 
 	}
	mysqli_close($conn);
?>
  