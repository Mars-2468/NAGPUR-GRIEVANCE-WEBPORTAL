<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	$tablescontions=array('ifyes','ifno','Condition');
	$response['status_code']=200;
	$response['message']='success';
    foreach($tablescontions as $type){
         $tableData = array();
	     $setData['id'] = '0';
         $setData['desc'] = '--Select--';
         array_push($tableData,$setData);
	 $sql="select * from geotagging_cat_dropdown where type='$type'";
	if($rs=mysqli_query($conn,$sql))
	{  
	     while($row = mysqli_fetch_assoc($rs))
		{
		
			        $setData['id']   = $row['id'];
	                $setData['desc'] = $row['desc'];
	                array_push($tableData,$setData);
		}
		 $response[$type] = $tableData;
		 
	}
	
    }
	

		
	
echo json_encode($response);
mysqli_close($conn);



?>