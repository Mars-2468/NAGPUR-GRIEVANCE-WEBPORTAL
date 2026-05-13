<?php
ini_set('display_errors',1);
require_once('connection.php');
include('prepare_connection.php');
		$conn=getconnection();
		
if(!empty($_POST["emp_id"])) {
 $keyword=htmlspecialchars(strip_tags($_POST["emp_id"]));
 $keyword1=htmlspecialchars(strip_tags($_POST["emp_id1"]));
 $keyword3=htmlspecialchars(strip_tags($_POST["emp_id3"]));

$query ="UPDATE emp_map SET emp_id=?, emp_id2 =?, emp_id3 =?,dept_id=?  
WHERE cs_id =? and ward_id =? and street_id=? and cs_type_id =?";
$sql=$conn->prepare($query);

$dept_id=htmlspecialchars(strip_tags($_POST['dept_id']));
$cs_id=htmlspecialchars(strip_tags($_POST['cs_id']));
$ward_id=htmlspecialchars(strip_tags($_POST['ward_id']));
$street_id=htmlspecialchars(strip_tags($_POST['street_id']));
$cs_type_id=1;
$sql->bind_param("sssiiiii",$keyword,$keyword1,$keyword3,$dept_id,$cs_id,$ward_id,$street_id,$cs_type_id);
if($sql->execute())
{
   $sql="select emp_id,emp_name,emp_mobile from emp_mst where emp_id=?";
   $query=$conn->prepare($sql);
  
   $query->bind_param("s",$keyword);
   $query->execute();
   $rs1=$query->get_result();
   
	 while($row1 = $rs1->fetch_array())
	 {
	 	$dropdown = $row1['emp_name']."-".$row1['emp_mobile'];
	 } 
}
else
$dropdown= '0';

echo $dropdown;
}

  $conn->close();
?>