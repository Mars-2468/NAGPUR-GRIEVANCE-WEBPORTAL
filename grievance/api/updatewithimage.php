<?php
error_reporting(0);
	require_once('../connection.php');
	require_once('../send_sms.php');
	require_once('../sms_conf.php');
	$conn=getconnection();
    date_default_timezone_set('Asia/Calcutta');
    
    
	
	$file_upload_url = "uploads/";
	$server_ip = $_SERVER['SERVER_NAME'];
 	$file_upload_full_uri = 'http://' . $server_ip .'/api/'. $file_upload_url;
 	
 	$sql="select transaction_id,emp_id,alloted_date,disposed_date,disposal_status,disposal_remarks from grievances_transactions where 
 	grievance_id=".$_REQUEST['Complaint_no']." order by transaction_id";
	if($rs=mysqli_query($conn,$sql))
	{
		$transaction_id=0;
		while($row = mysqli_fetch_assoc($rs))
		{
			$transaction_id = $row['transaction_id'];
		}
		
	}
	
	$id=$_REQUEST['emp_id'];
	$st = $_REQUEST['update_date'];
	$dt = strtotime($st);
	
	
		$sql ="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id NOT IN('1','9')";
			$rs = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}
			
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
 //	echo $_FILES["status_pic"]["name"];
 /*	if(isset($_FILES['status_pic']['name'])) 
	{

		if(is_uploaded_file($_FILES['status_pic']['tmp_name']))
		{	
		/*	$file = $_FILES["status_pic"]["name"];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$newfile =$id.$file.$ext;
		    	$target_path = $file_upload_url.$newfile;*/
		    	
		    	$dat=date('dmy');
		    	 if($_POST['status_pic'] !='')
            	    {
            		    $base=$_POST['status_pic'];
            		    $target_file = $file_upload_url.time().".jpg";
            		    $file=time().".jpg";
            		    $binary=base64_decode($base);
            		    header('Content-Type: image/jpeg; charset=utf-8');
            		    //file_put_contents($target_file,$binary);
            		    $target_file='https://aurangabadmahapalika.org/csms/api/uploads/'.$file;
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
			    }
			
			
			//	$target_path=$file_upload_full_uri.$newfile;
				$sql="update grievances_transactions set disposal_status=".$status.",
				disposed_date='".date('Y-m-d H:i:s',strtotime($_REQUEST['update_date']))."',origin_id='4' , updated_by='".$user_id."',disposal_remarks='".$_REQUEST['remarks']."' where  
				grievance_id=".$_REQUEST['Complaint_no']." and transaction_id=".$transaction_id;
	//echo $sql;
	
	
	if(mysqli_query($conn,$sql))
	{
	    
	    
	    
	    		    //Start of ULB response time report
	    		    
	    		    $grievance_id=$_REQUEST['Complaint_no'];
	    		    
			
			       
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
                			   
                			   	$sql="SELECT grievance_id FROM `complaints_map_info` where grievance_id=".$grievance_id; 
			      	//echo $sql;exit;
			      	$rs=mysqli_query($conn,$sql);
			      		if(mysqli_num_rows($rs)==0)
	                	{
                             	$sql = "INSERT INTO complaints_map_info(grievance_id, ulbid,cat3_id, status_id,response_time  )
                            VALUES ('".$grievance_id."', '".$ulbid."','".$cat3_id."','".$grievance_status_id."','".$response_time."')";
                            
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
                    			   $sql="SELECT grievance_id FROM `services_map_info` where grievance_id=".$grievance_id; 
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
					
	    
	    
	    
		//$req_id=mysqli_insert_id($conn);
		$msg="Successfully Updated  Details";
		$data = array('status_code'=>'200','status_desc'=>$msg);
		if($_REQUEST['update_status']== '5' )
		{
		 $sql ="select is_reopened_yn from grievances_transactions where grievance_id=".$_REQUEST['Complaint_no']." and transaction_id=".$transaction_id;
			$rs=mysqli_query($conn,$sql);
			$row = mysqli_fetch_assoc($rs);
			$is_reopened_yn=$row['is_reopened_yn'];
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
		
		
		$sql1="insert into grievances_transactions(grievance_id,transaction_id,emp_id,alloted_date,disposal_status,is_reopened_yn) values(".$_REQUEST['Complaint_no'].",".$transaction_id.",
		".$_REQUEST['emp_id'].",'".$_REQUEST['update_date']."','".$status."','".$reopen_status."')";
		}
		else
		{
		        
		        if($_REQUEST['update_status']==3 || $_REQUEST['update_status']==8)
			    {
			        $status=9;
			    }
			    
			$sql1="update grievances set grievance_status_id='".$status."', update_image = '".$target_file."', lat='".$_REQUEST['lat']."', 
			lng='".$_REQUEST['lng']."'  where  grievance_id=".$_REQUEST['Complaint_no'];
			
		}
		if(mysqli_query($conn,$sql1))
		{
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
		    
		    if($swatchta_app_status_yn=='1')
			{
			    
                			    if($status_id==4 || $status_id==6)
                			    {
                			        $ch = curl_init();
                                    $data = array(
                                        'statusId'=>$status_id,
                                        'complaintId'=>$complaint_id,
                                        'commentDescription'=>$_POST['disposal_remarks'],
                                        'deviceOs'=>'external',
                                        'vendor_name' => $vendor_name,
                                        'access_key' => $_SESSION['access_key'],
                                        'apiKey'=>'af4e61d75d2782a33eac7641e42bba6f'
                                        );
                                        
                                        
                                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/engineer/v1/complaint-status-update');
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                                    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $output=curl_exec($ch);
                                    
                                    $arr=json_decode($output,TRUE);
                                    $sql ="update grievances_transactions set http_code='".$arr['httpCode']."',code='".$arr['code']."',id='".$arr['complaint']['id']."' where grievance_id='".$_REQUEST['Complaint_no']."'";
                                    mysqli_query($conn,$sql);
                                    $sql="insert into swatchata_comp_status_map(generic_id,status_id,complaint_id)values('".$_REQUEST['Complaint_no']."','".$status_id."','".$arr['complaint']['id']."')";
                                    mysqli_query($conn,$sql);
                                    $sql ="update grievances set swatchta_app_status='".$status_id."' where grievance_id='".$grievance_id."'";
                                    mysqli_query($conn,$sql);
                			    
                			    
                			    }
			    
			}
			
			
		}
		
		
		
		
		
		
		
		
		
		
		 $sql="select g.person_name,g.cat3_id,g.grievance_id,g.ulbid,g.mobile,transaction_id,emp_id,alloted_date,disposed_date,disposal_status,disposal_remarks from grievances g,grievances_transactions gt where  g.grievance_id=gt.grievance_id and gt.grievance_id=".$_REQUEST['Complaint_no']." order by gt.transaction_id";
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
        	
        	
        	
        
        	
        	$sms="Dear ".$person_name.", Your Complaint  regarding ".$subject." with Ref No : ".$_REQUEST['Complaint_no']." Status is ".$status_list[$_REQUEST['update_status']]." , ".$_REQUEST['remarks']." Regards - Citizen Service Monitoring Cell , ".$ulb_list[$ulbid];
		    send_sms($sms,$mobile);
		    
		    
		    
		    	$sql ="select ulbid from grievances where grievance_id='".$_REQUEST['Complaint_no']."'";
        	$rs=mysqli_query($conn,$sql);
        	$row = mysqli_fetch_assoc($rs);
        	$ulbid=$row['ulbid'];
        	
        	 $app_type_id1=1;
	    
	    if($app_type_id1=='1')
				{
				    
				    
				   
				    
				    
			    $sql="select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status,
				  ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and 
				  g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and gt.disposal_status !=5 and is_reopened_yn='0' and gt.grievance_id=".$_REQUEST['Complaint_no'];
				}
				else
				{
				    $sql="select g.grievance_id,app_type_id,date_regd,disposed_date,c.cutt_of_time+holidays_added as target_days,
				  DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status from grievances g , grievances_transactions gt,category3_mst c,ulbmst u 
				  where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id   and gt.disposal_status !=5 and gt.grievance_id=".$_REQUEST['Complaint_no'];
				}
				
				
				$rs1=mysqli_query($conn,$sql);				
				 
				 $row = mysqli_fetch_assoc($rs1);
				 if($row['target'] <= $row['target_days'])
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
            		else if($_REQUEST['update_status']==12)
            		{
            				        $sql ="select reopened,reopened_completed from ulbid='".$ulbid."' and app_type_id='1'";
            				        $rs=mysqli_query($conn,$sql);
            				        $row= mysqli_fetch_assoc($rs);
            				        $reopened=$row['reopened']-1;
            				        $reopened_completed=$row['reopened_completed']+1;
            				        $sql ="update dashboard_count set reopened='".$reopened."',reopened_completed='".$reopened_completed."' where ulbid='".$ulbid."' and app_type_id='1'";
            				        mysqli_query($conn,$sql);
            				        
            		}
            		
            		
            		else if($_REQUEST['update_status']==4 || $_REQUEST['update_status']== 10)
            		{
            			            
                				    $sql ="select under_progress_sla from dashboard_count where app_type_id='1' and ulbid='".$ulbid."'";
                				    $rs = mysqli_query($conn,$sql);
                				    $rows = mysqli_fetch_assoc($rs);
                				    
                				    $under_progress_sla=$rows['under_progress_sla']-1;
                				    
                				    
                				    if($under_progress_sla <=0)
                				    {
                				        $under_progress_sla=0;
                				    }
                				     
                				    
                				    $sql ="update dashboard_count set under_progress_sla='".$under_progress_sla."' where app_type_id='1' and
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
            			else if($_REQUEST['update_status']==12)
            			{
            				        $sql ="select reopened,reopened_completed from ulbid='".$ulbid."' and app_type_id='1'";
            				        $rs=mysqli_query($conn,$sql);
            				        $row= mysqli_fetch_assoc($rs);
            				        $reopened=$row['reopened']-1;
            				        $reopened_completed=$row['reopened_completed']+1;
            				        $sql ="update dashboard_count set reopened='".$reopened."',reopened_completed='".$reopened_completed."' where ulbid='".$ulbid."' and app_type_id='1'";
            				        mysqli_query($conn,$sql);
            				        
            			}
            			
            			
            			else if($_REQUEST['update_status']==4 || $_REQUEST['update_status']== 10)
            			{
            			            
                				    $sql ="select under_pro_be_sla from dashboard_count where app_type_id='1' and ulbid='".$ulbid."'";
                				    $rs = mysqli_query($conn,$sql);
                				    $rows = mysqli_fetch_assoc($rs);
                				    
                				    $under_pro_be_sla = $rows['under_pro_be_sla']-1;
                				    
                				    
                				    if($under_pro_be_sla <=0)
                				    {
                				        $under_pro_be_sla=0;
                				    }
                				     
                				    
                				    $sql ="update dashboard_count set under_pro_be_sla='".$under_pro_be_sla."' where app_type_id='1' and
                				    ulbid='".$ulbid."'";
                				    mysqli_query($conn,$sql);
                				    
            			 }
            				    
            			
            			
            			
            			
            			
            			
            				   
					 }
	}
	else
		$data = array('status_code'=>'201','status_desc'=>'Please Try again');
		
	
		
	/*	}
		else
		{
			$data = array('status_code'=>'202','status_desc'=>'Please Try again');
		}*/
/*	}
	else
	{
		$data = array('status_code'=>'203','status_desc'=>'Please Try again');
	}*/
	echo json_encode($data);
	mysqli_close($conn);
?>