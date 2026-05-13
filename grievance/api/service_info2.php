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
	
	$data['docs']=array();
	  $sql2 ="SELECT doc_desc,cdm.doc_id FROM doc_mst dm, cs_doc_map cdm WHERE cdm.doc_id = dm.doc_id AND cdm.cs_id =  '".$_REQUEST['cs_id']."' AND dm.ulbid =  '".$_REQUEST['ulbid']."' group by cdm.doc_id";
			$rs2=mysqli_query($conn,$sql2);
			while($row2= mysqli_fetch_assoc($rs2))
			{
			    $doc_obj=array();
			    $doc_obj['id']=$row2['doc_id'];
			    $doc_obj['doc_desc']=$row2['doc_desc'];
			
			//$docs[$row2['doc_id']]=$row2['doc_desc'];
			
			array_push($data['docs'], $doc_obj);
			
			}
			
			
			$sql ="select * from service_placed_mst";
			$rs = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			$mode_list[$row['sp_id']]=$row['sp_desc'];
			}
			
			$data['info']=array();
	
	 $sql="select c.*,dept_desc from category3_mst c,dept_mst d where c.dept_id=d.dept_id and c.ulbid='".$_REQUEST['ulbid']."' and cs_type_id='2' and c.dept_id='".$_REQUEST['dept_id']."' and cs_id='".$_REQUEST['cs_id']."' order by comp_desc";
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
				
				if($row['fee_type_id']==1){$row['variable']=$row['app_fee'];}else{$row['variable']=$row['fee_desc'];}
				
				$i++;
				
				$mod = $mode_list[$row['sp_id']];
				if(is_null($mod))
				{
			      $mod='';
				}
				
				$info['sno']=$i;
				$info['department_name']=$row['dept_desc'];
				$info['cutt_of_time']=$row['cutt_of_time'];
				$info['app_fee']=$row['variable'];
				$info['fine_per_day']=$row['fine_per_day'];
				$info['fin_impl']=$row['fin_impl'];
				$info['comp_desc']=$row['comp_desc'];
				$info['mod']=$mod;
				array_push($data['info'], $info);
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