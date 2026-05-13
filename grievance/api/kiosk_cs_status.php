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
	$sql ="select emp_id,emp_name,emp_mobile,emp_name_marathi from emp_mst";
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    if($langId==1){
	        $emp_list[$row['emp_id']]=$row['emp_name']."-".$row['emp_mobile'];
	    }else{
	        $emp_list[$row['emp_id']]=$row['emp_name_marathi']."-".$row['emp_mobile']; 
	    }
	}
    
    
	
$sql ="select * from grievances g left join grievance_status_mst gsm ON g.grievance_status_id=gsm.grievance_status_id left join grievances_transactions gt on g.grievance_id=gt.grievance_id where g.grievance_id like '".$_REQUEST['gid']."'";


	$nr=0;
    $rs = mysqli_query($conn,$sql);
    $nr = mysqli_num_rows($rs);
    
    if($nr > 0)
    {
    
    $row = mysqli_fetch_assoc($rs);
    $data['app_type_id']=$row['app_type_id'];
    $data['cat3_id']=$row['cat3_id'];
    $data['person_name']=$row['person_name'];
    $data['grievance_id']=$row['grievance_id'];
    $data['address']=$row['address'];
    $data['comp_desc']=$row['comp_desc'];
    $data['date_regd']=date('d-m-Y',strtotime($row['date_regd']));
    $data['grievance_status_desc']=$row['grievance_status_desc'];
    
    
    $data['emp_name']= $emp_list[$row['emp_id']];
   
    $data['alloted_date']=date('d-m-Y',strtotime($row['alloted_date']));
    
     if(is_null($row['alloted_date']))
    {
        $data['alloted_date']="Not Allotted";
    }
    else
    {
    $data['alloted_date']=date('d-m-Y',strtotime($row['alloted_date']));
    }
    
    
    if(is_null($row['disposed_date']) || $row['disposed_date']=='0000-00-00 00:00:00' || $row['disposed_date']=='1970-01-01 00:00:00')
    {
        $data['disposed_date']="Not Completed";
    }
    else
    {
    $data['disposed_date']=date('d-m-Y',strtotime($row['disposed_date']));
    }
    
    
    
    
    if($data['app_type_id']=='1')
    {
    
     $sql ="select * from cs_mst";
    }
    else
    {
        $sql ="select cs_id,comp_desc as cs_desc,telugu_description as marathi_description from category3_mst";
    }
    
	$rs = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($rs))
	{
	    if($langId==1){
	        $cs_list[$row['cs_id']]=$row['cs_desc'];
	    }else{
	         $cs_list[$row['cs_id']]=$row['marathi_description'];
	    }
	}
	
    $data['comp_desc']=$cs_list[$data['cat3_id']];
    
    
    }
    else
    {
       
        $data['app_type_id']=0;
    }
   
    $response=json_encode($data);
    echo $response;
    mysqli_close($conn);
?>