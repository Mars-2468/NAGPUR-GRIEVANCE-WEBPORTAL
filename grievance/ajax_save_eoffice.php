<?php 
require "config.php";
require_once('connection.php');
$conn=getconnection();

 if (!preg_match("/^[0-9]+$/", $_REQUEST['ref_no'])) 
   {
       die('Invalid data passed to Department');
   }

if(isset($_REQUEST['ref_no']))
	{
	
	
	  $sql="UPDATE grievances SET eoffice_no= ?  WHERE grievance_id=?";
	  $eoffice_no = htmlspecialchars(strip_tags($_REQUEST['eofficeno']));
	  $gid = htmlspecialchars(strip_tags($_REQUEST['ref_no']));
	  $query=$conn->prepare($sql);
	  $query->bind_param("si",$eoffice_no,$gid);
	 
	  
        
		if($query->execute())
		{
		echo 'Updated Successfully';
		}
		else
		{
		echo 'Unable to update, Try again';
		}
		
		
		
   $query->close();         
	
}
?> 