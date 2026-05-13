	<?php

		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();		
	
		$sql =$conn->prepare("SELECT grievance_id,response_time FROM  complaints_map_info where response_time!=? and response_time!=?");
		$response_time='';
		$response_time1='0:0:0:0';
		$sql->bind_param("ss",$response_time,$response_time1);
		$sql->execute();
	    $rs=$sql->get_result();
		
			
		while($row=$rs->fetch_assoc())
		{
		  $grievance_id=$row['grievance_id'];
		  $response_time=$row['response_time'];
		  
		  $sql ="update grievances set response_time=? where grievance_id=?";
                $query=$conn->prepare($sql);
                $response_time=$response_time;
                $grievance_id=$grievance_id;
                $query->bind_param("si",$response_time,htmlspecialchars(strip_tags($grievance_id)));
                $query->execute();
	   
		}
		
		echo "complaints updated";
		
			
		
		$sql =$conn->prepare("SELECT grievance_id,response_time FROM  services_map_info where response_time!=? and response_time!=?");
		$response_time='';
		$response_time2='0:0:0:0';
		$sql->bind_param("ss",$response_time,$response_time2);
		$sql->execute();
	    $rs=$sql->get_result();
		
			
		while($row=$rs->fetch_assoc())
		{
		  $grievance_id=$row['grievance_id'];
		  $response_time=$row['response_time'];
		 
		   $sql ="update grievances set response_time=? where grievance_id=?";
                $query=$conn->prepare($sql);
                $response_time=$response_time;
                $grievance_id=$grievance_id;
                $query->bind_param("si",$response_time,htmlspecialchars(strip_tags($grievance_id)));
                $query->execute();
	   
		}
		
		echo "services updated";
		$conn->close();
	
	
	?>
	