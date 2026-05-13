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
	/*$data['docs']=array();
	$sql2 ="SELECT doc_desc,dcm.doc_id FROM doc_mst dm, cs_doc_map cdm WHERE cdm.doc_id = dm.doc_id AND cdm.cs_id =  '1' AND dm.ulbid =  '082'";
			$rs2=mysqli_query($conn,$sql2);
			while($row2= mysqli_fetch_assoc($rs2))
			{
			
			$docs['doc_id']=$row['doc_desc'];
			array_push($data['docs'], $docs);
			}*/
			
			$sql ="select * from service_placed_mst";
			$rs = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			$mode_list[$row['sp_id']]=$row['sp_desc'];
			}
	
	 $sql="select * from category3_mst where ulbid='".$_REQUEST['ulbid']."' and cs_type_id='2' and dept_id='".$_REQUEST['dept_id']."' and cs_id='".$_REQUEST['cs_id']."' order by comp_desc";
	//echo $sql;
	$fp=fopen('test.txt','a');
	fwrite($fp,$sql);
	fclose($fp);
	
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
			$i=1;
			while($row = mysqli_fetch_assoc($rs))
			{
				$data[]=array('sno'=>$i,'cutt_of_time'=>$row['cutt_of_time'],'app_fee'=>$row['app_fee'],'fine_per_day'=>$row['fine_per_day'],'fin_impl'=>$row['fin_impl'],'comp_desc'=>$row['comp_desc'],'mod'=>$mode_list[$row['sp_id']]);
				$i++;
			}
			
			
		}
		else
			$data[0] = array('status_code'=>201,'status_desc'=>'Data Not Available');
	}
	else
		$data[0] = array('status_code'=>201,'status_desc'=>'Query Not executed');
		
		
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);
mysqli_close($conn);



?>