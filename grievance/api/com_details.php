<?php
	error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	$response['data'] = array();
  	if(isset($_REQUEST['emp_id']))
  	{
  		$sql1 = "SELECT ulbid FROM  `emp_map` where emp_id='".$_REQUEST['emp_id']."'";
  		$rs1 = mysqli_query($conn, $sql1);
  		$ulbid = "";
  		while($row1 = mysqli_fetch_array($rs1))
  		{
  			$ulbid = $row1[0];
  		}
  		
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
		
		
		$sql="select grievance_origin_id,grievance_origin_desc from grievance_origin_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		
		$sql="select e.emp_id,emp_name,emp_mobile,emp_desg,desg_desc from emp_mst e,grievances_transactions gt,desg_mst d where e.emp_id=gt.emp_id and e.emp_desg=d.desg_id and gt.grievance_id='".$_REQUEST['Complaint_no']."'";
		if($rs=mysqli_query($conn,$sql))
		{
		    
			while($row = mysqli_fetch_assoc($rs))
			{
				$emp_list[$row['emp_id']]=$row['emp_name'];
				$emp_mobile[$row['emp_id']]=$row['emp_mobile'];
				$emp_desg[$row['emp_id']]=$row['desg_desc'];
			}
		}
  		
  		
  		
  		
  		
  		if(isset($_REQUEST['Complaint_no']))
  		{
  			//echo $sql="select g.*,c.cat_id, cm.description, w.ward_desc,s.street_desc,gs.grievance_origin_desc from grievances g, grievance_origin_mst gs, complaint_ulbmap c, category_mst cm, ward_mst w,street_mst s where g.cat3_id=c.cs_id and g.ulbid='".$ulbid."' and c.ulbid='".$ulbid."'  and g.app_type_id='1' and g.grievance_id = '".$_REQUEST['Complaint_no']."' and cm.cat_id = c.cat_id and cm.ulbid='".$ulbid."' and w.ward_id=g.ward_id and w.ulbid='".$ulbid."' and s.street_id = g.street_id and s.ulbid='".$ulbid."' and gs.grievance_origin_id = g.grievance_origin_id";
  			
  			if($_REQUEST['complaintStatus']=='12')
  			{
  			    $sql="select g.*,disposal_remarks,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_id='".$_REQUEST['Complaint_no']."' and gt.disposal_status='12'";
  			}
  			else
  			{
  			    $sql="select g.*,disposal_remarks,emp_id from grievances g,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_id='".$_REQUEST['Complaint_no']."'";
  			}
  			
  		$rs = mysqli_query($conn, $sql); 
  		if(mysqli_num_rows($rs) > 0)
  		{
			while($row = mysqli_fetch_assoc($rs))
			{
			    if($row['app_type_id']==1)
			    {
			      $sql="select cs_id,cs_desc from cs_mst";
            		if($rs2=mysqli_query($conn,$sql))
            		{
            			while($row12 = mysqli_fetch_assoc($rs2))
            				$cs_list[$row12['cs_id']]=$row12['cs_desc'];
            		}
			    }
			    else
			    {
			        $sql="select cs_id,cs_desc from standard_services";
            		if($rs2=mysqli_query($conn,$sql))
            		{
            			while($row12 = mysqli_fetch_assoc($rs2))
            				$cs_list[$row12['cs_id']]=$row12['cs_desc'];
            		}
			    }
			    
			    
			    
			    
			    
				$data['Complaint_no']=$row['grievance_id'];
				$data['Name']=$row['person_name'];
				$data['Mobile']=$row['mobile'];
				$data['Ward']=$ward_list[$row['ward_id']];
				$data['Complaint_Type']=$cs_list[$row['cat3_id']];
				$data['address']="House No".$row['hno'].", Street: ".$street_list[$row['street_id']].", Locality: ".$row['address'];
				$data['email']=$row['email'];
				$data['received_through']=$origin_list[$row['grievance_origin_id']];
				$data['Subject']=$row['comp_subject'];
				$data['Description']=$row['comp_desc'];
				$data['Photo']=$row['file_url'];
				$data['Photo_one']=$row['update_image'];
				$data['lat']=$row['lat'];
				$data['lng']=$row['lng'];
				$data['status']=$status_list[$row['grievance_status_id']];
				$data['date_time']=date('d-m-Y',strtotime($row['date_regd']))." ".date('h:i:s',strtotime($row['date_regd']));
				$data['remarks']=$row['disposal_remarks'];
				$data['emp_name']=$emp_list[$row['emp_id']];
				$data['emp_mobile']=$emp_mobile[$row['emp_id']];
				$data['emp_designation']=$emp_desg[$row['emp_id']];
				array_push($response['data'], $data);
			}
		}
		else
		{
			$data['Complaint_no']='NO RECORD AVAILABLE';
			$data['Name']='NO RECORD AVAILABLE';
			$data['Mobile']='NO RECORD AVAILABLE';
			$data['Ward']='NO RECORD AVAILABLE';
			$data['Complaint_Type']='NO RECORD AVAILABLE';
			$data['address']='NO RECORD AVAILABLE';
			$data['email']='NO RECORD AVAILABLE';
			$data['received_through']='NO RECORD AVAILABLE';
			$data['Subject']='NO RECORD AVAILABLE';
			$data['Description']='NO RECORD AVAILABLE';
			$data['Photo']='NO RECORD AVAILABLE';
			$data['lat']='NO RECORD AVAILABLE';
			$data['lng']='NO RECORD AVAILABLE';
			$data['grievance_status_id']='NO RECORD AVAILABLE';
			$data['date_time']="NOT AVAILABLE";
			array_push($response['data'], $data);
		}
	}
		echo json_encode($response); 
 	}
	mysqli_close($conn);
?>
   