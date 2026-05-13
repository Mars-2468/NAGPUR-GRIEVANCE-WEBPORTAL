<?php
		ini_set('display_errors',0);
	if($_REQUEST['person_name']!='' && $_REQUEST['hno']!='' && $_REQUEST['address']!='' && $_REQUEST['mobile'] !='' && $_REQUEST['cat3_id'] !='')
	{
	    
	
	
	require_once('../connection.php');
	$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET names=utf8');
        mysqli_query($conn,'SET character_set_client=utf8');
        mysqli_query($conn,'SET character_set_connection=utf8');
        mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET collation_connection=utf8_general_ci');
        $langId=$_REQUEST['lang_id'];
	date_default_timezone_set('Asia/Calcutta');
	 //echo date('Y-m-d H:i:s');
	
	require_once('../send_sms.php');
	require_once('../sms_conf.php');
	
	/* $_POST['person_name']='Girish';
	$_POST['ward_id']='1';
	$_POST['comp_subject']='Testing';
	$_POST['mobile']='9177474656';
	$_POST['cat3_id']='4';
	$_POST['grievance_status_id']='1';
	$_POST['street_id']='1'; */
	
	
	$sql="select ward_id,ward_desc,wards_marathi from ward_mst where ulbid='".$_REQUEST['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
			 if($langId==1){
			     	$ward_list[$row['ward_id']]=$row['ward_desc'];
			 }else{
			     	$ward_list[$row['ward_id']]=$row['wards_marathi'];
			 }
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
			
			$sql="select street_id,street_desc,street_desc_marathi from street_mst where ulbid='".$_REQUEST['ulbid']."' order by street_desc";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
			 if($langId==1){
			     $street_list[$row['street_id']]=$row['street_desc'];
			 }else{
			     $street_list[$row['street_id']]=$row['street_desc_marathi'];
			 }
		}
	
		$sql ="select cs_id,cs_desc,marathi_description as comp_desc from cs_mst";
			$rs = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			  if($langId==1){
			      $cs_list[$row['cs_id']]=$row['comp_desc'];
			  }else{
			      $cs_list[$row['cs_id']]=$row['marathi_description']; 
			  }
			}
	
	
	
	$sql="select emp_id,emp_name,emp_dept,emp_desg,emp_mobile,emp_name_marathi from emp_mst where ulbid='".$_REQUEST['ulbid']."'";
	if($rs=mysqli_query($conn,$sql))
	{
		while($row = mysqli_fetch_assoc($rs))
		{
			if($langId==1){
			    $emp_name_list[$row['emp_id']]=$row['emp_name'];
			}else{
			    $emp_name_list[$row['emp_id']]=$row['emp_name_marathi'];
			}
			$emp_dept_list[$row['emp_id']]=$row['emp_dept'];
			$emp_desg_list[$row['emp_id']]=$row['emp_desg'];
			$emp_mobile_list[$row['emp_id']]=$row['emp_mobile'];
		}
	}
		
		
	
		
		$dat=date('dmy');
		$target_dir= "../grievance/photos/".$dat."/";
		if (!file_exists($target_dir))
		{
			mkdir($target_dir, 0777, true);
					
		}
		
		//$data = array('status_code'=>'201','status_desc'=>$_POST['image']);
		//echo json_encode($data);
		//exit;
	    if($_FILES["image"]["name"] !='')
	    {
		    $base=$_FILES["image"]["name"];
		    $target_file = $target_dir.time().".jpg";
		    $file=time().".jpg";
		    $binary=base64_decode($base);
		    header('Content-Type: image/jpeg; charset=utf-8');
		    if(move_uploaded_file($_FILES["image"]["tmp_name"],$target_file)){
		        $target_file='http://municipalservices.in/grievance/photos/'.$dat.'/'.$file;
		    }else{
		        $target_file = '#';
		    }
	    }else if($_POST['image'] !='')
	    {
		    $base=$_POST['image'];
		    $target_file = $target_dir.time().".jpg";
		    $file=time().".jpg";
		    $binary=base64_decode($base);
		    header('Content-Type: image/jpeg; charset=utf-8');
		   // file_put_contents($target_file,$binary);
		    $target_file='http://municipalservices.in/grievance/photos/'.$dat.'/'.$file;
	    }
	    else
	    	$target_file='#';
	    	
	    	//$target_dir= "comm_address/";
		
				/*$file = $_FILES["image"]["name"];
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				$newfile =time().".jpg";
				
				
		 		$target_file = $target_dir. $newfile;
		
		
		 		if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file))
		 		{
                   
                   		$target_file="http://municipalservices.in/".$target_file;
                   		}
                   		else
                   		{
                   		$target_file=$target_file;
                   		}*/
  
  $sql ="select grievance_id from grievances where 
			app_type_id='1' and 
			person_name='".$_POST['person_name']."' and 
			email='-' and 
			hno='".$_POST['hno']."' and 
			address='".$_POST['address']."' and 
			ward_id='".$_POST['ward_id']."' and 
			street_id='".$_POST['street_id']."' and 
			mobile='".$_POST['mobile']."' and 
			comp_subject='".$_POST['comp_subject']."' and 
			comp_desc='".$_POST['comp_desc']."' and 
			grievance_origin_id='4' and 
			user_id='".$_POST['imei']."' and 
			lat='".$_POST['lat']."' and 
			lat='".$_POST['lng']."' and 
			cat3_id='".$_POST['cat3_id']."' and
			ulbid='".$_REQUEST['ulbid']."' and 
			tanker_type_id='".$_POST['tanker_id']."'
			";
			
	$rs = mysqli_query($conn,$sql);
			$nr= mysqli_num_rows($rs);
			if($nr > 0)
			{
			    $msg="Not Inserted";
			}
			else
			{
			    
			    
			    
		
	  $sql="insert into grievances(app_type_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_desc,grievance_origin_id,
	grievance_status_id,date_regd,user_id,lat,lng,file_url,cat3_id,ulbid,tanker_type_id,device_os_id)
	values('1','".mysqli_real_escape_string($conn,$_POST['person_name'])."','".$_POST['email']."','".mysqli_real_escape_string($conn,$_POST['hno'])."',
	'".mysqli_real_escape_string($conn,$_POST['address'])."','".$_POST['ward_id']."','".$_POST['street_id']."','".$_POST['mobile']."',
	'".mysqli_real_escape_string($conn,$_POST['comp_desc'])."',4,1,now(),'".$_POST['imei']."','".$_POST['lat']."','".$_POST['lng']."',
	'".$target_file."','".$_POST['cat3_id']."','".$_REQUEST['ulbid']."','".$_POST['tanker_id']."','".$_POST['deviceOs']."')";
	
	
