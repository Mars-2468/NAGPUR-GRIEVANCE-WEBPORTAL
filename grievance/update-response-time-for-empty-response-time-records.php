<?php
ini_set('display_errors',0);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();		
		
		
		$sql="select g.grievance_id,g.date_regd,gt.disposed_date from grievances g LEFT join grievances_transactions gt
		on g.grievance_id=gt.grievance_id where (g.grievance_status_id=? or g.grievance_status_id=? or g.grievance_status_id=?) and g.response_time=?";	
		
	        $query=$conn->prepare($sql);
    	    $grievance_status_id = [4,6,9];
            $grievance_status_id1 = 4;
            $grievance_status_id2 =6;
            $grievance_status_id3 =9;
            $response_time='';	
		    $query->bind_param("iiis",htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),htmlspecialchars(strip_tags($response_time)));
            $query->execute();
		    $rs=$query->get_result();	
			
		
			  while($row = $rs->fetch_assoc())
			    {
			    $grievance_id=$row['grievance_id'];
			    $date_regd=$row['date_regd'];
			    $disposed_date=$row['disposed_date'];
					   
				$start1  = date_create($date_regd);
				$end1 	= date_create($disposed_date); 	   
			    $diff  = date_diff( $end1, $start1 );
			    $response_time=$diff->d.":".$diff->h.":".$diff->i.":".$diff->s;
			   
                $sql ="update grievances set response_time=? where grievance_id=?";
                $query=$conn->prepare($sql);
                $response_time=$response_time;
                $grievance_id=$grievance_id;
                $query->bind_param("si",$response_time,htmlspecialchars(strip_tags($grievance_id)));
                $query->execute();
               
			    }

		echo "complaints updated";
		$conn->close();
		
  ?>