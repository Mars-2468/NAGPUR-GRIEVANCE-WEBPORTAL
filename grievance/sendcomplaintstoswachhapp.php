<?php
    
	
	    
	    include('user_defined_functions.php');
		
		require_once('connection.php');
	    $conn=getconnection();
	    
	        
	        $sql ="SELECT * FROM `ulbmst` WHERE ulbid LIKE '258'";
	        $rs = mysqli_query($conn,$sql);
	        $row = mysqli_fetch_assoc($rs);
	        
	        $apiUlbName = $row['api_ulbname'];
	        $accessKey = $row['access_key'];
	        $categoryId = $row['swapp_cat_id'];
	        $complaintLatitude = $row['lat'];
	        $complaintLongitude = $row['lng'];
	        
	        $complaintLocation = $row['address'];
	        
	        $sql ="SELECT * FROM `grievances` WHERE `ulbid` LIKE '258' and narsingSwachhStatus = '0' ORDER BY grievance_id LIMIT 1";
	        $rs = mysqli_query($conn,$sql);
	        while($row1 = mysqli_fetch_assoc($rs))
	        {
	        
	        $sql ="SELECT g.*,c.swapp_cat_id FROM `grievances` g,cs_mst c WHERE g.cat3_id=c.cs_id and `cat3_id` IN (22,25,31,33,71,72,73,74) and date(date_regd) >= '2021-03-20' and date(date_regd) <= '2021-03-21' order by rand() limit 1";
	        $rs2 = mysqli_query($conn,$sql);
	        while($row = mysqli_fetch_assoc($rs2))
	        {
	            
	            
	        
	                $ch = curl_init();
                    $data = array(
                        'vendor_name' => $apiUlbName, 
                        'access_key' => $accessKey,
                        'mobileNumber'=>$row1['mobile'],
                        'categoryId'=>$row['swapp_cat_id'],
                        'complaintLatitude'=>$complaintLatitude,
                        'complaintLongitude'=>$complaintLongitude,
                        'complaintLocation'=>$row1['address'],
                        'complaintLandmark'=>trim($row1['address']),
                        'fullName'=>$row1['person_name'],
                        'userLatitude'=>$complaintLatitude,
                        'userLongitude'=>$complaintLongitude,
                        'userLocation'=>trim($row1['address']),
                        'deviceOs'=>'external',
                        'file'=>$row['file_url'],
                        'complaintPostedDate'=>$row['date_regd']);
                        
                        
                        
                        
                        
                         $sql ="insert into NarsingSwachhGrievances(
                            grievance_id,
                            vendor_name,
                            access_key,
                            mobileNumber,
                            categoryId,
                            cat3_id,
                            complaintLatitude,
                            complaintLongitude,
                            complaintLocation,
                            complaintLandmark,
                            fullName,
                            userLatitude,
                            userLongitude,
                            userLocation,
                            deviceOs,
                            file,
                            complaintPostedDate
                            )value(
                                '".$row['grievance_id']."',
                                '".$apiUlbName."',
                                '".$accessKey."',
                                '".$row1['mobile']."',
                                '".$row['swapp_cat_id']."',
                                '".$row['cat3_id']."',
                                '".$complaintLatitude."',
                                '".$complaintLongitude."',
                                '".$row1['address']."',
                                '".$row1['address']."',
                                '".$row1['person_name']."',
                                '".$complaintLatitude."',
                                '".$complaintLongitude."',
                                '".trim($row1['address'])."',
                                'external',
                                '".$row['file_url']."',
                                '".$row['date_regd']."'
                                )";
                                
                                //mysqli_query($conn,$sql);
                                //$sql ="update grievances set  narsingSwachhStatus ='1' where grievance_id='".$row1['grievance_id']."'";
                                //mysqli_query($conn,$sql);
                                
                        
                         
                       
                        
                        
                        curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/sbm/v1/post-complaint');
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true); // required as of PHP 5.6.0
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        //$output=curl_exec($ch);
                        
                        print_r($output);
                        $arr=json_decode($output,TRUE);
                        
                        $generic_id=$arr['complaint']['generic_id'];
                        $newarray=explode('C',$arr['complaint']['generic_id']);
                        $complaint_id=$newarray[1];
                        
                        
                        
                        $arr['httpCode']=201;
                        $row['grievance_id']=460086;
                        $complaint_id = "24893538";
                        
                        
                    if($arr['httpCode'] =='201' || $arr['httpCode'] =='200')
                    {
                         $sql ="update grievances set narsingSwachhStatus ='1' where grievance_id='".$row['grievance_id']."'";
                         if(mysqli_query($conn,$sql))
                         {
                          //$sql ="update NarsingSwachhGrievances set RegHttpCode='".$arr['httpCode']."',RegCode='".$arr['httpCode']."',RegGenericId='".$generic_id."' where grievance_id='".$row['grievance_id']."'";
	                      //mysqli_query($conn,$sql);
	    
	                       $remarks ="Assigned to employee";
	                       $status_id=3;
			    
                			    if($status_id==3)
                			    {
                			        
                			       
                			        
                			        $ch = curl_init();
                                    $data = array(
                                        'statusId'=>3,
                                        'complaintId'=>$complaint_id,
                                        'commentDescription'=>$remarks,
                                        'deviceOs'=>'external',
                                        'vendor_name' => $apiUlbName,
                                        'access_key' => $accessKey,
                                        'apiKey'=>'af4e61d75d2782a33eac7641e42bba6f'
                                        );
                                        
                                        print_r($data);
                                        
                                        
                                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/engineer/v1/complaint-status-update');
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                                    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $output=curl_exec($ch);
                                    
                                    print_r($output);
                                    
                                    $arr=json_decode($output,TRUE);
                                    print_r($arr);
                                    $sql ="update NarsingSwachhGrievances set UpdateHttpCode='".$arr['httpCode']."',UpdateCode='".$arr['code']."',ComplaintId='".$arr['complaint']['id']."' where grievance_id='".$row['grievance_id']."'";
                                    mysqli_query($conn,$sql);
                                    
                                    
                                    if($arr['httpCode']==200 && $arr['code']==2000)
                                        {
                                            
                                            //$sql="insert into swatchata_comp_status_map(generic_id,status_id,complaint_id)values('".$generic_id."','".$status_id."','".$arr['complaint']['id']."')";
                                            //mysqli_query($conn,$sql);
                                            /*$sql ="update grievances set swatchta_app_status='".$status_id."' where grievance_id='".$grievance_id."'";
                                            mysqli_query($conn,$sql);*/
                                            echo 1;
                                        }
                                        else
                                        {
                                            echo 0;
                                        }
                			    
                			    
                			    }
                         }
                    }
	        }
			    
				    
	        }
		
		
	       
	      
	
?>