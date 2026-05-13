<?php
	ini_set('display_errors',0);
	session_start();
		
    date_default_timezone_set('Asia/Calcutta');
   
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	//echo "<pre>";print_r($_FILES);echo "</pre>";die();
	
	if(isset($_SESSION['uid']))
	{
	        
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		
		//require_once('prepare_connection.php');
		$conn=getconnection();
		
		mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		
		
	    $_SESSION['formStatus'] = 1; 
	/*	if($_SESSION['ulbid'] == '3')
    		{
    		  $_SESSION['formStatus'] = 0;  
    		}*/
		
		$tpl->assign('formStatus',$_SESSION['formStatus']);
        
		$sql="select grievance_origin_id,grievance_origin_desc from grievance_origin_mst where show_status=1";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
				
				//print_r($grievance_origin_list);
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
        //	$sql="select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
	
	$sql=$conn->prepare("select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid=? and delete_status='0' and emp_status='0'");
	$sql->bind_param("s",$_SESSION['ulbid']);
	
	if($sql->execute())
	{
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$emp_name_list[$row['emp_id']]=$row['emp_name'];
			$emp_dept_list[$row['emp_id']]=$row['emp_dept'];
			$emp_desg_list[$row['emp_id']]=$row['emp_desg'];
			$emp_mobile_list[$row['emp_id']]=$row['emp_mobile'];
		}
	}
	
	//$sql="select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
	
	$sql=$conn->prepare("select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst_od where ulbid=? and delete_status='0'");
	$sql->bind_param("s",$_SESSION['ulbid']);
	
	if($sql->execute())
	{
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$emp_name_list[$row['emp_id']]=$row['emp_name'];
			$emp_dept_list[$row['emp_id']]=$row['emp_dept'];
			$emp_desg_list[$row['emp_id']]=$row['emp_desg'];
			$emp_mobile_list[$row['emp_id']]=$row['emp_mobile'];
		}
	}
	
	//$sql="select ward_id,ward_desc from ward_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
	
	$sql=$conn->prepare("select ward_id,ward_desc from ward_mst where ulbid=?");
	$sql->bind_param("s",$_SESSION['ulbid']);
	
		if($sql->execute())
		{
		    $rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		else
			printf("Errormessage: %s\n", $sql->error);	
			
			//$sql="select street_id,street_desc from street_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' order by street_desc";
		$sql=$conn->prepare("select street_id,street_desc from street_mst where ulbid=? order by street_desc");
	    $sql->bind_param("s",$_SESSION['ulbid']);	
			
		if($sql->execute())
		{
		    $rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
				$street_list[$row['street_id']]=$row['street_desc'];
		}
	
	    $sql->close();
	
	
		/*if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));*/
	
	
	
	
	 $sql ="select cs_id,comp_desc from category3_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
		
		$sql=$conn->prepare("select cs_id,comp_desc from category3_mst where ulbid=?");
	    $sql->bind_param("s",$_SESSION['ulbid']);
		
		$rs = $sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		$service_list[$row['cs_id']]=$row['comp_desc'];
		}
		
		$sql->close();
		
		if(isset($_POST['save']))
		{
		
		    $old_complaint_check_id = $_POST['old_comp_check_id'];
		    if($old_complaint_check_id == 1){
	            $date_regd_old_comp = $_POST['datetimepicker'];
	            $date_regd_old_comp = date('Y-m-d H:i:s', strtotime($date_regd_old_comp));
	        }else{
	            $date_regd_old_comp = date('Y-m-d H:i:s');
	        }
		    //echo $date_regd_old_comp;
		    $lat_lng_check_id = $_POST['lat_lng_check_id'];
		    if($lat_lng_check_id == 1){
		        $lat = $_POST['lat'];
		        $lng = $_POST['lng'];
		    }else{
		        $lat = 0;
		        $lng = 0;
		    }
		    //echo $lat." ".$lng;exit;
		    
			$file_no=$_POST['prefix']."/".$_POST['file_no']."/".date('Y');
			
		$sql ="select grievance_id from grievances where 
			app_type_id='".$_POST['app_type_id']."' and 
			person_name='".$_POST['person_name']."' and 
			email='".$_POST['email']."' and 
			hno='".$_POST['hno']."' and 
			address='".$_POST['address']."' and 
			ward_id='".$_POST['ward_id']."' and 
			street_id='".$_POST['street_id']."' and 
			mobile='".$_POST['mobile']."' and 
			comp_subject='".$_POST['comp_subject']."' and 
			comp_desc='".$_POST['comp_desc']."' and 
			grievance_origin_id='".$_POST['grievance_origin_id']."' and 
			
			user_id='".$_SESSION['uid']."' and 
			cat3_id='".$_POST['cs_id']."' and 
			user_type='1' and 
			ulbid='".$_SESSION['ulbid']."' and 
			file_url='".$photo_url."' and 
			 
			file_no='".mysqli_real_escape_string($conn,$file_no)."' and 
			remarks='".mysqli_real_escape_string($conn,$_POST['remarks'])."' and 
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
			    $status_const="Pending for approval";
		
		        
			 $sql="insert into grievances(app_type_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,
    			 grievance_origin_id,grievance_status_id,date_regd,user_id,lat,lng,cat3_id,user_type,ulbid,file_url,cutt_of_time,file_no,remarks,tanker_type_id,holidays_added,
			 endorsement,mcat3_id,sub_cat_id) 
			 values(
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['app_type_id']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['person_name']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['email']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['hno']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['address']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['ward_id']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['street_id']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['mobile']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['comp_subject']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['comp_desc']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['grievance_origin_id']))."',
			 1,
			 '".$date_regd_old_comp."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_SESSION['uid']))."',
			 '".$lat."',
			 '".$lng."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['cs_id']))."',
			 '1','".mysqli_real_escape_string($conn,htmlspecialchars($_SESSION['ulbid']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($photo_url))."',
			 '".date('Y-m-d H:i:s',strtotime($_POST['cut_off_time']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($file_no))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['remarks']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['tanker_id']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['holidays']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['endorsement']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['cs_id']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['sub_id']))."')";
			 
			 /*$sql=$conn->prepare("insert into grievances(app_type_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,
    			 grievance_origin_id,grievance_status_id,date_regd,user_id,lat,lng,cat3_id,user_type,ulbid,file_url,cutt_of_time,file_no,remarks,tanker_type_id,holidays_added,
			 endorsement,mcat3_id) 
			 values(
			 ?,
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['person_name']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['email']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['hno']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['address']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['ward_id']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['street_id']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['mobile']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['comp_subject']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['comp_desc']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['grievance_origin_id']))."',
			 1,
			 '".$date_regd_old_comp."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_SESSION['uid']))."',
			 '".$lat."',
			 '".$lng."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['cs_id']))."',
			 '1','".mysqli_real_escape_string($conn,htmlspecialchars($_SESSION['ulbid']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($photo_url))."',
			 '".date('Y-m-d H:i:s',strtotime($_POST['cut_off_time']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($file_no))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['remarks']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['tanker_id']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['holidays']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['endorsement']))."',
			 '".mysqli_real_escape_string($conn,htmlspecialchars($_POST['cs_id']))."')");
			 
			 $sql->bind_param("i",$_POST['app_type_id']);*/
			 
		

			if(mysqli_query($conn,$sql))
			{
			    
			    
			    
			    //
			    
			    $_SESSION['form_submit']='1';
			    
				$grievance_id=mysqli_insert_id($conn);
				
				
			  //Start of ULB response time report
			  
			       
			       $ulbid='';$cat3_id='';$grievance_status_id='';$date_regd='';$disposed_date='';
                                $disposed_date='';$response_time='';$user_type='';
                    			   $dept_id='';
                    			   $merg_cs_id='';
                    			   $cs_type_id='';
                    			   $sub_cat_id='';
	                	    
	                	    	$sql="SELECT grievance_id,ulbid,cat3_id,grievance_status_id,app_type_id,sub_cat_id FROM `grievances` g where grievance_id=".mysqli_real_escape_string($conn,strip_tags($grievance_id));
	                	    	//	echo $sql;exit;
	                	    	$rs=mysqli_query($conn,$sql);
	                	    	$row=mysqli_fetch_assoc($rs);
	                	    
	                	 //     $grievance_id=$row['grievance_id'];
                			  $ulbid=$row['ulbid'];
                			  $cat3_id=$row['cat3_id'];
                			  $sub_cat_id  =$row['sub_cat_id'];
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
                             	$sql = "INSERT INTO complaints_map_info(grievance_id, ulbid,cat3_id, status_id,response_time,sub_cat_id  )
                            VALUES ('".$grievance_id."', '".$ulbid."','".$cat3_id."','".$grievance_status_id."','".$response_time."','".$sub_cat_id."')";
                            
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
					
			    
				
				
				
				
				$grievance_id2=$grievance_id;
				$_SESSION['gid']=$grievance_id;
				$path="photos/";
		
		if(is_uploaded_file($_FILES['f1']['tmp_name']))
			{
				 $file = $_FILES["f1"]["name"];
				 $ext = pathinfo($file, PATHINFO_EXTENSION);
				 $newfile =$grievance_id.".".$ext;
				 $photo_url = $path.$newfile;

				
				if(move_uploaded_file($_FILES['f1']['tmp_name'],$photo_url))
				{
				    $photo_url="https://" . $_SERVER['HTTP_HOST'] . "/grievance/".$photo_url;
				    
				               //$file_info = new finfo(FILEINFO_MIME_TYPE);
                               $mime_types_array = array('image/jpeg','image/gif','image/bmp','image/gif','image/png','application/pdf');
                               $finopath = $target_file;
		                       //$mime_type = $file_info->buffer(file_get_contents($photo_url));
		                      /* if(!in_array($mime_type,$mime_types_array))
                                                {
                                                    unlink($finopath);
                                                    die('Invalid file type');
                                                    
                                                   
                                                }
                                                else
                                                {
                                                    // $photo_url="http://municipalservices.in/".$photo_url;
                                                    $photo_url="https://" . $_SERVER['HTTP_HOST'] . "/grievance/".$photo_url;
                                                }*/
                                                
				    //$photo_url="http://municipalservices.in/".$photo_url;
				    
				}
				else
				{
				    $photo_url="#";
				}
			//	$photo_url=$photo_url;
				
			}
			else
			{
			$photo_url="";
			}
			
			$sql ="update grievances set file_url='".$photo_url."' where grievance_id='".$grievance_id."'";
			mysqli_query($conn,$sql);
			
			
			$sql ="select u.address as api_address,ulb_type_desc,api_ulbname,lat,lng,ulbname from ulb_type ut,ulbmst u where ut.ulb_type_id=u.ulb_type and u.ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
					$rs = mysqli_query($conn,$sql);
					$ulb_info= mysqli_fetch_assoc($rs);
					
			
			if($_POST['app_type_id']==1)
			{
				    
				    $sql ="select swatchta_app_status_yn,swapp_cat_id from cs_mst where cs_id='".mysqli_real_escape_string($conn,strip_tags($_POST['cs_id']))."'";
				    $rs = mysqli_query($conn,$sql);
				    $row = mysqli_fetch_assoc($rs);
				    $swatchta_app_status_yn=$row['swatchta_app_status_yn'];
				    if($row['swatchta_app_status_yn']=='1')
				    {
				    
				    // gettting geo location latitude and langitude
				    
				   /* $geocodeFrom = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.trim($_POST['address']).'&sensor=false');
                    $outputFrom = json_decode($geocodeFrom);
                    $latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
                   $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;*/
				    
				    if($lat != 0 && $lng != 0){
				        $lat = $lat;
				        $lng = $lng;
				    }else{
				        $lat = $ulb_info['lat'];
				        $lng = $ulb_info['lng'];
				    }
				    
				    $ch = curl_init();
                    $data = array(
                        'vendor_name' => $ulb_info['api_ulbname'], 
                        'access_key' => $_SESSION['access_key'],
                        'mobileNumber'=>$_POST['mobile'],
                        'categoryId'=>$row['swapp_cat_id'],
                        'complaintLatitude'=>$lat,
                        'complaintLongitude'=>$lng,
                        'complaintLocation'=>$ulb_info['api_address'],
                        'complaintLandmark'=>trim($ulb_info['api_address']),
                        'fullName'=>$_POST['person_name'],
                        'userLatitude'=>$lat,
                        'userLongitude'=>$lng,
                        'userLocation'=>trim($ulb_info['api_address']),
                        'deviceOs'=>'external',
                        'file'=>$photo_url,
                        'complaintPostedDate'=>$date_regd_old_comp);
                        
                        
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
                                    //print_r($newarray);
                                    $complaint_id=$newarray[1];
                   
                   
                                $sql ="update grievances set http_code='".$arr['httpCode']."',code='".$arr['code']."',generic_id='".$arr['complaint']['generic_id']."' ,swatchta_app_status='1' where grievance_id='".$grievance_id2."'";
                                mysqli_query($conn,$sql);
                                
				    }
				    
				}
			
			
			
			
			
			
			
			
			
			
			
			
			
				$tpl->assign('class','alert alert-success display-hide');

				
				$msg="Successfully Added Service Details With Ref ID : ".$grievance_id;

				
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

				
				$tpl->assign('msg','updated Service not assigned to employee , please map employee in emp matp');
				
				if($_POST['app_type_id']=='2')
				{
				
					// In case of Boduppal municipality
					
					if($_SESSION['ulbid']==207)
					{
						for($i=1;$i<=$_POST['file_count'];$i++)
						{
							$doc_id="doc_id".$i;
							$doc_number="doc_id_check".$i;
							if($_POST[$doc_number] != "")
							{
								 $sql="insert into docrec_mst(greivence_id,doc_id,app_enter_docno)values('".mysqli_real_escape_string($conn,strip_tags($grievance_id))."','".mysqli_real_escape_string($conn,strip_tags($_POST[$doc_id]))."','".mysqli_real_escape_string($conn,strip_tags($_POST[$doc_number]))."')";
								mysqli_query($conn,$sql);
							}
						}
					}
					else // For other municipalities
					{
					 	$_POST['file_count'];
						for($i=1;$i<=$_POST['file_count'];$i++)
						{
							$doc_id="doc_id".$i;
							$doc_number="doc_number".$i;
							if($_POST[$doc_number] != "")
							{
								 $sql="insert into docrec_mst(greivence_id,doc_id,app_enter_docno)values('".mysqli_real_escape_string($conn,strip_tags($grievance_id))."','".mysqli_real_escape_string($conn,strip_tags($_POST[$doc_id]))."','".mysqli_real_escape_string($conn,strip_tags($_POST[$doc_number]))."')";
								mysqli_query($conn,$sql);
							}
						}
					}
				}
				
				
				if($_POST['app_type_id']==2)
				{
				
				$_POST['comp_subject']=$service_list[$_POST['cs_id']];
				
				}
				
				
		    if($_POST['emp_id'] == '22222222222' || $_POST['emp_id'] == '')
		    {
				
			
        			
        		    $sql1="SELECT cs_id,emp_id,dept_id  FROM emp_map WHERE  cs_id ='".mysqli_real_escape_string($conn,strip_tags($_POST['cs_id']))."' and ward_id='".mysqli_real_escape_string($conn,strip_tags($_POST['ward_id']))."' and ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' and flag='1' and cs_type_id='".mysqli_real_escape_string($conn,strip_tags($_POST['app_type_id']))."' and street_id='".mysqli_real_escape_string($conn,strip_tags($_POST['street_id']))."'";
        			
        			$rs = mysqli_query($conn,$sql1);
		            $nr= mysqli_num_rows($rs);
		            if($nr > 0)
		            {
		                $status_const="Under progress";
		            }
		            $row1 = mysqli_fetch_assoc($rs);
		    }
		    else
		    {
		       $sql123="SELECT emp_id,emp_dept as dept_id,emp_desg,emp_mobile  FROM emp_mst WHERE emp_id='".mysqli_real_escape_string($conn,strip_tags($_POST['emp_id']))."' and ulbid='".$_SESSION['ulbid']."' and delete_status='0' and emp_status='0'";
		        
		        $rs = mysqli_query($conn,$sql123);
		        $nr = mysqli_num_rows($rs);
		        if($nr <=0)
		        {
		         $sql1="SELECT emp_id,emp_dept as dept_id,emp_desg,emp_mobile  FROM emp_mst_od WHERE emp_id='".mysqli_real_escape_string($conn,strip_tags($_POST['emp_id']))."' and ulbid='".$_SESSION['ulbid']."' and emp_status='0'";
		         $rs = mysqli_query($conn,$sql1);
		         $nr = mysqli_num_rows($rs);
		        }
		      
		       
		            if($nr > 0)
		            {
		                $status_const="Under progress";
		            }
		            $row1 = mysqli_fetch_assoc($rs);
		       
		        
		       
		    }
		    
		    //echo $sql1;
		    //exit;
		    
		  
		
			 if($nr > 0)
			 {
			     
			   $emp_id= $row1['emp_id'];
			   
			   if($_POST['emp_id'] == '22222222222' || $_POST['emp_id'] == '')
        		    {
        		        $emp_dept= $row1['dept_id'];
        		    }
        		    else
        		    {
        		        $emp_dept= $_POST['emp_dept'];
        		    }
		   
		         $today = date("Y-m-d H:i:s");
		        /// $today = date_format('d-m-Y',$cur_today);
		         
		         $sql2="insert into grievances_transactions(grievance_id,transaction_id,emp_id,alloted_date,disposal_status,dept_id) values(".$grievance_id.",1,'".$emp_id."','".$date_regd_old_comp."',2,'".$emp_dept."')";
				
				if(mysqli_query($conn,$sql2))
				{
				    
				    
				    // updating sla status in grievance
				    
				    $sql ="update  grievances set sla_status='1',grievance_at_emp_level='L1' where grievance_id='".$grievance_id."'";
				    mysqli_query($conn,$sql);
				    
				    
				    
				    // end
				    
				    $sql ="select under_progress_sla from dashboard_count where app_type_id='".mysqli_real_escape_string($conn,strip_tags($_POST['app_type_id']))."' and ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $under_progress_sla=$rows['under_progress_sla']+1;
				    
				    $sql ="update dashboard_count set under_progress_sla='".$under_progress_sla."' where app_type_id='".mysqli_real_escape_string($conn,strip_tags($_POST['app_type_id']))."' and ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
				    mysqli_query($conn,$sql);
				    
				    
				    
    				    	    
    				/******* unnder progress within sla ****/
    				
    				$sql1 = "select comp_cat from cs_mst where cs_id = '".mysqli_real_escape_string($conn,strip_tags($_POST['cs_id']))."'" ;
        			$rs1 = mysqli_query($conn,$sql1);
        			$rows1 = mysqli_fetch_assoc($rs1);
        			$field_name = $rows1['comp_cat'];
    				
    				
        			$sql3 = "select (".$field_name.") as under_sla from complaints_cat_count where ulbid = '".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' and status = '5' " ;
        			$rs3 = mysqli_query($conn,$sql3);
        			$rows3 = mysqli_fetch_assoc($rs3);
        			$under_sla = $rows3['under_sla']+1;
        			
        			$qry1 = "update complaints_cat_count set ".$field_name." = ".$under_sla." where ulbid = '".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' and status = '5' " ;
        			$res1 = mysqli_query($conn,$qry1);	
				    
				       
				    
				    
				    
				    
				   
				    
				    
					$tpl->assign('msg','inserted successfully');
					
					if($_POST['app_type_id']==1)
        				{
        					if($swatchta_app_status_yn=='1')
            					{
            				    $ch = curl_init();
                                $data = array(
                                    'statusId'=>'3',
                                    'complaintId'=>$complaint_id,
                                    'commentDescription'=>'Assigned to engineer',
                                    'deviceOs'=>'external',
                                    'vendor_name' => $ulb_info['api_ulbname'],
                                    'access_key' => $_SESSION['access_key'],
                                    'statusChangeDate'=>$date_regd_old_comp,
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
                                if($arr['httpCode']==200 && $arr['code']==2000)
                                {
                                $sql="insert into swatchata_comp_status_map(generic_id,status_id,complaint_id)values('".$generic_id."','3','".$arr['complaint']['id']."')";
                                mysqli_query($conn,$sql);
                                $sql ="update grievances set swatchta_app_status='3' where grievance_id='".$grievance_id."'";
                                mysqli_query($conn,$sql);
                                }
                                
                                
                                
            					}
        					
        					
        				}
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					//require_once('get_ulb_info.php');
					
					if($_SESSION['ulbid']==207)
					{
					    if($_POST['app_type_id']=='1')
					    {
					    $grievance_id=$grievance_id;
					    }
					    else
					    {
					//$grievance_id2=$grievance_id;
					$grievance_id=$file_no;
					    }
					}
					
					
					require_once('send_sms.php');
					require_once('sms_conf.php');
					
					 $sql ="select * from standard_services";
					 $rs = mysqli_query($conn,$sql);
					 while($row = mysqli_fetch_assoc($rs))
					 {
					     $standar_service_ist[$row['cs_id']]=$row['cs_desc'];
					 }
					 
					 $sql ="select * from cs_mst";
					 $rs = mysqli_query($conn,$sql);
					 while($row = mysqli_fetch_assoc($rs))
					 {
					     $cs_ist[$row['cs_id']]=$row['cs_desc'];
					 }
					 
					 $sql ="select * from comp_cutofdays_map";
					 $rs = mysqli_query($conn,$sql);
					 while($row = mysqli_fetch_assoc($rs))
					 {
					     $cutofdates[$row['cs_id']]=round($row['cutt_off_time'] * 24 * 60);
					 }
					 $Date=date('Y-m-d H:i:s');
					 
					 $endTime = strtotime("+".$cutofdates[$_POST['cs_id']]." minutes", strtotime(date('Y-m-d H:i:s')));
					 
					 $cutoffdate = date('Y-m-d H:i:s', $endTime);
					  if($_POST['app_type_id']==1)
					 {
					     $aaa="complaint";
					     $subject=$_POST['comp_subject'];
						 $complaintType = $cs_ist[$_POST['cs_id']];
						 
					 }
					 else
					 {
					     $aaa="service";
					     $subject=$standar_service_ist[$_POST['cs_id']];
					 }
					 
        		if($old_complaint_check_id != 1){			 
        		    /*$sms="Dear ".$emp_name_list[$row1['emp_id']].", A ".$aaa." from ".mysqli_real_escape_string($conn,strip_tags($_POST['person_name'])).",Mobile No.".mysqli_real_escape_string($conn,strip_tags($_POST['mobile'])).",".mysqli_real_escape_string($conn,strip_tags($_POST['hno']))." regarding ".$subject." with ref no ".$grievance_id." was alloted to you on ".date('d-m-Y',strtotime($today))." Regards - Citizen Service Monitoring Cell , ".$ulb_info['ulbname'];
        		    
        		    $mobile=$emp_mobile_list[$row1['emp_id']];
        		    $templateId ="1207161725772623021";
        		    send_sms($sms,$mobile,$templateId);*/
					
					
				// 	$sms = "Dear ".substr($emp_name_list[$row1['emp_id']], 0, 29)." i, A Grievance from ".mysqli_real_escape_string($conn,strip_tags(substr($_POST['person_name'], 0, 29))).",Mobile No.".mysqli_real_escape_string($conn,strip_tags(substr($_POST['mobile'], 0, 29)))." ,".substr($complaintType, 0, 30)."  with Ref No ".$grievance_id."  was alloted to you on ".date('d-m-Y H:i:s')." Regards - CFC,  AMCORP";
					$sms = "Dear ".substr($emp_name_list[$row1['emp_id']], 0, 29).", A Grievance from ".mysqli_real_escape_string($conn,strip_tags(substr($_POST['person_name'], 0, 29))).", Mobile No. ".mysqli_real_escape_string($conn,strip_tags(substr($_POST['mobile'], 0, 29))).", ".substr($complaintType, 0, 30)." with Ref No ".$grievance_id."is allotted to you on ".date('d-m-Y H:i:s')." https://aurangabadmahapalika.org/grievance/ Regards- CitizenServiceMonitoringCell ,NMCGOV";
					
					$mobile=$emp_mobile_list[$row1['emp_id']];
				    $templateId = "1707167653152348289";
													
				    $message =str_replace ( ' ', '%20', $sms);
					
					$result=sendSMS($mobile,$sms,$templateId);
					
				     /*$url ="http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
				    //require_once('aurangabad_sms_config.php');
				    $post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post); //result from mobile seva server */
					
					$sql ="insert into sms_response_logs(
					grievance_id,
					mobile,
					sms_content,
					response_content,
					datetime
					)values(
					'".$grievance_id."',
					'".$mobile."',
					'".$message."',
					".$result.",
					'".date('Y-m-d H:i:s')."'
					)"; 
					mysqli_query($conn,$sql);
        		}
				
				
        		
		
                //	$sms2 = "Dear ".$_POST['person_name']." , Your Complaint regarding with Ref No : ".$grievance_id." was alloted to ".$emp_name_list[$row1['emp_id']]." (".$mobile.") on ".$today." Regards - Citizen Service Monitoring Cell , ".$ulb_info['ulbname']." " ;	
		
		        //$mobile=$emp_mobile_list[$row1['emp_id']];
					 
                //$sms1="Drst ".$_POST['person_name']." ,Your Service registered ref no ".$grievance_id.", regarding ".$_POST['comp_subject'].",".$_POST['comp_desc'].",";
					  
		        if($old_complaint_check_id != 1){
		            //$sms1 = "Dear ".$_POST['person_name']." , Your ".$aaa." regarding ".$subject." with ref no ".$grievance_id." Status is under progress ,under progress Regards - Citizen Service Monitoring Cell , ".$ulb_info['ulbname'];			  
					//$sms1="Dear ".$_POST['person_name'].", Your Grievance  regarding ".$complaintType." with Ref No ".$grievance_id." was alloted to ".$emp_name_list[$row1['emp_id']]." on ".date('d-m-Y H:i:s')." Will be completed on ".$cutoffdate." Regards - CFC,  AMCORP";
					
				// 	$sms1="Dear ".substr($_POST['person_name'], 0, 29).", Your Grievance regarding ".substr($complaintType, 0, 29)." with Ref No ".$grievance_id." was alloted to ".substr($emp_name_list[$row1['emp_id']], 0, 29)." on ".date('d-m-Y H:i:s')." is in process. Regards - Citizen Service Monitoring Cell ,AMCORP";
					$sms1= "Dear ".substr($_POST['person_name'], 0, 29).", Your Grievance regarding ".substr($complaintType, 0, 29)." with Ref No ".$grievance_id." was allotted to".substr($emp_name_list[$row1['emp_id']], 0, 29)." on".date('d-m-Y H:i:s')." isinprocess.Regards - Citizen Service Monitoring Cell ,NMCGOV";
				    // $sms1 = "Dear ".substr($_POST['person_name'], 0, 29).", Your Grievance regarding  ".substr($complaintType, 0, 29)." with Ref No ".$grievance_id." was allotted to ".substr($emp_name_list[$row1['emp_id']], 0, 29)." on".date('d-m-Y H:i:s')." isinprocess. Regards - Citizen Service Monitoring Cell , NMCGOV";
					$templateId ="1707167653141568094";
                    $mobile=$_POST['mobile'];
                    $result=sendSMS($sms1,$mobile1,$templateid);
					
					/* $message =str_replace ( ' ', '%20', $sms1);
				    $url ="http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
				    //require_once('aurangabad_sms_config.php');
				    $post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post); */
					
					$sql ="insert into sms_response_logs(
					grievance_id,
					mobile,
					sms_content,
					response_content,
					datetime
					)values(
					'".$grievance_id."',
					'".$mobile."',
					'".$message."',
					".$result.",
					'".date('Y-m-d H:i:s')."'
					)"; 
					mysqli_query($conn,$sql);
					
		        }
				
									
					
					
					
					$grievance_status_id_inserted=2;
					$sql2="update grievances set grievance_status_id=2 where grievance_id=".$grievance_id2;
					mysqli_query($conn,$sql2);
					
					 if($_POST['email']<>'')
					{
						$myname="Grievance Cell - ".$ulb_info['ulb_name']." ".$ulb_info['ulb_type_desc'];
						$myemail=$ulb_info['myemail'];
	
						require_once('email_conf.php');
	
						$subject="Your Service registered with ".$ulb_info['ulb_name']." ".$ulb_info['ulb_type_desc'];;
		
					       $message="Dear ".$_POST['person_name'].",\n\nYour Service  regarding ".mysqli_real_escape_string($conn,htmlspecialchars($_POST['comp_subject']))." with Ref No : ".$grievance_id." was alloted to ".$emp_name_list[$row1['emp_id']]." on ".date('d-m-Y',strtotime($today)).". You can check the status of the Service any time by using the link ".$ulb_info['url']."/view_comp_det.php?grievance_id=".$grievance_id."\n\nRegards,\n\n Grievance Redressal Team,\n".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];
										
					}
				
				
				
				
				}
			
		 
		 	}else{
		 	
		 	 $sql ="select pending_for_approval from dashboard_count where app_type_id='".mysqli_real_escape_string($conn,strip_tags($_POST['app_type_id']))."' and ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $pending_for_approval=$rows['pending_for_approval']+1;
				    
				   $sql ="update dashboard_count set pending_for_approval='".$pending_for_approval."' where app_type_id='".mysqli_real_escape_string($conn,strip_tags($_POST['app_type_id']))."' and ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
				    mysqli_query($conn,$sql);
				    
				    
			$sql1 = "select comp_cat from cs_mst where cs_id = '".mysqli_real_escape_string($conn,strip_tags($_POST['cs_id']))."'" ;
			$rs1 = mysqli_query($conn,$sql1);
			$rows1 = mysqli_fetch_assoc($rs1);
			$field_name = $rows1['comp_cat'];
			
			
			$sql21 = "select (".$field_name.") as pending_apprvl from complaints_cat_count where ulbid = '".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' and status = '2' " ;
			$rs21 = mysqli_query($conn,$sql21);
			$rows2 = mysqli_fetch_assoc($rs21);
			$pending_apprvl = $rows2['pending_apprvl']+1;
			
			$qry = "update complaints_cat_count set ".$field_name." = ".$pending_apprvl." where ulbid = '".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' and status = '2' " ;
			$res = mysqli_query($conn,$qry);	    
				    
				    
				  
				    
				    
		 	
				if($_POST['email']<>'')
				{
					$myname="Grievance Cell - ".$ulb_info['ulbname'];
					$myemail=$ulb_info['myemail'];

					require_once('email_conf.php');

					$subject="Your Service registered with ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];
	
					$message="Dear ".$_POST['person_name'].",\n\nThank you for using online Grievance Redressal system of ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc']." Your Service Regarding ".mysqli_real_escape_string($conn,htmlspecialchars($_POST['comp_desc']))." has been successfully registered with us.\n\n Reference number is ".$grievance_id.".\n\n You may use this Reference number for future communications with us. You can check the status of the Service any time by using the link ".$ulb_info['url']."/view_comp_det.php?grievance_id=".$grievance_id.".\n\nRegards,\n\nGrievance Redressal Team,\n".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];
									
					//mail("\"".$_POST['person_name']."\" <".$_POST['email'].">", $subject, stripslashes($message), $headers, "-f$myemail");
				}
				
				if($_SESSION['ulbid']==207)
					{
					$grievance_id=$file_no;
					}
					
					
					
					
					 $sql ="select * from standard_services";
					 $rs = mysqli_query($conn,$sql);
					 while($row = mysqli_fetch_assoc($rs))
					 {
					     $standar_service_ist[$row['cs_id']]=$row['cs_desc'];
					 }
					 
					  if($_POST['app_type_id']==1)
					 {
					     $aaa="complaint";
					     $subject=$_POST['comp_subject'];
					 }
					 else
					 {
					     $aaa="service";
					     $subject=$standar_service_ist[$_POST['cs_id']];
					 }
				
				//$sms="Dear ".$_POST['person_name'].", Thank you for using online Grievance Redressal system. Your ".$aaa." has been successfully registered with reference number : ".$grievance_id.". regarding ".$subject.",".$_POST['comp_desc'].", Regards - ".$ulb_info['ulbname'];

				//$sms1="Dear ".$admin_name.", A ".$aaa." was registered by ".mysqli_real_escape_string($conn,strip_tags($_POST['person_name'])).", ".mysqli_real_escape_string($conn,strip_tags($_POST['hno'])).",".$ward_list[$_POST['ward_id']].",".mysqli_real_escape_string($conn,strip_tags($_POST['address'])).",Mobile No.".mysqli_real_escape_string($conn,strip_tags($_POST['mobile'])).", regarding ".$subject.", through ".$grievance_origin_list[$_POST['grievance_origin_id']]." with reference number : ".$grievance_id.". Regards - ".$ulb_info['ulbname'];	
				$sms = "Dear ".substr($_POST['person_name'], 0, 29).", Mobile No.".$_POST['mobile']." regarding ".substr($_POST['comp_desc'], 0, 29)." with RefNo ".$grievance_id." Is Submitted Successfully on ".date('d-m-Y H:i:s')." Regards - CFC ,  AMCORP";
				
				
				$mobile=$_POST['mobile'];
				$templateId = "1707164421987037010";
				$result=sendSMS($mobile,$sms,$templateId);
				
				/*
				$message =str_replace ( ' ', '%20', $sms);
				$url ="http://smsatm.net/v3/api.php?username=nmcgov&apikey=fe4ba54cf34bec238813&senderid=NMCGov&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
				//require_once('aurangabad_sms_config.php');
				$post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post); //result from mobile seva server
					*/
					
				$sql ="insert into sms_response_logs(
					grievance_id,
					mobile,
					sms_content,
					response_content,
					datetime
					)values(
					'".$grievance_id."',
					'".$mobile."',
					'".$message."',
					".$result.",
					'".date('Y-m-d H:i:s')."'
					)"; 
					mysqli_query($conn,$sql);
				//send_sms_new($sms,$mobile,$templateId);
				require_once('send_sms.php');
				
				/*if($old_complaint_check_id != 1){
				    $templateId = "1207161725758515114";
    				send_sms($sms,$mobile,$templateId);
    				//$templateId = "1207161725766387125";
    				//send_sms($sms1,$admin_mobile,$templateId);
				}*/
				
				
				
				
				
			 }
			 
			 
			 
			
			 
			 	
			 $sql ="select received from dashboard_count where app_type_id='".mysqli_real_escape_string($conn,strip_tags($_POST['app_type_id']))."' and ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $received=$rows['received']+1;
				    
				    $sql ="update dashboard_count set received='".$received."' where app_type_id='".mysqli_real_escape_string($conn,strip_tags($_POST['app_type_id']))."' and ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
				    mysqli_query($conn,$sql);
				    
			
			
			/**** complaints received *******/
				    
				
			$sql1 = "select comp_cat from cs_mst where cs_id = '".mysqli_real_escape_string($conn,strip_tags($_POST['cs_id']))."'" ;
			$rs1 = mysqli_query($conn,$sql1);
			$rows1 = mysqli_fetch_assoc($rs1);
			$field_name = $rows1['comp_cat'];
			
			
			$sql21 = "select (".$field_name.") as received from complaints_cat_count where ulbid = '".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' and status = '1' " ;
			$rs21 = mysqli_query($conn,$sql21);
			$rows2 = mysqli_fetch_assoc($rs21);
			$received = $rows2['received']+1;
			
			$qry = "update complaints_cat_count set ".$field_name." = ".$received." where ulbid = '".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' and status = '1' " ;
			$res = mysqli_query($conn,$qry);
				    
				    
			
				    
				    
				    
				    
				    
			 
			 
			 if($_SESSION['ulbid']==207)
			 {
			 	
			//	echo "<script>window.location='receive_print_boduppal.php?gid=".$grievance_id2."&aptid=".mysqli_real_escape_string($conn,strip_tags($_POST['app_type_id']))."';</script>";
			 	
			 }
			 else 
			 {
			    
			
			//	echo "<script>window.location='receive_print.php?gid=".$grievance_id2."&aptid=".mysqli_real_escape_string($conn,strip_tags($_POST['app_type_id']))."';</script>";
			     
				
			}
			 
			//header('location:receive_print.php');
			
			
		
			
			
			
			
			
			 
			 

		}
		else
		{
			$tpl->assign('msg','alert alert-danger display-hide');
			$msg="Uable to insert   ".mysqli_error($conn);
			}
			
			$tpl->assign('msg',$msg);
		}
		
		}

		


		$sql="select cat_id,description  from category_mst where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."' order by description ";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cat_list[$row['cat_id']]=$row['description'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));

		$sql="select sub_cat_id,cat_id,description  from subcategory_mst where status='1' order by description ";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$sub_cat_list[$row['sub_cat_id']]=$row['description'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
			$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".mysqli_real_escape_string($conn,strip_tags($_SESSION['ulbid']))."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
	//	print_r($online_applications);
	
	  $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	
	    $tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
			
			
			
		$app_type_list = array('1'=>'Complaint','2'=>'Service');
		
		//echo "<pre>";print_r($app_type_list);echo "</pre>";die();
			
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('sub_cat_list',$sub_cat_list);
		mysqli_close($conn);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);
		$tpl->assign('ulbid',$_SESSION['ulbid']);			
		$tpl->assign('app_type_list',$app_type_list);		
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);
		$tpl->assign('street_list',$street_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
				
		$tpl->display('register_comp_helpline_newtest.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		echo "<script>window.location='index.php';</script>";
	}
		
?>