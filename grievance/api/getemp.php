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
	 $sql="select emp_id,emp_name,desg_desc,desig_marathi,emp_name_marathi,emp_mobile FROM emp_mst,desg_mst WHERE emp_mst.emp_desg=desg_mst.desg_id and emp_dept=".$_REQUEST['dept_id']." and emp_mst.ulbid='".$_REQUEST['ulbid']."' ORDER BY sort_order,emp_desg,emp_name";
	//echo $sql;
	//$fp=fopen('test.txt','a');
//	fwrite($fp,$sql);
	//fclose($fp);
	
	if($rs=mysqli_query($conn,$sql))
	{
	   
		if(mysqli_num_rows($rs)>0)
		{
		    $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            $response['data'] = array();
			$i=1;
			while($row = mysqli_fetch_assoc($rs))
			{
			      if($langId==1){
			        $data=array('sno'=>$i,'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name'],'desg_desc'=>$row['desg_desc'],'emp_mobile'=>$row['emp_mobile']);
			        }else{
			         $data=array('sno'=>$i,'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name_marathi'],'desg_desc'=>$row['desig_marathi'],'emp_mobile'=>$row['emp_mobile']);   
			        }
				$i++;
				
				
					array_push($response['data'],$data);
				
				
				
			}
		}
		else
		{
		    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
			$data = array('sno'=>'0','emp_id'=>'0','emp_name'=>'No data','desg_desc'=>'No data','emp_mobile'=>'No data');
		}
		
		
	
		
	}
	else
	{
	    $response['status_code'] = '100';
        $response['status_msg'] = 'No data Found';
		$data = array('sno'=>'0','emp_id'=>'0','emp_name'=>'No data','desg_desc'=>'No data','emp_mobile'=>'No data');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);
mysqli_close($conn);



?>