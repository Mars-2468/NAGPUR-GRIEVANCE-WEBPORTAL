	<?php

        ini_set('display_errors',0);
		require_once('connection.php');
		$conn=getconnection();
		
		$max_stored_id='';
		$sql="SELECT max(`grievance_id`) as max_id FROM `services_map_info`";
		
        		 $query = $conn->prepare($sql);
        		 $query->execute();
        		 $rs = $query->get_result();
	
		$row=$rs->fetch_assoc();
		$max_stored_id=$row['max_id'];
		
		if($rs->num_rows == 0)
		{
			$sql="SELECT g.grievance_id,c.merg_cs_id,g.cat3_id,c.cs_type_id,c.dept_id,g.ulbid,g.user_type FROM `grievances` g LEFT join
            category3_mst c on g.cat3_id=c.cs_id where g.app_type_id=?";
            
                 $app_type_id = 2;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("i",$app_type_id);
        		
            
            
            
		}
		else
		{
		   $sql="SELECT g.grievance_id,c.merg_cs_id,g.cat3_id,c.cs_type_id,c.dept_id,g.ulbid,g.user_type FROM `grievances` g LEFT join
            category3_mst c on g.cat3_id=c.cs_id where g.app_type_id=2 and grievance_id >".$max_stored_id;
            
            $query = $conn->prepare($sql);
		}
       
       
             $query->execute();
        	$rs = $query->get_result();
		
			while($row=$rs->fetch_assoc())
			{
			  $grievance_id=htmlspecialchars(strip_tags($row['grievance_id']));
			  $ulbid=htmlspecialchars(strip_tags($row['ulbid']));
			  $cat3_id=htmlspecialchars(strip_tags($row['cat3_id']));
			   $user_type=htmlspecialchars(strip_tags($row['user_type']));
			   $dept_id=htmlspecialchars(strip_tags($row['dept_id']));
			   $merg_cs_id=htmlspecialchars(strip_tags($row['merg_cs_id']));
			   $cs_type_id=htmlspecialchars(strip_tags($row['cs_type_id']));
			  
			  $sql = "INSERT INTO services_map_info(grievance_id,ulbid,cat3_id,user_type,dept_id,merg_cs_id,cs_type_id)
                  VALUES (?,?,?,?,?,?,?)";
                
         
		         $grievance_id = $grievance_id;
        		 $ulbid = $ulbid;
        		 $cat3_id = $cat3_id;
        		 $user_type = $user_type;
        		 $dept_id = $dept_id;
        		 $merg_cs_id = $merg_cs_id;
        		 $cs_type_id = $cs_type_id;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("isiiiii",$grievance_id,$ulbid,$cat3_id,$user_type,$dept_id,$merg_cs_id,$cs_type_id);
        		 
		         $query->execute();
        	     $rs = $query->get_result();
			}
			
		$conn->close();	
	?>
	