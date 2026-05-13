<?php 
require "config.php";
ini_set('display_errors',0);
require_once('Smarty.class.php');
	$tpl=new Smarty();

	
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
	
	
if(isset($_POST['mobile']))
{
 $mobile=strip_tags($_POST['mobile']);

 $sql="SELECT mobile FROM council_mst WHERE mobile=? ";
 
 $mobile=$mobile;
 $query=$conn->prepare($sql);
 $query->bind_param("i",$mobile);

$query->execute();
$rs=$query->get_result();
 

 if($query->num_rows>0)
 {
 
   echo "<h5 style=color:#ff0004>Mobile Number Already Exist</h5>"; 
 
  
 }
 else
 {
  
 }
 exit();
}
$conn->close();

?>