<?php
require "config.php";
    ini_set('display_errors',0);


	if(isset($_POST['id']))
	{
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		$sql ="delete from field_visit_form where id=?";
		$query=$conn->prepare($sql);
		$query->bind_param("i",htmlspecialchars(strip_tags($_REQUEST['id'])));
		$query->execute();				
		
		$sql ="delete from field_visit_form_docs where field_visit_form_id=?";
		$query=$conn->prepare($sql);
		$query->bind_param("i",htmlspecialchars(strip_tags($_REQUEST['id'])));
		$query->execute();				
	
		$msg='Deleted successfully!';
		$conn->close(); 
	   
		echo $msg;	
	}
?>