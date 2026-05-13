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

	$nr =0;
	 $sql="select emp_id,emp_name,desg_desc,emp_name_marathi,emp_mobile FROM emp_mst,desg_mst WHERE emp_mst.emp_desg=desg_mst.desg_id  and delete_status='0' and emp_desg='".$_REQUEST['design_id']."' and emp_dept=".$_REQUEST['dept_id']." and emp_mst.ulbid='".$_REQUEST['ulbid']."' ORDER BY sort_order,emp_desg,emp_name";
	
	
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
		    $nr=1;
			$i=1;
			while($row = mysqli_fetch_assoc($rs))
			{
				
				if($langId==1){
				    $data[]=array('sno'=>$i,'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name'],'desg_desc'=>$row['desg_desc'],'emp_mobile'=>$row['emp_mobile']);
				}else{
				    $data[]=array('sno'=>$i,'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name_marathi'],'desg_desc'=>$row['desg_desc'],'emp_mobile'=>$row['emp_mobile']);
				}
				$i++;
			}
		}
		
	}
	
	 $sql="select emp_id,emp_name,emp_name_marathi,desg_desc,emp_mobile FROM emp_mst_od,desg_mst WHERE emp_mst_od.emp_desg=desg_mst.desg_id  and delete_status='0' and emp_dept=".$_REQUEST['dept_id']." and emp_mst_od.ulbid='".$_REQUEST['ulbid']."' ORDER BY sort_order,emp_desg,emp_name";
	
	
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
		    $nr=1;
			$i=1;
			while($row = mysqli_fetch_assoc($rs))
			{
			    if($langId==1){
				$data[]=array('sno'=>$i,'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name'],'desg_desc'=>$row['desg_desc'],'emp_mobile'=>$row['emp_mobile']);
			    }else{
			   $data[]=array('sno'=>$i,'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name_marathi'],'desg_desc'=>$row['desg_desc'],'emp_mobile'=>$row['emp_mobile']);     
			    }
				$i++;
			}
		}
		
	}
	
	
	if($nr==0)
	{
		$data[0] = array('sno'=>0,'emp_id'=>'0','emp_name'=>'No data','desg_desc'=>'No data','emp_mobile'=>'No data');
	}	
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);
mysqli_close($conn);



?>