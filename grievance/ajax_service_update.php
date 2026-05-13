<?php
require "config.php";
	if(isset($_POST['cs_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();

 if (!preg_match("/^[0-9]+$/", $_REQUEST['cs_id'])) // id
   {
       die('Invalid data passed to Department');
   }

           $sql = $conn->prepare("UPDATE category3_mst SET comp_desc=? WHERE cs_id=?");
           $sql->bind_param("si",htmlspecialchars(strip_tags($_REQUEST['comp_desc'])),htmlspecialchars(strip_tags($_REQUEST['cs_id'])));
           
	      
	       if($sql->execute())
	       {
	       echo 1;
	       }
	       else
	       {
	       echo 0;
	       }
	      
	      
	   $conn->close();   
	       
	 
	}
?>