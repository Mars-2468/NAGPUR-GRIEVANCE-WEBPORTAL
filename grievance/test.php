<?php
require_once('connection.php');
$conn=getconnection();

$sql ="SELECT DISTINCT(emp_code) FROM emp_mst";

$rs = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($rs)){
	
	
	$emp_code = $row['emp_code'];


$service_ids = array('employee_escalated_complaints');


	foreach($service_ids as $key2=>$service_id){
	
	echo $sql ="INSERT INTO `users_services`(`user_id`, `service_id`, `status`) VALUES ('".$emp_code."','".$service_id."','1');";
	echo "<br>";
	}

}


/*$emp_codes = array(6039,
3955,
3518,
21937,
5783,
7997,
6862,
6038,
5856,
6009,
18325,
14127,
5933,
5834,
15188,
5835,
5544,
22150,
10785,
5855,
9057,
15190,
7002,
4315,
3583,
5527,
15180,
5546,
20796,
22028,
2435

);

$service_ids = array('rep_comp_dept_abs_comp','ward_wise_abstract','change_pwd');

foreach($emp_codes as $key=>$emp_code){
	foreach($service_ids as $key2=>$service_id){
	
	echo $sql ="INSERT INTO `users_services`(`user_id`, `service_id`, `status`) VALUES ('".$emp_code."','".$service_id."','1');";
	echo "<br>";
	}
}




/*$sql ="SELECT * FROM `cs_mst` c, comp_cutofdays_map cc where c.cs_id=cc.cs_id";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
	$sql ="INSERT INTO `standard_services`(
	`section_id`, 
	`cs_desc`, 
	`cs_id`, 
	`cutt_off_time`, 
	`fine_per_day`, 
	`telugu_description`, 
	`is_external_service`
	) VALUES (
	'".$row['cat_id']."',
	'".$row['cs_desc']."',
	'".$row['cs_id']."',
	'".$row['cs_id']."',
	'[value-5]',
	'[value-6]',
	'[value-7]'
	)";
}*/

/*$sql ="SELECT * FROM `grievances` WHERE `grievance_status_id` = 1";

$rs = mysqli_query($conn,$sql);
// print_r($rs->fetch_assoc());
// exit();
while($row = mysqli_fetch_assoc($rs))
{
    $emp="SELECT * FROM `emp_map` WHERE `cs_id` = '".$row['cat3_id']."' AND `cs_type_id` LIKE '1' AND `street_id` = '".$row['street_id']."' AND `ward_id` = '".$row['ward_id']."'";
    $empdata = mysqli_query($conn,$emp);
    $emprow = mysqli_fetch_assoc($empdata);
    
    echo $sql1 ="INSERT INTO `grievances_transactions`(
        `grievance_id`,
        `transaction_id`, 
        `emp_id`, 
        `dept_id`, 
        `desg_id`, 
        `alloted_date`, 
        `disposed_date`, 
        `disposal_status`,
        `disposal_remarks`, 
        `update_status`,
        `updated_by`, 
        `origin_id`
        ) VALUES (
            '".$row['grievance_id']."',
            '1',
            '".$emprow['emp_id']."',
            '".$emprow['dept_id']."',
            '".$emprow['desg_id']."',
            '".$row['date_regd']."',
            '0000-00-00 00:00:00',
            '2',
            '',
            '',
            'system1',
            '1'
            )";
            echo '<br>';
            if(mysqli_query($conn,$sql1)){
                echo $update="update `grievances` set `grievance_status_id` = 2 where grievance_id='".$row['grievance_id']."'";
                mysqli_query($conn,$update);

            }
}



/*$sql ="select * from cs_mst c, category_mst cm where c.cat_id=cm.cat_id";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    echo $sql ="insert into complaint_ulbmap(cs_id,cat_id,flag,ulbid,cs_type_id)values('".$row['cs_id']."','".$row['cat_id']."','1','".$row['ulbid']."','1')";
    echo "<br>";
    mysqli_query($conn,$sql);
}*/

/*$sql ="select * from level_disposabledays_map";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
	$sql ="select * from cs_mst where cs_desc like '%".$row['cs_id']."%'";
	$rs2 = mysqli_query($conn,$sql);
	$row2 = mysqli_fetch_assoc($rs2);
	$cs_id = $row2['cs_id'];
	$sql ="update level_disposabledays_map set cs_id='".$cs_id."' where cs_id = '".$row['cs_id']."'";
	mysqli_query($conn,$sql);
	
}*/

/*$sql ="SELECT * FROM `grievances` WHERE `grievance_status_id` = 1 ORDER BY `grievance_id` DESC";

$rs = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($rs))
{
	$sql ="SELECT * FROM `emp_map` WHERE `cs_id` = '".$row['cat3_id']."'";
	$rs2 = mysqli_query($conn,$sql);
	$emp_id1 = "232";
	$sql ="update grievances set grievance_status_id='9',sla_status='1' where grievance_id = '".$row['grievance_id']."'";
	
	if(mysqli_query($conn,$sql))
	{
		echo $sql ="insert into grievances_transactions(
		
		grievance_id,
		transaction_id,
		emp_id,
		dept_id,
		desg_id,
		alloted_date,
		disposed_date,
		disposal_status,
		disposal_remarks,
		updated_by
		)values(
		'".$row['grievance_id']."',
		'1',
		'".$emp_id1."',
		'2',
		'56',
		'".$row['date_regd']."',
		'".date('Y-m-d H:i:s')."',
		'9',
		'Updated by system',
		'Updated by system'
		
		)";
	}
	mysqli_query($conn,$sql);
}*/




?>