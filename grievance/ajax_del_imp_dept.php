<?php

require "config.php";
	if(isset($_POST['dept_id']))
	{
		
	    include('user_defined_functions.php');
		require_once('prepare_connection.php');
		require_once('connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['dept_id'])) // id
   {
       die('Invalid data passed to Department');
   }
		
	  $dept_id=strip_tags($_REQUEST['dept_id']);
              
	
	    	$sql ='delete from dept_imp_mst where dept_id=? and ulbid=?';
		       $query=$conn->prepare($sql);
		       $query->bind_param("is",$dept_id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
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