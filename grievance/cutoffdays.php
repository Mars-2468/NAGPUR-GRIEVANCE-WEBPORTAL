<?php

require_once('connection.php');
		$conn=getconnection();
		

 
		     
		     $sql1 = "select cutt_off_time from comp_cutofdays_map where cs_id =?";
		     $cs_id=12;
		     $query=$conn->prepare($sql1);
		     $query->bind_param("i",$cs_id);
		     $query->execute();
		     $rs1=$query->get_result();
		     $row = $rs1->fetch_assoc();
		     $row['cutt_off_time'];
		     echo $date1=date('Y-m-d');
		    //echo $date = strtotime("+".$row['cutt_of_time']." days", strtotime($date1));
		    
		     $newdate =  strtotime ( '+ '.$row['cutt_off_time'].' days' , strtotime ( $date1 ) ) ;
		      echo  $newdate = date ( 'Y-m-d' , $newdate );










?>