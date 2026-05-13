<?php

ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	
	
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
		$sql="select cs_id,comp_desc as cs_desc from category3_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['cs_desc'];
		}
  		
  		
  		
  		
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
  	     if($_REQUEST['emp_id'] > 0)
  	     {
  	     
      	    $sql1 = "SELECT ulbid FROM  `emp_map` where emp_id='".$_REQUEST['emp_id']."'";
      		$rs1 = mysqli_query($conn, $sql1);
      		//$ulbid = "";
      		
      		while($row1 = mysqli_fetch_array($rs1))
      		{
      			$ulbid = $row1[0];
      		}    
  	     }
  	     else
  	     {
  	         $ulbid = $arr[2];;
  	     }
  	    
  	    
  		if($_REQUEST['record_id'] == 'td')
				{
					////////// employee login Total Assigned complaints
					 if($user_type == 'U')
                  	    {
                  	        $sql="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '2' AND `ulbid` LIKE '".$ulbid."' order by date_regd DESC";
                  	    }
                  	    else
                  	    {
                					
                				 $sql="select g.grievance_id,g.person_name,g.mobile,g.ward_id,g.cat3_id,g.street_id,g.street_id,g.date_regd,gt.disposal_status as grievance_status_id,gt.disposed_date from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_REQUEST['emp_id']."' and 
                				 g.app_type_id='2' and gt.disposal_status !=5  order by date_regd DESC";
                				 
                				 
                  	    }
				}
				else if($_REQUEST['record_id'] == 'withinSLA')
				{
					////////// employee login Under progress  complaints with in SLA
					 if($user_type == 'U')
                  	    {
                  	        $sql="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '2' AND `ulbid` LIKE '".$ulbid."' and 
  	        grievance_status_id IN('2') and sla_status='1' order by date_regd DESC";
                  	    }
                  	    else
                  	    {
					
				             /*$sql="select g.*,DATEDIFF(now(),date_regd) AS target from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and 
				             g.grievance_status_id NOT IN('3','8','6','10','4','9') and g.app_type_id='1' and gt.emp_id='".$_REQUEST['emp_id']."' and 
				             gt.disposal_status !=5 order by date_regd DESC";*/
				             
				             $sql ="select *  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and 
		g.grievance_status_id IN('2')  and gt.emp_id='".$_REQUEST['emp_id']."' and sla_status='1' and g.app_type_id = 2 and gt.disposal_status !=5  order by date_regd DESC";
                  	    }
				}
				else if($_REQUEST['record_id'] == 'beyondSLA')
				{
					////////// employee login Under progress  complaints beyond SLA
					
					 if($user_type == 'U')
                  	    {
                  	       /* $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '1' AND `ulbid` LIKE '".$ulbid."' and 
                  	        grievance_status_id NOT IN('3','8','6','10','4','9') order by date_regd DESC";*/
                  	        
                  	        $sql="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '2' AND `ulbid` LIKE '".$ulbid."' and 
  	        grievance_status_id IN('2') and sla_status='2' order by date_regd DESC";
                  	    }
                  	    else
                  	    {
				       /* $sql="select g.*,DATEDIFF(now(),date_regd) AS target from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and 
				        g.grievance_status_id NOT IN('3','8','6','10','4','9') and g.app_type_id='1' and gt.emp_id='".$_REQUEST['emp_id']."' and 
				        gt.disposal_status !=5 order by date_regd DESC";*/
				        
				        $sql ="select *  from grievances g , grievances_transactions gt where g.grievance_id=gt.grievance_id and 
		g.grievance_status_id IN('2')  and gt.emp_id='".$_REQUEST['emp_id']."' and sla_status='2' and g.app_type_id = 2 and gt.disposal_status !=5  
		order by date_regd DESC";
                  	    }
				}
				else if($_REQUEST['record_id'] == 'totalSolved')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '2' AND `ulbid` LIKE '".$ulbid."' and 
                  	        grievance_status_id IN('3','8','10','4','9','12') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				            $sql="select g.*,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and g.grievance_status_id IN('3','8','10','4','9')  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['emp_id']."' and gt.disposal_status !=5  order by date_regd DESC";
                  	    }
  				}
  				else if($_REQUEST['record_id'] == 'fin')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '2' AND `ulbid` LIKE '".$ulbid."' and 
                  	        grievance_status_id IN('10') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				            $sql="select g.*,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and g.grievance_status_id IN('10')  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['emp_id']."' and gt.disposal_status !=5  order by date_regd DESC";
                  	    }
  				
  				}
  				
  				
  				
  				else if($_REQUEST['record_id'] == 'resolved_you')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '2' AND `ulbid` LIKE '".$ulbid."' and 
                  	        grievance_status_id IN('13') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				             $sql="select g.grievance_id,g.person_name,g.mobile,g.ward_id,g.cat3_id,g.street_id,g.street_id,g.date_regd,gt.disposal_status as grievance_status_id,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and disposal_status='9'  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['emp_id']."' and 
  				            gt.disposal_status='9'  order by date_regd DESC";
                  	    }
  				
  				}
  				
  				
  				else if($_REQUEST['record_id'] == 'assigned_you')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '2' AND `ulbid` LIKE '".$ulbid."' and 
                  	        grievance_status_id IN('11') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				            $sql="select g.*,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and gt.disposal_status IN('11')  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['emp_id']."' and 
  				            gt.disposal_status !=5  order by date_regd DESC";
                  	    }
  				
  				}
  				
  				
  				
  				else if($_REQUEST['record_id'] == 'reopen_completed')
  				{
  				     if($user_type == 'U')
                  	    {
                  	        $sql="SELECT *, DATEDIFF(now(),date_regd) AS target FROM `grievances` WHERE `app_type_id` LIKE '2' AND `ulbid` LIKE '".$ulbid."' and 
                  	        grievance_status_id IN('12') order by date_regd DESC";
                  	    }
                  	    else
                  	    {
  				            $sql="select g.*,gt.disposed_date,DATEDIFF(disposed_date,date_regd) AS target from grievances g,grievances_transactions gt where 
  				            g.grievance_id=gt.grievance_id and gt.disposal_status IN('12')  and g.app_type_id='2' and gt.emp_id='".$_REQUEST['emp_id']."' and 
  				            gt.disposal_status !=5  order by date_regd DESC";
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
					
					else if($_REQUEST['record_id'] == 'totalSolved')
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
					else if($_REQUEST['record_id'] == 'fin')
					{
					    $data['status']=1;
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
   