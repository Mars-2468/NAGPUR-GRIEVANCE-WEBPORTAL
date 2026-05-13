<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
	mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET names=utf8');
mysqli_query($conn,'SET character_set_client=utf8');
mysqli_query($conn,'SET character_set_connection=utf8');
mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET collation_connection=utf8_general_ci');

$langId=$_REQUEST['lang_id'];
	
	$sql="select c.dept_id,d.dept_desc,d.dept_marathi from dept_mst d,category3_mst c where d.dept_id=c.dept_id and c.ulbid='".$_REQUEST['ulbid']."' group by c.dept_id order by d.dept_desc";
	$rs=mysqli_query($conn,$sql);
	
	if($rs)
	{
	
		if(mysqli_num_rows($rs) > 0)
		{
			while($row = mysqli_fetch_assoc($rs))
			{
			    if($langId==1){
				$data[]=array('dept_id'=>$row['dept_id'],'dept_desc'=>$row['dept_desc']);
			    }else{
			        $data[]=array('dept_id'=>$row['dept_id'],'dept_desc'=>$row['dept_marathi']);
			    }
			}
		}
		else
		{
			$data[] = array('dept_id'=>'0','dept_desc'=>'No Data Available');
		}
	}
	else
	{
	$data[] = array('dept_id'=>'0','dept_desc'=>'Query not executed');
	}
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);
mysqli_close($conn);



?>