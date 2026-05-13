<?php
	ini_set('display_errors',0);
	require_once('connection.php');
		$conn=getconnection();
	
		
			$sql = $conn->prepare("select g.grievance_id,g.date_regd,gt.disposed_date from grievances g LEFT join grievances_transactions gt on g.grievance_id=gt.grievance_id where g.app_type_id=? and (gt.disposal_status=? or gt.disposal_status=? or gt.disposal_status=? or gt.disposal_status=? or gt.disposal_status=?) and response_time=''");
			$app_type_id=1; 
			$disposal_status_4 =4;$disposal_status_6 =6;
			$disposal_status_9 =9;$disposal_status_10 =10;
			$disposal_status_12 =12;
			$sql->bind_param("iiiiii",$app_type_id,$disposal_status_4,$disposal_status_6,$disposal_status_9,$disposal_status_10,$disposal_status_12);
			
			$sql->execute();
	        $rs=$sql->get_result();
			while($row= $rs->fetch_assoc())
			{
			 
			   $grievance_id=$row['grievance_id'];
			   $date_regd=$row['date_regd'];
			   $disposed_date=$row['disposed_date'];
						   
				$start1  = date_create($date_regd);
				$end1 	= date_create($disposed_date); // Current time and date			   
			    $diff  = date_diff( $end1, $start1 );
			   $response_time=$diff->d.":".$diff->h.":".$diff->i.":".$diff->s;
			   
			   
			   $sql = $conn->prepare("UPDATE `grievances` SET `response_time`=? where grievance_id=?");
			     $sql->bind_param("si",$response_time,$grievance_id);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			   
			}
			
			$conn->close();
			
			
	?>
	