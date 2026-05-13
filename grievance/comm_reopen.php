<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']))
	{
	    
	    
	  //  session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
		
		
		if(isset($_POST['update']))
		{
		    
		    if(!empty($_POST['check_list']))
		    {
		        foreach($_POST['check_list'] as $val)
		        {
		            $generic_id="generic_id".$val;
		            $ulbid="ulbid".$val;
		            $imei_no="imei_no".$val;
		            $rating_no="rating_no".$val;
		            $sub_option_id="sub_option_id".$val;
		            $comment_desc="comment_desc".$val;
		            
		            /************ starting **********************/
		            
		            
		 $sql="insert into rating_mst(grievance_id,imei_no,rating_no,comment_desc,sub_option_id,resolved_id)values(?,?,?,?,?,?) ON DUPLICATE KEY UPDATE comment_desc=?,resolved_id=?";
    	
    	$generic_id=strip_tags($_REQUEST[$generic_id]);
    	$imei_no=strip_tags($_REQUEST[$imei_no]);
    	$rating_no=strip_tags($_REQUEST[$rating_no]);
    	$sub_option_id=strip_tags($_REQUEST[$sub_option_id]);
    	$comment_desc=mysqli_real_escape_string($conn,strip_tags($_REQUEST[$comment_desc]));
    	$query=$conn->prepare($sql);
    	$query->bind_param("iiiiis",$generic_id,$imei_no,$rating_no,$sub_option_id,$sub_option_id,$comment_desc);
    	
    	if($query->execute())
    	{
    		if($_REQUEST[$sub_option_id]=='11')
    		{
    		    
    		    $suboptionid='13';
    		    
    		    $sql="insert into reopen_transactions(grievance_id,imei_no,rating_no,comment_desc,sub_option_id)values(?,?,?,?,?)";
    		    
    		    $generic_id=strip_tags($_REQUEST[$generic_id]);
            	$imei_no=strip_tags($_REQUEST[$imei_no]);
            	$rating_no=strip_tags($_REQUEST[$rating_no]);
            	$sub_option_id=strip_tags($_REQUEST[$sub_option_id]);
    		    $comment_desc=mysqli_real_escape_string($conn,strip_tags($_REQUEST[$comment_desc]));
    		    $suboptionid=$suboptionid;
    		    
    		    $query1=$conn->prepare($sql);
    	        $query1->bind_param("iiiisi",$generic_id,$imei_no,$rating_no,$sub_option_id,$comment_desc,$suboptionid);
    		  
    		    $query1->execute();
    		    
    		    // checking weather grievance already reopened or not
    		    
    		    $sql ="select grievance_id from grievances_transactions where grievance_id=? and is_reopened_yn=?";
					     
					     $grievance_id=htmlspecialchars(strip_tags($_REQUEST[$generic_id]));
					     $is_reopened_yn=1;
					     $query2=$conn->prepare($sql);
					     $query2->bind_param("ii",$grievance_id,$is_reopened_yn);
					     $query2->execute();
					     $rs=$query2->get_result();
					   
					     $nr_reopen=$rs->num_rows();
    		    
    	
    		           
    		                $sql="update grievances set grievance_status_id='13' where grievance_id=?";
    		                
    		             $grievance_id=$_REQUEST[$generic_id];
					     $query3=$conn->prepare($sql);
					     $query3->bind_param("i",$grievance_id);
					     $query3->execute();
					     
    		               
    		                
    		                $sql ="update  grievances_transactions set is_reopened_yn=? where grievance_id=? and disposal_status =?";
    		                
    		                 $is_reopened_yn=1;
    		                 $grievance_id=htmlspecialchars(strip_tags($_REQUEST[$generic_id]));
    		                 $disposal_status=9;
    					     $query4=$conn->prepare($sql);
    					     $query4->bind_param("iii",$is_reopened_yn,$grievance_id,$disposal_status);
    					     $query4->execute();
    		                
    		               
    		                
    		          $comp_completed_withinsla=0;
		               $comp_completed_beyondsla=0;
		               
		               $sql ="select ulbid from grievances where grievance_id=?";
		               
		               $grievance_id=htmlspecialchars(strip_tags($_REQUEST[$generic_id]));
		               $query5=$conn->prepare($sql);
    					     $query5->bind_param("i",$grievance_id);
    					     $query5->execute();
		                    $rs=$query5->get_result();
		              
		               $row = $rs->fetch_assoc();
		               $ulbid=$row['ulbid'];
		               
		               
        		
				  
				  $sql5="select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status, ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm,ulbmst u where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and gt.disposal_status IN('13') and gt.disposal_status !=? and g.ulbid=? and g.app_type_id=? and g.grievance_id=? and transaction_id = (select MAX(transaction_id) from grievances_transactions where grievance_id=?)";
        			
        			$disposal_status=5;
        		    $ulbid=$ulbid;
        			$app_type_id=1;
        			$grievance_id=htmlspecialchars(strip_tags($_REQUEST[$generic_id]));
        			$query6=$conn->prepare($sql);
        			$query6->bind_param("isiii",$disposal_status,$ulbid,$app_type_id,$grievance_id,$grievance_id);
        			$query6->execute();
        			$res5=$query6->get_result();
        			  
        		
        		 while($row5 = $res5->fetch_assoc())
				 {
				     if($row5['target'] <= $row5['target_days'])
					 {
					     // getting completed with in sla count
					     
					     $sql ="select completed_sla from dashboard_count where ulbid=? and app_type_id=?";
					     
					     $ulbid=$ulbid;
					     $app_type_id=1;
					     $query7=$conn->prepare($sql);
					     $query7->bind_param("si",$ulbid,$app_type_id);
					     $query7->execute();
					     $rs=$query7->get_result();
					    
					     $row = $rs->fetch_assoc();
					     $completed_sla=$row['completed_sla']-1;
					     $sql ="update dashboard_count set completed_sla=? where ulbid=? and app_type_id=?";
					     
					     $completed_sla=$completed_sla;
					     $ulbid=$ulbid;
					     $app_type_id=1;
					     $query8=$conn->prepare($sql);
					     $query8->bind_param("ssi",$completed_sla,$ulbid,$app_type_id);
					     $query8->execute();
					   
					     
					     // checks for already reopened or not
					     
					     
    					     if($nr_reopen > 0) // if already existed updating counts
    					     {
    					        $sql ="select reopened_completed,reopened from dashboard_count where ulbid=? and app_type_id=?";
    					        
    					         $ulbid=$ulbid;
        					     $app_type_id=1;
        					     $query9=$conn->prepare($sql);
        					     $query9->bind_param("si",$ulbid,$app_type_id);
        					     $query9->execute();
        					     $rs=$query9->get_result();
					     
    					       
    					        $row = $rs->fetch_assoc();
    					        $reopened_completed=$row['reopened_completed']-1;
    					        $reopened=$row['reopened']+1;
    					        $sql ="update dashboard_count set reopened_completed=?,reopened=? where ulbid=? and app_type_id=?";
    					        
    					        $reopened_completed=$reopened_completed;
    					        $reopened=$reopened;
    					        $ulbid=$ulbid;
    					        $app_type_id=1;
    					        
    					        $query10=$conn->prepare($sql);
        					    $query10->bind_param("sssi",$reopened_completed,$reopened,$ulbid,$app_type_id);
    					        $query10->execute();
    					        
					          
    					        
    					     }
    					     else
    					     {
    					        $sql ="select reopened from dashboard_count where ulbid=? and app_type_id=?";
    					        
    					        $ulbid=$ulbid;
    					        $app_type_id=1;
    					        
    					        $query11=$conn->prepare($sql);
        					    $query11->bind_param("si",$ulbid,$app_type_id);
    					        $query11->execute();
    					        $rs=$query11->get_result();
    					       
    					        $row = $rs->fetch_assoc();
    					        
    					        $reopened=$row['reopened']+1;
    					        $sql ="update dashboard_count set reopened=? where ulbid=? and app_type_id=?";
    					        
    					        $reopened=$reopened;
    					        $ulbid=$ulbid;
    					        $app_type_id=1;
    					        $query12=$conn->prepare($sql);
        					    $query12->bind_param("ssi",$reopened,$ulbid,$app_type_id);
    					        $query12->execute();
					          
    					     }
					     
					 }
					 else
					 {
					     $sql ="select completed_be_sla from dashboard_count where ulbid=? and app_type_id=?";
					     
					            $ulbid=$ulbid;
    					        $app_type_id=1;
    					        $query13=$conn->prepare($sql);
        					    $query13->bind_param("si",$ulbid,$app_type_id);
    					        $query13->execute();
    					        $rs=$query13->get_result();
    					        
					  
					     $row = $rs->fetch_assoc();
					     $completed_be_sla=$row['completed_be_sla']-1;
					     $sql ="update dashboard_count set completed_be_sla='".$completed_be_sla."' where ulbid='".$ulbid."' and app_type_id='1'";
					     
					            $completed_be_sla=$completed_be_sla;
					            $ulbid=$ulbid;
    					        $app_type_id=1;
    					        $query14=$conn->prepare($sql);
        					    $query14->bind_param("ssi",$completed_be_sla,$ulbid,$app_type_id);
    					        $query14->execute();
    					        
    				
					    
    					     if($nr_reopen > 0) // if already existed updating counts
    					     {
    					        $sql ="select reopened_completed,reopened from dashboard_count where ulbid='".$ulbid."' and app_type_id='1'";
    					        
    					        $ulbid=$ulbid;
    					        $app_type_id=1;
    					        $query15=$conn->prepare($sql);
        					    $query15->bind_param("si",$ulbid,$app_type_id);
    					        $query15->execute();
    					        $rs=$query15->get_result();
    					        
    					      
    					        $row = $rs->fetch_assoc();
    					        $reopened_completed=$row['reopened_completed']-1;
    					        $reopened=$row['reopened']+1;
    					        $sql ="update dashboard_count set reopened_completed=?,reopened=? where ulbid=? and app_type_id=?";
					            
					            $reopened_completed=$reopened_completed;
					            $reopened=$reopened;
					            $ulbid=$ulbid;
					            $app_type_id=1;
					            
					            $query16=$conn->prepare($sql);
        					    $query16->bind_param("sssi",$reopened_completed,$reopened,$ulbid,$app_type_id);
    					        $query16->execute();
					            
					        
    					        
    					     }
    					     else
    					     {
    					        $sql ="select reopened from dashboard_count where ulbid=? and app_type_id=?";
    					        
    					        $ulbid=$ulbid;
					            $app_type_id=1;
					            $query17=$conn->prepare($sql);
        					    $query17->bind_param("si",$ulbid,$app_type_id);
    					        $query17->execute();
					            $rs=$query17->get_result();
    					       
    					        $row = $rs->fetch_assoc();
    					        
    					        $reopened=$row['reopened']+1;
    					        $sql ="update dashboard_count set reopened=? where ulbid=? and app_type_id=?";
    					        
    					        $reopened=$reopened;
    					        $ulbid=$ulbid;
					            $app_type_id=1;
					            $query18=$conn->prepare($sql);
        					    $query18->bind_param("ssi",$reopened,$ulbid,$app_type_id);
    					        $query18->execute();
    					        
					        
					            
					            
    					     }
					    
					 }
					 
				 } 
    		                
    		            
    		}
    	}
		            
		            
		            
		            
		            /*******************************************/
		            
		            
		            
		        }
		    }
		    
		}
		
		
		$_REQUEST['aptid']=1;
		
	 	$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
		
		
	    
	        
	        
				 
				 $sql="SELECT g.*,gt.emp_id,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,
				 ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,
				 grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid=? and 
				  g.cat3_id=ccm.cs_id and app_type_id=? and grievance_status_id IN ('3','8','9') and gt.disposal_status !=? and is_reopened_yn=?";
				  
				  
				  $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				  $app_type_id=1;
				  $disposal_status=5;
				  $is_reopened_yn=0;
				  $query19=$conn->prepare($sql);
				  $query19->bind_param("siii",$ulbid,$app_type_id,$disposal_status,$is_reopened_yn);
				  
				  if(isset($_POST['search']))
        			{
        			    
        			    
        			    if($_POST['ref_no'] !='')
        			    {
        			        $sql .=" and g.grievance_id=?";
        			        
        			        $grievance_id=$_POST['ref_no'];
        			        $query19=$conn->prepare($sql);
        			        $query19->bind_param("siiii",$ulbid,$app_type_id,$disposal_status,$is_reopened_yn,$grievance_id);
        			        
        			        
        			        $tpl->assign('refno_sel',$_POST['ref_no']);
        			    }
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			                $f_date=$f_date;
            			                $t_date=$t_date;
            			                $query19=$conn->prepare($sql);
            			                $query19->bind_param("siiiss",$ulbid,$app_type_id,$disposal_status,$is_reopened_yn,$f_date,$t_date);
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
	            
	            $query="SELECT count(g.grievance_id) as num FROM grievances g ,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=? and app_type_id=? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and cat3_id !=? and is_reopened_yn=? and grievance_origin_id NOT IN('4')";
				 
				 $id3=3;
				 $id8=8;
				 $id9=9;
				 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
				 $app_type_id=1;
				 $cat3_id=0;
				 $is_reopened_yn=0;
				 $query20=$conn->prepare($query);
				 $query20->bind_param("siiiiii",$ulbid,$app_type_id,$cat3_id,$is_reopened_yn,$id3,$id8,$id9);
				 
				 if(isset($_POST['search']))
        			{
        			            
        			             if($_POST['ref_no'] !='')
                			    {
                			        $query .=" and g.grievance_id=?";
                			        
                			        $grievance_id=$_POST['ref_no'];
                			        $query20=$conn->prepare($query);
                			        $query20->bind_param("siiii",$ulbid,$app_type_id,$cat3_id,$is_reopened_yn,$grievance_id);
                			        
                			    }
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $query.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			                $f_date=$f_date;
            			                $t_date=$t_date;
            			                
            			            $query20=$conn->prepare($query);
                			        $query20->bind_param("siiiss",$ulbid,$app_type_id,$cat3_id,$is_reopened_yn,$f_date,$t_date);
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
	        
	       
	      
		
		
		
		
		if($query19->execute())
		{
		    $rs=$query19->get_result();
			$field_info = $rs->fetch_fields();
			while($row =$rs->fetch_assoc())
			{
			
				
			
				
					foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
			}
			
	
			
		}
	
		
		$tpl->assign('data',$data);



		$sql="select ward_id,ward_desc from ward_mst";
		
		$query21=$conn->prepare($sql);
		
		if($query21->execute())
		{
		    $rs=$query21->get_result();
		    
			while($row = $rs->fetch_assoc())
			
			$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
	
	  	$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=?";
	  	
	  	$grievance_status_id=5;
	  	$query22=$conn->prepare($sql);
	  	$query22->bind_param("i",$grievance_status_id);
	  	
		if($query22->execute())
		{
		    $rs=$query22->get_result();
		    
			while($row = $rs->fetch_assoc())
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		

		$sql="select dept_id,dept_desc from dept_mst";
		$query23=$conn->prepare($sql);
		
		if($query23->execute())
		{
		    $rs=$query23->get_result();
		    
			while($row = $rs->fetch_assoc())
			
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
	
		$tpl->assign('dept_list',$dept_list);
		
		
		
		 $sql ="select emp_id, emp_name, emp_mobile from emp_mst where ulbid=?";
		 
		 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		 $query24=$conn->prepare($sql);
		 $query24->bind_param("s",$ulbid);
		 $query24->execute();
		 $rs=$query24->get_result();
		
		while($row =$rs->fetch_assoc())
		{
				$emp_list[$row['emp_id']]=$row['emp_name']." - ".$row['emp_mobile'];
				$emp_mobile[$row['emp_id']]=$row['emp_mobile'];
		}

        $tpl->assign('emp_list',$emp_list);
        $tpl->assign('emp_mobile',$emp_mobile);
        
        
        
        
		
		$sql="select cs_id,comp_desc from category3_mst where ulbid=?";
		
		 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		 $query25=$conn->prepare($sql);
		 $query25->bind_param("s",$ulbid);
		  
		
		if($_REQUEST['aptid']=='1')
		{
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		$query25=$conn->prepare($sql);
		}
		if($query25->execute())
		{
		    $rs=$query25->get_result(); 
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
	
		$sql ="select user_id,user_name from users where ulbid=?";	
		
		 $ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		 $query26=$conn->prepare($sql);
		 $query26->bind_param("s",$ulbid);
		 
			if($query26->execute())
        		{
        		    $rs=$query26->get_result(); 
        			while($row = $rs->fetch_assoc())
        			
        				$users_list[$row['user_id']]=$row['user_name'];
        		}
        		
        		$sql ="select sub_option_id,description from feedback_sub_options where sub_option_id=?";
        		
        		 $sub_option_id=11;
        		 $query27=$conn->prepare($sql);
        		 $query27->bind_param("i",$sub_option_id);
        		 
			if($query27->execute())
			
        		{
        		    $rs=$query27->get_result(); 
        			while($row =$rs->fetch_assoc())
        				$sub_option_list[$row['sub_option_id']]=$row['description'];
        		}
        		
        		
        		
        		$conn->close();
        $tpl->assign('sub_option_list', $sub_option_list);	
        $tpl->assign('hod_status2',$_SESSION['hod_status2']);
        $tpl->assign('hod_status',$_SESSION['hod_status']);
        $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('fdate',$_POST['f_date']);
        $tpl->assign('tdate',$_POST['t_date']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('comm_reopen.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>