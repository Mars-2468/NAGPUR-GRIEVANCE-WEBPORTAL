<?php
date_default_timezone_set('Asia/Calcutta');
 //echo date('Y-m-d H:i:s');
require_once('connection.php');
$conn=getconnection();
function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' )
{

			    $dates = array();
			    $current = strtotime($first);
			    $last = strtotime($last);
			
			    while( $current <= $last ) {
			
			        $dates[] = date($output_format, $current);
			        $current = strtotime($step, $current);
			    }
			
			    return $dates;
}

if(isset($_POST['save']))
		{
		    
		    
		    $sql="select ward_id,ward_desc from ward_mst where ulbid='".$_POST['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
			
			$sql="select street_id,street_desc from street_mst where ulbid='".$_POST['ulbid']."' order by street_desc";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$street_list[$row['street_id']]=$row['street_desc'];
		}
		
$sql="select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='".$_POST['ulbid']."'";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
		{
			$emp_name_list[$row['emp_id']]=$row['emp_name'];
			$emp_dept_list[$row['emp_id']]=$row['emp_dept'];
			$emp_desg_list[$row['emp_id']]=$row['emp_desg'];
			$emp_mobile_list[$row['emp_id']]=$row['emp_mobile'];
		}
	}
		
		
		 $sql ="select date from public_holydays where ulbid='".$_POST['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$holiday_list[$row['date']]=$row['date'];
		}
		$hdays=0;
		
		/********************************************************/
		
		$sqlcut ="SELECT * FROM `comp_cutofdays_map` where cs_id ='".$_POST['cs_id']."'";
		$rs = mysqli_query($conn,$sqlcut);
		$rowcut = mysqli_fetch_assoc($rs);
		
		
		$sql ="select e.emp_id,e.emp_id2,c.cutt_of_time,c.app_fee,c.fine_per_day from emp_map e,category3_mst c where e.cs_id=c.cs_id and e.cs_id='".$_POST['cs_id']."'";
		$rs = mysqli_query($conn,$sql);
		$emp_det=mysqli_fetch_assoc($rs);
		
		
		
		
		$date=date('Y-m-d');
		$date = strtotime("+".$rowcut['cutt_off_time']." days", strtotime($date));
		$date=date("d-m-Y", $date);
		$dates_range=date_range(date('Y-m-d'),$date);
		foreach($dates_range as $key=>$date)
		{
			if(in_array($date,$holiday_list))
			{
				$hdays++;
			}
		}
		
		
		$date = strtotime("+".$hdays." days", strtotime($date));
	 $date=date("d-m-Y", $date);
		
		
		
		
		
		
		
		
		
			 $sql="insert into grievances(
			app_type_id,
			person_name,
			email,
			hno,
			address,
			ward_id,
			street_id,
			mobile,
			comp_subject,
			comp_desc,
			grievance_origin_id,
			grievance_status_id,
			date_regd,
			cat3_id,
			ulbid,
			cutt_of_time,
			tanker_type_id
			) values(
			'1',
			'".strip_tags($_POST['person_name'])."',
			'".strip_tags($_POST['email'])."',
			'".strip_tags($_POST['hno'])."',
			'".mysqli_real_escape_string($conn,strip_tags($_POST['address']))."',
			'".$_POST['ward_id']."',
			".strip_tags($_POST['street_id']).",
			'".strip_tags($_POST['mobile'])."',
			'".strip_tags($_POST['comp_subject'])."',
			'".strip_tags($_POST['comp_desc'])."',
			'1',
			'1',
			now(),
			'".$_POST['cs_id']."',
			'".$_POST['ulbid']."',
			'".date('Y-m-d',strtotime($date))."',
			'".$_POST['tanker_id']."'
			)";
			

			if(mysqli_query($conn,$sql))
			{
				$status=1;
				$grievance_id=mysqli_insert_id($conn);
				
				
				
				
				
				
				
				
				
				
				$path="photos/";
		
		if(is_uploaded_file($_FILES['f1']['tmp_name']))
			{
				 $file = $_FILES["f1"]["name"];
				 $ext = pathinfo($file, PATHINFO_EXTENSION);
				 $newfile =$grievance_id.".".$ext;
				 $photo_url = $path.$newfile;
				

				
				move_uploaded_file($_FILES['f1']['tmp_name'],$photo_url);
				$photo_url="http://municipalservices.in/photos/".$newfile;
				
			}
			else
			{
			$photo_url="";
			}
			
			$sql ="select swatchta_app_status_yn,swapp_cat_id from cs_mst where cs_id='".$_POST['cs_id']."'";
				    $rs = mysqli_query($conn,$sql);
				    $row = mysqli_fetch_assoc($rs);
				    $swatchta_app_status_yn=$row['swatchta_app_status_yn'];
			
			$sql ="select u.address as api_address,ulb_type_desc,ulbname,api_ulbname,lat,lng,u.access_key from ulb_type ut,ulbmst u where ut.ulb_type_id=u.ulb_type and u.ulbid='".$_POST['ulbid']."'";
					$rs = mysqli_query($conn,$sql);
					$ulb_info= mysqli_fetch_assoc($rs);
					
					
			$sql ="update grievances set file_url='".$photo_url."' where grievance_id='".$grievance_id."'";
			if(mysqli_query($conn,$sql))
			{
			    
			    
			    
			     //Start of ULB response time report
			  
			       
			       $ulbid='';$cat3_id='';$grievance_status_id='';$date_regd='';$disposed_date='';
                                $disposed_date='';$response_time='';$user_type='';
                    			   $dept_id='';
                    			   $merg_cs_id='';
                    			   $cs_type_id='';
	                	    
	                	    	$sql="SELECT grievance_id,ulbid,cat3_id,grievance_status_id,app_type_id FROM `grievances` g where grievance_id=".$grievance_id;
	                	    	//	echo $sql;exit;
	                	    	$rs=mysqli_query($conn,$sql);
	                	    	$row=mysqli_fetch_assoc($rs);
	                	    
	                	 //     $grievance_id=$row['grievance_id'];
                			  $ulbid=$row['ulbid'];
                			  $cat3_id=$row['cat3_id'];
                			  $grievance_status_id=$row['grievance_status_id'];
	                	  if($row['app_type_id']==1)
	                	  {
	                	  //for Complaints 
    	                
                             
                             //calculating response time
                             
                             	$sql="select g.grievance_id,g.date_regd,gt.disposed_date from grievances g LEFT join grievances_transactions gt on g.grievance_id=gt.grievance_id where gt.disposal_status IN('4','6','9') and g.grievance_id=".$grievance_id;
                             	$rs=mysqli_query($conn,$sql);
                             	$row=mysqli_fetch_assoc($rs);
                             	 // $grievance_id=$row['grievance_id'];
                    			 $date_regd=$row['date_regd'];
                    			 $disposed_date=$row['disposed_date'];
                                	$start1  = date_create($date_regd);
                				$end1 	= date_create($disposed_date); // Current time and date			   
                			    $diff  = date_diff( $end1, $start1 );
                			   $response_time=$diff->d.":".$diff->h.":".$diff->i.":".$diff->s;
                			   
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
                             }
		                
	                	  }else if($row['app_type_id']==2)
	                	  {
	                	      //for Services
	                	      	$sql="SELECT g.grievance_id,c.merg_cs_id,g.grievance_status_id,g.cat3_id,c.cs_type_id,c.dept_id,g.ulbid,g.user_type FROM `grievances` g LEFT join
                                category3_mst c on g.cat3_id=c.cs_id where g.grievance_id=".$grievance_id;
                                
                                $rs=mysqli_query($conn,$sql);
                             	$row=mysqli_fetch_assoc($rs);
                                
                               //  $grievance_id=$row['grievance_id'];
                    			  $ulbid=$row['ulbid'];
                    			   $status_id=$row['grievance_status_id'];
                    			  $cat3_id=$row['cat3_id'];
                    			   $user_type=$row['user_type'];
                    			   $dept_id=$row['dept_id'];
                    			   $merg_cs_id=$row['merg_cs_id'];
                    			   $cs_type_id=$row['cs_type_id'];
                    			   //calculating response time for services
                    			   
                    			   $sql="select g.grievance_id,g.date_regd,gt.disposed_date from grievances g LEFT join grievances_transactions gt on g.grievance_id=gt.grievance_id where  g.grievance_id=".$grievance_id;
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
			      		    $sql = "INSERT INTO services_map_info(grievance_id,status_id,ulbid,cat3_id,user_type,dept_id,merg_cs_id,cs_type_id,response_time)
                                      VALUES ('".$grievance_id."','".$status_id."', '".$ulbid."','".$cat3_id."','".$user_type."','".$dept_id."','".$merg_cs_id."','".$cs_type_id."','".$response_time."')";
                                     mysqli_query($conn,$sql); 
                                     
                                  //  echo "Services Map Info is updated"; 
			      		    
			      		}
                    			  
                    			 
                                
                                
	                	      
	                	  }// end of if app_type_id=2
	                	  
			       
			  
					 
				  //End of ULB response time report
					
				    
				    $sql ="select swatchta_app_status_yn,swapp_cat_id from cs_mst where cs_id='".$_POST['cs_id']."'";
				    $rs = mysqli_query($conn,$sql);
				    $row = mysqli_fetch_assoc($rs);
				    $swatchta_app_status_yn=$row['swatchta_app_status_yn'];
				   /* if($swatchta_app_status_yn=='1')
				    {
				    
				    
				    
				    
				    
				    $ch = curl_init();
                    $data = array(
                        'vendor_name' => $ulb_info['api_ulbname'], 
                        'access_key' => $ulb_info['access_key'],
                        'mobileNumber'=>$_POST['mobile'],
                        'categoryId'=>$row['swapp_cat_id'],
                        'complaintLatitude'=>$ulb_info['lat'],
                        'complaintLongitude'=>$ulb_info['lng'],
                        'complaintLocation'=>$ulb_info['api_address'],
                        'complaintLandmark'=>$ulb_info['api_address'],
                        'fullName'=>$_POST['person_name'],
                        'userLatitude'=>$ulb_info['lat'],
                        'userLongitude'=>$ulb_info['lng'],
                        'userLocation'=>trim($ulb_info['api_address']),
                        'deviceOs'=>'external',
                       'file'=>$photo_url,
                        'complaintPostedDate'=>date("Y-m-d h:i:sa"));
                        
                        
                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/sbm/v1/post-complaint');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output=curl_exec($ch);
                    $arr=json_decode($output,TRUE);
                   // print_r($arr);
                    $generic_id=$arr['complaint']['generic_id'];
                    $complaint_id=substr($arr['complaint']['generic_id'],-7);
                   
                    
                    $sql ="update grievances set http_code='".$arr['httpCode']."',code='".$arr['code']."',generic_id='".$arr['complaint']['generic_id']."' ,swatchta_app_status='1' where grievance_id='".$grievance_id."'";
                    mysqli_query($conn,$sql);
				    }*/
				
			}
			
				

				
				//require_once('get_ulb_info.php');
				//$ulb_info = get_ulb_info(); 
				 
		
				
				$sql1="select user_mobile,user_email,user_name from users where user_id='admin'";
				if($rs1=mysqli_query($conn,$sql1))
				{
					$row1 = mysqli_fetch_assoc($rs1);
					$admin_mobile=$row1['user_mobile'];
					$admin_email=$row1['user_email'];
					$admin_name=$row1['user_name'];
				}
				else
					printf("Errormessage: %s\n", mysqli_error($conn));	

				
				
				
		if($_POST['cat_id']=='3' && $_POST['ulbid']=='052')
			{
			     $sql1="SELECT emp_id1 as emp_id,dept_id  FROM water_tanker_emp_map WHERE  water_tank_id ='".$_POST['tanker_id']."'  and ulbid='".$_POST['ulbid']."'";
			}
			else
			{		
				
				
		 $sql1="SELECT cs_id,emp_id,dept_id  FROM emp_map WHERE  cs_id ='".$_POST['cs_id']."' and ward_id='".$_POST['ward_id']."' and ulbid='".$_POST['ulbid']."' and cs_type_id='1' and flag='1' and street_id='".$_POST['street_id']."'";
			}
		$rs1=mysqli_query($conn,$sql1);
		 mysqli_num_rows($rs1);
			 if(mysqli_num_rows($rs1)>0)
			 {
			   $row1 = mysqli_fetch_assoc($rs1);
			   $row1['emp_id'];
		   
		   
		         $today = date("Y-m-d H:i:s");
		          $sql2="insert into grievances_transactions(grievance_id,transaction_id,emp_id,alloted_date,disposal_status,dept_id) values(".$grievance_id.",1,".$row1['emp_id'].",'".$today."',2,'".$row1['dept_id']."')";
				
				if(mysqli_query($conn,$sql2))
				{
				    
				    $sql ="update  grievances set sla_status='1' where grievance_id='".$grievance_id."'";
				    mysqli_query($conn,$sql);
				    
				    
				    
				    $sql ="select under_progress_sla from dashboard_count where app_type_id='1' and ulbid='".$_POST['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $under_progress_sla=$rows['under_progress_sla']+1;
				    
				    $sql ="update dashboard_count set under_progress_sla='".$under_progress_sla."' where app_type_id='1' and ulbid='".$_POST['ulbid']."'";
				    mysqli_query($conn,$sql);
				    
				    
				    
				    
					
			/*	if($swatchta_app_status_yn=='1')
            					{
            				    $ch = curl_init();
                                $data = array(
                                    'statusId'=>'3',
                                    'complaintId'=>$complaint_id,
                                    'commentDescription'=>'Assigned to engineer',
                                    'deviceOs'=>'external',
                                    'vendor_name' => $ulb_info['ulbname'],
                                    'access_key' => $ulb_info['access_key'],
                                    'apiKey'=>'af4e61d75d2782a33eac7641e42bba6f'
                                    );
                                    
                                    
                                curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/engineer/v1/complaint-status-update');
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                                curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $output=curl_exec($ch);
                                $arr=json_decode($output,TRUE);
                                $sql ="update grievances_transactions set http_code='".$arr['httpCode']."',code='".$arr['code']."',id='".$arr['complaint']['id']."' where grievance_id='".$grievance_id."'";
                                mysqli_query($conn,$sql);
                                $sql="insert into swatchata_comp_status_map(generic_id,status_id,complaint_id)values('".$generic_id."','3','".$arr['complaint']['id']."')";
                                mysqli_query($conn,$sql);
                                $sql ="update grievances set swatchta_app_status='3' where grievance_id='".$grievance_id."'";
                                mysqli_query($conn,$sql);
            					}*/
					
					
					require_once('send_sms.php');
					require_once('sms_conf.php');
					
					 $sms="Dear ".$emp_name_list[$row1['emp_id']].", A Complaint from ".$_POST['person_name'].",".$_POST['hno'].",".$_POST['address'].",Mobile No.".$_POST['mobile'].", regarding ".$_POST['comp_subject']." was alloted to you on ".$today." Regards - Grievance Monitoring Cell , ".$ulb_info['ulbname'];
					 $mobile=$emp_mobile_list[$row1['emp_id']];
					
					
					 
					 $sms1="Dear ".$_POST['person_name']." Your Complaint registered ref no ".$grievance_id.", Responsible officer, please contact ".$emp_name_list[$row1['emp_id']].", MOBILE ".$mobile." -CMNR ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];


					
					$mobile1=$_POST['mobile'];
									
					
					send_sms($sms,$mobile);
					send_sms($sms1,$mobile1);
	
					
					$sql2="update grievances set grievance_status_id=2 where grievance_id=".$grievance_id;
					mysqli_query($conn,$sql2);
					
					
				
				
				
				
				}
			
		 
		   
		   
		 	}else{
		 	
		 	         $sql ="select pending_for_approval from dashboard_count where app_type_id='1' and ulbid='".$_POST['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $pending_for_approval=$rows['pending_for_approval']+1;
				    
				   $sql ="update dashboard_count set pending_for_approval='".$pending_for_approval."' where app_type_id='1' and ulbid='".$_POST['ulbid']."'";
				    mysqli_query($conn,$sql);
				    
		 	
				
				$sms="Dear ".$_POST['person_name'].", Thank you for using online Grievance Redressal system. Your Complaint has been successfully registered with reference number : ".$grievance_id.". Regards - ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];

				$sms1="Dear ".$admin_name.", A Complaint was registered by ".$_POST['person_name']." through ".$grievance_origin_list[$_POST['grievance_origin_id']]." with reference number : ".$grievance_id.". Regards - ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];		

				$mobile=$_POST['mobile'];
				
				require_once('send_sms.php');
				
				send_sms($sms,$mobile);
				send_sms($sms1,$admin_mobile);
			 }
			 
			 
			  $sql ="select received from dashboard_count where app_type_id='1' and ulbid='".$_POST['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $received=$rows['received']+1;
				    
				    $sql ="update dashboard_count set received='".$received."' where app_type_id='1' and ulbid='".$_POST['ulbid']."'";
				    mysqli_query($conn,$sql);
			 
			 
			 
			 
		$indexpage="complaint_form_streetvendors.php?id=".$_POST['ulbid']."&status=".$status."&ref_id=".$grievance_id;
			 
			 //header("location:$indexpage");
		echo "<script>window.location='$indexpage';</script>";
			
			 
			
			 
		
			}
			else{
				$status=0;
			    $message="Something went wrong";
			    $indexpage="complaint_form_streetvendors.php?message=".$message;
			    echo "<script>window.location='$indexpage';</script>";
			}
		}
		
		mysqli_close($conn);
			?>
			
			
			
			