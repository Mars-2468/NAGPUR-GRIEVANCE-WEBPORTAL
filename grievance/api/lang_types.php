<?php
    error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$sql ="SELECT * FROM lang_category_mst";
	
	if($rs=mysqli_query($conn,$sql))
	{
	
	    if(mysqli_num_rows($rs)>0)
	    {
	      
	        $response['status_code'] = 200;
            $response['status_msg'] = 'success';
            $response['data'] = array();
	      
			while($row = mysqli_fetch_assoc($rs))
			{
				$data=array('id' => $row['id'], 'name'=>$row['name'], 'code'=>$row['code']);
				array_push($response['data'],$data);
			}
			
		}
		else
		{
			$response['status_code'] = '100';
			$response['status_msg'] = 'No data Found';
			array_push($response['data'],$data);
		}
	
	}
	else
	{
	    $response['status_code'] = '100';
        $response['status_msg'] = 'No data Found';
		$data = array();
		
		array_push($response['data'],$data);
		
	}
	
	$indexedOnly = array();
	
    header("Content-Type: application/json");
    echo json_encode($response, true);
    mysqli_close($conn);

?>