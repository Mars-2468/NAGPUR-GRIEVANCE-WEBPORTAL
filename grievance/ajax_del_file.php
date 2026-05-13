<?php 
require "config.php";
require_once('connection.php');
include('prepare_connection.php');
$conn=getconnection();

 
if(isset($_REQUEST['docfile_id']))
	{
	
	
	 $sql="DELETE FROM field_visit_form_docs WHERE id=? ";
	 $docfile_id = strip_tags($_REQUEST['docfile_id']);
	
	 $query=$conn->prepare($sql);
     $query->bind_param("i",$docfile_id);
        
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