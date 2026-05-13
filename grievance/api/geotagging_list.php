<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	
	if(empty($_POST)){
	$sql="select * from geotagging_cat_mst where ParentId=0";
	if($rs=mysqli_query($conn,$sql))
	{   $response['status_code']=200;
	    $response['message']='success';
	   
		while($row = mysqli_fetch_assoc($rs))
		{
			$data[]=array('Id'=>$row['Id'],'Description'=>$row['Description'],'Icon'=>$row['Icon'],'color'=>$row['color']);
		}
		 $response['data']=$data;
	}
	else{
		$response['status_code']=100;
	    $response['message']='No data found';
	    
	}
	}
	if($_POST['Id']==1){
	    $ParentId=$_POST['Id'];
	    $sql="select * from geotagging_cat_mst where ParentId=$ParentId";
	if($rs=mysqli_query($conn,$sql))
	{   $response['status_code']=200;
	    $response['message']='success';
	   
		while($row = mysqli_fetch_assoc($rs))
		{
			$data[]=array('Id'=>$row['Id'],'Description'=>$row['Description']);
		}
		 $response['data']=$data;
	}
	else{
		$response['status_code']=100;
	    $response['message']='No data found';
	    
	}
	    
	}
		
	
echo json_encode($response);
mysqli_close($conn);



?>