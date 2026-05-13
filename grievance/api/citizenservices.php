<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	
	$langId=$_REQUEST['lang_id'];
	$sql="select comp_desc as service_name,telugu_description,cutt_of_time as working_days from category3_mst where ulbid='".$_REQUEST['ulbid']."' and cs_type_id='2' order by working_days ASC";
	if($rs=mysqli_query($conn,$sql))
	{
	    if(mysqli_num_rows($rs)>0)
	    {
	        
	        $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            $response['data'] = array(); 
	        
	        
		while($row = mysqli_fetch_assoc($rs))
		{
			//$data=array('service_name'=>$row['service_name'],'working_days'=>$row['working_days']);
			if($langId==1){
			$data[$row['cs_id']]['service_name'] = $row['service_name'];
			$data[$row['cs_id']]['working_days'] = $row['working_days'];
		}else{
		    $data[$row['cs_id']]['service_name'] = $row['telugu_description'];
			$data[$row['cs_id']]['working_days'] = $row['working_days'];
		}
		}
	    }
	    
	    else
	    {
	        $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
		$data = array('service_name'=>'0','working_days'=>'No Data Available');
	    }
	    
	    array_push($response['data'],$data);
	}
	
	else
	{
	    $response['status_code'] = '100';
            $response['status_msg'] = 'No data Found';
		$data = array('service_name'=>'0','working_days'=>'No Data Available');
	}	
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);
mysqli_close($conn);



?>