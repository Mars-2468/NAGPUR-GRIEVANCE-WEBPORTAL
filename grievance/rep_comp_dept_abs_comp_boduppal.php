<?php
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	//session_start();
	
	    
	    $_SESSION['user_type']="U";
		$_SESSION['ulbid']="207";
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
			
		if($_SESSION['ulbid']=='3')
				 {
				     $sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
		                g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and g.app_type_id='1' and 
		                gt.disposal_status NOT IN('5','11','12')  and cat3_id !='0'";
				 }
				 else
				 {
		
		 $sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept,disposal_status from grievances g, grievances_transactions gt where 
		                g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and 
		                gt.disposal_status NOT IN('5','11','12')  and cat3_id !='0'";
		                
				 } 
		                
		              
		                
		                
		  if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			            $tpl->assign('fdate',date('Y-m-d',strtotime($_POST['f_date'])));
		                $tpl->assign('tdate',date('Y-m-d',strtotime($_POST['t_date'])));
			        }
			        
          }
          
			        
			       $sql.=" group by gt.dept_id";
			        
         
			if($rs=mysqli_query($conn,$sql))
			{
			  while($row = mysqli_fetch_assoc($rs))
			    {
				    $data[$row['emp_dept']]['count']=$row['count'];
				    $tot['received']+=$row['count'];
			    }
		 	}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
				
				if($_SESSION['ulbid']=='3')
				 {
				     $sql ="select COUNT(g.grievance_id) as count1,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, 
          grievances_transactions gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and 
          g.sla_status='1' and gt.disposal_status!='5' and cat3_id !='0' and is_reopened_yn='0' ";
				 }
				 else
				 {
           $sql ="select COUNT(g.grievance_id) as count1,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, 
          grievances_transactions gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and 
          g.sla_status='1' and gt.disposal_status!='5' and cat3_id !='0' and is_reopened_yn='0' ";
				 }
          
          
          if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			        }
			        
          }
          
			        
			        $sql.=" group by gt.dept_id,gt.disposal_status";
			        
          
			        
			       //echo $sql;
			    	
          
          
          
    
		 
		if($rs=mysqli_query($conn,$sql))
		{
		  while($row = mysqli_fetch_assoc($rs))
		    {
		      
		        
		        
		     if($row['disposal_status']== 3 || $row['disposal_status']== 8 || $row['disposal_status']== 9 )
			    {
			        $data_list[$row['emp_dept']]['completed']+=$row['count1'];
			        $tot['completed']+=$row['count1'];
			    }
			    
		     
						
		    }
	 	}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			
			/// reopend complaints
			
			if($_SESSION['ulbid']=='3')
				 {
				     $sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('9','12') and
			is_reopened_yn='1' and g.grievance_status_id IN('13') and ulbid IN('208','210') and gt.disposal_status!='5' ";
				 }
				 else
				 {
			
			$sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and gt.disposal_status IN('9','12') and
			is_reopened_yn='1' and g.grievance_status_id IN('13') and ulbid='".$_SESSION['ulbid']."' and gt.disposal_status!='5' ";
				 }
			
		  if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			        }
			        
          }
         
			        
			        $sql.=" group by gt.dept_id";
			        
			        
			        
          
			$rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data_list[$row['emp_dept']]['reopened']+=$row['count'];
			     $tot['reopened']+=$row['count'];
			}
			
			
			
			
				/// unresolvable complaints
			if($_SESSION['ulbid']=='3')
				 {
				     $sql ="select COUNT(g.grievance_id) as count1,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
			 and g.grievance_status_id IN ('4') and ulbid IN('208','210') and gt.disposal_status!='5'";
				 }
				 else
				 {
			$sql ="select COUNT(g.grievance_id) as count1,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
			 and g.grievance_status_id IN ('4') and ulbid='".$_SESSION['ulbid']."' and gt.disposal_status!='5'";
				 }
			
		  if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			        }
			        
          }
         
			        
			        $sql.=" group by gt.dept_id";
			        
			        //echo $sql ;
			        
          
			$rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data_list[$row['emp_dept']]['unresolved']+=$row['count1'];
			     $tot['unresolved']+=$row['count1'];
			}
			
			
			
			
			
			/********** FIN IMPLICATION **********************/
			
			
			
				/// unresolvable complaints
			if($_SESSION['ulbid']=='3')
				 {
				     $sql ="select COUNT(g.grievance_id) as count1,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
			 and g.grievance_status_id IN ('6') and ulbid IN('208','210') and gt.disposal_status!='5' ";
				 }
				 else
				 {
			$sql ="select COUNT(g.grievance_id) as count1,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
			 and g.grievance_status_id IN ('6') and ulbid='".$_SESSION['ulbid']."' and gt.disposal_status!='5' ";
				 }
			
		  if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			        }
			        
          }
         
			        
			        $sql.=" group by gt.dept_id";
			        
			        
			        
          
			$rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data_list[$row['emp_dept']]['fin']+=$row['count1'];
			     $tot['fin']+=$row['count1'];
			}
			
		/********* REJECTED ***********/
		    if($_SESSION['ulbid']=='3')
				 {
				     $sql ="select COUNT(g.grievance_id) as count2,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
			 and gt.disposal_status IN ('10') and gt.disposal_status!='5'  and ulbid IN('208','210')";
				 }
				 else
				 {
		    
		    $sql ="select COUNT(g.grievance_id) as count2,dept_id as emp_dept from grievances g, grievances_transactions gt where 
			g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' 
			 and gt.disposal_status IN ('10') and gt.disposal_status!='5'  and ulbid='".$_SESSION['ulbid']."'";
				 }
			 
    			  if(isset($_POST['search']))
                      {
                    	
                    		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
            	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                    			            
                    		    if($f_date!= '' && $t_date!='')
            			        {
            			            
            			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
            			        }
            			        
                      }
         
			        
			        $sql.=" group by gt.dept_id";
			
			if($rs=mysqli_query($conn,$sql))
		    {
		        
    		  while($row = mysqli_fetch_assoc($rs))
    		  {
    		      
    		      $data_list[$row['emp_dept']]['rejected']+=$row['count2'];
			        $tot['rejected']+=$row['count2'];
    		  }
    		  
		    }
		// complaints completed beyond sla
		if($_SESSION['ulbid']=='3')
				 {
				     $sql ="select COUNT(g.grievance_id) as count3,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and g.sla_status='2' and gt.disposal_status!='5' and cat3_id !='0'
           and is_reopened_yn='0' and gt.disposal_status IN('3','9','8')";
				 }
				 else
				 {
			
			$sql ="select COUNT(g.grievance_id) as count3,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, grievances_transactions gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and g.sla_status='2' and gt.disposal_status!='5' and cat3_id !='0'
           and is_reopened_yn='0' and gt.disposal_status IN('3','9','8')";
				 }
			
			
			if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			        }
			        
          }
         
			        
			        $sql.=" group by gt.dept_id";
			        
        
			$rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data_list[$row['emp_dept']]['completed_be_sla']+=$row['count3'];
			     $tot['completed_be_sla']+=$row['count3'];
			}	
			
			if($_SESSION['ulbid']=='3')
				 {
				     $sql6 ="select COUNT(g.grievance_id) as count2,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, 
	grievances_transactions gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and 
           gt.disposal_status!='5' and cat3_id !='0'
          and gt.disposal_status IN('2') and g.sla_status = '1' ";
				 }
				 else
				 {
						
				
	$sql6 ="select COUNT(g.grievance_id) as count2,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, 
	grievances_transactions gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and 
           gt.disposal_status!='5' and cat3_id !='0'
          and gt.disposal_status IN('2') and g.sla_status = '1' ";
				 }
				 
				 	if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql6.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			        }
			        
          }
			        
			       
			         $sql6.=" group by gt.dept_id";
			         
			         
				 
			$rs6=mysqli_query($conn,$sql6);
			while($row = mysqli_fetch_assoc($rs6))
			{
			    $data_list[$row['emp_dept']]['pending']+=$row['count2'];
			    
			     $tot['pending']+=$row['count2'];
			}
			
			
		if($_SESSION['ulbid']=='3')
				 {
				     $sql11 ="select COUNT(g.grievance_id) as count2,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, 
	grievances_transactions gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid IN('208','210') and g.app_type_id='1' and 
           gt.disposal_status!='5' and cat3_id !='0'
          and gt.disposal_status IN('2') and g.sla_status = '2' ";
				 }
				 else
				 {
			
			
	$sql11 ="select COUNT(g.grievance_id) as count2,dept_id as emp_dept,disposal_status,g.date_regd,g.sla_status from grievances g, 
	grievances_transactions gt,cs_mst c where 
          g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='1' and 
           gt.disposal_status!='5' and cat3_id !='0'
          and gt.disposal_status IN('2') and g.sla_status = '2' ";
				 }
				 
				  	if(isset($_POST['search']))
                      {
                    	
                    		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
            	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                    			            
                    		    if($f_date!= '' && $t_date!='')
            			        {
            			            
            			            $sql11.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
            			        }
            			        
                      }
			        
			       
			         $sql11.=" group by gt.dept_id";
			         
			    // echo $sql11;
				 
			$rs611=mysqli_query($conn,$sql11);
			while($row = mysqli_fetch_assoc($rs611))
			{
			    $data_list[$row['emp_dept']]['pending_be']+=$row['count2'];
			    
			     $tot['pending_be']+=$row['count2'];
			}
			
			if($_SESSION['ulbid']=='3')
				 {
				     $sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and
			gt.disposal_status IN('11')  and ulbid IN('208','210') ";
				 }
				 else
				 {
		$sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and
			gt.disposal_status IN('11')  and ulbid='".$_SESSION['ulbid']."' ";
				 }
		
		if(isset($_POST['search']))
        {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			        }
			        
        }
          
			        
			        $sql.=" group by gt.dept_id,g.grievance_status_id";
			        
			      
			        
         
			
			$rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			    
			    $data_list[$row['emp_dept']][$row['grievance_status_id']]['reopend_underProgress']+=$row['count'];
			     $tot[$row['grievance_status_id']]['reopend_underProgress']+=$row['count'];
			     $i+=$row['count'];
			}
			
			
			// reopened completed
			
			if($_SESSION['ulbid']=='3')
				 {
				     $sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and ulbid IN('208','210') and gt.disposal_status NOT IN('5','9')";
				 }
				 else
				 {
				 $sql ="select COUNT(g.grievance_id) as count,dept_id as emp_dept,g.grievance_status_id from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id  and cat3_id !='0' and g.app_type_id='1' and g.grievance_status_id IN ('12') and ulbid='".$_SESSION['ulbid']."' and gt.disposal_status NOT IN('5','9')";
				 }
		
		if(isset($_POST['search']))
        {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			        }
			        
        }
          
			        
			        $sql.=" group by gt.dept_id,gt.disposal_status";
			        
			        //echo $sql;
			        
         
			
			$rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
			{
			    
			     $data_list[$row['emp_dept']]['reopend_completed']+=$row['count'];
			     $tot['reopend_completed']['count']+=$row['count'];
			}

        
        if($_SESSION['ulbid']=='3')
				 {
				     $sql="select dept_id,dept_desc from dept_mst where ulbid IN('208','210')";
				 }
				 else
				 {
		
	       $sql="select dept_id,dept_desc from dept_mst where ulbid='".$_SESSION['ulbid']."'";
				 }
			if($rs=mysqli_query($conn,$sql))
			{
				while($row = mysqli_fetch_assoc($rs))
					$dept_list[$row['dept_id']]=$row['dept_desc'];
			}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
				
			
			
			$sql="select * from grievance_status_mst";
			if($rs=mysqli_query($conn,$sql))
			{
				while($row = mysqli_fetch_assoc($rs))
					$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
				
				
				$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		  $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	//	print_r($online_applications);
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('ulb',$_SESSION['ulbid']);
		$tpl->assign('tot',$tot);
		$tpl->assign('online_applications',$online_applications);
		mysqli_close($conn);
		$tpl->assign('status_list',$status_list);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet','3'=>'Both'));
		$tpl->assign('data_list',$data_list);		
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('user_dept',$_SESSION['user_dept']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('rep_comp_dept_abs_comp_boduppal.tpl');
		//$tpl->display('rep_comp_dept_abs.tpl');

?>	