$fp=fopen('test.txt','a');
	
	fwrite($fp,serialize($_POST));
	fwrite($fp,$sql);
	
	
	fclose($fp);
	
/*	if($_REQUEST['ulbid']==207 && ($_POST['cat3_id']=='36' || $_POST['cat3_id']=='37' || $_POST['cat3_id']=='38' || $_POST['cat3_id']=='39' || $_POST['cat3_id']=='53' || $_POST['cat3_id']=='63'))
         {
             
             $sms='Call Toll Free No 180030022582 for Streetlight Complaints';
             send_sms($sms,$_POST['mobile']);
         }
         else
         {*/
         
	
	
	if(mysqli_query($conn,$sql))
	{
	    
	    
	    
	    
	    
	    
	    
	$grievance_id=mysqli_insert_id($conn);
	$sql ="select received from dashboard_count where app_type_id=1 and ulbid='".$_REQUEST['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $received=$rows['received']+1;
				    
				    $sql ="update dashboard_count set received='".$received."' where app_type_id=1 and ulbid='".$_REQUEST['ulbid']."'";
				    mysqli_query($conn,$sql);
	
	
	
	
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
	
	
	// calling api
	
	                $sql ="select u.address as api_address,ulb_type_desc,ulbname,api_ulbname,access_key,lat,lng from ulb_type ut,ulbmst u where ut.ulb_type_id=u.ulb_type and u.ulbid='".$_REQUEST['ulbid']."'";
					$rs = mysqli_query($conn,$sql);
					$ulb_info= mysqli_fetch_assoc($rs);
				    
				    $sql ="select swatchta_app_status_yn,swapp_cat_id from cs_mst where cs_id='".$_POST['cat3_id']."'";
				    $rs = mysqli_query($conn,$sql);
				    $row = mysqli_fetch_assoc($rs);
				    $swatchta_app_status_yn=$row['swatchta_app_status_yn'];
				    if($row['swatchta_app_status_yn']=='1')
				    {
				    
				    
				    /*$geocodeFrom = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.trim($_POST['address']).'&sensor=false');
                    $outputFrom = json_decode($geocodeFrom);
                    $latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
                    $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;*/
				    
				    
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
                        'userLatitude'=>$_POST['lat'],
                        'userLongitude'=>$_POST['lng'],
                        'userLocation'=>trim($ulb_info['api_address']),
                        'deviceOs'=>'external',
                        'file'=>$target_file,
                        'complaintPostedDate'=>date("Y-m-d H:i:s"));
                        
                        
                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/sbm/v1/post-complaint');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output=curl_exec($ch);
                    
                    
                    $arr=json_decode($output,TRUE);
                    $generic_id=$arr['complaint']['generic_id'];
                    //$complaint_id=substr($arr['complaint']['generic_id'],-7);
                     $newarray=explode('C',$arr['complaint']['generic_id']);
            
            $complaint_id=$newarray[1];
                   
                  
                                    $sql ="update grievances set http_code='".$arr['httpCode']."',code='".$arr['code']."',generic_id='".$arr['complaint']['generic_id']."',swatchta_app_status='1' where grievance_id='".$grievance_id."'";
                                    mysqli_query($conn,$sql);
                                    
                                
				    }
				
	
	
	
	
	
	
		   
		
		
		$data = array('status_code'=>'200','status_desc'=>'Complaint Registered successfully with Reference no:'.$grievance_id);
		
		/*$conn2= mysqli_connect("localhost", "mahabubnagarmc_app", "4v7k8VJfLpC%", 'mahabubnagarmc_app');
		 $msg="Successfully Added Complaint Details With Ref ID : ".$grievance_id;
		   $data = array('status_code'=>'200','status_desc'=>$msg);*/
		
	//	$sql1="SELECT ward_id,cs_id,emp_id  FROM emp_map WHERE ward_id ='".$_POST['ward_id']."'  and cs_id ='".$_POST['cat3_id']."' and cs_type_id='1' and ulbid='".$_REQUEST['ulbid']."' and street_id='".$_POST['street_id']."'";
		
		if($_POST['dept_id']=='3' && $_REQUEST['ulbid']=='052')
			{
			      $sql1="SELECT emp_id1 as emp_id,dept_id  FROM water_tanker_emp_map WHERE  water_tank_id ='".$_POST['tanker_id']."'  and ulbid='".$_REQUEST['ulbid']."'";
			}
			else
			{
		
		 $sql1="SELECT ward_id,cs_id,emp_id,dept_id  FROM emp_map WHERE ward_id ='".$_POST['ward_id']."'  and cs_id ='".$_POST['cat3_id']."' and cs_type_id='1' and ulbid='".$_REQUEST['ulbid']."' and street_id='".$_POST['street_id']."'";
			}
			
			
			
			
		$rs1=mysqli_query($conn,$sql1);
		
		$fp=fopen('test.txt','a');
		fwrite($fp,$sql1);
		fclose($fp);
		$aaa=0;
	
		 if(mysqli_num_rows($rs1)>0)
		 {
		  $aaa=1;
		 	
			//require_once('get_ulb_info.php');
			//$ulb_info = get_ulb_info();
			
			 
		  
		   $row1 = mysqli_fetch_assoc($rs1);
		   $row1['emp_id'];
		   
		   
		         $today = date("Y-m-d H:i:s");
			$grievance_id_sel=$grievance_id;
		$sql2="insert into grievances_transactions(grievance_id,transaction_id,emp_id,alloted_date,disposal_status,dept_id) values(".$grievance_id_sel.",1,".$row1['emp_id'].",'".$today."',2,'".$row1['dept_id']."')";
			
				$fp=fopen('test.txt','a');
				fwrite($fp,$sql2);
				fclose($fp);	
					
			if(mysqli_query($conn,$sql2))
			{
			    
			    
			    $sql ="update  grievances set sla_status='1' where grievance_id='".$grievance_id."'";
				    mysqli_query($conn,$sql);
			   
			   $app_type_id=1;
				$sql ="select under_progress_sla from dashboard_count where app_type_id='".$app_type_id."' and ulbid='".$_REQUEST['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $under_progress_sla=$rows['under_progress_sla']+1;
				    
				    $sql ="update dashboard_count set under_progress_sla='".$under_progress_sla."' where app_type_id='".$app_type_id."' and ulbid='".$_REQUEST['ulbid']."'";
				    mysqli_query($conn,$sql);
				
				
				
				
				
				
				
			
			if($swatchta_app_status_yn=='1')
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
            					}
			
			
				//$sms="Dear ".$emp_name_list[$row1['emp_id']].", A Grievance from ".$_POST['person_name']." (".$_POST['mobile']."),".$_POST['address']." regarding ".$_POST['comp_desc']." with Ref No : ".$grievance_id_sel." was alloted to you on ".$today." Regards - Grievance Monitoring Cell , ".$ulb_info['ulb_name'];
				$sms="Dear ".$emp_name_list[$row1['emp_id']].", A Grievance from ".$_POST['person_name']." (".$_POST['mobile']."),".$_POST['address']." regarding ".$cs_list[$_POST['cat3_id']]." with Ref No : ".$grievance_id_sel." was alloted to you on ".date('d-m-Y H:i:s',strtotime($today))." Regards - Grievance Monitoring Cell , ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];
				 $mobile=$emp_mobile_list[$row1['emp_id']];
				
				
				
				$sms1="Dear ".$_POST['person_name'].", Your Grievance  regarding ".$cs_list[$_POST['cat3_id']]." with Ref No : ".$grievance_id_sel." was alloted to ".$emp_name_list[$row1['emp_id']]." (".$mobile.") on ".date('d-m-Y H:i:s',strtotime($today))." Regards - Grievance Monitoring Cell ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];
				
				$mobile1=$_POST['mobile'];
								
				
				send_sms($sms,$mobile);
				send_sms($sms1,$mobile1);
				
				$fp=fopen('test.txt','a');
				fwrite($fp,$sms);
				fwrite($fp,$sms1);
				fclose($fp);	

				
				$sql2="update grievances set grievance_status_id=2 where grievance_id=".$grievance_id_sel;
				mysqli_query($conn,$sql2);
			}
			else
			{
			    
			    /*$app_type_id=1;
			    $sql ="select pending_for_approval from dashboard_count where app_type_id='".$app_type_id."' and ulbid='".$_REQUEST['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $pending_for_approval=$rows['pending_for_approval']+1;
				    
				   $sql ="update dashboard_count set pending_for_approval='".$pending_for_approval."' where app_type_id='".$app_type_id."' and ulbid='".$_REQUEST['ulbid']."'";
				    mysqli_query($conn,$sql); */
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
				
				$sms2="Dear ".$_POST['person_name'].", Thank you for using online Grievance Redressal system. Your Complaint has been successfully registered with reference number : ".$grievance_id.". Regards - ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];;
				
				
				send_sms($sms2,$_POST['mobile']);
			}
			
			
			
				/* $app_type_id=1;	
			 $sql ="select received from dashboard_count where app_type_id='".$app_type_id."' and ulbid='".$_REQUEST['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $received=$rows['received']+1;
				    
				    $sql ="update dashboard_count set received='".$received."' where app_type_id='".$app_type_id."' and ulbid='".$_REQUEST['ulbid']."'";
				    mysqli_query($conn,$sql);*/
			
		 
		   
		   
		 }
		 else
		 {
		     
		      $app_type_id=1;
			    $sql ="select pending_for_approval from dashboard_count where app_type_id='".$app_type_id."' and ulbid='".$_REQUEST['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $pending_for_approval=$rows['pending_for_approval']+1;
				    
				   $sql ="update dashboard_count set pending_for_approval='".$pending_for_approval."' where app_type_id='".$app_type_id."' and ulbid='".$_REQUEST['ulbid']."'";
				    mysqli_query($conn,$sql); 
		     $sms2="Dear ".$_POST['person_name'].", Thank you for using online Grievance Redressal system. Your Complaint has been successfully registered with reference number : ".$grievance_id.". Regards - ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];
				
				
				send_sms($sms2,$_POST['mobile']);
		 }
		 
		 
		 
		 
		 
		 
		 
		 		 	
			 
			
		 
									
		
	}
	else
	{
		$data = array('status_code'=>'201','status_desc'=>'Please Try again');
	}
	
	
       /*  }*/
	
	
	
	}
	}
	else
	{
	    $data = array('status_code'=>'201','status_desc'=>'Please Try again');
	}
		
	echo json_encode($data);
mysqli_close($conn);

?>