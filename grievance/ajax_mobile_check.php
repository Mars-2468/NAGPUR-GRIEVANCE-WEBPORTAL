<?php

require "config.php";
	if(isset($_REQUEST['mobile']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		
 if (!preg_match("/^[0-9]+$/", $_REQUEST['mobile'])) // id
   {
       die('Invalid data passed to Department');
   }
   
		       $sql ="select emp_mobile from emp_mst where emp_mobile=?";
			   $emp_mobile = htmlspecialchars(strip_tags($_REQUEST['mobile']));
			   $query=$conn->prepare($sql);
			   $query->bind_param("s",$emp_mobile);
			   $query->execute();
			  $rs=$query->get_result();
			   
		      
		       if($rs->num_rows > 0)
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