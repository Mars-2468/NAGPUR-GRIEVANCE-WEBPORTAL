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

	if($_REQUEST['dept_id'])
	{
	 
	     $sql1 = "select * from desg_mst where dept_id = '".$_REQUEST['dept_id']."'" ;
	
	$rs1=mysqli_query($conn,$sql1);
	
	if($rs1)
	{
	
		if(mysqli_num_rows($rs1) > 0)
		{
			while($row = mysqli_fetch_assoc($rs1))
			{
				
					if($langId==1){
						$data[]=array('desg_id'=>$row['desg_id'],'desg_desc'=>$row['desg_desc']);
					}else{
					   $data[]=array('desg_id'=>$row['desg_id'],'desg_desc'=>$row['desig_marathi']); 
					}
					
					
				
			}
		}
		else
		{
			$data[] = array('desg_id'=>'0','desg_desc'=>'No Data Available');
		}
	}
	else
	{
	$data[] = array('desg_id'=>'0','desg_desc'=>'Query not executed');
	}
		
	}
	
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>