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
	$sql="select dim.dept_id,dim.dept_desc from dept_imp_mst dim,imp_contacts ic where ic.dept_id=dim.dept_id and ic.ulbid='".$_REQUEST['ulbid']."' group by dept_id order by dim.dept_id";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
		    
		            $response['status_code'] = 200;
                	$response['status_msg'] = 'success';
                	    
                	 $response['data'] = array(); 
		    
		    
			while($row = mysqli_fetch_assoc($rs))
			{
				if($langId==1){
				    $data=array('dept_id'=>$row['dept_id'],'dept_desc'=>$row['dept_desc']);
				}else{
				    $data=array('dept_id'=>$row['dept_id'],'dept_desc'=>$row['dept_desc_marathi']); 
				}
			}
		}
		else
		{
			$response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			$data = array('dept_id'=>'0','description'=>'No Data Available');
		}
		
			array_push($response['data'],$data);
			
			
	}
	else
	{
	$data[] = array('dept_id'=>'0','dept_desc'=>'Query not executed');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>