<?php
require "config.php";
 if($_SESSION['session_id']==session())
 {
            require_once('connection.php');
    		$conn=getconnection();
    		
    	if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['taker_number'])) // taker_number
   {
       die('Invalid data passed to Department');
   }	
    		
    		
     if(isset(mysqli_real_escape_string($conn,preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['taker_number']))))
    {
            
    	
                   $sql="SELECT name FROM tanker_mst WHERE taker_number= ?";
				   
				    $tanker_number = mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['taker_number'])));
				    $query=$conn->prepare($sql);
					$query->bind_param("s",$tanker_number);
					$query->execute();
					$rs=$query->get_result();
					$row= $rs->fetch_assoc();
    			    echo $row['name'];
                    $query->close();
    }
    else
    {
        die('Invalid details');
    }
}
else
{
    die('user login failed');
}
?>