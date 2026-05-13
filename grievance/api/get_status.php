<?php
ini_set('display_errors',0);
session_start();
	require_once('../connection.php');
	$conn=getconnection();
	
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET names=utf8');
    mysqli_query($conn,'SET character_set_client=utf8');
    mysqli_query($conn,'SET character_set_connection=utf8');
    mysqli_query($conn,'SET character_set_results=utf8');
    mysqli_query($conn,'SET collation_connection=utf8_general_ci');
    
    $langId=$_REQUEST['lang_id'];
	
	/*if($_REQUEST['Complaint_no'])
	{
	    
	    $sql1 = "select grievance_status_id from grievances where grievance_id = '".$_REQUEST['Complaint_no']."' ";
	    $rs1 = mysqli_query($conn,$sql1);
	    $rows = mysqli_fetch_assoc($rs1);
	    
	    if($rows['grievance_status_id'] == '11')
	    {
	        $sql="select * from grievance_status_mst  where grievance_status_id  IN('11') order by grievance_status_id ASC";
	    }
	    
	    else
	    {
	        $sql="select * from grievance_status_mst  where grievance_status_id NOT IN('1','9','11','12','2','13') order by grievance_status_id ASC";
	    }
	    
	}
	
	*/
	
	
	
	$sql="select * from grievance_status_mst  where grievance_status_id NOT IN('1','9','11','12','2','13','5') order by grievance_status_id ASC";
	
	
	if($_SESSION['emp_id']=='2398')
	{
	    $sql="select * from grievance_status_mst  where grievance_status_id NOT IN('1','9','11','12','2','13') order by grievance_status_id ASC";
	}
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
				
					    if($langId==1){
						$data[]=array('status_id'=>$row['grievance_status_id'],'status_desc'=>$row['grievance_status_desc']);
					    }else{
					    $data[]=array('status_id'=>$row['grievance_status_id'],'status_desc'=>$row['grievance_status_desc_marathi']);    
					    }
			}
		}
		else
		{
			$data[] = array('status_id'=>'0','status_desc'=>'No Data Available');
		}
	}
	else
	{
	$data[] = array('status_id'=>'0','status_desc'=>'Query not executed');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>