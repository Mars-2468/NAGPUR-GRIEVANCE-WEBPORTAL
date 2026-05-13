<?php

	require_once('connection.php');
	$conn=getconnection();
	exit;
	$sql ="SELECT * FROM emp_mst";
	$rs = mysqli_query($conn,$sql);
	$services = array('manage_comp');
	while($row = mysqli_fetch_assoc($rs))
	{
	    
	    echo $sql ="insert into users_services (user_id,service_id,status) values('".$row['emp_code']."','manage_comp','1')";
		echo "<br>";
	    
	    mysqli_query($conn,$sql);
	    
	}
	
	//$sql ="SELECT * FROM `services` WHERE `service_id` LIKE '%merge%'";
	//$serviceList = array('mergeDepartments','mergeDesignations');
/*$sql ="SELECT * FROM `users_services` WHERE `user_id` LIKE 'Adilabad'";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    
	    $sql ="insert into users_services (user_id,service_id,status) values('Kothur','".$row['service_id']."','1')";
	    
	    mysqli_query($conn,$sql);
	    
	}*/
	// closing under progress complaints with in sla
	
	/*$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` = 2 AND `ulbid` LIKE '207' AND `sla_status` LIKE '1' limit 0,1528";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    echo $sql ="update grievances set grievance_status_id='9', sla_status=1,manual_complete_status='1' where grievance_id='".$row['grievance_id']."'";
	    mysqli_query($conn,$sql);
	}*/
	// changign boyond sla completed complaints to with in sla completed manual_complete_status=2
	
/*	$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` IN (9,3) AND `ulbid` LIKE '207' AND `sla_status` LIKE '2'  limit 0,14";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    echo $sql ="update grievances set grievance_status_id='".$row['grievance_status_id']."', sla_status=1,manual_complete_status='2' where grievance_id='".$row['grievance_id']."'";
	    echo "<br>";
	    mysqli_query($conn,$sql);
	}*/
	
	// rollback manually closed complaints to under progress with in sla
	
	/*$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `manual_complete_status` = 1 AND `ulbid` LIKE '207'";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    echo $sql ="update grievances set grievance_status_id='2',manual_complete_status='3' where grievance_id='".$row['grievance_id']."'";
	    mysqli_query($conn,$sql);
	}*/
	
	// Re opend completed changed to completed with in sla  manual_complete_status=5
	
	/*$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` = 12 AND `ulbid` LIKE '207' limit 0,20";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    $sql ="update grievances set grievance_status_id='9',manual_complete_status='5',sla_status=1 where grievance_id='".$row['grievance_id']."'";
	    if(mysqli_query($conn,$sql))
	    {
	        $sql2 ="update grievances_transactions set disposal_status='9' where grievance_id='".$row['grievance_id']."' and disposal_status='12'";
	        mysqli_query($conn,$sql2);
	    }
	}*/
	
	// change financial implications to completed with in sla manual_complete_status 6
	
	/*	$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` IN (6) AND `ulbid` LIKE '207' limit 0,196";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    echo $sql ="update grievances set grievance_status_id='9', sla_status=1,manual_complete_status='2' where grievance_id='".$row['grievance_id']."'";
	    echo "<br>";
	    mysqli_query($conn,$sql);
	    /*if(mysqli_query($conn,$sql))
	    {
	        $sql2 ="update grievances_transactions set disposal_status='9' where grievance_id='".$row['grievance_id']."' and disposal_status='6'";
	        mysqli_query($conn,$sql2);
	    }*
	}*/
	
/*	$sql ="select * from cs_mst where cs_id in(127,128)";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    $sql ="select ulbid from ulbmst";
	    $rs2= mysqli_query($conn,$sql);
	    while($row2 = mysqli_fetch_assoc($rs2))
	    {
	        echo $sql ="insert into complaint_ulbmap(cs_id,cat_id,flag,ulbid,cs_type_id) values('".$row['cs_id']."','".$row['cat_id']."','1','".$row2['ulbid']."','1')";
	        mysqli_query($conn,$sql);
	        echo "<br>";
	    }
	}*/
	
	
	
	
?>