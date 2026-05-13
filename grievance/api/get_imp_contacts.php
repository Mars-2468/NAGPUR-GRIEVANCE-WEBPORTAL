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
	
	$apk_version = $_REQUEST['apk_version'];
	require_once('check_version.php');
	
	 $sql="select id,name,designation,mobile FROM imp_contacts WHERE dept_id=".$_REQUEST['dept_id']." and ulbid='".$_REQUEST['ulbid']."' ORDER BY sort_order,id";
	//echo $sql;
	//$fp=fopen('test.txt','a');
	//fwrite($fp,$sql);
//	fclose($fp);
	
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
			$i=1;
			while($row = mysqli_fetch_assoc($rs))
			{
			    if($langId==1){
				$data[]=array('sno'=>$i,'emp_id'=>$row['id'],'emp_name'=>$row['name'],'desg_desc'=>$row['designation'],'emp_mobile'=>$row['mobile']);
			    }else{
			     $data[]=array('sno'=>$i,'emp_id'=>$row['id'],'emp_name'=>$row['name_marathi'],'desg_desc'=>$row['designation_marathi'],'emp_mobile'=>$row['mobile']);   
			    }
				$i++;
			}
		}
		else
			$data[0] = array('emp_id'=>'0','emp_name'=>'-','desg_desc'=>'-','emp_mobile'=>'-');
	}
	else
		$data[0] = array('emp_id'=>'0','emp_name'=>'-','desg_desc'=>'-','emp_mobile'=>'-');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>