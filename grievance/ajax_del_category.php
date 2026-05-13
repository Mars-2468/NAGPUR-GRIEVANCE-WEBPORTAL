<?php

	require "config.php";
	if(isset($_POST['cat_id']))
	{
		include('user_defined_functions.php');
		require_once('prepare_connection.php');
		require_once('connection.php');
		$conn=getconnection();			
	if (!preg_match("/^[0-9]+$/", $_REQUEST['cat_id'])) // id
     {
       die('Invalid data passed to Department');
     }
     
       $cat_id=$_REQUEST['cat_id']; 
			if ( !empty( $_POST['csrf_token'] ) ) {		        
		      if( checkToken( $_POST['csrf_token'], $csrf_prefix_token ) ) {		            
		            if (!preg_match("/^[0-9]+$/", $cat_id))
        			    {
        			        die('Invalid data passed to category');
        			    }
		       $sql ='delete from category_mst where cat_id=?';
		       $query=$conn->prepare($sql);
		       $query->bind_param("i",$cat_id);
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