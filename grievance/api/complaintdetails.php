<?php

ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET names=utf8');
    mysqli_query($conn,'SET character_set_client=utf8');
    mysqli_query($conn,'SET character_set_connection=utf8');
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET collation_connection=utf8_general_ci');
    
    $langId=$_REQUEST['lang_id'];
	
  	if(isset($_REQUEST['emp_id']))
  	{
  	    
  		
  		 $sql="select ward_id,ward_desc from ward_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		$sql="select street_id,street_desc from street_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$street_list[$row['street_id']]=$row['street_desc'];
		}
		$sql="select cs_id,cs_desc from cs_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['cs_desc'];
		}
  		
  		
  		/*if($_REQUEST['record_id'] == 'td')
  		{
  			 $sql="select g.*,c.cat_id, cm.description, w.ward_desc,s.street_desc from grievances g, grievances_transactions gt,complaint_ulbmap c, category_mst cm, ward_mst w,street_mst s where gt.grievance_id = g.grievance_id and gt.emp_id = '".$_REQUEST['emp_id']."' and g.cat3_id=c.cs_id and g.ulbid='".$ulbid."' and c.ulbid='".$ulbid."'  and g.app_type_id='1' and cm.cat_id = c.cat_id and w.ward_id=g.ward_id and w.ulbid='".$ulbid."' and s.street_id = g.street_id and s.ulbid='".$ulbid."'";
  			 
  		//	echo $sql = "SELECT g.*, w.ward_desc,s.street_desc FROM grievances_transactions gt,grievances g, ward_mst w, street_mst s where g.grievance_id=gt.grievance_id and gt.emp_id='".$_REQUEST['emp_id']."' and g.app_type_id = 1 and g.ward_id = w.ward_id and w.ulbid='".$ulbid."' and g.street_id = s.street_id";
  		}
  		else if($_REQUEST['record_id'] == 'withinSLA')
  		{
  			$sql="select g.*,c.cat_id, cm.description, w.ward_desc,s.street_desc from grievances g,grievances_transactions gt,complaint_ulbmap c, category_mst cm, ward_mst w,street_mst s where gt.grievance_id = g.grievance_id and gt.emp_id = '".$_REQUEST['emp_id']."' and g.cat3_id=c.cs_id and  g.grievance_status_id NOT IN('3','8') and g.ulbid='".$ulbid."' and TIMESTAMPDIFF(HOUR,date_regd,now()) <= 24 and c.ulbid='".$ulbid."' and g.app_type_id='1' and cm.cat_id = c.cat_id and cm.ulbid='".$ulbid."' and w.ward_id=g.ward_id and w.ulbid='".$ulbid."' and s.street_id = g.street_id and s.ulbid='".$ulbid."' ";
  		}
		else if($_REQUEST['record_id'] == 'beyondSLA')
  		{
  			$sql="select g.*,c.cat_id, cm.description, w.ward_desc,s.street_desc from grievances g,grievances_transactions gt,complaint_ulbmap c, category_mst cm, ward_mst w,street_mst s where gt.grievance_id = g.grievance_id and gt.emp_id = '".$_REQUEST['emp_id']."' and g.cat3_id=c.cs_id and  g.grievance_status_id NOT IN('3','8') and g.ulbid='".$ulbid."' and TIMESTAMPDIFF(HOUR,date_regd,now()) > 24 and c.ulbid='".$ulbid."' and g.app_type_id='1' and cm.cat_id = c.cat_id and cm.ulbid='".$ulbid."' and w.ward_id=g.ward_id and w.ulbid='".$ulbid."' and s.street_id = g.street_id and s.ulbid='".$ulbid."' ";
  		}
  		else if($_REQUEST['record_id'] == 'totalSolved')
  		{
  			$sql="select g.*,c.cat_id, cm.description, w.ward_desc,s.street_desc from grievances g,grievances_transactions gt,complaint_ulbmap c, category_mst cm, ward_mst w,street_mst s where gt.grievance_id = g.grievance_id and gt.emp_id = '".$_REQUEST['emp_id']."' and g.cat3_id=c.cs_id and  g.grievance_status_id IN('3','8') and g.ulbid='".$ulbid."' and c.ulbid='".$ulbid."'  and g.app_type_id='1' and cm.cat_id = c.cat_id and c.ulbid='".$ulbid."' and w.ward_id=g.ward_id and w.ulbid='".$ulbid."' and s.street_id = g.street_id and s.ulbid='".$ulbid."'";
  		}*/
  		
  		/** splitting empid as empid and user type, here we get empid and user type seperated with - **/
  	    $arr=explode("-",$_REQUEST['emp_id']);
  	    
  	    /*** setting emp id after spit the stirng **/
  	     $_REQUEST['emp_id']=$arr[0];
  	    
  	    /** assign user type **/
  	     $user_type=$arr[1];
  	    /** setting ulbid **/
  	    $ulbid=$arr[2];
  	    /** setting user id **/
  	     $user_id=$arr[3];
  	     
  	     
  	     //echo $_REQUEST['emp_id'];
  	     
  	     
  	     if($user_type == 'E')
  	     {
  	         
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
  	         
  	    //$sql1 = "SELECT ulbid FROM  `emp_map` where emp_id='".$_REQUEST['emp_id']."'";
  	    $sql1 = "SELECT ulbid FROM  `emp_map` where emp_id in('$ids') group by ulbid";
  		$rs1 = mysqli_query($conn, $sql1);
  		//$ulbid = "";
  		
  		while($row1 = mysqli_fetch_array($rs1))
  		{
  			$ulbid = $row1[0];
  			$ulbids[] = $row1['ulbid'];
  		}    
  	     }
  	     else
  	     {
  	         $ulbid = $arr[2];;
  	         $ulbids[] = $arr[2];;
  	     }
  	    
  	    $ulbids = join("','",$ulbids);  
  		if($_REQUEST['record_id'] == 'td')
				{
					////////// employee login Total Assigned complaints
					 if($user_type == 'U')
                  	    {
                  	        $sql="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` IN ('$ulbids') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
                					
                				 $sql="select g.grievance_id,g.person_name,g.mobile,g.ward_id,g.cat3_id,g.street_id,g.street_id,g.date_regd,gt.disposal_status as grievance_status_id,gt.disposed_date from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id IN('$ids') and 
                				 g.app_type_id='1' and gt.disposal_status !=5  order by date_regd DESC";
                				 
                				 
                  	    }
				}
				else if($_REQUEST['record_id'] == 'withinSLA')
				{
					////////// employee login Under progress  complaints with in SLA
					 if($user_type == 'U')
                  	    {
                  	        $sql="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` IN ('$ulbids') and 
  	        grievance_status_id IN('2') and sla_status='1' order by date_regd DESC";
                  	    }
                  	    else
                  	    {
					
				             /*$sql="select g.*,DATEDIFF(now(),date_regd) AS target from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and 
				             g.grievance_status_id NOT IN('3','8','6','10','4','9') and g.app_type_id='1' and gt.emp_id='".$_REQUEST['emp_id']."' and 
				             gt.disposal_status !=5 order by date_regd DESC";*/
				             
				             $sql ="select *  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and 
		g.grievance_status_id IN('2')  and gt.emp_id IN('$ids') and sla_status='1' and g.app_type_id = 1 and gt.disposal_status !=5 and (is_reopened_yn='0' or is_reopened_yn is NULL) order by date_regd DESC";
                  	    }
				}
				else if($_REQUEST['record_id'] == 'beyondSLA')
				{
					////////// employee login Under progress  complaints beyond SLA
					
					 if($user_type == 'U')
                  	    {
                  	       /* $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."' and 
                  	        grievance_status_id NOT IN('3','8','6','10','4','9') order by date_regd DESC";*/
                  	        
                  	        $sql="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` IN ('$ulbids') and 
  	        grievance_status_id IN('2') and sla_status='2' order by date_regd DESC";
                  	    }
                  	    else
                  	    {
				       /* $sql="select g.*,DATEDIFF(now(),date_regd) AS target from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and 
				        g.grievance_status_id NOT IN('3','8','6','10','4','9') and g.app_type_id='1' and gt.emp_id='".$_REQUEST['emp_id']."' and 
				        gt.disposal_status !=5 order by date_regd DESC";*/
				        
				        $sql ="select *  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and 
		g.grievance_status_id IN('2')  and gt.emp_id IN('$ids') and sla_status='2' and g.app_type_id = 1 and gt.disposal_status !=5 and (is_reopened_yn='0' or is_reopened_yn is NULL) 
		order by date_regd DESC";
                  	    }
				}
				else if($_REQUEST['record_id'] == 'totalSolved')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` IN ('$ulbids') and 
                  	        grievance_status_id IN('3','8','10','4','9','12') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				            $sql="select g.*,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','10','4','9')  and g.app_type_id='1' and gt.emp_id IN('$ids') and gt.disposal_status !=5 and (is_reopened_yn='0' or is_reopened_yn is NULL) order by date_regd DESC";
                  	    }
  				}
  				else if($_REQUEST['record_id'] == 'fin')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` IN ('$ulbids') and 
                  	        grievance_status_id IN('6') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				            $sql="select g.*,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and g.grievance_status_id IN('6')  and g.app_type_id='1' and gt.emp_id IN('$ids') and gt.disposal_status !=5 and is_reopened_yn='0' order by date_regd DESC";
                  	    }
  				
  				}
  				
  				
  				
  				else if($_REQUEST['record_id'] == 'resolved_you')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` IN ('$ulbids') and 
                  	        grievance_status_id IN('13') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				             /*$sql="select g.grievance_id,g.person_name,g.mobile,g.ward_id,g.cat3_id,g.street_id,g.street_id,g.date_regd,gt.disposal_status as grievance_status_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and disposal_status='9'  and g.app_type_id='1' and gt.emp_id='".$_REQUEST['emp_id']."' and 
  				            gt.disposal_status='9' and is_reopened_yn='1' order by date_regd DESC";*/
  				            $sql ="select IFNULL(count(gt.grievance_id),0) as count,app_type_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and emp_id IN('$ids')  and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";
                  	    }
  				
  				}
  				
  				
  				else if($_REQUEST['record_id'] == 'assigned_you')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` IN ('$ulbids') and 
                  	        grievance_status_id IN('11') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				            $sql="select g.*,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and gt.disposal_status IN('11')  and g.app_type_id='1' and gt.emp_id IN('$ids') and 
  				            gt.disposal_status !=5 group by gt.grievance_id order by date_regd DESC";
  				            
  				            /*$sql ="select g.*,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and emp_id='".$_REQUEST['emp_id']."'  and is_reopened_yn='1'  and g.grievance_status_id IN('13') group by app_type_id";*/
                  	    }
  				
  				}
  				
  				
  				
  				else if($_REQUEST['record_id'] == 'reopen_completed')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` IN ('$ulbids') and 
                  	        grievance_status_id IN('12') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				            $sql="select g.*,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and gt.disposal_status IN('12')  and g.app_type_id='1' and gt.emp_id IN('$ids') and 
  				            gt.disposal_status !=5  group by gt.grievance_id order by date_regd DESC";
                  	    }
  				
  				}
  				
  				
  				
  				
  				
  				
  				
  				
				
				//echo $sql;
				
			if($rs=mysqli_query($conn,$sql))
			{
				$response['data'] = array();
				$field_info = mysqli_fetch_fields($rs);
				while($row = mysqli_fetch_assoc($rs))
				{
				    
				    
				    if($row['grievance_status_id']=='3' || $row['grievance_status_id']=='8' || $row['grievance_status_id']=='9' || $row['grievance_status_id']=='12' || $row['grievance_status_id']=='13')
        					    {
        					        $data['status']=1;
        					    }
        					    else
        					    {
        					        $data['status']=0;
        					    }
				    
				    
				    if($_REQUEST['record_id'] == 'withinSLA' || $_REQUEST['record_id'] == 'beyondSLA')
					{
				        $data['Complaint_no']=$row['grievance_id'];
						 $data['Name']=$row['person_name'];
						$data['Mobile']=$row['mobile'];
						$data['Ward']=$ward_list[$row['ward_id']];
						$data['Complaint_Type']=$cs_list[$row['cat3_id']];
						$data['street']=$street_list[$row['street_id']];
						$data['date_time']=date('d-m-Y',strtotime($row['date_regd']))." ".date('h:i:s',strtotime($row['date_regd']));
						$data['complaintStatus']=$row['grievance_status_id'];
						array_push($response['data'], $data);
					}
				    
				    
				    
				/*if($_REQUEST['record_id'] == 'withinSLA')
					{
					    
						if($row['target']=="")
						 {
						 $row['target']=0;
						 }
						 if($row['target'] <= 1)
						 {
						if($row['grievance_status_id']=='3' || $row['grievance_status_id']=='8' || $row['grievance_status_id']=='9')
					    {
					        $data['status']=1;
					    }
					    else
					    {
					        $data['status']=0;
					    }
						  $data['Complaint_no']=$row['grievance_id'];
						 $data['Name']=$row['person_name'];
						$data['Mobile']=$row['mobile'];
						$data['Ward']=$ward_list[$row['ward_id']];
						$data['Complaint_Type']=$cs_list[$row['cat3_id']];
						$data['street']=$street_list[$row['street_id']];
						$data['date_time']=date('d-m-Y',strtotime($row['date_regd']))." ".date('h:i:s',strtotime($row['date_regd']));
						
						array_push($response['data'], $data);
						 }
					}
					else if($_REQUEST['record_id'] == 'beyondSLA')
					{
						if($row['target']=="")
						 {
						 $row['target']=0;
						 }
						 if($row['target'] > 1)
						 {
						     
						     
						     	if($row['grievance_status_id']=='3' || $row['grievance_status_id']=='8' || $row['grievance_status_id']=='9')
        					    {
        					        $data['status']=1;
        					    }
        					    else
        					    {
        					        $data['status']=0;
        					    }
						     
						$data['Complaint_no']=$row['grievance_id'];
						$data['Name']=$row['person_name'];
						$data['Mobile']=$row['mobile'];
						$data['Ward']=$ward_list[$row['ward_id']];
						$data['Complaint_Type']=$cs_list[$row['cat3_id']];
						$data['street']=$street_list[$row['street_id']];
						$data['date_time']=date('d-m-Y',strtotime($row['date_regd']))." ".date('h:i:s',strtotime($row['date_regd']));
						array_push($response['data'], $data);
						 
						 }
					}*/
					else if($_REQUEST['record_id'] == 'td')
					{
					    if($row['grievance_status_id']=='3' || $row['grievance_status_id']=='8' || $row['grievance_status_id']=='9' || $row['grievance_status_id']=='12' || $row['grievance_status_id']=='13')
					    {
					        $data['status']=1;
					    }
					    else
					    {
					        $data['status']=0;
					    }
						$data['Complaint_no']=$row['grievance_id'];
						$data['Name']=$row['person_name'];
						$data['Mobile']=$row['mobile'];
						$data['Ward']=$ward_list[$row['ward_id']];
						$data['Complaint_Type']=$cs_list[$row['cat3_id']];
						$data['street']=$street_list[$row['street_id']];
						$data['date_time']=date('d-m-Y',strtotime($row['date_regd']))." ".date('h:i:s',strtotime($row['date_regd']));
						$data['complaintStatus']=$row['grievance_status_id'];
						array_push($response['data'], $data);
					}
					
					else if($_REQUEST['record_id'] == 'totalSolved' || $_REQUEST['record_id'] == 'fin')
					{
					if($row['grievance_status_id']=='3' || $row['grievance_status_id']=='8' || $row['grievance_status_id']=='9' || $row['grievance_status_id']=='12' || $row['grievance_status_id']=='13')
					    {
					        $data['status']=1;
					    }
					    else
					    {
					        $data['status']=0;
					    }
						$data['Complaint_no']=$row['grievance_id'];
						$data['Name']=$row['person_name'];
						$data['Mobile']=$row['mobile'];
						$data['Ward']=$ward_list[$row['ward_id']];
						$data['Complaint_Type']=$cs_list[$row['cat3_id']];
						$data['street']=$street_list[$row['street_id']];
						
						$data['date_time']=date('d-m-Y',strtotime($row['date_regd']))." ".date('h:i:s',strtotime($row['date_regd']));
						$data['complaintStatus']=$row['grievance_status_id'];
						
						array_push($response['data'], $data);
					}
					
					else if($_REQUEST['record_id'] == 'resolved_you')
					{
					    
					    if($row['grievance_status_id']=='13' || $row['grievance_status_id']=='9')
					    {
					        $data['status']=1;
					    }
					    else
					    {
					        $data['status']=0;
					    }
						$data['Complaint_no']=$row['grievance_id'];
						$data['Name']=$row['person_name'];
						$data['Mobile']=$row['mobile'];
						$data['Ward']=$ward_list[$row['ward_id']];
						$data['Complaint_Type']=$cs_list[$row['cat3_id']];
						$data['street']=$street_list[$row['street_id']];
						
						$data['date_time']=date('d-m-Y',strtotime($row['date_regd']))." ".date('h:i:s',strtotime($row['date_regd']));
						$data['complaintStatus']=$row['grievance_status_id'];
						
						array_push($response['data'], $data);
					}
					
					
					else if($_REQUEST['record_id'] == 'assigned_you')
					{
					    
					    if($row['grievance_status_id']=='11')
					    {
					        $data['status']=0;
					    }
					    
						$data['Complaint_no']=$row['grievance_id'];
						$data['Name']=$row['person_name'];
						$data['Mobile']=$row['mobile'];
						$data['Ward']=$ward_list[$row['ward_id']];
						$data['Complaint_Type']=$cs_list[$row['cat3_id']];
						$data['street']=$street_list[$row['street_id']];
						
						$data['date_time']=date('d-m-Y',strtotime($row['date_regd']))." ".date('h:i:s',strtotime($row['date_regd']));
						$data['complaintStatus']=$row['grievance_status_id'];
						
						array_push($response['data'], $data);
					}
				
					
					else if($_REQUEST['record_id'] == 'reopen_completed')
					{
					    
					    if($row['grievance_status_id']=='12')
					    {
					        $data['status']=1;
					    }
					    else
					    {
					        $data['status']=0;
					    }
						$data['Complaint_no']=$row['grievance_id'];
						$data['Name']=$row['person_name'];
						$data['Mobile']=$row['mobile'];
						$data['Ward']=$ward_list[$row['ward_id']];
						$data['Complaint_Type']=$cs_list[$row['cat3_id']];
						$data['street']=$street_list[$row['street_id']];
						
						$data['date_time']=date('d-m-Y',strtotime($row['date_regd']))." ".date('h:i:s',strtotime($row['date_regd']));
						$data['complaintStatus']=$row['grievance_status_id'];
						
						array_push($response['data'], $data);
					}
					
					
					
					
				}
				
			}
				
				
				
  	
  		
  		
  		
  		
  		
  		/*$rs = mysqli_query($conn, $sql); 
  		if(mysqli_num_rows($rs) > 0)
  		{	$response['data'] = array();
			while($row = mysqli_fetch_assoc($rs))
			{
				$data['Complaint_no']=$row['grievance_id'];
				$data['Name']=$row['person_name'];
				$data['Mobile']=$row['mobile'];
				$data['Ward']=$row['ward_desc'];
				$data['Complaint_Type']=$row['description'];
				$data['street']=$row['street_desc'];
				array_push($response['data'], $data);
			}
		}
		else
		{
			$response['status_code'] = '201';
			$response['Message']='NO RECORD AVAILABLE';
			
			//array_push($response['data'], $data);
		}*/
		echo json_encode($response); 
 	}
	mysqli_close($conn);
?>
   