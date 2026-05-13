<?php
require "config.php";
$_SESSION['formStatus']=1;
if($_POST['setVillage'])
		{
		    $_SESSION['ulbid']=$_POST['ulbid'];
		    $url =$_POST['url'];
		    
		    
		    echo "<script>window.location='".$url."'</script>";
		   
		}
?>