<?php
require "config.php";
	if(isset($_POST['tanker_id']))
	{
		
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
	 if (!preg_match("/^[0-9]+$/", $_REQUEST['tanker_id'])) // tanker_id
   {
       die('Invalid data passed to Department');
   }
   
		        $sql ="delete from water_tanker_emp_map where water_tank_id=? and ulbid=?";
				$tanker_id = htmlspecialchars(strip_tags($_REQUEST['tanker_id']));
				$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
				
				$query=$conn->prepare($sql);
			   $query->bind_param("is",$tanker_id,$ulbid);
		       if($query->execute())
		       {
		       echo 1;
		       }
		       else
		       {
		       echo 0;
		       }
		   
	      
	      
	      $query->close();
	       
	      
	}
?>