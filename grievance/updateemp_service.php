<?php
ini_set('display_errors',1);
require_once('connection.php');
$conn=getconnection();
		
if(!empty($_POST["emp_id"])) {
   
 $keyword=$_POST["emp_id"];
 $keyword1=$_POST["emp_id1"];

          

          $sql=$conn->prepare("UPDATE `emp_map` SET `emp_id`=?, emp_id2 =?, dept_id=? WHERE cs_id=? and ward_id =? and street_id=? and cs_type_id =?");
          $cs_type_id =2;
          $dept_id=$_POST['dept_id'];
          $cs_id=$_POST['cs_id'];
          $ward_id=$_POST['ward_id'];
          $street_id=$_POST['street_id'];
	      $sql->bind_param("ssiiiii",htmlspecialchars(strip_tags($keyword)),htmlspecialchars(strip_tags($keyword1)),htmlspecialchars(strip_tags($dept_id)),htmlspecialchars(strip_tags($cs_id)),htmlspecialchars(strip_tags($ward_id)),htmlspecialchars(strip_tags($street_id)),htmlspecialchars(strip_tags($cs_type_id)));
          $sql->execute();
	      $rs=$sql->get_result();
    if($rs)
    {
    	
    	  $sql=$conn->prepare("select emp_id,emp_name,emp_mobile from emp_mst where emp_id=?");
	      $sql->bind_param("s",htmlspecialchars(strip_tags($keyword)));
          $sql->execute();
	      $rs1=$sql->get_result();
    
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