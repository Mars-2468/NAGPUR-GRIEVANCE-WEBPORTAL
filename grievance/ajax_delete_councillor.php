<?php
require "config.php";
	ini_set('display_errors',0);

	if(isset($_REQUEST['id']))
	{
		
		require_once('connection.php');
		require_once('prepare_connection.php');
		$conn=getconnection();
		
		$id=$_REQUEST['id'];
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['id'])) // id
   {
       die('Invalid data passed to Department');
   }

		       
		       $sql ='delete from council_mst where  ulbid=? and id=?';
		       $query=$conn->prepare($sql);
		       $query->bind_param("si",htmlspecialchars(strip_tags($_SESSION['ulbid'])),$id);
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