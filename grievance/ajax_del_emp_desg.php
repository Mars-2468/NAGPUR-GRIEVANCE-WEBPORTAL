<?php 
require "config.php";
require_once('connection.php');
include('prepare_connection.php');
$conn=getconnection();

 
if(isset($_REQUEST['emp_id']) && isset($_REQUEST['desg_id']))
	{
	
	
	 $sql="DELETE FROM emp_desg_map WHERE emp_id=? and desg_id=?";
	 $emp_id = strip_tags($_REQUEST['emp_id']);
	 $desg_id = strip_tags($_REQUEST['desg_id']);
	 $query=$conn->prepare($sql);
     $query->bind_param("ii",$emp_id,$desg_id);
        
		if($query->execute())
		{
		echo 1;
		}
		else
		{
		echo 2;
		}
		
		
		
 $query->close();           
	
}
?> 