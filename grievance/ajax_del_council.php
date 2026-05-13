<?php
    
	require "config.php";
	ini_set('display_errors',0);
	if(isset($_POST['id']))
	{
	    
	    include('user_defined_functions.php');
		
		require_once('prepare_connection.php');
		//$conn=getconnection();
		
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['id'])) // id
              die('Invalid data passed to ward');
              else
              $id=$_REQUEST['id'];
              
              
		
		if ( !empty( $_POST['csrf_token'] ) ) {
		        
		        if( checkToken( $_POST['csrf_token'], $csrf_prefix_token ) ) { 
		            
		            if (!preg_match("/^[0-9]+$/", $id))
        			    {
        			        die('Invalid data passed to ward');
        			    }
		            
		            
		            
		
	
		
		$sql ="select id from council_mst where id=? and ulbid=?";
		
		$query=$conn->prepare($sql);
		$query->bind_param("is",$id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$nr=$query->num_rows();
		$query->close();
		
		
		if($nr > 0 )
		{
		echo 2;
		}
		else
		{
		
		       $sql ='delete from council_mst where id=? and ulbid=?';
		       $query=$conn->prepare($sql);
		       $query->bind_param("is",$id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
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