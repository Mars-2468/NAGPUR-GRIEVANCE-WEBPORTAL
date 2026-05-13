<?php
session_start();
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET names=utf8');
mysqli_query($conn,'SET character_set_client=utf8');
mysqli_query($conn,'SET character_set_connection=utf8');
mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET collation_connection=utf8_general_ci');

$langId=$_REQUEST['lang_id'];

	if($_REQUEST['desg_id'])
	{
	 
	     $sql1 = "select * from emp_mst where emp_desg = '".$_REQUEST['desg_id']."'" ;
	
	$rs1=mysqli_query($conn,$sql1);
	$nr=0;
	
	if($rs1)
	{
	    $nr=1;
	
		if(mysqli_num_rows($rs1) > 0)
		{
			while($row = mysqli_fetch_assoc($rs1))
			{
				
					if($langId==1){
						$data[]=array('emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name']);
					}else{
					    $data[]=array('emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name_marathi']);
					}
					
					
				
			}
		}
		
	}
	 $sql1 = "select * from emp_mst_od where emp_desg = '".$_REQUEST['desg_id']."'" ;
	
	$rs1=mysqli_query($conn,$sql1);
		if($rs1)
	{
	    $nr=1;
	
		if(mysqli_num_rows($rs1) > 0)
		{
			while($row = mysqli_fetch_assoc($rs1))
			{
				
						if($langId==1){
						$data[]=array('emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name']);
						}else{
						  $data[]=array('emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name_marathi']);  
						}
					
					
				
			}
		}
		
	}
	
	if($nr==0)
	{
	$data[] = array('emp_id'=>'0','emp_name'=>'Query not executed');
	}
		
	}
	
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>