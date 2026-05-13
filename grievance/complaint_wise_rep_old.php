<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
		$aptid1=$_REQUEST['aptid'];
		$status1=$_REQUEST['status'];
		$ulbid1=$_SESSION['ulbid'];
		$user_type1=$_SESSION['user_type'];
		$sla1=$_REQUEST['sla'];
		$dept_id = $_REQUEST['emp_id'];
		
		
		
		
		 if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime(strip_tags($_POST['f_date'])));
        	                            $t_date = date('Y-m-d',strtotime(strip_tags($_POST['t_date'])));
                			            $tpl->assign('fdate',$_POST['f_date']);
                                        $tpl->assign('tdate',$_POST['t_date']);
            			                
            			                 
			                      }
        			  
        			           
        		     }
	     
		
		
	     
	      
	      $sql="SELECT count(grievance_id) as grievance_id,cat3_id FROM grievances 
	      where ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0' ";
		  
		  if(!empty($dept_id)){
		  $sql.=" and street_id ='".$dept_id."'";
		  }
	      
	      
	      
	       if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'" ;
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		 $sql.=" group by cat3_id"; 
        		 
        		 //echo $sql;
	 
	        $rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
		    {
				  $data[$row['cat3_id']]['total_received']+=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
			}
				 
		 
        
			
			/**** resolved with in sla ****/
			
			$sql ="select COUNT(grievance_id) as resolved_within_sla,cat3_id from grievances where 
			grievance_status_id IN('3','8',9) and ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0' and sla_status='1' ";
			
			if(!empty($dept_id)){
		  $sql.=" and street_id ='".$dept_id."'";
		  }
			 if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'" ;
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		 $sql.=" group by cat3_id"; 
			
			//echo $sql;
			
			$rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data[$row['cat3_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
			    $tot['resolved_within_sla']+=$row['resolved_within_sla'];
			}
			
			/*** resolved beyond sla ****/
			
			$sql ="select COUNT(grievance_id) as resolved_beyond_sla,cat3_id from 
			grievances where grievance_status_id IN('3','8','9','12') and ulbid='".$ulbid1."' and 
			app_type_id='1' and cat3_id !='0' and sla_status='2'";
			
			if(!empty($dept_id)){
		  $sql.=" and street_id ='".$dept_id."'";
		  }
			 if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'" ;
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		 $sql.=" group by cat3_id"; 
			
			
			
			$rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data[$row['cat3_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			    $tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			}
			
			/**** pending with in sla ***/
			
			$sql ="select COUNT(grievance_id) as pending_within_sla,cat3_id from grievances where grievance_status_id IN('2') and
			ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0' and sla_status='1'";
			if(!empty($dept_id)){
		  $sql.=" and street_id ='".$dept_id."'";
		  }
			 if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'" ;
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		 $sql.=" group by cat3_id"; 
			
			
			
			$rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data[$row['cat3_id']]['pending_within_sla']+=$row['pending_within_sla'];
			    $tot['pending_within_sla']+=$row['pending_within_sla'];
			}
			
			
				/**** pending with beyond sla ***/
			
			$sql ="select COUNT(grievance_id) as pending_beyond_sla,cat3_id from grievances where grievance_status_id IN('2') and 
			ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0' and sla_status='2'";
			
			if(!empty($dept_id)){
		  $sql.=" and street_id ='".$dept_id."'";
		  }
		     if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'" ;
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		 $sql.=" group by cat3_id"; 	
			
			
			
			$rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data[$row['cat3_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
			    $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
			}
			
			
			
			
			
			
			
			
			
	 	
	        
	        $sql ="select COUNT(grievance_id) as fin_implication,cat3_id from grievances where grievance_status_id ='6' and
	        ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0'";
			
			if(!empty($dept_id)){
		  $sql.=" and street_id ='".$dept_id."'";
		  }
	         if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'" ;
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		 $sql.=" group by cat3_id";             
	        
	        
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['cat3_id']]['fin_implication']+=$row['fin_implication'];
				 $tot['fin_implication']+=$row['fin_implication'];
			}
			
			
			
			
		  	
	         $sql ="select COUNT(grievance_id) as pending_apprvl,cat3_id from grievances where grievance_status_id ='1' and
	         ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0'";
			 
			 if(!empty($dept_id)){
		  $sql.=" and ward_id ='".$dept_id."'";
		  }
	           if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'" ;
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		 $sql.=" group by cat3_id";           
	        
	        
	        
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['cat3_id']]['pending_apprvl']+=$row['pending_apprvl'];
				 $tot['pending_apprvl']+=$row['pending_apprvl'];
			}
			
			 $sql ="select COUNT(grievance_id) as rejected,cat3_id from grievances where grievance_status_id ='10' 
			 and ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0'";
			 
			 if(!empty($dept_id)){
		  $sql.=" and street_id ='".$dept_id."'";
		  }
		  
	           if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'" ;
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		 $sql.=" group by cat3_id";           
	        
	        //echo $sql;
	        
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['cat3_id']]['rejected']+=$row['rejected'];
				 $tot['rejected']+=$row['rejected'];
			}
			$sql ="select COUNT(grievance_id) as unresolved,cat3_id from grievances where grievance_status_id ='4' and
			ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0'";
			
			if(!empty($dept_id)){
		  $sql.=" and street_id ='".$dept_id."'";
		  }
		  
	         if(isset($_POST['search']))
        			{
        			    
        			    
        			   
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'" ;
            			                
            			                
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		 $sql.=" group by cat3_id";             
	        
	        
	        
	        
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['cat3_id']]['unresolved']+=$row['unresolved'];
				 $tot['unresolved']+=$row['unresolved'];
			}
			
		
			
			
			
	                    
	   
				
				$sql ="select * from ulbmst";
				$rs = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
				    
	        $sql ="select cat_id,cs_id,cs_desc from cs_mst";
	        $rs = mysqli_query($conn,$sql);
    		while($row = mysqli_fetch_assoc($rs))
    		{
    			$cs_list[$row['cs_id']]=$row['cs_desc'];
    			$cat_id[$row['cs_id']]['cat_id']=$row['cat_id'];
    				    
    				   
    		$total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla']+$data[$row['cs_id']]['fin_implication']+$data[$row['cs_id']]['unresolved']+$data[$row['cs_id']]['rejected'];
    		$data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,0);
    		if($data[$row['cs_id']]['percent']=='nan')
    				{
    				    $data[$row['cs_id']]['percent']=0;
    				}
    				    
    		}
    		
    				$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla']+$tot['fin_implication']+$tot['unresolved']+$tot['rejected'];
    				$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);
    				if($tot['percent']=='nan')
    				{
    				    $tot['percent']=0;
    				}
    				
    				
    				
    			$sql ="select cat_id,description from category_mst";
				$rs = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				    $cat_list[$row['cat_id']]=$row['description'];
				}
				  		
        		$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".mysqli_real_escape_string($conn,$_SESSION['ulbid'])."%'"; 
     $rs = mysqli_query($conn,$sql);
     $row = mysqli_fetch_assoc($rs);
     $users_count=$row['user_count'];
    $tpl->assign('users_count',$users_count);
        	mysqli_close($conn);
        	
        	



		$tpl->assign('emp_id',$dept_id);
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);
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
		$tpl->display('complaint_wise_rep_old.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>
