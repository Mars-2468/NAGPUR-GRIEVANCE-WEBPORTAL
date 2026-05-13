<?php
require "config.php";
	
		
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		

		       $sql ="delete from special_officers where  ulbid=?";
			   $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			   $query=$conn->prepare($sql);
			   $query->bind_param("s",$ulbid);
		       if($query->execute())
		       {
		       echo 1;
		       }
		       else
		       {
		       echo 0;
		       }
		   
	      
	      $query->close();
	      
	       
	      
	
?>