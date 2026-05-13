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
	
	$sql ="select c.cs_id,c.cs_desc as comp_desc,c.telugu_description from  cs_mst c,complaint_ulbmap cu where c.cs_id=cu.cs_id and cu.ulbid='".$_REQUEST['ulbid']."' and cu.flag='1'";
	
	$data1=array('cs_id'=>0,'cs_desc'=>'Select Complaint');
	if($rs=mysqli_query($conn,$sql))
	{
	    
	    if(mysqli_num_rows($rs) > 0)
	    {
	        $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            $response['data'] = array();
            
            array_push($response['data'],$data1);
	    
    		while($row = mysqli_fetch_assoc($rs))
    		{
    		  //  $data=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['comp_desc']."/".$row['telugu_description']);
    		    if($langId==1){
    			$data=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['comp_desc']);
    		}else{
    		    $data=array('cs_id'=>$row['cs_id'],'cs_desc'=>$row['telugu_description']);
    		}
    			//$data[$row['cs_id']]['cs_id'] = $row['cs_id'];
    			//$data[$row['cs_id']]['cs_desc'] = $row['comp_desc']."/".$row['telugu_description'];
    			
    				array_push($response['data'],$data);
    		}
	    }
	    else
	    {
	      $response['status_code'] = '100';
          $response['status_msg'] = 'No data Found'; 
          $data = array('cs_id'=>'0','cs_desc'=>'No Complaints Available');
	    }
	}
	else
	{
	    $response['status_code'] = '100';
        $response['status_msg'] = 'No data Found';
		$data = array('cs_id'=>'0','cs_desc'=>'No Complaints Available');
	}
	

		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);
mysqli_close($conn);



?>