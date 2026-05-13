<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_REQUEST['ulbid']))
	{
		
		require_once('connection.php');
		$conn=getconnection();	
		
		 $sql ="select description from about_municipality where ulbid='".strip_tags($_REQUEST['ulbid'])."'";
		 $rs=mysqli_query($conn,$sql);
		 
		if(mysqli_num_rows($rs) > 0)
		{
		$row = mysqli_fetch_assoc($rs);
		$description= $row['description'];
		}
		else
		{
		$description="Data Not Available";
		}
	}
	else
	{
	$description="Invalid id";
	}
		
		
	mysqli_close($conn);	
		
		
?>


<div style="text-align:justify; font-family: 'Roboto', sans-serif; padding:20px; line-height:1.8pc;">

<?php echo $description; ?>
</div>











