<?php
	
$conn2 = mysqli_connect('localhost','amc_root','Redhat@123','amc_db_2k21');
require_once('../connection.php');
$conn=getconnection();
$sql ="select * from flag_certifications";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{

echo $sql ="INSERT INTO `tiranga_details`( 
`name`, 
`phone_no`, 
`file_name`, 
`file_path`, 
`address`, 
`date_time`, 
`certificate_path`, 
`status`,
origin,
origin_auto_id
) VALUES (

'".$row['person_name']."', 
'".$row['mobile']."',
'".$row['file_url']."',
'".$row['file_url']."',
'".$row['address']."',
'".$row['ts']."',
'', 
'1',
'2',
'".$row['id']."'
)";

echo $sql;
mysqli_query($conn2,$sql);
}



//mysqli_query($conn2,$sql);
?>