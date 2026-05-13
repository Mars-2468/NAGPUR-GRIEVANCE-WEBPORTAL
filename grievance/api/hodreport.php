<?php
session_start();
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET names=utf8');
        mysqli_query($conn,'SET character_set_client=utf8');
        mysqli_query($conn,'SET character_set_connection=utf8');
        mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET collation_connection=utf8_general_ci');
        $langId=$_REQUEST['lang_id'];
	$arr=explode("-",$_REQUEST['emp_id']);
  	  
  	    /*** setting emp id after spit the stirng **/
  	    $_REQUEST['emp_id']=$arr[0];
  	    $_SESSION['emp_id']=$arr[0];
  	    
	$dept_id = $_REQUEST['dept_id'];
	
	$emp_id = $_REQUEST['emp_id'];
	$sql="select emp_id,emp_name from emp_mst where emp_dept='".$dept_id."'";
	$rs=mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    $emp_ids[$row['emp_id']] = $row['emp_id'];
}
$ids = join("','",$emp_ids); 
	
	/*received*/
	 $sql="select IFNULL(count(g.grievance_id),0) as count, gt.emp_id from grievances g, grievances_transactions gt where 
	g.grievance_id=gt.grievance_id and g.app_type_id='1' and gt.disposal_status NOT IN('5','13') and g.cat3_id !='0' 
	and gt.dept_id='".$dept_id."' and gt.emp_id IN('$ids') group by gt.emp_id";
	$rs=mysqli_query($conn,$sql);				
		while($row = mysqli_fetch_assoc($rs))
		{
		     if(is_null($row['count']))
		    {
		        $row['count']=0;
		    }
			$received[$row['emp_id']]=$row['count'];
		} 
	/*resolved*/
$sql="select IFNULL(count(g.grievance_id),0) as count, gt.emp_id from grievances g, 
	grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' 
	and gt.disposal_status  IN(9,4,10,8,6,3) and g.cat3_id !='0' and gt.dept_id='".$dept_id."' and gt.emp_id IN('$ids') group by gt.emp_id";
	$rs=mysqli_query($conn,$sql);				
		while($row = mysqli_fetch_assoc($rs))
		{
		   
			$resolved[$row['emp_id']]=$row['count'];
		} 
	
	/*underprogress*/
	 $sql="select IFNULL(count(g.grievance_id),0) as count, gt.emp_id from grievances g, 
	grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' 
	and gt.disposal_status  IN(2) and g.cat3_id !='0' and gt.dept_id='".$dept_id."' and gt.emp_id IN('$ids') group by gt.emp_id";
	$rs=mysqli_query($conn,$sql);				
		while($row = mysqli_fetch_assoc($rs))
		{
		    if($row['count']=='')
		    {
		        $row['count']=0;
		    }
			$underprogress[$row['emp_id']]=$row['count'];
		} 
	
	$sql="select emp_id,emp_name from emp_mst where emp_dept='".$dept_id."'";
	$rs=mysqli_query($conn,$sql);
	$nr = mysqli_num_rows($rs);
	$response['data']=array();
		if($nr > 0 )
		{
		    $response['status_code'] = 200;
			$response['message'] = 'successfull';
		}
		else
		{
		    $response['status_code'] = 100;
			$response['message'] = 'no data found';
		}
		$i=1;
		if($nr > 0 )
		{
	 while($row = mysqli_fetch_assoc($rs))
			    {
			        if($underprogress[$row['emp_id']]=='')
			        {
			            $underprogress[$row['emp_id']]=0;
			        }
			        if($received[$row['emp_id']]=='')
			        {
			            $received[$row['emp_id']]=0;
			        }
			        if($resolved[$row['emp_id']]=='')
			        {
			            $resolved[$row['emp_id']]=0;
			        }
			       if($langId==1){
			         $arr = array('sno'=>$i,'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name'],'assigned'=>$received[$row['emp_id']],'resolved'=>$resolved[$row['emp_id']],'pending'=>$underprogress[$row['emp_id']]); 
			        }else{
			          $arr = array('sno'=>$i,'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name_marathi'],'assigned'=>$received[$row['emp_id']],'resolved'=>$resolved[$row['emp_id']],'pending'=>$underprogress[$row['emp_id']]); 
			        
			       }
			       array_push($response['data'],$arr);
			       $i++;
			    }
			    
		}
		else
		{
		     $arr = array('emp_id'=>'','emp_name'=>''); 
			       array_push($response['data'],$arr);
		}
	
/*	$sql ="select COUNT(g.grievance_id) as count from grievances g, 
	grievances_transactions gt where g.grievance_id=gt.grievance_id and g.app_type_id='1' 
	and gt.disposal_status NOT IN('5','11','12') and g.cat3_id !='0' and gt.dept_id='".$dept_id."' group by gt.emp_id";
	

	
		$res = mysqli_query($conn,$sql);
		$rs = mysqli_num_rows($res);
			if($rs > 0 )
		{
		    while($row = mysqli_fetch_assoc($rs))
			    {
			        	$response['status_code'] = 200;
			      	$response['message'] = 'Valid details';
			      	$response['emp_id'] = $row['emp_id'];
			      	$response['disposal_status'] = $row['disposal_status'];
	/*$result='{
"status_code": 200,
"message": "Valid details",
"data:"[
  {
    "sno": "1",
    "emp_name": "Srinivas",
    "assigned": "12",
    "resolved": "50",
    "pending": "100"
  },
  {
    "sno": "1",
    "emp_name": "Srinivas",
    "assigned": "12",
    "resolved": "50",
    "pending": "100"
  },
  {
    "sno": "1",
    "emp_name": "Srinivas",
    "assigned": "12",
    "resolved": "50",
    "pending": "100"
  },
  {
    "sno": "1",
    "emp_name": "Srinivas",
    "assigned": "12",
    "resolved": "50",
    "pending": "100"
  }
]
}';
}
}*/
echo json_encode($response);

	mysqli_close($conn);
	?>