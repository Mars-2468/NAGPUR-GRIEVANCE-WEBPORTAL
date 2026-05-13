<?php
require "config.php";
	if(isset($_POST['id']))
	{
		
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['id'])) // id
   {
       die('Invalid data passed to Department');
   }
		

		       $sql ="delete from add_content_image where id=?";
			   $id = htmlspecialchars(strip_tags($_REQUEST['id']));
			   $query=$conn->prepare($sql);
			   $query->bind_param("i",$id);
		       if($query->execute())
		       {
		       echo "Deleted Successfully";
		       }
		       else
		       {
		       echo "Unable to delete";
		       }
		   
	      
	      
	      
	   $query->close(); 
	      
	}
?>