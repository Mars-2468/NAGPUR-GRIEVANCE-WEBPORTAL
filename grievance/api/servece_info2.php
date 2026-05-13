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
	
	  $sql2 ="SELECT doc_desc,cdm.doc_id,doc_desc_marathi FROM doc_mst dm, cs_doc_map cdm WHERE cdm.doc_id = dm.doc_id AND cdm.cs_id =  '".$_REQUEST['cs_id']."' AND dm.ulbid =  '".$_REQUEST['ulbid']."' group by cdm.doc_id";
			$rs2=mysqli_query($conn,$sql2);
			while($row2= mysqli_fetch_assoc($rs2))
			{
			        $data['status_code']='200';
			        $data['status_msg'] = 'succcess';
			        $data['docs']=array();
			        if($langId==1){
			        $docs[$row2['doc_id']]=$row2['doc_desc'];
			        }else{
			        $docs[$row2['doc_id']]=$row2['doc_desc_marathi'];    
			        }
			
			}
			array_push($data['docs'], $docs);
			
			$sql ="select * from service_placed_mst";
			$rs = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
		     if($langId==1){
		         $mode_list[$row['sp_id']]=$row['sp_desc'];
    			}else{
    			    	$mode_list[$row['sp_id']]=$row['sp-desc-marati'];
    			}
			}
			
			
	
	 $sql="select c.*,dept_desc,dept_marathi from category3_mst c,dept_mst d where c.dept_id=d.dept_id and c.ulbid='".$_REQUEST['ulbid']."' and cs_type_id='2' and c.dept_id='".$_REQUEST['dept_id']."' and cs_id='".$_REQUEST['cs_id']."' order by comp_desc";
	//echo $sql;
	$fp=fopen('test.txt','a');
	fwrite($fp,$sql);
	fclose($fp);
	
	if($rs=mysqli_query($conn,$sql))
	{
		if(mysqli_num_rows($rs)>0)
		{
		    
		    $data['status_code'] = 200;
            $data['status_msg'] = 'success';
            $data['info']=array();
		    
		    
			$i=1;
			while($row = mysqli_fetch_assoc($rs))
			{
				
				if($row['fee_type_id']==1){$row['variable']=$row['app_fee'];}else{$row['variable']=$row['fee_desc'];}
				
				$i++;
				
				$info['sno']=$i;
			   if($langId==1){
			    	$info['department_name']=$row['dept_desc'];
					$info['comp_desc']=$row['comp_desc'];
			   }else{
			       	$info['department_name']=$row['dept_marathi'];
					$info['comp_desc']=$row['telugu_description'];
			   }
				$info['cutt_of_time']=$row['cutt_of_time'];
				$info['app_fee']=$row['variable'];
				$info['fine_per_day']=$row['fine_per_day'];
				$info['fin_impl']=$row['fin_impl'];
			
				$info['mod']=$mode_list[$row['sp_id']];
				array_push($data['info'], $info);
			}
			
			
		}
		else
		{
		    $data =array();
			$data= array('status_code'=>100,'status_desc'=>'Data Not Available');
		}
	}
	else
	{
	    $data =array();
		$data= array('status_code'=>100,'status_desc'=>'Query Not executed');
		
	}
	$indexedOnly = array();

foreach ($data as $row) {
    $indexedOnly[] = array_values($row);
}

echo json_encode($data);

mysqli_close($conn);


?>