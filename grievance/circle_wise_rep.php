<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
		$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		

		 $sql=$conn->prepare("select * from circle_mst");
            $sql->execute();
		    $rs=$sql->get_result();    
	       
    		while($row = $rs->fetch_assoc())
    		{
    			$circle_list[$row['circle_id']]=$row['circle_desc'];
    			 
                		
    		}
    		
    		foreach($circle_list as $circle_id=>$circle_desc)
    		{
		                 $wards=array();
		                 $sql1 = "select cm.* from circle_ward_map cm  where cm.circle_id = ? ";
		                 
		                 $circle_id=$circle_id;
		                 $query=$conn->prepare($sql1);
		                 $query->bind_param("i",$circle_id);
		                 $query->execute();
		                 $rs1=$query->get_result();
		                
		                while($row = $rs1->fetch_assoc())
                		{
                		      $wards[$row['ward']]=$row['ward'];
                		}
                		
                	
                		
                    	           $sql="SELECT count(g.grievance_id) as totalreceived FROM grievances g
                    	        where  app_type_id=? and cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
                    	        
                    	        $app_type_id='1';
                    	        $cat3_id='0';
                    	        $query1=$conn->prepare($sql);
                    	        $query1->bind_param("ii",$app_type_id,$cat3_id);
                    	        
                    	          if(isset($_POST['search']))
        		                	{

                                   if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                       {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			        $f_date=$f_date;
                    	        $t_date=$t_date;
                    	        $query1=$conn->prepare($sql);
                    	        $query1->bind_param("iiss",$app_type_id,$cat3_id,$f_date,$t_date);
            			                
            			                 
			                        }
        		                	}
                    	        //echo "<br>";
                    	    $query1->execute();
                    	    $rs=$query1->get_result();
                    	 
                    	       
                    			while($rows = $rs->fetch_assoc())
                    		    {
                    				  $data[$circle_id]['total_received']+=$rows['totalreceived'];
                    				  $tot['total_received']+=$rows['totalreceived'];
                    			}
                			
                	
                		
    		
    
                			
                			/**** resolved with in sla ****/
                			
                			$sql ="select COUNT(grievance_id) as resolved_within_sla,cat3_id from grievances where grievance_status_id IN('3','8','9') and 
                			ulbid=? and app_type_id=? and cat3_id !=? and sla_status=? and ward_id IN ('".implode("', '",$wards)."')";
                			 
                			   //$grievance_status_id3=3;
                			   //$grievance_status_id8=8;
                			   //$grievance_status_id9=9;
                			   $ulbid=$ulbid1;
                			   $app_type_id=1;
                			   $cat3_id=0;
                			   $sla_status=1;
                			   
                			   $query3=$conn->prepare($sql);
                			   $query3->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$sla_status);
                			   
                			 
                			 if(isset($_POST['search']))
        		                	{

                                   if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                       {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ?" ;
            			                $sql.=" group by cat3_id order by date_regd DESC";
            			                
            			                $f_date=$f_date;
                    	                $t_date=$t_date;
                    	                $query3=$conn->prepare($sql);
                    	                $query3->bind_param("iiisiiiss",$grievance_status_id3,$grievance_status_id8,$grievance_status_id9,$ulbid,$app_type_id,$cat3_id,$sla_status,$f_date,$t_date);
            			                 
			                        }
        		                	}
        		                	
                			 //$sql.=" group by cat3_id order by date_regd DESC";
                			 $query3->execute();
                			 $rs=$query3->get_result();
                			 
                				
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$circle_id]['resolved_within_sla']+=$row['resolved_within_sla'];
                			    $tot['resolved_within_sla']+=$row['resolved_within_sla'];
                			}
                			
                			
         	
                			
                			/*** resolved beyond sla ****/
                			
                			$sql ="select COUNT(grievance_id) as resolved_beyond_sla,cat3_id from grievances where grievance_status_id IN('3','8','9') and 
                			ulbid=? and app_type_id=? and cat3_id !=? and sla_status=? and ward_id IN ('".implode("', '",$wards)."')";
                			
                			   $ulbid=$ulbid1;
                			   $app_type_id=1;
                			   $cat3_id=0;
                			   $sla_status=2;
                			   
                			   $query4=$conn->prepare($sql);
                			   $query4->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$sla_status);
                			
                			 if(isset($_POST['search']))
        		                	{

                                   if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                       {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ?";
            			                $sql.=" group by cat3_id order by date_regd DESC";
            			                
            			                $f_date=$f_date;
                    	                $t_date=$t_date;
                    	                $query4=$conn->prepare($sql);
                    	                $query4->bind_param("siiiss",$ulbid,$app_type_id,$cat3_id,$sla_status,$f_date,$t_date);
            			                 
			                        }
        		                	}
        		                	// $sql.=" group by cat3_id order by date_regd DESC";
        		                	$query4->execute();
        		                	$rs=$query4->get_result();
        		                	
                					
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$circle_id]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
                			    $tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
                			}
                			
	        
                			
                			/**** pending with in sla ***/
                			
                			$sql ="select COUNT(grievance_id) as pending_within_sla,cat3_id from grievances where grievance_status_id IN('2') and 
                			ulbid=? and app_type_id=? and cat3_id !=? and sla_status=? and ward_id IN ('".implode("', '",$wards)."')";
                			
                			   $ulbid=$ulbid1;
                			   $app_type_id=1;
                			   $cat3_id=0;
                			   $sla_status=1;
                			   
                			   $query5=$conn->prepare($sql);
                			   $query5->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$sla_status);
                			
                			 if(isset($_POST['search']))
        		                	{

                                   if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                       {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? " ;
            			                $sql.=" group by cat3_id order by date_regd DESC";
            			                
            			                $f_date=$f_date;
                    	                $t_date=$t_date;
                    	                $query5=$conn->prepare($sql);
                    	                $query5->bind_param("siiiss",$ulbid,$app_type_id,$cat3_id,$sla_status,$f_date,$t_date);
            			                 
			                        }
        		                	}
        		                	
        		                $query5->execute();
        		                	$rs=$query5->get_result();	
                				
                			while($row =$rs->fetch_assoc())
                			{
                			    $data[$circle_id]['pending_within_sla']+=$row['pending_within_sla'];
                			    $tot['pending_within_sla']+=$row['pending_within_sla'];
                			}
                			
	
                			
                			
                				/**** pending with beyond sla ***/
                			
                			$sql ="select COUNT(grievance_id) as pending_beyond_sla,cat3_id from grievances where grievance_status_id IN('2') and ulbid=? and 
                			app_type_id=? and cat3_id !=? and sla_status=? and ward_id IN ('".implode("', '",$wards)."')";
                			
                			   $ulbid=$ulbid1;
                			   $app_type_id=1;
                			   $cat3_id=0;
                			   $sla_status=2;
                			   
                			   $query6=$conn->prepare($sql);
                			   $query6->bind_param("siii",$ulbid,$app_type_id,$cat3_id,$sla_status);
                			   
                			 if(isset($_POST['search']))
        		                	{

                                   if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                       {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ?";
            			                	$sql.=" group by cat3_id order by date_regd DESC";
            			                $f_date=$f_date;
                    	                $t_date=$t_date;
                    	                $query6=$conn->prepare($sql);
                    	                $query6->bind_param("siiiss",$ulbid,$app_type_id,$cat3_id,$sla_status,$f_date,$t_date);
            			                 
			                        }
        		                	}
                	
                		$query6->execute();
        		                	$rs=$query6->get_result();	
                				
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$circle_id]['pending_beyond_sla']+=$row['pending_beyond_sla'];
                			    $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
                			}
                			
                	
                	 	
                	        
                	        $sql ="select COUNT(grievance_id) as fin_implication,cat3_id from grievances where grievance_status_id =? and ulbid=?
                	        and app_type_id=? and cat3_id !=? and ward_id IN ('".implode("', '",$wards)."')";
                	        
                	           $grievance_status_id=6;
                	           $ulbid=$ulbid1;
                			   $app_type_id=1;
                			   $cat3_id=0;
                			   
                			   
                			   $query7=$conn->prepare($sql);
                			   $query7->bind_param("isii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id);
                	                    
                	        if(isset($_POST['search']))
        		                	{

                                   if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                       {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ?";
            			                $sql.=" group by cat3_id order by date_regd DESC";
            			                $f_date=$f_date;
                    	                $t_date=$t_date;
                    	                $query7=$conn->prepare($sql);
                    	                $query7->bind_param("isiiss",$grievance_status_id,$ulbid,$app_type_id,$cat3_id,$f_date,$t_date);
            			                 
			                        }
        		                	}             
                	           
                	           	$query7->execute();
        		                	$rs=$query7->get_result();	
                	       
                			while($row = $rs->fetch_assoc())
                			{
                				 $data[$circle_id]['fin_implication']+=$row['fin_implication'];
                				 $tot['fin_implication']+=$row['fin_implication'];
                			}
                			
	
                			
                			
                			
                			
                		  	
                	         $sql ="select COUNT(grievance_id) as pending_apprvl,cat3_id from grievances where grievance_status_id =? and ulbid=? and 
                	         app_type_id=? and cat3_id != ? and ward_id IN ('".implode("', '",$wards)."')";
                	         
                	           $grievance_status_id=1;
                	           $ulbid=$ulbid1;
                			   $app_type_id=1;
                			   $cat3_id=0;
                			   
                			   
                			   $query8=$conn->prepare($sql);
                			   $query8->bind_param("isii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id);
                			   
                	          if(isset($_POST['search']))
        		                	{

                                   if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                       {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ?";
            			                $sql.=" group by cat3_id order by date_regd DESC";  
            			                $f_date=$f_date;
                    	                $t_date=$t_date;
                    	                $query8=$conn->prepare($sql);
                    	                $query8->bind_param("isiiss",$grievance_status_id,$ulbid,$app_type_id,$cat3_id,$f_date,$t_date);
            			                 
			                        }
        		                	}
                	             
                	              $query8->execute();
        		                	$rs=$query8->get_result();	
                	      		
                			while($row = $rs->fetch_assoc())
                			{
                				 $data[$circle_id]['pending_apprvl']+=$row['pending_apprvl'];
                				 $tot['pending_apprvl']+=$row['pending_apprvl'];
                			}
                			
				
                			
                			 $sql ="select COUNT(grievance_id) as rejected,cat3_id from grievances where grievance_status_id =? and ulbid=? and 
                			 app_type_id=? and cat3_id !=? and ward_id IN ('".implode("', '",$wards)."')";
                	                    
                	                     $grievance_status_id=10;
                	           $ulbid=$ulbid1;
                			   $app_type_id=1;
                			   $cat3_id=0;
                			   
                			   
                			   $query9=$conn->prepare($sql);
                			   $query9->bind_param("isii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id);
                	                    
                	                     if(isset($_POST['search']))
        		                	{

                                   if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                       {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? ";
            			                $sql.=" group by cat3_id order by date_regd DESC";
            			                
            			                $f_date=$f_date;
                    	                $t_date=$t_date;
                    	                $query9=$conn->prepare($sql);
                    	                $query9->bind_param("isiiss",$grievance_status_id,$ulbid,$app_type_id,$cat3_id,$f_date,$t_date);
            			                 
			                        }
        		                	}
                	          
                	           $query9->execute();
        		                	$rs=$query9->get_result();	
        		                	
                	        			
                			while($row =$rs->fetch_assoc())
                			{
                				 $data[$circle_id]['rejected']+=$row['rejected'];
                				 $tot['rejected']+=$row['rejected'];
                			}
                			
			
                			
                			$sql ="select COUNT(grievance_id) as unresolved,cat3_id from grievances where grievance_status_id =? and ulbid=? and 
                			app_type_id=? and cat3_id !=? and ward_id IN ('".implode("', '",$wards)."')";
                	                    
                	                 $grievance_status_id=4;
                	           $ulbid=$ulbid1;
                			   $app_type_id=1;
                			   $cat3_id=0;
                			   
                			   
                			   $query10=$conn->prepare($sql);
                			   $query10->bind_param("isii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id);   
                			   
                	                     if(isset($_POST['search']))
        		                	{

                                   if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                       {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ?";
            			                $sql.=" group by cat3_id order by date_regd DESC";   
            			                $f_date=$f_date;
                    	                $t_date=$t_date;
                    	                $query10=$conn->prepare($sql);
                    	                $query10->bind_param("isiiss",$grievance_status_id,$ulbid,$app_type_id,$cat3_id,$f_date,$t_date);
            			                 
			                        }
        		                	}
                	           
                	            $query10->execute();
        		                	$rs=$query10->get_result();	
                	       		
                			while($row = $rs->fetch_assoc())
                			{
                				 $data[$circle_id]['unresolved']+=$row['unresolved'];
                				 $tot['unresolved']+=$row['unresolved'];
                			}
                			
                			
                			
                			/** re-opened applicatons **/
			
		                $sql3 ="select count(grievance_id) as count,app_type_id,grievance_status_id from grievances where grievance_status_id IN('11','12','13') and ward_id IN ('".implode("', '",$wards)."')  and 
                			app_type_id=? and cat3_id !=? group by grievance_status_id";
		            
		                
		                        
                			   $app_type_id=1;
                			   $cat3_id=0;
                			   
                			   
                			   $query11=$conn->prepare($sql3);
                			   $query11->bind_param("ii",$app_type_id,$cat3_id);   
		                     $query11->execute();
        		             $rs=$query11->get_result();	
		                
		                  
		               
		                while($row =$rs->fetch_assoc())
		                {
		                    $reopened_completed_tot[$circle_id][$row['app_type_id']][$row['grievance_status_id']]['count']=$row['count'];
		                    $tot[$row['grievance_status_id']]['count']+=$row['count'];
		                }
                			
                			
			
    		}
    		
			
	     
	   
				
				$sql ="select * from ulbmst";
				
				$query12=$conn->prepare($sql);
				
				$query12->execute();
        		             $rs=$query12->get_result();
				
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
					
        		
        	$conn->close();
        $tpl->assign('reopened_completed_tot',$reopened_completed_tot);	
        $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('circle_list',$circle_list);
		$tpl->assign('cat_id',$cat_id);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('circle_wise_rep.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>