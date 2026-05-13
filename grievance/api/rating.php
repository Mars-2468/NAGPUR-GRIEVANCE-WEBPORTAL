<?php
error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	date_default_timezone_set('Asia/Calcutta');
	

	if($_REQUEST['generic_id'] !='' && $_REQUEST['ulbid'] !='' && $_REQUEST['imei_no'] !='' && $_REQUEST['rating_no'] !='0')
	{
	    $nr=0;
	    if($_REQUEST['ulbid']==207)
	    {
	        $sql ="select * from rating_mst where grievance_id='".$_REQUEST['generic_id']."'";
	        $rs=mysqli_query($conn,$sql);
	        $nr = mysqli_num_rows($rs);
	    }
	      if($nr > 0)
	        {
	            $data[0] = array('status_code'=>'100','message'=>'You can give rating only once for one grievance');
	        }
	        else
	        {
	    
	
    	   $sql="insert into rating_mst(grievance_id,imei_no,rating_no,comment_desc,sub_option_id,resolved_id)values('".$_REQUEST['generic_id']."','".$_REQUEST['imei_no']."','".$_REQUEST['rating_no']."','".mysqli_real_escape_string($conn,$_REQUEST['comment_desc'])."','".$_REQUEST['sub_option_id']."','".$_REQUEST['sub_option_id']."') ON DUPLICATE KEY UPDATE comment_desc='".mysqli_real_escape_string($conn,$_REQUEST['comment_desc'])."',resolved_id='".$_REQUEST['sub_option_id']."'";
    	
    	
    	
    	if($rs=mysqli_query($conn,$sql))
    	{
    		if($_REQUEST['sub_option_id']=='11')
    		{
    		    
    		    $suboptionid='13';
    		    
    		    $sql="insert into reopen_transactions(grievance_id,imei_no,rating_no,comment_desc,sub_option_id)values('".$_REQUEST['generic_id']."','".$_REQUEST['imei_no']."','".$_REQUEST['rating_no']."','".mysqli_real_escape_string($conn,$_REQUEST['comment_desc'])."','".$suboptionid."')";
    		    mysqli_query($conn,$sql);
    		    
    		    
    		    // checking weather grievance already reopened or not
    		    
    		    $sql ="select grievance_id from grievances_transactions where grievance_id='".$_REQUEST['generic_id']."' and is_reopened_yn='1'";
					     $rs = mysqli_query($conn,$sql);
					     $nr_reopen= mysqli_num_rows($rs);
    		    
    		    
    		    $sql="select * from grievances_transactions where grievance_id='".$_REQUEST['generic_id']."' and disposal_status !='5'";
    		    $rs= mysqli_query($conn,$sql);
    		    $row = mysqli_fetch_assoc($rs);
    		    $trnxid=$row['transaction_id']+1;
    		     $sql ="insert into grievances_transactions (
    		        grievance_id,
    		        transaction_id,
    		        emp_id,
    		        dept_id,
    		        alloted_date,
    		        disposal_status,
    		        disposal_remarks,
    		        is_reopened_yn
    		        ) values(
    		            '".$_REQUEST['generic_id']."',
    		            '".$trnxid."',
    		            '".$row['emp_id']."',
    		            '".$row['dept_id']."',
    		            '".date('Y-m-d H:i:s')."',
    		            '13',
    		            '".mysqli_real_escape_string($conn,$_REQUEST['comment_desc'])."','1')";
    		            mysqli_query($conn,$sql);


				/* WRITE BY  NAGARAJU */
					   $sql ="select ulbid,cat3_id,street_id,ward_id from grievances where grievance_id='".$_REQUEST['generic_id']."'";
		               $rs = mysqli_query($conn,$sql);
		               $row = mysqli_fetch_assoc($rs);
		               $ulbid=$row['ulbid'];
					   $cat3_id=$row['cat3_id'];
					   $street_id=$row['street_id'];
					   $ward_id=$row['ward_id'];
					 
					   $sql1 ="select * from emp_map where cs_id='".$cat3_id."' AND street_id='".$street_id."' AND ward_id='".$ward_id."' AND cs_type_id=1";
		               $rs1 = mysqli_query($conn,$sql1);
		               $row1 = mysqli_fetch_assoc($rs1);
		               $emp_id2=$row1['emp_id2'];
					 
                    /* GRIEVANCE UNDER PROGRESS */

					   $sql="select * from grievances_transactions where grievance_id='".$_REQUEST['generic_id']."' ORDER BY transaction_id DESC LIMIT 1 ";
					   $rs= mysqli_query($conn,$sql);
					   $row = mysqli_fetch_assoc($rs);
					   $trnxid=$row['transaction_id']+1;
						$sql ="insert into grievances_transactions (
						   grievance_id,
						   transaction_id,
						   emp_id,
						   dept_id,
						   alloted_date,
						   disposal_status,
						   disposal_remarks,
						   is_reopened_yn
						   ) values(
							   '".$_REQUEST['generic_id']."',
							   '".$trnxid."',
							   '".$emp_id2."',
							   '".$row['dept_id']."',
							   '".date('Y-m-d H:i:s')."',
							   '11',
							   '".mysqli_real_escape_string($conn,$_REQUEST['comment_desc'])."','1')";
							   mysqli_query($conn,$sql);
                           $sql="update grievances set grievance_status_id='11', grievance_at_emp_level='L2' where grievance_id='".$_REQUEST['generic_id']."'";
    		                mysqli_query($conn,$sql);
    		         /* ABIVE WRITE BY NAGARAJU */
					 
					 
    		               /* $sql ="update  grievances_transactions set is_reopened_yn='1' where grievance_id='".$_REQUEST['generic_id']."' and disposal_status ='9'";
    		                mysqli_query($conn,$sql);
    		                */
    		                 $comp_completed_withinsla=0;
		                     $comp_completed_beyondsla=0;
							 
		               $sql ="select ulbid from grievances where grievance_id='".$_REQUEST['generic_id']."'";
		               $rs = mysqli_query($conn,$sql);
		               $row = mysqli_fetch_assoc($rs);
		               $ulbid=$row['ulbid'];
		               
		               
        		  $sql5="select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status,
				  ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and 
				  g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','8','10','4','9')  and gt.disposal_status !=5 and 
				  g.ulbid='".$ulbid."' and g.app_type_id='1' and grievance_id='".$_REQUEST['generic_id']."'";
				  
				  $sql5="select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status, ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and gt.disposal_status IN('13') and gt.disposal_status !=5 and g.ulbid='".$ulbid."' and g.app_type_id='1' and g.grievance_id='".$_REQUEST['generic_id']."' and transaction_id = (select MAX(transaction_id) from grievances_transactions where grievance_id='".$_REQUEST['generic_id']."')";
        			  
        		 $res5=mysqli_query($conn,$sql5);
        		 while($row5 = mysqli_fetch_assoc($res5))
				 {
				     if($row5['target'] <= $row5['target_days'])
					 {
					     // getting completed with in sla count
					     
					     $sql ="select completed_sla from dashboard_count where ulbid='".$ulbid."' and app_type_id='1'";
					     $rs = mysqli_query($conn,$sql);
					     $row = mysqli_fetch_assoc($rs);
					     $completed_sla=$row['completed_sla']-1;
					     $sql ="update dashboard_count set completed_sla='".$completed_sla."' where ulbid='".$ulbid."' and app_type_id='1'";
					     mysqli_query($conn,$sql);
					     
					     // checks for already reopened or not
					     
					     
    					     if($nr_reopen > 0) // if already existed updating counts
    					     {
    					        $sql ="select reopened_completed,reopened from dashboard_count where ulbid='".$ulbid."' and app_type_id='1'";
    					        $rs = mysqli_query($conn,$sql);
    					        $row = mysqli_fetch_assoc($rs);
    					        $reopened_completed=$row['reopened_completed']-1;
    					        $reopened=$row['reopened']+1;
    					        $sql ="update dashboard_count set reopened_completed='".$reopened_completed."',reopened='".$reopened."' where ulbid='".$ulbid."' and app_type_id='1'";
					            mysqli_query($conn,$sql);
    					        
    					     }
    					     else
    					     {
    					        $sql ="select reopened from dashboard_count where ulbid='".$ulbid."' and app_type_id='1'";
    					        $rs = mysqli_query($conn,$sql);
    					        $row = mysqli_fetch_assoc($rs);
    					        
    					        $reopened=$row['reopened']+1;
    					        $sql ="update dashboard_count set reopened='".$reopened."' where ulbid='".$ulbid."' and app_type_id='1'";
					            mysqli_query($conn,$sql);
					            
					            
    					     }
					     
					     
					     
					 }
					 else
					 {
					     $sql ="select completed_be_sla from dashboard_count where ulbid='".$ulbid."' and app_type_id='1'";
					     $rs = mysqli_query($conn,$sql);
					     $row = mysqli_fetch_assoc($rs);
					     $completed_be_sla=$row['completed_be_sla']-1;
					     $sql ="update dashboard_count set completed_be_sla='".$completed_be_sla."' where ulbid='".$ulbid."' and app_type_id='1'";
					     mysqli_query($conn,$sql);
					     
					      // checks for already reopened or not
					     
					    
    					     if($nr_reopen > 0) // if already existed updating counts
    					     {
    					        $sql ="select reopened_completed,reopened from dashboard_count where ulbid='".$ulbid."' and app_type_id='1'";
    					        $rs = mysqli_query($conn,$sql);
    					        $row = mysqli_fetch_assoc($rs);
    					        $reopened_completed=$row['reopened_completed']-1;
    					        $reopened=$row['reopened']+1;
    					        $sql ="update dashboard_count set reopened_completed='".$reopened_completed."',reopened='".$reopened."' where ulbid='".$ulbid."' and app_type_id='1'";
					            mysqli_query($conn,$sql);
    					        
    					     }
    					     else
    					     {
    					        $sql ="select reopened from dashboard_count where ulbid='".$ulbid."' and app_type_id='1'";
    					        $rs = mysqli_query($conn,$sql);
    					        $row = mysqli_fetch_assoc($rs);
    					        
    					        $reopened=$row['reopened']+1;
    					        $sql ="update dashboard_count set reopened='".$reopened."' where ulbid='".$ulbid."' and app_type_id='1'";
					            mysqli_query($conn,$sql);
					            
					            
    					     }
					    
					 }
					 
				 } 
    		                
    		            
    		}
    		
    		
    			
    			
    			$sql ="select u.ulbid,g.generic_id,u.api_ulbname,u.access_key,g.mobile from grievances g,ulbmst u  where g.ulbid=u.ulbid and g.grievance_id='".$_REQUEST['generic_id']."'";
    			$rs = mysqli_query($conn,$sql);
    			$row = mysqli_fetch_assoc($rs);
    			
    			$generic_id=$row['generic_id'];
    			if($generic_id !='')
    			{
    			    $vendor_name=$row['api_ulbname'];
    			    $accesskey=$row['access_key'];
    			    $mobile=$row['mobile'];
    			    $complaint_id=substr($generic_id,-7);
    			    $feedback_option_id=1;
    			    $timestamp=date('Y-m-d H:i:s');
    			    $comment=$_REQUEST['comment_desc'];
    			    
    			    $ch = curl_init();
                                                    $data_sw = array(
                                                       // 'id'=>$complaint_id,
                                                        'vendor_name' => $vendor_name, 
                                                        'access_key' => $accesskey,
                                                        'user_mobile_number'=>$mobile,
                                                        'feedback_option_id'=>$feedback_option_id,
                                                        'timestamp'=>$timestamp,
                                                        'comment'=>$comment
                                                        );
                                                        
                                                        
                                                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/complaint/'.$complaint_id.'/feedbacks');
                                                    curl_setopt($ch, CURLOPT_POST, 1);
                                                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_sw);
                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                    $output=curl_exec($ch);
                                                   
                                                    $arr=json_decode($output,true);
                                                     if($arr['http_code']=='201')
                                                        {
                                                            $sql ="insert into feedback_complaint_map(
                                                            generic_id,
                                                            feedback_option_id,
                                                            id,
                                                            timestamp
                                                                )values(
                                                                    '".$generic_id."',
                                                                    '".$feedback_option_id."',
                                                                    '".$arr['data']['id']."',
                                                                    '".$timestamp."'
                                                                    )";
                                                                    if(mysqli_query($conn,$sql))
                                                                    {
                                                                        
                                                                        $sql ="update grievances set feedback_sent_status='1' where generic_id='".$generic_id."'";
                                                                        mysqli_query($conn,$sql);
                                                                        
                                                                    }
                                                        }
                                                        
                                                        $data[0] = array('status_code'=>'200','message'=>'Rating updated successfully');
    			    
    			    
    			    
    			    
    			}
    			else
    			{
    			    $data[0] = array('status_code'=>'200','message'=>'Rating updated successfully');
    			}
    			
    	}
    	else
    		$data[0] = array('status_code'=>'100','message'=>'Error: Please try again');
	}
	}
	else
	{
	    $data[0] = array('status_code'=>'100','message'=>'Rating is required');
	}
		
		
	$indexedOnly = array();
	
	foreach ($data as $row) {
	    $indexedOnly[] = array_values($row);
	}
	
	echo json_encode($data);
	mysqli_close($conn);
		

?>