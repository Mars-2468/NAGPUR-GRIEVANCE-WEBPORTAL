	<?php
	ini_set('display_errors',0);
	require_once('connection.php');
		$conn=getconnection();
		$max_stored_id='';
		
		$sql="SELECT grievance_id,ulbid,cat3_id,grievance_status_id FROM grievances g where app_type_id=? and
	    (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?)";
		$app_type_id=1;
		$grievance_status_id1 =9;
		$grievance_status_id2=10;
		$grievance_status_id3=4;
		$query= $conn->prepare($sql);
		$query->bind_param("iiii",$app_type_id,$grievance_status_id1,$grievance_status_id2,$grievance_status_id3);
		$query->execute();
		$rs=$query->get_result();
		
		
			while($row=$rs->fetch_assoc())
			{
			 
			  $grievance_id=$row['grievance_id'];
			  $ulbid=$row['ulbid'];
			  $cat3_id=$row['cat3_id'];
			  $grievance_status_id=$row['grievance_status_id'];
			  
			
			 	
			 		$sql="SELECT * FROM grievances WHERE grievance_id=?";
			 	    $grievance_id=$grievance_id;
			 	    $query= $conn->prepare($sql);
			 	    $query->bind_param("i",$grievance_id);
			 	
			
                  $sql = "INSERT INTO complaints_map_info(grievance_id,ulbid,cat3_id,status_id)
                  VALUES (?,?,?,?)";
                  $query=$conn->prepare($sql);
                  $grievance_id=strip_tags($grievance_id);
                  $ulbid=strip_tags($ulbid);
                  $cat3_id=strip_tags($cat3_id);
                  $status_id=strip_tags($grievance_status_id);
                  $query->bind_param("isii",$grievance_id,$ulbid,$cat3_id,$status_id);
                  
                  
                  $query->execute();
                  
                
			 
       
			}
			$conn->close();
			
	?>
	