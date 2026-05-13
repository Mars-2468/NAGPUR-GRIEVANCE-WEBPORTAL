<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	$sql="select app_banner FROM users WHERE  ulbid='".$_REQUEST['ulbid']."' group by ulbid";
	$fp=fopen('test.txt','a');
	fwrite($fp,$sql);
	fclose($fp);
	
	$rs = mysqli_query($conn,$sql);
	 
	if($rs)
	{
		if(mysqli_num_rows($rs) > 0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
				$data[]=array('app_banner'=>$row['app_banner']);
			}
		}
		else
		{
		$data[0] = array('status'=>'201','error_message'=>'Banner not available');
		}
	}
	else
		$data[0] = array('status'=>'201','error_message'=>'Query error');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);




?>