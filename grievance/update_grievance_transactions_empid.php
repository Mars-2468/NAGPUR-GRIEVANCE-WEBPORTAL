<?php
//exit;
$conn= mysqli_connect("127.0.0.1", "municipa_csms", "ipDa6sS!cQuv", 'municipa_csms') or die(mysqli_connect_error());
//$sql="SELECT *  FROM `grievances_transactions` gt, grievances g WHERE gt.grievance_id=g.grievance_id and gt.emp_id = 0 limit 500";
$sql="SELECT * FROM `grievances_transactions` gt, grievances g WHERE gt.grievance_id=g.grievance_id and emp_id not in(select emp_id from emp_mst) and app_type_id='2' limit 500";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    
   echo "<br>";
    $sql="insert into emp_id_zero_records(
        grievance_id,
        transaction_id
        )values(
            '".$row['grievance_id']."',
            '".$row['transaction_id']."'
            )";
            if(mysqli_query($conn,$sql))
            {
               /* echo $sql="select emp_id from emp_mst where emp_dept='".$row['dept_id']."' and ulbid='".$row['ulbid']."' limit 1";
                $rs2 = mysqli_query($conn,$sql);
                $row2=mysqli_fetch_assoc($rs2);*/
                $sql="select emp_id,dept_id from emp_map where cs_id='".$row['cat3_id']."' and street_id='".$row['street_id']."' and ward_id='".$row['ward_id']."' and ulbid='".$row['ulbid']."' and cs_type_id='1'";
                $rs2 = mysqli_query($conn,$sql);
                $row2=mysqli_fetch_assoc($rs2);
                $emp_id=$row2['emp_id'];
                $dept_id=$row2['dept_id'];
                echo $sql="update grievances_transactions set emp_id='".$emp_id."' ,dept_id='".$dept_id."' where grievance_id='".$row['grievance_id']."' and transaction_id='".$row['transaction_id']."'";
                mysqli_query($conn,$sql);
                echo "<br>";
            }
}
?>