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
	
	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	$sql="select req_id,req_address,req_address_marathi,req_date,req_time,amount,IFNULL(status_desc,''),delivery_date,delivery_time from tanker_req left join status_mst on tanker_req.status=status_mst.status_id where imei like '".$_REQUEST['imei']."'  order by req_date desc";
	//echo $sql;
	//$fp=fopen('test.txt','a');
	//fwrite($fp,$sql);
	//fclose($fp);
	
	if($rs=mysqli_query($conn,$sql))
	{
		
		if(mysqli_num_rows($rs)>0)
		{
		$i=1;
		
		while($row = mysqli_fetch_assoc($rs))
		{
		    if(is_null($row['status_desc']))
		    {
		        $row['status_desc']="";
		    }
		    if($langId==1){
			$data[]=array('sno'=>$i,'req_id'=>$row['req_id'],'req_address'=>$row['req_address'],'req_date'=>$row['req_date'],'req_time'=>$row['req_time'],'amount'=>$row['amount'],'status_desc'=>$row['status_desc'],'delivery_date'=>$row['delivery_date'],'delivery_time'=>$row['delivery_time']);
		    }else{
		     $data[]=array('sno'=>$i,'req_id'=>$row['req_id'],'req_address'=>$row['req_address_marathi'],'req_date'=>$row['req_date'],'req_time'=>$row['req_time'],'amount'=>$row['amount'],'status_desc'=>$row['status_desc'],'delivery_date'=>$row['delivery_date'],'delivery_time'=>$row['delivery_time']);   
		    }
			$i++;
		}
		}
		else
			$data[0] = array('req_id'=>'0','req_address'=>'N/A','req_date'=>'N/A','req_time'=>'N/A','amount'=>'N/A');
	}	
	else
		$data[0] = array('req_id'=>'0','req_address'=>'N/A','req_date'=>'N/A','req_time'=>'N/A','amount'=>'N/A');
		
		
	$indexedOnly = array();
	
	foreach ($data as $row) {
	    $indexedOnly[] = array_values($row);
	}
	
	echo json_encode($data);
	
	mysqli_close($conn);	

?>