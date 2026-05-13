<?php 
require "config.php";
require_once('connection.php');
include('prepare_connection.php');
$conn=getconnection();

 if (!preg_match("/^[0-9]+$/", $_REQUEST['id'])) // id
   {
       die('Invalid data passed to Department');
   }
   
if(isset($_REQUEST['id']))
	{
	
	
	 
		
		$sql="DELETE FROM imp_contacts WHERE id=?";
		$query=$conn->prepare($sql);
		$id=htmlspecialchars(strip_tags($_REQUEST['id']));
		$query->bind_param("i",$id);
		if($query->execute())
		{
		echo 1;
		}
		else
		{
		echo 2;
		}
		
	}	
		
		
      $query->close();      
	

?> 