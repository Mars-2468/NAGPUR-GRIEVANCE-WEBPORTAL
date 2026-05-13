<?php 
require "config.php";
require_once('connection.php');
include('user_defined_functions.php');
require_once('prepare_connection.php');
$conn=getconnection();

		
if(isset($_SESSION['uid']))
	{
	    //$doc_id=$_REQUEST['doc_id']; 
	    $doc_id=preg_replace('/^[0-9]+$/', ' ',$_POST['doc_id']);
	 if ( !empty( $_POST['csrf_token'] ) ) {
		        
		        if( checkToken( $_POST['csrf_token'], $csrf_prefix_token ) ) {
		   
	    

	 //$sql="DELETE FROM doc_mst WHERE doc_id=".strip_tags($_POST['doc_id']);
        
      $sql ="delete from doc_mst where doc_id=?";
		       $query=$conn->prepare($sql);
		       $query->bind_param("i",$_POST['doc_id']);
		       $res=$query->execute();
		       
		       if($res)
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