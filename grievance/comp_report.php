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
		
	 	$aptid1=$_POST['app_type_id'];
		$status1=$_POST['status'];
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
	 
		
		                    
		                    
		      $wards=array();
    		  $sql1 = "select cm.* from circle_ward_map cm  where cm.circle_id = ? ";
    		      
    		     $circle_id  = $_REQUEST['c_id'];
        		 $query = $conn->prepare($sql1);
        		 $query->bind_param("i",$circle_id);
        		 $query->execute();
        		 $rs = $query->get_result();
    		      
    		                 
    		   
    		   while($row = $rs->fetch_assoc())
               	{
               	      $wards[$row['ward']]=$row['ward'];
               	}
	               
	               if($_REQUEST['status'] == 1)
	               {
	                   
	                     $sql="SELECT * FROM grievances g where  app_type_id=? and cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                     
	                     
	                     $app_type_id = 1;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("ii",$app_type_id,$cat3_id);
	                     
	                     
	                     
	                      if(isset($_POST['search']))
        			{
        			     if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			               $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			               
            			              $f_date = $_REQUEST['f_date'];
                            		 $t_date = $_REQUEST['t_date'];
                            		 $query = $conn->prepare($sql);
                            		 $query->bind_param("ss",$f_date,$t_date);
            			               
            			                 
			                      }
			                      
			                      
        			}
	               }
	               
	               
	               else if($_REQUEST['status'] == 2)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and (g.grievance_status_id = ? or g.grievance_status_id = ? or g.grievance_status_id = ?) and  sla_status=? and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                   
	                   
	                     $app_type_id = 1;
                		 $grievance_status_id = 3;
                		 $grievance_status_id1 = 8;
                		 $grievance_status_id2 = 9;
                		 $sla_status = 1;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iiiiii",$app_type_id,$grievance_status_id,$grievance_status_id1,$grievance_status_id2,$sla_status,$cat3_id);
        	                   
	                   
	                   
	                    if(isset($_POST['search']))
        			    {
        			     if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			                $f_date = $_REQUEST['f_date'];
                            		 $t_date = $_REQUEST['t_date'];
                            		 $query = $conn->prepare($sql);
                            		 $query->bind_param("ss",$f_date,$t_date);
			                     }
        		        	}
	                   
	             }
	               
	               
	               else if($_REQUEST['status'] == 3)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and (g.grievance_status_id = ? or g.grievance_status_id = ? or g.grievance_status_id = ?) and  sla_status=? and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                   
	                     $app_type_id = 1;
                		 $grievance_status_id = 3;
                		 $grievance_status_id1 = 8;
                		 $grievance_status_id2 = 9;
                		 $sla_status = 2;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iiiiii",$app_type_id,$grievance_status_id,$grievance_status_id1,$grievance_status_id2,$sla_status,$cat3_id);
	                   
	                   
	                   
	                    if(isset($_POST['search']))
        			    {
        			     if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			                $f_date = $_REQUEST['f_date'];
                            		 $t_date = $_REQUEST['t_date'];
                            		 $query = $conn->prepare($sql);
                            		 $query->bind_param("ss",$f_date,$t_date);
			                     }
        		        	}
	                   
	               }
	               
	               
	               else if($_REQUEST['status'] == 4)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and (g.grievance_status_id = ?) and  sla_status=? and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                   
	                     $app_type_id = 1;
                		 $grievance_status_id = 2;
                		 $sla_status = 1;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iiii",$app_type_id,$grievance_status_id,$sla_status,$cat3_id);
	                   
	                    if(isset($_POST['search']))
        			    {
        			     if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			                $f_date = $_REQUEST['f_date'];
                            		 $t_date = $_REQUEST['t_date'];
                            		 $query = $conn->prepare($sql);
                            		 $query->bind_param("ss",$f_date,$t_date);
			                     }
        		        	}
	                   
	               }
	               
	               
	               else if($_REQUEST['status'] == 5)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and (g.grievance_status_id = ?) and  sla_status=? and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                   
	                     $app_type_id = 1;
                		 $grievance_status_id = 2;
                		 $sla_status = 2;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iiii",$app_type_id,$grievance_status_id,$sla_status,$cat3_id);
	                   
	                   
	                    if(isset($_POST['search']))
        			    {
        			     if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			                $f_date = $_REQUEST['f_date'];
                            		 $t_date = $_REQUEST['t_date'];
                            		 $query = $conn->prepare($sql);
                            		 $query->bind_param("ss",$f_date,$t_date);
			                     }
        		        	}
	                   
	               }
	               
	               
	               else if($_REQUEST['status'] == 6)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and (g.grievance_status_id = ?)  and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                    
	                    
	                     $app_type_id = 1;
                		 $grievance_status_id = 6;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iii",$app_type_id,$grievance_status_id,$cat3_id);
	                    
	                    
	                    
	                    if(isset($_POST['search']))
        			    {
        			     if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			                $f_date = $_REQUEST['f_date'];
                            		 $t_date = $_REQUEST['t_date'];
                            		 $query = $conn->prepare($sql);
                            		 $query->bind_param("ss",$f_date,$t_date);
			                     }
        		        	}
	                   
	               }
	               
	               
	               else if($_REQUEST['status'] == 8)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and (g.grievance_status_id = ?)  and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                   
	                   
	                     $app_type_id = 1;
                		 $grievance_status_id = 10;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iii",$app_type_id,$grievance_status_id,$cat3_id);
	                   
	                   
	                   
	                    if(isset($_POST['search']))
        			    {
        			     if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			             $f_date = $_REQUEST['f_date'];
                            		 $t_date = $_REQUEST['t_date'];
                            		 $query = $conn->prepare($sql);
                            		 $query->bind_param("ss",$f_date,$t_date);
			                     }
        		        	}
	                   
	               }
	               
	               else if($_REQUEST['status'] == 9)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and (g.grievance_status_id = ?)  and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                   
	                     $app_type_id = 1;
                		 $grievance_status_id = 4;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iii",$app_type_id,$grievance_status_id,$cat3_id);
	                   
	                    if(isset($_POST['search']))
        			    {
        			     if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            
            			                $sql.=" and date(date_regd) between ? and ? order by date_regd DESC" ;
            			                
            			                $f_date = $_REQUEST['f_date'];
                            		 $t_date = $_REQUEST['t_date'];
                            		 $query = $conn->prepare($sql);
                            		 $query->bind_param("ss",$f_date,$t_date);
			                     }
        		        	}
	                   
	               }
	               
	               
                     else if($_REQUEST['status'] == 10)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and (g.grievance_status_id = ? )  and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                   
	                     $app_type_id = 1;
                		 $grievance_status_id = 13;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iii",$app_type_id,$grievance_status_id,$cat3_id);
	                   
	                   
	               }
	               
	               
	                else if($_REQUEST['status'] == 11)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and (g.grievance_status_id = ? )  and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                   
	                     $app_type_id = 1;
                		 $grievance_status_id = 11;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iii",$app_type_id,$grievance_status_id,$cat3_id);
	                   
	               }
	               
	               
	                else if($_REQUEST['status'] == 12)
	               {
	                   
	                   $sql="SELECT * FROM grievances g where  app_type_id=? and g.grievance_status_id IN('12')  and
	                   cat3_id !=? and g.ward_id IN ('".implode("', '",$wards)."') ";
	                   
	                     $app_type_id = 1;
                		 $grievance_status_id = 12;
                		 $cat3_id = 0;
                		 $query = $conn->prepare($sql);
                		 $query->bind_param("iii",$app_type_id,$grievance_status_id,$cat3_id);
	                   
	               }
                    	      	
		$total_recordss=0;
		
		if($query->execute())
		{
		    $rs = $query->get_result();
			$field_info = $rs->fetch_fields();
			while($row = $rs->fetch_assoc())
			{
				
					foreach($field_info as $fi => $f) 
					{
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
					
					}
					$total_recordss++;
			}
			
		}
	
						
		$tpl->assign('total_recordss',$total_recordss);
		$tpl->assign('data',$data);
    	                
    	

	  	$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where (grievance_status_id != ? or grievance_status_id != ? or grievance_status_id != ? )";
	  	
	  	
	  	         $grievance_status_id = 5;
        		 $grievance_status_id1 = 8;
        		 $grievance_status_id2 = 3;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("iii",$grievance_status_id,$grievance_status_id1,$grievance_status_id2);
        		  
        		 
	  	
	  	
	  	
		if($query->execute())
		{
		    $rs = $query->get_result();
			while($row = $rs->fetch_assoc())
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		
			
			
			$sql="select cs_id,comp_desc from category3_mst where ulbid=?";
			
			     $ulbid = $_SESSION['ulbid'];
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 
		if($query->execute())
		{
		    $rs = $query->get_result();
			while($row = $rs->fetch_assoc())
				$service_list[$row['cs_id']]=$row['comp_desc'];
		}
		
			
		$sql="select cs_id,cs_desc from cs_mst";
		
		          
        		 $query = $conn->prepare($sql);
        		  
        		 
		if($query->execute())
		{
		    $rs = $query->get_result();
		
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['cs_desc'];
		}
	
		
		
		$sql = "select g.user_id,u.* from grievances g , users u where u.user_id = g.user_id and u.user_type= 'E' and u.ulbid = ? and
		(g.grievance_origin_id  = ? or g.grievance_origin_id  = ? or g.grievance_origin_id  = ? ) group by g.user_id";
		
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		         $grievance_origin_id = 2;
        		 $grievance_origin_id1 = 3;
        		 $grievance_origin_id2 = 7;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("siii",$ulbid,$grievance_status_id,$grievance_status_id1,$grievance_status_id2);
		
		
		
		if($query->execute())
		{
		     $rs = $query->get_result();
			while($row = $rs->fetch_assoc())
				$emp_list[$row['user_id']]=$row['user_name'];
		}
		
	
		
        		
        		
        		
        $conn->close();
        
        $tpl->assign('service_list',$service_list);
        $tpl->assign('app_type_sel',$_POST['app_type_id']);
        $tpl->assign('status_sel',$_POST['status']);
        $tpl->assign('emp_list',$emp_list);
        $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('emp',$_POST['employee']);
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
		$tpl->display('comp_report.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>