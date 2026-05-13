<?php
require "config.php";
error_reporting(0);
	if(isset($_POST['dept_id']))
	{
		
		require_once('connection.php');
		include('user_defined_functions.php');
		require_once('prepare_connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['dept_id'])) 
   {
       die('Invalid data passed to Department');
   }
	$dept_id=$_REQUEST['dept_id'];	
		
	if ( !empty( $_POST['csrf_token'] ) ) {
		        
		        if( checkToken( $_POST['csrf_token'], $csrf_prefix_token ) ) {
		      
		       
		      if (!preg_match("/^[0-9]+$/", $dept_id))
        			    {
        			        die('Invalid data passed to department');
        			    }
		     
		       $sql ='delete from hod_mst where dept_id=? and ulbid=?';
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