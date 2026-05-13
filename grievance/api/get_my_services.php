<?php
ini_set('display_errors', 0);
	require_once('../connection.php');
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');

	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	//$sql="select cs_id,comp_desc as cs_desc from category3_mst where ulbid='".$_REQUEST['ulbid']."'";
	
	$sql ="select app_type_id from app_type_id where grievance_id='".$_REQUEST['ref_no']."'";
	$rs = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($rs);
	$app_type_id=$row['app_type_id'];
	
	
	
	if($app_type_id=='2')
	{
	$sql="select cs_id,comp_desc as cs_desc from category3_mst";
	}
	else
	{
	    $sql="select cs_id,cs_desc from cs_mst";
	}
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['cs_desc'];
		}
		//$sql="select ward_id,ward_desc  from ward_mst where ulbid='".$_REQUEST['ulbid']."'";
		$sql="select ward_id,ward_desc  from ward_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
	
	//$sql ="select grievance_id  from grievances where grievance_id='".$_REQUEST['ref_no']."' and ulbid='".$_REQUEST['ulbid']."'";
	$sql ="select grievance_id  from grievances where grievance_id='".$_REQUEST['ref_no']."'";
	$rs = mysqli_query($conn,$sql);
	$nr = mysqli_num_rows($rs);
	if($nr > 0)
	{
	
	// $sql2 ="select grievance_id from grievances where grievance_id='".$_REQUEST['ref_no']."' and mobile='".$_REQUEST['mobile']."' and ulbid='".$_REQUEST['ulbid']."'";
	 $sql2 ="select grievance_id from grievances where grievance_id='".$_REQUEST['ref_no']."' and mobile='".$_REQUEST['mobile']."'";
	$rs2 = mysqli_query($conn,$sql2);
	$nr2 = mysqli_num_rows($rs2);
	if($nr2 > 0)
	{
	    
	    if($app_type_id=='2')
	    {
	
	  $sql3="select grievance_id,person_name,mobile,ward_id,DATE_ADD(date_regd, INTERVAL c.cutt_of_time+holidays_added  DAY)  as cutt_of_time,address,ward_id,street_id,mobile,comp_subject,g.comp_desc,grievance_status_desc,date_regd,cat3_id,app_type_id from grievances g,grievance_status_mst gsm,category3_mst c where g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.grievance_id ='".$_REQUEST['ref_no']."' and mobile='".$_REQUEST['mobile']."' and g.grievance_status_id=gsm.grievance_status_id order by grievance_id desc";
	    }
	    else
	    {
	        //  echo $sql3="select grievance_id,person_name,mobile,ward_id,DATE_ADD(date_regd, INTERVAL c.cutt_off_time DAY)  as cutt_of_time,address,ward_id,street_id,mobile,comp_subject,g.comp_desc,grievance_status_desc,date_regd,cat3_id,app_type_id from grievances g,grievance_status_mst gsm,comp_cutofdays_map c  where g.cat3_id=c.cs_id and g.grievance_status_id=gsm.grievance_status_id and g.grievance_id ='".$_REQUEST['ref_no']."' and mobile='".$_REQUEST['mobile']."' and g.grievance_status_id=gsm.grievance_status_id order by grievance_id desc";
			$sql3 = "select grievance_id,person_name,mobile,ward_id,address,ward_id,street_id,mobile,comp_subject,g.comp_desc,grievance_status_desc,date_regd,cat3_id,app_type_id
			from grievances g,grievance_status_mst gsm where
			g.grievance_status_id=gsm.grievance_status_id and g.grievance_id ='".$_REQUEST['ref_no']."' and mobile='".$_REQUEST['mobile']."' and
			g.grievance_status_id=gsm.grievance_status_id order by grievance_id desc";
	    }
	//echo $sql3;
	
	if($rs3=mysqli_query($conn,$sql3))
	{
		$i=1;
		if(mysqli_num_rows($rs3)>0)
		{
			while($row = mysqli_fetch_assoc($rs3))
			{
				
				
				$data[]=array('status_code'=>'200','error_desc'=>'Success','sno'=>$i,'grievance_id'=>$row['grievance_id'],'person_name'=>$row['person_name'],'mobile'=>$row['mobile'],'ward_id'=>$ward_list[$row['ward_id']],'cutt_of_time'=>date('d-m-Y ',strtotime($row['cutt_of_time'])),'address'=>$row['address'],'comp_desc'=>$row['comp_desc'],'date_regd'=>date('d-m-Y H:i:s',strtotime($row['date_regd'])),'grievance_status_desc'=>$row['grievance_status_desc'],'subject'=>$cs_list[$row['cat3_id']]);
				$i++;
			}
		}
		else
		{
			$data[0] = array('status_code'=>'1','error_desc'=>'Invalid Reference no or mobile number');
		}
	}
	else
	{
		$data[0] = array('status_code'=>'1','error_desc'=>'Query not executed');
	}
}
else
{
$data[0] = array('status_code'=>'201','error_desc'=>'Invalid Mobile no');
}
		
}
else
{
$data[0] = array('status_code'=>'202','error_desc'=>'Invalid Reference no');
}
		
		
	$indexedOnly = array();
	
	foreach ($data as $row) {
	    $indexedOnly[] = array_values($row);
	}
	
	echo json_encode($data);
	
	mysqli_close($conn);
		

?>