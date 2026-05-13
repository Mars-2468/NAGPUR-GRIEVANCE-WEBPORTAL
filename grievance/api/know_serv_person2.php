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
	
	
	
	$sql ="select cs_id,cs_desc as comp_desc,marathi_description from cs_mst";
	
	//$sql ="select cm.cs_id,cm"
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	   if($langId==1){ 
	         $cs_list[$row['cs_id']]=$row['comp_desc'];
    	  }else{
    	     $cs_list[$row['cs_id']]=$row['marathi_description'];
    	 }
	}
	
	$sql ="select dept_id,dept_desc,dept_marathi from dept_mst where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    if($langId==1){ 
	      $dept_list[$row['dept_id']]=$row['dept_desc'];
    	  }else{
    	      $dept_list[$row['dept_id']]=$row['dept_marathi'];
    	 }
	}
	
	$sql ="select ward_id,ward_desc,wards_marathi from ward_mst where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    if($langId==1){ 
	     $ward_list[$row['ward_id']]=$row['ward_desc'];
    	 }else{
    	      $ward_list[$row['ward_id']]=$row['wards_marathi'];
    	 }
	}
	
	$sql ="select desg_id,desg_desc,desig_marathi from desg_mst where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	     if($langId==1){ 
	           $desg_list[$row['desg_id']]=$row['desg_desc'];
    	 }else{
    	       $desg_list[$row['desg_id']]=$row['desig_marathi'];
    	 }
	}
	
	 $sql ="select street_id,street_desc,street_desc_marathi from street_mst where ulbid='".$_REQUEST['ulbid']."' and ward_id='".$_REQUEST['ward_id']."'";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	     
	    if($langId==1){ 
	     $street_list[$row['street_id']]=$row['street_desc'];
    	 }else{
    	      $street_list[$row['street_id']]=$row['street_desc_marathi'];
    	 }
	}
	
	$sql ="select emp_id,emp_name,emp_name_marathi from emp_mst where ulbid='".$_REQUEST['ulbid']."'";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	     
	     if($langId==1){ 
	         $emp_list[$row['emp_id']]=$row['emp_name'];
    	 }else{
    	     $emp_list[$row['emp_id']]=$row['emp_name_marathi'];
    	 }
	}
	
	
	
	 $sql="select em.cs_id,em.ward_id,em.emp_id,em.emp_id2,em.emp_id3,em.emp_id4,em.dept_id,e.emp_desg,e.emp_mobile from 
	 emp_map em,emp_mst e where e.emp_id=em.emp_id and e.ulbid='".$_REQUEST['ulbid']."' and em.cs_id='".$_REQUEST['cs_id']."'
	 and cs_type_id='1' and ward_id='".$_REQUEST['ward_id']."' and street_id='".$_REQUEST['street_id']."' and e.delete_status='0'";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
		    
		    $response['status_code']='200';
		    $response['status_msg']= 'success';
		    $response['services']=array();
		    
		    $i=1;
			while($row = mysqli_fetch_assoc($rs))
			{
				
				$stuff= array();
				$stuff['service_name']=$cs_list[$row['cs_id']];
				$stuff['ward']=$ward_list[$row['ward_id']];
				$stuff['emp_name']=$emp_list[$row['emp_id']];
				$stuff['devision']=$dept_list[$row['dept_id']];
				$stuff['designation']=$desg_list[$row['emp_desg']];
				$stuff['mobile']=$row['emp_mobile'];
				$stuff['street']=$street_list[$_REQUEST['street_id']];
				
				$sql ="select * from emp_mst where emp_id='".$row['emp_id2']."' and delete_status='0'";
				$rs2= mysqli_query($conn,$sql);
				$row2 = mysqli_fetch_assoc($rs2);
				$stuff['emp_name2']=$emp_list[$row['emp_id2']];
				$stuff['devision2']=$dept_list[$row2['emp_dept']];
				$stuff['designation2']=$desg_list[$row2['emp_desg']];
				$stuff['mobile2']=$row2['emp_mobile'];
				
				$sql ="select * from emp_mst where emp_id='".$row['emp_id3']."' and delete_status='0'";
				$rs3= mysqli_query($conn,$sql);
				$row3 = mysqli_fetch_assoc($rs3);
				$stuff['emp_name3']=$emp_list[$row['emp_id3']];
				$stuff['devision3']=$dept_list[$row3['emp_dept']];
				$stuff['designation3']=$desg_list[$row3['emp_desg']];
				$stuff['mobile3']=$row3['emp_mobile'];
				
				$sql ="select * from emp_mst where emp_id='".$row['emp_id4']."' and delete_status='0'";
				$rs4= mysqli_query($conn,$sql);
				$row4 = mysqli_fetch_assoc($rs4);
				$stuff['emp_name4']=$emp_list[$row['emp_id4']];
				$stuff['devision4']=$dept_list[$row4['emp_dept']];
				$stuff['designation4']=$desg_list[$row4['emp_desg']];
				$stuff['mobile4']=$row4['emp_mobile'];
				
				array_push($response["services"], $stuff);
	
				
			}
		}
		else
		{
		        
		        $response['status_code']='100';
		        $response['status_msg']= 'No Data';
		        $response['services']=array();
				$stuff['cs_id']=0;
				$stuff['service_name']='No Services Person Available';
				array_push($response["services"], $stuff);
		}
	}
	else
	{
	            
	            $response['status_code']='100';
		        $response['status_msg']= 'No Data';
		        $response['services']=array();
				$stuff['cs_id']=0;
				$stuff['service_name']='No Services Person Available';
				array_push($response["services"], $stuff);
		//$response[0] = array('cs_id'=>'0','cs_desc'=>'No Services Available');
	}
		
		
	$indexedOnly = array();

foreach ($response as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>