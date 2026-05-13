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
	
	
	$response['staffs']=array();
	
	$sql ="select desg_id,desg_desc,desig_marathi from desg_mst where ulbid='".$_REQUEST['ulbid']."' and dept_id = '".$_REQUEST['dept_id']."'";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	 if($langId==1){
	$desg_list[$row['desg_id']]=$row['desg_desc'];
	 }else{
	   $desg_list[$row['desg_id']]=$row['desig_marathi'];  
	 }
	}
	
	 $sql="select e.emp_name,e.emp_name_marathi,e.emp_desg,e.emp_mobile from emp_mst e where e.ulbid='".$_REQUEST['ulbid']."' and e.emp_dept='".$_REQUEST['dept_id']."' order by e.emp_dept ASC ";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
		$i=1;
			while($row = mysqli_fetch_assoc($rs))
			{
				
				$stuff= array();
                    if($langId==1){
                    $stuff['emp_name']=$row['emp_name'];
                    $stuff['designation']=$desg_list[$row['emp_desg']];
                    $stuff['mobile']=$row['emp_mobile'];
                    }else{
                    $stuff['emp_name']=$row['emp_name_marathi'];
                    $stuff['designation']=$desg_list[$row['emp_desg']];
                    $stuff['mobile']=$row['emp_mobile'];
				 }
				array_push($response["staffs"], $stuff);
	
				
			}
		}
		else
		{
				$stuff['emp_id']=0;
				$stuff['emp_name']='No Employee Available';
				array_push($response["staffs"], $stuff);
		}
	}
	else
	{
				$stuff['emp_id']=0;
				$stuff['emp_name']='No Employee Available';
				array_push($response["staffs"], $stuff);
		//$response[0] = array('cs_id'=>'0','cs_desc'=>'No Services Available');
	}
		
		
	$indexedOnly = array();

foreach ($response as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>