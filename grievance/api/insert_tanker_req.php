<?php
ini_set('display_errors', 0);
	require_once('../connection.php');
	$conn=getconnection();
	mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET names=utf8');
        mysqli_query($conn,'SET character_set_client=utf8');
        mysqli_query($conn,'SET character_set_connection=utf8');
        mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET collation_connection=utf8_general_ci');
        $langId=$_REQUEST['lang_id'];
	date_default_timezone_set('Asia/Calcutta');
	
	    require_once('../send_sms.php');
		require_once('../sms_conf.php');
	
	$sql="insert into tanker_req
   (ulbid,req_name,req_mobile,req_address,ward_id,street_id,req_date,req_time,ts,imei,tanker_type_id) values('".$_POST['ulbid']."','".mysqli_real_escape_string($conn,$_POST['req_name'])."','".$_POST['req_mobile']."','".mysqli_real_escape_string($conn,$_POST['req_address'])."',".$_POST['ward_id'].",".$_POST['street_id'].",'".date("Y-m-d",strtotime($_POST['req_date']))."','".$_POST['req_time']."',now(),'".$_POST['imei']."','".$_POST['tanker_type_id']."')";
	
	
	
	
	
	if(mysqli_query($conn,$sql))
	{
		$req_id=mysqli_insert_id($conn);
		$msg="Successfully Added Request With Ref ID : ".$req_id;
		$data = array('status_code'=>'200','status_desc'=>$msg);
		
		
		$sql="select ut.ulb_type_desc,u.ulbname from ulbmst u,ulb_type ut where u.ulb_type=ut.ulb_type_id and ulbid='".$_REQUEST['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rs);
		$ulbname=$row['ulbname'];
		$ulb_type=$row['ulb_type_desc'];
		
		
		
		
		if($_POST['ulbid']=='052')
		{
		    $mobile_string="";
		    if($_REQUEST['tanker_type_id'] == '1')
		    {
		        
		        
		         $sql ="select name,mobile from tanker_mst where tanker_type_id='1' group by mobile";
		        $rs = mysqli_query($conn,$sql);
		        while($row= mysqli_fetch_assoc($rs))
		        {
		            
		            $mobileno[$row['mobile']]['name']=$row['name'];
		        }
		        
		        
		        $sql ="select name,mobile from tanker_officer_map where tanker_type_id='1' group by mobile";
		        $rs = mysqli_query($conn,$sql);
		        while($row= mysqli_fetch_assoc($rs))
		        {
		            $mobileno[$row['mobile']]['name']=$row['name'];
		        }
		        
		        
		        foreach($mobileno as $mobileno=>$emp_name)
		        {
		            $mobile_string.=$mobileno."-".$emp_name.",";
		            $message=" Dear ".$emp_name['name']." A tanker Request is Received from ".$_POST['req_name']." Mobile No ".$_POST['req_mobile']." Ref No: ".$req_id;
		            send_sms($message,$mobileno);
		        }
		        
		    }
		    else if($_REQUEST['tanker_type_id'] == '2')
		    {
		        $sql ="select name,mobile from tanker_mst where tanker_type_id='2' group by mobile";
		        $rs = mysqli_query($conn,$sql);
		        while($row= mysqli_fetch_assoc($rs))
		        {
		            $mobileno[$row['mobile']]['name']=$row['name'];
		        }
		        
		        
		        $sql ="select name,mobile from tanker_officer_map where tanker_type_id='2' group by mobile";
		        $rs = mysqli_query($conn,$sql);
		        while($row= mysqli_fetch_assoc($rs))
		        {
		            $mobileno[$row['mobile']]['name']=$row['name'];
		        }
		        
		        foreach($mobileno as $mobileno=>$emp_name)
		        {
		            $mobile_string.=$mobileno."-".$emp_name.",";
		            $message=" Dear ".$emp_name['name']." A tanker Request is Received from ".$_POST['req_name']." Mobile No ".$_POST['req_mobile']." Ref No: ".$req_id;
		            send_sms($message,$mobileno);
		        }
		        
		    }
		    
		    
		}
		
		
		
		
		$sms1="Dear ".$_POST['req_name'].", Your Request for Water Tanker on  ".date("Y-m-d",strtotime($_POST['req_date']))." with Ref No : ".$req_id." received. Please contact ".$mobile_string." Forthur details.Regards - ".$ulbname." ".$ulb_type;
				
		$mobile1=$_POST['req_mobile'];
		
		send_sms($sms1,$mobile1);
		
		
	}
	else
		$data = array('status_code'=>'201','status_desc'=>'Please Try again');
		
	echo json_encode($data);
mysqli_close($conn);

?>