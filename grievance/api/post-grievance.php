<?php
	ini_set('display_errors',0);
	
	$accessKey=$_POST['accessKey'];
	$statusarray=array(2,9);
	if($accessKey=="74743749iihhkahdhi")
	{
	    $conn= mysqli_connect("127.0.0.1", "municipa_csms", "ipDa6sS!cQuv", 'municipa_csms') or die(mysqli_connect_error());
    	if($_POST['PersonName']!='' && $_POST['DoorNo']!='' && $_POST['Address']!='' && $_POST['Mobile'] !='' && $_POST['CompCatId'] !='' &&  $_POST['StatusId'])
    	{
    	    
    	     if($_POST['StatusId']=='2')
                       {
                           
                           if($_POST['AllotedDate']==''  || $_POST['AllotedDate']=='null')
    	                        {
    	                            $data = array('status_code'=>'201','status_desc'=>'Validation Fail');
    	                            echo json_encode($data);
    	                            exit;
    	                            
    	                        }
                       }
                       if($_POST['StatusId']=='9')
                       {
                           
                           if( $_POST['DisposalDate']=='' || $_POST['DisposalDate']=='null' || $_POST['AllotedDate']==''  || $_POST['AllotedDate']=='null')
    	                        {
    	                            $data = array('status_code'=>'201','status_desc'=>'Validation Fail');
    	                            echo json_encode($data);
    	                            exit;
    	                            
    	                        }
                       }
                       
                       

            $sql="insert into grievances(
                app_type_id,
                person_name,
                email,
                hno,
                ward_id,
                street_id,
                ulbid,
                mobile,
                comp_subject,
                comp_desc,
                grievance_origin_id,
                grievance_status_id,
                date_regd,
                lat,
                lng,
                cat3_id,
                file_url
                )values(
                    '1',
                    '".htmlspecialchars(strip_tags($_POST['PersonName']))."',
                    '".htmlspecialchars(strip_tags($_POST['PersonEmail']))."',
                    '".htmlspecialchars(strip_tags($_POST['DoorNo']))."',
                    '1',
                    '1',
                    '211',
                    '".htmlspecialchars(strip_tags($_POST['Mobile']))."',
                    '".htmlspecialchars(strip_tags($_POST['CompSubject']))."',
                    '".htmlspecialchars(strip_tags($_POST['CompDesc']))."',
                    '".htmlspecialchars(strip_tags($_POST['OriginId']))."',
                    '".htmlspecialchars(strip_tags($_POST['StatusId']))."',
                    '".htmlspecialchars(strip_tags($_POST['CompPostedDate']))."',
                    '".htmlspecialchars(strip_tags($_POST['Latitude']))."',
                    '".htmlspecialchars(strip_tags($_POST['Langitude']))."',
                    '".htmlspecialchars(strip_tags($_POST['CompCatId']))."',
                    '".htmlspecialchars(strip_tags($_POST['FilePath']))."'
                   )";
                   if(mysqli_query($conn,$sql))
                   {
                       $grievanceid = mysqli_insert_id($conn);
                       $data = array('status_code'=>'201','status_desc'=>'Data uploaded successfully','GrienvaceId'=>$grievanceid);
                       
                       if(in_array($_POST['StatusId'],$statusarray))
                       {
                      $sql="insert into grievances_transactions(
                           
                           grievance_id,
                           transaction_id,
                           emp_id,
                           dept_id,
                           alloted_date,
                           disposed_date,
                           disposal_status,
                           disposal_remarks,
                           is_reopened_yn
                           )values(
                               '".$grievanceid."',
                               '1',
                               '1',
                               '1',
                               '".htmlspecialchars(strip_tags($_POST['AllotedDate']))."',
                               '".htmlspecialchars(strip_tags($_POST['DisposalDate']))."',
                               '".htmlspecialchars(strip_tags($_POST['StatusId']))."',
                               '".htmlspecialchars(strip_tags($_POST['DisposalRemarks']))."',
                               '0'
                               )";
                               mysqli_query($conn,$sql);
                               $data = array('status_code'=>'201','status_desc'=>'Data uploaded successfully','GrienvaceId'=>$grievanceid);
                       }
                   }
    	}
    	else
    	{
    	    $data = array('status_code'=>'201','status_desc'=>'Validation Fail');
    	}
	}
	else
	{
	    $data = array('status_code'=>'100','status_desc'=>'Invalid AccessKey');
	}
	echo json_encode($data);
//mysqli_close($conn);

?>