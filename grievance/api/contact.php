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
	
	 $sql="SELECT * FROM  `comm_tab` where ulbid='".$_REQUEST['ulbid']."'";
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
        		    if($langId==1){
        			$data['comm_name']=$row['comm_name'];
        			$data['designation']=$row['designation'];
        			$data['address']=$row['address'];
        			$data['mobile']=$row['mobile'];
        			$data['photo']=$row['file_url'];
        			$data['email']=$row['email'];
        			$data['land_line']=$row['land_line'];
        			$data['fax']=$row['fax'];
        			
        		    }else{
        		    $data['comm_name']=$row['comm_name_marathi'];
        			$data['designation']=$row['designation_marathi'];
        			$data['address']=$row['address_marathi'];
        			$data['mobile']=$row['mobile'];
        			$data['photo']=$row['file_url'];
        			$data['email']=$row['email'];
        			$data['land_line']=$row['land_line'];
        			$data['fax']=$row['fax'];
        		    }
        			
        		}
           }
           else
           {
               $response['status_code'] = '100';
               $response['status_msg'] = 'No data Found';
               $data = array('address'=>'No Data Available','link'=>'No Data Available');
           }
           
           array_push($response['data'],$data);
           
	}
	else
	{
	  $response['status_code'] = '100';
      $response['status_msg'] = 'No data Found';  
	  $data = array('address'=>'No Data Available','link'=>'No Data Available');  
	}	
		
	$indexedOnly = array();

foreach ($data as $row) 
{
    $indexedOnly[] = array_values($row);
}

echo json_encode($response);
mysqli_close($conn);




?>