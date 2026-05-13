<?php
session_start();
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
	
	if($_REQUEST['ulbid'])
	{
	  /* $sql="select ulbid from emp_mst where emp_id = '".$_REQUEST['emp_id']."' ";
	    $rs = mysqli_query($conn,$sql);
	    $row = mysqli_fetch_assoc($rs);
	    $ulbid = $row['ulbid'];*/
	    
	     $sql1 = "select * from dept_mst where ulbid = '".$_REQUEST['ulbid']."'" ;
	
	$rs1=mysqli_query($conn,$sql1);
	
	if($rs1)
	{
	
		if(mysqli_num_rows($rs1) > 0)
		{
		    
		    $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            $response['data'] = array();
		    
		    
		    
			while($row = mysqli_fetch_assoc($rs1))
			{
				
				if($langId==1){
				$data=array('dept_id'=>$row['dept_id'],'dept_desc'=>$row['dept_desc']);
				}else{
				 $data=array('dept_id'=>$row['dept_id'],'dept_desc'=>$row['dept_marathi']);   
				}
						//$data[$row['dept_id']]['dept_id'] = $row['dept_id'];
						//$data[$row['dept_id']]['dept_desc'] = $row['dept_desc'];
						
						
					array_push($response['data'],$data);		
					
					
				
			}
		}
		else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			$data= array('dept_id'=>'0','dept_desc'=>'No Data Available');
		}
		
	
	}
	else
	{
	    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
	$data = array('dept_id'=>'0','dept_desc'=>'Query not executed');
	}
		
	}
	
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>