<?php
require "config.php";
	if(isset($_POST['content_no']))
	{
		
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
	
		       $sql ='delete from add_content_image where content_no=?';
		       $query=$conn->prepare($sql);
		       $content_no=htmlspecialchars(strip_tags($_REQUEST['content_no']));
		       $query->bind_param("i",$content_no);
		       if($query->execute())
		       {
			       
			       $sql ='delete from add_content_media_coverage where content_no=?';
		           $query=$conn->prepare($sql);
		           $content_no=htmlspecialchars(strip_tags($_REQUEST['content_no']));
		           $query->bind_param("i",$content_no);
			       if($query->execute())
			       {
			      	 echo "Deleted Successfully";
			       }
			       else
			       {
			       echo "Unable to delete";
			       }
		       }
		       else
		       {
		       echo "Unable to delete";
		       }
	      
	      
	      $query->close();
	       
	      
	}
?>