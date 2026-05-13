<?php 
require "config.php";
require_once('connection.php');
include('user_defined_functions.php');
require_once('prepare_connection.php');
$conn=getconnection();

	
if(isset($_SESSION['uid']))
	{
	   
	if ( !empty( $_POST['csrf_token'] ) ) {
		        
		        if( checkToken( $_POST['csrf_token'], $csrf_prefix_token ) ) {
		            $id=$_POST['id'];
		            

		     
		       $sql ='delete from public_holydays where id=?';
		       $query=$conn->prepare($sql);
		       $query->bind_param("i",$id);
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
		        else
		        {
		            echo 3;
		        }
		        
		}
		else
		{
		    echo 4;
		}
		$conn->close();         
}

?> 