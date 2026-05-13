<?php
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	
	 $sql="SELECT * FROM  `contact_tab` where ulbid='".$_REQUEST['ulbid']."'";
	$langId=$_REQUEST['lang_id'];
	if($rs=mysqli_query($conn,$sql))
	{
	    
	    if(mysqli_num_rows($rs) > 0)
		{
		    
		    $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            $response['data'] = array();
            
		
        		while($row = mysqli_fetch_assoc($rs))
        		{
        		
            		if($row['file_url']=="")
            		{
            		        $row['file_url']="http://municipalservices.in/comm_address/"."noimage.png";
            		}
            		    
            			$data=array('comm_name'=>$row['comm_name'],'designation'=>$row['designation'],'mobile'=>$row['mobile'],'photo'=>$row['file_url'],'address'=>$row['address'],'link'=>$row['link']);
            	         	        
            	        array_push($response['data'],$data);
            			
        		}
		}
		else
		{
		    $response['status_code'] = 100;
            $response['status_msg'] = 'No Data Available';
		}
	}
	else
	{
	    $data = array('address'=>'No Data Available','link'=>'No Data Available');
	}
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);

mysqli_close($conn);


?>