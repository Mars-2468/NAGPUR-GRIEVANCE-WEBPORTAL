<?php 
require "config.php";
 	ini_set('display_errors',0);
if(isset($_SESSION['uid']))
{
    session_regenerate_id();
    
   
        if(isset($_REQUEST['emp_id']))
        {
        
        require_once('prepare_connection.php');
        	
        	$sql ="select * from emp_mst where emp_id=? and ulbid=?";
        	$query=$conn->prepare($sql);
        	$emp_id = mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
        	$query->bind_param("is",$emp_id,$_SESSION['ulbid']);
        	 if(!$query->execute())
            {
                echo "Query not executed 1";
            }
            
            $rs=$query->get_result();
        	$row = $rs->fetch_assoc();
        	if(count($row) > 0)
        	{
        	    
        
        	
        	
        		echo $row['emp_mobile'];
        		echo "::";
        		echo $row['emp_name'];
        		echo "::";
        		echo $row['emp_dept'];
        		echo "::";
        		echo $row['emp_code'];
        	}
        	else
        	{
        	    $sql ="select * from emp_mst_od where emp_id=? and ulbid=?";
        	$query=$conn->prepare($sql);
        	$emp_id = mysqli_real_escape_string($conn,htmlspecialchars(strip_tags($_REQUEST['emp_id'])));
        	$query->bind_param("ss",$emp_id,$_SESSION['ulbid']);
        	 if(!$query->execute())
            {
                echo "Query not executed 1";
            }
            
            $rs=$query->get_result();
        	$row = $rs->fetch_assoc();
        	
        	
        		echo $row['emp_mobile'];
        		echo "::";
        		echo $row['emp_name'];
        		echo "::";
        		echo $row['emp_dept'];
        		echo "::";
        		echo $row['emp_code'];

        	}
        	
       
        
                	
        $query->close(); 
        
        }
        else
        {
           die('Invalid credentials'); 
        }
}
else
{
    die('User login fails');
}

?> 