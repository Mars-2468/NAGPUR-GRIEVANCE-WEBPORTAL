<?php
require "config.php";
ini_set('display_errors',0);
	if(isset($_POST['id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		include('prepare_connection.php');
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['id'])) 
   {
       die('Invalid data passed to Department');
   }
		

		       
		       
		   $id=strip_tags($_REQUEST['id']);
	            $sql ="delete from add_content where id=? and ulbid=?";
				$query=$conn->prepare($sql);
				$query->bind_param("is",$id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
				
				if($query->execute())
				{
		        echo 1;
		        }
		        else
		        {
		        echo 2;
		        }
		
	      
	      
	      
	       
	    
	    //$sql->close();
	}
?>