<?php
require "config.php";
	ini_set('display_errors',0);

	require_once('Smarty.class.php');
	$tpl=new Smarty();

	
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		$sql ="SELECT * FROM `grievances` WHERE `app_type_id` LIKE '1' AND `grievance_status_id` = 2 AND `ulbid` LIKE '207' AND `sla_status` LIKE '2' and date_regd <= '2021-07-31' limit 50";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    echo $sql ="select * from grievances_transactions where grievance_id='".$row['grievance_id']."' and disposal_status ='2'";
		    $rs2 = mysqli_query($conn,$sql);
		    $aaa=mysqli_fetch_assoc($rs2);
		    echo $alloteddate = $aaa['alloted_date'];
		    echo "<br>";
		    echo $disposaldate = date('Y-m-d H:i:s', strtotime($alloteddate . ' +1 day'));;
		    echo $sql="update grievances_transactions set disposal_status=9,disposed_date='".$disposaldate."' where grievance_id='".$row['grievance_id']."' and transaction_id='".$aaa['transaction_id']."' and disposal_status='2'";
		    if(mysqli_query($conn,$sql))
		    {
		        $sql="update grievances set grievance_status_id=9, sla_status=1,boduppal_manual_update='1' where grievance_id='".$row['grievance_id']."'";
		        mysqli_query($conn,$sql);
		    }
		}
	