<?php
	
		ini_set('display_errors',0);
	    require_once('connection.php');
		$conn=getconnection();
		
		
			$max_stored_id='';
			$status_id = 0;
		
			$sql=$conn->prepare("SELECT min(`grievance_id`) as max_id FROM `services_map_info` where status_id=?");
			$sql->bind_param("i",htmlspecialchars(strip_tags($status_id)));
		    
				$sql->execute();
			    $rs=$sql->get_result();
			
		 $row=$rs->fetch_assoc();
		 $max_stored_id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$row['max_id']));
	
		$app_type_id = 2;
		if($rs->num_rows == 0)
		{
		        $sql=$conn->prepare("select grievance_id,grievance_status_id from grievances where app_type_id=?");
		        $sql->bind_param("i",htmlspecialchars(strip_tags($app_type_id)));
				
		}else
		{
		         $sql=$conn->prepare("select grievance_id,grievance_status_id from grievances where app_type_id=? and grievance_id=?");
		        $sql->bind_param("ii",htmlspecialchars(strip_tags($app_type_id)),$max_stored_id);
		    
		   
		}
	
			$sql->execute();
			$rs=$sql->get_result();
			while($row=$rs->fetch_assoc())
			{
			  $grievance_id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$row['grievance_id']));
			  $status_id=strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$row['grievance_status_id']));
			
			   $sql=$conn->prepare("UPDATE `services_map_info` SET `status_id`=? where grievance_id=?");
		       $sql->bind_param("ii",$status_id,$grievance_id);
			 
			  $sql->execute();
			  $sql->get_result();
             
			   
        
			}
			$sql->close();
			
	?>
	