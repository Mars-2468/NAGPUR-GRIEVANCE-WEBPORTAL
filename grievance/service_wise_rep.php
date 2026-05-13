<?php
require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
//	echo "LoggedIn User: ".$_SESSION['uid'];
	if(isset($_SESSION['uid']))
	{
	    
	    
	  //  session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
		$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
		if($_SESSION['uid'] !='Warangal')
		{
	     
	     
	      if(isset($_POST['search']))
        			{
        			      
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            $tpl->assign('fdate',$_POST['f_date']);
                                        $tpl->assign('tdate',$_POST['t_date']);
            			                
            			                 
			                      }
        			   
        		     }
	     
	      
	     
	      
	      
	      $sql="SELECT count(grievance_id) as grievance_id,mcat3_id FROM grievances  
	      where ulbid=? and app_type_id=? and cat3_id !=?";
	      
	     
        		     
        		 $sql.=" group by mcat3_id"; 
        		
	 
	      
		
		$query=$conn->prepare($sql);
	    $app_type_id=2;
	    $ulbid=$ulbid1;
	    $cat3_id=0;
		$query->bind_param("sii",$ulbid,$app_type_id,$cat3_id);     
		$query->execute();
		$rs=$query->get_result();	
				
				
			if($rs)
			{
			  
			  while($row = $rs->fetch_assoc())
			    {
		          $data[$row['mcat3_id']]['total_received']+=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
			    }
		 	}
		
			
			$sql ="select COUNT(grievance_id) as resolved_within_sla,mcat3_id from grievances where 
			grievance_status_id IN(?) and ulbid=? and app_type_id=? and cat3_id !=? and sla_status=?";
		
			if(isset($_POST['search']))
        			{
        			    
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                        
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' " ;
            			                
			                      }
        			     
        		     }
        		     
        	$sql.=" group by mcat3_id"; 
		
		$query=$conn->prepare($sql);
	    $grievance_status_id = [3,8,9];
        $arr_as_string = implode( ',', $grievance_status_id); 
		$ulbid=$ulbid1;
		$app_type_id=2;
		$cat3_id=0;
		$sla_status=1;
		$query->bind_param("ssiii",$arr_as_string,$ulbid,$app_type_id,$cat3_id,$sla_status);     
		$query->execute();
		$rs=$query->get_result();	
				
				
			if($rs)
			{
			  
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['mcat3_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
			    $tot['resolved_within_sla']+=$row['resolved_within_sla'];
			    }
		 	}
		
			
			
			/*** resolved beyond sla ****/
			
		
			$sql ="select COUNT(grievance_id) as resolved_beyond_sla,mcat3_id from grievances where 
			grievance_status_id IN(?) and ulbid=? and app_type_id=? and cat3_id !=? and sla_status=?";
			
			
			if(isset($_POST['search']))
        			{
        			       
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                           
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' " ;
            			                
			                      }
        			    
        		     }
        		     
        		 $sql.=" group by mcat3_id"; 
        		 
        		 
		
		$query=$conn->prepare($sql);
	    $grievance_status_id = [3,8,9];
        $arr_as_string = implode( ',', $grievance_status_id); 
		$ulbid=$ulbid1;
		$app_type_id=2;
		$cat3_id=0;
		$sla_status=2;
		$query->bind_param("ssiii",$arr_as_string,$ulbid,$app_type_id,$cat3_id,$sla_status);     
		$query->execute();
		$rs=$query->get_result();	
				
				
			if($rs)
			{
			  
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['mcat3_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			    $tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			    }
		 	}
		
		

	 			/**** pending with in sla ***/
			
		
			
			$sql ="select COUNT(grievance_id) as pending_within_sla,mcat3_id from grievances where 
			grievance_status_id IN(?) and ulbid=? and app_type_id=? and cat3_id !=? and sla_status=?";
			$sql.=" group by mcat3_id";   
		
			
			$query=$conn->prepare($sql);
	        $grievance_status_id=2;
			$ulbid=$ulbid1;
			$app_type_id=2;
			$cat3_id=0;
			$sla_status=1;
		$query->bind_param("isiii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id,$sla_status);     
		$query->execute();
		$rs=$query->get_result();	
				
				
			if($rs)
			{
			  
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['mcat3_id']]['pending_within_sla']+=$row['pending_within_sla'];
			    $tot['pending_within_sla']+=$row['pending_within_sla'];
			    }
		 	}
		
				/**** pending with beyond sla ***/
			
			
			
			
				$sql ="select COUNT(grievance_id) as pending_beyond_sla,mcat3_id from grievances where 
			    grievance_status_id IN(?) and ulbid=? and app_type_id=? and cat3_id !=? and sla_status=?";
			
        		     
        		 $sql.=" group by mcat3_id"; 
        		 
        		 
		
			
		
			$query=$conn->prepare($sql);
	        $grievance_status_id=2;
			$ulbid=$ulbid1;
			$app_type_id=2;
			$cat3_id=0;
			$sla_status=2;
		    $query->bind_param("isiii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id,$sla_status);     
		    $query->execute();
		    $rs=$query->get_result();	
				
				
			if($rs)
			{
			  
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['mcat3_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
			    $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
			    }
		 	}
		
		
		
	       $sql="select COUNT(grievance_id) as pending_beyond_sla,mcat3_id  from grievances 
	         where grievance_status_id IN('6')  and 
	        g.ulbid='".$ulbid1."' and g.app_type_id='2' and cat3_id !='0'";
	        
	         
        		 $sql.=" group by mcat3_id";  
	                    
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['mcat3_id']]['fin_implication']+=1;
				 $tot['fin_implication']+=1;
			}
			
	      
	      $sql ="select COUNT(grievance_id) as fin_implication,mcat3_id from grievances where 
	      grievance_status_id =? and ulbid =? and app_type_id =? and cat3_id !=?";
	      
        		     
        		 $sql.=" group by mcat3_id";                   
	      
			
			$query=$conn->prepare($sql);
			$grievance_status_id=6;
		    $ulbid=$ulbid1;
		    $app_type_id=2;
		    $cat3_id=0;
		    $query->bind_param("isii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id);
		    $query->execute();
		    $rs=$query->get_result();
		    while($row =$rs->fetch_assoc())
		    {
		       $data[$row['mcat3_id']]['fin_implication']+=$row['fin_implication'];
				 $tot['fin_implication']+=$row['fin_implication']; 
		    }
		  	
	       
	         $sql ="select COUNT(grievance_id) as pending_apprvl,mcat3_id from grievances where 
	         grievance_status_id =? and ulbid =? and app_type_id =? and cat3_id !=?";
	         
	            
        	$sql.=" group by mcat3_id";               
	        
			$query=$conn->prepare($sql);
	        $grievance_status_id=1;
			$ulbid=$ulbid1;
			$app_type_id=2;
			$cat3_id=0;
		
		$query->bind_param("isii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id);     
		$query->execute();
		$rs=$query->get_result();	
		
			  
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['mcat3_id']]['pending_apprvl']+=$row['pending_apprvl'];
				 $tot['pending_apprvl']+=$row['pending_apprvl'];
			    }
			
			
			 
			 $sql ="select COUNT(grievance_id) as rejected,mcat3_id from grievances where 
			 grievance_status_id =? and ulbid =? and app_type_id =? and cat3_id !=?";
			 
			   
        		 $sql.=" group by mcat3_id";               
	       
			$query=$conn->prepare($sql);
	        $grievance_status_id=10;
			$ulbid=$ulbid1;
			$app_type_id=2;
			$cat3_id=0;
		
		    $query->bind_param("isii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id);     
		    $query->execute();
		    $rs=$query->get_result();	
		
			  
			  while($row = $rs->fetch_assoc())
			    {
			     $data[$row['mcat3_id']]['rejected']+=$row['rejected'];
				 $tot['rejected']+=$row['rejected'];
			    }
		
			$sql ="select COUNT(grievance_id) as unresolved,mcat3_id from grievances where 
			grievance_status_id =? and ulbid =? and app_type_id =? and cat3_id !=?";
			 
		$query=$conn->prepare($sql);
		$grievance_status_id=4;
		$ulbid=	$ulbid1;
		$app_type_id=2;	
		$cat3_id=0;	
		$query->bind_param("isii",$grievance_status_id,$ulbid,$app_type_id,$cat3_id);
		$query->execute();
		$rs=$query->get_result();
		while($row=$rs->fetch_assoc())
		{
		    $data[$row['mcat3_id']]['unresolved']+=$row['unresolved'];
				 $tot['unresolved']+=$row['unresolved'];
		}
		
			
				
			$sql=$conn->prepare("select * from ulbmst");
			$query->execute();
			$rs=$query->get_result();
			while($row= $rs->fetch_assoc())
			{
			     $ulb_list[$row['ulbid']]=$row['ulbname'];
			}
				
			
    	$sql=$conn->prepare("select cs_id,cs_desc from standard_services");
    	
    	$sql->execute();
    	$rs=$sql->get_result();
    	while($row = $rs->fetch_assoc())
    	{
    	    	$cs_list[$row['cs_id']]=$row['cs_desc'];
    	    	$total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla']+$data[$row['cs_id']]['unresolved']+$data[$row['cs_id']]['rejected']+$data[$row['cs_id']]['fin_implication'];
    			$data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,2);
    	}
    		$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla']+$tot['unresolved']+$tot['rejected']+$tot['unresolved'];
    		$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);
    		
			$sql=$conn->prepare("select cat_id,description from category_mst");
			$sql->execute();
			$rs=$sql->get_result();
			while($row = $rs->fetch_assoc())
			{
			   $cat_list[$row['cat_id']]=$row['description']; 
			}
			
		}
			
				//For Warangal Municipality
				 if($_SESSION['uid']=='Warangal' || $_SESSION['uid']=='warangal')
				 {
				  
				    $sql=$conn->prepare("select service_type_id,soap_type from warangal_service_wise_rep");
				    $sql->execute();
				    $rs=$sql->get_result();
				    while($row = $rs->fetch_assoc())
				    {
				       $cs_list[$row['service_type_id']]=$row['soap_type']; 
				    }
				    
				    $data=array();
				     
			
		  $sql=$conn->prepare("select SUM(resolveinsla+resolve_beyond_sla+pending_with_in_sla+pending_beyond_sla) as 
	      total_received,service_type_id from warangal_service_wise_rep group by service_type_id");
	      $sql->execute();
	      $rs=$sql->get_result();
	      while($row =$rs->fetch_assoc())
	      {
	        $data[$row['cat3_id']]['total_received']+=$row['grievance_id'];
	       
	      }
			
        		 	 
                        $sql=$conn->prepare("SELECT * FROM warangal_service_wise_rep");
                        $sql->execute();
                        $res=$sql->get_result();
                        
                           
                            while($row = $res->fetch_assoc())
                            {
                                
                             $data[$row['service_type_id']]['resolved_within_sla']=$row['resolveinsla'];
                             $data[$row['service_type_id']]['resolved_beyond_sla']=$row['resolve_beyond_sla'];
                             $data[$row['service_type_id']]['pending_within_sla']=$row['pending_with_in_sla'];
                             $data[$row['service_type_id']]['pending_beyond_sla']=$row['pending_beyond_sla'];
                                    
                             $data[$row['service_type_id']]['total_received']=$row['resolveinsla']+$row['resolve_beyond_sla']+$row['pending_with_in_sla']+$row['pending_beyond_sla'];
                             
                             $tot['total_received']+=$data[$row['service_type_id']]['total_received'];
                             $tot['resolved_within_sla']+=$row['resolveinsla'];
                             $tot['resolved_beyond_sla']+=$row['resolve_beyond_sla'];
                             $tot['pending_within_sla']+=$row['pending_with_in_sla'];
                             $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
                             
                             $tot_resolved=$row['resolveinsla']+$row['resolve_beyond_sla'];
                             $data[$row['service_type_id']]['percent']=number_format(($tot_resolved/$data[$row['service_type_id']]['total_received'])*100,2);
                             
                             	if($data[$row['service_type_id']]['percent']=='nan')
                    				{
                    				    $data[$row['service_type_id']]['percent']=0;
                    				}
                            }
                            
                            $total_resolved=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
                            $tot['percent']=number_format(($total_resolved/$tot['total_received'])*100,2);
                            if($tot['percent']=='nan')
            				{
            				    $tot['percent']=0;
            				}
                               
                    }
                    	
				 
		/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();
	    $conn->close();*/
	    
	    
	    
	      $users_count=$row['user_count'];
	      $tpl->assign('users_count',$users_count);
		  
		 	
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);
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
		$tpl->display('service_wise_rep.tpl');
	}
	else
	{
		
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>