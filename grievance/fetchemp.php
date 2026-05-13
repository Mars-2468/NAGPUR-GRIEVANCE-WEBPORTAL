<?php
require "config.php";
require_once('connection.php');
include('prepare_connection.php');
		$conn=getconnection();
		
if(!empty($_POST["emp_id"])) {
 $keyword=$_POST["emp_id"];
//$customer_name=$_POST["customer_name"];

		
        $sql ="select desg_id,desg_desc from desg_mst where ulbid=?";
		$query=$conn->prepare($sql);
		$query->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$query->execute();
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $desg_list[$row['desg_id']]=$row['desg_desc'];
		}		
		



$sql1 ="select * from dept_mst where ulbid=? order by dept_id";
$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
$query=$conn->prepare($sql1);
$query->bind_param("s",$ulbid);
$query->execute();
$rs1=$query->get_result();



 $street_desc = "'".$_POST["street_desc"]."'";
	$ward_desc = "'".$_POST["ward_desc"]."'";
	if($_REQUEST['cs_type_id']==""){$_REQUEST['cs_type_id']=2;}

 $dropdown='<td>'.$_POST["ward_desc"].'</td><td>'.$_POST["street_desc"].'</td><td><select id="dept_type" name="dept_type" class="form-control myinput_size" onchange="editemp('.$_POST["emp_id"].','.$_POST["street_id"].','.$street_desc.','.$_POST["ward_id"].','.$ward_desc.','.$_POST["cs_id"].','.this.','.$_REQUEST['cs_type_id'].')">
 	<option value="0">---select---</option>';
while($row1=$rs1->fetch_assoc())
			{
			
			if($row1['dept_id'] == $_POST['dept_id'])
			{
		$dropdown.="<option value='".$row1['dept_id']."' selected = '".$_POST['dept_id']."'>".$row1['dept_desc']."</option>";
		}
		else
		{
			$dropdown.="<option value='".$row1['dept_id']."'>".$row1['dept_desc']."</option>";
		}
		
		  } 
$dropdown.='</select></td>';



$sql1 ="select emp_id,emp_name,emp_mobile,emp_desg from emp_mst where emp_dept=? and ulbid=?";
$emp_dept=$_POST["dept_id"];
$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
$query=$conn->prepare($sql1);
$query->bind_param("is",$emp_dept,$ulbid);
$query->execute();
$rs1=$query->get_result();

		$dropdown.='<td><select id="emp_type" name="emp_type" class="form-control myinput_size">
 	<option value="0">---select---</option>';
while($row1=$rs1->fetch_assoc())
			{
			
		$dropdown.="<option value='".$row1['emp_id']."'>".$row1['emp_name']."(".$desg_list[$row1['emp_desg']].")"."-".$row1['emp_mobile']."</option>";
		
		  } 
		  
		  


$sql1 ="select e.emp_id,emp_name,emp_mobile,emp_desg from emp_mst e,emp_desg_map em where em.emp_id=e.emp_id 
and em.dept_id=? and ulbid=? group by e.emp_id";
$dept_id=$_POST["dept_id"];
$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
$query=$conn->prepare($sql1);
$query->bind_param("is",$dept_id,$ulbid);
$query->execute();
$rs1=$query->get_result();
	while($row1=$rs1->fetch_assoc())
			{
			
		$dropdown.="<option value='".$row1['emp_id']."'>".$row1['emp_name']."(".$desg_list[$row1['emp_desg']].")"."-".$row1['emp_mobile']."</option>";
		
		  }
		  
		  
		  
$dropdown.='</select></td>';


$sql1 = "select emp_id,emp_name,emp_mobile,emp_desg from emp_mst where emp_dept=? and ulbid=?";
$emp_dept=$_POST["dept_id"];
$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
$query=$conn->prepare($sql1);
$query->bind_param("is",$emp_dept,$ulbid);
$query->execute();
$rs1=$query->get_result();



$dropdown.='<td><select id="empr_type" name="empr_type" class="form-control myinput_size">
 	<option value="0">---select---</option>';
while($row1=$rs1->fetch_assoc())
			{
			
		$dropdown.="<option value='".$row1['emp_id']."'>".$row1['emp_name']."(".$desg_list[$row1['emp_desg']].")"."-".$row1['emp_mobile']."</option>";
		
		  } 
		  

$sql1 ="select e.emp_id,emp_name,emp_mobile,emp_desg from emp_mst e,emp_desg_map em where em.emp_id=e.emp_id and 
em.dept_id=? and ulbid=? group by e.emp_id";
$dept_id=$_POST["dept_id"];
$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
$query=$conn->prepare($sql1);
$query->bind_param("is",$dept_id,$ulbid);
$query->execute();
$rs1=$query->get_result();

	while($row1=$rs1->fetch_assoc())
			{
			
		$dropdown.="<option value='".$row1['emp_id']."'>".$row1['emp_name']."(".$desg_list[$row1['emp_desg']].")"."-".$row1['emp_mobile']."</option>";
		
		  }
$dropdown.='</select></td>';

if($_REQUEST['cs_type_id']==1)
{



$sql1 ="select emp_id,emp_name,emp_mobile,emp_desg from emp_mst where emp_dept=? and ulbid=?";
$emp_dept=$_POST["dept_id"];
$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
$query=$conn->prepare($sql1);
$query->bind_param("is",$emp_dept,$ulbid);
$query->execute();
$rs1=$query->get_result();

$dropdown.='<td><select id="emp3_type" name="emp3_type" class="form-control myinput_size">
 	<option value="0">---select---</option>';
while($row1=$rs1->fetch_assoc())
			{
			
		$dropdown.="<option value='".$row1['emp_id']."'>".$row1['emp_name']."(".$desg_list[$row1['emp_desg']].")"."-".$row1['emp_mobile']."</option>";
		
		  } 
		  
		  
		
$sql1 ="select e.emp_id,emp_name,emp_mobile,emp_desg from emp_mst e,emp_desg_map em where em.emp_id=e.emp_id 
		   and em.dept_id=? and ulbid=? group by e.emp_id";
$dept_id=$_POST["dept_id"];
$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
$query=$conn->prepare($sql1);
$query->bind_param("is",$dept_id,$ulbid);
$query->execute();
$rs1=$query->get_result();


	while($row1=$rs1->fetch_assoc())
			{
			
		$dropdown.="<option value='".$row1['emp_id']."'>".$row1['emp_name']."(".$desg_list[$row1['emp_desg']].")"."-".$row1['emp_mobile']."</option>";
		
		  }
$dropdown.='</select></td>';

}




$dropdown.='<td> <button type="submit" name="update" onclick="updaterecord('.$_POST['street_id'].','.$_POST["ward_id"].','.$_POST["cs_id"].')">Update</button><button type="submit" name="clear" onclick="clearpage()">Cancel</button> </td>';

echo $dropdown;
} 

$conn->close();

?>