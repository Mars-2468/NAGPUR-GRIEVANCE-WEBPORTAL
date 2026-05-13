<?php
    ini_set('display_errors',0);
	require_once('../connection.php');
	require_once('../send_sms.php');
	require_once('../sms_conf.php');
	$conn=getconnection();
	
	    mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET names=utf8');
		mysqli_query($conn,'SET character_set_client=utf8');
		mysqli_query($conn,'SET character_set_connection=utf8');
		mysqli_query($conn,'SET character_set_results=utf8');
		mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	
	
	
	
    date_default_timezone_set('Asia/Calcutta');
	//$st = $_REQUEST['update_date'];
	$st = '2017-28-01';
	$dt = strtotime($st);
//echo	$dt =  date('Y-m-d',$dt);
//	echo $dt->format('d-m-Y');
//echo $date = date("Y-m-d", $dt);

$originalDate = "2017-01-28";
//echo $newDate = date("d-m-Y", strtotime($originalDate));

			$sql ="select u.ulbid,ulbname,ulb_type_desc from ulbmst u,ulb_type ut where u.ulb_type=ut.ulb_type_id";
			$rs = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			$ulb_list[$row['ulbid']]=$row['ulbname']." ".$row['ulb_type_desc'];
			}
	
			$sql ="select cs_id,cs_desc as comp_desc from cs_mst";
			$rs = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			$cs_list[$row['cs_id']]=$row['comp_desc'];
			}
			$sql ="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id NOT IN('1','11','12')";
			$rs = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}

	 $sql="select g.person_name,g.cat3_id,g.grievance_id,g.ulbid,g.mobile,transaction_id,emp_id,alloted_date,disposed_date,disposal_status,disposal_remarks from grievances g,
	 grievances_transactions gt where  g.grievance_id=gt.grievance_id and gt.grievance_id=".$_REQUEST['Complaint_no']." order by gt.transaction_id";
	if($rs=mysqli_query($conn,$sql))
	{
		$transaction_id=0;
		while($row = mysqli_fetch_assoc($rs))
		{
			$transaction_id = $row['transaction_id'];
			$person_name=$row['person_name'];
			$subject=$cs_list[$row['cat3_id']];
			$ulbid=$row['ulbid'];
			$mobile=$row['mobile'];
		}
		
	}
	
		$sql ="select emp_mobile from emp_mst where emp_id='".$_REQUEST['emp_id']."'";
            	$rs = mysqli_query($conn,$sql);
            	$row = mysqli_fetch_assoc($rs);
            	$user_id=$row['emp_mobile'];
		    	$curtime = date('H:i:s');
			
			   $_REQUEST['update_date']=$_REQUEST['update_date']." ".$curtime;
			    
			    if($_REQUEST['update_status']==3 || $_REQUEST['update_status']==8)
			    {
			        $status=9;
			        $_REQUEST['update_status']=9;
			        
			    }
			    else
			    {
			        $status=$_REQUEST['update_status'];
			    }
			    
			 $sql ="select is_reopened_yn from grievances_transactions where grievance_id=".$_REQUEST['Complaint_no']." and transaction_id=".$transaction_id;
			$rs=mysqli_query($conn,$sql);
			$row = mysqli_fetch_assoc($rs);
			$is_reopened_yn=$row['is_reopened_yn'];
			if($is_reopened_yn==1)
			{
			    $reopen_status=1;
			}
			else
			{
			    $reopen_status=0;
			}
	
	$sql="update grievances_transactions set disposal_status=".$status.",disposed_date='".date('Y-m-d H:i:s',strtotime($_REQUEST['update_date']))."',updated_by='".$user_id."',disposal_remarks='".mysqli_real_escape_string($conn,$_REQUEST['remarks'])."',origin_id='4',is_reopened_yn='".$reopen_status."' where  grievance_id=".$_REQUEST['Complaint_no']." and transaction_id=".$transaction_id;
	//echo $sql;
	
	
	if(mysqli_query($conn,$sql))
	{
	    
	    if($_REQUEST['update_status']=='12')
	    {
	        $sql ="update rating_mst set comment_desc='".mysqli_real_escape_string($conn,$_REQUEST['remarks'])."',resolved_id='".$_REQUEST['update_status']."' where grievance_id='".$_REQUEST['Complaint_no']."'";
	        mysqli_query($conn,$sql);
	        $sql ="insert into reopen_transactions(grievance_id,sub_option_id,comment_desc) values('".$_REQUEST['Complaint_no']."','".$_REQUEST['update_status']."','".mysqli_real_escape_string($conn,$_REQUEST['remarks'])."')";
	        mysqli_query($conn,$sql);
	    }
	    
	    
	    
	    $app_type_id1=1;
	    
	    $sql ="select ulbid from grievances where grievance_id='".$_REQUEST['Complaint_no']."'";
	    $rs=mysqli_query($conn,$sql);
	    $row =mysqli_fetch_assoc($rs);
	    $ulbid=$row['ulbid'];
	    
	    
				    
				    
				$grievance_id=$_REQUEST['Complaint_no'];
	    
	  		    //Start of ULB response time report
			 
			       
			       $grievance_id='';$ulbid='';$cat3_id='';$grievance_status_id='';$date_regd='';$disposed_date='';
                                $disposed_date='';$response_time='';$user_type='';
                    			   $dept_id='';
                    			   $merg_cs_id='';
                    			   $cs_type_id='';
	                	    
	                	    	$sql="SELECT grievance_id,ulbid,cat3_id,grievance_status_id,app_type_id FROM `grievances` g where grievance_id=".$_REQUEST['Complaint_no'];
	                	    	//	echo $sql;exit;
	                	    	$rs=mysqli_query($conn,$sql);
	                	    	$row=mysqli_fetch_assoc($rs);
	                	    
	                	      $grievance_id=$row['grievance_id'];
                			  $ulbid=$row['ulbid'];
                			  $cat3_id=$row['cat3_id'];
                			  $grievance_status_id=$row['grievance_status_id'];
	                	  if($row['app_type_id']==1)
	                	  {
	                	  //for Complaints 
    	                
                             
                             //calculating response time
                             
                             	$sql="select g.grievance_id,g.date_regd,gt.disposed_date from grievances g LEFT join grievances_transactions gt on g.grievance_id=gt.grievance_id where  g.grievance_id=".$_REQUEST['Complaint_no'];
                             	$rs=mysqli_query($conn,$sql);
                             	$row=mysqli_fetch_assoc($rs);
                             	  $grievance_id=$row['grievance_id'];
                    			 $date_regd=$row['date_regd'];
                    			 $disposed_date=$row['disposed_date'];
                                	$start1  = date_create($date_regd);
                				$end1 	= date_create($disposed_date); // Current time and date			   
                			    $diff  = date_diff( $end1, $start1 );
                			   $response_time=$diff->d.":".$diff->h.":".$diff->i.":".$diff->s;
                			   
                			   $sql="update grievances set response_time='".$response_time."' where grievance_id=".$_REQUEST['Complaint_no'];
                			   $rs = mysqli_query($conn,$sql);
                			   
                			   
                			   	$sql="SELECT grievance_id FROM `complaints_map_info` where grievance_id=".$_REQUEST['Complaint_no']; 
			      	//echo $sql;exit;
			      	$rs=mysqli_query($conn,$sql);
			      		if(mysqli_num_rows($rs)==0)
	                	{
                             	$sql = "INSERT INTO complaints_map_info(grievance_id, ulbid,cat3_id, status_id,response_time)
                            VALUES ('".$_REQUEST['Complaint_no']."', '".$ulbid."','".$cat3_id."','".$grievance_status_id."','".$response_time."')";
                            
                          //  echo $sql;exit;
                             mysqli_query($conn,$sql);
                            // echo "Complaints Map Info is updated"; 
                             }else
		                {
		                    
		                   
                            
                            
                            
		                    $sql = "UPDATE `complaints_map_info` SET `response_time`='".$response_time."', `status_id`=".$_REQUEST['update_status']." where grievance_id=".$_REQUEST['Complaint_no'];
                            mysqli_query($conn,$sql);
		                   
		                    
		                    
		                    //echo "record available in complaints map info";
		                }
	                	  }else if($row['app_type_id']==2)
	                	  {
	                	      //for Services
	                	      	$sql="SELECT g.grievance_id,c.merg_cs_id,g.cat3_id,c.cs_type_id,c.dept_id,g.ulbid,g.user_type FROM `grievances` g LEFT join
                                category3_mst c on g.cat3_id=c.cs_id where g.grievance_id=".$_REQUEST['Complaint_no'];
                                
                                $rs=mysqli_query($conn,$sql);
                             	$row=mysqli_fetch_assoc($rs);
                                
                                 $grievance_id=$row['grievance_id'];
                    			  $ulbid=$row['ulbid'];
                    			  $cat3_id=$row['cat3_id'];
                    			   $user_type=$row['user_type'];
                    			   $dept_id=$row['dept_id'];
                    			   $merg_cs_id=$row['merg_cs_id'];
                    			   $cs_type_id=$row['cs_type_id'];
                    			   //calculating response time for services
                    			   
                    			   $sql="select g.grievance_id,g.date_regd,gt.disposed_date from grievances g LEFT join grievances_transactions gt on g.grievance_id=gt.grievance_id where  g.grievance_id=".$_REQUEST['Complaint_no'];
                    			 //  echo $sql;exit;
		                        	$rs=mysqli_query($conn,$sql);
		                        		$row=mysqli_fetch_assoc($rs);
		                        	 $date_regd=$row['date_regd'];
                    			   $disposed_date=$row['disposed_date'];
                    				//$start='2017-01-10 15:05:08';
                    			  //  $end='2017-01-13 16:05:08';			   
                    				$start1  = date_create($date_regd);
                    				$end1 	= date_create($disposed_date); // Current time and date			   
                    			    $diff  = date_diff( $end1, $start1 );
                    			
                    			   $response_time=$diff->d.":".$diff->h.":".$diff->i.":".$diff->s;
                    			   //echo  $response_time;exit;
                    			   $sql="SELECT grievance_id FROM `services_map_info` where grievance_id=".$_REQUEST['Complaint_no']; 
			      	            $rs=mysqli_query($conn,$sql);
			      		if(mysqli_num_rows($rs)==0)
			      		{
			      		    $sql = "INSERT INTO services_map_info(grievance_id,ulbid,cat3_id,user_type,dept_id,merg_cs_id,cs_type_id,response_time)
                                      VALUES ('".$grievance_id."', '".$ulbid."','".$cat3_id."','".$user_type."','".$dept_id."','".$merg_cs_id."','".$cs_type_id."','".$response_time."')";
                                     mysqli_query($conn,$sql); 
                                     
                                  //  echo "Services Map Info is updated"; 
			      		    
			      		}else
		                {
		                    
                             
                             
                             
                            
		                    $sql = "UPDATE `services_map_info` SET `response_time`='".$response_time."', `status_id`=".$_REQUEST['update_status']." where grievance_id=".$_REQUEST['Complaint_no'];
                            mysqli_query($conn,$sql);
		                   
		                }
                    			  
                    			 
                                
                                
	                	      
	                	  }// end of if app_type_id=2
	                	  
			       
			 
					 
				  //End of ULB response time report
					  
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    $_REQUEST['update_status'];
	    
		//$req_id=mysqli_insert_id($conn);
		$msg="Successfully Updated Details";
		$data = array('status_code'=>'200','status_desc'=>$msg);
		if($_REQUEST['update_status']=='5' )
		{
		     if($is_reopened_yn==1)
            			{
            			    $reopen_status=1;
            			    $status=11;
            			}
            			else
            			{
            			    $reopen_status=0;
            			    $status=2;
            			}
            			
               
        		    $transaction_id=$transaction_id+1;
            		$sql1="insert into grievances_transactions(
            		grievance_id,
            		transaction_id,
            		dept_id,
            		desg_id,
            		emp_id,
            		alloted_date,
            		disposal_status,
            		is_reopened_yn
            		) 
            		values(
            		".$_REQUEST['Complaint_no'].",
            		".$transaction_id.",
            		".$_REQUEST['dept_id'].",
            		".$_REQUEST['desg_id'].",
            		".$_REQUEST['employee_id'].",
            		'".date('Y-m-d H:i:s',strtotime($_REQUEST['update_date']))."',
            		'2',
            		'".$reopen_status."'
            		)";
            		$rs1 = mysqli_query($conn,$sql1);
        
                		if($rs1)
                		{
                		    
                		    $sql2="update grievances set grievance_status_id = '2' where grievance_id = '".$_REQUEST['Complaint_no']."'";
                		    $rs2 = mysqli_query($conn,$sql2);
                		    
                		}
                		
        		
        		
		
		    
		    
		    
		}
		else
		{
		    
		    // caling api
		    
		    if($_REQUEST['update_status']=='3' || $_REQUEST['update_status']=='4' || $_REQUEST['update_status']=='6' || $_REQUEST['update_status']=='8' || $_REQUEST['update_status']=='9')
		    {
		        $status_id=4;
		    }
		    else if($_REQUEST['update_status']=='10')
		    {
		        $status_id=6;
		    }
		    
		    $sql ="select u.ulbname,g.app_type_id,c.swatchta_app_status_yn,c.swapp_cat_id,g.generic_id from ulbmst u, grievances g,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_id='".$_REQUEST['Complaint_no']."'";
		    $rs =mysqli_query($conn,$sql);
		    $row = mysqli_fetch_assoc($rs);
		    $vendor_name=$row['ulbname'];
		    $app_type_id1=$row['app_type_id'];
		    $swatchta_app_status_yn=$row['swatchta_app_status_yn'];
		    $swapp_cat_id=$row['swapp_cat_id'];
		    $generic_id=$row['generic_id'];
		    //$complaint_id=substr($row['generic_id'],-7);
		     $newarray=explode('C',$row['generic_id']);
            
            $complaint_id=$newarray[1];
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    if($_REQUEST['update_status']==3 || $_REQUEST['update_status']==8)
			    {
			        $status=9;
			    }
		    
		    
			 $sql1="update grievances set grievance_status_id='".$status."', lat='".$_REQUEST['lat']."', lng='".$_REQUEST['lng']."',update_remarks='".$_REQUEST['remarks']."',
			 updated_by='".$user_id."' where  grievance_id=".$_REQUEST['Complaint_no'];
			 
			 
			 $sms="Dear ".$person_name.", Your Complaint  regarding ".$subject." with Ref No : ".$_REQUEST['Complaint_no']." Status is ".$status_list[$_REQUEST['update_status']]." , ".$_REQUEST['remarks']." Regards - Citizen Service Monitoring Cell , ".$ulb_list[$ulbid];
			 
			 
		}
		
		mysqli_query($conn,$sql1);
	
		send_sms($sms,$mobile);
		
		
		
		$app_type_id1=1;
		$sql1="select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status,
				  ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and 
				  g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id ='".$_REQUEST['update_status']."'  and gt.disposal_status !=5 and is_reopened_yn='0' and gt.grievance_id=".$_REQUEST['Complaint_no']." and transaction_id=".$transaction_id;
			
				
				
				$rs1=mysqli_query($conn,$sql1);				
				 
				 $row1 = mysqli_fetch_assoc($rs1);
				 
				 
				 if($row1['target'] <= $row1['target_days'])
				{
					       // updating sla status in grievance
				    
				    $sql ="update  grievances set sla_status='1' where grievance_id='".$_REQUEST['Complaint_no']."'";
				    mysqli_query($conn,$sql);
				    
				    
				    
				    // end
					     
            					 if($_REQUEST['update_status']==3 || $_REQUEST['update_status']==8  || $_REQUEST['update_status']==9)
            				    {
                    				        $sql ="select under_progress_sla,completed_sla from dashboard_count where app_type_id='".$app_type_id1."' and ulbid='".$ulbid."'";
                    				    $rs = mysqli_query($conn,$sql);
                    				    $rows = mysqli_fetch_assoc($rs);
                    				    
                    				    $under_progress_sla=$rows['under_progress_sla']-1;
                    				    $completed_sla=$rows['completed_sla']+1;
                    				    
                    				    if($under_progress_sla <= 0)
                    				    {
                    				        $under_progress_sla=0;
                    				    }
                    				     if($completed_sla <= 0)
                    				    {
                    				        $completed_sla=0;
                    				    }
                    				    
                    				    
                    				    $sql ="update dashboard_count set under_progress_sla='".$under_progress_sla."',completed_sla='".$completed_sla."' where app_type_id='".$app_type_id1."' and ulbid='".$ulbid."'";
                    				    mysqli_query($conn,$sql);
            				    }
            				    else if($_REQUEST['update_status']==6)
            				    {
                    				        $sql ="select under_progress_sla,financial_implication from dashboard_count where app_type_id='".$app_type_id1."' and ulbid='".$ulbid."'";
                    				    $rs = mysqli_query($conn,$sql);
                    				    $rows = mysqli_fetch_assoc($rs);
                    				    
                    				    $under_progress_sla=$rows['under_progress_sla']-1;
                    				    $financial_implication=$rows['financial_implication']+1;
                    				    
                    				     if($under_progress_sla <= 0)
                    				    {
                    				        $under_progress_sla=0;
                    				    }
                    				     if($financial_implication <= 0)
                    				    {
                    				        $financial_implication=0;
                    				    }
                    				    
                    				    
                    				    $sql ="update dashboard_count set under_progress_sla='".$under_progress_sla."',financial_implication='".$financial_implication."' where app_type_id='".$app_type_id1."' and ulbid='".$ulbid."'";
                    				    mysqli_query($conn,$sql);
            				    }
            				  
            				    
            				    
            				     else if($_REQUEST['update_status']==4 || $_REQUEST['update_status']== 10)
            			        {
            			            
                				    $sql ="select under_progress_sla from dashboard_count where app_type_id='".$app_type_id1."' and ulbid='".$ulbid."'";
                				    $rs = mysqli_query($conn,$sql);
                				    $rows = mysqli_fetch_assoc($rs);
                				    
                				    $under_progress_sla=$rows['under_progress_sla']-1;
                				    
                				    
                				    if($under_progress_sla <=0)
                				    {
                				        $under_progress_sla=0;
                				    }
                				     
                				    
                				    $sql ="update dashboard_count set under_progress_sla='".$under_progress_sla."' where app_type_id='".$app_type_id1."' and
                				    ulbid='".$ulbid."'";
                				    mysqli_query($conn,$sql);
                				    
            			        }
            				    
            				    
            				    
            				    
					 }
					 else
					 {
					     
					      // updating sla status in grievance
				    
				     $sql ="update  grievances set sla_status='2' where grievance_id='".$_REQUEST['Complaint_no']."'";
				    mysqli_query($conn,$sql);
				    
				    
				    
				    // end
					    if($_REQUEST['update_status']==3 || $_REQUEST['update_status']==8 ||  $_REQUEST['update_status']==9)
            				    {
                    				        $sql ="select under_pro_be_sla,completed_be_sla from dashboard_count where app_type_id='".$app_type_id1."' and ulbid='".$ulbid."'";
                    				    $rs = mysqli_query($conn,$sql);
                    				    $rows = mysqli_fetch_assoc($rs);
                    				    
                    				    $under_pro_be_sla=$rows['under_pro_be_sla']-1;
                    				    $completed_be_sla=$rows['completed_be_sla']+1;
                    				    
                    				     if($under_pro_be_sla <= 0)
                    				    {
                    				        $under_pro_be_sla=0;
                    				    }
                    				     if($completed_be_sla <= 0)
                    				    {
                    				        $completed_be_sla=0;
                    				    }
                    				    
                    				    
                    				    $sql ="update dashboard_count set under_pro_be_sla='".$under_pro_be_sla."',completed_be_sla='".$completed_be_sla."' where app_type_id='".$app_type_id1."' and ulbid='".$ulbid."'";
                    				    mysqli_query($conn,$sql);
            				    }
            				    else if($_REQUEST['update_status']==6)
                    			{
                    				        $sql ="select under_pro_be_sla,financial_implication from dashboard_count where app_type_id='".$app_type_id1."' and ulbid='".$ulbid."'";
                    				    $rs = mysqli_query($conn,$sql);
                    				    $rows = mysqli_fetch_assoc($rs);
                    				    
                    				    $under_pro_be_sla=$rows['under_pro_be_sla']-1;
                    				    $financial_implication=$rows['financial_implication']+1;
                    				    
                    				    
                    				     if($under_pro_be_sla <= 0)
                    				    {
                    				        $under_pro_be_sla=0;
                    				    }
                    				     if($financial_implication <= 0)
                    				    {
                    				        $financial_implication=0;
                    				    }
                    				    
                    				    
                    				    $sql ="update dashboard_count set under_pro_be_sla='".$under_pro_be_sla."',financial_implication='".$financial_implication."' where app_type_id='".$app_type_id1."' and ulbid='".$ulbid."'";
                    				    mysqli_query($conn,$sql);
            				    }
            				   
            				    
            				    
            				    
            				    
            				    
            				   
					 }
	    
	    
	
		
	}
	else
		$data = array('status_code'=>'201','status_desc'=>'Please Try again');
		
	echo json_encode($data);
mysqli_close($conn);

?>