<?php
require "config.php";
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors',0);

	
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	  //  session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();	
		function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

			    $dates = array();
			    $current = strtotime($first);
			    $last = strtotime($last);
			
			    while( $current <= $last ) 
			    {
			
			        $dates[] = date($output_format, $current);
			        $current = strtotime($step, $current);
			    }
			
			    return $dates;
			}	

		$sql="select emp_id,emp_name,emp_dept,emp_desg,emp_mobile from emp_mst where ulbid='".$_SESSION['ulbid']."' and delete_status='0' and emp_status='0'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
			{
				$emp_list[$row['emp_id']]['emp_name']=$row['emp_name'];
				$emp_list[$row['emp_id']]['emp_dept']=$row['emp_dept'];
				$emp_list[$row['emp_id']]['emp_desg']=$row['emp_desg'];
				$emp_list[$row['emp_id']]['emp_mobile']=$row['emp_mobile'];
			}
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));

		 
		 
			
			


		
		if(isset($_POST['grievance_id_sel']))
		{
		    $sql ="select person_name,mobile,address,mcat3_id from grievances where grievance_id='".$_POST['grievance_id_sel']."'";
		    $rs = mysqli_query($conn,$sql);
		    $row = mysqli_fetch_assoc($rs);
		    $user_mobile=$row['mobile'];
		    $username=$row['person_name'];
		    $useraddress=$row['address'];
		    $mcat3_id=$row['mcat3_id'];
		    $mobile1=$row['mobile'];
		    
		    
		    $sql ="select u.ulbname,u.api_ulbname,g.app_type_id,c.swatchta_app_status_yn,c.swapp_cat_id,g.generic_id from ulbmst u, grievances g,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_id='".$_POST['grievance_id_sel']."'";
		    $rs =mysqli_query($conn,$sql);
		    $row = mysqli_fetch_assoc($rs);
		    $vendor_name=$row['api_ulbname'];
		    $app_type_id1=$row['app_type_id'];
		    $swatchta_app_status_yn=$row['swatchta_app_status_yn'];
		    $swapp_cat_id=$row['swapp_cat_id'];
		    $generic_id=$row['generic_id'];
		   	// $complaint_id=substr($row['generic_id'],-7);
		    $newarray=explode('C',$row['generic_id']);
            
            $complaint_id=$newarray[1];
		    
		    
		    
		    
			$grievance_id_sel=$_POST['grievance_id_sel'];
			
			$curtime = date('H:i:s');
			
			$_POST['alloted_date']=$_POST['alloted_date']." ".$curtime;
			
			/*********************************************************************** if complaint status is reopened ****/
			
			if($_POST['status_sel']=='13')
			{
			    $status_grvns=11;
			    $sql ="select MAX(transaction_id) as trnsid from grievances_transactions where grievance_id='".$_POST['grievance_id_sel']."'";
			    $rs = mysqli_query($conn,$sql);
			    $row = mysqli_fetch_assoc($rs);
			    $trnsid=$row['trnsid']+1;
			    $sql="insert into grievances_transactions(grievance_id,transaction_id,emp_id,alloted_date,disposal_status,dept_id) values(".$_POST['grievance_id_sel'].",'".$trnsid."',".$_POST['emp_id'].",'".date('Y-m-d H:i:s',strtotime($_POST['alloted_date']))."',11,'".$_POST['emp_dept']."')";	
			    
			}/***************** end *******************/
			else
			{
			$status_grvns=2;
		   $sql="insert into grievances_transactions(grievance_id,transaction_id,emp_id,alloted_date,disposal_status,dept_id) values(".$_POST['grievance_id_sel'].",1,'".$_POST['emp_id']."','".date('Y-m-d H:i:s',strtotime($_POST['alloted_date']))."',2,'".$_POST['emp_dept']."')";	
			  
			} 
			
			  
			if(mysqli_query($conn,$sql))
			{
			    $sql ="insert into reopen_transactions(grievance_id,sub_option_id,comment_desc) values('".$_POST['grievance_id_sel']."','11','')";
	            mysqli_query($conn,$sql);
	            $sql ="update rating_mst set resolved_id='11' where grievance_id='".$_POST['grievance_id_sel']."'";
	            mysqli_query($conn,$sql);
			   
			   //Start of status update in response time report tables
			   
			   	$sql="SELECT grievance_id,ulbid,cat3_id,grievance_status_id,app_type_id FROM `grievances` g where grievance_id=".$_POST['grievance_id_sel'];
	                	    	//	echo $sql;exit;
	                	    	$rs=mysqli_query($conn,$sql);
	                	    	$row=mysqli_fetch_assoc($rs);
	                	    	 if($row['app_type_id']==1)
	                	  {
	                	    	
                            $sql = "UPDATE `complaints_map_info` SET  `status_id`=2 where grievance_id=".$_POST['grievance_id_sel'];
                            mysqli_query($conn,$sql);
                            
	                	  }else if($row['app_type_id']==2)
	                	  {
	                	       $sql = "UPDATE `services_map_info` SET  `status_id`=2 where grievance_id=".$_POST['grievance_id_sel'];
                               mysqli_query($conn,$sql);
	                	      
	                	  }
			   
			     //End of status update in response time report tables
					 

			    
				$tpl->assign('class','alert alert-success display-hide');
				$msg="Updated Successfully";
				
				// calling api
				
				if($app_type_id1=='1')
				{
				    
				    if($swatchta_app_status_yn=='1')
				    {
				    
				
				
				    $ch = curl_init();
                    $array = array(
                        'statusId'=>'3',
                        'complaintId'=>$complaint_id,
                        'commentDescription'=>'Assigned to engineer',
                        'deviceOs'=>'external',
                        'vendor_name' => $vendor_name,
                        'access_key' => $_SESSION['access_key'],
                        'apiKey'=>'af4e61d75d2782a33eac7641e42bba6f'
                        );
                        
                        
                    curl_setopt($ch, CURLOPT_URL, 'http://api.swachh.city/engineer/v1/complaint-status-update');
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
                    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                   // $output=curl_exec($ch);
                    
                    
                    
                    $arr=json_decode($output,TRUE);
                    
                    //print_r($arr);
                    
                    
                    
                                 $sql ="update grievances_transactions set http_code='".$arr['httpCode']."',code='".$arr['code']."',id='".$arr['complaint']['id']."' where grievance_id='".$_POST['grievance_id_sel']."'";
                                    mysqli_query($conn,$sql);
                                    
                                if($arr['httpCode']==200 && $arr['code']==2000)
                                {
                                    
                                    $sql="insert into swatchata_comp_status_map(generic_id,status_id,complaint_id)values('".$generic_id."','3','".$arr['complaint']['id']."')";
                                    mysqli_query($conn,$sql);
                                    $sql ="update grievances set swatchta_app_status='3' where grievance_id='".$_POST['grievance_id_sel']."'";
                                    mysqli_query($conn,$sql);
                                }
                    
				    }
				
				}
				
				
				
				
				
				
				
				
				
				
				
				
		/******************** updating cut off time ********/
		$sql ="select date from public_holydays where ulbid='".$_SESSION['ulbid']."'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		$holiday_list[$row['date']]=$row['date'];
		}
		$hdays=0;
		
		if($_POST['app_type_id']=='1')
		{
		    $sql ="select c.cutt_off_time as cutt_of_time from comp_cutofdays_map c,grievances g where g.cat3_id=c.cs_id and g.grievance_id='".$_POST['grievance_id_sel']."'";
		}
		else
		{
		    $sql ="select c.cutt_off_time as cutt_of_time from standard_services c,grievances g where g.mcat3_id=c.cs_id and g.grievance_id='".$_POST['grievance_id_sel']."'";
		}
				
		//$sql ="select c.cutt_of_time from category3_mst c ,grievances g where g.cat3_id=c.cs_id and g.grievance_id='".$_POST['grievance_id_sel']."'";
		$rs = mysqli_query($conn,$sql);
		$emp_det=mysqli_fetch_assoc($rs);
		
		$date=date('Y-m-d');
		$date = strtotime("+".$emp_det['cutt_of_time']." days", strtotime($date));
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
		 $date=date("Y-m-d", $date);
		
		 $sql ="update grievances set cutt_of_time='".date('Y-m-d',strtotime($date))."' where grievance_id='".$_POST['grievance_id_sel']."'";
		mysqli_query($conn,$sql);
				
				
				/**/
				
				
			    
				
				if($_POST['app_type_id']==1)
				{
				    $string=" Complaint ";
				    $sql ="select cs_id , cs_desc as  comp_desc from cs_mst";
				        $rs = mysqli_query($conn,$sql);
                		while($row = mysqli_fetch_assoc($rs))
                		{
                		$cs_list[$row['cs_id']]=$row['comp_desc'];
                		}
                		$complaintType=$cs_list[$_POST['cs_id_sel']];
				    
				}
				else
				{
				    $string=" Service ";
				    $sql ="select cs_id,cs_desc as comp_desc from standard_services";
    						$rs = mysqli_query($conn,$sql);
    						while($row = mysqli_fetch_assoc($rs))
    						{
    						$cs_list[$row['cs_id']]=$row['comp_desc'];
    						}
    						
    						$complaintType=$cs_list[$mcat3_id];
    						
				}
				
				
				
				 $sql ="select ulb_type_desc,ulbname from ulb_type ut,ulbmst u where ut.ulb_type_id=u.ulb_type and u.ulbid='".$_SESSION['ulbid']."'";
				$rs = mysqli_query($conn,$sql);
				$ulb_info= mysqli_fetch_assoc($rs);
				
				require_once('send_sms.php');
				
				/*$sms="Dear ".$emp_list[$_POST['emp_id']]['emp_name'].", A ".$string." from ".$username.", Mobile No.".$user_mobile.", ".$useraddress." regarding ".$subject." with Ref No : ".$_POST['grievance_id_sel']." was alloted to you on ".date('d-m-Y H:i:s',strtotime($_POST['alloted_date']))." Regards - Citizen Service Monitoring Cell , ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];
				$mobile=$emp_list[$_POST['emp_id']]['emp_mobile'];*/
				
				/*$sms1="Dear ".$username.", Your ".$string."  regarding ".$subject." with Ref No : ".$_POST['grievance_id_sel']." was alloted to ".$emp_list[$_POST['emp_id']]['emp_name']." on ".date('d-m-Y H:i:s',strtotime($_POST['alloted_date']));
				$sms1.=" Will be completed on ".date('d-m-Y',strtotime($date));
				$sms1.=" Regards - Citizen Service Monitoring Cell , ".$ulb_info['ulbname']." ".$ulb_info['ulb_type_desc'];*/
				
				/*** sending sms to Employee ****/
				
				    $sms ="Dear ".$emp_list[$_POST['emp_id']]['emp_name']." i, A Grievance from ".mysqli_real_escape_string($conn,strip_tags($username)).",Mobile No.".mysqli_real_escape_string($conn,strip_tags($user_mobile))." ,".$complaintType."  with Ref No ".$_POST['grievance_id_sel']."  was alloted to you on ".date('d-m-Y H:i:s',strtotime($_POST['alloted_date']))." Regards - CFC,  AMCORP";
					$mobile=$emp_list[$_POST['emp_id']]['emp_mobile'];
				    $templateId = "1707164421995512795";
				    $message =str_replace ( ' ', '%20', $sms);
				    $url ="http://smsatm.net/v3/api.php?username=ASCDCL&apikey=c01f32640f54e44f7660&senderid=AMCGOV&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
				    //require_once('aurangabad_sms_config.php');
				    $post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post);
				
				/** closed ***/
				
				/** sending sms to user **/
				
				$sms1="Dear ".$username.", Your Grievance  regarding ".$complaintType." with Ref No ".$_POST['grievance_id_sel']." was alloted to ".$emp_list[$_POST['emp_id']]['emp_name']." on ".date('d-m-Y H:i:s',strtotime($_POST['alloted_date']))." Will be completed on ".date('d-m-Y',strtotime($date))." Regards - CFC,  AMCORP";
					$templateId ="1707164422005193911";
                    $mobile=$mobile1;
                    //send_sms($sms1,$mobile1,$templateid);
					
					$message =str_replace ( ' ', '%20', $sms1);
				    $url ="http://smsatm.net/v3/api.php?username=ASCDCL&apikey=c01f32640f54e44f7660&senderid=AMCGOV&templateid=".$templateId."&mobile=".$mobile."&message=".$message;
				    //require_once('aurangabad_sms_config.php');
				    $post = curl_init();
                    curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($post, CURLOPT_URL, $url);
                    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                    $result=curl_exec($post);
				
				/** closed ***/
								
				//$templateId ="1207161725772623021";
				//send_sms($sms,$mobile,$templateId);
				
				//$templateId ="1207161725775761437";
				//send_sms($sms1,$mobile1,$templateId);

				if($data[$_POST['grievance_id_sel']]['email']<>'')
				{
					$myname="Grievance Cell - ".$ulb_info['ulb_name'];
					$myemail=$ulb_info['myemail'];

					require_once('email_conf.php');
					$subject="Your Service Status Update";
	
					$message="Dear ".$data[$_POST['grievance_id_sel']]['person_name'].",\n\nYour Service  regarding ".$data[$_POST['grievance_id_sel']]['comp_subject']." with Ref No : ".$_POST['grievance_id_sel']." was alloted to ".$emp_list[$_POST['emp_id']]['emp_name']." on ".$_POST['alloted_date'].". You can check the status of the Service any time by using the link http://egoveindia.in/CSMS/ Regards,\n\nCitizen Service Redressal Team,\n".$ulb_info['ulbname'];
									
					//mail("\"".$data[$_POST['grievance_id_sel']]['person_name']."\" <".$data[$_POST['grievance_id_sel']]['email'].">", $subject, stripslashes($message), $headers, "-f$myemail");
				}
				 $sql1="update grievances set grievance_status_id='".$status_grvns."' where grievance_id=".$_POST['grievance_id_sel'];
				if(mysqli_query($conn,$sql1))
				{
				    
				//printf("<script>location.href='view_comp_det_admin.php?grievance_id=".$_POST['grievance_id_sel']."'</script>");
				}
				
				
				
				
				
				
				
				 if($_POST['app_type_id']=='1')
				{
			    $sql="select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(alloted_date,date_regd) AS target,gt.disposal_status,
				  ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and 
				  g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('2')  and gt.disposal_status !=5 and 
				  g.grievance_id='".$_POST['grievance_id_sel']."'";
				}
				else
				{
				  $sql="select g.grievance_id,app_type_id,date_regd,disposed_date,c.cutt_of_time+holidays_added as target_days,
				  DATEDIFF(alloted_date,date_regd) AS target,gt.disposal_status from grievances g , grievances_transactions gt,category3_mst c,ulbmst u 
				  where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN('2')  and 
				  gt.disposal_status !=5 and g.grievance_id='".$_POST['grievance_id_sel']."'";
				}
				
			//	echo $sql;
			$rs=mysqli_query($conn,$sql);
			//print_r($rs);
			$kk=mysqli_fetch_assoc($rs);
			//print_r($kk);
			$target=$kk['target'];
			$target_days=$kk['target_days'];
				 
				
				// echo $target."<".$target_days;
				 
				 if($target <= $target_days)
					 {
					     
					      // updating sla status in grievance
				    
				    $sql ="update  grievances set sla_status='1' where grievance_id='".$_POST['grievance_id_sel']."'";
				    mysqli_query($conn,$sql);
				    
				    
				    
				    // end
					     
					$sql ="select pending_for_approval,under_progress_sla from dashboard_count where app_type_id='".$_POST['app_type_id']."' and ulbid='".$_SESSION['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $pending_for_approval=$rows['pending_for_approval']-1;
				    
				    $under_progress_sla=$rows['under_progress_sla']+1;
				    
				    if($pending_for_approval <= 0)
				    {
				        $pending_for_approval=0;
				    }
				     if($under_progress_sla <= 0)
				    {
				        $under_progress_sla=0;
				    }
				    
				    
				  $sql ="update dashboard_count set pending_for_approval='".$pending_for_approval."',under_progress_sla='".$under_progress_sla."' where app_type_id='".$_POST['app_type_id']."' and ulbid='".$_SESSION['ulbid']."'";
				    mysqli_query($conn,$sql);
				    
				    
				    
				    /**** complaints categories ****/
				    
				    $sql2 = "select cat3_id from grievances where grievance_id = '".$_POST['grievance_id_sel']."'" ;
				    $rs2 = mysqli_query($conn,$sql2);
				    $rows = mysqli_fetch_assoc($rs2);
				    $cat_id = $rows['cat3_id'];
				    
                            				    
				    
				    
				    
				    	$sql1 = "select comp_cat from cs_mst where cs_id = '".$cat_id."'" ;
            			$rs1 = mysqli_query($conn,$sql1);
            			$rows1 = mysqli_fetch_assoc($rs1);
            			$field_name = $rows1['comp_cat'];
            			
            			
            			$sql21 = "select (".$field_name.") as pending_apprvl from complaints_cat_count where ulbid = '".$_SESSION['ulbid']."' and status = '2' " ;
            			$rs21 = mysqli_query($conn,$sql21);
            			$rows2 = mysqli_fetch_assoc($rs21);
            			$pending_apprvl = $rows2['pending_apprvl']-1;
            			
            			    if($pending_apprvl <= 0)
        				    {
        				        $pending_apprvl=0;
        				    }
            			
            			
            			
            			$sql211 = "select (".$field_name.") as under_progres_sla from complaints_cat_count where ulbid = '".$_SESSION['ulbid']."' and status = '5' " ;
            			$rs211 = mysqli_query($conn,$sql211);
            			$rows21 = mysqli_fetch_assoc($rs211);
            			$under_progres_sla = $rows21['under_progres_sla']+1;
            			
            			    if($under_progres_sla <= 0)
        				    {
        				        $under_progres_sla=0;
        				    }
            			
            			
            			
            			
            			$qry = "update complaints_cat_count set ".$field_name." = ".$pending_apprvl." where ulbid = '".$_SESSION['ulbid']."' and status = '2' " ;
            			$res = mysqli_query($conn,$qry);
				    
				        $qry1 = "update complaints_cat_count set ".$field_name." = ".$under_progres_sla." where ulbid = '".$_SESSION['ulbid']."' and status = '5' " ;
            			$res1 = mysqli_query($conn,$qry1);
				    
				    
					
					 }
					 else
					 {
					     
					      // updating sla status in grievance
				    
				    $sql ="update  grievances set sla_status='2' where grievance_id='".$_POST['grievance_id_sel']."'";
				    mysqli_query($conn,$sql);
				    
				    
				    
				    // end
					     
					$sql ="select pending_for_approval,under_pro_be_sla from dashboard_count where app_type_id='".$_POST['app_type_id']."' and ulbid='".$_SESSION['ulbid']."'";
				    $rs = mysqli_query($conn,$sql);
				    $rows = mysqli_fetch_assoc($rs);
				    $pending_for_approval=$rows['pending_for_approval']-1;
				    
				    $under_pro_be_sla=$rows['under_pro_be_sla']+1;
				    
				    
				    
				    if($pending_for_approval <= 0)
				    {
				        $pending_for_approval=0;
				    }
				     if($under_pro_be_sla <= 0)
				    {
				        $under_pro_be_sla=0;
				    }
				    
				    
				  $sql ="update dashboard_count set pending_for_approval='".$pending_for_approval."',under_pro_be_sla='".$under_pro_be_sla."' where app_type_id='".$_POST['app_type_id']."' and ulbid='".$_SESSION['ulbid']."'";
				  mysqli_query($conn,$sql);
				    
				    
				    
				    /**** commplaints categories ****/
				    
				    
				    $sql3 = "select cat3_id from grievances where grievance_id = '".$_POST['grievance_id_sel']."'" ;
				    $rs3 = mysqli_query($conn,$sql3);
				    $row3 = mysqli_fetch_assoc($rs3);
				    $cat3_id = $row3['cat3_id'];
				    
                            				    
				    
				    
				    
				    	$sql12 = "select comp_cat from cs_mst where cs_id = '".$cat3_id."'" ;
            			$rs12 = mysqli_query($conn,$sql12);
            			$rows12 = mysqli_fetch_assoc($rs12);
            			$field = $rows12['comp_cat'];
            			
            			
            			$sql21 = "select (".$field.") as pending_apprvl from complaints_cat_count where ulbid = '".$_SESSION['ulbid']."' and status = '2' " ;
            			$rs21 = mysqli_query($conn,$sql21);
            			$rows2 = mysqli_fetch_assoc($rs21);
            			$pending_apprvl = $rows2['pending_apprvl']-1;
            			
            			    if($pending_apprvl <= 0)
        				    {
        				        $pending_apprvl=0;
        				    }
            			
            			
            			
            			$sql211 = "select (".$field.") as under_progres_besla from complaints_cat_count where ulbid = '".$_SESSION['ulbid']."' and status = '6' " ;
            			$rs211 = mysqli_query($conn,$sql211);
            			$rows21 = mysqli_fetch_assoc($rs211);
            			$under_progres_besla = $rows21['under_progres_besla']+1;
            			
            			    if($under_progres_besla <= 0)
        				    {
        				        $under_progres_besla=0;
        				    }
            			
            			
            			
            			
            			$qry = "update complaints_cat_count set ".$field." = ".$pending_apprvl." where ulbid = '".$_SESSION['ulbid']."' and status = '2' " ;
            			$res = mysqli_query($conn,$qry);
				    
				        $qry1 = "update complaints_cat_count set ".$field." = ".$under_progres_besla." where ulbid = '".$_SESSION['ulbid']."' and status = '6' " ;
            			$res1 = mysqli_query($conn,$qry1);
            			
            			
            			echo "<script>alert('updated successfully'); window.location='view_pending_approval.php';</script>";
				    
				    
				    
				    
					 }
				
				
				
			
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				//echo mysqli_error($conn);
				$tpl->assign('msg',"failed to Update, Please try again");			
			}
			$tpl->assign('msg',$msg);
		}
		
		
		
		if($_REQUEST['app_type_id']==1 && $_SESSION['mc_yn']==1)
		 {
		  $sql="select grievance_id,app_type_id,cat3_id,grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,cat3_id,grievance_origin_id,grievance_status_id,date_regd,comp_desc from grievances where grievance_status_id IN('13') and ulbid='".$_SESSION['ulbid']."' and app_type_id='1' order by grievance_id desc"; 
		}
		else if($_REQUEST['app_type_id']==1 && $_SESSION['mc_yn']=='')
		{
		    $sql="select grievance_id,app_type_id,cat3_id,grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,cat3_id,grievance_origin_id,grievance_status_id,date_regd,comp_desc from grievances where grievance_status_id IN('1') and ulbid='".$_SESSION['ulbid']."' and app_type_id='1' order by grievance_id desc"; 
		}
		else if($_REQUEST['app_type_id']==2)
		 {
		  $sql="select grievance_id,app_type_id,cat3_id,grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,cat3_id,grievance_origin_id,grievance_status_id,date_regd,comp_desc from grievances where grievance_status_id IN('1','13') and ulbid='".$_SESSION['ulbid']."' and app_type_id='2' order by grievance_id desc"; 
		}else if($_SESSION['mc_yn']==1)
		{
		 $sql="select grievance_id,app_type_id,cat3_id,grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,cat3_id,grievance_origin_id,grievance_status_id,date_regd,comp_desc from grievances where grievance_status_id IN('13') and ulbid='".$_SESSION['ulbid']."' order by grievance_id desc";
		}
		else
		{
		    $sql="select grievance_id,app_type_id,cat3_id,mcat3_id,grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,cat3_id,grievance_origin_id,grievance_status_id,date_regd,comp_desc from grievances where grievance_status_id IN('1') and ulbid='".$_SESSION['ulbid']."' order by grievance_id desc";
		}
		
		
		
		if($rs=mysqli_query($conn,$sql))
		{
			$field_info = mysqli_fetch_fields($rs);
			while($row = mysqli_fetch_assoc($rs))
			{
			    $mcat3_id=$row['mcat3_id'];
				foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
			}
			
			$num_comp_to_approve=mysqli_num_rows($rs);
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
		


			
		$sql="select ward_id,ward_desc from ward_mst where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
			
		$sql="select street_id,street_desc from street_mst where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$street_list[$row['street_id']]=$row['street_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
			
		$sql="select dept_id,dept_desc from dept_mst where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	

		$sql="select desg_id,desg_desc from desg_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$desg_list[$row['desg_id']]=$row['desg_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));




		$sql="select grievance_origin_id,grievance_origin_desc from grievance_origin_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		}
		$grievance_origin_list[0]='Website';
			
			$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));

		if(isset($_POST['grievance_id']))
		{
			$grievance_id_sel=$_POST['grievance_id'];
			$tpl->assign('data1',$data[$grievance_id_sel]);
			$tpl->assign('grievance_id_sel',$grievance_id_sel);
		}	
		

		
			 $sql="select cs_id,cs_desc as comp_desc from cs_mst";
		
	//	$sql ="select * from category3_mst where ulbid='".$_SESSION['ulbid']."'";
	$sql ="select cs_id,cs_desc as comp_desc from standard_services";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $cat3_list[$row['cs_id']]=$row['comp_desc'];
		}
		
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		
		  $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	      $tpl->assign('users_count',$users_count);
	     
		mysqli_close($conn);
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('cat3_list',$cat3_list);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('data',$data);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('street_list',$street_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('grievance_origin_list',$grievance_origin_list);	
		$tpl->assign('num_comp_to_approve',$num_comp_to_approve);
		
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('view_pending_approval.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>