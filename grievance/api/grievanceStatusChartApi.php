<?php
    session_start();
    ini_set('display_errors',0);
	require_once('apiuserconn.php');
	
      	mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET names=utf8');
        mysqli_query($conn,'SET character_set_client=utf8');
        mysqli_query($conn,'SET character_set_connection=utf8');
        mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET collation_connection=utf8_general_ci');
        $langId=$_REQUEST['lang_id'];
	
  	if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['app_type_id']))
	{
		
		if($_POST['username']=='user@54321')
		{
			if($_POST['password']=='b2ec4c96567842db02529e251cea9bb9e1879595')
				{
			
					$app_type_ids = array(1,2);
					if(in_array($_POST['app_type_id'],$app_type_ids))
					{
						$fromDate = date('Y-m-d',strtotime($_POST['fromDate']));
						$toDate = date('Y-m-d',strtotime($_POST['toDate']));
						$response['status_code'] ='200';
						$response['status_message'] ='success';
						
						
						$sql ="SELECT * FROM `grievance_status_mst` WHERE `status` = 1";
						$rs =mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($rs))
						{
						    
							$response[$row['grievance_status_desc']] =0;
						    
							
						}
						
						
						echo $sql ="SELECT count(grievance_id) as count,g.grievance_status_id,grievance_status_desc FROM grievances g left join grievance_status_mst gsm on g.grievance_status_id=gsm.grievance_status_id where app_type_id='".$_POST['app_type_id']."' and ulbid=250 and cat3_id > 0 and DATE(date_regd) >='".$fromDate."' and DATE(date_regd) <= '".$toDate."' group by `grievance_status_id`";
						$rs = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($rs))
						{
							$response[$row['grievance_status_desc']] = $row['count'];
						}
					}
					else{
							$response['status_code'] ='500';
							$response['status_message'] ='Invalid App type id';
					}
				
				}
				else{
				$response['status_code'] ='400';
				$response['status_message'] ='Invalid Password';
				}
		}
		else{
		$response['status_code'] ='300';
		$response['status_message'] ='Invalid username';
		}
	}
	else{
	    $response['status_code'] ='100';
		$response['status_message'] ='Username , Password and App type  are required';
	}
	echo json_encode($response);
	mysqli_close($conn);
  	
  	  
  