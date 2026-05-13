<?php
require_once('connection.php');
error_reporting(0);
$conn=getconnection();
$sql ="select * from emp_mst";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    $p = sha1(md5('Amc@123'));
    echo $sql ="insert into users(
	user_id,
	emp_id,
	user_pwd,
	user_name,
	user_mobile,
	user_email,
	user_type,
	ulbid
	)values(
	'".$row['emp_mobile']."',
	'".$row['emp_id']."',
	PASSWORD('".$p."'),
	'".$row['emp_name']."',
	'".$row['emp_mobile']."',
	'',
	'E',
	'250'
	) ON DUPLICATE KEY UPDATE user_pwd=PASSWORD('".$p."')";
	echo "<br>"; 
    mysqli_query($conn,$sql);
	
	$services_array = array('change_pwd','manage_comp');
	foreach($services_array as $value){
	$sql ="insert into users_services(user_id,service_id,status)values('".$row['emp_mobile']."','".$value."','1')";
	mysqli_query($conn,$sql);
	}
    
}

//echo sha1(md5('boduppal123'));
?>