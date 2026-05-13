<?php
    
	require "config.php";
	ini_set('display_errors',1);
	if(isset($_POST['username']))
	{
	    
	    include('user_defined_functions.php');
		
		require_once('connection.php');
	$conn=getconnection();
		
		$sql ="select * from users where user_id='".$_POST['username']."'";
		$rs = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($rs);
		if($nr > 0)
		{
		    echo 1;
		}
		else
		{
		    echo 0;
		}
		
	       
	      
	}
?>