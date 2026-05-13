<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	

	
	
	$data[]=array('water_tank_id'=>0,'water_tank_desc'=>'Select Water Tanker');
	
	
	$sql="select water_tank_id,water_tank_desc from water_tank_det_mst where ulbid='052'";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
				$data[]=array('water_tank_id'=>$row['water_tank_id'],'water_tank_desc'=>$row['water_tank_desc']);
			}
		}
		else
		{
			$data[] = array('water_tank_id'=>'0','water_tank_desc'=>'No Data Available');
		}
	}
	else
	{
	$data[] = array('water_tank_id'=>'0','water_tank_desc'=>'Query not executed');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>