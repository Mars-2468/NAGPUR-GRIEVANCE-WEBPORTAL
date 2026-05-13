<?php
require "config.php";
require_once('connection.php');
$conn=getconnection();		
$str="0:::Select Employee";

$sql="SELECT emp_id,emp_name FROM emp_mst WHERE emp_desg=".$_GET['desg_id']."  and delete_status='0' and emp_status='0' ORDER BY emp_name";
if($rs=mysqli_query($conn,$sql))
{
	while($row = mysqli_fetch_assoc($rs))
		$str.="___".$row['emp_id'].":::".$row['emp_name'];
}
else
	printf("Errormessage: %s\n", mysqli_error($conn));
	
	
	$sql="SELECT emp_id,emp_name FROM emp_mst_od WHERE emp_desg=".$_GET['desg_id']." and delete_status='0' ORDER BY emp_name";
if($rs=mysqli_query($conn,$sql))
{
	while($row = mysqli_fetch_assoc($rs))
		$str.="___".$row['emp_id'].":::".$row['emp_name'];
}

$sql="SELECT e.emp_id,emp_name FROM emp_mst e,emp_desg_map edm,desg_mst d WHERE edm.delete_status = '0' and e.emp_id=edm.emp_id and d.desg_id= edm.desg_id and edm.desg_id='".$_GET['desg_id']."' and e.delete_status='0' and e.emp_status='0' ORDER BY emp_name";
if($rs=mysqli_query($conn,$sql))
{
	while($row = mysqli_fetch_assoc($rs))
		$str.="___".$row['emp_id'].":::".$row['emp_name'];
}
$sql="SELECT e.emp_id,emp_name FROM emp_mst_od e,emp_desg_map edm,desg_mst d WHERE edm.delete_status = '0' and e.emp_id=edm.emp_id and d.desg_id= edm.desg_id and edm.desg_id='".$_GET['desg_id']."' and e.delete_status='0' and e.emp_status='0' ORDER BY emp_name";
if($rs=mysqli_query($conn,$sql))
{
	while($row = mysqli_fetch_assoc($rs))
		$str.="___".$row['emp_id'].":::".$row['emp_name'];
}
	
	
	
	
	
	/*$sql="SELECT e.emp_id,e.emp_name FROM emp_mst e,emp_desg_map edm WHERE e.emp_id=edm.emp_id and edm.desg_id=".$_GET['desg_id']." and ulbid='".$_SESSION['ulbid']."' and delete_status='0' and emp_status='0' group by e.emp_id ORDER BY e.emp_name";
	if($rs=mysqli_query($conn,$sql))
{
	while($row = mysqli_fetch_assoc($rs))
		$str.="___".$row['emp_id'].":::".$row['emp_name'];
}

 $sql="SELECT e.emp_id,e.emp_name FROM emp_mst_od e,emp_desg_map edm WHERE e.emp_id=edm.emp_id and edm.desg_id=".$_GET['desg_id']." and ulbid='".$_SESSION['ulbid']."' and delete_status='0' group by e.emp_id ORDER BY e.emp_name";
	if($rs=mysqli_query($conn,$sql))
{
	while($row = mysqli_fetch_assoc($rs))
		$str.="___".$row['emp_id'].":::".$row['emp_name'];
}
	*/
echo $str;
mysqli_close($conn);
?>